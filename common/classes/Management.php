<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 23.
 * Time: PM 1:45
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminBase.php" ;?>
<?
/*
 * Web process
 * add by cho
 * */
if(!class_exists("Management")){
    class Management extends  AdminBase {
        function __construct($req)
        {
            parent::__construct($req);
        }

        function customerList(){
            $searchType = $_REQUEST["searchType"];
            $searchText = $_REQUEST["searchText"];
            $where = "1=1";
            if($searchType == "name"){
                $where .= " AND `name` LIKE '%{$searchText}%'";
            }else if($searchType == "BO"){
                //TODO bank owner search
            }else if($searchType == "phone"){
                $where .= " AND `phone` LIKE '%{$searchText}%'";
            }else if($searchType == "email"){
                $where .= " AND `email` LIKE '%{$searchText}%'";
            }else if($searchType == "addr"){
                $where .= " AND (`addr` LIKE '%{$searchText}%' OR `addrDetail` LIKE '%{$searchText}%')";
            }

            $this->initPage();
            $sql = "SELECT COUNT(*) cnt FROM tblCustomer WHERE `status` = 1 AND {$where}";
            $this->rownum = $this->getValue($sql, "cnt");
            $this->setPage($this->rownum);

            $sql = "
                SELECT *
                FROM tblCustomer
                WHERE `status` = 1 AND {$where}
                LIMIT {$this->startNum}, {$this->endNum};
            ";
            return $this->getArray($sql);
        }

        function customerInfo(){
            $id = $_REQUEST["id"];

            $sql = "SELECT * FROM tblCustomer WHERE `id` = '{$id}' LIMIT 1";
            $userInfo = $this->getRow($sql);

            //TODO 결제 정보
            $sql = "
                SELECT *
                FROM(
                    SELECT PM1.id, cardTypeId, bankCode, ownerName, monthlyDate, PM1.type AS pmType, info, totalPrice, PM1.regDate, P1.regDate AS paymentDate, 'SUB' AS productType
                    FROM 
                    tblPayMethod PM1 JOIN tblPayment P1 ON PM1.`id` = P1.`payMethodId` JOIN tblSubscription SUB ON SUB.paymentId = P1.id
                    UNION ALL
                    SELECT PM2.id, cardTypeId, bankCode, ownerName, monthlyDate, PM2.type AS pmType, info, totalPrice, PM2.regDate, P2.regDate AS paymentDate, 'SUP' AS productType 
                    FROM tblPayMethod PM2 JOIN tblPayment P2 ON PM2.`id` = P2.`payMethodId` JOIN tblSupport SUP ON SUP.paymentId = P2.id
                ) tmp
                ORDER BY regDate DESC
            ";
            $paymentInfo = $this->getArray($sql);

            $sql = "
                SELECT 
                  S.*, PM.info, PM.type as pmType, 
                  (SELECT `name` FROM tblPublicationLang PL WHERE PL.publicationId = publicationId AND langCode = '{$userInfo["langCode"]}' LIMIT 1) publicationName,
                  (SELECT COUNT(*) FROM tblShipping S WHERE S.subsciptionId = id) lostCnt
                FROM tblSubscription S LEFT JOIN tblPayment P ON S.paymentId = P.id  LEFT JOIN tblPayMethod PM ON PM.id = P.payMethodId
                WHERE S.customerId = '{$id}' 
                ORDER BY S.regDate DESC
            ";
            $subscriptionInfo = $this->getArray($sql);

            $sql = "
                SELECT S.*, PM.info, PM.type as pmType, (SELECT `desc` FROM tblNationGroup WHERE `id` = (SELECT nationId FROM tblSupportParent WHERE `id` = S.parentId)) nation
                FROM tblSupport S LEFT JOIN tblPayment P ON S.paymentId = P.id LEFT JOIN tblPayMethod PM ON PM.id = P.payMethodId
                WHERE S.customerId = '{$id}'
                ORDER BY S.regDate DESC
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

        function setNotiFlag(){
            $id = $_REQUEST["id"];
            $flag = $_REQUEST["flag"];
            $sql = "UPDATE tblCustomer SET `notiFlag` = '{$flag}' WHERE `id` = '{$id}'";
            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

        function setCommercial(){
            $id = $_REQUEST["id"];
            $type = $_REQUEST["type"];
            $check = $_REQUEST["check"];

            $sql = "
                UPDATE tblCustomer SET `commercial{$type}` = '{$check}' WHERE `id` = {$id}
            ";
            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

        function updateSubscription(){
            $id = $_REQUEST["id"];
            $customerLang = $_REQUEST["customerLang"];
            $sql = "SELECT * FROM tblPublicationLang WHERE publicationId = '{$_REQUEST["publicationId"]}' AND langCode = '{$customerLang}' LIMIT 1";
            $publication = $this->getRow($sql);
            $totalPrice = -1;
            if($_REQUEST["cnt"] < 10)
                $totalPrice = $publication["price"] * $_REQUEST["cnt"];
            else
                $totalPrice = $publication["discounted"] * $_REQUEST["cnt"];

            $sql = "SELECT rName, rPhone, rZipCode, rAddr, rAddrDetail, publicationId, cnt, subType, shippingType, pYear, pMonth, eYear, eMonth, deliveryStatus FROM tblSubscription WHERE id='{$id}' LIMIT 1";
            $old = $this->getRow($sql);
            $sql = "
                INSERT INTO tblSubscription(id, customerId, publicationId, cnt, pYear, pMonth, eYear, eMonth, totalPrice, subType, shippingType, rName, rPhone, rZipCode, rAddr, rAddrDetail, deliveryStatus, regDate) 
                VALUES(
                  '{$id}',
                  '{$_REQUEST["customerId"]}',
                  '{$_REQUEST["publicationId"]}',
                  '{$_REQUEST["cnt"]}',
                  '{$_REQUEST["pYear"]}',
                  '{$_REQUEST["pMonth"]}',
                  '{$_REQUEST["eYear"]}',
                  '{$_REQUEST["eMonth"]}',
                  '{$totalPrice}',
                  '{$_REQUEST["subType"]}',
                  '{$_REQUEST["shippingType"]}',
                  '{$_REQUEST["rName"]}',
                  '{$_REQUEST["rPhone"]}',
                  '{$_REQUEST["rZipCode"]}',
                  '{$_REQUEST["rAddr"]}',
                  '{$_REQUEST["rAddrDetail"]}',
                  '{$_REQUEST["deliveryStatus"]}',
                  NOW()
                )
                ON DUPLICATE KEY UPDATE
                publicationId = '{$_REQUEST["publicationId"]}',
                cnt = '{$_REQUEST["cnt"]}',
                pYear = '{$_REQUEST["pYear"]}',
                pMonth = '{$_REQUEST["pMonth"]}',
                eYear = '{$_REQUEST["eYear"]}',
                eMonth = '{$_REQUEST["eMonth"]}',
                totalPrice = '{$totalPrice}',
                subType = '{$_REQUEST["subType"]}',
                shippingType = '{$_REQUEST["shippingType"]}',
                rName = '{$_REQUEST["rName"]}',
                rPhone = '{$_REQUEST["rPhone"]}',
                rZipCode = '{$_REQUEST["rZipCode"]}',
                rAddr = '{$_REQUEST["rAddr"]}',
                rAddrDetail = '{$_REQUEST["rAddrDetail"]}',
                deliveryStatus = '{$_REQUEST["deliveryStatus"]}'
            ";
            $this->update($sql);

            foreach(json_decode(json_encode($old), true) as $key => $value){
                if($value != $_REQUEST[$key]){
                    $tmp = "";
                    $result = "";
                    if($key == "rName") $tmp = "받는사람 변경";
                    if($key == "rPhone") $tmp = "받는사람 변경";
                    switch($key){
                        case "rName":
                            $tmp = "받는사람";
                            $result = $_REQUEST[$key];
                            break;
                        case "rPhone":
                            $tmp = "전화번호";
                            $result = $_REQUEST[$key];
                            break;
                        case "rZipCode":
                            $tmp = "우편번호";
                            $result = $_REQUEST[$key];
                            break;
                        case "rAddr":
                            $tmp = "주소";
                            $result = $_REQUEST[$key];
                            break;
                        case "rAddrDetail":
                            $tmp = "상세주소";
                            $result = $_REQUEST[$key];
                            break;
                        case "publicationId":
                            $tmp = "버전";
                            $sql = "SELECT `desc` FROM tblPublication WHERE id = '{$_REQUEST[$key]}'";
                            $result = $this->getValue($sql, "desc");
                            break;
                        case "cnt":
                            $tmp = "부수";
                            $result = $_REQUEST[$key];
                            break;
                        case "subType":
                            $tmp = "유형";
                            if($_REQUEST[$key] == "0") $result = "개인";
                            else if($_REQUEST[$key] == "1") $result = "단체";
                            else if($_REQUEST[$key] == "2") $result = "묶음배송";
                            else if($_REQUEST[$key] == "3") $result = "표지광고";
                            break;
                        case "shippingType":
                            $tmp = "배송";
                            $shippingType = $_REQUEST[$key];
                            $result = $_REQUEST[$key] == 0 ? "우편" : "택배";
                            break;
                        case "pYear":
                            $tmp = "시작월호(년)";
                            $result = $_REQUEST[$key];
                            break;
                        case "pMonth":
                            $tmp = "시작월호(월)";
                            $result = $_REQUEST[$key];
                            break;
                        case "eYear":
                            $tmp = "끝나는월호(년)";
                            $result = $_REQUEST[$key];
                            break;
                        case "eMonth":
                            $tmp = "끝나는월호(월)";
                            $result = $_REQUEST[$key];
                            break;
                        case "deliveryStatus":
                            $tmp = "상태";
                            if($_REQUEST[$key] == "0") $result = "정상";
                            if($_REQUEST[$key] == "1") $result = "취소";
                            if($_REQUEST[$key] == "2") $result = "발송보류";
                            break;
                    }

                    $sql = "
                    INSERT INTO tblCustomerHistory(modifier,`type`, content, regDate)
                    VALUES(
                      '{$this->admUser->account}',
                      'sub',
                      '{$tmp} 변경: {$result}',
                      NOW()
                    )
                ";
                    $this->update($sql);
                }
            }
            return $this->makeResultJson(1, "succ");
        }

        function updateSupport(){
            $id = $_REQUEST["id"];
            $sql = "SELECT `status`, rName, supType, sYear, sMonth, eYear, eMonth, assemblyName, totalPrice FROM tblSupport WHERE id='{$id}' LIMIT 1";
            $old = $this->getRow($sql);

            $sql = "
                UPDATE tblSupport SET
                    supType = '{$_REQUEST["supType"]}',
                    totalPrice = '{$_REQUEST["totalPrice"]}',
                    rName = '{$_REQUEST["rName"]}',
                    sYear = '{$_REQUEST["sYear"]}',
                    sMonth = '{$_REQUEST["sMonth"]}',
                    eYear = '{$_REQUEST["eYear"]}',
                    eMonth = '{$_REQUEST["eMonth"]}',
                    status = '{$_REQUEST["status"]}',
                    assemblyName = '{$_REQUEST["assemblyName"]}'
                WHERE `id` = '{$id}' 
            ";
            $this->update($sql);

            foreach(json_decode(json_encode($old), true) as $key => $value){
                if($value != $_REQUEST[$key]){
                    $tmp = "";
                    $result = "";
                    if($key == "rName") $tmp = "받는사람 변경";
                    if($key == "rPhone") $tmp = "받는사람 변경";
                    switch($key){
                        case "status":
                            $tmp = "상태";
                            if($_REQUEST[$key] == "0") $result = "정상";
                            if($_REQUEST[$key] == "1") $result = "취소";
                            break;
                        case "rName":
                            $tmp = "후원자명";
                            $result = $_REQUEST[$key];
                            break;
                        case "supType":
                            $tmp = "후원유형";
                            if($_REQUEST[$key] == "BTG") $result = "BTG";
                            else if($_REQUEST[$key] == "BTF") $result = "BTF";
                            break;
                        case "sYear":
                            $tmp = "시작년월(년)";
                            $result = $_REQUEST[$key];
                            break;
                        case "sMonth":
                            $tmp = "시작년월(월)";
                            $result = $_REQUEST[$key];
                            break;
                        case "eYear":
                            $tmp = "끝나는년월(년)";
                            $result = $_REQUEST[$key];
                            break;
                        case "eMonth":
                            $tmp = "끝나는년월(월)";
                            $result = $_REQUEST[$key];
                            break;
                        case "assemblyName":
                            $tmp = "후원집회명";
                            $result = $_REQUEST[$key];
                            break;
                        case "totalPrice":
                            $tmp = "가격";
                            $result = $_REQUEST[$key];
                    }
                    $sql = "
                    INSERT INTO tblCustomerHistory(modifier,`type`, content, regDate)
                    VALUES(
                      '{$this->admUser->account}',
                      'sup',
                      '{$tmp} 변경: {$result}',
                      NOW()
                    )
                ";
                    $this->update($sql);
                }
            }
            return $this->makeResultJson(1, "succ");
        }

        function historyData(){
            $typeArr = $_REQUEST["typeArr"];
            $where = "1=1";
            if($typeArr[0] != "all"){
                $where .= " AND(";
                foreach($typeArr as $item) {
                    if(!next($typeArr)) $where .= "`type` = '{$item}'";
                    else $where .= "`type` = '{$item}' OR";
                }
                $where .= ")";
            }
            $sql = "SELECT * FROM tblCustomerHistory WHERE {$where} ORDER BY id DESC";
            return $this->makeResultJson(1, succ, $this->getArray($sql));
        }

        function upsertCustomer(){
            $historyIdArr = $_REQUEST["historyId"];
            $historyTypeArr = $_REQUEST["hType"];
            $historyContentArr = $_REQUEST["historyContent"];
            $historyModifierArr = $_REQUEST["modifier"];

            for($i=0; $i<sizeof($historyIdArr); $i++){
                $tmpId = $historyIdArr[$i] == "" ? "0" : $historyIdArr[$i];
                $sql = "
                    INSERT INTO tblCustomerHistory(`id`, modifier, `type`, `content`, `regDate`)
                    VALUES(
                      '{$tmpId}',
                      '{$historyModifierArr[$i]}',
                      '{$historyTypeArr[$i]}',
                      '{$historyContentArr[$i]}',
                      NOW()
                    )
                    ON DUPLICATE KEY UPDATE
                    `type` = '{$historyTypeArr[$i]}',
                    `modifier` = '{$historyModifierArr[$i]}',
                    `content` = '{$historyContentArr[$i]}'
                ";
                $this->update($sql);
            }
            return $this->makeResultJson(1, "succ");
        }

        function addForeignPub(){
            $year = $_REQUEST["year"];
            $print = $_REQUEST["print"];
            $country = $_REQUEST["country"];
            $language = $_REQUEST["language"];
            $text = $_REQUEST["text"];

            $sql = "
              INSERT INTO tblForeignPub(`year`, `print`, `country`, `language`, `text`, regDate)
              VALUES(
                '{$year}',
                '{$print}',
                '{$country}',
                '{$language}',
                '{$text}',
                NOW()
              )
            ";
            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

        function foreignPubList(){
            $year = $_REQUEST["year"];
            $where = "1=1";
            if($year != "") $where .= " AND `year` = '{$year}'";
            $sql = "
                SELECT * FROM tblForeignPub WHERE {$where} ORDER BY regDate DESC
            ";
            $list = $this->getArray($sql);
            foreach($list as $i=>$item){
                $sql = "SELECT * FROM tblForeignPubItem WHERE `foreignPubId` = '{$item["id"]}' ORDER BY regDate ASC";
                $childList = $this->getArray($sql);
                $list[$i]["childList"] = $childList;
            }
            return $list;
        }

        function foreignPubInfo(){
            $id = $_REQUEST["parentId"];
            $sql = "SELECT * FROM tblForeignPub WHERE `id` = '{$id}' LIMIT 1";
            return $this->getRow($sql);
        }

        function foreignPubChild(){
            $id = $_REQUEST["id"];
            $sql = "
                SELECT * FROM tblForeignPubItem WHERE `id` = '{$id}' LIMIT 1
            ";
            return $this->getRow($sql);
        }

        function upsertForeignPubChild(){
            $fileArray = array();
            $parentId = $_REQUEST["parentId"];
            $id = $_REQUEST["id"] == "" ? 0 : $_REQUEST["id"];
            $printCharge = str_replace(",", "", $_REQUEST["printCharge"]);
            $deliveryCharge = str_replace(",", "", $_REQUEST["deliveryCharge"]);

            $dueDate1 = $_REQUEST["dueDate1"] == "" ? "NULL" : "'" . $_REQUEST["dueDate1"] . "'";
            $dueDate2 = $_REQUEST["dueDate2"] == "" ? "NULL" : "'" . $_REQUEST["dueDate2"] . "'";
            $dueDate3 = $_REQUEST["dueDate3"] == "" ? "NULL" : "'" . $_REQUEST["dueDate3"] . "'";
            $dueDate4 = $_REQUEST["dueDate4"] == "" ? "NULL" : "'" . $_REQUEST["dueDate4"] . "'";
            $dueDate5 = $_REQUEST["dueDate5"] == "" ? "NULL" : "'" . $_REQUEST["dueDate5"] . "'";

            for($i = 0; $i < 3; $i++) {
                $check = file_exists($_FILES['docFile'.($i+1)]['tmp_name']);
                $fileName = $_FILES["docFile".($i+1)]["name"];
                $filePath = $_REQUEST["filePath".($i+1)];

                if ($check !== false) {
                    $fName = $this->makeFileName() . "." . pathinfo(basename($_FILES["docFile".($i+1)]["name"]), PATHINFO_EXTENSION);
                    $targetDir = $this->filePath . $fName;
                    if (move_uploaded_file($_FILES["docFile".($i+1)]["tmp_name"], $targetDir)) $filePath = $fName;
                    else return $this->makeResultJson(-1, "fail");
                }else{
                    if($filePath != ""){
                        $fileName = $_REQUEST["fileName".($i+1)];
                    }else {
                        $fileName = "";
                        $filePath = "";
                    }
                }
                $fileArray[$i]["fileName"] = $fileName;
                $fileArray[$i]["filePath"] = $filePath;
            }

            $sql = "
                INSERT INTO tblForeignPubItem(`id`, `foreignPubId`, `nd`, `startMonth`, `endMonth`, `type`, `cnt`, `client`, `printCharge`, 
                `deliveryCharge`, `note`, `dueDate1`, `dueDate2`, `dueDate3`, `dueDate4`, `dueDate5`, `fileName1`, `filePath1`, `fileName2`, `filePath2`, 
                `fileName3`, `filePath3`, `regDate`)
                VALUES(
                  '{$id}',
                  '{$parentId}',
                  '{$_REQUEST["nd"]}',
                  '{$_REQUEST["startMonth"]}',
                  '{$_REQUEST["endMonth"]}',
                  '{$_REQUEST["type"]}',
                  '{$_REQUEST["cnt"]}',
                  '{$_REQUEST["client"]}',
                  '{$printCharge}',
                  '{$deliveryCharge}',
                  '{$_REQUEST["note"]}',
                  {$dueDate1},
                  {$dueDate2},
                  {$dueDate3},
                  {$dueDate4},
                  {$dueDate5},
                  '{$fileArray[0]["fileName"]}', '{$fileArray[0]["filePath"]}',
                  '{$fileArray[1]["fileName"]}', '{$fileArray[1]["filePath"]}',
                  '{$fileArray[2]["fileName"]}', '{$fileArray[2]["filePath"]}',
                  NOW()
                )
                ON DUPLICATE KEY UPDATE
                  `nd` = '{$_REQUEST["nd"]}',
                  `startMonth` = '{$_REQUEST["startMonth"]}',
                  `endMonth` = '{$_REQUEST["endMonth"]}',
                  `type` = '{$_REQUEST["type"]}',
                  `cnt` = '{$_REQUEST["cnt"]}',
                  `client` = '{$_REQUEST["client"]}',
                  `printCharge` = '{$printCharge}',
                  `deliveryCharge` = '{$deliveryCharge}',
                  `note` = '{$_REQUEST["note"]}',
                  `paymentFlag` = '{$_REQUEST["paymentFlag"]}',
                  `dueDate1` = {$dueDate1},
                  `dueDate2` = {$dueDate2},
                  `dueDate3` = {$dueDate3},
                  `dueDate4` = {$dueDate4},
                  `dueDate5` = {$dueDate5},
                  `fileName1` = '{$fileArray[0]["fileName"]}',
                  `filePath1` = '{$fileArray[0]["filePath"]}',
                  `fileName2` = '{$fileArray[1]["fileName"]}',
                  `filePath2` = '{$fileArray[1]["filePath"]}',
                  `fileName3` = '{$fileArray[2]["fileName"]}',
                  `filePath3` = '{$fileArray[2]["filePath"]}'
            ";
            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

        function changeFpubStatus(){
            $id = $_REQUEST["id"];
            $next = $_REQUEST["next"];

            $set = "";
            switch($next){
                case "1":
                    $set = ",`endDate1` = NOW()";
                    break;
                case "2":
                    $set = ",`endDate2` = NOW()";
                    break;
                case "3":
                    $set = ",`endDate3` = NOW()";
                    break;
                case "4":
                    $set = ",`endDate4` = NOW()";
                    break;
            }
            $sql = "
                UPDATE tblForeignPubItem
                SET
                  `manufactureFlag` = `manufactureFlag` + 1
                  {$set}
                WHERE 
                `id` IN (SELECT * FROM (SELECT `id` FROM tblForeignPubItem WHERE `id` = '{$id}' LIMIT 1) tmp)
            ";
            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

        function fPubChildList(){
            $this->initPage();
            $sql = "SELECT COUNT(*) cnt FROM tblForeignPubItem FPI JOIN tblForeignPub FP ON FPI.foreignPubId = FP.id";
            $this->rownum = $this->getValue($sql, "cnt");

            $this->setPage($this->rownum);

            $sql = "
                SELECT FPI.*, FP.country, FP.language, FP.year 
                FROM tblForeignPubItem FPI JOIN tblForeignPub FP ON FPI.foreignPubId = FP.id
                ORDER BY regDate DESC
                LIMIT {$this->startNum}, {$this->endNum};
            ";
            return $this->getArray($sql);
        }

        function changeFpubFlag(){
            $id = $_REQUEST["id"];
            $flag = $_REQUEST["flag"];
            $sql = "
                UPDATE tblForeignPubItem 
                SET `paymentFlag` = '{$flag}'
                WHERE `id` = '{$id}'
            ";
            $this->update($sql);
            return $this->makeResultJson(1, "succ");
        }

        function storePublication(){
            $adminId = $this->admUser->id;
            $shippingType = $_REQUEST["shippingType"];
            $shippingCo = $_REQUEST["shippingCo"];
            $shippingPrice = str_replace(",", "", $_REQUEST["shippingPrice"]);

            $publicationIdArr = $_REQUEST["publicationId"];
            $typeArr = $_REQUEST["type"];
            $cntArr = $_REQUEST["cnt"];
            $pYearArr = $_REQUEST["pYear"];
            $pMonthArr = $_REQUEST["pMonth"];
            $contentArr = $_REQUEST["content"];

            for($i=0; $i<sizeof($publicationIdArr); $i++){
                $sql = "
                    INSERT INTO tblWarehousing(`publicationId`, `adminId`, `shippingType`, `shippingCo`, `shippingPrice`, `type`, `cnt`, `pYear`, `pMonth`,
                    `content`, `regDate`)
                    VALUES(
                      '{$publicationIdArr[$i]}',
                      '{$adminId}',
                      '{$shippingType}',
                      '{$shippingCo}',
                      '{$shippingPrice}',
                      '{$typeArr[$i]}',
                      '{$cntArr[$i]}',
                      '{$pYearArr[$i]}',
                      '{$pMonthArr[$i]}',
                      '{$contentArr[$i]}',
                      NOW()
                    )
                ";
                $this->update($sql);
            }
            return $this->makeResultJson(1, "succ");
        }

        function stockHistory(){
            $startDate = $_REQUEST["startDate"];
            $endDate = $_REQUEST["endDate"];

            $year = $_REQUEST["year"];
            $month = $_REQUEST["month"];
            $where = "pYear = '{$year}' AND pMonth = '{$month}'";

            $sql = "SELECT COUNT(*) cnt FROM tblWarehousing WHERE {$where}";
            $this->initPage();
            $this->rownum = $this->getValue($sql, "cnt");
            $this->setPage($this->rownum);

            $sql = "
                SELECT 
                  *, 
                  (SELECT `desc` FROM tblPublication WHERE `id` = publicationId) publicationName,
                  (SELECT `name` FROM tblAdmin WHERE tblAdmin.id = adminId) adminName
                FROM tblWarehousing
                WHERE {$where}
                ORDER BY regDate DESC
                LIMIT {$this->startNum}, {$this->endNum};
            ";
            return $this->getArray($sql);
        }

        function stockStat(){
            $startYear = $_REQUEST["startYear"];
            $startMonth = $_REQUEST["startMonth"];
            $endYear = $_REQUEST["endYear"];
            $endMonth = $_REQUEST["endMonth"];

            $sql = "
                SELECT *, SUM(cnt) AS summation
                FROM tblWarehousing
                WHERE 
                1=1
            ";
            if($startYear != ""){
                if($startMonth == "") $startMonth = 1;
                $sql .= "
                AND CASE
                  WHEN pYear = {$startYear} THEN pMonth >= {$startMonth}
                  WHEN pYear < {$startYear} THEN pYear > {$startYear}
                  WHEN pYear > {$startYear} THEN 1=1   
                  ELSE 1=1
                END
                ";
            }
            if($endYear != ""){
                if($endMonth == "") $endMonth = 1;
                $sql .= "
                AND CASE
                  WHEN pYear = {$endYear} THEN pMonth <= {$endMonth}
                  WHEN pYear < {$endYear} THEN 1=1
                  WHEN pYear > {$endYear} THEN pYear < {$endYear}
                  ELSE 1=1
                END
                ";
            }
            $sql .= "GROUP BY pYear, pMonth, publicationId ORDER BY pYear DESC, pMonth DESC";
            return $this->getArray($sql);
        }

        function stockDetail(){
            $year = $_REQUEST["year"];
            $month = $_REQUEST["month"];

            $sql = "
                SELECT 
                  *
                FROM tblPublication 
                ORDER BY regDate DESC
            ";
            $pubList = $this->getArray($sql);

            $sql = "
                SELECT *, SUM(cnt) AS summation
                FROM tblWarehousing
                WHERE pYear = '{$year}' AND pMonth = '{$month}'
                GROUP BY publicationId, `type` 
            ";
            $stat = $this->getArray($sql);

            for($i=0; $i<sizeof($pubList); $i++){
                for($e=0; $e<sizeof($stat); $e++){
                    if($pubList[$i]["id"] == $stat[$e]["publicationId"]){
                        $pubList[$i]["stat"][intval($stat[$e]["type"])] = $stat[$e]["summation"];
                    }
                }
            }
            return $pubList;
        }

        function shippingList($type){
            $sql = "
                SELECT 
                  S.*, 
                  (SELECT `desc` FROM tblPublication WHERE id = S.publicationId) publicationName,
                  (SELECT COUNT(*) FROM tblShipping WHERE subsciptionId = S.subsciptionId) lostCnt,
                  SUB.pYear,
                  SUB.pMonth,
                  SUB.eYear,
                  SUB.eMonth
                FROM tblShipping S JOIN tblSubscription SUB ON S.subsciptionId = SUB.id
                WHERE S.shippingType = '{$type}' AND `status` = '1' 
                ORDER BY regDate DESC
            ";
            return $this->getArray($sql);
        }

        function cardTypeList(){
            $sql = "
                SELECT * FROM tblCardType ORDER BY `id` ASC
            ";
            return $this->getArray($sql);
        }

        function bankTypeList(){
            $sql = "
                SELECT * FROM tblBankType ORDER BY `id` ASC
            ";
            return $this->getArray($sql);
        }

        function transactionList(){
            $type = $_REQUEST["type"];
            $month = $_REQUEST["month"];
            $customerType = $_REQUEST["customerType"];

            if($month != "")
                $where = " AND pMonth = '{$month}'";

            if($type == "sub"){
                $sql = "
                    SELECT * FROM tblSubscription WHERE 1=1 {$where} ORDER BY regDate DESC
                ";
            }
            else if($type == "sup"){
                $sql = "
                    SELECT * FROM tblSupport WHERE 1=1 {$where} ORDER BY regDate DESC
                ";
            }

            return $this->getArray($sql);
        }

        function lostList(){
            $id = $_REQUEST["id"];

            $sql = "
                SELECT *, (SELECT `name` FROM tblPublicationLang PL WHERE PL.publicationId = S.publicationId AND langCode = 'kr' LIMIT 1) publicationName 
                FROM tblSubscription S
                WHERE `customerId` = '{$id}' 
                ORDER BY regDate DESC
            ";
            return $this->getArray($sql);
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
                      'SYSTEM',
                      NOW()
                    )
                ";
                $this->update($sql);
                $index++;
            }
            return $this->makeResultJson(1, "succ");
        }

        function setWarehousing(){
            $type = $_REQUEST["type"];
            $list = json_decode($_REQUEST["list"], true);
            $sPrice = 0;
            if($type == "1") $sPrice = 2000;
            foreach($list as $item){
                $cnt = intval($item["cnt"]) * -1;
                $sql = "
                    INSERT INTO tblWarehousing(`publicationId`, `adminId`, `shippingType`, `shippingCo`, `shippingPrice`, `type`, `cnt`, `pYear`, `pMonth`, `content`, `regDate`)
                    VALUES(
                      '{$item["publicationId"]}',
                      '{$this->admUser->id}',
                      '{$type}',
                      '',
                      '{$sPrice}',
                      '1',
                      '{$cnt}',
                      '{$item["pYear"]}',
                      '{$item["pMonth"]}',
                      '',
                      NOW()
                    )
                ";
                $this->update($sql);

                $sql = "
                    UPDATE tblShipping SET `status` = 0 WHERE id = '{$item["id"]}'
                ";
                $this->update($sql);
            }
            return $this->makeResultJson(1, "succ");
        }
    }
}
