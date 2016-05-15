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
<title>相关合同</title>
<link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/static/css/liapp-tzjl.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/static/css/bootstrap.min.css">  
<script type="text/javascript" src="/static/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/static/js/bootstrap.min.js"></script>

</head>
<body>
<div class="liapp-tzjl">
		<div class="invest-list-likeapp-top" style="background:#a93434"><!--/*<em>相关合同</em>*/-->
<!--     				<div class="dropdown">-->
<!--                                <button type="button" class="btn dropdown-toggle" id="dropdownMenu1"  data-toggle="dropdown" style="background:#a93434"> 个人信息 <span class="glyphicon  glyphicon-cog"></span></button>-->
<!--                                <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">-->
<!--                                          <li role="presentation"> <a role="menuitem" tabindex="-1" href="#">空1</a> </li>-->
<!--                                          <li role="presentation"> <a role="menuitem" tabindex="-1" href="#">空1</a> </li>-->
<!--                                          <li role="presentation"><a role="menuitem" tabindex="-1" href="#"> 空1 </a> </li>-->
<!--                                          <li role="presentation">  <a role="menuitem" tabindex="-1" href="#">空1</a> </li>-->
<!--                               </ul>-->
<!--						</div>-->
                         <div class="come-back"><a href="javascript:history.back(-1);">返回</a></div>
        </div>
        <div class="invest-tbhk-likeapp-main">
        		<div class="hui">
                		<ul>
                        		<li   class="qian selected" data-name="jingxingzhong">投标中</li>
                                <li class="hou" data-name = "shouyizhong">还款中</li>
                                <li class="hou3" data-name="yiwancheng">已还款</li>
                        </ul>
                       
                </div>
                <div class="hui2">
                		<ul>
                        		<li class="qian2"></li>
                                <li class="hou2"></li>
                                <li class="hou33"></li>
                        </ul>
                       
                </div>
            <div class="bai">

                <div class="tbjl">
                        <?php if(!empty($tenderlist)) :   ?>
                         <?php foreach($tenderlist as $key=>$val) : ?>
                        <a href="#"> <div class="waiyi">
                                <table>
                                    <tr>
                                        <td colspan="2" class="td-qi" style="color:#000; font-size:12px;"><span></span>借款项目&nbsp;&nbsp;<?=$val['borrow_name']?></td>

                                    </tr>
                                    <tr>
                                        <td class="td-qi">&nbsp;<span></span>在投资金：<?=$val['borrow_account']?>元</td>
                                        <td class="td-hou">投资时间：<?php echo date('Y/m/d',$val['addtime']) ?>&nbsp;<?php echo date('H:i',$val['addtime']) ?>&nbsp;</td>
                                    </tr>
                                </table>
                            </div></a>
                        <?php  endforeach; ?>
                        <?php endif; ?>




                </div>
                <div class="hkjh">
                    <?php if(!empty($recoverlist)) :   ?>
                        <?php foreach($recoverlist as $key=>$val) : ?>
                            <a href="#"> <div class="waiyi">
                                    <table>
                                        <tr>
                                            <td colspan="2" class="td-qi" style="color:#000; font-size:12px;"><span></span>借款项目&nbsp;&nbsp;<?=$val['borrow_name']?></td>

                                        </tr>
                                        <tr>
                                            <td class="td-qi">&nbsp;<span></span>在投资金：<?=$val['borrow_account']?>元</td>
                                            <td class="td-hou">投资时间：<?php echo date('Y/m/d',$val['addtime']) ?>&nbsp;<?php echo date('H:i',$val['addtime']) ?>&nbsp;</td>
                                        </tr>
                                    </table>
                                </div></a>
                        <?php  endforeach; ?>
                    <?php endif; ?>


                </div>
                <div class="hkjh2">
                    <?php if(!empty($endlist)) :   ?>
                    <?php foreach($endlist as $key=>$val) : ?>
                        <a href="#"> <div class="waiyi">
                                <table>
                                    <tr>
                                        <td colspan="2" class="td-qi" style="color:#000; font-size:12px;"><span></span>借款项目&nbsp;&nbsp;<?=$val['borrow_name']?></td>

                                    </tr>
                                    <tr>
                                        <td class="td-qi">&nbsp;<span></span>在投资金：<?=$val['borrow_account']?>元</td>
                                        <td class="td-hou">投资时间：<?php echo date('Y/m/d',$val['addtime']) ?>&nbsp;<?php echo date('H:i',$val['addtime']) ?>&nbsp;</td>
                                    </tr>
                                </table>
                            </div></a>
                    <?php  endforeach; ?>
                    <?php endif; ?>




                </div>
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
        
<!--下面的div非常重要，不要删除！！！-->
         <div class="bixuyaokongk" style=" width:100%; height:60px;"></div>
         <!--上面的div非常重要，不要删除！！！-->

</div>


</body>
</html> 
<script>
$(document).ready(function(){
$(".qian").click(function(){
		$(".hkjh").css("display","none");
		$(".tbjl").css("display","block");
		$(".qian2").css("display","block");
		$(".hou2").css("display","none");
        $(".hou33").css("display","none");
		$(".hkjh2").css("display","none");
		});
$(".hou").click(function(){
		$(".tbjl").css("display","none");
		$(".hkjh").css("display","block");
		$(".qian2").css("display","none");
		$(".hou2").css("display","block");
		$(".hou33").css("display","none");
		$(".hkjh2").css("display","none");
		});
	$(".hou3").click(function(){
		$(".tbjl").css("display","none");
		$(".hkjh").css("display","none");
		$(".qian2").css("display","none");
		$(".hou2").css("display","none");
		$(".hou33").css("display","block");
		$(".hkjh2").css("display","block");
		});

});

$(function() {
    $('.circle2').each(function(index, el) {
        var num = $(this).find('span').text() * 3.6;
        if (num<=180) {
            $(this).find('.right2').css('transform', "rotate(" + num + "deg)");
        } else {
            $(this).find('.right2').css('transform', "rotate(180deg)");
            $(this).find('.left2').css('transform', "rotate(" + (num - 180) + "deg)");
        };
    });
	//var gao= window.screen.height;
	var gao=$(window).height();
	//alert(gao);
	var gaogao=(gao-60)+"px";
	//alert(gaogao);
	$(".fo-dinw").css("top",gaogao);
});














</script>




<script>

	$(document).ready(function(){

	$("#add").click(function(){
		$(".pp").css("display","none");
	  var n=$("#num").val();

	  var numm=parseInt(n)+100;

	// if(numm==0){alert("cc");}

	  $("#num").val(numm);

	});

	$("#jian").click(function(){
$(".pp").css("display","none");
	  var n=$("#num").val();

	  var num=parseInt(n)-100;

	// if(num==-100){alert("不能为0!"); return}

	  $("#num").val(num);

	  });
	
	  $(".pp").click(function(){
	  $(".pp").css("display","none");
	   });
	});

	</script>  



































































