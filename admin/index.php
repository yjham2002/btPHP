<?php
/**
 * Created by PhpStorm.
 * User: sayho
 * Date: 2018. 7. 27.
 * Time: PM 1:36
 */
?>

<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/Admin.php"; ?>
<? include $_SERVER["DOCUMENT_ROOT"] . "/common/classes/AdminMain.php" ;?>

<!DOCTYPE html>
<html lang="ko">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin - Login</title>

    <!-- Bootstrap core CSS-->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script type="text/javascript" src="/modules/ajaxCall/ajaxClass.js"></script>
    <script type="text/javascript" src="/modules/sehoMap/sehoMap.js"></script>


<!--    <script src="http://malsup.github.com/jquery.form.js"></script>-->
</head>

<script>
    $(document).ready(function(){
        $(".jLogin").click(function(){
            if($("[name=account]").val() == "" || $("[name=password]").val() == ""){
                alert("계정 정보를 입력하세요.");
                return;
            }
            var params = new sehoMap();
            params.put("account", $("#account").val());
            params.put("password", $("#password").val());
            var ajax = new AjaxSender("/action_front.php?cmd=AdminMain.login", false, "json", params);
            ajax.send(function(data){
                if(data.returnCode === 1){
                    location.href = "/admin/pages/index.php";
                }
                else{
                    alert("로그인 정보를 확인하세요");
                }
            });
        });

        $('input').on("keydown", function(event){
            if (event.keyCode == 13) {
                $(".jLogin").trigger("click");
            }
        });
    });

</script>

<body class="bg-dark">

<div class="container">
    <div class="card card-login mx-auto mt-5">
        <div class="card-header">Admin Login</div>
        <div class="card-body">
            <form>
                <div class="form-group">
                    <div class="form-label-group">
                        <input type="text" id="account" class="form-control" placeholder="Email address" required="required" autofocus="autofocus">
                        <label for="account">Account</label>
                    </div>
                </div>
                <div class="form-group">
                    <div class="form-label-group">
                        <input type="password" id="password" class="form-control" placeholder="Password" required="required">
                        <label for="password">Password</label>
                    </div>
                </div>
<!--                <div class="form-group">-->
<!--                    <div class="checkbox">-->
<!--                        <label>-->
<!--                            <input type="checkbox" value="remember-me">-->
<!--                            Remember Password-->
<!--                        </label>-->
<!--                    </div>-->
<!--                </div>-->
                <a class="btn btn-primary btn-block jLogin">Login</a>
            </form>
        </div>
    </div>
</div>


<!-- Core plugin JavaScript-->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>
</body>

</html>
