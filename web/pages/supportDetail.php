<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 9.
 * Time: PM 3:47
 */
?>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebSupport.php";?>
<?
    $obj = new WebSupport($_REQUEST);
    $item = $obj->supportDetail();

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
        var user = "<?=$user->id?>";

        var currency = "<?=$currency?>";
        var decimal = "<?=$decimal?>";
        var emailCheck = "<?=$user->id == "" ? -1 : 1?>";

        setPrice(5);
        if(user > 1){
            setReadonly("[name=name]");
            setReadonly("[name=phone]");
            setReadonly("[name=email]");
        }

        $("#jCnt").change(function(){
            setPrice($(this).val());
        });

        function setPrice(cnt){
            var price = 2000;
            var value = cnt * price;

            $(".jPriceTarget").text(currency + value.format());
            $("[name=totalPrice]").val(value);
        }

        function setReadonly(selector){
            $(selector).attr("readonly", true);
        }

        $(".jCheckEmail").click(function(){
            var email = $("[name=email]").val();
            var ajax = new AjaxSender("/route.php?cmd=WebUser.checkEmail", false, "json", new sehoMap().put("email", email));
            ajax.send(function(data){
                if(data.returnCode !== 1){
                    alert("이미 사용중인 이메일입니다. 로그인 후 구독신청해주세요\n" +
                        "문의 1644-9159");
                    location.href = "/web/pages/login.php";
                }
                else emailCheck = 1;
            })
        });

        $(".jOrder").click(function(){
            if(emailCheck != 1){
                alert("이메일 중복 체크를 해주시길 바랍니다.");
                return;
            }
            if($("[name=phone]").val() == ""){
                alert("휴대전화번호는 필수 입력 항목입니다.");
                return;
            }
            if($("[name=name]").val() == ""){
                alert("성함은 필수 입력 항목입니다.");
                return;
            }

            var ajax = new AjaxSubmit("/route.php?cmd=WebSupport.setSupportInfo", "post", true, "json", "#form");
            ajax.send(function(data){
                if(data.returnCode === 1){
                    console.log(data);
                    alert("구독신청이 완료되었습니다.");
                    location.href = "/web";
                }
                else alert("저장 실패");
            });

        });
    });
</script>

<section class="wrapper special books" style="padding-bottom:0 !important;">
    <div class="inner">
        <header>
            <h2 class="pageTitle">후원 신청/결제</h2>
            <div class="empLineT"></div>
        </header>
    </div>
</section>

<!-- Two -->
<section class="wrapper special books" style="padding-top:0 !important;">
    <div class="inner">
        <h2 class="align-left nanumGothic" style="margin-left:1.0em;">BibleTime 선물</h2>
        <form method="post" id="form" action="#" enctype="multipart/form-data">
            <input type="hidden" name="parentId" value="<?=$item["parentId"]?>" />
            <input type="hidden" name="customerId" value="<?=$user->id?>"/>
            <input type="hidden" name="type" value="<?=$_REQUEST["type"]?>" />
            <input type="hidden" name="totalPrice" value="" />
            <div class="row uniform" style="margin : 0 1em;">
                <div class="6u 12u$(small)">
                    <div class="image fit">
                        <img src="<?=$obj->fileShowPath.$item["titleImg"]?>" style="margin : 0 auto; max-width:10em;" />
                    </div>
                </div>
                <div class="6u 12u$(small) align-left">
                    <text class="roundButton captionBtn">후원</text><br/><br/>
                    <div class="row">
                        <h2 class="nanumGothic" style="color:black; font-size:1.5em;">BibleTime 선물하기</h2>

                        <div class="select-wrapper" style="width:40%;">
                            <select name="cnt" id="jCnt">
                                <?for($i=1; $i<=100; $i++){?>
                                    <option value="<?=$i?>" <?=$i == 5 ? "selected" : ""?>><?=$i?> 권</option>
                                <?}?>
                            </select>
                        </div>
                    </div>

                    <br/>
                    <div class="row">
                        <div style="color:black;" class="nanumGothic 3u 12u$(small)">결제유형</div>
                        <div style="color:black;" class="nanumGothic 6u 12u$(small)">정기후원</div>
                    </div>
                    <br/>
                    <div class="row">
                        <div style="color:black;" class="nanumGothic 3u 12u$(small)">결제금액</div>
                        <div style="color:#3498DB;" class="nanumGothic 6u 12u$(small)"><text class="jPriceTarget"></text> / 월</div>
                    </div>
                    <br/>
                </div>
            </div>


            <div class="row" style="margin-top : 1em;">
                <div class="6u 12u$(small)">
                    <h2 class="nanumGothic">신청자 정보</h2>
                </div>
                <div class="6u$ 12u$(small) align-left">

                    <input class="smallTextBox" type="text" name="name" placeholder="보내는 분 성함" value="<?=$user->name?>"/>
                    <input class="smallTextBox" type="text" name="email" placeholder="이메일" value="<?=$user->email?>"/>
                    <?if($user->id == ""){?>
                        <a href="#" class="grayButton roundButton innerButton jCheckEmail">이메일 중복체크</a>
                        <br/><br/>
                    <?}?>
                    <div style="font-size:0.8em; color:black!important;" class="nanumGothic 9u 12u$(small)">* 해외에 계신 경우 국가번호를 함께 아래와 같이 입력해주세요.<br/>예)+11234567890</div>
                    <input class="smallTextBox" type="text" name="phone" placeholder="휴대폰 번호 (-없이 입력)" value="<?=$user->phone?>"/>
                    <input class="smallTextBox" type="text" name="message" placeholder="응원글을 입력해 주세요"/>
                </div>

                <div class="6u 12u$(small)" style="margin-top : 1em;">
                    <h2 class="nanumGothic">결제정보</h2>
                </div>
                <div class="6u$ 12u$(small) align-left" style="margin-top : 1em;">
                    <a href="#" class="selected grayButton roundButton innerButton lineButton">신용카드</a>
                    <a href="#" class="grayButton roundButton innerButton lineButton">계좌이체</a>
                    <a href="#" class="grayButton roundButton innerButton lineButton">해외신용카드</a>
                </div>

                <div class="6u 12u$(small)" style="margin-top : 1em;">
                    <h2 class="nanumGothic">카드주</h2>
                </div>
                <div class="6u$ 12u$(small) align-left" style="margin-top : 1em;">
                    <input type="radio" id="cardOwner-me" name="cardOwner" checked>
                    <label for="cardOwner-me">본인</label>
                    <input type="radio" id="cardOwner-other" name="cardOwner">
                    <label for="cardOwner-other">타인</label>
                </div>

                <div class="6u 12u$(small)">
                    <h2 class="nanumGothic">카드번호</h2>
                </div>
                <div class="6u$ 12u$(small) align-left">
                    <div class="select-wrapper" style="width:30%; margin-bottom:1em;">
                        <select name="category" id="category">
                            <option value="">BC카드</option>
                            <option value="">Visa카드</option>
                            <option value="">Master카드</option>
                        </select>
                    </div>
                    <input class="smallTextBox" type="text" placeholder="받는 분 성함" />

                    <div class="row">
                        <div class="select-wrapper" style="width:40%;">
                            <!-- 현재 년도로 부터 10년 이내 -->
                            <select name="category" id="category">
                                <option value="">유효기간(년)</option>
                                <option value="">2018</option>
                                <option value="">2019</option>
                                <option value="">2020</option>
                                <option value="">2021</option>
                                <option value="">2022</option>
                                <option value="">2023</option>
                                <option value="">2024</option>
                            </select>
                        </div>
                        <div class="select-wrapper" style="width:40%;">
                            <select name="category" id="category">
                                <option value="">유효기간(월)</option>
                                <option value="">01</option>
                                <option value="">02</option>
                                <option value="">03</option>
                                <option value="">04</option>
                                <option value="">05</option>
                                <option value="">06</option>
                                <option value="">07</option>
                                <option value="">08</option>
                                <option value="">09</option>
                                <option value="">10</option>
                                <option value="">11</option>
                                <option value="">12</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div style="margin : 2em 0;">
            <p style="font-size:0.8em; color:black;">
                ※ 결제 전 꼭 확인해주세요!<br/>
                <br/>
                후원금 결제 시 카드의 경우 결제 대행업체인 [NICE 한국 사이버결제]로 승인 SMS가 전송됩니다.<br/>
                결제관련 문의 : 후원지원팀 (1644-9159 평일 9시~18시/공휴일제외) / team@bibletime.com<br/>
                구독 : 개인 카드(1일), 계좌이체(5일) / 단체 (15일)  ｜ 후원 :  개인/단체 (25일)
            </p>
            <a href="#" class="orgButton roundButton jOrder">결제</a>
        </div>
    </div>
    </div>
</section>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>