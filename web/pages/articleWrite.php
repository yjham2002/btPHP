<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 16.
 * Time: PM 2:27
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebBoard.php";?>
<?
$obj = new webBoard($_REQUEST);
$categoryInfo = $obj->getCategoryInfo();
$info = $obj->getArticleInfo();
?>
<script>
    $(document).ready(function(){
        $("[name=imgFile]").change(function(){
            readURL(this);
            $("#imgPath").val("");
        });

        function readURL(input){
            if (input.files && input.files[0]){
                var reader = new FileReader();
                reader.onload = function(e){
                    $(".jImg").attr("src", e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $(".jSave").click(function(){
            var ajax = new AjaxSubmit("/route.php?cmd=WebBoard.saveArticle", "post", true, "json", "#form");
            ajax.send(function(data){
                // if(data.returnCode === 1) history.back();
                // else alert("이미지 저장 실패");
            });
        });
    });
</script>

<form method="post" id="form" action="#" enctype="multipart/form-data">
    <input type="hidden" name="boardTypeId" value="<?=$_REQUEST["categoryId"]?>" />
    <section class="wrapper special books">
        <div class="inner">
            <h5 class="dirHelper">BibleTime 나눔 > 게시판명 > 게시글명</h5>
            <div class="articleWrapper align-left">
                <table class="alt white">
                    <tr>
                        <td class="nanumGothic" style="width:3.2em;">
                            <div class="profileImage"><img src="/web/images/pic03.jpg" /></div>
                        </td>
                        <td>길동 홍</td>
                        <td class="smallIconTD" style="text-align:right">
                            <a href="#"><img src="/web/images/img_context.png" width=20 /></a>
                        </td>
                    </tr>
                </table>
                <input class="smallTextBox" type="text" name="title" id="title" placeholder="게시글 제목 입력" />
                <input type="hidden" name="imgPath" value="<?=$item["imgPath"]?>"/>
                <div class="image fit"><img class="jImg" src="" /></div>
                <input type="file" class="custom-file-input" name="imgFile" id="inputGroupFile01" style="margin-bottom: 2vh">
                <textarea name="content" placeholder="게시물 내용 입력" style="height:20vh;"></textarea>
            </div>
        </div>

        <a href="#" class="roundButton detailSubscribe nanumGothic jSave">등록</a>
    </section>
</form>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
