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
        <h2 class="form-signin-heading">注  册</h2>
        <label for="inputMobile" class="sr-only">手机号</label>
        <br>
        <input type="text" name="mobile" id="inputMobile" class="form-control" placeholder="手机号" required autofocus>
        <br>
        <label for="inputPassword" class="sr-only">密  码</label>
        <input type="password" name="password" id="inputPassword" class="form-control" placeholder="密码" required>
        <br>
        <label for="inputNickname" class="sr-only">昵  称</label>
        <input type="text" name="nickname" id="inputNickname" class="form-control" placeholder="昵称" required>
        <br>
        <div class="radio">
            <label for="optionGenderMale" class="sr-only">性  别</label>
            <label>
                <input type="radio" name="gender" id="optionGenderMale"
                       value="male" checked> 男
            </label>
            <label>
                <input type="radio" name="gender" id="optionGenderFemale"
                       value="female"> 女
            </label>
        </div>
        <br>
        <input type="submit" class="btn btn-lg btn-primary btn-block" onclick="do_add()" value="Register">
    </form>
</div>
</body>
<script>
    function do_add(){
        var mobile = $('#inputMobile').val();
        var password = $('#inputPassword').val();
        var nickname = $('#inputNickname').val();
        var gender = $("input[name='gender']:checked").val();
        $.ajax({
            url:'user/register',
            type:'post',
            dataType:'json',
            data:{mobile:mobile,password:password,nickname:nickname,gender:gender},
            success:function(res){
                if(res.type == 0){
                    alert(res.msg);
                }else if(res.type == 3){
                    alert(res.msg);
                    window.location.href='login';
                }else{
                    window.location.href='login';

                }
            }
        });
    }
</script>
</html>