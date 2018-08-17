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
    $info = $objm->supportAricleDetail();

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
        $("[name=locale]").val($(".jLang").val());
        // $("[name=description]").text($("[name=description]").text().replace(/<br\s?\/?>/g,""));

        $(".jLang").change(function(){
            $("[name=locale]").val($(this).val());
            form.submit();
        });

        $("[name=titleFile]").change(function(){
            readURL(this, ".jImgTitle");
            $("#titleImg").val("");
        });

        $("[name=imgFile1]").change(function(){
            readURL(this, ".jImg1");
            $("#imgPath1").val("");
        });

        $("[name=imgFile2]").change(function(){
            readURL(this, ".jImg2");
            $("#imgPath2").val("");
        });

        $("[name=imgFile3]").change(function(){
            readURL(this, ".jImg3");
            $("#imgPath3").val("");
        });

        $("[name=imgFile4]").change(function(){
            readURL(this, ".jImg4");
            $("#imgPath4").val("");
        });

        $("[name=imgFile5]").change(function(){
            readURL(this, ".jImg5");
            $("#imgPath5").val("");
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
            var ajax = new AjaxSubmit("/route.php?cmd=AdminMain.upsertSupportArticle", "post", true, "json", "#form");
            ajax.send(function(data){
                if(data.returnCode === 1){
                    location.reload();
                    //location.href = "/admin/pages/siteManage/publicationDetail.php?id=" + data.entity + "&langCode=<?//=$_REQUEST["langCode"]?>//";
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
                    <option value="<?=$item["code"]?>" <?=$_REQUEST["locale"] == $item["code"] ? "selected" : ""?>><?=$item["desc"]?></option>
                <?}?>
            </select>
        </div>

        <form method="post" id="form" action="#" enctype="multipart/form-data">
            <input type="hidden" name="parentId" value="<?=$sid?>" />
            <input type="hidden" name="locale" value="<?=$_REQUEST["locale"]?>" />

            <table class="table table-hover table-bordered">
                <thead>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">상단 타이틀</td>
                    <td><input type="text" class="form-control" name="smTitle" value="<?=$info["smTitle"]?>" placeholder="내용을 입력하세요"/></td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">중앙 타이틀</td>
                    <td><input type="text" class="form-control" name="Title" value="<?=$info["Title"]?>" placeholder="내용을 입력하세요" /></td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">하단 타이틀</td>
                    <td><input type="text" class="form-control" name="subTitle" value="<?=$info["subTitle"]?>" placeholder="내용을 입력하세요" /></td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">후원 목표</td>
                    <td><input type="text" class="form-control" name="goal" value="<?=$info["goal"]?>" placeholder="금액을 입력하세요" /></td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">내용</td>
                    <td><textarea class="form-control" name="content" placeholder="내용을 입력하세요"><?=$info["content"]?></textarea></td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">메인 이미지</td>
                    <td>
                        <div style="text-align: center;">
                            <img class="jImgTitle" src="<?=$info["titleImg"] != "" ? $obj->fileShowPath . $info["titleImg"] : ""?>" width="100px;"/>
                        </div>
                        <div class="custom-file">
                            <input type="hidden" class="form-control" name="titleImg" value="<?=$info["titleImg"]?>"/>
                            <input type="file" class="custom-file-input" name="titleFile" id="inputGroupFile01">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                    </td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">갤러리 01</td>
                    <td>
                        <div style="text-align: center;">
                            <img class="jImg1" src="<?=$info["imgPath1"] != "" ? $obj->fileShowPath . $info["imgPath1"] : ""?>" width="100px;"/>
                        </div>
                        <div class="custom-file">
                            <input type="hidden" class="form-control" name="imgPath1" value="<?=$info["imgPath1"]?>"/>
                            <input type="file" class="custom-file-input" name="imgFile1" id="inputGroupFile01">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                    </td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">갤러리 02</td>
                    <td>
                        <div style="text-align: center;">
                            <img class="jImg2" src="<?=$info["imgPath2"] != "" ? $obj->fileShowPath . $info["imgPath2"] : ""?>" width="100px;"/>
                        </div>
                        <div class="custom-file">
                            <input type="hidden" class="form-control" name="imgPath2" value="<?=$info["imgPath2"]?>"/>
                            <input type="file" class="custom-file-input" name="imgFile2" id="inputGroupFile01">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                    </td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">갤러리 03</td>
                    <td>
                        <div style="text-align: center;">
                            <img class="jImg3" src="<?=$info["imgPath3"] != "" ? $obj->fileShowPath . $info["imgPath3"] : ""?>" width="100px;"/>
                        </div>
                        <div class="custom-file">
                            <input type="hidden" class="form-control" name="imgPath3" value="<?=$info["imgPath3"]?>"/>
                            <input type="file" class="custom-file-input" name="imgFile3" id="inputGroupFile01">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                    </td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">갤러리 04</td>
                    <td>
                        <div style="text-align: center;">
                            <img class="jImg4" src="<?=$info["imgPath4"] != "" ? $obj->fileShowPath . $info["imgPath4"] : ""?>" width="100px;"/>
                        </div>
                        <div class="custom-file">
                            <input type="hidden" class="form-control" name="imgPath4" value="<?=$info["imgPath4"]?>"/>
                            <input type="file" class="custom-file-input" name="imgFile4" id="inputGroupFile01">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                        </div>
                    </td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">갤러리 05</td>
                    <td>
                        <div style="text-align: center;">
                            <img class="jImg5" src="<?=$info["imgPath5"] != "" ? $obj->fileShowPath . $info["imgPath5"] : ""?>" width="100px;"/>
                        </div>
                        <div class="custom-file">
                            <input type="hidden" class="form-control" name="imgPath5" value="<?=$info["imgPath5"]?>"/>
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
