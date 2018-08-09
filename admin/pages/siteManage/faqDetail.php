<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 8.
 * Time: PM 5:30
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<?
    $obj = new AdminMain($_REQUEST);
    $langList = $obj->getLocale();
    $item = $obj->faqDetail();
?>

    <script>
        $(document).ready(function(){
            $("[name=content]").text($("[name=content]").text().replace(/<br\s?\/?>/g,""));

            $(".jLang").change(function(){
                form.submit();
            });

            $(".jSave").click(function(){
                var ajax = new AjaxSubmit("/route.php?cmd=AdminMain.upsertFaq", "post", true, "json", "#form");
                ajax.send(function(data){
                    if(data.returnCode === 1) location.reload();
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
                <li class="breadcrumb-item active">faq 관리</li>
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
                        <span class="input-group-text" id="basic-addon3">질문</span>
                    </div>
                    <input type="text" class="form-control" name="question" value="<?=$item["question"]?>">
                </div>

                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">답변</span>
                    </div>
                    <textarea type="text" class="form-control" name="content"><?=$item["content"]?></textarea>
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