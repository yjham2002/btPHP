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
    }
}