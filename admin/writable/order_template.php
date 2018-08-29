<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Uncallable.php";?>
<?
$uc = new Uncallable($_REQUEST);
$CONST_PREFIX_IMAGE = "S_ORDER_";
$sign1 = $uc->getProperty($CONST_PREFIX_IMAGE."01");
$sign2 = $uc->getProperty($CONST_PREFIX_IMAGE."02");
$sign3 = $uc->getProperty($CONST_PREFIX_IMAGE."03");

$static_addr = $uc->getProperty("STATIC_ADDR");
$static_reg = $uc->getProperty("STATIC_REG");
$static_trade = $uc->getProperty("STATIC_TRADE");
$static_phone = $uc->getProperty("STATIC_PHONE");

if($_REQUEST["id"] == ""){
    echo "<script>alert('비정상적인 접근입니다.'); window.close();</script>";
}

$formData = $uc->getOrderForm();
$formJson = $formData["formJson"];

?>
<?
    $F_VALUE = json_decode(preg_replace('/[\x00-\x1F\x80-\xFF]/', '', nl2br($formJson)), true);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    <title></title>
    <meta name="author" content="BibleTime BackOffice"/>
    <meta name="created" content="2016-02-26T03:58:22"/>
    <meta name="changedby" content="BibleTime"/>
    <meta name="changed" content="2018-07-30T10:51:20"/>

    <style type="text/css" id="styleCss">
        @page {
            size: A4 portrait;
            margin: 0;
        }
        @media print {
            #toPrint {
                margin: 5mm 10mm 8mm 10mm;
                border: initial;
                border-radius: initial;
                width: initial;
                min-height: initial;
                box-shadow: initial;
                background: initial;
                page-break-after: always;
            }
            .darkBg{
                background:#C0C0C0 !important;
                background-color: #C0C0C0 !important;
                -webkit-print-color-adjust: exact;
                color-adjust: exact;
            }
        }

        .darkBg{
            background:#C0C0C0 !important;
            background-color: #C0C0C0 !important;
            -webkit-print-color-adjust: exact;
            color-adjust: exact;
        }
        body,div,table,thead,tbody,tfoot,tr,th,td,p {  font-size:13px; }

        .jRounded{
            color : white;
            background : #1a1a1a;
            border-radius: 5px;
            font-size: 15px;
            padding : 5px 30px 5px 30px;
            text-decoration: none;
        }
    </style>
    <script src="/admin/vendor/jquery/jquery.min.js"></script>
    <script src="/admin/writable/jspdf/jspdf.min.js"></script>
<!--    <script src="/admin/writable/jspdf/plugins/from_html.js"></script>-->
<!--    <script src="/admin/writable/jspdf/plugins/split_text_to_size.js"></script>-->
<!--    <script src="/admin/writable/jspdf/plugins/standard_fonts_metrics.js"></script>-->
<!--    <script src="/admin/writable/jspdf/plugins/addhtml.js"></script>-->
<!--    <script src="/admin/writable/jspdf/plugins/cell.js"></script>-->
<!--    <script src="/admin/writable/jspdf/plugins/addimage.js"></script>-->
<!--    <script src="/admin/writable/jspdf/plugins/png_support.js"></script>-->
    <script src="/admin/writable/jspdf/libs/html2canvas/dist/html2canvas.js"></script>
    <script>
        function exportToExcel(){
            var divToPrint=document.getElementById("toPrint");
            var optionCss = "#toPrint{width : 210mm;}";
            var htmls = $("#styleCss").prop("outerHTML") + "<style>" + optionCss + "</style>" + divToPrint.outerHTML;

            var uri = 'data:application/vnd.ms-excel;base64,';
            var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>';
            var base64 = function(s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            };

            var format = function(s, c) {
                return s.replace(/{(\w+)}/g, function(m, p) {
                    return c[p];
                })
            };

//            htmls = "YOUR HTML AS TABLE"

            var ctx = {
                worksheet : 'Worksheet',
                table : htmls
            }

            var link = document.createElement("a");
            link.download = "export.xls";
            link.href = uri + base64(format(template, ctx));
            link.click();
        }

        function printData() {
            var divToPrint=document.getElementById("toPrint");
            newWin= window.open("");
            newWin.document.write($("#styleCss").prop("outerHTML"));
            newWin.document.write(divToPrint.outerHTML);
            newWin.document.close();
            newWin.focus();
            newWin.print();
            newWin.close();
        }

        $(document).ready(function(){

            function exportToPdf(fileName){
                html2canvas($(".tableWrapper"), {
                    onrendered: function(canvas) {
                        var imgData = canvas.toDataURL("image/png");
                        var pdf = new jsPDF('p', 'mm', [297, 210]);
                        var leftMargin = 10;
                        var topMargin = 5;
                        pdf.addImage(imgData, 'PNG',
                            leftMargin, topMargin, 210 - (leftMargin * 2), 297 - (topMargin * 2) - 5);
                        pdf.save(fileName + '.pdf');
                    }
                });
            }

            function getDate(){
                var today = new Date();
                var dd = today.getDate();
                var mm = today.getMonth()+1; //January is 0!
                var yyyy = today.getFullYear();
                var hh = today.getHours();
                var m = today.getMinutes();
                var s = today.getSeconds();

                if(dd<10) { dd = '0'+dd; }
                if(mm<10) { mm = '0'+mm }
                if(hh<10) { hh = '0'+hh }
                if(m<10) { m = '0'+m }
                if(s<10) { s = '0'+s }

                today = yyyy + mm + dd + hh + m + s;

                return today;
            }

            $(".jPrint").click(function(){
                printData();
            });

            $(".jModify").click(function(){

            });

            $(".jDownload").click(function(){
                exportToPdf("발주서_" + getDate());
            });

            $(".jClose").click(function(){

            });

        });
    </script>

</head>

<body>

<div class="tableWrapper">
<table cellspacing="0" border="0" id="toPrint">
    <colgroup span="36" width="26"></colgroup>
    <tr>
        <td colspan=36 height="49" align="center" valign=middle><b><u><font face="DejaVu Sans" size=6>발   주   서</u></b></td>
    </tr>
    <tr>
        <td height="12" align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="center" valign=middle></td>
        <td align="left" valign=middle><br></td>
    </tr>
    <tr>
        <td height="25" align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="center" valign=middle><br></td>
        <td style="border-top: 2px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=2 align="center" valign=middle>결<br><br>제</td>
        <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 align="center" valign=middle>담  당</td>
        <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=4 align="center" valign=middle>대  표</td>
        <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=4 align="center" valign=middle>회  장</td>
    </tr>
    <tr>
        <td height="60" align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="center" valign=middle><br></td>
        <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 align="center" valign=middle><img src="<?=$sign1 != "" ? $uc->fileShowPath . $sign1 : ""?>" width="100" height="50" /></td>
        <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=4 align="center" valign=middle><img src="<?=$sign2 != "" ? $uc->fileShowPath . $sign2 : ""?>" width="100" height="50" /></td>
        <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=4 align="center" valign=middle><img src="<?=$sign3 != "" ? $uc->fileShowPath . $sign3 : ""?>" width="100" height="50" /></td>
    </tr>
    <tr>
        <td height="11" align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
        <td align="left" valign=middle><br></td>
    </tr>
    <tr>
        <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=5 rowspan=2 height="50" align="center" class="darkBg">발주번호</td>
        <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=12 rowspan=2 align="center" valign=middle ><?=$formData["regNo"]?></td>
        <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=4 align="center" valign=middle class="darkBg">발 <br><br><br><br>주</td>
        <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="center" class="darkBg">등록번호</td>
        <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=11 align="center" valign=middle><?=$static_reg?></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000000;" colspan=6 align="center" class="darkBg">상호</td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=11 align="center" valign=middle><?=$static_trade?></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=5 rowspan=2 height="70" align="center" class="darkBg">건명</td>
        <td style="border: 1px solid #000000;" colspan=12 rowspan=2 align="center" valign=middle><?=$F_VALUE["order_name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="center" class="darkBg">사업장주소</td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=11 align="center" valign=middle><?=$static_addr?></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000000;" colspan=6 align="center" class="darkBg">전화</td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=11 align="center" valign=middle><?=$static_phone?></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=3 height="27" align="center" class="darkBg">번호</td>
        <td style="border: 1px solid #000000;" colspan=12 align="center" class="darkBg">품명</td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" class="darkBg">용도</td>
        <td style="border: 1px solid #000000;" colspan=3 align="center" class="darkBg">단위</td>
        <td style="border: 1px solid #000000;" colspan=5 align="center" class="darkBg">수량</td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" class="darkBg">단가</td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=5 align="center" class="darkBg">비고</td>
    </tr>
    <?for($w = 0; $w < sizeof($F_VALUE["products"]); $w++){?>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=3 height="27" align="center" valign=middle class="darkBg"><?=$w + 1?></td>
        <td style="border: 1px solid #000000;" colspan=12 align="center" valign=middle><?=$F_VALUE["products"][$w]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" valign=middle><?=$F_VALUE["products"][$w]["use"]?></td>
        <td style="border: 1px solid #000000;" colspan=3 align="center" valign=middle><?=$F_VALUE["products"][$w]["unit"]?></td>
        <td style="border: 1px solid #000000;" colspan=5 align="right" valign=middle><?=$F_VALUE["products"][$w]["quantity"]?></td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" valign=middle><?=$F_VALUE["products"][$w]["price"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=5 align="center" valign=middle><?=$F_VALUE["products"][$w]["etc"]?></td>
    </tr>
    <?}?>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=3 height="30" align="center" valign=middle class="darkBg">가격</td>
        <td style="border: 1px solid #000000;" colspan=12 align="center" valign=middle><?=$F_VALUE["price"]?></td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" valign=middle class="darkBg">세액</td>
        <td style="border: 1px solid #000000;" colspan=8 align="center" valign=middle><?=$F_VALUE["tax"]?></td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" valign=middle class="darkBg">합계금액</td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=5 align="center" valign=middle><?=$F_VALUE["tax"]?></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=5 height="30" align="center" valign=middle class="darkBg">담당자</td>
        <td style="border: 1px solid #000000;" colspan=14 align="center" valign=middle><?=$F_VALUE["charge"]?></td>
        <td style="border: 1px solid #000000;" colspan=8 align="center" valign=middle class="darkBg">납품장소</td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=9 align="center" valign=middle><?=$F_VALUE["place"]?></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=12 height="320" align="center" valign=middle class="darkBg">납<br><br>품<br><br>상<br><br>세<br><br>내<br><br>역</td>
        <td style="border: 1px solid #000000;" colspan=17 align="center" valign=middle bgcolor="#FFFFFF"><?=$F_VALUE["product_left"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=17 align="center" valign=middle bgcolor="#FFFFFF"><?=$F_VALUE["product_right"]?></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000000;" colspan=5 align="center" bgcolor="#FFFFFF">품명</td>
        <td style="border: 1px solid #000000;" colspan=6 align="center" bgcolor="#FFFFFF">수량</td>
        <td style="border: 1px solid #000000;" colspan=6 align="center" bgcolor="#FFFFFF">비고</td>
        <td style="border: 1px solid #000000;" colspan=5 align="center" bgcolor="#FFFFFF">품명</td>
        <td style="border: 1px solid #000000;" colspan=6 align="center" bgcolor="#FFFFFF">수량</td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=6 align="center" bgcolor="#FFFFFF">비고</td>
    </tr>
    <?for($w = 0; $w < sizeof($F_VALUE["products_left"]); $w++){?>
    <tr>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["products_left"][$w]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["products_left"][$w]["quantity"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="center" valign=middle><?=$F_VALUE["products_left"][$w]["etc"]?></td>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["products_right"][$w]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["products_right"][$w]["quantity"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=6 align="center" valign=middle><?=$F_VALUE["products_right"][$w]["etc"]?></td>
    </tr>
    <?}?>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=2 align="center" valign=middle class="darkBg">참<br><br>고<br><br>사<br><br>항</td>
        <td style="border-top: 1px solid #000000; border-bottom: 2px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=34 align="left" valign=middle><?=$F_VALUE["comment"]?></td>
    </tr>
</table>
</div>
<!-- ************************************************************************** -->

<p><b>※ 인쇄 시 Chrome 브라우저 사용 권장. (타 브라우저 사용 시 셀 배경 등 미적용)</b></p>

<div style="position:absolute; right:0; padding: 20px;">
<a href="#" class="jPrint jRounded" >인쇄</a>
<a href="#" class="jModify jRounded" >입력/수정</a>
<a href="#" class="jDownload jRounded" >다운로드</a>
<a href="#" class="jClose jRounded" >닫기</a>
</div>

</body>

</html>
