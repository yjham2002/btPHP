<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
$obj = new webUser($_REQUEST);
?>

<!-- 분리 영역 시작 -->
<script src="/web/assets/js/mapdata.js"></script>
<script src="/web/assets/js/continentmap.js"></script>
<script>
    $(document).ready(function(){
        var selected="<?=$_REQUEST["state"]?>"; // NA, SA, SS, EU, NS, OC, ME, AF 대륙 구분 코드
        // 대륙을 누르면 ?state=SA 와 같이 링크됨 저 정보를 php로 추출하여 이 곳에 삽입
        simplemaps_continentmap_mapdata.state_specific[selected].color=map_const.active_color;
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

			<section class="wrapper special books">
				<div class="inner">
					<header>
						<div class="mapWrap">
							<div id="map" ></div>
						</div>
					</header>
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
										<div class="4u"><span class="image fit"><img src="images/con_01.png" alt="" /></span></div>
										<div class="4u"><span class="image fit"><img src="images/con_02.png" alt="" /></span></div>
										<div class="4u"><span class="image fit"><img src="images/con_03.png" alt="" /></span></div>
									</div>
								</div>
						</div>
						<div class="3u$ 12u$(medium)">
							<a href="#"><img class="circleBtn" src="images/btn_support.png" /></a>
						</div>
					</div>
				</div>
			</section>

			<div class="footerRibbon">
						<ul class="icons">
							<li><a href="#" class="iconT"><img src="images/icon_facebook.png" alt="Pic 02" /></a></li>
							<li><a href="#" class="iconT"><img src="images/icon_instagram.png" alt="Pic 02" /></a></li>
						</ul>
			</div>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>