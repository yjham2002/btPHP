function aeClass(name,event,fn)
{
	$("." + name).bind(event, eval(fn)).css({cursor : "pointer"}) ;
}

function aeId(name,event,fn)
{
	$("#" + name).bind(event, eval(fn)).css({cursor : "pointer"}) ;
}

function aeClassNc(name,event,fn)
{
	$("." + name).bind(event, eval(fn)) ;
}

function aeIdNc(name,event,fn)
{
	$("#" + name).bind(event, eval(fn)) ;
}

function toggleHTML()
{
	var dp = $(".sHtml").css("display") ;

	if( dp == "none" )
		$(".sHtml").show() ;
	else
		$(".sHtml").hide() ;
}

function go(url)
{
	location.href = url + makeQueryString(sParam) ;
}

function goPage(url)
{
	var arrEptKey = new Array("rurl") ;
	location.href = url + makeQueryStringEptKey(sParam,arrEptKey) ;
}

function goRurl()
{
	if( sParam == undefined )
		go(LIST_SC) ;
	else
		location.href = decodeURIComponent(sParam["rurl"]) ;
}

function jsonAjax(type,url,params,fn,evtFn)
{
	$.ajax({type:"POST",
			data:params,
			dataType:"json",
			url:url,
			success:function(data,status){

				if( data == null )
				{
					alert("결과 데이터가 없거나 프로세스에 문제가 있습니다.") ;
					return ;
				}

				var listData = data[0] ;	//리스트 데이터셋
				var retData = data[1] ;		//아웃풋 데이터셋
				

				fn(listData,retData,status) ;

				if( evtFn != null )
					evtFn() ;

			},
			error:function(request,status){
				alert("AJAX 사용 문법을 점검하시기 바랍니다.\n\n" +  request.responseText);
			}
		}) ;
}

function makeQueryString(param)
{
	jQuery.extend(param) ;
	
	var queryString = "?" ;
	var isFirst = true ;

	for( var key in param )
	{
		if( !isFirst )
			queryString += "&" ;

		queryString += key + "=" + encodeURIComponent(param[key]) ;
		isFirst = false ;
	}
	return queryString ;
}

//제외할 key를 제어하여 쿼리스트링 만듦
function makeQueryStringEptKey(param,arrEptKey)
{
	jQuery.extend(param) ;
	
	var queryString = "?" ;
	var isFirst = true ;

	for( var key in param )
	{
		if( jQuery.inArray(key,arrEptKey) < 0 )
		{
			if( !isFirst )
				queryString += "&" ;

			queryString += key + "=" + encodeURIComponent(param[key]) ;
			isFirst = false ;
		}
	}

	return queryString ;
}

//값 세팅
function setValue(infoData,clsName)
{
	var arrInfoForm = jQuery.makeArray($("."+clsName)) ;
	var objInfoForm ;
	var isFilter ;

	$.each(arrInfoForm,function(){

		objInfoForm = $(this).attr("fid") ;
		isFilter = ( $(this).attr("filter") != undefined ) ;

		if( isFilter )
		{
			eval($(this).attr("filter"))() ;
		}
		
		$("#"+objInfoForm).val(( infoData == null ) ? "" : infoData[objInfoForm]) ;

	}) ;
}

function debug(param)
{
	document.write("http://www.nowniz.com/action.php" + makeQueryString(param) );
}


function setVisibility(arrVis)
{
	$.each(jQuery.makeArray($(".action")),function(){

		if( jQuery.inArray($(this).attr("id"),arrVis) >= 0 )
		{
			$(this).show() ;
		}
	}) ;

}

function progress(isExec)
{
	if( isExec )
		$("#progress").show() ;
	else
		$("#progress").hide() ;
}

function popup(popId,css,isCenter,isModal)
{
	if( isModal )
	{
		$("body").append( $("<div id=\"bgdiv\"/>").css({"background":"#333333","position":"absolute","top":0,"left":0,"z-index":10,"opacity":"0.7"}).hide().width("100%").height("100%") ) ;		
		$("#bgdiv").show();
	}

	$("#" + popId).css(css) ;

	if( isCenter )
	{
		var windowWidth		= document.documentElement.clientWidth;
		var windowHeight	= document.documentElement.clientHeight;
		var popupHeight		= $("#" + popId).height();
		var popupWidth		= $("#" + popId).width();

		$("#" + popId).css({"top":windowHeight/2-popupHeight/2,"left":windowWidth/2-popupWidth/2}) ;
	}

	return $("#" + popId) ;
}