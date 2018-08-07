<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 5:56
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebBoard.php";?>
<?

    $obj = new webBoard($_REQUEST);
    $categoryInfo = $obj->getCategoryInfo();
    $list = $obj->getArticleList();
?>
<script>
    $(document).ready(function(){
        $(".jView").click(function(){
            var id = $(this).attr("id");
            location.href = "/web/pages/articleDetail.php?categoryId=<?=$_REQUEST["categoryId"]?>&articleId=" + id;
        });
    });
</script>

<section class="wrapper special books" style="padding : 1.5em 0;">
    <div class="inner">
        <h5 class="dirHelper">BibleTime 나눔 > <?=$categoryInfo["name"]?></h5>
    </div>
</section>

<section class="wrapper special sectionCover floatingS" style="background-image: url('/web/images/intro_bottom.jpg');">
    <h1 style="color:white; font-size:2.8em; margin:0; line-height:1.3em;"><?=$categoryInfo["name"]?></h1>
    <div class="empLineT white"></div>
    <h3 class="nanumGothic" style="color:white; font-size:1.3em"><?=$categoryInfo["subTitle"]?></h3>
</section>

<!-- Two -->
<section class="wrapper special books">
    <div class="inner">
        <div class="row inner">
            <input type="text" class="fancy" id="searchBox" placeholder="검색어를 입력하세요" style="width: 18em; font-size:0.9em;" />
            <a href="#" style="margin-top:0.8em;"><img src="/web/images/img_search.png" width="20px"/></a>
        </div>
        <br/>
        <div class="table-wrapper white">
            <table class="alt white list">
                <tbody>
                <tr>
                    <td></td>
                    <td>제목</td>
                    <td class="smallIconTD"><a><img src="/web/images/icon_comment.png" width="20px"/></a></td>
                    <td class="smallIconTD"><a><img src="/web/images/icon_like.png" width="20px"/></a></td>
                    <td class="smallIconTD"><a><img src="/web/images/icon_view.png" width="20px"/></a></td>
                </tr>
                <?foreach($list as $item){?>
                    <tr class="jView" id="<?=$item["id"]?>">
                        <td>1</td>
                        <td>
                            <a>
                                <p><?=$item["title"]?></p>
                                <?=$item["userName"]?>
                            </a>
                        </td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                <?}?>
                </tbody>
            </table>
        </div>
    </div>
</section>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
