jQuery.fn.extend({

	readImage :
	function(onReadHandler) {
		
		var files = this.get(0).files ;

		function readAndPreview(file) {

			if ( /\.(jpe?g|png|gif)$/i.test(file.name) ) {

				var reader = new FileReader();
				
				reader.addEventListener("load", function () {
					
					if( onReadHandler != undefined && typeof onReadHandler == "function" ) {
						
						onReadHandler(file, this.result) ;
						
					}
					
				}, false) ;

				reader.readAsDataURL(file);
				
			}
		}

		if (files) {
			[].forEach.call(files, readAndPreview);
		}
		
	}

}) ;