<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 5.
 * Time: PM 4:19
 */
?>

<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/web/inc/geoip.inc";?>

<?
    $obj = new WebUser($_REQUEST);

    $country_code = $_COOKIE["btLocale"];

    if (!isset($_COOKIE["btLocale"])) {
        $gi = geoip_open($_SERVER["DOCUMENT_ROOT"] . "/web/inc/" . "GeoIP.dat",GEOIP_STANDARD);
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

    $sql = "
        SELECT * FROM tblLangJson WHERE `code` = '{$country_code}'
    ";

    $langJson = $obj->getRow($sql);
    $langJson = json_decode($langJson["json"]);

    $CODE = $country_code;

    $HEADER_ELEMENTS = Array(
        "webTitle" => $langJson->webTitle,
        "headerMenu_home" => $langJson->headerMenu_home,
        "headerMenu_introduce" => $langJson->headerMenu_introduce,
        "headerMenu_subscribe" => $langJson->headerMenu_subscribe,
        "headerMenu_support" => $langJson->headerMenu_support,
        "headerMenu_share" => $langJson->headerMenu_share,
        "headerMenu_faq" => $langJson->headerMenu_faq,
        "headerMenu_login" => $langJson->headerMenu_login,
        "headerMenu_mypage" => $langJson->headerMenu_mypage
    );

    $MYPAGE_ELEMENTS = Array(
        "title" => $langJson->mypage_title,
        "subTitle" => $langJson->mypage_subTitle,
        "menu" => Array(
            "ordinary" => $langJson->mypage_ordinaryMenu,
            "church" => $langJson->mypage_churchMenu,
            "charge" => $langJson->mypage_chargeMenu,
            "noti" => $langJson->mypage_notiMenu,
            "payMethod" => $langJson->mypage_payMethodMenu,
            "subscription" => $langJson->mypage_subscriptionMenu,
            "support" => $langJson->mypage_supportMenu
        ),
        "input" => Array(
            "cPass" => $langJson->mypage_cPass,
            "nPass" => $langJson->mypage_nPass,
            "nPassConfirm" => $langJson->mypage_nPassConfirm,
            "phone" => $langJson->mypage_phone,
            "zip" => $langJson->mypage_zip,
            "addr" => $langJson->mypage_addr,
            "addrDetail" => $langJson->mypage_addrDetail,
            "birth" => $langJson->mypage_birth,
            "text" => $langJson->mypage_passText
        ),
        "tableMenu" => Array(

        )
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
        "title" => $langJson->intro_title,
        "start" => Array(
            "title" => $langJson->intro_startTitle,
            "subTitle" => $langJson->intro_startSubTitle,
            "text" => $langJson->intro_startText
        ),
        "phrase" => Array(
            "text" => $langJson->intro_phraseText,
            "loc" => $langJson->intro_phraseLoc
        ),
        "box" => Array(
            "title" => $langJson->intro_boxTitle,
            "text" => $langJson->intro_boxText
        ),
        "article" => Array(
            "title" => $langJson->intro_articleTitle,
            "phrase" => $langJson->intro_articlePhrase,
            "subTitle" => $langJson->intro_articleSubTitle,
            "text" => $langJson->intro_articleText
        ),
        "secondPhrase" => Array(
            "text" => $langJson->intro_secondPhraseText,
            "loc" => $langJson->intro_secondPhraseLoc
        ),
        "prologue" => Array(
            "title" => $langJson->intro_prologueTitle,
            "text" => $langJson->intro_prologueText
        ),
        "secondArticle" => Array(
            "title" => $langJson->intro_secondArticleTitle,
            "text" => $langJson->intro_secondArticleText
        )
    );

    $SUBSCRIBE_ELEMENTS = Array(
        "title" => $langJson->subscribe_title,
        "detail" => Array(
            "title" => $langJson->subscribe_detail_title,
            "subTitle" => $langJson->subscribe_detail_subTitle,
            "type" => $langJson->subscribe_detail_type,
            "buyerInfo" => $langJson->subscribe_detail_buyerInfo,
            "name" => $langJson->subscribe_detail_name,
            "email" => $langJson->subscribe_detail_email,
            "emailCheck" => $langJson->subscribe_detail_emailCheck,
            "phone" => $langJson->subscribe_detail_phone,
            "zipcode" => $langJson->subscribe_detail_zipcode,
            "addr" => $langJson->subscribe_detail_addr,
            "addrDetail" => $langJson->subscribe_detail_addrDetail,
            "shippingInfo" => $langJson->subscribe_detail_shippingInfo,
            "same" => $langJson->subscribe_detail_same,
            "rName" => $langJson->subscribe_detail_rName,
            "rPhone" => $langJson->subscribe_detail_rPhone,
            "rZipcode" => $langJson->subscribe_detail_rZipcode,
            "rAddr" => $langJson->subscribe_detail_rAddr,
            "rAddrDetail" => $langJson->subscribe_detail_rAddrDetail,
            "paymentInfo" => $langJson->subscribe_detail_paymentInfo,
            "owner" => $langJson->subscribe_detail_owner,
            "mine" => $langJson->subscribe_detail_mine,
            "notMine" => $langJson->subscribe_detail_notMine
        )
    );

    $SUPPORT_ELEMENTS = Array(
        "article" => Array(
            "title" => $langJson->support_articleTitle,
            "text" => $langJson->support_articleText
        ),
        "phrase" => $langJson->support_phrase,
        "detail" => Array(
            "title" => $langJson->support_detail_title
        )
    );

    $SHARE_ELEMENTS = Array(
        "title" => $langJson->share_title,
        "subTitle" => $langJson->share_subTitle,
        "common" => Array(
          "viewText" => $langJson->share_viewText,
          "articleText" => $langJson->share_articleText
        ),
        "notice" => Array(
            "title" => $langJson->share_noticeTitle,
            "subTitle" => $langJson->share_noticeSubTitle
        ),
        "img" => Array(
            "title" => $langJson->share_imgTitle,
            "subTitle" => $langJson->share_imgSubTitle
        ),
        "video" => Array(
            "title" => $langJson->share_videoTitle,
            "subTitle" => $langJson->share_videoSubTitle
        ),
        "quiz" => Array(
            "title" => $langJson->share_quizTitle,
            "subTitle" => $langJson->share_quizSubTitle
        ),
        "audio" => Array(
            "title" => $langJson->share_audioTitle,
            "subTitle" => $langJson->share_audioSubTitle
        )
    );

    $FAQ_ELEMENTS = Array(
        "title" => $langJson->faq_title,
        "subTitle" => $langJson->faq_subTitle
    );

    $LOGIN_ELEMENTS = Array(

    );

//    echo json_encode($HEADER_ELEMENTS);

?>
