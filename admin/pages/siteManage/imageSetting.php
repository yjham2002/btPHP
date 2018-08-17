<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 2:09
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Uncallable.php";?>
<?
$objm = new AdminMain($_REQUEST);
$langList = $objm->getLangList();

$uc = new Uncallable($_REQUEST);

$locCode = $_REQUEST["loc"];

if($locCode == ""){
    echo "<script>location.href='imageSetting.php?loc=kr';</script>";
}

$CONST_PREFIX_IMAGE = "L_IMG";

$imageList = $uc->getProperties($CONST_PREFIX_IMAGE, $locCode);
?>

    <script>
        $(document).ready(function(){

            $(".jLang").change(function(){
                location.href="imageSetting.php?loc=" + $(this).val();
            });

            $("[name=imgFile]").change(function(){
                readURL(this, $(this).parent().parent().parent().find(".jImg"));
                $("#imgPath").val("");
            });

            function readURL(input, object){
                if (input.files && input.files[0]){
                    var reader = new FileReader();
                    reader.onload = function(e){
                        object.attr("src", e.target.result);
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }
            $(".jApply").click(function(){
                if(confirm("본 설정은 복구할 수 없습니다.\n일괄 적용하시겠습니까?")){
                var imgName = $(this).attr("imgName");
                var pName = $(this).attr("pName");
                var pDesc = $(this).attr("pDesc");

                var ajax = new AjaxSender(
                    "/route.php?cmd=Uncallable.setPropertyAllAjax",
                    true, "json",
                    new sehoMap().put("name", pName).put("desc", pDesc).put("value", imgName));
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("전체 언어에 대해 일괄 적용 되었습니다.");
                    }
                });
                }
            });

            $(".jSave").click(function(){
                var ajax = new AjaxSubmit("/route.php?cmd=Uncallable.setPropertyWithData", "post", true, "json", "#" + $(this).attr("formName"));
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        location.reload();
                    } else {
                        alert("레이아웃 이미지 저장 중 오류가 발생하였습니다.");
                    }
                });
            });

        });
    </script>

    <div id="content-wrapper">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">홈페이지관리</li>
                <li class="breadcrumb-item active">레이아웃 이미지 설정</li>
            </ol>

            <div class="btn-group float-right mb-2" role="group">
                <select class="custom-select mr-2 jLang" id="inputGroupSelect01">
                    <?foreach($langList as $item){?>
                        <option value="<?=$item["code"]?>" <?=$item["code"]==$locCode ? "SELECTED" : ""?>><?=$item["desc"]?></option>
                    <?}?>
                </select>
            </div>


            <h2>레이아웃 이미지 설정</h2>

            <br/>
            <div class="row">
                <? for($e = 0; $e < sizeof($imageList); $e++){
                    $item = $imageList[$e];
                    ?>

                    <div class="col-xl-6 col-sm-6 mb-3">
                        <form method="post" id="<?=$item["propertyName"]?>" action="#" enctype="multipart/form-data">

                            <div class="card text-white bg-dark o-hidden h-100" >
                                <div class="card-header">
                                    <i class="fas fa-image"></i>
                                    <?=$item["desc"]?>
                                    <div class="float-right">
                                        <a href="#" pDesc="<?=$item["desc"]?>" pName="<?=$item["propertyName"]?>" imgName="<?=$item["value"]?>" class="jApply btn btn-primary">다국어 일괄 적용</a>
                                        <a href="#" formName="<?=$item["propertyName"]?>" class="jSave btn btn-secondary">저장</a>
                                    </div>
                                </div>
                                <img class="jImg" src="<?=$item["value"] != "" ? $obj->fileShowPath . $item["value"] : ""?>" width="100%;"/>
                            </div>
                            <div class="input-group mb-2" >

                                <div class="custom-file">
                                    <input type="hidden" name="imgPath" value="<?=$item["value"]?>"/>
                                    <input type="file" class="custom-file-input" name="imgFile" id="inputGroupFile01">
                                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                </div>
                                <input type="hidden" name="propertyName" value="<?=$item["propertyName"]?>" />
                                <input type="hidden" name="loc" value="<?=$locCode?>" />
                            </div>
                        </form>
                    </div>

                <? } ?>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>