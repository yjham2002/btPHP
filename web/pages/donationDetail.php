<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Uncallable.php";?>
<?
    $selected = $_REQUEST["state"] == "" ? "SS" : $_REQUEST["state"];

    $obj = new WebUser($_REQUEST);
    $uc = new Uncallable($_REQUEST);

    $nations = $uc->getNationsByCode($selected, $country_code);

    $danglingNo = 1;
    if($_REQUEST["nid"] == "" && sizeof($nations) > 0) $danglingNo = $nations[0]["id"];
    $nationSelected = $_REQUEST["nid"] == "" ? $danglingNo : $_REQUEST["nid"];

    $continent = $uc->getContinentCode($nationSelected);
    if($_REQUEST["nid"] != "") {
        $selected = $continent;
        $nations = $uc->getNationsByCode($selected, $country_code);
    }

    $current = $_REQUEST["id"] == "" ? $uc->getLastSupportNumber($nationSelected) : $_REQUEST["id"];
    $article = $uc->getSupport($current, $country_code);
    $lastList = $uc->getLastStories($nationSelected, $country_code);
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

        var nid = "<?=$_REQUEST["nid"]?>";
        var sid = "<?=$_REQUEST["id"]?>";

        $(".lastStory").click(function(){
            var parentId = $(this).attr("sid");
            location.href = "/web/pages/donationDetail.php?id=" + parentId + "&nid=" + nid;
        });

        $(".jNation").click(function(){
            var parentId = $(this).attr("nid");
            location.href = "/web/pages/donationDetail.php?id=" + "" + "&nid=" + parentId;
        });

        var selected="<?=$selected?>"; // NA, SA, SS, EU, NS, OC, ME, AF 대륙 구분 코드
        // 대륙을 누르면 ?state=SA 와 같이 링크됨 저 정보를 php로 추출하여 이 곳에 삽입

        simplemaps_continentmap_mapdata.state_specific[selected].color=map_const.active_color;

        showDivs(slideIndex);

        $(".jSupport").click(function(){
            var id = $(this).attr("id");
            location.href = "/web/pages/supportDetail.php?id=" + id;
        });
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
                        <? for($e = 0; $e < sizeof($nations); $e++){
                            $item = $nations[$e];
                            ?>
						<div class="3u 12u$(small)">
							<input type="checkbox" class="jNation" id="con_<?=$e?>" nid="<?=$item["id"]?>" name="con_<?=$e?>" <?=$item["id"] == $nationSelected ? "CHECKED disabled" : ""?> >
							<label for="con_<?=$e?>"><?=$item["locName"]?></label>
						</div>
                        <? } ?>
					</div>
				
				</div>
			</section>

    <?if($current == 0){}
        else{
    ?>
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
                        <img src="<?=$obj->fileShowPath.$article["titleImg"]?>" />
                    </div>
                    <a class="align-right jSupport" href="#" id="<?=$article["parentId"]?>">
                        <img class="circleBtn" src="../images/btn_support.png" />
                    </a>
                </div>
                <div class="8u 12u$(medium)">
                    <p class="align-left nanumGothic">
                        <?=$article["smTitle"]?>
                    </p>
                    <h2 class="align-left nanumGothic"><?=$article["Title"]?></h2>
                    <p class="align-left nanumGothic">
                        <?=$article["subTitle"]?>
                    </p>
                    <p class="align-left nanumGothic small-primary">목표 <?=$article["goal"]?></p>
                    <div class="w3-light-grey">
                        <div class="w3-container w3-oyellow w3-center" style="width:25%">&nbsp;</div>
                    </div>

                    <p></p>

                    <div class="box alt">
                        <div class="empLineT" style="margin : 0 0 10px 0;"></div>
                        <div class="row 50% uniform">
                            <p class="align-left">
                                <?=$article["content"]?>
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
                <?if($article["imgPath1"] != ""){?><img class="mySlides" src="<?=$obj->fileShowPath.$article["imgPath1"]?>" style="width:100%"><?}?>
                <?if($article["imgPath2"] != ""){?><img class="mySlides" src="<?=$obj->fileShowPath.$article["imgPath2"]?>" style="width:100%"><?}?>
                <?if($article["imgPath3"] != ""){?><img class="mySlides" src="<?=$obj->fileShowPath.$article["imgPath3"]?>" style="width:100%"><?}?>
                <?if($article["imgPath4"] != ""){?><img class="mySlides" src="<?=$obj->fileShowPath.$article["imgPath4"]?>" style="width:100%"><?}?>
                <?if($article["imgPath5"] != ""){?><img class="mySlides" src="<?=$obj->fileShowPath.$article["imgPath5"]?>" style="width:100%"><?}?>
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
                <? for($ee = 0; $ee < sizeof($lastList); $ee++){ ?>
                <div class="2u 12u$(medium)">
                    <div class="image fit lastStory" style="padding : 1em;" sid="<?=$lastList[$ee]["parentId"]?>">
                        <img src="<?=$obj->fileShowPath.$lastList[$ee]["titleImg"]?>" />
                    </div>
                </div>
                <? } ?>

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
            <?}?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>