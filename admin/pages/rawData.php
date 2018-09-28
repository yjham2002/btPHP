<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 1.
 * Time: PM 3:08
 */
?>
<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Uncallable.php";

    $obj = new Uncallable($_REQUEST);
    $dbName = $obj->dbName;
    $tables = $obj->getArray("SELECT TABLE_NAME
                        FROM INFORMATION_SCHEMA.TABLES 
                        WHERE TABLE_SCHEMA = '{$dbName}'");

    $list = array();

    $column = array();

    if($_REQUEST["table"] != ""){
        $obj->initPage();
        $sqlNum = "SELECT COUNT(*) AS rn FROM {$_REQUEST["table"]}";
        $obj->rownum = $obj->getValue($sqlNum, "rn");
        $obj->setPage($obj->rownum);
        $sql = "
            SELECT
            *
            FROM {$_REQUEST["table"]}
            LIMIT {$obj->startNum}, {$obj->endNum};
            ";

        $list = $obj->getArray($sql);
        $column = $obj->getArray("DESCRIBE {$_REQUEST["table"]}");
    }
?>

<link rel="stylesheet" href="/admin/scss/smSheet.css">
<script>
    $(document).ready(function(){

        $(".jPage").click(function(){
            var page = $(this).val();
            var table = $(".jLang").val();
            location.href = "/admin/pages/rawData.php?table=" + table + "&page=" + page;
        });

       $(".jLang").change(function(){
           var page = $("#pNum").val();
           var table = $(this).val();
           location.href = "/admin/pages/rawData.php?table=" + table + "&page=" + page;
       });
    });
</script>

<input type="hidden" id="pNum" value="<?=$_REQUEST["page"] == "" ? 1 : $_REQUEST["page"]?>" />

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">데이터베이스</a>
            </li>
            <li class="breadcrumb-item active">조회</li>
        </ol>

        <div class="btn-group float-right mb-2" role="group">
            <select class="custom-select jLang" id="inputGroupSelect01">
                <option value="">선택</option>
                <?foreach($tables as $item){?>
                    <option value="<?=$item["TABLE_NAME"]?>" <?=$item["TABLE_NAME"] == $_REQUEST["table"] ? "SELECTED" : ""?>><?=$item["TABLE_NAME"]?></option>
                <?}?>
            </select>
        </div>

        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <?
                for($e = 0; $e < sizeof($column); $e++){
                    ?>
                    <th><?=$column[$e]["Field"]?></th>
                <?}
                ?>
            </tr>
            </thead>
            <tbody>
            <?
            foreach($list as $item){?>
                <tr>
                    <?
                    for($e = 0; $e < sizeof($column); $e++){
                        ?>
                        <td><?=$item[$column[$e]["Field"]]?></td>
                    <?}
                    ?>
                </tr>
            <?}?>
            </tbody>
        </table>

        <?if($_REQUEST["table"] != "") include $_SERVER["DOCUMENT_ROOT"] . "/admin/inc/pageNavigator.php";?>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>

