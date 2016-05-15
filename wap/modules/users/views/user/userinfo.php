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
<title>个人信息</title>
<link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/static/css/li-app-imtzr.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/static/css/bootstrap.min.css">
<script type="text/javascript" src="/static/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
</head>
<body>
<div class="li-app-imtzr">
		<div class="invest-list-likeapp-top"><em>个人信息</em>
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
       <div class="regis-one"></div>
       <div class="regis-three"></div>
       <div class="regis-four">
           <img src="/static/images/grxx-zsxm.png" class="reg-2"/>
           <div><span class="sp-le">真实姓名</span><span class="sp-ri"><?=$realName?></span></div>
           <img src="/static/images/grxx-sfz.png" class="reg-1"/>
           <div style="border-top:1px solid #f9f9f9;"><span class="sp-le">身份证号</span><span class="sp-ri"><?=$card_id?></span></div>
       </div>
        <div class="regis-four">
            <img src="/static/images/grxx-sjh.png" class="reg-2"/>
            <div style="border-top:1px solid #f9f9f9;"><span class="sp-le">用户名</span><span class="sp-ri"><?=$username?></span></div>
            <img src="/static/images/grxx-yhk.png" class="reg-1"/>
            <div style="border-top:1px solid #f9f9f9;"><span class="sp-le">我的银行卡</span><span class="sp-ri"><a href="#"><em class="glyphicon glyphicon-circle-arrow-right" style="color:#e35252;"></em></a></span></div>
       </div>
       <div class="regis-four">
           <img src="/static/images/app-mima.png" class="reg-2"/>
           <div style="border-top:1px solid #f9f9f9;border-bottom:1px solid #f9f9f9"><span class="sp-le">我是借款人</span><span class="sp-ri"><a href="#"><em class="glyphicon glyphicon-circle-arrow-right" style="color:#e35252;"></em></a></span></div>
       </div>
       <div class="regis-five">
           <a href="<?=Url::toRoute('/login/logout')?>"> <button>退出登录</button></a>
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
	$(".personal-message-likeapp").css("height",gao);
});
</script>

