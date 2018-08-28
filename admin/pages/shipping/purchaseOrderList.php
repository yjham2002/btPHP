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
$list = $obj->getKakaoList();

?>

<script>
    $(document).ready(function(){
        $(".jPage").click(function(){
            var page = $(this).attr("page");
            var range = $("[name=dateRange]:checked").val();
            var year = $("#jYear").val();
            var month = $("#jMonth").val();
            location.href="/admin/pages/shipping/purchaseOrderList.php?" +
                "page=" + page + "&" +
                "range=" + range + "&" +
                "year=" + year + "&" +
                "month=" + month;
        });

        $(".jSearch").click(function(){
            var page = $(".pageNum").val();
            var range = $("[name=dateRange]:checked").val();
            var year = $("#jYear").val();
            var month = $("#jMonth").val();
            location.href="/admin/pages/shipping/purchaseOrderList.php?" +
                "page=" + page + "&" +
                "range=" + range + "&" +
                "year=" + year + "&" +
                "month=" + month;
        });

        $(".jDetail").click(function(){
            location.href = "/admin/pages/shipping/purchaseOrderDetail.php"
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
                            <select class="custom-select mr-2" id="jYear">
                                <?for($e = intval(date("Y")) + 5; $e >= 1950 ; $e--){?>
                                    <option value="<?=$e?>" <?=$_REQUEST["year"] == $e ? "SELECTED" : ""?>><?=$e?>년</option>
                                <?}?>
                            </select>
                            <select class="custom-select mr-2" id="jMonth">
                                <?for($e = 1; $e <= 12; $e++){
                                    $temp = $e < 10 ? "0".$e : $e;
                                    ?>
                                    <option value="<?=$e < 10 ? "0".$e : $e?>" <?=$_REQUEST["month"] == $temp ? "SELECTED" : ""?>><?=$e < 10 ? "0".$e : $e?>월</option>
                                <?}?>
                            </select>
                            <button type="button" class="btn btn-primary jSearch">조회</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <table class="table">
            <thead>
            <tr>
                <th>No.</th>
                <th>년도</th>
                <th>월호</th>
                <th>유형</th>
                <th>등록번호</th>
                <th>발주서</th>
                <th>등록일자</th>
                <th>상세</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>2018</td>
                <td>01</td>
                <td>미국판</td>
                <td>610-82-78048</td>
                <td><button type="button" class="btn btn-secondary btn-sm">발주서</button></td>
                <td>2018-01-01 13:12:13</td>
                <td><button type="button" class="btn btn-secondary btn-sm jDetail">상세</button></td>
            </tr>
            <tr>
                <td>1</td>
                <td>2018</td>
                <td>01</td>
                <td>미국판</td>
                <td>610-82-78048</td>
                <td><button type="button" class="btn btn-secondary btn-sm">발주서</button></td>
                <td>2018-01-01 13:12:13</td>
                <td><button type="button" class="btn btn-secondary btn-sm jDetail">상세</button></td>
            </tr>
            <tr>
                <td>1</td>
                <td>2018</td>
                <td>01</td>
                <td>미국판</td>
                <td>610-82-78048</td>
                <td><button type="button" class="btn btn-secondary btn-sm">발주서</button></td>
                <td>2018-01-01 13:12:13</td>
                <td><button type="button" class="btn btn-secondary btn-sm jDetail">상세</button></td>
            </tr>
            </tbody>
        </table>
        <?include $_SERVER["DOCUMENT_ROOT"] . "/admin/inc/pageNavigator.php";?>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
