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
  <form name="sdf" id="sdf" action="__URL__/zwindex" method="post">
  <div class="Toolbar_inbox">
  	<span>从<input onclick="WdatePicker({maxDate:'#F{$dp.$D(\'end_time\')||\'2020-10-01\'}',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true});" name="start_time" id="start_time"  class="input Wdate" type="text" value="<?php echo (mydate('Y-m-d H:i:s',$search["start_time"])); ?>"><span id="tip_start_time" class="tip">只选开始时间则查询从开始时间往后所有</span>到<input onclick="WdatePicker({minDate:'#F{$dp.$D(\'start_time\')}',maxDate:'2020-10-01',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true});" name="end_time" id="end_time"  class="input Wdate" type="text" value="<?php echo (mydate('Y-m-d H:i:s',$search["end_time"])); ?>"><span id="tip_end_time" class="tip">只选结束时间则查询从结束时间往前所有</span></span>
    <a href="javascript:;" onclick="javascript:document.forms.sdf.submit();" class="btn_a"><span>统计</span></a>
  </div>
</form>
<style>

#container{ width:800px; margin:0 auto; display:block; font-weight:b}

.input1{ width:260px;line-height:22px; min-height:22px;padding:3px;} 
.input2{ width:260px;line-height:22px; min-height:22px;padding:3px;}  

.table_100{width:100%;float:left;height:auto;background:#cecece;color:#000;margin:5px 0;}
.table_100 tr{ background:#fff;} 
.table_100 tr td{ padding:6px 3px;}      
.table_100 tr.top{background:#edecec; font-weight:bold;} 
.table_100 tr:nth-of-type(odd){background:#edecec;} 

</style> 
  <div class="list">
<table class="table_100" border="0" cellspacing="0" cellpadding="0">
<tr class="top">
<td width="16%">ID</td>
<td width="16%">姓名</td>
<td width="16%">实名注册数</td>
<td width="16%">首次有效投资数</td>
<td width="16%">年化投资金额</td>
<td width="17%">年化投资金额</td>
</tr>
<?php foreach($recommenderInfo as $key=>$value ){ ?>
<tr>
<td> <?php echo $value['id']; ?></td>
<td><?php echo $value['recommender']; ?></td>
<td><?php echo $value['register_number']; ?></td>
<td><?php echo $value['first_invest']; ?></td>
<td><?php echo $value['investMoney']; ?></td>
<td><?php echo $value['investAllMoney']; ?></td>
</tr>
<?php } ?>
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