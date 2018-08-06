<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 6:08
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
<section class="wrapper special books">
    <div class="inner">
        <h5 class="dirHelper"><?=$SHARE_ELEMENTS["title"]?></h5>
        <header>
            <h2 class="pageTitle"><?=$SHARE_ELEMENTS["title"]?></h2>
            <div class="empLineT"></div>
            <h3 class="pageSubTitle"><?=$SHARE_ELEMENTS["subTitle"]?></h3>
        </header>
        <div class="table-wrapper white">
            <table class="alt white">
                <tbody>
                <tr>
                    <td colspan="2">
                        <a href="/web/pages/articleList.php?order=0">
                            <p><?=$SHARE_ELEMENTS["notice"]["title"]?></p>
                            <?=$SHARE_ELEMENTS["notice"]["subTitle"]?>
                        </a>
                    </td>
                    <td>0<br/><?=$SHARE_ELEMENTS["common"]["viewText"]?></td>
                    <td>5<br/><?=$SHARE_ELEMENTS["common"]["articleText"]?></td>
                    <td style="text-align:center;">
                        <a><img src="/web/images/img_context.png" width="20px"/></a>
                    </td>
                </tr>
                <tr>
                    <td width="10%">
                        <img src="/web/images/donate_img_01.png"/>
                    </td>
                    <td width="50%">
                        <a href="/web/pages/articleList.php?order=1">
                            <p><?=$SHARE_ELEMENTS["img"]["title"]?></p>
                            <?=$SHARE_ELEMENTS["img"]["subTitle"]?>
                        </a>
                    </td>
                    <td width="15%">0<br/><?=$SHARE_ELEMENTS["common"]["viewText"]?></td>
                    <td width="15%">5<br/><?=$SHARE_ELEMENTS["common"]["articleText"]?></td>
                    <td width="10%" style="text-align:center;">
                        <a><img src="/web/images/img_context.png" width="20px"/></a>
                    </td>
                </tr>
                <tr>
                    <td width="10%">
                        <img src="/web/images/donate_img_02.png"/>
                    </td>
                    <td width="50%">
                        <a href="/web/pages/articleList.php?order=2">
                            <p><?=$SHARE_ELEMENTS["video"]["title"]?></p>
                            <?=$SHARE_ELEMENTS["video"]["subTitle"]?>
                        </a>
                    </td>
                    <td width="15%">0<br/><?=$SHARE_ELEMENTS["common"]["viewText"]?></td>
                    <td width="15%">5<br/><?=$SHARE_ELEMENTS["common"]["articleText"]?></td>
                    <td width="10%" style="text-align:center;">
                        <a><img src="/web/images/img_context.png" width="20px"/></a>
                    </td>
                </tr>
                <tr>
                    <td width="10%">
                        <img src="/web/images/donate_img_03.png"/>
                    </td>
                    <td width="50%">
                        <a href="/web/pages/articleList.php?order=3">
                            <p><?=$SHARE_ELEMENTS["quiz"]["title"]?></p>
                            <?=$SHARE_ELEMENTS["quiz"]["subTitle"]?>
                        </a>
                    </td>
                    <td width="15%">0<br/><?=$SHARE_ELEMENTS["common"]["viewText"]?></td>
                    <td width="15%">5<br/><?=$SHARE_ELEMENTS["common"]["articleText"]?></td>
                    <td width="10%" style="text-align:center;">
                        <a><img src="/web/images/img_context.png" width="20px"/></a>
                    </td>
                </tr>
                <tr>
                    <td width="10%">
                        <img src="/web/images/donate_img_04.png"/>
                    </td>
                    <td width="50%">
                        <a href="/web/pages/articleList.php?order=4">
                            <p><?=$SHARE_ELEMENTS["audio"]["title"]?></p>
                            <?=$SHARE_ELEMENTS["audio"]["subTitle"]?>
                        </a>
                    </td>
                    <td width="15%">0<br/><?=$SHARE_ELEMENTS["common"]["viewText"]?></td>
                    <td width="15%">5<br/><?=$SHARE_ELEMENTS["common"]["articleText"]?></td>
                    <td width="10%" style="text-align:center;">
                        <a><img src="/web/images/img_context.png" width="20px"/></a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
