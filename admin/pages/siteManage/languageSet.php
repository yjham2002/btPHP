<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 2:09
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>

<?
    $obj = new AdminMain($_REQUEST);
    $langList = $obj->getLangList();
?>

<script>
    $(document).ready(function(){
        $(".jSend").click(function(){
            var code = $("input[name=code]").val();
            var order = $("input[name=order]").val();
            var desc = $("input[name=desc]").val();

            if(code == "" || code.length > 2 || order == ""){
                alert("올바른 정보를 입력하세요.");
                return;
            }

            $.ajax({
                type: "GET",
                url: '/route.php?cmd=AdminMain.upsertLang',
                data: {
                    'code' : code,
                    'order' : order,
                    'desc' : desc
                },
                success: function(data){
                    alert('등록되었습니다.');
                    location.reload();
                }
            });
        });

        $('.jEdit').click(function(){
            var code = $(this).parent().attr('code');
            var order = $(this).parent().attr('order');
            var desc = $(this).parent().attr('desc');

            $("input[name=code]").val(code);
            $("input[name=order]").val(order);
            $("input[name=desc]").val(desc);
        });

        $(".jDel").click(function(){
            var code = $(this).parent().attr('code');
            if(confirm('언어 코드('+code+')의 셋을 정말 삭제하시겠습니까?\n해당 언어와 관련된 모든 정보가 삭제됩니다.')){
                $.ajax({
                    type: "GET",
                    url: '/route.php?cmd=AdminMain.deleteLang',
                    data: {
                        'code' : code
                    },
                    success: function(data){
                        alert('삭제되었습니다.');
                        location.reload();
                    }
                });
            }
        });
    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">홈페이지관리</li>
            <li class="breadcrumb-item">언어</li>
            <li class="breadcrumb-item active">언어셋 관리</li>
        </ol>

        <div class="btn-group float-right mb-2" role="group" aria-label="Basic example">
            <button type="button" class="jSend btn btn-secondary mr-2">등록 / 수정</button>
        </div>


        <h2>언어셋 관리</h2>

        <br/>

        <table class="table table-sm table-bordered text-center">
            <colgroup>
                <col width="30%"/>
                <col width="70%"/>
            </colgroup>
            <tr class="h-auto">
                <td class="bg-secondary text-light">언어 코드</td>
                <td>
                    <input type="text" class="form-control" name="code" placeholder="언어 코드(ex. ko)">
                </td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">표시 순서</td>
                <td>
                    <input type="number" class="form-control" name="order" placeholder="표시 순서(ex. 0)">
                </td>
            </tr>
            <tr class="h-auto">
                <td class="bg-secondary text-light">관리용 부가 설명</td>
                <td>
                    <input type="text" class="form-control" name="desc" placeholder="관리용 부가 설명(ex. 한국어)">
                </td>
            </tr>
        </table>

        <hr>

        <table class="table table-sm table-bordered text-center">
            <colgroup>
                <col width="10%"/>
                <col width="15%"/>
                <col width="15%"/>
                <col width="15%"/>
                <col width="15%"/>
            </colgroup>
            <thead>
                <tr>
                    <th class="bg-secondary text-light">No.</th>
                    <th class="bg-secondary text-light">언어코드</th>
                    <th class="bg-secondary text-light">순서</th>
                    <th class="bg-secondary text-light">부가설명</th>
                    <th class="bg-secondary text-light">-</th>
                </tr>
            </thead>
            <?
                for($e = 0; $e < sizeof($langList); $e++){
            ?>
            <tr class="h-auto">
                <td><?=$e+1?></td>
                <td><?=$langList[$e]['code']?></td>
                <td><?=$langList[$e]['order']?></td>
                <td><?=$langList[$e]['desc']?></td>
                <td code="<?=$langList[$e]['code']?>" order="<?=$langList[$e]['order']?>" desc="<?=$langList[$e]['desc']?>">
                    <button type="button" rowId="<?=$e?>" class="jEdit btn-sm btn-secondary">수정</button>
                    <button type="button" rowId="<?=$e?>" class="jDel btn-sm btn-secondary btn-danger">삭제</button>
                </td>
            </tr>
            <? } ?>
        </table>

    </div>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>
