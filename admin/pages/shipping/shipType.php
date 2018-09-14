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
$list = $obj->getTypeList(0);

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

        $(".jSave").click(function(){
            var desc = $(".jTitle").val();
            var ajax = new AjaxSender(
                "/route.php?cmd=Uncallable.upsertTypeAjax",
                true, "json",
                new sehoMap().put("desc", desc).put("type", 0));
            ajax.send(function(data){
                if(data.returnCode === 1){
                    location.reload();
                }
            });
        });

        $(".jDelete").click(function(){
            if(confirm("본 기능은 복구되지 않으며, 해당 삭제로 인해 예기치 못한 오류가 발생할 수 있습니다.\n정말 삭제하시겠습니까?")){
                var ajax = new AjaxSender(
                    "/route.php?cmd=Uncallable.deleteTypeAjax",
                    true, "json",
                    new sehoMap().put("id", $(this).attr("tid")));
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
                <a>배송</a>
            </li>
            <li class="breadcrumb-item active">배송 타입 설정</li>
        </ol>

        <div id="jAddPop" style="
            padding : 30px 30px; width : 500px;
            border : 1px solid black; position : absolute; left : calc(50vw - 250px); top : calc(50vh); background : white; display: none;"
        >
            <a href="#" class="jClosePop float-right" ><img src="./attr/btn_close.png" width="30px" height="30px" /></a>
            속성명
            <br/><br/>
            <input type="text" class="form-control jTitle" placeholder="내용을 입력하세요" />
            <br/>
            <button type="button" class="btn btn-secondary mb-2 jSave">저장</button>
            <button type="button" class="btn btn-danger mb-2 jClosePop">취소</button>
        </div>

        <button type="button" class="btn btn-secondary float-right mb-2 jAdd">추가</button>

        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>속성번호</th>
                <th>속성명</th>
                <th width="15%">-</th>
            </tr>
            </thead>
            <tbody>
            <?
            foreach($list as $item){?>
                <tr>
                    <td class="jView"><?=$item["id"]?></td>
                    <td class="jView"><?=$item["desc"]?></td>
                    <td>
                        <button type="button" tid="<?=$item["id"]?>" class="btn-sm btn-danger mb-2 jDelete">삭제</button>
                    </td>
                </tr>
            <?}?>
            </tbody>
        </table>
    </div>
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
