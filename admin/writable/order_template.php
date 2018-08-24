<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Uncallable.php";?>
<?
$uc = new Uncallable($_REQUEST);
$CONST_PREFIX_IMAGE = "S_ORDER_";
$sign1 = $uc->getProperty($CONST_PREFIX_IMAGE."01");
$sign2 = $uc->getProperty($CONST_PREFIX_IMAGE."02");
$sign3 = $uc->getProperty($CONST_PREFIX_IMAGE."03");
?>
<?
    $F_VALUE = array(
        "order_number" => "20180823_#", // 발주번호
        "order_name" => "OYBT 2018년 5월호_#", // 건명
        "reg_number" => "610-82-78048_#", // 등록번호
        "reg_name" => "바이블타임_#", // 상호
        "reg_addr" => "경기 성남시 수정구<br/>사송로 46번길 20, 3층 바이블타임_#", // 사업장주소
        "reg_phone" => "070-7874-0895_#", // 전화
        "price" => "_#", // 가격
        "tax" => "_#", // 세액
        "total" => "_#", // 합계금액
        "charge" => "이재암_#", // 담당자
        "place" => "바이블타임 및 월드피에이디_#", // 납품장소
        "comment" => "1. 청주여자교도소(X3 NT) 100권 스티커 제거 및 발송 (이름: 청주여자교도소 사회복귀과, 전화번호: 0432888145.
                       <br>   발송주소: 충북 청주시 서원구 청남로 1887번길 78, 청주여자교도소 사회복귀과 기독교담당(산남동)
                       <br>2. X2 5월호는 미국과 같이 인쇄하였습니다.
                       <br>3. 판교 수량은 위에 표기 되었습니다(박스별 책 권수를 반드시 기록해주세요). 
                       <br>4. 월드피에이디 납품 Box(대)는 이전과 동일하게 진행해주세요.
                       <br>5. X2 6월호는 창영에 1달 보관 부탁드립니다.
                       <br>6. 극동방송 1770권 &gt; 월드 / 850권 &gt; 판교로 부탁드립니다._#", // 참고사항

        "product_01" => array(
            "name" => "클래식_#",
            "use" => "_#",
            "unit" => "_#",
            "quantity" => "12,320_#",
            "price" => "_#",
            "etc" => "_#"
        ),
        "product_02" => array(
            "name" => "맥체인_#",
            "use" => "_#",
            "unit" => "_#",
            "quantity" => "3,540_#",
            "price" => "_#",
            "etc" => "_#"
        ),
        "product_03" => array(
            "name" => "연대기_#",
            "use" => "_#",
            "unit" => "_#",
            "quantity" => "6,240_#",
            "price" => "_#",
            "etc" => "_#"
        ),
        "product_04" => array(
            "name" => "X2_#",
            "use" => "_#",
            "unit" => "_#",
            "quantity" => "0_#",
            "price" => "_#",
            "etc" => "_#"
        ),
        "product_05" => array(
            "name" => "X3 OT_#",
            "use" => "_#",
            "unit" => "_#",
            "quantity" => "8,460_#",
            "price" => "_#",
            "etc" => "_#"
        ),
        "product_06" => array(
            "name" => "X3 NT_#",
            "use" => "_#",
            "unit" => "_#",
            "quantity" => "10,300_#",
            "price" => "_#",
            "etc" => "_#"
        ),
        "product_07" => array(
            "name" => "NT_#",
            "use" => "_#",
            "unit" => "_#",
            "quantity" => "3,910_#",
            "price" => "_#",
            "etc" => "_#"
        ),
        "product_08" => array(
            "name" => "노트_#",
            "use" => "_#",
            "unit" => "_#",
            "quantity" => "800_#",
            "price" => "_#",
            "etc" => "_#"
        ),

        "product_left" => "월드피에이디 납품_#",
        "product_right" => "판교 바이블타임 납품_#",
        
        "product_left_01" => array(
            "name" => "클래식_#",
            "quantity" => "0_#",
            "etc" => "_#"
        ),
        "product_left_02" => array(
            "name" => "맥체인_#",
            "quantity" => "0_#",
            "etc" => "_#"
        ),
        "product_left_03" => array(
            "name" => "연대기_#",
            "quantity" => "0_#",
            "etc" => "_#"
        ),
        "product_left_04" => array(
            "name" => "X2_#",
            "quantity" => "0_#",
            "etc" => "_#"
        ),
        "product_left_05" => array(
            "name" => "X3 OT_#",
            "quantity" => "0_#",
            "etc" => "_#"
        ),
        "product_left_06" => array(
            "name" => "X3 NT_#",
            "quantity" => "0_#",
            "etc" => "_#"
        ),
        "product_left_07" => array(
            "name" => "NT_#",
            "quantity" => "0_#",
            "etc" => "_#"
        ),
        "product_left_08" => array(
            "name" => "노트_#",
            "quantity" => "0_#",
            "etc" => "_#"
        ),
        "product_left_09" => array(
            "name" => "Box(대)_#",
            "quantity" => "0_#",
            "etc" => "_#"
        ),
        "product_left_10" => array(
            "name" => "Box(소)_#",
            "quantity" => "0_#",
            "etc" => "_#"
        ),

        "product_right_01" => array(
            "name" => "클래식_#",
            "quantity" => "0_#",
            "etc" => "_#"
        ),
        "product_right_02" => array(
            "name" => "맥체인_#",
            "quantity" => "0_#",
            "etc" => "_#"
        ),
        "product_right_03" => array(
            "name" => "연대기_#",
            "quantity" => "0_#",
            "etc" => "_#"
        ),
        "product_right_04" => array(
            "name" => "X2_#",
            "quantity" => "0_#",
            "etc" => "_#"
        ),
        "product_right_05" => array(
            "name" => "X3 OT_#",
            "quantity" => "0_#",
            "etc" => "_#"
        ),
        "product_right_06" => array(
            "name" => "X3 NT_#",
            "quantity" => "0_#",
            "etc" => "_#"
        ),
        "product_right_07" => array(
            "name" => "NT_#",
            "quantity" => "0_#",
            "etc" => "_#"
        ),
        "product_right_08" => array(
            "name" => "노트_#",
            "quantity" => "0_#",
            "etc" => "_#"
        ),
        "product_right_09" => array(
            "name" => "Box(대)_#",
            "quantity" => "0_#",
            "etc" => "_#"
        ),
        "product_right_10" => array(
            "name" => "Box(소)_#",
            "quantity" => "0_#",
            "etc" => "_#"
        ),
    );

    $F_VALUE = json_decode(json_encode($F_VALUE), true);
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
        <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=12 rowspan=2 align="center" valign=middle ><?=$F_VALUE["order_number"]?></td>
        <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=2 rowspan=4 align="center" valign=middle class="darkBg">발 <br><br><br><br>주</td>
        <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 1px solid #000000" colspan=6 align="center" class="darkBg">등록번호</td>
        <td style="border-top: 2px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=11 align="center" valign=middle><?=$F_VALUE["reg_number"]?></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000000;" colspan=6 align="center" class="darkBg">상호</td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=11 align="center" valign=middle><?=$F_VALUE["reg_name"]?></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=5 rowspan=2 height="70" align="center" class="darkBg">건명</td>
        <td style="border: 1px solid #000000;" colspan=12 rowspan=2 align="center" valign=middle><?=$F_VALUE["order_name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="center" class="darkBg">사업장주소</td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=11 align="center" valign=middle><?=$F_VALUE["reg_addr"]?></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000000;" colspan=6 align="center" class="darkBg">전화</td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=11 align="center" valign=middle><?=$F_VALUE["reg_phone"]?></td>
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
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=3 height="27" align="center" valign=middle class="darkBg" sdval="1" sdnum="1033;">1</td>
        <td style="border: 1px solid #000000;" colspan=12 align="center" valign=middle><?=$F_VALUE["product_01"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" valign=middle><?=$F_VALUE["product_01"]["use"]?></td>
        <td style="border: 1px solid #000000;" colspan=3 align="center" valign=middle><?=$F_VALUE["product_01"]["unit"]?></td>
        <td style="border: 1px solid #000000;" colspan=5 align="right" valign=middle><?=$F_VALUE["product_01"]["quantity"]?></td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" valign=middle><?=$F_VALUE["product_01"]["price"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=5 align="center" valign=middle><?=$F_VALUE["product_01"]["etc"]?></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=3 height="27" align="center" valign=middle class="darkBg" sdval="2" sdnum="1033;">2</td>
        <td style="border: 1px solid #000000;" colspan=12 align="center" valign=middle><?=$F_VALUE["product_02"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" valign=middle><?=$F_VALUE["product_02"]["use"]?></td>
        <td style="border: 1px solid #000000;" colspan=3 align="center" valign=middle><?=$F_VALUE["product_02"]["unit"]?></td>
        <td style="border: 1px solid #000000;" colspan=5 align="right" valign=middle><?=$F_VALUE["product_02"]["quantity"]?></td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" valign=middle><?=$F_VALUE["product_02"]["price"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=5 align="center" valign=middle><?=$F_VALUE["product_02"]["etc"]?></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=3 height="27" align="center" valign=middle class="darkBg" sdval="3" sdnum="1033;">3</td>
        <td style="border: 1px solid #000000;" colspan=12 align="center" valign=middle><?=$F_VALUE["product_03"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" valign=middle><?=$F_VALUE["product_03"]["use"]?></td>
        <td style="border: 1px solid #000000;" colspan=3 align="center" valign=middle><?=$F_VALUE["product_03"]["unit"]?></td>
        <td style="border: 1px solid #000000;" colspan=5 align="right" valign=middle><?=$F_VALUE["product_03"]["quantity"]?></td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" valign=middle><?=$F_VALUE["product_03"]["price"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=5 align="center" valign=middle><?=$F_VALUE["product_03"]["etc"]?></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=3 height="27" align="center" valign=middle class="darkBg" sdval="4" sdnum="1033;">4</td>
        <td style="border: 1px solid #000000;" colspan=12 align="center" valign=middle><?=$F_VALUE["product_04"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" valign=middle><?=$F_VALUE["product_04"]["use"]?></td>
        <td style="border: 1px solid #000000;" colspan=3 align="center" valign=middle><?=$F_VALUE["product_04"]["unit"]?></td>
        <td style="border: 1px solid #000000;" colspan=5 align="right" valign=middle><?=$F_VALUE["product_04"]["quantity"]?></td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" valign=middle><?=$F_VALUE["product_04"]["price"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=5 align="center" valign=middle><?=$F_VALUE["product_04"]["etc"]?></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=3 height="27" align="center" valign=middle class="darkBg" sdval="5" sdnum="1033;">5</td>
        <td style="border: 1px solid #000000;" colspan=12 align="center" valign=middle><?=$F_VALUE["product_05"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" valign=middle><?=$F_VALUE["product_05"]["use"]?></td>
        <td style="border: 1px solid #000000;" colspan=3 align="center" valign=middle><?=$F_VALUE["product_05"]["unit"]?></td>
        <td style="border: 1px solid #000000;" colspan=5 align="right" valign=middle><?=$F_VALUE["product_05"]["quantity"]?></td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" valign=middle><?=$F_VALUE["product_05"]["price"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=5 align="center" valign=middle><?=$F_VALUE["product_05"]["etc"]?></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=3 height="27" align="center" valign=middle class="darkBg" sdval="6" sdnum="1033;">6</td>
        <td style="border: 1px solid #000000;" colspan=12 align="center" valign=middle><?=$F_VALUE["product_06"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" valign=middle><?=$F_VALUE["product_06"]["use"]?></td>
        <td style="border: 1px solid #000000;" colspan=3 align="center" valign=middle><?=$F_VALUE["product_06"]["unit"]?></td>
        <td style="border: 1px solid #000000;" colspan=5 align="right" valign=middle><?=$F_VALUE["product_06"]["quantity"]?></td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" valign=middle><?=$F_VALUE["product_06"]["price"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=5 align="center" valign=middle><?=$F_VALUE["product_06"]["etc"]?></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=3 height="27" align="center" valign=middle class="darkBg" sdval="7" sdnum="1033;">7</td>
        <td style="border: 1px solid #000000;" colspan=12 align="center" valign=middle><?=$F_VALUE["product_07"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" valign=middle><?=$F_VALUE["product_07"]["use"]?></td>
        <td style="border: 1px solid #000000;" colspan=3 align="center" valign=middle><?=$F_VALUE["product_07"]["unit"]?></td>
        <td style="border: 1px solid #000000;" colspan=5 align="right" valign=middle><?=$F_VALUE["product_07"]["quantity"]?></td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" valign=middle><?=$F_VALUE["product_07"]["price"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=5 align="center" valign=middle><?=$F_VALUE["product_07"]["etc"]?></td>
    </tr>
    <tr>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 2px solid #000000; border-right: 1px solid #000000" colspan=3 height="27" align="center" valign=middle class="darkBg" sdval="8" sdnum="1033;">8</td>
        <td style="border: 1px solid #000000;" colspan=12 align="center" valign=middle><?=$F_VALUE["product_08"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" valign=middle><?=$F_VALUE["product_08"]["use"]?></td>
        <td style="border: 1px solid #000000;" colspan=3 align="center" valign=middle><?=$F_VALUE["product_08"]["unit"]?></td>
        <td style="border: 1px solid #000000;" colspan=5 align="right" valign=middle><?=$F_VALUE["product_08"]["quantity"]?></td>
        <td style="border: 1px solid #000000;" colspan=4 align="center" valign=middle><?=$F_VALUE["product_08"]["price"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=5 align="center" valign=middle><?=$F_VALUE["product_08"]["etc"]?></td>
    </tr>
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
    <tr>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["product_left_01"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["product_left_01"]["quantity"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="center" valign=middle><?=$F_VALUE["product_left_01"]["etc"]?></td>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["product_right_01"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["product_right_01"]["quantity"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=6 align="center" valign=middle><?=$F_VALUE["product_right_01"]["etc"]?></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["product_left_02"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["product_left_02"]["quantity"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="center" valign=middle><?=$F_VALUE["product_left_02"]["etc"]?></td>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["product_right_02"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["product_right_02"]["quantity"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=6 align="center" valign=middle><?=$F_VALUE["product_right_02"]["etc"]?></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["product_left_03"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["product_left_03"]["quantity"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="center" valign=middle><?=$F_VALUE["product_left_03"]["etc"]?></td>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["product_right_03"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["product_right_03"]["quantity"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=6 align="center" valign=middle><?=$F_VALUE["product_right_03"]["etc"]?></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["product_left_04"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["product_left_04"]["quantity"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="center" valign=middle><?=$F_VALUE["product_left_04"]["etc"]?></td>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["product_right_04"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["product_right_04"]["quantity"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=6 align="center" valign=middle><?=$F_VALUE["product_right_04"]["etc"]?></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["product_left_05"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["product_left_05"]["quantity"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="center" valign=middle><?=$F_VALUE["product_left_05"]["etc"]?></td>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["product_right_05"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["product_right_05"]["quantity"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=6 align="center" valign=middle><?=$F_VALUE["product_right_05"]["etc"]?></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["product_left_06"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["product_left_06"]["quantity"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="center" valign=middle><?=$F_VALUE["product_left_06"]["etc"]?></td>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["product_right_06"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["product_right_06"]["quantity"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=6 align="center" valign=middle><?=$F_VALUE["product_right_06"]["etc"]?></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["product_left_07"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["product_left_07"]["quantity"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="center" valign=middle><?=$F_VALUE["product_left_07"]["etc"]?></td>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["product_right_07"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["product_right_07"]["quantity"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=6 align="center" valign=middle><?=$F_VALUE["product_right_07"]["etc"]?></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["product_left_08"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["product_left_08"]["quantity"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="center" valign=middle><?=$F_VALUE["product_left_08"]["etc"]?></td>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["product_right_08"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["product_right_08"]["quantity"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=6 align="center" valign=middle><?=$F_VALUE["product_right_08"]["etc"]?></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["product_left_09"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["product_left_09"]["quantity"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="center" valign=middle><?=$F_VALUE["product_left_09"]["etc"]?></td>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["product_right_09"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["product_right_09"]["quantity"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=6 align="center" valign=middle><?=$F_VALUE["product_right_09"]["etc"]?></td>
    </tr>
    <tr>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["product_left_10"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["product_left_10"]["quantity"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="center" valign=middle><?=$F_VALUE["product_left_10"]["etc"]?></td>
        <td style="border: 1px solid #000000;" colspan=5 align="center" valign=middle><?=$F_VALUE["product_right_10"]["name"]?></td>
        <td style="border: 1px solid #000000;" colspan=6 align="right" valign=middle><?=$F_VALUE["product_right_10"]["quantity"]?></td>
        <td style="border-top: 1px solid #000000; border-bottom: 1px solid #000000; border-left: 1px solid #000000; border-right: 2px solid #000000" colspan=6 align="center" valign=middle><?=$F_VALUE["product_right_10"]["etc"]?></td>
    </tr>
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
