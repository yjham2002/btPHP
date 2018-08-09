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
    $list = $obj->publicationList();
?>
<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script>
    $(document).ready(function(){
        setPrice($("#jCnt").val());

        $("#jCategory").change(function(){
            var id = $(this).val();
            location.href = "/web/pages/subscribeDetail.php?id=" + id;
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
            if(cnt >= 10) value = cnt * discounted;
            else value = cnt * price;
            $(".jPriceTarget").text(value);
        }

        $(".jPhone").change(function(){
            if($(this).prop("checked") == true) $(".jPhoneTarget").fadeOut();
            else $(".jPhoneTarget").fadeIn();
        });

        $(".jGift").change(function(){
            if($(this).prop("checked") == true) $(".jGiftTarget").fadeIn();
            else $(".jGiftTarget").fadeOut();
        });

        $(".jAddress").click(function(){
            new daum.Postcode({
                oncomplete: function(data) {
                    console.log()
                }
            }).open();
        })

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
                        <select name="category" id="jCnt">
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
                    <div style="color:#3498DB;" class="nanumGothic 6u 12u$(small)"><text class="jPriceTarget"></text>원 / 월 (우편료 포함)</div>
                </div>
                <br/>
                <div class="row">
                    <div class="3u 12u$(small)">&nbsp;</div>
                    <div style="font-size:0.8em;" class="nanumGothic 9u 12u$(small)">* 10권 이상 신청 시 단체 가격이 적용됩니다.</div>
                </div>
            </div>
        </div>


        <div class="row" style="margin-top : 1em;">
            <div class="6u 12u$(small)">
                <h2 class="nanumGothic">배송정보</h2>
            </div>
            <div class="6u$ 12u$(small) align-left">
                <input type="checkbox" id="con_1" name="con_1" class="jGift">
                <label class="nanumGothic" for="con_1">선물하기(로그인 시 나옴)</label>
                <div class="jGiftTarget" style="display: none;">
                    <input class="smallTextBox" type="text" placeholder="받는 분 성함" />
                    <input class="smallTextBox" type="text" placeholder="이메일" />
                </div>

                <input type="checkbox" id="con_2" name="con_2" class="jPhone">
                <label class="nanumGothic" for="con_2">휴대폰이 없는 경우 체크</label>
                <div class="jPhoneTarget">
                    <input class="smallTextBox" type="text" placeholder="휴대폰 번호 (-없이 입력)" />
                    <input class="smallTextBox" type="text" placeholder="우편번호" />
                </div>

                <div>
                    <a href="#" class="grayButton roundButton innerButton jAddress">주소찾기</a>
                    <input class="smallTextBox" type="text" placeholder="상세주소" />
                </div>
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
        <div style="margin : 2em 0;">
            <p style="font-size:0.8em; color:black;">
                ※ 결제 전 꼭 확인해주세요!<br/>
                <br/>
                후원금 결제 시 카드의 경우 결제 대행업체인 [NICE 한국 사이버결제]로 승인 SMS가 전송됩니다.<br/>
                결제관련 문의 : 후원지원팀 (1644-9159 평일 9시~18시/공휴일제외) / team@bibletime.com<br/>
                구독 : 개인 카드(1일), 계좌이체(5일) / 단체 (15일)  ｜ 후원 :  개인/단체 (25일)
            </p>
            <a href="#" class="orgButton roundButton">결제</a>
        </div>
    </div>
    </div>
</section>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>