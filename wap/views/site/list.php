<?php

use yii\helpers\Url;

?>
<!DOCTYPE html>
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Author" content="hejingfa">
<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
<!-- Mobile Devices Support @begin -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta http-equiv="Cache-Control" content="no-cache,must-revalidate">
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="expires" content="0">
<meta name="format-detection" content="telephone=no, address=no">
<meta content="yes" name="apple-mobile-web-app-capable">
<!-- apple devices fullscreen -->
<meta content="black-translucent" name="apple-mobile-web-app-status-bar-style">
<!-- Mobile Devices Support @end -->
<title>理财产品</title>
<link href="/static/css/bootstrap.css" rel="stylesheet" type="text/css">
<link href="/static/css/innew1026.css" rel="stylesheet" type="text/css">
<link href="/static/css/li-app-wx.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="/static/js/jquery-wx.js"></script>
<script type="text/javascript" src="/static/js/bootstrap.js"></script>
<style>
	ul li{list-style: none}
	.change {border-bottom: 2px solid #fc5c3e;}
</style>
</head>
<body>
<div class="inlist-new invest-list-likeapp">
		<div class="invite-fri-likeapp-top"><em></em>
          <div class="come-back"><a href="javascript:history.go(-1);">返回</a></div>
        </div>
       <div class="invite-fri-likeapp-main">
                <div class="acnews">
					<img src="/static/images/acnewlogo.png">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;0手续费，100元起投所有项目均足值抵押和担保</div>
                <div class="tzzq-app" id="a">
				<?php  if(!empty($list)) :?>
				<?php  foreach($list as $key=>$val) : ?>
						<?php if($val['borrow_type'] == 'roam'){ ?>
						<a href="<?= Url::toRoute(['/deal/deal-view','dealid'=>$val['borrow_nid']])?> ">
							<div class="list-row">
								<div class="name"><em><?=$val['name']?></em></div>
								<div class="cont">
									<div class="pol-o">
										<ul>
											<li class="big" style="font-size:13px;"><span style="color:red;"><?=$val['borrow_apr']?>%</span></li>
											<li>预期年化收益</li>
										</ul>
									</div>
									<div class="pol-t">
										<ul>
											<li class="hei" style="font-size:13px;"><span style="color:red;"><?=$val['borrow_period_name']?></span></li>
											<li>投资期限</li>
										</ul>
									</div>
									<div class="pol-th">
										<ul>
											<li>
												<?php if($val['borrow_status_nid'] == 'roam_now'){  ?>
													  <div class="circle">
														<div class="pie_left"><div class="left" style="transform: rotate(<?=$val['leftcircle']?>deg);"></div></div>
														<div class="pie_right"><div class="right" style="transform: rotate(<?=$val['rightcircle']?>deg);"></div></div>
														<div class="mask"><em style="display:inline-block; margin-top:4px; color:#ccc;width:34px;">完成</em><span style="color:#ccc;"><?=$val['borrow_account_scale']?></span>%</div>
														<div class="sm">
															<i style="display:inline-block; margin-top:15px; font-style:normal; color:red;"><?=$val['borrow_account_scale']?>%</i>
														</div>
													</div>
												<?php }else{ ?>
													<img src="/static/images/wxhasbeenpayment.png" style=" position:absolute; top:5px; left:35%;width:42px;height:42px;">
												<?php } ?>
											</li>
										</ul>
									</div>
								</div>
							</div>
						</a>
						<?php }else{ ?>
							<a href="<?= Url::toRoute(['/deal/deal-view','dealid'=>$val['borrow_nid']])?> ">
								<div class="list-row">
									<div class="name"><em><?=$val['name']?></em></div>
									<div class="cont">
										<div class="pol-o">
											<ul>
												<li class="big" style="font-size:13px;"><span style="color:red;"><?=$val['borrow_apr']?>%</span></li>
												<li>预期年化收益</li>
											</ul>
										</div>
										<div class="pol-t">
											<ul>
												<li class="hei" style="font-size:13px;"><span style="color:red;"><?=$val['borrow_period_name']?></span></li>
												<li>投资期限</li>
											</ul>
										</div>
										<div class="pol-th">
											<ul>
												<li>

													<?php if($val['borrow_status_nid'] == 'loan'){ ?>
														<div class="circle">
															<div class="pie_left"><div class="left" style="transform: rotate(<?=$val['leftcircle']?>deg);"></div></div>
															<div class="pie_right"><div class="right" style="transform: rotate(<?=$val['rightcircle']?>deg);"></div></div>
															<div class="mask"><em style="display:inline-block; margin-top:4px; color:#ccc;width:34px;">完成</em><span style="color:#ccc;"><?=$val['borrow_account_scale']?></span>%</div>
															<div class="sm">
																<i style="display:inline-block; margin-top:15px; font-style:normal; color:red;"><?=$val['borrow_account_scale']?>%</i>
															</div>
														</div>
													<?php }elseif($val['borrow_status_nid'] == 'loand'){ ?>
														<img src="/static/images/fullscale.png" style=" position:absolute; top:5px; left:35%;width:42px;height:42px;">
													<?php }else { ?>
														<img src="/static/images/wxhasbeenpayment.png" style=" position:absolute; top:5px; left:35%;width:42px;height:42px;">
													<?php } ?>

												</li>
											</ul>
										</div>
									</div>
								</div>
							</a>

						<?php  } ?>
				<?php endforeach ; ?>
				<?php endif; ?>
		</div>
		        <link href="/static/css/tishi.css" rel="stylesheet" type="text/css">
                <div style="top:720px;" class="invest-list-likeapp-footer fo-dinw">
                    <div class="xuanx f1">
                        <a href="<?=Url::toRoute('/site/deal-list')?>">
                            <ul>
                                <li class="ding"><i class="i1">
                                        <img src="/static/images/invest-click.png" class="im1" style="width:25px; height:25px;"></i>
                                </li>
                                <li class="mo">投资项目</li>
                            </ul>
                        </a>
                    </div>
                    <div class="xuanx f2">
                        <a href="<?=Url::toRoute('/users/invitefriend')?>">
                            <ul>
                                <li class="ding"><i class="i2"><img src="/static/images/invite-click.png" class="im1" style="width:25px; height:25px;"></i></li>
                                <li class="mo">邀请好友</li>
                            </ul>
                        </a>
                    </div>
                    <div class="xuanx f3">
                        <a href="<?=Url::toRoute('/users/user')?>">
                            <ul>
                                <li class="ding"><i class="i3"><img src="/static/images/fundman-click.png" class="im1" style="width:25px; height:25px;"></i></li>
                                <li class="mo">资金管理</li>
                            </ul>
                        </a>
                    </div>
                    <div class="xuanx f4">
                        <a href="<?=Url::toRoute('/users/user/userinfo')?>">
                            <ul>
                                <li class="ding"><i class="i4"><img src="/static/images/message-click.png" class="im1" style="width:25px; height:25px;"></i></li>
                                <li class="mo">个人信息</li>
                            </ul>
                        </a>
                    </div>
                </div>
                <!-- 提示-->
                <div class="zzc-liapp"></div>
                <div class="zzc-main">
                    <div class="zzc-top">
                        <span class="sp-1">提示</span><span class="glyphicon glyphicon-remove-sign sp-2 zzccl"></span>
                    </div>
                    <div class="zzc-cont">
                        <p></p>
                        <button>绑定银行卡</button>
                    </div>
                </div>
</div>
</body>
</html>