<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 13.
 * Time: PM 9:07
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT'] . "/web/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
    $obj = new WebUser($_REQUEST);
?>
<style>
    .agBtn{
        font-size:1.0em;
    }
    @media screen and (max-width:720px){
        .agBtn{
            font-size:0.9em;
        }
    }
</style>
<script>
    $(document).ready(function(){
        var customerId = -1;

        $(".jAgree").hide();

        $(".jAuthEmail").click(function(){
            $(".jImg").hide();
            $(".jEmail").fadeIn();
        });

        $(".jAuthPhone").click(function(){
            $(".jImg").hide();
            $(".jPhone").fadeIn();
        });

        $(".jAuthKakao").click(function(){
            $(".jImg").hide();
            $(".jKakao").fadeIn();
        });

        $(".jShowPo").click(function(){
            window.open("/web/pages/popup2.php?type=po", "_blank", "toolbar=yes,scrollbars=yes,resizable=no,width=500px,height=600px");
        });

        $(".jShowPr").click(function(){
            window.open("/web/pages/popup2.php?type=pr", "_blank", "toolbar=yes,scrollbars=yes,resizable=no,width=500px,height=600px");
        });

        $(".jSendEmail").click(function(){
            $(".jEmail").hide();
            var ajax = new AjaxSender("/route.php?cmd=WebUser.sendAuthEmail", false, "json", new sehoMap().put("email", $("#email").val()));
            ajax.send(function(data){
                if(data.returnCode === 1){
                    alert("인증번호가 전송되었습니다.");
                    $(".jAuthForm").fadeIn();
                    customerId = data.entity;
                }
                else if(data.returnCode === -1){
                    alert("일치하는 회원정보가 없습니다.");
                    location.reload();
                }
                else{
                    alert("전송 실패");
                    location.reload();
                }
            });
        });

        $(".jSendPhone").click(function(){
            $(".jPhone").hide();
            var ajax = new AjaxSender("/route.php?cmd=WebUser.sendAuthSms", false, "json", new sehoMap().put("phone", $("#phone").val()));
            ajax.send(function(data){
                if(data.returnCode === 1){
                    alert("인증번호가 전송되었습니다");
                    $(".jAuthForm").fadeIn();
                    customerId = data.entity;
                }
                else if(data.returnCode === -1){
                    alert("일치하는 회원정보가 없습니다.");
                    location.reload();
                }
                else{
                    alert("전송 실패");
                    location.reload();
                }
            });
        });

        $(".jSendKakao").click(function(){
            $(".jKakao").hide();
            var ajax = new AjaxSender("/route.php?cmd=WebUser.sendAuthKakao", false, "json", new sehoMap().put("email", $("#kEmail").val()));
            ajax.send(function(data){
                if(data.returnCode === 1){
                    alert("인증번호가 전송되었습니다");
                    $(".jAuthForm").fadeIn();
                    customerId = data.entity;
                }
                else if(data.returnCode === -1){
                    alert("일치하는 회원정보가 없습니다.");
                    location.reload();
                }
                else{
                    alert("전송 실패");
                    location.reload();
                }
            });
        });

        $(".jShowOk").click(function(){
            var password = $("#password").val();

            var params = new sehoMap()
                .put("customerId", customerId)
                .put("code", $("#authText").val()).put("password", password);
            var ajax = new AjaxSender("/route.php?cmd=WebUser.auth", false, "json", params);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    alert("비밀번호가 변경되었습니다.");
                    location.href = "/web/pages/login.php";
                }
                else if(data.returnCode === -1){
                    alert("일치하는 회원정보가 없습니다.");
                    location.reload();
                }
                else{
                    alert("전송 실패");
                    location.reload();
                }
            });
        });

        $(".jAuth").click(function(){
            var password = $("#password").val();
            var pc = $("#passwordc").val();
            if(verifyPassword(password) === false){
                alert("비밀번호 형식에 맞춰서 작성해 주시기 바랍니다.");
                return;
            }
            if(password != pc){
                alert("재확인 비밀번호가 일치하지 않습니다.");
                return;
            }
            $(".jAuthForm").hide();
            $(".jAgree").fadeIn();
        });

    });
</script>

<section class="wrapper special books">
    <div class="inner">
        <header>
            <h2 class="pageTitle">인증수단 선택</h2>
            <div class="empLineT"></div>
        </header>

        <div class="">
            <form method="post" action="#">
                <div class="row jImg" style="">
                    <!-- Break -->
                    <div class="4u 12u$(medium)">
                        <div class="image fit">
                            <img class="jAuthEmail" src="../images/authEmail.png" style="cursor: pointer; max-width:25em; margin : 0 auto;"/>
                        </div>
                    </div>
                    <div class="4u 12u$(medium)">
                        <div class="image fit">
                            <img class="jAuthPhone" src="../images/authPhone.png" style="cursor: pointer; max-width:25em; margin : 0 auto;"/>
                        </div>
                    </div>
                    <div class="4u 12u$(medium)">
                        <div class="image fit">
                            <img class="jAuthKakao" src="../images/authKakao.png" style="cursor: pointer; max-width:25em; margin : 0 auto;"/>
                        </div>
                    </div>
                </div>

                    <table class="noBorder jType">
                        <tr class="noBorder jEmail" style="display: none;">
                            <td class="noBorder">
                                <input type="text" class="formCtrl" name="email" id="email" value="" placeholder="이메일 입력" />
                            </td>
                            <td class="loginArea noBorder">
                                <a href="#" class="jSendEmail confirmBtn roundButton">전송</a>
                            </td>
                        </tr>
                        <tr class="noBorder jPhone" style="display: none;">
                            <td class="noBorder">
                                <input type="text" class="formCtrl" name="phone" id="phone" value="" placeholder="휴대폰번호 입력" />
                            </td>
                            <td class="loginArea noBorder">
                                <a href="#" class="jSendPhone confirmBtn roundButton">전송</a>
                            </td>
                        </tr>
                        <tr class="noBorder jKakao" style="display: none;">
                            <td class="noBorder">
                                <input type="text" class="formCtrl" name="kEmail" id="kEmail" value="" placeholder="이메일 입력" />
                            </td>
                            <td class="loginArea noBorder">
                                <a href="#" class="jSendKakao confirmBtn roundButton">전송</a>
                            </td>
                        </tr>
                    </table>

                    <table class="noBorder jAuthForm" style="display: none;">
                        <tr class="noBorder whiteBG">
                            <td class="noBorder fcWrap">
                                <input type="text" class="formCtrl" name="authText" id="authText" value="" placeholder="인증번호 입력" />
                            </td>
                            <td rowspan="3" class="loginArea noBorder">
                                <a href="#" class="jAuth confirmBtn roundButton">확인</a>
                            </td>
                        </tr>
                        <tr class="noBorder">
                            <td class="noBorder">
                                <input type="text" class="formCtrl" name="password" id="password" value="" placeholder="패스워드 입력" />
                            </td>
                        </tr>
                        <tr class="noBorder">
                            <td class="noBorder">
                                <input type="text" class="formCtrl" name="passwordc" id="passwordc" value="" placeholder="패스워드 재확인" />
                            </td>
                        </tr>
                    </table>

                <table class="noBorder jAgree">
                    <tr class="noBorder whiteBG">
                        <td colspan="2" style="text-align:left;">
                            <b>약관 및 이용동의</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>이용약관을 확인하였으며, 바이블타임선교회 서비스 이용을 위해 이용약관에 동의합니다.</p>
                            <div class="jShowPo blueButton roundButton agBtn">
                                약관 전문 보기
                            </div>
                        </td>
                        <td>
                            <p>개인정보 수집 및 이용에 대한 안내를 확인하였으며, 수집 이용에 동의합니다.</p>
                            <div class="jShowPr blueButton roundButton agBtn">
                                개인정보 처리방침 전문 보기
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="background:white;">
                            <p>이용 약관 및 개인 정보 이용 안내를 확인하였으며, 위 내용에 동의합니다.</p>
                            <a href="#" class="jShowOk blueButton roundButton agBtn">확인</a>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</section>

<? include_once $_SERVER['DOCUMENT_ROOT'] . "/web/inc/footer.php"; ?>
