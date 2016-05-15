<?php
use yii\helpers\Url;
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta name="Author" content="hejingfa">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<!-- Mobile Devices Support @begin -->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="Cache-Control" content="no-cache,must-revalidate">
	<meta http-equiv="pragma" content="no-cache">
	<meta http-equiv="expires" content="0">
	<meta name="format-detection" content="telephone=no, address=no">
	<meta content="yes" name="apple-mobile-web-app-capable">
	<!-- apple devices fullscreen -->
	<meta content="black-translucent" name="apple-mobile-web-app-status-bar-style">
	<!-- Mobile Devices Support @end -->
	<title>投资详情页</title>
	<link href="/static/css/reset.css" rel="stylesheet" type="text/css">
	<link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/static/css/li-app-wx.css" rel="stylesheet" type="text/css">
	<link href="/static/css/tishi.css" rel="stylesheet" type="text/css">
	<script src="/static/js/hm.js"></script><script type="text/javascript" src="/static/js/jquery-wx.js"></script>
	<script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/layer/layer.min.js"></script>

</head>
<body>
<div class="invest-parti-likeapp">
		<div class="invest-list-likeapp-top">
     					<div class="dropdown">
                                <!-- <button type="button" class="btn dropdown-toggle" id="dropdownMenu1"  data-toggle="dropdown" > 个人信息 <span class="glyphicon  glyphicon-cog"></span></button>
                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                          <li role="presentation"> <a role="menuitem" tabindex="-1" href="#">空1</a> </li>
                                          <li role="presentation"> <a role="menuitem" tabindex="-1" href="#">空1</a> </li>
                                          <li role="presentation"><a role="menuitem" tabindex="-1" href="#"> 空1 </a> </li>
                                          <li role="presentation">  <a role="menuitem" tabindex="-1" href="#">空1</a> </li>
                               </ul> -->
						</div>
                         <div class="come-back"><a href="javascript:history.go(-1);"><span class="glyphicon glyphicon-chevron-left"></span>返回</a></div>
        </div>
        <div class="invest-parti-likeapp-main">
        		<div class="one-le">
                		<div class="le">
							<ul>
								<li class="big"><em><?=$dealinfo['borrow_apr']?>%</em></li>
								<li>预期年化收益</li>
							</ul>
                        </div>
                        <div class="mid">
                        		<p style="width:100%; font-size:28px; color:#000; text-align:center; margin-top:34px;font-weight:200;"><?=$dealinfo['borrow_account_wait']?></p>
                        		<p style="width:100%; font-size:11px; color:#777; text-align:center;margin-top:3px;">剩余金额(元)</p>
                          </div>
                        <div class="ri">
							<ul>
								<li class="big" style="color:#000"><em><?=$dealinfo['borrow_period_name']?></em></li>
								<li>期限(<?=$dealinfo['style_title']?>)</li>
							</ul>
                        </div>
                </div>
                <div class="invest-parti-twole">
                		<div class="le">融资金额&nbsp;&nbsp;<?=$dealinfo['account']?>元</div>
                        <div class="ri">项目名称：&nbsp;&nbsp;<?=$dealinfo['name']?></div>
                </div>
                <div style="height:17px; width:100%; background-color:#f9f9f9;"></div>
                <div class="sixuanx" onclick="location.href='<?= Url::toRoute(['/deal/basic-info','dealid'=>$dealinfo['borrow_nid']])?>'" style="cursor:pointer">
					<span class="sp-1">基本信息</span>
					<a href="<?= Url::toRoute(['/deal/basic-info','dealid'=>$dealinfo['borrow_nid']])?>" >
						<span class="sp-2 glyphicon glyphicon-arrow-right"></span>
					</a>
				</div>
                <div class="sixuanx" onclick="location.href='<?= Url::toRoute(['/deal/trade-record','dealid'=>$dealinfo['borrow_nid']])?>'" style="cursor:pointer">
					<span class="sp-1">交易记录</span>
					<a href="<?= Url::toRoute(['/deal/trade-record','dealid'=>$dealinfo['borrow_nid']])?>"><span class="sp-2 glyphicon glyphicon-arrow-right"></span>
					</a>
				</div>
				<?php if(false): ?>
                <div class="sixuanx" onclick="location.href='<?= Url::toRoute(['/deal/flow-record','dealid'=>$dealinfo['borrow_nid']])?>'" style="cursor:pointer">
					<span class="sp-1">流转历史记录</span>
					<a href="<?= Url::toRoute(['/deal/flow-record','dealid'=>$dealinfo['borrow_nid']])?>"><span class="sp-2 glyphicon glyphicon-arrow-right"></span>
					</a>
				</div>
				<?php endif; ?>
                <div class="invest-parti-thle" style="font-size:12px"><span class="glyphicon glyphicon-ok-circle"></span>&nbsp;&nbsp;账户资金安全由易宝支付监管</div>
                <!-- <div class="syje">&nbsp;&nbsp;&nbsp;剩余金额：0元</div> -->
                <div style="width:100%; height:60px;"></div>
				<?php if($dealinfo['borrow_account_wait']!=0){ ?>
                <div class="fo-dinw2" style="height: 60px; width: 100%; position: fixed; z-index: 300; background-color: rgb(255, 255, 255); top: 422px;">
					<button style="width:100%; height:35px; background-color:#e35252;border:1px solid #e35252; line-height:35px; text-align:center; font-size:12px; color:#fff;margin-top:-5px;" onclick="location.href='<?= Url::toRoute(['/deal/confim','dealid'=>$dealinfo['borrow_nid']])?>'">我要投资</button>
                </div>
				<?php } ?>
        </div>
</div>
<div class="zzc-liapp"></div>
<div class="zzc-main">
	<div class="zzc-top">
		<span class="sp-1">提示</span><span class="glyphicon glyphicon-remove-sign sp-2 zzccl"></span>
	</div>
	<div class="zzc-cont">
		<p></p>
	</div>
</div>

<script>
$(function() {
    var gao=$(window).height();
	//var gao= window.screen.height;
	//alert(gao);
	var gaogao=(gao-60)+"px";
	//alert(gaogao);
	$(".fo-dinw2").css("top",gaogao);

});
</script>

</body>
</html>