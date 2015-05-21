<!-- <!DOCTYPE html> -->
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
// 初始localst
// utils.setParam('ShoppingCart','');
// ---------检测浏览器宽高------
	var H = document.documentElement.clientHeight;
	var W = document.documentElement.clientWidth;
	$('.nav,.showPic,.bill').css({
		height: H,
		property2: 'value2'
	});

// -----------账单页面显示=========
	$('.showPic,.bill').css({
		width: W,
		property2: 'value2'
	});

// 给每个主账单绑定样式
	$('#1,#2,#3,#4,#5,#6,#7').click(function() {
		/* Act on the event */
		$('.active').removeClass('active');
		$(this).addClass('active');
	});

// 动态生成账单总金额
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
            		var _this = $(this);
            		var t=$(this).parent().find('input[class*=text_box]');
									t.val(parseInt(t.val())-1);
									if(parseInt(t.val()) < 1){
										t.val(1);
										if(t.val() == 1){
											$(".comfirmdelete").css('display','block');
											$('#comfirmdelete-name').html($(this).parents('.main-copy-container').find('.main-copy-container-name').html());
											$('.comfirm-container').click(function(event) {
												/* Act on the event */
												_this.parents('.main-copy-container').remove();
												var ShoppingCart = utils.getParam("ShoppingCart");
												var jsonstr = JSON.parse(ShoppingCart.substr(1,ShoppingCart.length));
								
												for(var i in jsonstr.productlist){
													if(_this.parents('.main-copy-container').find('.main-copy-container-name').html() == jsonstr.productlist[i].name){

														jsonstr.productlist.splice(i,1);
														if(jsonstr.productlist.length == 0){
															utils.setParam("ShoppingCart","");
														}else(utils.setParam("ShoppingCart","'"+JSON.stringify(jsonstr)))
														
													}
												}

												$('.comfirmdelete').css('display','none')

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

// 账单头绑定事件
    $('#btn-add').click(function(event) {
		$('.bill').css('display','none');
		
		init();//调用预定义init（）

		init2();
		});
		

	$('#btn-empty').click(function(product){
		var ShoppingCart = utils.getParam("ShoppingCart");
		var jsonstr = JSON.parse(ShoppingCart.substr(1,ShoppingCart.length));
		var productlist = jsonstr.productlist;
		for(var i in productlist){
            $('.main-copy-container').remove();

		}
		utils.setParam("ShoppingCart","")
	});

//delete-container
   $('.delete-container').click(function(event) {
   	/* Act on the event */
   	$('.comfirmdelete').css('display','none');
   });

// 第一次加载商品 发出ajax请求
	   function init(){
	   		var request = new XMLHttpRequest();
				request.open("GET", "service.php?number=1");
				request.send();
				request.onreadystatechange = function() {
					if (request.readyState===4) {
						if (request.status===200) { 
							var data = JSON.parse(request.responseText);
							if (data.success) { 
								// 重新nav第一个元素加上active类
								$('.active').removeClass('active');
								$('.nav div:nth-child(1)').addClass('active');
								// 动态生成元素
								$('.main').empty().append('<div class="detail"><div id="detail-pic"></div><p class="name"></p><p class="price"><span id="price-number"></span>元1<span id="price-amount"></span></p><p class="people"><span id="price-people"></span>人点过</p></div>');
								$('.name').html(data.name);
								$('.main .detail').addClass(data.id);
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
                                           "amountName":data.amount,
                                           "id":data.id
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


								// 提取localstorage数据，动态显示inputval
                               var ShoppingCart = utils.getParam("ShoppingCart");
								var jsonstr = JSON.parse(ShoppingCart.substr(1,ShoppingCart.length));
								var productlist = jsonstr.productlist;
								for(var i in productlist){
						            $('.main-copy-container').remove();
						            $('.'+productlist[i].id).find("input[class*=text_box]").val(productlist[i].amount);
		
						        }

								
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

// 第一加载商品时候绑定后台数据
   function init2(){
   		for(i=0;i<=7;i++){
    	$('#' + i).each(function() {
    		$(this).click(function(event) {
    			/* Act on the event */
    			var request = new XMLHttpRequest();
				request.open("GET", "service.php?number="+ $(this).attr('id'));
				request.send();
				request.onreadystatechange = function() {
					if (request.readyState===4) {
						if (request.status===200) { 
							var data = JSON.parse(request.responseText);
							if (data.success) { 
								// 动态生成元素
								$('.main').empty().append('<div class="detail"><div id="detail-pic"></div><p class="name"></p><p class="price"><span id="price-number"></span>元1<span id="price-amount"></span></p><p class="people"><span id="price-people"></span>人点过</p></div>');
								$('.name').html(data.name);
								$('.main .detail').addClass(data.id);
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
                                           "amountName":data.amount,
                                           "id":data.id
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


								// 提取localstorage数据，动态显示inputval
                               var ShoppingCart = utils.getParam("ShoppingCart");
								var jsonstr = JSON.parse(ShoppingCart.substr(1,ShoppingCart.length));
								var productlist = jsonstr.productlist;
								for(var i in productlist){
										$('.main-copy-container').remove();
						                $('.'+productlist[i].id).find("input[class*=text_box]").val(productlist[i].amount);
						         
						        }

								
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
    		});
    	});
    		
    }
   };
    
    init2();

 
</script>
</body>
</html>