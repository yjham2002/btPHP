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

if($cId == "" || $nid == ""){
    echo "<script>
            alert('비정상적인 접근입니다.');
            history.back();
            </script>";
}

$continent = $obj->getContinent($cId);
$nation = $obj->getNation($nid);
$list = $obj->getSupportParents($nid);

?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
    $(document).ready(function(){
        var addPop = $("#jAddPop");
        var addPopP = $("#jAddPopP");
        addPop.draggable();
        addPopP.draggable();

        $(".jAdd").click(function(){
            addPop.fadeIn();
        });

        $(".jAddParent").click(function(){
            addPopP.fadeIn();
        });

        $(".jLang").change(function(){
            var loc = $(this).val();
            var nationId = "<?=$nid?>";
            if(loc != "#"){
                var ajax = new AjaxSender("/route.php?cmd=AdminMain.getNationName", true, "json",
                    new sehoMap().put("loc", loc).put("nid", nationId));
                ajax.send(function(data){
                    if(data == null || data == "") $(".jTitle").val("");
                    else $(".jTitle").val(data.name);
                });
            }else{
                // Do nothing
            }
        });

        $(".jSave").click(function(){
            var lang = $(".jLang").val();
            var nationId = "<?=$nid?>";
            if(lang == "#"){
                alert("언어를 선택하세요.");
                return;
            }

            var desc = $(".jTitle").val();
            var ajax = new AjaxSender("/route.php?cmd=AdminMain.setNationName", true, "json",
                new sehoMap().put("lang", lang).put("nationId", nationId).put("name", desc));
            ajax.send(function(data){
                if(data.returnCode === 1){
                    alert("저장되었습니다.");
                    $(".jLang").trigger("change");
                }
            });
        });

        $(".jSaveP").click(function(){
            var nationId = "<?=$nid?>";
            var contId = "<?=$cId?>";
            var desc = $(".jTitleP").val();
            var ajax = new AjaxSender("/route.php?cmd=AdminMain.initSupport", true, "json",
                new sehoMap().put("desc", desc).put("nationId", nationId));
            ajax.send(function(data){
                if(data.returnCode === 1){
                    var id = data.entity;
                    location.href = "/admin/pages/siteManage/supportArticleDetail.php?sid=" + id + "&id=" + nationId + "&fid=" + contId;
                }
            });
        });

        $(".jDelete").click(function(){
            if(confirm("해당 글을 하위 계층의 모든 후원글이 삭제되며, 복구되지 않습니다.\n정말 삭제하시겠습니까?")){
                var ajax = new AjaxSender(
                    "/route.php?cmd=AdminMain.deleteSupport",
                    true, "json",
                    new sehoMap().put("id", $(this).attr("id")));
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("삭제되었습니다.");
                        location.reload();
                    }
                });
            }
        });

        $(".jView").click(function(){
            var id = $(this).attr("id");
            var nationId = "<?=$nid?>";
            var contId = "<?=$cId?>";
            location.href = "/admin/pages/siteManage/supportArticleDetail.php?sid=" + id + "&id=" + nationId + "&fid=" + contId;
        });

        $(".jClosePop").click(function(){
            addPop.fadeOut();
        });

        $(".jClosePopP").click(function(){
            addPopP.fadeOut();
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
            <li class="breadcrumb-item active">국가 정보 관리(<?=$nation["desc"]?>)</li>
        </ol>

        <button type="button" class="btn btn-secondary mb-2 jAdd">언어별 국가명 설정</button>
        <button type="button" class="btn btn-secondary float-right mb-2 jAddParent">게시글 추가</button>

        <div id="jAddPop" style="
            padding : 30px 30px; width : 500px;
            border : 1px solid black; position : absolute; left : calc(50vw - 250px); top : calc(50vh); background : white; display: none;"
        >
            <br/>
            <a href="#" class="jClosePop float-right" ><img src="./attr/btn_close.png" width="30px" height="30px" /></a>
            국가명 / 언어
            <select class="jLang">
                <option value="#">선택</option>
                <?foreach($langList as $item){?>
                    <option value="<?=$item["code"]?>"><?=$item["desc"]?></option>
                <?}?>
            </select>
            <br/><br/>
            <input type="text" class="form-control jTitle" placeholder="내용을 입력하세요" />
            <br/>
            <button type="button" class="btn btn-secondary mb-2 jSave">저장</button>
            <button type="button" class="btn btn-danger mb-2 jClosePop">취소</button>
        </div>

        <div id="jAddPopP" style="
            padding : 30px 30px; width : 500px;
            border : 1px solid black; position : absolute; left : calc(50vw - 250px); top : calc(50vh); background : white; display: none;"
        >
            <br/>
            <a href="#" class="jClosePopP float-right" ><img src="./attr/btn_close.png" width="30px" height="30px" /></a>
            후원 게시글 제목(관리용)
            <br/><br/>
            <input type="text" class="form-control jTitleP" placeholder="내용을 입력하세요" />
            <br/>
            <button type="button" class="btn btn-secondary mb-2 jSaveP">저장</button>
            <button type="button" class="btn btn-danger mb-2 jClosePopP">취소</button>
        </div>

        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th width="40%">후원 게시글 제목(관리용)</th>
                <th width="30%">등록일시</th>
                <th>-</th>
            </tr>
            </thead>
            <tbody>
            <?foreach($list as $item){?>
                <tr class="" id="<?=$item["id"]?>">
                    <td><?=$item["title"]?></td>
                    <td><?=$item["regDate"]?></td>
                    <td>
                        <button type="button" id="<?=$item["id"]?>" class="btn btn-secondary jView">관리</button>
                        <button type="button" id="<?=$item["id"]?>" class="btn btn-danger jDelete">삭제</button>
                    </td>
                </tr>
            <?}?>
            </tbody>
        </table>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
