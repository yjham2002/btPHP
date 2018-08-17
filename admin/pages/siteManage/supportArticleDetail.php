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
        $("[name=description]").text($("[name=description]").text().replace(/<br\s?\/?>/g,""));

        $(".jLang").change(function(){
            form.submit();
        });

        $("[name=imgFile]").change(function(){
            readURL(this, ".jImg");
            $("#imgPath").val("");
        });

        $("[name=titleFile]").change(function(){
            readURL(this, ".jImgTitle");
            $("#titleImg").val("");
        });

        function readURL(input, selector){
            if (input.files && input.files[0]){
                var reader = new FileReader();
                reader.onload = function(e){
                    $(selector).attr("src", e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".jSave").click(function(){
            var ajax = new AjaxSubmit("/route.php?cmd=AdminMain.upsertPublication", "post", true, "json", "#form");
            ajax.send(function(data){
                if(data.returnCode === 1){
                    location.href = "/admin/pages/siteManage/publicationDetail.php?id=" + data.entity + "&langCode=<?=$_REQUEST["langCode"]?>";
                }
                else alert("이미지 저장 실패");
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

        <form method="post" id="form" action="#" enctype="multipart/form-data">
            <input type="hidden" name="parentId" value="<?=$sid?>" />
            <input type="hidden" name="locale" value="" />

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
                    <td>
                        <div style="text-align: center;">
                            <img class="jImgTitle" src="<?=$item["titleImg"] != "" ? $obj->fileShowPath . $item["titleImg"] : ""?>" width="100px;"/>
                        </div>
                        <div class="custom-file">
                            <input type="hidden" class="form-control" name="titleImg" value="" placeholder="내용을 입력하세요" />
                            <input type="file" class="custom-file-input" name="titleFile" id="inputGroupFile01">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                    </td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">갤러리 01</td>
                    <td>
                        <div style="text-align: center;">
                            <img class="jImg1" src="<?=$item["imgPath1"] != "" ? $obj->fileShowPath . $item["imgPath1"] : ""?>" width="100px;"/>
                        </div>
                        <div class="custom-file">
                            <input type="hidden" class="form-control" name="imgPath1" value="" placeholder="내용을 입력하세요" />
                            <input type="file" class="custom-file-input" name="imgFile1" id="inputGroupFile01">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                    </td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">갤러리 02</td>
                    <td>
                        <div style="text-align: center;">
                            <img class="jImg2" src="<?=$item["imgPath2"] != "" ? $obj->fileShowPath . $item["imgPath2"] : ""?>" width="100px;"/>
                        </div>
                        <div class="custom-file">
                            <input type="hidden" class="form-control" name="imgPath2" value="" placeholder="내용을 입력하세요" />
                            <input type="file" class="custom-file-input" name="imgFile2" id="inputGroupFile01">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                    </td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">갤러리 03</td>
                    <td>
                        <div style="text-align: center;">
                            <img class="jImg3" src="<?=$item["imgPath3"] != "" ? $obj->fileShowPath . $item["imgPath3"] : ""?>" width="100px;"/>
                        </div>
                        <div class="custom-file">
                            <input type="hidden" class="form-control" name="imgPath3" value="" placeholder="내용을 입력하세요" />
                            <input type="file" class="custom-file-input" name="imgFile3" id="inputGroupFile01">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                    </td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">갤러리 04</td>
                    <td>
                        <div style="text-align: center;">
                            <img class="jImg4" src="<?=$item["imgPath4"] != "" ? $obj->fileShowPath . $item["imgPath4"] : ""?>" width="100px;"/>
                        </div>
                        <div class="custom-file">
                            <input type="hidden" class="form-control" name="imgPath4" value="" placeholder="내용을 입력하세요" />
                            <input type="file" class="custom-file-input" name="imgFile4" id="inputGroupFile01">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                    </td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">갤러리 05</td>
                    <td>
                        <div style="text-align: center;">
                            <img class="jImg5" src="<?=$item["imgPath5"] != "" ? $obj->fileShowPath . $item["imgPath5"] : ""?>" width="100px;"/>
                        </div>
                        <div class="custom-file">
                            <input type="hidden" class="form-control" name="imgPath5" value="" placeholder="내용을 입력하세요" />
                            <input type="file" class="custom-file-input" name="imgFile5" id="inputGroupFile01">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                    </td>
                </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </form>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
