<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 1.
 * Time: PM 12:28
 */
?>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>

<script>
    $(document).ready(function(){
        $(document).on("click", ".jViewDoc", function(){
            var path = $(this).attr("data");
            alert(path);
            location.href = "";
        });
    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Blank Page</li>
        </ol>

        <table class="table table-sm table-bordered text-center">
            <colgroup>
                <col width="10%"/>
                <col width="25%"/>
                <col width="10%"/>
                <col width="25%"/>
                <col width="10%"/>
                <col width="25%"/>
            </colgroup>
            <tr class="h-auto">
                <td class="bg-secondary text-light">국가</td>
                <td>asdasdasd</td>
                <td class="bg-secondary text-light">언어</td>
                <td>asdasdasd</td>
                <td class="bg-secondary text-light">ND</td>
                <td>asdasdasd</td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">월호</td>
                <td>asdasdasd</td>
                <td class="bg-secondary text-light">구분</td>
                <td>asdasdasd</td>
                <td class="bg-secondary text-light">수량</td>
                <td>asdasdasd</td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">인쇄 거래처</td>
                <td>asdasdasd</td>
                <td class="bg-secondary text-light">인쇄비</td>
                <td>asdasdasd</td>
                <td class="bg-secondary text-light">배송비</td>
                <td>asdasdasd</td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">합계</td>
                <td colspan="5" class="text-right">asdasdasd</td>
            </tr>
        </table>

        <hr>

        <div style="width: 100%;">
            <table class="table table-sm table-bordered">
                <thead>
                <tr>
                    <th>일자</th>
                    <th>번역</th>
                    <th>데이터</th>
                    <th>인쇄</th>
                    <th>배송</th>
                    <th>입금</th>
                </tr>
                </thead>
                <tbody>
                <tr style="height: 10px;">
                    <td>John</td>
                    <td>Doe</td>
                    <td>john@example.com</td>
                    <td>john@example.com</td>
                    <td>john@example.com</td>
                    <td>john@example.com</td>
                </tr>
                <tr>
                    <td>Mary</td>
                    <td>Moe</td>
                    <td>mary@example.com</td>
                    <td>mary@example.com</td>
                    <td>mary@example.com</td>
                    <td>mary@example.com</td>
                </tr>
                <tr>
                    <td>July</td>
                    <td>Dooley</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                </tr>
                </tbody>
            </table>
        </div>

        <hr>

        <div class="float-left text-center" style="width: 300px; height: 600px">
            <object class="jViewDoc" data="../test.pdf" type="application/pdf" width="300px" height="460px"></object>
            <button type="button" class="btn btn-secondary mb-3">등록/수정</button>
        </div>
        <div class="float-left text-center" style="width: 300px; height: 600px">
            <object class="jViewDoc" data="../test.pdf" type="application/pdf" width="300px" height="460px"></object>
            <button type="button" class="btn btn-secondary mb-3">등록/수정</button>
        </div>
        <div class="float-left text-center" style="width: 300px; height: 600px">
            <object class="jViewDoc" data="../test.pdf" type="application/pdf" width="300px" height="460px"></object>
            <button type="button" class="btn btn-secondary mb-3">등록/수정</button>
        </div>


        <button type="button" class="btn btn-secondary float-right mb-3">등록/수정</button>

    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>

