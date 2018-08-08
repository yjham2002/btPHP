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
<?
    $obj = new AdminMain($_REQUEST);
    $list = $obj->publicationList();
?>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
        $(document).ready(function(){
            var addPop = $("#jAddPop");
            addPop.draggable();

            $(".jAdd").click(function(){
                addPop.fadeIn();
                // location.href = "/admin/pages/siteManage/publicationDetail.php";
            });

            $(".jSave").click(function(){
                var desc = $(".jTitle").val();
                var ajax = new AjaxSender("/route.php?cmd=AdminMain.initPublication", true, "json", new sehoMap().put("desc", desc));
                ajax.send(function(data){
                    if(data.returnCode === 1){
                        location.href = "/admin/pages/siteManage/publicationDetail.php?id=" + data.entity;
                    }
                });
            });

            $(".jView").click(function(){
                var id = $(this).attr("id");
                location.href = "/admin/pages/siteManage/publicationDetail.php?id=" + id + "&langCode=kr";
            });

            $(".jClosePop").click(function(){
                addPop.fadeOut();
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
                <li class="breadcrumb-item active">간행물 관리</li>
            </ol>

            <button type="button" class="btn btn-secondary float-right mb-2 jAdd">추가</button>

            <div id="jAddPop" style="
            padding : 30px 30px; width : 500px;
            border : 1px solid black; position : absolute; left : calc(50vw - 250px); top : calc(50vh); background : white; display: none;"
            >
                <a href="#" class="jClosePop float-right" ><img src="./attr/btn_close.png" width="30px" height="30px" /></a>
                관리용 간행물명
                <br/><br/>
                <input type="text" class="form-control jTitle" placeholder="내용을 입력하세요" />
                <br/>
                <button type="button" class="btn btn-secondary mb-2 jSave">추가</button>
                <button type="button" class="btn btn-danger mb-2 jClosePop">취소</button>
            </div>

            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>간행물명(관리용)</th>
                    <th>등록일시</th>
                </tr>
                </thead>
                <tbody>
                <?foreach($list as $item){?>
                    <tr class="jView" id="<?=$item["id"]?>">
                        <td><?=$item["desc"]?></td>
                        <td><?=$item["regDate"]?></td>
                    </tr>
                <?}?>
                </tbody>
            </table>
        </div>
        <!-- /.container-fluid -->
    </div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>