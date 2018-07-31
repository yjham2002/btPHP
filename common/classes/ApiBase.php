<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/comm/Common.php" ; ?>
<?php
if(! class_exists("ApiBase") )	{

	class ApiBase extends Common {
		
		
		// xml 키가 들어 왔을경우 
		function __construct($req) 
		{
            $this->serverRoot = "http://192.168.0.38:8550";
			parent::__construct($req);
		}

		function wrapParam()
		{
			$this->req['page']	= ($this->req['page'] == "") ? 1 : $this->req['page'] ;			 
		}
				
		function getAddQuery()
		{			
			$addQuery = "" ;

			return $addQuery ;
		}

		
		
		
		/***************************************************************************
		*	제  목 : 인트로 프로세스
		*	함수명 : introProcess
		*	작성일 : 2013-08-19
		*	작성자 : dev.Na
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function introProcess()
		{
			$appVersion			= $this->req["appVersion"];
			$deviceID			= $this->req["deviceID"];
			$deviceTypeID		= $this->req["deviceTypeID"];
			$storeTypeID		= $this->req["storeTypeID"];
			$registrationKey	= $this->req["registrationKey"];
			$userNumber			= $this->req["no"];
			$app_type			= $this->req["app_type"];
			
			
			

			$versionParams["appVersion"]	= $appVersion;			// APP 버전
			$versionParams["deviceTypeID"]	= $deviceTypeID;		// APP 타입
			$versionParams["storeTypeID"]	= $storeTypeID;		// store 타입
			$versionParams["userNumber"]	= $userNumber;
			$versionParams["appType"]		= $app_type;		// 1:동네 2:직장
			
			$versionInfo = $this->inFn_ApiBase_getVersionSync($versionParams);


			$loginParams["userNumber"]			= $userNumber;
			$loginParams["deviceID"]			= $deviceID;
			$loginParams["deviceTypeID"]		= $deviceTypeID;
			$loginParams["storeTypeID"]			= $storeTypeID;
			$loginParams["registrationKey"]		= $registrationKey;
			$loginParams["appVersion"]			= $appVersion;
			$loginParams["appType"]				= $app_type;

			$loginInfo = $this->inFn_ApiBase_autoLogin($loginParams);
			
			$openPopupInfo = $this->inFn_ApiBase_popupInfo($this->POPUP_TYPE_OPEN);
			$closePopupInfo = $this->inFn_ApiBase_popupInfo($this->POPUP_TYPE_CLOSE);
			
			$entity = Array(
				"version"	=> $versionInfo["version"],
				"marketUrl"	=> $versionInfo["marketUrl"]
			);
			
			
			
			$addData = Array(
				"loginData"	=> $loginInfo,
				"openPopupInfo" => $openPopupInfo,
				"closePopupInfo" => $closePopupInfo
			);
			
			return $this->makeResultJson($versionInfo["returnCode"], $versionInfo["returnMessage"], $entity, $addData);

		}



		function doAppLogout()
		{
			LoginUtil::doAppLogout();

			$resultJson = Array(
				"callApi"		=> $this->callApi,
				"returnCode"	=> "1",
				"returnMessage"	=> "로그아웃 처리되었습니다.",
				"entity"		=> ""
			);

			return json_encode($resultJson);
		}


		/***************************************************************************
		 *	제  목 : 팝업 정보 조회
		 *	함수명 : inFn_ApiBase_popupInfo
		 *	작성일 : 2013-08-19
		 *	작성자 : dev.Na
		 *	설  명 :
		 *	수  정 :
		 '***************************************************************************/
		function inFn_ApiBase_popupInfo($popup_type)
		{
			$sql = "
				SELECT *
				FROM tbl_popup
				WHERE popup_type = '{$popup_type}' AND is_apply = 1 AND status = 'Y'
				LIMIT 1
			";
			$result = $this->getRow($sql);
			
			return $result;
			
		}



		/***************************************************************************
		*	제  목 : 자동 로그인 함수
		*	함수명 : inFn_ApiBase_autoLogin
		*	작성일 : 2013-08-19
		*	작성자 : dev.Na
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function inFn_ApiBase_autoLogin($loginParams)
		{

			$param = Array(
				$loginParams[0],
				$loginParams[1],
				$loginParams[2],
				$loginParams[3],
				$loginParams[4]
			) ;
			
			$ret = Array(
				"po_returnCode"	=>	"@po_returnCode",
				"po_returnMsg"	=>	"@po_returnMsg"
			) ; 
			
			$sql = $this->strCallProc("uspU_autoLogin", $param, $ret) ;
			

			$result =  $this->getMultiArray($sql) ;

			//echo $loginParams[5];
			
			if($result[0][0]["po_returnCode"] == "-1")
			{
				$loginInfo["isLogin"]		= $result[0][0]["po_returnCode"];
				$loginInfo["loginMessage"]	= $result[0][0]["po_returnMsg"];
				$loginInfo["loginInfo"]	= "";
			}
			else
			{
				$loginInfo["isLogin"]		= $result[0][0]["po_returnCode"];
				$loginInfo["loginMessage"]	= $result[0][0]["po_returnMsg"];
				$loginInfo["loginInfo"]	= $this->inFn_ApiBase_getInfoOfUser($loginParams[0]);
				/*
				if($loginParams[5]!=$loginInfo["loginInfo"]["userPwd"]){
					$loginInfo["loginInfo"]="";
					$loginInfo["isLogin"]="-1000";
					$loginInfo["loginMessage"]="비밀번호를 확인하세요";
					return $loginInfo;
				}
				*/
					
				LoginUtil::doAppLogin($loginInfo["loginInfo"]);
			}
			
			return $loginInfo;
		}




		/***************************************************************************
		*	제  목 : 회원정보 조회
		*	함수명 : inFn_ApiBase_getInfoOfUser
		*	작성일 : 2013-08-20
		*	작성자 : dev.Na
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function inFn_ApiBase_getInfoOfUser($userNo)
		{
			$sql = "
				SELECT 
					U.*
				FROM tblUser U
				WHERE U.userNo = '{$userNo}' AND status=1
				LIMIT 0, 1
			";

			$userInfo = $this->getRow($sql);

			if($userInfo == null)
			{
				return false;
			}
			else
			{
				//unset($userInfo["userPwd"])	;
			}

			return $userInfo;
		}



		/***************************************************************************
		*	제  목 : 버전체크 내부함수
		*	함수명 : inFn_ApiBase_getVersionSync
		*	작성일 : 2013-07-04
		*	작성자 : dev.Na
		*	설  명 : 
		*	수  정 :
		'***************************************************************************/
		function inFn_ApiBase_getVersionSync($versionParams)
		{			
			$appVersion		= $versionParams["appVersion"];			// APP 버전
			$appTypeID		= $versionParams["deviceTypeID"];		// APP 타입

			$appVersionInt = (int)str_replace(".", "", $appVersion);
			
			$isMustUpdate = "0";
			
			$sql = "
				SELECT COUNT(*) AS isUpdate
				FROM tblAppVersion 
				WHERE appTypeID = '{$appTypeID}' AND versionInt > {$appVersionInt};
				
				SELECT COUNT(*) AS isMustUpdate
				FROM tblAppVersion 
				WHERE appTypeID = '{$appTypeID}' versionInt > {$appVersionInt} AND isMustUpdate > 0;
				
				SELECT version
				FROM tblAppVersion
				WHERE appTypeID = '{$appTypeID}' 
				ORDER BY versionInt DESC
				LIMIT 0, 1;
			";
			
			
			$result = $this->getMultiArray($sql);

			

			if($result[2][0]["version"] == "")
			{
				$returnCode = "-1";
				$returnMessage = "해당 마켓에 등록된 어플이 아닙니다.";
			}
			else if($result[0][0]["isUpdate"] > 0)
			{
				$returnCode = "-10";
				$returnMessage = "업데이트된 버전이 있습니다. 업데이트 받으시겠습니까?";
				
				if($result[1][0]["isMustUpdate"] > 0)
				{
					$returnCode = "-20";
					$returnMessage = "업데이트된 버전이 있습니다. 업데이트 받으셔야만 이용하실 수 있습니다.";
				}	
			}
			else
			{
				$returnCode = "1";
				$returnMessage = "";
			}

			$marketUrl = "";

			
			$retArr = Array(
				"returnCode"	=> $returnCode,
				"returnMessage"	=> $returnMessage,
				"version"		=> $result[2][0]["version"],
				"marketUrl"		=> $marketUrl,
			);

			return $retArr;
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

			$Extension = array("txt","html","asp","php");
			$Upload = new UploadUtil($_FILES["file"],$this->fileSavePath,$Extension,1);
			$fileData = $Upload->processing() ;

			$fileList = Array() ;

			
			for( $i = 0 ; $i < sizeof($_FILES["file"]["name"]) ; $i++ )
			{
				if( strcmp($fileData[$i]['re_name'],"") ){
					$fileName = $Upload->GetDate() . "/" . $fileData[$i]['re_name'];
					array_push($fileList, $fileName);
					$image = new SimpleImage();
					$assoc = array($this->fileSavePath_720, $this->fileSavePath_640, $this->fileSavePath_480, $this->fileSavePath_320, $this->fileSavePath_100) ; 
					$image->check($assoc) ;
					$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_720, 720, $fileData[$i]['re_name']) ;
					$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_640, 640, $fileData[$i]['re_name']) ;
					$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_480, 480, $fileData[$i]['re_name']) ;
					$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_320, 320, $fileData[$i]['re_name']) ;
					$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_100, 100, $fileData[$i]['re_name']) ;
				}
			}

			if(sizeof($fileList) > 0)
			{
				$resultJson = Array(
					"callApi"			=> $this->callApi,
					"returnCode"		=> "1",
					"returnMessage"		=> "",
					"entity"			=> $fileList
				);
				
				return json_encode($resultJson);
			}

			
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
				$assoc = array($this->fileSavePath_720, $this->fileSavePath_640, $this->fileSavePath_480, $this->fileSavePath_320, $this->fileSavePath_100) ; 

				$image->check($assoc) ;

				$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_720, 720, $fileData[0]['re_name']) ;
				$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_640, 640, $fileData[0]['re_name']) ;
				$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_480, 480, $fileData[0]['re_name']) ;
				$image->processing($this->fileSavePath . $Upload->GetDate() . "/", $this->fileSavePath_320, 320, $fileData[0]['re_name']) ;
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


		function smsTest()
		{
			$str = "투리 테스트입니다. 님의 선물을 받아주세요.퍼니룰렛 돌리고, 퍼니콘 직접 고르기!돌리러 가기 http://funnycon.richware.co.kr/appStart.php" ;
			$this->sendSMS($str, "010-4220-1597", $this->turiCSPhone) ;

			// http://funnycon.richware.co.kr/action_front.php?cmd=ApiBase.smsTest
		}
		

		/**
		 * 댓글 삭제
		 * @param $commentNo
		 */
		function inFn_ApiBase_delComment($commentNo)
		{
			$sql = "
				DELETE FROM tbl_comment WHERE `no` = '{$commentNo}'
			";
			$this->update($sql);
		}
		
	}//클래스 종료
}
?>