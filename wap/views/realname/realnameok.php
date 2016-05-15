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
<title>注册</title>
<link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/static/css/li-app-regis-login.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/static/css/bootstrap.min.css">
<script type="text/javascript" src="/static/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/static/js/bootstrap.min.js"></script>

</head>
<body>
<div class="invest-ybktcg-likeapp">
	<div class="one"><span class="glyphicon glyphicon-ok-sign" style="color:#00bacf;"></span>&nbsp;&nbsp;您开通易宝已成功</div>
    <div class="two"><a href="<?=Url::toRoute('/recharge')?>" style="text-decoration:none; color:#e35252;">我要充值</a></div>
    <div class="three">您账户金额为0。无法进行投资，请前往充值页面。</div>
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
	$(".invest-ybktcg-likeapp").css("height",gao);
	
});
</script>

