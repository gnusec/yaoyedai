 //  wap 注册验证类
define(function(require, exports, module) {
        //验证规则
		exports.gorealname = function(){
            $('#gorealname').click(function(){
                $.ajax({
                    type:"post",
                    url:"/realname/go-real-name",
                    data:"cardid="+$("input[name='card_id']").val()+'&username='+$("input[name='username']").val(),
                    success:function(msg){
                        var results = eval('('+msg+')');
                        if(results.code != 0){
                            exports.opentishi("<p>"+results.message+"</p>")
                        }else{
                            window.location.href='/realname/real-ok'
                        }
                    }
                });
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