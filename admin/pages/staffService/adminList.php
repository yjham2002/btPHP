<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 20.
 * Time: PM 4:44
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<?
    $obj = new AdminMain($_REQUEST);
    $list = $obj->adminList();
?>

<script>
    $(document).ready(function(){
        $(".jDel").click(function(){
            if(confirm("정말 삭제하시겠습니까?")) {
                var id = $(this).attr("id");
                var ajax = new AjaxSender("/route.php?cmd=AdminMain.deleteAdmin", true, "json", new sehoMap().put("id", id));
                ajax.send(function (data) {
//                    location.reload();
                });
            }
        });

        $(".jAdd").click(function(){
            location.href = "/admin/pages/staffService/adminDetail.php";
        });

        $(".jView").click(function(){
            var id = $(this).attr("id");
            location.href = "/admin/pages/staffService/adminDetail.php?id=" + id;
        });
    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>직원서비스</a>
            </li>
            <li class="breadcrumb-item active">관리자</li>
        </ol>

        <?if($userInfo->auth == 2){?>
        <button type="button" class="btn btn-secondary float-right mb-2 jAdd">추가</button>
        <?}?>

        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th>관리자 계정</th>
                <th>관리자 이름</th>
                <th>권한</th>
                <th>등록일시</th>
                <th>-</th>
            </tr>
            </thead>
            <tbody>
            <?foreach($list as $item){?>
                <tr class="jView" id="<?=$item["id"]?>">
                    <td><?=$item["account"]?></td>
                    <td><?=$item["name"]?></td>
                    <td>
                        <?switch ($item["auth"]) {
                            case 0: echo "일반관리자"; break;
//                            case 1: echo "중간관리자"; break;
                            case 2: echo "슈퍼관리자"; break;
                        }?>
                    </td>
                    <td><?=$item["regDate"]?></td>
                    <td>
                        <?if($userInfo->auth == 2){?>
                        <button type="button" id="<?=$item["id"]?>" class="btn btn-danger mb-2 jDel">삭제</button>
                        <?}?>
                    </td>
                </tr>
            <?}?>
            </tbody>
        </table>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
