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
        var type = "";
        var customerId = -1;

        $(".jAuthEmail").click(function(){
            $(".jImg").hide();
            $(".jEmail").fadeIn();
            type = "E";
        });

        $(".jAuthPhone").click(function(){
            $(".jImg").hide();
            $(".jPhone").fadeIn();
            type = "P";
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
            });
        });

        $(".jSendPhone").click(function(){

        });

        $(".jAuth").click(function(){
            if(type === "E"){
                var params = new sehoMap()
                    .put("customerId", customerId)
                    .put("code", $("#authText").val()).put("password", $("#password").val());
                var ajax = new AjaxSender("/route.php?cmd=WebUser.authEmail", false, "json", params);
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("비밀번호가 변경되었습니다.");
                        location.href = "/web/pages/login.php";
                    }
                });
            }
            else if(type === "P"){

            }
            else{

            }
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
                    <table class="noBorder jImg" width="50vw">
                        <tr class="noBorder whiteBG">
                            <td class="noBorder fcWrap" style="border-right: 1px solid black">
                                <img class="jAuthEmail" src="../images/authEmail.png" style="width: 20vw; cursor: pointer"/>
                            </td>
                            <td class="noBorder fcWrap">
                                <img class="jAuthPhone" src="../images/authPhone.png" style="width: 20vw; cursor: pointer"/>
                            </td>
                        </tr>
                    </table>

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
