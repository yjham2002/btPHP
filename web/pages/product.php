<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 3.
 * Time: PM 6:31
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
$obj = new webUser($_REQUEST);
?>
<script>
    $(document).ready(function(){

    });
</script>

<section class="wrapper special books">
    <div class="inner">
        <h5 class="dirHelper">메인 / 상품명</h5>
        <table>
            <tr class="noBorder whiteBG">
                <td width="50%" class="productArea">
                    <div class="image fit">
                        <img src="/web/images/testProduct.png" />
                    </div>
                </td>
                <td width="50%" style="vertical-align:top; text-align:left;">
                    <h2 class="nanumGothic" style="color:black; font-size:1.8em;">상품명</h2>
                    <h3 class="nanumGothic" style="color:black;">
                        <s style="color:#AAAAAA;">₩2,500</s>
                        &nbsp;&nbsp; ₩1,500
                    </h3>
                    <p class="nanumGothic" style="color:black;">* 단체 주문시 할인가로 적용됩니다.(10권이상, 배송료 3000원)</p>
                    <a href="#" class="nanumGothic viewDetail">자세히 보기</a>
                    <br/><br/>
                    <p class="nanumGothic">수량</p>
                    <p>
                        <input type="number" class="nanumGothic quantity" name="quantity" id="quantity" value="1" />
                    </p>
                    <a href="#" class="roundButton detailSubscribe nanumGothic" >구독하기</a>
                </td>
            </tr>
        </table>
        <h5 class="dirHelper">상품명 / 상품설명</h5>
        <div class="detailWrapper">
            <div class="image fit">
                <img src="/web/images/product_info.png" />
            </div>
        </div>
    </div>
</section>
<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
