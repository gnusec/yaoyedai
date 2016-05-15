<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
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
    <title><?= isset($this->context->nav_title) ? $this->context->nav_title : '' ?></title>
    <link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/static/css/li-app-monemass.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/static/css/bootstrap.min.css">
    <script type="text/javascript" src="/static/js/jquery-1.8.3.min.js"></script>
    <script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/static/js/diyou.js"></script>
</head>
<body>
<div class="liapp-chongz">
    <div class="invest-list-likeapp-top">
        <!--<div class="dropdown">
               <button type="button" class="btn dropdown-toggle" id="dropdownMenu1"  data-toggle="dropdown"> 个人信息 <span class="glyphicon  glyphicon-cog"></span></button>
               <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                         <li role="presentation"> <a role="menuitem" tabindex="-1" href="#">空1</a> </li>
                         <li role="presentation"> <a role="menuitem" tabindex="-1" href="#">空1</a> </li>
                         <li role="presentation"><a role="menuitem" tabindex="-1" href="#"> 空1 </a> </li>
                         <li role="presentation">  <a role="menuitem" tabindex="-1" href="#">空1</a> </li>
              </ul>
       </div>-->
        <div class="come-back"><a href="<?=Url::toRoute('/users/user')?>"><span class="glyphicon glyphicon-chevron-left"></span>返回</a></div>
    </div>
    <div class="cont">
        <div style="text-align: center;margin-top: 2em">
            <div class="top">
                <ul>
                    <li class="li-1"><span class=" 	glyphicon glyphicon-ok-sign" style="color:#00bacf;"></span>&nbsp;&nbsp;提现成功</li>
                    <li class="li-2">提现金额(元)</li>
                    <li class="li-3"><?=$balance?></li>
                </ul>
            </div>
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
        $(".liapp-chongz").css("height",gao);

        var gao=$(window).height();
        //alert(gao);
        var gaogao=(gao-60)+"px";
        //alert(gaogao);
        $(".fo-dinw").css("top",gaogao);
    });
</script>

