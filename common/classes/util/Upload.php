<?php

if(! class_exists("Upload") )	{

class Upload {
	var $File;
	var $Files;
	var $Root;
	var $File_Extension;
	var $File_Unique_Name;
	var $Extension;
	var $Extension_Type;
	var $Limit_File_Size;

	function Upload($File,$Root,$Extension=array(),$Extension_Type=1,$Limit_File_Size=99999999999999999){

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
	# 기본 : 1메가 (1048576)
	*/

		$this->File = array();
		$this->File = $File;


		$this->Files = array();

		//Dev server
    	if ( $_SERVER["SERVER_ADDR"] == "211.52.72.59" ) {
			$Root = str_replace("/home/", "E:/work/", $Root);
    	}
		$this->Root = $Root;


		if(!count($Extension) && !is_array($Extension)){

			$Extension = array("php","cgi","php3","php","asp","html");

		}else{

			$this->Extension = array();
			$this->Extension = $Extension;

		}

		$this->Extension_Type = $Extension_Type;
		$this->Limit_File_Size = $Limit_File_Size;

		// 업로드할 디렉터리를 체크 해본다.
		if(!$this->File_Check_Upload_Root()){

			echo "에러 : 업로드 루트 디렉터리가 존재 하지 않소이다. ({$this->Root})";
			exit;

		}
	}


	function GetDate(){

		return date("Ymd") ;

	}


	function File_Check_Upload_Root(){

		if(!file_exists($this->Root)){

			return false;

		}

		if(!file_exists($this->Root."/".date("Ymd"))){

			if(@mkdir($this->Root."/".date("Ymd"),0755)){
				$this->Root = $this->Root."/".date("Ymd");

			}

		}else{

			$this->Root = $this->Root."/".date("Ymd");

		}

		return true;

	}


	// 파일명중 확장자를 분리해준다.
	function File_Explode_Extension($File_Name){

		$Tmp = explode(".",$File_Name);
		$this->File_Extension = $Tmp[count($Tmp)-1];
	}


	function File_Check_Extension($File_Name){

		if(!count($this->File_Extension)){

			$this->File_Explode_Extension($File_Name);
		}

		$Temp = strtolower($this->File_Extension); // 확장자를 소문자로 변환해준다.

		for($i=0;$i <= count($this->Extension);$i++){

			if(!strcmp($this->Extension[$i],$Temp)){
				return true;
				break;
			}
		}

		return false;
	}


	function File_Check_Size($File_Size){

		if($this->Limit_File_Size < $File_Size){

			return false;
			exit;
		}

		return true;
	}


	function File_Make_Unique_Name(){

		srand((double)microtime()*1000000) ;
		$Rnd = rand(1000000,2000000) ;
		$Temp = date("Ymdhis") ;
		$this->File_Unique_Name = $Temp.$Rnd.".".$this->File_Extension ;

	}


	function File_Check_Overlap(){

		if(!$this->File_Unique_Name){

			$this->File_Make_Unique_Name();
		}

		if(file_exists($this->Root."/".$this->File_Unique_Name)){

			return false;
			exit;
		}

		return true;

	}


	function File_Check_Error($Error){


		// 추후 에러에 대한 메시지를 반환

		return 1;

	}

	function File_RollBack($i){

		if($i > 1){

			for($i=$i-1;$i>=0;$i--){

				unlink($this->Root."/".$this->Files[$i]["re_name"]);

			}
		}
	}


	function processing(){

		// 폼의 파일박스의 갯수
		$IDX = count($this->File["name"]);

		for($i=0;$i<$IDX;$i++){

			// 우선 파일사이즈가 0인건 업로드 하지 않음
			if($this->File["size"][$i] >= 0 && $this->File["name"][$i]){

				// HTTP POST를 통하여 업로드 된 파일인지 체크
				if(!is_uploaded_file($this->File["tmp_name"][$i])){

					echo "<script> alert('다시 시도해 주시기 바랍니다.') ; history.go(-1);</script>" ;

					$this->File_RollBack($i);

					exit;

				}


				// 파일 확장자 체크
				$Temps = $this->File_Check_Extension($this->File["name"][$i]);

				if((!$Temps && !$this->Extension_Type)||($Temps && $this->Extension_Type)){

					echo "1 : 확장자 거부";

					$this->File_RollBack($i);

					exit;

				}


				// 파일 사이즈 체크
				if(!$this->File_Check_Size($this->File["size"][$i])){

					echo "2 : 용량 너무큽니다.";

					$this->File_RollBack($i);

					exit;

				}

				// 에러 체크
				if(!$this->File_Check_Error($this->File["error"][$i])){

					echo "3 : 에러";

					$this->File_RollBack($i);

					exit;

				}

				// 파일 중복 체크
				if(!$this->File_Check_Overlap()){

					echo "4 : 중복됨";

					$this->File_Make_Unique_Name();

				}


				if(!@move_uploaded_file($this->File["tmp_name"][$i],$this->Root."/".$this->File_Unique_Name)){

					echo "5 : 업로드 도중 에러가 발생함";

					$this->File_RollBack($i);

					exit;

				}


				chmod($this->Root."/".$this->File_Unique_Name,"0777");



				$this->Files[$i] = array(

				"re_name"=>$this->File_Unique_Name,

				"name"=>$this->File["name"][$i],

				"tmp_name"=>$this->File["tmp_name"][$i],

				"error"=>$this->File["error"][$i],

				"type"=>$this->File["type"][$i],

				"size"=>$this->File["size"][$i],

				);

				unset($this->File_Unique_Name); // 유니크 네임 리셋

				unset($this->File_Extension); // 확장자 리셋

			}

		}

		return $this->Files; // 모든 파일을 업로드 한후 파일 정보를 넘겨준당.

	}

} // Class End

}
?>