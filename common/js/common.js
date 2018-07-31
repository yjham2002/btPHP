function aeClass(name,event,fn)
{
	$("." + name).bind(event, eval(fn)).css({cursor : "pointer"}) ;
	
}

function aeClassNonCursor(name,event,fn)
{
	$("." + name).bind(event, eval(fn)) ;
}

function iNumber()
{		
	var number = $(this).val() ;		
	if(number != "")
	{
		if(!isNumber(number))
		{
			alert('숫자만 기입하여 주십시요.') ;			
			$(this).val('').focus();
			return ;
		}
	}		
}

/*************************************************************************
   함수명 : containsCharsOnly
   기  능 : 특정문자가 존재하는지 체크
   인  수 : input, chars - 객체, 찾고자하는 문자
   리턴값 : 존재하면 true
**************************************************************************/
function containsCharsOnly(input,chars) {
    for (var inx = 0; inx < input.length; inx++) {
       if (chars.indexOf(input.charAt(inx)) == -1)
           return false;
    }
    return true;
}

/*************************************************************************
   함수명 : isNumber
   기  능 : 입력값이 숫자인지를 체크
   인  수 : input - 입력값
   리턴값 :
**************************************************************************/
function isNumber(input) {
    var chars = "0123456789.";
    if(input == "") return false;
    return containsCharsOnly(input,chars);
}

function focusMove()
{

	if($(this).val().length >= $(this).attr("maxlength"))
			 $(this).next().focus() ;		
}

function iCheckChar()
{
	var value = $(this).val() ; 
	if(value != "")
	{
		if(!checkChars(value))
		{
			alert('띄어쓰기 없이 영문,숫자,특수문자(_)만 사용 가능합니다.') ;			
			$(this).val('').focus();
			return ;
		}
	}
}

function checkChars( message )
{

    for ( var i=0; i<message.length; i++ )
    {
        var c = message.charAt(i);
		if(c.search(/[0-9|a-z|A-Z|_]/) == -1) 
			return false ;
        if( escape(c).length == 3 ) // 특수문자일 경우...
        {
            return false;
        }
    }
	
	var str = message;

	for (var i=0; i < str.length; i++) { 
		ch_char = str .charAt(i);
		ch = ch_char.charCodeAt();
		if( (ch >= 33 && ch <= 47) || (ch >= 58 && ch <= 64) || (ch >= 91 && ch <= 96) || (ch >= 123 && ch <= 126) ) {
			return false;
		}
	}

    return true;
}



//아이프레임 자동 리사이징
function reSize() {
    try {
        var objBody = auto_iframe.document.body;
        var objFrame = document.all["auto_iframe"];
        ifrmHeight = objBody.scrollHeight + (objBody.offsetHeight - objBody.clientHeight);
        objFrame.style.height = ifrmHeight;
    }
        catch(e) {}
}


function popup(theURL,winName,width,height) { //v2.0
	Left = (screen.availWidth - width) / 2 ;
	Top  = (screen.availHeight - height) / 2 ;
	window.open(''+theURL+'',winName,'width='+width+',height='+height+',left=' + Left + ',top=' + Top) ;
}

function getCookie( name )
{
	  var nameOfCookie = name + "=";
	  var x = 0;
	  while ( x <= document.cookie.length )
	  {
		var y = (x+nameOfCookie.length);
		if ( document.cookie.substring( x, y ) == nameOfCookie )
		{
		  if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
			endOfCookie = document.cookie.length;
		  return unescape( document.cookie.substring( y, endOfCookie ) );
		}
		x = document.cookie.indexOf( " ", x ) + 1;
		if ( x == 0 )
		break;
	  }
	  return "";
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

//주민등록번호 유효성 검사
function isIdentifyNo(sID){

   if (sID == null || sID == '')
   {
		return false; 
   }
   if (sID.length != 13) 
   {
		return false;
   }

   if (isNaN(sID)) return false;  //sID가 숫자가 아닐겨우 return

    if  (sID.charAt(6) <= "4"){          //내국인     
        cBit = 0;
        sCode="234567892345";
        for(i=0;i<12;i++)   {
            cBit = cBit+parseInt(sID.substring(i,i+1))*parseInt(sCode.substring(i,i+1));
        }    
        cBit=11-(cBit%11);
        cBit=cBit%10;
   
        if(parseInt(sID.substring(12,13))==cBit) 
		  {
				   return true;
		  }
				else
		  {
				  return false;
		  }
    }else{                       //외국인

		return false ; 
         if   ((sID.charAt(6) == "5") || (sID.charAt(6) == "6")) birthYear = "19";
         else if ((sID.charAt(6) == "7") || (sID.charAt(6) == "8")) birthYear = "20";
         else if ((sID.charAt(6) == "9") || (sID.charAt(6) == "0")) birthYear = "18";
         else  return false;

        
         birthYear  += sID.substr(0, 2);
         birthMonth = sID.substr(2, 2) - 1;
         birthDate   = sID.substr(4, 2);
         birth         = new Date(birthYear, birthMonth, birthDate);
        
         if (birth.getYear() % 100 != sID.substr(0, 2) || birth.getMonth() != birthMonth || birth.getDate() != birthDate) {
              return false;
         }
         if (fgn_no_chksum(sID) == false)
             return false;
         else            
             return true;         
    }
 }

function fgn_no_chksum(reg_no) {
     var sum = 0;
     var odd = 0;
     
     buf = new Array(13);
     for (i = 0; i < 13; i++) buf[i] = parseInt(reg_no.charAt(i));
     odd = buf[7]*10 + buf[8];    
     if (odd%2 != 0)       return false;
     
     if ((buf[11] != 6)&&(buf[11] != 7)&&(buf[11] != 8)&&(buf[11] != 9))  return false;
      
     multipliers = [2,3,4,5,6,7,8,9,2,3,4,5];
     for (i = 0, sum = 0; i < 12; i++) sum += (buf[i] *= multipliers[i]);
     sum=11-(sum%11);    
     if (sum>=10) sum-=10;
     sum += 2;
     if (sum>=10) sum-=10;
     if ( sum != buf[12]) return false;
     else  return true;
 }



 function pop(theURL, winName, winWidth, winHeight , isScroll ) {


    var tmp_focus;
    var winSize;

	if ((winWidth=="" || winWidth==null) && (winHeight=="" || winHeight==null)) {
		tmpFocus = window.open(theURL, winName );
 	}
	else {
	
		if (winWidth=="" || winWidth==null)
	      winSize = "height="+winWidth;
		else if (winHeight=="" || winHeight==null)
	      winSize = "height="+winWidth;
		else
	      winSize = "width="+winWidth+",height="+winHeight;
	      
	    if( isScroll == true )
	    	winSize += ",scrollbars=yes" ;
	    else
	    	winSize += ",scrollbars=no" ;

        tmpFocus = window.open(theURL, winName, winSize );
	}

 	tmpFocus.focus() ;

	return tmpFocus ;
}

function checkSpace( str )
{
     if(str.search(/\s/) != -1){
      return 1;
     }

     else {
         return "";
     }
}

function validID( strObj , viewTag)
{
	str = strObj.val() ;

	result = "" ;
	
	/* check whether input value is included space or not  */
	var isOnlyNum = /^[0-9_]{6,16}$/ ;
	if( isOnlyNum.test(str)) {		
		result = "아이디는 영문 숫자 조합으로 사용하실수 있습니다."; 
	}

	/* checkFormat  */
	var isID = /^[a-z0-9_]{6,16}$/;
	if( !isID.test(str) ) {         
		result = "아이디는 6~16자의 영문 소문자와 숫자,특수기호(_)만 사용할 수 있습니다."; 
	}

	var retVal = checkSpace( str ); 

	if( retVal != "" ) {        
		result = "아이디는 빈 공간 없이 연속된 영문 소문자와 숫자만 사용할 수 있습니다."; 
	} 
	if( str.charAt(0) == '_') {	  
		result = "아이디의 첫문자는 '_'로 시작할수 없습니다.";
	}

	if( str == ""){	 
		result = "아이디를 입력하여 주십시오.";
	}

	if(viewTag != undefined)
		viewTag.html(result) ;

	return result;
}

function validPWD( strObj , viewTag )
{
	str = strObj.val() ;

	result = "" ;

	/* limitLength */			
	var isPW = /^[a-z0-9]{8,12}$/;
	if( !isPW.test(str) ) {
		result = "비밀번호는 8~12자의 영문 소문자와 숫자만 사용할 수 있습니다." ; 			
	}
	
	/* check whether input value is included space or not  */
	var retVal = checkSpace( str );
	if( retVal != "") {
		result = "비밀번호는 빈공간 없이 연속된 영문 소문자와 숫자만 사용할 수 있습니다." ;			
	}
	var cnt=0;
	for( var i=0; i < str.length; ++i)
	{
		if( str.charAt(0) == str.substring( i, i+1 ) ) ++cnt;
	}  
	if( cnt == str.length ) {
		result = "보안상의 이유로 한 문자로 연속된 비밀번호는 허용하지 않습니다." ;			
	}
	
	if( str == ""){
		result = "비밀번호를 입력하세요." ;			
	}    
	
	if(viewTag != undefined)
		viewTag.html(result) ;	
	
	return result ;
}

function AssocToStr(tgName)
{
	var retStr = "" ;
	var tg = $(":input[name='" + tgName + "']") ;
	var cnt = tg.length ;

	if( cnt > 1)
	{
		for(var i = 0 ; i < cnt ; i++)
		{
			var arrTg = $(":input[name='" + tgName + "']:eq("+i+")") ;
			
			retStr += arrTg.val() ;			
		}
	}
	else
	{
		retStr = tg.val() ;
	}

	return retStr ;
}

function delImgHandler()
{
	var index = $(".jDelBtn").index($(this)) ;
	
	$(".jDelImg:eq("+index+")").hide() ; 	
	$(":input[name='hidFile[]']:eq("+index+")").val("") ;
}



function imgResize(img_id, wWindow, hWindow)
{
	var img = document.getElementById(img_id) ;

	if(img == undefined || img == null)
	return ; 

	var wImage = img.width;
	var hImage = img.height;
	
	if (wImage > wWindow || hImage > hWindow)
	{
		if (wImage*hWindow > wWindow*hImage)
		{
			wResult = wWindow
			hResult = hImage*wResult/wImage
		}
		else
		{
			hResult = hWindow
			wResult = wImage*hResult/hImage
		}
	}
	else {
		wResult = wImage;
		hResult = hImage;
	}

	img.width = wResult;
	img.height = hResult;
}

/* window 마스킹 처리를 위한 메소드 */
function wrapWindowByMask(){
	//화면의 높이와 너비를 구한다.
	var maskHeight = $(document).height();
	var maskWidth = $(window).width();  

	//마스크의 높이와 너비를 화면 것으로 만들어 전체 화면을 채운다.
	$('#mask').css({'width':maskWidth,'height':maskHeight});  

	//애니메이션 효과 - 일단 1초동안 까맣게 됐다가 80% 불투명도로 간다.
	// $('#mask').fadeIn(1000);
	$('#mask').fadeTo("fast",0.8);    

	//윈도우 같은 거 띄운다.
	$('.window').show();
	$(".loading").show() ;
}

function notice_setCookie( name, value, expiredays )
{
	var todayDate = new Date();
	todayDate.setDate( todayDate.getDate() + expiredays );
	document.cookie = name + "=" + escape( value ) + "; path=/; expires=" + todayDate.toGMTString() + ";"
}

function notice_getCookie( name )
{
	var nameOfCookie = name + "=";
	var x = 0;
	while ( x <= document.cookie.length )
	{
			var y = (x+nameOfCookie.length);
			if ( document.cookie.substring( x, y ) == nameOfCookie ) {
					if ( (endOfCookie=document.cookie.indexOf( ";", y )) == -1 )
							endOfCookie = document.cookie.length;
					return unescape( document.cookie.substring( y, endOfCookie ) );
			}
			x = document.cookie.indexOf( " ", x ) + 1;
			if ( x == 0 )
					break;
	}
	return "";
}

function InitImageUpload(index, controllerName) {
    var width = $('#width' + index).val();
    var height = $('#height' + index).val();
    var url = '/action_front.php?cmd=AdminBase.imageFileUploadForThrift';
    
    new AjaxUpload('#btnImageUpload' + index, {

        action: url, // I disabled uploads in this example for security reaaons
		responseType : "json",
        data: {
            'key1': "This data won't",
            'key2': "be send because",
            'key3': "we will overwrite it"
        },
        onSubmit: function (file, ext) {        	
        },
        onComplete: function (file, responseText) {
        	
            if (responseText == '-1100') {
                ValidationMessageTarget('divImageResult' + index, 'Error: Size is too small.');
                return false;
            }
            
            if (responseText == '-1000') {
                ValidationMessageTarget('divImageResult' + index, 'Error: This is not an English name.');
                return false;
            }
            console.log(responseText);
            previewImageBind(index, responseText[0].filePath);
        }
    });
}


function previewImageDelete(index) {
    $('#divPreviewImage' + index).hide();
    $('#previewImage' + index).attr('src', '');
    $('#images' + index).val('');
    $('#imgPreview' + index).attr('href', '');    
}

function previewImageBind(index, imgURL) {
	
	if(imgURL.lastIndexOf(".") != -1){
		var ext = imgURL.toString().substring(imgURL.lastIndexOf(".") + 1);
	}
	
	if (ext && /^(jpg|png|jpeg|gif)$/.test(ext)) {
		
		$('#previewImage' + index).attr('src', "http://182.161.118.73:8501/uploadImg/origin/" + imgURL);	    
	    
	    $('#images' + index).val(imgURL.replace("/upload_img/origin/",""));
	    
	    $('#imgPreview' + index).attr('href', $('#previewImage' + index).attr('src'));
	    $('#imgPreview' + index).imgPreview({
	        imgCSS: {
	            width: $('#imgPreview' + index).attr('W') + 'px'	         
	        }
	    });
	    $('#divPreviewImage' + index).show();
	    $('#divResultPin').attr('src', imgURL);
    } else {
        previewNoImageBindUpload(index, imgURL);
    }
}



function previewNoImageBindUpload(index, imgURL) 
{

    $('#images' + index).val(imgURL);    
    // $('#divDescription' + index).html(imgURL).show();
}

function replaceAssocUrl(paramName, paramVal, url)
{
	var tmp = url.toString().split("?") ;
		
	var makeUrl = "" ;

	if( tmp[1] != undefined )
	{
		makeUrl = tmp[0] + "?" ;

		s = tmp[1].toString().split('&'); 
		
		idx = 0
		for(i = 0 ; i < s.length ; i++)
		{

			strArr = s[i].split('=') ;
			 
			if(strArr[0] != paramName){
				if (idx != 0)
				{
					makeUrl = (makeUrl + "&") ;
				}
				idx = (idx + 1)
				makeUrl = (makeUrl + s[i]) ;	
			}				
		}
		
		makeUrl = (makeUrl + "&" + paramName + "=" + paramVal) ;	
	}
	else{
		makeUrl = url + "?" + paramName + "=" + paramVal;		
	}

	return makeUrl ;

}


//파일 업로더 setting
function loadFileUploader(fileTagName, uploadUrl, callBackFunc)
{

	$("#jFileForm").remove();
	
	var form = $("<form id='jFileForm' method='post' action='" + uploadUrl + "' enctype='multipart/form-data' />");
	$(form).append("<input type='file' name='" + fileTagName + "' style = 'display:none;'/>");
	$("body").append(form);

	var retSelector = $("#jFileForm :input[name='" + fileTagName + "']"); 
	
	$(retSelector).one("change", function(){
		$('#jFileForm').ajaxSubmit({
			dataType:  'json', 
			//submit이후의 처리
			success: function(jsonData, statusText, xhr){
				console.log(jsonData);
				if(jsonData.returnCode == "1")
					callBackFunc(jsonData.entity);
				else
					alert(jsonData.returnMessage);
				
			},
			//ajax error
			error: function(){
				alert("에러발생!!");
			}                               
		});
	});

	$(retSelector).trigger("click");
	
}

// 업로더에 이벤트 장착
function addEventHandlerForFileUploader(selector, eventType, fileTagName, uploadUrl, callBackFunc)
{
	$(selector).css("cursor", "pointer");
	$(selector).bind(eventType, function(){
		loadFileUploader(fileTagName, uploadUrl, callBackFunc);
	});
}
