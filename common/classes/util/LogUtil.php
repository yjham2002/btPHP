<?php
if(! class_exists("LogUtil") )	{

	class LogUtil
	{

		private static function writeLog($logPath, $logData)
		{
			$logTime	= date("Y-m-d H:i:s", time());
			
			$fp = fopen($logPath,"a+");
			 
			//파일에 쓰는부분 . 
			fwrite($fp,"log Date : ".$logTime. " // " . $logData . "\n");
			fwrite($fp,"============================================================================\n");

			//파일 쓰기 끝 닫기
			fclose($fp);
		}


		private static function makeLogFolder($fileDirectory)
		{
			if(!is_dir ($fileDirectory)){
				mkdir($fileDirectory, 0755, true);
			}
		}


        public static function writeFileLog($basePath, $logData, $foldor = "simpleLog")
        {
            $today	= date("Ymd", time());
            $month	= date('Ym', time());


            $folderPath = $basePath . "/" . $foldor . "/" . $month ;

            $fileName = $today.".txt";
            $logPath = $folderPath."/".$fileName;

            //폴더 생성
            self::makeLogFolder($folderPath);
            self::writeLog($logPath, $logData);
        }
		

	}	
}
?>