<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebBase.php" ;?>
<?
if(!class_exists("Web")){
	class Web extends WebBase{
			
		function __construct($req) {
			parent::__construct($req);
		}
		
		
		//이용약관을 꺼내온다.
		function getInfoOfAgreeText() {
			$this->req["type"] = $this->req["type"] ? $this->req["type"] : 1 ;
			
			$actionUrl = "{$this->serverRoot}/GolfLand/ApiComm/getInfoOfAgreeText";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
		
		//단체예약 신청하기
		function requestGolfReserve() {
			$this->req["userNumber"]	=	$this->webUser["userNumber"] ;
			
			$actionUrl = "{$this->serverRoot}/GolfLand/ApiBooking/requestGolfReserve";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
		
		//리뷰 정보
		function getInfoOfReview() {
			$actionUrl = "{$this->serverRoot}/GolfLand/Web/getInfoOfReview";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
		
		// 리뷰 저장 / 수정
		function saveGolfReview() {
			$this->req["userNumber"]	=	$this->webUser["userNumber"] ;
			
			$actionUrl = "{$this->serverRoot}/GolfLand/Web/saveGolfReview";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
		
		// 리뷰 삭제
		function deleteReview() {
			$actionUrl = "{$this->serverRoot}/GolfLand/Web/deleteReview";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
		
		// 골프장 상세
		function getInfoOfGolf() {
			$actionUrl = "{$this->serverRoot}/GolfLand/AdminBooking/getInfoOfGolf";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
		
		//골프장 리스트
		function getListOfGolf() {
			$actionUrl = "{$this->serverRoot}/GolfLand/Web/getListOfGolf";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
		
		//특가상품 상세
		function getInfoOfEvent() {
			$actionUrl = "{$this->serverRoot}/GolfLand/Web/getInfoOfEvent";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
		
		
		//북마크 on/off
		function setEventBookmark() {
			$this->req["userNumber"]	=	$this->webUser["userNumber"] ;
			
			$actionUrl = "{$this->serverRoot}/GolfLand/ApiBooking/setEventBookmark";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
			
		
		//특가상품 리스트
		function getListOfEvent() {
			$actionUrl = "{$this->serverRoot}/GolfLand/Web/getListOfEvent";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
		
		//투어 리스트
		function getListOfTour() {
			$actionUrl = "{$this->serverRoot}/GolfLand/Web/getListOfTour";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
		
		//양도/조인
		function getListOfBooking() {
			$this->req["userNumber"]	=	$this->webUser["userNumber"] ;
			
			$actionUrl = "{$this->serverRoot}/GolfLand/Web/getListOfBooking";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
		//특가 이벤트 리스트 (메인)
		function getListOfMainEvent() {
			$actionUrl = "{$this->serverRoot}/GolfLand/Web/getListOfMainEvent" ;
			
			$retVal = $this->getData($actionUrl, $this->req) ;
			
			return $retVal ;
		}
		
		//골프장 리스트 (메인)
		function getListOfMainGolfcourse() {
			$actionUrl = "{$this->serverRoot}/GolfLand/Web/getListOfMainGolfcourse" ;
			
			$retVal = $this->getData($actionUrl, $this->req) ;
			
			return $retVal ;
		}
		
		
		//골프장 리스트 (검색팝업)
		function getListOfGolfcourse() {
			$actionUrl = "{$this->serverRoot}/GolfLand/WebUser/getListOfGolfcourse" ;
			
			$retVal = $this->getData($actionUrl, $this->req) ;
			
			return $retVal ;
		}
		
		//지역 리스트
		function getListOfLocList() {
			$actionUrl = "{$this->serverRoot}/GolfLand/WebUser/getListOfLocList";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
		//나의 단체 예약 신청 현황
		function getListOfMyGolfReserve() {
			$this->req["userNumber"]	=	$this->webUser["userNumber"] ;
			
			$actionUrl = "{$this->serverRoot}/GolfLand/WebUser/getListOfMyGolfReserve";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
		
		//나의 단체 예약 신청 상세
		function getInfoOfMyRes() {
			$actionUrl = "{$this->serverRoot}/GolfLand/WebUser/getInfoOfMyRes";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
		
		//나의 특가 신청 현황
		function getListOfMyEvent() {
			$this->req["userNumber"]	=	$this->webUser["userNumber"] ;
			
			$actionUrl = "{$this->serverRoot}/GolfLand/WebUser/getListOfMyEvent";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
		
		//나의 특가 신청 현황 상세
		function getInfoOfMyEvent() {
			$actionUrl = "{$this->serverRoot}/GolfLand/WebUser/getInfoOfMyEvent";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
			
		//나의 양도/조인 신청글 상세
		function getInfoOfMyBooking() {
			$actionUrl = "{$this->serverRoot}/GolfLand/WebUser/getInfoOfMyBooking";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
		//나의 투어 신청 현황
		function getListOfMyTour() {
			$this->req["userNumber"]	=	$this->webUser["userNumber"] ;
			
			$actionUrl = "{$this->serverRoot}/GolfLand/WebUser/getListOfMyTour";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
		//나의 투어 신청 현황 상세
		function getInfoOfMyTour() {
			$actionUrl = "{$this->serverRoot}/GolfLand/WebUser/getInfoOfMyTour";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
				
		//포인트 사용 내역
		function getListOfPointTrans() {
			$this->req["userNumber"]	=	$this->webUser["userNumber"] ;
			
			$actionUrl = "{$this->serverRoot}/GolfLand/WebUser/getListOfPointTrans";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
		
		//회원 비밀번호 변경
		function modifyUserPW() {
			$this->req["userNumber"]	=	$this->webUser["userNumber"] ;
			$this->req["userID"]	=	$this->webUser["userID"] ;
			
			$actionUrl = "{$this->serverRoot}/GolfLand/WebUser/modifyUserPW";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}

		
		//회원 정보 변경
		function modifyUserInfo() {
			$this->req["userNumber"]	=	$this->webUser["userNumber"] ;
			
			$actionUrl = "{$this->serverRoot}/GolfLand/WebUser/modifyUserInfo";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
				
		//유저 닉네임 중복체크
		function duplicateUserNick() {
			$actionUrl = "{$this->serverRoot}/GolfLand/ApiUser/duplicateUserNick";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
		//유저 정보 
		function getUserInfo() {
			$this->req["userNumber"]	=	$this->webUser["userNumber"] ;
			
			$actionUrl = "{$this->serverRoot}/GolfLand/ApiUser/getUserInfo";
			
			$retVal = $this->getData($actionUrl, $this->req);
			
			return $retVal;
		}
		
			
		//로그인			
		function login() {
			$userID	=	$this->req["userID"] ;
			$userPW	=	$this->req["userPW"] ;
						
			$actionUrl = "{$this->serverRoot}/GolfLand/WebUser/loginUser";
			
			$retVal = $this->getData($actionUrl, $this->req);
			$data = json_decode($retVal);
			$userInfo = $data->entity;
			
			if($data->returnCode > 0)			
				LoginUtil::doWebLogin($userInfo);
			
			return $this->makeResultJson($data->returnCode, $data->returnMessage);
				
		}
		
		//로그아웃
		function logout(){
			LoginUtil::doWebLogout();
			$_REQUEST['rurl'] = bin2hex("/web/index.php");
		}
		
		
	}
}
?>