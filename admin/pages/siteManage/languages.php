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

        bindLangPair();

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
            if(data == null){
                $(".langValue").val("");
                return;
            }

            var map = JSON.parse(data.json);

            console.log(map);

            $.each(map, function(key, value){
                $('input[key='+key+']').val(value);
            });
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
                type : 'get',
                data : {
                    code : $(".jLang").val(),
                    json : JSON.stringify(jsonArr.map)
                },
                success : function(data){
                    // alert(data);
                }
            });
        });



    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">홈페이지관리</li>
            <li class="breadcrumb-item active">언어</li>
        </ol>

        <div class="btn-group float-right mb-2" role="group" aria-label="Basic example">
            <a href="#" class="jSave btn btn-secondary mr-2">저장</a>
            <a href="/admin/pages/siteManage/languageSet.php" class="btn btn-secondary mr-2">언어셋 관리</a>
            <select class="custom-select mr-2 col-6 jLang" id="inputGroupSelect01">
                <option value="ko">한국어</option>
                <option value="en">영어</option>
                <option value="es">스페인어</option>
                <option value="zh">중국어</option>
            </select>
        </div>


        <h2>언어 설정</h2>

        <br/>

        <table class="table table-sm table-bordered w-auto text-center">
            <colgroup>
                <col width="30%"/>
                <col width="70%"/>
            </colgroup>
            <tr class="h-auto">
                <td class="bg-secondary text-light langKey" key="webTitle">웹 페이지 타이틀</td>
                <td><input type="text" class="form-control langValue" key="webTitle" value="" placeholder="내용을 입력하세요" /></td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">메뉴[소개]</td>
                <td>소개</td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">메뉴[구독]</td>
                <td>구독하기</td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">메뉴[후원]</td>
                <td>후원하기</td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">메뉴[나눔]</td>
                <td>나눔</td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">메뉴[FAQ]</td>
                <td>FAQ</td>
            </tr>
        </table>

        <hr>

    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
