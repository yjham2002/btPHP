<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 22.
 * Time: PM 6:13
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
    $obj = new WebUser($_REQUEST);
    $info = $obj->customerInfo();
    //    echo json_encode($info);

    $userInfo = $info["userInfo"];
    $subscriptionInfo = $info["subscriptionInfo"];
    $supportInfo = $info["supportInfo"];

    if($_COOKIE["btLocale"] == "kr") {
        $currency = "₩";
        $decimal = 0;
    }
    else{
        $currency = "$";
        $decimal = 2;
    }
?>



<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
