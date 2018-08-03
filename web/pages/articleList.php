<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 5:56
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

<section class="wrapper special books" style="padding : 1.5em 0;">
    <div class="inner">
        <h5 class="dirHelper">BibleTime 나눔 > 게시판명</h5>
    </div>
</section>

<section class="wrapper special sectionCover floatingS" style="background-image: url('/web/images/intro_bottom.jpg');">
    <h1 style="color:white; font-size:2.8em; margin:0; line-height:1.3em;">게시판명</h1>
    <div class="empLineT white"></div>
    <h3 class="nanumGothic" style="color:white; font-size:1.3em">게시판 부가 설명이 삽입됩니다.</h3>

</section>

<!-- Two -->
<section class="wrapper special books">
    <div class="inner">
        <div class="row inner">
            <input type="text" class="fancy" id="searchBox" placeholder="검색어를 입력하세요" style="width: 18em; font-size:0.9em;" />
            <a href="#" style="margin-top:0.8em;"><img src="/web/images/img_search.png" width="20px"/></a>
        </div>
        <br/>
        <div class="table-wrapper white">
            <table class="alt white list">
                <tbody>
                <tr>
                    <td></td>
                    <td>제목</td>
                    <td class="smallIconTD"><a><img src="/web/images/icon_comment.png" width="20px"/></a></td>
                    <td class="smallIconTD"><a><img src="/web/images/icon_like.png" width="20px"/></a></td>
                    <td class="smallIconTD"><a><img src="/web/images/icon_view.png" width="20px"/></a></td>
                    <td class="smallWordTD">최근 활동</td>
                    <td style="text-align:center;">
                        <a><img src="/web/images/img_context.png" width="20px"/></a>
                    </td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>
                        <a href="/web/pages/articleDetail.php">
                            <p>글 제목이 삽입됩니다.</p>
                            길동 홍 <text style="color:#888888;">7일 전</text>
                        </a>
                    </td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>7일 전</td>
                    <td style="text-align:center;">
                        <a><img src="/web/images/img_context.png" width="20px"/></a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>
                        <a href="/web/pages/articleDetail.php">
                            <p>글 제목이 삽입됩니다.</p>
                            길동 홍 <text style="color:#888888;">7일 전</text>
                        </a>
                    </td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>7일 전</td>
                    <td style="text-align:center;">
                        <a><img src="/web/images/img_context.png" width="20px"/></a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>
                        <a href="/web/pages/articleDetail.php">
                            <p>글 제목이 삽입됩니다.</p>
                            길동 홍 <text style="color:#888888;">7일 전</text>
                        </a>
                    </td>
                    <td>0</td>
                    <td>0</td>
                    <td>0</td>
                    <td>7일 전</td>
                    <td style="text-align:center;">
                        <a><img src="/web/images/img_context.png" width="20px"/></a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>

<div class="footerRibbon">
    <ul class="icons">
        <li><a href="#" class="iconT"><img src="/web/images/icon_facebook.png" alt="Pic 02" /></a></li>
        <li><a href="#" class="iconT"><img src="/web/images/icon_instagram.png" alt="Pic 02" /></a></li>
    </ul>
</div>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
