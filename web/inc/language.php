<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 5.
 * Time: PM 4:19
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/web/inc/geoip.inc";?>

<?
    $obj = new WebUser($_REQUEST);

    if (!isset($_COOKIE["btLocale"])) {
        $gi = geoip_open($obj->geoipPath . "GeoIP.dat",GEOIP_STANDARD);
        if (!empty($_SERVER["HTTP_CLIENT_IP"]))             //공용 IP 확인
            $ip = $_SERVER["HTTP_CLIENT_IP"];
        elseif (!empty($_SERVER["HTTP_X_FORWARDED_FOR"]))   // 프록시 사용하는지 확인
            $ip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        else
            $ip = $_SERVER["REMOTE_ADDR"];

        $country_code = geoip_country_code_by_addr($gi, $ip);
        $country_name = geoip_country_name_by_addr($gi, $ip);

        $country_code = strtolower($country_code);
        geoip_close($gi);

        //test
        $country_code = "kr";

        setcookie("btLocale", $country_code, time()+60*60*24*100, "/");
    }

    $country_code = $_COOKIE["btLocale"];

    $sql = "
        SELECT * FROM tblLangJson WHERE `code` = '{$country_code}'
    ";

    $langJson = json_decode($obj->getRow($sql)["json"]);

    $HEADER_ELEMENTS = Array(
        "webTitle" => $langJson->webTitle,
        "headerMenu_home" => $langJson->headerMenu_home,
        "headerMenu_introduce" => $langJson->headerMenu_introduce,
        "headerMenu_subscribe" => $langJson->headerMenu_subscribe,
        "headerMenu_support" => $langJson->headerMenu_support,
        "headerMenu_share" => $langJson->headerMenu_share,
        "headerMenu_faq" => $langJson->headerMenu_faq
    );

    $HOME_ELEMENTS = Array(
        "top" => Array(
            "title" => $langJson->home_topTitle,
            "subTitle" => $langJson->home_topSubTitle,
        ),
        "mid" => Array(
            "title" => $langJson->home_midTitle,
            "subTitle" => $langJson->home_midSubTitle
        ),
        "midBottom" => Array(
            "title" => $langJson->home_midBottomTitle,
            "subTitle" => $langJson->home_midBottomSubTitle
        ),
        "bottom" => Array(
            "title" => $langJson->home_bottomTitle,
            "text" => $langJson->home_bottomText
        )
    );

    $INTRODUCTION_ELEMENTS = Array(

    );

    $SUBSCRIBE_ELEMENTS = Array(

    );

    $SUPPORT_ELEMENTS = Array(

    );

    $SHARE_ELEMENTS = Array(

    );

    $FAQ_ELEMENTS = Array(

    );

    $LOGIN_ELEMENTS = Array(

    );

    $MYPAGE_ELEMENTS = Array(

    );

//    echo json_encode($HEADER_ELEMENTS);

?>
