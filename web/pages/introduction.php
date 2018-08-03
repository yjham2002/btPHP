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
            <h2 class="pageTitle">소개하기</h2>
            <div class="empLineT"></div>
        </header>
    </div>
</section>

<section class="wrapper special sectionCover floating" style="background-image: url('/web/images/intro_main.jpg');">
    <a href="#toGo" class="jSmoothScroll baseAlign">
        <img class="small circleBtn" src="/web/images/btn_down.png" />
    </a>
</section>

<!-- Two -->
<section id="toGo" class="wrapper special books">
    <div class="inner">
        <header>
            <h2>바이블타임의 시작</h2>
            <div class="row small">
                <div class="6u adjacent"><span class="image fit"><img src="/web/images/intro_s_01.jpg" alt="" /></span></div>
                <div class="6u adjacent"><span class="image fit"><img src="/web/images/intro_s_02.jpg" alt="" /></span></div>
            </div>
        </header>

        <div class="row">
            <!-- Break -->
            <div class="4u 12u$(medium)">
                <h3><text style="color:black;">바이블타임은</text><br />기독교 국가<text style="color:black;">에서 시작되었습니다.</text></h3>
            </div>
            <div class="7u 12u$(medium)">
                <p class="align-left">
                    바이블타임은 전세계에 성경 읽는 시대를 열기 위해 힘쓰는 초교파 국제 선교단체입니다.<br />
                    교회개척, 구제, 의료, 중보기도 등 많은 사역이 있지만, 구성원들이 성경을 읽지 않는다면 어떤 열매도 맺을 수 없습니다.<br />
                    이에 따라 바이블타임은 모든 사역의 기간사역(infrastructured ministry)으로서 모든 국가에 누구나 쉽게 하나님 말씀을 매일 먹고,<br />
                    매년 성경을 일독할 수 있는 토대를 구축해 나가려고 합니다.<br />
                    이를 위해 함께 동역할 분은 언제나 환영합니다.
                </p>
            </div>
        </div>

        <hr />
        <img src="/web/images/cross_logo.png" />
        <div class="4u 12u$(medium) autoMargin">
            <p class="nanumGothic" style="color:black;"><br />예수께서 제자들을 불러 이르시되 내가 무리를 불쌍히 여기노라 그들이 나와 함께 있은 지
                이미 사흘이매 먹을 것이 없도다 길에서 기진할까 하여 굶겨 보내지 못하겠노라</>
            <p class="nanumGothic">마태복음 15:32</p>
        </div>

    </div>
</section>

<section class="wrapper special sectionCover floatingS" style="background-image: url('/web/images/intro_middle.jpg');">
    <h1 style="color:white; font-size:3.0em; margin:0; line-height:1.3em;">바이블타임 역사</h1>
    <div class="empLine vertical"></div>
    <h3 class="nanumGothic" style="color:white; font-size:1.7em">최초로 성경을 전한 한국인<br />"매서인"을 아시나요?</h3>
</section>

<!-- Three -->
<section id="toGo" class="wrapper special books">
    <div class="inner">
        <header>
            <br/>
            <h2>성경을 위한 희생</h2>
            <h3 style="color:black;">"바이블타임은 <text class="colorPrimary">성경</text>이 필요한 곳 끝까지 전달합니다."</h3>
            <div class="row small">
                <!-- 필히, 관리자에서 해당 이미지 2개는 사이즈가 동일하게 업로드하도록 안내해야 함 -->
                <div class="6u adjacent"><span class="image fit"><img src="/web/images/intro_mid_01.jpg" alt="" /></span></div>
                <div class="6u adjacent"><span class="image fit"><img src="/web/images/intro_mid_02.jpg" alt="" /></span></div>
            </div>
        </header>
        <div class="row">
            <!-- Break -->
            <div class="4u 12u$(medium) align-center">
                <h3><text style="color:black;">매서인의 희생적인 성경 나눔을<br/>현재 바이블타임이 이어받아 나눕니다.</text></h3>
            </div>
            <div class="7u 12u$(medium)">
                <p class="align-left">
                    1882년 누가복음과 요한복음을 필두로 만주에서 인쇄되어 나오기 시작한 한글 쪽복음은 은밀하게 한국에 유입되어 읽히기 시작했다.<br/>
                    아직은 ‘쇄국’의 분위기가 가시지 않았기 때문에 성경 반입과 반포는 목숨을 내건 한국인 신자들에 의해 이루어졌다. 주로 의주사람이었던 이들 초기 전도인들을 ‘매서인’ 혹은 ‘권서’라 불렀다.<br/>
                    성경을 한국에 들여오는 일은 어렵고도 위험한 일이었다. 그럼에도 초기 한국인 매서인들은 성경을 국내에 들여오기 위해 목숨을 내건 모험을 감행했다.<br/><br/>
                    목숨을 내건 매서인들의 활약으로 이 성경들이 압록강과 북부 서해안 지역에 반포되어 읽혔고, 170명의 세례 교인이 생겨났다. 이들은 모두 성경을 ‘잿물’처럼 마시고 깨끗함을 입은 자들이자 한국 교회의 풍요를 기약하는 ‘비료’였다.
                </p>
            </div>
        </div>
</section>



<section class="wrapper special books" style="padding : 1em 0;">
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
        <img src="/web/images/cross_logo.png" />
        <div class="4u 12u$(medium) autoMargin">
            <p class="nanumGothic" style="color:black;"><br />예수께서 제자들을 불러 이르시되 내가 무리를 불쌍히 여기노라 그들이 나와 함께 있은 지
                이미 사흘이매 먹을 것이 없도다 길에서 기진할까 하여 굶겨 보내지 못하겠노라</>
            <p class="nanumGothic">마태복음 15:32</p>
        </div>


    </div>
</section>

<section class="wrapper special sectionCover floatingS" style="background-image: url('/web/images/intro_bottom.jpg');">
    <h1 style="color:white; font-size:2.5em; margin:0; line-height:1.3em;">인사말</h1>
    <div class="empLineT white"></div>
    <h3 class="nanumGothic" style="color:white; font-size:1.3em">바이블타임을 방문해 주신 분들께 감사드립니다.</h3>

</section>

<section class="wrapper speical books">
    <div class="inner">
        <div class="row">
            <!-- Break -->
            <div class="4u 12u$(medium) align-center">
                <h3><text style="color:black;">말씀의 놀라움</text></h3>
            </div>
            <div class="7u 12u$(medium)">
                <p class="align-left">
                    바이블타임은 전세계에 성경 읽는 시대를 열기 위해 힘쓰는 초교파 국제 선교단체입니다.<br />
                    교회개척, 구제, 의료, 중보기도 등 많은 사역이 있지만, 구성원들이 성경을 읽지 않는다면 어떤 열매도 맺을 수 없습니다.<br />
                    이에 따라 바이블타임은 모든 사역의 기간사역(infrastructured ministry)으로서 모든 국가에 누구나 쉽게 하나님 말씀을 매일 먹고,
                    매년 성경을 일독할 수 있는 토대를 구축해 나가려고 합니다.<br />
                    이를 위해 함께 동역할 분은 언제나 환영합니다.<br /><br />
                    ​바이블타임선교회 회장 <text style="font-size:1.4em; color:black; font-weight:700;">전재덕</text> 드림
                </p>
            </div>
        </div>
    </div>
</section>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
