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
$list = $obj->getContinents();
$nations = $obj->getAllNation();
$selected = $obj->getProperty("CONST_SUPPORT_NATION");

?>
<script>
    $(document).ready(function(){

        $(".jManage").click(function(){
            location.href="/admin/pages/siteManage/continentManage.php?id=" + $(this).attr("id");
        });

        $(".jSave").click(function(){
            var ajax = new AjaxSender(
                "/route.php?cmd=Uncallable.setPropertyAjax",
                true, "json",
                new sehoMap().put("name", "CONST_SUPPORT_NATION").put("value", $(".jNation").val()));
            ajax.send(function(data){
                if(data.returnCode === 1){
                    alert("저장되었습니다.");
                }
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
            <li class="breadcrumb-item active">후원 관리</li>
        </ol>

        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">후원 메인 페이지 표시 국가</span>
            </div>
            <select class="custom-select mr-2 jNation col-5" id="inputGroupSelect01">
                <?foreach($nations as $item){?>
                    <option value="<?=$item["id"]?>" <?=$selected == $item["id"] ? "SELECTED" : "" ?> ><?=$item["desc"]?></option>
                <?}?>
            </select>
            <a href="#" class="jSave btn btn-secondary">저장</a>
        </div>

        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th width="60%">대륙 구분(코드)</th>
                <th width="25%">등록 국가</th>
                <th>-</th>
            </tr>
            </thead>
            <tbody>
            <?foreach($list as $item){?>
                <tr class="" id="<?=$item["id"]?>">
                    <td><?=$item["name"]?>(<?=$item["continentCode"]?>)</td>
                    <td><?=$item["ncnt"]?></td>
                    <td>
                        <button type="button" id="<?=$item["id"]?>" class="btn btn-secondary jManage">관리</button>
                    </td>
                </tr>
            <?}?>
            </tbody>
        </table>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
