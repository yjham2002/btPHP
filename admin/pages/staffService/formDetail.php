<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 8.
 * Time: PM 5:09
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Uncallable.php";?>
<?
$obj = new Uncallable($_REQUEST);
$item = $obj->getDoc();
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function(){

        function resizeTextArea(){
            var arr = $("textarea");
            for(var e = 0; e < arr.length; e++){
                arr.eq(e).height(arr.eq(e).prop('scrollHeight'));
            }
        }

        resizeTextArea();

        $(".jSave").click(function(){
            var id = $(".jId").val();
            var title = $(".jTitle").val();
            var content = $(".jContent").val();

            if(confirm("저장하시겠습니까?")){
                var ajax = new AjaxSender("/route.php?cmd=Uncallable.upsertDoc", true, "json",
                    new sehoMap().put("id", id).put("title", title).put("content", content));
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("저장되었습니다.");
                        location.href = "/admin/pages/staffService/formList.php";
                    }
                });
            }

        });

        $(".jCancel").click(function(){
            history.back();
        });

    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>직원서비스</a>
            </li>
            <li class="breadcrumb-item ">문서 서식</li>
            <li class="breadcrumb-item active">문서 서식 상세</li>
        </ol>

        <div class=" float-right">
            <button type="button" class="btn btn-secondary mb-2 jSave">저장</button>
            <button type="button" class="btn btn-danger mb-2 jCancel">취소</button>
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">제목</span>
            </div>
            <input type="hidden" class="jId" value="<?=$item["id"]?>" />
            <input type="text" class="form-control jTitle" name="title" value="<?=$item["title"]?>">
        </div>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">내용</span>
            </div>
            <textarea class="form-control jContent" name="content"><?=$item["content"]?></textarea>
        </div>
        <!---->
        <!--        <div class="input-group mb-3">-->
        <!--            <div class="input-group-prepend">-->
        <!--                <span class="input-group-text" id="basic-addon3">첨부파일</span>-->
        <!--            </div>-->
        <!--            <div class="custom-file">-->
        <!--                <input type="hidden" name="imgPath" value="--><?//=$item["imgPath"]?><!--"/>-->
        <!--                <input type="file" class="custom-file-input" name="imgFile" id="inputGroupFile01">-->
        <!--                <label class="custom-file-label jLabel" for="inputGroupFile01">--><?//=$item["fileName"] == "" ? "파일을 선택하세요" : $item["fileName"]?><!--</label>-->
        <!--            </div>-->
        <!--        </div>-->

    </div>
    <!-- /.container-fluid -->
</div>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
