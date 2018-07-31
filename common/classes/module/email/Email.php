<?php
if(! class_exists("Email") )	{

	class Email {

		protected $MailHeaderArray = array();			// 메일헤더를 담을 배열 
     
		protected $MailFrom;							// 보내는 사람 
		protected $MailTo;								// 회신받을 주소 (기본적으로 보내는 메일주소가 된다) 
		protected $ArrMailTo = array();					// 받는 사람을 담을 배열 
		 
		protected $Subject;								// 메일제목 
		protected $MailBody;							// 메일본문 
		protected $Charset = 'UTF-8';					// 메일기본 캐릭터셋 	 
		
		protected $no ;								// 데이터베이스 메일폼 no
		protected $strArray = array() ;					// replace할 배열
		
		protected $ori_subject;								// 컨버팅전 제목

		function __construct()	//보내는 사람
		{
		}

		public function setFrom($email, $name = null) 
		{ 

			// 보내는 메일 
			$this->setReplyTo($email); 
			return $this->MailFrom = ($name) ? $name . ' <' . $email . '>' : $email; 
		} 

		public function makeMailBody()
		{
			$mailbody = $this->MailBody ;
			foreach($this->strArray as $key => $val)
				$mailbody = str_replace($key, $val, $mailbody) ;

			return $mailbody ;
		}

		public function setReplyTo($email) 
		{ 
			// 회신주소 - 기본적으로 보내는 메일을 회신주소로 셋한다 
			return $this->MailTo = $email; 
		} 

		public function addTo($email, $name = null) 
		{ 
			// 받는 메일을 추가한다 
			return $this->ArrMailTo[$email] = $name; 
		} 

		private function AddBasicHeader() 
		{ 
			// 메일의 기본 헤더를 작성한다 
			$this->addHeader('From', $this->MailFrom); 
			$this->addHeader('User-Agent', 'Dabuilder Mail System'); 
			$this->addHeader('X-Accept-Language', 'ko, en'); 
			$this->addHeader('X-Sender', $this->MailTo); 
			$this->addHeader('X-Mailer', 'PHP'); 
			$this->addHeader('X-Priority', 1); 
			$this->addHeader('Reply-to', $this->MailTo); 
			$this->addHeader('Return-Path', $this->MailTo); 
			$this->addHeader('Content-Type', 'text/html; charset=' . $this->Charset); 
			$this->addHeader('Content-Transfer-Encoding', 'base64'); 							  

		}

		private function addHeader($Content, $Value) 
		{ 
			// 메일헤더의 내용을 추가한다 
			$this->MailHeaderArray[$Content] = $Value; 
		} 

		private function makeMailHeader() 
		{ 
			// 보낼 메일의 헤더를 작성한다 
			$header = ""; 
			foreach($this->MailHeaderArray as $Key => $Val) 
				$header .= $Key . ": " . $Val . "\r\n"; 
			 
			return $header . "\r\n"; 
		}

		public function setMailBody($Body, $useHtml = true) 
		{ 
			if(!$useHtml) {        // 메일본문이 HTML 형식이 아니면 HTML 형식으로 바꾸어준다 
				$Body = ' 
					<html> 
						<head> 
							<meta http-equiv="Content-Type" content="text/html; charset=' . $this->Charset . '"> 
							
						</head> 
						 
						<body> 
							' . nl2br($Body) . ' 
						</body> 
					</html> 
				'; 
			} 
			 
			$this->MailBody = $Body ;        // 메일본문을 셋한다 
		}

		public function setSubject($subject)
		{
			$this->Subject="=?UTF-8?B?".base64_encode($subject)."?=\n";
			$this->ori_subject = $subject ;
		}


		public function sendMail($fromMail, $fromName, $toMail, $toName, $strArr)
		{	
			$fromName = iconv("UTF-8","EUC-KR",$fromName) ;
			$toName = iconv("UTF-8","EUC-KR",$toName) ;

			$this->strArray = $strArr ;			
			
			// 보내는 메일 
			$this->setReplyTo($fromMail); 
			$this->MailFrom = ($fromName) ? $fromName . ' <' . $fromMail . '>' : $fromMail; 

			// 받는 메일
			$this->addTo($toMail, $toName) ;

			$Contents = $this->makeMailBody() ;
			
			$Contents = chunk_split(base64_encode($Contents));

			// 메일을 전송한다 
			$this->AddBasicHeader();        // 메일의 기본헤더를 생성한다 

			$Succ = 0; 
			foreach($this->ArrMailTo as $Email => $Name) { 
				$toEMail = ($Name) ? $Name . ' <' . $Email . '>' : $Email;    // 받는메일 
				$this->addHeader('To', $toEMail);                            // 메일헤더에 받는메일을 추가한다 
				$header = $this->makeMailHeader();                            // 헤더를 작성한다 
				//echo "subject: " .$this->Subject ."Email". $Email ."header: ". $header  ; 
				if(mail($Email, $this->Subject, $Contents, $header)) $Succ++;    // 성공여부 판단 
			
			} 
			 
			return $Succ;
		}


	}//클래스 종료

}

?>