<?php
/**
 * Created by PhpStorm.
 * User: 전세호
 * Date: 2018-07-31
 * Time: 오후 11:31
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/header.php"; ?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebSupport.php";?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Management.php";?>
<?
$obj = new WebSupport($_REQUEST);
$management = new Management($_REQUEST);
$item = $obj->supportDetail();

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

        $(".jOrderAlter").click(function(){
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

        $(".jOrder").click(function(){
            var ajax = new AjaxSubmit("/route.php?cmd=WebSupport.setSupportInfo", "post", true, "json", "#form");
            ajax.send(function(data){
                if(data.returnCode === 1){
                    console.log(data);
                    alert("후원신청이 완료되었습니다.");
                    location.href = "/admin/pages/customerManage/customerDetail.php?id=<?=$_REQUEST["customerId"]?>";
                }
                else alert("저장 실패");
            });
        });

        $(".jPayType").click(function(){
            $("[name=paymentType]").val($(this).attr("typeP"));

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

<div id="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>고객관리</a>
            </li>
            <li class="breadcrumb-item">고객정보</li>
            <li class="breadcrumb-item">고객정보 상세</li>
            <li class="breadcrumb-item active">후원 입력</li>
        </ol>

        <form method="post" id="form" action="#" enctype="multipart/form-data">
            <input type="hidden" name="parentId" value="<?=$item["parentId"]?>" />
            <input type="hidden" name="customerId" value="<?=$_REQUEST["customerId"]?>"/>
            <input type="hidden" name="type" value="<?=$_REQUEST["type"]?>" />
            <input type="hidden" name="totalPrice" value="" />
            <input type="hidden" name="nationId" value="<?=$item["nationId"]?>"/>
            <input type="hidden" name="paymentType" value=""/>
            <div class="row uniform" style="margin : 0 1em;">
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
                        <div style="color:black;" class="nanumGothic 3u 12u$(small)"><?=$SUBSCRIBE_ELEMENTS["detail"]["type"]?></div>
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
                    <h2 class="nanumGothic"><?=$SUBSCRIBE_ELEMENTS["detail"]["buyerInfo"]?></h2>
                </div>
                <div class="6u$ 12u$(small) align-left">

                    <input class="form-control" type="text" name="name" placeholder="<?=$SUBSCRIBE_ELEMENTS["detail"]["name"]?>" value="<?=$user->name?>"/>
                    <input class="form-control" type="text" name="email" placeholder="<?=$SUBSCRIBE_ELEMENTS["detail"]["email"]?>" value="<?=$user->email?>"/>
                    <?if($user->id == ""){?>
                        <a href="#" class="grayButton roundButton innerButton jCheckEmail"><?=$SUBSCRIBE_ELEMENTS["detail"]["emailCheck"]?></a>
                        <br/><br/>
                    <?}?>
                    <div style="font-size:0.8em; color:black!important;" class="nanumGothic 9u 12u$(small)">* 해외에 계신 경우 국가번호를 함께 아래와 같이 입력해주세요.<br/>예)+11234567890</div>
                    <input class="form-control" type="text" name="phone" placeholder="<?=$SUBSCRIBE_ELEMENTS["detail"]["phone"]?>" value="<?=$user->phone?>"/>
                    <input class="form-control" type="text" name="message" placeholder="응원글을 입력해 주세요"/>
                </div>

                <div class="6u 12u$(small)" style="margin-top : 1em;">
                    <h2 class="nanumGothic"><?=$SUBSCRIBE_ELEMENTS["detail"]["paymentInfo"]?></h2>
                </div>
                <div class="6u$ 12u$(small) align-left" style="margin-top : 1em;">
                    <?if($_COOKIE["btLocale"] == "kr"){?>
                        <input type="button" class="btn btn-secondary jPayType" id="firstKr" targ="jCardArea" type="CC" value="신용카드"></input>
                        <input type="button" class="btn btn-secondary jPayType" targ="jAccountArea" type="BA" value="계좌이체"></input>
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

                    <input class="form-control" type="text" name="ownerName" placeholder="카드/계좌주 성함"/>
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
                    <input class="form-control" type="text" name="info" placeholder="계좌번호"/>
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
                    <input class="form-control" type="text" name="firstName" placeholder="first name"/>
                    <input class="form-control" type="text" name="lastName" placeholder="last name"/>
                    <input class="form-control" type="text" name="aAddr" placeholder="address"/>
                    <input class="form-control" type="text" name="aCity" placeholder="city"/>
                    <input class="form-control" type="text" name="aState" placeholder="state"/>
                    <input class="form-control" type="text" name="aZip" placeholder="zip"/>
                    <input class="form-control" type="text" name="cardForeign" placeholder="card number"/>
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
