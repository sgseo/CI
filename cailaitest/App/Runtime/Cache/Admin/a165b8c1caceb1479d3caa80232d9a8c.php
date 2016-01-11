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
<style type="text/css">
.quxiantu{ margin-top:30px;}
.qleft{ float:left; width:50%; text-align:left;}
.qright{ float:right; width:50%; text-align:right;}

.ssx a{height:30px; line-height:30px}
.lf{
    float:left;
    width:99%;border:1px solid #D2D2D0; margin: 10px;
}
.lf1{margin-left:10px;}
.lf2{float:left; border:1px solid #D2D2D0; width:50%;}
.lf3{float:right;border:1px solid #D2D2D0;  width:49%;}
.lf h6{
   <!--  border-bottom: 1px solid #e3d9be; -->
    color: #5a4714;
    height: 26px;
    line-height: 28px;
    padding: 0 10px;
    font-size: 13px;
}
.lf2 h6{
   <!--  border-bottom: 1px solid #e3d9be; -->
    color: #5a4714;
    height: 26px;
    line-height: 28px;
    padding: 0 10px;
    font-size: 13px;
}
.lf3 h6{
   <!--  border-bottom: 1px solid #e3d9be; -->
    color: #5a4714;
    height: 26px;
    line-height: 28px;
    padding: 0 10px;
    font-size: 13px;
}
.lf .content{
    padding: 9px 10px;
    line-height: 22px;
}
.lf2 .content{
    padding: 9px 10px;
    line-height: 28px;
}
.lf3 .content{
    padding: 9px 10px;
    line-height: 22px;
    height:130px;
}
.lf .content a{
    color:red;
    font-weight:bold;
}
.lf2 .content a{
    color:red;
    font-weight:bold;
}
.lf3 .content a{
    color:red;
    font-weight:bold;
}
</style>
<script type="text/javascript" src="__ROOT__/Style/Js/highcharts.js"></script>
<script type="text/javascript" src="__ROOT__/Style/Js/exporting.js"></script>
<div class="so_main">
  <div style="height:20px;"></div>
  

<div class="lf">
    <h6>个人信息</h6>
    <div class="content">
        您好，<span style="color:red;font-weight:bold;"><?php echo ($user["user_name"]); ?></span>
        <br />
        所属角色：<?php echo ($user["groupname"]); ?> 
        <br />
        上次登录时间：<?php echo (date('Y-m-d H:i:s',$user["last_log_time"])); ?>
        <br />
        上次登录IP：<?php echo ($user["last_log_ip"]); ?>   
    </div>
</div>

 <div class="lf">
    <h6>待审核工作</h6>
    <div class="content">
     <div style="float: left; width:150px;">
        等待初审的标[<?php if($row["borrow_1"] > 0): ?><a href="__APP__/admin/borrow/waitverify.html" ><?php echo ($row["borrow_1"]); ?></a><?php else: ?> 0<?php endif; ?>]个
     </div>
    <div style="float: left;">
        等待复审的标[<?php if($row["borrow_2"] > 0): ?><a href="__APP__/admin/borrow/waitverify2.html"><?php echo ($row["borrow_2"]); ?></a><?php else: ?> 0<?php endif; ?>]个
     </div>
     <br />
     <div style="float: left; width:150px;">
        额度申请等待审核的[<?php if($row["limit_a"] > 0): ?><a href="__APP__/admin/members/infowait.html"><?php echo ($row["limit_a"]); ?></a><?php else: ?> 0<?php endif; ?>]个 
     </div>
     <div style="float: left;"> 
        上传资料等待审核的[<?php if($row["data_up"] > 0): ?><a href="__APP__/admin/memberdata/index.html"><?php echo ($row["data_up"]); ?></a><?php else: ?> 0<?php endif; ?>]个
     </div>
     <br />
     <div style="float: left; width:150px;">  
        等待VIP认证的[<?php if($row["vip_a"] > 0): ?><a href="__APP__/admin/vipapply/index?status=0"><?php echo ($row["vip_a"]); ?></a><?php else: ?> 0<?php endif; ?>]个
     </div>
     <div style="float: left; ">  
        等待实名认证的[<?php if($row["real_a"] > 0): ?><a href="__APP__/admin/memberid/index?status=3"><?php echo ($row["real_a"]); ?></a><?php else: ?> 0<?php endif; ?>]个
     </div>
     <br />
     <div style="float: left; width:150px;"> 
        等待现场认证的[<?php if($row["face_a"] > 0): ?><a href="__APP__/admin/verifyface/index.html"><?php echo ($row["face_a"]); ?></a><?php else: ?> 0<?php endif; ?>]个
     </div>
	 <br />
     <div style="float: left; width:150px;">
        等待视频认证的[<?php if($row["video_a"] > 0): ?><a href="__APP__/admin/verifyvideo/index.html"><?php echo ($row["video_a"]); ?></a><?php else: ?> 0<?php endif; ?>]个
     </div>
     <br />
     <div style="float: left; width:150px;">   
        等待审核提现[<?php if($row["withdraw"] > 0): ?><a href="__APP__/admin/Withdrawlogwait/index.html"><?php echo ($row["withdraw"]); ?></a><?php else: ?> 0<?php endif; ?>]个
     </div>
	  <br />
    </div>
</div>
<div class="lf1">
<div class="lf2">
    <h6>系统信息</h6>
	 <div class="content">
     <div style="float: left; width:300px;">
        财来网程序版本：财来网超级版 
     </div>
    <div style="float: left;">
        操作系统：<?php echo ($service["service_name"]); ?> 
     </div>
     <br />
	<div style="float: left; width:300px;">
       服务器软件：<?php echo ($service["service"]); ?>
     </div>
    <div style="float: left;">
        MySQL 版本：<?php echo ($service["mysql"]); ?>
     </div>
     <br />
	 <div style="float: left; width:300px;">
      服务器协议：<?php echo ($_SERVER['SERVER_PROTOCOL']); ?>
     </div>
    <div style="float: left;">
      服务器名称：<?php echo ($_SERVER['SERVER_NAME']); ?>
     </div>
     <br />
	 <div style="float: left; width:300px;">
      网关接口：<?php echo ($_SERVER['GATEWAY_INTERFACE']); ?>
     </div>
    <div style="float: left;">
      服务器IP：<?php echo ($_SERVER['SERVER_ADDR']); ?>
     </div>
	<br />
	 </div>
	 
	 
</div> 
<div class="lf3">
	 <h6>开发团队</h6>
    <div class="content">
        版权所有：上海财来金融信息服务股份有限公司
        <br />
		 总策划:
       
        <br />
        开发与支持团队：
        <br />    
        UI 设计：
        <br />    
        官方网站：http://www.cailai.com/ 
        <br />    
       
    </div>
</div>
</div>
  

</div>
<script type="text/javascript" src="__ROOT__/Style/A/js/adminbase.js"></script>
</body>
</html>