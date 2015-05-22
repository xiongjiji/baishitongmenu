$(document).ready(function($) {
	init();//调用init函数

	navTap();
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
								$('.detail-pic').eq(i).css('backgroundImage', "url("+obj1[i].img+")");//css 要传入一个字符串
								$('.detail').eq(i).append('<table id="tap"><tr><td><input class="min" name="" type="button" value="-" /><input class="text_box" name="" type="text" value="0" /><input class="add" name="" type="button" value="+" /></td></tr><div>');
			
							} else {
							}//结束动态生成
						}//end the for loop
					}//end thd request.status
				}//end the request.readyState
			}//end the onreadystatechange
}//end the firstNav	

//为每个Nav绑定click时间 动态显示main
function navTap(){
	var navTap = $('.nav div');//get the nav object
	for(i=0;i<=navTap.length;i++){
		$('#'+i).each(function() {
			$(this).tap(function(){
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
								$('.detail-pic').eq(i).css('backgroundImage', "url("+obj1[i].img+")");//css 要传入一个字符串
								$('.detail').eq(i).append('<table id="tap"><tr><td><input class="min" name="" type="button" value="-" /><input class="text_box" name="" type="text" value="0" /><input class="add" name="" type="button" value="+" /></td></tr><div>');
			
								} else {
								}//结束动态生成
							}//end the for loop
						}//end status
					}//end readyState
				}//end onready....
			})//end tap
		});//end each
	}//end for loop
}