<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 7. 27.
 * Time: PM 2:45
 */
?>
<? include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Management.php";?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<?
$obj = new Management($_REQUEST);
$main = new AdminMain($_REQUEST);
$list = $obj->customerListDetail();
$pubList = $main->publicationList();
?>
    <script>
        $(document).ready(function(){
//            $(".jPage").click(function(){
//                $("[name=page]").val($(this).attr("page"));
//                form.submit();
//            });

            $(".jView").click(function(){
                var id = $(this).attr("id");
                location.href = "/admin/pages/customerManage/customerDetail.php?id=" + id;
            });

            $(".jSearch").click(function(){
                form.submit();
            });

            $(".jReset").click(function(){
                location.href="/admin/pages/customerManage/customerSearch.php";
            });

            function exportToExcel(htmls){

                var uri = 'data:application/vnd.ms-excel;base64,';
                var template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--><meta charset="utf-8"></head><body><table>{table}</table></body></html>';
                var base64 = function(s) {
                    return window.btoa(unescape(encodeURIComponent(s)))
                };

                var format = function(s, c) {
                    return s.replace(/{(\w+)}/g, function(m, p) {
                        return c[p];
                    })
                };

//            htmls = "YOUR HTML AS TABLE"

                var ctx = {
                    worksheet : 'Worksheet',
                    table : htmls
                }

                var link = document.createElement("a");
                link.download = "export.xls";
                link.href = uri + base64(format(template, ctx));
                link.click();

                window.close();
            }

            $(".jDownExcel").click(function(){
                var id = $(this).attr("id");
                $.ajax({
                    url : "/admin/pages/customerManage/customerExcel.php?id=" + id,
                    async : true,
                    type : "get",
                    dataType : "html",
                    success : function(data){
                        exportToExcel(data);
                    },
                    error : function(){
                        alert("데이터를 불러오는 중 오류가 발생했습니다.");
                    }
                });
            });

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

            <h3>고객 상세 검색</h3>

            <form id="form">
                <table class="mb-2 table table-sm table-bordered">
                    <tbody>
                    <tr>
                        <th width="15%">코드</th>
                        <td width="35%" colspan="2"><input type="text" class="form-control" name="code" value="<?=$_REQUEST["code"]?>" /></td>
                        <th width="15%">성명</th>
                        <td colspan="35%"><input type="text" class="form-control" name="name" value="<?=$_REQUEST["name"]?>" /></td>
                    </tr>
                    <tr>
                        <th>시작 월호</th>
                        <td>
                            <select class="custom-select" name="pYear">
                                <option value="" >전체</option>
                                <?for($i=-50; $i<50; $i++){ $tmp = intval(date("Y")) + $i; ?>
                                    <option value="<?=$tmp?>" <?=$_REQUEST["pYear"] == $tmp ? "selected" : ""?>><?=$tmp?></option>
                                <?}?>
                            </select>
                        </td>
                        <td>
                            <select class="custom-select" name="pMonth">
                                <option value="" >전체</option>
                                <?for($i=1; $i<13; $i++){ ?>
                                    <option value="<?=$i < 10 ? "0".$i : $i?>" <?=$_REQUEST["pMonth"] == $i ? "selected" : ""?>><?=$i?></option>
                                <?}?>
                            </select>
                        </td>
                        <th>종료 월호</th>
                        <td>
                            <select class="custom-select" name="eYear">
                                <option value="" >전체</option>
                                <?for($i=-50; $i<50; $i++){ $tmp = intval(date("Y")) + $i; ?>
                                    <option value="<?=$tmp?>" <?=$_REQUEST["eYear"] == $tmp ? "selected" : ""?>><?=$tmp?></option>
                                <?}?>
                            </select>
                        </td>
                        <td>
                            <select class="custom-select" name="eMonth">
                                <option value="" >전체</option>
                                <?for($i=1; $i<13; $i++){ ?>
                                    <option value="<?=$i < 10 ? "0".$i : $i?>" <?=$_REQUEST["eMonth"] == $i ? "selected" : ""?>><?=$i?></option>
                                <?}?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>신청년월</th>
                        <td>
                            <select class="custom-select" name="rYear">
                                <option value="" >전체</option>
                                <?for($i=-50; $i<50; $i++){ $tmp = intval(date("Y")) + $i; ?>
                                    <option value="<?=$tmp?>" <?=$_REQUEST["rYear"] == $tmp ? "selected" : ""?>><?=$tmp?></option>
                                <?}?>
                            </select>
                        </td>
                        <td>
                            <select class="custom-select" name="rMonth">
                                <option value="" >전체</option>
                                <?for($i=1; $i<13; $i++){ ?>
                                    <option value="<?=$i < 10 ? "0".$i : $i?>" <?=$_REQUEST["rMonth"] == $i ? "selected" : ""?>><?=$i?></option>
                                <?}?>
                            </select>
                        </td>
                        <th>E-Mail</th>
                        <td colspan="2"><input type="text" class="form-control" name="email" value="<?=$_REQUEST["email"]?>" /></td>
                    </tr>
                    <tr>
                        <th>상태</th>
                        <td colspan="2">
                            <select class="custom-select" name="status">
                                <option value="" >전체</option>
                                <option value="0" <?=$_REQUEST["status"] == "0" ? "SELECTED" : ""?>>정상</option>
                                <option value="1" <?=$_REQUEST["status"] == "1" ? "SELECTED" : ""?>>취소</option>
                                <option value="2" <?=$_REQUEST["status"] == "2" ? "SELECTED" : ""?>>발송보류</option>
                            </select>
                        </td>
                        <th>전화번호</th>
                        <td colspan="2"><input type="text" class="form-control" name="phone" value="<?=$_REQUEST["phone"]?>" /></td>
                    </tr>
                    <tr>
                        <th>후원방법</th>
                        <td colspan="2">
                            <select class="custom-select" name="sMethod">
                                <option value="" >전체</option>
                                <option value="BTG" <?=$_REQUEST["sMethod"] == "BTG" ? "SELECTED" : ""?>>BTG</option>
                                <option value="BTF" <?=$_REQUEST["sMethod"] == "BTF" ? "SELECTED" : ""?>>BTF</option>
                            </select>
                        </td>
                        <th>후원집회명</th>
                        <td colspan="2"><input type="text" class="form-control" name="sName" value="<?=$_REQUEST["sName"]?>" /></td>
                    </tr>
                    <tr>
                        <th>주소</th>
                        <td colspan="2"><input type="text" class="form-control" name="addr" value="<?=$_REQUEST["addr"]?>" /></td>
                        <th>버전</th>
                        <td colspan="2">
                            <select class="custom-select" name="version">
                                <option value="" >전체</option>
                                <?foreach($pubList as $pubItem){?>
                                    <option value="<?=$pubItem["id"]?>" <?=$_REQUEST["version"] == $pubItem["id"] ? "SELECTED" : ""?>><?=$pubItem["desc"]?></option>
                                <?}?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th>배송방식</th>
                        <td colspan="2">
                            <select class="custom-select" name="shippingType">
                                <option value="" >전체</option>
                                <option value="0" <?=$_REQUEST["shippingType"] == "0" ? "SELECTED" : ""?>>우편</option>
                                <option value="1" <?=$_REQUEST["shippingType"] == "1" ? "SELECTED" : ""?>>택배</option>
                            </select>
                        </td>
                        <th></th>
                        <td colspan="2">
                        </td>
                    </tr>
                    </tbody>
                </table>
                <div class="float-right">
                    <input type="reset" class="btn btn-secondary jReset" value="초기화" />
                    <button type="button" class="btn btn-secondary jSearch">조회</button>
                </div>
            </form>

            <br/>
            <br/>
            <hr/>
            <h3>조회 결과</h3>
            <div class="float-right mb-2" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-secondary jTranscendanceExcel" data-toggle="dropdown">
                    <i class="fas fa-download fa-fw"></i>Excel
                </button>
            </div>
            <table class="table table-hover table-bordered mt-2 alterTarget">
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
                    <tr class="jView" id="<?=$item["id"]?>">
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
            <? // include $_SERVER["DOCUMENT_ROOT"] . "/admin/inc/pageNavigator.php";?>
        </div>
    </div>

<? include_once $_SERVER['DOCUMENT_ROOT'] . "/admin/inc/footer.php"; ?>