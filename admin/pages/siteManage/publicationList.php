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
    <script>
        $(document).ready(function(){
            $(".jAdd").click(function(){
                location.href = "/admin/pages/siteManage/publicationDetail.php";
            });

            $(".jView").click(function(){
                var id = $(this).attr("id");
                location.href = "/admin/pages/siteManage/publicationDetail.php?id=" + id + "&langCode=kr";
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

            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>간행물 이름</th>
                    <th>가격</th>
                    <th>할인 가격</th>
                    <th>등록일시</th>
                </tr>
                </thead>
                <tbody>
                <?foreach($list as $item){?>
                    <tr class="jView" id="<?=$item["id"]?>">
                        <td><?=$item["name"]?></td>
                        <td><?=$item["writePermission"] == "C" ? "회원" : "모두"?></td>
                        <td><?=$item["readPermission"] == "C" ? "회원" : "모두"?></td>
                        <td><?=$item["regDate"]?></td>
                    </tr>
                <?}?>
                </tbody>
            </table>
        </div>
        <!-- /.container-fluid -->
    </div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>