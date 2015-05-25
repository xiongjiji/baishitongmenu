
<html lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta name="viewport" content="width=device-width,minimum-scale=1,maximum-scale=1,initial-scale=1.0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="full-screen" content="true">
	<meta name="screen-orientation" content="portrait">
	<meta name="x5-fullscreen" content="true">
	<meta name="360-fullscreen" content="true">
	<title>百事通点菜系统</title>
	<link rel="stylesheet" type="text/css" href="./css/main.css">
	<script type="text/javascript" src='./js/jquery-1.9.1.min.js'></script>
	<script type="text/javascript" src='./js/gouwuche.js'></script>
	<script type="text/javascript" src="./js/main.js"></script>
</head>
<body>

	<div class="wrapper">
		<!-- <div class="logo" style = "background:url('./image/logo.png') top left no-repeat;background-size:cover"></div> -->
		<div class="nav">
			
			<div id="1" class="active">
				<p>推荐菜</p>
			</div>
			<div id="2">
				<p>新菜</p>
			</div>
			<div id="3">
				<p>新品菜式</p>
			</div>
			<div id="4">
				<p>经典招牌</p>
			</div>
			<div id="5">
				<p>美味汤底</p>
			</div>
			<div id="6">
				<p>优惠套餐</p>
			</div>
			<div id="7">
				<p>主食</p>
			</div>
		</div>

		<div class="main">
			<!-- <div id="tuijiancai-main" class = "active-main">
				<div class="detail">
					<div class="detail-pic"></div>
					<p class="name">百事通炒饭</p>
					<p class="price"><span id="price-number">0</span>元1<span id="price-amount">份</span></p>
					<p class="people"><span id="price-people">0</span>人点过</p>
				</div>
				<div class="detail">
					<div class="detail-pic" style = "background-image:url('./image/logo.png')"></div>
					<p class="name">百事通炒粉</p>
					<p class="price">0元1份</p>
					<p class="people">0人点过</p>
				</div>
			</div> -->
		</div>

		<div class="mymenu">
			<p>我的菜单</p>
		</div>

		<!-- 点击展示放大框 -->
		<div class="showPic">
			<div class="showPic-wrapper">
				<div class="close"></div>
				<div id="Pic-detail"></div>
				<div id="words-detail">
					<div id="detail-name"></div>
					<div id="detail-price"></div>
					<div id="detail-people"></div>
				</div>	
			</div>
		</div>
	</div>

	<!-- 我的菜单 -->
	<div class="bill" style = "display:none">
		<div class="comfirmdelete">
			<div class="comfirmdelete-name">是否删除<span id="comfirmdelete-name"></span></div>
			<div class="comfirm-container">确定</div>
			<div class="delete-container">取消</div>
		</div>
		<h3>请叫服务员下单</h3>
		<div class="total">
			<span class="gongji">共计</span><span id="result"></div>
			<div class="menu-title">
				<span>我的菜单</span>
				<div class="add-empty">
					<button class="btn" id="btn-add">加菜</button>
					<button class="btn" id="btn-empty">清空</button>
				</div>
			</div>
			<div class="main-copy">
				<div class="main-copy-control"></div>
			</div>
		</div>
		
	</div>

<script>

</script>
</body>
</html>