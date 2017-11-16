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
    <form class="form-signin" action="music" method="post" enctype="multipart/form-data" id="filemp3">
        <h2 class="form-signin-heading">上传歌曲</h2>
        <div class="form-group">
            <input type="file" id="exampleInputFile" name="mp3"/>
            <p class="help-block">
                只能上传后缀为 mp3 的文件。格式为 歌曲名-歌手名.mp3 才可以被正确识别
            </p>
        </div>
        <br>
        <input type="submit" class="btn btn-lg btn-primary btn-block" value="Upload">
    </form>
</div>
</body>
<script>
    // function do_upload(){
    //     // var mobile = $('#inputMobile').val();
    //     // var password = $('#inputPassword').val();
    //     // var nickname = $('#inputNickname').val();
    //     // var gender = $("input[name='gender']:checked").val();
    //     // var file = $('#exampleInputFile').val();
    //     var file = new FormData($('#filemp3')[0]);
    //     $.ajax({
    //         url:'music',
    //         type:'post',
    //         dataType:'json',
    //         data:file,
    //         async:false,
    //         cache:false,
    //         contentType:false,
    //         processData:false,
    //         success:function(res) {
    //             if (res.type == 0) {
    //                 alert(res.msg);
    //             } else {
    //                 alert(res.msg);
    //                 window.location.href = 'login';
    //             }
    //         }
    //     });
    // }
</script>
</html>