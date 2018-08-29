<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 1.
 * Time: PM 2:40
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Uncallable.php";?>
<?
$obj = new Uncallable($_REQUEST);
$list = $obj->getOrderFormList();

?>
<script>
    $(document).ready(function(){
        $(".jPage").click(function(){
            var page = $(this).attr("page");
            var range = $("[name=dateRange]:checked").val();
            var yearS = $("#jYearS").val();
            var monthS = $("#jMonthS").val();
            var yearE = $("#jYearE").val();
            var monthE = $("#jMonthE").val();

            if(yearS > yearE || (yearS == yearE && monthS > monthE)){
                alert("시작일자는 종료일자 이전으로 설정하세요.");
                return;
            }

            location.href="/admin/pages/shipping/purchaseOrderList.php?" +
                "page=" + page + "&" +
                "range=" + range + "&" +
                "yearS=" + yearS + "&" +
                "yearE=" + yearE + "&" +
                "monthS=" + monthS + "&" +
                "monthE=" + monthE;
        });

        $(".jSearch").click(function(){
            var page = $(".pageNum").val();
            var range = $("[name=dateRange]:checked").val();
            var yearS = $("#jYearS").val();
            var monthS = $("#jMonthS").val();
            var yearE = $("#jYearE").val();
            var monthE = $("#jMonthE").val();

            if(yearS > yearE || (yearS == yearE && monthS > monthE)){
                alert("시작일자는 종료일자 이전으로 설정하세요.");
                return;
            }

            location.href="/admin/pages/shipping/purchaseOrderList.php?" +
                "page=" + page + "&" +
                "range=" + range + "&" +
                "yearS=" + yearS + "&" +
                "yearE=" + yearE + "&" +
                "monthS=" + monthS + "&" +
                "monthE=" + monthE;
        });

        $(".jDetail").click(function(){
            var id = $(this).attr("no");
            location.href = "/admin/pages/shipping/purchaseOrderDetail.php?id=" + id;
        });

        $(".jForm").click(function(){
            var id = $(this).attr("no");
            window.open("/admin/writable/order_template.php?id=" + id, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes");
        });

        $(".jAdd").click(function(){
            location.href = "/admin/pages/shipping/purchaseOrderDetail.php"
        });

        $(".jDelete").click(function(){
            var id = $(this).attr("no");
            if(confirm("해당 작업은 복구가 불가능합니다.\n정말 삭제하시겠습니까?")){
                var ajax = new AjaxSender("/route.php?cmd=Uncallable.deleteOrderForm", true, "json", new sehoMap().put("id", id));
                ajax.send(function (data) {
                    location.reload();
                });
            }
        });

    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/admin/index.php">배송</a>
            </li>
            <li class="breadcrumb-item active">발주서 조회</li>
        </ol>

        <form id="form">
            <input type="hidden" name="page" class="pageNum" />

            <div class="col-xl-12 col-sm-12 mb-3">
                <div class="card text-white bg-secondary o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fas fa-fw fa-search"></i>
                        </div>
                        <div class="mr-3">
                            <input type="radio" id="date-all" name="dateRange" value="0" <?=$_REQUEST["range"] == 0 ? "checked" : ""?>>
                            <label for="date-all">전체</label>
                            <input type="radio" id="date-range" name="dateRange" value="1" <?=$_REQUEST["range"] == 1 ? "checked" : ""?>>
                            <label for="date-range">기간</label>
                        </div>
                        <div class="input-group">
                            <span class="form-control">범위</span>
                            <select class="custom-select" id="jYearS">
                                <?for($e = intval(date("Y")) + 5; $e >= 1950 ; $e--){?>
                                    <option value="<?=$e?>" <?=$_REQUEST["yearS"] == $e ? "SELECTED" : ""?>><?=$e?>년</option>
                                <?}?>
                            </select>
                            <select class="custom-select" id="jMonthS">
                                <?for($e = 1; $e <= 12; $e++){
                                    $temp = $e < 10 ? "0".$e : $e;
                                    ?>
                                    <option value="<?=$e < 10 ? "0".$e : $e?>" <?=$_REQUEST["monthS"] == $temp ? "SELECTED" : ""?>><?=$e < 10 ? "0".$e : $e?>월</option>
                                <?}?>
                            </select>
                            <span class="form-control" style="text-align: center;"> ~ </span>
                            <select class="custom-select" id="jYearE">
                                <?for($e = intval(date("Y")) + 5; $e >= 1950 ; $e--){?>
                                    <option value="<?=$e?>" <?=$_REQUEST["yearE"] == $e ? "SELECTED" : ""?>><?=$e?>년</option>
                                <?}?>
                            </select>
                            <select class="custom-select" id="jMonthE">
                                <?for($e = 1; $e <= 12; $e++){
                                    $temp = $e < 10 ? "0".$e : $e;
                                    ?>
                                    <option value="<?=$e < 10 ? "0".$e : $e?>" <?=$_REQUEST["monthE"] == $temp ? "SELECTED" : ""?>><?=$e < 10 ? "0".$e : $e?>월</option>
                                <?}?>
                            </select>
                            <button type="button" class="btn btn-primary jSearch form-control">조회</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="float-right">
            <button type="button" class="btn btn-secondary mb-3 jAdd">발주 입력</button>
        </div>

        <table class="table">
            <thead>
            <tr>
                <th>No.</th>
                <th>년도</th>
                <th>월호</th>
                <th>유형</th>
                <th>발주번호</th>
                <th>발주서</th>
                <th>등록일자</th>
                <th>-</th>
            </tr>
            </thead>
            <tbody>
            <?$vnum = $obj->virtualNum;
            foreach($list as $item){?>
            <tr>
                <td><?=$vnum--?></td>
                <td><?=$item["year"]?></td>
                <td><?=$item["month"]?></td>
                <td><?=$item["type"]?></td>
                <td><?=$item["regNo"]?></td>
                <td><button type="button" no="<?=$item["id"]?>" class="btn btn-secondary btn-sm jForm">발주서</button></td>
                <td><?=$item["regDate"]?></td>
                <td>
                    <button type="button" no="<?=$item["id"]?>" class="btn btn-secondary btn-sm jDetail">상세</button>
                    <button type="button" no="<?=$item["id"]?>" class="btn btn-danger btn-sm jDelete">삭제</button>
                </td>
            </tr>
            <?}?>
            </tbody>
        </table>
        <?include $_SERVER["DOCUMENT_ROOT"] . "/admin/inc/pageNavigator.php";?>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
