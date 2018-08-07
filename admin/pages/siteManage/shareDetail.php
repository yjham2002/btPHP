<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 7.
 * Time: PM 5:28
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<?
    $obj = new AdminMain($_REQUEST);
    $langList = $obj->getLocale();
    $item = $obj->shareCategoryDetail();
?>
<script>
    $(document).ready(function(){
        $("[name=imgFile]").change(function(){
            readURL(this);
            $("#imgPath").val("");
        });

        function readURL(input){
            if (input.files && input.files[0]){
                var reader = new FileReader();
                reader.onload = function(e){
                    $(".jImg").attr("src", e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".jSave").click(function(){
            var ajax = new AjaxSubmit("/action_front.php?cmd=AdminMain.upsertCategory", "post", true, "json", "#form");
            ajax.send(function(data){
                if(data.returnCode === 1) location.href = "/admin/pages/siteManage/shareList.php";
                else alert("이미지 저장 실패");
            });
        });
    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Blank Page</li>
        </ol>

        <form method="post" id="form" action="#" enctype="multipart/form-data">
            <input type="hidden" id="<?=$_REQUEST["id"]?>" />

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">언어</span>
                </div>
                <select class="custom-select" id="inputGroupSelect01" name="lang">
                    <option value="">선택</option>
                    <?foreach($langList as $listItem){?>
                        <option value="<?=$listItem["code"]?>" <?=$item["lang"] == $listItem["code"] ? "selected" : ""?>><?=$listItem["desc"]?></option>
                    <?}?>
                </select>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">게시판 이름</span>
                </div>
                <input type="text" class="form-control" name="name" value="<?=$item["name"]?>">
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">게시판 하위 타이틀</span>
                </div>
                <input type="text" class="form-control" name="subTitle" value="<?=$item["subTitle"]?>">
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">쓰기권한</span>
                </div>
                <select class="custom-select" id="inputGroupSelect01" name="writePermission">
                    <option value="">선택</option>
                    <option value="C" <?="C" == $item["writePermission"] ? "selected" : ""?>>회원</option>
                    <option value="E" <?="E" == $item["writePermission"] ? "selected" : ""?>>모두</option>
                </select>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">읽기권한</span>
                </div>
                <select class="custom-select" id="inputGroupSelect01" name="readPermission">
                    <option value="">선택</option>
                    <option value="C" <?="C" == $item["readPermission"] ? "selected" : ""?>>회원</option>
                    <option value="E" <?="E" == $item["readPermission"] ? "selected" : ""?>>모두</option>
                </select>
            </div>

            <div style="text-align: center;">
                <img class="jImg" src="<?=$item["imgPath"] != "" ? $obj->fileShowPath . $item["imgPath"] : ""?>" width="100px;"/>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">썸네일 이미지</span>
                </div>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" name="imgFile" id="inputGroupFile01">
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
            </div>

        </form>
        <button type="button" class="btn btn-secondary float-right jSave">저장</button>

    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>