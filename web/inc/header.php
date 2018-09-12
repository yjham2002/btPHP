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
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Uncallable.php";?>
<?
    $url = $_SERVER['REQUEST_URI'];
    $expObj = new WebUser($_REQUEST);
    $EXPOSURE_SET = $expObj->getExposures();

    $user= $expObj->webUser;
//    echo json_encode($user);
    $uc = new Uncallable($_REQUEST);

    $popFlag = $uc->getProperty("FLAG_VALUE_POPUP_SHOW");

    $CONST_PREFIX_IMAGE = "L_IMG";

    $CONST_IMAGE_RAW = $uc->getProperties($CONST_PREFIX_IMAGE, $country_code);
    $CONST_IMAGE;
    for($imageLoop = 0; $imageLoop < sizeof($CONST_IMAGE_RAW); $imageLoop++){
        $CONST_IMAGE[$CONST_IMAGE_RAW[$imageLoop]["propertyName"]] = $CONST_IMAGE_RAW[$imageLoop]["value"];
    }

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

    <script src="http://malsup.github.com/jquery.form.js"></script>
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

        $(".langBtnEv").click(function(){
            var val = $(this).attr("loc");
            setCookie('btLocale', val, 1);
            location.reload();
        });

        // 숫자 타입에서 쓸 수 있도록 format() 함수 추가
        Number.prototype.format = function(){
            if(this==0) return 0;
            var reg = /(^[+-]?\d+)(\d{3})/;
            var n = (this + '');
            while(reg.test(n)) n = n.replace(reg, '$1' + ',' + '$2');
            return n;
        };
        // 문자열 타입에서 쓸 수 있도록 format() 함수 추가
        String.prototype.format = function(){
            var num = parseFloat(this);
            if( isNaN(num) ) return "0";
            return num.format();
        };

        $(".jLangShow").click(function(){
            $("#jLangPop").fadeIn();
        });

        $(".jCloseLangPop").click(function(){
            $("#jLangPop").fadeOut();
        });

        $(".jLogout").click(function(){
            var ajax = new AjaxSender("/route.php?cmd=WebUser.logout", true, "json", new sehoMap());
            ajax.send(function(data){
                if(data.returnCode === 1){
                    alert("로그아웃 되었습니다.");
                    location.href = "/web";
                }
            });
        });
    });

    function verifyEmail(email){
        var regExp = /^[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_.]?[0-9a-zA-Z])*.[a-zA-Z]{2,3}$/i;
        return (email.match(regExp) != null);
    }

    function verifyPassword(password){
        var regExp = "^(?=.*?[A-Za-z])(?=.*?[0-9])(?=.*?[$@$!%*#?&])[A-Za-z0-9$@$!%*#?&]{5,15}$";
        return (password.match(regExp) != null);
    }
</script>

<!-- Header -->
<header id="header">

    <div id="jLangPop" style="
      border:2px white solid;
      display: none;
      padding:0em 1.0em 1.0em 1.0em;
      vertical-align:middle;
      text-align:center;
      border-radius:5px;
      z-index: 999;
      position: fixed;
      top : 28%;
      left:calc(50% - 15vw);
      background: #3a3a3a;
      width : 30vw;
      ">
        <a href="#" style="float:right;margin:1.0em;color:white;text-decoration: none;">
            <span class="fa fa-close jCloseLangPop"></span>
        </a>
        <table style="height: 100%; margin:auto 0;">
            <tr>
                <td>
                    <?
                    $langList = $expObj->getLocale();
                    ?>
                    <?foreach($langList as $listItem){?>
                        <a class="langBtnEv" loc="<?=$listItem["code"]?>" href="#" style="margin:.5em 0em;color:white;text-decoration: none;"><?=$listItem["desc"] . " (" . strtoupper($listItem["code"]) . ")"?></a><br/>
                    <?}?>
                </td>
            </tr>
        </table>
    </div>

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
            <a class="link jLangShow" href="#"><span class="fa fa-language"> <?=strtoupper($country_code)?> </span></a>
            <?if($user != "" && $user != null){?>
                <a class="link" href="/web/pages/mypage.php"><span class="fa fa-user"> <?=$HEADER_ELEMENTS["headerMenu_mypage"]?> </span></a>
            <?}else{?>
                <a class="link" href="/web/pages/login.php"><span class="fa fa-user"> <?=$HEADER_ELEMENTS["headerMenu_login"]?> </span></a>
            <?}?>
            <?if($user->id != ""){?>
                <a class="link jLogout" href="#"><span class="fa fa-power-off"> 로그아웃 </span></a>
            <?}?>
        </div>

        <a href="#navPanel" class="navPanelToggle"><span class="fa fa-bars"></span></a>
    </div>
</header>



