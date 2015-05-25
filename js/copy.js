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
    	$('.main').empty;
    	$('.main-copy').empty();//清空mymenu
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

											});//end for
										}//end if
									};//end if

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
		// init();//调用预定义init（）

		// init2();
		inputval();
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
	   		$('.main').empty();
	   		var request = new XMLHttpRequest();
				request.open("GET", "service.php?number=1");
				request.send();
				request.onreadystatechange = function() {
					if (request.readyState===4) {
						if (request.status===200) { 
							var data = JSON.parse(request.responseText);
							var data = '[' + data + ']';
							var obj1 = eval("("+data+")");
							for(var i in obj1){
								if (obj1[i].success) { 
								// 重新nav第一个元素加上active类
								$('.active').removeClass('active');
								$('.nav div:nth-child(1)').addClass('active');
								// 动态生成元素
								$('.main').append('<div class="detail"><div class="detail-pic"></div><p class="name"></p><p class="price"><span class="price-number"></span>元1<span class="price-amount"></span></p><p class="people"><span class="price-people"></span>人点过</p></div>');
								$('.name').eq(i).html(obj1[i].name);
								$('.main .detail').eq(i).attr({
									id: obj1[i].id
								});
								$('.price-number').eq(i).html(obj1[i].price);
								$('.price-amount').eq(i).html(obj1[i].amount);
								$('.price-people').eq(i).html(obj1[i].people);
								$('.detail-pic').eq(i).css('backgroundImage', "url("+obj1[i].img+")");//css 要传入一个字符串
								$('.detail').eq(i).append('<table id="tap"><tr><td><input class="min" name="" type="button" value="-" /><input class="text_box" name="" type="text" value="0" /><input class="add" name="" type="button" value="+" /></td></tr><div>');
			
							} else {
							}
							}

							// 购物车增加
								$(".add").click(function(){ 
									var t=$(this).parent().find('input[class*=text_box]'); 
									t.val(parseInt(t.val())+1);
									// 向购物车加入商品
									product = {
                                           "name":$(this).parents('.detail').find('.name').html(),
                                           "price":$(this).parents('.detail').find('.price-number').html(),
                                           "amount":$(this).parent().find('input[class*=text_box]').val(),
                                           "amountName":$(this).parents('.detail').find('.price-amount').html(),
                                           "id":$(this).parents('.detail').attr('id'),
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
                                          "name":$(this).parents('.detail').find('.name').html(),
                                           "price":$(this).parents('.detail').find('#price-number').html(),
                                           "amount":$(this).parent().find('input[class*=text_box]').val(),
                                           "amountName":$(this).parents('.detail').find('#price-amount').html(),
                                           "id":$(this).parents('.detail').attr('id'),
                                       }
									cart.addproduct(product);
								})


								// 提取localstorage数据，动态显示inputval
        //                        var ShoppingCart = utils.getParam("ShoppingCart");
								// var jsonstr = JSON.parse(ShoppingCart.substr(1,ShoppingCart.length));
								// var productlist = jsonstr.productlist;
								// for(var i in productlist){
								// 	if(productlist[i].id = $('.main').find('.detail').attr('id')){
								// 		console.log(productlist[i].id);
								// 		// $('.main').find('#'+productlist[i].id).find("input[class*=text_box]").val(productlist[i].amount);
								// 	}
						  //           // $('.main-copy-container').remove();
						  //           // $('#'+productlist[i].id).find("input[class*=text_box]").val(productlist[i].amount);
		
						  //       }

								
// 详情图片
								$('.detail-pic').bind('click', function(event) {
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
							alert("发生错误：" + request.status);
						}
					} 
				}
	   }

	   init();

// 第一加载商品时候绑定后台数据
	function init2(){
		for (i=0;i<=7;i++) {
			$('#' + i).each(function() {
				$(this).click(function(){
					$('.main').empty();
	   		var request = new XMLHttpRequest();
				request.open("GET", "service.php?number="+ $(this).attr('id'));
				request.send();
				request.onreadystatechange = function() {
					if (request.readyState===4) {
						if (request.status===200) { 
							var data = JSON.parse(request.responseText);
							var data = '[' + data + ']';
							var obj1 = eval("("+data+")");
							for(var i in obj1){
								if (obj1[i].success) { 
								// 重新nav第一个元素加上active类
								// $('.active').removeClass('active');
								// $('.nav div:nth-child(1)').addClass('active');
								// 动态生成元素
								$('.main').append('<div class="detail"><div class="detail-pic"></div><p class="name"></p><p class="price"><span class="price-number"></span>元1<span class="price-amount"></span></p><p class="people"><span class="price-people"></span>人点过</p></div>');
								$('.name').eq(i).html(obj1[i].name);
								$('.main .detail').eq(i).attr({
									id: obj1[i].id
								});
								$('.price-number').eq(i).html(obj1[i].price);
								$('.price-amount').eq(i).html(obj1[i].amount);
								$('.price-people').eq(i).html(obj1[i].people);
								$('.detail-pic').eq(i).css('backgroundImage',"url("+obj1[i].img+")");
								$('.detail').eq(i).append('<table id="tap"><tr><td><input class="min" name="" type="button" value="-" /><input class="text_box" name="" type="text" value="0" /><input class="add" name="" type="button" value="+" /></td></tr><div>');

								
							} else {
							}
							}

								inputval();
							// 购物车增加
								$(".add").click(function(){ 
									var t=$(this).parent().find('input[class*=text_box]'); 
									t.val(parseInt(t.val())+1);
									// 向购物车加入商品
									product = {
                                           "name":$(this).parents('.detail').find('.name').html(),
                                           "price":$(this).parents('.detail').find('.price-number').html(),
                                           "amount":$(this).parent().find('input[class*=text_box]').val(),
                                           "amountName":$(this).parents('.detail').find('.price-amount').html(),
                                           "id":$(this).parents('.detail').attr('id'),
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
                                          "name":$(this).parents('.detail').find('.name').html(),
                                           "price":$(this).parents('.detail').find('#price-number').html(),
                                           "amount":$(this).parent().find('input[class*=text_box]').val(),
                                           "amountName":$(this).parents('.detail').find('#price-amount').html(),
                                           "id":$(this).parents('.detail').attr('id'),
                                       }
									cart.addproduct(product);
								})
// 详情图片
								$('.detail-pic').bind('click', function(event) {
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
							alert("发生错误：" + request.status);
						}
					} 
				}
				})
			});
		};
	}

    init2();
//动态显示inputval
    function inputval(){
    	 var ShoppingCart = utils.getParam("ShoppingCart");
		 var jsonstr = JSON.parse(ShoppingCart.substr(1,ShoppingCart.length));
		 var productlist = jsonstr.productlist;
		 for(var i in productlist){
		 	$('.main').find('#'+productlist[i].id).find("input[class*=text_box]").val(productlist[i].amount);
		 }
    }                                   