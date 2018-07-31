<?php
if(! class_exists("Push") )	{

	class Push{
			
		public $pushMessage = "" ;		// Push Message		
		public $pushFlag = "1" ;			// Push flag  - 1:관리자 임의 발송
		
		private $gcm_key = "AIzaSyAa1R06tYAiqeYIvJ5dC4THb2S-LgNNzfY" ;
		private $gaom_key = "";
		
		// xml 키가 들어 왔을경우 
		function _counstruct($req) 
		{
		}
		
		//벌크단위로 발송
		function sendPushArray($pushKeyArr)
		{
			$gcmKeyArr = Array();
			$gaomKeyArr = Array();
			$apnsKeyArr = Array();

			if($pushKeyArr != null){
				foreach($pushKeyArr as $key => $pushKey){
					if($pushKey["appTypeID"] != "2"){
						
						if($pushKey["gaomKey"] != "")
							array_push($gaomKeyArr, $pushKey["gaomKey"]);
						else if(strlen($pushKey["registrationKey"]) > 32)
							array_push($gcmKeyArr, $pushKey["registrationKey"]);
					}
					
					if($pushKey["appTypeID"] == "2" && strlen($pushKey["registrationKey"]) > 32){
						array_push($apnsKeyArr, $pushKey["registrationKey"]);
					}

					if(sizeof($gcmKeyArr) >= 500){
						$this->sendMessageGCM($gcmKeyArr);
						$gcmKeyArr = Array();
					}

					if(sizeof($gaomKeyArr) >= 500){
						$this->sendMessageGAOM($gaomKeyArr);
						$gaomKeyArr = Array();
					}

					if(sizeof($apnsKeyArr) >= 100){
						$this->sendMessageApnsArray($apnsKeyArr);
						$apnsKeyArr = Array();
					}
						
				}
			}

			//자투리 푸시들 전송
			if(sizeof($gcmKeyArr) > 0){
				$this->sendMessageGCM($gcmKeyArr);
			}

			//자투리 푸시들 전송
			if(sizeof($gaomKeyArr) > 0){
				$this->sendMessageGAOM($gaomKeyArr);
			}

			//자투리 푸시들 전송
			if(sizeof($apnsKeyArr) > 0){
				$this->sendMessageApnsArray($apnsKeyArr);
			}

		}

		// GAOM 서버로 MESSAGE 보내기
		function sendMessageGAOM($keyArray)
		{
			$this->seq = 100;

			$ch = curl_init();  

			$resultJson =  array(								
								"flag" => $this->pushFlag ,
								"message" => $this->pushMessage
							);
			
			$dataJson = json_encode($resultJson) ;

			$param = "cmd=pushMessage";
			$param .= "&id=" . $this->gaom_key;
			$param .= "&message=" . $dataJson;
			$param .= "&seq=" . "1";
			
			
			
			for($idex = 0 ; $idex < sizeof($keyArray); $idex++)
				$param .= "&key=" . $keyArray[$idex] . "&data=" . $idex;
			

			$headers = array(
				"Content-Type: application/x-www-form-urlencoded", 
				"Content-Length: ". strlen($param)
			);
						
			curl_setopt($ch, CURLOPT_URL, "http://www.qpush.co.kr/ext.api");
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $param);
			$result = curl_exec($ch);
			
			//echo $param . "<br>";
			//echo $result;

			curl_close($ch);
		}

		
		// GCM 서버로 MESSAGE 보내기
		function sendMessageGCM($keyArray)
		{
			$ch = curl_init();  

			$resultJson = array(
				"collapse_key" => "score_update" ,
				"time_to_live" => 1 ,
				"delay_while_idle" => true,
				"data" => array(								
								"flag" => $this->pushFlag,								
								"message" => $this->pushMessage
							),
				"registration_ids" => $keyArray
			) ;
			
			$data = json_encode($resultJson) ;
			
			$headers = array(
				"Content-Type: application/json", 
				"Content-Length: ". strlen($data), 
				"Authorization: key=" . $this->gcm_key  
			);
						
			curl_setopt($ch, CURLOPT_URL, "https://android.googleapis.com/gcm/send");
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
			$result = curl_exec($ch);
			curl_close($ch);
		}



		// 디바이스토큰ID
		function sendMessageApns($deviceToken)
		{
			// 개발용			
			$apnsHost = 'gateway.sandbox.push.apple.com' ;
			$apnsCert = '/www/way21/authFile/way21Dev.pem';
			
			// 운영
			// $apnsHost = 'gateway.push.apple.com' ;
			// $apnsCert = '/www/way21/authFile/way21Dist.pem'; 
			
			$pass = 'pass' ;

			$apnsPort = 2195 ;

			$payload = array('aps' => array('alert' => $this->pushMessage, "no" => $this->push_no, 'flag' => $this->pushFlag , 'badge' => 0, 'sound' => 'default')) ;
			$payload = json_encode($payload) ;

			$streamContext = stream_context_create() ;
			stream_context_set_option($streamContext, 'ssl', 'local_cert', $apnsCert) ;
			stream_context_set_option($streamContext, 'ssl', 'passphrase', $pass) ;

			// $apns = stream_socket_client($apnsHost, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
			// $apns = stream_socket_client('ssl://'.$apnsHost.':'.$apnsPort, $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext);
			// $apns = stream_socket_client('ssl://gateway.push.apple.com:2195', $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext) ;
			$apns = stream_socket_client('ssl://gateway.sandbox.push.apple.com:2195', $error, $errorString, 2, STREAM_CLIENT_CONNECT, $streamContext) ;
			
			if($apns)
			{
				$apnsMessage = chr(0).chr(0).chr(32).pack('H*', str_replace(' ', '', $deviceToken)).chr(0).chr(strlen($payload)).$payload ;
				fwrite($apns, $apnsMessage) ;
				fclose($apns) ;
			}
			
			return true ;
		}

	}

}

?>
