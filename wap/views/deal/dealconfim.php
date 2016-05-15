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
		.txt{
			border:1px solid #eee;
		}
		.txt1{
			border:1px solid #eee;
		}
		.foot{
			text-align:center;
			margin-top:10px;
		}
		.footer{
			text-align:center;
			margin-top:10px;
		}
	</style>
</head>
<body>
<div class="hyztj2">
	<div class="invest-list-likeapp-top"><em></em>
		<div class="come-back"><a href="javascript:history.back(-1);"><span class="glyphicon glyphicon-chevron-left"></span>返回</a></div>
	</div>
    <?php $form = ActiveForm::begin(['id' => 'deal', 'action' => Url::toRoute('/deal/deal'), 'options' => ['enctype' => 'multipart/form-data']]); ?>
    <input type="hidden" name="borrow_nid" id="borrow_nid" value="<?=$confimdealinfo['borrow_nid']?>" />
    <div style="margin-left:1em;margin-top: 0.5em;">
	<header>
			<div class="form-group form-inline">
				<label for="">当前可投金额</label>
				<span><?=$confimdealinfo['borrow_account_wait']?>元</span>
			</div>
			<div class="form-group form-inline">
				<label for="">借款期限</label>
				<span><?=$confimdealinfo['borrow_period_name']?></span>
			</div>

			<?php if($confimdealinfo['borrow_type']!='welfare'): ?>
			<div class="form-group form-inline">
				<label for="">账户余额</label>
				<span><?=$balance?>元</span>
			</div>
			<?php endif; ?>

			<div class="form-group">
				<label for="exampleInputEmail1">投资金额</label>

				<?php if($confimdealinfo['tender_account_min']>0 && $confimdealinfo['borrow_account_wait']<$confimdealinfo['tender_account_min']){ ?>　
					<input type="text" class="form-control"   name="tender_account_wait"  value="<?=$confimdealinfo['borrow_account_wait']?>" disabled="true" />
					<input type="hidden" name="account" id='tender_money' value="<?=$confimdealinfo['borrow_account_wait']?>"/>
				<?php }else{ ?>
					<?php if($confimdealinfo['borrow_type'] == 'welfare'){ ?>
						<input type="hidden" name="account" id='tender_money' value="" class="basic_input"/>
						<input type="text" name="tender_account_wait" id="welfare_account" value="" class="form-control"  disabled="true"/>
					<?php  }else{ ?>
						<input type="text"  name="account" id='tender_money' value=""  placeholder="投资金额" class="form-control"/>
					<?php  } ?>
				<?php  } ?>

			</div>

			<div class="form-group">
				<label for="exampleInputPassword1">支付密码</label>
				<input type="password" name="paypassword" class="form-control" id="" placeholder="Password">
			</div>

			<?php if($confimdealinfo['borrow_type'] == 'welfare' && !empty($couponInfo)): ?>
				<table class="table table-bordered">
					<tr>
						<th class="text-center">序列号</th>
						<th class="text-center">金额</th>
						<th class="text-center">操作</th>
					</tr>
					<?php  foreach($couponInfo as $key=>$val): ?>
						<tr>
							<td><?=$val['serial']?></td>
							<td><?=$val['vouchers_account']?></td>
							<td><input type="radio" name="serial" value="<?=$val['serial']?>" onclick="showmoney(<?=$val['vouchers_account']?>);"/></td>
						</tr>
					<?php  endforeach ;?>
				</table>
			<?php endif; ?>
			<div class="footer">
				<?= Html::submitButton('马上投标', ['class'=>'btn btn-success','name' =>'submit-button']) ?>
			</div>


		<?php ActiveForm::end(); ?>
	</header>
    </div>
</div>

<script>
        function showmoney(account)
        {
            var account_wait = <?=$confimdealinfo['borrow_account_wait']?>;
            if(account>account_wait){
                document.getElementById("tender_money").value=account_wait;
                document.getElementById("welfare_account").value=account_wait;

            }else{
                document.getElementById("tender_money").value=account;
                document.getElementById("welfare_account").value=account;
            }
        }
</script>
</body>
</html>
