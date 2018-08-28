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

$CONST_PREFIX_IMAGE = "S_ORDER_";

$imageList = $uc->getProperties($CONST_PREFIX_IMAGE, "#");
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
                <li class="breadcrumb-item">배송</li>
                <li class="breadcrumb-item active">발주서 서명</li>
            </ol>


            <h2>발주서 서명 이미지 설정</h2>
            <p>※ 가로 2 : 세로 1 비율 권장</p>

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