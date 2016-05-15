<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use wap\assets\AppAsset;
use common\widgets\Alert;
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="Author" content="hejingfa">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="Cache-Control" content="no-cache,must-revalidate">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
    <meta name="format-detection" content="telephone=no, address=no">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black-translucent" name="apple-mobile-web-app-status-bar-style">

    <title>登录</title>
    <link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="/static/css/login.css" rel="stylesheet" type="text/css">
    <link href="/static/css/tishi.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/static/css/reset.css">
    <script src="/static/js/hm.js"></script><script type="text/javascript" src="/static/js/jquery-wx.1.8.3.min.js"></script>
    <script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/static/js/login.js"></script>
    <script type="text/javascript" src="/static/js/diyou.js"></script>
    <script type="text/javascript" src="/static/js/jquery-1.8.3.min.js"></script>

</head>
<body>
<?php $this->beginBody() ?>

    <div class="invest-dl-likeapp" style="position: relative; height: 799px;">
        <div class="invest-list-likeapp-top"><em>我的账户</em>
            <!--<div class="dropdown">
                   <button type="button" class="btn dropdown-toggle" id="dropdownMenu1"  data-toggle="dropdown"> 个人信息 <span class="glyphicon  glyphicon-cog"></span></button>
                   <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                             <li role="presentation"> <a role="menuitem" tabindex="-1" href="#">空1</a> </li>
                             <li role="presentation"> <a role="menuitem" tabindex="-1" href="#">空1</a> </li>
                             <li role="presentation"><a role="menuitem" tabindex="-1" href="#"> 空1 </a> </li>
                             <li role="presentation">  <a role="menuitem" tabindex="-1" href="#">空1</a> </li>
                  </ul>
           </div>-->
        </div>

        <?= $content ?>

    </div>
<?php $this->endBody() ?>
</body>
</html>

<script>
    $(document).ready(function(){
        var gao=$(window).height();
        $(".invest-dl-likeapp").css("height",gao);
    });
</script>
<?php $this->endPage() ?>
