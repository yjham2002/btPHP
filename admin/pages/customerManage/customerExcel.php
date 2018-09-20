<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 9. 20.
 * Time: PM 6:32
 */
include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";

$obj = new AdminMain($_REQUEST);
$list = $obj->getCustomerExcelList();

?>

<table border="1" id="toPrint">
    <tr>
        <th>구분</th>
    </tr>
    <?for($i = 0; $i < sizeof($list); $i++){
        $item = $list[$i];
        ?>
    <tr>
        <td><?=$item["id"]?></td>
    </tr>
    <?}?>
</table>