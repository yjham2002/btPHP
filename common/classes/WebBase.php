<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/comm/Common.php" ; ?>
<?php
if(! class_exists("WebBase") )	{

	class WebBase extends Common {
		
		function __construct($req) {
			parent::__construct($req);
		}

		function doWebLogout()
		{
			LoginUtil::doWebLogout();

			$resultJson = Array(
				"callApi"		=> $this->callApi,
				"returnCode"	=> "1",
				"returnMessage"	=> "로그아웃 처리되었습니다.",
				"entity"		=> ""
			);

			$this->makeResultJson();

			return json_encode($resultJson);
		}

		
		/***************************************************************************
		*	제  목 : 이용약관/개인정보 취급방침
		*	함수명 : getInfoOfProvision
		*	작성일 : 2013-08-19
		*	작성자 : dev.Na
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function getInfoOfProvision()
		{
			$agreeTypeID = $this->req["agreeTypeID"];

			$agree = "";

			if($agreeTypeID == "1")
			{
				$filePath = $this->agreeInfoPath;
			}
			else
			{
				$filePath = $this->privacyInfoPath;
			}

			$files = fopen($filePath, "r");
			
			while($ss = fgets($files, 1024))	
			{
				$agree .= $ss;
			}
			
			fclose($files);

			$resultJson = array(
				"returnCode"	=> "1" ,
				"returnMessage" => "" ,
				"entity"		=> $agree
			) ;

			return json_encode($resultJson) ;
		}
		

		/***************************************************************************
		*	제  목 : 다중 파일 업로드
		*	함수명 : fileUpload
		*	작성일 : 2013-07-22
		*	작성자 : dev.Na
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function fileUploadMulti()
		{
			
			$this->feedSimpleLog("FILE => " . json_encode($_FILES));
			$fileList = $this->inFn_Common_fileSave($_FILES);
			
			if(sizeof($fileList) > 0)
			{
				$resultJson = Array(
						"callApi"			=> $this->callApi,
						"returnCode"		=> "1",
						"returnMessage"		=> "",
						"entity"			=> $fileList
				);
			}
			else{
				$resultJson = Array(
						"callApi"			=> $this->callApi,
						"returnCode"		=> "-1",
						"returnMessage"		=> "file 업로드 에러~!"
				);
			}
			$this->feedSimpleLog("RETURN => " . json_encode($resultJson));
			return json_encode($resultJson);
			
		}


		/***************************************************************************
		*	제  목 : 파일 업로드
		*	함수명 : fileUpload
		*	작성일 : 2013-07-22
		*	작성자 : dev.Na
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function fileUpload()
		{

			$Extension = array("txt","html","asp","php");
			$Upload = new UploadUtil($_FILES["file"],$this->fileSavePath,$Extension,1);
			$fileData = $Upload->processing() ;

			$filePath = "" ;
			
			if( strcmp($fileData[0]['re_name'],"") ){
				$filePath = $Upload->GetDate() . "/" . $fileData[0]['re_name'];
				$image = new SimpleImage();
				$assoc = array($this->fileSavePath_720, $this->fileSavePath_480, $this->fileSavePath_100) ; 

				$image->check($assoc) ;

				$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_720, 720, $fileData[0]['re_name']) ;
				$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_480, 480, $fileData[0]['re_name']) ;
				$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_100, 100, $fileData[0]['re_name']) ;
			}
			

			if($filePath == "")
			{
				$returnCode		= "-1";
				$returnMessage	= "";
			}
			else
			{
				$returnCode		= "1";
				$returnMessage	= "";	
			}


			$resultJson = Array(
				"callApi"			=> $this->callApi,
				"returnCode"		=> $returnCode,
				"returnMessage"		=> $returnMessage,
				"entity"			=> $filePath
			);
			
			return json_encode($resultJson);

		}

		/***************************************************************************
			*	제  목 : 이미지 파일 사이즈 구하기
		*	함수명 : fileUpload
		*	작성일 : 2013-07-22
		*	작성자 : dev.Na
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function getImageSize($imgUrl)
		{
			$imgUrl = str_replace("/upload_img/", "", $imgUrl);

			$imgUrl = $this->fileSavePath.$imgUrl;
			$sizeInfo = getimagesize($imgUrl);

			if($sizeInfo != false)
			{
				$file_width		= $sizeInfo[0];
				$file_height	= $sizeInfo[1];
			}
			else
			{
				$file_width		= "0";
				$file_height	= "0";
			}

			$retArr = Array(
				"file_name"		=> str_replace($this->fileSavePath, "", $imgUrl),
				"file_width"	=> $file_width,
				"file_height"	=> $file_height
			);

			return $retArr;

		}



		// 파일명중 확장자를 분리해준다.
		function getFileExtension($imgUrl){
			
			$Tmp = explode(".",$imgUrl);
			
			return $Tmp[count($Tmp)-1];
		}


	}//클래스 종료
}
?>