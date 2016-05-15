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
	<title>我要投资</title>
	<link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
	<link href="/static/css/hytztj2.css" rel="stylesheet" type="text/css">
	<link rel="stylesheet" href="/static/css/bootstrap.min.css">
	<script type="text/javascript" src="/static/js/jquery-1.8.3.min.js"></script>
	<script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
	<style>
		*{
			margin:0;
			padding:0;
		}
		input{
			width:150px;
			height:30px;
			border:1px solid #eee;
		}
		.l{
			width:50px;
			height:30px;
			background:#eee;
		}
		.r{
			width:50px;
			height:30px;
			background:#eee;
		}
	</style>
</head>
<body>
<div class="hyztj2">
	<div class="invest-list-likeapp-top"><em></em>
		<div class="come-back"><a href="javascript:history.back(-1);"><span class="glyphicon glyphicon-chevron-left"></span>返回</a></div>
	</div>
	<header style="margin-left: 1em;line-height: 20px">
		<nav style="margin-top: 1em">
			<center><span>我要投资</span></center>
		</nav>
	</header>
    <?php $form = ActiveForm::begin(['id' => 'roamdeal', 'action' => Url::toRoute('/deal/roam-deal'), 'options' => ['enctype' => 'multipart/form-data','style'=>'margin-left:1em;margin-right:1em']]); ?>
    <input type='hidden' id='portion_wait' value="<?=$roaminfo['portion_wait']?>" />
    <input type='hidden' id='user_balance' value="<?=$balance?>" />

	<div class="form-group form-inline">
		<label for="">帐户余额:</label>
		<span><?=$balance?>元</span>
	</div>

	<div class="form-group form-inline">
		<label for="invest">投资份数:</label>
		<input type="text" class="form-control" name="roam_account" id="invest" placeholder="份">
	</div>

	<div class="form-group form-inline">
		<label for="">当前可投份数:<?=$roaminfo['portion_wait']?>份（<?=$roaminfo['account_min']?>元/份）</label>
	</div>

	<div class="form-group form-inline">
		<label for="">借款期限:<?=$roaminfo['borrow_period']?>个月</label>
	</div>


	<div class="form-group form-inline">
		<label for="paywd">交易密码:</label>
		<input type="password" class="form-control" name="paypassword" id="paywd" placeholder="">
	</div>

	<div class="btn">
        <input type="hidden"  name="borrow_userid" value="<?=$confimdealinfo['user_id']?>">
        <input type="hidden"  name="borrow_style" value="<?=$confimdealinfo['borrow_style']?>">
        <input type="hidden"  name="borrow_use" value="<?=$confimdealinfo['borrow_use']?>">
        <input type="hidden"  name="endtime_house" value="<?=$confimdealinfo['_borrow_end_time']?>">
        <input type="hidden" name="borrow_nid" value="<?=$roaminfo['borrow_nid']?>"/>
        <input type="hidden" name="account_min" value="<?=$roaminfo['account_min']?>"/>
        <?= Html::submitButton('立即认购', ['class'=>'btn btn-success','name' =>'submit-button']) ?>
	</div>
    <?php ActiveForm::end(); ?>
</div>
</body>
</html>

