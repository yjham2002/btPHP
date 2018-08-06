<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 6:14
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
$obj = new webUser($_REQUEST);
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
                        $(".collapsible").eq(e).addClass("inactive");
                        hrTag.hide();
                    }
                }
            }
        });
    });
</script>

<section class="wrapper special books">
    <div class="inner">
        <header>
            <h2 class="pageTitle"><?=$FAQ_ELEMENTS["title"]?></h2>
            <div class="empLineT"></div>
            <p><?=$FAQ_ELEMENTS["subTitle"]?></p>
        </header>

        <input type="text" class="fancy" id="searchBox" placeholder="Looking for something?" />

        <br/>

        <div class="collapsible">
            <a class="queryWord">새로운 질문을 추가하려면 어떻게 해야 하나요?</a>
            <a class="opener"></a>
        </div>
        <div class="colContent">
            <br/>
            <p class="queryAns">이 곳에 첫번째 답변 내용이 삽입됩니다.</p>
        </div>
        <hr class="thinLine" />
        <div class="collapsible">
            <a class="queryWord">메뉴 이동은 어떻게 하나요?</a>
            <a class="opener"></a>
        </div>
        <div class="colContent">
            <br/>
            <p class="queryAns">이 곳에 메뉴 관련 답변 내용이 삽입됩니다.</p>
        </div>
        <hr class="thinLine" />
        <div class="collapsible">
            <a class="queryWord">메뉴는 어디에 있나요?</a>
            <a class="opener"></a>
        </div>
        <div class="colContent">
            <br/>
            <p class="queryAns">이 곳에 메뉴 관련 답변 내용이 삽입됩니다.</p>
        </div>
        <hr class="thinLine" />
        <div class="collapsible">
            <a class="queryWord">지금은 몇 시 인가요?</a>
            <a class="opener"></a>
        </div>
        <div class="colContent">
            <br/>
            <p class="queryAns">이 곳에 4번째 답변 내용이 삽입됩니다.</p>
        </div>
        <hr class="thinLine" />
    </div>
</section>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
