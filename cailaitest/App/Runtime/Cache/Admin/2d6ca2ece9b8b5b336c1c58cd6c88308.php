<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title><?php echo ($ts['site']['site_name']); ?>管理后台</title>
<link href="__ROOT__/Style/A/css/style.css" rel="stylesheet" type="text/css">
<link href="__ROOT__/Style/A/js/tbox/box.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="__ROOT__/Style/A/js/jquery.js"></script>
<script type="text/javascript" src="__ROOT__/Style/A/js/common.js"></script>
<script type="text/javascript" src="__ROOT__/Style/A/js/tbox/box.js"></script>
</head>
<body>
<script type="text/javascript" src="__ROOT__/Style/My97DatePicker/WdatePicker.js" language="javascript"></script>
<style type="text/css">
.tip{color:#F2F4F6}
#container{ width:800px; margin:0 auto; display:block; font-weight:b}

.input1{ width:260px;line-height:22px; min-height:22px;padding:3px;} 
.input2{ width:260px;line-height:22px; min-height:22px;padding:3px;}  

.table_100{width:100%;float:left;height:auto;background:#cecece;color:#000;margin:5px 0;}
.table_100 tr{ background:#fff;} 
.table_100 tr td{ padding:6px 3px;}      
.table_100 tr.top{background:#edecec; font-weight:bold;} 
.table_100 tr:nth-of-type(odd){background:#edecec;} 

.list_bottom_right { width:100%; float:right; height:30px; padding:10px 0;}
.list_bottom_right ul{height:26px;margin-top:8px; float:right; text-align:right;}

.list_bottom_right ul span.current {width:32px;height:30px;font-size: 16px;line-height:30px; display:block; float:left;
border:#00b7ef solid 1px; background:#00b7ef;color: #fff;text-align: center;margin-right:5px;}

.list_bottom_right ul a{width:32px;height:30px;font-size:14px;line-height:30px;color: #949494;float:left;display:block; text-align:center; border:1px solid #ccc;margin-right:8px; text-decoration:none;background:#fff;}
.list_bottom_right ul a:hover {color:#00b7ef; border:#00b7ef solid 1px; background:#00b7ef;}
.list_bottom_right ul a.prevnext{padding:0px 10px 0px 10px;border:1px solid #ccc;color:#666;width:50px;background:#fff;height:30px;line-height:30px;}
.list_bottom_right ul a.prevnext:hover{color:#00b7ef;border:1px solid #00b7ef;background:#fff;}
.list_bottom_right ul a:hover{color:#fff;}
.list_bottom_right ul a.delcolor:hover{color:#00b7ef; border:#00b7ef solid 1px; background:#fff;}
.list_bottom_right ul a.delcolor{padding:0px 10px 0px 10px;border:1px solid #ccc;color:#666;width:50px;background:#fff;height:30px;line-height:30px;}
.model-line label {float: left;}
.err-explain {width: 346px;border: 1px solid #e3d9be;line-height: 22px;background-position: -2px -10px;background-color: #F9F9F9;padding: 4px 3px 4px 24px;color: #4B4E45;
border-radius: 2px;left: 80px;top: -2px;display: none;position: absolute;}
.i1 {left: 400px;width: 450px;}
.model-line {float: left;margin-bottom: 15px;width: 100%;position: relative;}

</style>
<div class="so_main">
<form action="__SELF__" method="post" onsubmit="return check()">
    <div class="model-container clearfix">
        <h2 class="page_tit">发送短信</h2>

        <div class="model-detail">
            <div class="model-line">
                <label for="model">发送号码：</label>
                <textarea rows="5" style="width:300px;" name="mobile" id="mobile"></textarea>
                <div style="display:block;" class="err-explain i1">
                    说明：必填项,如果发送多个用户手机号可用（@）号分隔,例如：138*****@139****
                    <em></em>
                </div>
            </div>
            <div class="model-line">
                <label for="model">短信内容：</label>
                <textarea rows="10" style="width:300px;" name="content" id="content"></textarea>
                <div style="display:block;" class="err-explain i1">
                    说明：必填项,填写短信内容
                    <em></em>
                </div>
            </div>
            <div class="model-line"><strong><input class="btn" type="submit" value="发送" name="submit"></strong></div>
        </div>
    </div>
    <div class="model-line">
    </div>
</form>
<input type="hidden" class="success_mobile" value="<?php echo ($success); ?>">
</div>
<div class="clear"></div> 
<script type="text/javascript">
$(function(){
	var success = $('.success_mobile').val();
	if(success!=''){
		alert("发送成功的短信:"+success);
	}	
})


function check(){
    if ($("#mobile").val() == "") {
        alert("用户手机号码不能为空！");
        return false;
    }   
    if ($("#content").val() == "") {
        alert("短信内容不能为空！");
        return false;
    }
}
</script>

<script type="text/javascript" src="__ROOT__/Style/A/js/adminbase.js"></script>
</body>
</html>