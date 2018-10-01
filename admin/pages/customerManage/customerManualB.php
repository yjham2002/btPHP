<?php
/**
 * Created by PhpStorm.
 * User: 전세호
 * Date: 2018-07-31
 * Time: 오후 11:31
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/header.php"; ?>
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

<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<!--[if IE]><script src="/web/assets/js/excanvas.js" type="text/javascript" charset="utf-8"></script><![endif]-->
<script src="/web/assets/js/FileSaver.js" type="text/javascript" charset="utf-8"></script>
<script src="/web/assets/js/canvasToBlob.js" type="text/javascript" charset="utf-8"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

<link rel="stylesheet" href="/admin/scss/smSheet.css">
<script>
    $(document).ready(function(){
        $(".datepicker").datepicker({
            yearRange: "-100:",
            showMonthAfterYear:true,
            inline: true,
            changeMonth: true,
            changeYear: true,
            dateFormat : 'yymmdd',
            dayNamesMin:['일', '월', '화', '수', '목', '금', ' 토'],
            monthNames:['1월','2월','3월','4월','5월','6월','7 월','8월','9월','10월','11월','12월'],
            monthNamesShort:['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월']
        });
        var user = "<?=$user->id?>";
        var type = "<?=$_REQUEST["type"]?>"
        var currency = "<?=$currency?>";
        var decimal = "<?=$decimal?>";
        var emailCheck = "<?=$user->id == "" ? -1 : 1?>";
        var locale = "<?=$_COOKIE["btLocale"]?>";

        /**
         * Canvas Start
         */
        var canvas = document.getElementById("canvas");
        if(typeof G_vmlCanvasManager != 'undefined') { canvas = G_vmlCanvasManager.initElement(canvas);}
        context = canvas.getContext("2d");
        var canvasWidth = $("#canvas").parent().parent().width() - ($("#canvas").parent().parent().innerWidth() - $("#canvas").parent().parent().width());
        canvas.setAttribute('width', canvasWidth);

        $('#canvas').mousedown(function(e){
            var mouseX = e.pageX - this.offsetLeft;
            var mouseY = e.pageY - this.offsetTop;
            paint = true;
            addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop);
            redraw();
        });
        $('#canvas').mousemove(function(e){
            if(paint){
                addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
                redraw();
            }
        });
        $('#canvas').mouseup(function(e){
            paint = false;
        });
        $('#canvas').mouseleave(function(e){
            paint = false;
        });

        $(".jRedraw").click(function(){
            clickX = [];
            clickY = [];
            clickDrag = [];
            redraw();
        });

        $(".jOrderAlter").click(function(){
            if(emailCheck != 1){
                alert("이메일 중복 체크를 해주시길 바랍니다.");
                return;
            }
            if($("[name=phone]").val() == ""){
                alert("휴대전화번호는 필수 입력 항목입니다.");
                return;
            }

            if($("[name=ownerName]").val() == ""){
                alert("카드/계좌주를 입력해 주시길 바랍니다.");
                return;
            }
            if($("[name=birth]").val() == ""){
                alert("생년월일을 입력해 주시길 바랍니다.");
                return;
            }
            if($("[name=info]").val() == ""){
                alert("계좌번호를 입력해 주시길 바랍니다.");
                return;
            }
            if($("[name=bankType]").val() == ""){
                alert("은행을 입력해 주시길 바랍니다.");
                return;
            }

            var canvas = document.getElementById("canvas");
            var ctx = canvas.getContext("2d");
            ctx.font = "30px arial";
            context.fillStyle = "black";
            var name = $("[name=ownerName]").val();
            var birth = $("[name=birth]").val();
            var account = $("[name=info]").val();
            var bankType = $(".jBtype:selected").attr("desc");
            ctx.fillText(name, 20, 50);
            ctx.fillText(birth, 20, 80);
            ctx.fillText(account, 20, 110);
            ctx.fillText(bankType, 20, 140);

            canvas.toBlob(function(blob) {
                var fd = new FormData($("#form")[0]);
                fd.append("signatureFile", blob);
                if(confirm("저장하시겠습니까?")){
                    $.ajax({
                        url: "/route.php?cmd=WebSubscription.setSubscriptionInfo",
                        type : "post",
                        method : "post",
                        cache : false,
                        data : fd,
                        contentType : false,
                        processData : false,
                        dataType : "json",
                        success : function(data){
                            console.log(data);
                            if(data.returnCode === 1){
                                redraw();
                                alert("구독신청이 완료되었습니다.");
                                location.href = "/web";
                            }
                            else alert("구독 신청에 실패하였습니다.");
                        },
                        error : function(req, res, error){
                            alert(req+res+error);
                        }
                    });
                }
            });

        });

        var clickX = new Array();
        var clickY = new Array();
        var clickDrag = new Array();
        var paint;

        function addClick(x, y, dragging) {
            clickX.push(x);
            clickY.push(y);
            clickDrag.push(dragging);
        }

        function redraw(){
            context.clearRect(0, 0, context.canvas.width, context.canvas.height); // Clears the canvas

            context.fillStyle = "white";
            context.fillRect(0, 0, canvas.width, canvas.height);

            context.strokeStyle = "#222222";
            context.lineJoin = "round";
            context.lineWidth = 5;

            for(var i=0; i < clickX.length; i++) {
                context.beginPath();
                if(clickDrag[i] && i){
                    context.moveTo(clickX[i-1], clickY[i-1]);
                }else{
                    context.moveTo(clickX[i]-1, clickY[i]);
                }
                context.lineTo(clickX[i], clickY[i]);
                context.closePath();
                context.stroke();
            }
        }
        /**
         * Canvas End
         */

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

            if(locale == "kr"){
                if($("[name=ownerName]").val() == ""){
                    alert("카드/계좌주를 입력해 주시길 바랍니다.");
                    return;
                }
                if($("[name=cardType]").val() == ""){
                    alert("카드사를 입력해 주시길 바랍니다.");
                    return;
                }
                if($("[name=card1]").val() == "" || $("[name=card2]").val() == "" || $("[name=card3]").val() == "" || $("[name=card4]").val() == ""){
                    alert("카드번호를 입력해 주시길 바랍니다.");
                    return;
                }
                if($("[name=validThruYear]").val() == "" || $("[name=validThruMonth]").val() == ""){
                    alert("유효년월을 입력해 주시길 바랍니다.");
                    return;
                }
            } else{
                if($("[name=firstName]").val() == "" || $("[name=lastName]").val() == "" || $("[name=aAddr]").val() == "" || $("[name=aCity]").val() == "" ||
                    $("[name=sState]").val() == "" || $("[name=aZip]").val() == "" || $("[name=cardForeign]").val() == "" || $("[name=validThruYearF]").val() == "" ||
                    $("[name=validThruYearF]").val() == ""){
                    alert("please fill in required information");
                    return;
                }
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

        if(locale !== "kr"){
            $(".jAddress").hide();
            $("[name=addr]").attr("readonly", false);
            $("[name=zipcode]").attr("readonly", false);
            $(".jRAddress").hide();
            $("[name=rAddr]").attr("readonly", false);
            $("[name=rZipcode]").attr("readonly", false);
        }
    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>고객관리</a>
            </li>
            <li class="breadcrumb-item">고객정보</li>
            <li class="breadcrumb-item">고객정보 상세</li>
            <li class="breadcrumb-item active">구독 입력</li>
        </ol>

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
                        <div style="color:black;" class="nanumGothic 3u 12u$(small)"><?=$SUBSCRIBE_ELEMENTS["detail"]["type"]?></div>
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
                        <h2 class="nanumGothic"><?=$SUBSCRIBE_ELEMENTS["detail"]["buyerInfo"]?></h2>
                    </div>

                    <div class="6u$ 12u$(small) align-left">
                        <input class="smallTextBox" type="text" name="name" placeholder="<?=$SUBSCRIBE_ELEMENTS["detail"]["name"]?>" value="<?=$user->name?>" />
                        <input class="smallTextBox" type="text" name="email" placeholder="<?=$SUBSCRIBE_ELEMENTS["detail"]["email"]?>" value="<?=$user->email?>"/>
                        <?if($user->id == ""){?>
                            <a class="grayButton roundButton innerButton jCheckEmail"><?=$SUBSCRIBE_ELEMENTS["detail"]["emailCheck"]?></a>
                            <br/><br/>
                        <?}?>
                        <div class="jPhoneTarget">
                            <div style="font-size:0.8em; color:black!important;" class="nanumGothic 9u 12u$(small)">* 해외에 계신 경우 국가번호를 함께 아래와 같이 입력해주세요.<br/>예)+11234567890</div>
                            <input class="smallTextBox" name="phone" type="text" placeholder="<?=$SUBSCRIBE_ELEMENTS["detail"]["phone"]?>" value="<?=$user->phone?>"/>
                        </div>

                        <div>
                            <input class="smallTextBox" type="text" name="zipcode" placeholder="<?=$SUBSCRIBE_ELEMENTS["detail"]["zipcode"]?>" value="<?=$user->zipcode?>" readonly/>
                            <?if($user->id == ""){?>
                                <a href="#" class="grayButton roundButton innerButton jAddress">주소찾기</a>
                            <?}?>
                            <input class="smallTextBox" type="text" name="addr" placeholder="<?=$SUBSCRIBE_ELEMENTS["detail"]["addr"]?>" value="<?=$user->addr?>" readonly/>
                            <input class="smallTextBox" type="text" name="addrDetail" placeholder="<?=$SUBSCRIBE_ELEMENTS["detail"]["addrDetail"]?>" value="<?=$user->addrDetail?>" />
                        </div>
                    </div>

                    <div class="6u 12u$(small)">
                        <h2 class="nanumGothic"><?=$SUBSCRIBE_ELEMENTS["detail"]["shippingInfo"]?></h2>
                    </div>
                    <div class="6u$ 12u$(small) align-left">
                        <input type="checkbox" id="con_2" class="jDup">
                        <label class="nanumGothic" for="con_2"><?=$SUBSCRIBE_ELEMENTS["detail"]["same"]?></label>

                        <input class="smallTextBox" type="text" name="rName" placeholder="<?=$SUBSCRIBE_ELEMENTS["detail"]["rName"]?>" />
                        <div class="jPhoneTarget">
                            <div style="font-size:0.8em; color:black!important;" class="nanumGothic 9u 12u$(small)">* 해외에 계신 경우 국가번호를 함께 아래와 같이 입력해주세요.<br/>예)+11234567890</div>
                            <input class="smallTextBox" name="rPhone" type="text" placeholder="<?=$SUBSCRIBE_ELEMENTS["detail"]["rPhone"]?>" />
                        </div>

                        <div>
                            <input class="smallTextBox" type="text" name="rZipcode" placeholder="<?=$SUBSCRIBE_ELEMENTS["detail"]["rZipcode"]?>" readonly/>
                            <a href="#" class="grayButton roundButton innerButton jRAddress">주소찾기</a>
                            <input class="smallTextBox" type="text" name="rAddr" placeholder="<?=$SUBSCRIBE_ELEMENTS["detail"]["rAddr"]?>" readonly/>
                            <input class="smallTextBox" type="text" name="rAddrDetail" placeholder="<?=$SUBSCRIBE_ELEMENTS["detail"]["rAddrDetail"]?>" />
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
                    <h2 class="nanumGothic"><?=$SUBSCRIBE_ELEMENTS["detail"]["paymentInfo"]?></h2>
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
                    <h2 class="nanumGothic"><?=$SUBSCRIBE_ELEMENTS["detail"]["owner"]?></h2>
                </div>
                <div class="6u$ 12u$(small) align-left" style="margin-top : 1em;">
                    <input type="radio" id="cardOwner-me" name="isOwner" value="1" checked>
                    <label for="cardOwner-me"><?=$SUBSCRIBE_ELEMENTS["detail"]["mine"]?></label>
                    <input type="radio" id="cardOwner-other" name="isOwner" value="0">
                    <label for="cardOwner-other"><?=$SUBSCRIBE_ELEMENTS["detail"]["notMine"]?></label>

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
                    <input class="smallTextBox datepicker" type="text" name="birth" id="birth" placeholder="생년월일"/>
                    <div class="select-wrapper" style="width:30%; margin-bottom:1em;">
                        <select name="bankType">
                            <option value="">선택</option>
                            <?foreach($bankTypeList as $bankItem){?>
                                <option class="jBtype" value="<?=$bankItem["code"]?>" desc="<?=$bankItem["desc"]?>"><?=$bankItem["desc"]?></option>
                            <?}?>
                        </select>
                    </div>
                    <input class="smallTextBox" type="text" name="info" placeholder="계좌번호"/>
                    <p style="margin:0;">서명</p>
                    <div class="smallTextBox">
                        <canvas style="border: 1px solid black;" height="300px" id="canvas"></canvas>
                    </div>
                    <a class="resBtn grayButton roundButton innerButton lineButton jRedraw">서명 지우기</a>
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
                    <input class="smallTextBox" type="text" name="aZip" placeholder="zip"/>
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

    </div>
</div>

<? include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/footer.php"; ?>
