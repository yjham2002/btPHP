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
$cId = $_REQUEST["id"];

if($cId == ""){
    echo "<script>
            alert('비정상적인 접근입니다.');
            history.back();
            </script>";
}

$continent = $obj->getContinent($cId);
$list = $obj->getNations($cId);
?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function(){
        var addPop = $("#jAddPop");
        addPop.draggable();

        $(".jAdd").click(function(){
            addPop.fadeIn();
        });

        $(".jManage").click(function(){
            location.href = "/admin/pages/siteManage/nationManage.php?id=" + $(this).attr("id") + "&fid=" + "<?=$_REQUEST["id"]?>";
        });

        $(".jSave").click(function(){
            var continent = "<?=$cId?>";
            var desc = $(".jTitle").val();
            var ajax = new AjaxSender(
                "/route.php?cmd=AdminMain.initNation",
                true, "json",
                new sehoMap().put("desc", desc).put("fContinent", continent));
            ajax.send(function(data){
                if(data.returnCode === 1){
                    location.href = "/admin/pages/siteManage/nationManage.php?id=" + data.entity + "&fid=" + "<?=$_REQUEST["id"]?>";
                }
            });
        });

        $(".jDelete").click(function(){
            if(confirm("해당 국가에 소속된 모든 후원글이 삭제되며, 복구되지 않습니다.\n정말 삭제하시겠습니까?")){
                var ajax = new AjaxSender(
                    "/route.php?cmd=AdminMain.deleteNation",
                    true, "json",
                    new sehoMap().put("id", $(this).attr("id")));
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("삭제되었습니다.");
                        location.reload();
                    }
                });
            }
        });

        $(".jClosePop").click(function(){
            addPop.fadeOut();
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
            <li class="breadcrumb-item">후원 관리</li>
            <li class="breadcrumb-item active">대륙 정보 관리(<?=$continent["name"]?>)</li>
        </ol>

        <button type="button" class="btn btn-secondary float-right mb-2 jAdd">추가</button>

        <div id="jAddPop" style="
            padding : 30px 30px; width : 500px;
            border : 1px solid black; position : absolute; left : calc(50vw - 250px); top : calc(50vh); background : white; display: none;"
        >
            <a href="#" class="jClosePop float-right" ><img src="./attr/btn_close.png" width="30px" height="30px" /></a>
            국가명(관리용)
            <br/><br/>
            <input type="text" class="form-control jTitle" placeholder="내용을 입력하세요" />
            <br/>
            <button type="button" class="btn btn-secondary mb-2 jSave">추가</button>
            <button type="button" class="btn btn-danger mb-2 jClosePop">취소</button>
        </div>

        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>No.</th>
                <th width="65%">국가명(관리용)</th>
                <th>-</th>
            </tr>
            </thead>
            <tbody>
            <?
            $cnt = 1;
            foreach($list as $item){?>
                <tr class="" id="<?=$item["id"]?>">
                    <td><?=$cnt++?></td>
                    <td><?=$item["desc"]?></td>
                    <td>
                        <button type="button" id="<?=$item["id"]?>" class="btn btn-secondary jManage">관리</button>
                        <button type="button" id="<?=$item["id"]?>" class="btn btn-danger jDelete">삭제</button>
                    </td>
                </tr>
            <?}?>
            </tbody>
        </table>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
