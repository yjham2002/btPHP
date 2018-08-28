<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 1.
 * Time: PM 3:08
 */
?>
<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>

<link rel="stylesheet" href="/admin/scss/smSheet.css">
<script>
    $(document).ready(function(){

    });
</script>

<div id="content-wrapper">
    <div class="container-fluid">
        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.html">Server Configuration</a>
            </li>
            <li class="breadcrumb-item active">View</li>
        </ol>

        <h2>PHP CONFIG</h2>
        <?php
        ob_start();
        phpinfo();
        $info_arr = array();
        $info_lines = explode("\n", strip_tags(ob_get_clean(), "<tr><td><h2>"));
        $cat = "General";
        foreach($info_lines as $line) {
            preg_match("~<h2>(.*)</h2>~", $line, $title) ? $cat = $title[1] : null;
            if(preg_match("~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~", $line, $val)) {
                $info_arr[$cat][$val[1]] = $val[2];
            }
            else if(preg_match("~<tr><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td><td[^>]+>([^<]*)</td></tr>~", $line, $val)) {
                $info_arr[$cat][$val[1]] = array("local" => $val[2], "master" => $val[3]);
            }
        }

        // example:
        echo "<pre>".print_r($info_arr, 1)."</pre>";
        ?>
    <!-- /.container-fluid -->
</div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>

