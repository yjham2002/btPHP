<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 7. 27.
 * Time: PM 1:37
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Uncallable.php";?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Management.php";?>
<?
    $uncallable = new Uncallable($_REQUEST);
    $overview = $uncallable->getOverviews();
    $notices = $uncallable->getNoticesForMain();
    $todayL = $uncallable->getNowSchedule("l");
    $todayG = $uncallable->getNowSchedule("g");

    $management = new Management($_REQUEST);
    $stock = $management->getStock();
?>

<script>

    $(function() {

        /**
         * 참조 Docs : https://fullcalendar.io/
         * events 파라미터에 주소 삽입 시 이하와 같은 파라미터가 전송됨
         * start=2013-12-01&end=2014-01-12
         */

        $('#calendar_local').fullCalendar({
            defaultView: 'month',
            events: "/route.php?cmd=ScheduleLoader.getMonthlySchedule&type=l" // 주소를 입력 시 파싱됨 : 예제 json은 fc_picklecode.js 참조
        });

        $('#calendar_global').fullCalendar({
            defaultView: 'month',
            events: "/route.php?cmd=ScheduleLoader.getMonthlySchedule&type=g" // 주소를 입력 시 파싱됨 : 예제 json은 fc_picklecode.js 참조
        });

        $(".jSearch").click(function(){
            location.href = "/admin/pages/customerManage/customerList.php?" + $("#cSearch").serialize();
        });

    });

</script>

<div id="content-wrapper">

    <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="#">Home</a>
            </li>
            <li class="breadcrumb-item active">대시보드</li>
        </ol>

        <!-- Icon Cards-->
        <div class="row">
            <div class="col-xl-12 col-sm-12 mb-3">
                <div class="card text-white bg-danger o-hidden h-100">
                    <form id="cSearch">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fas fa-fw fa-search"></i>
                        </div>
                        <div class="mr-5 mb-3">고객 검색</div>
                        <div class="mr-5">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <select class="custom-select" id="inputGroupSelect01" name="searchType">
                                        <option value="">선택</option>
                                        <option value="name" <?=$_REQUEST["searchType"] == "name" ? "selected" : ""?>>이름</option>
                                        <?if(false){?><option value="BO" <?=$_REQUEST["searchType"] == "BO" ? "selected" : ""?>>뱅크오너</option><?}?>
                                        <option value="phone" <?=$_REQUEST["searchType"] == "phone" ? "selected" : ""?>>전화번호</option>
                                        <option value="email" <?=$_REQUEST["searchType"] == "email" ? "selected" : ""?>>이메일</option>
                                        <option value="addr" <?=$_REQUEST["searchType"] == "addr" ? "selected" : ""?>>주소</option>
                                    </select>
                                </div>
                                <input type="text" class="form-control jStart" name="searchText" placeholder="검색어를 입력하세요" />
                                <button type="button" class="btn btn-secondary jSearch">검색</button>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>
            </div>

            <div class="col-xl-6 col-sm-6 mb-3">
                <div class="card text-white bg-primary o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fas fa-fw fa-list"></i>
                        </div>
                        <div class="mr-5">금일 스케쥴<br/>국내 <?=$todayL?> / 해외 <?=$todayG?><br/>총 <?=$todayL + $todayG?> 항목</div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="/admin/pages/staffService/schedules.php">
                        <span class="float-left">자세히 보기</span>
                        <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                    </a>
                </div>
            </div>

            <div class="col-xl-6 col-sm-6 mb-3">
                <div class="card text-white bg-dark o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fas fa-fw fa-user"></i>
                        </div>
                        <div class="mr-5">로그인/가입 회원<br/>총 <?=$overview["overview_user"]?> 명</div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="#">
                        <span class="float-left">자세히 보기</span>
                        <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Caleandars -->

        <div class="row">
            <div class="col-xl-6 col-sm-6 mb-3">
                국내 현황
                <div id='calendar_local'></div>
            </div>
            <div class="col-xl-6 col-sm-6 mb-3">
                해외 현황
                <div id='calendar_global'></div>
            </div>
        </div>

        <!-- Pickle Data Sheet -->
        <div class="row">
            <div class="col-xl-6 col-sm-6 mb-3">
                <h3>공지사항</h3>
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>No.</th>
                            <th>제목</th>
                            <th>작성일자</th>
                        </tr>
                        </thead>
                        <tfoot>
                        <tr>
                            <td colspan=3>
                                <a href="/admin/pages/staffService/noticeList.php" >더보기</a>
                            </td>
                        </tr>
                        </tfoot>
                        <tbody>
                            <? for($e = 0; $e < sizeof($notices); $e++) {
                                $noticeItem = $notices[$e];
                                ?>
                            <tr>
                                <th><?=$noticeItem["id"]?></th>
                                <td><?=$noticeItem["title"]?></td>
                                <td><?=$noticeItem["regDate"]?></td>
                            </tr>
                            <? } ?>
                        <? if(sizeof($notices) < 7){ ?>
                            <? for($e = 0; $e < 7 - sizeof($notices); $e++) {
                                $noticeItem = $notices[$e];
                                ?>
                                <tr>
                                    <th>&nbsp;</th>
                                    <td></td>
                                    <td></td>
                                </tr>
                            <? } ?>
                        <? } ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="col-xl-6 col-sm-6 mb-3">
                <h3>재고현황</h3>
                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                        <tr>
                            <th>버전</th>
                            <th>미국판</th>
                            <th>한국판</th>
                            <th>광고</th>
                            <th>합계</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?foreach($stock as $stockItem){?>
                            <tr>
                                <td><?=$stockItem["publicationName"]?></td>
                                <td><?=$stockItem["aStock"] == "" ? "0" : $stockItem["aStock"]?>권</td>
                                <td><?=$stockItem["kStock"] == "" ? "0" : $stockItem["kStock"]?>권</td>
                                <td><?=$stockItem["pStock"] == "" ? "0" : $stockItem["pStock"]?>권</td>
                                <td><?=$stockItem["summation"] == "" ? "0" : $stockItem["summation"]?>권</td>
                            </tr>
                        <?}?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td colspan=5>
                                <a href="/admin/pages/shipping/stockList.php">더보기</a>
                            </td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->



<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>

