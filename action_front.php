<? include $_SERVER["DOCUMENT_ROOT"] . "/common/php/LoginUtil.php" ;  ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminBase.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Admin.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminEtc.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/ApiList.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebBoard.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebMain.php" ; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/php/AnyGo.php" ;?>
<?
	$cmd	= $_REQUEST[cmd] ; 
	
	$nextDisable = false ;		// 디버깅용
	$arr = explode(".", $cmd) ;
	if( sizeof($arr) != 2 )
		echo "[ControlException ] Cmd 형식이 맞지 않습니다." ;
	else
	{
		$clsNm = $arr[0] ;
		$mtdNm = $arr[1] ;
		//var_dump();
		$obj = new ReflectionClass($clsNm)		; 
		$obj= $obj->newInstance($_REQUEST)	;
		$method = new ReflectionMethod($clsNm,$mtdNm) ;
		$flow	= $_REQUEST[flow] ;
		if( $flow == "Ajax" || $flow == "" )			// JSON 이나 AJAX 일경우 	
			echo $method->invoke($obj) ;
		else
		{
			$method->invoke($obj) ;
			if( $nextDisable == false  )
			{
				$rurl	= $_REQUEST[rurl] ;
				$msg	= $_REQUEST[msg] ;
				$flow	= $_REQUEST[flow] ;
				if( $flow == "" )
					echo "[ControlException ] flow 형식이 맞지 않습니다." ;
				else
				{
					go("NORMAL",$flow,$msg,$rurl) ;	
				}
			}
		}
	}
?>