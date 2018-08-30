<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 7. 30.
 * Time: PM 3:11
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Management.php";?>
<?
    $obj = new Management($_REQUEST);
    $list = $obj->fPubChildList();
?>
<link rel="stylesheet" href="/admin/scss/smSheet.css">
<script>
    $(document).ready(function(){
        $(".jPage").click(function(){
            $("[name=page]").val($(this).attr("page"));
            form.submit();
        });

        $(".jChange").click(function(){
            var flag = $(this).attr("flag");
            var id = $(this).attr("id");

            var ajax = new AjaxSender("/route.php?cmd=Management.changeFpubFlag", true, "json", new sehoMap().put("flag", flag).put("id", id));
            ajax.send(function(data){
                if(data.returnCode === 1){
                    alert("변경되었습니다");
                    location.reload();
                }
            });
        });
    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>고객관리</a>
            </li>
            <li class="breadcrumb-item active">입금 현황</li>
        </ol>

        <form id="form">
            <input type="hidden" name="page"/>
        </form>

        <table class="table table-bordered">
            <thead>
            <tr>
                <th>국가</th>
                <th>언어</th>
                <th>ND</th>
                <th>년도</th>
                <th>월호</th>
                <th>출금예정금액</th>
                <th>처리현황</th>
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
        <?include $_SERVER["DOCUMENT_ROOT"] . "/admin/inc/pageNavigator.php";?>
    </div>
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
