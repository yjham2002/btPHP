

var RBaseElementObject = Class.create({

	initialize :

		function(rhForm,key)
		{
			this.rhForm			= rhForm ;
			this.orgForm		= this.rhForm.getOrg() ;
			this.orgElements	= WPUtil.safeArray(this.orgForm[key]) ;
			this.evOrgElement	= undefined ;
			this.length			= this.orgElements.length	;

			this.rhForm.oBody.wrapElements(this.orgElements) ;

		},

	//V1.0 iterator 반복처리자
	// iterFn 이 false 를 리턴하면 중단
	iter :

		function(iterFn)
		{
			for(var i = 0 ; i < this.orgElements.length ; i++ )
			{
				rv = iterFn(this.orgElements[i],i) ;

				if(rv != undefined && !rv ) 
					break ;
			}
		},

	// 순수 DOM 객체를 배열 형태로 리턴한다.
	// indes : 첫 번째 인자가 있으면 , index Element 를 리턴
	getOrg : 

		function()
		{
			return this.orgElements ;

		},

	// 순수 DOM 객체를 배열의 첫번째 요소를 리턴한다.
	getaOrg :

		function()
		{
			return this.getOrg()[0] ;

		},

	// 이벤트 발생되었을 당시의 오리지널 엘레먼트(DOM) 객체
	getOrgEv :

		function()
		{
			return this.evOrgElement ;			
		},

	// 속성 값 가져오기
	getA :
		function (name,index)
		{
			var array = [] ;
			var obj = null ;

			this.iter(
				function(item,cur) {

					if( index == undefined ) 
						array.push(item.getA(name)) ;
					else if( index == cur )	{
						obj = item.getA(name) ;
						return false ;
					}
				}
			) ;

			if( index == undefined )
				return array		;
			else
				return obj	;
		},

	// 스타일 값 가져오기
	getS :

		function(name,index)
		{
			var array = [] ;
			var obj = null ;

			this.iter(
				function(item,cur) {

					if( index == undefined ) 
						array.push(item.getS(name)) ;
					else if( index == cur )	{
						obj = item.getS(name) ;
						return false ;
					}
				}
			) ;

			if( index == undefined )
				return array		;
			else
				return obj	;

		},

	// 텍스트 값 가져오기
	getT :

		function(index)
		{
			var array = [] ;
			var obj = null ;

			this.iter(
				function(item,cur) {

					if( index == undefined ) 
						array.push(item.getT()) ;
					else if( index == cur )	{
						obj = item.getT() ;
						return false ;
					}
				}
			) ;

			if( index == undefined )
				return array		;
			else
				return obj	;

		},

	// value 값 가져오기
	getV :

		function(index)
		{
			var array = [] ;
			var obj = null ;

			this.iter(
				function(item,cur) {

					if( index == undefined ) 
						array.push(item.getV()) ;
					else if( index == cur )	{
						obj = item.getV() ;
						return false ;
					}
				}
			) ;

			if( index == undefined )
				return array		;
			else
				return obj	;

		},


	// 속성 값 세팅하기
	setA :

		function(name,value,index)
		{
			this.iter(
				function(item,cur) {
					if( index == undefined )
						item.setA(name,value) ;
					else if( cur == index )
						item.setA(name,value) ;
				}
			) ;
			
		},

	// 스타일 값 세팅하기
	setS :

		function(name,value,index)
		{
			this.iter(
				function(item,cur) {
					if( index == undefined )
						item.setS(name,value) ;
					else if( cur == index )
						item.setS(name,value) ;
				}
			) ;

		},

	// 텍스트 값 세팅
	setT :

		function(value,index)
		{
			var type = ( typeof(value) == "string" ) ? "string" : "array" ;

			this.iter(
				function(item,cur) {

					rvalue = ( type == "string" ) ? value : value[cur] ;

					if( index == undefined )
						item.setT(rvalue) ;
					else if( cur == index )
						item.setT(rvalue) ;
				}
			) ;
		},

	// 텍스트 값 세팅
	// index 기능 지원
	// value : String , Array 
	setV :

		function(value,index)
		{
			var type = ( typeof(value) == "string" ) ? "string" : "array" ;

			this.iter(
				function(item,cur) {

					rvalue = ( type == "string" ) ? value : value[cur] ;

					if( index == undefined )
						item.setV(rvalue) ;
					else if( cur == index )
						item.setV(rvalue) ;
				}
			) ;
		},

	// 체크박스 , 라디오만 가능한 메소드
	// setCheck(index)
	setC :

		function(index)
		{
			this.iter(
				function(item,cur)
				{	
					if( index == cur )
						item.checked = true ;
				}
			) ;
		},


	// 구분자를 기준으로 나눈 배열을 가지고 값을 세팅할 수 있게 한다.
	// 또는 구분자가 없을 경우 eValue 로 전부 세팅한다.
	setVBySpliter :

		function(eValue,spliter)
		{
			var aValue = ( spliter != undefined ) ? eValue.split(spliter) : new Array() ;

			this.iter(
				function(item)
				{
					item.value = ( spliter == undefined ) ? eValue : aValue[i] ;
				}
			) ;

		},

	setOrgEv :

		function(ele)
		{
			this.evOrgElement = ele ;
		},


	// 객체 사용 여부 세팅
	able :

		function(isAble)
		{
			this.iter(
				function(item) {
					item.able(isAble) ;
				}
			) ;
		},

	// 읽기 전용으로 할것인지
	readable :

		function(isAble)
		{
			this.iter(
				function(item) {
					item.readable(isAble) ;
				}
			) ;
		},

	// 객체 숨기기 V0.5
	// true/false 랜더링 여부
	hide :

		function(isRendering)
		{
			this.iter(
				function(item) {
					item.hide(isRendering) ;
				}
			) ;
		},


	// 객체 보이기 V0.5
	// true/false 랜더링 여부
	show :

		function(isRendering)
		{
			this.iter(
				function(item) {
					item.show(isRendering) ;
				}
			) ;
		}

	


}) ;


// overloading getOrg(index) 
/*
Class.overload.apply(RBaseElementObject,[ 'getOrg',[ String ] , 
	function(index)
	{
			return this.getOrg()[index] ;

	} ]
) ;

*/


