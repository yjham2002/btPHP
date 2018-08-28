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

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="/admin/scss/smSheet.css">
<script>
    $(document).ready(function(){
        $(".jDate").datepicker({
            yearRange: "-100:",
            showMonthAfterYear:true,
            inline: true,
            changeMonth: true,
            changeYear: true,
            dateFormat : 'yy-mm-dd',
            dayNamesMin:['일', '월', '화', '수', '목', '금', ' 토'],
            monthNames:['1월','2월','3월','4월','5월','6월','7 월','8월','9월','10월','11월','12월'],
            monthNamesShort:['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            beforeShow: function() {
                setTimeout(function(){
                    $('.ui-datepicker').css('z-index', 9999);
                }, 0);
            }
        });
    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">배송</a>
            </li>
            <li class="breadcrumb-item active">발주 입력</li>
        </ol>

        <h4>내역</h4>
        
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">일자</span>
            </div>
            <input type="text" class="form-control jDate" name="setDate" value="<?=$item["setDate"]?>"
                   placeholder="일자를 선택하세요"
                   readonly>
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">유형</span>
            </div>
            <input type="text" class="form-control" name="type" value="<?=$item["type"]?>">
        </div>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">년도</span>
            </div>
            <select class="custom-select" id="jYear">
                <?for($e = intval(date("Y")) + 5; $e >= 1950 ; $e--){?>
                    <option value="<?=$e?>" <?=$_REQUEST["year"] == $e ? "SELECTED" : ""?>><?=$e?>년</option>
                <?}?>
            </select>
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">월호</span>
            </div>
            <select class="custom-select" id="jMonth">
                <?for($e = 1; $e <= 12; $e++){
                    $temp = $e < 10 ? "0".$e : $e;
                    ?>
                    <option value="<?=$e < 10 ? "0".$e : $e?>" <?=$_REQUEST["month"] == $temp ? "SELECTED" : ""?>><?=$e < 10 ? "0".$e : $e?>월</option>
                <?}?>
            </select>
        </div>
        <div class="input-group mb-2">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">발주번호</span>
            </div>
            <input type="text" class="form-control" name="regNo" value="<?=$item["regNo"]?>">
            <div class=" input-group-prepend">
                <span class="input-group-text" id="basic-addon3">거래처</span>
            </div>
            <input type="text" class="form-control" name="buyer" value="<?=$item["buyer"]?>">
        </div>

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
            <table class="table table-sm table-bordered text-center">
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
                <button type="button" class="btn btn-secondary mr-1">입력</button>
                <button type="button" class="btn btn-secondary jBack">다시작성</button>
            </div>
        <?}else{?>
            <div class="btn-group float-right mb-2 mr-1" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary mr-1">Excel</button>
                <button type="button" class="btn btn-secondary mr-1">발주서</button>
                <button type="button" class="btn btn-secondary jBack">취소</button>
            </div>
        <?}?>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>

