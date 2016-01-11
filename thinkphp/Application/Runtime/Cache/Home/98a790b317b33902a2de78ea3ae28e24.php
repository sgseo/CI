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
<form class="form-inline definewidth m20" action="/Home/Role/index" method="post">  
    我推荐的人员列表&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    推荐者手机：
    <input type="text" name="mobile" id="rolename" class="abc input-default" placeholder="" value="">&nbsp;&nbsp;  
    <button type="submit" class="btn btn-primary">查询</button>&nbsp;&nbsp; 
    <!-- <button type="button" class="btn btn-success" id="addnew">新增角色</button> -->
    <a class="btn btn-success" href="/Home/Role/cl_to_excel">下载</a>
</form>
<table class="table table-bordered table-hover definewidth m10" >
    <thead>
    <tr>
        <th>推荐者id</th>
        <th>推荐者姓名</th>
        <th>推荐者电话</th>
        <th>推荐者贡献额度</th>
        <th>推荐者注册时间</th>
        <th>操作</th>
       
    </tr>
    </thead>

    <?php if(is_array($result)): $i = 0; $__LIST__ = array_slice($result,$cls,$spc,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
          <td><?php echo ($vo["id"]); ?></td>
          <td><?php echo ($vo["real_name"]); ?></td>
          <td><?php echo ($vo["mobile"]); ?></td>
          <td><?php echo ($vo["bonus"]); ?></td>
          <td><?php echo ($vo["reg_date"]); ?></td>
          <td>
            <a href="/Home/Role/rectendback?userId=<?php echo ($vo["id"]); ?>&real_name=<?php echo ($vo["real_name"]); ?>">投资记录</a>&there4;
            <a href="/Home/Role/remember?userId=<?php echo ($vo["id"]); ?>&real_name=<?php echo ($vo["real_name"]); ?>&phone=<?php echo ($vo["mobile"]); ?>">资金状况</a></td>
            <!-- <?php echo ($vo["mobile"]); ?> -->
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        <tr><td colspan='6'> 对我的总贡献:<font color='red'><?php $single_bonus=$single_bonus?$single_bonus:$total_bonus;echo $single_bonus; ?></font>元</td></tr>
  
    </table>
    <div class='table table-bordered table-hover definewidth m10' style='margin:0 auto;text-align:center;'>
           <?php for($i=1;$i<=$total;$i++) { echo "<a href='/Home/Role/?p=$i&tp=$tp'>"."第".$i.'页</a>&nbsp;&nbsp;'; } $p=$p?$p:1;$total=$total?$total:1; echo "当前第<span style='color:red'>&nbsp;".$p.'&nbsp;</span>页'."共".$total."页"; ?>
    </div>
  
        <!-- 今日投资的人 -->
<div class="form-inline definewidth m20"><font color='red'>今日</font> 投资的人的投资记录：</div>

<table class="table table-bordered table-hover definewidth m10" >
    <thead>
        <tr>
            <th>借款标号</th>
            <th>标的标题</th>
            <th>电子合同</th>
            <th>借款人姓名</th>
            <th>投资人姓名</th>
            <th>投资人电话</th>
            <th>投资金额</th>
            <th>年利率</th>
            <th>投资时间</th>
        </tr>
    </thead>

<?php if(count($tinvestors) != 0): ?>ThinkPHP
    <?php if(is_array($tinvestors)): $i = 0; $__LIST__ = array_slice($tinvestors,$tcls,$tspc,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($vo["borrow_id"]); ?></td>
            <td><?php echo ($vo["borrow_name"]); ?></td>
            <td><a href="https://test.cailai.com/home/agreement/downfile?id=<?php echo ($vo["borrow_id"]); ?>">查看</a></td>
            <td><?php echo ($vo["borrow_real_name"]); ?></td>
            <td><?php echo ($vo["real_name"]); ?></td>
            <td><?php echo ($vo["cell_phone"]); ?></td>
            <td><?php echo ($vo["investor_capital"]); ?></td>
            <td><?php echo ($vo["borrow_interest_rate"]); ?></td>
            <td><?php echo (date("Y-m-d H:i:s",$vo["add_time"])); ?></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </table>
    <div class='table table-bordered table-hover definewidth m10' style='margin:0 auto;text-align:center;'>
           <?php for($i=1;$i<=$ttotal;$i++) { echo "<a href='/Home/Role/index?&p=$p&tp=$i'>"."第".$i.'页</a>&nbsp;&nbsp;'; } $tp=$tp?$tp:1;$ttotal=$ttotal?$ttotal:1; echo "当前第<span style='color:red'>&nbsp;".$tp.'&nbsp;</span>页'."共".$ttotal."页"; ?>
    </div>
     <?php else: ?><div class="form-inline definewidth m20"><font color='red'>今日暂无投资人</font> </div><?php endif; ?>

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