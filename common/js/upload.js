var fileInfo = {} ;

//함수 네이밍은 꼭 지겨주세요.
function uploader_var(){
	return {
			btnPath:'/images/search.gif', //100*24 px
			upload:'/common/php/Upload.php', //상대경로 절대 경로 모두 가능
			overNum:8, //한번에 선택될수 있는 파일갯수 초과시 아래 uploader_alert() 함수 호출
			overSize:5*1024*1024, // 파일 한개의 크기 제한 현재 5mb .. (bytes 단위) -> 보기 편하게 * 하는 표현으로 썼을뿐입니다.
			typeVar:'file', //전송할 파일 폼 네이밍 (input type="file" name="file") 여기에 해당.
			param:{mode:'upload', no:''}, //파일과 같이 전달될 변수 object .. 
			filterName:"이미지 (*.jpg, *.jpeg, *.gif,*.png, *.bmp)", //확장자제한이름,	(1)
			filterExt:"*.jpg; *.jpeg; *.gif; *.png; *.bmp;" //확장자		(2)
		   };
}

/*
(1)(2) 예시 좀더..
ㄱ. filterName:"동영상",	
    filterExt:"*.wma; *.wmv; *.asf; *.flv;"
ㄴ. filterName:"동영상·이미지",	
    filterExt:"*.wma; *.wmv; *.asf; *.flv; *.jpg; *.jpeg; *.gif; *.png; *.bmp;"
ㄷ. filterName:"오피스파일",	
    filterExt:"*.xls; *.ppt; *.doc; *.hwp; *.pdf;"

이건 예시일뿐..
*/

function uploader_alert(val, str){
	if(val == 'numOver'){
		alert(str + "개의 파일를 초과할 수 없습니다.");
		return false;
	}else{//ioError 와 securitError 출력부분 없애도 됨
		alert(str);
		return false;
	}
}

//파일전송후 리턴받은 값을 처리하는 함수임.여러개의 인자를 해야 할 경우 리턴받을때 | 등의구분자를 두고 여기서 처리함이..좋을듯
//이부분에서 데이터 임시 저장후 DB에 넣어어두 되고 아래 php코드에서 넣어두 되고.
//보여지는 UI는 여기서 수정하셔야 합니다.
function uploader_return(val){
	// 0 : 업로드 로컬 파일명
	// 1 : 업로드 변경 파일명
	// 2 : 업로드 확장자
	// 3 : 업로드 변경 풀파일명
	// 4 : 업로드 풀패스

	uInfo = val.split("|");//값 받아 오는 것은 파일경로|파일명 이렇게 받아옵니다. 이건 예시일뿐.. 
	
	name = uInfo[0] ;
	uName = uInfo[1] ;
	uExt = uInfo[2] ;
	uFullName = uInfo[3] ;
	path = uInfo[4] ;

	fileInfo[uName] = uInfo ;

	$("#imgField").append("<div id='div_'"+uName+"' test='aa'>" +
							"<table class='list_base'>" + 
								"<tr><td rowspan='2'>" + 
									"<img class='image_view' src='"+path+"'/></td><td>" + name + "</td></tr>" + 
								"<tr><td>" + getSelectImageStr(uName) + "</td></tr>" + 
							"</table>" + 
							"</div>") ;
	
	aeId(uName,"click",selImage) ;
	aeId("del_"+uName,"click",delImage) ;

}

function delImage()
{
	$( "#div_"+$(this).attr("id").replace("del_","") ).remove() ;
}