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
<?

    $uc = new Uncallable($_REQUEST);
    $subscribe = $uc->getSub();
    $formData = $uc->getReceipt();
    $formJson = $formData["formJson"];

    $flag = false;

    if($formJson != ""){
    }else{
        $flag = true;
        $formJson = $uc->getProperty("FORM_JSON_RECEIPT");
    }

    $F_VALUE = json_decode(preg_replace('/[\x00-\x1F\x7F]/', '', $formJson), true);

    if($flag){
        $F_VALUE[0]["date"] = $subscribe["ftd"];
        $F_VALUE[0]["name"] = $subscribe["puName"]."(배송료포함)";
        $F_VALUE[0]["quantity"] = $subscribe["cnt"];
        $F_VALUE[0]["price"] = $subscribe["unitPrice"];
        $F_VALUE[0]["supply"] = intval($subscribe["totalPrice"]);
        $F_VALUE[0]["vat"] = $subscribe["pMonth"]."월호";
    }

    $subscribe["puName"];
?>

<link rel="stylesheet" href="/admin/scss/smSheet.css">
<script>
    $(document).ready(function(){
        var formJson = <?=preg_replace('/[\x00-\x1F\x7F]/', '', $formJson)?>;
        var currentId = "<?=$_REQUEST["id"]?>";

        function updateFormJson(jsonObj, id, vat, check){
            if(vat == ""){
                vat = 0;
            }
            $.ajax({
                type : "POST",
                url: "/route.php?cmd=Uncallable.updateReceiptJson",
                async: true,
                cache: false,
                dataType: "json",
                data: {
                    "formJson" : jsonObj,
                    "id" : id,
                    "vat" : vat,
                    "check": check
                },
                success: function (data){
                    alert("저장되었습니다.");
                    location.reload();
                },
                error : function(req, res, err){
                    alert(req+res+err);
                }
            });
        }

        $(".jSave").click(function(){
            var vat = $("[name=vat]").val();
            var check = $("[name=check]").val();
            updateFormJson(JSON.stringify(formJson), currentId, vat, check);
        });

        $(".jCancel").click(function(){
            location.href = "/admin/pages/customerManage/transactionDetailsSend.php?year=<?=intval(date("Y"))?>&month=<?=date("m")?>&type=-1&page=1";
        });

        $(".jPreview").click(function(){
            window.open("/admin/writable/receipt_template.php?id=" + currentId, "_blank", "toolbar=yes,scrollbars=yes,resizable=yes");
        });

        $("input, textarea").change(function(){
            process();
            console.log(JSON.stringify(formJson));
            if(currentId == ""){

            }else{

            }

        });

        var processed = false;

        function process(){
            processed = true;
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
            <button type="button" class="btn btn-secondary mr-2 jSave">저장</button>
            <button type="button" class="btn btn-secondary mr-2 jPreview">미리보기</button>
            <button type="button" class="btn btn-secondary jCancel">취소</button>
        </div>

        <table class="table table-sm table-bordered">
            <thead>
            <tr>
                <th>받는사람</th>
                <th>전화번호</th>
                <th>우편번호</th>
                <th>주소</th>
                <th>버전</th>
                <th>부수</th>
                <th>신청일</th>
                <th>시작월호</th>
                <th>종료월호</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td ><?=$subscribe["rName"]?></td>
                <td ><?=$subscribe["rPhone"]?></td>
                <td ><?=$subscribe["rZipCode"]?></td>
                <td ><?=$subscribe["rAddr"]." ".$subscribe["rAddrDetail"]?></td>
                <td ><?=$subscribe["puName"]?></td>
                <td ><?=$subscribe["cnt"]?></td>
                <td ><?=$subscribe["regDate"]?></td>
                <td ><?=$subscribe["pYear"]."-".$subscribe["pMonth"]?></td>
                <td ><?=$subscribe["eYear"]."-".$subscribe["eMonth"]?></td>
            </tr>
            </tbody>
        </table>

        <table class="table table-sm table-bordered">
            <tr>
                <th>VAT</th>
                <td>
                    <input type="number" class="form-control" name="vat" value="<?=$formData["vat"]?>"/>
                </td>
            </tr>
            <tr>
                <th>인수</th>
                <td>
                    <input type="text" class="form-control" name="check" value="<?=$formData["check"]?>"/>
                </td>
            </tr>
        </table>

        <table class="table table-sm table-bordered">
            <thead>
            <tr>
                <th>일자</th>
                <th>품목명 및 규격</th>
                <th>수량</th>
                <th>단가</th>
                <th>공급가액</th>
                <th>적요</th>
            </tr>
            </thead>
            <tbody>
            <?for($e = 0; $e < sizeof($F_VALUE); $e++){
                $item = $F_VALUE[$e];
                ?>
            <tr>
                <td><input type="text" class="form-control" name="<?=$e?>-date" value="<?=$item["date"]?>" /></td>
                <td><input type="text" class="form-control" name="<?=$e?>-name" value="<?=$item["name"]?>" /></td>
                <td><input type="text" class="form-control" name="<?=$e?>-quantity" value="<?=$item["quantity"]?>" /></td>
                <td><input type="text" class="form-control" name="<?=$e?>-price" value="<?=$item["price"]?>" /></td>
                <td><input type="text" class="form-control" name="<?=$e?>-supply" value="<?=$item["supply"]?>" /></td>
                <td><input type="text" class="form-control" name="<?=$e?>-vat" value="<?=$item["vat"]?>" /></td>
            </tr>
            <?}?>
            </tbody>
        </table>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
