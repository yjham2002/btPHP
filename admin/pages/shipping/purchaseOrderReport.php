<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 1.
 * Time: PM 4:28
 */
?>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>

<script>
    $(document).ready(function(){
        $(".jPage").click(function(){
            $("[name=page]").val($(this).attr("page"));
            form.submit();
        });
    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="/admin/index.php">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Blank Page</li>
        </ol>

        <table class="table table-responsive">
            <thead>
            <tr>
                <th>No.</th>
                <th>등록일시</th>
                <th>내용</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1.</td>
                <td>2018.01.01 12:12:12</td>
                <td>john@example.comjohn@example.comjohn@example.comjohn@example.comjohn@example.comjohn@example.comjohn@example.com</td>
            </tr>
            <tr>
                <td>1.</td>
                <td>2018.01.01 12:12:12</td>
                <td>john@example.comjohn@example.comjohn@example.comjohn@example.comjohn@example.comjohn@example.comjohn@example.com</td>
            </tr>
            <tr>
                <td>1.</td>
                <td>2018.01.01 12:12:12</td>
                <td>john@example.comjohn@example.comjohn@example.comjohn@example.comjohn@example.comjohn@example.comjohn@example.com</td>
            </tr>
            <tr>
                <td>1.</td>
                <td>2018.01.01 12:12:12</td>
                <td>john@example.comjohn@example.comjohn@example.comjohn@example.comjohn@example.comjohn@example.comjohn@example.com</td>
            </tr>
            </tbody>
        </table>
        <button type="button" class="float-left btn btn-secondary mr-5">글쓰기</button>

        <?include $_SERVER["DOCUMENT_ROOT"] . "/admin/inc/pageNavigator.php";?>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>

