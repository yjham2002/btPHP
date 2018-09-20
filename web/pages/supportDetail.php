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
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Management.php";?>
<?
    $obj = new WebSupport($_REQUEST);
    $management = new Management($_REQUEST);
    $item = $obj->supportDetail();

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
        }.ui-datepicker select{display: inline!important;}
    </style>
    <script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
    <!--[if IE]><script src="/web/assets/js/excanvas.js" type="text/javascript" charset="utf-8"></script><![endif]-->
    <script src="/web/assets/js/FileSaver.js" type="text/javascript" charset="utf-8"></script>
    <script src="/web/assets/js/canvasToBlob.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
                if($("[name=name]").val() == ""){
                    alert("성함은 필수 입력 항목입니다.");
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
                            url: "/route.php?cmd=WebSupport.setSupportInfo",
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
                                    alert("후원신청이 완료되었습니다.");
                                    location.href = "/web";
                                }
                                else alert("후원신청에 실패하였습니다.");
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
                        alert("후원신청이 완료되었습니다.");
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
            <input type="hidden" name="nationId" value="<?=$item["nationId"]?>"/>
            <input type="hidden" name="paymentType" value=""/>
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
                        <!--                            <a href="#" class="jShowOk blueButton roundButton agBtn jOrder">결제</a>-->
                        <a href="#" class="jShowOk blueButton roundButton agBtn jOrderAlter">결제(서명포함)</a>
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