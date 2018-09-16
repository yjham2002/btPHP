<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 8. 13.
 * Time: PM 9:07
 */
?>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/header.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/WebUser.php";?>
<?
$obj = new WebUser($_REQUEST);
?>

<!--[if IE]><script src="/web/assets/js/excanvas.js" type="text/javascript" charset="utf-8"></script><![endif]-->
<script src="/web/assets/js/FileSaver.js" type="text/javascript" charset="utf-8"></script>
<script src="/web/assets/js/canvasToBlob.js" type="text/javascript" charset="utf-8"></script>

<script>

    $(document).ready(function(){

        var canvas = document.getElementById("canvas");
//        var canvasDiv = document.getElementById('canvasDiv');
//        canvas = document.createElement('canvas');
//        canvas.setAttribute('width', $(window).width());
//        canvas.setAttribute('height', $(window).width());
//        canvas.setAttribute('id', 'canvas');
//        canvasDiv.appendChild(canvas);
        if(typeof G_vmlCanvasManager != 'undefined') {
            canvas = G_vmlCanvasManager.initElement(canvas);
        }

        context = canvas.getContext("2d");


        $('#canvas').mousedown(function(e){
            var mouseX = e.pageX - this.offsetLeft;
            var mouseY = e.pageY - this.offsetTop;

            paint = true;
            addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop);
            redraw();
        });
        $('#canvas').mousemove(function(e){
            if(paint){
                addClick(e.pageX - this.offsetLeft, e.pageY - this.offsetTop, true);
                redraw();
            }
        });
        $('#canvas').mouseup(function(e){
            paint = false;
        });
        $('#canvas').mouseleave(function(e){
            paint = false;
        });

        $(".jRedraw").click(function(){
            clickX = [];
            clickY = [];
            clickDrag = [];
            redraw();
        });

        $(".jSaveSig").click(function(){
            var canvas = document.getElementById("canvas");
            var ctx = canvas.getContext("2d");
            ctx.font = "30px arial";
            context.fillStyle = "black";
            ctx.fillText("Line 01", 20, 50);
            ctx.fillText("Line 02", 20, 80);
            ctx.fillText("Line 03", 20, 110);
            ctx.fillText("Line 04", 20, 140);

            canvas.toBlob(function(blob) {
                saveAs(blob, "pretty image.png");
            });

//            var imgData = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
//
//            var link = document.createElement("a");
//            link.href = imgData;
//            link.download = "test.jpg";
//
//            link.click();

        });

        var clickX = new Array();
        var clickY = new Array();
        var clickDrag = new Array();
        var paint;

        function addClick(x, y, dragging) {
            clickX.push(x);
            clickY.push(y);
            clickDrag.push(dragging);
        }

        function redraw(){
            context.clearRect(0, 0, context.canvas.width, context.canvas.height); // Clears the canvas

            context.fillStyle = "white";
            context.fillRect(0, 0, canvas.width, canvas.height);

            context.strokeStyle = "#222222";
            context.lineJoin = "round";
            context.lineWidth = 5;

            for(var i=0; i < clickX.length; i++) {
                context.beginPath();
                if(clickDrag[i] && i){
                    context.moveTo(clickX[i-1], clickY[i-1]);
                }else{
                    context.moveTo(clickX[i]-1, clickY[i]);
                }
                context.lineTo(clickX[i], clickY[i]);
                context.closePath();
                context.stroke();
            }
        }
    });
</script>

<section class="wrapper special books">
    <div class="inner">
        <header>
            <h2 class="pageTitle">인증수단 선택</h2>
            <div class="empLineT"></div>
        </header>

        <div id="canvasDiv" >
            <canvas style="border: 1px solid black;" width="300px" height="300px" id="canvas"></canvas>
        </div>

        <br/>

        <a href="#" class="roundButton grayButton jRedraw">다시 작성</a>
        <a href="#" class="roundButton grayButton jSaveSig">저장</a>

    </div>
</section>

<? include_once $_SERVER['DOCUMENT_ROOT']."/web/inc/footer.php"; ?>
