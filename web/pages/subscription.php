<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 6:32
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebSubscription.php";?>
<?
    $obj = new WebSubscription($_REQUEST);
    $publicationList = $obj->publicationList();
?>

<script>
    $(document).ready(function(){
        $(".jView").click(function(){
            var id = $(this).attr("id");
            location.href = "/web/pages/product.php?id=" + id;
        });
    });
</script>

<section class="wrapper special books">
    <div class="inner">
        <header exposureSet="SECTION_SUBSCRIBE_BANNER">
            <h2 class="pageTitle"><?=$SUBSCRIBE_ELEMENTS["title"]?></h2>
            <div class="empLineT"></div>
            <div class="image fit thin" style="background-image: url('/web/images/sub_main.jpg');">
            </div>
        </header>
        <div class="flex flex-4" exposureSet="SECTION_SUBSCRIBE_BOOKS">
            <?foreach($publicationList as $item){?>
                <div class="box person jView" id="<?=$item["publicationId"]?>">
                    <div class="image fader">
                        <img class="scalable" src="<?=$item["imgPath"] != "" ? $obj->fileShowPath . $item["imgPath"] : ""?>" alt="Person 1" />
                        <div class="overlayT">
                            <div class="text">제품보기</div>
                        </div>
                    </div>
                    <div class="desc">
                        <h3><?=$item["name"]?></h3>
                        <p><s><?=$item["price"]?></s> <?=$item["discounted"]?></p>
                    </div>
                </div>
            <?}?>
        </div>
    </div>
</section>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
