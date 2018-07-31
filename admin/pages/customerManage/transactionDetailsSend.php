<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 7. 30.
 * Time: PM 2:54
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

        <form class="mb-2" id="form">
            <input type="hidden" name="page" />
            <select class="custom-select mr-2 col-2" id="inputGroupSelect01">
                <option selected>Choose...</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
            <select class="custom-select mr-2 col-2" id="inputGroupSelect01">
                <option selected>Choose...</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>

            <div class="float-right">
                <button type="button" class="btn btn-secondary mr-2">인쇄</button>
                <button type="button" class="btn btn-secondary mr-2">Email</button>
                <button type="button" class="btn btn-secondary">Excel</button>
            </div>


        </form>



        <table class="table">
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
            <tr>
                <td>John</td>
                <td>Doe</td>
                <td>john@example.com</td>
                <td>john@example.com</td>
                <td>john@example.com</td>
                <td>john@example.com</td>
            </tr>
            <tr>
                <td>Mary</td>
                <td>Moe</td>
                <td>mary@example.com</td>
                <td>mary@example.com</td>
                <td>mary@example.com</td>
                <td>mary@example.com</td>
            </tr>
            <tr>
                <td>July</td>
                <td>Dooley</td>
                <td>july@example.com</td>
                <td>july@example.com</td>
                <td>july@example.com</td>
                <td>july@example.com</td>
            </tr>
            </tbody>
        </table>
        <?include $_SERVER["DOCUMENT_ROOT"] . "/admin/inc/pageNavigator.php";?>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>

