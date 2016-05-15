 //wap重置交易密码类
define(function(require, exports, module) {
        //验证规则
		exports.check = function(){
            $('#resetpaypwd').click(function () {
                var oldpwd = $("input[name='oldpasswd']").val();
                var newpwd = $("input[name='newpasswd']").val();
                var reppwd = $("input[name='repeatpasswd']").val();
                var _csrf = $("input[name='_csrf']").val();
                if(!oldpwd){
                    exports.opentishi("<p>原密码不能为空</p>")
                    return false;
                }
                if( !newpwd){
                    exports.opentishi("<p>新密码不能为空</p>")
                    return false;
                }
                if( !reppwd){
                    exports.opentishi("<p>重复密码不能为空</p>")
                    return false;
                }

                if( newpwd != reppwd){
                    exports.opentishi("<p>两次密码不一致</p>")
                    return false;
                }

                $.ajax({
                    type:"get",
                    url:"/users/paypassword/upd",
                    data:"oldpasswd="+oldpwd+'&newpasswd='+newpwd+'&repeatpasswd='+reppwd,
                    success:function(msg){
                        var results = eval('('+msg+')');
                        if(results.code != 0){
                            exports.opentishi("<p>"+results.message+"</p>")
                        }else{
                            exports.opentishi("<p>修改成功</p><a href='/site/deal-list'><button>去投资</button></a>")
                        }
                    }
                });
               // return true;

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