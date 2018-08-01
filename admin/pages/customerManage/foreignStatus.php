<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 7. 30.
 * Time: PM 3:10
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

        $(".jHistory").click(function(){
            location.href = "/admin/pages/customerManage/foreignHistory.php";
        });
    });
</script>

<style>

    .dotWrap{
        padding-left: 5px;
        padding-right: 5px;
        float:left;
        margin-left : 5px;
        margin-right : 5px;
        height:70px;
        border-radius: 5px;
        background: lightblue;
        text-align: center;
    }

    .dotWrap h3{

        font-size: 1.5em;
    }

    .dot {
        background : green;
        border-radius: 20px;
        width : 14px;
        height : 14px;
        float : left;
        margin : 2px;
    }

    .dot.disabled{
        background: gray;
    }

    .dot:not(.text) pickle{
        display: none;
    }

    .dot.text{
        color:white;
        background : #AAAAAA;
        padding : 5px;
        line-height: 10px;
        border-radius: 3px;
        font-size : 0.8em;
        width : auto;
        margin-top: 0px;
        height : 20px;
    }
</style>

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Blank Page</li>
        </ol>

        <form class="mb-2" id="form">
            <input type="hidden" name="page" />
        </form>
        <div class="btn-group float-right mb-2" role="group" aria-label="Basic example">
            <button type="button" class="btn btn-secondary mr-2">Excel</button>
            <button type="button" class="btn btn-secondary">입력</button>
        </div>



        <table class="table table-bordered">
            <thead>
            <tr>
                <th class="col-sm-">인쇄</th>
                <th>국가</th>
                <th>언어</th>
                <th>진행상황</th>
                <th>번역판</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>John</td>
                <td>Doe</td>
                <td>ㅁㄴㅇㅁㄴㅇ</td>
                <td style="padding-left: 0; padding-right: 0;">
                    <div class="dotWrap">
                        <h3>6-7월 <i class="fas fa-fw fa-list jHistory"></i></h3>
                        <div class="dot"><pickle>데이터</pickle></div>
                        <div class="dot text"><pickle>데이터</pickle></div>
                        <div class="dot"><pickle>배송</pickle></div>
                        <div class="dot disabled"><pickle>데이터</pickle></div>
                    </div>
                    <div class="dotWrap">
                        <h3>8-9월 <i class="fas fa-fw fa-list jHistory"></i></h3>
                        <div class="dot"><pickle>데이터</pickle></div>
                        <div class="dot text"><pickle>데이터</pickle></div>
                        <div class="dot"><pickle>배송</pickle></div>
                        <div class="dot disabled"><pickle>데이터</pickle></div>
                    </div>
                    <div class="dotWrap">
                        <h3>8-9월 <i class="fas fa-fw fa-list jHistory"></i></h3>
                        <div class="dot"><pickle>데이터</pickle></div>
                        <div class="dot text"><pickle>데이터</pickle></div>
                        <div class="dot"><pickle>배송</pickle></div>
                        <div class="dot disabled"><pickle>데이터</pickle></div>
                    </div>
                    <div class="dotWrap">
                        <h3>8-9월 <i class="fas fa-fw fa-list jHistory"></i></h3>
                        <div class="dot"><pickle>데이터</pickle></div>
                        <div class="dot text"><pickle>데이터</pickle></div>
                        <div class="dot"><pickle>배송</pickle></div>
                        <div class="dot disabled"><pickle>데이터</pickle></div>
                    </div>
                    <div class="dotWrap">
                        <h3>8-9월 <i class="fas fa-fw fa-list jHistory"></i></h3>
                        <div class="dot"><pickle>데이터</pickle></div>
                        <div class="dot text"><pickle>데이터</pickle></div>
                        <div class="dot"><pickle>배송</pickle></div>
                        <div class="dot disabled"><pickle>데이터</pickle></div>
                    </div>
                </td>
                <td>adsdas</td>
            </tr>

            </tbody>
        </table>
        <?include $_SERVER["DOCUMENT_ROOT"] . "/admin/inc/pageNavigator.php";?>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
