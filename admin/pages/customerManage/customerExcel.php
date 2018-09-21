<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 9. 20.
 * Time: PM 6:32
 */
include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";

$obj = new AdminMain($_REQUEST);
$list = $obj->getCustomerExcelList();
//echo json_encode($list);
?>

<table border="1" id="toPrint">
    <tr>
        <th>타입</th>
        <th>구독/후원 시작월</th>
        <th>구독/후원끝나는월</th>
        <th>간행물</th>
        <th>부수</th>
        <th>가격</th>
        <th>구독유형</th>
        <th>후원유형</th>
        <th>배송방식</th>
        <th>받는분 이름</th>
        <th>받는분 이메일</th>
        <th>받는분 핸드폰</th>
        <th>받는분 우편번호</th>
        <th>받는분 주소</th>
        <th>후원집회명</th>
        <th>신청일</th>
        <th>회원 아이디</th>
        <th>회원 유형</th>
        <th>결제 유형</th>
        <th>월 결제일</th>
        <th>계좌이체 외부참조키</th>
        <th>Authorize.net 구독키</th>
        <th>Authorize.net 회원키</th>
        <th>카드사</th>
        <th>은행</th>
        <th>카드/계좌번호</th>
        <th>카드 유효월</th>
    </tr>
    <?for($i = 0; $i < sizeof($list); $i++){
        $item = $list[$i];
        ?>
    <tr>
        <td><?
                if($item["productType"] == "SUB") echo "구독";
                else echo "후원";
            ?>
        </td>
        <td style='mso-number-format:"\@"'>
            <?
                if($item["productType"] == "SUB") echo $item["pYear"]."/".$item["pMonth"];
                else echo $item["sYear"]."/".$item["sMonth"];
            ?>
        </td>
        <td style='mso-number-format:"\@"'><?=$item["eYear"] . "/" . $item["eMonth"]?></td>
        <td><?=$item["desc"]?></td>
        <td><?=$item["cnt"]?></td>
        <td><?=$item["totalprice"]?></td>
        <td>
            <?
                if($item["subType"] == 0) echo "개인";
                else if($item["subType"] == 1) echo "단체";
                else if($item["subType"] == 2) echo "묶음배송";
                else if($item["subType"] == 3) echo "표지광고";
            ?>
        </td>
        <td>
            <?=$item["supType"]?>
        </td>
        <td>
            <?
                if($item["shippingType"] == 0) echo "우편";
                else if($item["shippingType"] == 1) echo "택배";
            ?>
        </td>
        <td><?=$item["rName"]?></td>
        <td><?=$item["rEmail"]?></td>
        <td style='mso-number-format:"\@"'><?=$item["rPhone"]?></td>
        <td><?=$item["rZipCode"]?></td>
        <td><?=$item["rAddr"] . " " . $item["rAddrDetail"]?></td>
        <td><?=$item["assemblyName"]?></td>
        <td><?=$item["regDate"]?></td>
        <td><?=$item["email"]?></td>
        <td><?=$item["customerType"] == 1 ? "개인" : "단체"?></td>
        <td>
            <?
                if($item["paymentType"] == "CC") echo "신용카드";
                else if($item["paymentType"] == "BA") echo "계좌이체";
                else if($item["paymentType"] == "FC") echo "해외신용카드";
            ?>
        </td>
        <td><?=$item["monthlyDate"]?></td>
        <td><?=$item["primeIndex"]?></td>
        <td><?=$item["aSubscriptionId"]?></td>
        <td><?=$item["aCustomerProfileId"]?></td>
        <td><?=$item["cardDesc"]?></td>
        <td><?=$item["bankDesc"]?></td>
        <td style='mso-number-format:"\@"'><?=$item["info"]?></td>
        <td><?=$item["validThruMonth"] . "/" . $item["validThruYear"]?></td>

    </tr>
    <?}?>
</table>