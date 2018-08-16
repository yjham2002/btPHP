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
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<?
$obj = new Uncallable($_REQUEST);
$objm = new AdminMain($_REQUEST);
$langList = $objm->getLangList();
$cId = $_REQUEST["fid"];
$nid = $_REQUEST["id"];
$sid = $_REQUEST["sid"];

if($sid == "" || $cId == "" || $nid == ""){
    echo "<script>
            alert('비정상적인 접근입니다.');
            history.back();
            </script>";
}

$continent = $obj->getContinent($cId);
$nation = $obj->getNation($nid);

?>
<script>
    $(document).ready(function(){

        $(".jSave").click(function(){
            var desc = $(".jTitle").val();
            var ajax = new AjaxSender("/route.php?cmd=AdminMain.initFaq", true, "json", new sehoMap().put("desc", desc));
            ajax.send(function(data){
                if(data.returnCode === 1){
                    location.href = "/admin/pages/siteManage/faqDetail.php?id=" + data.entity;
                }
            });
        });

    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>홈페이지 관리</a>
            </li>
            <li class="breadcrumb-item">후원 관리</li>
            <li class="breadcrumb-item">대륙 정보 관리(<?=$continent["name"]?>)</li>
            <li class="breadcrumb-item">국가 정보 관리(<?=$nation["desc"]?>)</li>
            <li class="breadcrumb-item active">후원 게시글 관리</li>
        </ol>

        <div class="btn-group float-right mb-2" role="group">
            <a href="#" class="jSave btn btn-secondary mr-2">저장</a>
            <select class="custom-select mr-2 jLang">
                <?foreach($langList as $item){?>
                    <option value="<?=$item["code"]?>"><?=$item["desc"]?></option>
                <?}?>
            </select>
        </div>

        <table class="table table-hover table-bordered">
            <thead>
            <tr class="h-auto">
                <td class="bg-secondary text-light">상단 타이틀</td>
                <td><input type="text" class="form-control" name="smTitle" value="" placeholder="내용을 입력하세요" /></td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">중앙 타이틀</td>
                <td><input type="text" class="form-control" name="Title" value="" placeholder="내용을 입력하세요" /></td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">하단 타이틀</td>
                <td><input type="text" class="form-control" name="subTitle" value="" placeholder="내용을 입력하세요" /></td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">후원 목표</td>
                <td><input type="text" class="form-control" name="goal" value="0" placeholder="금액을 입력하세요" /></td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">내용</td>
                <td><textarea class="form-control" name="content" value="" placeholder="내용을 입력하세요"></textarea></td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">메인 이미지</td>
                <td><input type="text" class="form-control" name="titleImg" value="" placeholder="내용을 입력하세요" /></td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">갤러리 01</td>
                <td><input type="text" class="form-control" name="imgPath1" value="" placeholder="내용을 입력하세요" /></td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">갤러리 01</td>
                <td><input type="text" class="form-control" name="imgPath2" value="" placeholder="내용을 입력하세요" /></td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">갤러리 01</td>
                <td><input type="text" class="form-control" name="imgPath3" value="" placeholder="내용을 입력하세요" /></td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">갤러리 01</td>
                <td><input type="text" class="form-control" name="imgPath4" value="" placeholder="내용을 입력하세요" /></td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">갤러리 01</td>
                <td><input type="text" class="form-control" name="imgPath5" value="" placeholder="내용을 입력하세요" /></td>
            </tr>
            </thead>
            <tbody>
            </tbody>
        </table>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
