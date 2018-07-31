// Text Element Wrapping 한 Class

var RHText = Class.create(RBaseElementObject,{

	initialize :

		function($super,rhForm,key)
		{
			$super(rhForm,key) ;
		},

	
	// 자동완성 설정
	ac :

		function(is,index)
		{
			this.iter(
				function(item,cur)
				{
					if( index == undefined )
						item.autocomplete = is ;
					else if( index == cur )
						item.autocomplete = is ;
				}
			) ;
		}
}) ;

