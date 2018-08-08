<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 5:03
 */
?>

<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/web/inc/language.php";?>
<?
    $url = $_SERVER['REQUEST_URI'];
    $expObj = new WebUser($_REQUEST);
    $EXPOSURE_SET = $expObj->getExposures();
?>

<!DOCTYPE HTML>
<html>
<head>
    <title>BibleTime</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="stylesheet" href="/web/assets/css/main.css" />

    <script src="/web/assets/js/jquery.min.js"></script>
    <script src="/web/assets/js/skel.min.js"></script>
    <script src="/web/assets/js/util.js"></script>
    <script src="/web/assets/js/main.js"></script>

    <script type="text/javascript" src="/modules/ajaxCall/ajaxClass.js"></script>
    <script type="text/javascript" src="/modules/sehoMap/sehoMap.js"></script>

    <script src="//developers.kakao.com/sdk/js/kakao.min.js"></script>
</head>
<body class="subpage">

<script>
    $(document).ready(function(){
        var exposureJson = <?=json_encode($EXPOSURE_SET)?>;
        for(var it = 0; it < exposureJson.length; it++){
            var toApply = $("[exposureSet='" + exposureJson[it].code + "']");
            if(toApply != null && exposureJson[it].exposure == 0){
                toApply.hide();
            }
        }

        console.log(getCookie("btLocale"));

        var url = window.location.pathname;
        $(".headerMenu").each(function(){
            $(this).removeClass("selected");
            var match = $(this).attr("match");
            if(url.includes(match)) $(this).addClass("selected");
        });

        if(url === "/web/pages/") $(".headerMenu").eq(0).addClass("selected");

        // 쿠키 생성
        function setCookie(cName, cValue, cDay){
            var expire = new Date();
            expire.setDate(expire.getDate() + cDay);
            cookies = cName + '=' + escape(cValue) + '; path=/ '; // 한글 깨짐을 막기위해 escape(cValue)를 합니다.
            if(typeof cDay != 'undefined') cookies += ';expires=' + expire.toGMTString() + ';';
            document.cookie = cookies;
        }

        // 쿠키 가져오기
        function getCookie(cName){
            cName = cName + '=';
            var cookieData = document.cookie;
            var start = cookieData.indexOf(cName);
            var cValue = '';
            if(start != -1){
                start += cName.length;
                var end = cookieData.indexOf(';', start);
                if(end == -1)end = cookieData.length;
                cValue = cookieData.substring(start, end);
            }
            return unescape(cValue);
        }

        $(".langBtn").click(function(){
            var val = $(this).attr("loc");
            setCookie('btLocale', val, 1);
            location.reload();
        });
    });
</script>

<!-- Header -->
<header id="header">
    <div class="inner">
        <a href="/web" class="logo"><?=$HEADER_ELEMENTS["webTitle"]?></a>
        <nav id="nav">
            <a class="selected headerMenu" href="/web"><?=$HEADER_ELEMENTS["headerMenu_home"]?></a>
            <a class="headerMenu" match="/web/pages/introduction.php" href="/web/pages/introduction.php"><?=$HEADER_ELEMENTS["headerMenu_introduce"]?></a>
            <a class="headerMenu" match="/web/pages/subscription.php" href="/web/pages/subscription.php"><?=$HEADER_ELEMENTS["headerMenu_subscribe"]?></a>
            <a class="headerMenu" match="/web/pages/contribution.php" href="/web/pages/contribution.php"><?=$HEADER_ELEMENTS["headerMenu_support"]?></a>
            <a class="headerMenu" match="/web/pages/donation.php" href="/web/pages/donation.php"><?=$HEADER_ELEMENTS["headerMenu_share"]?></a>
            <a class="headerMenu" match="/web/pages/faq.php" href="/web/pages/faq.php"><?=$HEADER_ELEMENTS["headerMenu_faq"]?></a>
        </nav>
        <div class="rightBox">
            <a class="langBtn" loc="kr" href="#"><img src="/web/images/lang_ko.png" />KO | </a>
            <a class="langBtn" loc="en" href="#"><img src="/web/images/lang_en.png" />EN | </a>
            <a class="langBtn" loc="es" href="#"><img src="/web/images/lang_es.png" />ES | </a>
            <a class="langBtn" loc="zh" href="#"><img src="/web/images/lang_zh.png" />ZH</a>

            <a class="link" href="/web/pages/login.php">로그인</a>
<!--            <a class="link" href="/web/pages/mypage.php">마이페이지</a>-->
        </div>
        <a href="#navPanel" class="navPanelToggle"><span class="fa fa-bars"></span></a>
    </div>
</header>



