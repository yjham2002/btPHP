<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 1.
 * Time: PM 12:28
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Management.php";?>
<?
    $management = new Management($_REQUEST);
    $parent = $management->foreignPubInfo();
    $item = $management->foreignPubChild();
?>

<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/admin/scss/smSheet.css">
<script>
    $(document).ready(function(){
        $(".datePicker").datepicker({
            showMonthAfterYear:true,
            inline: true,
            changeMonth: true,
            changeYear: true,
            dateFormat : 'yy-mm-dd',
            dayNamesMin:['일', '월', '화', '수', '목', '금', ' 토'],
            monthNames:['1월','2월','3월','4월','5월','6월','7 월','8월','9월','10월','11월','12월'],
            monthNamesShort:['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월']
        });

        calculateCharge();

        $(document).on("click", ".jViewDoc", function(){
            var path = $(this).attr("data");
            alert(path);
            location.href = "";
        });

        $("[name=printCharge]").keyup(function(){
            $(this).val($(this).val().format());
            calculateCharge();
        });

        $("[name=deliveryCharge]").keyup(function(){
            $(this).val($(this).val().format());
            calculateCharge();
        });

        function calculateCharge(){
            var printCharge = $("[name=printCharge]").val().replace(",", "");
            var deliveryCharge = $("[name=deliveryCharge]").val().replace(",", "");
            if(printCharge === "") printCharge = 0;
            else printCharge = parseInt(printCharge);
            if(deliveryCharge === "") deliveryCharge = 0;
            else deliveryCharge = parseInt(deliveryCharge)
            $(".jTotal").text((printCharge + deliveryCharge).format());
        }

        $(".jSave").click(function(){
            //TODO file save
            var ajax = new AjaxSubmit("/route.php?cmd=Management.upsertForeignPubChild", "post", false, "json", "#form");
            ajax.send(function(data){
                if(data.returnCode === 1){
                    alert("저장되었습니다");
                    location.reload();
                }
            })
        });

        $(".jFile").change(function(){
            var no = $(this).attr("no");
            var fullPath = $(this).val();
            if(fullPath){
                var startIndex = (fullPath.indexOf('\\') >= 0 ? fullPath.lastIndexOf('\\') : fullPath.lastIndexOf('/'));
                var filename = fullPath.substring(startIndex);
                if (filename.indexOf('\\') === 0 || filename.indexOf('/') === 0) filename = filename.substring(1);
                $(".jLabel" + no).text(filename);
            }
        });

        $(".jClear").click(function(){
            var no = $(this).attr("no");
            $(".jLabel" + no).text("");
            $("[name=docFile" + no + "]").val("");
            $("[name=filePath" + no + "]").val("");
            $(".jDown" + no).parent().remove();
        });
    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a>고객관리</a>
            </li>
            <li class="breadcrumb-item active">해외진행 현황</li>
            <li class="breadcrumb-item active">해외진행 현황 상세</li>
        </ol>
        <button type="button" class="btn btn-primary float-right mb-3 jSave">등록/수정</button>
        <form method="post" id="form" action="#" enctype="multipart/form-data">
            <input type="hidden" name="parentId" value="<?=$_REQUEST["parentId"]?>"/>
            <input type="hidden" name="id" value="<?=$_REQUEST["id"]?>"/>

            <table class="table table-sm table-bordered text-center">
                <colgroup>
                    <col width="10%"/>
                    <col width="25%"/>
                    <col width="10%"/>
                    <col width="25%"/>
                    <col width="10%"/>
                    <col width="25%"/>
                </colgroup>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">국가</td>
                    <td><?=$parent["country"]?></td>
                    <td class="bg-secondary text-light">언어</td>
                    <td><?=$parent["language"]?></td>
                    <td class="bg-secondary text-light">ND</td>
                    <td><input type="text" class="form-control" name="nd" value="<?=$item["nd"]?>"/></td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">월호</td>
                    <td style="text-align: center;">
                        <div class="form-inline">
                            <select class="form-control" id="startMonth" name="startMonth">
                                <option value="">선택</option>
                                <?for($i=1; $i<=12; $i++){?>
                                    <option value="<?=$i?>" <?=$item["startMonth"] == $i ? "selected" : ""?>><?=$i?></option>
                                <?}?>
                            </select>
                            &nbsp;~&nbsp;
                            <select class="form-control" id="endMonth" name="endMonth">
                                <option value="">선택</option>
                                <?for($i=1; $i<=12; $i++){?>
                                    <option value="<?=$i?>" <?=$item["endMonth"] == $i ? "selected" : ""?>><?=$i?></option>
                                <?}?>
                            </select>
                        </div>
                    </td>
                    <td class="bg-secondary text-light">구분</td>
                    <td><input type="text" class="form-control" name="type" value="<?=$item["type"]?>"/></td>
                    <td class="bg-secondary text-light">수량</td>
                    <td><input type="number" class="form-control" name="cnt" value="<?=$item["cnt"]?>"/></td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">인쇄 거래처</td>
                    <td><input type="text" class="form-control" name="client" value="<?=$item["client"]?>"/></td>
                    <td class="bg-secondary text-light">인쇄비</td>
                    <td><input type="text" class="form-control" name="printCharge" value="<?=$item["printCharge"]?>"/></td>
                    <td class="bg-secondary text-light">배송비</td>
                    <td><input type="text" class="form-control" name="deliveryCharge" value="<?=$item["deliveryCharge"]?>"/></td>
                </tr>
                <tr class="h-auto">
                    <td class="bg-secondary text-light">합계</td>
                    <td colspan="5" class="text-right jTotal"></td>
                </tr>
            </table>

            <hr>

            <div style="width: 100%;">
                <table class="table table-sm table-bordered">
                    <thead>
                    <tr>
                        <th>일자</th>
                        <th>번역</th>
                        <th>데이터</th>
                        <th>인쇄</th>
                        <th>배송</th>
                        <th>입금</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <th>예정</th>
                        <td><input class="form-control datePicker" name="dueDate1" value="<?=$item["dueDate1"]?>" /></td>
                        <td><input class="form-control datePicker" name="dueDate2" value="<?=$item["dueDate2"]?>"/></td>
                        <td><input class="form-control datePicker" name="dueDate3" value="<?=$item["dueDate3"]?>"/></td>
                        <td><input class="form-control datePicker" name="dueDate4" value="<?=$item["dueDate4"]?>"/></td>
                        <td><input class="form-control datePicker" name="dueDate5" value="<?=$item["dueDate5"]?>"/></td>
                    </tr>
                    <tr>
                        <th>완료</th>
                        <td><?=$item["endDate1"]?></td>
                        <td><?=$item["endDate2"]?></td>
                        <td><?=$item["endDate3"]?></td>
                        <td><?=$item["endDate4"]?></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>

            <hr>

            <div class="container">
                <div class="row">
                    <div class="col" style="width: 33.3%">
                        <object class="jViewDoc" data="../../../uploadFiles/<?=$item["filePath1"]?>" type="application/pdf" width="100%" height="480px"></object>
                        <br>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="hidden" name="filePath1" value="<?=$item["filePath1"]?>"/>
                                <input type="hidden" name="fileName1" value="<?=$item["fileName1"]?>"/>
                                <input type="file" class="custom-file-input" name="docFile1" id="inputGroupFile01">
                                <label class="custom-file-label jLabel1" for="inputGroupFile01"><?=$item["fileName1"] == "" ? "파일을 선택하세요" : $item["fileName1"]?></label>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <a class="jDown1" href="<?=$item["filePath1"] != "" ? $obj->fileShowPath . $item["filePath1"] : ""?>" id="file1" download="<?=$item["fileName1"]?>">
                                <label style="color:black;" for="file1"><?=$item["fileName1"]?></label>
                            </a>
                            <a no="1" class="btn-sm btn-danger ml-2 text-white jClear"> X </a>
                        </div>
                    </div>
                    <div class="col" style="width: 33.3%">
                        <object class="jViewDoc" data="../../../uploadFiles/<?=$item["filePath2"]?>" type="application/pdf" width="100%" height="480px"></object>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="hidden" name="filePath2" value="<?=$item["filePath2"]?>"/>
                                <input type="hidden" name="fileName2" value="<?=$item["fileName2"]?>"/>
                                <input type="file" class="custom-file-input" name="docFile2" id="inputGroupFile01">
                                <label class="custom-file-label jLabel2" for="inputGroupFile01"><?=$item["fileName2"] == "" ? "파일을 선택하세요" : $item["fileName2"]?></label>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <a class="jDown2" href="<?=$item["filePath2"] != "" ? $obj->fileShowPath . $item["filePath2"] : ""?>" id="file2" download="<?=$item["fileName2"]?>">
                                <label style="color:black;" for="file2"><?=$item["fileName2"]?></label>
                            </a>
                            <a no="2" class="btn-sm btn-danger ml-2 text-white jClear"> X </a>
                        </div>
                    </div>
                    <div class="col" style="width: 33.3%">
                        <object class="jViewDoc" data="../../../uploadFiles/<?=$item["filePath3"]?>" type="application/pdf" width="100%" height="480px"></object>
                        <br>
                        <div class="input-group mb-3">
                            <div class="custom-file">
                                <input type="hidden" name="filePath3" value="<?=$item["filePath3"]?>"/>
                                <input type="hidden" name="fileName3" value="<?=$item["fileName3"]?>"/>
                                <input type="file" class="custom-file-input" name="docFile3" id="inputGroupFile01">
                                <label class="custom-file-label jLabel3" for="inputGroupFile01"><?=$item["fileName3"] == "" ? "파일을 선택하세요" : $item["fileName3"]?></label>
                            </div>
                        </div>
                        <div class="input-group mb-3">
                            <a class="jDown3" href="<?=$item["filePath3"] != "" ? $obj->fileShowPath . $item["filePath3"] : ""?>" id="file3" download="<?=$item["fileName3"]?>">
                                <label style="color:black;" for="file3"><?=$item["fileName3"]?></label>
                            </a>
                            <a no="3" class="btn-sm btn-danger ml-2 text-white jClear"> X </a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>

