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

        function getLocale(){
            $sql = "SELECT * FROM tblLang ORDER BY `order` ASC";
            return $this->getArray($sql);
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

                if($res["logDate"] == "" || $res["logDate"] == null){
                    $uptSql = "UPDATE tblCustomer SET `logDate`=NOW() WHERE `id` = '{$res["id"]}'";
                    $this->update($uptSql);

                    $phone = $res["phone"];
                    if(strpos($phone, "+") !== false) $phone = $phone;
                    else $phone = "82" . substr($phone, 1, strlen($phone));

                    $result = $this->sendKakao($phone,
                        "[바이블타임선교회] 안녕하세요. {$res["name"]}님! 바이블타임선교회 홈페이지에 가입해주셔서 진심으로 감사드립니다. *회원가입 정보 아이디 : {$res["email"]} 성경을 읽는데 도움이 되는 동기부여 영상, 현수막, 포스터 이미지, 성경 골든벨 서비스를 만나보세요! ▶ 문의: 1644-9159 ▶ www.BibleTime.org"
                        , "Home_02");
                    $res = json_decode($result);
                }

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
                SELECT * FROM tblCustomer WHERE `email` = '{$email}' AND `status` = 1 AND `initFlag` = 0 LIMIT 1
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
                SELECT * FROM tblCustomer WHERE `email` = '{$email}' AND `status` = 1 AND `initFlag` = 0 LIMIT 1
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


            $templateCode = "Home_01";
            $msg = "고객님이 홈페이지에서 요청하신 인증번호는 {$code}입니다.";
            $result = $this->sendKakao($phone, $msg, $templateCode);
            $res = json_decode($result);

            if($res->code == "200") return $this->makeResultJson(1, "succ", $row["id"]);
            else return $this->makeResultJson(-2, "send fail");
        }

        function sendAuthSms(){
            $phone = $_REQUEST["phone"];
            $sql = "
                SELECT * FROM tblCustomer WHERE `phone` = '{$phone}' AND `status` = 1 AND `initFlag` = 0 LIMIT 1
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
                SELECT *, (SELECT `name` FROM tblPublicationLang PL WHERE PL.publicationId = S.publicationId AND langCode = '{$locale}' LIMIT 1) publicationName 
                FROM tblSubscription S
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
            $password = $_REQUEST["password"];
            $phone = $_REQUEST["phone"];
            $zipcode = $_REQUEST["zipcode"];
            $addr = $_REQUEST["addr"];
            $addrDetail = $_REQUEST["addrDetail"];
            $notiFlag = $_REQUEST["notiFlag"];
            $birth = $_REQUEST["birth"];

            $cName = $_REQUEST["cName"];
            $cPhone = $_REQUEST["cPhone"];

            $sql = "SELECT addr, addrDetail FROM tblCustomer WHERE `id` = '{$id}' LIMIT 1";
            $old = $this->getRow($sql);

            if($password != ""){
                $password = md5($_REQUEST["password"]);
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
                      `birth` = '{$birth}'
                    WHERE `id` = '{$id}'
                ";
                $this->update($sql);
            }
            else{
                $sql = "
                    UPDATE tblCustomer
                    SET
                      `phone` = '{$phone}',
                      `zipcode` = '{$zipcode}',
                      `addr` = '{$addr}',
                      `addrDetail` = '{$addrDetail}',
                      `cName` = '{$cName}',
                      `cPhone` = '{$cPhone}',
                      `notiFlag` = '{$notiFlag}',
                      `birth` = '{$birth}'
                    WHERE `id` = '{$id}'
                ";
                $this->update($sql);
            }


            if($addr != $old["addr"] || $addrDetail != $old["addrDetail"]){
                $sql = "
                    INSERT INTO tblCustomerHistory(customerId, modifier,`type`, content, regDate)
                    VALUES(
                      '{$this->webUser->id}',
                      '고객',
                      'etc',
                      '주소 변경: {$addr} {$addrDetail}',
                      NOW()
                    )
                ";
                $this->update($sql);
            }
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

        function setLost(){
            $type = $_REQUEST["type"];
            $noArr = $_REQUEST["noArr"];
            $ymArr = $_REQUEST["ymArr"];
            $noStr = implode(',', $noArr);
            $sql = "SELECT * FROM tblSubscription WHERE `id` IN ({$noStr})";

            $targetArr = $this->getArray($sql);
            $retArr = array();

            for($w = 0; $w < sizeof($noArr); $w++){
                for($e = 0; $e < sizeof($targetArr); $e++){
                    if($noArr[$w] == $targetArr[$e]["id"]) array_push($retArr, $targetArr[$e]);
                }
            }

            $index = 0;
            foreach($retArr as $item){
                $ym = json_decode($ymArr[$index]);
                $pYear = $ym->pYear;
                $pMonth = $ym->pMonth;
                $sql = "
                    INSERT INTO tblShipping(`customerId`, `subsciptionId`, `type`, `rName`, `zipcode`, `phone`, `addr`, `addrDetail`, `publicationId`, `cnt`, `pYear`, `pMonth`, `shippingType`, `manager`, `regDate`)
                    VALUES(
                      '{$item["customerId"]}',
                      '{$item["id"]}',
                      '1',
                      '{$item["rName"]}',
                      '{$item["rZipCode"]}',
                      '{$item["rPhone"]}',
                      '{$item["rAddr"]}',
                      '{$item["rAddrDetail"]}',
                      '{$item["publicationId"]}',
                      '{$item["cnt"]}',
                      '{$pYear}',
                      '{$pMonth}',
                      '{$type}',
                      '고객',
                      NOW()
                    )
                ";
                $this->update($sql);
                $index++;
            }
            return $this->makeResultJson(1, "succ");
        }


    }
}
?>