<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 2:09
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<?
$objm = new AdminMain($_REQUEST);

$toShow = $objm->getLangJsonStatic($_COOKIE["btLocale"]);
$content = json_decode($toShow["json"], true);

switch ($_REQUEST["type"]){
    case "pr":
        $cd = "privacy_text_service";
        break;
    case "po":
        $cd = "policy_text_service";
        break;
}

?>

<div>
    <?=$content[$cd]?>
</div>