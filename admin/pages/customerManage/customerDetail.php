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
//    echo json_encode($paymentInfo);
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

        $(".jLost").click(function(){location.href = "/admin/pages/customerManage/Lost.php?id=<?=$_REQUEST["id"]?>"});

        $(".jCommercial").change(function(){
            var id = "<?=$_REQUEST["id"]?>";
            var object = $(this).find('input');
            var check = $(object).prop("checked") == true ? 1 : 0;
            var ajax = new AjaxSender("/route.php?cmd=Management.setCommercial", true, "json", new sehoMap()
                .put("id", id).put("type", object.attr("cType")).put("check", check));
            ajax.send(function(data){
                alert("변경되었습니다.");
                location.reload();
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
            location.href = "/admin/pages/customerManage/deliveryList.php?id=<?=$_REQUEST["id"]?>";
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

        $(document).on("click", ".historyDel", function(){
            var index = $(".historyDel").index($(this));
            $(".historyInx").eq(index).empty();
            var id = $(this).attr("id");
            if(id != undefined){
                var ajax = new AjaxSender("/route.php?cmd=Management.deleteHistory", false, "json", new sehoMap().put("id", id));
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("삭제되었습니다");
                        location.reload();
                    }
                });
            }
        });

        $("[name=historyType][value=all]").trigger("click");

        function initHistoryTable(typeArr){
            var ajax = new AjaxSender("/route.php?cmd=Management.historyData", true, "json", new sehoMap().put("id", "<?=$_REQUEST["id"]?>").put("typeArr", typeArr));
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
                        template = template.replace("#{modifier}", row.modifier == null ? "" : row.modifier);
                        template = template.replace("#{content}", row.content);
                        template = template.replace("#{id}", row.id);
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
            var ajax = new AjaxSender("/route.php?cmd=Management.updateSubscription", false, "json", new sehoMap()
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
            ajax.send(function(data){
                if(data.returnCode === 1){
                    alert("저장되었습니다.");
                    location.reload();
                }
            });
        });

        $(".jSaveSup").click(function(){
            var id = $(this).attr("id");
            var index = $(".jSaveSup").index($(this));
            var ajax = new AjaxSender("/route.php?cmd=Management.updateSupport", false, "json", new sehoMap()
                .put("customerId", "<?=$_REQUEST["id"]?>")
                .put("id", id).put("supType", $("[name='sup_supType[]']").eq(index).val())
                .put("totalPrice", $("[name='sup_totalPrice[]']").eq(index).val())
                .put("rName", $("[name='sup_rName[]']").eq(index).val())
                .put("assemblyName", $("[name='sup_assemblyName[]']").eq(index).val())
                .put("sYear", $("[name='sup_sYear[]']").eq(index).val())
                .put("sMonth", $("[name='sup_sMonth[]']").eq(index).val())
                .put("eYear", $("[name='sup_eYear[]']").eq(index).val())
                .put("eMonth", $("[name='sup_eMonth[]']").eq(index).val())
                .put("status", $("[name='sup_status[]']").eq(index).val())
            );
            ajax.send(function(data){
                if(data.returnCode === 1){
                    alert("저장되었습니다.");
                    location.reload();
                }
            });
        });

        $(".jDel").click(function(){
            var map = new sehoMap().put("id", $(this).attr("id"));
            var ajax = new AjaxSender("/route.php?cmd=Management.deleteCustomer", false, "json", map);
            if(confirm("삭제하시겠습니까?")){
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("삭제되었습니다");
                        location.href = "/admin/pages/customerManage/customerList.php"
                    }
                })
            }
        });
    });
</script>

<table  style="display: none;">
    <tbody class="historyTemplate">
    <tr class="historyInx">
        <td><input type="text" class="form-control" value="#{regDate}"/></td>
        <td>
            <input type="hidden" class="form-control" name="historyId[]" value="#{id}"/>
            <input type="text" class="form-control" name="modifier[]" value="#{modifier}"/>
        </td>
        <td>
            <select class="form-control" name="hType[]">
                <option value="">선택</option>
                <option value="sub">구독</option>
                <option value="sup">후원</option>
                <option value="pay">결제</option>
                <option value="etc">기타</option>
            </select>
        </td>
        <td><input type="text" class="form-control" name="historyContent[]" value="#{content}"/></td>
        <td><input type="button" class="btn btn-secondary historyDel" id="#{id}" name="historyDel[]" value="X"/></td>
    </tr>
    </tbody>
</table>

<table style="display: none;">
    <tbody class="newHistoryTemplate">
    <tr class="historyInx">
        <td><input type="text" class="form-control" readonly/></td>
        <td>
            <input type="hidden" class="form-control" name="historyId[]" readonly/>
            <input type="text" class="form-control" name="modifier[]"/>
        </td>
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
        <td><input type="button" class="btn btn-secondary historyDel" name="historyDel[]" value="X"/></td>
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
<!--            <button type="button" class="btn btn-secondary mr-2">결제 처리중</button>-->
            <button type="button" class="btn btn-secondary mr-2 jLost">LOST</button>
            <button type="button" class="btn btn-danger mr-2 jDel" id="<?=$_REQUEST["id"]?>">삭제</button>
        </div>

        <h2><?=$userInfo["cName"] == "" ? $userInfo["name"] : $userInfo["cName"]?></h2>

        <form method="post" id="form" action="#" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?=$_REQUEST["id"]?>"/>
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
                            <tr class="h-auto">
                                <td class="bg-secondary text-light">광고</td>
                                <td>
                                    <label class="form-check-label mr-4 jCommercial">
                                        <input class="form-check-input" type="checkbox" cType="1" <?=$userInfo["commercial1"] == "1" ? "checked" : ""?>>
                                        1도
                                    </label>
                                    <label class="form-check-label mr-4 jCommercial">
                                        <input class="form-check-input" type="checkbox" cType="2" <?=$userInfo["commercial2"] == "1" ? "checked" : ""?>>
                                        2도
                                    </label>
                                    <label class="form-check-label mr-4 jCommercial">
                                        <input class="form-check-input" type="checkbox" cType="3" <?=$userInfo["commercial3"] == "1" ? "checked" : ""?>>
                                        3도
                                    </label>
                                    <label class="form-check-label jCommercial">
                                        <input class="form-check-input" type="checkbox" cType="4" <?=$userInfo["commercial4"] == "1" ? "checked" : ""?>>
                                        4도
                                    </label>
                                </td>
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
            <span class="badge badge-pill badge-primary float-right jDelivery">&nbsp;배송조회&nbsp;</span>

            <div style="width: 100%; height: 300px; overflow-y: scroll">
                <table class="table table-sm table-bordered jCTable" value="SUB">
                    <thead>
                    <tr>
                        <th width="4%">받는사람</th>
                        <th width="8%">전화번호</th>
                        <th width="3%">우편번호</th>
                        <th width="12%">주소</th>
                        <th width="8%">상세주소</th>
                        <th width="8%">버전</th>
                        <th width="3%">부수</th>
                        <th width="6%">유형</th>
                        <th width="6%">배송</th>
                        <th width="7%">신청일</th>
                        <th width="6%">시작 월호</th>
                        <th width="6%">끝나는 월호</th>
                        <th width="4%">가격</th>
                        <th width="2%">결제정보</th>
                        <th width="5%">발송현황</th>
                        <th width="6%">상태</th>
                        <th width="6%">결제</th>
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
                                <?=$subItem["totalPrice"]?>
                            </td>
                            <td>
                                <?
                                    if($subItem["pmType"] == "CC") echo "신용카드";
                                    else if($subItem["pmType"] == "BA") echo "계좌";
                                    else if($subItem["pmType"] == "FC") echo "해외신용";
                                    echo "/ " . $subItem["info"];
                                ?>
                            </td>
                            <td>
                                <?=$subItem["lostCnt"]?>
                                /
                                <?=intval(date("Y") - intval($subItem["pYear"])) * 12 + intval(date("m") - intval($subItem["pMonth"]))?>
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
                                <button type="button" class="btn btn-sm <?
                                    switch($subItem["paymentResult"]){
                                        case "0":
                                            echo "btn-danger";
                                            break;
                                        case "1":
                                            echo "btn-primary";
                                            break;
                                        case "2":
                                            echo "btn-success";
                                            break;
                                    }
                                ?>"><?
                                        switch($subItem["paymentResult"]){
                                            case "0":
                                                echo "실패";
                                                break;
                                            case "1":
                                                echo "성공";
                                                break;
                                            case "2":
                                                echo "처리중";
                                                break;
                                        }
                                    ?></button>
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
                        <th>상태</th>
                        <th>후원자명</th>
                        <th>후원유형</th>
                        <th>후원국가</th>
                        <th>신청일자</th>
                        <th>시작년월</th>
                        <th>끝나는년월</th>
                        <th>후원집회명</th>
                        <th>가격</th>
                        <th>결제정보</th>
                        <th>결제</th>
                        <th>-</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?foreach($supportInfo as $supItem){?>
                        <tr>
                            <td>
                                <select class="form-control" name="sup_status[]">
                                    <option value="">선택</option>
                                    <option value="0" <?=$supItem["status"] == "0" ? "selected" : ""?>>정상</option>
                                    <option value="1" <?=$supItem["status"] == "1" ? "selected" : ""?>>취소</option>
                                </select>
                            </td>
                            <td><input type="text" class="form-control" name="sup_rName[]" value="<?=$supItem["rName"]?>"/></td>
                            <td>
                                <select class="form-control" name="sup_supType[]">
                                    <option value="">선택</option>
                                    <option value="BTG" <?=$supItem["supType"] == "BTG" ? "selected" : ""?>>BTG</option>
                                    <option value="BTF" <?=$supItem["supType"] == "BTF" ? "selected" : ""?>>BTF</option>
                                </select>
                            </td>
                            <td><?=$supItem["nation"]?></td>
                            <td><?=$supItem["regDate"]?></td>
                            <td>
                                <select class="form-control" name="sup_sYear[]">
                                    <option value="">선택</option>
                                    <?for($i=-50; $i<50; $i++){
                                        $tmp = intval(date("Y")) + $i;
                                        ?>
                                        <option value="<?=$tmp?>" <?=$supItem["sYear"] == $tmp ? "selected" : ""?>><?=$tmp?></option>
                                    <?}?>
                                </select>
                                <select class="form-control" name="sup_sMonth[]">
                                    <option value="">선택</option>
                                    <?for($i=1; $i<13; $i++){?>
                                        <option value="<?=$i?>" <?=$supItem["sMonth"] == $i ? "selected" : ""?>><?=$i?></option>
                                    <?}?>
                                </select>
                            </td>
                            <td>
                                <select class="form-control" name="sup_eYear[]">
                                    <option value="">선택</option>
                                    <?for($i=-50; $i<50; $i++){
                                        $tmp = intval(date("Y")) + $i;
                                        ?>
                                        <option value="<?=$tmp?>" <?=$supItem["eYear"] == $tmp ? "selected" : ""?>><?=$tmp?></option>
                                    <?}?>
                                </select>
                                <select class="form-control" name="sup_eMonth[]">
                                    <option value="">선택</option>
                                    <?for($i=1; $i<13; $i++){?>
                                        <option value="<?=$i?>" <?=$supItem["eMonth"] == $i ? "selected" : ""?>><?=$i?></option>
                                    <?}?>
                                </select>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="sup_assemblyName[]" value="<?=$supItem["assemblyName"]?>"/>
                            </td>
                            <td>
                                <input type="text" class="form-control" name="sup_totalPrice[]" value="<?=$supItem["totalPrice"]?>"/>
                            </td>
                            <td>
                                <?
                                if($supItem["pmType"] == "CC") echo "신용카드";
                                else if($supItem["pmType"] == "BA") echo "계좌";
                                else if($supItem["pmType"] == "FC") echo "해외신용";
                                echo "/ " . $supItem["info"];
                                ?>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm <?
                                switch($subItem["paymentResult"]){
                                    case "0":
                                        echo "btn-danger";
                                        break;
                                    case "1":
                                        echo "btn-primary";
                                        break;
                                    case "2":
                                        echo "btn-success";
                                        break;
                                }
                                ?>"><?
                                    switch($subItem["paymentResult"]){
                                        case "0":
                                            echo "실패";
                                            break;
                                        case "1":
                                            echo "성공";
                                            break;
                                        case "2":
                                            echo "처리중";
                                            break;
                                    }
                                    ?></button>
                            </td>
                            <td>
                                <button type="button" class="btn btn-sm btn-secondary jSaveSup" id="<?=$supItem["id"]?>">저장</button>
                            </td>
                        </tr>
                    <?}?>
                    </tbody>
                </table>

                <table class="table table-sm table-bordered jCTable" value="PAY" style="display: none;">
                    <thead>
                    <tr>
                        <th>타입</th>
                        <th>결제수단</th>
                        <th>카드사/은행</th>
                        <th>유효월/년</th>
                        <th>생년월일</th>
                        <th>금액</th>
                        <th>결제 시작일</th>
                        <th>정기 결제일</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?foreach($paymentInfo as $paymentItem){?>
                        <tr>
                            <td>
                                <?
                                    if($paymentItem["productType"] == "SUB") echo "구독";
                                    else if($paymentItem["productType"] == "SUP") echo "후원";
                                ?>
                            </td>
                            <td>
                                <?
                                    if($paymentItem["pmType"] == "CC") echo "신용카드";
                                    else if($paymentItem["pmType"] == "BA") echo "계좌";
                                    else if($paymentItem["pmType"] == "FC") echo "해외신용";
                                    echo "/ " . $paymentItem["info"];
                                ?>
                            </td>
                            <td><?=$paymentItem["bankTypeDesc"] . $paymentItem["cardTypeDesc"]?></td>
                            <td><?=$paymentItem["validThruMonth"] != "" ? $paymentItem["validThruMonth"] . "/" . $paymentItem["validThruYear"] : ""?></td>
                            <td><?=$paymentItem["primeJumin"]?></td>
                            <td><?=$paymentItem["totalPrice"]?></td>
                            <td><?=$paymentItem["paymentDate"]?></td>
                            <td><?=$paymentItem["monthlyDate"]?></td>
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
                <button type="button" class="btn btn-secondary ml-5 jSave">저장</button>
            </div>
            <div style="width: 100%; height: 500px; overflow-y: scroll">
                <table class="table table-sm table-bordered">
                    <thead>
                    <tr>
                        <th style="width: 25%">등록일시</th>
                        <th style="width: 10%">상담ID</th>
                        <th style="width: 10%">상담유형</th>
                        <th style="width: 50%">내용</th>
                        <th style="width: 5%">-</th>
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
