<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 2:09
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Uncallable.php";?>
<?
    $objm = new AdminMain($_REQUEST);
    $langList = $objm->getLangList();

    $uc = new Uncallable($_REQUEST);
    $link_fb = $uc->getProperty("URL_FACEBOOK");
    $link_ig = $uc->getProperty("URL_INSTAGRAM");
    $link_kakao = $uc->getProperty("URL_KAKAO");

?>

    <script>
        $(document).ready(function(){

            var lengthLimit = 10;

            bindLangPair();

            function convert(){
                var arr = $(".langValue");
                for(var e = 0; e < arr.length; e++){
                    var item = arr.eq(e);
                    if(item.val().length > lengthLimit){
                        var html = "<textarea class='form-control langValue' key="+ item.attr("key") +">" + item.val() + "</textarea>";
                        item.parent().html(html);
                    }
                }
                resizeTextArea();
            }

            function resizeTextArea(){
                var arr = $("textarea");
                for(var e = 0; e < arr.length; e++){
                    arr.eq(e).height(arr.eq(e).prop('scrollHeight'));
                }
            }

            function getLangPair(){
                var tds = $(".langKey");
                var inputs = $(".langValue");
                var langPair = new sehoMap();
                for(var e = 0; e < tds.length; e++){
                    langPair.put(tds.eq(e).attr("key"), inputs.eq(e).val());
                }

                return langPair;
            }

            function _bindLangPair(data){
                //empy every input
                $(".langValue").each(function(){$(this).val("");});
                if(data == null) return;

                var map = JSON.parse(data.json);
                // console.log(map);

                $.each(map, function(key, value){
                    $('input[key='+key+'], textarea[key='+key+']').val(value);
                });

                convert();
            }

            function bindLangPair(){
                $.ajax({
                    url : "/route.php?cmd=AdminMain._getLangJson",
                    async : true,
                    type : 'get',
                    dataType : 'json',
                    data : {
                        code : $(".jLang").val()
                    },
                    success : function(data){
                        _bindLangPair(data);
                    },
                    error : function(a, b, c){
                        alert(a + "/" + b + "/"+ c);
                    }
                });
            }

            $(".jLang").change(function(){
                bindLangPair();
            });

            $(".jSaveK").click(function(){
                var val = $("#v_kakao").val();
                var ajax = new AjaxSender("/route.php?cmd=Uncallable.setPropertyAjax", true, "json", new sehoMap().put("name", "URL_KAKAO").put("value", val));
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("저장되었습니다");
                    }
                });
            });

            $(".jSaveI").click(function(){
                var val = $("#v_inst").val();
                var ajax = new AjaxSender(
                    "/route.php?cmd=Uncallable.setPropertyAjax",
                    true, "json",
                    new sehoMap().put("name", "URL_INSTAGRAM").put("value", val));
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("저장되었습니다.");
                    }
                });
            });

            $(".jSaveF").click(function(){
                var val = $("#v_fb").val();
                var ajax = new AjaxSender(
                    "/route.php?cmd=Uncallable.setPropertyAjax",
                    true, "json",
                    new sehoMap().put("name", "URL_FACEBOOK").put("value", val));
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("저장되었습니다.");
                    }
                });
            });

            $(".jSaveO").click(function(){
                var val = $("#v_info").val();
                var loc = $(".jLangO").val();
                var ajax = new AjaxSender(
                    "/route.php?cmd=Uncallable.setPropertyLocAjax",
                    true, "json",
                    new sehoMap().put("name", "URL_INFO").put("value", val).put("lang", loc));
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("저장되었습니다.");
                        loadInfo(loc);
                    }
                });
            });

            $(".jLangO").change(function(){
                loadInfo($(this).val());
            });

            loadInfo("kr");

            function loadInfo(loc){
                $.ajax({
                    url : "/route.php?cmd=Uncallable.getPropertyLocAjax",
                    async : true,
                    type : 'get',
                    dataType : 'text',
                    data : {
                        name : "URL_INFO",
                        lang : loc
                    },
                    success : function(data){
                        $("#v_info").text(data.trim());
                        resizeTextArea();
                    },
                    error : function(a, b, c){
                        alert("데이터를 불러올 수 없습니다.");
                    }
                });
            }

            $(".jS01").click(function(){
                var d = "#" + $(this).attr("divId");
                $(".jS01").removeClass("btn-primary");
                $(".jS01").addClass("btn-secondary");
                $(this).removeClass("btn-secondary");
                $(this).addClass("btn-primary");
                hideAllBox();
                $(d).fadeIn();
                resizeTextArea();
            });

            function hideAllBox(){
                $("#show01").hide();
                $("#show02").hide();
                $("#show03").hide();
                $("#show04").hide();
                $("#show05").hide();
                $("#show06").hide();
                $("#show07").hide();
                $("#show08").hide();
            }

            $("#show02").hide();
            $("#show03").hide();
            $("#show04").hide();
            $("#show05").hide();
            $("#show06").hide();
            $("#show07").hide();
            $("#show08").hide();

            $(".jSave").click(function(){
                var jsonArr = getLangPair();
                console.log(jsonArr);
                $.ajax({
                    url : "/route.php?cmd=AdminMain._upsertLangJson",
                    async : true,
                    type : 'post',
                    data : {
                        code : $(".jLang").val(),
                        json : JSON.stringify(jsonArr.map)
                    },
                    success : function(data){
                        alert("저장되었습니다.");
                        location.reload();
                    }
                });
            });



        });
    </script>

    <div id="content-wrapper">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">홈페이지관리</li>
                <li class="breadcrumb-item active">언어 및 문구</li>
            </ol>

            <div class="btn-group float-right mb-2" role="group">
                <a href="#" class="jSave btn btn-secondary mr-2">저장</a>
                <a href="/admin/pages/siteManage/languageSet.php" class="btn btn-secondary mr-2">언어셋 관리</a>
                <select class="custom-select mr-2 jLang col-5" id="inputGroupSelect01">
                    <?foreach($langList as $item){?>
                        <option value="<?=$item["code"]?>"><?=$item["desc"]?></option>
                    <?}?>
                </select>
            </div>


            <h2>언어 및 문구 설정</h2>

            <br/>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">하단 카카오 링크 주소(공통)</span>
                </div>
                <input type="text" class="form-control" id="v_kakao" value="<?=$link_kakao?>">
                <a href="#" class="jSaveK btn btn-secondary">저장</a>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">하단 페이스북 링크 주소(공통)</span>
                </div>
                <input type="text" class="form-control" id="v_fb" value="<?=$link_fb?>">
                <a href="#" class="jSaveF btn btn-secondary">저장</a>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">하단 인스타그램 링크 주소(공통)</span>
                </div>
                <input type="text" class="form-control" id="v_inst" value="<?=$link_ig?>">
                <a href="#" class="jSaveI btn btn-secondary">저장</a>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text">하단 사업자 정보
                        &nbsp;&nbsp;
                        <select class="custom-select mr-2 jLangO col-5" id="inputGroupSelect01">

                        <?foreach($langList as $item){?>
                            <option value="<?=$item["code"]?>"><?=$item["desc"]?></option>
                        <?}?>
                    </select></span>
                </div>

                <textarea class="form-control" id="v_info"></textarea>
                <a href="#" class="jSaveO btn btn-secondary">저장</a>
            </div>

            <h4>영역별 설정</h4>

            <div class="btn-group float-left mb-3" role="group">
                <button type="button" class="btn btn-primary jS01" divId="show01">웹사이트 헤더</button>
                <button type="button" class="btn btn-secondary jS01" divId="show02">웹사이트 HOME</button>
                <button type="button" class="btn btn-secondary jS01" divId="show03">웹사이트 소개</button>
                <button type="button" class="btn btn-secondary jS01" divId="show04">웹사이트 구독</button>
                <button type="button" class="btn btn-secondary jS01" divId="show08">웹사이트 후원</button>
            </div>
            <div class="btn-group float-left mb-3" role="group">
            <button type="button" class="btn btn-secondary jS01" divId="show05">웹사이트 나눔</button>
            <button type="button" class="btn btn-secondary jS01" divId="show06">웹사이트 FAQ</button>
            <button type="button" class="btn btn-secondary jS01" divId="show07">웹사이트 MYPAGE</button>
            </div>

            <!-- HEADER ELEMENTS -->

            <div id="show01">
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <colgroup>
                        <col width="30%"/>
                        <col width="70%"/>
                    </colgroup>
                    <tr class="h-auto">
                        <td colspan="2">
                            <img src="./attr/header_elem.png" width="100%" />
                        </td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="webTitle">웹 페이지 타이틀</td>
                        <td><input type="text" class="form-control langValue" key="webTitle" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="headerMenu_home">헤더 메뉴[home]</td>
                        <td><input type="text" class="form-control langValue" key="headerMenu_home" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="headerMenu_introduce">메뉴[소개]</td>
                        <td><input type="text" class="form-control langValue" key="headerMenu_introduce" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="headerMenu_subscribe">메뉴[구독]</td>
                        <td><input type="text" class="form-control langValue" key="headerMenu_subscribe" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="headerMenu_support">메뉴[후원]</td>
                        <td><input type="text" class="form-control langValue" key="headerMenu_support" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="headerMenu_share">메뉴[나눔]</td>
                        <td><input type="text" class="form-control langValue" key="headerMenu_share" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="headerMenu_faq">메뉴[FAQ]</td>
                        <td><input type="text" class="form-control langValue" key="headerMenu_faq" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="headerMenu_login">로그인 버튼</td>
                        <td><input type="text" class="form-control langValue" key="headerMenu_login" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="headerMenu_mypage">마이페이지 버튼</td>
                        <td><input type="text" class="form-control langValue" key="headerMenu_mypage" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                </table>
            </div>
            </div>

            <br/>

            <div id="show02">
            <!-- HOME ELEMENTS-->
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <colgroup>
                        <col width="30%"/>
                        <col width="70%"/>
                    </colgroup>
                    <tr class="h-auto">
                        <td colspan="2">
                            <img src="./attr/home_elem.png" width="100%" />
                        </td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="home_topTitle">홈[상단 타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="home_topTitle" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="home_topSubTitle">홈[상단 하위 타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="home_topSubTitle" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="home_midTitle">홈[중단 타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="home_midTitle" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="home_midSubTitle">홈[중단 하위 타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="home_midSubTitle" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>

                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="home_midBottomTitle">홈[중하단 타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="home_midBottomTitle" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="home_midBottomSubTitle">홈[중하단 하위 타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="home_midBottomSubTitle" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>

                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="home_bottomTitle">홈[하단 타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="home_bottomTitle" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="home_bottomText">홈[하단 텍스트]</td>
                        <td><input type="text" class="form-control langValue" key="home_bottomText" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                </table>
            </div>
            </div>

            <br/>

            <div id="show03">
            <!-- INTRODUCTION ELEMENTS-->
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <colgroup>
                        <col width="30%"/>
                        <col width="70%"/>
                    </colgroup>
                    <tr class="h-auto">
                        <td colspan="2">
                            <img src="./attr/introduction_elem.png" width="100%" />
                        </td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="intro_title">소개[타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="intro_title" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="intro_startTitle">소개[시작 타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="intro_startTitle" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="intro_startSubTitle">소개[시작 하위 타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="intro_startSubTitle" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="intro_startText">소개[시작 텍스트]</td>
                        <td><input type="text" class="form-control langValue" key="intro_startText" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>

                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="intro_phraseText">소개[성경구절]</td>
                        <td><input type="text" class="form-control langValue" key="intro_phraseText" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="intro_phraseLoc">소개[구절 위치(장/절)]</td>
                        <td><input type="text" class="form-control langValue" key="intro_phraseLoc" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>

                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="intro_boxTitle">소개[역사 타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="intro_boxTitle" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="intro_boxText">소개[역사 텍스트]</td>
                        <td><input type="text" class="form-control langValue" key="intro_boxText" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>

                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="intro_articleTitle">소개[아티클 타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="intro_articleTitle" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="intro_articlePbrase">소개[아티클 문구]</td>
                        <td><input type="text" class="form-control langValue" key="intro_articlePbrase" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="intro_articleSubTitle">소개[아티클 하위 타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="intro_articleSubTitle" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="intro_articleText">소개[아티클 텍스트]</td>
                        <td><input type="text" class="form-control langValue" key="intro_articleText" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>

                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="intro_secondPbraseText">소개[두번째 성경구절]</td>
                        <td><input type="text" class="form-control langValue" key="intro_secondPbraseText" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="intro_secondPbraseLoc">소개[두번째 구절 위치(장/절)]</td>
                        <td><input type="text" class="form-control langValue" key="intro_secondPbraseLoc" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>

                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="intro_prologueTitle">소개[인사말 타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="intro_prologueTitle" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="intro_prologueText">소개[인사말 내용]</td>
                        <td><input type="text" class="form-control langValue" key="intro_prologueText" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>

                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="intro_secondArticleTitle">소개[두번째 아티클 타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="intro_secondArticleTitle" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="intro_secondArticleText">소개[두번째 아티클 텍스트]</td>
                        <td><input type="text" class="form-control langValue" key="intro_secondArticleText" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                </table>
            </div>
            </div>

            <br/>

            <div id="show04">
            <!-- SUBSCRIBE ELEMENTS -->
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <colgroup>
                        <col width="30%"/>
                        <col width="70%"/>
                    </colgroup>
                    <tr class="h-auto">
                        <td colspan="2">
                            <img src="./attr/subscribe_elem.png" width="100%" />
                        </td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_title">구독[타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_title" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_title">구독 상세[타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_title" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_subTitle">구독 상세[하위 타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_subTitle" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_type">구독 상세[결제 유형]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_type" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_buyerInfo">구독 상세[구매정보]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_buyerInfo" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_name">구독 상세[성함]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_name" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_email">구독 상세[이메일]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_email" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_emailCheck">구독 상세[이메일 중복 체크]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_emailCheck" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_phone">구독 상세[휴대폰 번호]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_phone" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_zipcode">구독 상세[우편번호]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_zipcode" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_addr">구독 상세[주소]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_addr" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_addrDetail">구독 상세[상세주소]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_addrDetail" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_shippingInfo">구독 상세[배송정보]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_shippingInfo" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_same">구독 상세[구매정보와 동일]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_same" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_rName">구독 상세[받는분 성함]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_rName" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_rPhone">구독 상세[받는분 휴대전화번호]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_rPhone" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_rZipcode">구독 상세[받는분 우편번호]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_rZipcode" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_rAddr">구독 상세[받는분 주소]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_rAddr" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_rAddrDetail">구독 상세[받는분 상세주소]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_rAddrDetail" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_paymentInfo">구독 상세[결제 정보]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_paymentInfo" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_owner">구독 상세[카드/계좌주]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_owner" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_mine">구독 상세[본인]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_mine" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="subscribe_detail_notMine">구독 상세[타인]</td>
                        <td><input type="text" class="form-control langValue" key="subscribe_detail_notMine" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                </table>
            </div>
            </div>
            <br/>

            <div id="show08">
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <colgroup>
                            <col width="30%"/>
                            <col width="70%"/>
                        </colgroup>
                        <tr class="h-auto">
                            <td colspan="2">
                                <img src="./attr/support_elem.png" width="100%" />
                            </td>
                        </tr>
                        <p>* 구독 페이지와 중복되는 항목은 구독 탭의 설정을 따릅니다.</p>
                        <tr class="h-auto">
                            <td class="bg-secondary text-light langKey" key="support_detail_title">후원 상세[타이틀]</td>
                            <td><input type="text" class="form-control langValue" key="support_detail_title" value="" placeholder="내용을 입력하세요" /></td>
                        </tr>
                    </table>
                </div>
            </div>

            <br/>

            <div id="show05">
            <!-- SHARE ELEMENTS -->
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <colgroup>
                        <col width="30%"/>
                        <col width="70%"/>
                    </colgroup>
                    <tr class="h-auto">
                        <td colspan="2">
                            <img src="./attr/share_elem.png" width="100%" />
                        </td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="share_title">나눔[타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="share_title" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="share_subTitle">나눔[하위 타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="share_subTitle" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>

                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="share_viewText">나눔[조회 텍스트]</td>
                        <td><input type="text" class="form-control langValue" key="share_viewText" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="share_articleText">나눔[게시물 텍스트]</td>
                        <td><input type="text" class="form-control langValue" key="share_articleText" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                </table>
            </div>
            </div>
            <br/>

            <div id="show06">
            <!-- FAQ ELEMENTS -->
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <colgroup>
                        <col width="30%"/>
                        <col width="70%"/>
                    </colgroup>
                    <tr class="h-auto">
                        <td colspan="2">
                            <img src="./attr/faq_elem.png" width="100%" />
                        </td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="faq_title">faq[타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="faq_title" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="faq_subTitle">faq[하위 타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="faq_subTitle" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                </table>
            </div>
            </div>
            <br/>

            <div id="show07">
            <!-- MYPAGE ELEMENTS -->
            <div class="table-responsive">
                <table class="table table-bordered" width="100%" cellspacing="0">
                    <colgroup>
                        <col width="30%"/>
                        <col width="70%"/>
                    </colgroup>
                    <tr class="h-auto">
                        <td colspan="2">
                            <img src="./attr/mypage_elem.png" width="100%" />
                        </td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="mypage_title">마이페이지[타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="mypage_title" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="mypage_subTitle">마이페이지[하위 타이틀]</td>
                        <td><input type="text" class="form-control langValue" key="mypage_subTitle" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>


                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="mypage_ordinaryMenu">메뉴[기본정보]</td>
                        <td><input type="text" class="form-control langValue" key="mypage_ordinaryMenu" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="mypage_churchMenu">메뉴[교회/단체정보]</td>
                        <td><input type="text" class="form-control langValue" key="mypage_churchMenu" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="mypage_chargeMenu">메뉴[담당자 정보]</td>
                        <td><input type="text" class="form-control langValue" key="mypage_chargeMenu" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="mypage_notiMenu">메뉴[이메일/SMS수신]</td>
                        <td><input type="text" class="form-control langValue" key="mypage_notiMenu" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="mypage_payMethodMenu">메뉴[결제 정보]</td>
                        <td><input type="text" class="form-control langValue" key="mypage_payMethodMenu" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="mypage_subscriptionMenu">메뉴[구독 정보]</td>
                        <td><input type="text" class="form-control langValue" key="mypage_subscriptionMenu" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="mypage_supportMenu">메뉴[후원내역]</td>
                        <td><input type="text" class="form-control langValue" key="mypage_supportMenu" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>





                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="mypage_cPass">placeholder[현재 비밀번호]</td>
                        <td><input type="text" class="form-control langValue" key="mypage_cPass" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="mypage_nPass">placeholder[신규 비밀번호]</td>
                        <td><input type="text" class="form-control langValue" key="mypage_nPass" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="mypage_nPassConfirm">placeholder[신규 비밀번호 확인]</td>
                        <td><input type="text" class="form-control langValue" key="mypage_nPassConfirm" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>

                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="mypage_passText">문구[비밀번호]</td>
                        <td><input type="text" class="form-control langValue" key="mypage_passText" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>

                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="mypage_phone">placeholder[휴대폰 번호]</td>
                        <td><input type="text" class="form-control langValue" key="mypage_phone" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="mypage_zip">placeholder[우편 번호]</td>
                        <td><input type="text" class="form-control langValue" key="mypage_zip" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="mypage_addr">placeholder[주소]</td>
                        <td><input type="text" class="form-control langValue" key="mypage_addr" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="mypage_addrDetail">placeholder[주소 상세]</td>
                        <td><input type="text" class="form-control langValue" key="mypage_addrDetail" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="mypage_birth">placeholder[생년월일]</td>
                        <td><input type="text" class="form-control langValue" key="mypage_birth" value="" placeholder="내용을 입력하세요" /></td>
                    </tr>

                </table>
            </div>
            </div>
            <br/>

        </div>
        <!-- /.container-fluid -->
    </div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>