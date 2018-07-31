<?php

function go($method,$subtype,$msg,$url)
{

	$GF_TYPE 	= $method ;
	$type		= $subtype ;
	$msg	 	= $msg ;
	$url		= $url ;

	$url =  pack("H*",$url);

 // echo $GF_TYPE . " : " .$type. " : " .$msg. " : ". $url ; 
	

if( $type == "ToPrepageByRef" )
	$ref = $_SERVER['HTTP_REFERER'] ;

if( $GF_TYPE == "AJAX" ) { ?>
	
function errorMSG(ERROR_ALERT_MSG)	{
	if( ERROR_ALERT_MSG != "null" && ERROR_ALERT_MSG != "" ) 
		alert(ERROR_ALERT_MSG)	;			// 에러 메세지 출력
}
function flowControl()
{
	var url		= '<?= $url ?>'	;
	var type	= '<?= $type ?>'	;
	var msg		= '<?= $msg ?>'	;
	var ref		= '<?= $ref ?>'	;

	errorMSG(msg) ;
	
	<?= $jsStatement ?> ;
	
	if( type == "ToSelf" )
		retrieveGRID()	;
	else if( type == "ToNext" )
		location.href = url ;
	else if( type == "Close" )
		self.close() ;
		
	

}
flowControl() ;
<? } else { ?>
<HTML>
<HEAD>
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; charset=utf-8" />
<TITLE> ANYGO </TITLE>
<script>

function errorMSG(ERROR_ALERT_MSG)	{
	if( ERROR_ALERT_MSG != "null" && ERROR_ALERT_MSG != "" ) 
		alert(ERROR_ALERT_MSG)	;			// 에러 메세지 출력
}


var url		= '<?= $url ?>'	;
var type	= '<?= $type ?>'	;
var msg		= '<?= $msg ?>'	;
var ref		= '<?= $ref ?>'	;



errorMSG(msg) ;
	// ToO , ToS , ToPbyRef , ToOandClose , ReOandClose , ReOandToS , 
	// Close , ToP , RePa , None , Ajax 
if( type == "ToO" )	
	opener.location.href = url ;
else if( type == "ToS" )	
	self.location.href = url ;
else if( type == "ToPbyRef" )
	self.location.href = ref ;
else if( type == "ToOandClose") {
	opener.location.href = url ;
	self.close() ;
}
else if( type == "ReOandClose") {
	opener.location.href = opener.document.URL ;
	self.close() ;
}
else if( type == "ReOandToS") {
	opener.location.href = opener.document.URL ;
	self.location.href = url ;
}
else if( type == "Close")	{
	self.close() ;
}
else if( type == "ToP")	{
	history.go(-1) ;

}
else if( type == "RePa")	{
	
	parent.location.href = parent.document.URL ;

}
else if( type == "None")	{
	
}
else
	{
		alert('[Control Exception] 정의되어 있는 않은 flow type 입니다.') ;
	}
</script>
</HEAD>
</HTML>
<? }  }?>