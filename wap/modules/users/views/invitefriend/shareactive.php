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
<title>分享页</title>
<link href="/static/css/bootstrap.min.css" rel="stylesheet" type="text/css">
<link href="/static/css/hytztj2.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="/static/css/bootstrap.min.css">  
<script type="text/javascript" src="/static/js/jquery-1.8.3.min.js"></script>
<script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
<style>
.logo{
	width:100%;
	height:1000px;
	background:gray;
	opacity:.5;
	position:relative;
}
.logo img{
	display:inline-block;
	position:absolute;
	top:-125px;
	right:0px;
}
.wz{
	position:absolute;
	left:670px;
	top:100px;
}
.share{
	position:absolute;
	top:230px;
	left:670px;
	font-size:20px;
	color:white;
}
</style>
</head>
<body>
<div class="hyztj2">
	 <div class="invest-list-likeapp-top"><em></em>
     	<div class="come-back"><a href="javascript:history.back(-1);"><span class="glyphicon glyphicon-chevron-left"></span>返回</a></div>
        </div>
        <div class="logo">
        	<img src="/static/images/logo.png">
        </div>
        <div class="wz">
        	点击分享按钮，分享给朋友。
            <div>
            分享链接：<?=$shareurl?>
            </div>
        </div>
         <div class="share">点击分享给您的朋友</div>
	</div>
	<script>
	<script src="https://res.wx.qq.com/open//static/js/jweixin-1.0.0.js"></script>
<script>
    $(document).ready(function () {

        /*微信接口开始*/
        wx.config({
            debug: false,
            appId: '<?php echo $signPackage["appid"];?>',
            timestamp: <?php echo $signPackage["timestamp"];?>,
            nonceStr: '<?php echo $signPackage["noncestr"];?>',
            signature: '<?php echo $signPackage["signature"];?>',
            jsApiList: [
                // 所有要调用的 API 都要加到这个列表中
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo'
            ]
        });
        var protocol = window.location.protocol + '//';
        var primary = window.location.hostname;
        var host_url = protocol + primary;
        var present_url = host_url + '/register?inviteid=<?=$user_id?>';
        wx.ready(function () {
            $('title').html('药业贷分享')
            wx.onMenuShareTimeline({
                title: "药业贷分享-lhw", // 分享标题
                link: present_url, // 分享链接
                imgUrl: host_url + "/static/imageshead.png", // 分享图标
                desc: "快来分享吧，2016要继续。", // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
            wx.onMenuShareAppMessage({
                title: "药业贷分享-lhw", // 分享标题
                link: present_url, // 分享链接
                imgUrl: host_url + "/static/imageshead.png", // 分享图标
                desc: "快来分享吧，2016要继续。", // 分享图标
                type: '', // 分享类型,music、video或link，不填默认为link
                dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
            wx.onMenuShareQQ({
                title: "药业贷分享-lhw", // 分享标题
                desc: "快来分享吧，2016要继续。", // 分享图标
                link: present_url, // 分享链接
                imgUrl: host_url + "/static/imageshead.png", // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
            wx.onMenuShareWeibo({
                title: "药业贷分享-lhw", // 分享标题
                link: present_url, // 分享链接
                imgUrl: host_url + "/static/imageshead.png", // 分享图标
                success: function () {
                    // 用户确认分享后执行的回调函数
                },
                cancel: function () {
                    // 用户取消分享后执行的回调函数
                }
            });
        });
    });
</script>

</body>
</html> 

