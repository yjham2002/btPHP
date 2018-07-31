<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 7. 27.
 * Time: PM 4:20
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>

<script>
    $(document).ready(function(){

    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Blank Page</li>
        </ol>

        <form id="form">
            <input type="hidden" name="page" />
            <div class="btn-group float-left" role="group">
                <button type="button" class="btn btn-secondary">자동이체</button>
                <button type="button" class="btn btn-secondary">카드</button>
                <button type="button" class="btn btn-secondary">직접입금</button>
            </div>

            <div class="btn-group float-right mb-2" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-danger mr-2">삭제</button>
<!--                <button type="button" class="btn btn-secondary mr-2">삭제</button>-->
                <button type="button" class="btn btn-secondary">Excel</button>
            </div>
        </form>



        <div style="width: 100%; height: 600px; overflow-y: scroll">
            <table class="table table-bordered">
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
                <tr style="height: 10px;">
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
                <tr>
                    <td>July</td>
                    <td>Dooley</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                </tr>
                <tr>
                    <td>July</td>
                    <td>Dooley</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                </tr><tr>
                    <td>July</td>
                    <td>Dooley</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                </tr><tr>
                    <td>July</td>
                    <td>Dooley</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                </tr>
                <tr>
                    <td>July</td>
                    <td>Dooley</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                </tr>
                <tr>
                    <td>July</td>
                    <td>Dooley</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                </tr><tr>
                    <td>July</td>
                    <td>Dooley</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                </tr><tr>
                    <td>July</td>
                    <td>Dooley</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                </tr>
                <tr>
                    <td>July</td>
                    <td>Dooley</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
                    <td>july@example.com</td>
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
        </div>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
