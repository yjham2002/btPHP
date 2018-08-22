<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 6:30
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
    $obj = new WebUser($_REQUEST);
    $info = $obj->customerInfo();
//    echo json_encode($info);

    $userInfo = $info["userInfo"];
    $subscriptionInfo = $info["subscriptionInfo"];
    $supportInfo = $info["supportInfo"];

    if($_COOKIE["btLocale"] == "kr") {
        $currency = "₩";
        $decimal = 0;
    }
    else{
        $currency = "$";
        $decimal = 2;
    }
?>

<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script>
    $(document).ready(function(){
        var id = "<?=$userInfo["id"]?>";
        var type = "<?=$userInfo["type"]?>";

        $(".jAddress").click(function(){
            new daum.Postcode({
                oncomplete: function(data){
                    console.log(data);
                    $("[name=zipcode]").val(data.zonecode);
                    $("[name=addr]").val(data.address);
                }
            }).open();
        });

        $(".jSave").click(function(){
            var currentPass = $("#userPW").val();
            var newPW = $("#newPW").val();
            var newPWC = $("#newPWC").val();

            if(verifyPassword(newPW) === false){
                alert("비밀번호 형식에 맞춰서 작성해 주시기 바랍니다.");
                return;
            }

            var ajax = new AjaxSender("/route.php?cmd=WebUser.checkCustomerPassword", true, "json", new sehoMap().put("id", id).put("password", currentPass));
            ajax.send(function(data){
                if(data.returnCode !== 1){
                    alert("현재 비밀번호가 일치하지 않습니다.");
                    return;
                }
                else{
                    if(newPW !== newPWC){
                        alert("새로운 비밀번호가 일치하지 않습니다.");
                        return;
                    } else saveOperation();
                }
            });
        });

        function saveOperation(){
            var password = $("#newPW").val();
            var phone = $("#phone").val();
            var zipcode = $("#zipcode").val();
            var addr = $("#addr").val();
            var addrDetail = $("#addrDetail").val();
            var cName = $("#cName").val();
            var cPhone = $("#cPhone").val();
            var params = new sehoMap().put("id", id).put("password", password).put("phone", phone).put("zipcode", zipcode).put("addr", addr)
                .put("addrDetail", addrDetail).put("cName", cName).put("cPhone", cPhone);
            params.put("type", type);

            var ajax = new AjaxSender("/route.php?cmd=WebUser.updateCustomerInfo", false, "json", params);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    alert("저장되었습니다");
                    location.reload();
                }
                else{
                    alert(data.returnMessage);
                    location.reload();
                }
            });
        }

        $(".jCancel").click(function(){
            history.back();
        });
    });
</script>

<section class="wrapper special books">
    <div class="inner mypage">
        <header>
            <h2 class="pageTitle"><?=$MYPAGE_ELEMENTS["title"]?></h2>
            <div class="empLineT"></div>
            <p><?=$MYPAGE_ELEMENTS["subTitle"]?></p>
        </header>

        <div style="" class="align-right">
            <a href="#" class="grayButton roundButton">거래명세서</a>
            <a href="#" class="grayButton roundButton">1:1 문의</a>
        </div>
        <hr />

        <div class="row">
            <div class="4u 12u$(small)">
                <h2 class="nanumGothic">ID/PW</h2>
            </div>
            <div class="8u$ 12u$(small) align-left">
                <h3 style="color:black;" class="nanumGothic" ><?=$userInfo["email"]?></h3>
                <input class="smallTextBox" type="password" name="userPW" id="userPW" placeholder="현재 비밀번호" />
                <input class="smallTextBox" type="password" name="newPW" id="newPW" placeholder="신규 비밀번호" />
                <input class="smallTextBox" type="password" name="newPWC" id="newPWC" placeholder="신규 비밀번호 확인" />
                <h5>*  띄어쓰기 없이 영문, 숫자, 특수문자 3가지 조합으로 5~15자 이내(대소문자 구별)로 입력해주세요.</h5>
            </div>

            <?if($userInfo["type"] == "1"){?>
                <div class="4u 12u$(small)">
                    <h2 class="nanumGothic"><?=$MYPAGE_ELEMENTS["menu"]["ordinary"]?></h2>
                </div>
                <div class="8u$ 12u$(small) align-left">
                    <h3 style="color:black;" class="nanumGothic" ><?=$userInfo["name"]?></h3>
                    <input class="smallTextBox" type="text" name="phone" id="phone" placeholder="휴대폰 번호" value="<?=$userInfo["phone"]?>"/>

                    <input class="smallTextBox" type="text" name="zipcode" id="zipcode" placeholder="우편번호" value="<?=$userInfo["zipcode"]?>" readonly/>
                    <a href="#" class="grayButton roundButton innerButton jAddress">주소찾기</a>
                    <input class="smallTextBox" type="text" name="addr" id="addr" placeholder="주소" value="<?=$userInfo["addr"]?>" readonly/>
                    <input class="smallTextBox" type="text" name="addrDetail" id="addrDetail" placeholder="상세주소" value="<?=$userInfo["addrDetail"]?>" />
                </div>
            <?}else if($userInfo["type"] == "2"){?>
                <div class="4u 12u$(small)">
                    <h2 class="nanumGothic"><?=$MYPAGE_ELEMENTS["menu"]["church"]?></h2>
                </div>
                <div class="8u$ 12u$(small) align-left">
                    <input class="smallTextBox" type="text" name="cName" id="cName" placeholder="교회/단체명" value="<?=$userInfo["cName"]?>" />
                    <input class="smallTextBox" type="text" name="cPhone" id="CPhone" placeholder="교회/단체 전화번호" value="<?=$userInfo["cPhone"]?>" />
                    <input class="smallTextBox" type="text" name="zipcode" id="zipcode" placeholder="우편번호" value="<?=$userInfo["zipcode"]?>" readonly/>
                    <a href="#" class="grayButton roundButton innerButton jAddress">주소찾기</a>
                    <input class="smallTextBox" type="text" name="addr" id="addr" placeholder="주소" value="<?=$userInfo["addr"]?>" readonly/>
                    <input class="smallTextBox" type="text" name="addrDetail" id="addrDetail" placeholder="상세주소" value="<?=$userInfo["addrDetail"]?>" />
                </div>

                <div class="4u 12u$(small)">
                    <h2 class="nanumGothic"><?=$MYPAGE_ELEMENTS["menu"]["charge"]?></h2>
                </div>
                <div class="8u$ 12u$(small) align-left">
                    <input class="smallTextBox" type="text" name="name" id="name" placeholder="담당자 성함" value="<?=$userInfo["name"]?>"/>
                    <input class="smallTextBox" type="text" name="rank" id="rank" placeholder="담당자 직분" value="<?=$userInfo["rank"]?>"/>
                    <input class="smallTextBox" type="text" name="phone" id="phone" placeholder="휴대폰 번호" value="<?=$userInfo["phone"]?>"/>
                </div>
            <?}?>

            <div class="4u 12u$(small)">
                <h2 class="nanumGothic"><?=$MYPAGE_ELEMENTS["menu"]["payMethod"]?></h2>
            </div>
            <div class="8u$ 12u$(small) align-left">
                <h3 class="nanumGothic">카드사/계좌이체/직접입금 &nbsp;&nbsp; 카드번호 앞 네자리</h3>
            </div>

            <div class="4u 12u$(small)">
                <h2 class="nanumGothic"><?=$MYPAGE_ELEMENTS["menu"]["subscription"]?></h2>
            </div>
            <div class="8u$ 12u$(small) align-left">
                <table>
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>받는 분</th>
                        <th>버전</th>
                        <th>수량</th>
                        <th>배송정보</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?for($i=0; $i<sizeof($subscriptionInfo); $i++){?>
                        <tr>
                            <td><?=$i+1?></td>
                            <td>
                                <?=$subscriptionInfo[$i]["rName"] == "" ? $user->name : $subscriptionInfo[$i]["rName"]?>
                            </td>
                            <td><?=$subscriptionInfo[$i]["publicationName"]?></td>
                            <td><?=$subscriptionInfo[$i]["cnt"]?></td>
                            <td>
                                <?
                                    switch($subscriptionInfo[$i]["deliveryStatus"]){
                                        case 0:
                                            echo "배송준비중";
                                            break;
                                    }
                                ?>
                            </td>
                        </tr>
                    <?}?>
                    </tbody>
                </table>
            </div>

            <div class="4u 12u$(small)">
                <h2 class="nanumGothic"><?=$MYPAGE_ELEMENTS["menu"]["support"]?></h2>
            </div>
            <div class="8u$ 12u$(small) align-left">
                <table>
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>후원자명</th>
                        <th>시작한 날짜</th>
                        <th>금액</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?for($i=0; $i<sizeof($supportInfo); $i++){?>
                        <tr>
                            <td><?=$i+1?></td>
                            <td><?=$supportInfo[$i]["rName"]?></td>
                            <td><?=$supportInfo[$i]["regDate"]?></td>
                            <td><?=number_format($supportInfo[$i]["totalPrice"], $decimal)?></td>
                        </tr>
                    <?}?>
                    </tbody>
                </table>
            </div>
        </div>
        <a href="#" class="roundButton grayButton jCancel">취소</a>
        <a href="#" class="roundButton blueButton jSave">확인</a>
    </div>
</section>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
