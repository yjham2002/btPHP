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

$subscribe = $uc->getSub();

if($_REQUEST["id"] == ""){
    echo "<script>alert('비정상적인 접근입니다.'); window.close();</script>";
}

$formData = $uc->getReceipt();
$formJson = $formData["formJson"];
$F_VALUE = json_decode(preg_replace('/[\x00-\x1F\x7F]/', '', $formJson), true);

$totalPrice = 0;
$totalQuan = 0;

$check = $formData["check"];
$vat = $formData["vat"];

for($w = 0; $w < sizeof($F_VALUE); $w++){
    $totalPrice += intval($F_VALUE[$w]["supply"]);
    $totalQuan += intval($F_VALUE[$w]["quantity"]);
}

$supplyPrice = $totalPrice;
$totalPrice += $vat;

$totalLiteral = $uc->getHangleMoney($totalPrice);
if($totalLiteral == "") $totalLiteral = "영";

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

            td input[type=text], td textarea {
                border : none;
                width: 100%;
                height: 100%;
                font-size: 1.0em !important;
                padding : 0 !important;
            }

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

        body,div,table,thead,tbody,tfoot,tr,th,td,p {  font-size:13px; }

        .jRounded{
            color : white;
            background : #1a1a1a;
            border-radius: 5px;
            font-size: 15px;
            padding : 5px 30px 5px 30px;
            text-decoration: none;
        }

        td{
            color : black !important;
        }

        input{
            color : black !important;
        }
    </style>
    <script src="/admin/vendor/jquery/jquery.min.js"></script>
    <script src="/admin/writable/jspdf/jspdf.min.js"></script>
    <script src="/admin/writable/jspdf/libs/html2canvas/dist/html2canvas.js"></script>
    <script>
        var formJson = <?=preg_replace('/[\x00-\x1F\x7F]/', '', $formJson)?>;
        var currentId = "<?=$_REQUEST["id"]?>";

        function exportToExcel(){
            var divToPrint=document.getElementById("toPrint");
            var optionCss = "#toPrint{width : 210mm;}";
            var htmls = $("#styleCss").prop("outerHTML") + "<style>" + optionCss + "</style>" + divToPrint.outerHTML;

            var uri = 'data:application/vnd.ms-excel;base64,';
            var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>';

            var base64 = function(s) { return window.btoa(unescape(encodeURIComponent(s))); };
            var format = function(s, c) { return s.replace(/{(\w+)}/g, function(m, p) { return c[p];});};

            var ctx = { worksheet : 'Worksheet', table : htmls};
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
                        var leftMargin = 20;
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

            $("input, textarea").change(function(){
                process();
                console.log(JSON.stringify(formJson));
                if(currentId == ""){

                }else{

                }

            });

            var processed = false;

            function process(){
                processed = true;
                var objs = $("input, textarea");
                for(var e = 0; e < objs.length;  e++){
                    var name = objs.eq(e).attr("name");
                    var content = objs.eq(e).val();
                    var spName = name.split("-");
                    var pointer = "formJson";
                    if(!formJson.hasOwnProperty(spName[0])) continue;
                    for(var w = 0; w < spName.length; w++){
                        pointer = pointer + "['" + spName[w] + "']";
                    }
                    eval(pointer + " = content");
                }
            }

            $(".jPrint").click(function(){
                if(processed){
                    alert("변경사항이 있습니다. 저장 후 인쇄가 가능합니다.");
                }else{
                    printData();
                }
            });

            $(".jModify").click(function(){

            });

            $(".jClose").click(function(){
                updateFormJson(JSON.stringify(formJson), currentId);
            });

            $(".jDownload").click(function(){
                exportToPdf("거래명세서_" + getDate());
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
            <?
            $tempName = $subscribe["cuName"];
            if($subscribe["cName"] != "") $tempName .= "(".$subscribe["cName"].")";
            ?>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$tempName?> 貴中<br/><?=$subscribe["fAddr"]?><br/>☎ <?=$subscribe["cuPhone"]?></span></P>
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
                <P STYLE='text-align:left;'><span STYLE='font-size:12.0pt;line-height:140%;'>금액 : <?=$totalLiteral?>원정</span></P>
            </td>
            <td width="370" height="30" valign="middle" style='border-left:none;border-right:solid #000000 1.7pt;border-top:solid #000000 1.7pt;border-bottom:solid #000000 1.7pt;padding:1.4pt 14.2pt 1.4pt 14.2pt'>
                <P STYLE='text-align:right;'><span STYLE='font-size:12.0pt;line-height:140%;'>(\ <?=$totalPrice?>)</span></P>
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
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>수량</span></P>
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
    <?for($e = 0; $e < sizeof($F_VALUE) ; $e++){
        $item = $F_VALUE[$e];
        ?>
    <tr>
        <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$item["date"]?></span></P>
        </td>
        <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$item["name"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$item["quantity"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$item["price"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$item["supply"]?></span></P>
        </td>
        <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
            <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$item["vat"]?></span></P>
        </td>
    </tr>
    <?}?>

    </table></P>

    <P>
        <table border="1" width="100%" cellspacing="0" cellpadding="0" style='border-collapse:collapse;border:none;'>
            <tr>
                <td width="41" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
    <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>수량</span></P>
    </td>
    <td width="97" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$totalQuan?></span></P>
    </td>
    <td width="75" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>공급가액</span></P>
    </td>
    <td width="97" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$supplyPrice?></span></P>
    </td>
    <td width="37" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>VAT</span></P>
    </td>
    <td width="101" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$vat?></span></P>
    </td>
    <td width="45" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>합계</span></P>
    </td>
    <td width="90" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$totalPrice?></span></P>
    </td>
    <td width="41" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>인수</span></P>
    </td>
    <td width="86" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$check?></span></P>
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
            <?
            $tempName = $subscribe["cuName"];
            if($subscribe["cName"] != "") $tempName .= "(".$subscribe["cName"].")";
            ?>
            <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$tempName?> 貴中<br/><?=$subscribe["fAddr"]?><br/>☎ <?=$subscribe["cuPhone"]?></span></P>
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
                <P STYLE='text-align:left;'><span STYLE='font-size:12.0pt;line-height:140%;'>금액 : <?=$totalLiteral?>원정</span></P>
            </td>
            <td width="370" height="30" valign="middle" style='border-left:none;border-right:solid #000000 1.7pt;border-top:solid #000000 1.7pt;border-bottom:solid #000000 1.7pt;padding:1.4pt 14.2pt 1.4pt 14.2pt'>
                <P STYLE='text-align:right;'><span STYLE='font-size:12.0pt;line-height:140%;'>(\ <?=$totalPrice?>)</span></P>
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
                    <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>수량</span></P>
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
            <?for($e = 0; $e < sizeof($F_VALUE) ; $e++){
                $item = $F_VALUE[$e];
                ?>
                <tr>
                    <td width="118" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
                        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$item["date"]?></span></P>
                    </td>
                    <td width="315" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
                        <P><span STYLE='font-size:9.0pt;line-height:140%;'><?=$item["name"]?></span></P>
                    </td>
                    <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
                        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$item["quantity"]?></span></P>
                    </td>
                    <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
                        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$item["price"]?></span></P>
                    </td>
                    <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
                        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$item["supply"]?></span></P>
                    </td>
                    <td width="69" height="19" valign="middle" style='border-left:solid #000000 1px;border-right:solid #000000 1px;border-top:solid #000000 1px;border-bottom:solid #000000 1px;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
                        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$item["vat"]?></span></P>
                    </td>
                </tr>
            <?}?>
    </table></P>

    <P>
        <table border="1" width="100%" cellspacing="0" cellpadding="0" style='border-collapse:collapse;border:none;'>
            <tr>
                <td width="41" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
    <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>수량</span></P>
    </td>
    <td width="97" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$totalQuan?></span></P>
    </td>
    <td width="75" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>공급가액</span></P>
    </td>
    <td width="97" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$supplyPrice?></span></P>
    </td>
    <td width="37" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>VAT</span></P>
    </td>
    <td width="101" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$vat?></span></P>
    </td>
    <td width="45" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>합계</span></P>
    </td>
    <td width="90" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$totalPrice?></span></P>
    </td>
    <td width="41" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:center;'><span STYLE='font-size:9.0pt;line-height:140%;'>인수</span></P>
    </td>
    <td width="86" height="23" valign="middle" style='border-left:solid #000000 1.1pt;border-right:solid #000000 1.1pt;border-top:solid #000000 1.1pt;border-bottom:solid #000000 1.1pt;padding:1.4pt 5.1pt 1.4pt 5.1pt'>
        <P STYLE='text-align:right;'><span STYLE='font-size:9.0pt;line-height:140%;'><?=$check?></span></P>
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
