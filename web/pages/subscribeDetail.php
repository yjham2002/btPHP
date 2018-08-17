<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 9.
 * Time: PM 3:30
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebSubscription.php";?>
<?
    $obj = new WebSubscription($_REQUEST);
    $item = $obj->publicationDetail();
    if($item == ""){
        echo "<script>alert('비정상적인 접근입니다.')</script>";
        echo "<script>history.back();</script>";
    }
    $list = $obj->publicationList();

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
        var type = "<?=$_REQUEST["type"]?>"
        var currency = "<?=$currency?>";
        var decimal = "<?=$decimal?>";
        var emailCheck = -1;

        setPrice($("#jCnt").val());

        $("#jCategory").change(function(){
            var id = $(this).val();
            location.href = "/web/pages/subscribeDetail.php?id=" + id + "&type=" + type;
        });

        $("#jCnt").change(function(){
            setPrice($(this).val());
        });

        function setPrice(cnt){
            var price = "<?=$item["price"]?>";
            var discounted = "<?=$item["discounted"]?>";
            price = price.replace(/[^0-9\.]/g, '');
            discounted = discounted.replace(/[^0-9\.]/g, '');

            var value = 0;
            if(type == 1) value = cnt * price;
            else value = cnt * discounted;

            $(".jPriceTarget").text(currency + value.format());
            $("[name=totalPrice]").val(value);
        }

        $(".jAddress").click(function(){
            new daum.Postcode({
                oncomplete: function(data){
                    console.log(data);
                    $("[name=zipcode]").val(data.zonecode);
                    $("[name=addr]").val(data.address);
                }
            }).open();
        });

        $(".jRAddress").click(function(){
            new daum.Postcode({
                oncomplete: function(data){
                    console.log(data);
                    $("[name=rZipcode]").val(data.zonecode);
                    $("[name=rAddr]").val(data.address);
                }
            }).open();
        });

        $(".jDup").click(function(){
            if($(this).prop("checked") == true){
                var name = $("[name=name]").val();
                var phone = $("[name=phone]").val();
                var zipcode = $("[name=zipcode]").val();
                var addr = $("[name=addr]").val();
                var addrDetail = $("[name=addrDetail]").val();

                $("[name=rName]").val(name);
                $("[name=rPhone]").val(phone);
                $("[name=rZipcode]").val(zipcode);
                $("[name=rAddr]").val(addr);
                $("[name=rAddrDetail]").val(addrDetail);
            }
        });

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
            }

            var ajax = new AjaxSubmit("/route.php?cmd=WebSubscription.setSubscriptionInfo", "post", true, "json", "#form");
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
            <h2 class="pageTitle">주문/결제</h2>
            <div class="empLineT"></div>
            <p>25일 이전에 주문하시면, 다음달 BibleTime을 만나볼 수 있습니다.</p>
        </header>
    </div>
</section>

<!-- Two -->
<section class="wrapper special books" style="padding-top:0 !important;">
    <div class="inner">
        <h2 class="align-left nanumGothic" style="margin-left:1.0em;">BibleTime 배송상품</h2>

        <form method="post" id="form" action="#" enctype="multipart/form-data">
            <input type="hidden" name="publicationId" value="<?=$_REQUEST["id"]?>" />
            <input type="hidden" name="type" value="<?=$_REQUEST["type"]?>" />
            <input type="hidden" name="totalPrice" value="" />

            <div class="row uniform" style="margin : 0 1em;">
                <div class="6u 12u$(small)">
                    <div class="image fit">
                        <img src="<?=$item["imgPath"] != "" ? $obj->fileShowPath . $item["imgPath"] : ""?>" style="margin : 0 auto; max-width:10em;"/>
                    </div>
                </div>
                <div class="6u 12u$(small) align-left">
                    <text class="roundButton captionBtn">구독신청</text><br/><br/>
                    <div class="row">

                        <div class="select-wrapper" style="width:40%;">
                            <select name="category" id="jCategory">
                                <?foreach($list as $pItem){?>
                                    <option value="<?=$pItem["publicationId"]?>" <?=$pItem["publicationId"] == $item["publicationId"] ? "selected" : ""?>><?=$pItem["name"]?></option>
                                <?}?>
                            </select>
                        </div>
                        <div class="select-wrapper" style="width:40%;">
                            <select name="publicationCnt" id="jCnt">
                                <?for($i=1; $i<=100; $i++){?>
                                    <option value="<?=$i?>" <?=$_REQUEST["cnt"] == $i ? "selected" : ""?>><?=$i?> 권</option>
                                <?}?>
                            </select>
                        </div>
                    </div>
                    <!--<h2 class="nanumGothic" style="color:black; font-size:1.5em;">BibleTime 선물하기</h2>-->
                    <br/>
                    <div class="row">
                        <div style="color:black;" class="nanumGothic 3u 12u$(small)">결제유형</div>
                        <div style="color:black;" class="nanumGothic 6u 12u$(small)">정기구독</div>
                    </div>
                    <br/>
                    <div class="row">
                        <div style="color:black;" class="nanumGothic 3u 12u$(small)">결제금액</div>
                        <div style="color:#3498DB;" class="nanumGothic 6u 12u$(small)"><text class="jPriceTarget"></text> / 월 (우편료 포함)</div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="3u 12u$(small)">&nbsp;</div>
                        <div style="font-size:0.8em;" class="nanumGothic 9u 12u$(small)">* 10권 이상 신청 시 단체 가격이 적용됩니다.</div>
                    </div>
                </div>
            </div>


            <div class="row" style="margin-top : 1em;">
                <?if($_REQUEST["type"] == "1"){?>
                    <div class="6u 12u$(small)">
                        <h2 class="nanumGothic">구매정보</h2>
                    </div>

                    <div class="6u$ 12u$(small) align-left">
                        <input class="smallTextBox" type="text" name="name" placeholder="성함" />
                        <input class="smallTextBox" type="text" name="email" placeholder="이메일" />
                        <a href="#" class="grayButton roundButton innerButton jCheckEmail">이메일 중복체크</a>
                        <br/><br/>
                        <div class="jPhoneTarget">
                            <div style="font-size:0.8em; color:black!important;" class="nanumGothic 9u 12u$(small)">* 해외에 계신 경우 국가번호를 함께 아래와 같이 입력해주세요.<br/>예)+11234567890</div>
                            <input class="smallTextBox" name="phone" type="text" placeholder="휴대폰 번호 (-없이 입력)" />
                        </div>

                        <div>
                            <input class="smallTextBox" type="text" name="zipcode" placeholder="우편번호" readonly/>
                            <a href="#" class="grayButton roundButton innerButton jAddress">주소찾기</a>
                            <input class="smallTextBox" type="text" name="addr" placeholder="주소" readonly/>
                            <input class="smallTextBox" type="text" name="addrDetail" placeholder="상세주소" />
                        </div>
                    </div>

                    <div class="6u 12u$(small)">
                        <h2 class="nanumGothic">배송정보</h2>
                    </div>
                    <div class="6u$ 12u$(small) align-left">
                        <input type="checkbox" id="con_2" class="jDup">
                        <label class="nanumGothic" for="con_2">구매정보와 동일</label>

                        <input class="smallTextBox" type="text" name="rName" placeholder="받는 분 성함" />
                        <div class="jPhoneTarget">
                            <div style="font-size:0.8em; color:black!important;" class="nanumGothic 9u 12u$(small)">* 해외에 계신 경우 국가번호를 함께 아래와 같이 입력해주세요.<br/>예)+11234567890</div>
                            <input class="smallTextBox" name="rPhone" type="text" placeholder="받는분 휴대폰 번호 (-없이 입력)" />
                        </div>

                        <div>
                            <input class="smallTextBox" type="text" name="rZipcode" placeholder="우편번호" readonly/>
                            <a href="#" class="grayButton roundButton innerButton jRAddress">주소찾기</a>
                            <input class="smallTextBox" type="text" name="rAddr" placeholder="주소" readonly/>
                            <input class="smallTextBox" type="text" name="rAddrDetail" placeholder="상세주소" />
                        </div>
                    </div>
                <?}else if($_REQUEST["type"] == "2"){?>
                    <div class="6u 12u$(small)">
                        <h2 class="nanumGothic">단체(교회) 정보</h2>
                    </div>

                    <div class="6u$ 12u$(small) align-left">
                        <input class="smallTextBox" type="text" name="cName" placeholder="교회/단체명" />
                        <input class="smallTextBox" type="text" name="cPhone" placeholder="교회/단체 전화번호" />
                    </div>

                    <div class="6u 12u$(small)">
                        <h2 class="nanumGothic">담당자 정보</h2>
                    </div>

                    <div class="6u$ 12u$(small) align-left">
                        <div>
                            <input class="smallTextBox" type="text" name="name" placeholder="담당자 성함" />
                            <input class="smallTextBox" type="text" name="rank" placeholder="담당자 직분" />
                            <input class="smallTextBox" type="text" name="email" placeholder="담당자 이메일" />
                            <a href="#" class="grayButton roundButton innerButton jCheckEmail">이메일 중복체크</a>
                            <br/><br/>
                            <div class="jPhoneTarget">
                                <div style="font-size:0.8em; color:black!important;" class="nanumGothic 9u 12u$(small)">* 해외에 계신 경우 국가번호를 함께 아래와 같이 입력해주세요.<br/>예)+11234567890</div>
                                <input class="smallTextBox" name="phone" type="text" placeholder="휴대폰 번호 (-없이 입력)" />
                            </div>
                        </div>
                    </div>

                    <div class="6u 12u$(small)">
                        <h2 class="nanumGothic">배송정보</h2>
                    </div>
                    <div class="6u$ 12u$(small) align-left">
                        <div>
                            <input class="smallTextBox" type="text" name="zipcode" placeholder="우편번호" readonly/>
                            <a href="#" class="grayButton roundButton innerButton jAddress">주소찾기</a>
                            <input class="smallTextBox" type="text" name="addr" placeholder="주소" readonly/>
                            <input class="smallTextBox" type="text" name="addrDetail" placeholder="상세주소" />
                        </div>
                    </div>
                <?}?>

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
                    <input type="radio" id="cardOwner-me" name="isOwner" value="1" checked>
                    <label for="cardOwner-me">본인</label>
                    <input type="radio" id="cardOwner-other" name="isOwner" value="0">
                    <label for="cardOwner-other">타인</label>
                </div>

                <div class="6u 12u$(small)">
                    <h2 class="nanumGothic">카드번호</h2>
                </div>
                <div class="6u$ 12u$(small) align-left">
                    <div class="select-wrapper" style="width:30%; margin-bottom:1em;">
                        <select name="cardCategory" id="category">
                            <option value="">BC카드</option>
                            <option value="">Visa카드</option>
                            <option value="">Master카드</option>
                        </select>
                    </div>
                    <input class="smallTextBox" type="text" name="receiverName" placeholder="받는 분 성함" />

                    <div class="row">
                        <div class="select-wrapper" style="width:40%;">
                            <!-- 현재 년도로 부터 10년 이내 -->
                            <select name="validThruYear" id="category">
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
                            <select name="validThruMonth" id="category">
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