<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 8.
 * Time: PM 2:49
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebBase.php" ;?>
<?
if(!class_exists("WebSubscription")){
    class WebSubscription extends  WebBase {

        function __construct($req)
        {
            parent::__construct($req);
        }

        function publicationList(){
            $langCode = $_COOKIE["btLocale"];

            $sql = "
                SELECT * 
                FROM tblPublicationLang 
                WHERE `langCode` = '{$langCode}' AND `exposure` = 1 
                ORDER BY regDate DESC;
            ";
            return $this->getArray($sql);
        }

        function publicationDetail(){
            $id = $_REQUEST["id"];
            $langCode = $_COOKIE["btLocale"];

            $sql = "
                SELECT *
                FROM tblPublicationLang
                WHERE `publicationId` = '{$id}' AND `langCode` = '{$langCode}'
                LIMIT 1
            ";
            return $this->getRow($sql);
        }

        function setSubscriptionInfo(){
            $phone = $_REQUEST["phone"];
            $email = $_REQUEST["email"];
            $name = $_REQUEST["name"];
            $zipcode = $_REQUEST["zipcode"];
            $addr = $_REQUEST["addr"];
            $addrDetail = $_REQUEST["addrDetail"];
            $langCode = $_COOKIE["btLocale"];
            $phoneFlag = $_REQUEST["isPhone"] ? "1" : "0";

            $customerId = -1;

            $sql = "SELECT * FROM tblCustomer WHERE email = '{$email}' LIMIT 1";
            $member = $this->getRow($sql);
            if($member == ""){
                $sql = "
                    INSERT INTO tblCustomer(`name`, `phone`, `email`, `zipcode`, `addr`, `addrDetail`, `langCode`, `phoneFlag`, `regDate`)
                    VALUES(
                      '{$name}',
                      '{$phone}',
                      '{$email}',
                      '{$zipcode}',
                      '{$addr}',
                      '{$addrDetail}',
                      '{$langCode}',
                      '{$phoneFlag}',
                      NOW()
                    )
                ";
                $this->update($sql);

                $customerId = $this->mysql_insert_id();
            }else $customerId = $member["id"];

            $publicationId = $_REQUEST["publicationId"];
            $publicationCnt = $_REQUEST["publicationCnt"];
            $isGift = $_REQUEST["isGift"] ? "1" : "0";
            $rName = $_REQUEST["rName"];

            //TODO paymethod/payment info insert
            $payMethodId = 0;

            $sql = "
                INSERT INTO tblSubscription(`customerId`, `publicationId`, `cnt`, `isGift`, `rName`, `zipcode`, `addr`, `addrDetail`, `payMethodId`, `regDate`)
                VALUES(
                  '{$customerId}',
                  '{$publicationId}',
                  '{$publicationCnt}',
                  '{$isGift}',
                  '{$rName}',
                  '{$zipcode}',
                  '{$addr}',
                  '{$addrDetail}',
                  '{$payMethodId}',
                  NOW()
                )
            ";
            $this->update($sql);

            return $this->makeResultJson(1, "succ");
        }
    }
}