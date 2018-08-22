<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 22.
 * Time: PM 5:16
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

<script>
    $(document).ready(function(){
        $(".jCancel").click(function(){
            history.back();
        });

        $(".jSend").click(function(){
            var title = $("[name=title]").val();
            var content = $("[name=content]").val();
            var ajax = new AjaxSender("/route.php?cmd=WebUser.sendInquiryEmail", false, "json", new sehoMap().put("title", title).put("content", content));
            ajax.send(function(data){
                if(data.returnCode === 1){
                    alert("전송되었습니다.");
                    location.href = "/web/pages/mypage.php";
                }
                else alert("전송 실패");
            });
        });
    });
</script>

    <section class="wrapper special books">
        <div class="inner mypage">
            <div class="row">
                <div class="4u 12u$(small)">
                    <h2 class="nanumGothic">문의 제목</h2>
                </div>
                <div class="8u$ 12u$(small) align-left">
                    <input type="text" class="smallTextBox" name="title" placeholder="title"/>
                </div>

                <div class="4u 12u$(small)">
                    <h2 class="nanumGothic">문의 내용</h2>
                </div>
                <div class="8u$ 12u$(small) align-left">
                    <textarea class="smallTextBox" name="content" placeholder="content" style="height: 20vh;"></textarea>
                </div>
            </div>
            <a href="#" class="roundButton grayButton jCancel">취소</a>
            <a href="#" class="roundButton blueButton jSend">전송</a>
        </div>
    </section>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>