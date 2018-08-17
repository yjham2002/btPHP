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

    $loc = "kr";
    $json = $uc->getPropertyLoc("LAYOUT_HISTORY", $loc);

?>

    <script>
        $(document).ready(function(){

            function addYears(){
                var now = new Date().getFullYear();
                var html = "<option value='#'>연도 선택</option>";

                for(var e = now - 50; e <= now; e++){
                    html += "<option value='"+e+"'>"+e+"</option>";
                }

                $(".jSelectYear").html(html);
            }

            addYears();

            function addContainer(selectedYear, content){
                var template = $("#templateContainer").html().replace("#{content}", content);
                var appended = $("#yContainer").append(template);
                if(selectedYear != "") {
                    appended.find("select").last().val(selectedYear);
                }
            }

            function getHistoryJson(loc){
                $.ajax({
                    beforeSend : function(){
                        $("#yContainer").html("");
                    },
                    url : "/route.php?cmd=Uncallable.getPropertyLocAjax",
                    async : true,
                    type : 'get',
                    dataType : 'json',
                    data : {
                        name : "LAYOUT_HISTORY",
                        lang : loc
                    },
                    success : function(data){
                        for(var e = 0; e < data.length; e++){
                            addContainer(data[e].year + "", data[e].content);
                        }
                    },
                    error : function(a, b, c){
                        alert("데이터를 불러올 수 없습니다.");
                    }
                });
            }

            getHistoryJson($(".jLang").val());
            $(".jLang").change(function(){
                getHistoryJson($(".jLang").val());
            });

            function setHistoryJson(loc, value){
                $.ajax({
                    url : "/route.php?cmd=Uncallable.setPropertyLocAjax",
                    async : true,
                    type : 'get',
                    dataType : 'json',
                    data : {
                        name : "LAYOUT_HISTORY",
                        lang : loc,
                        value : value
                    },
                    success : function(data){
                        alert("저장되었습니다.");
                    },
                    error : function(a, b, c){
                        alert(a + "/" + b + "/"+ c);
                    }
                });
            }

            function executeJson(){
                var tds = $(".jYear");
                var inputs = $(".jContent");
                var langPair = [];
                for(var e = 1; e < tds.length; e++){
                    if(tds.eq(e).val() == "#"){
                        continue;
                    }
                    langPair.push({
                        year : tds.eq(e).val(),
                        content : inputs.eq(e).val()
                    });
                }

                return JSON.stringify(langPair);
            }

            $(".jAdd").click(function(){
                addContainer("", "");
            });

            $(document).on("click", ".jRemove", function(){
                $(this).parent().parent().remove();
            });

            $(".jSave").click(function(){
                var json = executeJson();
                var loc = $(".jLang").val();
                if(json == ""){
                    alert("올바른 값을 입력하세요.");
                    return;
                }
                setHistoryJson(loc, json);
            });

        });
    </script>

<div id="templateContainer" style="display: none;">
    <div class="input-group mb-3">
        <div class="input-group-prepend">
            <span class="input-group-text"><select class="jSelectYear jYear" year="2017"></select></span>
            <button class="btn btn-danger jRemove" value="X" >X</button>
        </div>
        <input type="text" placeholder="내용을 입력하세요" class="form-control jContent" value="#{content}">
    </div>
</div>

    <div id="content-wrapper">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">홈페이지관리</li>
                <li class="breadcrumb-item active">연혁</li>
            </ol>

            <div class="btn-group float-right mb-2" role="group">
                <select class="custom-select mr-2 jLang" id="inputGroupSelect01">
                    <?foreach($langList as $item){?>
                        <option value="<?=$item["code"]?>"><?=$item["desc"]?></option>
                    <?}?>
                </select>
                <a href="#" class="jSave btn btn-secondary mr-2">저장</a>
            </div>


            <h2>연혁 관리</h2>

            <br/>

            <div id="yContainer"></div>

            <a href="#" class="float-right jAdd btn btn-dark"><i class="fas fa-plus fa-fw"></i> 연혁 추가</a>

        </div>
        <!-- /.container-fluid -->
    </div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>