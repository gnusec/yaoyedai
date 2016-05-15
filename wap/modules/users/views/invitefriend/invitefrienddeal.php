<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
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
<title>交易记录</title>
<link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/static/css/li-app-monemass.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/static/css/bootstrap.min.css">
<script type="text/javascript" src="/static/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/static/js/bootstrap.min.js"></script>

</head>
<body>
<div class="liapp-jyjl-mas">
		<div class="invest-list-likeapp-top" style="background:#a93434"><em>交易记录</em>
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
 		<div class="contd">
<!--        		<div class="one-le">-->
<!--                		<table>-->
<!--                        		<tr>-->
<!--                                		<td class="td-1">2015年</td><td class="td-2">8月份</td>-->
<!--                                </tr>-->
<!--                        </table>-->
<!--                </div>-->
                <div class="tw-le">
                    <table class="table">
                        <thead>
                        <tr>
                            <td align="center">投资人</td>
                            <td align="center">投资金额</td>
                            <td align="center">投资时间</td>
                        </tr>
                        </thead>
                        <tbody>
                            <?php if(!empty($list) && is_array($list)) :?>
                            <?php foreach($list as $key=>$val): ?>
                                    <tr>
                                        <td align="center"><?=$val['username']?></td>
                                        <td align="center"><?=$val['account'] ?>元</td>
                                        <td align="center"><?php echo date('Y-m-d',$val['addtime']) ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>

                </div>
            <div style="text-align: center">
                <?= LinkPager::widget([
                    'pagination' => $pagination,
                    'firstPageLabel'=>'首页',
                    'lastPageLabel'=>'尾页',
                    'prevPageLabel' => '上一页',
                    'nextPageLabel' => '下一页',
                    'maxButtonCount'=>0,
                ]) ?>
            </div>
                <div style="width:100%; height:60px;"></div>
        </div>
        <div class="invest-list-likeapp-footer fo-dinw" style="background:#333">
         			<div class="xuanx f1"><a href="<?=Url::toRoute('/site/deal-list')?>">
                    		<ul>
                            		<li class="ding"><i class="i1"><!--<img src="images/appfooter-11.png" class="im1"/>--></i></li>
                                    <li class="mo">药业贷</li>
                            </ul></a>
                    </div>
                    <div class="xuanx f2"><a href="<?=Url::toRoute('/site/deal-list')?>">
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


<script>


$(document).ready(function(){
	//var gao= window.screen.height;
	var gao=$(window).height();
	//alert(gao);
	//var gaogao=(gao-60)+"px";
	//alert(gaogao);
	$(".liapp-jyjl-mas").css("height",gao);
	
	
	
	
	var gao=$(window).height();
	//alert(gao);
	var gaogao=(gao-60)+"px";
	//alert(gaogao);
	$(".fo-dinw").css("top",gaogao);
	

	
});
</script>

