<?php

if(! class_exists("UploadUtil") )	{

class UploadUtil
{
	var $acceptExtension;
	var $LimitFileSize;



	function UploadUtil($LimitFileSize = 31457280, $Extension = NULL, $acceptExtension = FALSE)
	{
		/*
		$File
		# 파일로 넘어온 데이터
		$Root
		# 파일이 저장될 디렉터리
		$Extension
		# 업로드시 허용 또는 허용하지 않는 확장자명
		# 변수 타입 Array();
		$Extension_Type
		# 0 $Extension 으로 넘어오는 확장자 배열을 포함하면 업로드 허용
		# 1 $Extension 으로 넘어오는 확장자 배열을 포함하면 업로드 불가
		$Limit_File_Size
		# 업로드 할수 있는 파일용량 제한
		# 기본 : 2메가 (1048576)
		*/

		if(!isset($Extension))
		{
			$Extension = array("xls", "xlsx", "jpg", "png");
		}else
		{
			$this->Extension = $Extension;

			//대문자로 들어오더라도 소문자로 변환
			for($i=0; $i<sizeof($this->Extension); $i++)
			{
				$this->Extension[$i] = strtolower($this->Extension[$i]);
			}

		}

		$this->acceptExtension = $acceptExtension;
		$this->LimitFileSize = $LimitFileSize;

	}



	//업로드 기본 패스 확인
	function Make_SavePath($savePath, $makeDayFolderFlag)
	{
		if($makeDayFolderFlag)
			$savePath = $savePath . "/" . date("Ymd");

		if(!file_exists($savePath))
		{
			if(!@mkdir($savePath, 0755, TRUE))
				$savePath = FALSE;
		}

		return $savePath;
	}


	// 파일명중 확장자를 분리해준다.
	function File_Explode_Extension($File_Name){

		$Tmp = explode(".", $File_Name) ;

		if(count($Tmp) == 1)
		{
			return "";
		}
		else
		{
			return strtolower($Tmp[count($Tmp)-1]);
		}

	}


	//확장자 체크
	function File_Check_Extension($File_Name){

		$extension = $this->File_Explode_Extension($File_Name);

		if($extension == "")
		{
			return false;
		}

		for($i=0;$i <= count($this->Extension);$i++){

			//허용확장자에 포함되는 경우 - 확장자가 동일해야함
			if($this->acceptExtension && strcmp($this->Extension[$i],$extension) === 0){
				return true;
				break;
			}
			else if(!$this->acceptExtension && strcmp($this->Extension[$i],$extension) !== 0)
			{
				return true;
				break;
			}
		}

		return false;
	}


	//파일 크기 체크
	function File_Check_Size($File_Size){

		if($this->LimitFileSize < $File_Size){
			return false;
		}

		return true;
	}


	//유니크 이름 생성
	function File_Make_Unique_Name($FileName){

		$extension = $this->File_Explode_Extension($FileName);

		srand((double)microtime()*1000000) ;
		$Rnd = rand(1000000,2000000) ;
		$Temp = date("Ymdhis") ;
		return $Temp.$Rnd.".".$extension ;

	}


	function File_Check_Overlap($SavePath, $fileName){

		if(file_exists($SavePath."/".$fileName)){
			return false;
		}
		return true;
	}


	function removeFile($SavePath, $fileName)
	{
		@unlink($SavePath."/".$fileName);
	}



	//결과정보 전송
	function makeResult($returnCode, $returnMsg, $fileInfo = NULL)
	{
		$retVal = Array(
			"returnCode"	=> $returnCode,
			"returnMessage"	=> $returnMsg,
			"fileInfo"		=> $fileInfo
		);

		return $retVal;
	}


	function uploadOneFile($File, $BasePath, $SubPath, $makeDayFolderFlag = FALSE, $overlapFlag = FALSE, $MakeNewNameFlag = FALSE){

		$newFileName = $File["name"];

		if($SubPath != "")
		    $SavePath = $BasePath . "/" . $SubPath;
		else
		    $SavePath = $BasePath;

		//새로운 파일 이름 생성
		if($MakeNewNameFlag)
			$newFileName = $this->File_Make_Unique_Name($newFileName);

		// HTTP POST를 통하여 업로드 된 파일인지 체크
		if(!is_uploaded_file($File["tmp_name"])){
			return $this->makeResult("-1", "비정상 접근");
		}

		// 우선 파일사이즈가 0인건 업로드 하지 않음
		if($File["size"] == 0 || !isset($File["size"])){
			return $this->makeResult("-2", "비정상 파일입니다.(사이즈 0)");
		}


		// 파일 확장자 체크
		if(!$this->File_Check_Extension($File["name"])){
			return $this->makeResult("-3", "허용되지 않은 확장자");
		}


		// 파일 사이즈 체크
		if(!$this->File_Check_Size($File["size"])){
			return $this->makeResult("-4", "업로드 용량을 초과하였습니다.");
		}

		// 에러 체크
		if($File["error"] === "0"){
			return $this->makeResult("-5", "파일이 비정상적으로 업로드 되었습니다 - {$File["error"]}");
		}

		// 파일 중복 체크
		if($overlapFlag && !$this->File_Check_Overlap($SavePath, $newFileName)){
			$this->removeFile($SavePath, $newFileName);
		}
		else if(!$overlapFlag && !$this->File_Check_Overlap($SavePath, $newFileName))
		{
			return $this->makeResult("-6", "이미 파일이 존재합니다.");
		}


		$SavePath	= $this->Make_SavePath($SavePath, $makeDayFolderFlag);
		$SubPath	= str_replace($BasePath . "/", "", $SavePath);

		if($SavePath === FALSE)
		{
			return $this->makeResult("-7", "업로드 경로 확인");
		}


		//실제 업로드
		if(!@move_uploaded_file($File["tmp_name"], $SavePath."/".$newFileName)){
			return $this->makeResult("-8", "업로드 도중 에러가 발생함");
		}

		chmod($SavePath."/".$newFileName, 0755);

		$fileInfo = array(
			"re_name"	=> $newFileName,
			"name"		=> $File["name"],
			"tmp_name"	=> $File["tmp_name"],
			"error"		=> $File["error"],
			"type"		=> $File["type"],
			"size"		=> $File["size"],
			"extension"	=> $this->File_Explode_Extension($newFileName),
			"savePath"	=> $SavePath,
			"saveURL"	=> $SubPath . "/" . $newFileName
		);

		return $this->makeResult("1", "", $fileInfo); // 모든 파일을 업로드 한후 파일 정보를 넘겨준당.

	}





}

}
