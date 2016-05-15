 //  wap 充值类
define(function(require, exports, module) {
        //验证规则
		exports.DoRecharge = function(){
            $('#dorecharge').submit(function () {
                var transamt = $('input[name=chargemoney]').val();
                if (transamt == '') {
                    exports.opentishi("<p>充值金额不能为空</p>")
                    return false;
                }
                var reg = new RegExp("^[0-9.]*$");
                if(!reg.test(transamt)){
                    exports.opentishi("<p>充值金额必须是数字</p>")
                    return false;
                }
                return true;
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