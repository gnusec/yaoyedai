<?php

use yii\helpers\Url;

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="Author" content="hejingfa">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<!-- Mobile Devices Support @begin -->
<meta http-equiv="Content-Type" content="application/xhtml+xml;charset=UTF-8">
<meta http-equiv="Cache-Control" content="no-cache,must-revalidate">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0">
<meta name="format-detection" content="telephone=no, address=no">
<meta content="yes" name="apple-mobile-web-app-capable">
<!-- apple devices fullscreen -->
<meta content="black-translucent" name="apple-mobile-web-app-status-bar-style">
<!-- Mobile Devices Support @end -->
<title></title>
<link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/static/css/newac2.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/static/css/bootstrap.min.css">
<script type="text/javascript" src="/static/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/static/js/bootstrap.min.js"></script>

</head>
<body>
<div class="newac23">
		<div class="invite-fri-likeapp-top"><em></em>
     					<!--<div class="dropdown">
                                <button type="button" class="btn dropdown-toggle" id="dropdownMenu1"  data-toggle="dropdown"> 个人信息 <span class="glyphicon  glyphicon-cog"></span></button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                          <li role="presentation"> <a role="menuitem" tabindex="-1" href="#">空1</a> </li>
                                          <li role="presentation"> <a role="menuitem" tabindex="-1" href="#">空1</a> </li>
                                          <li role="presentation"><a role="menuitem" tabindex="-1" href="#"> 空1 </a> </li>
                                          <li role="presentation">  <a role="menuitem" tabindex="-1" href="#">空1</a> </li>
                               </ul>
						</div>-->
          <div class="come-back"><a href="javascript:history.back(-1);"><span class=" 	glyphicon glyphicon-chevron-left"></span>返回</a></div>
        </div>
       <div class="newact-main">
       			<div class="on-le">
                		<div class="but-some">
                        		<a href="<?=Url::toRoute('/users/invitefriend/share-active')?>"><button style="border-right:1px solid #fff;"><img src="/static/images/new-ac-1.jpg"/></button></a><button style="border-left:1px solid #fff;"><img src="/static/images/new-ac-2.jpg"/></button>
                        </div>
                </div>
                <div class="tw-le">
                		<p>活动简述：投100元得2000元特权本金，邀请好友投资奖1000元特权本金，好友再邀请好友投资再奖1000元特权本金。</p>
                </div>
                <div class="thr-le">
					<a href="<?=Url::toRoute('/users/invitefriend/share-active')?>"><button>我要邀请</button></a>
                </div>
                <div class="xinz">
                		<a href="<?=Url::toRoute('/users/invitefriend/view-friend-nums')?>"><button style="border-right:1px solid #fff;"><img src="/static/images/bbbee1.jpg"/></button></a><a href="<?=Url::toRoute('/users/invitefriend/view-friend-money')?>"><button style="border-left:1px solid #fff;"><img src="/static/images/bbbee2.jpg"/></button></a>
                </div>
                <div class="fu-le">
                		<p class="p1">声&nbsp;&nbsp;明</p>
                        <p class="p2">如邀请人采用某些特殊技术手段，或是盗用他人身份信息，扰乱正常的邀请秩序，一经核实，药业贷保留拒绝支付奖励的权利。
</p>
                </div>
       </div>     
</div>


</body>
</html>
<script>


$(document).ready(function(){
	//var gao= window.screen.height;
	var gao=$(window).height();
	//alert(gao);
	//var gaogao=(gao-60)+"px";
	//alert(gaogao);
	$(".liapp-yqhymess5").css("height",gao);
	var gao=$(window).height();
	//alert(gao);
	var gaogao=(gao-60)+"px";
	//alert(gaogao);
	$(".fo-dinw").css("top",gaogao);

});
</script>

<script type="text/javascript">
var intDiff = parseInt(100000);//倒计时总秒数量
function timer(intDiff){
	window.setInterval(function(){
	var day=0,
		hour=0,
		minute=0,
		second=0;//时间默认值		
	if(intDiff > 0){
		day = Math.floor(intDiff / (60 * 60 * 24));
		hour = Math.floor(intDiff / (60 * 60)) - (day * 24);
		minute = Math.floor(intDiff / 60) - (day * 24 * 60) - (hour * 60);
		second = Math.floor(intDiff) - (day * 24 * 60 * 60) - (hour * 60 * 60) - (minute * 60);
	}
	if (minute <= 9) minute = '0' + minute;
	if (second <= 9) second = '0' + second;
	//$('#day_show').html(day+"天");
	$('.bbb').html('<s id="h"></s>'+day+"天"+hour+'时'+'<s></s>'+minute+'分'+'<s></s>'+second+'秒');
	//$('#minute_show').html('<s></s>'+minute+'分');
//	$('#second_show').html('<s></s>'+second+'秒');
	intDiff--;
	}, 1000);
} 
$(function(){
	timer(intDiff);
});	
</script>