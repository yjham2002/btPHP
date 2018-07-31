<?php
if(! class_exists("Constants") )
{
	class Constants 
	{
	
		/* 개발서버 */
		var $excelSavePath			= "/home/KCSpecialVehicle/upload_excel" ;
		var $fileSavePath			= "/home/KCSpecialVehicle/upload_img" ;
		var $fileSavePath_720		= "/home/KCSpecialVehicle/720" ;				// linux 경로
		var $fileSavePath_640		= "/home/KCSpecialVehicle/640" ;				// linux 경로
		var $fileSavePath_480		= "/home/KCSpecialVehicle/480" ;				// linux 경로
		var $fileSavePath_320		= "/home/KCSpecialVehicle/320" ;				// linux 경로
		var $fileSavePath_100		= "/home/KCSpecialVehicle/100" ;				// linux 경로
		var $payAttentionInfoPath	= "/home/KCSpecialVehicle/setting/pay_attention.txt";	// 결제시 유의사항
		

		var $logPath				= "/home/KCSpecialVehicle/log" ;	// simple 로그기록
		var $documentRoot			= "/home/KCSpecialVehicle/" ;	// simple 로그기록
		var $webRoot				= "http://tsh.fingersmith.co.kr" ;			
		var $con_domain				= "http://tsh.fingersmith.co.kr" ;	// 메일에서 사용되는 도메인
		
				
		var $fileSaveUrl			= "/upload_img/" ;
		var $fileSaveUrl_480		= "/480/" ;


		var $dbHost					= "182.161.118.74" ;
		var $dbName					= "kcSpecialVehicle" ;
		var $dbUser					= "root" ;
		var $dbPass					= "$#@!richware7" ;
		var $charset				= "utf8" ;
		
		
		/* System Constants */
		var $MEM_TYPE_NOMAL			= "N" ;		// 일반회원
		var $MEM_TYPE_HOLD			= "H" ;		// 멤버쉽 신청중
		var $MEM_TYPE_MEMBER		= "M" ;		// 멤버쉽 회원
		var $MEM_TYPE_VIP			= "V" ;		// VIP 회원
		
		var $MEM_REGI_EMAIL			= "E" ;		// 이메일 회원가입
		var $MEM_REGI_KAKAO			= "K" ;		// 카카오 회원가입
		var $MEM_REGI_FACEBOOK		= "F" ;		// 페이스북 회원가입
		
		var $STATUS_NOMAL			= "Y" ;		// 정상
		var $STATUS_STOP			= "N" ;		// 삭제(탈퇴)

		var $BOARD_PUBLIC_NORMAL	= "Y" ;		// 일반글
		var $BOARD_PUBLIC_CLOSE		= "N" ;		// 비밀글
		
		var $POPUP_TYPE_OPEN		= "1" ;		// 실행시 팝업
		var $POPUP_TYPE_CLOSE		= "2" ;		// 종료시 팝업
		
		var $LNG_ONE_KM				= 11259;   // LNG 약 1키로 정도
		var $LAT_ONE_KM				= 9015;   // LNG 약 1키로 정도
		
		var $PAY_TYPE_USE			= "use" ;		// 실행시 팝업
		var $PAY_TYPE_ADMIN			= "admin" ;		// 종료시 팝업
		var $PAY_TYPE_RETRIEVE		= "retrieve" ;		// 종료시 팝업
		var $SEND_SMS_PHONE			= "01042201597";
		
		// 푸시 타입 정의
		public $PUSH_TYPE_BI = "100";
		public $PUSH_TYPE_BI_COM = "101";
		public $PUSH_TYPE_MS_OK = "201";
		public $PUSH_TYPE_MS_NO = "202";
		public $PUSH_TYPE_V_OK = "203";
		public $PUSH_TYPE_V_NO = "204";
		public $PUSH_TYPE_ADMIN = "999";
	}
}
?>