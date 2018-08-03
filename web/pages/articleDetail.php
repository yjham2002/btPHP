<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 5:49
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
        <h5 class="dirHelper">BibleTime 나눔 > 게시판명 > 게시글명</h5>
        <div class="articleWrapper align-left">
            <table class="alt white">
                <tr>
                    <td class="nanumGothic" style="width:3.2em;">
                        <div class="profileImage"><img src="/web/images/pic03.jpg" /></div>
                    </td>
                    <td>길동 홍</td>
                    <td style="text-align:right">
                        7일 전
                    </td>
                    <td class="smallIconTD" style="text-align:right">
                        <a href="#"><img src="/web/images/img_context.png" width=20 /></a>
                    </td>
                </tr>
            </table>
            <h2 class="nanumGothic">게시글 명입니다.</h2>
            <p class="nanumGothic">조회 3회 &nbsp; 댓글 0개</p>
            <h4 class="nanumGothic" style="color:black;">
                게시글 내용이 삽입됩니다.
                게시글 내용이 삽입됩니다.
                <div class="image fit"><img src="/web/images/testImage.png" /></div>
                게시글의 내용입니다.
                게시글의 내용입니다.
                게시글의 내용입니다.
            </h4>
        </div>
    </div>
</section>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
