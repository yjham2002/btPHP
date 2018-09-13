<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 7. 30.
 * Time: PM 2:54
 */
?>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<script>
    $(document).ready(function(){
        $(".jPage").click(function(){
            $("[name=page]").val($(this).attr("page"));
            form.submit();
        });

        $(".jView").click(function(){
            location.href = "/admin/pages/customerManage/transactionDetailView.php";
        });

        $(".jTab").click(function(){
            var target = $(this).attr("target");
            $("[name=type]").val(target);
            form.submit();
        });
    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>직원서비스</a>
            </li>
            <li class="breadcrumb-item active">스케쥴</li>
        </ol>

        <form id="form">
            <input type="hidden" name="type" value="<?=$_REQUEST["type"]?>"/>
            <input type="hidden" name="customerType" value="<?=$_REQUEST["customerType"]?>"/>
            <input type="hidden" name="month" value="<?=$_REQUEST["month"]?>"
        </form>

        <button type="button" class="btn btn-secondary float-right mb-2 jExcel">Excel</button>

        <div class="float-left col-xl-12 col-sm-12 mb-3">
            <!-- Spacer -->
        </div>

        <button type="button" target="sub" class="jTab btn mb-2 <?=$_REQUEST["type"] == "sub" ? "btn-secondary" : ""?>">구독</button>
        <button type="button" target="sup" class="jTab btn mb-2 <?=$_REQUEST["type"] == "sup" ? "btn-secondary" : ""?>">후원</button>

        <br/>

        <select class="custom-select" id="jYear" style="width: 20%">
            <?for($e = 1950; $e < intval(date("Y")) + 50; $e++){?>
                <option value="<?=$e?>" <?=intval(date("Y")) == $e ? "SELECTED" : ""?>><?=$e?>년</option>
            <?}?>
        </select>
        <select class="custom-select" id="jMonth" style="width: 20%">
            <?for($e = 1; $e <= 12; $e++){?>
                <option value="<?=$e < 10 ? "0".$e : $e?>" <?=intval(date("m")) == $e ? "SELECTED" : ""?>><?=$e < 10 ? "0".$e : $e?>월</option>
            <?}?>
        </select>

        <br/>
        <br/>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>체크</th>
                <th>거래처명</th>
                <th>품명 및 규격</th>
                <th>금액</th>
                <th>상세</th>
                <th>비고</th>
                <th>인쇄</th>
            </tr>
            </thead>
            <tbody>
            <?foreach($list as $item){?>
                <tr>
                    <td><?=$item["country"]?></td>
                    <td><?=$item["language"]?></td>
                    <td><?=$item["nd"]?></td>
                    <td><?=$item["year"]?></td>
                    <td><?=$item["startMonth"] . " ~ " . $item["endMonth"]?></td>
                    <td><?=$item["deliveryCharge"] + $item["printCharge"]?></td>
                    <td>
                        <button type="button" class="btn btn-sm <?
                        switch($item["paymentFlag"]){
                            case "0":
                                echo "btn-primary";
                                break;
                            case "-1":
                                echo "btn-danger";
                                break;
                            case "1":
                                echo "btn-success";
                                break;
                        }
                        ?> dropdown-toggle" data-toggle="dropdown">
                            <?
                            switch($item["paymentFlag"]){
                                case "0":
                                    echo "처리중";
                                    break;
                                case "-1":
                                    echo "미결제";
                                    break;
                                case "1":
                                    echo "완료";
                                    break;
                            }
                            ?>
                        </button>
                        <div class="dropdown-menu">
                            <a class="dropdown-item jChange" id="<?=$item["id"]?>" flag="0">처리중</a>
                            <a class="dropdown-item jChange" id="<?=$item["id"]?>" flag="-1">미결제</a>
                            <a class="dropdown-item jChange" id="<?=$item["id"]?>" flag="1">완료</a>
                        </div>
                    </td>
                </tr>
            <?}?>
            </tbody>
        </table>

    </div>
</div>



<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>

