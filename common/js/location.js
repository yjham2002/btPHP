function areaInit(nm, value)
{
	if(typeof(nm) == "undefinded")
	{
		nm = "area"
	}

	if(document.getElementById(nm) != null){
		$("#"+nm).empty();
		
		$("#"+nm)[0].options[0] = new Option;
		$("#"+nm + ">option:eq(0)").attr({value:"", text:"대륙선택"});
		
		for(var i=1; i<=ARR_LOCATION.length; i++)
		{
			$("#"+nm)[0].options[i] = new Option;
			$("#"+nm + ">option:eq("+i+")").attr({value:ARR_LOCATION[i-1][0], text:ARR_LOCATION[i-1][0]});

			if(value != undefined && value != "" && value == ARR_LOCATION[i-1][0])
				$("#"+nm + ">option:eq("+i+")").attr("selected","true") ;

		}
	}
}

function nationInit(nm, areaIdx, value)
{
	if(typeof(nm) == "undefinded")
	{
		nm = "nation"
	}
	
	if(document.getElementById(nm) != null){
		$("#"+nm).empty();
		
		$("#"+nm)[0].options[0] = new Option;
		$("#"+nm + ">option:eq(0)").attr({value:"", text:"국가선택"});
		
		if(areaIdx >= 0)
		{
			for(var i=1; i<ARR_LOCATION[areaIdx].length; i++)
			{
				$("#"+nm)[0].options[i] = new Option;
				$("#"+nm + ">option:eq("+i+")").attr({value:ARR_LOCATION[areaIdx][i], text:ARR_LOCATION[areaIdx][i]});
				
				if(value != undefined && value != "" && value == ARR_LOCATION[areaIdx][i])
					$("#"+nm + ">option:eq("+i+")").attr("selected","true") ;

			}
		}
	}
}

var ARR_LOCATION = new Array;

ARR_LOCATION[0] = new Array;
ARR_LOCATION[1] = new Array;
ARR_LOCATION[2] = new Array;
ARR_LOCATION[3] = new Array;
ARR_LOCATION[4] = new Array;
ARR_LOCATION[5] = new Array;

ARR_LOCATION[0][0] = "EUROPE";
ARR_LOCATION[0][1] = "ALBANIA" ;
ARR_LOCATION[0][2] = "AUSTRIA" ;
ARR_LOCATION[0][3] = "BELARUS" ;
ARR_LOCATION[0][4] = "BELGIUM" ;
ARR_LOCATION[0][5] = "BOSNIA HERZEGOVINA" ;
ARR_LOCATION[0][6] = "BULGARIA" ;
ARR_LOCATION[0][7] = "CROATIA" ;
ARR_LOCATION[0][8] = "CZECH REPUBLIC" ;
ARR_LOCATION[0][9] = "DENMARK" ;
ARR_LOCATION[0][10] = "ESTONIA" ;
ARR_LOCATION[0][11] = "FINLAND" ;
ARR_LOCATION[0][12] = "FRANCE" ;
ARR_LOCATION[0][13] = "GERMANY" ;
ARR_LOCATION[0][14] = "GREECE" ;
ARR_LOCATION[0][15] = "HUNGARY" ;
ARR_LOCATION[0][16] = "ICELAND" ;
ARR_LOCATION[0][17] = "IRELAND" ;
ARR_LOCATION[0][18] = "ITALY" ;
ARR_LOCATION[0][19] = "LATVIA" ;
ARR_LOCATION[0][20] = "LUXEMBOURG" ;
ARR_LOCATION[0][21] = "MACEDONIA" ;
ARR_LOCATION[0][22] = "MOLDOVA" ;
ARR_LOCATION[0][23] = "NETHERLANDS" ;
ARR_LOCATION[0][24] = "NORWAY" ;
ARR_LOCATION[0][25] = "POLAND" ;
ARR_LOCATION[0][26] = "PORTUGAL" ;
ARR_LOCATION[0][27] = "ROMANIA" ;
ARR_LOCATION[0][28] = "RUSSIAN FEB" ;
ARR_LOCATION[0][29] = "SLOVAKIA" ;
ARR_LOCATION[0][30] = "SLOVENIA" ;
ARR_LOCATION[0][31] = "SPAIN" ;
ARR_LOCATION[0][32] = "SWEDEN" ;
ARR_LOCATION[0][33] = "SWITZERLAND" ;
ARR_LOCATION[0][34]	= "UK"	;
ARR_LOCATION[0][35] = "UKRAINE" ;
ARR_LOCATION[0][36] = "YUGOSLAVIA" ;

ARR_LOCATION[1][0] = "ASIA";
ARR_LOCATION[1][1] = "ARMENIA" ;
ARR_LOCATION[1][2] = "AZERBAIJAN" ;
ARR_LOCATION[1][3] = "BAHRAIN" ;
ARR_LOCATION[1][4] = "BANGLADESH" ;
ARR_LOCATION[1][5] = "BHUTAN" ;
ARR_LOCATION[1][6] = "BRUNEI DARUSSALAM" ;
ARR_LOCATION[1][7] = "CAMBODIA" ;
ARR_LOCATION[1][8] = "CHINA" ;
ARR_LOCATION[1][9] = "HONG KONG" ;
ARR_LOCATION[1][10] = "INDIA" ;
ARR_LOCATION[1][11] = "INDONESIA" ;
ARR_LOCATION[1][12] = "IRAN" ;
ARR_LOCATION[1][13] = "ISRAEL" ;
ARR_LOCATION[1][14] = "JAPAN" ;
ARR_LOCATION[1][15] = "JORDAN" ;
ARR_LOCATION[1][16] = "KAZAKHSTAN" ;
ARR_LOCATION[1][17] = "LAOS" ;
ARR_LOCATION[1][18] = "MACAU" ;
ARR_LOCATION[1][19] = "MALAYSIA" ;
ARR_LOCATION[1][20] = "MALDIVES" ;
ARR_LOCATION[1][21] = "MONGOLIA" ;
ARR_LOCATION[1][22] = "MYANMAR" ;
ARR_LOCATION[1][23] = "NEPAL" ;
ARR_LOCATION[1][24] = "OMAN" ;
ARR_LOCATION[1][25] = "PAKISTAN" ;
ARR_LOCATION[1][26] = "PHILIPPINES" ;
ARR_LOCATION[1][27] = "QATAR" ;
ARR_LOCATION[1][28] = "SAUDI ARABIA" ;
ARR_LOCATION[1][29] = "SINGAPORE" ;
ARR_LOCATION[1][30] = "SRILANKA" ;
ARR_LOCATION[1][31] = "SYRIA ARAB REP." ;
ARR_LOCATION[1][32] = "TAIWAN" ;
ARR_LOCATION[1][33] = "THAILAND" ;
ARR_LOCATION[1][34] = "TURKEY" ;
ARR_LOCATION[1][35] = "U.A.E." ;
ARR_LOCATION[1][36] = "UZBEKISTAN" ;
ARR_LOCATION[1][37] = "VIETNAM" ;
ARR_LOCATION[1][38] = "YEMEN" ;

ARR_LOCATION[2][0] = "N.America";
ARR_LOCATION[2][1] = "CANADA";
ARR_LOCATION[2][2] = "COSTARICA";
ARR_LOCATION[2][3] = "DOMINICAN REP.";
ARR_LOCATION[2][4] = "U.S.A";

ARR_LOCATION[3][0] = "S.America";
ARR_LOCATION[3][1] = "ARGENTINA" ;
ARR_LOCATION[3][2] = "BRAZIL" ;
ARR_LOCATION[3][3] = "CHILE" ;
ARR_LOCATION[3][4] = "CUBA" ;
ARR_LOCATION[3][5] = "ECUADOR" ;
ARR_LOCATION[3][6] = "ELSALVADOR" ;
ARR_LOCATION[3][7] = "GUATEMALA" ;
ARR_LOCATION[3][8] = "HAITI" ;
ARR_LOCATION[3][9] = "MEXICO" ;
ARR_LOCATION[3][10] = "PANAMA" ;
ARR_LOCATION[3][11] = "PARAGUAY" ;
ARR_LOCATION[3][12] = "PERU" ;
ARR_LOCATION[3][13] = "TRINIDAD AND TOBAGO" ;

ARR_LOCATION[4][0] = "OCEANIA";
ARR_LOCATION[4][1] = "AUSTRALIA";
ARR_LOCATION[4][2] = "FIJI ISLANDS";
ARR_LOCATION[4][3] = "NEW ZEALAND";

ARR_LOCATION[5][0] = "AFRICA";
ARR_LOCATION[5][1] = "ALGERIA" ;
ARR_LOCATION[5][2] = "ANGOLA" ;
ARR_LOCATION[5][3] = "BENIN" ;
ARR_LOCATION[5][4] = "BOTSWANA" ;
ARR_LOCATION[5][5] = "BURKINA FASO" ;
ARR_LOCATION[5][6] = "CAMEROON" ;
ARR_LOCATION[5][7] = "CAPE VERDE" ;
ARR_LOCATION[5][8] = "CHAD" ;
ARR_LOCATION[5][9] = "CONGO" ;
ARR_LOCATION[5][10] = "DJIBOUTI" ;
ARR_LOCATION[5][11] = "EGYPT" ;
ARR_LOCATION[5][12] = "ERITREA" ;
ARR_LOCATION[5][13] = "ETHIOPIA" ;
ARR_LOCATION[5][14] = "KENYA" ;
ARR_LOCATION[5][15] = "MALI" ;
ARR_LOCATION[5][16] = "MAURITIUS" ;
ARR_LOCATION[5][17] = "MOROCCO" ;
ARR_LOCATION[5][18] = "MOZAMBIQUE" ;
ARR_LOCATION[5][19] = "NICARAGUA" ;
ARR_LOCATION[5][20] = "NIGER" ;
ARR_LOCATION[5][21] = "NIGERIA" ;
ARR_LOCATION[5][22] = "RWANDA" ;
ARR_LOCATION[5][23] = "SENEGAL" ;
ARR_LOCATION[5][24] = "TANZANIA" ;
ARR_LOCATION[5][25] = "TOGO" ;
ARR_LOCATION[5][26] = "TUNISIA" ;
ARR_LOCATION[5][27] = "ZAMBIA" ;