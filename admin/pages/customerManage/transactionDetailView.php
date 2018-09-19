<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 1.
 * Time: PM 1:59
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Uncallable.php";?>

<script>
    $(document).ready(function(){

    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">고객 관리</a>
            </li>
            <li class="breadcrumb-item">거래명세서 발송</li>
            <li class="breadcrumb-item active">거래명세서 상세</li>
        </ol>

        <div class="btn-group float-right mb-2" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-secondary mr-2">저장</button>
            <button type="button" class="btn btn-secondary mr-2">저장/전표</button>
            <button type="button" class="btn btn-secondary">취소</button>
        </div>

        <table class="table table-sm table-bordered">
            <thead>
            <tr>
                <th></th>
                <th>품목명</th>
                <th class="col-xs-2">수량</th>
                <th>단가</th>
                <th>금액</th>
                <th>비고</th>
                <th>적요</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td><input type="text" class="form-control"></td>
                <td><input type="text" class="form-control col-6"></td>
                <td><input type="text" class="form-control"></td>
                <td><input type="text" class="form-control"></td>
                <td><input type="text" class="form-control"></td>
                <td><input type="text" class="form-control"></td>
            </tr>
            <tr>
                <td>1</td>
                <td>OYB_Bulk</td>
                <td>8</td>
                <td>15,000</td>
                <td>12,000</td>
                <td></td>
                <td>7월호</td>
            </tr>
            <tr>
                <td>1</td>
                <td>OYB_Bulk</td>
                <td>8</td>
                <td>15,000</td>
                <td>12,000</td>
                <td></td>
                <td>7월호</td>
            </tr>
            </tbody>
        </table>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
