//  wap绑卡类
define(function(require, exports, module) {
    //验证规则
    exports.checkbink = function(){
        $('#bank').submit(function(){
            var bank= /^\d{0,19}$/;

            //开户行
            var branch = $("input[name='branch']").val();
            if(!branch){
                exports.opentishi("<p>请输入开户行</p>");return false;
            }
            //银行卡卡号
            var account = $("input[name='account']").val();
            if(!account){
                exports.opentishi("<p>请输入银行卡卡号</p>");return false;
            }

            if(!bank.test(account)){
                exports.opentishi("<p>请输入正确银行的卡号</p>");return false;
            }

            //确认银行卡号
            var confirm_account = $("input[name='confirm_account']").val();
            if(!confirm_account){
                exports.opentishi("<p>请输入确认银行卡号</p>");return false;
            }
            if(confirm_account !=account){
                exports.opentishi("<p>银行卡卡号不一致</p>");return false;
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