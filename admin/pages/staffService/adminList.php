<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 20.
 * Time: PM 4:44
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<?
    $obj = new AdminMain($_REQUEST);
    $list = $obj->adminList();
?>

<script>
    $(document).ready(function(){

        $(".jSave").click(function(){
            var desc = $(".jTitle").val();
            var ajax = new AjaxSender("/route.php?cmd=AdminMain.initFaq", true, "json", new sehoMap().put("desc", desc));
            ajax.send(function(data){
                if(data.returnCode === 1){
                    location.href = "/admin/pages/siteManage/faqDetail.php?id=" + data.entity;
                }
            });
        });

        $(".jDel").click(function(){
            if(confirm("해당 FAQ 및 하위 계층 다국어 FAQ 게시글이 모두 삭제되며, 복구할 수 없습니다.\n정말 삭제하시겠습니까?")) {
                var id = $(this).attr("fid");
                var ajax = new AjaxSender("/route.php?cmd=Uncallable.deleteFaq", true, "json", new sehoMap().put("id", id));
                ajax.send(function (data) {
                    location.reload();
                });
            }
        });

        $(".jView").click(function(){
            var id = $(this).attr("id");
            location.href = "/admin/pages/siteManage/faqDetail.php?id=" + id + "&langCode=kr";
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
            <li class="breadcrumb-item active">관리자</li>
        </ol>

        <button type="button" class="btn btn-secondary float-right mb-2 jAdd">추가</button>

        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>관리자 계정</th>
                <th>관리자 이름</th>
                <th>등록일시</th>
                <th>-</th>
            </tr>
            </thead>
            <tbody>
            <?foreach($list as $item){?>
                <tr class="" id="<?=$item["id"]?>">
                    <td><?=$item["account"]?></td>
                    <td><?=$item["name"]?></td>
                    <td><?=$item["regDate"]?></td>
                    <td>
                        <button type="button" id="<?=$item["id"]?>" class="btn btn-secondary mb-2 jView">관리</button>
                        <button type="button" fid="<?=$item["id"]?>" class="btn btn-danger mb-2 jDelF">삭제</button>
                    </td>
                </tr>
            <?}?>
            </tbody>
        </table>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
