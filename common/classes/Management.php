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


    }
}
