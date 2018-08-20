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

        function supportDetail(){
            $id = $_REQUEST["id"];
            $locale = $_COOKIE["btLocale"];

            $sql = "
                SELECT * FROM tblSupportArticle
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

            $sql = "
                INSERT INTO tblSupport(`customerId`, `parentId`, `cnt`, `totalPrice`, `rName`, `rEmail`, `rPhone`, `payMethodId`, `regDate`)
                VALUES(
                  '{$customerId}',
                  '{$parentId}',
                  '{$cnt}',
                  '{$totalPrice}',
                  '{$name}',
                  '{$email}',
                  '{$phone}',
                  1,
                  NOW()
                )
            ";
            $this->update($sql);

            return $this->makeResultJson(1, "succ");
        }
    }
}
