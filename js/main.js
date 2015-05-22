//c全局变量



$(document).ready(function($) {
	init();//调用init函数

	navTap();

	active();
});

function init(){
	wh();
	
	firstNav();
	
}

//定义页面宽高
function wh(){
	var w = document.documentElement.clientWidth;
	var h = document.documentElement.clientHeight;
	$('.nav').css('height',h);
	$('.showPic,.bill').css({
		width: w,
		height: h
	});
}

//一开始加载时候生成第一个菜单的详细内容
function firstNav(){
	var no1 = $('.nav div:nth-child(1)').attr('id');
	//with ajax
	var request = new XMLHttpRequest();
	request.open('get',"service.php?number=" + no1);
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
								$('.detail-pic').eq(i).css('backgroundImage', "url("+obj1[i].img+")").bind('click',imgDetail);//css 要传入一个字符,链式调用imgdetail事件
								$('.detail').eq(i).append('<table id="tap"><tr><td><input class="min" name="" type="button" value="-" /><input class="text_box" name="" type="text" value="0" /><input class="add" name="" type="button" value="+" /></td></tr><div>');

								
			
							} else {
							}//结束动态生成
						}//end the for loop

						if(!utils.getParam("ShoppingCart")){
							utils.setParam('ShoppingCart','')
						}else{
							inputval();
						}//add inputval
						add();//add event
						min();
					}//end thd request.status
				}//end the request.readyState
			}//end the onreadystatechange
}//end the firstNav	

//为每个Nav绑定click时间 动态显示main
function navTap(){
	var navTap = $('.nav div');//get the nav object
	for(i=0;i<=navTap.length;i++){
		$('#'+i).each(function() {
			$(this).click(function(){
				$('.active').removeClass('active');
				$('this').addClass('active');

				$('.main').empty();
				var request = new XMLHttpRequest();
				request.open('get',"service.php?number=" + $(this).attr('id'));
				request.send();
				request.onreadystatechange = function(){
					if(request.readyState===4){
						if(request.status===200){
							var data = JSON.parse(request.responseText);
							var data = '[' + data + ']';
							var obj1 = eval("("+data+")");
							for(var i in obj1){
								if (obj1[i].success) { 
								// 重新nav第一个元素加上active类
								// 动态生成元素
								$('.main').append('<div class="detail"><div class="detail-pic"></div><p class="name"></p><p class="price"><span class="price-number"></span>元1<span class="price-amount"></span></p><p class="people"><span class="price-people"></span>人点过</p></div>');
								$('.name').eq(i).html(obj1[i].name);
								$('.main .detail').eq(i).attr({
									id: obj1[i].id
								});
								$('.price-number').eq(i).html(obj1[i].price);
								$('.price-amount').eq(i).html(obj1[i].amount);
								$('.price-people').eq(i).html(obj1[i].people);
								$('.detail-pic').eq(i).css('backgroundImage', "url("+obj1[i].img+")").bind('click',imgDetail);//css 要传入一个字符串
								$('.detail').eq(i).append('<table id="tap"><tr><td><input class="min" name="" type="button" value="-" /><input class="text_box" name="" type="text" value="0" /><input class="add" name="" type="button" value="+" /></td></tr><div>');
								
								} else {
								}//结束动态生成
							}//end the for loop

							if(!utils.getParam("ShoppingCart")){
							utils.setParam('ShoppingCart','')
							}else{
							inputval();
							}
							add();//add event
							min();
						}//end status
					}//end readyState
				}//end onready....
			})//end tap
		});//end each
	}//end for loop
}

//详情页function
function imgDetail(){
	$('.showPic').css("display","block");

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
	$('.close').click(function(){
		$('.showPic').css('display','none')
	})
}

//input add
function add(){
	$('.add').click(function(){
		//get the value of the text_box
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
	})//end the click function
}

//input min
function min(){
	$('.min').click(function(){
		var ShoppingCart = utils.getParam("ShoppingCart");
		var jsonstr = JSON.parse(ShoppingCart.substr(1,ShoppingCart.length));
		var productlist = jsonstr.productlist;
		//get the value of the text_box
		var t=$(this).parent().find('input[class*=text_box]'); 
	    t.val(parseInt(t.val())-1);
	    // 向购物车加入商品
	    if(parseInt(t.val())<1){
	    	t.val(0);
	    	if(t.val() == 0){
	    		for(var i in productlist){
	    			if(product.name = productlist[i].name){
	    				console.log(productlist[i].name);
	    				delete productlist[i];
	    			}
	    		}
	    	}
	    }//end if
		product = {
            "name":$(this).parents('.detail').find('.name').html(),
            "price":$(this).parents('.detail').find('.price-number').html(),
            "amount":$(this).parent().find('input[class*=text_box]').val(),
            "amountName":$(this).parents('.detail').find('.price-amount').html(),
            "id":$(this).parents('.detail').attr('id'),
            }
        cart.addproduct(product);
	})//end the tap function
}

//页面显示以点数量
function inputval(){
	var ShoppingCart = utils.getParam("ShoppingCart");
		 var jsonstr = JSON.parse(ShoppingCart.substr(1,ShoppingCart.length));
		 var productlist = jsonstr.productlist;
		 for(var i in productlist){
		 	$('.main').find('#'+productlist[i].id).find("input[class*=text_box]").val(productlist[i].amount);
		 }
}

//为每一个点击的菜单加丄active类
function active(){
	var navTap = $('.nav div');//get the nav object
	for(i=0;i<=navTap.length;i++){
		$('#'+i).each(function() {
			$(this).click(function(){
				$('.active').removeClass('active');
				$(this).addClass('active');
			});//end click
		});//end each
	}//end for
}