<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 7. 27.
 * Time: PM 2:45
 */
?>
<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Management.php";?>
<?
    $obj = new Management($_REQUEST);
    $list = $obj->customerList();
?>
<script>
    $(document).ready(function(){
        $(".jPage").click(function(){
            $("[name=page]").val($(this).attr("page"));
            form.submit();
        });

        $(".jView").click(function(){
            location.href = "/admin/pages/customerManage/customerDetail.php";
        })
    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>고객관리</a>
            </li>
            <li class="breadcrumb-item active">고객정보</li>
        </ol>

        <form id="form">
            <input type="hidden" name="page" />
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <a class="dropdown-item" href="#">Something else here</a>
                        <div role="separator" class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Separated link</a>
                    </div>
                </div>
                <input type="text" class="form-control mr-2" aria-label="Text input with dropdown button">
                <div class="btn-group float-right" role="group" aria-label="Basic example">

                    <button type="button" class="btn btn-secondary mr-lg-5">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                    <button type="button" class="btn btn-secondary mr-2">삭제</button>
                    <button type="button" class="btn btn-secondary">Excel</button>
                </div>
            </div>
        </form>

        <table class="table table-responsive table-hover table-bordered">
            <thead>
            <tr>
                <th>ID</th>
                <th>구분</th>
                <th>이름</th>
                <th>핸드폰번호</th>
                <th>주소</th>
                <th>등록일시</th>
            </tr>
            </thead>
            <tbody>
            <?foreach($list as $item){?>
                <tr class="jView">
                    <td><?=$item["email"]?></td>
                    <td><?=$item["type"] == "1" ? "개인" : "단체"?></td>
                    <td><?=$item["name"]?></td>
                    <td><?=$item["phone"]?></td>
                    <td><?=$item["addr"] . " " . $item["addrDetail"]?></td>
                    <td><?=$item["regDate"]?></td>
                </tr>
            <?}?>
            </tbody>
        </table>
        <?include $_SERVER["DOCUMENT_ROOT"] . "/admin/inc/pageNavigator.php";?>
    </div>
</div>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>