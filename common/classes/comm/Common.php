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
//		function sendSMS($sendStr, $resPhone, $reqPhone){
//
//			$sms_id		= "groupby" ;
//			$sms_passwd	= "rtgvcdf$%" ;
//			$sms_type	= "L" ;
//			$sms_to		= $resPhone ;
//			$sms_from	= $reqPhone ;
//			$sms_date	= "0" ;
//			$sms_msg	= $sendStr ;
//
//			if($resPhone == "" && $resPhone == "")
//			{
//				$logData = "Api : sendSMS // reqPhone : {$reqPhone} //resPhone : {$resPhone} // 발송실패";
//				LogUtil::writeFileLog($this->logPath, $logData);
//				return false;
//			}
//
//			$sms = new EmmaSMS();
//
//			$sms->login($sms_id, $sms_passwd);
//
//			$ret = $sms->send($sms_to, $sms_from, $sms_msg, $sms_date, $sms_type);
//
//			if($ret)
//			{
//				$smsInfo	= json_encode($ret);
//				$retunrVal	= true;
//				$returnMsg	= "Success";
//			}
//			else
//			{
//				$smsInfo	= "";
//				$retunrVal	= false;
//				$returnMsg	= $sms->errMsg;
//			}
//
//			$logData = "Api : sendSMS // reqPhone : {$reqPhone} //resPhone : {$resPhone} // 메세지 : {$sendStr} // 발송여부 : {$returnMsg} // 잔여정보 : {$smsInfo}";
//			LogUtil::writeFileLog($this->logPath, $logData);
//
//			return $retunrVal;
//		}

        /**
         * 문자대표 sms 전송함수
         */
        function sendSmsBibleTime($url){
            $result = file_get_contents($url);
            $result = trim($result);
            parse_str($result, $result_var);

            return $result_var;
        }
        function sendSms($to, $msg){
            $actionUrl = "http://link.smsceo.co.kr/sendsms_utf8.php";
            $params = Array(
                "userkey" => "BjsNPg08Dj4CMQYpAj4DP1dnBGNRaAVuVy9Vfg==",
                "userid" => "onebody",
                "msg" => $msg,
                "phone" => $to,
                "callback" => "07078740895",
                "send_date" => ""
            );
            $url = $actionUrl . "?" . http_build_query($params, '', '&');
            $result = $this->sendSmsBibleTime($url);

//            if($result["result_code"] == "1"){    // 전송성공
//                echo "결과코드 : " . $result["result_code"];
//                echo "메세지 : " . $result["result_msg"];
//                echo "총 접수건수 : " . $result["total_count"];
//                echo "성공건수 : " . $result["succ_count"];
//                echo "실패건수 : " . $result["fail_count"];
//                echo "잔액 : " . $result["money"];
//            }
            return $result;
        }

        function sendKakao($to, $text, $templateCode){
            $params = Array(
                "usercode" => "bibletime",
                "deptcode" => "ZR-JL6-FB",
                "yellowid_key" => "c317b7234fd51330097e43141101bd91161cf58e",
            );

            $message = Array(
                "message_id" => "",
                "to" => $to,
                "text" => $text,
                "from" => "07078740896",
                "template_code" => $templateCode,
                "reserved_time" => "",
                "re_send" => "Y",
                "re_text" => ""
            );
            $messagesData =array($message);
            $params["messages"] = $messagesData;
            $output =  json_encode($params);

            $ch = curl_init("https://api.surem.com/alimtalk/v2/json");
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($ch, CURLOPT_POSTFIELDS, $output);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json;charset=UTF-8',
                    'Content-Length: ' . strlen($output))
            );

            $result = curl_exec($ch);

            $this->logKakao(1, $to, $text, $templateCode, $result);

            return $result;
        }

        function logKakao($count, $phone, $content, $template, $result){
            $res = json_decode($result);
            $resNum = 0;
            if($res->code == "200") $resNum = 1;

            $sql = "INSERT INTO tblKakaoLog(`count`, `phone`, `content`, `templateName`, `result`, `regDate`)
                    VALUES ('{$count}', '{$phone}', '{$content}', '{$template}', '{$resNum}', NOW())";
            $this->update($sql);
        }

        function sendAuthrizeSubscription($subscriptionName, $startDate, $totalOccurrences, $amount, $unit, $cardNo, $cardExpiry,
                                          $FirstName, $LastName, $intervalLength, $address, $city, $state, $zip){
            $refId = 'ref' . time();

            $params["ARBCreateSubscriptionRequest"] = Array(
                "merchantAuthentication" => Array(
                    "name" => "54W7Cxvt",
                    "transactionKey" => "62q47AUmd9qH4d35"
                ),
                "refId" => "$refId",
                "subscription" => Array(
                    "name" => $subscriptionName,
                    "paymentSchedule" => Array(
                        "interval" => Array(
                            "length" => $intervalLength,
                            "unit" => $unit
                        ),
                        "startDate" => $startDate,
                        "totalOccurrences" => $totalOccurrences
                    ),
                    "amount" => $amount,
                    "payment" => Array(
                        "creditCard" => Array(
                            "cardNumber" => $cardNo,
                            "expirationDate" => $cardExpiry
                        )
                    ),
                    "billTo" => Array(
                        "firstName" => $FirstName,
                        "lastName" => $LastName,
                        "address" => $address,
                        "city" => $city,
                        "state" => $state,
                        "zip" => $zip
                    )
                )
            );
            $params = json_encode($params);


            $postString = '';
            foreach ($params as $key => $value)
                $postString .= $key.'='.urlencode($value).'&';
            $postString = trim($postString, '&');
            $url = 'https://apitest.authorize.net/xml/v1/request.api';


            $request = curl_init($url);
            curl_setopt($request, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($request, CURLOPT_POSTFIELDS, $params);
            curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($request, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json;charset=UTF-8',
                    'Content-Length: ' . strlen($params))
            );

            $postResponse = curl_exec($request);
            curl_close($request);

            if(substr($postResponse, 0, 3) == "\xef\xbb\xbf"){
                $postResponse = substr($postResponse, 3, strlen($postResponse));
            }
            $response = json_decode($postResponse);
            $returnCode = $response->messages->message[0]->code;

            return $response;
        }

        function getAuthorizeStatus($subscriptionId){
            $refId = 'ref' . time();
            $params["ARBGetSubscriptionStatusRequest"] = Array(
                "merchantAuthentication" => Array(
                    "name" => "54W7Cxvt",
                    "transactionKey" => "62q47AUmd9qH4d35"
                ),
                "refId" => $refId,
                "subscriptionId" => $subscriptionId
            );
            $params = json_encode($params);


            $postString = '';
            foreach ($params as $key => $value)
                $postString .= $key.'='.urlencode($value).'&';
            $postString = trim($postString, '&');
            $url = 'https://apitest.authorize.net/xml/v1/request.api';


            $request = curl_init($url);
            curl_setopt($request, CURLOPT_CUSTOMREQUEST, "POST");
            curl_setopt($request, CURLOPT_POSTFIELDS, $params);
            curl_setopt($request, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($request, CURLOPT_HTTPHEADER, array(
                    'Content-Type: application/json;charset=UTF-8',
                    'Content-Length: ' . strlen($params))
            );

            $postResponse = curl_exec($request);
            curl_close($request);

            if(substr($postResponse, 0, 3) == "\xef\xbb\xbf"){
                $postResponse = substr($postResponse, 3, strlen($postResponse));
            }
            $response = json_decode($postResponse);
            $returnCode = $response->messages->message[0]->code;

            return $response;
        }

        function makeFileName(){
            srand((double)microtime()*1000000) ;
            $Rnd = rand(1000000,2000000) ;
            $Temp = date("Ymdhis") ;
            return $Temp.$Rnd;
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

        function get_masking_string($str, $len1, $len2=0, $limit=0, $mark='*')
        {
            $arr_str = preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY);
            $str_len = count($arr_str);
            $len1 = abs($len1);
            $len2 = abs($len2);
            if($str_len <= ($len1 + $len2))
                return $str;
            $str_head = '';
            $str_body = '';
            $str_tail = '';
            $str_head = join('', array_slice($arr_str, 0, $len1));
            if($len2 > 0)
                $str_tail = join('', array_slice($arr_str, $len2 * -1));
            $arr_body = array_slice($arr_str, $len1, ($str_len - $len1 - $len2));
            if(!empty($arr_body)) {
                $len_body = count($arr_body);
                $limit    = abs($limit);
                if($limit > 0 && $len_body > $limit)
                    $len_body = $limit;
                $str_body = str_pad('', $len_body, $mark);
            }
            return $str_head.$str_body.$str_tail;
        }

        function addPrime($ext_inx, $username, $bank_code, $account_no, $account_name, $account_jumin, $start_date, $inday, $pay_monthdefault){
            $sql = "
                INSERT INTO member(
                    `m_index`, 
                    `ext_inx`, 
                    `username`, 
                    `bank_code`, 
                    `account_no`, 
                    `account_name`, 
                    `account_jumin`, 
                    `start_date`, 
                    `remove`, 
                    `pay_nonpayment`, 
                    `inday`, 
                    `pay_monthdefault`, 
                    `pay_agreement`, 
                    `account_divide`, 
                    `p_seday`, 
                    `month_max`, 
                    `send_stat`, 
                    `in_time`
                )
                VALUES(
                    '', # 고정값 : auto_increment값
                    '{$ext_inx}', #a01 
                    '{$username}',  # 고객명
                    '{$bank_code}', # 0040000
                    '{$account_no}',  # 계좌번호 특수문자 제외
                    '{$account_name}', # 예금주명 
                    '{$account_jumin}', # 생년월일만 입력하라고 필수사항으로 표시됨(주민번호 앞 6자리)
                    '{$start_date}', # 2014-01 (혹시 몰라서 써놓는데 2001~현재+5 내에 입력이래요)
                    '1', # 고정값 
                    '0', # 정기결제시작년월이 되지 않아도 최대한 빨리 빼낼 금액 => 0 쓰면 될 듯, 만약 이체예정일을 3일로 했는데 오늘이 5일이면 뺄지 말지 결정해야 하니까 물어보고 정기결제 금액이랑 동일하게 하면 될듯
                    '{$inday}', #  필히 2~25 사이의 값 - 월마다 결제될 일자(숫자) (위에는 년월만 있으니)
                    '{$pay_monthdefault}', # 월마다 결제될 금액(숫자)
                    '0', # 할부거래가 아니므로, 할부총액은 0원
                    '1', # 1:월매출, 2: 수시매출, 3:할부매출, 4:기간매출, 5:월종량제 : 여기선 무제한이므로, 1로 설정
                    '', # 다른 타입의 거래에서 사용되는 값 - 공백으로 처리
                    '0', # 월청구제한 여부 0:제한X / 1이상:제한O : 예를 들어 이번달에 한번 연체했으면, 
                    # 1이 입력될 경우 1(월청구제한) * 30000(매출예정액) = 30000  30000원이 한달 청구 제한 금액이 됨.
                    # 2달이상 연체된 고객이여서 60000원의 미수금이 있다해도 해당월내에는 최대 30000원만 청구됨.
                    '1', # 고정값 : 1로 박아두면 아인시스템이 확인하면 2로 변할거임
                    '' # 고정값 : 아인시스템에서 알아서 넣는 regDate
                )
            ";

            $this->connect_ext_db();
            $this->update($sql);
            $index = $this->mysql_insert_id();
            $this->connect_int_db();
            return $index;
        }

        function addAgreeFile($mem_inx, $ext_inx, $bank_code, $account_no, $af_date, $af_kind, $af_filename, $apply_div){
            $sql = "
                INSERT INTO agreefile(
                  mem_inx, 
                  ext_inx, 
                  bank_code, 
                  account_no, 
                  af_date, 
                  af_kind, 
                  af_filename, 
                  apply_div, 
                  send_stat
                )
                VALUES(
                  '{$mem_inx}',
                  '{$ext_inx}',
                  '{$bank_code}',
                  '{$account_no}',
                  '{$af_date}',
                  '{$af_kind}',
                  '{$af_filename}',
                  '{$apply_div}',
                  '1'
                ) 
            ";
            $this->connect_ext_db();
            $this->update($sql);
            $this->connect_int_db();
        }

        function ftpUpload($file_name){
            $ftp_host = "219.255.134.104";   // ftp host명
            $ftp_id = "agree_testupg";         // ftp 아이디
            $ftp_pw = "agree_testupgpw1234";  // ftp 비밀번호
            $ftp_port = "21";           // ftp 포트

//            $server_path = "/agree_testupg/";
            $server_path = "/";
            if(!($fc = ftp_connect($ftp_host, $ftp_port))) die("$ftp_host : $ftp_port - 연결에 실패하였습니다.");
            if(!ftp_login($fc, $ftp_id, $ftp_pw)) die("$ftp_id - 로그인에 실패하였습니다.");
            ftp_pasv($fc, true) or die("Unable switch to passive mode");
            ftp_chdir($fc, $server_path);
            $source_file = $this->filePath . $file_name;
            $destination_file = $file_name;

            if(!ftp_put($fc, $destination_file, $source_file, FTP_ASCII)){
                echo" <script> window.alert ('파일을 지정한 디렉토리로 복사 하는 데 실패했습니다.');</script>";
                exit;
            }
            ftp_quit($fc);
        }
	}
}
?>