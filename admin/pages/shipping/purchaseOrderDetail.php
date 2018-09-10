<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 1.
 * Time: PM 3:08
 */
?>
<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Uncallable.php";?>

<?
    $uc = new Uncallable($_REQUEST);
    $currentId = $_REQUEST["id"];

    if($currentId != ""){
        $item = $uc->getOrderForm();
        $formJson = $item["formJson"];

//        $F_VALUE = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', nl2br($formJson)), true);
    }else{
        $formJson = $uc->getProperty("FORM_JSON_ORDER");
    }

    $F_VALUE = json_decode(preg_replace('/[\x00-\x1F\x7F]/', '', $formJson), true);

?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="/admin/scss/smSheet.css">
<script>
    var currentId = "<?=$currentId?>";

    $(document).ready(function(){

        var formJson = <?=preg_replace('/[\x00-\x1F\x7F]/', '', $formJson)?>;

        function process(){
            var objs = $("input");
            for(var e = 0; e < objs.length;  e++){
                var name = objs.eq(e).attr("name");
                var content = objs.eq(e).val();
                var spName = name.split("-");
                var pointer = "formJson";
                if(!formJson.hasOwnProperty(spName[0])) continue;
                for(var w = 0; w < spName.length; w++){
                    pointer = pointer + "['" + spName[w] + "']";
                }
                eval(pointer + " = content");
            }
        }

        function clear(){
            var objs = $("input");
            for(var e = 0; e < objs.length;  e++){
                var name = objs.eq(e).attr("name");
                var content = objs.eq(e).val();
                var spName = name.split("-");
                var pointer = "formJson";
                if(formJson.hasOwnProperty(spName[0])){
                    objs.eq(e).val("");
                }
            }
        }

        function updateFormJson(jsonObj, id){
            $.ajax({
                type : "POST",
                url: "/route.php?cmd=Uncallable.updateOrderJson",
                async: true,
                cache: false,
                dataType: "json",
                data: {
                    "formJson" : jsonObj,
                    "id" : id
                },
                success: function (data){
                    console.log(data);
                },
                error : function(req, res, err){
                    alert(req+res+err);
                }
            });
        }

        $("input").change(function(){
            process();
//            console.log(JSON.stringify(formJson));
            if(currentId == ""){

            }else{
//                updateFormJson(JSON.stringify(formJson), currentId);
            }

        });

        $(".jSubmit").click(function(){
            $.ajax({
                type : "POST",
                url: "/route.php?cmd=Uncallable.saveOrderForm",
                async: true,
                cache: false,
                dataType: "json",
                data: {
                    "id" : currentId,
                    "regNo" : $("input[name=regNo]").val(),
                    "buyer" : $("input[name=buyer]").val(),
                    "year" : $("#jYear").val(),
                    "month" : $("#jMonth").val(),
                    "setDate" : $("input[name=setDate]").val(),
                    "type" : $("input[name=type]").val(),
                    "formJson" : JSON.stringify(formJson)
                },
                success: function (data){
                    console.log(data);
                    alert("저장되었습니다.");
                    if(currentId == "") history.back();
                    else location.reload();
                },
                error : function(req, res, err){
                    alert(req+res+err);
                }
            });
        });

        $(".jForm").click(function(){
            var id = $(this).attr("no");
            window.open("/admin/writable/order_template.php?id=" + id, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes");
        });

        $(".jBack").click(function(){
            history.back();
        });

        $(".jClear").click(function(){
            clear();
        });

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
            <li class="breadcrumb-item active">발주 상세</li>
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
                    <option value="<?=$e?>" <?=$item["year"] == $e ? "SELECTED" : ""?>><?=$e?>년</option>
                <?}?>
            </select>
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon3">월호</span>
            </div>
            <select class="custom-select" id="jMonth">
                <?for($e = 1; $e <= 12; $e++){
                    $temp = $e < 10 ? "0".$e : $e;
                    ?>
                    <option value="<?=$e < 10 ? "0".$e : $e?>" <?=$item["month"] == $temp ? "SELECTED" : ""?>><?=$e < 10 ? "0".$e : $e?>월</option>
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
                <th width="60px"></th>
                <?for($i = 0; $i < 8; $i++){?>
                    <th><?=$F_VALUE["products"][$i]["name"]?></th>
                <?}?>
            </tr>
            </thead>
            <tbody>
            <tr>
                <th>수량</th>
                <?for($i = 0; $i < 8; $i++){?>
                    <td><input type="text" class="form-control" name="products-<?=$i?>-quantity" value="<?=$F_VALUE["products"][$i]["quantity"]?>"/></td>
                <?}?>
            </tr>
            <tr>
                <th>금액</th>
                <?for($i = 0; $i < 8; $i++){?>
                    <td><input type="text" class="form-control" name="products-<?=$i?>-price" value="<?=$F_VALUE["products"][$i]["price"]?>"/></td>
                <?}?>
            </tr>
            <tr>
                <th>단가</th>
                <?for($i = 0; $i < 8; $i++){?>
                    <td><input type="text" class="form-control" name="products-<?=$i?>-unit" value="<?=$F_VALUE["products"][$i]["unit"]?>"/></td>
                <?}?>
            </tr>
            </tbody>
        </table>

        <hr>
        
        <h4>배송지</h4>
        <div class="mb-2">
            <table class="table table-sm table-bordered text-center">
                <thead>
                <tr>
                    <th width="60px"></th>
                    <th>배송처</th>
                    <th>내용</th>
                    <?for($i = 0; $i < 8; $i++){?>
                        <th><?=$F_VALUE["products"][$i]["name"]?></th>
                    <?}?>
                </tr>
                </thead>
                <tbody>
                <tr style="height: 10px;">
                    <th>1</th>
                    <td><input type="text" class="form-control" name="product_left" value="<?=$F_VALUE["product_left"]?>"/></td>
                    <td></td>
                    <?for($i = 0; $i < 8; $i++){?>
                        <td><input type="text" class="form-control" name="products_left-<?=$i?>-quantity" value="<?=$F_VALUE["products_left"][$i]["quantity"]?>"/></td>
                    <?}?>
                </tr>
                <tr>
                    <th>2</th>
                    <td><input type="text" class="form-control" name="product_right" value="<?=$F_VALUE["product_right"]?>"/></td>
                    <td></td>
                    <?for($i = 0; $i < 8; $i++){?>
                        <td><input type="text" class="form-control" name="products_right-<?=$i?>-quantity" value="<?=$F_VALUE["products_right"][$i]["quantity"]?>"/></td>
                    <?}?>
                </tr>
                </tbody>
            </table>
        </div>

        <?if($_REQUEST["id"] == ""){?>
            <div class="btn-group float-right mb-2 mr-1" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary mr-1 jSubmit">저장</button>
                <button type="button" class="btn btn-secondary jClear">다시작성</button>
                <button type="button" class="btn btn-secondary jBack">취소</button>
            </div>
        <?}else{?>
            <div class="btn-group float-right mb-2 mr-1" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary mr-1">Excel</button>
                <button type="button" class="btn btn-secondary mr-1 jSubmit">저장</button>
                <button type="button" no="<?=$_REQUEST["id"]?>" class="jForm btn btn-secondary mr-1">발주서</button>
                <button type="button" class="btn btn-secondary jBack">취소</button>
            </div>
        <?}?>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>

