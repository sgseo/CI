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

<script type="text/javascript">
  var delUrl = '__URL__/doDel';
  var addUrl = '__URL__/add';
  var isSearchHidden = 1;
  var searchName = "搜索/筛选会员";
</script>
<div class="so_main">
  <div class="page_tit"><?php echo ($status_html); ?>会员交易明细</div>
    <div id="search_div" style="display:none">
    <div class="page_tit"><script type="text/javascript">document.write(searchName);</script> [ <a href="javascript:void(0);" onclick="dosearch();">隐藏</a> ]</div>
  
  <div class="form2">
  <form method="get" action="__URL__/index">
    <?php if($search["uid"] > 0): ?><input type="hidden" name="uid" value="<?php echo ($search["uid"]); ?>" /><?php endif; ?>
    <dl class="lineD">
      <dt>会员名：</dt>
      <dd>
        <input name="uname" style="width:190px" id="title" type="text" value="<?php echo ($search["uname"]); ?>">
        <span>不填则不限制</span>
      </dd>
    </dl>
  
    <dl class="lineD">
      <dt>交易类型：</dt>
      <dd>
      <select name="type" id="type" style="width:150px"  class="c_select"><option value="">--请选择--</option><?php foreach($type as $key=>$v){ if($search["type"]==$key && $search["type"]!=""){ ?><option value="<?php echo ($key); ?>" selected="selected"><?php echo ($v); ?></option><?php }else{ ?><option value="<?php echo ($key); ?>"><?php echo ($v); ?></option><?php }} ?></select>
        <span>不填则不限制</span>
      </dd>
    </dl>
    
  <dl class="lineD"><dt>交易时间(开始)：</dt><dd><input onclick="WdatePicker({maxDate:'#F{$dp.$D(\'end_time\')||\'2020-10-01\'}',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true});" name="start_time" id="start_time"  class="input" type="text" value="<?php echo ($search["start_time"]); ?>"><span id="tip_start_time" class="tip">时间段(包括当天)</span></dd></dl>
  <dl class="lineD"><dt>交易时间(结束)：</dt><dd><input onclick="WdatePicker({minDate:'#F{$dp.$D(\'start_time\')}',maxDate:'2020-10-01',dateFmt:'yyyy-MM-dd',alwaysUseStartDate:true});" name="end_time" id="end_time"  class="input" type="text" value="<?php echo ($search["end_time"]); ?>"><span id="tip_end_time" class="tip">时间段(包括当天)</span></dd></dl>

    <div class="page_btm">
      <input type="submit" class="btn_b" value="确定" />
    </div>
  </form>
  </div>
  </div>
  <div class="Toolbar_inbox">
    <div class="page right"><?php echo ($pagebar); ?></div>
    <a onclick="dosearch();" class="btn_a" href="javascript:void(0);"><span class="search_action">搜索/筛选会员</span></a>
  </div>
  
  <div class="list">
  <table id="area_list" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th style="width:30px;">
        <input type="checkbox" id="checkbox_handle" onclick="checkAll(this)" value="0">
        <label for="checkbox"></label>
    </th>
    <th class="line_l">ID</th>
    <th class="line_l">用户名</th>
    <th class="line_l">交易类型</th>
    <th class="line_l">影响积分</th>
    <th class="line_l">可用积分</th>
    <th class="line_l">总积分</th>
    <th class="line_l">发生时间</th>
    <th class="line_l">说明</th>
  </tr>
  <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr overstyle='on' id="list_<?php echo ($vo["id"]); ?>">
        <td><input type="checkbox" name="checkbox" id="checkbox2" onclick="checkon(this)" value="<?php echo ($vo["id"]); ?>"></td>
        <td><?php echo ($vo["id"]); ?></td>
        <td><a onclick="loadUser(<?php echo ($vo["uid"]); ?>,'<?php echo ($vo["user_name"]); ?>')" href="javascript:void(0);"><?php echo ($vo["user_name"]); ?></a></td>
        <td><?php echo ($type[$vo['type']]); ?>(<?php echo ($vo['type']); ?>)</td>
        <td><?php echo (($vo["affect_integral"])?($vo["affect_integral"]):0); ?></td>
        <td><?php echo (($vo["active_integral"])?($vo["active_integral"]):0); ?></td>
        <td><?php echo (($vo["account_integral"])?($vo["account_integral"]):0); ?></td>
        <td><?php echo (date("Y-m-d H:i",$vo["add_time"])); ?></td>
        <td><?php echo ($vo["info"]); ?></td>
      </tr><?php endforeach; endif; else: echo "" ;endif; ?>
  </table>

  </div>
  
  <div class="Toolbar_inbox">
    <div class="page right"><?php echo ($pagebar); ?></div>
    <a onclick="dosearch();" class="btn_a" href="javascript:void(0);"><span class="search_action">搜索/筛选会员</span></a>
  </div>
</div>
<script type="text/javascript">
function showurl(url,Title){
  ui.box.load(url, {title:Title});
}
</script>

<script type="text/javascript" src="__ROOT__/Style/A/js/adminbase.js"></script>
</body>
</html>