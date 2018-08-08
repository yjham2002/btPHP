<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 8.
 * Time: PM 1:29
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<?
    $obj = new AdminMain($_REQUEST);
    $langList = $obj->getLocale();
    $item = $obj->publicationDetail();
?>
<script>
    $(document).ready(function(){
        $(".jLang").change(function(){
            form.submit();
        });

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
            var ajax = new AjaxSubmit("/route.php?cmd=AdminMain.upsertPublication", "post", true, "json", "#form");
            ajax.send(function(data){
                if(data.returnCode === 1){
                    location.href = "/admin/pages/siteManage/publicationDetail.php?id=" + data.entity + "&langCode=<?=$_REQUEST["langCode"]?>";
                }
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
                <a>홈페이지 관리</a>
            </li>
            <li class="breadcrumb-item active">간행물 관리</li>
        </ol>

        <form method="post" id="form" action="#" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$_REQUEST["id"]?>" />

            <select class="custom-select jLang w-25 mb-2" id="inputGroupSelect01" name="langCode">
                <option value="">선택</option>
                <?foreach($langList as $listItem){?>
                    <option value="<?=$listItem["code"]?>" <?=$_REQUEST["langCode"] == $listItem["code"] ? "selected" : ""?>><?=$listItem["desc"]?></option>
                <?}?>
            </select>
            <button type="button" class="btn btn-secondary float-right mb-2 jSave">현재 언어 저장</button>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">간행물 이름</span>
                </div>
                <input type="text" class="form-control" name="name" value="<?=$item["name"]?>">
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">가격(통화 포함)</span>
                </div>
                <input type="text" class="form-control" name="price" value="<?=$item["price"]?>">
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">할인된 가격(통화 포함)</span>
                </div>
                <input type="text" class="form-control" name="discounted" value="<?=$item["discounted"]?>">
            </div>

            <div style="text-align: center;">
                <img class="jImg" src="<?=$item["imgPath"] != "" ? $obj->fileShowPath . $item["imgPath"] : ""?>" width="100px;"/>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">썸네일 이미지</span>
                </div>
                <div class="custom-file">
                    <input type="hidden" name="imgPath" value="<?=$item["imgPath"]?>"/>
                    <input type="file" class="custom-file-input" name="imgFile" id="inputGroupFile01">
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
            </div>

            <table class="table table-sm text-center">
                <colgroup>
                    <col width="30%"/>
                    <col width="70%"/>
                </colgroup>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">
                        노출여부
                    </td>
                    <td>
                        <input class="mr-2 form-control" id="exposure" type="checkbox" name="exposure" <?="1" == $item["exposure"] ? "checked" : ""?>>
                    </td>
                </tr>
            </table>

        </form>

    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>