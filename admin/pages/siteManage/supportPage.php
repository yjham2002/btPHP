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
<?
$obj = new Uncallable($_REQUEST);
$list = $obj->getContinents();
?>
<script>
    $(document).ready(function(){

        $(".jManage").click(function(){
            location.href="/admin/pages/siteManage/continentManage.php?id=" + $(this).attr("id");
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
            <li class="breadcrumb-item active">후원 관리</li>
        </ol>


        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <th width="60%">대륙 구분(코드)</th>
                <th width="25%">등록 국가</th>
                <th>-</th>
            </tr>
            </thead>
            <tbody>
            <?foreach($list as $item){?>
                <tr class="" id="<?=$item["id"]?>">
                    <td><?=$item["name"]?>(<?=$item["continentCode"]?>)</td>
                    <td><?=$item["ncnt"]?></td>
                    <td>
                        <button type="button" id="<?=$item["id"]?>" class="btn btn-secondary jManage">관리</button>
                    </td>
                </tr>
            <?}?>
            </tbody>
        </table>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
