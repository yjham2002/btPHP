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

        $(".jTable").click(function(){
            var page = 1;
            var table = $(this).attr("value");
            location.href = "/admin/pages/rawData.php?table=" + table + "&page=" + page;
        });

        $(".jTable[value=<?=$_REQUEST["table"]?>]").addClass("active");

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

        <div class="btn-group float-left mb-2" role="group">
            <button type="button" class="btn btn-secondary jTable" value="tblPublication">간행물</button>
            <button type="button" class="btn btn-secondary jTable" value="tblSupportParent">후원게시물</button>
            <button type="button" class="btn btn-secondary jTable" value="tblCardType">카드</button>
            <button type="button" class="btn btn-secondary jTable" value="tblBankType">은행</button>
        </div>

        <br/><br/>

        <p>- 후원게시글의 경우, 국가 및 후원자 언어모드 참조를 위해 게시글 번호를 사용하며,
            게시글과 별도로 후원국가 지정만을 원할 경우, 해당 국가가 연결된 게시글 중 임의의 항목을 사용하십시오.</p>

        <table class="table table-hover table-bordered">
            <thead>
            <tr>
                <?
                for($e = 0; $e < sizeof($column); $e++){
                    ?>
                    <th><?=$column[$e]["Field"] == "id" ? "고유관리번호[참조키]" : $column[$e]["Field"]?></th>
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

