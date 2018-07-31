<? include_once $_SERVER["DOCUMENT_ROOT"] . '/common/classes/comm/DB.php'; ?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . '/common/php/LoginUtil.php'; ?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . '/common/classes/util/UploadUtil.php'; ?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . '/common/classes/util/LogUtil.php'; ?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . '/common/classes/util/SimpleImage.php'; ?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . '/common/classes/util/Push.php'; ?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . '/common/classes/module/whoisSMS/class.http.php'; ?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . '/common/classes/module/whoisSMS/class.EmmaSMS.php'; ?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/excel/reader.php" ?>
<?php
if(! class_exists("HomeFrm") )	{
	

	class HomeFrm extends DB
	{
		var $page = NULL;		// 게시판 리스트 출력할 때 사용한다.
		var $req = NULL;		// 현재 HttpRequest + Cookie

		var $appUser = NULL;    //사용자 app
		var $webuser = NULL;    //회사 관리자 app/web , kopas web 사용자
		var $admUser = NULL;    //kopas admin

		var $callApi		= NULL ;

		var	$rowPerPage		= 20 ;
		var $rowPerPageDevice = 6;
		var	$pagePerBlock	= 10 ;
		var $rownum			= 0	 ;
		var $startBlock		= 1 ;
		var $endBlock		= 10 ;
		var $virtualNum     = 0 ;
		var $endPage     	= 0 ;
		var $startNum		= 0 ; 
		var $endNum		= 0 ;

		function __construct($req)
		{
			parent::__construct($req);

			$this->req		= $req	;
			$this->appUser	= LoginUtil::getAppUser() ; 
			$this->webUser	= LoginUtil::getWebUser() ;
			$this->admUser	= LoginUtil::getAdminUser() ;
			$this->callApi	= $req["cmd"];
		}


		// 20091221 added by nukiboy
		protected function setFlow($rurl,$msg,$flow)
		{
			$_REQUEST['rurl']	= $rurl ;
			$_REQUEST['msg']	= $msg	;
			$_REQUEST['flow']	= $flow ;

		}


		//페이지 초기화
		function initPage()
		{
			$this->rowPerPage = $this->req["rowPerPage"] == "" ? $this->rowPerPage : $this->req["rowPerPage"];
			$this->req["page"] = ($this->req["page"] == "" || $this->req["page"] == "0") ? "1" : $this->req["page"] ;
			$this->startNum = ($this->req["page"] - 1) * $this->rowPerPage ;
			$this->endNum = $this->rowPerPage ;
		}

		//페이지 설정
		function setPage($rownum)
		{
			$this->virtualNum	= $rownum - ($this->startNum - 0) ;
			$this->rownum = $rownum ;
			$this->endPage = ($rownum%$this->rowPerPage) > 0 ? floor($rownum/$this->rowPerPage)+1 : floor($rownum/$this->rowPerPage);
			$blockNum = (floor(($this->req["page"] - 1) / $this->pagePerBlock) * $this->pagePerBlock) ;
			$totalBlock = floor( ($this->rownum - 1) / $this->rowPerPage ) + 1 ;

			$this->startBlock = $blockNum + 1 ;
			$this->endBlock = ( $blockNum + $this->pagePerBlock < $totalBlock ) ? $blockNum + $this->pagePerBlock : $totalBlock ;
		}
		
		//디바이스용 페이지 설정
		function setPageForDevice($rownum)
		{
			$this->virtualNum	= $rownum - ($this->startNum - 0) ;
			$this->rownum = $rownum ;
			$this->endPage = ($rownum%$this->rowPerPageDevice) > 0 ? floor($rownum/$this->rowPerPageDevice)+1 : floor($rownum/$this->rowPerPageDevice);
			$blockNum = (floor(($this->req["page"] - 1) / $this->pagePerBlock) * $this->pagePerBlock) ;
			$totalBlock = floor( ($this->rownum - 1) / $this->rowPerPageDevice ) + 1 ;
		
			$this->startBlock = $blockNum + 1 ;
			$this->endBlock = ( $blockNum + $this->pagePerBlock < $totalBlock ) ? $blockNum + $this->pagePerBlock : $totalBlock ;
		}

		//이전 블록 여부 체크
		function isPrevBlock()
		{
			$thisBlockSet = floor(($this->req["page"] - 1) / $this->pagePerBlock) ;

			return ( $thisBlockSet > 0 ) ;
		}

		//다음 블록 여부 체크
		function isNextBlock()
		{

			$totalBlock = floor( ($this->rownum - 1) / $this->rowPerPage ) + 1 ;
			$thisBlockSet = ceil(($this->req["page"]) / $this->pagePerBlock) ;
			$lastBlockSet = ceil(($totalBlock) / $this->pagePerBlock) ;

			return ( $thisBlockSet < $lastBlockSet ) ;
		}
		
		
		//디바이스 페이징 2012.08.28 추가 ny Dev.Na
		//파라미터 페이징 sql 쿼리
		function setDevicePaging($sqlStr, $noCol,  $no=null){
			$rowPerPage = ($this->req["rowPerPage"] == "" || $this->req["rowPerPage"] == "0") ? "20" : $this->req["rowPerPage"] ;
			$sqlStr = trim($sqlStr);

			$noColArr = explode(".", $noCol);
			
			if(sizeof($noColArr) > 1)
			{
				$whereCol = $noColArr[1];
			}
			else
			{
				$whereCol = $noCol;
			}

			if($no != "" && $no != null && $no != "0")
				$where = " WHERE sel1.{$whereCol} = {$no}";
			
			$totalSqlstr = str_ireplace("SELECT ".$noCol, "SELECT COUNT(".$noCol.") AS totalRecordCount", $sqlStr);

			$sql = "SELECT total.totalRecordCount, sel1.rowNumber
					FROM
					( 
						{$totalSqlstr}
					)total,
					(
						SELECT @rownum1:=@rownum1+1 AS 'rowNumber', tbl.*
						FROM	
						(SELECT @rownum1:=0) rn,
						({$sqlStr}) tbl 
					)sel1
					{$where}
					LIMIT 0, 1";
			
			$result = $this->getRow($sql);
			
			$this->startNum = ($no != "") ? $result[rowNumber] : 0;
			$this->totalRecordCount = $result[totalRecordCount] == "" ? "0" : $result[totalRecordCount];
			//$this->nextPageNo =  $result[nextPageNO] == "" ? "" : $result[nextPageNO];
			$this->endNum = $rowPerPage;
		}
		
		
		
		
		function isNextPage(){
			if($this->totalRecordCount > ($this->startNum + $this->endNum))
				return true;
			else
				return false;
		}
		
		//디바이스 페이징 2012.08.28 추가 ny Dev.Na 끝

	}	
}

?>