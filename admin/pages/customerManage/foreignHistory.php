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
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Management.php";?>
<?
    $management = new Management($_REQUEST);
    $parent = $management->foreignPubInfo();
    $item = $management->foreignPubChild();
?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/admin/scss/smSheet.css">
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

        calculateCharge();

        $(document).on("click", ".jViewDoc", function(){
            var path = $(this).attr("data");
            alert(path);
            location.href = "";
        });

        $("[name=printCharge]").keyup(function(){
            $(this).val($(this).val().format());
            calculateCharge();
        });

        $("[name=deliveryCharge]").keyup(function(){
            $(this).val($(this).val().format());
            calculateCharge();
        });

        function calculateCharge(){
            var printCharge = $("[name=printCharge]").val().replace(",", "");
            var deliveryCharge = $("[name=deliveryCharge]").val().replace(",", "");
            if(printCharge === "") printCharge = 0;
            else printCharge = parseInt(printCharge);
            if(deliveryCharge === "") deliveryCharge = 0;
            else deliveryCharge = parseInt(deliveryCharge)
            $(".jTotal").text((printCharge + deliveryCharge).format());
        }

        $(".jSave").click(function(){
            var ajax = new AjaxSubmit("/route.php?cmd=Management.upsertForeignPubChild", "post", false, "json", "#form");
            ajax.send(function(data){
                if(data.returnCode === 1){
                    alert("저장되었습니다");
                }
            })

        });
    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Blank Page</li>
        </ol>
        <button type="button" class="btn btn-primary float-right mb-3 jSave">등록/수정</button>
        <form method="post" id="form" action="#" enctype="multipart/form-data">
            <input type="hidden" name="parentId" value="<?=$_REQUEST["parentId"]?>"/>
            <input type="hidden" name="id" value="<?=$_REQUEST["id"]?>"/>

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
                    <td><?=$parent["country"]?></td>
                    <td class="bg-secondary text-light">언어</td>
                    <td><?=$parent["language"]?></td>
                    <td class="bg-secondary text-light">ND</td>
                    <td><input type="text" class="form-control" name="nd" value="<?=$item["nd"]?>"/></td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">월호</td>
                    <td style="text-align: center;">
                        <div class="form-inline">
                            <select class="form-control" id="startMonth" name="startMonth">
                                <option value="">선택</option>
                                <?for($i=1; $i<=12; $i++){?>
                                    <option value="<?=$i?>" <?=$item["startMonth"] == $i ? "selected" : ""?>><?=$i?></option>
                                <?}?>
                            </select>
                            &nbsp;~&nbsp;
                            <select class="form-control" id="endMonth" name="endMonth">
                                <option value="">선택</option>
                                <?for($i=1; $i<=12; $i++){?>
                                    <option value="<?=$i?>" <?=$item["endMonth"] == $i ? "selected" : ""?>><?=$i?></option>
                                <?}?>
                            </select>
                        </div>
                    </td>
                    <td class="bg-secondary text-light">구분</td>
                    <td><input type="text" class="form-control" name="type" value="<?=$item["type"]?>"/></td>
                    <td class="bg-secondary text-light">수량</td>
                    <td><input type="number" class="form-control" name="cnt" value="<?=$item["cnt"]?>"/></td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">인쇄 거래처</td>
                    <td><input type="text" class="form-control" name="client" value="<?=$item["client"]?>"/></td>
                    <td class="bg-secondary text-light">인쇄비</td>
                    <td><input type="text" class="form-control" name="printCharge" value="<?=$item["printCharge"]?>"/></td>
                    <td class="bg-secondary text-light">배송비</td>
                    <td><input type="text" class="form-control" name="deliveryCharge" value="<?=$item["deliveryCharge"]?>"/></td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">합계</td>
                    <td colspan="5" class="text-right jTotal"></td>
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
                    <tr>
                        <th>예정</th>
                        <td><input class="form-control datePicker" name="dueDate1" value="<?=$item["dueDate1"]?>" /></td>
                        <td><input class="form-control datePicker" name="dueDate2" value="<?=$item["dueDate2"]?>"/></td>
                        <td><input class="form-control datePicker" name="dueDate3" value="<?=$item["dueDate3"]?>"/></td>
                        <td><input class="form-control datePicker" name="dueDate4" value="<?=$item["dueDate4"]?>"/></td>
                        <td><input class="form-control datePicker" name="dueDate5" value="<?=$item["dueDate5"]?>"/></td>
                    </tr>
                    <tr>
                        <th>완료</th>
                        <td><?=$item["endDate1"]?></td>
                        <td><?=$item["endDate2"]?></td>
                        <td><?=$item["endDate3"]?></td>
                        <td><?=$item["endDate4"]?></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <hr>

            <div class="container">
                <div class="row">
                    <div class="col">
                        <object class="jViewDoc" data="../test.pdf" type="application/pdf" width="auto" height="460px"></object>
                        <br>
                        <button type="button" class="btn btn-secondary mb-3">등록/수정</button>
                    </div>
                    <div class="col">
                        <object class="jViewDoc" data="../test.pdf" type="application/pdf" width="auto" height="460px"></object>
                        <button type="button" class="btn btn-secondary mb-3">등록/수정</button>
                    </div>
                    <div class="col">
                        <object class="jViewDoc" data="../test.pdf" type="application/pdf" width="auto" height="460px"></object>
                        <br>
                        <button type="button" class="btn btn-secondary mb-3">등록/수정</button>
                    </div>
                </div>
            </div>
        </form>

<!--        <div class="float-left text-center" style="width: 300px; height: 600px">-->
<!--            <object class="jViewDoc" data="../test.pdf" type="application/pdf" width="auto" height="460px"></object>-->
<!--            <button type="button" class="btn btn-secondary mb-3">등록/수정</button>-->
<!--        </div>-->
<!--        <div class="float-left text-center" style="width: 300px; height: 600px">-->
<!--            <object class="jViewDoc" data="../test.pdf" type="application/pdf" width="auto" height="460px"></object>-->
<!--            <button type="button" class="btn btn-secondary mb-3">등록/수정</button>-->
<!--        </div>-->
<!--        <div class="float-left text-center" style="width: 300px; height: 600px">-->
<!--            <object class="jViewDoc" data="../test.pdf" type="application/pdf" width="auto" height="460px"></object>-->
<!--            <button type="button" class="btn btn-secondary mb-3">등록/수정</button>-->
<!--        </div>-->
    </div>
</div>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>

