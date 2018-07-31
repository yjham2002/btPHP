<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminBase.php" ;?>
<?
/*
 * Admin process
 * add by dev.lee
 * */
if(!class_exists("AdminEtc")){
	class AdminEtc extends  AdminBase {
		
		function __construct($req) 
		{
			parent::__construct($req);
		}

		
		// 관리자 비밀번호 변경
		function chageAdminPWD()
		{
			$no = $this->admUser["adminNo"];
			$nowPWD	= $this->req["nowPWD"];
			$newPWD	= $this->req["newPWD"];
		
		
			$sql = "
				SELECT *
				FROM tblAdmin
				WHERE `adminNo` = '{$no}'
				LIMIT 1
			";
			$result = $this->getRow($sql);
		
			if($result == null)
			{
				$_REQUEST["msg"] = "재 로그인 후 다시 시도해주세요.";
				return false;
			}
		
		
			if($result["adminPwd"] != MD5($nowPWD))
			{
				$_REQUEST["msg"] = "현재 비밀번호가 일치하지 않습니다.";
				return false;
			}
		
		
			$sql = "
				UPDATE tblAdmin
				SET adminPwd = MD5('{$newPWD}')
				WHERE `adminNo` = '{$no}'
			";
			$this->update($sql);
				
		}
		
		function getListOfAdmin(){
			
			$this->initPage() ;
			$sql="
			SELECT COUNT(*) AS rn
			FROM tblAdmin
			WHERE status=1
			";
			$this->rownum = $this->getValue($sql, 'rn');
			$this->setPage($this->rownum) ;
			
			$sql="
				SELECT *
				FROM tblAdmin
				WHERE status=1
				LIMIT {$this->startNum}, {$this->endNum} ;
			";
			$result=$this->getArray($sql);
			//echo json_encode($result);
			return $result;
		}
		
		function checkRedundancyAdminID($adminID){
			$sql="
				SELECT adminNo
				FROM tblAdmin
				WHERE adminID='{$adminID}'
			";
			
			$result=$this->getValue($sql, 'adminNo');
			return $result;
		}
		
		function saveAdmin(){
			$no=$this->req["no"];
			$adminID=$this->req["adminID"];
			$adminPwd=md5($this->req["adminPwd"]);
			$adminName=$this->req["adminName"];
			
			if($no==""){
				$res=$this->checkRedundancyAdminID($adminID);
				if($res != "")
					return $this->makeResultJson(-1, "동일한 아이디가 존재합니다");
				
				$sql="
					INSERT INTO tblAdmin(adminID, adminPwd, adminName, status, regDate)
					VALUES
					(
					'{$adminID}',
					'{$adminPwd}',
					'{$adminName}',
					1,
					NOW()
					)
				";
				$this->update($sql);
				return $this->makeResultJson(1, "등록되었습니다");
			}
			else{
				$sql="
					UPDATE tblAdmin
					SET
					adminPwd='{$adminPwd}',
					adminName='{$adminName}'
					WHERE adminNo='{$no}'
				";
				$this->update($sql);
				return $this->makeResultJson(1, "수정되었습니다");
			}
		}
		
		function getInfoOfAdmin(){
			$adminNo=$this->req["no"];
			
			$sql="
				SELECT *
				FROM tblAdmin
				WHERE adminNo='{$adminNo}'
			";
			$result=$this->getRow($sql);
			//echo json_encode($result);
			return $result;
		}
		
		function deleteAdmin(){
			$adminNo=$this->req["no"];
			
			$sql="
				UPDATE tblAdmin
				SET
				status=0
				WHERE adminNo='{$adminNo}'
			";
			$this->update($sql);
			return $this->makeResultJson(1, "삭제되었습니다");
		}

	} 
}
?>