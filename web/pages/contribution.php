<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 6:06
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
$obj = new webUser($_REQUEST);
?>
<script>
    $(document).ready(function(){

    });
</script>
<div class="image fit">
    <img src="/web/images/contribution_main.jpg" />
</div>

<section class="wrapper special">
    <div class="inner">
        <div class="row">
            <!-- Break -->
            <div class="3u 12u$(medium)">
                <h2><?=$SUPPORT_ELEMENTS["article"]["title"]?></h2>
            </div>
            <div class="6u 12u$(medium)">
                <p class="align-left">
                    <?=$SUPPORT_ELEMENTS["article"]["text"]?>
                </p>
                <div class="box alt">
                    <div class="row 50% uniform">
                        <div class="4u"><span class="image fit"><img src="/web/images/con_01.png" alt="" /></span></div>
                        <div class="4u"><span class="image fit"><img src="/web/images/con_02.png" alt="" /></span></div>
                        <div class="4u"><span class="image fit"><img src="/web/images/con_03.png" alt="" /></span></div>
                    </div>
                </div>
            </div>
            <div class="3u$ 12u$(medium)">
                <a href="#"><img class="circleBtn" src="/web/images/btn_detail.png" /></a>
                <a href="#"><img class="circleBtn" src="/web/images/btn_support.png" /></a>
            </div>
        </div>
    </div>

</section>

<!-- Three -->
<section class="wrapper special slim">
    <h2><?=$SUPPORT_ELEMENTS["phrase"]?></h2>
    <div class="image fit slim">
        <img src="/web/images/contribution_bot.jpg" />
    </div>
</section>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
