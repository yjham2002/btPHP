<?php
/**
 * Created by PhpStorm.
 * User: 전세호
 * Date: 2018-07-31
 * Time: 오후 11:31
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Management.php";?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<?
    $obj = new Management($_REQUEST);
    $main = new AdminMain($_REQUEST);

    $item = $obj->customerInfo();
    $userInfo = $item["userInfo"];
    $paymentInfo = $item["paymentInfo"];
    $subscriptionInfo = $item["subscriptionInfo"];
    $supportInfo = $item["supportInfo"];

    $localeList = $main->getLocale();
    $localeTxt = "";
    foreach($localeList as $localeItem)
        if($localeItem["code"] == $userInfo["langCode"]) $localeTxt = $localeItem["desc"];

    $publicationList = $main->publicationList();
?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/admin/scss/smSheet.css">
<script>
    $(document).ready(function(){
        var notiFlag = "<?=$userInfo["notiFlag"]?>";
        if(notiFlag == 1) $(".jNoti[value=1]").show();
        else $(".jNoti[value=0]").show();

        $(".monthPicker").datepicker({
            showMonthAfterYear:true,
            dateFormat: 'yy-mm',
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            monthNames:['1월','2월','3월','4월','5월','6월','7 월','8월','9월','10월','11월','12월'],
            monthNamesShort:['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            onClose: function(dateText, inst) {
                var month = $("#ui-datepicker-div .ui-datepicker-month :selected").val();
                var year = $("#ui-datepicker-div .ui-datepicker-year :selected").val();
                $(this).datepicker('setDate', new Date(year, month, 1));
            }
        });

        $(".monthPicker").focus(function(){
            $(".ui-datepicker-calendar").hide();
            $("#ui-datepicker-div").position({
                my: "center top",
                at: "center bottom",
                of: $(this)
            });
        });

        $(".jNoti").click(function(){
            var id = "<?=$userInfo["id"]?>";
            var currentFlag = $(this).val();
            var flag = -1;
            if(currentFlag == 1) flag = 0;
            else flag = 1;
            var ajax = new AjaxSender("/route.php?cmd=Management.setNotiFlag", true, "json", new sehoMap().put("id", id).put("flag", flag));
            ajax.send(function(data){
                if(data.returnCode === 1){
                    alert("변경되었습니다");
                    location.reload();
                }
            });
        });

        $(".jCmenu").click(function(){
            $(".jCmenu").removeClass("btn-primary");
            $(".jCmenu").addClass("btn-secondary");

            $(this).removeClass("btn-secondary");
            $(this).addClass("btn-primary");

            console.log($(this).val());

            $(".jCTable").hide();
            $(".jCTable[value='" + $(this).val() + "']").fadeIn();
        });

        $(".jDelivery").click(function(){
            //TODO 배송조회
        });

        $(document).on("click", "[name=historyType]", function(){
            var currentType = $(this).val();
            var typeArr = new Array();
            if(currentType === "all"){
                console.log("length = 0");
                $("[name=historyType]").each(function(){
                    $(this).prop("checked", false);
                });
                $(this).prop("checked", true);
            }else{
                $("[name=historyType][value=all]").prop("checked", false);
            }

            if($("[name=historyType]:checked").length === 0){
                $("[name=historyType][value=all]").prop("checked", true);
            }

            $("[name=historyType]:checked").each(function(){
                typeArr.push($(this).val());
            });
            initHistoryTable(typeArr);
        });

        $("[name=historyType][value=all]").trigger("click");

        function initHistoryTable(typeArr){
            var ajax = new AjaxSender("/route.php?cmd=Management.historyData", true, "json", new sehoMap().put("typeArr", typeArr));
            ajax.send(function(data){
                if(data.returnCode === 1){
                    $("#historyArea").html("");
                    var arr = data.entity;
                    for(var i=0; i<arr.length; i++){
                        var row = arr[i];
                        var template = $(".historyTemplate").html();
                        template = template.replace("#{regDate}", row.regDate);
                        template = template.replace("#{id}", row.id);
                        // template = template.replace("#{type}", row.type);
                        template = template.replace("#{content}", row.content);
                        $("#historyArea").append(template);
                        $("#historyArea").find("[name='hType[]']").eq(i).val(row.type);
                    }
                }else alert("데이터 불러오기 실패!");
            });
        }

        $(".jAddHistory").click(function(){
            var template = $(".newHistoryTemplate").html();
            $("#historyAddArea").append(template);
        });

        $(".jSave").click(function(){
            var ajax = new AjaxSubmit("/route.php?cmd=Management.upsertCustomer", "post", true, "json", "#form");
            ajax.send(function(data){
                if(data.returnCode === 1){
                    location.reload();
                } else {
                    alert("레이아웃 이미지 저장 중 오류가 발생하였습니다.");
                }
            });
        });

        $(".jSaveSub").click(function(){
            var id = $(this).attr("id");
            var index = $(".jSaveSub").index($(this));
            var customerId = "<?=$userInfo["id"]?>";
            var customerLang = "<?=$userInfo["langCode"]?>";
            alert($("[name='sub_subType[]']").eq(index).val());
            var ajax = new AjaxSender("/route.php?cmd=Management.updateSubscription", true, "json", new sehoMap()
                .put("id", id).put("customerId", customerId)
                .put("customerLang", customerLang)
                .put("rName", $("[name='sub_rName[]']").eq(index).val())
                .put("rPhone", $("[name='sub_rPhone[]']").eq(index).val())
                .put("rZipCode", $("[name='sub_rZipCode[]']").eq(index).val())
                .put("rAddr", $("[name='sub_rAddr[]']").eq(index).val())
                .put("rAddrDetail", $("[name='sub_rAddrDetail[]']").eq(index).val())
                .put("publicationId", $("[name='sub_publicationId[]']").eq(index).val())
                .put("cnt", $("[name='sub_cnt[]']").eq(index).val())
                .put("subType", $("[name='sub_subType[]']").eq(index).val())
                .put("shippingType", $("[name='sub_shippingType[]']").eq(index).val())
                .put("pYear", $("[name='pYear[]']").eq(index).val())
                .put("pMonth", $("[name='pMonth[]']").eq(index).val())
                .put("eYear", $("[name='eYear[]']").eq(index).val())
                .put("eMonth", $("[name='eMonth[]']").eq(index).val())
                .put("deliveryStatus", $("[name='deliveryStatus[]']").eq(index).val())
            );
            console.log(ajax);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    alert("저장되었습니다.");
                    // location.reload();
                }
            });
        });
    });
</script>

<table  style="display: none;">
    <tbody class="historyTemplate">
    <tr>
        <td><input type="text" class="form-control" value="#{regDate}"/></td>
        <td><input type="text" class="form-control" name="historyId[]" value="#{id}"/></td>
        <td>
<!--            <input type="text" class="form-control" name="hType" value="#{type}"/>-->
            <select class="form-control" name="hType[]">
                <option value="">선택</option>
                <option value="sub">구독</option>
                <option value="sup">후원</option>
                <option value="pay">결제</option>
                <option value="etc">기타</option>
            </select>
        </td>
        <td><input type="text" class="form-control" name="historyContent[]" value="#{content}"/></td>
    </tr>
    </tbody>
</table>

<table style="display: none;">
    <tbody class="newHistoryTemplate">
    <tr>
        <td><input type="text" class="form-control" readonly/></td>
        <td><input type="text" class="form-control" name="historyId[]" readonly></td>
        <td>
            <select class="form-control" name="hType[]">
                <option value="">선택</option>
                <option value="sub">구독</option>
                <option value="sup">후원</option>
                <option value="pay">결제</option>
                <option value="etc">기타</option>
            </select>
        </td>
        <td><input type="text" class="form-control" name="historyContent[]"></td>
    </tr>
    </tbody>
</table>

<div id="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>고객관리</a>
            </li>
            <li class="breadcrumb-item active">고객정보</li>
            <li class="breadcrumb-item active">고객정보 상세</li>
        </ol>

        <div class="btn-group float-right mb-2" role="group" aria-label="Basic example">
            <button type="button" class="float-right btn btn-danger mr-5 jNoti" value="0" style="display: none;">문자/이메일 수신여부</button>
            <button type="button" class="float-right btn btn-primary mr-5 jNoti" value="1" style="display: none;">문자/이메일 수신여부</button>
            <button type="button" class="btn btn-secondary mr-2">결제 처리중</button>
            <button type="button" class="btn btn-secondary mr-2">LOST</button>
            <button type="button" class="btn btn-secondary jSave">적용</button>
        </div>

        <h2><?=$userInfo["cName"] == "" ? $userInfo["name"] : $userInfo["cName"]?></h2>

        <form method="post" id="form" action="#" enctype="multipart/form-data">
            <div class="container">
                <div class="row">
                    <div class="col-sm">
                        <table class="table table-sm table-bordered w-auto text-center">
                            <colgroup>
                                <col width="30%"/>
                                <col width="70%"/>
                            </colgroup>
                            <tr class="h-auto">
                                <td class="bg-secondary text-light">ID(이메일주소)</td>
                                <td><?=$userInfo["email"]?></td>
                            </tr>
                            <tr class="h-auto">
                                <td class="bg-secondary text-light">유형</td>
                                <td><?=$userInfo["type"] == "1" ? "개인" : "단체"?></td>
                            </tr>
                            <tr class="h-auto">
                                <td class="bg-secondary text-light">언어</td>
                                <td><?=$localeTxt?></td>
                            </tr>
                            <tr class="h-auto">
                                <td class="bg-secondary text-light">생년월일</td>
                                <td><?=$userInfo["birth"]?></td>
                            </tr>
                            <tr class="h-auto">
                                <td class="bg-secondary text-light">전화번호</td>
                                <td><?=$userInfo["phone"]?></td>
                            </tr>
                            <tr class="h-auto">
                                <td class="bg-secondary text-light">우편번호</td>
                                <td><?=$userInfo["zipcode"]?></td>
                            </tr>
                            <tr class="h-auto">
                                <td class="bg-secondary text-light">주소</td>
                                <td><?=$userInfo["addr"] . "<br>" . $userInfo["addrDetail"]?></td>
                            </tr>
                            <tr class="h-auto">
                                <td class="bg-secondary text-light">가입일시</td>
                                <td><?=$userInfo["regDate"]?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-sm">
                        <?if($userInfo["type"] == "2"){?>
                            <table class="table table-sm table-bordered w-auto text-center">
                                <colgroup>
                                    <col width="30%"/>
                                    <col width="70%"/>
                                </colgroup>
                                <tr class="h-auto">
                                    <td class="bg-secondary text-light">담당자이름</td>
                                    <td><?=$userInfo["name"]?></td>
                                </tr>
                                <tr class="h-auto">
                                    <td class="bg-secondary text-light">담당자 휴대폰</td>
                                    <td><?=$userInfo["phone"]?></td>
                                </tr>
                                <tr class="h-auto">
                                    <td class="bg-secondary text-light">담당자 직분</td>
                                    <td><?=$userInfo["rank"]?></td>
                                </tr>
                            </table>
                        <?}?>
                    </div>
                </div>
            </div>

            <hr>


            <input type="hidden" name="page" />
            <div class="btn-group float-left" role="group">
                <button type="button" class="btn btn-primary jCmenu" value="SUB">구독</button>
                <button type="button" class="btn btn-secondary jCmenu" value="SUP">후원</button>
                <button type="button" class="btn btn-secondary jCmenu" value="PAY">결제</button>
            </div>
            <!--        </form>-->
            <span class="badge badge-pill badge-primary float-right jDelivery">&nbsp;배송조회&nbsp;</span>

            <div style="width: 100%; height: 300px; overflow-y: scroll">
                <table class="table table-sm table-bordered jCTable" value="SUB">
                    <thead>
                    <tr>
                        <th width="4%">받는사람</th>
                        <th width="5%">전화번호</th>
                        <th width="3%">우편번호</th>
                        <th width="12%">주소</th>
                        <th width="6%">상세주소</th>
                        <th width="5%">버전</th>
                        <th width="3%">부수</th>
                        <th width="6%">유형</th>
                        <th width="6%">배송</th>
                        <th width="9%">신청일</th>
                        <th width="4%">시작 월호</th>
                        <th width="4%">끝나는 월호</th>
                        <th width="6%">결제정보</th>
                        <th width="6%">발송현황</th>
                        <th width="5%">상태</th>
                        <th width="6%">-</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?foreach($subscriptionInfo as $subItem){?>
                        <tr>
                            <td>
                                <input type="text" class="form-control" name="sub_rName[]" value="<?=$subItem["rName"]?>"/>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="sub_rPhone[]" value="<?=$subItem["rPhone"]?>"/>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="sub_rZipCode[]" value="<?=$subItem["rZipCode"]?>"/>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="sub_rAddr[]" value="<?=$subItem["rAddr"]?>"/>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="sub_rAddrDetail[]" value="<?=$subItem["rAddrDetail"]?>"/>
                            </td>
                            <td>
                                <select class="form-control" name="sub_publicationId[]">
                                    <?foreach($publicationList as $pubItem){?>
                                        <option value="<?=$pubItem["id"]?>" <?=$pubItem["id"] == $subItem["publicationId"] ? "selected" : ""?>>
                                            <?=$pubItem["desc"]?>
                                        </option>
                                    <?}?>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="sub_cnt[]" value="<?=$subItem["cnt"]?>"/>
                            </td>
                            <td>
                                <select class="form-control" name="sub_subType[]">
                                    <option value="">선택</option>
                                    <option value="0" <?=$subItem["subType"] == "0" ? "selected" : ""?>>개인</option>
                                    <option value="1" <?=$subItem["subType"] == "1" ? "selected" : ""?>>단체</option>
                                    <option value="2" <?=$subItem["subType"] == "2" ? "selected" : ""?>>묶음배송</option>
                                    <option value="3" <?=$subItem["subType"] == "3" ? "selected" : ""?>>표지광고</option>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" name="sub_shippingType[]">
                                    <option value="">선택</option>
                                    <option value="0" <?=$subItem["shippingType"] == "0" ? "selected" : ""?>>우편</option>
                                    <option value="1" <?=$subItem["shippingType"] == "1" ? "selected" : ""?>>택배</option>
                                </select>
                            </td>
                            <td>
                                <?=$subItem["regDate"]?>
                            </td>
                            <td>
                                <select class="form-control" name="pYear[]">
                                    <option value="">선택</option>
                                    <?for($i=-50; $i<50; $i++){
                                        $tmp = intval(date("Y")) + $i;
                                        ?>
                                        <option value="<?=$tmp?>" <?=$subItem["pYear"] == $tmp ? "selected" : ""?>><?=$tmp?></option>
                                    <?}?>
                                </select>
                                <select class="form-control" name="pMonth[]">
                                    <option value="">선택</option>
                                    <?for($i=1; $i<13; $i++){?>
                                        <option value="<?=$i?>" <?=$subItem["pMonth"] == $i ? "selected" : ""?>><?=$i?></option>
                                    <?}?>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" name="eYear[]">
                                    <option value="">선택</option>
                                    <?for($i=-50; $i<50; $i++){
                                        $tmp = intval(date("Y")) + $i;
                                        ?>
                                        <option value="<?=$tmp?>" <?=$subItem["eYear"] == $tmp ? "selected" : ""?>><?=$tmp?></option>
                                    <?}?>
                                </select>
                                <select class="form-control" name="eMonth[]">
                                    <option value="">선택</option>
                                    <?for($i=1; $i<13; $i++){?>
                                        <option value="<?=$i?>" <?=$subItem["eMonth"] == $i ? "selected" : ""?>><?=$i?></option>
                                    <?}?>
                                </select>
                            </td>
                            <td>

                            </td>
                            <td>
                                <?=$subItem["lostCnt"]?>
                                /
                                <?=$subItem["eYear"] != "" && $subItem["eMonth"] != "" ?
                                    (intval($subItem["eYear"]) - intval($subItem["pYear"])) * 12 + (intval($subItem["eMonth"]) - intval($subItem["pMonth"])) : "-"
                                ?>
                            </td>
                            <td>
                                <select class="form-control" name="deliveryStatus[]">
                                    <option value="">선택</option>
                                    <option value="0" <?=$subItem["deliveryStatus"] == "0" ? "selected" : ""?>>정상</option>
                                    <option value="1" <?=$subItem["deliveryStatus"] == "1" ? "selected" : ""?>>취소</option>
                                    <option value="2" <?=$subItem["deliveryStatus"] == "2" ? "selected" : ""?>>발송보류</option>
                                </select>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-secondary jSaveSub" id="<?=$subItem["id"]?>">저장</button>
                            </td>
                        </tr>
                    <?}?>
                    </tbody>
                </table>

                <table class="table table-sm table-bordered jCTable" value="SUP" style="display: none;">
                    <thead>
                    <tr>
                        <th>후원자명</th>
                        <th>시작한 날짜</th>
                        <th>금액</th>
                        <th>결제정보</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?foreach($supportInfo as $supItem){?>
                        <tr>
                            <td><?=$supItem["rName"]?></td>
                            <td><?=$supItem["regDate"]?></td>
                            <td><?=$supItem["totalPrice"]?></td>
                            <td></td>
                        </tr>
                    <?}?>
                    </tbody>
                </table>

                <table class="table table-sm table-bordered jCTable" value="PAY" style="display: none;">
                    <thead>
                    <tr>
                        <th>받는사람</th>
                        <th>전화번호</th>
                        <th>우편번호</th>
                        <th>주소</th>
                        <th>상태</th>
                        <th>버전</th>
                        <th>부수</th>
                        <th>시작 월호</th>
                        <th>끝나는 월호</th>
                        <th>결제정보</th>
                        <th>LOST 횟수</th>
                        <th>상태</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?foreach($subscriptionInfo as $subItem){?>
                        <tr>
                            <td><?=$subItem["rName"]?></td>
                            <td><?=$subItem["rPhone"]?></td>
                            <td><?=$subItem["rZipCode"]?></td>
                            <td><?=$subItem["rAddr"] . " " . $subItem["rAddrDetail"]?></td>
                            <td></td>
                            <td><?=$subItem["publicationName"]?></td>
                            <td><?=$subItem["cnt"]?></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    <?}?>
                    </tbody>
                </table>
            </div>

            <hr>
            <h3>History</h3>
            <div class="input-group mb-3 float-right">
                <div class="input-group-text">
                    <input type="checkbox" name="historyType" id="hOption1" value="all">
                    <label for="hOption1">전체</label>
                    &nbsp;&nbsp;
                    <input type="checkbox" name="historyType" id="hOption2" value="sub">
                    <label for="hOption1">구독</label>
                    &nbsp;&nbsp;
                    <input type="checkbox" name="historyType" id="hOption3" value="sup">
                    <label for="hOption1">후원</label>
                    &nbsp;&nbsp;
                    <input type="checkbox" name="historyType" id="hOption4" value="pay">
                    <label for="hOption1">결제</label>
                    &nbsp;&nbsp;
                    <input type="checkbox" name="historyType" id="hOption5" value="etc">
                    <label for="hOption5">기타</label>
                </div>
                <button type="button" class="btn btn-secondary ml-4 jAddHistory">+</button>
            </div>

            <div style="width: 100%; height: 500px; overflow-y: scroll">
                <table class="table table-sm table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 25%">등록일시</th>
                        <th style="width: 10%">상담ID</th>
                        <th style="width: 10%">상담유형</th>
                        <th style="width: 55%">내용</th>
                    </tr>
                    </thead>
                    <tbody id="historyArea">

                    </tbody>
                    <tbody id="historyAddArea">

                    </tbody>
                </table>
            </div>
        </form>


    </div>
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
