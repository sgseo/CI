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
</style>

<div class="so_main">
  <!--列表模块-->
<!--   <form name="sdf" id="sdf" action="__URL__/index" method="get">
  <div class="Toolbar_inbox">
    <span>从<input onclick="WdatePicker({maxDate:'#F{$dp.$D(\'end_time\')||\'2020-10-01\'}',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true});" name="start_time" id="start_time"  class="input Wdate" type="text" value="<?php echo (mydate('Y-m-d H:i:s',$search["start_time"])); ?>"><span id="tip_start_time" class="tip">只选开始时间则查询从开始时间往后所有</span>到<input onclick="WdatePicker({minDate:'#F{$dp.$D(\'start_time\')}',maxDate:'2020-10-01',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true});" name="end_time" id="end_time"  class="input Wdate" type="text" value="<?php echo (mydate('Y-m-d H:i:s',$search["end_time"])); ?>"><span id="tip_end_time" class="tip">只选结束时间则查询从结束时间往前所有</span></span>
    <a href="javascript:;" onclick="javascript:document.forms.sdf.submit();" class="btn_a"><span>统计</span></a></div>
</form> -->
<style type="text/css">
.ssx a{height:30px; line-height:30px}
.list td{border-right:1px solid #E3E6EB; width:30%}
.lx{width:100%; overflow:hidden; height:30px; line-height:30px}
.lx dt,.lx dd{float:left; width:40%}
.lx dt{text-align:right;}
.lx dd{text-align:left; text-indent:10px}
</style>
  <div class="list">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
        <th class="line_l">投资者收益统计</th>
    </tr>
    <tr>
       
        <td valign="top">
            <dl class="lx"><dt>成功借款利息总额:</dt><dd><?php echo (fmoney($list["28"]["money"])); ?></dd></dl>
            <dl class="lx"><dt>成功借款投标奖励总额:</dt><dd><?php echo (fmoney($list["21"]["money"])); ?></dd></dl>
            <dl class="lx"><dt>邀请注册奖金总额:</dt><dd><?php echo (fmoney($list["13"]["money"])); ?></dd></dl>
            <dl class="lx"><dt>已付利息总额:</dt><dd><?php echo (fmoney($list["32"]["money"])); ?></dd></dl>
            <dl class="lx"><dt>待付利息总额:</dt><dd><?php echo (fmoney($list["32"]["money"])); ?></dd></dl>
            <dl class="lx"><dt>红包总额:</dt><dd><?php echo (fmoney($red)); ?></dd></dl>
            <!-- <dl class="lx"><dt>总计:</dt><dd><?php echo Fmoney($list['28']['money']+$list['21']['money']+$list['32']['money']);?> -->
</dd></dl>
        </td>
      </tr>
     
    </table>
  </div>
<!--<script type="text/javascript">
var _bdhmProtocol = (("https:" == document.location.protocol) ? " https://" : " http://");
document.write(unescape("%3Cscript src='" + _bdhmProtocol + "hm.baidu.com/h.js%3Ff708bea5a5b94473d52231dbe92e5017' type='text/javascript'%3E%3C/script%3E"));
</script>
-->
</div>
<script type="text/javascript" src="__ROOT__/Style/A/js/adminbase.js"></script>
</body>
</html>