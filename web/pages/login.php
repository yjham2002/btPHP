<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 6:29
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT'] . "/web/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
    $obj = new WebUser($_REQUEST);
?>
<script>
    $(document).ready(function(){
        $(".jLogin").click(function(){
            var account = $("#userId").val();
            var password = $("#userPW").val();
            var ajax = new AjaxSender("/route.php?cmd=WebUser.login", false, "json", new sehoMap().put("account", account).put("password", password));
            ajax.send(function(data){
                if(data.returnCode === 1) location.href = "/web";
                else if(data.returnCode === -1) alert("처음 로그인을 클릭하여 비밀번호를 설정해주시기 바랍니다.");
                else alert("일치하는 계정이 존재하지 않습니다");
            });
        });

        $('input').on("keydown", function(event){
            if (event.keyCode == 13) {
                $(".jLogin").trigger("click");
            }
        });

        $(".jInit").click(function(){
            location.href = "/web/pages/accountInit.php";
        });
    });
</script>

<section class="wrapper special books">
    <div class="inner">
        <header>
            <h2 class="pageTitle">로그인</h2>
            <div class="empLineT"></div>
<!--            <p>후원과 구독을 확인하는 공간입니다.</p>-->
        </header>

        <div class="">
            <form method="post" action="#">
                <div class="formWrap loginWW">
                    <table class="noBorder">
<!--                        <tr class="noBorder whiteBG">-->
<!--                            <td colspan="2" style="text-align:left;">-->
<!--                                <a href="#" class="optionSelected privateBtn roundButton">개인</a>-->
<!--                                <a href="#" class="groundBtn roundButton">단체</a>-->
<!--                            </td>-->
<!--                        </tr>-->
                        <tr class="noBorder whiteBG">
                            <td class="noBorder fcWrap">
                                <input type="email" class="formCtrl loginTT" name="userId" id="userId" value="" placeholder="이메일 입력" />
                            </td>
                            <td rowspan="2" class="loginArea noBorder loginAA">
                                <a href="#" class="jLogin confirmBtn roundButton loginBB">확인</a>
                            </td>
                        </tr>
                        <tr class="noBorder">
                            <td class="noBorder">
                                <input type="password" class="formCtrl loginTT" name="userPW" id="userPW" value="" placeholder="패스워드 입력" />
                            </td>

                        </tr>

                        <a id="kakao-login-btn"></a>
                        <tr class="noBorder">
                            <td colspan="2" class="loginOO" style="text-align:left; color:white;">
                                <a href="#" class="optionLink jInit">처음 로그인</a> |
                                <a href="#" class="optionLink">아이디 찾기</a> |
                                <a href="#" class="optionLink jInit">비밀번호 찾기</a>
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
<? include_once $_SERVER['DOCUMENT_ROOT'] . "/web/inc/footer.php"; ?>
