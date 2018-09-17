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
<?// include $_SERVER["DOCUMENT_ROOT"] . "/web/abroad/billing.php" ;?>
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
            $monthlyDate = 5;
            if($type == "2"){
                $rName = $name;
                $rPhone = $phone;
                $rZipcode = $zipcode;
                $rAddr = $addr;
                $rAddrDetail = $addrDetail;
                $monthlyDate = 15;
            }

            //TODO paymethod/payment info insert
            $paymentType = $_REQUEST["paymentType"];
            $isOwner = $_REQUEST["isOwner"];
            $ownerName = $_REQUEST["ownerName"];
            $cardTypeId = $_REQUEST["cardType"] == "" ? -1 : $_REQUEST["cardType"];
            $bankCode = $_REQUEST["bankType"];
            $info = $_REQUEST["info"];
            $validThruYear = $_REQUEST["validThruYear"];
            $validThruMonth =  $_REQUEST["validThruMonth"];

            $aSubsciptionId = "";
            $aCustomerProfileId = "";
            $paymentResult = 0;

            $primeJumin = $_REQUEST["birth"];
            $primeSigPath = "";
            $primeIndex = -1;



            if($paymentType == "CC"){
                $info = $_REQUEST["card1"] . $_REQUEST["card2"] .$_REQUEST["card3"] .$_REQUEST["card4"];
//                $paymentResult = 1;
            }
            if($paymentType == "BA"){
                $check = file_exists($_FILES['signatureFile']['tmp_name']);
                if($check !== false){
                    $fName = "bt" . $this->makeFileName() . "." . "jpg";
                    $targetDir = $_SERVER["DOCUMENT_ROOT"]."/uploadFiles/" . $fName;
                    $fileName = $fName;
                    if(move_uploaded_file($_FILES["signatureFile"]["tmp_name"], $targetDir)){
                        //TODO prime member row add
                        //TODO prime agreefile row add

                        $tmpTimestamp  = "bt" . $this->makeFileName();
                        $tmpSdate = date("Y") . "-" . date("m");
                        $primeIndex = $this->addPrime(
                            $tmpTimestamp,
                            $_REQUEST["rName"],
                            $_REQUEST["bankType"] . "0000",
                            $_REQUEST["info"],
                            $_REQUEST["rName"],
                            $primeJumin,
                            $tmpSdate,
                            $monthlyDate,
                            $totalPrice
                            );
                        $primeIndex = str_pad($primeIndex, 10, '0', STR_PAD_LEFT);
                        $this->ftpUpload($fName);

                        $tmpSdate = date("Y").date("m").date("d");
                        $this->addAgreeFile(
                            $primeIndex,
                            $tmpTimestamp,
                            $_REQUEST["bankType"],
                            $_REQUEST["info"],
                            $tmpSdate,
                            1,
                            $fName,
                            2
                        );

                        $primeSigPath = $fName;
                    }
                    else return $this->makeResultJson(-22, "signature upload fail");
                }
            }
            if($paymentType == "FC"){
                $info = $_REQUEST["cardForeign"];
                $validThruYear = $_REQUEST["validThruYearF"];
                $validThruMonth = $_REQUEST["validThruMonthF"];
                $monthlyDate = 15;
                /**
                 * Parameters
                 */
                $subscriptionName = "";
                $startDate = date("Y") . "-" . date("m") . "-" . "15";
                $totalOccurrences = "9999";
                $trialOccurrences = "";
                $amount = $totalPrice;
                $unit = "months";
                $trialAmount = "";
                $cardNo = $info;
                $cardExpiry = $validThruYear."-".$validThruMonth;
                $FirstName = $_REQUEST["firstName"];
                $LastName = $_REQUEST["lastName"];
                $intervalLength = "1";

                $address = $_REQUEST["aAddr"];
                $city = $_REQUEST["aCity"];
                $state = $_REQUEST["aState"];
                $zip = $_REQUEST["aZip"];
                /**
                 * End
                 */

                $payRes = $this->sendAuthrizeSubscription(
                    $subscriptionName,
                    $startDate,
                    $totalOccurrences,
                    $amount,
                    $unit,
                    $cardNo,
                    $cardExpiry,
                    $FirstName,
                    $LastName,
                    $intervalLength,
                    $address,
                    $city,
                    $state,
                    $zip
                );

                $returnCode = $payRes->messages->message[0]->code;
                $paymentId = -1;

                if($returnCode == "I00001"){
                    $aSubsciptionId = $payRes->subscriptionId;
                    $aCustomerProfileId = $payRes->profile->customerProfileId;
                    $paymentResult = 1;
                }
                else return $this->makeResultJson(-1, "payment failure");
            }

            $sql = "
              INSERT INTO tblPayment(`buyType`, `type`, monthlyDate, primeJumin, primeSigPath, primeIndex, `aSubscriptionId`, `aCustomerProfileId`, paymentResult, regDate)
              VALUES(
                'SUB',
                '{$paymentType}',
                '{$monthlyDate}',
                '{$primeJumin}',
                '{$primeSigPath}',
                '{$primeIndex}',
                '{$aSubsciptionId}',
                '{$aCustomerProfileId}',
                '{$paymentResult}',
                NOW()
              )
            ";
            $this->update($sql);
            $paymentId = $this->mysql_insert_id();

            $sql = "
                INSERT INTO tblPayMethod(customerId, isOwner, cardTypeId, bankCode, ownerName, `type`, info, aFirstname, aLastname, aAddr, aCity, aState, aZip, validThruYear, validThruMonth, regDate)
                VALUES(
                  '{$customerId}',
                  '{$isOwner}',
                  '{$cardTypeId}',
                  '{$bankCode}',
                  '{$ownerName}',
                  '{$paymentType}',
                  '{$info}',
                  '{$_REQUEST["firstName"]}',
                  '{$_REQUEST["lastName"]}',
                  '{$_REQUEST["aAddr"]}',
                  '{$_REQUEST["aCity"]}',
                  '{$_REQUEST["aState"]}',
                  '{$_REQUEST["aZip"]}',
                  '{$validThruYear}',
                  '{$validThruMonth}',
                  NOW()
                )
            ";
            $this->update($sql);
            $payMethodId = $this->mysql_insert_id();

            $sql = "
                UPDATE tblPayment SET payMethodId = '{$payMethodId}' WHERE `id` = {$paymentId}
            ";
            $this->update($sql);

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
                INSERT INTO tblSubscription(`customerId`, `publicationId`, `cnt`, `pYear`, `pMonth`, `totalPrice`, `shippingType`, `rName`, `rPhone`, `rZipcode`, `rAddr`, `rAddrDetail`, `paymentId`, `regDate`)
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
                  '{$paymentId}',
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