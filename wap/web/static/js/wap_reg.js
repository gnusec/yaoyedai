
//  wap 注册验证类
define(function(require, exports, module) {
        //验证规则
		exports.check = function(){
            $('#wap_reg').click(function(){
                    if( !exports.checkPhone() || !exports.checkPassword() || !exports.checkIsagree()){
                        return false;
                    }
                 //转向下一页
                 window.location.href="/register/register-next?phone="+$("input[name='phone']").val()+'&passwd='+$("input[name='passwd']").val()+'&invitecode='+$("input[name='invitecode']").val();
            })
	    }

     //验证密码
     exports.checkPassword = function(){
         //验证密码强度
         var pw = checkStrong($("input[name='passwd']").val());
         if(pw===0){
             exports.opentishi("<p>密码太短</p>")
             return false;
         }else if(pw==1){
             exports.opentishi("<p>密码只有一种字符</p>")
             return false;
         }
         //测试某个字符是属于哪一类
         function CharMode(iN) {
             if (iN>=48 && iN <=57) //数字
                 return 1;
             if (iN>=65 && iN <=90) //大写字母
                 return 2;
             if (iN>=97 && iN <=122) //小写
                 return 4;
             else
                 return 8; //特殊字符
         };
         //计算出当前密码当中一共有多少种模式
         function bitTotal(num) {
             modes=0;
             for (i=0;i<4;i++) {
                 if (num & 1) modes++;
                 num>>>=1;
             }
             return modes;
         };
         //返回密码的强度级别
         function checkStrong(passwdStr) {
             if (passwdStr.length<=4){
                 return 0;
             }
             Modes=0;
             for (i=0;i<passwdStr.length;i++) {
                 //测试每一个字符的类别并统计一共有多少种模式
                 Modes|=CharMode(passwdStr.charCodeAt(i));
             }
             return bitTotal(Modes);
         };

         //验证重复密码是否正确
         if($("input[name='repeatpasswd']").val()!=$("input[name='passwd']").val()){
             exports.opentishi("<p>两次密码输入不一致</p>")
             return false;
         }
         //验证通过返回true
        return true;
     }
    //验证手机号
     exports.checkPhone = function(){
         var phone_reg = /^1[3|4|5|8][0-9]\d{4,8}$/;
         //验证手机号是否空
         if(!$("input[name='phone']").val()){
            exports.opentishi("<p>手机号不能为空</p>")
             return false;
         }
         //验证格式
         if(!phone_reg.test($("input[name='phone']").val())){
             exports.opentishi("<p>手机号格式不正确</p>")
             return false;
         }
         //在验证是否注册过 todo
          var flg = false;
         $.ajax({
             type:"get",
             url:"/register/check-phone",
             data:"phone="+$("input[name='phone']").val(),
             async:false,
             success:function(msg){
                 var results = eval('('+msg+')');
                 if(results.code == '100'){
                        flg = true;
                 }else{
                      flg = false;
                 }
             }
         });
         if(!flg){
             exports.opentishi("<p>手机号已注册</p>")
             return false;
         }
         return true;
     }

     //验证是否选择同意协议
     exports.checkIsagree = function(){
            if(!$("input[name='agree']").prop('checked')){
                exports.opentishi("<p>请先同意协议</p>")
                return false;
            }
            return true;
     }

    //去注册
    exports.sendPhoneCode = function(){
        //验证手机号 todo
        $('#registercomplate').click(function(){
            $.ajax({
                type:"get",
                url:"/register/do-register",
                data:"phone="+$("input[name='phone']").val()+'&passwd='+$("input[name='password']").val()+'&invitecode='+$("input[name='invitecode']").val()+'&phonecode='+$("input[name='phonecode']").val(),
                success:function(msg){
                    var results = eval('('+msg+')');
                    if(results.code != 0){
                        exports.opentishi("<p>"+results.message+"</p>")
                    }else{
                        exports.opentishi('<p>'+results.message+'</p><a href="/login"><button>去登录</button></a>')
                        window.location.href="/login";
                    }
                }
            });
        })
    }

    //开通易宝支付

    exports.opneYibao = function(){
        //验证 todo
        $('#openyibao').click(function(){
            window.location.href="/register/register-ok?phone="+$("input[name='phone']").val()+'&passwd='+$("input[name='passwd']").val();
        })
    }

    //发送短信验证码

    exports.sendCode = function(){

        $('#send_phone').click(function(){
            if(!$("input[name='phone']").val()){
                exports.opentishi("<p>请返回重新填写手机号</p>")
                return false;
            }
            $.ajax({
                type:"get",
                url:"/register/send-phone-code",
                data:"phone="+$("input[name='phone']").val(),
                success:function(msg){
                    var results = eval('('+msg+')');
                    if(results.code != 0){
                        exports.opentishi("<p>"+results.message+"</p>")
                    }else{
                        exports.opentishi("<p>发送成功</p>")
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