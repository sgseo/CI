<!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>application/views/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>application/views/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="<?=base_url()?>application/views/Css/style.css" />
    <script type="text/javascript" src="<?=base_url()?>application/views/Js/jquery.js">{$vo.}</script>
    <script type="text/javascript" src="<?=base_url()?>application/views/Js/jquery.sorted.js">{$vo.}</script>
    <script type="text/javascript" src="<?=base_url()?>application/views/Js/bootstrap.js">{$vo.}</script>
    <script type="text/javascript" src="<?=base_url()?>application/views/Js/ckform.js">{$vo.}</script>
    <script type="text/javascript" src="<?=base_url()?>application/views/Js/common.js">{$vo.}</script>

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
<form class="form-inline definewidth m20" action="<?=base_url('home/menu/index')?>" method="post">
    菜单名称：
    <input type="text" name="real_name" id="menuname" class="abc input-default" placeholder="" value="">&nbsp;&nbsp; 
    <button type="submit" class="btn btn-primary">查询</button>&nbsp;&nbsp; 
    <a class="btn btn-success" href="<?=base_url('home/menu/area_import')?>">下载</a>
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
    <?php
    foreach($result as $vo):
    ?>
	     <tr>
            <td><?=$vo['uid']?></td>
            <td><?=$vo['real_name']?></td>
            <td><?=$vo['age']?></td>
            <td><?=$vo['idcard']?></td>
            <td><?=$vo['cell_phone']?></td>
            <td><?=$vo['address']?></td>
            <td><?=$vo['reg_time']?></td>
        </tr>
     <?php
    endforeach;
     ?>
        </table>

        <div class='table table-bordered table-hover definewidth m10' style='margin:0 auto;text-align:center;'>
           <?php
            for($i=1;$i<=$total;$i++)
            {   
                echo "<a href=".base_url('home/menu/index?p='.$i).">"."第".$i.'页</a>&nbsp;&nbsp;';
            }
            
            $p=$p?$p:1;$total=$total?$total:1;

            echo "当前第<span style='color:red'>&nbsp;".$p.'&nbsp;</span>页'."共".$total."页";
           ?>
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