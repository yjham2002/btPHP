// Text Element Wrapping 한 Class

var RHCheckBox = Class.create(RBaseElementObject,{

	initialize :

		function($super,rhForm,key)
		{
			$super(rhForm,key) ;
		},

	// 체크 되었는지 여부 리턴
	// return : Array<boolean>
	getC : 

		function(index)
		{
			var array = [] ;

			this.iter(
				function(item,cur)
				{
					if( index == undefined ) 
						array.push(item.checked) ;
					else if( index == cur )
						array.push(item.checked) ;
				}
			) ;

			return array ;
		},

	// 체크된 값 가져오기	
	// return : Array<string>
	getV :

		function()
		{
			var array = [] ;

			this.iter(
				function(item,cur)
				{
					if( item.checked )
						array.push(item.getV()) ;
				}
			) ;

			return array ;
		},

	// 값 체크하기
	// return : this 
	setV :

		function(value)
		{
			this.iter(
				function(item,cur) {

					if( item.getV() == value )
						item.checked = true ;
				}
			) ;

			return this ;
		},


	// 선택/비선택 하기
	// return : this 
	doCheck :

		function(is)
		{
			this.iter(
				function(item,cur)
				{
					item.checked = is ;
				}
			) ;

			return this ;
		},

	// 타켓 Radio Checked 따라처리하기
	// return : this 
	doCheckChain :

		function(target,isReverse)
		{
			isReverse = ( isReverse == undefined ) ? false : true ;

			var tChecked = this.getaOrg().checked ;

			tChecked = ( isReverse == true ) ? !tChecked : tChecked ;

			target.doCheck(tChecked) ;

			return this ;
		},

	// 체크 된 체크박스 갯수 가져오기
	// return : number 
	getCheckedCount : 

		function()
		{
			var cnt = 0 ;

			this.iter(
				function(item,cur)
				{
					cnt += ( item.checked ) ? 1 : 0 ;
				}
			) ;

			return cnt ;
		},

	// 라디오 버튼 처럼 동작처리 하기
	// return : this 	
	radiolize :

		function()
		{

			this.rhForm.oBody.attachEvent(this.getOrg(),"onclick",this.radiolizeHandler) ;

			return this ;
		},

	// 라디오 버튼 처럼 동작처리를 위한 클릭 핸들러
	radiolizeHandler :

		function(str)
		{
			var eventEle = this.getOrgEv() ;

			this.iter(
				function(item,index)
				{
					item.checked = ( item == eventEle )	;
				}
			) ;
		}



}) ;


