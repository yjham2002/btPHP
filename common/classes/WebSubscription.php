<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 8.
 * Time: PM 2:49
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebBase.php" ;?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Uncallable.php" ;?>
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
            $uc = new Uncallable($_REQUEST);
            $flag = $uc->getProperty("FLAG_VALUE_LOST");

            $type = $_REQUEST["type"];

            $customerId = $_REQUEST["customerId"];
            $phone = $_REQUEST["phone"];
            $email = $_REQUEST["email"];
            $name = $_REQUEST["name"];
            $zipcode = $_REQUEST["zipcode"];
            $addr = $_REQUEST["addr"];
            $addrDetail = $_REQUEST["addrDetail"];
            $langCode = $_COOKIE["btLocale"];

            $cName = $_REQUEST["cName"];
            $cPhone = $_REQUEST["cPhone"];
            $rank = $_REQUEST["rank"];

            if($customerId == ""){
                $sql = "
                    INSERT INTO tblCustomer(`type`, `name`, `phone`, `email`, `zipcode`, `addr`, `addrDetail`, `langCode`, `cName`, `cPhone`, `rank`, `regDate`)
                    VALUES(
                      '{$type}',
                      '{$name}',
                      '{$phone}',
                      '{$email}',
                      '{$zipcode}',
                      '{$addr}',
                      '{$addrDetail}',
                      '{$langCode}',
                      '{$cName}',
                      '{$cPhone}',
                      '{$rank}',
                      NOW()
                    )
                ";
                $this->update($sql);
                $customerId = $this->mysql_insert_id();
            }

            $publicationId = $_REQUEST["publicationId"];
            $publicationCnt = $_REQUEST["publicationCnt"];
            $rName = $_REQUEST["rName"];
            $rPhone = $_REQUEST["rPhone"];
            $rZipcode = $_REQUEST["rZipcode"];
            $rAddr = $_REQUEST["rAddr"];
            $rAddrDetail = $_REQUEST["rAddrDetail"];
            $totalPrice = $_REQUEST["totalPrice"];

            if($type == "2"){
                $rName = $name;
                $rPhone = $phone;
                $rZipcode = $zipcode;
                $rAddr = $addr;
                $rAddrDetail = $addrDetail;
            }

            //TODO paymethod/payment info insert
            $payMethodId = 0;

            $publicationName = $_REQUEST["publicationName"];
            $curYear = intval(date("Y"));
            $curMonth = intval(date("m"));
            $curDate = intval(date("d"));
            $templateCode = "";
            $temp = "";
            if($curDate < 10){
                $curMonth++;
                $templateCode = "04_Delivery";
                $temp = 25;
            }
            else if($curDate >= 10 && $curDate <=20){
                $curMonth++;
                $templateCode = "02_Delivery";
                $temp = 30;
            }
            else if($curDate >=21 && $curDate <= 25){
                $curMonth++;
                $templateCode = "03_Delivery";
                $temp = 10;
            }
            else if($curDate > 25){
                $curMonth = $curMonth + 2;
                $templateCode = "04_Delivery";
                $temp = 25;
            }

            if($curMonth > 12){
                $curYear++;
                $curMonth = $curMonth - 12;
            }
            $pYear = $curYear;
            $pMonth = $curMonth;
            $msg = "[바이블타임선교회] 주문하신 상품이 정상 처리 되었습니다. ▶ 상품명: {$publicationName} {$curMonth} ▶ 결제금액: {$totalPrice} {$temp}일까지 도착하지 않을 시, 연락주세요. ▶ 문의: 1644-9159 ▶ www.BibleTime.org";

            if(strpos($phone, "+") !== false) $phone = $phone;
            else $phone = "82" . substr($phone, 1, strlen($phone));


            $result = $this->sendKakao($phone, $msg, $templateCode);
            $shippingType = 0;
            if($publicationCnt >= 10) $shippingType = 1;

            $sql = "
                INSERT INTO tblSubscription(`customerId`, `publicationId`, `cnt`, `pYear`, `pMonth`, `totalPrice`, `shippingType`, `rName`, `rPhone`, `rZipcode`, `rAddr`, `rAddrDetail`, `payMethodId`, `regDate`)
                VALUES(
                  '{$customerId}',
                  '{$publicationId}',
                  '{$publicationCnt}',
                  '{$pYear}',
                  '{$pMonth}',
                  '{$totalPrice}',
                  '{$shippingType}',
                  '{$rName}',
                  '{$rPhone}',
                  '{$rZipcode}',
                  '{$rAddr}',
                  '{$rAddrDetail}',
                  '{$payMethodId}',
                  NOW()
                )
            ";
            $this->update($sql);
            $subscriptionId = $this->mysql_insert_id();

            if($flag == 1){
                $sql = "
                    INSERT INTO tblShipping(customerId, subsciptionId, rName, `type`, zipcode, phone, addr, addrDetail, publicationId, cnt, pYear, pMonth, shippingType, manager, regDate)
                    VALUES(
                      '{$customerId}',
                      '{$subscriptionId}',
                      '{$rName}',
                      '0',
                      '{$rZipcode}',
                      '{$rPhone}',
                      '{$rAddr}',
                      '{$rAddrDetail}',
                      '{$publicationId}',
                      '{$publicationCnt}',
                      '{$pYear}',
                      '{$pMonth}',
                      '{$shippingType}',
                      'SYSTEM',
                      NOW()
                    )
                ";

                $this->update($sql);
            }

            return $this->makeResultJson(1, "succ");
        }
    }
}