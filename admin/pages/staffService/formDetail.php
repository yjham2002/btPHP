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
            if(confirm("저장하시겠습니까?")){
                var ajax = new AjaxSubmit("/route.php?cmd=Uncallable.upsertDoc", "post", true, "json", "#form");
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("저장되었습니다.");
                        location.href = "/admin/pages/staffService/formList.php";
                    }
                });
            }
        });

        $("[name=docFile]").change(function(){
            var fullPath = $(this).val();
            if(fullPath){
                var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
                var filename = fullPath.substring(startIndex);
                if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) filename = filename.substring(1);
                $(".jLabel").text(filename);
            }
        });

        $(".jCancel").click(function(){
            history.back();
        });

        $(".jFile").change(function(){
            var no = $(this).attr("no");
            var fullPath = $(this).val();
            if(fullPath){
                var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
                var filename = fullPath.substring(startIndex);
                if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) filename = filename.substring(1);
                $(".jLabel" + no).text(filename);
            }
        });

        $(".jClear").click(function(){
            var no = $(this).attr("no");
            $(".jLabel" + no).text("");
            $("[name=docFile]").val("");
            $("[name=filePath]").val("");
            $(".jDown" + no).parent().remove();
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

        <form method="post" id="form" action="#" enctype="multipart/form-data">
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">제목</span>
                </div>
                <input type="hidden" name="id" value="<?=$item["id"]?>" />
                <input type="text" class="form-control jTitle" name="title" value="<?=$item["title"]?>">
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">내용</span>
                </div>
                <textarea class="form-control jContent" name="content"><?=$item["content"]?></textarea>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">첨부파일</span>
                </div>
                <div class="custom-file">
                    <input type="hidden" name="filePath" value="<?=$item["filePath"]?>"/>
                    <input type="hidden" name="fileName" value="<?=$item["fileName"]?>"/>
                    <input type="file" class="custom-file-input jFile" no="1" name="docFile" id="inputGroupFile01">
                    <label class="custom-file-label jLabel1" for="inputGroupFile01"><?=$item["fileName"] == "" ? "파일을 선택하세요" : $item["fileName"]?></label>
                </div>
            </div>

<!--            <div class="input-group mb-3">-->
<!--                <a href="--><?//=$item["filePath"] != "" ? $obj->fileShowPath . $item["filePath"] : ""?><!--" id="file" download="--><?//=$item["fileName"]?><!--">-->
<!--                    <label for="file">--><?//=$item["fileName"]?><!--</label>-->
<!--                </a>-->
<!--            </div>-->

            <div class="input-group mb-3">
                <a class="jDown1" href="<?=$item["filePath"] != "" ? $obj->fileShowPath . $item["filePath"] : ""?>" id="file3" download="<?=$item["fileName"]?>">
                    <label style="color:black;" for="file3"><?=$item["fileName"]?></label>
                </a>
                <a no="1" class="btn-sm btn-danger ml-2 text-white jClear"> X </a>
            </div>
        </form>


    </div>
    <!-- /.container-fluid -->
</div>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
