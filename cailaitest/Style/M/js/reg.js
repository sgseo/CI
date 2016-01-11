var arrBox = new Array();
arrBox["dvEmail"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce1.gif'/>&nbsp;请填写真实的电子邮件地址。";
arrBox["dvUser"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce1.gif'/>&nbsp;6-15个字母、数字、下划线。";
arrBox["dvPwd"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce1.gif'/>&nbsp;6-16个字母、数字、下划线。";
arrBox["dvRepwd"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce1.gif'/>&nbsp;请再一次输入您的密码。";
arrBox["dvRec"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce1.gif'/>&nbsp;请输入推荐人的手机号码，可不填。";
arrBox["dvCode"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce1.gif'/>&nbsp;请按照图片显示内容输入验证码。";
arrBox["dvTelephone"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce1.gif'/>&nbsp;请输入手机号码。";
arrBox["dvBusiCode"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce1.gif'/>&nbsp;请输入企业营业执照注册号。";
arrBox["dvSMS"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce1.gif'/>&nbsp;请输入您收到的短信验证码。";
arrBox["zwCode"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce1.gif'/>&nbsp;请先正确输入验证码。";

var arrWrong = new Array();
arrWrong["dvEmail"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;请输入真实的电子邮件。";
arrWrong["dvUser"] = "<img style='margin:3px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;6-15个字母、数字、下划线。";
arrWrong["dvPwd"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;6-16个字母、数字、下划线。";
arrWrong["dvRepwd"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;未输入或两次输入密码不同。";
arrWrong["dvRec"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;请输入推荐人的手机号码。";
arrWrong["dvCode"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;验证码位数输入不正确。";
arrWrong["dvTelephone"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;号码格式不正确。";
arrWrong["dvBusiCode"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;企业营业执照注册号格式不正确。";
arrWrong["dvSMS"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;短信验证码错误。";
arrWrong["zwSMS"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;一个手机号每天注册次数不能超过5次哦。";

var arrOk = new Array();
arrOk["dvEmail"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce3.gif'/>&nbsp;电子邮件地址可用。";
arrOk["dvUser"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce3.gif'/>&nbsp;用户名可用。";
arrOk["dvPwd"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce3.gif'/>&nbsp;密码格式正确。";
arrOk["dvRepwd"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce3.gif'/>&nbsp;密码格式正确。";
arrOk["dvRec"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce3.gif'/>&nbsp;推荐人的手机号码正确。";
arrOk["dvCode"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce3.gif'/>&nbsp;验证码正确。";
arrOk["dvTelephone"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce3.gif'/>&nbsp;号码格式正确。";
arrOk["dvBusiCode"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce3.gif'/>&nbsp;企业营业执照注册号格式正确。";
arrOk["dvSMS"] = "<img style='margin:2px;' src='"+imgpath+"images/zhuce3.gif'/>&nbsp;短信验证码正确。";


function Init() {
    //$('#txtEmail').click(function() { ClickBox("dvEmail"); });
    //$('#txtUser').click(function() { ClickBox("dvUser") });
    $('#txtPwd').click(function() { ClickBox("dvPwd") });
    $('#txtRepwd').click(function() { ClickBox("dvRepwd") });
	$('#txtRec').click(function() { ClickBox("dvRec") });
    $('#txtCode').click(function() { ClickBox("dvCode") });
	$('#txtTelephone').click(function() { ClickBox("dvTelephone") });
	$('#txtBusiCode').click(function() { ClickBox("dvBusiCode") });
    $('#txtSMS').click(function() { ClickBox("dvSMS") });

    //$('#txtEmail').blur(function() { BlurEmail(); });
    //$('#txtUser').blur(function() { BlurUName(); });
    $('#txtPwd').blur(function() { BlurPwd(); });
    $('#txtRepwd').blur(function() { BlurRepwd(); });
	$('#txtRec').blur(function() { BlurRec(); });
    $('#txtCode').blur(function() { BlurCode(); });
	$('#txtTelephone').blur(function() { BlurTelephone(); });
	$('#txtBusiCode').blur(function() { BlurBusiCode(); });
    $('#txtSMS').blur(function() { BlurSMS(); });

}

$(document).ready(
function() {
	$('#dvRec').html('<font>填写推荐人手机号码，没有推荐人可不填。</font>');
    Init();
    //$("#txtTelephone").focus();
    //$("#Img1").click(function() { RegSubmit(this); });
    $("#txtCode").keypress(
    function(e) {
        if (e.keyCode == "13")
            $("#Img1").click();
    });


    // 发送短信验证码
    $('#sendSMS').data('status', 0);
    $('#sendSMS').click(function() {
        //alert(111);
        var txt = "#txtTelephone";
        var tc = $.trim($('#txtCode').val());
        var td = "#dvTelephone";
        var pat = new RegExp(/^1[3|4|5|7|8][0-9]\d{8}$/);
        var str = $(txt).val();
        if(pat.test(str))
        {
            if( $('#sendSMS').data('status') == 1) {
                return false;
            }
            ///alert(222);
            $.ajax({
                type: "post",
                url: "/member/common/sendsmscode/",
                dataType: "json",
                data: {"mobile":str,"tcode":tc},    //zhangwei
                beforeSend:function(){
                    $('#sendSMS').html('短信发送中…');
                },
                timeout: 3000,
                success: function(data) {
                    if(data.status == '1') {
                        $('#sendSMS').data('status', 1).attr('disabled', 'disabled');
                        $("#dvSMS").html();
                        // 处理60秒后重发
                        var i = 0;
                        countTime = setInterval(function(){
                            var tt = 60 - i;
                           $('#sendSMS').html('('+tt+')'+'秒后重新发送' + data.smscode);
                           //$('#sendSMS').html('('+tt+')'+'秒后重新发送');
                            if(i == 60) {
                                clearInterval(countTime);
                                $('#sendSMS').data('status', 0).attr('disabled', false).html('发送短信验证码');
                            }
                            i++;

                        }, 1000);
                    } else if(data.status == '2'){
                        $('#sendSMS').data('status', 0).attr('disabled', 'disabled').html('此号休息一天！');
                        $("#dvSMS").html(GetP("reg_wrong", arrWrong["zwSMS"]));
                    }else if(data.status == '3'){
                        $('#sendSMS').data('status', 0).attr('disabled', false).html('发送短信验证码');
                        $("#dvSMS").html(GetP("reg_wrong", arrBox["zwCode"]));
                    }else{
                        $('#sendSMS').data('status', 0).attr('disabled', false).html('发送短信验证码');
                        $("#dvSMS").html();
                    }
                }
            });
        }else
        {
            $(td).html(GetP("reg_wrong", arrWrong["dvTelephone"]));
        }

    });

// 短信发送倒计时


});

function strLength(as_str){
		return as_str.replace(/[^\x00-\xff]/g, 'xx').length;
}
function isLegal(str){
	if(/[!,#,$,%,^,&,*,?,~,\s+]/gi.test(str)) return false;
	return true;
}
function BlurTelephone() {
	 var txt = "#txtTelephone";
    var td = "#dvTelephone";
	var pat = new RegExp(/^1[3|4|5|7|8][0-9]\d{8}$/);
	var str = $(txt).val();
	if(pat.test(str))
	{
		//$(td).html(GetP("reg_ok", arrOk["dvTelephone"]));
		$(td).html(GetP("reg_info", "<img style='margin:2px;' src='"+imgpath+"images/zhuce0.gif'/>&nbsp;正在检测手机号……"));
		$.ajax({
            type: "post",
            async: false,
            url: "/member/common/checkphone/",
			dataType: "json",
            data: {"Telephone":str},
            timeout: 3000,
            success: AsyncTphone
        });
	}
	else
	{
		$(td).html(GetP("reg_wrong", arrWrong["dvTelephone"]));
	}
}
// BlurBusiCode
function BlurBusiCode() {
	var txt = "#txtBusiCode";
        var td = "#dvBusiCode";
	var pat = new RegExp(/^\d{15}$/);//420103000057404 \d{15}
	var str = $(txt).val();
        console.log(str);
	if(pat.test(str))
	{
		//$(td).html(GetP("reg_ok", arrOk["dvTelephone"]));
		$(td).html(GetP("reg_info", "<img style='margin:2px;' src='"+imgpath+"images/zhuce0.gif'/>"));
		$.ajax({
            type: "post",
            async: false,
            url: "/member/common/checkBusiCode/",
            dataType: "json",
            data: {"BusiCode":str},
            timeout: 3000,
            success: AsyncBusiCode
        });
	}
	else
	{
		$(td).html(GetP("reg_wrong", arrWrong["dvBusiCode"]));
	}
}

// 短信验证码
function BlurSMS() {
    var txt = "#txtSMS";
    var td = "#dvSMS";
    var pat = new RegExp(/^\d{6}$/);
    var str = $(txt).val();
    if(pat.test(str))
    {
        $(td).html(GetP("reg_info", "<img style='margin:2px;' src='"+imgpath+"images/zhuce0.gif'/>&nbsp;正在检测短信验证码……"));
        $.ajax({
            type: "post",
            async: false,
            url: "/member/common/checksmscode/",
            dataType: "json",
            data: {"smscode":str, "mobile":$("#txtTelephone").val()},
            timeout: 3000,
            success: AsyncSMS
        });
    }
    else
    {
        $(td).html(GetP("reg_wrong", arrWrong["dvSMS"]));
    }
}



function BlurUName() {
    var txt = "#txtUser";
    var td = "#dvUser";
    //var pat = new RegExp("^[\\d|\\.a-z_A-Z|\\u4e00-\\u9fa5|\\x00-\\xff]$", "g");
	var pat = new RegExp("[^\\d|a-z_A-Z]", "g");
    var str = $(txt).val();
    var strlen = strLength(str);
    if (isLegal(str) && !pat.test(str) && strlen>=6 && strlen<=15) {
        $(td).html(GetP("reg_info", "<img style='margin:2px;' src='"+imgpath+"images/zhuce0.gif'/>&nbsp;正在检测用户名……"));
        $.ajax({
            type: "post",
            async: false,
            url: "/member/common/ckuser/",
			dataType: "json",
            data: {"UserName":str},
            timeout: 3000,
            success: AsyncUname
        });
    }
    else {
        $(td).html(GetP("reg_wrong", arrWrong["dvUser"]));
    }
}
function BlurRec() {
    var txt = "#txtRec";
    var td = "#dvRec";
    var pat = new RegExp("^[a-zA-Z0-9_]*$", "g");
    var str = $.trim($(txt).val());
	
    var strlen = strLength(str);
	if (isLegal(str) && strlen>=3 && strlen<=20) {
		$(td).html(GetP("reg_info", "<img style='margin:2px;' src='"+imgpath+"images/zhuce0.gif'/>&nbsp;正在检测推荐人……"));
		$.ajax({
			type: "post",
			async: false,
			url: "/member/common/ckInviteUser/",
			dataType: "json",
			data: {"InviteUserName":str},
			timeout: 3000,
			success: AsyncInviteUname
		}
		);
	}else if(str==''){
		$(td).empty();
    }
    else {
        $(td).html(GetP("reg_wrong", arrWrong["dvRec"]));
    }
}
function AsyncUname(data) {
    if (data.status == 1) {
        $("#dvUser").html(GetP("reg_ok", arrOk["dvUser"]));
    }else if(data.status == -1){
        $("#dvUser").html(GetP("reg_wrong", "<img style='margin:2px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;此用户名格式错误。"));
    }else if(data.status == -2){
        $("#dvUser").html(GetP("reg_wrong", "<img style='margin:2px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;此用户名含有敏感字符。"));
    }else {
		$("#dvUser").html(GetP("reg_wrong", "<img style='margin:2px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;此用户名已被注册。"));
	}
}
function AsyncTphone(data) {
    if (data.status == "1") {
        $("#dvTelephone").html(GetP("reg_ok", arrOk["dvTelephone"]));
    }
    else {
        $("#dvTelephone").html(GetP("reg_wrong", "<img style='margin:2px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;此手机号已被注册。"));

    }
}
function AsyncBusiCode(data) {
    if (data.status == "1") {
        $("#dvBusiCode").html(GetP("reg_ok", arrOk["dvBusiCode"]));
    }
    else {
        $("#dvBusiCode").html(GetP("reg_wrong", "<img style='margin:2px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;此企业营业执照编号已被注册。"));

    }
}

// 短信验证码
function AsyncSMS(data) {
    if (data.status == "1") {
        $("#dvSMS").html(GetP("reg_ok", arrOk["dvSMS"]));
    }
    else {
        $("#dvSMS").html(GetP("reg_wrong", "<img style='margin:2px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;验证码错误。"));

    }
}



function AsyncInviteUname(data) {
    if (data.status == "1") {
        $("#dvRec").html(GetP("reg_ok", arrOk["dvRec"]));
    }
    else {
        $("#dvRec").html(GetP("reg_wrong", "<img style='margin:2px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;此推荐人不存在。"));

    }

}
function BlurEmail() {
    var txt = "#txtEmail";
    var td = "#dvEmail";
    var pat = new RegExp("^[\\w-]+(\\.[\\w-]+)*@[\\w-]+(\\.[\\w-]+)+$", "i");
    var str = $(txt).val();
    if (pat.test(str)) {
        $(td).html(GetP("reg_info", "<img style='margin:2px;' src='"+imgpath+"images/zhuce0.gif'/>&nbsp;正在检测电子邮件地址……"));
        $.ajax({
            type: "post",
            async: false,
			dataType: "json",
            url: "/member/common/ckemail/",
            data: {"Email":str},
            timeout: 3000,
            success: AsyncEmail
        });
    }
    else { $(td).html(GetP("reg_wrong", arrWrong["dvEmail"])); }
}

function AsyncEmail(data) {
    if (data.status == 1) {
        $("#dvEmail").html(GetP("reg_ok", arrOk["dvEmail"]));
    }else if(data.status == -4){    
		$("#dvEmail").html(GetP("reg_wrong", "<img style='margin:2px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;邮箱格式错误<a href='javascript:getPassWord();'>取回密码？</a>"));
    }else if(data.status == -5){
		$("#dvEmail").html(GetP("reg_wrong", "<img style='margin:2px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;邮箱不允许注册<a href='javascript:getPassWord();'>取回密码？</a>"));
    }else{    
		$("#dvEmail").html(GetP("reg_wrong", "<img style='margin:2px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;邮箱已经在本站注册<a href='javascript:getPassWord();'>取回密码？</a>"));
    }
}

function getPassWord() {
	window.location.href = "/member/common/getpassword/";
}

function BlurPwd() {
    var txt = "#txtPwd";
    var td = "#dvPwd";
    var pat = new RegExp("^.{6,16}$", "i");
    var str = $(txt).val();
    if (pat.test(str)) {
        //格式正确
        $(td).html(GetP("reg_ok", arrOk["dvPwd"]));
    }
    else {
        $(td).html(GetP("reg_wrong", arrWrong["dvPwd"]));
    }
}

function BlurRepwd() {
    var txt = "#txtRepwd";
    var td = "#dvRepwd";
    var str = $(txt).val();
    if (str == $("#txtPwd").val() && str.length > 5) {
        //格式正确
        $(td).html(GetP("reg_ok", arrOk["dvRepwd"]));
    }
    else {
        $(td).html(GetP("reg_wrong", arrWrong["dvRepwd"]));
    }
}
//检验 验证码
function BlurCode() {
    var txt = "#txtCode";
    var td = "#dvCode";
    var pat = new RegExp("^[\\da-z]{4}$", "i");
    var str = $.trim($(txt).val());
    if (pat.test(str)) {
        //格式正确
        $.post("/member/common/ckcode/", { Action: "post", Cmd: "CheckVerCode", sVerCode: str }, AsyncVerCode);
       // $('#sendSMS').removeAttr("disabled").html('发送短信验证码！'); 
    }
    else {
        $('#imVcode').click();
        $(td).html(GetP("reg_wrong", arrWrong["dvCode"]));
       // $('#sendSMS').attr('disabled', 'disabled').html('请输入正确的验证码！');
    }
}

function AsyncVerCode(data) {
    if (data == "1") {
        $("#dvCode").html(GetP("reg_ok", arrOk["dvCode"]));
    }
    else {
        //$("#dvCode").html(GetP("reg_wrong", "<img style='margin:2px;' src='"+imgpath+"images/zhuce2.gif'/>&nbsp;验证码填写错误！"));
		 $("#dvCode").html(GetP("reg_wrong", arrBox["dvCode"]));
                 //$('#sendSMS').attr('disabled', 'disabled').html('请输入正确的验证码！');
                 $('#imVcode').click();
		//document.getElementById('imVcode').onclick();
    }
}

function ClickBox(id) {
    var ele = '#' + id;
    $(ele).html(GetP("reg_info", arrBox[id]));
}

function GetP(clsName, c) { return "<div class='" + clsName + "'>" + c + "</div>"; }

function RegSubmit(ctrl) {
    $(ctrl).unbind("click");
    var arrTds = new Array("#dvPwd","#dvRepwd", "#dvTelephone","#txtBusiCode", "#dvCode", "#dvRec");
    //BlurEmail();
    //BlurUName();
    BlurSMS();
    BlurPwd();
	BlurRec();
    BlurCode();
    // for (var i = 0; i < arrTds.length; i++) {
    //     if ($(arrTds[i]).html().indexOf('reg_wrong') > -1) {
    //         $(ctrl).click(function() { RegSubmit(this); });
    //         return false;
    //     }
    // }
	
	var check = $("input[type='checkbox']").attr("checked");
	if(!check){
		$.jBox.tip("请确认服务协议");  
		return false;
  	}

	$.jBox.tip("提交中......","loading");
	$.ajax({
		//url: curpath+"/regtemp/",
		url: curpath+"/regaction/",//
		data: {
            "txtUser": $.trim($("#txtTelephone").val()),
            "txtPwd": $.trim($("#txtPwd").val()),
            "txtTelephone":$.trim($("#txtTelephone").val()),
            "txtUserType":$.trim($("input[type='radio'][name='register_usertype']:checked").val()),//会员类型
            "txtBusiCode":$.trim($("#txtBusiCode").val()),//企业营业执照注册号
            "txtEmail": $.trim($("#txtTelephone").val()) + '@139.com',
            "sVerCode": $.trim($("#txtCode").val()),
            "txtSMS": $.trim($("#txtSMS").val()),
            "txtRec": $.trim($("#txtRec").val())
        },
		//timeout: 8000,
		cache: false,
		type: "post",
		dataType: "json",
		success: function (res) {
				if(res==1){
					//window.location.href="/member/common/register2";
					window.location.href="/member";//临时修改
				}else{
					$.jBox.tip(res,"fail");
					//$(ctrl).click(function() { RegSubmit(this); });
				}
		}
	});
}

function myrefresh()
{
	   window.location.href="/member";
}
function AsyncReg(data) {
    Close_Dialog_AutoClose();
    if (data == "True") {
        suc();
    }
    else { }
}

function AsyncReg_Back() { window.location.href = "/member/"; }
