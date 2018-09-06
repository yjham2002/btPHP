<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 20.
 * Time: PM 2:12
 */
?>


<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebBase.php" ;?>
<?
if(!class_exists("WebSupport")){
    class WebSupport extends  WebBase {

        function __construct($req)
        {
            parent::__construct($req);
        }

        function getSupportMessage($id){
            $sql = "
                SELECT * FROM tblSupport
                WHERE `parentId` = '{$id}'
            ";
            return $this->getArray($sql);
        }

        function supportDetail(){
            $id = $_REQUEST["id"];
            $locale = $_COOKIE["btLocale"];

            $sql = "
                SELECT *, (SELECT nationId FROM tblSupportParent SP WHERE parentId = SP.id) AS nationId
                FROM tblSupportArticle
                WHERE `parentId` = '{$id}' AND locale = '{$locale}'
                LIMIT 1 
            ";
            return $this->getRow($sql);
        }

        function setSupportInfo(){
            $customerId = $_REQUEST["customerId"];
            $parentId = $_REQUEST["parentId"];

            $name = $_REQUEST["name"];
            $email = $_REQUEST["email"];
            $phone = $_REQUEST["phone"];
            $nationId = $_REQUEST["nationId"];
            $langCode = $_COOKIE["btLocale"];
            if($customerId == ""){
                $type = 1;
                $sql = "
                    INSERT INTO tblCustomer(`type`, `name`, `phone`, `email`,`langCode`, `regDate`)
                    VALUES(
                      '{$type}',
                      '{$name}',
                      '{$phone}',
                      '{$email}',
                      '{$langCode}',
                      NOW()
                    )
                ";
                $this->update($sql);
                $customerId = $this->mysql_insert_id();
            }

            $cnt = $_REQUEST["cnt"];
            $totalPrice = $_REQUEST["totalPrice"];
            $message = $_REQUEST["message"];

            $sql = "
                INSERT INTO tblSupport(`customerId`, `parentId`, `cnt`, `totalPrice`, `rName`, `rEmail`, `rPhone`, `payMethodId`, `message`, `regDate`)
                VALUES(
                  '{$customerId}',
                  '{$parentId}',
                  '{$cnt}',
                  '{$totalPrice}',
                  '{$name}',
                  '{$email}',
                  '{$phone}',
                  1,
                  '{$message}',
                  NOW()
                )
            ";
            $this->update($sql);


            if(strpos($phone, "+") !== false) $phone = $phone;
            else $phone = "82" . substr($phone, 1, strlen($phone));

            $sql = "SELECT `name` FROM tblNationLang WHERE nationId = '{$nationId}' AND lang = '{$langCode}'";
            $nation = $this->getValue($sql, "name");

            $type = "정기후원";
            $templateCode = "01_Share";
            $msg = "[바이블타임선교회] 안녕하세요. {$name}님! 귀한 섬김으로 성경을 보내주셔서 감사드립니다. *후원정보 {$nation} * 결제금액 {$type} / {$totalPrice} ▶ 문의: 1644-9159 ▶ www.BibleTime.org";
            $result = $this->sendKakao($phone, $msg, $templateCode);
            $res = json_decode($result);
            echo json_encode($res);

            if($res->code == "200") return $this->makeResultJson(1, "succ", $row["id"]);
            else return $this->makeResultJson(-2, "send fail");


            return $this->makeResultJson(1, "succ");
        }

        function getSummation($id){
            $sql = "
                SELECT SUM(`totalPrice`) total FROM tblSupport WHERE `parentId` = '{$id}'
            ";

            return $this->getValue($sql, "total");
        }
    }
}
