<?php
if(! class_exists("InAppPaymentVerifyCls") )	{

	class InAppPaymentVerifyCls{

		/*
		IOS URL 예시
		 - 테스트 : https://sandbox.itunes.apple.com/verifyReceipt
		 - 운영 : https://buy.itunes.apple.com/verifyReceipt
		*/
		private $iosVerifyURL = "";		//IOS인앱 검증 url
		private $androidRSAKey = ""; 	//안드로이드 암호화키

		function __construct($iosVerifyURL, $androidRSAKey) 
		{
			$this->iosVerifyURL		= $iosVerifyURL;
			$this->androidRSAKey	= $androidRSAKey ;
		}


		/***************************************************************************
		*	제  목 : 아이폰 인앱 결제 검증
		*	함수명 : verifyIOSPayment
		*	작성일 : 2013-07-04
		*	작성자 : dev.Na
		*	설  명 : receiptData : 결제결과 바이너리 데이터
		*	수  정 :
		'***************************************************************************/
		function verifyIOSPayment($receiptData)
		{
			if($receiptData == "")
			{
				return "-1";
			}

			$postData = json_encode(
				array('receipt-data' => $receiptData)
			);
		   
			$ch = curl_init($this->iosVerifyURL);

			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

			$jsonResult = curl_exec($ch);
			$errno		= curl_errno($ch);
			$errmsg		= curl_error($ch);

			curl_close($ch);

			$resultArr = json_decode($jsonResult, true);

			if($resultArr["status"] === 0)
			{
				return "1";
			}
			else
			{
				return "-2";
			}
		}


		/***************************************************************************
		*	제  목 : 안드로이드 인앱 결제 검증
		*	함수명 : verifyANDPayment
		*	작성일 : 2013-07-04
		*	작성자 : dev.Na
		*	설  명 : signed_data : json_data, signature = 바이너리 데이터
		*	수  정 :
		'***************************************************************************/
		function verifyANDPayment($signed_data, $signature) 
		{
			$key = "-----BEGIN PUBLIC KEY-----\n" . chunk_split($this->androidRSAKey, 64, "\n") . "-----END PUBLIC KEY-----";

			$key = openssl_get_publickey($key);
			
			

			//키가 이상함
			if (false === $key) {
				return "-1";
			}
			
			//특수문자 escape 제거
			$signed_data = stripslashes($signed_data);


			

			//signature는 바이너리 데이터이기 때문에 반드시 base64로 인코딩
			$signature = base64_decode($signature);

			$result = openssl_verify(
				$signed_data,
				$signature,
				$key,
				OPENSSL_ALGO_SHA1
			);

			//데이터 검증 성공
			if (1 === $result) 
			{
				return "1";
			}
			//데이터 검증 실패
			else if (0 === $result) 
			{
				return "-2";
			}

			//에러
			return "-3";
			
		}




	}//클래스 종료
}

?>