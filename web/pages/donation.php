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
        <h5 class="dirHelper">BibleTime 나눔</h5>
        <header>
            <h2 class="pageTitle">BibleTime 나눔</h2>
            <div class="empLineT"></div>
            <h3 class="pageSubTitle">BibleTime을 활용할 수 있는 다양한 자료를 제공해드립니다.</h3>
        </header>
        <div class="table-wrapper white">
            <table class="alt white">
                <tbody>
                <tr>
                    <td colspan="2">
                        <a href="/web/pages/articleList.html"><p>공지사항</p></a></td>
                    <td>0<br/>조회</td>
                    <td>5<br/>게시물</td>
                    <td style="text-align:center;">
                        <a><img src="/web/images/img_context.png" width="20px"/></a>
                    </td>
                </tr>
                <tr>
                    <td width="10%">
                        <img src="/web/images/donate_img_01.png"/>
                    </td>
                    <td width="50%">
                        <a href="/web/pages/articleList.html">
                            <p>이미지</p>
                            포스터, 현수막 등 다양한 이미지를 제공해드립니다.
                        </a>
                    </td>
                    <td width="15%">0<br/>조회</td>
                    <td width="15%">5<br/>게시물</td>
                    <td width="10%" style="text-align:center;">
                        <a><img src="/web/images/img_context.png" width="20px"/></a>
                    </td>
                </tr>
                <tr>
                    <td width="10%">
                        <img src="/web/images/donate_img_02.png"/>
                    </td>
                    <td width="50%">
                        <a href="/web/pages/articleList.html">
                            <p>영상</p>
                            성경 읽기를 효과적으로 홍보할 수 잇는 영상을 제공해드립니다.
                        </a>
                    </td>
                    <td width="15%">0<br/>조회</td>
                    <td width="15%">5<br/>게시물</td>
                    <td width="10%" style="text-align:center;">
                        <a><img src="/web/images/img_context.png" width="20px"/></a>
                    </td>
                </tr>
                <tr>
                    <td width="10%">
                        <img src="/web/images/donate_img_03.png"/>
                    </td>
                    <td width="50%">
                        <a href="/web/pages/articleList.html">
                            <p>BibleTime Quiz</p>
                            매월 제공되는 퀴즈로 성경 골든벨을 해보세요!
                        </a>
                    </td>
                    <td width="15%">0<br/>조회</td>
                    <td width="15%">5<br/>게시물</td>
                    <td width="10%" style="text-align:center;">
                        <a><img src="/web/images/img_context.png" width="20px"/></a>
                    </td>
                </tr>
                <tr>
                    <td width="10%">
                        <img src="/web/images/donate_img_04.png"/>
                    </td>
                    <td width="50%">
                        <a href="/web/pages/articleList.html">
                            <p>오디오북</p>
                            기독교 고전 100선을 선정하여 제공해드립니다.
                        </a>
                    </td>
                    <td width="15%">0<br/>조회</td>
                    <td width="15%">5<br/>게시물</td>
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
