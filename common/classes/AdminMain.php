<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminBase.php" ;?>
<?
/*
 * Web process
 * add by cho
 * */
if(!class_exists("AdminMain")){
    class AdminMain extends  AdminBase {
        function __construct($req)
        {
            parent::__construct($req);
        }

        function login(){
            $account = $_REQUEST["account"];
            $password = md5($_REQUEST["password"]);

            $sql = "
                SELECT * FROM tblAdmin
                WHERE `account` = '{$account}' AND `password` = '{$password}' AND status = 1
                LIMIT 1
            ";
            $res = $this->getRow($sql);
            if($res != ""){
                LoginUtil::doAdminLogin($res);
                return $this->makeResultJson(1, "succ", $res);
            }
            else return $this->makeResultJson(-1, "fail");
        }

        function logout(){
            LoginUtil::doAdminLogout();
            return $this->makeResultJson(1, "succ");
        }

        function getLangList(){
            $sql = "SELECT * FROM tblLang ORDER BY `order` ASC;";
            return $this->getArray($sql);
        }

        function deleteLang(){
            $code = $_REQUEST['code'];
            if($code == "") return;
            else{
                $sql = "DELETE FROM tblLang WHERE `code` = '{$code}'";
                $this->update($sql);
            }
        }

        function upsertLang(){
            $code = $_REQUEST['code'];
            $order = $_REQUEST['order'];
            $desc = $_REQUEST['desc'];
            $sql = "INSERT 
                    INTO tblLang(`code`, `order`, `desc`) 
                    VALUES('{$code}', '{$order}', '{$desc}')
                    ON DUPLICATE KEY UPDATE `order`='{$order}', `desc`='{$desc}'";
            $this->update($sql);
        }

//        function adminList(){
//            $sql = "
//                SELECT * FROM tblAdmin
//                WHERE status = 1
//                ORDER BY regDate DESC
//            ";
//
//            return $this->getArray($sql);
//        }
//
//        function adminInfo(){
//            $id = $_REQUEST["id"];
//            $sql = "SELECT * FROM tblAdmin WHERE adminNo = '{$id}' AND status = 1";
//            return $this->getRow($sql);
//        }
//
//
//        function deleteAdmin(){
//            $noArr = $this->req["no"];
//
//            $noStr = implode(',', $noArr);
//
//            $sql = "
//				UPDATE tblAdmin
//				SET status = 0
//				WHERE `adminNo` IN({$noStr})
//			";
//            $this->update($sql);
//
//            return $this->makeResultJson(1, "succ");
//        }


        function _upsertLangJson(){
            $this->upsertLangJson($_REQUEST["code"], $_REQUEST["json"]);
        }

        function upsertLangJson($code, $jsonArray){
            $json = $jsonArray;

            $sql = "
            INSERT INTO tblLangJson(`code`, `json`, `regDate`)
            VALUES ('{$code}', '{$json}', NOW())
            ON DUPLICATE KEY UPDATE `json`='{$json}'
            ";

            $this->update($sql);
        }

        function _getLangJson(){
            return json_encode($this->getLangJson($_REQUEST["code"]));
        }

        function getLangJson($code){
            $sql = "SELECT * FROM tblLangJson WHERE `code` = '{$code}'";
            return $this->getRow($sql);
        }

    }


}