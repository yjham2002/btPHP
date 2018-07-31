
var RichElement = { 

	// 폼 데이터 필드 인지/아닌지
	isInput :
		function()
		{
			return ( this.tagName != undefined && this.tagName.toLowerCase() == "input" ) ;
		},

	// 폼 이름 가져오기 
	getFormNm :
		function()
		{
			return this.form.name ;
		},
	
	// 엘레먼트 이름 가져오기
	getNm :
		function()
		{
			return this.name ;
		},

	// 엘레먼트의 타입을 가져온다.
	getType : 
		function()
		{
			return  this.type ;
		},
	
	// 속성 값 가져오기
	getA :
		function (name)
		{
			return this.getAttribute(name) ;
		},

	// 스타일 값 가져오기
	getS :

		function(name)
		{
			return this.style[name] ;
		},

	// 텍스트 값 가져오기
	getT :

		function()
		{
			var type = this.getType() ;

			if( type == "select-one" )
				return this.options(this.selectedIndex) ;
			else if( this.innerHTML ) 
				return this.innerHTML ;
			else 
				return this.value ;
		},

	// value 값 가져오기
	getV :

		function()
		{
			return this.value ;

		},


	// 속성 값 세팅하기
	setA :

		function(name,value)
		{	
			this.setAttribute(name,value) ;
		},

	// 스타일 값 세팅하기
	setS :

		function(name,value)
		{
			this.style[name] = value ;
		},

	// 텍스트 값 세팅
	setT :

		function(value)
		{	if( this.innerHTML ) 
				this.innerHTML = value ;	
			else
				this.value = value ;
		},

	// 텍스트 값 세팅
	setV :

		function(value)
		{	
			this.value = value ;
		},


	// 객체 사용 여부 세팅
	able :

		function(isAble)
		{
			this.disabled = isAble ;
		},

	// 읽기 전용으로 할것인지
	readable :

		function(isAble)
		{
			this.readOnly = isAble ;
		},

	// 객체 숨기기 V0.5
	// true/false 랜더링 여부
	hide :

		function(isRendering)
		{
			if( isRendering == true )
				this.setS('visibility','hidden')	;
			else
				this.setS('display','none')			;
		},


	// 객체 보이기 V0.5
	// true/false 랜더링 여부
	show :

		function(isRendering)
		{
			if( isRendering == true )
				this.setStyle('visibility','visible')	;
			else
				this.setStyle('display','inline')		;
		}

} ;


// Class Aliasing 
Object.extend(RichElement,{

	get : RichElement.getA,
	set : RichElement.setA

}) ;


