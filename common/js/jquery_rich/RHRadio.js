
var RHRadio = Class.create(RBaseElementObject,{

	initialize :

		function($super,rhForm,key) 
		{
			$super(rhForm,key) ;
		},


	getV :

		function()
		{

			var value = null ;

			this.iter(
				function(item,cur)
				{
					if( item.checked )
						value = item.getV() ;
				}
			) ;

			return ( value == null ) ? "" : value ;
		},

		
	setV : 

		function(value)
		{
			this.iter(
				function(item,cur)
				{
					if( item.getV() == value )
						item.checked = true ;
				}
			) ;


			return this ;
		
		}


}) ;
