<?php
/**
 * Created by PhpStorm.
 * User: 전세호
 * Date: 2018-08-23
 * Time: 오후 3:02
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<?
    $obj = new AdminMain($_REQUEST);
    $item = $obj->getAdmin();
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function(){
        $(".jSave").click(function(){
            if(confirm("저장하시겠습니까?")){
                var ajax = new AjaxSubmit("/route.php?cmd=AdminMain.upsertAdmin", "post", true, "json", "#form");
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("저장되었습니다.");
                        location.href = "/admin/pages/staffService/adminList.php";
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
            <li class="breadcrumb-item ">관리자</li>
            <li class="breadcrumb-item active">관리자 등록/수정</li>
        </ol>

        <div class=" float-right">
            <button type="button" class="btn btn-secondary mb-2 jSave">저장</button>
            <button type="button" class="btn btn-danger mb-2 jCancel">취소</button>
        </div>

        <form method="post" id="form" action="#" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$item["id"]?>" />
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">관리자 계정</span>
                </div>
                <input class="form-control" name="account" value="<?=$item["account"]?>">
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">관리자 이름</span>
                </div>
                <input class="form-control" name="name" value="<?=$item["name"]?>">
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">비밀번호</span>
                </div>
                <input type="text" class="form-control" name="password" value="">
            </div>
        </form>
    </div>
</div>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>

