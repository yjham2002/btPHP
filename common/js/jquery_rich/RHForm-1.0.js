
var RHForm = Class.create({

	// 객체 초기화 V0.7
	initialize :

		function(oBody,orgForm,submitOfType)
		{
			this.oBody = oBody	;
			
			this.orgForm = orgForm ;

			this.el		= orgForm.elements			// type=image 가 제외된 elements
			
			if( this.orgForm.method == "" )
				this.orgForm.method = "POST" ;
				
			this.preAction = this.orgForm.action  ;
			this.preTarget = this.orgForm.target ;
			this.preMethod = this.orgForm.method ;

			this.submitOfType = ( submitOfType == undefined ) ? "NORMAL" : submitOfType ; // AJAX
			this.submitOfSuper = null ;

			this.isSubmited = false ;		// 중복 Submit 방지

			return this ;
		},


	setAction :

		function(url)
		{
			this.preAction = this.orgForm.action ; 
			this.orgForm.action = url ;

			return this ;
		},
		
	setMethod :

		function(str)
		{
			this.preMethod = this.orgForm.method ; 
			this.orgForm.method = str ;

			return this ;
		},
		
	setTarget :

		function(target)
		{
			this.preTarget = this.orgForm.target ; 
			this.orgForm.target = target ;

			return this ;
		},


	setSubmitType :

		function(key)
		{
			this.submitOfSuper = key ;

			return this ;
		},

	getSubmitType : 

		function()
		{
			return this.submitOfSuper ;

			return this ;
		},

	// 오리지날 폼 리턴
	getOrg : 

		function()
		{
			return this.orgForm ;

		},

			

	// Document Object 무조건 Array 로 가져오기 V0.7
	getOrgE : 

		function(key)
		{
			var orgElements = WPUtil.safeArray(this.orgForm[key]) ;

			return this.oBody.wrapElements(orgElements) ;
		},

	// Document Object 무조건 Array 로 가져오기 V0.7
	getaOrgE : 

		function(key)
		{
			return this.getOrgE(key)[0] ;
		},

	// 폼 엘레먼트 리턴
	getE :

		function(key)
		{

			var type	= this.getaOrgE(key).getType() ;
			var obj		= null ;

			switch(type)
			{
				case "text" :
					obj = new RHText(this,key) ;
					break ;
				case "password" :
					obj = new RHText(this,key) ;
					break ;
				case "textarea" :
					obj = new RHText(this,key) ;
					break ;
				case "hidden" :
					obj = new RHText(this,key) ;
					break ;
				case "button" :
					obj = new RHText(this,key) ;
					break ;
				case "radio" :
					obj = new RHRadio(this,key) ;
					break ;
				case "checkbox" :
					obj = new RHCheckBox(this,key) ;
					break ;
				case "select-one" :
					obj = new RHSelect(this,key) ;
					break ;
				default :
					obj = this.getOrgE(key) ;

			}

			return obj ;

		},

	// 폼값을 가져온다.
	getV : 

		function(key)
		{
			return this.getE(key).getV() ;
		},

	// 폼 텍스트를 가져온다.
	getT : 

		function(key)
		{
			return this.getE(key).getT() ;
		},

	// 폼과 연관배열을 가지고 값을 세팅
	setVAssoc : 

		function(assoc)
		{
			for (var key in assoc) 
				if(assoc.hasOwnProperty(key))
					this.setV(key,assoc[key]) ;

			return this ;
		},

	// 값을 세팅한다.
	setV : 

		function(key,value,index)
		{
	
			this.getE(key).setV(value,index) ;

			return this ;

		},

	// 배열인 객체에 값을 인덱스로 세팅한다.(For Text 만 지원) 
	setVBySpliter : 

		function(key,value,spliter)
		{
			this.getE(key).setVBySpliter(value,spliter) ;

			return this ;
		}, 


	// 일반 SUBMIT 사용( POPUP 으로 SUBMIT )
	submit : 

		function()
		{
			if( this.validate() == true )	{

				if( this.isSubmited == false )	{

					// rurl 을 전송
					if( this.oBody.autoCreateRurl  )	{

					}

					this.isSubmited = true ;
					this.orgForm.submit() ;
					this.setTarget(this.preTarget) ;
					return true ;
				}
				else	{
					window.status = "확인버튼은 한번한 누르셔야 합니다." ;
				}

			}
			else
				return false ;


		},


	// POPUP 으로 SUBMIT 
	popSubmit :

		function()
		{
			if( this.validate() == true )	{

					this.orgForm.submit() ;
					this.setTarget(this.preTarget) ;
					return true ;

			}
			else
				return false ;


		}, 

		// override 해서 발리데이트 할 수 있다.
		chk : 
			function() { return true ; },

		// 폼 데이터 검증처리함 - 오버라이드 처리할 수 있습니다.
		validate : 

			function(except)	{

			var f = this.orgForm	;
			var min = 0			;
			var necessary = "" ;
			var isExcept = false ;
			
			var chk_img = "";
			
			
			except = ( except == undefined ) ? new Array() : except ;

			for(var i = 0 ; i < f.elements.length ; i++ )	{

				for(var j = 0 ; j < except.length ; j++ )	{
					if( f.elements[i].name == except[j] )	{
						isExcept = true ;
						break ;
					}
				}
				if( isExcept == true )	{	
					isExcept = false ;
					continue ;
				}
				
				necessary = f.elements[i].getAttribute("VTYPE")	;
				min = f.elements[i].getAttribute("MIN_LENGTH")	;
				chk_img = f.elements[i].getAttribute("CHK_IMG")	;

				if( necessary != null )	{

					if( f.elements[i].type == "radio" )	{

						if( WPUtil.nullRadio(f[f.elements[i].name]) == false )	{
							try
							{
								f.elements[i].focus()	;
							}
							catch(e){ continue ; }
							alert(f.elements[i].title + "은(는) 필수 입력 사항입니다.") ;
							return false ;
						}
					}
					else if ( f.elements[i].type == "checkbox") {
							var sChkIndex = i ;
							var bOk = false ;
							while( f.elements[i].type == "checkbox" )	{
								if( f.elements[i].checked == true )	
									bOk = true ;
								i++ ;
							}

							if( bOk == false )	{
								alert(f.elements[sChkIndex].title + "은(는) 필수 입력 사항입니다.") ;
								return false ;
							}
				
					}
					else	
					{

						if( f.elements[i].value == "" )	{
							if( f.elements[i].disabled )
							{}
							else if( f.elements[i].type == "select-one" )
								f.elements[i].focus() ;
							else if(f.elements[i].readOnly == false )
								f.elements[i].focus() ;
						
							
							alert(f.elements[i].title + "은(는) 필수 입력 사항입니다.") ;
								
							return false ;
						}
					}
				}

				if( min != null ) {
					if( f.elements[i].value.length < min )	{
						alert(f.elements[i].title + "는 최소 " + min + "자 이상 입니다. 다시 입력하여 주십시오.") ;
						if( f.elements[i].readOnly == false )
							f.elements[i].focus() ;
						return false ;
					}
				}
				
				if(chk_img != null) {		
				
					var obj = f.elements[i]; 
				
					if(obj.value == '')
						return true;
			
					if(obj.value != '' && !obj.value.toLowerCase().match(/(.jpg|.jpeg|.gif|.png|.bmp)/)) { 
						alert('이미지 파일만 업로드 할 수 있습니다.');			
						obj.focus();
						//document.selection.clear();
						//document.execCommand('Delete');
						return false ;	
					}		
					
				}



			}
			
			// 오버라이드 된 chk() 함수 호출
			if( this.chk() == false )
				return false ; 

			return true ;
		},

	// 폼 Submit 후 다음 행동을 어떻게 할것인 지를 action.xxx 의 형식(규격) 맞춰 폼 엘레먼트 생성 V0.7
	//  nextType 
	//		- ToOpener
	//		- ToSelf
	//		- ToPrepageByRef
	//		- ToOpenerAndClose
	//		- OpenerRefreshAndClose
	//		- Close
	//		- ToPrepage
	nextActionCreate : 

		function(actionSC,nextType,nextUrl,nextMsg)
		{
				this.setMethod("POST")			;
				this.setAction(actionSC)		;
				this.create("rType",nextType)	;
				this.create("rUrl",nextUrl)		;
				this.create("rMsg",nextMsg)		;
		},

	// rurl 을 생성 V0.7
	rurlCreate : 

		function(url)
		{
			this.ecreate("rurl",url) ;
		},


	// 데이터를 인코딩해서 생성
	ecreate : 

		function(name,value,type)
		{
			this.create(name,WPUtil.bin2hex(value),type) ;
		},


	// 2008.06.21  연관배열을 히든으로 전부 변환
	createAssoc :

		function(assoc)
		{
			for(key in assoc)
				if(assoc.hasOwnProperty(key)){
					this.create(key,assoc[key]) ;
				}
		},

	/* 해당 FORM 에 INPUT 태그 삽입&수정 */
	create : 

		function(name,value,type)
		{
				var obj ;
				var preObj ;
		
				preObj = document.getElementsByName(name)[0] ;
				
				if( preObj == undefined )	{
		
		
					var input = document.createElement("INPUT");
		
					input.type		= "hidden"	;
					input.name		= name		;
					input.id		= name		;
					input.value		= value		;
		
					type = ( type == undefined ) ? "afterBegin" : type ;

					obj = this.orgForm.appendChild(input);

				}
				else
				{
		
					preObj.value = value ;
					obj = preObj ;
				}
			
				return obj ;
		
		}

}) ;



Object.extend(RHForm.prototype,{

	nac : RHForm.prototype.nextActionCreate  

}) ;


// CMD 값을 가지고 서브미트
Class.overload.apply(RHForm,[ 'submit',[ String ] , 
	function(cmd)
	{
			this.create("cmd",cmd) ;

			this.submit() ;
	} ]
) ;

// 리턴 정보를 가지고 서브미트
Class.overload.apply(RHForm,[ 'submit',[ String , String , String , String ] , 
	function(cmd,nextType,nextUrl,nextMsg)
	{
			this.create("cmd",cmd) ;
			this.create("rType",nextType)	;
			this.ecreate("rUrl",nextUrl)	;
			this.create("rMsg",nextMsg)		;

			this.submit() ;
	} ]
) ;



