<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 6:14
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebBoard.php";?>
<?
    $obj = new WebBoard($_REQUEST);
    $list = $obj->faqList();
?>

<script>
    $(document).ready(function(){
        //collapse related script
        var coll = $(".collapsible");
        for (var i = 0; i < coll.length; i++){
            coll[i].addEventListener("click", function(){
                this.classList.toggle("active");
                var content = this.nextElementSibling;

                if (content.style.maxHeight)
                    content.style.maxHeight = null;
                else
                    content.style.maxHeight = content.scrollHeight + "px";
            });
        }

        //general scripts
        $("#searchBox").keyup(function(){
            var searchValue = $(this).val().trim();
            $(".collapsible").removeClass("inactive");
            $(".collapsible").next().next().show();
            if(searchValue == ""){

            }else{
                for(var e = 0; e < $(".collapsible").length; e++){
                    var query = $(".collapsible").eq(e).find(".queryWord").text();
                    var queryAns = $(".collapsible").eq(e).next().find(".queryAns").text();
                    var hrTag = $(".collapsible").eq(e).next().next();


                    if(query.indexOf(searchValue) == -1 && queryAns.indexOf(searchValue) == -1) {
                        console.log(query);
                        console.log(queryAns);
                        console.log(query.indexOf(searchValue));
                        console.log(e + $(".collapsible").eq(e).text());
                        $(".collapsible").eq(e).addClass("inactive");
                        hrTag.hide();
                    }
                    else{
                        $(".collapsible").eq(e).removeClass("inactive");
                    }
                }
            }
        });
    });
</script>

<section class="wrapper special books">
    <div class="inner">
        <header>
            <h2 class="pageTitle" exposureSet="SECTION_FAQ_BANNER"><?=$FAQ_ELEMENTS["title"]?></h2>
            <div class="empLineT" exposureSet="SECTION_FAQ_BANNER"></div>
            <p exposureSet="SECTION_FAQ_BANNER"><?=$FAQ_ELEMENTS["subTitle"]?></p>
        </header>

        <input type="text" class="fancy" id="searchBox" placeholder="Looking for something?" style="display: none;" />

        <br/>


        <hr class="thinLine" />
        <?foreach($list as $item){?>
            <div class="collapsible">
                <a class="queryWord"><?=$item["question"]?></a>
                <a class="opener"></a>
            </div>
            <div class="colContent">
                <br/>
                <p class="queryAns"><?=$item["content"]?></p>
            </div>
        <?}?>
    </div>
</section>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
