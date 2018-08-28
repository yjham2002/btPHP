<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 20.
 * Time: PM 4:44
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<?
    $obj = new AdminMain($_REQUEST);
    $list = $obj->adminList();
?>

<script>
    var selected = "l";

    $(document).ready(function(){
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

        $('#prev_l').on('click', function() {
            $('#calendar_local').fullCalendar('prev'); // call method
        });

        $('#next_l').on('click', function() {
            $('#calendar_local').fullCalendar('next'); // call method
        });

        $('#prev_g').on('click', function() {
            $('#calendar_global').fullCalendar('prev'); // call method
        });

        $('#next_g').on('click', function() {
            $('#calendar_global').fullCalendar('next'); // call method
        });

        $(".jTab").click(function(){
            $(".jTab").removeClass("btn-secondary");
            $(this).addClass("btn-secondary");
            selected = $(this).attr("target");
            toggleView();
        });

        function toggleView(){
            if(selected == "l"){
                $(".jGlobal").hide();
                $(".jLocal").fadeIn();
            }else{
                $(".jLocal").hide();
                $(".jGlobal").fadeIn();
            }
        }

        function goToDate(date){
            $('#calendar_local').fullCalendar('gotoDate', date);
            $('#calendar_global').fullCalendar('gotoDate', date);
        }

        toggleView();

        $(".jAdd").click(function(){
             location.href = "/admin/pages/staffService/scheduleDetail.php";
        });

        $(".jSave").click(function(){
            var desc = $(".jTitle").val();
            var ajax = new AjaxSender("/route.php?cmd=AdminMain.initPublication", true, "json", new sehoMap().put("desc", desc));
            ajax.send(function(data){
                if(data.returnCode === 1){
                    location.href = "/admin/pages/siteManage/publicationDetail.php?id=" + data.entity;
                }
            });
        });

        $(".jView").click(function(){
            var id = $(this).attr("id");
            location.href = "/admin/pages/siteManage/publicationDetail.php?id=" + id + "&langCode=kr";
        });

        $(".jClosePop").click(function(){
            addPop.fadeOut();
        });

        $(".jDel").click(function(){
            if(confirm("정말 삭제하시겠습니까?")) {
                var id = $(this).attr("id");
                var ajax = new AjaxSender("/route.php?cmd=AdminMain.deleteAdmin", true, "json", new sehoMap().put("id", id));
                ajax.send(function (data) {
//                    location.reload();
                });
            }
        });

        $("#jYear").change(function(){
            var date = $("#jYear").val() + "-" + $("#jMonth").val() + "-" + "01";
            goToDate(date);
        });

        $("#jMonth").change(function(){
            var date = $("#jYear").val() + "-" + $("#jMonth").val() + "-" + "01";
            goToDate(date);
        });

    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>직원서비스</a>
            </li>
            <li class="breadcrumb-item active">스케쥴</li>
        </ol>

        <button type="button" class="btn btn-secondary float-right mb-2 jAdd">스케쥴 추가</button>

        <div class="float-left col-xl-12 col-sm-12 mb-3">
            <!-- Spacer -->
        </div>

        <button type="button" target="l" class="jTab btn-secondary btn mb-2">국내 현황</button>
        <button type="button" target="g" class="jTab btn mb-2">해외 현황</button>

        <br/>

        <select id="jYear">
            <?for($e = 1950; $e < intval(date("Y")) + 50; $e++){?>
                <option value="<?=$e?>" <?=intval(date("Y")) == $e ? "SELECTED" : ""?>><?=$e?>년</option>
            <?}?>
        </select>
        <select id="jMonth">
            <?for($e = 1; $e <= 12; $e++){?>
                <option value="<?=$e < 10 ? "0".$e : $e?>" <?=intval(date("m")) == $e ? "SELECTED" : ""?>><?=$e < 10 ? "0".$e : $e?>월</option>
            <?}?>
        </select>

        <br/>
        <br/>

        <div class="col-xl-12 col-sm-12 mb-3 jLocal">
            국내 현황
            <button type="button" id="prev_l" class="btn-sm btn-secondary mb-2"><</button>
            <button type="button" id="next_l" class="btn-sm btn-secondary mb-2">></button>
            <div id='calendar_local'></div>
        </div>
        <div class="col-xl-12 col-sm-12 mb-3 jGlobal" style="display: none;">
            해외 현황
            <button type="button" id="prev_g" class="btn-sm btn-secondary mb-2"><</button>
            <button type="button" id="next_g" class="btn-sm btn-secondary mb-2">></button>
            <div id='calendar_global'></div>
        </div>

    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
