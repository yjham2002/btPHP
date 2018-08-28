<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 8.
 * Time: PM 5:09
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Uncallable.php";?>
<?
$obj = new Uncallable($_REQUEST);
$list = $obj->getKakaoList();

?>
<script>
    $(document).ready(function(){

        $(".jPage").click(function(){
            var page = $(this).attr("page");
            var range = $("[name=dateRange]:checked").val();
            var year = $("#jYear").val();
            var month = $("#jMonth").val();
            var cls = $("#cls").val();
            var query = encodeURI($(".jStart").val());
            location.href="/admin/pages/customerManage/kakaoList.php?" +
                "page=" + page + "&" +
                "range=" + range + "&" +
                "year=" + year + "&" +
                "month=" + month + "&" +
                "cls=" + cls + "&" +
                "query=" + query;
        });

        $(".jSearch").click(function(){
            var page = $(".pageNum").val();
            var range = $("[name=dateRange]:checked").val();
            var year = $("#jYear").val();
            var month = $("#jMonth").val();
            var cls = $("#cls").val();
            var query = encodeURI($(".jStart").val());
            location.href="/admin/pages/customerManage/kakaoList.php?" +
                "page=" + page + "&" +
                "range=" + range + "&" +
                "year=" + year + "&" +
                "month=" + month + "&" +
                "cls=" + cls + "&" +
                "query=" + query;
        });

        $('input').on("keydown", function(event){
            if (event.keyCode == 13) {
                $(".jSearch").trigger("click");
            }
        });

    });
</script>

<input type="hidden" class="pageNum" value="<?=$_REQUEST["page"] == "" ? 1 : $_REQUEST["page"]?>" />

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>고객관리</a>
            </li>
            <li class="breadcrumb-item active">카톡 발송 현황</li>
        </ol>

        <div class="col-xl-12 col-sm-12 mb-3">
            <div class="card text-white bg-secondary o-hidden h-100">
                <div class="card-body">
                    <div class="card-body-icon">
                        <i class="fas fa-fw fa-search"></i>
                    </div>
                    <div class="mr-5 mb-3">
                        <input type="radio" id="date-all" name="dateRange" value="0" <?=$_REQUEST["range"] == 0 ? "checked" : ""?>>
                        <label for="date-all">전체</label>
                        <input type="radio" id="date-range" name="dateRange" value="1" <?=$_REQUEST["range"] == 1 ? "checked" : ""?>>
                        <label for="date-range">기간</label>
                        <select id="jYear">
                            <?for($e = intval(date("Y")); $e >= 1950 ; $e--){?>
                                <option value="<?=$e?>" <?=$_REQUEST["year"] == $e ? "SELECTED" : ""?>><?=$e?>년</option>
                            <?}?>
                        </select>
                        <select id="jMonth">
                            <?for($e = 1; $e <= 12; $e++){
                                $temp = $e < 10 ? "0".$e : $e;
                                ?>
                                <option value="<?=$e < 10 ? "0".$e : $e?>" <?=$_REQUEST["month"] == $temp ? "SELECTED" : ""?>><?=$e < 10 ? "0".$e : $e?>월</option>
                            <?}?>
                        </select>
                    </div>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <select class="custom-select" id="cls">
                                <option value="0" <?=$_REQUEST["cls"] == 0 ? "SELECTED" : ""?>>전체</option>
                                <option value="1" <?=$_REQUEST["cls"] == 1 ? "SELECTED" : ""?>>연락처</option>
                                <option value="2" <?=$_REQUEST["cls"] == 2 ? "SELECTED" : ""?>>내용</option>
                            </select>
                        </div>
                        <input type="text" class="form-control jStart"
                               placeholder="검색어를 입력하세요" value="<?=$_REQUEST["query"]?>" />
                        <button type="button" class="btn btn-primary jSearch">검색</button>
                    </div>
                </div>
            </div>
        </div>

        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>No.</th>
                <th>보낸날짜</th>
                <th>건수</th>
                <th>연락처</th>
                <th>내용</th>
            </tr>
            </thead>
            <tbody>
            <?
            $vnum = $obj->virtualNum;
            foreach($list as $item){?>
                <tr class="jView" id="<?=$item["id"]?>">
                    <td><?=$vnum--?></td>
                    <td><?=$item["regDate"]?></td>
                    <td><?=$item["count"]?></td>
                    <td><?=$item["phone"]?></td>
                    <td><?=$item["content"]?></td>
                </tr>
            <?}?>
            </tbody>
        </table>

        <?include $_SERVER["DOCUMENT_ROOT"] . "/admin/inc/pageNavigator.php";?>
    </div>
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
