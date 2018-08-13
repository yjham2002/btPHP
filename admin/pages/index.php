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
<?
    $uncallable = new Uncallable($_REQUEST);
    $overview = $uncallable->getOverviews();
    $notices = $uncallable->getNoticesForMain();
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
            events: example_json // 주소를 입력 시 파싱됨 : 예제 json은 fc_picklecode.js 참조
        });

        $('#calendar_global').fullCalendar({
            defaultView: 'month',
            events: example_json
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
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-primary o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fas fa-fw fa-list"></i>
                        </div>
                        <div class="mr-5">금일 스케쥴<br/>총 0 항목</div>
                    </div>
<!--                    <a class="card-footer text-white clearfix small z-1" href="#">-->
<!--                        <span class="float-left">자세히 보기</span>-->
<!--                        <span class="float-right">-->
<!--                    <i class="fas fa-angle-right"></i>-->
<!--                  </span>-->
<!--                    </a>-->
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-warning o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fas fa-fw fa-list"></i>
                        </div>
                        <div class="mr-5">이번달 스케쥴<br/>총 0 항목</div>
                    </div>
<!--                    <a class="card-footer text-white clearfix small z-1" href="#">-->
<!--                        <span class="float-left">자세히 보기</span>-->
<!--                        <span class="float-right">-->
<!--                    <i class="fas fa-angle-right"></i>-->
                  </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
                <div class="card text-white bg-danger o-hidden h-100">
                    <div class="card-body">
                        <div class="card-body-icon">
                            <i class="fas fa-fw fa-shopping-cart"></i>
                        </div>
                        <div class="mr-5">금일 후원/구독<br/>총 0 항목</div>
                    </div>
                    <a class="card-footer text-white clearfix small z-1" href="#">
                        <span class="float-left">자세히 보기</span>
                        <span class="float-right">
                    <i class="fas fa-angle-right"></i>
                  </span>
                    </a>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6 mb-3">
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
                                <a href="#" >더보기</a>
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
<!--                        <tfoot>-->
<!--                        <tr>-->
<!--                            <td colspan=5>-->
<!--                                <a href="#" >더보기</a>-->
<!--                            </td>-->
<!--                        </tr>-->
<!--                        </tfoot>-->
                        <tbody>
                        <tr>
                            <td>NT</td>
                            <td>100권</td>
                            <td>50권</td>
                            <td>10권</td>
                            <td>160권</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->



<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>

