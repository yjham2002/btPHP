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
            $this->initPage();
            $sql = "SELECT COUNT(*) cnt FROM tblCustomer";
            $this->rownum = $this->getValue($sql, "cnt");
            $this->setPage($this->rownum);

            $sql = "
                SELECT *
                FROM tblCustomer
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
    }
}
