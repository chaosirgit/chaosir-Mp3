<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>chaosir-Audio</title>
	<link rel="stylesheet" href="css/music.css">
	<script src="http://apps.bdimg.com/libs/jquery/2.1.4/jquery.min.js"></script>
</head>
<body class="blueHour">
	<div class="search">
		{{--<input id="keyword" type="text">--}}
		{{--<a id="search-btn" href="javascript:;">&nbsp;&nbsp;&nbsp;搜&nbsp;&nbsp;一&nbsp;&nbsp;下&nbsp;&nbsp;</a>--}}
		{{--<span id="result"></span>--}}
	</div>
	<div class="container">
		<div class="music-list">
			<div class="title">所有歌曲</div>
			<div class="list">
				<ul>
					@foreach ($music_all as $music)
					<li>{{ $music->music_name }} - {{ $music->music_author }}</li>
					@endforeach
				</ul>
			</div>
		</div>
		<audio id="audio">
			@foreach ($music_all as $music)
			<source title="{{$music->music_name}}" data-img="" src="{{$music->music_addr}}">
			@endforeach
		</audio>
		<div class="music">
			<div class="header">
				<h1>chaosir-Audio <small>音乐播放器</small></h1>
			</div>
			<div class="fengmian">
				<img src="img/music.png" id="music-img" alt="">
			</div>
			<div id="title">
				hey!
			</div>
			<div class="jindu">
				<span id="music-bar">
					<span id="load-bar"></span>
					<span id="played-bar"></span>
				</span>
				<span id="voice-bar">
					<span id="voiced-bar"></span>
				</span>
				<div id="time">
					<span id="current-time">0:00</span>
					<span id="total-time"></span>
				</div>
			</div>
			<div class="controls">
				<a id="xunhuan" href="javascript:;">循环</a>
				<a id="prev" href="javascript:;"><</a>
				<a id="play" href="javascript:;">Play</a>
				<a id="next" href="javascript:;">></a>
				<a id="jingyin" href="javascript:;">静音</a>
			</div>
		</div>
	</div>
	<div id="footer">
		@if($user_info[0]->id)
			<a href="javascript:;">{{$user_info[0]->nickname}}</a>
		@else
		<a href="login" target="_blank">登录</a>
		@endif
		<a href="http://blog.adminchao.com/" target="_blank">博客</a>
		<a href="admin/upload" target="_blank">上传歌曲</a>
	</div>

	<script src="js/music.js"></script>
	<script>
		// 回调函数将返回的内容添加到结果区（需要在页面加载完后加载上，为后面执行回调）
		function jsonpcallback (rs) {
			var resultHtml = '歌曲：<strong>' + rs[0].music_name + '</strong>' +
							 '歌手：<strong>' + rs[0].music_author + '</strong>' +
							 '<a href="javascript:;" id="to-play">立即播放</a>';
			result.innerHTML = resultHtml;
			result.setAttribute('data-audio', rs.result.songs[0].audio);
			result.setAttribute('data-img', rs.result.songs[0].album.picUrl);
			result.setAttribute('data-music', rs.result.songs[0].name);
			result.setAttribute('data-singer', rs.result.songs[0].artists[0].name);
			result.style.opacity = '1';

		};
	</script>
</body>
</html>