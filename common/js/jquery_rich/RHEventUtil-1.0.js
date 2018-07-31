
RHEventUtil = function(){} ;

// 이벤트 붙이기
RHEventUtil.attachEvent =

	function(oBody,oTarget,eventOfType,handlerOfEvent,fnOfCondition)
	{
		oTarget	=	RHEventUtil.safeArray(oTarget) ;
		
		for(var i = 0 ; i < oTarget.length ; i++ )	{

			oTargetForCondition = RHEventUtil.getEventObj(oBody,oTarget[i]) ;

			if( fnOfCondition == undefined || fnOfCondition.call(oTargetForCondition) == true )
				RHEventUtil.attachEventSingle(oBody,oTarget[i],eventOfType,handlerOfEvent)	;
		}
	}

// obj 를 무조건 array 으로 변환한다. 데이터 타입을 마추기 위해 사용한다.
RHEventUtil.safeArray = 

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

RHEventUtil.wrapEventString =

	function(eventOfType)
	{
		return ( RichFrameworkStatic.isIE == false ) ? eventOfType.substring(2) : eventOfType ;

	}

//V1.0 통일된 이벤트 명 리턴 click 등등
RHEventUtil.uniqueEventString =
	
	function(eventOfType)
	{

		return ( RichFrameworkStatic.isIE == false ) ? eventOfType : eventOfType.substring(2) ;

	}


// 이벤트 붙이기 다중 아이디 객체 고려 안함
RHEventUtil.attachEventSingle =

	function(oBody,oTarget,eventOfType,handlerOfEvent)
	{
		// 이벤트 이름 처리
		eventOfType = RHEventUtil.wrapEventString(eventOfType) ;

		if( oTarget == undefined ) return false ;

		if( eventOfType == "onclick" || eventOfType == "click" )
				 oTarget.style.cursor = "pointer"	; 

		try
		{
			 // IE
			 if( jQuery.browser.msie )
				 oTarget.attachEvent(eventOfType,RHEventUtil.prepareHandler.bind(oBody,eventOfType,handlerOfEvent)) ;	
			else	
				oTarget.addEventListener(eventOfType,RHEventUtil.prepareHandler.bind(oBody,eventOfType,handlerOfEvent),false) ;

		}
		catch (e)
		{	
			WPUtil.log("RHEventUtil.attachEventSingle","",e) ;
		}
	}

// V1.0 간단 이벤트 발생시의 객체 리턴하기
// 이벤트 걸린 태그가 INPUT 태그이면 RichBaseElement 를 리턴한다.
RHEventUtil.getEventObj =

	function(oBody,ele)
	{
		var rv = null ;

		if( ele != null )	{

			Object.extend(ele,RichElement) ; 

			if( ele.isInput() ) 
			{	
				var rf = oBody.getForm(ele.getFormNm()) ;
				rv = rf.getE(ele.getNm()) ;
				rv.setOrgEv(ele) ;
			}
			else
				rv = ele ;
		}

		return rv ;
	}

	

// V1.0 이벤트 걸기 전에 항상 실행되는 핸들러
RHEventUtil.prepareHandler =

	function(eventOfType,fn)
	{
		eventOfType = RHEventUtil.uniqueEventString(eventOfType) ;

		this.prepareGlobalHandler() ; 

		eventOfType = eventOfType.substring(0,1).toUpperCase() + eventOfType.substring(1) ;
				
		obj = RHEventUtil.getEventObj(this,event.srcElement) ;
		
		// 각각에 맞는 이벤트 전처리기 실행
		var isContinue = eval("this.prepare" + eventOfType + "Handler").apply(obj,arguments) ;

		isContinue = ( isContinue == undefined ) ? true : isContinue ;
		
		// 실제 이벤트 핸들러 실행
		if( isContinue )
			fn.apply(obj,arguments) ;

	}
