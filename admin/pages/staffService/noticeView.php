<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 23.
 * Time: PM 1:44
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Uncallable.php";?>
<?
$obj = new Uncallable($_REQUEST);
$item = $obj->getNotice();
?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function(){
            function resizeTextArea(){
                var arr = $("textarea");
                for(var e = 0; e < arr.length; e++){
                    arr.eq(e).height(arr.eq(e).prop('scrollHeight'));
                }
            }

            resizeTextArea();
        });
    </script>

    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a>직원서비스</a>
                </li>
                <li class="breadcrumb-item ">공지사항</li>
                <li class="breadcrumb-item active">공지사항 상세</li>
            </ol>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">제목</span>
                </div>
                <input type="hidden" class="jId" value="<?=$item["id"]?>" />
                <input type="text" class="form-control jTitle" name="title" value="<?=$item["title"]?>" readonly>
            </div>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <span class="input-group-text" id="basic-addon3">내용</span>
                </div>
                <textarea class="form-control jContent" name="content" readonly><?=$item["content"]?></textarea>
            </div>

            <div style="text-align: center;">
                <img class="jImgIntro" src="<?=$item["filePath"] != "" ? $obj->fileShowPath . $item["filePath"] : ""?>" width="100px;"/>
            </div>

        </div>
        <!-- /.container-fluid -->
    </div>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>