<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 5:16
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
        $(".toSubscription").click(function(){location.href = "/web/pages/subscription.php";});
        $(".toSupport").click(function(){location.href = "/web/pages/contribution.php";});

        $(".jViewPublication").click(function(){
            var id = $(this).attr("id");
            location.href = "/web/pages/product.php?id=" + id;
        });
    });
</script>

<section id="banner" style="background-image: url('<?=$obj->fileShowPath.$CONST_IMAGE["L_IMG_HOME_BANNER"]?>');" exposureSet="SECTION_HOME_BANNER">
    <h1><?=$HOME_ELEMENTS["top"]["title"]?></h1>
    <p><?=$HOME_ELEMENTS["top"]["subTitle"]?></p>
    <a href="#" class="bannerLink toSubscription"><?=$HEADER_ELEMENTS["headerMenu_subscribe"]?></a>
    <a href="#" class="bannerLink toSupport"><?=$HEADER_ELEMENTS["headerMenu_support"]?></a>
</section>

<section class="wrapper special books" exposureSet="SECTION_HOME_BOOKS">
    <div class="inner tinySection">
        <header>
            <h2><?=$HOME_ELEMENTS["mid"]["title"]?></h2>
            <p>
                <?=$HOME_ELEMENTS["mid"]["subTitle"]?>
            </p>
        </header>
        <div class="flex flex-4">
            <?foreach($publicationList as $publicationItem){?>
                <div class="box person jViewPublication" id="<?=$publicationItem["publicationId"]?>">
                    <div class="image fader">
                        <img src="<?=$publicationItem["imgPath"] != "" ? $obj->fileShowPath . $publicationItem["imgPath"] : ""?>" alt="Person 1" />
                        <div class="overlayT">
                            <div class="text">제품보기</div>
                        </div>
                    </div>
                    <div class="desc">
                        <h3><?=$publicationItem["name"]?></h3>
                        <p><s><?=$publicationItem["price"]?></s> <?=$publicationItem["discounted"]?></p>
                    </div>
                </div>
            <?}?>
<!--            <div class="box person">-->
<!--                <div class="image fader">-->
<!--                    <img src="/web/images/testBook.png" alt="Person 2" />-->
<!--                    <div class="overlayT">-->
<!--                        <div class="text">제품보기</div>-->
<!--                    </div>-->
<!--                </div>-->
<!--                <div class="desc">-->
<!--                    <h3>OYB_맥체인 / 새번역 (+NIV)</h3>-->
<!--                    <p><s>₩2,500</s> ₩1,500</p>-->
<!---->
<!--                </div>-->
<!--            </div>-->
        </div>
    </div>
</section>

<section exposureSet="SECTION_HOME_PHRASE" class="wrapper special sectionCover" style="background-image: url('<?=$obj->fileShowPath.$CONST_IMAGE["L_IMG_HOME_PHRASE"]?>');">
    <h1><?=$HOME_ELEMENTS["midBottom"]["title"]?></h1>
    <p><?=$HOME_ELEMENTS["midBottom"]["subTitle"]?></p>
</section>

<section id="three" class="wrapper special darkSection" exposureSet="SECTION_HOME_SUPPORT">
    <div class="inner tinySection">
        <div class="flex flex-2 darkness">
            <article>
                <div class="empLine"></div>
                <h2><?=$HOME_ELEMENTS["bottom"]["title"]?></h2>
                <p><?=$HOME_ELEMENTS["bottom"]["text"]?></p>
                <footer>
                    <a href="#" class="bottomLink toSupport"><?=$HEADER_ELEMENTS["headerMenu_support"]?> >></a>
                </footer>
            </article>
            <article>
                <div class="image fit">
                    <img src="<?=$obj->fileShowPath.$CONST_IMAGE["L_IMG_HOME_BOTTOM"]?>" alt="Pic 02" />
                </div>
            </article>
        </div>
    </div>
</section>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
