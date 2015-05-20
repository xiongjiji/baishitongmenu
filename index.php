<!DOCTYPE html>
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
</head>
<body>

	<div class="wrapper">
		<div class="nav">
			<div class="logo" style = "background:url('./image/logo.png') top left no-repeat;background-size:cover">
				
			</div>
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
	var H = document.documentElement.clientHeight;
	var W = document.documentElement.clientWidth;
	$('.nav,.showPic,.bill').css({
		height: H,
		property2: 'value2'
	});

	$('.showPic,.bill').css({
		width: W,
		property2: 'value2'
	});

	$('#1,#2,#3,#4,#5,#6,#7').click(function() {
		/* Act on the event */
		$('.active').removeClass('active');
		$(this).addClass('active');
	});
    
    $('.mymenu').click(function(product) {
    	/* Act on the event */
    	$('.bill').css('display','block');
    	$('#result').html(cart.totalNumber);
    	var ShoppingCart = utils.getParam("ShoppingCart");
        var jsonstr = JSON.parse(ShoppingCart.substr(1,ShoppingCart.length));
        var productlist = jsonstr.productlist;
        for(var i in productlist){
            	$('.main-copy').append('<div class="main-copy-container"><div class="main-copy-container-name">'+productlist[i].name+'</div><div class="main-copy-container-price"><span id="comfirm-price">'+productlist[i].price+'</span>元/<span id="comfirm-amountname">'+productlist[i].amountName+'<span></div><table id="tap"><tr><td><input class="min" name="" type="button" value="-" /><input class="text_box" name="" type="text" value="'+productlist[i].amount+'" /><input class="add" name="" type="button" value="+" /></td></tr></div></div>');

            }
        $('.main-copy .add').click(function(event) {
            		/* Act on the event */
            		var t=$(this).parent().find('input[class*=text_box]'); 
					t.val(parseInt(t.val())+1);

					var aftername = $(this).parents('.main-copy-container').find('.main-copy-container-name').html();
					var afterPrice = $(this).parents('.main-copy-container').find('#comfirm-price').html();
					var afteramount = $(this).parents('.main-copy-container').find('#price-amount').html();
					var product = {
							"name":aftername,
                             "price":afterPrice,
                              "amount":t.val(),
                                "amountName":afteramount

					}
                    cart.addproduct(product);
            		$('#result').html(cart.totalNumber);
            	});

        $('.main-copy .min').click(function(event) {
            		/* Act on the event */
            		var t=$(this).parent().find('input[class*=text_box]');
									t.val(parseInt(t.val())-1);
									if(parseInt(t.val())< 0){
										t.val(0);
										if(t.val() == 0){
											$(".comfirmdelete").css('display','block');
											$('.comfirm-container').click(function(event) {
												/* Act on the event */
											});
										}
									};

					var aftername = $(this).parents('.main-copy-container').find('.main-copy-container-name').html();
					var afterPrice = $(this).parents('.main-copy-container').find('#comfirm-price').html();
					var afteramount = $(this).parents('.main-copy-container').find('#price-amount').html();
					var product = {
							"name":aftername,
                             "price":afterPrice,
                              "amount":t.val(),
                                "amountName":afteramount

					}
                    cart.addproduct(product);
            		$('#result').html(cart.totalNumber);
            	});


    });

    $('#btn-add').click(function(event) {
		$('.bill').css('display','none');
	});

	$('#btn-empty').click(function(product){
		var ShoppingCart = utils.getParam("ShoppingCart");
		var jsonstr = JSON.parse(ShoppingCart.substr(1,ShoppingCart.length));
		var productlist = jsonstr.productlist;
		for(var i in productlist){
            $('.main-copy-container').remove();
		}
	});

	$('#btn-add').click(function(event) {
		$('.bill').css('display','none');
	});

	$('#btn-empty').click(function(product){
		var ShoppingCart = utils.getParam("ShoppingCart");
		var jsonstr = JSON.parse(ShoppingCart.substr(1,ShoppingCart.length));
		var productlist = jsonstr.productlist;
		for(var i in productlist){
            $('.main-copy-container').remove();
		}
	});

	// function showPic(){
	// 	$('.detail-pic').click(function(event) {
 //    	/* Act on the event */
 //    	$('.showPic').css({
 //    		display: 'block',
 //    		property2: 'value2'
 //    	});
 //    	var imgDetail = $(this).css('background-image');
 //    	// 动态获取背景图片
 //    	$('#Pic-detail').css('backgroundImage',imgDetail);
 //    	//动态获取说明文字
 //    	var name = $(this).next().html();
 //    	var price = $(this).next().next().html();
 //    	var people = $(this).next().next().html();
 //    	$('#detail-name').html(name);
 //    	$('#detail-price').html(price);
 //    	$('#detail-people').html(people);
 //    	$('.close').click(function(event) {
 //    		$('.showPic').css({
 //    			display: 'none',
 //    			property2: 'value2'
 //    		});
 //    	});
 //    });
	// 	return false;
	// }
	   function init(){
	   		var request = new XMLHttpRequest();
				request.open("GET", "service.php?number=1");
				request.send();
				request.onreadystatechange = function() {
					if (request.readyState===4) {
						if (request.status===200) { 
							var data = JSON.parse(request.responseText);
							if (data.success) { 
								$('.main').empty().append('<div class="detail"><div id="detail-pic"></div><p class="name"></p><p class="price"><span id="price-number"></span>元1<span id="price-amount"></span></p><p class="people"><span id="price-people"></span>人点过</p></div>');
								$('.name').html(data.name);
								$('#price-number').html(data.price);
								$('#price-amount').html(data.amount);
								$('#price-people').html(data.people);
								$('.detail-pic').css('backgroundImage',data.img);
								$('.detail').append('<table id="tap"><tr><td><input class="min" name="" type="button" value="-" /><input class="text_box" name="" type="text" value="0" /><input class="add" name="" type="button" value="+" /></td></tr><div>');

								// 购物车增加
								$(".add").click(function(){ 
									var t=$(this).parent().find('input[class*=text_box]'); 
									t.val(parseInt(t.val())+1);
									// 向购物车加入商品
									product = {
                                           "name":data.name,
                                           "price":data.price,
                                           "amount":t.val(),
                                           "amountName":data.amount
                                       }
									cart.addproduct(product);
									
								})
							
								// 购物车减少数量
								$(".min").click(function(event) {
									var t=$(this).parent().find('input[class*=text_box]');
									t.val(parseInt(t.val())-1);
									if(parseInt(t.val())< 0){
										t.val(0);
									};
									//更改购物车数据
									product = {
                                           "name":data.name,
                                           "price":data.price,
                                           "amount":t.val(),
                                           "amountName":data.amount
                                       }
									cart.addproduct(product);
								})
								//购物车的函数
							
								// 	// 定义localStorage方法
								// 	utils = {
								// 		setParam: function(name,value){
								// 			localStorage.setItem(name,value);//定义localstorage的name和value
								// 		},
								// 		getParam: function(name,value){
								// 			return localStorage.getItem(name,value);
								// 		}
								// 	}

								// 	//定义product参数
								// 	product = {
								// 		name:1,
								// 		price:1,
								// 		amount:1,

								// 	}
								// 	//定义购物车里的product
								// 	cart = {
								// 		addproduct:function(){
								// 			var ShoppingCart = utils.getParam('ShoppingCart');
								// 			// 第一次加入商品
								// 			if(ShoppingCart == "null"||ShoppingCart == ""){
								// 				var jsonstr = {"productlist":[{"name":product.name,"price":product.price,"amount":product.amount,}],"totalNumber":product.amount,"totalAmount":(product.price*product.amount)};
								// 				utils.setParam("ShoppingCart","'"+Json.stringfy(jsonStr));//转换字符串
								// 			}else{
								// 				var jsonstr = JSON.parse(ShoppingCart.substr(1,ShoppingCart.length));  
        //     									var productlist = jsonstr.productlist;  
        //     									var result=false;
        //     									// 寻找是否有该商品
        //     									for(i in productlist){
        //     										if(productlist[i].name == product.name)
        //     									}
								// 			}
								// 		},
								// 	}


								
								// 详情图片
								$('#detail-pic').bind('click', function(event) {
									/* Act on the event */
    								$('.showPic').css({
									 display: 'block',
									 property2: 'value2'
									     	});
    								 var imgDetail = $(this).css('background-image');
							    	// 动态获取背景图片
							    	$('#Pic-detail').css('backgroundImage',imgDetail);
							    	//动态获取说明文字
							    	var name = $(this).next().html();
							    	var price = $(this).next().next().html();
							    	var people = $(this).next().next().html();
							    	$('#detail-name').html(name);
							    	$('#detail-price').html(price);
							    	$('#detail-people').html(people);
							    	$('.close').click(function(event) {
							    		$('.showPic').css({
							    			display: 'none',
							    			property2: 'value2'
							    		});
							    	});
									// event.stopPropagation(); 
								});
							} else {
							}
						} else {
							alert("发生错误：" + request.status);
						}
					} 
				}
	   }

	   init();


    for(i=0;i<=7;i++){
    	$('#' + i).each(function() {
    		$(this).click(function() {
    			/* Act on the event */
    			var request = new XMLHttpRequest();
				request.open("GET", "service.php?number=" + $(this).attr('id'));
				request.send();
				request.onreadystatechange = function() {
					if (request.readyState===4) {
						if (request.status===200) { 
							var data = JSON.parse(request.responseText);
							if (data.success) { 
								$('.main').empty().append('<div class="detail"><div id="detail-pic"></div><p class="name"></p><p class="price"><span id="price-number"></span>元1<span id="price-amount"></span></p><p class="people"><span id="price-people"></span>人点过</p></div>');
								$('.name').html(data.name);
								$('#price-number').html(data.price);
								$('#price-amount').html(data.amount);
								$('#price-people').html(data.people);
								$('.detail-pic').css('backgroundImage',data.img);
								$('.detail').append('<table id="tap"><tr><td><input class="min" name="" type="button" value="-" /><input class="text_box" name="" type="text" value="0" /><input class="add" name="" type="button" value="+" /></td></tr><div>');

								// 购物车增加
								$(".add").click(function(){ 
									var t=$(this).parent().find('input[class*=text_box]'); 
									t.val(parseInt(t.val())+1);
									// 向购物车加入商品
									product = {
                                           "name":data.name,
                                           "price":data.price,
                                           "amount":t.val(),
                                           "amountName":data.amount
                                       }
									cart.addproduct(product);
									
									setTotal(); 
								})

								// 购物车减少数量
								$(".min").click(function(event) {
									var t=$(this).parent().find('input[class*=text_box]');
									t.val(parseInt(t.val())-1);
									if(parseInt(t.val())< 0){
										t.val(0);
									};
									//更改购物车数据
									product = {
                                           "name":data.name,
                                           "price":data.price,
                                           "amount":t.val(),
                                           "amountName":data.amount
                                       }
									cart.addproduct(product);
								})

								//详情页展示
								$('#detail-pic').bind('click', function(event) {
									/* Act on the event */
    								$('.showPic').css({
									 display: 'block',
									 property2: 'value2'
									     	});
    								 var imgDetail = $(this).css('background-image');
							    	// 动态获取背景图片
							    	$('#Pic-detail').css('backgroundImage',imgDetail);
							    	//动态获取说明文字
							    	var name = $(this).next().html();
							    	var price = $(this).next().next().html();
							    	var people = $(this).next().next().html();
							    	$('#detail-name').html(name);
							    	$('#detail-price').html(price);
							    	$('#detail-people').html(people);
							    	$('.close').click(function(event) {
							    		$('.showPic').css({
							    			display: 'none',
							    			property2: 'value2'
							    		});
							    	});
									// event.stopPropagation(); 
								});
							} else {
							}
						} else {
							alert("发生错误：" + request.status);
						}
					} 
				}
    			
    		});
    	});
    }

 
</script>
</body>
</html>