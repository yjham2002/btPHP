/******************* JsForm Class Foundation *******************/
/***************************************************************/
    var validateFailEnum = {
        NOT_NULL : ' 필수입력 항목 입니다.',
        NEED_SELECTED : ' 선택하세요.',
        VALUE_MIN : ' 글자 수 이상 입니다.',
        VALUE_MAX : ' 글자 수 이하 입니다.',
        ONLY_NUMBER : ' 숫자만 입력하셔야 합니다.',
		NO_SPACE : ' 공백없이 입력하셔야 합니다.',
		ATTACH_FILE : ' 첨부하여 주십시오.',
		CHECK_CHARS : ' 특수문자를 입력하실수 없습니다.'
    };
    
    function JsForm(formObj)
    {
        this._formObj = formObj;
        
        this.validate = function()
        {
            for(var i=0; i<this._formObj.elements.length; i++)
            {
                var element = this._formObj.elements[i];
                var tagName = element.tagName;
                
                var result = true;
                if(tagName == "INPUT" && element.type == 'text')
                    result = this._validateForTextBox(element);
                if(tagName == "INPUT" && element.type == 'password')
                    result = this._validateForTextBox(element);
                /*if(tagName == "INPUT" && element.type == 'checkbox')
                    result = this._validateForCheckBox(element);*/
                if(tagName == "SELECT")
                    result = this._validateForSelectBox(element);
                if(tagName == "TEXTAREA")
                    result = this._validateForTextArea(element);
				if(tagName == "INPUT" && element.type == 'file')
				 result = this._validateForFile(element) ;
                    
                if(result != true){
                    alert(result);
                    
                    try{
                        element.select();
                        element.focus();
                    }
                    catch(e){}
                    finally{return false}            
                }    
                    
            }
            
            return true;
        }
        
        this._validateForTextBox = function(element){
            var frontStr = "";
            
            if(element.title != '')
                frontStr = element.title + ' 은(는) ';
                
            if(element.getAttribute("NOT_NULL") != null){
                if(element.value == '')
                    return frontStr + validateFailEnum.NOT_NULL;
            }
			 if(element.getAttribute("NO_SPACE") != null){
				 if(this._checkSpace(element.value)!= "")
					 return frontStr + validateFailEnum.NO_SPACE;
            }
            if(element.getAttribute("MIN") != null){
                if(element.value.length < element.getAttribute("MIN"))
                    return frontStr + element.getAttribute("MIN") + validateFailEnum.VALUE_MIN;
            }            
            if(element.getAttribute("MAX") != null){                
                if(element.value.length > element.getAttribute("MAX"))                
                    return frontStr + element.getAttribute("MAX") + validateFailEnum.VALUE_MAX;
            }
            if(element.getAttribute("ONLY_NUMBER") != null){
                if(isNaN(element.value)){
			 if(!this._isNumber(element.value))
			  return frontStr + validateFailEnum.ONLY_NUMBER;
			}
            }
			if(element.getAttribute("CHECK_CHARS") != null){
                if(!this._checkChars(element.value))
					 return frontStr + validateFailEnum.CHECK_CHARS;
            }

            return true;        
        }

		  this._validateForFile = function(element){
		   var frontStr = "" ;
		   if(element.getAttribute("ATTACH_FILE") != null){
			if(element.title != '')
								frontStr = element.title + ' 을(를) ';
			if(element.value == '')
							return frontStr + validateFailEnum.ATTACH_FILE;  
		   }
		   return true;
		  }
        
        this._validateForSelectBox = function(element){
            var frontStr = "";
            if(element.getAttribute("NEED_SELECTED") != null){
                if(element.getAttribute("NOT_NULL") != null){
                    if(element.title != '')
                        frontStr = element.title + ' 을(를) ';
                    if(element.selectedIndex < 1)
                        return frontStr + validateFailEnum.NEED_SELECTED;
                }
            }
            return true;
        }
        
        this._validateForTextArea = function(element){
             var frontStr = "";
             
             if(element.getAttribute("NOT_NULL") != null){
                if(element.title != '')
                    frontStr = element.title + ' 을(를) ';
                if(element.value == '')
                    return frontStr + validateFailEnum.NOT_NULL;       
             }
             
             return true;
        }

		  this._checkSpace = function( str ){
		   return (str.search(/\s/) != -1)? 1 : "" ;
		  }

		  this._isNumber = function(str) {
		   var chars = "0123456789." ;
		   if(str == "") return false ;
		   return this._containsCharsOnly(str,chars) ;
		  }

		  this._containsCharsOnly = function(input,chars){
		   for (var inx = 0; inx < input.length; inx++) {
			  if (chars.indexOf(input.charAt(inx)) == -1)
			   return false ;
		   }
		   return true ;
		  }

		  this._checkChars = function(str){
		   for ( var i=0; i<str.length; i++ ){
			var c = str.charAt(i);
			var ch = c.charCodeAt();

			if(c.search(/[0-9|a-z|A-Z|ㄱ-ㅎ|ㅏ-ㅣ|가-힝]/) == -1) 
			 return false ;
			if( escape(c).length == 3 )
			 return false;
			if( (ch >= 33 && ch <= 47) || (ch >= 58 && ch <= 64) || (ch >= 91 && ch <= 96) || (ch >= 123 && ch <= 126) )
			return false;    
		   }
		   return true;
		  }  
    }

