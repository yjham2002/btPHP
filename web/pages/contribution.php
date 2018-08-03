<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 6:06
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
$obj = new webUser($_REQUEST);
?>
<script>
    $(document).ready(function(){

    });
</script>
<div class="image fit">
    <img src="/web/images/contribution_main.jpg" />
</div>

<section class="wrapper special">
    <div class="inner">
        <div class="row">
            <!-- Break -->
            <div class="3u 12u$(medium)">
                <h2>페루<text style="color:black;">에서 온 편지</text></h2>
            </div>
            <div class="6u 12u$(medium)">
                <p class="align-left">
                    페루의 아레끼빠(Arequipa)라는 작은 도시에 위치한 또레 뿌에르떼(Torre Fuerte:견고한 망대)라는 고아원이 있습니다.
                    이 고아원에서는 여자아이들 40여명만 양육하고 있습니다.
                    <br />
                    아이들은 매일 아침 등교준비로 매우 분주하답니다.
                    그런데 이 아이들이 더 분주한 이유가 있는데 그것은 바로 아침 식사 전 더 이른 시간에 한 번 더 밥을 먹기 때문이죠.
                    이 아이들의 첫 끼는 바로 BibleTime으로 하나님의 말씀을 먹는 것입니다.
                    <br />
                    40명의 아이들은 다시 7~8 명씩 한 반을 이루고 있고, 각 반 선생님들과 매일 아침 식사 전에 성경을 읽고, 기도로 하루를 시작합니다.
                    이 시간이 첫 번째 식사 시간 입니다.
                    그래서 또레 뿌에르떼의 아이들은 하루 네 번 밥을 먹습니다.
                    <br />
                    이 아이들의 첫 끼, 첫 식사를 후원해 주시는 모든 분들께 진심으로 감사드립니다
                </p>
                <div class="box alt">
                    <div class="row 50% uniform">
                        <div class="4u"><span class="image fit"><img src="/web/images/con_01.png" alt="" /></span></div>
                        <div class="4u"><span class="image fit"><img src="/web/images/con_02.png" alt="" /></span></div>
                        <div class="4u"><span class="image fit"><img src="/web/images/con_03.png" alt="" /></span></div>
                    </div>
                </div>
            </div>
            <div class="3u$ 12u$(medium)">
                <a href="#"><img class="circleBtn" src="/web/images/btn_detail.png" /></a>
                <a href="#"><img class="circleBtn" src="/web/images/btn_support.png" /></a>
            </div>
        </div>
    </div>

</section>

<!-- Three -->
<section class="wrapper special slim">
    <h2>내가 나눈 사랑<text style="color:black;">은 어떻게 전해질까요?</text></h2>
    <div class="image fit slim">
        <img src="/web/images/contribution_bot.jpg" />
    </div>
</section>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
