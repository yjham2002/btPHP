<?php
/**
 * Created by PhpStorm.
 * User: 전세호
 * Date: 2018-07-31
 * Time: 오후 11:31
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Management.php";?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<?
    $obj = new Management($_REQUEST);
    $main = new AdminMain($_REQUEST);

    $item = $obj->customerInfo();
    $userInfo = $item["userInfo"];
    $paymentInfo = $item["paymentInfo"];
    $subscriptionInfo = $item["subscriptionInfo"];
    $supportInfo = $item["supportInfo"];

    $localeList = $main->getLocale();
    $localeTxt = "";
    foreach($localeList as $localeItem)
        if($localeItem["code"] == $userInfo["langCode"]) $localeTxt = $localeItem["desc"];
?>
<script>
    $(document).ready(function(){

    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>고객관리</a>
            </li>
            <li class="breadcrumb-item active">고객정보</li>
            <li class="breadcrumb-item active">고객정보 상세</li>
        </ol>

        <div class="btn-group float-right mb-2" role="group" aria-label="Basic example">
            <button type="button" class="float-right btn btn-danger mr-5">문자/이메일 수신여부</button>
            <button type="button" class="btn btn-secondary mr-2">결제 처리중</button>
            <button type="button" class="btn btn-secondary mr-2">LOST</button>
            <button type="button" class="btn btn-secondary">적용</button>
        </div>

        <h2><?=$userInfo["name"]?></h2>

        <table class="table table-sm table-bordered w-auto text-center">
            <colgroup>
                <col width="30%"/>
                <col width="70%"/>
            </colgroup>
            <tr class="h-auto">
                <td class="bg-secondary text-light">ID(이메일주소)</td>
                <td><?=$userInfo["email"]?></td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">언어</td>
                <td><?=$localeTxt?></td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">생년월일</td>
                <td><?=$userInfo["birth"]?></td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">전화번호</td>
                <td><?=$userInfo["phone"]?></td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">우편번호</td>
                <td><?=$userInfo["zipcode"]?></td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">주소</td>
                <td><?=$userInfo["addr"] . "<br>" . $userInfo["addrDetail"]?></td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">가입일시</td>
                <td><?=$userInfo["regDate"]?></td>
            </tr>
        </table>

        <hr>

        <form id="form">
            <input type="hidden" name="page" />
            <div class="btn-group float-left" role="group">
                <button type="button" class="btn btn-secondary">구독</button>
                <button type="button" class="btn btn-secondary">후원</button>
                <button type="button" class="btn btn-secondary">결제</button>
            </div>
        </form>
        <span class="badge badge-pill badge-primary float-right">&nbsp;배송조회 </span>



        <div style="width: 100%; height: 300px; overflow-y: scroll">
            <table class="table table-sm table-bordered">
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
                </tr>
                </tbody>
            </table>
        </div>

        <hr>
        <h3>History</h3>

        <div class="input-group mb-3 float-right">
            <div class="input-group-text">
                <input type="checkbox" id="hOption1">
                <label for="hOption1">전체</label>
                &nbsp;&nbsp;
                <input type="checkbox" id="hOption2">
                <label for="hOption1">구독</label>
                &nbsp;&nbsp;
                <input type="checkbox" id="hOption3">
                <label for="hOption1">후원</label>
                &nbsp;&nbsp;
                <input type="checkbox" id="hOption4">
                <label for="hOption1">결제</label>
            </div>
        </div>

        <div style="width: 100%; height: 500px; overflow-y: scroll">
            <table class="table table-sm table-bordered">
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
                </tr>
                </tbody>
            </table>
        </div>
    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
