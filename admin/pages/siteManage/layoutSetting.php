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
    $mainObj = new AdminMain($_REQUEST);
    $exposures = $mainObj->getExposures();
?>

    <script>
        $(document).ready(function(){

            $(".jToggle").click(function(){
                var code = $(this).attr("code");
                var checked = $(this).prop("checked") ? 1 : 0;

                $.ajax({
                    url : "/route.php?cmd=AdminMain.saveExposure",
                    async : true,
                    type : 'post',
                    data : {
                        code : code,
                        checked : checked
                    },
                    success : function(data){
//                         alert(data);
                    }
                });
            });



        });
    </script>

    <div id="content-wrapper">
        <div class="container-fluid">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">홈페이지관리</li>
                <li class="breadcrumb-item active">레이아웃</li>
            </ol>

            <div class="btn-group float-right mb-2" role="group">
                
            </div>


            <h2>레이아웃 설정</h2>

            <br/>

            <!-- HEADER ELEMENTS -->
            <h4>레이아웃 노출 여부 설정</h4>
            <table class="table table-sm table-bordered text-center">
                <colgroup>
                    <col width="90%"/>
                    <col width="10%"/>
                </colgroup>
                <?for($i = 0; $i < sizeof($exposures); $i++){?>
                    <tr class="h-auto">
                        <td class="bg-secondary text-light langKey" key="webTitle"><?=$exposures[$i]["desc"]?></td>
                        <td>
                            <input type="checkbox" class="form-control jToggle"
                                   <?=$exposures[$i]["exposure"] == 1 ? "checked" : ""?> code="<?=$exposures[$i]["code"]?>"/>
                        </td>
                    </tr>
                <?}?>
            </table>

            <hr>

        </div>
        <!-- /.container-fluid -->
    </div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>