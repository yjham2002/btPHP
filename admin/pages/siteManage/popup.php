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

$uc = new Uncallable($_REQUEST);

$CONST_PREFIX_IMAGE = "S_POPUP_IMG_";

$imageList = $uc->getProperties($CONST_PREFIX_IMAGE, "#");

$static_addr = $uc->getProperty("STATIC_POPUP");
$flag = $uc->getProperty("FLAG_VALUE_POPUP_SHOW");

?>

    <script>
        $(document).ready(function(){

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

            $(".jTog").click(function(){
                var ajax = new AjaxSender("/route.php?cmd=Uncallable.setPropertyAjax", true, "json",
                    new sehoMap()
                        .put("name", "FLAG_VALUE_POPUP_SHOW")
                        .put("value", "<?= $flag == 0 ? 1 : 0?>")
                );
                ajax.send(function (data) {
                    location.reload();
                });
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

            $(".jSaveStatic").click(function(){
                var pr = $(this).attr("pr");
                var val = $("[pr="+pr+"]").val();

                var ajax = new AjaxSender(
                    "/route.php?cmd=Uncallable.setPropertyAjax",
                    true, "json",
                    new sehoMap().put("name", pr).put("value", val));
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        alert("저장되었습니다.");
                        location.reload();
                    }
                });
            });

        });
    </script>

    <div id="content-wrapper">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">홈페이지 관리</li>
                <li class="breadcrumb-item active">메인 팝업 관리</li>
            </ol>

            <h3>메인 팝업 설정</h3>

            <button type="button" class="btn <?=$flag == 0 ? "btn-secondary" : "btn-primary"?> float-right mb-2 jTog">팝업 노출 <?=$flag == 0 ? "OFF" : "ON"?></button>

            <br/>

            <div class="input-group mb-2">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">팝업 내용</span>
                </div>
                <input type="text" class="form-control" pr="STATIC_POPUP" name="setDate" value="<?=$static_addr?>" placeholder="내용을 입력하세요" />
                <a href="#" class="jSaveStatic btn btn-secondary" pr="STATIC_POPUP">저장</a>
            </div>

            <br/>
            <div class="row">
                <? for($e = 0; $e < sizeof($imageList); $e++){
                    $item = $imageList[$e];
                    ?>

                    <div class="col-xl-12 col-sm-12 mb-3">
                        <form method="post" id="<?=$item["propertyName"]?>" action="#" enctype="multipart/form-data">

                            <div class="card text-white bg-dark o-hidden h-100" >
                                <div class="card-header">
                                    <i class="fas fa-image"></i>
                                    <?=$item["desc"]?>
                                    <div class="float-right">
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
                                <input type="hidden" name="loc" value="#" />
                            </div>
                        </form>
                    </div>

                <? } ?>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>