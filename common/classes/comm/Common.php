<? include $_SERVER["DOCUMENT_ROOT"] . '/common/classes/comm/HomeFrm.php'; ?>
<?php

if (! class_exists("Common"))
{

	class Common extends HomeFrm
	{

		function __construct($req)
		{
			parent::__construct($req);
		}
		
		//resultJson 생성
		function makeResultJson($returnCode, $returnMessage, $entity = "", $addData = Array())
		{
			
			//기본 json데이터 생성
			$resultJson = Array(
				"callApi" => $this->callApi,
				"returnCode" => $returnCode,
				"returnMessage" => $returnMessage,
				"entity" => $entity
			);
			
			//추가 데이터 추가
			if (is_array($addData))
			{
				foreach ($addData as $key => $value)
				{
					$resultJson[$key] = $value;
				}
			}
			
			return json_encode($resultJson);
		}

		/**
		 * *************************************************************************
		 * 제 목 : 이미지 파일 사이즈 구하기
		 * 함수명 : fileUpload
		 * 작성일 : 2013-07-22
		 * 작성자 : dev.Na
		 * 설 명 :
		 * 수 정 :
		 * '**************************************************************************
		 */
		function inFn_Common_getImageSize($imgUrl)
		{
			$imgUrl = $this->fileSavePath . "/" . $imgUrl;
			
			$imgExtension = Array(
				'GIF',
				'JPG',
				'PNG',
				'PSD',
				'BMP'
			);
			
			if (in_array(strtoupper($this->inFn_Common_getFileExtension($imgUrl)), $imgExtension))
			{
				$sizeInfo = getimagesize($imgUrl);
				$file_width = $sizeInfo[0];
				$file_height = $sizeInfo[1];
			}
			else
			{
				$file_width = "0";
				$file_height = "0";
			}
			
			$retArr = Array(
				"file_name" => str_replace($this->fileSavePath, "", $imgUrl),
				"file_width" => $file_width,
				"file_height" => $file_height
			);
			
			return $retArr;
		}
		
		// 파일명중 확장자를 분리해준다.
		function inFn_Common_getFileExtension($imgUrl)
		{
			$Tmp = explode(".", $imgUrl);
			
			return $Tmp[count($Tmp) - 1];
		}
		
		// 파일 저장
		function inFn_Common_fileSave($Files)
		{
			$result = Array();
			$Upload = new UploadUtil();
			
			foreach ($Files as $key => $File)
			{
				$uploadResult = $Upload->uploadOneFile($File, $this->fileSavePath, "", true, false, true);
				$result[$key] = $uploadResult["fileInfo"];
				
				if ($uploadResult["returnCode"] == "1")
				{
					// 파일 디비에 저장할 데이터 셋팅
					$fileOriginName = $result[$key]["name"];
					$filePath = $result[$key]["saveURL"];
					$fileSize = $result[$key]["size"];
					$fileType = $result[$key]["type"];
					$fileExtension = $result[$key]["extension"];
					$imgWidth = 0;
					$imgHeight = 0;
					
					//이미지일 경우
					if (strpos($result[$key]["type"], "image") !== false)
					{
						// 이미지 사이즈 조회 후 디비 저장 데이터에 추가
						$imgSizeData = $this->inFn_Common_getImageSize($result[$key]["saveURL"]);
						$imgWidth = $imgSizeData["file_width"];
						$imgHeight = $imgSizeData["file_height"];
						
						// 이미지 리사이징
						$image = new SimpleImage();
						$assoc = array(
							$this->fileSavePath_720 . "/",
							$this->fileSavePath_640 . "/",
							$this->fileSavePath_480 . "/",
							$this->fileSavePath_320 . "/",
							$this->fileSavePath_100 . "/"
						);
						
						$image->check($assoc);
						
						$image->processing($uploadResult["fileInfo"]["savePath"] . "/", $this->fileSavePath_720 . "/", 720, $uploadResult["fileInfo"]['re_name']);
						$image->processing($uploadResult["fileInfo"]["savePath"] . "/", $this->fileSavePath_640 . "/", 640, $uploadResult["fileInfo"]['re_name']);
						$image->processing($uploadResult["fileInfo"]["savePath"] . "/", $this->fileSavePath_480 . "/", 480, $uploadResult["fileInfo"]['re_name']);
						$image->processing($uploadResult["fileInfo"]["savePath"] . "/", $this->fileSavePath_320 . "/", 320, $uploadResult["fileInfo"]['re_name']);
						$image->processing($uploadResult["fileInfo"]["savePath"] . "/", $this->fileSavePath_100 . "/", 100, $uploadResult["fileInfo"]['re_name']);
					}
				}
			}
			
			return $result;
		}
		
		// 엑셀 데이터 추출
		function inFnExcelDataToArr($uploadExcelFile, $isReadTitle = false){
			$arrRow = Array();
			$Upload = new UploadUtil();
			$uploadResult = $Upload->uploadOneFile($uploadExcelFile, $this->excelSavePath, "", true, false, true);
			
			if ($uploadResult["returnCode"] != "1")
				return $arrRow;
			
			$excelData = $uploadResult["fileInfo"];
			if (strcmp($excelData['re_name'], ""))
			{
				$excelFile = $this->excelSavePath . "/" . $excelData['saveURL'];
				
				$exReaderObj = new Spreadsheet_Excel_Reader();
				$exReaderObj->setOutputEncoding("UTF-8");
				$exReaderObj->read($excelFile);
				
				error_reporting(E_ALL ^ E_NOTICE);
				
				$seq = $exReaderObj->sheets[0]['numRows'];
				
				for ($i = (($isReadTitle) ? 1 : 2); $i <= $seq; $i ++)
				{
					// safe array
					

					if ($exReaderObj->sheets[0]['cells'][$i][1] != "" && $exReaderObj->sheets[0]['numCols'] > 0)
					{
						$arrData = Array();
						
						for ($j = 1; $j <= $exReaderObj->sheets[0]['numCols']; $j ++)
						{
							
							$input = $exReaderObj->sheets[0]['cells'][$i][$j];
							
							$input = ($input == null) ? "" : $input;
							
							array_push($arrData, $input);
						}
						
						array_push($arrRow, $arrData);
					}
				}
			}
			
			return $arrRow;
		}

		/**
		 * 회원 사용가능 포인트 조회
		 * 
		 * @return string
		 */
		function inFn_Common_getUserPointBalance($no)
		{
			
			$sql = "
                SELECT IFNULL(SUM(CASE trans_type WHEN 'I' THEN amt ELSE (amt*-1) END ), 0) AS balanceAmt
				FROM tbl_point_trans
				WHERE user_fk = '{$no}'
			";
			
			$balanceAmt = $this->getValue($sql, "balanceAmt");
			
			return $balanceAmt;
		}
		
		/**
		 * 등록 차감 함수
		 * @param $trans_type
		 * @param $no
		 * @param $amt
		 * @param $shop_fk
		 * @param $pay_type
		 * @return boolean
		 */
		function inFn_Common_savePointTrans($trans_type, $user_fk, $amt, $group_fk, $shop_fk = 0, $pay_type = "", $pay_amt = "0")
		{
			$sql = "
				INSERT INTO tbl_point_trans
				(
					user_fk, group_fk, shop_fk, trans_type, amt, pay_type, pay_amt, reg_dt, reg_date
				)
				VALUES
				(
					'{$user_fk}', '{$group_fk}', '{$shop_fk}', '{$trans_type}', '{$amt}', '{$pay_type}', '{$pay_amt}', NOW(), CURDATE()
				)
			";	
			$result = $this->update($sql);
				
			return ($result > 0);
		}
		
		
		
		/***************************************************************************
		*	제  목 : 주소로 좌표 뽑기 / reverseGeocode
		*	작성일 : 2013-11-04
		*	작성자 : dev.Na
		*	설  명 : 
		*   리  턴 : String
		*   
		****************************************************************************/
		function reverseGeocode($address)
		{
			$latitude	= 0;
			$longitude	= 0;

			$addresParam = urlencode($address);
			$url = "http://maps.googleapis.com/maps/api/geocode/json?address=$addresParam&sensor=false&language=ko";
			//$url = "https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDoTwPl7kcLmuMqz5ljXgNJqvYJgmUS2ps&address=$addresParam&sensor=true&language=ko";
			//https://maps.googleapis.com/maps/api/geocode/json?address=1600+Amphitheatre+Parkway,+Mountain+View,+CA&key=YOUR_API_KEY
			
			if($address){
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language:ko"));
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);	
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
				curl_setopt($ch, CURLOPT_SSLVERSION,4); 
				curl_setopt($ch, CURLOPT_HEADER, 0);			
				curl_setopt($ch, CURLOPT_TIMEOUT, 30); 
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$resultJson = curl_exec($ch);
				curl_close($ch);
				
				//echo $resultJson;
				$resultArr = json_decode($resultJson, true);
				
				if($resultArr["status"] == "OK")
				{
					$lat = $resultArr["results"][0]["geometry"]["location"]["lat"];
					$lng = $resultArr["results"][0]["geometry"]["location"]["lng"];
	
					$latitude = floor($lat*1E6);
					$longitude = floor($lng*1E6);
				}
			}
			$retArr = Array(
				"latitude"	=> $latitude,
				"longitude"	=> $longitude
			);

			return $retArr;
		}
		/***************************************************************************
		 *	제  목 : 주소로 좌표 뽑기 / reverseGeocode2
		 *	작성일 : 2013-11-04
		 *	작성자 : dev.Na
		 *	설  명 : Daum
		 *  리  턴 : String
		 *
		 ****************************************************************************/
		function reverseGeocode2($address)
		{
			$latitude	= 0;
			$longitude	= 0;
			$addresParam = urlencode($address);
			$apikey = "29ba15a34edd4ee5ad304b1f7c7cd26c";
			//$address = str_replace(" ", "%20", $address);
			$url = "https://apis.daum.net/local/geo/addr2coord?apikey=$apikey&q=$addresParam&output=json";
			//echo $url . "<br/>";
			if($address){
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HTTPHEADER, array("Accept-Language:ko"));
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
				curl_setopt($ch, CURLOPT_SSLVERSION,4);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_TIMEOUT, 30);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$resultJson = curl_exec($ch);
				$curl_errno = curl_errno($ch);
				$curl_error = curl_error($ch);			
				curl_close($ch);
				/*
				echo "=====================================<br/>";
				echo "RESULT : " . $resultJson . "<br/>";
				echo "ERROR CODE : " . $curl_errno . "<br/>";
				echo "ERROROR MSG : " . $curl_error . "<br/>";
				echo "=====================================<br/>";
				*/
				echo $resultJson;
				$resultArr = json_decode($resultJson, true);
				$result = $resultArr["channel"]; 
				
				if($result["result"] == "1")
				{
					
					$lat = $result["item"][0]["lat"];
					$lng = $result["item"][0]["lng"];
					
					$latitude = floor($lat*1E6);
					$longitude = floor($lng*1E6);
				}
			}
			$retArr = Array(
					"latitude"	=> $latitude,
					"longitude"	=> $longitude
			);
		
			return $retArr;
		}
		
		
		
		
		
		function sendPushBulk($params)
		{
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, "{$this->con_domain}/feed/sendBulkPush.php");
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
			$result = curl_exec($ch);
			
			if(curl_error($ch)){
				echo 'error:' . curl_error($ch);
			}
	
			curl_close($ch);
		}
		
		
		/** 
		 * sendSms($sendStr)
		 * add by Dev.Na 2013-01-09
		 * @param $sendStr - 발송할 문구
		 *
		 * @param $phone - 전화번호
		 * */
		function sendSMS($sendStr, $resPhone, $reqPhone){
				
			$sms_id		= "groupby" ;
			$sms_passwd	= "rtgvcdf$%" ;
			$sms_type	= "L" ;
			$sms_to		= $resPhone ;
			$sms_from	= $reqPhone ;
			$sms_date	= "0" ;
			$sms_msg	= $sendStr ;
		
			if($resPhone == "" && $resPhone == "")
			{
				$logData = "Api : sendSMS // reqPhone : {$reqPhone} //resPhone : {$resPhone} // 발송실패";
				LogUtil::writeFileLog($this->logPath, $logData);
				return false;
			}
				
			$sms = new EmmaSMS();
		
			$sms->login($sms_id, $sms_passwd);
			
			$ret = $sms->send($sms_to, $sms_from, $sms_msg, $sms_date, $sms_type);
			
			if($ret)
			{
				$smsInfo	= json_encode($ret);
				$retunrVal	= true;
				$returnMsg	= "Success";
			}
			else
			{
				$smsInfo	= "";
				$retunrVal	= false;
				$returnMsg	= $sms->errMsg;
			}
		
			$logData = "Api : sendSMS // reqPhone : {$reqPhone} //resPhone : {$resPhone} // 메세지 : {$sendStr} // 발송여부 : {$returnMsg} // 잔여정보 : {$smsInfo}";
			LogUtil::writeFileLog($this->logPath, $logData);
		
			return $retunrVal;
		}
		
		function feedSimpleLog($logData)
		{
			$today = date("Ymd", time()); ;
		
		
			$fileDirectory = $this->logPath;
		
		
			if(is_dir ($fileDirectory)!=true){
				mkdir($fileDirectory);
			}
		
			if(is_dir($fileDirectory.$today)!=true){
				mkdir($fileDirectory.$today);
			}
		
			$fileName = $today.".txt";
		
			$fPath = $fileDirectory.$today."/".$fileName;
		
			$fp = fopen($fPath,"a+");
		
			//파일에 쓰는부분 .
		
			fwrite($fp,"LogStart Date : ".$today. " // " . $logData . "\n");
			fwrite($fp,"============================================================================\n");
		
		
			//파일 쓰기 끝 닫기
		
			fclose($fp);
		}

        //스마트 에디터기용
        function seditorImagePreUpload()
        {
            $url = $_REQUEST["callback"].'?callback_func='.$_REQUEST["callback_func"];

            $tmp_name = $_FILES["Filedata"]["tmp_name"];
            $file_name = $_FILES["Filedata"]["name"];
            $file_size = $_FILES["Filedata"]["size"];

            $actionUrl = "http://106.240.232.36:8890/GolfLand/ApiComm/imgUpload" ;

            $headers = array("Content-Type:multipart/form-data");


            if($_FILES){
                $this->req["file"] = "@{$tmp_name};filename={$file_name};type=image/jpeg";
            }

            $curl_obj = curl_init();
            curl_setopt($curl_obj, CURLOPT_URL, $actionUrl);
            curl_setopt($curl_obj, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl_obj, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($curl_obj, CURLOPT_POST, true);
            curl_setopt($curl_obj, CURLOPT_INFILESIZE, $file_size);
            curl_setopt($curl_obj, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_obj, CURLOPT_POSTFIELDS, $this->req);

            $ret = json_decode(curl_exec($curl_obj))->entity;
            $imagePath = $ret[0]->fileUrlPath;

            if($imagePath == "")
            {
                $url .= '&errstr=error';
            }
            else
            {
                $url .= "&bNewLine=true";
                $url .= "&sFileName=".$imagePath;
                $url .= "&sFileURL={$this->imgPath}/480/".$imagePath;
            }

            header("Location:".$url);
            exit;
        }

        function imgUpload(){
            $actionUrl = "http://106.240.232.36:8890/GolfLand/ApiComm/imgUpload" ;

            $headers = array("Content-Type:multipart/form-data");

            $tmp_name = $_FILES["file"]["tmp_name"];
            $file_name = $_FILES["file"]["name"];
            $file_size = $_FILES["file"]["size"];

            //echo json_encode($_FILES);
            //$post_filed = array("file" => "@{$tmp_name}; filename={$file_name}");

            if($_FILES){
                $this->req["file"] = "@{$tmp_name[0]};filename={$file_name[0]};type=image/jpeg";
            }

            //$this->req["filename"] = "@{$file_name}";

            $curl_obj = curl_init();
            curl_setopt($curl_obj, CURLOPT_URL, $actionUrl);
            curl_setopt($curl_obj, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl_obj, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($curl_obj, CURLOPT_POST, true);
            curl_setopt($curl_obj, CURLOPT_INFILESIZE, $file_size);
            curl_setopt($curl_obj, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_obj, CURLOPT_POSTFIELDS, $this->req);
            //curl_setopt($curl_obj, CURLOPT_POSTFIELDS, array("file" => "@{$tmp_name};filename={$file_name}"));

            return (curl_exec($curl_obj));
        }

        function getData($actionUrl, $request=array()) {
            $url = $actionUrl . "?" . http_build_query($request, '', '&');
            $curl_obj = curl_init();
            curl_setopt($curl_obj, CURLOPT_URL, $url);
            curl_setopt($curl_obj, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($curl_obj, CURLOPT_RETURNTRANSFER, true);
            return  (curl_exec($curl_obj));
        }

        function postData($actionUrl, $postData) {
            $curl_obj = curl_init();
            curl_setopt($curl_obj, CURLOPT_URL, $actionUrl);
            curl_setopt($curl_obj, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($curl_obj, CURLOPT_POST, true);
            curl_setopt($curl_obj, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl_obj, CURLOPT_POSTFIELDS, $postData);
            return  (curl_exec($curl_obj));
        }

        function lnFn_Common_CrPost($a,$b='',$c=0){
            if( !is_array( $a ) ) return false;
            foreach((array)$a as $k=>$v){
                if($c){
                    if(is_numeric( $k )) $k=$b;
                    else $k=$b;
                }
                else{
                    if (is_int($k))$k=$b.$k;
                }
                if(is_array($v) || is_object($v)){
                    $r[] = $this->lnFn_Common_CrPost($v, $k, 1);
                    continue;
                }
                $r[] = urlencode($k) . "=" . urlencode($v) ;
            }
            return implode("&", $r);
        }

        function post($apiName, $params){
            $request = $this->lnFn_Common_CrPost($params);
            $actionUrl = "{$this->serverRoot}{$apiName}";
            $retVal = $this->postData($actionUrl, $request);
            return $retVal;
        }

        function get($apiName, $params){
            $actionUrl = "{$this->serverRoot}{$apiName}";
            $retVal = $this->getData($actionUrl, $params);
            return $retVal;
        }

        function checkNullParam($paramName, $default){
            return $this->req[$paramName] == "" ? $default : $this->req["$paramName"];
        }
	}
}
?>