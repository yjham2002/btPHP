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
            $paymentInfo = null;

            $sql = "
                SELECT *, (SELECT `name` FROM tblPublicationLang PL WHERE PL.publicationId = publicationId AND langCode = '{$userInfo["langCode"]}' LIMIT 1) publicationName 
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

        function setNotiFlag(){
            $id = $_REQUEST["id"];
            $flag = $_REQUEST["flag"];
            $sql = "UPDATE tblCustomer SET `notiFlag` = '{$flag}' WHERE `id` = '{$id}'";
            $this->update($sql);
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
            $sql = "SELECT * FROM tblCustomerHistory WHERE {$where} ORDER BY regDate ASC";
            return $this->makeResultJson(1, succ, $this->getArray($sql));
        }

        function upsertCustomer(){
            $historyIdArr = $_REQUEST["historyId"];
            $historyTypeArr = $_REQUEST["hType"];
            $historyContentArr = $_REQUEST["historyContent"];

//            echo json_encode($historyIdArr);
//            echo json_encode($historyTypeArr);
//            echo json_encode($historyContentArr);

            for($i=0; $i<sizeof($historyIdArr); $i++){
                $tmpId = $historyIdArr[$i] == "" ? "0" : $historyIdArr[$i];
                $sql = "
                    INSERT INTO tblCustomerHistory(`id`, `type`, `content`, `regDate`)
                    VALUES(
                      '{$tmpId}',
                      '{$historyTypeArr[$i]}',
                      '{$historyContentArr[$i]}',
                      NOW()
                    )
                    ON DUPLICATE KEY UPDATE
                    `type` = '{$historyTypeArr[$i]}',
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

            return $this->getArray($sql);
        }
    }
}
