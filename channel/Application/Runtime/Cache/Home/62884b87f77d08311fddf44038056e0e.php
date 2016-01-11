<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/channel/Public/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="/channel/Public/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="/channel/Public/Css/style.css" />
    <script type="text/javascript" src="/channel/Public/Js/jquery.js"></script>
    <script type="text/javascript" src="/channel/Public/Js/jquery.sorted.js"></script>
    <script type="text/javascript" src="/channel/Public/Js/bootstrap.js"></script>
    <script type="text/javascript" src="/channel/Public/Js/ckform.js"></script>
    <script type="text/javascript" src="/channel/Public/Js/common.js"></script>

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
<script type='text/javascript'>
    function send(phone)
    {
            //var txt = "#txtTelephone";
            var tc = $("#content").val();
            var pat = new RegExp(/^1[3|4|5|7|8][0-9]\d{8}$/);
            var str = phone;
            if(pat.test(str))
            {
               $.ajax({
                    type: "post",
                    url: "/channel/Home/Role/sendsms",
                    dataType: "json",
                    data: {"mobile":str,"content":tc},    //zhangwei
                    beforeSend:function(){
                        $('#sendSMS').html('短信发送中…');
                    },
                    timeout: 3000,
                    success: function(data) {
                        if(data.status== 'ok') {
                           $('#sendSMS').html('发送短信成功');
                           // 处理180秒后重发
                            var i = 0;
                            countTime = setInterval(function(){
                                var tt = 180 - i;
                               $('#sendSMS').html('('+tt+')'+'秒后重新发送');
                               //$('#sendSMS').html('('+tt+')'+'秒后重新发送');
                                if(i == 180) {
                                    clearInterval(countTime);
                                    $('#sendSMS').html('发送短信验证码');
                                }
                                i++;

                            }, 1000);
                        }else if(data.status=='no')
                        {
                             $('#sendSMS').html('发送短信失败');
                        }
                    }
                });
            }
    }
    
</script>

</head>
<body>
<!-- <form class="form-inline definewidth m20" action="/channel/Home/Role/remember?userId=123487&real_name=%E8%8C%83%E4%BB%A5%E5%BD%A4&phone=13300000001" method="post">  
    我推荐的人员列表&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    推荐者手机：
    <input type="text" name="mobile" id="rolename" class="abc input-default" placeholder="" value="">&nbsp;&nbsp;  
    <button type="submit" class="btn btn-primary">查询</button>&nbsp;&nbsp; 
  <button type="button" class="btn btn-success" id="addnew">新增角色</button>
</form> -->
<div class="form-inline definewidth m20"><font color='red'><?php echo ($real_name); ?></font> 的资金状况：</div>
<table class="table table-bordered table-hover definewidth m10" >
    <thead>
        <tr>
        <th>帐户余额</th>
        <th>待收利息</th>
        <th>待收总额</th>
        <th>已收利息</th>
        <th>冻结金额</th>
        <th>总资产额</th>
        <?php if(($auth) != ""): ?><th>发送的内容</th>
        <th>发送短信提醒</th><?php endif; ?>
        </tr>
    </thead>
         <tr>
            <td><?php echo ($reclist["account_money"]); ?></td>
            <td><?php echo ($reclist["wait_interest"]); ?></td>
            <td><?php echo ($reclist["money_collect"]); ?></td>
            <td><?php echo ($reclist["back_money"]); ?></td>
            <td><?php echo ($reclist["money_freeze"]); ?></td>
            <td><?php echo ($reclist["all_money"]); ?></td>
            <?php if(($auth) != ""): ?><td><textarea id='content' rows='1' cols='1' placeholder='请编辑提醒内容'><?php echo ($auth); ?></textarea></td>
            <td><button type="button" class="btn btn-success" id='sendSMS' onclick="send(<?php echo ($phone); ?>)">提醒</button></td><?php endif; ?>
        </tr>
        <!-- <tr><td colspan='6'> 对我的总贡献:<font color='red'><?php $single_bonus=$single_bonus?$single_bonus:$total_bonus;echo $single_bonus; ?></font>元</td></tr>
   -->
    </table>
    <div class='table table-bordered table-hover definewidth m10' style='margin:0 auto;text-align:center;'>
           <?php for($i=1;$i<=$total;$i++) { echo "<a href='/channel/Home/Role/remember?userId=$condi&real_name=$real_name&p=$i'>"."第".$i.'页</a>&nbsp;&nbsp;'; } $p=$p?$p:1;$total=$total?$total:1; echo "当前第<span style='color:red'>&nbsp;".$p.'&nbsp;</span>页'."共".$total."页"; ?>
    </div>
		</body>
		</html>