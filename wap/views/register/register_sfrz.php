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
<title>身份认证</title>
<link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/static/css/li-app-regis-login.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/static/css/bootstrap.min.css">
<script type="text/javascript" src="/static/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/js/diyou.js"></script>
</head>
<body>
<div class="invest-regissfrz-likeapp">
		<div class="invest-list-likeapp-top"><em>实名认证</em>
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
       <div class="regis-two">
       			<img src="/static/images/app-zsxm.png" class="reg-3"/>
                <input type="text" placeholder="输入您的姓名" class="form-control put-1"/>
       </div>
       <div class="regis-three"></div>
       <div class="regis-four">
       			<img src="/static/images/app-sfzh.png" class="reg-2"/>
                <input type="text" placeholder="输入您的身份证号" class="form-control put-2"/>
      		
       </div>
       <div class="regis-five">
       					
                        <button id="openyibao">开通易宝</button>
                        <ul>
                        		<li>温馨提示：</li>
                                <li>为了确保您的投资资金安全及资金的流动透明，请您实名认证且开通第三方资金托管易宝支付账户</li>
                        </ul>
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
	$(".invest-regissfrz-likeapp").css("height",gao);
	
});
</script>
<script type="text/javascript">
    diyou.use('wap_reg', function(wap) {
        wap.opneYibao()
    });
</script>

