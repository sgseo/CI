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
    var delUrl = '__URL__/doDel';
    var addUrl = '__URL__/add';
    var isSearchHidden = 1;
</script>
<div class="so_main">
  <div class="page_tit">债权转让</div>
<!--搜索/筛选会员-->
  <script type="text/javascript" src="__ROOT__/Style/My97DatePicker/WdatePicker.js" language="javascript"></script>
<script type="text/javascript">
	var searchName = "搜索/筛选借款";
</script>
  <div id="search_div" style="display:none">
  	<div class="page_tit"><script type="text/javascript">document.write(searchName);</script> [ <a href="javascript:void(0);" onclick="dosearch();">隐藏</a> ]</div>
	
	<div class="form2">
	<form method="get" action="__URL__/<?php echo ($xaction); ?>">
    <?php if($search["customer_id"] > 0): ?><input type="hidden" name="customer_id" value="<?php echo ($search["customer_id"]); ?>" /><?php endif; ?>
    <?php if($search["uid"] > 0): ?><input type="hidden" name="uid" value="<?php echo ($search["uid"]); ?>" /><input type="hidden" name="olduname" value="<?php echo ($search["uname"]); ?>" /><?php endif; ?>
   <dl class="lineD">
      <dt>会员名：</dt>
      <dd>
        <input name="uname" style="width:190px" id="title" type="text" value="<?php echo ($search["uname"]); ?>">
        <span>不填则不限制</span>
      </dd>
    </dl>
    <dl class="lineD">
      <dt>所属客服：</dt>
      <dd>
        <input name="customer_name" style="width:190px" id="title" type="text" value="<?php echo ($search["customer_name"]); ?>">
        <span>不填则不限制</span>
      </dd>
    </dl>
	
    <dl class="lineD">
      <dt>借款金额：</dt>
      <dd>
      <select name="bj" id="bj" style="width:80px"  class="c_select"><option value="">--请选择--</option><?php foreach($bj as $key=>$v){ if($search["bj"]==$key && $search["bj"]!=""){ ?><option value="<?php echo ($key); ?>" selected="selected"><?php echo ($v); ?></option><?php }else{ ?><option value="<?php echo ($key); ?>"><?php echo ($v); ?></option><?php }} ?></select>
      <input name="money" id="money" style="width:100px" class="input" type="text" value="<?php echo ($search["money"]); ?>" >
        <span>不填则不限制</span>
      </dd>
    </dl>

	<dl class="lineD"><dt>借款时间(开始)：</dt><dd><input onclick="WdatePicker({maxDate:'#F{$dp.$D(\'end_time\')||\'2020-10-01\'}',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true});" name="start_time" id="start_time"  class="input Wdate" type="text" value="<?php echo (mydate('Y-m-d H:i:s',$search["start_time"])); ?>"><span id="tip_start_time" class="tip">只选开始时间则查询从开始时间往后所有</span></dd></dl>
	<dl class="lineD"><dt>借款时间(结束)：</dt><dd><input onclick="WdatePicker({minDate:'#F{$dp.$D(\'start_time\')}',maxDate:'2020-10-01',dateFmt:'yyyy-MM-dd HH:mm:ss',alwaysUseStartDate:true});" name="end_time" id="end_time"  class="input Wdate" type="text" value="<?php echo (mydate('Y-m-d H:i:s',$search["end_time"])); ?>"><span id="tip_end_time" class="tip">只选结束时间则查询从结束时间往前所有</span></dd></dl>

    <div class="page_btm">
      <input type="submit" class="btn_b" value="确定" />
    </div>
	</form>
  </div>
  </div>
<!--搜索/筛选会员-->

  <div class="Toolbar_inbox">
      <div class="page right"><?php echo ($list["page"]); ?></div>
    <a href="__URL__/index" class="btn_a"><span class="search_action">所有债权转让</span></a>
    <a href="__URL__/index?status=1,4" class="btn_a"><span class="search_action">转让成功的债权</span></a>
    <a href="__URL__/index?status=2" class="btn_a"><span class="search_action">正在转让的债权</span></a>
    <a href="__URL__/index?status=3" class="btn_a"><span class="search_action">撤销的债权</span></a>
  </div>
  
  <div class="list">
  <table id="area_list" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <th style="width:30px;">
        <input type="checkbox" id="checkbox_handle" onclick="checkAll(this)" value="0">
        <label for="checkbox"></label>
    </th>
    <th class="line_l">ID</th>
    <th class="line_l">转让人</th>
    <th class="line_l">投资标题</th>
    <th class="line_l">利率</th>
    <th class="line_l">待收期数</th>
    <th class="line_l">转让期数</th>
    <th class="line_l">总期数</th>
    <th class="line_l">待收本金</th>
    <th class="line_l">待收利息</th>
    <th class="line_l">转让价格</th>
    <th class="line_l">提交时间</th>
    <th class="line_l">状态</th>  
  </tr>
  <?php if(is_array($list["data"])): $i = 0; $__LIST__ = $list["data"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr overstyle='on' id="list_<?php echo ($vo["id"]); ?>">
        <td><input type="checkbox" name="checkbox" id="checkbox2" onclick="checkon(this)" value="<?php echo ($vo["id"]); ?>"></td>
        <td><?php echo ($vo["debt_id"]); ?></td>
        <td><a onclick="loadUser(<?php echo ($vo["mid"]); ?>,'<?php echo ($vo["user_name"]); ?>')" href="javascript:void(0);"><?php echo ($vo["user_name"]); ?></a></td>
        <td><a href="<?php echo (getinvesturl($vo["id"])); ?>" title="<?php echo ($vo["borrow_name"]); ?>" target="_blank"><?php echo (cnsubstr($vo["borrow_name"],12)); ?></a></td>
        <td><?php echo ($vo["borrow_interest_rate"]); ?>%</td>
        <td><?php echo ($vo['total']-$vo['has_pay']); ?>期</td>
        <td><?php echo ($vo["period"]); ?>期</td>
        <td><?php echo ($vo["total"]); ?>期</td>
        <td>￥<?php echo (($vo["capital"])?($vo["capital"]):0); ?></td>
        <td>￥<?php echo (($vo["interest"])?($vo["interest"]):0); ?></td>
        <td>￥<?php echo (($vo["transfer_price"])?($vo["transfer_price"]):0); ?></td>
        <td><?php echo (date("Y-m-d H:i",$vo["addtime"])); ?></td> 
        <td>
            <?php if($vo["status"] == '99'): ?><a href="javascript:void(0)" onclick="ui.box.load('/admin/debt/audit?debt_id=<?php echo ($vo["debt_id"]); ?>', {title:'债权转让审核'})">审核</a> 
            <?php elseif($vo["status"] == 1): ?> 
                转让成功
            <?php elseif($vo["status"] == 2): ?> 
                转让中
            <?php elseif($vo["status"] == 3): ?> 
                撤销 
            <?php elseif($vo["status"] == 4): ?> 
                还款结束<?php endif; ?>
        </td> 
      </tr><?php endforeach; endif; else: echo "" ;endif; ?>
  </table>

  </div>
  
  <div class="Toolbar_inbox" style="overflow: hidden;">
      <div class="page right"><?php echo ($list["page"]); ?></div>
  </div>
</div>


<script type="text/javascript" src="__ROOT__/Style/A/js/adminbase.js"></script>
</body>
</html>