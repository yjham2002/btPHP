<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 5:18
 */
?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Uncallable.php";?>
<?
$uc = new Uncallable($_REQUEST);
$link_fb = $uc->getProperty("URL_FACEBOOK");
$link_ig = $uc->getProperty("URL_INSTAGRAM");
$link_kakao = $uc->getProperty("URL_KAKAO");
$link_info = $uc->getPropertyLoc("URL_INFO", $country_code);
?>

<div class="footerRibbon">
    <ul class="icons">
        <li><a href="<?=$link_kakao?>" target="_blank" class="iconT"><img src="/web/images/icon_kakao.png" alt="Pic 02" /></a></li>
        <li><a href="<?=$link_fb?>" target="_blank" class="iconT"><img src="/web/images/icon_facebook.png" alt="Pic 02" /></a></li>
        <li><a href="<?=$link_ig?>" target="_blank" class="iconT"><img src="/web/images/icon_instagram.png" alt="Pic 02" /></a></li>
    </ul>
</div>

<!-- Footer -->
<footer id="footer">
    <div class="inner">
        <div class="regInfo">
            <?=$link_info?>
        </div>
        <div class="flex">

        </div>

    </div>
</footer>

</body>
</html>
