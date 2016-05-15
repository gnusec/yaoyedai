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
<title>我要投资</title>
<link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/static/css/hytztj2.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/static/css/bootstrap.min.css">  
<script type="text/javascript" src="/static/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/static/js/bootstrap.min.js"></script>

</head>
<body>
<div class="hyztj2">
		<div class="invest-list-likeapp-top"><em></em>
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
        <div class="search">
            <?php $form = ActiveForm::begin(['id' => 'friends', 'method'=>'get','action' => Url::toRoute('/users/invitefriend/view-friend-nums'), 'options' => ['enctype' => 'multipart/form-data']]); ?>
        		<div class="star-input"><input type="date" name="begin_time" value="<?php if($begin_time){echo $begin_time;} ?>"/></div>
                <div class="with">到</div>
                <div class="stop-input"><input type="date" name="end_time" value="<?php if($end_time){echo $end_time;} ?>"/></div>
                <div class="search-but">
                    <?= Html::submitButton('查询', ['class'=>'','name' =>'submit-button']) ?>
                </div>
            <?php ActiveForm::end(); ?>
        </div>
        <div class="content">
        		<div class="level-one">
                		<img src="/static/images/appfocai-3.png"/>
                		<div class="left">邀请好友</div><div class="right"><?=$inviternums?>位</div>
                </div>
                <div class="level-one">
                		<img src="/static/images/appfocai-3.png"/>
                		<div class="left">一级奖励</div><div class="right"><?=$oneLevelNums?>位</div>
                </div>
                <div class="level-one">
                		<img src="/static/images/appfocai-3.png"/>
                		<div class="left">二级奖励</div><div class="right"><?=$twoLevelNums?>位</div>
                </div>

        </div>
        <div class="noname">好友投资成功后，可获得体验金奖励</div>
      	<table>
        		<tr class="biaoti">
                		<td>好友</td><td>一级奖励</td><td>二级奖励</td>
                </tr>
        </table>
        <table>
            <?php if(!empty($list) && is_array($list)): ?>
            <?php foreach($list as $key=>$val): ?>
        		<tr>
                		<td><?= $val['username'] ?></td><td><?=$val['one_level_voucher_money']?>元</td><td><?=$val['twolevel']?>元</td>
                </tr>
            <?php endforeach; ?>
            <?php endif; ?>

        </table>
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
</div>


</body>
</html> 



