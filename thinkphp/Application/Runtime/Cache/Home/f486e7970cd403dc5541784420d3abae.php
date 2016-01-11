<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title><?php echo ($vo[""]); ?></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/Public/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Css/style.css" />
    <script type="text/javascript" src="/Public/Js/jquery.js"><?php echo ($vo[""]); ?></script>
    <script type="text/javascript" src="/Public/Js/jquery.sorted.js"><?php echo ($vo[""]); ?></script>
    <script type="text/javascript" src="/Public/Js/bootstrap.js"><?php echo ($vo[""]); ?></script>
    <script type="text/javascript" src="/Public/Js/ckform.js"><?php echo ($vo[""]); ?></script>
    <script type="text/javascript" src="/Public/Js/common.js"><?php echo ($vo[""]); ?></script>

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
<form class="form-inline definewidth m20" action="/Home/Menu" method="get">
    姓名：
    <input type="text" name="real_name" class="abc input-default" placeholder="" value="">&nbsp;&nbsp; 
    <button type="submit" class="btn btn-primary">查询</button>&nbsp;&nbsp; 
    <a class="btn btn-success" href="/Home/Menu/cl_to_excel">下载</a>
</form>
<table class="table table-bordered table-hover definewidth m10">
    <thead>
    <tr>
        <th>用户id</th>
        <th>姓名</th>
        <th>年龄</th>
        <th>身份证号</th>
        <th>手机号</th>
        <th>地址</th>
        <th>注册时间</th>
    </tr>
    </thead>
    <?php if(is_array($result)): $i = 0; $__LIST__ = array_slice($result,$cls,$spc,true);if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($vo["uid"]); ?></td>
            <td><?php echo ($vo["real_name"]); ?></td>
            <td><?php echo ($vo["age"]); ?></td>
            <td><?php echo ($vo["idcard"]); ?></td>
            <td><?php echo ($vo["cell_phone"]); ?></td>
            <td><?php echo ($vo["address"]); ?></td>
            <td><?php echo (date('Y-m-d',$vo["reg_time"])); ?></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>

        <div class='table table-bordered table-hover definewidth m10' style='margin:0 auto;text-align:center;'>
           <?php for($i=1;$i<=$total;$i++) { echo "<a href='/Home/menu/index?p=$i'>"."第".$i.'页</a>&nbsp;&nbsp;'; } $p=$p?$p:1;$total=$total?$total:1; echo "当前第<span style='color:red'>&nbsp;".$p.'&nbsp;</span>页'."共".$total."页"; ?>
    </div>

</body>
</html>
<script>
    $(function () {
        

		$('#addnew').click(function(){

				window.location.href="add.html";
		 });


    });
	
</script>