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
?>
<script>
    $(document).ready(function(){
        var notiFlag = "<?=$userInfo["notiFlag"]?>";
        if(notiFlag == 1) $(".jNoti[value=1]").show();
        else $(".jNoti[value=0]").show();

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
                $("[name=historyType]").each(function(){
                    $(this).prop("checked", false);
                });
                $(this).prop("checked", true);
            }else{
                $("[name=historyType][value=all]").prop("checked", false);
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
                        template = template.replace("#{type}", row.type);
                        template = template.replace("#{content}", row.content);
                        $("#historyArea").append(template);
                    }
                }else alert("데이터 불러오기 실패!");
            });
        }


    });
</script>

<table  style="display: none;">
    <tbody class="historyTemplate">
    <tr>
        <td>#{regDate}</td>
        <td>#{id}</td>
        <td>#{type}</td>
        <td>#{content}</td>
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
            <button type="button" class="btn btn-secondary">적용</button>
        </div>

        <h2><?=$userInfo["cName"] == "" ? $userInfo["name"] : $userInfo["cName"]?></h2>

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

        <form id="form">
            <input type="hidden" name="page" />
            <div class="btn-group float-left" role="group">
                <button type="button" class="btn btn-primary jCmenu" value="SUB">구독</button>
                <button type="button" class="btn btn-secondary jCmenu" value="SUP">후원</button>
                <button type="button" class="btn btn-secondary jCmenu" value="PAY">결제</button>
            </div>
        </form>
        <span class="badge badge-pill badge-primary float-right jDelivery">&nbsp;배송조회&nbsp;</span>

        <div style="width: 100%; height: 300px; overflow-y: scroll">
            <table class="table table-sm table-bordered jCTable" value="SUB">
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
                    <th>등록일시</th>
                    <th>상담ID</th>
                    <th>상담유형</th>
                    <th>내용</th>
                </tr>
                </thead>
                <tbody id="historyArea">

                </tbody>

                <tbody class="historyTemplate">
                <tr>
                    <td>
                        <input type="text" class="form-control"/>
                    </td>
                    <td>
                        <input type="text" class="form-control" readonly>
                    </td>
                    <td>
                        <input type="text" class="form-control">
                    </td>
                    <td>
                        <input type="text" class="form-control">
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
