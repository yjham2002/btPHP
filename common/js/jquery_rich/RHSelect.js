
var RHSelect = Class.create(RBaseElementObject,{

	initialize :

		function($super,rhForm,key) 
		{
			$super(rhForm,key) ;
		},


	/** OPTION 값 세팅	**/
	/** assoc : 값/텍스트 Hash  , index : 적용할 index **/
	/** index 가 없으면 전체 적용 **/
	setOption :

		function(assoc,index)
		{
			this.iter(
				function(item,cur)
				{
					var aOption = null ;
					

					for(var key in assoc) 
						if(assoc.hasOwnProperty(key))	
							this.makeOption(item,assoc[key],key) ;	

					return ( index != cur ) 
				}
			) ;

			return this ;
		},


	/** 옵션 만들기 **/
	/** index : 엘레먼트 index , name : option text , value : option value **/
	makeOption :

		function(index,name,value)
		{
			var ele = this.getOrg()[index] ;
		
			var aOption = document.createElement("OPTION");
			aOption.text	= name	;
			aOption.value	= value	;

			ele.add(aOption) ;

		},
	

	/** return : OPTION 객체를 리턴한다. **/
	getOption :

		function(index)
		{
			var ele = this.getOrg()[index] ;

			return ele.options(ele.selectedIndex) ;
		}


}) ;
