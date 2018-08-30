<?php
if(! class_exists("Constants") )
{
	class Constants 
	{
	
//		/* 개발서버 */
//		var $excelSavePath			= "D:/workspace_php/kopas/upload_excel" ;
//		var $fileSavePath			= "C:/Users/p/workspace_php/kopas/wapp/upload_img" ;
//		var $fileSavePath_720		= "C:/Users/p/workspace_php/kopas/720" ;
//		var $fileSavePath_640		= "C:/Users/p/workspace_php/kopas/640" ;
//		var $fileSavePath_480		= "C:/Users/p/workspace_php/kopas/480" ;
//		var $fileSavePath_320		= "C:/Users/p/workspace_php/kopas/320" ;
//		var $fileSavePath_100		= "C:/Users/p/workspace_php/kopas/100" ;
//
//
//		var $logPath				= "C:/Users/p/workspace_php/kopas/wapp/log" ;	// simple 로그기록
//		var $documentRoot			= "C:/Users/p/workspace_php/kopas/wapp" ;	// simple 로그기록
//		var $webRoot				= "http://localhost:9880/wapp" ;
//		var $con_domain				= "http://localhost:9880" ;	// 메일에서 사용되는 도메인
//
        //MAC Local path
        var $filePath               = "/usr/local/var/BibleTime/uploadFiles/";
        //Windows Local path
//        var $filePath               = "D:/workspace_integrated/WebstormProjects/BibleTime/uploadFiles/";

        var $fileShowPath           = "/uploadFiles/";

        var $serverRoot				= "http://huneps.com:10040/";

        var $geoipPath              = "/usr/local/var/BibleTime/web/inc/";
				
//		var $fileSaveUrl			= "/upload_img/" ;
//		var $fileSaveUrl_480		= "/480/" ;

 		var $dbHost					= "picklecode.co.kr";
 		var $dbName					= "bibleTime_db" ;
 		var $dbUser					= "root" ;
 		var $dbPass					= "pickle!@#$" ;
 		var $charset				= "utf8" ;

 		var $IMG_DIR                = "http://huneps.com:9000/";
	}
}
?>