 //  wap 提现类
define(function(require, exports, module) {
        //验证规则
		exports.DoWithdraw = function(){
            $('#dowithdraw').submit(function () {
                var transamt = $('input[name=cashmoney]').val();
                if (transamt == '') {
                    exports.opentishi("<p>提现金额不能为空</p>")
                    return false;
                }
                var reg = new RegExp("^[0-9.]*$");
                if(!reg.test(transamt)){
                    exports.opentishi("<p>提现金额必须是数字</p>")
                    return false;
                }

                //验证支付密码
                var paypasswd =  $('input[name=paypassword]').val();
                if(!paypasswd){
                    exports.opentishi("<p>支付密码不能为空</p>")
                    return false;
                }
                //ajax校验
                 return true;
                 //window.location.href="/withdraw/withdraw-ok";
            })
	    }


    //关闭提示
    exports.closedtishi = function(){
        $(".zzccl").click(function(){
            $(".zzc-liapp").css("display","none");
            $(".zzc-main").css("display","none");
        });
    }

    //打开提示
    exports.opentishi = function(msg){
        var zzcg=$(window).height();
        $(".zzc-liapp").css("height",zzcg);
        var zzck=$(window).width();
        $(".zzc-liapp").css("width",zzck);
        $(".zzc-liapp").css("display","block");
        $(".zzc-main").css("display","block");
        $('.zzc-main  .zzc-cont ').html(msg)
    }

});