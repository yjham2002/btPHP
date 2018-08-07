<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 7.
 * Time: PM 4:47
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<?
    $obj = new AdminMain($_REQUEST);
    $langList = $obj->getLocale();
    $list = $obj->shareCategoryList();
?>
    <script>
        $(document).ready(function(){
            $(".jAdd").click(function(){
                location.href = "/admin/pages/siteManage/shareDetail.php";
            });

            $(".jView").click(function(){
                var id = $(this).attr("id");
                location.href = "/admin/pages/siteManage/shareDetail.php?id=" + id;
            });

            $(".jLang").change(function(){
                var code = $(this).val();
                $("[name=code]").val(code);
                form.submit();
            });
        });
    </script>

    <div id="content-wrapper">
        <div class="container-fluid">
            <!-- Breadcrumbs-->
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a>Dashboard</a>
                </li>
                <li class="breadcrumb-item active">Blank Page</li>
            </ol>

            <form id="form">
                <input type="hidden" name="code" />

                <select class="custom-select jLang w-25 mb-2" id="inputGroupSelect01">
                    <option value="">선택</option>
                    <?foreach($langList as $item){?>
                        <option value="<?=$item["code"]?>" <?=$_REQUEST["code"] == $item["code"] ? "selected" : ""?>><?=$item["desc"]?></option>
                    <?}?>
                </select>

                <button type="button" class="btn btn-secondary float-right jAdd">추가</button>
            </form>

            <table class="table table-hover table-bordered">
                <thead>
                <tr>
                    <th>게시판 이름</th>
                    <th>하위 타이틀</th>
                    <th>언어</th>
                    <th>쓰기권한</th>
                    <th>읽기권한</th>
                    <th>등록일시</th>
                </tr>
                </thead>
                <tbody>
                <?foreach($list as $item){?>
                    <tr class="jView" id="<?=$item["id"]?>">
                        <td><?=$item["name"]?></td>
                        <td><?=$item["subTitle"]?></td>
                        <td><?=$item["langDesc"]?></td>
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