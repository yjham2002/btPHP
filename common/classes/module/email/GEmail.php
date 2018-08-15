<? require_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/module/email/class.phpmailer.php" ; ?>
<?
if(! class_exists("GEmail") )	{

	class GEmail {

		protected $gMail = null;
		protected $userName = "BibleTime";
		protected $userEmail = "noreply@bibletime.org";
		protected $password = "16449159";
		protected $host = "ssl://smtp.gmail.com";
		protected $port = 465;
		protected $mailer = "smtp";


//		function GEmail($req, $xmlKey)	//보내는 사람
        function GEmail()	//보내는 사람
		{
			$this->init();
		}

		function init()
		{
			$this->gMail = new PHPMailer();
			$this->gMail->IsSMTP(); // send via SMTP
			$this->gMail->Host = $this->host;
			$this->gMail->Port = $this->port;
			$this->gMail->Mailer = $this->mailer;
			$this->gMail->SMTPAuth = true; // turn on SMTP authentication
			$this->gMail->WordWrap = 50; // set word wrap
			$this->gMail->IsHTML(true); // send as HTML
			$this->setAccount($this->userEmail, $this->password);
			$this->setSendEmail($this->userEmail, $this->userName);			
		}
		

		//보내는 계정 설정
		function setAccount($email, $pass)
		{
			$this->gMail->Username = $email; // SMTP username
			$this->gMail->Password = $pass; // SMTP password
		}


		//이메일 받는계정 추가
		function addReceiveEmail($email, $name)
		{
			$this->gMail->addAddress($email,$name);
		}


		//보내는 메일 셋팅
		function setSendEmail($email, $name)
		{
			$this->gMail->From = $email;
			$this->gMail->FromName = $name;
		}


		//회신가능 여부
		function isReplyAvail()
		{
			$this->gMail->AddReplyTo($this->userEmail, $this->userName);
		}


		//파일 첨부
		function attachFile($filePath)
		{
			$this->gMail->AddAttachment($filePath); // attachment
		}

		//내용셋팅
		function setMailBody($content)
		{
			$this->gMail->Body = $content;
		}


		//제목 셋팅
		function setSubject($subject)
		{
			$this->gMail->Subject = $subject;
		}


		function sendTestMail()
		{
			$this->setMailBody("테스트 이메일");
			$this->setSubject("테스트 이메일 제목");

			$this->addReceiveEmail("fishcreek@naver.com", "전세호");

			$this->sendMail();
		}

		
		function sendMail()
		{	
			$isSend = $this->gMail->Send();


//			if(!$isSend)
//				echo "Mailer Error: " . $this->gMail->ErrorInfo;
//			else
//				echo "Message has been sent";

			return $isSend;
		}


	}//클래스 종료

}

?>