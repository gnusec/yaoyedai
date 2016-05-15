 define(function(require, exports, module) {

	 //打开提示
	 exports.error = function(msg,url){
		 var zzcg=$(window).height();
		 $(".zzc-liapp").css("height",zzcg);
		 var zzck=$(window).width();
		 $(".zzc-liapp").css("width",zzck);
		 $(".zzc-liapp").css("display","block");
		 $(".zzc-main").css("display","block");
		 $('.zzc-main  .zzc-cont ').html(msg)
	 }


 });