<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebBase.php" ;?>
<?php
if(! class_exists("WebUser") ){

    class WebUser extends Common{
        function __construct($req){
            parent::__construct($req);
        }


        function login(){
            $account = $_REQUEST["account"];
            $password = md5($_REQUEST["password"]);

            $sql = "
                SELECT * FROM tblCustomer
                WHERE `email` = '{$account}' AND `password` = '{$password}' AND status = 1
                LIMIT 1
            ";
            $res = $this->getRow($sql);
            if($res != ""){
                LoginUtil::doWebLogin($res);
                return $this->makeResultJson(1, "succ", $res);
            }
            else return $this->makeResultJson(-1, "fail");
        }

        function logOut(){
            LoginUtil::doWebLogout();
            return $this->makeResultJson(1, "succ");
        }

        function updatePushKey(){
            $retVal = $this->get("/web/user/update/pushKey/{$this->webUser->id}", Array("pushKey" => $_REQUEST["pushKey"]));
            return $retVal;
        }

        function autoLogin(){
            $retVal = $this->get("/web/user/basic/{$_REQUEST["userId"]}", null);
            LoginUtil::doWebLogin(json_decode($retVal)->data);
            return $retVal;
        }

        function userLogin(){
            $retVal = $this->post("/web/user/login", Array("account" => $_REQUEST["account"], "password" => $_REQUEST["password"] ));
            LoginUtil::doWebLogin(json_decode($retVal)->data);
            return $retVal;
        }
        

    }
}
?>