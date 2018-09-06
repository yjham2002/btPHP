<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 22.
 * Time: PM 6:13
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
    $obj = new WebUser($_REQUEST);
    $info = $obj->customerInfo();

    $userInfo = $info["userInfo"];
    $subscriptionInfo = $info["subscriptionInfo"];

    if($_COOKIE["btLocale"] == "kr") {
        $currency = "₩";
        $decimal = 0;
    }
    else{
        $currency = "$";
        $decimal = 2;
    }
?>
<script>
    $(document).ready(function(){
        $(".jLost").click(function(){
            var type = $(this).attr("sType");
            var noArr = new Array();
            var noCnt = $(".jSub:checked").length;
            if(noCnt == 0){
                alert("항목을 하나 이상 선택해주세요.");
                return;
            }
            if(confirm("신청하시겠습니까?")){
                for(var i=0; i<noCnt; i++) noArr.push($(".jSub:checked:eq(" + i + ")").val());
                var ajax = new AjaxSender("/route.php?cmd=WebUser.setLost", false, "json", new sehoMap().put("type", type).put("noArr", noArr));
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("신청되었습니다!");
                        location.href = "/web/pages/mypage.php";
                    }
                });
            }
        });
    });
</script>
<section class="wrapper special books">
    <div class="inner mypage">
        <header>
            <h2 class="pageTitle">구독 정보</h2>
            <div class="empLineT"></div>
            <p>상세 구독 정보입니다</p>
        </header>

        <table>
            <thead>
            <tr>
                <th>No.</th>
                <th>받는 분</th>
                <th>우편번호</th>
                <th>주소</th>
                <th>상세주소</th>
                <th>버전</th>
                <th>수량</th>
                <th>시작한 날짜</th>
                <th>재발송 요청</th>
            </tr>
            </thead>
            <tbody>
            <?for($i=0; $i<sizeof($subscriptionInfo); $i++){?>
                <tr>
                    <td><?=$i+1?></td>
                    <td>
<!--                        <input class="smallTextBox" type="text" name="rName" value="--><?//=$subscriptionInfo[$i]["rName"]?><!--" readonly/>-->
                        <?=$subscriptionInfo[$i]["rName"] == "" ? $user->name : $subscriptionInfo[$i]["rName"]?>
                    </td>
                    <td>
                        <?=$subscriptionInfo[$i]["rZipCode"]?>
                    </td>
                    <td>
                        <?=$subscriptionInfo[$i]["rAddr"]?>
                    </td>
                    <td>
                        <?=$subscriptionInfo[$i]["rAddrDetail"]?>
                    </td>
                    <td>
                        <?=$subscriptionInfo[$i]["publicationName"]?>
                    </td>
                    <td>
                        <?=$subscriptionInfo[$i]["cnt"]?>
                    </td>
                    <td>
                        <?=$subscriptionInfo[$i]["regDate"]?>
                    </td>
                    <td>
                        <input type="checkbox" class="jSub" id="con_<?=$i?>" value="<?=$subscriptionInfo[$i]["id"]?>">
                        <label for="con_<?=$i?>"></label>
                    </td>
                </tr>
            <?}?>
            </tbody>
        </table>

        <div style="" class="align-right">
            <p>* 우편 무료, 5일 소요<br/>택배 2,000원, 2~3일 소요</p>
        </div>

<!--        <div style="" class="align-left">-->
<!--            <a href="#" class="grayButton roundButton">재발송요청</a>-->
<!--        </div>-->

        <hr />
        <div style="text-align:center;" class="align-left">
            <p>재발송 방법을 선택해주세요.</p>
            <a href="#" style="background:#5E5E5E;" class="grayButton roundButton jLost" sType="0">우편 (무료)</a>
            <a href="#" style="background:#5E5E5E;" class="grayButton roundButton jLost" sType="1">택배 (2,000원)</a>
        </div>
        <hr />
    </div>
</section>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
