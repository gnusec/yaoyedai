<?php

use yii\helpers\Url;

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
<title>注册</title>
<link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/static/css/li-app-regis-login.css" rel="stylesheet" type="text/css">
<link href="/static/css/tishi.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/static/css/bootstrap.min.css">
<script type="text/javascript" src="/static/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/js/diyou.js"></script>
<style>
.invest-regis-likeapp .regis-four .reg-3{
    position: absolute;
    width: 25px;
    height: 25px;
    top: 70px;
    left: 30px;
}
</style>
</head>
<body>
<div class="invest-regis-likeapp">
		<div class="invest-list-likeapp-top"><em>注册药业贷</em>
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
       <div class="regis-two">
       			<img src="/static/images/app-sjh.png" class="reg-3"/>
                <input type="text" placeholder="输入手机号" class="form-control put-1" name="phone"/>
       </div>
       <div class="regis-three"></div>
       <div class="regis-four">
           <img src="/static/images/app-mima.png" class="reg-2"/>
           <input type="password" placeholder="密码6~20个字符" class="form-control put-2" name="passwd"/>
           <img src="/static/images/app-mima.png" class="reg-1"/>
           <input type="password" placeholder="请再次输入密码" class="form-control put-3" style="border-top:1px solid #f9f9f9;" name="repeatpasswd"/>
           <span style="<?php if(!empty($inviteid)) :?> display: none <?php endif; ?>">
               <img src="/static/images/app-mima.png" class="reg-1"/>
               <img src="/static/images/app-mima.png" class="reg-3"/>
               <input type="text" placeholder="填写邀请码" value="<?= $inviteid ?>"  class="form-control put-3" style="border-top:1px solid #f9f9f9;" name="invitecode"/>
          </span>
       </div>
       <div class="regis-five">
           <div class="checkbox"> <label><input type="checkbox" value="" style=" margin-top:30px;" name="agree">我同意药业贷《药业贷注册协议》</label></div>
           <button id="wap_reg">下一步</button>
           <ul>
               <li>温馨提示：</li>
               <li>为保护用户隐私，用户名涉及到发生购买行为的合同有效性，故暂不支持修改，敬请原谅。</li>
           </ul>
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
    diyou.use('wap_reg', function(wap) {
            wap.check()
            wap.closedtishi()
    });
</script>


