<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 6:31
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebSubscription.php";?>
<?
    $obj = new WebSubscription($_REQUEST);
    $item = $obj->publicationDetail();

    if($_COOKIE["btLocale"] == "kr") {
        $currency = "₩";
        $decimal = 0;
    }
    else{
        $currency = "$";
        $decimal = 2;
    }
?>

<script>
    $(document).ready(function(){

        $(document).on("click", ".jToggleOn", function(){
            $(".jCollapse").fadeIn();
            $(this).removeClass("jToggleOn").addClass("jToggleOff");
            $(this).text("접기");
        });

        $(document).on("click", ".jToggleOff", function(){
            $(".jCollapse").fadeOut();
            $(this).removeClass("jToggleOff").addClass("jToggleOn");
            $(this).text("자세히 보기");
        });

        $(".jSubscribe").click(function(){
            var cnt = $("#quantity").val();
            var type = $(this).attr("type");
            location.href = "/web/pages/subscribeDetail.php?id=<?=$_REQUEST["id"]?>&cnt=" + cnt + "&type=" + type;
        });
    });
</script>

<section class="wrapper special books">
    <div class="inner">
        <h5 class="dirHelper">메인 / <?=$item["name"]?></h5>
        <div class="row uniform" >
            <div class="6u 12u$(small)">
                <div class="image fit">
                    <img src="<?=$item["imgPath"] != "" ? $obj->fileShowPath . $item["imgPath"] : ""?>"
                         style="margin : 0 auto; max-width:15em;"
                    />
                </div>
            </div>
            <div class="6u 12u$(small) align-left" >
                <h2 class="nanumGothic" style="color:black; font-size:1.8em;"><?=$item["name"]?></h2>
                <h3 class="nanumGothic" style="color:black;">
                    개인: <?=$currency . number_format($item["price"], $decimal)?>(배송비 포함)
                    <br/>
                    단체: <?=$currency . number_format($item["discounted"], $decimal)?>(택배비 3,000원)
                </h3>
                <p class="nanumGothic" style="color:black;"><?=$item["subTitle"]?></p>
                <br/>
                <p class="nanumGothic jCollapse" style="color:black; display: none;">
                    <?=$item["description"]?>
                </p>
                <a href="#" class="nanumGothic viewDetail jToggleOn">자세히 보기</a>
                <br/><br/>
                <p class="nanumGothic">수량 &nbsp;<input type="number" class="nanumGothic quantity" name="quantity" id="quantity" value="1" /></p>

                <a href="#" class="roundButton detailSubscribe nanumGothic jSubscribe" type="1">개인구독 신청</a>
                <br/><br/>
                <a href="#" class="roundButton detailSubscribe nanumGothic jSubscribe" type="2">단체구독 신청</a>
            </div>
        </div>


    </div>
    <h5 style="margin-top : 1em;" class="dirHelper"><?=$item["name"]?> / 상품설명</h5>
    <div class="detailWrapper">
        <div class="image fit">
            <!--                <img src="/web/images/product_info.png" />-->
            <img src="<?=$item["imgPathIntro"] != "" ? $obj->fileShowPath . $item["imgPathIntro"] : ""?>" />
        </div>
    </div>
</section>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
