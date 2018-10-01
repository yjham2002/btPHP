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
    $item = $management->publicationDetail();
    $list = $management->publicationList();

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

        $(".jRAddress").click(function(){
            new daum.Postcode({
                oncomplete: function(data){
                    console.log(data);
                    $("[name=rZipcode]").val(data.zonecode);
                    $("[name=rAddr]").val(data.address);
                }
            }).open();
        });

        $(".jOrder").click(function(){
            var ajax = new AjaxSubmit("/route.php?cmd=Management.setSubscriptionInfo", "post", true, "json", "#form");
            ajax.send(function(data){
                if(data.returnCode === 1){
                    console.log(data);
                    alert("구독신청이 완료되었습니다.");
                    location.href = "/admin/pages/customerManage/customerDetail.php?id=<?=$_REQUEST["customerId"]?>";
                }
                else alert("저장 실패");
            });
        });

        $(".jPayType").click(function(){
            $("[name=paymentType]").val($(this).attr("typeP"));

            $(".jPayType").removeClass("active");
            $(this).addClass("active");
            var target = $(this).attr("targ");
            $(".jCardArea").hide();
            $(".jAccountArea").hide();
            $(".jForeignArea").hide();
            $("." + target).fadeIn();

            if($(this).attr("typeP") == "FC") $("[name=ownerName]").hide();
            else $("[name=ownerName]").show();
        });

        $(".jPayType").eq(0).trigger("click");
        $("[name=paymentType]").val($(".jPayType.active").attr("typeP"));
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
            <input type="hidden" name="customerId" value="<?=$_REQUEST["customerId"]?>"/>
            <input type="hidden" name="type" value="<?=$_REQUEST["type"]?>"/>
            <input type="hidden" name="paymentType" value=""/>

            <div class="row uniform mb-3 ml-3">
                <div class="6u 12u$(small) align-left">
                    <div class="row">
                        <div class="select-wrapper">
                            <select name="publicationId">
                                <?foreach($list as $pItem){?>
                                    <option value="<?=$pItem["id"]?>" <?=$pItem["id"] == $item["id"] ? "selected" : ""?>><?=$pItem["desc"]?></option>
                                <?}?>
                            </select>
                        </div>
                        <div class="select-wrapper ml-3">
                            <select name="publicationCnt">
                                <?for($i=1; $i<=100; $i++){?>
                                    <option value="<?=$i?>" <?=$_REQUEST["cnt"] == $i ? "selected" : ""?>><?=$i?> 권</option>
                                <?}?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">결제금액</span>
                </div>
                <input type="text" class="form-control" name="totalPrice"/>
            </div>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">수신자 이름</span>
                </div>
                <input class="form-control" type="text" name="rName"/>
            </div>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">수신자 핸드폰 번호</span>
                </div>
                <input class="form-control" name="rPhone" type="text"/>
            </div>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">배송지 우편번호</span>
                </div>
                <input class="form-control" type="text" name="rZipcode"/>
            </div>
            <a href="#" class="btn btn-secondary jRAddress mb-2">주소찾기</a>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">배송지 주소</span>
                </div>
                <input class="form-control" type="text" name="rAddr"/>
            </div>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">배송지 상세주소</span>
                </div>
                <input class="form-control" type="text" name="rAddrDetail"/>
            </div>



            <input type="button" class="btn btn-secondary jPayType" id="firstKr" targ="jCardArea" typeP="CC" value="신용카드"/>
            <input type="button" class="btn btn-secondary jPayType" targ="jAccountArea" typeP="BA" value="계좌이체"/>
            <input type="button" class="btn btn-secondary jPayType" id="firstF" targ="jForeignArea" typeP="FC" value="해외신용카드"/>

            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">소유주</span>
                </div>
                <input type="radio" class="custom-radio ml-2" id="cardOwner-me" name="isOwner" value="1" checked>
                <label for="cardOwner-me">본인</label>
                <input type="radio" class="custom-radio ml-2" id="cardOwner-other" name="isOwner" value="0">
                <label for="cardOwner-other">타인</label>
            </div>
            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">카드/계좌주 성함</span>
                </div>
                <input class="form-control" type="text" name="ownerName"/>
            </div>

            <div class="align-left jCardArea">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">카드 타입</span>
                    </div>
                    <div class="select-wrapper">
                        <select class="form-control" name="cardType">
                            <option value="">선택</option>
                            <?foreach($cardTypeList as $cardItem){?>
                                <option value="<?=$cardItem["id"]?>"><?=$cardItem["desc"]?></option>
                            <?}?>
                        </select>
                    </div>
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">카드번호</span>
                    </div>
                    <input class="form-control" type="text" name="card1"/>
                    <input class="form-control" type="text" name="card2"/>
                    <input class="form-control" type="text" name="card3"/>
                    <input class="form-control" type="text" name="card4"/>
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">유효년월</span>
                    </div>
                    <div class="select-wrapper">
                        <select class="form-control" name="validThruYear" id="category">
                            <option value="">유효기간(년)</option>
                            <?for($i=intval(date("Y")); $i<=intval(date("Y")) + 20; $i++){?>
                                <option value="<?=$i?>"><?=$i?></option>
                            <?}?>
                        </select>
                    </div>
                    <div class="select-wrapper">
                        <select class="form-control" name="validThruMonth" id="category">
                            <option value="">유효기간(월)</option>
                            <?for($i=1; $i<=12; $i++){?>
                                <option value="<?=sprintf('%02d', $i)?>"><?=sprintf('%02d', $i)?></option>
                            <?}?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="jAccountArea">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">생년월일</span>
                    </div>
                    <input class="smallTextBox datepicker" type="text" name="birth" id="birth"/>
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">은행</span>
                    </div>
                    <div class="select-wrapper">
                        <select class="form-control" name="bankType">
                            <option value="">선택</option>
                            <?foreach($bankTypeList as $bankItem){?>
                                <option class="jBtype" value="<?=$bankItem["code"]?>" desc="<?=$bankItem["desc"]?>"><?=$bankItem["desc"]?></option>
                            <?}?>
                        </select>
                    </div>
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">계좌번호</span>
                    </div>
                    <input class="form-control" type="text" name="info"/>
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">파일</span>
                    </div>
                    <div class="select-wrapper">
                        <select class="form-control" name="fileType">
                            <option value="jpg">이미지</option>
                            <option value="jpg">음성</option>
                        </select>
                    </div>
                    <input type="file" name="signatureFile"/>
                </div>
            </div>

            <div class="jForeignArea">
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">first name</span>
                    </div>
                    <input class="form-control" type="text" name="firstName"/>
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">last name</span>
                    </div>
                    <input class="form-control" type="text" name="lastName"/>
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">address</span>
                    </div>
                    <input class="form-control" type="text" name="aAddr"/>
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">city</span>
                    </div>
                    <input class="form-control" type="text" name="aCity"/>
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">state</span>
                    </div>
                    <input class="form-control" type="text" name="aState"/>
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">zip</span>
                    </div>
                    <input class="form-control" type="text" name="aZip"/>
                </div>
                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">card number</span>
                    </div>
                    <input class="form-control" type="text" name="cardForeign"/>
                </div>

                <div class="input-group mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">valid thru</span>
                    </div>
                    <div class="select-wrapper">
                        <select class="form-control" name="validThruYearF" id="category">
                            <option value="">validThru(year)</option>
                            <?for($i=intval(date("Y")); $i<=intval(date("Y")) + 20; $i++){?>
                                <option value="<?=$i?>"><?=$i?></option>
                            <?}?>
                        </select>
                    </div>
                    <div class="select-wrapper">
                        <select class="form-control" name="validThruMonthF" id="category">
                            <option value="">validThru(month)</option>
                            <?for($i=1; $i<=12; $i++){?>
                                <option value="<?=sprintf('%02d', $i)?>"><?=sprintf('%02d', $i)?></option>
                            <?}?>
                        </select>
                    </div>
                </div>
            </div>

        </form>
        <button class="btn btn-secondary mt-5 mb-2 jOrder">저장</button>
    </div>
</div>

<? include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/footer.php"; ?>
