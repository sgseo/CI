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

<script type="text/javascript">
	var setUrl = '__URL__/set';
	var tableUrl = '__URL__/showtable';
	var setTitle = '备份参数';
	var strTitle = '查看表结构';
</script>
<div class="so_main">
  <div class="page_tit">数据库管理</div>

  <div class="Toolbar_inbox">
    <a onclick="javascript:bakup();" class="btn_a" href="javascript:void(0);"><span>备份所选表</span></a>
  </div>
  
  <div class="list">
  <table id="area_list" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th style="width:30px;">
        <input type="checkbox" id="checkbox_handle" onclick="checkAll(this)" value="0">
        <label for="checkbox"></label>
    </th>
    <th class="line_l">序号</th>
    <th class="line_l">表名</th>
    <th class="line_l">引擎</th>
    <th class="line_l">编码</th>
    <th class="line_l">记录数</th>
    <th class="line_l">大小</th>
    <th class="line_l">最后更新时间</th>
    <th class="line_l">操作</th>
  </tr>
  <?php if(is_array($tablelist)): $i = 0; $__LIST__ = $tablelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr overstyle='on' id="list_<?php echo ($vo["Name"]); ?>">
        <td><input type="checkbox" name="checkbox" id="checkbox2" onclick="checkon(this)" value="<?php echo ($vo["Name"]); ?>"></td>
        <td><?php echo ($key); ?></td>
        <td><?php echo ($vo["Name"]); ?></td>
        <td><?php echo ($vo["Engine"]); ?></td>
        <td><?php echo (($vo["Collation"])?($vo["Collation"]):'--'); ?></td>
        <td><?php echo ($vo["Rows"]); ?></td>
        <td><?php echo getMb($vo['Data_length']+$vo['Index_length']);$total_szie+=$vo['Data_length']+$vo['Index_length']; ?></td>
        <td><?php echo ($vo["Update_time"]); ?></td>
        <td>
            <a href="javascript:showtable('<?php echo ($vo["Name"]); ?>')">查看表结构</a> 
        </td>
      </tr><?php endforeach; endif; else: echo "" ;endif; ?>
  <tr><td colspan="9" align="right">数据库总大小：<?php echo getMb($total_szie); ?></td></tr>
  </table>

  </div>
  
  <div class="Toolbar_inbox">
    <a onclick="javascript:bakup();" class="btn_a" href="javascript:void(0);"><span>备份所选表</span></a>
  </div>
</div>
<script type="text/javascript">
function bakup(){
	var table = getChecked();
	if(table=="") {
		alert("请选择要备份的表");
		return false;
	}
	ui.box.load(setUrl, {title:setTitle},"POST",{"tables":table});
}
function showtable(table){
	if(table=="") {
		return false;
	}
	ui.box.load(tableUrl+"?tables="+table, {title:strTitle});
}
</script>

<script type="text/javascript" src="__ROOT__/Style/A/js/adminbase.js"></script>
</body>
</html>