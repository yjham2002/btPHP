<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 13.
 * Time: PM 9:07
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
    $obj = new WebUser($_REQUEST);
?>
<script>
    $(document).ready(function(){
        var customerId = -1;

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

        $(".jAuth").click(function(){
            var params = new sehoMap()
                .put("customerId", customerId)
                .put("code", $("#authText").val()).put("password", $("#password").val());
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
                            <td rowspan="2" class="loginArea noBorder">
                                <a href="#" class="jAuth confirmBtn roundButton">확인</a>
                            </td>
                        </tr>
                        <tr class="noBorder">
                            <td class="noBorder">
                                <input type="text" class="formCtrl" name="password" id="password" value="" placeholder="패스워드 입력" />
                            </td>
                        </tr>
                    </table>
            </form>
        </div>
    </div>
</section>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
