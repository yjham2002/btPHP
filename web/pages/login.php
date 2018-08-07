<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 6:29
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
$obj = new webUser($_REQUEST);
?>
<script>
    $(document).ready(function(){
        Kakao.cleanup();
        // 사용할 앱의 JavaScript 키를 설정해 주세요.
        Kakao.init('4dc7da3cb02d7e90c6e870c9902e7205');
        // 카카오 로그인 버튼을 생성합니다.
        Kakao.Auth.createLoginButton({
            container: '#kakao-login-btn',
            success: function(authObj) {
                // 로그인 성공시, API를 호출합니다.
                Kakao.API.request({
                    url: '/v1/user/me',
                    success: function(res){
                        console.log("email :::: " + res.kaccount_email);
                        console.log(JSON.stringify(res));
                    },
                    fail: function(error){
                        alert(JSON.stringify(error));
                    }
                });
            },
            fail: function(err) {
                alert(JSON.stringify(err));
            }
        });
    });
</script>

<section class="wrapper special books">
    <div class="inner">
        <header>
            <h2 class="pageTitle">마이페이지</h2>
            <div class="empLineT"></div>
            <p>후원과 구독을 확인하는 공간입니다.</p>
        </header>

        <div class="">

            <form method="post" action="#">
                <div class="formWrap">
                    <table class="noBorder">
                        <tr class="noBorder whiteBG">
                            <td colspan="2" style="text-align:left;">
                                <a href="#" class="optionSelected privateBtn roundButton">개인</a>
                                <a href="#" class="groundBtn roundButton">단체</a>
                            </td>
                        </tr>
                        <tr class="noBorder whiteBG">
                            <td class="noBorder fcWrap">
                                <input type="email" class="formCtrl" name="userId" id="userId" value="" placeholder="이메일 입력" />
                            </td>
                            <td rowspan="2" class="loginArea noBorder">
                                <a href="#" class="jLogin confirmBtn roundButton">확인</a>
                            </td>
                        </tr>
                        <tr class="noBorder">
                            <td class="noBorder">
                                <input type="password" class="formCtrl" name="userPW" id="userPW" value="" placeholder="패스워드 입력" />
                            </td>

                        </tr>

                        <a id="kakao-login-btn"></a>
                        <tr class="noBorder">
                            <td colspan="2" style="text-align:left; color:white;">
                                <a href="#" class="optionLink">처음 로그인</a> |
                                <a href="#" class="optionLink">아이디 찾기</a> |
                                <a href="#" class="optionLink">비밀번호 찾기</a>
                            </td>
                        </tr>
                        <tr class="noBorder">
                            <td colspan="2" style="text-align:left; color:white; font-size:0.8em;">
                                * 가입하실 때, 입력하셨던 이메일주소가 아이디(ID)입니다.<br/>
                                비밀번호는 본인 인증 후 변경해서 사용하실 수 있습니다.
                            </td>
                        </tr>
                    </table>
                </div>
            </form>

        </div>
    </div>
</section>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
