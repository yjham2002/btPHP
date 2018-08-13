<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebBase.php" ;?>
<?php
if(! class_exists("WebUser") ){

    class WebUser extends Common{
        function __construct($req){
            parent::__construct($req);
        }

        function getExposures(){
            $sql = "SELECT `code`, `exposure` FROM tblLayoutExposure ORDER BY `code`";
            $arr = $this->getArray($sql);
//            $retVal = Array();
//            for($e = 0; $e < sizeof($arr); $e++){
//                $retVal[$arr[$e]["code"]] = $arr[$e]["exposure"];
//            }

            return $arr;
        }

        function login(){
            $account = $_REQUEST["account"];
            $password = md5($_REQUEST["password"]);

            $sql = "
                SELECT * FROM tblCustomer
                WHERE `email` = '{$account}'
                LIMIT 1
            ";
            $res = $this->getRow($sql);

            if($res == "") return $this->makeResultJson(-2, "fail");

            if($res["initFlag"] == 1 && $res["password"] == $password){
                LoginUtil::doWebLogin($res);
                return $this->makeResultJson(1, "succ", $res);
            }
            else if($res["initFlag"] == 0) return $this->makeResultJson(-1, "init", $res);
            else{
                return $this->makeResultJson(-3, "incorrect password");
            }
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

        function sendAuthEmail(){
            $email = $_REQUEST["email"];
            $sql = "
                SELECT * FROM tblCustomer WHERE `email` = '{$email}' LIMIT 1
            ";
            $row = $this->getRow($sql);

            if($row == ""){
                return $this->makeResultJson(-1, "no data");
            }

            $code = substr(md5(date("Y-m-d H:i:s").$row["email"]), 0, 6);

            $sql = "DELETE FROM tblAuth WHERE `customerId` = '{$row["id"]}'";
            $this->update($sql);

            $sql = "
                INSERT INTO tblAuth(`customerId`, `code`, `regDate`)
                VALUES(
                  '{$row["id"]}',
                  '{$code}',
                  NOW()
                )
            ";
            $this->update($sql);

            $body = "BibleTime 인증 메일입니다. 인증번호 " . $code . " 를 입력하여 인증을 완료하세요";

            $mail = new GEmail();
            $mail->setMailBody($body);
            $mail->setSubject("BibleTime 인증 이메일");
            $mail->addReceiveEmail($email, $row["name"]);
            $flag = $mail->sendMail();

            if($flag) return $this->makeResultJson(1, "succ", $row["id"]);
            else return $this->makeResultJson(-2, "send fail");
        }

        function authEmail(){
            $customerId = $_REQUEST["customerId"];
            $code =$_REQUEST["code"];
            $password = md5($_REQUEST["password"]);

            $sql = "
                SELECT `code` FROM tblAuth WHERE `customerId` = '{$customerId}' ORDER BY regDate DESC LIMIT 1
            ";
            $val = $this->getValue($sql, "code");
            if($val == $code){
                $sql = "
                    UPDATE tblCustomer
                    SET
                      `password` = '{$password}',
                      `initFlag` = '1'
                    WHERE `id` = '{$customerId}'
                ";
                $this->update($sql);
                return $this->makeResultJson(1, "succ");
            }
            else return $this->makeResultJson(-1, "auth fail");
        }
    }
}
?>