<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <link href="https://cdn.bootcss.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.bootcss.com/jquery/2.1.1/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <style>
        body {
            padding-top: 40px;
            padding-bottom: 40px;
            background-color: #eee;
        }

        .form-signin {
            max-width: 330px;
            padding: 15px;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="container">
    <form class="form-signin" action="user/register" method="post" onsubmit="return false">
        <h2 class="form-signin-heading">登  陆</h2>
        <label for="inputMobile" class="sr-only">手机号</label>
        <br>
        <input type="text" name="mobile" id="inputMobile" class="form-control" placeholder="手机号" required autofocus>
        <br>
        <label for="inputPassword" class="sr-only">密  码</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="密码" required>
        <br>
        <a class="btn btn-lg btn-primary btn-block" href="register"> 注 册 </a>
        <input type="submit" class="btn btn-lg btn-primary btn-block" onclick="do_login()" value=" 登 录 ">
    </form>
</div>
</body>
<script>
    function do_login(){
        var mobile = $('#inputMobile').val();
        var password = $('#inputPassword').val();

        $.ajax({
            url:'user/login',
            type:'post',
            dataType:'json',
            data:{mobile:mobile,password:password},
            success:function(res){
                if(res.type == 0){
                    alert(res.msg);
                }else{
                    window.location.href='/';
                }
            }
        });
    }
</script>
</html>