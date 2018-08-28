<?php
/**
 * Created by PhpStorm.
 * User: 전세호
 * Date: 2018-08-23
 * Time: 오후 3:02
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/ScheduleLoader.php";?>
<?
    $obj = new ScheduleLoader($_REQUEST);
    $item = $obj->getSchedule();

    $adminName = $item["adminName"];
    if($_REQUEST["id"] == ""){
        $adminName = $obj->admUser->name;
    }
    
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function(){
        $(".jSave").click(function(){
            if(confirm("저장하시겠습니까?")){
                var sid = "<?=$_REQUEST["id"]?>";
                var authorId = "<?=$obj->admUser->id?>";
                var title = $(".jTitle").val();
                var start = $(".jStart").val();
                var end = $(".jEnd").val();
                var content = $(".jContent").val();
                var jCls = $(".jCls").val();

                if(title=="" || start=="" || end==""){
                    alert("모든 항목을 입력해주세요.");
                    return;
                }

                var ajax = new AjaxSender("/route.php?cmd=ScheduleLoader.upsertSchedule", true, "json",
                new sehoMap()
                    .put("sid", sid)
                    .put("jCls", jCls)
                    .put("authorId", authorId)
                    .put("title", title)
                    .put("start", start)
                    .put("end", end)
                    .put("content", content)
                );
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("저장되었습니다.");
                        location.href = "/admin/pages/staffService/schedules.php";
                    }
                });
            }

        });

        $(".jStart").datepicker({
            yearRange: "-100:",
            showMonthAfterYear:true,
            inline: true,
            changeMonth: true,
            changeYear: true,
            dateFormat : 'yy-mm-dd',
            dayNamesMin:['일', '월', '화', '수', '목', '금', ' 토'],
            monthNames:['1월','2월','3월','4월','5월','6월','7 월','8월','9월','10월','11월','12월'],
            monthNamesShort:['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            beforeShow: function() {
                setTimeout(function(){
                    $('.ui-datepicker').css('z-index', 9999);
                }, 0);
            }
        });
        $(".jEnd").datepicker({
            yearRange: "-100:",
            showMonthAfterYear:true,
            inline: true,
            changeMonth: true,
            changeYear: true,
            dateFormat : 'yy-mm-dd',
            dayNamesMin:['일', '월', '화', '수', '목', '금', ' 토'],
            monthNames:['1월','2월','3월','4월','5월','6월','7 월','8월','9월','10월','11월','12월'],
            monthNamesShort:['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
            beforeShow: function() {
                setTimeout(function(){
                    $('.ui-datepicker').css('z-index', 9999);
                }, 0);
            }
        });

        $(".jCancel").click(function(){
            history.back();
        });

        $(".jDelete").click(function(){
            if(confirm("삭제하시겠습니까?")){
                var ajax = new AjaxSender("/route.php?cmd=ScheduleLoader.deleteSchedule", true, "json",
                    new sehoMap()
                        .put("id", "<?=$_REQUEST["id"]?>")
                );
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("삭제되었습니다.");
                        location.href = "/admin/pages/staffService/schedules.php";
                    }
                });
            }
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
            <li class="breadcrumb-item ">스케쥴</li>
            <li class="breadcrumb-item active">스케쥴 상세정보</li>
        </ol>

        <div class=" float-right">
            <button type="button" class="btn btn-secondary mb-2 jSave">저장</button>
            <button type="button" class="btn btn-secondary mb-2 jCancel">취소</button>
            <?if($_REQUEST["id"] != ""){?>
            <button type="button" class="btn btn-danger mb-2 jDelete">삭제</button>
            <?}?>
        </div>

        <h2>스케쥴 상세정보</h2>

        <br/>

        <form method="post" id="form" action="#" enctype="multipart/form-data">
            <div class="row m-2">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">구분</span>
                    </div>
                    <select class="custom-select mr-2 jCls">
                        <option value="l" <?=$item["type"] == "l" ? "SELECTED" : ""?>>국내</option>
                        <option value="g" <?=$item["type"] == "g" ? "SELECTED" : ""?>>해외</option>
                    </select>
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <input type="hidden" id="id" value="<?=$_REQUEST["id"]?>" name="id" />
                        <input type="hidden" id="authorId" value="<?=$obj->admUser->id?>" name="authorId" />
                        <span class="input-group-text" id="basic-addon3">최종 작성자</span>
                    </div>
                    <input type="text" class="form-control" value="<?=$adminName?>" readonly />
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">제목</span>
                    </div>
                    <input type="text"
                           value="<?=$item["title"]?>"
                           class="form-control jTitle" placeholder="내용을 입력하세요" />
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">시작</span>
                    </div>
                    <input type="text" class="form-control jStart"
                           value="<?=$item["start"]?>"
                           placeholder="날짜 선택" readonly />
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3">종료</span>
                    </div>
                    <input type="text" class="form-control jEnd"
                           value="<?=$item["end"]?>"
                           placeholder="날짜 선택(시작일자와 동일일자 선택 시 당일)" readonly />
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon3" style="height: 30vh;">내용</span>
                    </div>
                    <textarea class="form-control jContent" ><?=$item["content"]?></textarea>
                </div>
            </div>
        </form>
    </div>
</div>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>

