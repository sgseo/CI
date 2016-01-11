<!DOcTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>application/views/css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>application/views/css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>application/views/css/style.css" />
    <script type="text/javascript" src="<?=base_url()?>application/views/js/jquery.js"></script>
    <script type="text/javascript" src="<?=base_url()?>application/views/js/jquery.sorted.js"></script>
    <script type="text/javascript" src="<?=base_url()?>application/views/js/bootstrap.js"></script>
    <script type="text/javascript" src="<?=base_url()?>application/views/js/ckform.js"></script>
    <script type="text/javascript" src="<?=base_url()?>application/views/js/common.js"></script>

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
<form class="form-inline definewidth m20" action="<?=base_url('home/index/cl_moneyback')?>" method="post">  
    回款月份（默认当前月）：
    <input type="text" name="month" id="rolename" class="abc input-default" placeholder="" value="">&nbsp;&nbsp;  
    <button type="submit" class="btn btn-primary">查询</button>&nbsp;&nbsp; 
    <a href="__URL__/cl_to_excel" class="btn btn-success" id="addnew">下载</a> 
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
   <?php 
   foreach($data as $key => $value):
    ?>
	<tr>
        <td><?=$value['borrow_id']?></td>
        <td><?=$value['borrow_uid']?></td>
        <td><?=$value['real_name']?></td>
        <td><?=$value['interest']?></td>
        <td><?=$value['capital']?></td>
        <td><?=$value['interest_fee']?></td>
        <td><?=$value['status']?></td>
        <td><font color='red'><?=date('Y-m-d',$value['deadline'])?></font></td>
        <td><?=$value['expired_money']?></td>
        <td><?=$value['interest']+$value['capital']-$value['interest_fee']?></td>
        </tr>
    <?php 
            // endforeach;
       endforeach;
    ?>
    
    </table>
     <!-- 我的个人信息结束 -->
     <div class='table table-bordered table-hover definewidth m10' style='margin:0 auto;text-align:center;'>
     <!--       <php>
            for($i=1;$i<=$total;$i++)
            {   
                echo "<a href='__MODULE__/index/cl_moneyback?p=$i&month=$m'>"."第".$i.'页</a>&nbsp;&nbsp;';
            }
            
            $p=$p?$p:1;$total=$total?$total:1;

            echo "当前第<span style='color:red'>&nbsp;".$p.'&nbsp;</span>页'."共".$total."页";
           </php> -->
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