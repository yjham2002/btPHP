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
$list = $obj->getReportList();
$flag = $obj->getProperty("FLAG_VALUE_LOST");

?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function(){

        $(".jPage").click(function(){
            location.href="/admin/pages/shipping/formList.php?page=" + $(this).attr("page");
        });

        $(".jAdd").click(function(){
            location.href="/admin/pages/shipping/formDetail.php";
        });

        $(".jDelF").click(function(){
            if(confirm("정말 삭제하시겠습니까?")) {
                var id = $(this).attr("fid");
                var ajax = new AjaxSender("/route.php?cmd=Uncallable.deleteReport", true, "json", new sehoMap().put("id", id));
                ajax.send(function (data) {
                    location.reload();
                });
            }
        });

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

        $(".jMod").click(function(e){
            e.stopPropagation();
            var id = $(this).attr("id");
            location.href="/admin/pages/shipping/formDetail.php?id=" + id;
        });

        $(".jView").click(function(){
            var id = $(this).attr("sid");
            location.href="/admin/pages/shipping/formView.php?id=" + id;
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

        <button type="button" class="btn <?=$flag == 0 ? "btn-secondary" : "btn-primary"?> float-right mb-2 jTog">자동등록 <?=$flag == 0 ? "OFF" : "ON"?></button>

        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>No.</th>
                <th>제목</th>
                <th>최종작성자</th>
                <th>작성일자</th>
                <th>-</th>
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

        <?include $_SERVER["DOCUMENT_ROOT"] . "/admin/inc/pageNavigator.php";?>
    </div>
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
