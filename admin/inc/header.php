<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 7. 27.
 * Time: PM 1:35
 */
?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Admin.php"; ?>
<!DOCTYPE html>
<html lang="ko">
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>BibleTime Admin</title>

    <!-- Bootstrap core CSS-->
    <link href="/admin/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="/admin/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Page level plugin CSS-->
    <link href="/admin/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="/admin/css/sb-admin.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="/admin/vendor/jquery/jquery.min.js"></script>
    <script src="/admin/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="/admin/vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="http://malsup.github.com/jquery.form.js"></script>

    <script type="text/javascript" src="/modules/ajaxCall/ajaxClass.js"></script>
    <script type="text/javascript" src="/modules/sehoMap/sehoMap.js"></script>

    <link href="/admin/vendor/fullcalendar/fullcalendar.min.css" rel="stylesheet" />
    <link href="/admin/vendor/fullcalendar/fullcalendar.print.min.css" rel="stylesheet" />
    <script src="/admin/vendor/fullcalendar/fc_picklecode.js"></script>
    <script src="/admin/vendor/fullcalendar/lib/moment.min.js"></script>
    <script src="/admin/vendor/fullcalendar/fullcalendar.min.js"></script>
    <script src="/admin/vendor/fullcalendar/locale/ko.js"></script>
</head>

<?
$obj = new Admin($_REQUEST);
$userInfo = $obj->admUser;

if($userInfo->id < 0 || $userInfo->id == ""){
    echo "<script>alert(\"로그인 후 이용이 가능합니다\");</script>";
    echo "<script>location.href='/admin';</script>";
}
?>
<style>
    td, th {
        font-size: 0.9em;
    }
</style>
<script>
    $(document).ready(function(){
        $(".jLogout").click(function(){
            var ajax = new AjaxSender("/route.php?cmd=AdminMain.logout", false, "json", new sehoMap());
            ajax.send(function(data){
                if(data.returnCode === 1) location.href = "/admin";
            });
        });

        $(".jTranscendancePrint").click(function(){
            var target = $("table");
            var divToPrint= target.eq(0);
            newWin= window.open("");
            newWin.document.write("<style>table{width:100%;}</style>");
            newWin.document.write(divToPrint.prop("outerHTML"));
            newWin.document.close();
            newWin.focus();
            newWin.print();
            newWin.close();
        });

        $(".jTranscendanceExcel").click(function(){
            var target = $("table");
            if($(".alterTarget").length > 0) target = $(".alterTarget").eq(0);
            if(target.length < 1) alert("출력 대상이 없습니다.");
            var divToPrint= target.eq(0);
            var optionCss = "";//"#toPrint{width : 210mm;}";
            var htmls = "<style>" + optionCss + "</style>" + divToPrint.prop("outerHTML");

            var uri = 'data:application/vnd.ms-excel;base64,';
            var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta charset="utf-8"></head><body><table>{table}</table></body></html>';
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
        });
    });

    function replaceAll(str, searchStr, replaceStr) {
        return str.split(searchStr).join(replaceStr);
    }

    // 숫자 타입에서 쓸 수 있도록 format() 함수 추가
    Number.prototype.format = function(){
        if(this==0) return 0;
        var reg = /(^[+-]?\d+)(\d{3})/;
        var n = (this + '');
        while(reg.test(n)) n = n.replace(reg, '$1' + ',' + '$2');
        return n;
    };
    // 문자열 타입에서 쓸 수 있도록 format() 함수 추가
    String.prototype.format = function(){
        var num = parseFloat(replaceAll(this, ",", ""));
        if( isNaN(num) ) return "0";
        return num.format();
    };


</script>

<body id="page-top">

<nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="/admin/pages/index.php">고객 관리 시스템</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle" href="#">
        <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
<!--    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">-->
<!--        <div class="input-group">-->
<!--            <input type="text" class="form-control" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">-->
<!--            <div class="input-group-append">-->
<!--                <button class="btn btn-primary" type="button">-->
<!--                    <i class="fas fa-search"></i>-->
<!--                </button>-->
<!--            </div>-->
<!--        </div>-->
<!--    </form>-->

    <!-- Navbar -->
    <ul class="navbar-nav d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-user-circle fa-fw"></i>
                <?=$userInfo->name?>(<?=$userInfo->account?>) 님
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
<!--                <a class="dropdown-item" href="#">Settings</a>-->
<!--                <a class="dropdown-item" href="#">Activity Log</a>-->
<!--                <div class="dropdown-divider"></div>-->
                <a class="dropdown-item jLogout">로그아웃</a>
            </div>
        </li>
    </ul>

</nav>

<div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
        <li class="nav-item active">
            <a class="nav-link" href="/admin/pages/index.php">
                <i class="fas fa-fw fa-home"></i>
                <span>Home</span>
            </a>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-user"></i>
                <span>고객 관리</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">고객 관리</h6>
                <a class="dropdown-item" href="/admin/pages/customerManage/customerList.php">고객정보</a>
                <?if($userInfo->auth >= 2){?>
                <a class="dropdown-item" href="/admin/pages/customerManage/failedPurchase.php?type=BA">결제관리</a>
                <div class="dropdown-divider"></div>
                <h6 class="dropdown-header">발송</h6>
                <a class="dropdown-item" href="/admin/pages/customerManage/kakaoList.php">카톡 발송 현황</a>
                    <a class="dropdown-item" href="/admin/pages/customerManage/signatures.php">명세서 정적정보</a>
                    <a class="dropdown-item" href="/admin/pages/customerManage/transactionDetailsSend.php?year=<?=intval(date("Y"))?>&month=<?=date("m")?>&type=-1&page=1">거래명세서 발송</a>
                <div class="dropdown-divider"></div>
                <h6 class="dropdown-header">해외</h6>
                <a class="dropdown-item" href="/admin/pages/customerManage/foreignStatus.php">해외진행 현황</a>
                <a class="dropdown-item" href="/admin/pages/customerManage/paymentStatus.php">입금 현황</a>
                <?}?>
            </div>
        </li>

        <?if($userInfo->auth >= 2){?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-box"></i>
                <span>배송</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">발주서</h6>
                <a class="dropdown-item" href="/admin/pages/shipping/signatures.php">발주서 정적정보</a>
                <a class="dropdown-item" href="/admin/pages/shipping/purchaseOrderList.php">발주서 입력 / 조회</a>
                <a class="dropdown-item" href="/admin/pages/shipping/formList.php">발주 보고서</a>
                <div class="dropdown-divider"></div>
                <h6 class="dropdown-header">입/출고 관리</h6>
                <a class="dropdown-item" href="/admin/pages/shipping/stockList.php">재고현황 / 조회</a>
                <a class="dropdown-item" href="/admin/pages/shipping/storeForm.php">입/출고 입력</a>
<!--                <a class="dropdown-item" href="blank.html">출고 입력</a>-->
                <div class="dropdown-divider"></div>
                <h6 class="dropdown-header">배송 관리</h6>
                <a class="dropdown-item" href="/admin/pages/shipping/today.php">당일배송 추출</a>
                <a class="dropdown-item" href="/admin/pages/shipping/shipType.php">배송 타입 설정</a>
            </div>
        </li>
        <?}?>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-desktop"></i>
                <span>직원 서비스</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">직원 서비스</h6>
                <a class="dropdown-item" href="/admin/pages/staffService/noticeList.php">공지사항</a>
                <a class="dropdown-item" href="/admin/pages/staffService/formList.php">문서 서식</a>
                <a class="dropdown-item" href="/admin/pages/staffService/schedules.php">스케쥴</a>
                <?if($userInfo->auth >= 2){?>
                <a class="dropdown-item" href="/admin/pages/staffService/adminList.php">관리자</a>
                <?}?>
            </div>
        </li>

        <?if($userInfo->auth >= 2){?>
        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-cog"></i>
                <span>홈페이지 관리</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">홈페이지 관리</h6>
                <a class="dropdown-item" href="/admin/pages/siteManage/historyManage.php">연혁</a>
                <a class="dropdown-item" href="/admin/pages/siteManage/supportPage.php">후원</a>
                <a class="dropdown-item" href="/admin/pages/siteManage/publicationList.php">간행물 관리</a>
                <a class="dropdown-item" href="/admin/pages/siteManage/shareList.php">나눔 게시판 카테고리</a>
                <a class="dropdown-item" href="/admin/pages/siteManage/faqList.php">FAQ 관리</a>
<!--                <a class="dropdown-item" href="/admin/pages/siteManage/adminList.php">관리자</a>-->
                <a class="dropdown-item" href="/admin/pages/siteManage/languages.php">언어 및 문구</a>
                <a class="dropdown-item" href="/admin/pages/siteManage/policies.php">정적 정보 설정</a>
                <a class="dropdown-item" href="/admin/pages/siteManage/layoutSetting.php">레이아웃</a>
                <a class="dropdown-item" href="/admin/pages/siteManage/imageSetting.php">레이아웃 이미지 설정</a>
                <a class="dropdown-item" href="/admin/pages/siteManage/popup.php">메인 팝업 관리</a>

            </div>
        </li>
        <?}?>
        <?if($userInfo->auth >= 2){?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-shopping-cart"></i>
                    <span>영업 관리</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <h6 class="dropdown-header">영업 관리</h6>
                    <a class="dropdown-item" href="/admin/pages/salesManage/salesGeneral.php">매출 통계</a>
                    <a class="dropdown-item" href="/admin/pages/salesManage/salesPrintFee.php">인쇄비 통계</a>
                    <a class="dropdown-item" href="/admin/pages/salesManage/salesPrints.php">인쇄 통계</a>
                    <a class="dropdown-item" href="/admin/pages/salesManage/salesSubscribe.php">구독 통계</a>
                    <a class="dropdown-item" href="/admin/pages/salesManage/salesNations.php">국가별 후원 통계</a>
                    <a class="dropdown-item" href="/admin/pages/salesManage/salesShip.php">배송비 통계</a>
                    <a class="dropdown-item" href="/admin/pages/salesManage/salesResend.php">재배송 통계</a>

                </div>
            </li>
        <?}?>
        <?if($userInfo->auth >= 2){?>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-fw fa-question"></i>
                    <span>업무 도우미</span>
                </a>
                <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                    <h6 class="dropdown-header">데이터베이스</h6>
                    <a class="dropdown-item" href="/admin/pages/rawData.php">조회</a>
                </div>
            </li>
        <?}?>
    </ul>