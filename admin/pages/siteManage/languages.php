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
                    <option value="kr">한국어</option>
                    <option value="en">영어</option>
                    <option value="es">스페인어</option>
                    <option value="zh">중국어</option>
                </select>
            </div>


            <h2>언어 및 문구 설정</h2>

            <br/>

            <!-- HEADER ELEMENTS -->
            <h4>웹사이트 헤더 영역</h4>
            <table class="table table-sm text-center table-responsive">
                <colgroup>
                    <col width="30%"/>
                    <col width="70%"/>
                </colgroup>
                <tr class="h-auto">
                    <td colspan="2">
                        <img src="./attr/header_elem.png" />
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
            </table>

            <br/>

            <h4>웹사이트 HOME 영역</h4>
            <!-- HOME ELEMENTS-->
            <table class="table table-sm text-center table-responsive">
                <colgroup>
                    <col width="30%"/>
                    <col width="70%"/>
                </colgroup>
                <tr class="h-auto">
                    <td colspan="2">
                        <img src="./attr/home_elem.png" />
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

            <br/>

            <h4>웹사이트 소개 영역</h4>
            <!-- INTRODUCTION ELEMENTS-->
            <table class="table table-sm text-center table-responsive">
                <colgroup>
                    <col width="30%"/>
                    <col width="70%"/>
                </colgroup>
                <tr class="h-auto">
                    <td colspan="2">
                        <img src="./attr/introduction_elem.png" />
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
                    <td class="bg-secondary text-light langKey" key="intro_pbraseText">소개[성경구절]</td>
                    <td><input type="text" class="form-control langValue" key="intro_pbraseText" value="" placeholder="내용을 입력하세요" /></td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light langKey" key="intro_pbraseLoc">소개[구절 위치(장/절)]</td>
                    <td><input type="text" class="form-control langValue" key="intro_pbraseLoc" value="" placeholder="내용을 입력하세요" /></td>
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

            <br/>

            <h4>웹사이트 구독하기 영역</h4>
            <!-- SUBSCRIBE ELEMENTS -->
            <table class="table table-sm text-center table-responsive">
                <colgroup>
                    <col width="30%"/>
                    <col width="70%"/>
                </colgroup>
                <tr class="h-auto">
                    <td colspan="2">
                        <img src="./attr/subscribe_elem.png" />
                    </td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light langKey" key="subscribe_title">구독[타이틀]</td>
                    <td><input type="text" class="form-control langValue" key="subscribe_title" value="" placeholder="내용을 입력하세요" /></td>
                </tr>
            </table>

            <h4>웹사이트 후원하기 영역</h4>
            <!-- SUPPORT ELEMENTS -->
            <table class="table table-sm text-center table-responsive">
                <colgroup>
                    <col width="30%"/>
                    <col width="70%"/>
                </colgroup>
                <tr class="h-auto">
                    <td colspan="2">
                        <img src="./attr/support_elem.png" />
                    </td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light langKey" key="support_articleTitle">후원[아티클 타이틀]</td>
                    <td><input type="text" class="form-control langValue" key="support_articleTitle" value="" placeholder="내용을 입력하세요" /></td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light langKey" key="support_articleText">후원[아티클 텍스트]</td>
                    <td><input type="text" class="form-control langValue" key="support_articleText" value="" placeholder="내용을 입력하세요" /></td>
                </tr>

                <tr class="h-auto">
                    <td class="bg-secondary text-light langKey" key="support_pbrase">후원[문구]</td>
                    <td><input type="text" class="form-control langValue" key="support_pbrase" value="" placeholder="내용을 입력하세요" /></td>
                </tr>
            </table>

            <br/>

            <h4>웹사이트 나눔 영역</h4>
            <!-- SHARE ELEMENTS -->
            <table class="table table-sm text-center table-responsive">
                <colgroup>
                    <col width="30%"/>
                    <col width="70%"/>
                </colgroup>
                <tr class="h-auto">
                    <td colspan="2">
                        <img src="./attr/share_elem.png" />
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

            <br/>

            <h4>웹사이트 FAQ 영역</h4>
            <!-- FAQ ELEMENTS -->
            <table class="table table-sm text-center table-responsive">
                <colgroup>
                    <col width="30%"/>
                    <col width="70%"/>
                </colgroup>
                <tr class="h-auto">
                    <td colspan="2">
                        <img src="./attr/faq_elem.png" />
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

<!--                <tr class="h-auto">-->
<!--                    <td class="bg-secondary text-light">메뉴[나눔]</td>-->
<!--                    <td>나눔</td>-->
<!--                </tr>-->
<!--                <tr class="h-auto">-->
<!--                    <td class="bg-secondary text-light">메뉴[FAQ]</td>-->
<!--                    <td>FAQ</td>-->
<!--                </tr>-->
            </table>

            <br>

        </div>
        <!-- /.container-fluid -->
    </div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>