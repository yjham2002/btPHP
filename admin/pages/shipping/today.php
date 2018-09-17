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
<link rel="stylesheet" href="/admin/scss/smSheet.css">
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

        $("#jCheckAll").change(function(){
            if($(this).is(":checked"))
                $(".jShip").prop("checked", true);
            else
                $(".jShip").prop("checked", false);
        });


        // 아래로 참조용 소스
        $(".jDel").click(function(){
            var noArr = new Array();
            var noCount = $(".jStage:checked").length;
            if(noCount == 0){
                alert("삭제할 항목을 하나 이상 선택해주세요.");
                return false;
            }
            if(confirm("삭제하시겠습니까?")){
                for(var i = 0; i < noCount; i++ ) noArr[i] = $(".jStage:checked:eq(" + i + ")").val();
                deleteStage(noArr);
            }
        });

        function deleteStage(noArr){
            var ajax = new AjaxSender("/action_front.php?cmd=AdminMain.deleteStage", false, "json", new sehoMap().put("no", noArr));
            ajax.send(function(data){
                if(data.returnCode == 1){
                    alert("삭제되었습니다");
                    location.reload();
                }
            });
        }
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
                <th>
                    <input type="checkbox" id="jCheckAll">
                </th>
                <th>이름</th>
                <th>연락처</th>
                <th>주소</th>
                <th>품명</th>
                <th>담당자</th>
                <th>유형</th>
                <th>배송사고 이력</th>
            </tr>
            </thead>
            <tbody class="jType0">
            <?foreach($list0 as $item0){?>
                <tr>
                    <td><input type="checkbox" class="jShip"></td>
                    <td><?=$item0["rName"]?></td>
                    <td><?=$item0["phone"]?></td>
                    <td><?=$item0["addr"] . $item0["addrDetail"]?></td>
                    <td><?=$item0["publicationName"]?></td>
                    <td><?=$item0["manager"]?></td>
                    <td><?=$item0["type"] == "0" ? "신규배송" : "재배송"?></td>
                    <td><?=$item0["publicationName"]?></td>
                </tr>
            <?}?>
            </tbody>
            <tbody class="jType1" style="display: none;">
            <?foreach($list1 as $item1){?>
                <tr>
                    <td><input type="checkbox" class="jShip"></td>
                    <td><?=$item1["rName"]?></td>
                    <td><?=$item1["phone"]?></td>
                    <td><?=$item1["addr"] . $item1["addrDetail"]?></td>
                    <td><?=$item1["publicationName"]?></td>
                    <td><?=$item1["manager"]?></td>
                    <td><?=$item1["type"] == "0" ? "신규배송" : "재배송"?></td>
                    <td><?=$item1["publicationName"]?></td>
                </tr>
            <?}?>
            </tbody>
        </table>
    </div>
</div>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
