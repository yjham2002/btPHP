<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 9. 1.
 * Time: PM 3:47
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Management.php";?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Uncallable.php";?>
<?
    $obj = new Management($_REQUEST);
    $obj2 = new AdminMain($_REQUEST);
    $uc = new Uncallable($_REQUEST);
    $pList = $obj2->publicationList();
    $typeList = $uc->getTypeList(0);

//    $uc->connect_ext_db();
//    $sql = "SELECT * from member LIMIT 1 ";
//    var_dump($uc->getRow($sql));
//    $uc->connect_int_db();
//    $sql = "SELECT * FROM tblAdmin LIMIT 1";
//    var_dump($uc->getRow($sql));

?>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="/admin/scss/smSheet.css">
<script>
    $(document).ready(function(){
        $(".jAddStore").click(function(){
            var template = $(".newStoreTemplate").html();
            $("#storeAddArea").append(template);
        });

        $("[name=shippingPrice]").keyup(function(){
            $(this).val($(this).val().format());
        });

        $(".jSave").click(function(){
            var ajax = new AjaxSubmit("/route.php?cmd=Management.storePublication", "post", true, "json", "#form");
            ajax.send(function(data){
                if(data.returnCode === 1){
                    alert("등록되었습니다.");
                    location.reload();
                }
            });
        });
    });
</script>


<table style="display: none;">
    <tbody class="newStoreTemplate">
    <tr>
        <td>
            <select class="form-control" name="publicationId[]">
                <?foreach($pList as $pItem){?>
                    <option value="<?=$pItem["id"]?>"><?=$pItem["desc"]?></option>
                <?}?>
            </select>
        </td>
        <td>
            <select class="form-control" name="type[]">
                <option value="">선택</option>
                <option value="0">미국판</option>
                <option value="1">한국판</option>
                <option value="2">표지광고</option>
            </select>
        </td>
        <td>
            <input type="number" class="form-control" name="cnt[]">
        </td>
        <td>
            <select class="form-control" name="pYear[]">
                <option value="">선택</option>
                <?for($i=-50; $i<50; $i++){
                    $tmp = intval(date("Y")) + $i;
                    ?>
                    <option value="<?=$tmp?>"><?=$tmp?></option>
                <?}?>
            </select>
        </td>
        <td>
            <select class="form-control" name="pMonth[]">
                <option value="">선택</option>
                <?for($i=1; $i<13; $i++){?>
                    <option value="<?=$i?>"><?=$i?></option>
                <?}?>
            </select>
        </td>
        <td>
            <input type="text" class="form-control" name="content[]">
        </td>
    </tr>
    </tbody>
</table>

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>배송</a>
            </li>
            <li class="breadcrumb-item active">입고 입력</li>
        </ol>
        <button type="button" class="btn btn-primary float-right mb-3 jSave">입력</button>
        <form method="post" id="form" action="#" enctype="multipart/form-data">

            <table class="table table-sm table-bordered text-center">
                <colgroup>
                    <col width="10%"/>
                    <col width="25%"/>
                    <col width="10%"/>
                    <col width="25%"/>
                </colgroup>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">일자</td>
                    <td><?=date("Y-m-d")?></td>
                    <td class="bg-secondary text-light">담당자</td>
                    <td><?=$obj->admUser->name?></td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">배송방식</td>
                    <td style="text-align: center;">
                        <select class="form-control" name="shippingType">
                            <option value="">선택</option>
                            <option value="0">우편</option>
                            <option value="1">택배</option>
                            <option value="2">직배송</option>
                        </select>
                    </td>
                    <td class="bg-secondary text-light">배송거래처</td>
                    <td>
                        <select class="form-control" name="shippingCo">
                            <option value="">선택</option>
                            <?foreach($typeList as $typeItem){?>
                                <option value="<?=$typeItem["id"]?>"><?=$typeItem["desc"]?></option>
                            <?}?>
                        </select>
<!--                        <input type="text" class="form-control" name="shippingCo" value=""/>-->
                    </td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">배송비</td>
                    <td><input type="text" class="form-control" name="shippingPrice" value=""/></td>
                </tr>
            </table>

            <hr>

            <div class="input-group mb-3 float-right">

            </div>

            <div style="width: 100%; height: 500px; overflow-y: scroll">
                <table class="table table-sm table-bordered">
                    <thead>
                    <tr>
                        <th style="width:12%">버전</th>
                        <th style="width:12%">분류</th>
                        <th style="width:12%">수량</th>
                        <th style="width:12%">연도</th>
                        <th style="width:12%">월호</th>
                        <th style="width:40%">내용</th>
                    </tr>
                    </thead>
                    <tbody id="storeAddArea">

                    </tbody>
                </table>
                <div class="input-group float-none">
                    <button type="button" class="btn btn-secondary ml-4 jAddStore">+</button>
                </div>
            </div>
        </form>
    </div>
</div>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>

