<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 8.
 * Time: PM 5:09
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Statistic.php";?>
<?
$obj = new Statistic($_REQUEST);

$tableData = $obj->getGeneral();

$subTable = array();
$supTable = array();

for($i=1; $i<=2; $i++){
    $subscription = $tableData["subscription"][$i];
    $support = $tableData["support"][$i];
    foreach($subscription as $sItem){
        if ($sItem["flag"] == 0) {
            $subTable[$i][$sItem["type"]]["totalCnt"] += intval($sItem["cnt"]);
            $subTable[$i][$sItem["type"]]["totalPrice"] += intval($sItem["total"]);
        }
        if ($sItem["paymentResult"] == 1) {
            $subTable[$i][$sItem["type"]]["succCnt"] += intval($sItem["cnt"]);
            $subTable[$i][$sItem["type"]]["succPrice"] += intval($sItem["total"]);
        }
    }
    foreach($support as $sItem){
        if ($sItem["flag"] == 0) {
            $supTable[$i][$sItem["type"]]["totalCnt"] += intval($sItem["cnt"]);
            $supTable[$i][$sItem["type"]]["totalPrice"] += intval($sItem["total"]);
        }
        if ($sItem["paymentResult"] == 1) {
            $supTable[$i][$sItem["type"]]["succCnt"] += intval($sItem["cnt"]);
            $supTable[$i][$sItem["type"]]["succPrice"] += intval($sItem["total"]);
        }
    }
}

$support = $tableData["support"];
$rangeData = $obj->getRangeAsArrayFromRequest();
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/admin/js/canvasjs.min.js"></script>
<script>
    $(document).ready(function(){
        function validateRange(startYear, startMonth, endYear, endMonth){
            if(startYear == "" || startMonth == "" || endYear == "" || endMonth == ""){
                return false;
            }
            if(startYear > endYear){
                return false;
            }else if(startYear == endYear && startMonth > endMonth){
                return false;
            }
            return true;
        }

        function fillZero(){
            var tds = $("td");
            for(var e = 0; e < tds.length; e++){
                if(tds.eq(e).text() == "") tds.eq(e).text("0");
                else if(tds.eq(e).text() == "%") tds.eq(e).text("0%");
            }
        }

        fillZero();

        $(".jSearch").click(function(){
            var startYear = $("#startYear").val();
            var startMonth = $("#startMonth").val();
            var endYear = $("#endYear").val();
            var endMonth = $("#endMonth").val();

            if(!validateRange(startYear, startMonth, endYear, endMonth)){
                alert("올바른 범위를 선택하세요.");
                return;
            }

            window.location.href = window.location.href.replace( /[\?#].*|$/, "?" +
                "startYear=" + startYear + "&" +
                "startMonth=" + startMonth + "&" +
                "endYear=" + endYear + "&" +
                "endMonth=" + endMonth );
        });

    });
</script>



<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>영업 관리</a>
            </li>
            <li class="breadcrumb-item active">매출 통계</li>
        </ol>

        <div class="input-group mb-3">
            <select class="custom-select mr-2 col-2" name="startYear" id="startYear">
                <?for($i=-50; $i<50; $i++){
                    $tmp = intval(date("Y")) + $i;
                    $alter = $_REQUEST["startYear"] == "" && date("Y")== $tmp ? "selected" : "";
                    ?>
                    <option value="<?=$tmp?>" <?=$_REQUEST["startYear"] == $tmp ? "selected" : $alter?>><?=$tmp?></option>
                <?}?>
            </select>
            <select class="custom-select mr-2 col-2" name="startMonth" id="startMonth">
                <?for($i=1; $i<13; $i++){
                    $alter = $_REQUEST["startMonth"] == "" && date("m")== $i ? "selected" : "";
                    ?>
                    <option value="<?=$i < 10 ? "0".$i : $i?>" <?=$_REQUEST["startMonth"] == $i ? "selected" : $alter?>><?=$i?></option>
                <?}?>
            </select>
            <button type="button" class="btn btn-secondary ml-2 jSearch">
                <i class="fas fa-search fa-fw"></i>
            </button>

        </div>

        <div class="mb-2">
            <h3>구독</h3>
            <table class="table table-sm table-bordered text-center">
                <thead>
                <tr>
                    <th rowspan="2" width="100px"></th>
                    <th rowspan="2" width="100px">구분</th>
                    <th colspan="3" style="font-size: 12px;">건</th>
                    <th colspan="3" style="font-size: 12px;">금액</th>
                </tr>
                <tr>
                    <th style="background: #EEE; font-size: 12px;">대상</th>
                    <th style="background: #EEE; font-size: 12px;">입금</th>
                    <th style="background: #EEE; font-size: 12px;">비율</th>
                    <th style="background: #EEE; font-size: 12px;">대상</th>
                    <th style="background: #EEE; font-size: 12px;">입금</th>
                    <th style="background: #EEE; font-size: 12px;">비율</th>
                </tr>
                </thead>
                <tbody>
                <?for($j=1; $j<=2; $j++){?>
                    <tr style="height: 10px;">
                        <th rowspan="3"><?=$j==1 ? "개인" : "단체"?></th>
                        <th style="background: #EEE; font-size: 12px;">카드</th>
                        <td style="font-size: 12px;"><?=$subTable[$j]["CC"]["totalCnt"]?></td>
                        <td style="font-size: 12px;"><?=intval($subTable[$j]["CC"]["succCnt"])?></td>
                        <td style="font-size: 12px;"><?=intval($subTable[$j]["CC"]["succCnt"]) / $subTable[$j]["CC"]["totalCnt"] * 100?>%</td>
                        <td style="font-size: 12px;"><?=$subTable[$j]["CC"]["totalPrice"]?></td>
                        <td style="font-size: 12px;"><?=intval($subTable[$j]["CC"]["succPrice"])?></td>
                        <td style="font-size: 12px;"><?=intval($subTable[$j]["CC"]["succPrice"]) / $subTable[$j]["CC"]["totalPrice"] * 100?>%</td>
                    </tr>
                    <tr>
                        <th style="background: #EEE; font-size: 12px;">CMS</th>
                        <td style="font-size: 12px;"><?=$subTable[$j]["BA"]["totalCnt"]?></td>
                        <td style="font-size: 12px;"><?=intval($subTable[$j]["BA"]["succCnt"])?></td>
                        <td style="font-size: 12px;"><?=intval($subTable[$j]["BA"]["succCnt"]) / $subTable[$j]["BA"]["totalCnt"] * 100?>%</td>
                        <td style="font-size: 12px;"><?=$subTable[$j]["BA"]["totalPrice"]?></td>
                        <td style="font-size: 12px;"><?=intval($subTable[$j]["BA"]["succPrice"])?></td>
                        <td style="font-size: 12px;"><?=intval($subTable[$j]["BA"]["succPrice"]) / $subTable[$j]["BA"]["totalPrice"] * 100?>%</td>
                    </tr>
                    <tr>
                        <th style="background: #EEE; font-size: 12px;">해외카드</th>
                        <td style="font-size: 12px;"><?=$subTable[$j]["FC"]["totalCnt"]?></td>
                        <td style="font-size: 12px;"><?=intval($subTable[$j]["FC"]["succCnt"])?></td>
                        <td style="font-size: 12px;"><?=intval($subTable[$j]["FC"]["succCnt"]) / $subTable[$j]["FC"]["totalCnt"] * 100?>%</td>
                        <td style="font-size: 12px;"><?=$subTable[$j]["FC"]["totalPrice"]?></td>
                        <td style="font-size: 12px;"><?=intval($subTable[$j]["FC"]["succPrice"])?></td>
                        <td style="font-size: 12px;"><?=intval($subTable[$j]["FC"]["succPrice"]) / $subTable[$j]["FC"]["totalPrice"] * 100?>%</td>
                    </tr>
                <?}?>
                </tbody>
            </table>


            <h3>후원</h3>
            <table class="table table-sm table-bordered text-center">
                <thead>
                <tr>
                    <th rowspan="2" width="100px"></th>
                    <th rowspan="2" width="100px">구분</th>
                    <th colspan="3" style="font-size: 12px;">건</th>
                    <th colspan="3" style="font-size: 12px;">금액</th>
                </tr>
                <tr>
                    <th style="background: #EEE; font-size: 12px;">대상</th>
                    <th style="background: #EEE; font-size: 12px;">입금</th>
                    <th style="background: #EEE; font-size: 12px;">비율</th>
                    <th style="background: #EEE; font-size: 12px;">대상</th>
                    <th style="background: #EEE; font-size: 12px;">입금</th>
                    <th style="background: #EEE; font-size: 12px;">비율</th>
                </tr>
                </thead>
                <tbody>
                <?for($j=1; $j<=2; $j++){?>
                    <tr style="height: 10px;">
                        <th rowspan="3"><?=$j==1 ? "BTF" : "BTG"?></th>
                        <th style="background: #EEE; font-size: 12px;">카드</th>
                        <td style="font-size: 12px;"><?=$supTable[$j]["CC"]["totalCnt"]?></td>
                        <td style="font-size: 12px;"><?=intval($supTable[$j]["CC"]["succCnt"])?></td>
                        <td style="font-size: 12px;"><?=intval($supTable[$j]["CC"]["succCnt"]) / $supTable[$j]["CC"]["totalCnt"] * 100?>%</td>
                        <td style="font-size: 12px;"><?=$supTable[$j]["CC"]["totalPrice"]?></td>
                        <td style="font-size: 12px;"><?=intval($supTable[$j]["CC"]["succPrice"])?></td>
                        <td style="font-size: 12px;"><?=intval($supTable[$j]["CC"]["succPrice"]) / $supTable[$j]["CC"]["totalPrice"] * 100?>%</td>
                    </tr>
                    <tr>
                        <th style="background: #EEE; font-size: 12px;">CMS</th>
                        <td style="font-size: 12px;"><?=$supTable[$j]["BA"]["totalCnt"]?></td>
                        <td style="font-size: 12px;"><?=intval($supTable[$j]["BA"]["succCnt"])?></td>
                        <td style="font-size: 12px;"><?=intval($supTable[$j]["BA"]["succCnt"]) / $supTable[$j]["BA"]["totalCnt"] * 100?>%</td>
                        <td style="font-size: 12px;"><?=$supTable[$j]["BA"]["totalPrice"]?></td>
                        <td style="font-size: 12px;"><?=intval($supTable[$j]["BA"]["succPrice"])?></td>
                        <td style="font-size: 12px;"><?=intval($supTable[$j]["BA"]["succPrice"]) / $supTable[$j]["BA"]["totalPrice"] * 100?>%</td>
                    </tr>
                    <tr>
                        <th style="background: #EEE; font-size: 12px;">해외카드</th>
                        <td style="font-size: 12px;"><?=$supTable[$j]["FC"]["totalCnt"]?></td>
                        <td style="font-size: 12px;"><?=intval($supTable[$j]["FC"]["succCnt"])?></td>
                        <td style="font-size: 12px;"><?=intval($supTable[$j]["FC"]["succCnt"]) / $supTable[$j]["FC"]["totalCnt"] * 100?>%</td>
                        <td style="font-size: 12px;"><?=$supTable[$j]["FC"]["totalPrice"]?></td>
                        <td style="font-size: 12px;"><?=intval($supTable[$j]["FC"]["succPrice"])?></td>
                        <td style="font-size: 12px;"><?=intval($supTable[$j]["FC"]["succPrice"]) / $supTable[$j]["FC"]["totalPrice"] * 100?>%</td>
                    </tr>
                <?}?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
