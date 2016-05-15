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
<link href="/static/css/tishi.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/static/css/bootstrap.min.css">
<script type="text/javascript" src="/static/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/static/js/diyou.js"></script>
</head>
<body>
<div class="hyztj2">
	 <div class="invest-list-likeapp-top"><em></em>
          <div class="come-back"><a href="javascript:history.back(-1);"><span class=" 	glyphicon glyphicon-chevron-left"></span>返回</a></div>
        </div>
		<div class="noname">绑卡</div>
	<?php $form = ActiveForm::begin(['id' => 'bank', 'action' =>  Url::toRoute('/bank/go-bank'), 'options' => ['enctype' => 'multipart/form-data','style'=>'margin-left:1em;margin-right:1em']]); ?>

	<div class="form-group form-inline">
		<label for="">真实姓名:</label>
		<span><?=$realName?></span>
	</div>
	<div class="form-group ">
		<label for="openuser">开户名:</label>
		<input type="text" class="form-control" id="openuser" placeholder="">
	</div>
	<div class="form-group">
		<label for="openuser">选择银行:</label>
		<select name="bank" class="form-control">
			<option>请选择</option>
			<?php  if(!empty($banklist) && is_array($banklist)):?>
				<?php  foreach ($banklist as $key=>$val) :?>
					<option value="<?=$val['value']?>"><?=$val['name']?></option>
				<?php endforeach; ?>
			<?php endif; ?>
		</select>
	</div>
	<div class="form-group">
		<label for="openuser">开户所在地:</label>
		<script src="/bank/get-areas"></script>
	</div>
	<div class="form-group">
		<label for="openbranch">开户行:</label>
		<input type="text" class="form-control" name="branch" id="openbranch" placeholder="">
	</div>
	<div class="form-group">
		<label for="banknum">银行卡卡号:</label>
		<input type="text" class="form-control" name="account" id="banknum" placeholder="">
	</div>
	<div class="form-group">
		<label for="confirmbanknum">确认卡号:</label>
		<input type="text" class="form-control" name="confirm_account" id="confirmbanknum" placeholder="">
	</div>
	<?= Html::submitButton('确认', ['class'=>'btn btn-success','name' =>'submit-button']) ?>
	<?php ActiveForm::end(); ?>
				<div style="margin-left: 1em;margin-right: 1em">
					<h3>温馨提示</h3>
					<div>1.如果您填写的开户行支行不正确,可能将无法成功提现,由此产生的提现费用将不予返还。</div>
					<div>2.如果您不确定开户行支行名称,可打电话到所在地银行的营业网点询问或上网查询。</div>
					<div>3.不支持提现至信用卡账户。</div>
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
<script type="text/javascript">
    diyou.use('wap_bank', function(wap) {
        wap.checkbink()
        wap.closedtishi()
    });

</script
</body>
</html>





