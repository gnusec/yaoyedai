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
<title>我要投资</title>
<link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/static/css/hytztj2.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/static/css/bootstrap.min.css">  
<script type="text/javascript" src="/static/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
<style>
.invest-list-likeapp-footer{  height:60px;border-top:1px solid #aeaeae;  position:fixed; z-index:300; background-color:#fff; width:100%;  margin:0 auto;}
.invest-list-likeapp-footer .xuanx{ width:25%; height:60px; float:left;}
.invest-list-likeapp-footer .xuanx li{ width:100%; text-align:center;}
.invest-list-likeapp-footer .xuanx .ding .i1{ width:25px; height:25px; display:inline-block; margin-top:10px; background:url(/static/images/appfp-xiao1.png);}
.invest-list-likeapp-footer .xuanx .ding .i1:hover{ background:url(../images/appfocai-1.png);}
.invest-list-likeapp-footer .xuanx .ding .i2{ width:25px; height:25px; display:inline-block; margin-top:10px; background:url(/static/images/appfp-xiao2.png);}
.invest-list-likeapp-footer .xuanx .ding .i2:hover{ background:url(../images/appfocai-2.png);}
.invest-list-likeapp-footer .xuanx .ding .i3{ width:25px; height:25px; display:inline-block; margin-top:10px; background:url(/static/images/appfp-xiao4.png);}
.invest-list-likeapp-footer .xuanx .ding .i3:hover{ background:url(../images/appfocai-3.png);}
.invest-list-likeapp-footer .xuanx .ding .i4{ width:25px; height:25px; display:inline-block; margin-top:10px; background:url(/static/images/appfp-xiao3.png);}
.invest-list-likeapp-footer .xuanx .ding .i4:hover{ background:url(../images/appfocai-4.png);}
.invest-list-likeapp-footer .xuanx .mo{ font-size:11px; line-height:18px;}
.invest-list-likeapp-footer .xuanx a{ text-decoration:none;}
</style>
</head>
<body>
<div class="hyztj2">
	 <div class="invest-list-likeapp-top"><em></em>
     	<div class="come-back"><a href="javascript:history.back(-1);"><span class="glyphicon glyphicon-chevron-left"></span>返回</a></div>
     </div>
      <div class="title">
		  <center><h5>借款方商业描述:</h5></center>
			<div style="padding-left:30px;">
				<?=$basicinfo?>
			</div>
			   <div class="invest-list-likeapp-footer fo-dinw" style="background:#333;position:fixed;top:740px;">
                     			<div class="xuanx f1"><a href="<?=Url::toRoute('/')?>">
                                		<ul>
                                        		<li class="ding"><i class="i1"></i></li>
                                                <li class="mo">药业贷</li>
                                        </ul></a>
                                </div>
                                <div class="xuanx f2"style="><a href="<?=Url::toRoute('/site/deal-list')?>">
                                		<ul>
                                        		<li class="ding"><i class="i2"></i></li>
                                                <li class="mo">我要投资</li>
                                        </ul></a>
                                </div>
                                <div class="xuanx f3"><a href="<?=Url::toRoute('/users/user/userinfo')?>">
                                			<ul>
                                        		<li class="ding"><i class="i3"></i></li>
                                                <li class="mo">个人信息</li>
                                        </ul></a>
                                </div>
                                <div class="xuanx f4"><a href="<?=Url::toRoute('/traderecord/deal-record')?>">
                                		<ul>
                                        		<li class="ding"><i class="i4"></i></li>
                                                <li class="mo">投资记录</li>
                                        </ul></a>
                                </div>
                     </div>
   </div>
</body>
</html> 

