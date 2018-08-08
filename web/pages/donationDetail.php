<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
$obj = new webUser($_REQUEST);
?>

<!-- 분리 영역 시작 -->
    <link rel="stylesheet" href="/web/assets/css/w3.css" />
<script src="/web/assets/js/mapdata.js"></script>
<script src="/web/assets/js/continentmap.js"></script>
<script>
    var slideIndex = 1;

    function plusDivs(n) {
        showDivs(slideIndex += n);
    }

    function showDivs(n) {
        var i;
        var x = $(".mySlides");
        if (n > x.length) {slideIndex = 1;}
        if (n < 1) {slideIndex = x.length;}
        for (i = 0; i < x.length; i++) {
            x[i].style.display = "none";
        }
        x.eq(slideIndex-1).fadeIn();
        x[slideIndex-1].style.display = "block";
    }

    $(document).ready(function(){
        var selected="<?=$_REQUEST["state"]?>"; // NA, SA, SS, EU, NS, OC, ME, AF 대륙 구분 코드
        // 대륙을 누르면 ?state=SA 와 같이 링크됨 저 정보를 php로 추출하여 이 곳에 삽입
        if(selected == "") selected = "SS";
        simplemaps_continentmap_mapdata.state_specific[selected].color=map_const.active_color;

        showDivs(slideIndex);
    });
</script>
<!-- 분리 영역 종료 -->

		<!-- Two -->
			<section class="wrapper special books">
				<div class="inner">
					<header>
						<div class="mapWrap">
							<div id="map" ></div>
						</div>
					</header>
					
					<div class="row mapWrap">
						<div class="3u 12u$(small)">
							<input type="checkbox" id="con_1" name="con_1">
							<label for="con_1">중국</label>
						</div>
						<div class="3u 12u$(small)">
							<input type="checkbox" id="con_2" name="con_2">
							<label for="con_2">홍콩</label>
						</div>
						<div class="3u 12u$(small)">
							<input type="checkbox" id="con_3" name="con_3">
							<label for="con_3">필리핀</label>
						</div>
						<div class="3u 12u$(small)">
							<input type="checkbox" id="con_4" name="con_4">
							<label for="con_4">태국</label>
						</div>
						<div class="3u 12u$(small)">
							<input type="checkbox" id="con_5" name="con_5">
							<label for="con_5">미얀마</label>
						</div>
						<div class="3u 12u$(small)">
							<input type="checkbox" id="con_6" name="con_6">
							<label for="con_6">라오스</label>
						</div>
						<div class="3u 12u$(small)">
							<input type="checkbox" id="con_7" name="con_7">
							<label for="con_7">말레이시아</label>
						</div>
						<div class="3u 12u$(small)">
							<input type="checkbox" id="con_8" name="con_8">
							<label for="con_8">인도네시아</label>
						</div>
					</div>
				
				</div>
			</section>

    <section class="wrapper special books" style="padding : 0 !important;">
        <div class="inner">
            <header>
                <div class="mapWrap">
                    <div id="map" ></div>
                </div>
            </header>
            <div class="row">
                <!-- Break -->
                <div class="4u 12u$(medium)">
                    <div class="image fit" style="padding : 1em;">
                        <img src="../images/support_person.png" />
                    </div>
                    <a class="align-right" href="#"><img class="circleBtn" src="../images/btn_support.png" /></a>
                </div>
                <div class="8u 12u$(medium)">
                    <p class="align-left nanumGothic">
                        아시아 대륙을 선교하고 있습니다.
                    </p>
                    <h2 class="align-left nanumGothic">안녕하세요?<br/>저는 김철수 선교사입니다.</h2>
                    <p class="align-left nanumGothic">
                        우리 캄퐁츠낭우신교회에서는 야심찬 프로젝트를 하나 기획했습니다.
                        <br />
                        프로젝트명은 ‘오리나눔 프로젝트’입니다.
                    </p>
                    <p class="align-left nanumGothic small-primary">목표</p>
                    <div class="w3-light-grey">
                        <div class="w3-container w3-oyellow w3-center" style="width:25%">&nbsp;</div>
                    </div>

                    <p></p>

                    <div class="box alt">
                        <div class="empLineT" style="margin : 0 0 10px 0;"></div>
                        <div class="row 50% uniform">
                            <p class="align-left">
                                프로젝트의 첫 수혜자는 쩜란의 가정입니다.<br/>
                                쩜란은 5년 전 우리 교회에 출석한 이후 교회에서 숙식을 하며, 매일 새벽기도까지 참석하는 신실한 청소년입니다.<br/>
                                <br/>
                                그 뿐 아니라 쩜란은 우리 센터에서 관악단 단원으로 클라리넷도 연주하고 있습니다.<br/>
                                그래서 쩜란의 가정이 ‘오리나눔 프로젝트’의 첫 수혜자가 되었습니다.<br/>
                                ​<br/>
                                우리는 쩜란의 부모님께 무상으로 오리를 제공하되, 오직 한 가지 조건만을 제시했습니다.<br/>
                                그 조건은 교회출석이 아닌 BibleTime을 읽어야 한다는 것입니다.<br/>
                                쩜란의 아버지는 기꺼이 그렇게 하겠다고 하면서 BibleTime과 오리를 받았습니다.
                            </p>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>

    <section class="wrapper special books" style="padding-bottom : 0 !important;">
        <div class="inner">
            <header>
                <div style="margin : 0 2em;">
                    <div class="empLineT" style="margin : 0 1em 10px 0;"></div>
                    <h1 style="color:black;" class="nanumGothic align-left">Gallery</h1>
                </div>
            </header>
            <div class="w3-content w3-display-container">
                <img class="mySlides" src="../images/slide_1.png" style="width:100%">
                <img class="mySlides" src="../images/slide_2.png" style="width:100%">
                <img class="mySlides" src="../images/slide_3.png" style="width:100%">
                <button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094;</button>
                <button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">&#10095;</button>
            </div>
        </div>
    </section>

    <section class="wrapper special books" style="padding-bottom : 0 !important;">
        <div class="inner">
            <header>
                <div style="margin : 0 2em;">
                    <div class="empLineT" style="margin : 0 1em 10px 0;"></div>
                    <h1 style="color:black;" class="nanumGothic align-left">지난 이야기</h1>
            </header>
            <div class="row">
                <div class="2u 12u$(medium)">
                    <div class="image fit" style="padding : 1em;">
                        <img src="../images/support_person.png" />
                    </div>
                </div>
                <div class="2u 12u$(medium)">
                    <div class="image fit" style="padding : 1em;">
                        <img src="../images/support_person.png" />
                    </div>
                </div>
                <div class="2u 12u$(medium)">
                    <div class="image fit" style="padding : 1em;">
                        <img src="../images/support_person.png" />
                    </div>
                </div>
                <div class="2u 12u$(medium)">
                    <div class="image fit" style="padding : 1em;">
                        <img src="../images/support_person.png" />
                    </div>
                </div>
                <div class="2u 12u$(medium)">
                    <div class="image fit" style="padding : 1em;">
                        <img src="../images/support_person.png" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="wrapper special books">
        <div class="inner">
            <header>
                <div style="margin : 0 2em;">
                    <div class="empLineT" style="margin : 0 1em 10px 0;"></div>
                    <h1 style="color:black;" class="nanumGothic align-left">후원자</h1>
                    <div class="align-right">
                        <a href="#" class="roundButton grayButton" >더보기</a>
                    </div>
                </div>
            </header>
            <div class="row">
                <!-- Break -->
                <div class="3u 12u$(medium)">
                    <h2>김**<text style="font-size:0.6em;">&nbsp;&nbsp;후원자님</text></h2>
                    <p>응원 메시지가 삽입됩니다.</p>
                </div>
                <div class="3u 12u$(medium)">
                    <h2>김**<text style="font-size:0.6em;">&nbsp;&nbsp;후원자님</text></h2>
                    <p>응원 메시지가 삽입됩니다.</p>
                </div>
                <div class="3u 12u$(medium)">
                    <h2>김**<text style="font-size:0.6em;">&nbsp;&nbsp;후원자님</text></h2>
                    <p>응원 메시지가 삽입됩니다.</p>
                </div>
                <div class="3u 12u$(medium)">
                    <h2>김**<text style="font-size:0.6em;">&nbsp;&nbsp;후원자님</text></h2>
                    <p>응원 메시지가 삽입됩니다.</p>
                </div>
                <div class="3u 12u$(medium)">
                    <h2>김**<text style="font-size:0.6em;">&nbsp;&nbsp;후원자님</text></h2>
                    <p>응원 메시지가 삽입됩니다.</p>
                </div>
                <div class="3u 12u$(medium)">
                    <h2>김**<text style="font-size:0.6em;">&nbsp;&nbsp;후원자님</text></h2>
                    <p>응원 메시지가 삽입됩니다.</p>
                </div>
                <div class="3u 12u$(medium)">
                    <h2>김**<text style="font-size:0.6em;">&nbsp;&nbsp;후원자님</text></h2>
                    <p>응원 메시지가 삽입됩니다.</p>
                </div>
                <div class="3u 12u$(medium)">
                    <h2>김**<text style="font-size:0.6em;">&nbsp;&nbsp;후원자님</text></h2>
                    <p>응원 메시지가 삽입됩니다.</p>
                </div>
            </div>
        </div>
    </section>

			<div class="footerRibbon">
						<ul class="icons">
							<li><a href="#" class="iconT"><img src="../images/icon_facebook.png" alt="Pic 02" /></a></li>
							<li><a href="#" class="iconT"><img src="../images/icon_instagram.png" alt="Pic 02" /></a></li>
						</ul>
			</div>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>