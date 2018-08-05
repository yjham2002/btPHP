<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 5:16
 */
?>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>

<!-- Banner -->
<section id="banner" style="background-image: url('/web/images/banner.jpg');">
    <h1><?=$HOME_ELEMENTS["top"]["title"]?></h1>
    <p><?=$HOME_ELEMENTS["top"]["subTitle"]?></p>
    <a href="#" class="bannerLink"><?=$HEADER_ELEMENTS["headerMenu_subscribe"]?></a>
    <a href="#" class="bannerLink"><?=$HEADER_ELEMENTS["headerMenu_support"]?></a>
    <!--<div class="bannerScreen">
        <img src="images/bb_banner_cut.png" class="bannerImg" />
    </div>-->

</section>

<!-- Two -->
<section class="wrapper special books">
    <div class="inner">
        <header>
            <h2><?=$HOME_ELEMENTS["mid"]["title"]?></h2>
            <p>
                <?=$HOME_ELEMENTS["mid"]["subTitle"]?>
            </p>
        </header>
        <div class="flex flex-4">
            <div class="box person">
                <div class="image fader">
                    <img src="/web/images/testBook.png" alt="Person 1" />
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
                    <img src="/web/images/testBook.png" alt="Person 2" />
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
                    <img src="/web/images/testBook.png" alt="Person 3" />
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
                    <img src="/web/images/testBook.png" alt="Person 4" />
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
                    <img src="/web/images/testBook.png" alt="Person 1" />
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
                    <img src="/web/images/testBook.png" alt="Person 2" />
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
                    <img src="/web/images/testBook.png" alt="Person 3" />
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
                    <img src="/web/images/testBook.png" alt="Person 4" />
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

<!-- Three -->
<section class="wrapper special sectionCover" style="background-image: url('/web/images/section_cover.jpg');">
    <h1>사람이 빵으로만 살것이 아니라,<br/>하나님의 입에서 나오는 모든 말씀으로 살것이다</h1>
    <p>- 마태복음 4장 4절 -</p>
</section>

<section id="three" class="wrapper special darkSection">
    <div class="inner">
        <!--<header class="align-center">
            <h2>Nunc Dignissim</h2>
            <p>Aliquam erat volutpat nam dui </p>
        </header>-->
        <div class="flex flex-2 darkness">
            <article>
                <div class="empLine"></div>
                <h2>어둠 속에 있는 아이들에게 성경을 보내주세요!</h2>
                <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
                <footer>
                    <a href="#" class="bottomLink">후원하기 >></a>
                </footer>
            </article>
            <article>
                <div class="image fit">
                    <img src="/web/images/bb_dark_cover.jpg" alt="Pic 02" />
                </div>
            </article>
        </div>
    </div>
</section>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
