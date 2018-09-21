<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 9. 20.
 * Time: PM 6:26
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Management.php";?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<?
    $obj = new Management($_REQUEST);
    $list = $obj->deliveryHistory();
?>
<script>
    $(document).ready(function(){
        $(".jUploadExcel").click(function(){
            $("[name=docFile]").click();
        });

        $("[name=docFile]").change(function(){
            if($(this).val() != ""){
                var ajax = new AjaxSubmit("/route.php?cmd=ExcelParser.parseDeliveryHistory", "post", true, "json", "#form");
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("저장되었습니다.");
                        location.reload();
                    }else if(data.returnCode == -1){
                        var err = data.entity;
                        if(err == null || err == "") err = "#";
                        alert("파일을 읽는 중 오류가 발생하였습니다. (" + err + ")");
                    }
                });
            }
        });
    });
</script>
<div id="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>고객관리</a>
            </li>
            <li class="breadcrumb-item active">고객정보</li>
            <li class="breadcrumb-item active">고객정보 상세</li>
            <li class="breadcrumb-item active">배송조회</li>
        </ol>

        <form id="form">
            <input type="hidden" name="id" value="<?=$_REQUEST["id"]?>"/>
            <input type="file" name="docFile" style="display: none;"/>
        </form>
        <div class="btn-group float-right mb-2" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-secondary mr-2 jUploadExcel"><i class="fas fa-upload fa-fw"></i>Excel</button>
        </div>

        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>이름</th>
                <th>발송날짜</th>
                <th>버전/월호</th>
                <th>수량</th>
                <th>주소</th>
                <th>등록일시</th>
            </tr>
            </thead>
            <tbody>
            <?foreach($list as $item){?>
                <tr>
                    <td><?=$item["name"]?></td>
                    <td><?=$item["shippingDate"]?></td>
                    <td><?=$item["info"]?></td>
                    <td><?=$item["cnt"]?></td>
                    <td><?=$item["addr"]?></td>
                    <td><?=$item["regDate"]?></td>
                </tr>
            <?}?>
            </tbody>
        </table>
        <? include $_SERVER["DOCUMENT_ROOT"] . "/admin/inc/pageNavigator.php";?>
    </div>
</div>

<? include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/footer.php"; ?>
