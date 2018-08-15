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
    echo json_encode($info);

    $userInfo = $info["userInfo"];
    $orgInfo = $info["orgInfo"];
    $managerInfo = $info["managerInfo"];
    $subscriptionInfo = $info["subscriptionInfo"];
?>
<script>
    $(document).ready(function(){

    });
</script>

<section class="wrapper special books">
    <div class="inner mypage">
        <header>
            <h2 class="pageTitle">마이페이지</h2>
            <div class="empLineT"></div>
            <p>후원과 구독을 확인하는 공간입니다.</p>
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

            <div class="4u 12u$(small)">
                <h2 class="nanumGothic">교회/단체 정보</h2>
            </div>
            <div class="8u$ 12u$(small) align-left">
                <input class="smallTextBox" type="text" name="groupName" id="groupName" placeholder="교회 / 단체명" />
                <input class="smallTextBox" type="text" name="CRN" id="CRN" placeholder="사업자 등록 번호" />
                <a href="#" class="grayButton roundButton innerButton">변경</a>
                <input class="smallTextBox" type="text" name="zipCode" id="zipCode" placeholder="우편번호" />
                <a href="#" class="grayButton roundButton innerButton">주소찾기</a>
                <input class="smallTextBox" type="text" name="zipDetail" id="zipDetail" placeholder="상세주소" />
                <input class="smallTextBox" type="text" name="phone" id="phone" placeholder="전화번호" />
            </div>

            <div class="4u 12u$(small)">
                <h2 class="nanumGothic">담당자 정보</h2>
            </div>
            <div class="8u$ 12u$(small) align-left">
                <input class="smallTextBox" type="text" name="chargeName" id="chargeName" placeholder="교회 / 단체명" />
                <input class="smallTextBox" type="text" name="chargeLevel" id="chargeLevel" placeholder="사업자 등록 번호" />
                <input class="smallTextBox" type="text" name="chargePhone" id="chargePhone" placeholder="휴대폰 번호" />
            </div>

            <div class="4u 12u$(small)">
                <h2 class="nanumGothic">결제 정보</h2>
            </div>
            <div class="8u$ 12u$(small) align-left">
                <h3 class="nanumGothic">카드사/계좌이체/직접입금 &nbsp;&nbsp; 카드번호 앞 네자리</h3>
            </div>

            <div class="4u 12u$(small)">
                <h2 class="nanumGothic">구독 정보</h2>
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
                    <tr>
                        <td>1</td>
                        <td>김**</td>
                        <td>X3_NT</td>
                        <td>1권</td>
                        <td>배송중</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>이**</td>
                        <td>NT</td>
                        <td>5권</td>
                        <td>배송완료</td>
                    </tr>
                    <tr>
                        <td>-</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <div class="4u 12u$(small)">
                <h2 class="nanumGothic">후원내역</h2>
            </div>
            <div class="8u$ 12u$(small) align-left">
                <table>
                    <thead>
                    <tr>
                        <th>No.</th>
                        <th>후원자명</th>
                        <th>후원유형</th>
                        <th>시작한 날짜</th>
                        <th>금액</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>김**</td>
                        <td>고아후원</td>
                        <td>2018-01-01</td>
                        <td>금액</td>
                    </tr>
                    <tr>
                        <td>-</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td>-</td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <a href="#" class="roundButton grayButton">취소</a>
        <a href="#" class="roundButton blueButton">확인</a>
    </div>
</section>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
