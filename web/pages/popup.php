<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 2:09
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Uncallable.php";?>
<?
$objm = new AdminMain($_REQUEST);

$uc = new Uncallable($_REQUEST);

$CONST_PREFIX_IMAGE = "S_POPUP_IMG_";

$imageList = $uc->getProperties($CONST_PREFIX_IMAGE, "#");

$static_addr = $uc->getProperty("STATIC_POPUP");
$flag = $uc->getProperty("FLAG_VALUE_POPUP_SHOW");

?>
<div class="row">
    <? for($e = 0; $e < sizeof($imageList); $e++){
        $item = $imageList[$e];
        if($item["value"] == "") continue;
        ?>

        <img class="jImg" src="<?=$item["value"] != "" ? $objm->fileShowPath . $item["value"] : ""?>" width="100%;"/>

    <? } ?>
</div>
<h5><?=$static_addr?></h5>