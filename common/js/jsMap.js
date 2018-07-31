function JsMap()
{
	this._array = new Array();//Map배열 
	this.pointer = 0;

	this._getIndexByKey = function(key)
	{
		for(var i=0; i< this._array.length; i++)
		{
			if(key == this._array[i][0])
			{
				return i;
			}
		}
		return -1;
	}

	this.put = function(key,value)
	{
		var index = this._getIndexByKey(key)

		if(index == -1)
		{
			var newArray = new Array();//key와value를 담는 배열
			newArray[0] = key;
			newArray[1] = value;
			this._array[this._array.length] = newArray;
		}
		else
		{
			this._array[index][1] = value;
		}
	}

	this.get = function(key)
	{    
		for(var i=0; i < this._array.length; i++)
		{
			if(this._array[i][0] == key)
				return this._array[i][1];
		}
	}

	this.isNext = function()
	{
		var result;
		if(this._array.length > this.pointer)
		{     
			result =  true;
		}
		else
		{
			result = false;
		}
		this.pointer++;
		return result;
	}

	this.size = function()
	{
		return this._array.length;
	}

	this.nowKey = function()
	{
		return this._array[this.pointer -1][0];
	}
	this.nowValue = function()
	{
		return this._array[this.pointer -1][1];
	}

	this.initMsg = function()
	{
		//---- New Msg ----//
		this.put("TxtPickUpLocation", "영문/한글 도시 이름을 입력") ;
		this.put("TxtReturnLocation", "영문/한글 도시 이름을 입력") ;
		this.put("RateQualifier", "오른쪽 요금조회 버튼 클릭후 선택") ;
		this.put("airMemId","멤버쉽 번호") ;
		this.put("PromotionCode","쿠폰 코드") ;
		
		this.put("mem_fnm_en", "ex : HONG") ;
		this.put("mem_lnm_en", "ex : KILDONG") ;


		this.put("mem_id", "아이디") ;
		this.put("mem_pw", "비밀번호") ;
		this.put("agent_no", "사업자등록번호") ;
		this.put("agent_id", "담당자 아이디") ;
		this.put("agent_pw", "비밀번호") ;		


	}
}