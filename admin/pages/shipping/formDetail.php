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
$item = $obj->getReport();
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
                var ajax = new AjaxSubmit("/route.php?cmd=Uncallable.upsertReport", "post", true, "json", "#form");
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("저장되었습니다.");
                        location.href = "/admin/pages/shipping/formList.php";
                    }
                });
            }
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

        $(".jCancel").click(function(){
            history.back();
        });

        $(".jClear").click(function(){
            var no = $(this).attr("no");
            $(".jLabel" + no).text("");
            $("[name=docFile" + no + "]").val("");
            $("[name=filePath" + no + "]").val("");
            $(".jDown" + no).parent().remove();
        });

    });
</script>



<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>배송</a>
            </li>
            <li class="breadcrumb-item ">발주 보고서</li>
            <li class="breadcrumb-item active">발주 보고서 상세</li>
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

            <?for($i = 1; $i <= 5; $i++){?>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">첨부파일 0<?=$i?></span>
                </div>
                <div class="custom-file">
                    <input type="hidden" name="filePath<?=$i?>" value="<?=$item["filePath".$i]?>"/>
                    <input type="hidden" name="fileName<?=$i?>" value="<?=$item["fileName".$i]?>"/>
                    <input type="file" no="<?=$i?>" class="custom-file-input jFile" name="docFile<?=$i?>" id="inputGroupFile0<?=$i?>">
                    <label class="custom-file-label jLabel<?=$i?>" for="inputGroupFile0<?=$i?>"><?=$item["fileName".$i] == "" ? "파일을 선택하세요" : $item["fileName".$i]?></label>
                </div>
            </div>
            <?}?>

            <?
            $cnt = 1;
            for($i = 1; $i <= 5; $i++){
                if($item["filePath".$i] == "") continue;
                ?>
            <div class="input-group mb-1">
                <a class="btn-sm btn-secondary mr-2 text-white"><?=$cnt++?></a>
                <a class="jDown<?=$i?>" href="<?=$item["filePath".$i] != "" ? $obj->fileShowPath . $item["filePath".$i] : ""?>" id="file<?=$i?>" download="<?=$item["fileName".$i]?>">
                    <label style="color:black;" for="file<?=$i?>"><?=$item["fileName".$i]?></label>
                </a>
                <a no="<?=$i?>" class="btn-sm btn-danger ml-2 text-white jClear" href="#"> X </a>
            </div>
            <?}?>
        </form>


    </div>
    <!-- /.container-fluid -->
</div>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
