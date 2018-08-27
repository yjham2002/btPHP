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
                WHERE `email` = '{$account}' AND `status` = 1
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

        function sendAuthEmail(){
            $email = $_REQUEST["email"];
            $sql = "
                SELECT * FROM tblCustomer WHERE `email` = '{$email}' AND `status` = 1 LIMIT 1
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

        function sendAuthKakao(){
            $email = $_REQUEST["email"];
            $sql = "
                SELECT * FROM tblCustomer WHERE `email` = '{$email}' AND `status` = 1 LIMIT 1
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

            $phone = "";
            if(strpos($row["phone"], "+") !== false) $phone = $row["phone"];
            else $phone = "82" . substr($row["phone"], 1, strlen($row["phone"]));


            $templateCode = "BibleTIme_002";
            $msg = "{$code}님! BibleTime 홈페이지 회원가입을 진심으로 축하드립니다. 감사합니다.";
            $result = $this->sendKakao($phone, $msg, $templateCode);
            $res = json_decode($result);

            if($res->code == "200") return $this->makeResultJson(1, "succ", $row["id"]);
            else return $this->makeResultJson(-2, "send fail");
        }

        function sendAuthSms(){
            $phone = $_REQUEST["phone"];
            $sql = "
                SELECT * FROM tblCustomer WHERE `phone` = '{$phone}' AND `status` = 1 LIMIT 1
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

            $msg = "BibleTime 인증 메세입니다. 인증번호 " . $code . " 를 입력하여 인증을 완료하세요";
            $result = $this->sendSms($phone, $msg);

            if($result["result_code"] == 1) return $this->makeResultJson(1, "succ", $row["id"]);
            else return $this->makeResultJson(-1, "send fail");
        }

        function auth(){
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

                $sql = "DELETE FROM tblAuth WHERE `customerId` = '{$customerId}'";
                $this->update($sql);
                return $this->makeResultJson(1, "succ");
            }
            else return $this->makeResultJson(-1, "auth fail");
        }

        function customerInfo(){
            $id = $this->webUser->id;
            $locale = $_COOKIE["btLocale"];

            $sql = "SELECT * FROM tblCustomer WHERE `id` = '{$id}' AND `status` = 1 LIMIT 1";
            $userInfo = $this->getRow($sql);

            //TODO 결제 정보
            $paymentInfo = null;

            $sql = "
                SELECT *, (SELECT `name` FROM tblPublicationLang PL WHERE PL.publicationId = publicationId AND langCode = '{$locale}' LIMIT 1) publicationName 
                FROM tblSubscription 
                WHERE `customerId` = '{$id}' 
                ORDER BY regDate DESC
            ";
            $subscriptionInfo = $this->getArray($sql);

            $sql = "
                SELECT *
                FROM tblSupport
                WHERE `customerId` = '{$id}'
                ORDER BY regDate DESC
            ";
            $supportInfo = $this->getArray($sql);
            $retVal = Array(
                "userInfo" => $userInfo,
                "paymentInfo" =>$paymentInfo,
                "subscriptionInfo" => $subscriptionInfo,
                "supportInfo" => $supportInfo
            );
            return $retVal;
        }

        function checkEmail(){
            $email = $_REQUEST["email"];
            $sql = "SELECT * FROM tblCustomer WHERE `email` = '{$email}' AND `status` = 1 LIMIT 1";
            $row = $this->getRow($sql);
            if($row == "") return $this->makeResultJson(1, "succ");
            else return $this->makeResultJson(-1, "fail");
        }

        function checkCustomerPassword(){
            $id = $_REQUEST["id"];
            $password = md5($_REQUEST["password"]);
            $sql = "SELECT * FROM tblCustomer WHERE `id` = '{$id}' AND `password` = '{$password}' AND `status` = 1 LIMIT 1";
            $row = $this->getRow($sql);
            if($row != "") return $this->makeResultJson(1, "succ");
            else return $this->makeResultJson(-1, "fail");
        }

        function updateCustomerInfo(){
            $type = $_REQUEST["type"];
            $id = $_REQUEST["id"];
            $password = md5($_REQUEST["password"]);
            $phone = $_REQUEST["phone"];
            $zipcode = $_REQUEST["zipcode"];
            $addr = $_REQUEST["addr"];
            $addrDetail = $_REQUEST["addrDetail"];
            $notiFlag = $_REQUEST["notiFlag"];
            $birth = $_REQUEST["birth"];

            $cName = $_REQUEST["cName"];
            $cPhone = $_REQUEST["cPhone"];

            $sql = "
                    UPDATE tblCustomer
                    SET
                      `password` = '{$password}',
                      `phone` = '{$phone}',
                      `zipcode` = '{$zipcode}',
                      `addr` = '{$addr}',
                      `addrDetail` = '{$addrDetail}',
                      `cName` = '{$cName}',
                      `cPhone` = '{$cPhone}',
                      `notiFlag` = '{$notiFlag}',
                      `birth` = '{$birth}'``
                    WHERE `id` = '{$id}'
                ";
            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

        function sendInquiryEmail(){
            $email = "team@bibletime.org";
            $title = $_REQUEST["title"];
            $body = $_REQUEST["content"];

            $mail = new GEmail();
            $mail->setMailBody($body);
            $mail->setSubject($title);
            $mail->addReceiveEmail($email, "bibleTime");
            $mail->setSendEmail($this->webUser->email, $this->webUser->name);

            $flag = $mail->sendMail();
            if($flag) return $this->makeResultJson(1, "succ");
            else return $this->makeResultJson(-2, "send fail");
        }
    }
}
?>