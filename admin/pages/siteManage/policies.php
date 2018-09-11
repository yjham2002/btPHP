<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 2:09
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php";?>
<? include_once $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Uncallable.php";?>
<?
    $objm = new AdminMain($_REQUEST);
    $langList = $objm->getLangList();

    $uc = new Uncallable($_REQUEST);

?>

    <script>
        $(document).ready(function(){

            var lengthLimit = 10;

            bindLangPair();

            function convert(){
                var arr = $(".langValue");
                for(var e = 0; e < arr.length; e++){
                    var item = arr.eq(e);
                    // if(item.val().length > lengthLimit){
                    //
                    // }
                    var html = "<textarea class='form-control langValue' key="+ item.attr("key") +">" + item.val() + "</textarea>";
                    item.parent().html(html);
                }
                resizeTextArea();
            }

            function resizeTextArea(){
                var arr = $("textarea");
                for(var e = 0; e < arr.length; e++){
                    arr.eq(e).height(arr.eq(e).prop('scrollHeight'));
                }
            }

            function getLangPair(){
                var tds = $(".langKey");
                var inputs = $(".langValue");
                var langPair = new sehoMap();
                for(var e = 0; e < tds.length; e++){
                    langPair.put(tds.eq(e).attr("key"), inputs.eq(e).val());
                }

                return langPair;
            }

            function _bindLangPair(data){
                //empy every input
                $(".langValue").each(function(){$(this).val("");});
                if(data == null) return;

                var map = JSON.parse(data.json);
                // console.log(map);

                $.each(map, function(key, value){
                    str = value.replace(/(?:\r\n|\r|\n)/g, '&#13;&#10;');
                    $('input[key='+key+'], textarea[key='+key+']').val(str);
                });

                convert();
            }

            function bindLangPair(){
                $.ajax({
                    url : "/route.php?cmd=AdminMain._getLangJsonStatic",
                    async : true,
                    type : 'get',
                    dataType : 'json',
                    data : {
                        code : $(".jLang").val()
                    },
                    success : function(data){
                        _bindLangPair(data);
                    },
                    error : function(a, b, c){
                        alert(a + "/" + b + "/"+ c);
                    }
                });
            }

            $(".jLang").change(function(){
                bindLangPair();
            });

            $(".jSave").click(function(){
                var jsonArr = getLangPair();
                console.log(jsonArr);
                $.ajax({
                    url : "/route.php?cmd=AdminMain._upsertLangJsonStatic",
                    async : true,
                    type : 'post',
                    data : {
                        code : $(".jLang").val(),
                        json : JSON.stringify(jsonArr.map)
                    },
                    success : function(data){
                        alert("저장되었습니다.");
                        location.reload();
                    }
                });
            });



        });
    </script>

    <div id="content-wrapper">

            <div class="container-fluid">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">홈페이지관리</li>
                    <li class="breadcrumb-item active">정적 정보 설정</li>
                </ol>

                <div class="btn-group float-right mb-2" role="group">
                    <a href="#" class="jSave btn btn-secondary mr-2">저장</a>
                    <select class="custom-select mr-2 jLang col-5" id="inputGroupSelect01">
                        <?foreach($langList as $item){?>
                            <option value="<?=$item["code"]?>"><?=$item["desc"]?></option>
                        <?}?>
                    </select>
                </div>

                <h2>정적 정보 설정</h2>

                <div class="table-responsive">
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <colgroup>
                            <col width="30%"/>
                            <col width="70%"/>
                        </colgroup>

                        <tr class="h-auto">
                            <td class="bg-secondary text-light langKey" key="policy_text_thebill">약관 정보(더빌)</td>
                            <td><input type="text" class="form-control langValue" key="policy_text_thebill" value="" placeholder="내용을 입력하세요" /></td>
                        </tr>
                        <tr class="h-auto">
                            <td class="bg-secondary text-light langKey" key="privacy_text_thebill">개인정보처리방침(더빌)</td>
                            <td><input type="text" class="form-control langValue" key="privacy_text_thebill" value="" placeholder="내용을 입력하세요" /></td>
                        </tr>
                        <tr class="h-auto">
                            <td class="bg-secondary text-light langKey" key="privacy_text_auto">개인정보처리방침(자동이체)</td>
                            <td><input type="text" class="form-control langValue" key="privacy_text_auto" value="" placeholder="내용을 입력하세요" /></td>
                        </tr>
                        <tr class="h-auto">
                            <td class="bg-secondary text-light langKey" key="policy_text_service">개인정보처리방침(처음 로그인)</td>
                            <td><input type="text" class="form-control langValue" key="policy_text_service" value="" placeholder="내용을 입력하세요" /></td>
                        </tr>
                        <tr class="h-auto">
                            <td class="bg-secondary text-light langKey" key="privacy_text_service">개인정보처리방침(처음 로그인)</td>
                            <td><input type="text" class="form-control langValue" key="privacy_text_service" value="" placeholder="내용을 입력하세요" /></td>
                        </tr>
                    </table>
                </div>

            <br/>

        </div>
        <!-- /.container-fluid -->
    </div>


<? include_once $_SERVER['DOCUMENT_ROOT']."/admin/inc/footer.php"; ?>