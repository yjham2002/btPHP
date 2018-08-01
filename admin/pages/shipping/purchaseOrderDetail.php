<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 1.
 * Time: PM 3:08
 */
?>
<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>

<script>
    $(document).ready(function(){

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

        <table class="table table-sm table-bordered w-auto text-center">
            <colgroup>
                <col width="15%"/>
                <col width="35%"/>
                <col width="15%"/>
                <col width="35%"/>
            </colgroup>
            <tr class="h-auto">
                <td class="bg-secondary text-light">일자</td>
                <td>asdasdasd</td>
                <td class="bg-secondary text-light">유형</td>
                <td>asdasdasd</td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">년도</td>
                <td>asdasdasd</td>
                <td class="bg-secondary text-light">월호</td>
                <td>asdasdasd</td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">발주번호</td>
                <td>asdasdasd</td>
                <td class="bg-secondary text-light">거래처</td>
                <td>창영프로세스</td>
            </tr>
        </table>

        <hr>

        <table class="table table-sm table-bordered text-center">
            <thead>
            <tr>
                <th></th>
                <th>클래식</th>
                <th>연대기</th>
                <th>맥체인</th>
                <th>X2</th>
                <th>NT</th>
                <th>X3_NT</th>
                <th>X3_OT</th>
                <th>NOTE</th>
            </tr>
            </thead>
            <tbody>
            <tr style="height: 10px;">
                <th>수량</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>금액</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <th>단가</th>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>

        <hr>
        <h4>배송지</h4>
        <div class="mb-2" style="width: 100%; height: 300px; overflow-y: scroll">
            <table class="table table-sm table-bordered">
                <thead>
                <tr>
                    <th>No.</th>
                    <th>배송처</th>
                    <th>내용</th>
                    <th>클래식</th>
                    <th>연대기</th>
                    <th>맥체인</th>
                    <th>X2</th>
                    <th>NT</th>
                    <th>X3_NT</th>
                    <th>X3_OT</th>
                    <th>NOTE</th>
                </tr>
                </thead>
                <tbody>
                <tr style="height: 10px;">
                    <th>1</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th>2</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <th>3</th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>

        <?if($_REQUEST["id"] == ""){?>
            <div class="btn-group float-right mb-2 mr-1" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary mr-2">입력</button>
                <button type="button" class="btn btn-secondary jBack">다시작성</button>
            </div>
        <?}else{?>
            <div class="btn-group float-right mb-2 mr-1" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary mr-2">Excel</button>
                <button type="button" class="btn btn-secondary mr-2">발주서</button>
                <button type="button" class="btn btn-secondary jBack">취소</button>
            </div>
        <?}?>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>

