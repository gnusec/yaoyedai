$(function() {
	$("#nextStep").click(function() {
		if (validInput()) {
			$("#fm").submit();
			$(this).unbind().click(function() {
				alert("正在处理中，请勿重复提交！");
			});
		}
	});
	
	$(".timeval").click(function(){
		doajax();
	});
});

/**
 * 下一步前的验证,四个验证都通过才能进入下一步
 */
function validInput() {
	return ckPhone() && ckAgreement()&&wxphoneisexist();
}

function ckAgreement() {
	var agreement = document.getElementById("agree").checked;
	if (!agreement) {
		alert("请勾选我同意药业贷注册协议");
		return false;
	}
	return true;
}

function ckPhone() {
	var phone = $("#phone");
	var bMes = $("#message");
	var repTest = /^(0|86|17951)?(13[0-9]|15[012356789]|17[678]|18[0-9]|14[57])[0-9]{8}$/;
	var value = phone.val();
	if (value == "") {
		bMes.html("手机号不能为空");
		return false;
	} else if (value != "" && !repTest.test(value)) {
		bMes.html("手机格式不正确")
		return false;
	}
	bMes.html("")
	return true;
}

function ckPassword() {
	var pwdBox = $("#firstpwd");
	var firstMes = $("#pwdmessage");
	var value = pwdBox.val();
	var str_len = value.length;
	if ((str_len > 7) && (str_len < 17)) {
		var result = getResult(value);
		if (result == 0) {
			firstMes.html("密码太短了");
			return false;
		}
		firstMes.html("");
		return true;
	} else {
		firstMes.html("请输入8到16位密码");
		return false;
	}
}

function ckRepassword() {
	var pwdBox = $("#firstpwd");
	var checkBox = $("#checkpwd");
	var checkMes = $("#pwdmessage");
	var value = pwdBox.val();
	var checkStr = checkBox.val();
	if (checkStr == "" || checkStr != value) {
		checkMes.html("两次输入的密码不一致");
		return false;
	}
	checkMes.html("");
	return true;
}

function getResult(value) {
	var str_len = value.length;
	var i = 0;
	if (value.match(/[a-z]/ig)) {
		i++;
	}
	if (value.match(/[0-9]/ig)) {
		i++;
	}
	if (value.match(/(.[^a-z0-9])/ig)) {
		i++;
	}
	if (value.length < 8) {
		i = 0;
	}
	return i;
}
function wxphoneisexist(){
	var phone=$("#phone").val().trim();
	var bool=true;
	$.ajax({
		"url" : "/user/wxphoneisexist.html?phone=" + phone,
		"type" : "post",
		"async" : false,
		"dataType" : "json",
		"success" : function(data) {
			if((data.data)!=null){
				$("#message").html(data.data);
				bool= false;
			}
		}
	});
	return bool;
}