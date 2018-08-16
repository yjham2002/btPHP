<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 6:08
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
    $obj = new webUser($_REQUEST);
?>
<script>
    $(document).ready(function(){
        var code = "<?=$CODE?>";
        var path = "<?=$obj->fileShowPath?>";
        var ajax = new AjaxSender("/route.php?cmd=WebBoard.getBoardCategory", true, "json", new sehoMap().put("code", code));
        ajax.send(function(data){
            if(data.returnCode === 1){
                console.log(data.entity);
                for(var i=0; i<data.entity.length; i++){
                    var row = data.entity[i];
                    console.log(row);
                    var template = $("#template").html();
                    template= template.replace("#{id}", row.id);
                    if(row.imgPath != null) template = template.replace("#{path}", path + row.imgPath);
                    else template = template.replace("#{path}", "");
                    template = template.replace("#{name}", row.name);
                    if(row.subTitle == null) template = template.replace("#{subTitle}", "");
                    else template = template.replace("#{subTitle}", row.subTitle);
                    template = template.replace("#{viewCnt}", row.viewCnt);
                    template = template.replace("#{articleCnt}", row.articleCnt);

                    template = template.replace("<tbody>", "");
                    template = template.replace("</tbody>", "");
                    $(".target").append(template);
                }
            }
        });

        $(document).on("click", ".jView", function(){
            var id = $(this).attr("id");
            location.href = "/web/pages/articleList.php?categoryId=" + id;
        });

    });
</script>

<table id="template" style="display: none">
    <tr class="jView" id="#{id}">
        <td width="10%">
            <img src="#{path}"/>
        </td>
        <td width="50%">
            <a>
                <p>#{name}</p>
                #{subTitle}
            </a>
        </td>
<!--        <td width="15%">#{viewCnt}<br/>--><?//=$SHARE_ELEMENTS["common"]["viewText"]?><!--</td>-->
        <td width="15%">#{articleCnt}<br/><?=$SHARE_ELEMENTS["common"]["articleText"]?></td>
<!--        <td width="10%" style="text-align:center;">-->
<!--            <a><img src="/web/images/img_context.png" width="20px"/></a>-->
<!--        </td>-->
    </tr>
</table>



<section class="wrapper special books">
    <div class="inner">
        <h5 class="dirHelper"><?=$SHARE_ELEMENTS["title"]?></h5>
        <header>
            <h2 class="pageTitle" exposureSet="SECTION_DONATE_BANNER"><?=$SHARE_ELEMENTS["title"]?></h2>
            <div class="empLineT" exposureSet="SECTION_DONATE_BANNER"></div>
            <h3 class="pageSubTitle" exposureSet="SECTION_DONATE_BANNER"><?=$SHARE_ELEMENTS["subTitle"]?></h3>
        </header>
        <div class="table-wrapper white">
            <table class="alt white">
                <tbody class="target">

                </tbody>
            </table>
        </div>
    </div>
</section>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
