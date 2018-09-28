<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 1.
 * Time: PM 4:38
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Management.php";?>
<?
    $obj = new Management($_REQUEST);
    $obj2 = new AdminMain($_REQUEST);

    $stat = $obj->stockDetail();

    $list = $obj->stockHistory();
?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<!--<link rel="stylesheet" href="/admin/scss/smSheet.css">-->
<script>
    $(document).ready(function(){
        $(".datePicker").datepicker({
            showMonthAfterYear:true,
            inline: true,
            changeMonth: true,
            changeYear: true,
            dateFormat : 'yy-mm-dd',
            dayNamesMin:['일', '월', '화', '수', '목', '금', ' 토'],
            monthNames:['1월','2월','3월','4월','5월','6월','7 월','8월','9월','10월','11월','12월'],
            monthNamesShort:['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월']
        });

        $(".jPage").click(function(){
            $("[name=page]").val($(this).attr("page"));
            form.submit();
        });

        $(".jSearch").click(function(){
            form.submit();
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
            <li class="breadcrumb-item active">재고현황 조회</li>
        </ol>

        <form id="form">
            <input type="hidden" name="page" />

            <div class="input-group mb-3">
                <select class="custom-select mr-2 col-2" id="startYear" name="year">
                    <option value="">선택</option>
                    <?for($i=-50; $i<50; $i++){
                        $tmp = intval(date("Y")) + $i;
                        ?>
                        <option value="<?=$tmp?>" <?=$_REQUEST["year"] == $tmp ? "selected" : ""?>><?=$tmp?></option>
                    <?}?>
                </select>
                <select class="custom-select mr-2 col-2" name="month">
                    <option value="">선택</option>
                    <?for($i=1; $i<13; $i++){?>
                        <option value="<?=$i?>" <?=$_REQUEST["month"] == $i ? "selected" : ""?>><?=$i?></option>
                    <?}?>
                </select>
                <button type="button" class="btn btn-secondary ml-2 jSearch">
                    <i class="fas fa-search fa-fw"></i>
                </button>

                <div class="btn-group float-right ml-5">
                    <button type="button" class="btn btn-secondary float-right jTranscendanceExcel">Excel</button>
                </div>
            </div>
        </form>

        <table class="table table-bordered table-sm text-center">
            <thead>
            <tr>
                <th width="20%">버전</th>
                <th width="20%">미국판</th>
                <th width="20%">한국판</th>
                <th width="20%">광고</th>
                <th width="20%">합계</th>
            </tr>
            </thead>
            <tbody>
            <?foreach($stat as $sItem){?>
                <tr>
                    <td><?=$sItem["desc"]?></td>
                    <td><?=$sItem["stat"]["0"]?></td>
                    <td><?=$sItem["stat"]["1"]?></td>
                    <td><?=$sItem["stat"]["2"]?></td>
                    <td><?=intval($sItem["stat"]["0"]) + intval($sItem["stat"]["1"]) + intval($sItem["stat"]["2"])?></td>
                </tr>
            <?}?>
            </tbody>
        </table>

        <table class="table table table-sm text-center">
            <thead>
            <tr>
                <th>등록일시</th>
                <th>배송 거래처</th>
                <th>입고/출고</th>
                <th>버전</th>
                <th>담당자</th>
                <th>수량</th>
                <th>연도</th>
                <th>월호</th>
                <th>받는사람</th>
                <th>내용</th>
            </tr>
            </thead>
            <tbody>
            <?foreach($list as $item){?>
                <tr>
                    <td><?=$item["regDate"]?></td>
                    <td><?=$item["shippingCoDesc"]?></td>
                    <td><?=$item["cnt"] > 0 ? "입고" : "출고"?></td>
                    <td><?=$item["publicationName"]?></td>
                    <td><?=$item["adminName"]?></td>
                    <td><?=$item["cnt"]?></td>
                    <td><?=$item["pYear"]?></td>
                    <td><?=$item["pMonth"]?></td>
                    <td><?=$item[""]?> TODO</td>
                    <td><?=$item["content"]?></td>
                </tr>
            <?}?>
            </tbody>
        </table>
        <?include $_SERVER["DOCUMENT_ROOT"] . "/admin/inc/pageNavigator.php";?>
    </div>
</div>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>

