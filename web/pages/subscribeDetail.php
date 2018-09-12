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
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Management.php";?>
<?
    $obj = new WebSubscription($_REQUEST);
    $management = new Management($_REQUEST);
    $item = $obj->publicationDetail();
    if($item == ""){
        echo "<script>alert('비정상적인 접근입니다.')</script>";
        echo "<script>location.href='/web';</script>";
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

    $cardTypeList = $management->cardTypeList();
    $bankTypeList = $management->bankTypeList();
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
    <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
    <script>
        $(document).ready(function(){
            var user = "<?=$user->id?>";
            var type = "<?=$_REQUEST["type"]?>"
            var currency = "<?=$currency?>";
            var decimal = "<?=$decimal?>";
            var emailCheck = "<?=$user->id == "" ? -1 : 1?>";
            var locale = "<?=$_COOKIE["btLocale"]?>";

            setPrice($("#jCnt").val());

            if(user > 1){
                setReadonly("[name=name]");
                setReadonly("[name=phone]");
                setReadonly("[name=email]");
                setReadonly("[name=addrDetail]");
            }

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
                if(cnt >= 10) value = cnt * discounted + 3000;
                else value = cnt * price;

                $(".jPriceTarget").text(currency + value.format());
                $("[name=totalPrice]").val(value);
            }

            function setReadonly(selector){
                $(selector).attr("readonly", true);
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
                if(verifyEmail(email) === false){
                    alert("이메일 형식에 맞춰서 작성해 주시기 바랍니다.");
                    return;
                }

                var ajax = new AjaxSender("/route.php?cmd=WebUser.checkEmail", false, "json", new sehoMap().put("email", email));
                ajax.send(function(data){
                    if(data.returnCode !== 1){
                        alert("이미 사용중인 이메일입니다. 로그인 후 구독신청해주세요\n" +
                            "문의 1644-9159");
                        location.href = "/web/pages/login.php";
                    }
                    else{
                        emailCheck = 1;
                        alert("사용하실 수 있는 이메일 입니다.");
                    }
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

            $(".jPayType").click(function(){
                $("[name=paymentType]").val($(this).attr("type"));

                $(".jPayType").removeClass("selected");
                $(this).addClass("selected");
                var target = $(this).attr("targ");
                $(".jCardArea").hide();
                $(".jAccountArea").hide();
                $(".jForeignArea").hide();
                $("." + target).fadeIn();

                if($(this).attr("type") == "FC") $("[name=ownerName]").hide();
                else $("[name=ownerName]").show();

            });

            if(locale == "kr") $(".jPayType#firstKr").trigger("click");
            else $(".jPayType#firstF").trigger("click");
            $("[name=paymentType]").val($(".jPayType.selected").attr("type"));

            $(".jShowPo").click(function(){
                window.open("/web/pages/popup2.php?type=po_card", "_blank", "toolbar=yes,scrollbars=yes,resizable=no,width=500px,height=600px");
            });

            $(".jShowPr").click(function(){
                window.open("/web/pages/popup2.php?type=pr_card", "_blank", "toolbar=yes,scrollbars=yes,resizable=no,width=500px,height=600px");
            });

            $(".jShowPoAuto").click(function(){
                window.open("/web/pages/popup2.php?type=pr_account", "_blank", "toolbar=yes,scrollbars=yes,resizable=no,width=500px,height=600px")
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
                <input type="hidden" name="publicationId" value="<?=$_REQUEST["id"]?>"/>
                <input type="hidden" name="customerId" value="<?=$user->id?>"/>
                <input type="hidden" name="type" value="<?=$_REQUEST["type"]?>"/>
                <input type="hidden" name="totalPrice" value=""/>
                <input type="hidden" name="publicationName" value="<?=$item["name"]?>"/>
                <input type="hidden" name="paymentType" value=""/>

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
                            <input class="smallTextBox" type="text" name="name" placeholder="성함" value="<?=$user->name?>" />
                            <input class="smallTextBox" type="text" name="email" placeholder="이메일" value="<?=$user->email?>"/>
                            <?if($user->id == ""){?>
                                <a class="grayButton roundButton innerButton jCheckEmail">이메일 중복체크</a>
                                <br/><br/>
                            <?}?>
                            <div class="jPhoneTarget">
                                <div style="font-size:0.8em; color:black!important;" class="nanumGothic 9u 12u$(small)">* 해외에 계신 경우 국가번호를 함께 아래와 같이 입력해주세요.<br/>예)+11234567890</div>
                                <input class="smallTextBox" name="phone" type="text" placeholder="휴대폰 번호 (-없이 입력)" value="<?=$user->phone?>"/>
                            </div>

                            <div>
                                <input class="smallTextBox" type="text" name="zipcode" placeholder="우편번호" value="<?=$user->zipcode?>" readonly/>
                                <?if($user->id == ""){?>
                                    <a href="#" class="grayButton roundButton innerButton jAddress">주소찾기</a>
                                <?}?>
                                <input class="smallTextBox" type="text" name="addr" placeholder="주소" value="<?=$user->addr?>" readonly/>
                                <input class="smallTextBox" type="text" name="addrDetail" placeholder="상세주소" value="<?=$user->addrDetail?>" />
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
                        <?if($_COOKIE["btLocale"] == "kr"){?>
                            <a class="resBtn grayButton roundButton innerButton lineButton jPayType" id="firstKr" targ="jCardArea" type="CC">신용카드</a>
                            <a class="resBtn grayButton roundButton innerButton lineButton jPayType" targ="jAccountArea" type="BA">계좌이체</a>
                        <?}else{?>
                            <a class="resBtn grayButton roundButton innerButton lineButton jPayType" id="firstF" targ="jForeignArea" type="FC">해외신용카드</a>
                        <?}?>
                    </div>

                    <div class="6u 12u$(small)" style="margin-top : 1em;">
                        <h2 class="nanumGothic">카드/계좌주</h2>
                    </div>
                    <div class="6u$ 12u$(small) align-left" style="margin-top : 1em;">
                        <input type="radio" id="cardOwner-me" name="isOwner" value="1" checked>
                        <label for="cardOwner-me">본인</label>
                        <input type="radio" id="cardOwner-other" name="isOwner" value="0">
                        <label for="cardOwner-other">타인</label>

                        <input class="smallTextBox" type="text" name="ownerName" placeholder="카드/계좌주 성함"/>
                    </div>

                    <div class="6u 12u$(small) jCardArea" style="display: none;">
                        <h2 class="nanumGothic"></h2>
                    </div>

                    <div class="6u$ 12u$(small) align-left jCardArea" style="display: none;">
                        <div class="select-wrapper" style="width:30%; margin-bottom:1em;">
                            <select name="cardType">
                                <option value="">선택</option>
                                <?foreach($cardTypeList as $cardItem){?>
                                    <option value="<?=$cardItem["id"]?>"><?=$cardItem["desc"]?></option>
                                <?}?>
                            </select>
                        </div>

                        <div class="flex flex-4 cardNumberBox">
                            <input class="cardNumberBoxText" type="text" name="card1"/>
                            <input class="cardNumberBoxText" type="text" name="card2"/>
                            <input class="cardNumberBoxText" type="text" name="card3"/>
                            <input class="cardNumberBoxText" type="text" name="card4"/>
                        </div>

                        <br/>

                        <div class="row">
                            <div class="select-wrapper" style="width:40%;">
                                <select name="validThruYear" id="category">
                                    <option value="">유효기간(년)</option>
                                    <?for($i=intval(date("Y")); $i<=intval(date("Y")) + 20; $i++){?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                    <?}?>
                                </select>
                            </div>
                            <div class="select-wrapper" style="width:40%;">
                                <select name="validThruMonth" id="category">
                                    <option value="">유효기간(월)</option>
                                    <?for($i=1; $i<=12; $i++){?>
                                        <option value="<?=sprintf('%02d', $i)?>"><?=sprintf('%02d', $i)?></option>
                                    <?}?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="6u 12u$(small) jAccountArea" style="display: none;">
                        <h2 class="nanumGothic"></h2>
                    </div>

                    <div class="6u$ 12u$(small) align-left jAccountArea" style="display: none;">
                        <div class="select-wrapper" style="width:30%; margin-bottom:1em;">
                            <select name="bankType">
                                <option value="">선택</option>
                                <?foreach($bankTypeList as $bankItem){?>
                                    <option value="<?=$bankItem["code"]?>"><?=$bankItem["desc"]?></option>
                                <?}?>
                            </select>
                        </div>
                        <input class="smallTextBox" type="text" name="info" placeholder="계좌번호"/>
                    </div>

                    <div class="6u 12u$(small) jForeignArea" style="display: none;">
                        <h2 class="nanumGothic"></h2>
                    </div>

                    <div class="6u$ 12u$(small) align-left jForeignArea" style="display: none;">
                        <input class="smallTextBox" type="text" name="firstName" placeholder="first name"/>
                        <input class="smallTextBox" type="text" name="lastName" placeholder="last name"/>
                        <input class="smallTextBox" type="text" name="aAddr" placeholder="address"/>
                        <input class="smallTextBox" type="text" name="aCity" placeholder="city"/>
                        <input class="smallTextBox" type="text" name="aState" placeholder="state"/>
                        <input class="smallTextBox" type="text" name="aState" placeholder="zip"/>
                        <input class="smallTextBox" type="text" name="cardForeign" placeholder="card number"/>
                        <div class="row">
                            <div class="select-wrapper" style="width:40%;">
                                <select name="validThruYearF" id="category">
                                    <option value="">validThru(year)</option>
                                    <?for($i=intval(date("Y")); $i<=intval(date("Y")) + 20; $i++){?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                    <?}?>
                                </select>
                            </div>
                            <div class="select-wrapper" style="width:40%;">
                                <select name="validThruMonthF" id="category">
                                    <option value="">validThru(month)</option>
                                    <?for($i=1; $i<=12; $i++){?>
                                        <option value="<?=sprintf('%02d', $i)?>"><?=sprintf('%02d', $i)?></option>
                                    <?}?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <div class="jCardArea" style="margin : 2em 0; display: none;">
                <table class="noBorder jAgree">
                    <tr class="noBorder whiteBG">
                        <td colspan="2" style="text-align:left;">
                            <b>약관 및 이용동의</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>자동이체 서비스 이용약관을 확인하였으며,수집·이용에 동의합니다.
                            </p>
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
                            <p>위와 같이 금융거래정보의 제공 및 개인정보 수집 및 이용, 개인정보 제 3 자 제공에 동의하며, 자동이체 서비스 약관을 확인하고 자동이체 이용을 신청합니다.</p>
                            <a href="#" class="jShowOk blueButton roundButton agBtn jOrder">결제</a>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="jAccountArea" style="margin : 2em 0; display: none;">
                <table class="noBorder jAgree">
                    <tr class="noBorder whiteBG">
                        <td colspan="2" style="text-align:left;">
                            <b>약관 및 이용동의</b>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p>개인정보 수집 및 이용에 대한 안내를 확인하였으며,수집·이용에 동의합니다.</p>
                            <div class="jShowPoAuto blueButton roundButton agBtn">
                                약관 전문 보기
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="background:white;">
                            <p>위와 같이 금융거래정보의 제공 및 개인정보 수집 및 이용, 개인정보 제 3 자 제공에 동의하며, 자동이체 서비스 약관을 확인하고 자동이체 이용을 신청합니다.</p>
                            <a href="#" class="jShowOk blueButton roundButton agBtn jOrder">결제</a>
                        </td>
                    </tr>
                </table>
            </div>
            <div style="margin : 2em 0;" class="jForeignArea">
                <a href="#" class="orgButton roundButton jOrder">order</a>
            </div>
        </div>
        </div>
    </section>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>