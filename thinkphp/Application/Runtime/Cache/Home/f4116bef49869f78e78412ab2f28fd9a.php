<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/thinkphp/Public/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="/thinkphp/Public/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="/thinkphp/Public/Css/style.css" />
    <script type="text/javascript" src="/thinkphp/Public/Js/jquery.js"></script>
    <script type="text/javascript" src="/thinkphp/Public/Js/jquery.sorted.js"></script>
    <script type="text/javascript" src="/thinkphp/Public/Js/bootstrap.js"></script>
    <script type="text/javascript" src="/thinkphp/Public/Js/ckform.js"></script>
    <script type="text/javascript" src="/thinkphp/Public/Js/common.js"></script>

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
<!-- <form class="form-inline definewidth m20" action="/thinkphp/Home/Role/rectendback?userId=123487&real_name=%E8%8C%83%E4%BB%A5%E5%BD%A4" method="post">  
    我推荐的人员列表&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    推荐者手机：
    <input type="text" name="mobile" id="rolename" class="abc input-default" placeholder="" value="">&nbsp;&nbsp;  
    <button type="submit" class="btn btn-primary">查询</button>&nbsp;&nbsp; 
  <button type="button" class="btn btn-success" id="addnew">新增角色</button>
</form> -->
<div class="form-inline definewidth m20"><font color='red'><?php echo ($real_name); ?></font> 的投资记录：</div>
<table class="table table-bordered table-hover definewidth m10" >
    <thead>
        <tr>
            <th>借款标号</th>
            <th>标的标题</th>
            <th>电子合同</th>
            <th>借款人姓名</th>
            <th>投资金额</th>
            <th>已还本息</th>
            <th>年利率</th>
            <th>总共期限</th>
            <th>已经期数</th>
            <th>下一还款时间</th>
            <th>投资时间</th>
        </tr>
    </thead>

    <?php if(is_array($reclist)): $i = 0; $__LIST__ = array_slice($reclist,$cls,$spc,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($vo["bid"]); ?></td>
            <td><?php echo ($vo["bname"]); ?></td>
            <td><a href="https://test.cailai.com/home/agreement/downfile?id=<?php echo ($vo["bid"]); ?>">查看</a></td>
            <td><?php echo ($vo["borrow_uname"]); ?></td>
            <td><?php echo ($vo["invest_money"]); ?></td>
            <td><?php echo ($vo["repayment_money"]); ?></td>
            <td><?php echo ($vo["borrow_interest_rate"]); ?></td>
            <td><?php echo ($vo["total_periods"]); ?></td>
            <td><?php echo ($vo["payed_periods"]); ?></td>
            <td><?php echo ($vo["next_pay_date"]); ?></td>
            <td><?php echo (date('Y-m-d',$vo["atime"])); ?></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>

        <!-- <tr><td colspan='6'> 对我的总贡献:<font color='red'><?php $single_bonus=$single_bonus?$single_bonus:$total_bonus;echo $single_bonus; ?></font>元</td></tr>
   -->
    </table>
    <div class='table table-bordered table-hover definewidth m10' style='margin:0 auto;text-align:center;'>
           <?php for($i=1;$i<=$total;$i++) { echo "<a href='/thinkphp/Home/Role/rectendback?userId=$condi&real_name=$real_name&p=$i'>"."第".$i.'页</a>&nbsp;&nbsp;'; } $p=$p?$p:1;$total=$total?$total:1; echo "当前第<span style='color:red'>&nbsp;".$p.'&nbsp;</span>页'."共".$total."页"; ?>
    </div>
		</body>
		</html>

<script>
 //    $(function () {
        
	// 	$('#addnew').click(function(){

	// 			window.location.href="add.html";
	// 	 });


 //    });

	// function del(id)
	// {
		
		
	// 	if(confirm("确定要删除吗？"))
	// 	{
		
	// 		var url = "index.html";
			
	// 		window.location.href=url;		
		
	// 	}
	
	
	
	
	// }
</script>