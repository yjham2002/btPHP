//////////////////////////////////////////////////////////////////////////
// 제목				: Rich Framework For Javascript	jquery plugin		//
// 제작자			: (주)리치웨어 시스템즈 김태영(www.richware.co.kr)	//
// 문의				: 문의전화 02-6409-6842								//
// 이메일			: nukiboy@naver.com									//
// 최종 수정일		: 2009.12.08(화)									//
// 라이센스			: 상용 :: 제작자의 동의없이 사용 절대 불가			//
// 버전				: ver 1.1											//
// 프로그램등록번호	: 1003-3445345										//
// ** 불법적인 사용시 법적인 조치를 취할 수 있습니다. **				//
// 업데이트 내용	:													//
//	- firefox 에서 동작													//
//	- 핸들러에 인자 사용 가능											//
//	- 이벤트 핸들러 후위자 설정 기능									//
//	- 이벤트 전처리 가능												//
//	- 이벤트 this 사용 통일(V1.0)										//
//  - 이벤트 걸기를 선택적으로 할 수 있게 하는 function 제공(V1.0)		//
//  - 클래스 스타일 변경												//
//  - Element 배열 또는 객체에 interator 지원							//
//////////////////////////////////////////////////////////////////////////

/* 리치프레임워크 정적인 값 정의 */ 
var RichFrameworkStatic = {

	Version	: '1.1',

	SPECIFY		: 1,			// init 호출 시에 실행
	END			: 2,			// 초기화 함수 실행 시기 끝

	// 에러 코드
	DEPRECATED	: 0,
	WARNNING	: 1,
	ERROR		: 2,
	
	empty : function() { },
	
	evHandlerPostfix : "Handler",
	target		: "self" ,

	init		:

		function()
		{
			// IE 와 FIREFOX 이벤트 객체 동기화
			if( jQuery.browser.Gecko )
			{
				var events = [ "load" , "submit","change","mousedown", "mouseover", "mouseout", "mousemove","mousedrag", "click", "dblclick","keypress"] ;     
			
				for (var i = 0; i < events.length; i++)
				{    
					window.addEventListener(events[i], 
							function(e)
							{     
								window.event = e;    
								window.event.srcElement = e.target ;
		
							}, true) ;   
			
				}  
			}
		}

} ;

// 기본 RichFrameworkStatic 초기화
RichFrameworkStatic.init() ;

var RichFrameworkJS = Class.create({

	initialize : 

		// nPointOfInit  : 페이지 초기화 함수 포인터
		function(submitOfType)
		{
			this.eDoc				= new Array() 				;	// html 도큐먼트 전체 객체 컬렉션
			this.eForms				= null						;	// html 도큐먼트의 폼객체 컬렉션
			this.domain				= document.domain			;	// 현재 도큐먼트의 도메인
			this.aCacheForm			= new Array()				;	// 캐시를 위한 폼 객체 배열
			this.nPointOfInt		= RichFrameworkStatic.END	;	// 초기화 함수 실행 시기 : [END] , [BEGIN]
			this.submitOfType		= submitOfType				;	// 폼 submit 타입 [NORMAL] , [AJAX]
			this.target				= RichFrameworkStatic.target ;			;
			this.evHandlerPostfix	= RichFrameworkStatic.evHandlerPostfix 	;	// 이벤트명 후위표기자

			// V0.6 
			this.url	= null									;	// 현재 유알엘
			this.sc		= null									;	// 현재 스크립트 명
			this.qs		= null 									;	// 쿼리 스트링
			this.cookie	= document.cookie						;	// 현재 쿠키
			// V0.7
			this.aInitFN	= new Array()						;	// V0.7 페이지에서 실행될 callback 함수 리스트 
			this.autoCreateRurl	= true							;	// 자동으로 폼 Submit 될때 현재 페이지의 encoded return url 생성할건지
		
			// 페이지 초기 후 이벤트 세팅
			RHEventUtil.attachEventSingle(this,window,"onload",this.init.bind(this)) ;
		},

	init :

		function()
		{
			this.eDoc		= document.all			;	// html 도큐먼트 전체 객체 컬렉션
			this.eForms		= document.forms		;	// html 도큐먼트의 폼객체 컬렉션
			this.eFrames	= document.frames		;
			
			this.submitNativeHandlerDisable() ;		// submit Native Handler 불능화

			this.initURL()		;		// URL Properties 초기화


			this.invokeFn()		;		// 사용자 정의 초기화 함수 호출

		},

	//0.7 URL 관련 된 Property 초기화 :: url , sc , qs , rurl 초기화
	initURL  :

		function()
		{
			// 현재 URL 정보 파싱
			this.url	= document.URL ;
			var arr = this.url.split("?") ;

			this.sc		= arr[0] ;
			this.qs		= ( arr.length > 1 ) ? arr[1] : "" ;

			// 리턴 유알엘 만들기
			this.rurl	= this.url ;

		},

	//V0.7 추가한 init 함수 호출
	invokeFn :

		function()
		{
			// 추가한 함수 호출
			for(var i = 0 ; i < this.aInitFN.length ; i++ )
			{
				this.aInitFN[i].call(this) ;
			}
		},

	//V1.1 핸들러 POSTFIX 를 설정한다.
	setPostfix :

		function(str)
		{
			this.evHandlerPostfix = str ;
		},
	

	//V0.7 init 함수 추가 :: init() 함수가 호출되기 전에 사용해야 함
	addInit :

		function(pFn)
		{
			this.aInitFN.push(pFn) ;
		},

	//V0.7 init 함수 삭제 :: init() 함수가 호출되기 전에 사용해야 함
	popInit :

		function(pFn)
		{
			return this.aInitFN.pop() ;
		},

	//V0.5 private 폼 submit disbale 시키기 
	submitNativeHandlerDisable :

	function()
	{
		for(var i = 0 ; i < this.eForms.length ; i++ )
			this.eForms[i].onsubmit = function(){ return false; } ;
	},

	/* overridable methods */

	// V0.8 이벤트 전처리 핸들러
	prepareGlobalHandler	: RichFrameworkStatic.empty,
	prepareLoadHandler		: RichFrameworkStatic.empty,
	prepareClickHandler		: RichFrameworkStatic.empty,
	prepareChangeHandler	: RichFrameworkStatic.empty,
	prepareSubmitHandler	: RichFrameworkStatic.empty,
	prepareMousedownHandler : RichFrameworkStatic.empty,
	prepareMouseoverHandler : RichFrameworkStatic.empty,
	prepareMouseoutHandler	: RichFrameworkStatic.empty,
	prepareMousemoveHandler : RichFrameworkStatic.empty,
	prepareMousedragHandler : RichFrameworkStatic.empty,
	prepareKeypressHandler	: RichFrameworkStatic.empty,

	// ############################################# Reference & value 가져오기 ################################################ //


	//V1.0 Native Element Object 에 RichElement 를 추가한다.
	// safe mode 
	wrapElement :
	
		function(ele)
		{
			if( ele != undefined )
				Object.extend(ele,RichElement) ;

			return ele ;
		},

	// safe mode 
	wrapElements : /** [Array<RichElement>] **/
	
		function(ele)
		{
			for(var i = 0 ; i < ele.length ; i++ )
			{
				if( ele[i] != undefined )
					Object.extend(ele[i],RichElement) ;
			}

			return ele ;
		},


	// 무조건 배열로 리턴 V0.5
	// tag 에서 무조건 name 값으로 세팅하여야 한다.

	 get : /** [Array<RichElement>] **/

		function(name)
		{
			var obj = null ;

			// tag 에 필히 name 속성으로 세팅한다.
			obj = window.document.getElementsByName(name) ;

			this.wrapElements(obj) ;

			return obj ;
		},

	// 첫번째 요소 리턴 V0.5
	// 배열을 단일 변수로 리턴

	geta : 	/** [ RichElement ] **/

		function(name)
		{
			return this.get(name)[0] ;
		},


	// TEXT/HTML 요소 배열로 리턴 V0.7
	getT :	/** Array<String> **/

		function(name)
		{
			var obj = null ;
			var aData = new Array() ;

			obj = this.get(name) ;

			for(var i = 0 ; i < obj.length ; i++ )
				aData.push(obj[i].innerHTML) ;

			return aData ;
		},


	// 첫번째 TEXT/HTML 요소 리턴 V0.7
	getaT :	/** String **/

		function(name)
		{
			return this.getT(name)[0] ;
		},

	// 이름으로 폼  리턴
	getForm : 	/** [ RHForm ] **/

		function(sName)
		{
			if( this.aCacheForm[sName] == undefined )	{
				if( this.eForms[sName] == undefined )	{
					this.alert('현재 도규먼트에  "' + sName + '" 폼을 정의 하셔야 합니다. <form name="' + sName + '">....</form> 의영아! 정신차려~ 혹시 세진이?') ;
				}
				else	{
					var wf = new RHForm(this,document.forms[sName]) ;
					this.aCacheForm[sName] = wf ;

				}
			}
			
			return this.aCacheForm[sName] ;
		},
	
	getFrame :	/** DOM **/

		function(sName)
		{
			return this.eFrames[sName] ;
		},


	// 인코딩 된 유알엘 가져오기  V0.7
	getEurl : /** String **/

		function(url)
		{
			return WPUtil.bin2hex(url) ;
		},

	// 쿠키가져오기 V0.6
	getCookie :	/** String **/

		function(name)
		{
			return WPUtil.getCookie(name) ;
		},

// ############################################### Setter Methods ######################################################### //

// 쿠키 세팅하기 V0.6
	setCookie :
		
		function(name, value) {

			WPUtil.setCookie(name,value) ;
		},


	// V0.7 텍스트 세팅 ( value : string , array ) 
	setT :

		function(name,value)
		{
			var array = WPUtil.toArray(value) ;

			var aDO = this.get(name) ;

			for(var i = 0 ; i < aDO.length ; i++ ) 
			{
				if( array[i] != undefined )
					aDO[i].innerHTML = array[i] ;
			}
		},


	// 상태 처리
	status : 

		function(msg)
		{
			window.status = msg ;
		},

	// Alert 처리
	alert : 

		function(msg)
		{
			alert(msg) ;

		},


// ################## 이벤트 관련 메소드 ############################################ ////

	// Object 로 이벤트 붙이기
	attachEvent : 

		function(oTarget,typeOfEvent,handlerOfEvent,fnOfCondition)
		{

			RHEventUtil.attachEvent(this,oTarget,typeOfEvent,handlerOfEvent,fnOfCondition) ;
		},



	// Object name 으로 이벤트 붙이기
	// V1.0 조건 함수에 따른 이벤트 여부 처리
	attachEventByName : 

		function(objName,typeOfEvent,handlerOfEvent,fnOfCondition)
		{

			oTarget = this.get(objName) ;

			try
			{
				handlerOfEvent = ( handlerOfEvent == undefined ) ? eval(objName + this.evHandlerPostfix) : handlerOfEvent ;				
			}
			catch (e)
			{
				this.alert(e) ;
			}
			


			RHEventUtil.attachEvent(this,oTarget,typeOfEvent,handlerOfEvent,fnOfCondition) ;
		},

	// 이벤트 이름을 배열로 받아서 처리 ver 0.32
	attachEventByArray :

		function(array,typeOfEvent,handlerOfEvent,fnOfCondition)
		{
			try
			{
				for(var i = 0 ; i < array.length ; i++ )
				{
					objName = array[i] ;
					oTarget = this.get(objName) ;

					handlerOfEvent = ( handlerOfEvent == undefined ) ? eval(objName + this.evHandlerPostfix) : handlerOfEvent ;	
					RHEventUtil.attachEvent(this,oTarget,typeOfEvent,handlerOfEvent,fnOfCondition) ;

				}				
			
			}
			catch (e)
			{
				this.alert(e) ;
			}

		},

	// 클릭 이벤트 붙이기 V0.6
	anc : 

		function(objName,handlerOfEvent,fnOfCondition)
		{

			if( typeof(objName) == "string")
				this.an(objName,"onclick",handlerOfEvent,fnOfCondition) ;
			else	{
				this.attachEventByArray(objName,"onclick",handlerOfEvent,fnOfCondition) ;
			}

		},

	// change 이벤트 붙이기 V0.6
	anch : 

		function(objName,handlerOfEvent,fnCondition)
		{
			if( typeof(objName) == "string")
				this.an(objName,"onchange",handlerOfEvent,fnOfCondition) ;
			else
				this.attachEventByArray(objName,"onchange",handlerOfEvent,fnOfCondition) ;
		},

//##################################### 내장 Attach 시리즈(이벤트 + 핸들러 기능을 함) #########################################

	// 링크 액션을 처리한다.
	attachLink : 

		function(objName,typeOfEvent,url,msg,type,target)
		{
			this.an(objName,typeOfEvent,this.linkHandler.bind(url,msg,type,target)) ;
				
		},

	// Alert 액션을 처리한다.
	attachAlert : 

		function(objName,typeOfEvent,msg)
		{
			this.an(objName,typeOfEvent,this.alertHandler.bind(msg)) ;			
		},

	// 자동으로 콤마처리한다.
	attachAutoComma : 

		function(objName)
		{
			var typeOfEvent = "onkeyup" ;

			this.an(objName,typeOfEvent,WPHandler.autoComma.bind()) ;			
		},	

	// 엔터 처리 하기 V0.6
	attachEnter :

		function(objName,fn)
		{	
			var typeOfEvent = "onkeypress" ;

			this.an(objName,typeOfEvent,this.enterHandler.bind(fn)) ;			

		},


	// 검색 클릭 처리 + 엔터 처리 V0.6
	attachSearch :

		function(textObjNm,clickObjNm,fn)
		{	
			this.attachEnter(textObjNm,fn)	;
			this.anc(clickObjNm,fn)			;
		},

	// Attribute 로 부터 데이터를 가져와서 ReQuery 처리해서 그 주소로 간다. V0.6
	attachGo :

		function(objName,typeOfEvent,attNm,paramNm,assoc)
		{
			if( typeof(attNm) == "string" )
				this.an(objName,typeOfEvent,this.oneReQueryHandler.bindChange(this,attNm,paramNm,assoc)) ;
			else
				this.an(objName,typeOfEvent,this.manyReQueryHandler.bindChange(this,attNm,paramNm,assoc)) ;

		},

	// Attribute 로 부터 ReQuery 후 팝업까지 처리 V0.7
	attachPop : 

		function(objName,typeOfEvent,attNm,paramNm,assoc,popNm,popWidth,popHeight,popScroll)
		{
				this.an(objName,typeOfEvent,
					this.selfPopHandler.bindChange(
						this,attNm,paramNm,assoc,popNm,popWidh,popHeight,popScroll)) ;

		},

//################################################## 기본 제공 핸들러 ########################################################

	// 도규먼트의 타켓 세팅
	setTarget :

		function(str)
		{
			this.target = str ;
		
		},


	// 링크 핸들러 ==> 여러가지 기능을 함
	linkHandler : 

		
		function(url,msg,type,target)
		{
			if( target == "undefined" ) 
				target = "self" ;
			
			if( type == "confirm" )
				if( confirm(msg) )
					eval(target).location.href = url ;
			else if( type == "alert" )	{
				this.alert(msg) ;
				eval(target).location.href = url ;
			}
			else	{			
				eval(target).location.href = url ;
			}
			
		},
		
	// 알림 핸들러
	alertHandler : 

		function(msg)
		{	
			alert(msg) ;
		},

	// 엔터 찾기 핸들러
	enterHandler :

		function(fn)
		{
			if( event.keyCode == 13 )
				fn() ;
		},

	// 한개의 파라미터 ReQuery 핸들러 V0.6
	oneReQueryHandler :

		function(attNm,paramNm,restAssoc)
		{
			this.go(this.reQueryForOneAttr(attNm,paramNm,restAssoc)) ;
		},

	// 여러개의 파라미터 ReQuery 핸들러 V0.6
	manyReQueryHandler :

		function(aAttNm,aParamNm,restAssoc)
		{
			this.go(this.reQueryForManyAttr(attNm,paramNm,restAssoc)) ;
		},


	// 여러개의 파라미터 ReQuery 핸들러 + 팝업 V0.6
	selfPopHandler :

		function(attNm,paramNm,restAssoc,popNm,popWidth,popHeight,popScroll)
		{
			var url ; 

			if( typeof(attNm) == "string" )
				url = this.reQueryForOneAttr(attNm,paramNm,restAssoc) ;
			else
				url = this.reQueryForManyAttr(attNm,paramNm,restAssoc) ;

			this.pop(url,popNm,popWidth,popHeight,popScroll) ;

		},

	// ReQuery 후 popup 처리
	pop : 

		function(theURL, winName, winWidth, winHeight , isScroll ) {
			//alert("aa") ;
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
					winSize += ",scrollbars=1" ;
				else
					winSize += ",scrollbars=no" ;
				
				tmpFocus = window.open(theURL, winName, winSize );
			}

			this.movePop(tmpFocus,winWidth) ;
			tmpFocus.focus() ;

			return tmpFocus ;
		},

	// 팝업 가운데로 옮기기
	movePop :

		function(target,winWidth) {

		  var winWidth = (screen.width - winWidth) / 2;
		  var winHeight = (screen.height - 500) / 2;
		  
		  target.moveTo(winWidth, winHeight);

		},


	moveFreePop :

		function(target,left,top) {

		  
		  target.moveTo(left, top);

		},

	// 가기
	go : 

		function(url)
		{
			location.href = url ;
		
		},

	// Cmd 로 가기
	goCmd :

		function(sc,cmd,qs)
		{		
			location.href = this.getCmdUrl(sc,cmd,qs) ;
		},

	getCmdUrl : 

		function(sc,cmd,qs)
		{
			gurl = sc + "?cmd=" + cmd ;

			if( qs != undefined ) 
				gurl += "&" + qs ;

			return gurl ;

		},

	// 도메인 가져오기
	getDomain : 

		function()
		{
			return this.domain ;
		},

	// ########################################## ReQuery 관련 유틸 메쏘드 ################################################# //

	// V0.6 에서 bug fix
	http_build_query :

		function(array) 
		{ 
				var i = 0 ;
				var str = "" ; 
		 
				for(var key in array) {

					if(array.hasOwnProperty(key))	{

						if(! (array[key] == "undefined" || array[key] == "" || array[key] == undefined) )
						{ 
							str += key + "=" + array[key] ;
							str += "&" ;
						}
						i++ ;
					}
				}

				return "?" + str.substr(0,str.length - 1) ; 
		}, 


	// 쿼리 스르링을 파싱해서 o(Array) 에 넣는다.
	parse_str : 

		function(s, o) 
		{ 
			 var i, f, p, m, r = /\[(.*?)\]/g; 
			 s = s.toString().replace(/\+/g,' ').split('&'); 
	  
			 function c(o, k, v, p) 
			 { 
					 var n, m = r.exec(p); 
	  
					 if(m != null) 
					 { 
							 n = m[1]; 
							 if(typeof(o[k]) == 'undefined'){ o[k] = []; }; 
							 c(o[k], n || o[k].length.toString(), v, p); 
							 return; 
					}; 
	  
					 o[k] = v;
					  
			 }; 
	  
			 for(i=0,f=s.length;i<f;i++) 
			 { 
					 p = s[i].split('='), m = p[0].indexOf('['); 
					 c(o || this, (0 <= m) ? p[0].slice(0, m) : p[0], p[1], p[0]); 
			 }; 
			 
		},
		

	// 쿼리 스트링 값  변경
	reQuery : 

		function(qs,key,value)
		{ 	
			var array = new Array() ;
			this.parse_str(qs,array)	;	
			array[key] = value ;

			return this.http_build_query(array) ;
		},

	// request		:	파라미터 , assoc : 변경할 셋
	// Process Date :	2008.07.02
	reQueryForPost : 

		function(request,assoc)
		{
			var queryString = "?" ;
			var isSame = false ;

			for( reqKey in request)	
			{
				if(request.hasOwnProperty(reqKey)){

					for( chKey in assoc )
					{
						if(assoc.hasOwnProperty(chKey)){
							if( chKey == reqKey )	{
								queryString += reqKey + "=" +  assoc[reqKey] ;
								isSame = true ;
								break ;
							}
						}
					}
		
					if( isSame == false )	
						queryString += reqKey + "=" +  request[reqKey] ;
		
					isSame = false ;
					
					queryString += "&" ;
					
				}

			}

			return queryString ;

		},


		
	// 쿼리 스트링 값  변경
	reQueryByArray : 

		function(qs,set)
		{ 	
			var array = new Array() ;
			this.parse_str(qs,array)	;
			
			for( key in set)
				if(set.hasOwnProperty(key)){				
					array[key] = set[key] ;			
				}
			
			return this.http_build_query(array) ;
		},


	// 하나의 어트리뷰트와 연관 처리 V0.6
	reQueryForOneAttr :

		function(attNm,paramNm,restAssoc)
		{
			var attVn = event.srcElement.getAttribute(attNm) ;

			var assoc = new Array() ;

			if( restAssoc != undefined )
			{
				for(key in restAssoc )
					if(restAssoc.hasOwnProperty(key))
						assoc[key] = restAssoc[key] ;
			}

			assoc[paramNm] = attVn ;

			return this.reQueryByArray(this.qs,assoc) ;
		},

	// 여러개의 어트리뷰트와 연관 처리 V0.6
	reQueryForManyAttr :

		function(aAttNm,aParamNm,restAssoc)
		{
			var attVn = "" ;

			var assoc = new Array() ;

			if( restAssoc != undefined )
			{
				for(key in restAssoc )
					if(restAssoc.hasOwnProperty(key))
						assoc[key] = restAssoc[key] ;
			}

			for(var i = 0 ; i < aParamNm.length ; i++ )
			{
				attVn = event.srcElement.getAttribute(aAttNm[i]) ;
				assoc[aParamNm[i]] = attVn ;
			}

			if( restAssoc != undefined )
				assoc.concat(restAssoc) ;

			return this.reQueryByArray(this.qs,assoc) ;
		},


	// #################################################################################################################### //



	// 텍스트 필드 선택 핸들러
	selectHandler :

		function ()
		{
			event.srcElement.select() ;
		},
	 

	// 엔터 입력 시 submit 핸들러
	enterHandler :

		function (obj)
		{
	//		alert(obj) ;
			/*
			var keyCode = event.keyCode ;

			if( keyCode == "13" )
				obj.fireEvent("onclick") ;
				*/
		},



	// UTF8로 인코딩 변경
enEncodeUTF8 :

function(s)
{

	var sbuf = '';
	var len;
	var i;
	var ch;

	if(s == null) return "" ;
	s = s + "" ;
	len = s.length;

	for (i = 0; i < len; i++)	{
		ch = s.charCodeAt(i);
		if	( (65 <= ch && ch <= 90) || // 'A'..'Z'
			(97 <= ch && ch <= 122) || // 'a'..'z'
			(46 <= ch && ch <= 57) ) { // '.', '/', '0'..'9'
			
			sbuf += s.charAt(i);
		} 
		else if (ch == 32) { // space
			sbuf += '+';
		} else if (ch <= 0x007f) { // other ASCII
			sbuf += this.enEncodeChar(ch);
		} else if (ch <= 0x07FF) { // non-ASCII <= 0x7FF
			sbuf += this.enEncodeChar(0xc0 | (ch >> 6));
			sbuf += this.enEncodeChar(0x80 | (ch & 0x3F));
		} else { // 0x7FF < ch <= 0xFFFF
			sbuf += this.enEncodeChar(0xe0 | (ch >> 12));
			sbuf += this.enEncodeChar(0x80 | ((ch >> 6) & 0x3F));
			sbuf += this.enEncodeChar(0x80 | (ch & 0x3F));
		}
	}
	
	return sbuf;
},

enEncodeChar :

function(ch)
{
	var enHexChars = "0123456789ABCDEF" ;

	return '%' + enHexChars.charAt(ch >> 4) + enHexChars.charAt(ch & 0x0F);
}




}) ;


Object.extend(RichFrameworkJS.prototype,{
		// 단축 함수들
		an				: RichFrameworkJS.prototype.attachEventByName,
		atLink			: RichFrameworkJS.prototype.attachLink,
		atAlert			: RichFrameworkJS.prototype.attachAlert,
		atAutoComma		: RichFrameworkJS.prototype.attachAutoComma,
		atEnter			: RichFrameworkJS.prototype.attachEnter,
		atSearch		: RichFrameworkJS.prototype.attachSearch,
		atGo			: RichFrameworkJS.prototype.attachGo,
		attachPop		: RichFrameworkJS.prototype.atPop,

		///////////////////////// Deprecated Methods 0.5 //////////////////////////////////////////////////////////////////////

		// deprecated from 1.5
		// Dep랩핑 된 객체를 반환
		// get() 와 동일
		getObject :

			function(name)
			{
				return this.get(name) ;
			},
			
		// deprecated from 0.5
		// 객체를 배열로 가져온다.
		// get() 과 동일
		getByArray :

			function(name)
			{
				return this.get(name) ;
			},

		// deprecated from 0.5
		// get() 과 동일
		getArray :

			function(name)
			{
				return this.getByArray(name) ;

			},

		// deprecated from 0.5
		// IE == FireFox 이벤트 객체 호환처리
		wrapEvent :
			
			function(event) {

			  if (! window.event ) { //IE이면.. 웹표준을 더 참조해야함

					event.srcElement = event.target ;
			  }
			
			  return event;
			}

		///////////////////////// Deprecated Methods 0.32 //////////////////////////////////////////////////////////////////////


		// 첫번째 폼 객체를 리턴한다. 
		/* Deprecated  by 0.32
		getFirstForm :

			function()
			{
				return new WPForm(this.eForms[0],this.submitOfType) ;
			},

		*/

		// 마지막 폼 객체를 리턴한다.
		/* Deprecated  by 0.32
		getLastForm : 

			function()
			{
				var lindex = this.eForms.length -1 ;
				return this.getForm(this.eForms[lindex].name) ;
			}
		*/


}) ;


