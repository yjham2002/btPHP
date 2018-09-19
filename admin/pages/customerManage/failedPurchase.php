<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 7. 27.
 * Time: PM 4:20
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Management.php";?>
<?
    $obj = new Management($_REQUEST);
    $list = $obj->paymentList();
    $obj->processFC();
    $type = $_REQUEST["type"];
//    echo json_encode($list);
?>
<script>
    $(document).ready(function(){
        $(".jType").click(function(){
            var type = $(this).val();
            location.href = "/admin/pages/customerManage/failedPurchase.php?type=" + type;
        });
    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">고객관리</a>
            </li>
            <li class="breadcrumb-item active">결제관리</li>
        </ol>

        <form id="form">
            <input type="hidden" name="page" />
            <div class="btn-group float-left" role="group">
                <button type="button" class="btn jType <?=$type == "BA" ? "btn-secondary" : ""?>" value="BA">자동이체</button>
                <button type="button" class="btn jType <?=$type == "CC" ? "btn-secondary" : ""?>" value="CC">카드</button>
                <button type="button" class="btn jType <?=$type == "FC" ? "btn-secondary" : ""?>" value="FC">해외카드</button>
            </div>

            <div class="btn-group float-right mb-2" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary jTranscendanceExcel">Excel</button>
            </div>
        </form>



        <div style="width: 100%; height: 600px; overflow-y: scroll">
            <?if($type == "BA"){?>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>이름</th>
                        <th>은행</th>
                        <th>계좌번호</th>
                        <th>외부참조키</th>
                        <th>출금일</th>
                        <th>출금금액</th>
                        <th>등록일시</th>
                        <th>처리현황</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?foreach($list as $item){?>
                        <tr>
                            <td><?=$item["ownerName"]?></td>
                            <td><?=$item["bankDesc"]?></td>
                            <td style='mso-number-format:"\@"'><?=$item["info"]?></td>
                            <td><?=$item["primeIndex"]?></td>
                            <td><?=$item["monthlyDate"]?></td>
                            <td><?=$item["totalPrice"]?></td>
                            <td><?=$item["regDate"]?></td>
                            <td>
                                <button type="button" class="btn btn-sm <?
                                switch($item["paymentResult"]){
                                    case "0":
                                        echo "btn-danger";
                                        break;
                                    case "1":
                                        echo "btn-primary";
                                        break;
                                    case "2":
                                        echo "btn-success";
                                        break;
                                }
                                ?> dropdown-toggle" data-toggle="dropdown">
                                    <?
                                    switch($item["paymentResult"]){
                                        case "0":
                                            echo "미결제";
                                            break;
                                        case "2":
                                            echo "처리중";
                                            break;
                                        case "1":
                                            echo "완료";
                                            break;
                                    }
                                    ?>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item jChange" id="<?=$item["idx"]?>" flag="0">미결제</a>
                                    <a class="dropdown-item jChange" id="<?=$item["idx"]?>" flag="1">완료</a>
                                    <a class="dropdown-item jChange" id="<?=$item["idx"]?>" flag="2">처리중</a>
                                </div>
                            </td>
                        </tr>
                    <?}?>
                    </tbody>
                </table>
            <?} else if($type == "CC"){?>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>이름</th>
                        <th>카드사</th>
                        <th>카드번호</th>
                        <th>유효월 / 유효년</th>
                        <th>출금일</th>
                        <th>출금금액</th>
                        <th>등록일시</th>
                        <th>처리현황</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?foreach($list as $item){?>
                        <tr>
                            <td><?=$item["ownerName"]?></td>
                            <td><?=$item["cardDesc"]?></td>
                            <td style='mso-number-format:"\@"'><?=$item["info"]?></td>
                            <td><?=$item["validThruMonth"] . " / " . $item["validThruYear"]?></td>
                            <td><?=$item["monthlyDate"]?></td>
                            <td><?=$item["totalPrice"]?></td>
                            <td><?=$item["regDate"]?></td>
                            <td>
                                <button type="button" class="btn btn-sm <?
                                switch($item["paymentResult"]){
                                    case "0":
                                        echo "btn-danger";
                                        break;
                                    case "1":
                                        echo "btn-primary";
                                        break;
                                    case "2":
                                        echo "btn-success";
                                        break;
                                }
                                ?> dropdown-toggle" data-toggle="dropdown">
                                    <?
                                    switch($item["paymentResult"]){
                                        case "0":
                                            echo "미결제";
                                            break;
                                        case "2":
                                            echo "처리중";
                                            break;
                                        case "1":
                                            echo "완료";
                                            break;
                                    }
                                    ?>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item jChange" id="<?=$item["idx"]?>" flag="0">미결제</a>
                                    <a class="dropdown-item jChange" id="<?=$item["idx"]?>" flag="1">완료</a>
                                    <a class="dropdown-item jChange" id="<?=$item["idx"]?>" flag="2">처리중</a>
                                </div>
                            </td>
                        </tr>
                    <?}?>
                    </tbody>
                </table>
            <?} else if($type == "FC"){?>
                <table class="table table-bordered">
                    <thead>
                    <tr>
                        <th>이름</th>
                        <th>카드번호</th>
                        <th>유효월 / 유효년</th>
                        <th>출금일</th>
                        <th>출금금액</th>
                        <th>등록일시</th>
                        <th>처리현황</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?foreach($list as $item){?>
                        <tr>
                            <td><?=$item["aFirstname"] . " " . $item["aLastname"]?></td>
                            <td style='mso-number-format:"\@"'><?=$item["info"]?></td>
                            <td><?=$item["validThruMonth"] . " / " . $item["validThruYear"]?></td>
                            <td><?=$item["monthlyDate"]?></td>
                            <td><?=$item["totalPrice"]?></td>
                            <td><?=$item["regDate"]?></td>
                            <td>
                                <button type="button" class="btn btn-sm <?
                                switch($item["paymentResult"]){
                                    case "0":
                                        echo "btn-danger";
                                        break;
                                    case "1":
                                        echo "btn-primary";
                                        break;
                                    case "2":
                                        echo "btn-success";
                                        break;
                                }
                                ?> dropdown-toggle" data-toggle="dropdown">
                                    <?
                                    switch($item["paymentResult"]){
                                        case "0":
                                            echo "미결제";
                                            break;
                                        case "2":
                                            echo "처리중";
                                            break;
                                        case "1":
                                            echo "완료";
                                            break;
                                    }
                                    ?>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item jChange" id="<?=$item["idx"]?>" flag="0">미결제</a>
                                    <a class="dropdown-item jChange" id="<?=$item["idx"]?>" flag="1">완료</a>
                                    <a class="dropdown-item jChange" id="<?=$item["idx"]?>" flag="2">처리중</a>
                                </div>
                            </td>
                        </tr>
                    <?}?>
                    </tbody>
                </table>
            <?}?>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
