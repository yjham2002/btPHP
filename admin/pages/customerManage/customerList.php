<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 7. 27.
 * Time: PM 2:45
 */
?>
<? include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Management.php";?>
<?
    $obj = new Management($_REQUEST);
    $list = $obj->customerList();
?>
<script>
    $(document).ready(function(){
        $(".jPage").click(function(){
            $("[name=page]").val($(this).attr("page"));
            form.submit();
        });

        $(".jView").click(function(){
            var id = $(this).attr("id");
            location.href = "/admin/pages/customerManage/customerDetail.php?id=" + id;
        });

        $(".jSearch").click(function(){form.submit();});

        $(".jDetailSearch").click(function(){
            //TODO 상세검색
        });

        $(".jUploadExcel").click(function(){
            $("[name=docFile]").click();
        });

        $("[name=docFile]").change(function(){
            if($(this).val() != ""){
                var ajax = new AjaxSubmit("/route.php?cmd=ExcelParser.parseCustomerList", "post", true, "json", "#form");
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("저장되었습니다.");
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

<form id="form">
    <input type="file" name="docFile" style="display: none;"/>
</form>

<div id="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>고객관리</a>
            </li>
            <li class="breadcrumb-item active">고객정보</li>
        </ol>

        <form id="form">
            <input type="hidden" name="page"/>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <button type="button" class="btn btn-secondary mr-lg-5 jDetailSearch"><i class="fas fa-search fa-fw"></i></button>
                    <select class="form-control" name="searchType">
                        <option value="">선택</option>
                        <option value="name" <?=$_REQUEST["searchType"] == "name" ? "selected" : ""?>>이름</option>
                        <option value="BO" <?=$_REQUEST["searchType"] == "BO" ? "selected" : ""?>>뱅크오너</option>
                        <option value="phone" <?=$_REQUEST["searchType"] == "phone" ? "selected" : ""?>>전화번호</option>
                        <option value="email" <?=$_REQUEST["searchType"] == "email" ? "selected" : ""?>>이메일</option>
                        <option value="addr" <?=$_REQUEST["searchType"] == "addr" ? "selected" : ""?>>주소</option>
                    </select>
                </div>
                <input type="text" class="form-control mr-2" name="searchText" value="<?=$_REQUEST["searchText"]?>">
                <div class="btn-group float-right" role="group" aria-label="Basic example">
                    <button type="button" class="btn btn-secondary mr-2 jSearch">검색</button>
                    <button type="button" class="btn btn-secondary mr-2 jTranscendanceExcel"><i class="fas fa-download fa-fw"></i>Excel</button>
                    <button type="button" class="btn btn-secondary mr-2 jUploadExcel"><i class="fas fa-upload fa-fw"></i>Excel</button>
                </div>
            </div>
        </form>

        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>구분</th>
                <th>이름</th>
                <th>핸드폰번호</th>
                <th>주소</th>
                <th>등록일시</th>
                <th style="display: none;">숨어이쪄</th>
            </tr>
            </thead>
            <tbody>
            <?foreach($list as $item){?>
                <tr class="jView" id="<?=$item["id"]?>">
                    <td><?=$item["email"]?></td>
                    <td><?=$item["type"] == "1" ? "개인" : "단체"?></td>
                    <td><?=$item["name"]?></td>
                    <td><?=$item["phone"]?></td>
                    <td><?=$item["addr"] . " " . $item["addrDetail"]?></td>
                    <td><?=$item["regDate"]?></td>
                    <td style="display: none;">뀨?</td>
                </tr>
            <?}?>
            </tbody>
        </table>
        <? include $_SERVER["DOCUMENT_ROOT"] . "/admin/inc/pageNavigator.php";?>
    </div>
</div>

<? include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/footer.php"; ?>