<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminBase.php" ;?>
<?
/*
 * Admin process
 * add by dev.lee
 * */
if(!class_exists("Admin")){
	class Admin extends  AdminBase {
		
		function __construct($req) 
		{
			parent::__construct($req);
		}
		
		function wrapParam()
		{
			$this->req['page']	= ($this->req['page'] == "") ? 1 : $this->req['page'] ;
		}

		function getAddQuery()
		{
			$addQuery = "" ;
			$addQuery .= $this->getSearchQuery() ;

			return $addQuery ;
		}
		

		function login()
		{
			$id = $this->req[adm_id];
			$pass = MD5($this->req[adm_pw]);
			
			$sql = "
				SELECT adm.*
				FROM tblAdmin adm 
				WHERE adm.adminID = '{$id}' AND adm.adminPwd = '{$pass}' AND adm.status = 1
				LIMIT 0, 1
			";
			
			$retVal = $this->getRow($sql);
			
			if($retVal == null)
			{
				$_REQUEST[msg] = "로그인 정보가 일치하지 않습니다. 확인해주세요.";
				return;
			}
			else
			{
				LoginUtil::doAdminLogin($retVal);
				$_REQUEST[rurl] =  bin2hex("/admin/planManage/planList.php");
			}
		}
		
		
		//계정 정보 조회
		function getAdminInfo()
		{
			$no = $this->admUser["adminNo"];
			
			$sql = "
				SELECT adm.*
				FROM tblAdmin adm 
				WHERE adm.adminNo = '{$no}' AND adm.status = 1
				LIMIT 0, 1
			";
			$result = $this->getRow($sql);

			return $result;
		}
			
		
		function checkLogin(){
			
			if(LoginUtil::isAdminLogin() == false){
				$rurl = bin2hex($_SERVER[REQUEST_URI]) ;
				
				if(stristr($_SERVER[REQUEST_URI],"pop"))
					echo "<script>alert('관리자로 로그인 후 이용할 수 있습니다.') ; opener.location.href = 'index.php'; self.close();</script>" ;
				else
					echo "<script>alert('관리자로 로그인 후 이용할 수 있습니다.') ; location.href = 'index.php' ;</script>" ;
			}
			
		}
		

		function logout(){
			LoginUtil::doAdminLogout();
			$_REQUEST[rurl] = bin2hex("/admin/index.php");
		}


	
	}
}
?>