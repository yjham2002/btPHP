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
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Management.php";?>
<?
    $obj = new Uncallable($_REQUEST);
    $list = $obj->getReportList();
    $flag = $obj->getProperty("FLAG_VALUE_LOST");

    $management = new Management($_REQUEST);
    $list0 = $management->shippingList(0);
    $list1 = $management->shippingList(1);
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function(){
        var selected;

        $(".jTab").click(function(){
            $(".jTab").removeClass("btn-secondary");
            $(this).addClass("btn-secondary");
            selected = $(this).attr("target");
            toggleView();
        });

        function toggleView(){
            if(selected == "0"){
                $(".jType1").hide();
                $(".jType0").fadeIn();
            }else{
                $(".jType0").hide();
                $(".jType1").fadeIn();
            }
        }

        $(".jTog").click(function(){
            var ajax = new AjaxSender("/route.php?cmd=Uncallable.setPropertyAjax", true, "json",
                new sehoMap()
                    .put("name", "FLAG_VALUE_LOST")
                    .put("value", "<?= $flag == 0 ? 1 : 0?>")
            );
            ajax.send(function (data) {
                location.reload();
            });
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
            <li class="breadcrumb-item active">당일 배송 추출</li>
        </ol>

        <button type="button" target="0" class="jTab btn-secondary btn mb-2">우편</button>
        <button type="button" target="1" class="jTab btn mb-2">택배</button>
        <button type="button" class="btn <?=$flag == 0 ? "btn-secondary" : "btn-primary"?> float-right mb-2 jTog">자동등록 <?=$flag == 0 ? "OFF" : "ON"?></button>

        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th></th>
                <th>이름</th>
                <th>연락처</th>
                <th>주소</th>
                <th>품명</th>
                <th>담당자</th>
                <th>유형</th>
                <th>배송사고 이력</th>
            </tr>
            </thead>
            <tbody>
            <?
            $vnum = $obj->virtualNum;
            foreach($list as $item){?>
                <tr>
                    <td sid="<?=$item["id"]?>" class="jView"><?=$vnum--?></td>
                    <td sid="<?=$item["id"]?>" class="jView"><?=$item["title"]?></td>
                    <td sid="<?=$item["id"]?>" class="jView"><?=$item["name"]?></td>
                    <td sid="<?=$item["id"]?>" class="jView"><?=$item["regDate"]?></td>
                    <td>
                        <button type="button" id="<?=$item["id"]?>" class="btn-sm btn-secondary mb-2 jMod">수정</button>
                        <button type="button" fid="<?=$item["id"]?>" class="btn-sm btn-danger mb-2 jDelF">삭제</button>
                    </td>
                </tr>
            <?}?>
            </tbody>
        </table>
    </div>
</div>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
