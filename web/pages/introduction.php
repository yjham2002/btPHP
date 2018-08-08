<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 6:21
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
$obj = new webUser($_REQUEST);
?>
<script>
    $(document).ready(function(){
        $(".jSmoothScroll").click(function(){
            if(this.hash !== ""){
                // Prevent default anchor click behavior
                event.preventDefault();

                // Store hash
                var hash = this.hash;

                // Using jQuery's animate() method to add smooth page scroll
                // The optional number (800) specifies the number of milliseconds it takes to scroll to the specified area
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                }, 800, function(){
                    // Add hash (#) to URL when done scrolling (default click behavior)
                    window.location.hash = hash;
                });
            }
        });
    });
</script>

<section class="wrapper slimTitle special books">
    <div class="inner">
        <header>
            <h2 class="pageTitle"><?=$INTRODUCTION_ELEMENTS["title"]?></h2>
            <div class="empLineT"></div>
        </header>
    </div>
</section>

<section class="wrapper special sectionCover floating" style="background-image: url('/web/images/intro_main.jpg');" exposureSet="SECTION_INTRO_BANNER">
    <a href="#toGo" class="jSmoothScroll baseAlign">
        <img class="small circleBtn" src="/web/images/btn_down.png" />
    </a>
</section>

<!-- Two -->
<section id="toGo" class="wrapper special books" exposureSet="SECTION_INTRO_START">
    <div class="inner">
        <header>
            <h2><?=$INTRODUCTION_ELEMENTS["start"]["title"]?></h2>
            <div class="row small">
                <div class="6u adjacent"><span class="image fit"><img src="/web/images/intro_s_01.jpg" alt="" /></span></div>
                <div class="6u adjacent"><span class="image fit"><img src="/web/images/intro_s_02.jpg" alt="" /></span></div>
            </div>
        </header>

        <div class="row">
            <!-- Break -->
            <div class="4u 12u$(medium)">
<!--                <h3><text style="color:black;">바이블타임은</text><br />기독교 국가<text style="color:black;">에서 시작되었습니다.</text></h3>-->
                <h3><text style="color:black;"><?=$INTRODUCTION_ELEMENTS["start"]["subTitle"]?></text></h3>
            </div>
            <div class="7u 12u$(medium)">
                <p class="align-left">
                    <?=$INTRODUCTION_ELEMENTS["start"]["text"]?>
                </p>
            </div>
        </div>

        <hr />
        <img src="/web/images/cross_logo.png" exposureSet="SECTION_INTRO_PHRASE_1" />
        <div class="4u 12u$(medium) autoMargin" exposureSet="SECTION_INTRO_PHRASE_1">
            <p class="nanumGothic" style="color:black;"><br />
                <?=$INTRODUCTION_ELEMENTS["phrase"]["text"]?>
            <p class="nanumGothic"><?=$INTRODUCTION_ELEMENTS["phrase"]["loc"]?></p>
        </div>

    </div>
</section>

<section class="wrapper special sectionCover floatingS" style="background-image: url('/web/images/intro_middle.jpg');" exposureSet="SECTION_INTRO_HISTORY" >
    <h1 style="color:white; font-size:3.0em; margin:0; line-height:1.3em;"><?=$INTRODUCTION_ELEMENTS["box"]["title"]?></h1>
    <div class="empLine vertical"></div>
    <h3 class="nanumGothic" style="color:white; font-size:1.7em"><?=$INTRODUCTION_ELEMENTS["box"]["text"]?></h3>
</section>

<!-- Three -->
<section id="toGo" class="wrapper special books" exposureSet="SECTION_INTRO_HISTORY_CONTENT">
    <div class="inner">
        <header>
            <br/>
            <h2><?=$INTRODUCTION_ELEMENTS["article"]["title"]?></h2>
<!--            <h3 style="color:black;">"바이블타임은 <text class="colorPrimary">성경</text>이 필요한 곳 끝까지 전달합니다."</h3>-->
            <h3 style="color:black;"><?=$INTRODUCTION_ELEMENTS["article"]["phrase"]?></h3>
            <div class="row small">
                <!-- 필히, 관리자에서 해당 이미지 2개는 사이즈가 동일하게 업로드하도록 안내해야 함 -->
                <div class="6u adjacent"><span class="image fit"><img src="/web/images/intro_mid_01.jpg" alt="" /></span></div>
                <div class="6u adjacent"><span class="image fit"><img src="/web/images/intro_mid_02.jpg" alt="" /></span></div>
            </div>
        </header>
        <div class="row">
            <!-- Break -->
            <div class="4u 12u$(medium) align-center">
                <h3><text style="color:black;"><?=$INTRODUCTION_ELEMENTS["article"]["subTitle"]?></text></h3>
            </div>
            <div class="7u 12u$(medium)">
                <p class="align-left">
                    <?=$INTRODUCTION_ELEMENTS["article"]["text"]?>
                </p>
            </div>
        </div>
</section>



<section class="wrapper special books" style="padding : 1em 0;" exposureSet="SECTION_INTRO_VISUAL_HISTORY">
    <div class="inner">
        <hr style="margin:0;" />
        <header style="margin:0;">
            <section id="conference-timeline">
                <!--<div class="timeline-start">Start</div>-->
                <div class="conference-center-line"></div>
                <div class="conference-timeline-content">
                    <!-- Article -->
                    <div class="timeline-article">
                        <div class="content-left-container">
                            <div class="horizontal-line"></div>
                            <div class="meta-date sticky"></div>
                            <div class="content-left">
                                <p>
                                    2018<br/>
                                    홈페이지 론칭 / ONE BODY 분사
                                    <!--<span class="article-number">01</span>-->
                                </p>
                            </div>
                            <!--<span class="timeline-author">John Doe</span>-->
                        </div>
                        <div class="meta-date">
                            <!--<span class="date">18</span>
                            <span class="month">APR</span>-->
                        </div>
                    </div>
                    <!-- // Article -->

                    <div class="timeline-article">

                        <div class="content-right-container">
                            <div class="horizontal-line"></div>
                            <div class="meta-date sticky"></div>
                            <div class="content-right">
                                <p>
                                    2017<br/>
                                    홈페이지 론칭 / ONE BODY 분사
                                </p>
                            </div>
                        </div>
                        <div class="meta-date">
                            <!--<span class="date">18</span>
                            <span class="month">APR</span>-->
                        </div>
                    </div>

                    <div class="timeline-article">
                        <div class="content-left-container">
                            <div class="horizontal-line"></div>
                            <div class="meta-date sticky"></div>
                            <div class="content-left">
                                <p>
                                    2016<br/>
                                    2016년 연혁
                                </p>
                            </div>
                        </div>
                        <div class="meta-date">
                        </div>
                    </div>

                    <div class="timeline-article">
                        <div class="content-right-container">
                            <div class="horizontal-line"></div>
                            <div class="meta-date sticky"></div>
                            <div class="content-right">
                                <p>
                                    2015<br/>
                                    2015년 연혁
                                </p>
                            </div>
                        </div>
                        <div class="meta-date">
                        </div>
                    </div>

                </div>
                <!--<div class="timeline-end">End</div>-->
            </section>
            <!-- // Vertical Timeline -->

        </header>

        <hr style="margin-top:0;" />
        <img src="/web/images/cross_logo.png" exposureSet="SECTION_INTRO_PHRASE_2" />
        <div class="4u 12u$(medium) autoMargin" exposureSet="SECTION_INTRO_PHRASE_2">
            <p class="nanumGothic" style="color:black;"><br />
                <?=$INTRODUCTION_ELEMENTS["secondPhrase"]["text"]?>
            <p class="nanumGothic"><?=$INTRODUCTION_ELEMENTS["secondPhrase"]["loc"]?></p>
        </div>


    </div>
</section>

<section exposureSet="SECTION_INTRO_GREETING_BANNER" class="wrapper special sectionCover floatingS" style="background-image: url('/web/images/intro_bottom.jpg');">
    <h1 style="color:white; font-size:2.5em; margin:0; line-height:1.3em;"><?=$INTRODUCTION_ELEMENTS["prologue"]["title"]?></h1>
    <div class="empLineT white"></div>
    <h3 class="nanumGothic" style="color:white; font-size:1.3em"><?=$INTRODUCTION_ELEMENTS["prologue"]["text"]?></h3>

</section>

<section class="wrapper speical books" exposureSet="SECTION_INTRO_GREETING_CONTENT">
    <div class="inner">
        <div class="row">
            <!-- Break -->
            <div class="4u 12u$(medium) align-center">
                <h3><text style="color:black;"><?=$INTRODUCTION_ELEMENTS["secondArticle"]["title"]?></text></h3>
            </div>
            <div class="7u 12u$(medium)">
                <p class="align-left">
                    <?=$INTRODUCTION_ELEMENTS["secondArticle"]["text"]?>
                </p>
            </div>
        </div>
    </div>
</section>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
