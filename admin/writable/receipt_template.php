<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Uncallable.php";?>
<?
$uc = new Uncallable($_REQUEST);
$CONST_PREFIX_IMAGE = "S_RECEIPT_";
$sign1 = $uc->getProperty($CONST_PREFIX_IMAGE."01");

$static_addr = $uc->getProperty("STATIC_R_ADDR");
$static_reg = $uc->getProperty("STATIC_R_REG");
$static_trade = $uc->getProperty("STATIC_R_TRADE");
$static_phone = $uc->getProperty("STATIC_R_PHONE");
$static_name = $uc->getProperty("STATIC_R_NAME");
$static_account = $uc->getProperty("STATIC_R_ACCOUNT");

if($_REQUEST["id"] == ""){
    echo "<script>alert('비정상적인 접근입니다.'); window.close();</script>";
}

$formData = $uc->getOrderForm();
$formJson = $formData["formJson"];
?>
<?
    $F_VALUE = json_decode(preg_replace('/[\x00-\x1F\x7F]/', '', nl2br($formJson)), true);
?>
<?
    $F_VALUE = array(
        "supply_number" => "2018-08-24 - 1_#", // 일련번호
        "supply_tel" => "1566-5333_#", // TEL
        "supply_reg" => "123-12-12345_#", // 사업자등록번호
        "supply_name" => "김신래_#", // 성명
        "supply_trade" => "(주)가장많이쓰는 이카운트 ERP_#", // 상호
        "supply_addr" => "서울특별시 구로구 구로동 222-14 에이스하이엔드타워2차 603호_#", // 주소
        "title_box" => "이카건설 貴中<br/>충남 당진군 대호지면 매송리 8325-9852번지<br/>☎ 1566-5333_#", // 좌측 상단 박스
        "total_literal" => "팔백구십일만원 정_#", // 금액(한글)
        "total_number" => "8,910,000_#", // 금액
        "total_quantity" => "1,500_#", // 총 수량
        "total_supply" => "8,100,000_#", // 총 공급가액
        "total_vat" => "810,000_#", // 총 VAT
        "total_check" => "_#", // 인수

        "list_01" => array( // 품목 리스트
            "date" => "08/24_#",
            "name" => "품목명_#",
            "quantity" => "100EA_#",
            "price" => "1,000_#",
            "supply" => "900,000_#",
            "vat" => "100,000_#"
        ),
        "list_02" => array( // 품목 리스트
            "date" => "08/24_#",
            "name" => "품목명_#",
            "quantity" => "100EA_#",
            "price" => "1,000_#",
            "supply" => "900,000_#",
            "vat" => "100,000_#"
        ),
        "list_03" => array( // 품목 리스트
            "date" => "08/24_#",
            "name" => "품목명_#",
            "quantity" => "100EA_#",
            "price" => "1,000_#",
            "supply" => "900,000_#",
            "vat" => "100,000_#"
        ),
        "list_04" => array( // 품목 리스트
            "date" => "08/24_#",
            "name" => "품목명_#",
            "quantity" => "100EA_#",
            "price" => "1,000_#",
            "supply" => "900,000_#",
            "vat" => "100,000_#"
        ),
        "list_05" => array( // 품목 리스트
            "date" => "08/24_#",
            "name" => "품목명_#",
            "quantity" => "100EA_#",
            "price" => "1,000_#",
            "supply" => "900,000_#",
            "vat" => "100,000_#"
        ),
        "list_06" => array( // 품목 리스트
            "date" => "08/24_#",
            "name" => "품목명_#",
            "quantity" => "100EA_#",
            "price" => "1,000_#",
            "supply" => "900,000_#",
            "vat" => "100,000_#"
        ),
        "list_07" => array( // 품목 리스트
            "date" => "08/24_#",
            "name" => "품목명_#",
            "quantity" => "100EA_#",
            "price" => "1,000_#",
            "supply" => "900,000_#",
            "vat" => "100,000_#"
        ),
        "list_08" => array( // 품목 리스트
            "date" => "08/24_#",
            "name" => "품목명_#",
            "quantity" => "100EA_#",
            "price" => "1,000_#",
            "supply" => "900,000_#",
            "vat" => "100,000_#"
        ),
        "list_09" => array( // 품목 리스트
            "date" => "08/24_#",
            "name" => "품목명_#",
            "quantity" => "100EA_#",
            "price" => "1,000_#",
            "supply" => "900,000_#",
            "vat" => "100,000_#"
        ),
        "list_10" => array( // 품목 리스트
            "date" => "08/24_#",
            "name" => "품목명_#",
            "quantity" => "100EA_#",
            "price" => "1,000_#",
            "supply" => "900,000_#",
            "vat" => "100,000_#"
        ),
        "list_11" => array( // 품목 리스트
            "date" => "08/24_#",
            "name" => "품목명_#",
            "quantity" => "100EA_#",
            "price" => "1,000_#",
            "supply" => "900,000_#",
            "vat" => "100,000_#"
        ),
        "list_12" => array( // 품목 리스트
            "date" => "08/24_#",
            "name" => "품목명_#",
            "quantity" => "100EA_#",
            "price" => "1,000_#",
            "supply" => "900,000_#",
            "vat" => "100,000_#"
        )
    );

    $F_VALUE = json_decode(json_encode($F_VALUE), true);
?>

<?if($_REQUEST["raw"] != "true"){?>
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
                        var leftMargin = 30;
                        var topMargin = 10;
                        pdf.addImage(imgData, 'PNG',
                            leftMargin, topMargin, 210 - (leftMargin * 2), 297 - (topMargin * 2));
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
                exportToPdf("거래명세서_" + getDate());
            });

            $(".jClose").click(function(){

            });

            if("<?=$_REQUEST["redirect"]?>" == "true"){
                printData();
            }

        });
    </script>

</head>
<?}?>

<body>

<div class="tableWrapper" id="toPrint" style="max-width: 210mm;">
    <P>
        <table border="1" width="100%" cellspacing="0" cellpadding="0" style='border-collapse:collapse;border:none;'>
            <tr>
                <td rowspan="2" width="390" valign="middle" style='border-left:none;border-right:none;border-top:none;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
    <P STYLE='text-align:center;'><span STYLE='font-size:19.0pt;line-height:140%;'>거래명세서</span></P>
    </td>
    <td rowspan="5" width="20" height="105" valign="middle" style='border-left:none;border-right:solid #000000 1px;border-top:none;border-bottom:none;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P><span STYLE='font-size:5.0pt;line-height:140%;'>&nbsp;</span></P>
    </td>
    <td rowspan="5" width="57" height="105" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>공</span></P>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>급</span></P>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>자</span></P>
    </td>
    <td width="76" height="16" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>일련번호</span></P>
    </td>
    <td width="95" height="16" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P><span STYLE='font-size:8.0pt;line-height:140%;'><?="미정"?></span></P>
    </td>
    <td width="57" height="16" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>TEL</span></P>
    </td>
    <td width="95" height="16" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$static_phone?></span></P>
    </td>
    </tr>
    <tr>
        <td width="76" height="35" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>사업자등록번호</span></P>
        </td>
        <td width="95" height="35" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:8.0pt;line-height:140%;'><?=$static_reg?></span></P>
        </td>
        <td width="57" height="35" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>성명</span></P>
        </td>
        <td width="95" height="35" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$static_name?> <img src="<?=$sign1 != "" ? $uc->fileShowPath . $sign1 : ""?>" width="30" height="30" /></span></P>
        </td>
    </tr>
    <tr>
        <td rowspan="3" height="54" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["title_box"]?></span></P>
        </td>
        <td width="76" height="16" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>상호</span></P>
        </td>
        <td colspan="3" height="16" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$static_trade?></span></P>
        </td>
    </tr>
    <tr>
        <td width="76" height="38" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>주소</span></P>
        </td>
        <td colspan="3" width="247" height="38" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$static_addr?></span></P>
        </td>
    </tr>
    <tr>
        <td width="76" height="38" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>입금계좌</span></P>
        </td>
        <td colspan="3" width="247" height="38" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$static_account?></span></P>
        </td>
    </tr>
    </table></P>

    <table border="1" width="100%" cellspacing="0" cellpadding="0" style='border-collapse:collapse;border:none;'>
        <tr>
            <td width="370" height="30" valign="middle" style='border-left:solid #000000 1.7pt;border-right:none;border-top:solid #000000 1.7pt;border-bottom:solid #000000 1.7pt;padding:1.4pt 14.2pt 1.4pt 14.2pt'>
                <P STYLE='text-align:left;'><span STYLE='font-size:12.0pt;line-height:140%;'>금액 : <?=$F_VALUE["total_literal"]?></span></P>
            </td>
            <td width="370" height="30" valign="middle" style='border-left:none;border-right:solid #000000 1.7pt;border-top:solid #000000 1.7pt;border-bottom:solid #000000 1.7pt;padding:1.4pt 14.2pt 1.4pt 14.2pt'>
                <P STYLE='text-align:right;'><span STYLE='font-size:12.0pt;line-height:140%;'>(\ <?=$F_VALUE["total_number"]?>)</span></P>
            </td>
        </tr>
    </table>

    <P>
        <table border="1" width="100%" cellspacing="0" cellpadding="0" style='border-collapse:collapse;border:none;'>
            <tr>
                <td width="118" height="29" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
    <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>일자</span></P>
    </td>
    <td width="240" height="29" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>품목명 및 규격</span></P>
    </td>
    <td width="69" height="29" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>수량<br/>(단위포함)</span></P>
    </td>
    <td width="69" height="29" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>단가</span></P>
    </td>
    <td width="69" height="29" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>공급가액</span></P>
    </td>
    <td width="144" height="29" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>적요</span></P>
    </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_01"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_01"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_01"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_01"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_01"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_01"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_02"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_02"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_02"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_02"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_02"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_02"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_03"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_03"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_03"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_03"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_03"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_03"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_04"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_04"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_04"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_04"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_04"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_04"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_05"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_05"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_05"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_05"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_05"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_05"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_06"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_06"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_06"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_06"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_06"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_06"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_07"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_07"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_07"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_07"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_07"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_07"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_08"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_08"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_08"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_08"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_08"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_08"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_09"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_09"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_09"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_09"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_09"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_09"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_10"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_10"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_10"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_10"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_10"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_10"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_11"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_11"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_11"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_11"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_11"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_11"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_12"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_12"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_12"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_12"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_12"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_12"]["vat"]?></span></P>
        </td>
    </tr>
    </table></P>

    <P>
        <table border="1" width="100%" cellspacing="0" cellpadding="0" style='border-collapse:collapse;border:none;'>
            <tr>
                <td width="41" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
    <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>수량</span></P>
    </td>
    <td width="97" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["total_quantity"]?></span></P>
    </td>
    <td width="75" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>공급가액</span></P>
    </td>
    <td width="97" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["total_supply"]?></span></P>
    </td>
    <td width="37" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>VAT</span></P>
    </td>
    <td width="101" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["total_vat"]?></span></P>
    </td>
    <td width="45" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>합계</span></P>
    </td>
    <td width="90" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["total_number"]?></span></P>
    </td>
    <td width="41" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>인수</span></P>
    </td>
    <td width="86" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["total_check"]?> 인</span></P>
    </td>
    </tr>
    </table></P>

    <hr/>

    <P>
        <table border="1" width="100%" cellspacing="0" cellpadding="0" style='border-collapse:collapse;border:none;'>
            <tr>
                <td rowspan="2" width="390" valign="middle" style='border-left:none;border-right:none;border-top:none;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
    <P STYLE='text-align:center;'><span STYLE='font-size:19.0pt;line-height:140%;'>거래명세서</span></P>
    </td>
    <td rowspan="5" width="20" height="105" valign="middle" style='border-left:none;border-right:solid #000000 1px;border-top:none;border-bottom:none;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P><span STYLE='font-size:5.0pt;line-height:140%;'>&nbsp;</span></P>
    </td>
    <td rowspan="5" width="57" height="105" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>공</span></P>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>급</span></P>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>자</span></P>
    </td>
    <td width="76" height="16" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>일련번호</span></P>
    </td>
    <td width="95" height="16" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P><span STYLE='font-size:8.0pt;line-height:140%;'><?="미정"?></span></P>
    </td>
    <td width="57" height="16" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>TEL</span></P>
    </td>
    <td width="95" height="16" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$static_phone?></span></P>
    </td>
    </tr>
    <tr>
        <td width="76" height="35" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>사업자등록번호</span></P>
        </td>
        <td width="95" height="35" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:8.0pt;line-height:140%;'><?=$static_reg?></span></P>
        </td>
        <td width="57" height="35" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>성명</span></P>
        </td>
        <td width="95" height="35" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$static_name?> <img src="<?=$sign1 != "" ? $uc->fileShowPath . $sign1 : ""?>" width="30" height="30" /></span></P>
        </td>
    </tr>
    <tr>
        <td rowspan="3" height="54" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["title_box"]?></span></P>
        </td>
        <td width="76" height="16" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>상호</span></P>
        </td>
        <td colspan="3" height="16" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$static_trade?></span></P>
        </td>
    </tr>
    <tr>
        <td width="76" height="38" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>주소</span></P>
        </td>
        <td colspan="3" width="247" height="38" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$static_addr?></span></P>
        </td>
    </tr>
    <tr>
        <td width="76" height="38" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>입금계좌</span></P>
        </td>
        <td colspan="3" width="247" height="38" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$static_account?></span></P>
        </td>
    </tr>
    </table></P>
        <table border="1" width="100%" cellspacing="0" cellpadding="0" style='border-collapse:collapse;border:none;'>
            <tr>
                <td width="118" height="29" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
    <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>일자</span></P>
    </td>
                <td width="240" height="29" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
                    <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>품목명 및 규격</span></P>
                </td>
                <td width="69" height="29" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
                    <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>수량<br/>(단위포함)</span></P>
                </td>
                <td width="69" height="29" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
                    <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>단가</span></P>
                </td>
                <td width="69" height="29" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
                    <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>공급가액</span></P>
                </td>
                <td width="144" height="29" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
                    <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>적요</span></P>
                </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_01"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_01"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_01"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_01"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_01"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_01"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_02"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_02"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_02"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_02"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_02"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_02"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_03"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_03"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_03"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_03"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_03"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_03"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_04"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_04"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_04"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_04"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_04"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_04"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_05"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_05"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_05"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_05"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_05"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_05"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_06"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_06"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_06"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_06"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_06"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_06"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_07"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_07"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_07"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_07"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_07"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_07"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_08"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_08"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_08"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_08"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_08"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_08"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_09"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_09"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_09"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_09"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_09"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_09"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_10"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_10"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_10"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_10"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_10"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_10"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_11"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_11"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_11"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_11"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_11"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_11"]["vat"]?></span></P>
        </td>
    </tr>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_12"]["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_12"]["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_12"]["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_12"]["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_12"]["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["list_12"]["vat"]?></span></P>
        </td>
    </tr>
    </table></P>

    <P>
        <table border="1" width="100%" cellspacing="0" cellpadding="0" style='border-collapse:collapse;border:none;'>
            <tr>
                <td width="41" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
    <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>수량</span></P>
    </td>
    <td width="97" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["total_quantity"]?></span></P>
    </td>
    <td width="75" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>공급가액</span></P>
    </td>
    <td width="97" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["total_supply"]?></span></P>
    </td>
    <td width="37" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>VAT</span></P>
    </td>
    <td width="101" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["total_vat"]?></span></P>
    </td>
    <td width="45" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>합계</span></P>
    </td>
    <td width="90" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["total_number"]?></span></P>
    </td>
    <td width="41" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>인수</span></P>
    </td>
    <td width="86" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$F_VALUE["total_check"]?> 인</span></P>
    </td>
    </tr>
    </table></P>
</div>
<!-- ************************************************************************** -->
<?if($_REQUEST["raw"] != "true"){?>
<p><b>※ 인쇄 시 Chrome 브라우저 사용 권장. (타 브라우저 사용 시 셀 배경 등 미적용)</b></p>

<div style="position:absolute; right:0; padding: 20px;">
<a href="#" class="jPrint jRounded" >인쇄</a>
<a href="#" class="jModify jRounded" >입력/수정</a>
<a href="#" class="jDownload jRounded" >다운로드</a>
<a href="#" class="jClose jRounded" >닫기</a>
</div>
<?}?>

</body>

</html>
