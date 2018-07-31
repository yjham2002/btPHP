WPUtil = function(){}	;

WPUtil.log = 

	function(nm,str,org)
	{
		var tmp = "[" + nm + "] " + str  + " :: Error = " + org ;

		alert(tmp) ;
	}

// obj 를 무조건 array 으로 변환한다. 데이터 타입을 마추기 위해 사용한다.
WPUtil.safeArray = 

	function(obj)	{

		
		obj = ( obj == undefined ) ? new Array() : obj ;
		
	
		// select 객체는 자체 length 메쏘드를 가지고 있다.
		if( obj.tagName != undefined && obj.tagName.toLowerCase() == "select" )
		{	
			obj = new Array(obj)
		} 
		else
			obj = ( obj.length == undefined ) ? new Array(obj) : obj ;

		return obj ;
	}

// 인자로 String 으로 들어온 것 역시 배열로 리턴한다. V0.7
WPUtil.toArray = 

	function(obj)
	{
		var array = new Array() ;

		if( typeof(obj) == "string" )
			array.push(obj) ;
		else
			array = obj ;

		return array ;
	}



/* my Own Object Closure 
/* 객체 메쏘드를 이벤트 핸들러로 사용하면 Switching Context 가 발생하기 때문에 사용한다. */

WPUtil.safeContext = 

	function(obj,method)
	{	
		return function() { 
			eval("obj." + method + "()") ; } 
	} 


WPUtil.safeContext2 = 

	function(obj,methodStr)
	{
		return function() { 
		
			eval("obj." + methodStr) ; } 
	}
	
	

// 메세지 alert 처리
WPUtil.alert = 

	function(msg,param)
	{
		var prefix = "WP Exception : " ;

		alert(prefix + msg) ;
	}


// 숫자에 컴마 제거하기	
WPUtil.removeComma =
	
	function(str)
	{
		while(str.indexOf(",") > -1) { 
  			str = str.replace(",", ""); 
 		}
 		
 		return str ;
 	} 

// 숫자에 컴마 넣기			
WPUtil.addComma =

	function(str)
	{
		var iNum = WPUtil.removeComma(str.toString()); 
		var aNum = iNum.split("."); 
		 
		var num = ""; 
		for(var i=0;i<aNum[0].length;i++) { 
		 if(i > 1 && ((i+1) % 3) == 1) { 
		 num = "," + num; 
		 } 
		 num = aNum[0].substr(aNum[0].length-i-1, 1) + num; 
		} 
		 
		if(aNum.length > 1) { 
		 	return num + "." + aNum[1]; 
		} else { 
			 return num; 
		}
	} 
	
// text 필드에 자동으로 ',' 처리하기

WPUtil.autoCommaHandler =

	function() 
	{
          var num = event.srcElement.value;

          if (event.srcElement.value.length >= 4) {

			re = /^$|,/g; 

				// "$" and "," 입력 제거 

				num = num.replace(re, ""); 

		var fl="" ;

		if(num==0) return num 
		 
		if(num<0){ 
			num=num*(-1) ;
			fl="-" ;
		}
		else
			num=num*1 //처음 입력값이 0부터 시작할때 이것을 제거한다. 
	
		num = new String(num) 
		temp="" 
		co=3 
		num_len=num.length 

		while (num_len>0){ 
			num_len=num_len-co 
			if(num_len<0){co=num_len+co;num_len=0} 
			temp=","+num.substr(num_len,co)+temp 
		} 
		
		event.srcElement.value =  fl+temp.substr(1);
	 }

}
        

WPUtil.pop =

	function(doURI,cmd,param,width,height,isScroll)	{

		if( isScroll == true )	{
			 mypop = window.open(
				goPageURL,
				goPageName,
				'width='+goPageWidth+',height='+goPageHeight+',menubar=no, scrollbars=yes, resizable=yes'
			); 

			mypop.focus() ;
		}
		else	{

			mypop = window.open(goPageURL,goPageName,'width='+goPageWidth+',height='+goPageHeight+',menubar=no, scrollbars=no, resizable=no'); 
			mypop.focus() ;

			return mypop ;		

		}

	}

WPUtil.modalPop = 
	
	function(url, name,width,height){	// 모달 창 

	var myObject = new Object();
	myObject.win = window;
   
    var sFeatures="dialogHeight: " +  height + "px;dialogWidth: " + width + "px;status:0;dialogHide:1;help: No;scroll:No;resizable:No";
    window.showModalDialog(url, myObject, sFeatures)

}

WPUtil.IsWinXPSP2 =

function()
{

	try
	{
		var info = window.clientInformation;
		var reg1 = /[^A-Z0-9]MSIE[ ]+6.0[^A-Z0-9]/i;
		var reg2 = /[^A-Z0-9]WINDOWS[ ]+NT[ ]+5.1[^A-Z0-9]/i;

		if ((info.appMinorVersion.replace(/\s/g,"").toUpperCase().indexOf(";SP2;") >= 0) &&
			(reg1.test(info.userAgent) == true) && (reg2.test(info.userAgent) == true))
		{
			return true;
		}
	}
	catch(e)
	{
		return false;
	}
	
	return false;
}

// static
WPUtil.nullRadio = 

function(target)	{
	
	target = WPUtil.safeArray(target) ;

	var checkTrue = false ;

	for(var i = 0 ; i < target.length ; i++ )	{
			if( target[i].checked == true )
				return true ;			
	}

	return false ;

} 

WPUtil.bin2hex =

function(s)  
{  
         var i = 0, f = s.length, a = [];  
         for(;i<f;i++) a[i] = s.charCodeAt(i).toString(16);  
         return a.join('');  
} 

WPUtil.getCookie = 

function(s)
{
	var nameOfCookie = name + "=";
	var x = 0;
	while ( x <= document.cookie.length )
	{
		var y = (x+nameOfCookie.length);
	
		if ( document.cookie.substring( x, y ) == nameOfCookie ) {
			if ( (endOfCookie = document.cookie.indexOf( ";", y )) == -1 ) {
				endOfCookie = document.cookie.length;
			}
			return unescape( document.cookie.substring( y, endOfCookie ) );
		}

		x = document.cookie.indexOf( " ", x ) + 1;

		if ( x == 0 )	break;
	}

	return "";

}

WPUtil.setCookie = 

function(name,value)
{
   var argv = arguments;
   var argc = arguments.length;

   var expires	= (2 < argc) ? argv[2] : null;
   var path		= (3 < argc) ? argv[3] : null;
   var domain	= (4 < argc) ? argv[4] : null;
   var secure	= (5 < argc) ? argv[5] : false;

   document.cookie = name + "=" + escape(value) +
	  ((expires == null)	? "" :	("; expires=" + expires.toGMTString())) +
	  ((path == null)		? "" :	("; path=" + path)) +
	  ((domain == null)		? "" :	("; domain=" + domain)) +
	  ((secure == true)		? "; secure" : "") ;
  
}



