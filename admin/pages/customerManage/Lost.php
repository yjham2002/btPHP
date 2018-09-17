<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 9. 17.
 * Time: PM 5:38
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Management.php";?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<?
    $management = new Management($_REQUEST);
    $subscriptionInfo = $management->lostList();
?>

<script>
    $(document).ready(function(){
        $(".jLost").click(function(){
            var type = $(this).attr("sType");
            var noArr = new Array();
            var ymArr = new Array();

            var noCnt = $(".jSub:checked").length;
            if(noCnt == 0){
                alert("항목을 하나 이상 선택해주세요.");
                return;
            }
            if(confirm("신청하시겠습니까?")){
                for(var i=0; i<noCnt; i++) noArr.push($(".jSub:checked:eq(" + i + ")").val());

                $.each(noArr, function(index, item){
                    console.log(index + ":" + item);
                    var pYear = $("[name='pYear" + item + "']").val();
                    var pMonth = $("[name='pMonth" + item + "']").val();
                    console.log(pYear + "::" + pMonth);
                    ymArr.push('{"pYear":"' + pYear +'", "pMonth":"' + pMonth +'"}');
                });

                var ajax = new AjaxSender("/route.php?cmd=WebUser.setLost", false, "json", new sehoMap().put("type", type).put("noArr", noArr).put("ymArr", ymArr));
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("신청되었습니다!");
                        history.back();
                    }
                });
            }
        });
    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>고객관리</a>
            </li>
            <li class="breadcrumb-item active">고객정보</li>
            <li class="breadcrumb-item active">고객정보 상세</li>
            <li class="breadcrumb-item active">LOST</li>
        </ol>

        <table class="table table-sm table-bordered">
            <thead>
            <tr>
                <th>No.</th>
                <th>받는 분</th>
                <th>우편번호</th>
                <th>주소</th>
                <th>상세주소</th>
                <th>버전</th>
                <th>수량</th>
                <th>신청월호</th>
                <th>시작한 날짜</th>
                <th>재발송 요청</th>
            </tr>
            </thead>
            <tbody>
            <?for($i=0; $i<sizeof($subscriptionInfo); $i++){?>
                <tr>
                    <td><?=$i+1?></td>
                    <td>
                        <!--                        <input class="smallTextBox" type="text" name="rName" value="--><?//=$subscriptionInfo[$i]["rName"]?><!--" readonly/>-->
                        <?=$subscriptionInfo[$i]["rName"] == "" ? $user->name : $subscriptionInfo[$i]["rName"]?>
                    </td>
                    <td>
                        <?=$subscriptionInfo[$i]["rZipCode"]?>
                    </td>
                    <td>
                        <?=$subscriptionInfo[$i]["rAddr"]?>
                    </td>
                    <td>
                        <?=$subscriptionInfo[$i]["rAddrDetail"]?>
                    </td>
                    <td>
                        <?=$subscriptionInfo[$i]["publicationName"]?>
                    </td>
                    <td>
                        <?=$subscriptionInfo[$i]["cnt"]?>
                    </td>
                    <td>
                        <select name="pYear<?=$subscriptionInfo[$i]["id"]?>">
                            <option value="">년도</option>
                            <?for($y=-50; $y<50; $y++){
                                $tmp = intval(date("Y")) + $y;
                                ?>
                                <option value="<?=$tmp?>"><?=$tmp?></option>
                            <?}?>
                        </select>
                        <select name="pMonth<?=$subscriptionInfo[$i]["id"]?>">
                            <option value="">월호</option>
                            <?for($m=1; $m<13; $m++){?>
                                <option value="<?=$m?>"><?=$m?></option>
                            <?}?>
                        </select>
                    </td>
                    <td>
                        <?=$subscriptionInfo[$i]["regDate"]?>
                    </td>
                    <td>
                        <input type="checkbox" class="jSub" id="con_<?=$i?>" value="<?=$subscriptionInfo[$i]["id"]?>">
                        <label for="con_<?=$i?>"></label>
                    </td>
                </tr>
            <?}?>
            </tbody>
        </table>

        <hr />
        <div style="text-align:center;" class="align-left">
            <p>재발송 방법을 선택해주세요.</p>
            <input type="button" class="btn btn-sm btn-primary jLost" sType="0" value="우편">
            <input type="button" class="btn btn-sm btn-primary jLost" sType="1" value="택배">
        </div>



    </div>
</div>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>

