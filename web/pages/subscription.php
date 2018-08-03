<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 6:32
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

<section class="wrapper special books">
    <div class="inner">
        <header>
            <h2 class="pageTitle">구독하기</h2>
            <div class="empLineT"></div>
            <div class="image fit thin" style="background-image: url('/web/images/sub_main.jpg');">
            </div>
        </header>
        <div class="flex flex-4">
            <div class="box person">
                <div class="image fader">
                    <img class="scalable" src="/web/images/testBook.png" alt="Person 1" />
                    <div class="overlayT">
                        <div class="text">제품보기</div>
                    </div>
                </div>
                <div class="desc">
                    <h3>Note</h3>
                    <p><s>₩2,500</s> ₩1,500</p>

                </div>
            </div>
            <div class="box person">
                <div class="image fader">
                    <img class="scalable" src="/web/images/testBook.png" alt="Person 1" />
                    <div class="overlayT">
                        <div class="text">제품보기</div>
                    </div>
                </div>
                <div class="desc">
                    <h3>OYB_맥체인 / 새번역 (+NIV)</h3>
                    <p><s>₩2,500</s> ₩1,500</p>

                </div>
            </div>
            <div class="box person">
                <div class="image fader">
                    <img class="scalable" src="/web/images/testBook.png" alt="Person 1" />
                    <div class="overlayT">
                        <div class="text">제품보기</div>
                    </div>
                </div>
                <div class="desc">
                    <h3>OYB_연대기 / 새번역 (+NIV)</h3>
                    <p><s>₩2,500</s> ₩1,500</p>

                </div>
            </div>
            <div class="box person">
                <div class="image fader">
                    <img class="scalable" src="/web/images/testBook.png" alt="Person 1" />
                    <div class="overlayT">
                        <div class="text">제품보기</div>
                    </div>
                </div>
                <div class="desc">
                    <h3>OYB_클래식 / 개역개정 (+ESV)</h3>
                    <p><s>₩2,500</s> ₩1,500</p>

                </div>
            </div>
            <div class="box person">
                <div class="image fader">
                    <img class="scalable" src="/web/images/testBook.png" alt="Person 1" />
                    <div class="overlayT">
                        <div class="text">제품보기</div>
                    </div>
                </div>
                <div class="desc">
                    <h3>X2 / 개역개정 (+NIV)</h3>
                    <p><s>₩2,500</s> ₩1,500</p>

                </div>
            </div>
            <div class="box person">
                <div class="image fader">
                    <img class="scalable" src="/web/images/testBook.png" alt="Person 1" />
                    <div class="overlayT">
                        <div class="text">제품보기</div>
                    </div>
                </div>
                <div class="desc">
                    <h3>X3_OT / 새번역 (+ESV)</h3>
                    <p><s>₩2,500</s> ₩1,500</p>

                </div>
            </div>
            <div class="box person">
                <div class="image fader">
                    <img class="scalable" src="/web/images/testBook.png" alt="Person 1" />
                    <div class="overlayT">
                        <div class="text">제품보기</div>
                    </div>
                </div>
                <div class="desc">
                    <h3>X3_NT / 새번역 (+ESV)</h3>
                    <p><s>₩2,500</s> ₩1,500</p>

                </div>
            </div>
            <div class="box person">
                <div class="image fader">
                    <img class="scalable" src="/web/images/testBook.png" alt="Person 1" />
                    <div class="overlayT">
                        <div class="text">제품보기</div>
                    </div>
                </div>
                <div class="desc">
                    <h3>NT / 개역개정 (+NT)</h3>
                    <p><s>₩2,500</s> ₩1,500</p>

                </div>
            </div>
        </div>
    </div>
</section>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
