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

$tableData = $obj->getPrints();
$graphData = $tableData;
$rangeData = $obj->getRangeAsArrayFromRequest();

?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="/admin/js/canvasjs.min.js"></script>
<script>
    $(document).ready(function(){
        var chart = new CanvasJS.Chart("chartContainer", {
            animationEnabled: true,
            axisX: { interval: 0, intervalType: "month", valueFormatString: "YYYY-MM"},
            axisY:{ valueFormatString:"#0", gridColor: "#B6B1A8", tickColor: "#B6B1A8"},
            toolTip: { shared: true, content: toolTipContent},
            data: [
                <?foreach($graphData as $key => $value){?>
                {
                    type: "stackedColumn",
                    showInLegend: true,
                    name: "<?=$key?>",
                    dataPoints: [
                        <?foreach($value as $dateKey => $dateValue){?>
                        { y: <?=$dateValue?>, x: new Date("<?=$dateKey?>") },
                        <?}?>
                    ]
                },
                <?}?>
            ]
        });
        chart.render();

        function toolTipContent(e) {
            var str = "";
            var total = 0;
            var str2, str3;
            for (var i = 0; i < e.entries.length; i++){
                var  str1 = "<br/>"+e.entries[i].dataSeries.name+": "+e.entries[i].dataPoint.y;
                total = e.entries[i].dataPoint.y + total;
                str = str.concat(str1);
            }
            total = Math.round(total * 100) / 100;
            str3 = "<br/>합계: "+total;
            return "상세정보" + str.concat(str3);
        }

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
            <li class="breadcrumb-item active">인쇄 통계</li>
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
            <b class="mr-3">~</b>
            <select class="custom-select mr-2 col-2" name="endYear" id="endYear">
                <?for($i=-50; $i<50; $i++){
                    $tmp = intval(date("Y")) + $i;
                    $alter = $_REQUEST["endYear"] == "" && date("Y")== $tmp ? "selected" : "";
                    ?>
                    <option value="<?=$tmp?>" <?=$_REQUEST["endYear"] == $tmp ? "selected" : $alter?>><?=$tmp?></option>
                <?}?>
            </select>
            <select class="custom-select mr-2 col-2" name="endMonth" id="endMonth">
                <?for($i=1; $i<13; $i++){
                    $alter = $_REQUEST["endMonth"] == "" && date("m")== $i ? "selected" : "";
                    ?>
                    <option value="<?=$i < 10 ? "0".$i : $i?>" <?=$_REQUEST["endMonth"] == $i ? "selected" : $alter?>><?=$i?></option>
                <?}?>
            </select>
            <button type="button" class="btn btn-secondary ml-2 jSearch">
                <i class="fas fa-search fa-fw"></i>
            </button>

        </div>

        <div class="mb-2">
            <table class="table table-sm table-bordered text-center">
                <thead>
                <tr>
                    <th>구분</th>
                    <?for($i = 0; $i < sizeof($rangeData); $i++){?>
                        <th style="font-size: 12px;"><?=$rangeData[$i]?></th>
                    <?}?>
                </tr>
                </thead>
                <tbody>
                <?
                $total = array();
                ?>
                <?foreach ($tableData as $key => $value){?>
                    <tr style="height: 10px;">
                        <th><?=$key?></th>
                        <?for($i = 0; $i < sizeof($rangeData); $i++){
                            $col1 = intval($tableData[$key][$rangeData[$i]]);
                            $total[$rangeData[$i]] += $col1;
                            ?>
                            <td style="font-size: 12px;"><?=$col1?></td>
                        <?}?>
                    </tr>
                <?}?>
                <tr>
                    <th>합계</th>
                    <?for($i = 0; $i < sizeof($rangeData); $i++){?>
                        <td style="font-size: 12px;"><?=$total[$rangeData[$i]]?></td>
                    <?}?>
                </tr>
                </tbody>
            </table>
        </div>

        <hr/>

        <h4>매출 통계</h4>
        <div id="chartContainer" style="height: 370px; width: 100%;"></div>

    </div>
    <!-- /.container-fluid -->
</div>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
