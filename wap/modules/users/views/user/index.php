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
<title>资金管理</title>
<link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/static/css/newzm.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/static/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
<style>
.invlist-new .invest-list-likeapp-footer{  height:60px;border-top:1px solid #aeaeae;  position:fixed; z-index:300; background-color:#333; width:100%;  margin:0 auto;bottom:0; right:0;}
.invlist-new .invest-list-likeapp-footer .xuanx{ width:25%; height:60px; float:left;}
.invlist-new .invest-list-likeapp-footer .xuanx li{ width:100%; text-align:center;}
.invlist-new .invest-list-likeapp-footer .xuanx .mo{ font-size:11px; line-height:18px;}
.invlist-new .invest-list-likeapp-footer .xuanx a{ text-decoration:none;}

</style>
</head>
<body>
<div class="newzm">
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
       <div class="newzm-main">
       			<div class="top"><img src="/static/images/newzm-lab.jpg"/>
					<span id="le-bu">恭喜您获得<i>1000</i>元特权本金</span>
					<a href="#"><span class=" glyphicon glyphicon-chevron-right" id="ri-bu"></span></a>
				</div>
                <div class="sgg-1"  style="border-bottom:1px solid #999">
					<div class="sgg-2" style="border-right:1px solid #999"><p>可用余额（元）</p><strong><?=$balance?></strong>
					</div>
				</div>
                <div class="sgg-1" style="border-bottom:1px solid #999">
					<div class="sgg-2"><p>冻结金额（元）</p>
						<strong style="color:#fbb03b"><?=$frost?></strong>
					</div>
				</div>
                <div class="sgg-1">
					<div class="sgg-2" style="border-right:1px solid #999"><p>账户总额（元）</p><strong><?=$total?></strong>
					</div>
				</div>
                <div class="sgg-1">
					<div class="sgg-2"><p>当前待收本金（元）</p><strong><?=$tender_wait_capital?></strong>
					</div>
				</div>
                <div class="syje">
                		<div class="top">收益</div>
                        <div class="bo-2" style="border-right:1px solid #fff">
                        		<p class="p1">已收利息</p>
                                <p class="p2"><?=$recover_yes_interest?><span>元</span></p>
                        </div>
                        <div class="bo-2">
                       		 <p class="p1">待收利息</p>
                             <p class="p2"><?=$tender_wait_interest?><span>元</span></p>
                        </div>
                </div>
                <div class="bbu">
					<a href="<?=Url::toRoute('/recharge')?>"><button>充值</button></a><a href="<?=Url::toRoute('/withdraw')?>"><button style="margin-left:10%;">提现</button></a>
                </div>
                <div class="fo4bu" style=" position:relative;">
                		<div style="width:100%; height:1px; border-bottom:1px solid #f2f2f2; position:absolute; top:32px;"></div>
                		<a href="<?=Url::toRoute('/traderecord')?>" style=" border-right:1px solid #f2f2f2; "><img src="/static/images/appfp-xiao1.png"/>交易记录&nbsp;&nbsp;&nbsp;</a>
                        <a href="<?=Url::toRoute('/traderecord/deal-record')?>"><img src="/static/images/appfp-xiao1.png"/>投资记录</a>
                        <a href="#" style=" border-right:1px solid #f2f2f2;"><img src="/static/images/appfp-xiao1.png"/>银行卡管理</a>
                        <a href="<?=Url::toRoute('/users/user/userinfo')?>"><img src="/static/images/appfp-xiao1.png"/>个人信息</a>
                </div>
       </div>
       <div style="height:60px;border-top:1px solid #aeaeae;  position:fixed; z-index:300; background-color:#333; width:100%;  margin:0 auto;bottom:0; right:0;" class="invest-list-likeapp-footer fo-dinw">
                          <div class="xuanx f1" style="width:25%; height:60px; float:left;">
                              <a href="<?=Url::toRoute('/site/deal-list')?>">
                                  <ul>
                                      <li class="ding" style="width:100%; text-align:center;"><i class="i1">
                                              <img src="/static/images/invest-click.png" class="im1" style="width:25px; height:25px;"></i>
                                      </li>
                                      <li class="mo" style="width:100%; text-align:center;font-size:11px; line-height:18px;">投资项目</li>
                                  </ul>
                              </a>
                          </div>
                          <div class="xuanx f2" style=" width:25%; height:60px; float:left;">
                              <a href="<?=Url::toRoute('/users/invitefriend')?>">
                                  <ul>
                                      <li class="ding" style="width:100%; text-align:center;"><i class="i2"><img src="/static/images/invite-click.png" class="im1" style="width:25px; height:25px;"></i></li>
                                      <li class="mo" style="width:100%; text-align:center;font-size:11px; line-height:18px;">邀请好友</li>
                                  </ul>
                              </a>
                          </div>
                          <div class="xuanx f3" style=" width:25%; height:60px; float:left;">
                              <a href="<?=Url::toRoute('/users/user')?>">
                                  <ul>
                                      <li class="ding" style="width:100%; text-align:center;"><i class="i3"><img src="/static/images/fundman-click.png" class="im1" style="width:25px; height:25px;"></i></li>
                                      <li class="mo" style="width:100%; text-align:center;"font-size:11px; line-height:18px;>资金管理</li>
                                  </ul>
                              </a>
                          </div>
                          <div class="xuanx f4" style=" width:25%; height:60px; float:left;">
                              <a href="<?=Url::toRoute('/users/user/userinfo')?>">
                                  <ul>
                                      <li class="ding" style="width:100%; text-align:center;"><i class="i4"><img src="/static/images/message-click.png" class="im1" style="width:25px; height:25px;"></i></li>
                                      <li class="mo" style="width:100%; text-align:center;"font-size:11px; line-height:18px;>个人信息</li>
                                  </ul>
                              </a>
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