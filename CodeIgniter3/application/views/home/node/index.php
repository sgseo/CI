<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/application/views/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/application/views/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>/application/views/Css/style.css" />
    <script type="text/javascript" src="<?=base_url()?>/application/views/Js/jquery.js"></script>
    <script type="text/javascript" src="<?=base_url()?>/application/views/Js/jquery.sorted.js"></script>
    <script type="text/javascript" src="<?=base_url()?>/application/views/Js/bootstrap.js"></script>
    <script type="text/javascript" src="<?=base_url()?>/application/views/Js/ckform.js"></script>
    <script type="text/javascript" src="<?=base_url()?>/application/views/Js/common.js"></script>

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
            <td><?=$result['account_money']?></td>
            <td><?=$result['wait_interest']?></td>
            <td><?=$result['money_collect']?></td>
            <td><?=$result['back_money']?></td>
            <td><?=$result['money_freeze']?></td>
            <td><?=$result['all_money']?></td>
        </tr>

    </table>
     <!-- 我的个人信息结束 -->

    <!-- 我的投资记录开始 -->
   <div class="form-inline definewidth m20">我的投资记录：<a class="btn btn-success" href="<?=base_url('home/node/cl_invest_import')?>">导出excel</a></div>
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
        <?php
        foreach ($bidlist as $key => $value):
        ?>
        <tr>
            <td><?=$value['bid']?></td>
            <td><?=$value['bname']?></td>
            <td><?=$value['borrow_uname']?></td>
            <td><?=$value['invest_money']?></td>
            <td><?=$value['repayment_money']?></td>
            <td><?=$value['borrow_interest_rate']?></td>
            <td><?=$value['total_periods']?></td>
            <td><?=$value['payed_periods']?></td>
            <td><?=$value['next_pay_date']?></td>
        </tr>
    <?php 
        endforeach;
    ?>
    </table>
  <div class='table table-bordered table-hover definewidth m10' style='margin:0 auto;text-align:center;'>
          <?php 
         for($i=1;$i<=$total;$i++)
          {
             echo "<a href='".base_url('home/node/index?p='.$i.'&dp='.$dp)."'>第".$i."页</a>&nbsp;&nbsp;";
          }
         $p=$p?$p:1;$total=$total?$total:1;

         echo "当前第<span style='color:red'>&nbsp;".$p.'&nbsp;</span>页'."&nbsp;&there4;投资记录共".$total."页";
           ?>
        </div>
        <!-- 我的投资记录结束-->

        <!-- 个人流水开始 -->

        <div class="form-inline definewidth m20">我的交易记录：
            <a class="btn btn-success" href="<?=base_url('home/node/deal_record')?>">导出excel</a></div>
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
        <?php
        foreach ($deallist as $key => $value):
            ?>
        <tr>
            <td><?=$value['date']?></td>
            <td><?=$value['type']?></td>
            <td><?=$value['affect_money']?></td>
            <td><?=$value['collect_money']?></td>
            <td><?=$value['desc']?></td>
            <td><?=$value['account_money']?></td>
        </tr>
        <?php
        endforeach;
        ?>       
</table>
  <div class='table table-bordered table-hover definewidth m10' style='margin:0 auto;text-align:center;'>
           <?php
            for($i=1;$i<=$dtotal;$i++)
            {
                echo "<a href='".base_url('home/node/index?p='.$p.'&dp='.$i)."'>第".$i."页</a>&nbsp;&nbsp;";
            }
            
            $dp=$dp?$dp:1;$total=$dtotal?$dtotal:1;

            echo "当前第<span style='color:red'>&nbsp;".$dp.'&nbsp;</span>页'."&nbsp;&there4;交易记录共".$dtotal."页";
           ?>
  </div>
</body>
</html>
<script type="text/javascript">
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