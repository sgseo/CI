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
    <div class="form-inline definewidth m20">我的回款计划 &there4;(单位:元)</div>
<form class="form-inline definewidth m20" action="/Home/index/cl_moneyback" method="get">  
    回款月份（默认当前月）：
    <input type="text" name="month" id="rolename"class="abc input-default" placeholder="" value="">&nbsp;&nbsp;  
    <button type="submit" class="btn btn-primary">查询</button>&nbsp;&nbsp; 
    <a href="/Home/Index/cl_to_excel" class="btn btn-success" id="addnew">下载</a> 
</form>
        <!-- 我的个人信息开始 -->

<table class="table table-bordered table-hover definewidth m10" >
    <thead>
    <tr>
      
        <th>借款标号</th>
        <th>借款人id</th>
        <th>借款人姓名</th>
        <th>应收利息</th>
        <th>应收本金</th>
        <th>利息管理费</th>
        <th>标的状态</th>
        <th>应还日期</th>
        <th>逾期罚金</th>
        <th>预期总收益</th>
    </tr>
    </thead>
    <?php if(is_array($result)): $i = 0; $__LIST__ = array_slice($result,$cls,$spc,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($vo["borrow_id"]); ?></td>
            <td><?php echo ($vo["borrow_uid"]); ?></td>
            <td><?php echo ($vo["real_name"]); ?></td>
            <td><?php echo ($vo["interest"]); ?></td>
            <td><?php echo ($vo["capital"]); ?></td>
            <td><?php echo ($vo["interest_fee"]); ?></td>
            <td><?php echo ($status_arr[$vo['status']]); ?></td>
            <td><font color='red'><?php echo (date('Y-m-d',$vo["deadline"])); ?></font></td>
            <td><?php echo ($vo["expired_money"]); ?></td>
            <td><?php echo ($vo['interest']+$vo['capital']-$vo['interest_fee']); ?></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    
    </table>
     <!-- 我的个人信息结束 -->
     <div class='table table-bordered table-hover definewidth m10' style='margin:0 auto;text-align:center;'>
           <?php for($i=1;$i<=$total;$i++) { echo "<a href='/Home/index/cl_moneyback?p=$i&month=$m'>"."第".$i.'页</a>&nbsp;&nbsp;'; } $p=$p?$p:1;$total=$total?$total:1; echo "当前第<span style='color:red'>&nbsp;".$p.'&nbsp;</span>页'."共".$total."页"; ?>
    </div>
  
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