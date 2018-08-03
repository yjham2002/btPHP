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

    <title>SB Admin - Dashboard</title>

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
</head>

<?
$obj = new Admin($_REQUEST);
$userInfo = $obj->admUser;

if($userInfo->id < 0 || $userInfo->id == ""){
    echo "<script>alert(\"로그인 후 이용이 가능합니다\");</script>";
    echo "<script>location.href='/admin';</script>";
}
?>

<script>
    $(document).ready(function(){
        $(".jLogout").click(function(){
            var ajax = new AjaxSender("/action_front.php?cmd=AdminMain.logout", false, "json", new sehoMap());
            ajax.send(function(data){
                if(data.returnCode === 1) location.href = "/admin";
            });
        });
    })
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
                <?=$userInfo->name?> 님
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
<!--                <a class="dropdown-item" href="#">Settings</a>-->
<!--                <a class="dropdown-item" href="#">Activity Log</a>-->
<!--                <div class="dropdown-divider"></div>-->
                <a class="dropdown-item jLogout">Logout</a>
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
                <i class="fas fa-fw fa-folder"></i>
                <span>고객관리</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">고객관리:</h6>
                <a class="dropdown-item" href="/admin/pages/customerManage/customerList.php">고객정보</a>
                <a class="dropdown-item" href="/admin/pages/customerManage/failedPurchase.php">결제실패</a>
                <div class="dropdown-divider"></div>
                <h6 class="dropdown-header">발송:</h6>
                <a class="dropdown-item" href="/admin/pages/customerManage/kakaoList.php">카톡 발송 현황</a>
                <a class="dropdown-item" href="/admin/pages/customerManage/transactionDetailsSend.php">거래명세서 발송</a>
                <div class="dropdown-divider"></div>
                <h6 class="dropdown-header">해외:</h6>
                <a class="dropdown-item" href="/admin/pages/customerManage/foreignStatus.php">해외진행 현황</a>
                <a class="dropdown-item" href="/admin/pages/customerManage/paymentStatus.php">입금 현황</a>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-folder"></i>
                <span>배송</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">발주서:</h6>
                <a class="dropdown-item" href="/admin/pages/shipping/purchaseOrderList.php">발주서 조회</a>
                <a class="dropdown-item" href="/admin/pages/shipping/purchaseOrderDetail.php">발주입력</a>
                <a class="dropdown-item" href="/admin/pages/shipping/purchaseOrderReport.php">발주보고서</a>
                <div class="dropdown-divider"></div>
                <h6 class="dropdown-header">입/출고 관리:</h6>
                <a class="dropdown-item" href="/admin/pages/shipping/stockList.php">재고현황/조회</a>
                <a class="dropdown-item" href="blank.html">입고 입력</a>
                <a class="dropdown-item" href="blank.html">출고 입력</a>
                <div class="dropdown-divider"></div>
                <h6 class="dropdown-header">배송 관리:</h6>
                <a class="dropdown-item" href="404.html">당일배송 추출</a>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-folder"></i>
                <span>직원서비스</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <a class="dropdown-item" href="login.html">공지사항</a>
                <a class="dropdown-item" href="register.html">문서 서식</a>
                <a class="dropdown-item" href="register.html">스케줄관리</a>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-folder"></i>
                <span>홈페이지관리</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <a class="dropdown-item" href="/admin/pages/siteManage/mainPage.php">메인</a>
                <a class="dropdown-item" href="/admin/pages/siteManage/supportPage.php">후원</a>
                <a class="dropdown-item" href="/admin/pages/siteManage/subscriptionPage.php">구독</a>
                <a class="dropdown-item" href="/admin/pages/siteManage/adminList.php">관리자</a>
            </div>
        </li>

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-fw fa-folder"></i>
                <span>Pages</span>
            </a>
            <div class="dropdown-menu" aria-labelledby="pagesDropdown">
                <h6 class="dropdown-header">Login Screens:</h6>
                <a class="dropdown-item" href="login.html">Login</a>
                <a class="dropdown-item" href="register.html">Register</a>
                <a class="dropdown-item" href="forgot-password.html">Forgot Password</a>
                <div class="dropdown-divider"></div>
                <h6 class="dropdown-header">Other Pages:</h6>
                <a class="dropdown-item" href="404.html">404 Page</a>
                <a class="dropdown-item" href="blank.html">Blank Page</a>
            </div>
        </li>
    </ul>