<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 1.
 * Time: PM 2:40
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

        <form id="form">
            <input type="hidden" name="page" />

            <div class="input-group mb-3">
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
            </div>
        </form>
        
        <table class="table">
            <thead>
            <tr>
                <th>No.</th>
                <th>년도</th>
                <th>월호</th>
                <th>유형</th>
                <th>등록번호</th>
                <th>발주서</th>
                <th>등록일자</th>
                <th>상세</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>1</td>
                <td>2018</td>
                <td>01</td>
                <td>미국판</td>
                <td>610-82-78048</td>
                <td><button type="button" class="btn btn-secondary btn-sm">발주서</button></td>
                <td>2018-01-01 13:12:13</td>
                <td><button type="button" class="btn btn-secondary btn-sm">상세</button></td>
            </tr>
            <tr>
                <td>1</td>
                <td>2018</td>
                <td>01</td>
                <td>미국판</td>
                <td>610-82-78048</td>
                <td><button type="button" class="btn btn-secondary btn-sm">발주서</button></td>
                <td>2018-01-01 13:12:13</td>
                <td><button type="button" class="btn btn-secondary btn-sm">상세</button></td>
            </tr>
            <tr>
                <td>1</td>
                <td>2018</td>
                <td>01</td>
                <td>미국판</td>
                <td>610-82-78048</td>
                <td><button type="button" class="btn btn-secondary btn-sm">발주서</button></td>
                <td>2018-01-01 13:12:13</td>
                <td><button type="button" class="btn btn-secondary btn-sm">상세</button></td>
            </tr>
            </tbody>
        </table>
        <?include $_SERVER["DOCUMENT_ROOT"] . "/admin/inc/pageNavigator.php";?>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
