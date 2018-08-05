<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 5:03
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/web/inc/geoip.inc.php";?>

<?
    // open the geoip database
    $gi = geoip_open("GeoIP.dat",GEOIP_STANDARD);
    
    //$ipAddress = '165.69.10.27'; // news.com.au
    //$ipAddress = '202.21.128.102'; // stuff.co.nz
    //$ipAddress = '212.58.251.195'; // bbc.co.uk
    $ipAddress = $_SERVER['REMOTE_ADDR']; // user IP address

    // to get country code
    $country_code = geoip_country_code_by_addr($gi, $ipAddress);
    echo "Your country code is: $country_code <br/>";

    // to get country name
    $country_name = geoip_country_name_by_addr($gi, $ipAddress);
    echo "Your country name is: $country_name <br/>";

    // close the database
    geoip_close($gi);
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
</head>
<body class="subpage">

<!-- Header -->
<header id="header">
    <div class="inner">
        <a href="/web" class="logo">BIBLETIME</a>
        <nav id="nav">
            <a class="selected" href="/web">Home</a>
            <a href="/web/pages/introduction.php">소개</a>
            <a href="/web/pages/subscription.php">구독하기</a>
            <a href="/web/pages/contribution.php">후원하기</a>
            <a href="/web/pages/donation.php">나눔</a>
            <a href="/web/pages/faq.php">FAQ</a>
        </nav>
        <div class="rightBox">
            <a class="langBtn" href="#"><img src="/web/images/lang_ko.png" />KO | </a>
            <a class="langBtn" href="#"><img src="/web/images/lang_en.png" />EN | </a>
            <a class="langBtn" href="#"><img src="/web/images/lang_es.png" />ES | </a>
            <a class="langBtn" href="#"><img src="/web/images/lang_zh.png" />ZH</a>

            <a class="link" href="/web/pages/mypage.php">마이페이지</a>
        </div>
        <a href="#navPanel" class="navPanelToggle"><span class="fa fa-bars"></span></a>
    </div>
</header>



