<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta name="Author" content="hejingfa">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta http-equiv="Content-Type" content="application/xhtml+xml;charset=UTF-8">
<meta http-equiv="Cache-Control" content="no-cache,must-revalidate">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0">
<meta name="format-detection" content="telephone=no, address=no">
<meta content="yes" name="apple-mobile-web-app-capable">
<meta content="black-translucent" name="apple-mobile-web-app-status-bar-style">
<title>修改支付密码</title>
<link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/static/css/li-app-regis-login.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/static/css/bootstrap.min.css">
 <link href="/static/css/tishi.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/static/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/js/diyou.js"></script>
<script type="text/javascript" src="/layer/layer.min.js"></script>
</head>
<body>
<div class="invest-regis-likeapp">
		<div class="invest-list-likeapp-top"><em>设置交易密码</em>
<!--            <div class="dropdown">-->
<!--                <button type="button" class="btn dropdown-toggle" id="dropdownMenu1"  data-toggle="dropdown"> 个人信息 <span class="glyphicon  glyphicon-cog"></span></button>-->
<!--                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">-->
<!--                    <li role="presentation"> <a role="menuitem" tabindex="-1" href="#">空1</a> </li>-->
<!--                    <li role="presentation"> <a role="menuitem" tabindex="-1" href="#">空1</a> </li>-->
<!--                    <li role="presentation"><a role="menuitem" tabindex="-1" href="#"> 空1 </a> </li>-->
<!--                    <li role="presentation">  <a role="menuitem" tabindex="-1" href="#">空1</a> </li>-->
<!--                </ul>-->
<!--            </div>-->
          <div class="come-back"><a href="javascript:history.back(-1);"><span class="glyphicon glyphicon-chevron-left"></span>返回</a></div>
        </div>
       <div class="regis-one"></div>

           <div class="regis-three"></div>
           <div class="regis-four">
               <img src="/static/images/app-mima.png" class="reg-2"/>
               <input type="password" placeholder="原交易密码" class="form-control put-2" name="oldpasswd"/>
               <img src="/static/images/app-mima.png" class="reg-2"/>
               <input type="password" placeholder="新交易密码" class="form-control put-2" name="newpasswd"/>
               <img src="/static/images/app-mima.png" class="reg-1"/>
               <input type="password" placeholder="请再次输入新交易密码" class="form-control put-3" style="border-top:1px solid #f9f9f9;" name="repeatpasswd"/>
           </div>
           <div class="regis-five">
               <button class="btn-2"  id="resetpaypwd">提交</button>
           </div>
</div>

<div class="zzc-liapp"></div>
<div class="zzc-main">
    <div class="zzc-top">
        <span class="sp-1">提示</span>
        <span class="glyphicon glyphicon-remove-sign sp-2 zzccl"></span>
    </div>
    <div class="zzc-cont">
        <p></p>
        <!--        <button>我要充值</button>-->
    </div>
</div>

</body>
</html>
<script type="text/javascript">
    diyou.use('wap_payword', function(wap) {
        wap.check()
        wap.closedtishi()
    });
</script>




