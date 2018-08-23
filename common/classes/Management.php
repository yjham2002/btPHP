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



    }


}
