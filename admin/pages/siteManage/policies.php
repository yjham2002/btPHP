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

            $(".jSavePr").click(function(){
                var val = $("#v_fb").val();
                var ajax = new AjaxSender(
                    "/route.php?cmd=Uncallable.setPropertyAjax",
                    true, "json",
                    new sehoMap().put("name", "TEXT_PRIVACY").put("value", val));
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("저장되었습니다.");
                    }
                });
            });

            $(".jSavePl").click(function(){
                var val = $("#v_info").val();
                var loc = $(".jLangO").val();
                var ajax = new AjaxSender(
                    "/route.php?cmd=Uncallable.setPropertyLocAjax",
                    true, "json",
                    new sehoMap().put("name", "TEXT_POLICY").put("value", val).put("lang", loc));
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
            }

            $("#show02").hide();
            $("#show03").hide();
            $("#show04").hide();
            $("#show05").hide();
            $("#show06").hide();
            $("#show07").hide();

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
                    <li class="breadcrumb-item active">정적 정보 설정</li>
                </ol>

                <div class="btn-group float-right mb-2" role="group">
                    <a href="#" class="jSave btn btn-secondary mr-2">저장</a>
                    <select class="custom-select mr-2 jLang col-5" id="inputGroupSelect01">
                        <?foreach($langList as $item){?>
                            <option value="<?=$item["code"]?>"><?=$item["desc"]?></option>
                        <?}?>
                    </select>
                </div>

                <h2>정적 정보 설정</h2>

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
                            <td class="bg-secondary text-light langKey" key="policy_text">약관 정보</td>
                            <td><input type="text" class="form-control langValue" key="policy_text" value="" placeholder="내용을 입력하세요" /></td>
                        </tr>
                        <tr class="h-auto">
                            <td class="bg-secondary text-light langKey" key="privacy_text">개인정보처리방침</td>
                            <td><input type="text" class="form-control langValue" key="privacy_text" value="" placeholder="내용을 입력하세요" /></td>
                        </tr>
                    </table>
                </div>

            <br/>

        </div>
        <!-- /.container-fluid -->
    </div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>