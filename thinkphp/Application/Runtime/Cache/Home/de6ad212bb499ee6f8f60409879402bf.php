<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/Public/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Css/style.css" />
    <script type="text/javascript" src="/Public/Js/jquery.js"></script>
    <script type="text/javascript" src="/Public/Js/jquery.sorted.js"></script>
    <script type="text/javascript" src="/Public/Js/bootstrap.js"></script>
    <script type="text/javascript" src="/Public/Js/ckform.js"></script>
    <script type="text/javascript" src="/Public/Js/common.js"></script>

    <style type="text/css">
        body {
            padding-bottom: 40px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }

        @media (max-width: 980px) {
            /* Enable use of floated navbar text */
            .navbar-text.pull-right {
                float: none;
                padding-left: 5px;
                padding-right: 5px;
            }
        }


    </style>
</head>
<body>
<!-- <form class="form-inline definewidth m20" action="index.html" method="get">  
    机构名称：
    <input type="text" name="rolename" id="rolename"class="abc input-default" placeholder="" value="">&nbsp;&nbsp;  
    <button type="submit" class="btn btn-primary">查询</button>&nbsp;&nbsp; <button type="button" class="btn btn-success" id="addnew">新增机构</button>
</form> -->
        <!-- 我的个人信息开始 -->
<div class="form-inline definewidth m20">我的个人信息(单位：元)</div>
<table class="table table-bordered table-hover definewidth m10" >
    <thead>
    <tr>
      
        <th>帐户余额</th>
        <th>待收利息</th>
        <th>待收总额</th>
        <th>已收利息</th>
        <th>冻结金额</th>
        <th>总资产额</th>
    </tr>
    </thead>
	     <tr>
            <td><?php echo ($result["data"]["account_money"]); ?></td>
            <td><?php echo ($result["data"]["wait_interest"]); ?></td>
            <td><?php echo ($result["data"]["money_collect"]); ?></td>
            <td><?php echo ($result["data"]["back_money"]); ?></td>
            <td><?php echo ($result["data"]["money_freeze"]); ?></td>
            <td><?php echo ($result["data"]["all_money"]); ?></td>
        </tr>

    </table>
     <!-- 我的个人信息结束 -->

    <!-- 我的投资记录开始 -->
   <div class="form-inline definewidth m20">我的投资记录：<a class="btn btn-success" href="/Home/Node/invest_record">导出excel</a></div>
    <table class="table table-bordered table-hover definewidth m10" >
    <thead>
    <tr>
        <th>借款标号</th>
        <th>借款名字</th>
        <th>借款人姓名</th>
        <th>投资金额</th>
        <th>已还本息</th>
        <th>年利率</th>
        <th>总共期数</th>
        <th>已经期数</th>
        <th>下一还款时间</th>
    </tr>
    </thead>
        <?php if(is_array($bidlist["data"])): $i = 0; $__LIST__ = array_slice($bidlist["data"],$cls,$spc,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($vo["bid"]); ?></td>
            <td><?php echo ($vo["bname"]); ?></td>
            <td><?php echo ($vo["borrow_uname"]); ?></td>
            <td><?php echo ($vo["invest_money"]); ?></td>
            <td><?php echo ($vo["repayment_money"]); ?></td>
            <td><?php echo ($vo["borrow_interest_rate"]); ?></td>
            <td><?php echo ($vo["total_periods"]); ?></td>
            <td><?php echo ($vo["payed_periods"]); ?></td>
            <td><?php echo ($vo["next_pay_date"]); ?></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </table>
  <div class='table table-bordered table-hover definewidth m10' style='margin:0 auto;text-align:center;'>
           <?php for($i=1;$i<=$total;$i++) { echo "<a href='/Home/Node/?p=$i&dp=$dp'>"."第".$i.'页</a>&nbsp;&nbsp;'; } $p=$p?$p:1;$total=$total?$total:1; echo "当前第<span style='color:red'>&nbsp;".$p.'&nbsp;</span>页'."&nbsp;&there4;投资记录共".$total."页"; ?>
        </div>
        <!-- 我的投资记录结束-->

        <!-- 个人流水开始 -->

         <div class="form-inline definewidth m20">我的交易记录：<a class="btn btn-success" href="/Home/Node/deal_record">导出excel</a></div>
    <table class="table table-bordered table-hover definewidth m10" >
    <thead>
    <tr>
        <th>交易时间</th>
        <th>交易类型</th>
        <th>影响金额</th>
        <th>待收金额</th>
        <th>说明</th>
        <th>可用余额</th>
    </tr>
    </thead>
        <?php if(is_array($deallist["data"])): $i = 0; $__LIST__ = array_slice($deallist["data"],$dcls,$dspc,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($vo["date"]); ?></td>
            <td><?php echo ($vo["type"]); ?></td>
            <td><?php echo ($vo["affect_money"]); ?></td>
            <td><?php echo ($vo["collect_money"]); ?></td>
            <td><?php echo ($vo["desc"]); ?></td>
            <td><?php echo ($vo["account_money"]); ?></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>

        
</table>
  <div class='table table-bordered table-hover definewidth m10' style='margin:0 auto;text-align:center;'>
           <?php for($i=1;$i<=$dtotal;$i++) { echo "<a href='/Home/Node/?p=$p&dp=$i'>"."第".$i.'页</a>&nbsp;&nbsp;'; } $dp=$dp?$dp:1;$total=$dtotal?$dtotal:1; echo "当前第<span style='color:red'>&nbsp;".$dp.'&nbsp;</span>页'."&nbsp;&there4;交易记录共".$dtotal."页"; ?>
        </div>
        <!-- 个人流水结束 -->
<!-- <div class="inline pull-right page">
         10122 条记录 1/507 页  <a href='#'>下一页</a>     <span class='current'>1</span><a href='#'>2</a><a href='/chinapost/index.php?m=Label&a=index&p=3'>3</a><a href='#'>4</a><a href='#'>5</a>  <a href='#' >下5页</a> <a href='#' >最后一页</a>    </div> -->
</body>
</html>
<script>
    $(function () {
        
		$('#addnew').click(function(){

				window.location.href="add.html";
		 });


    });

	function del(id)
	{
		
		
		if(confirm("确定要删除吗？"))
		{
		
			var url = "index.html";
			
			window.location.href=url;		
		
		}
	
	
	
	
	}
</script>