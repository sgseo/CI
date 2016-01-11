<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta charset="UTF-8">
    <link href="/Public/bootstrap-datetimepicker/css/bootstrap.min.css" rel="stylesheet" media="screen">
    <link href="/Public/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="/Public/Css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Css/style.css" />
     <script type="text/javascript" src="/Public/Js/jquery.js"></script>
    <script type="text/javascript" src="/Public/Js/amounttochinese.js"></script>
   <link rel="stylesheet" type="text/css" href="/Public/webuploader015/webuploader.css">
<!--引入JS-->
    <script type="text/javascript" src="/Public/webuploader015/webuploader.js"></script>
   <!-- 时间插件 -->
    <script type="text/javascript" src="/Public/bootstrap-datetimepicker/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/Public/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/Public/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8">
    </script>
    <!-- 时间插件结束 -->
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
  <ol class="breadcrumb">
  <li><a href="#">业务管理-></a></li>
   <li><a href="#">贷款还款-></a></li>
  <li class="active">还款</li>
</ol>
    <div class="table table-bordered table-hover definewidth m10" style='margin:auto auto'>
      <!-- 还款计划 -->
     <div class="form-inline definewidth m20" id='001'>还款计划 &there4;</div>
<table class="table table-bordered table-hover definewidth m10" >
    <thead>
    <tr>
     
        <th>标号</th>
        <th>计划日期</th>
        <th>计划还款(元)</th>
        <th>实际还款(元)</th>
        <th>实还时间</th>
        <th>当前期数</th>
        <th>还款方式</th>
        <th>财来操作人</th>
        <th>操作时间</th>
        <th>其他核对人</th>
        <th>核对时间</th>
        <th>还款凭证</th>
    </tr>
    </thead>
    <?php if(is_array($rplist)): $k = 0; $__LIST__ = $rplist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k; if($vo["cursort"] == 1): ?><tr><td colspan='13'>这是第<?php echo ($vo["nci"]); ?>次放款的计划</td></tr><?php endif; ?>
       <tr>
            <td><?php echo ($vo["cursort"]); ?></td>
            <td><?php echo ($vo["shouldtime"]); ?></td>
            <td><?php echo ($vo["shouldrepay"]); ?></td>
            <td><?php echo ($vo["realrepay"]); ?></td>
            <td><?php if(($vo["donetime"]) != "0000-00-00"): echo ($vo["donetime"]); endif; ?></td>
            <td><?php echo ($vo["cursort"]); ?></td>
            <td><?php
 if($vo['repaytype']==1) { echo "银行转账"; }else if($vo['repaytype']==2) { echo "现金还款"; }else if($vo['repaytype']==3){ echo "其他"; }else{ } ?></td>
            <td><?php echo ($vo["operator"]); ?></td>
            <td><?php if(($vo["operatetime"]) != "0000-00-00 00:00:00"): echo ($vo["operatetime"]); endif; ?></td>
            <td><?php echo ($vo["operator2"]); ?></td>
            <td><?php if(($vo["operator2time"]) != "0000-00-00 00:00:00"): echo ($vo["operator2time"]); endif; ?></td>
            <td><?php if(($vo["path"]) != ""): ?><img src="/Uploads/<?php echo ($vo["path"]); ?>" width='40em' height='30em' class='scale' title='点击图片进行放大'/><?php endif; ?></td>
        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </table>
     <!-- 我的个人信息结束 -->
     <div class='page' >
          <?php echo ($pager); ?>
    </div>
  </div>
  <!-- 计划结束 -->
    <div class="form-inline definewidth m20" id='001' style='color:red'>请一次操作一笔还款 &there4;</div>
<div class='every' style='width:100%;height:680px;margin:50px 0px;'>
    <?php
 for($i=1;$i<=$totaltimes;$i++){ ?>
     <?php if($list[$i][nci] != 0): ?><div style='float:left;width:350px;height:680px;margin-left:80px;'>
      <div>这是第<?php echo ($i); ?>次还款</div>
        <form  class="m10" action="/index.php/Home/User/save" method="post" enctype="multipart/form-data" >
        <!-- 基础文档模型 -->
            <div class="controls">
               借款编号&nbsp;<input type="text" class="text input-large" name="id" value="<?php echo ($list["$i"]["id"]); ?>"  readonly='readonly'></br>
               <input type="hidden" name='respid' value="<?php echo ($list["$i"]["respid"]); ?>">
               借款标题&nbsp;<input type="text" class="text input-large" name="title" value="<?php echo ($list["$i"]["title"]); ?>"  readonly='readonly'></br>
               客户姓名&nbsp;<input type="text" class="text input-large" name="cstname" value="<?php echo ($list["$i"]["cstname"]); ?>"  readonly='readonly'></br>
               身份证号&nbsp;<input type="text" class="text input-large" name="idno" value="<?php echo ($list["$i"]["idno"]); ?>"  readonly='readonly'></br>
               手机号码&nbsp;<input type="text" class="text input-large" name="tel" value="<?php echo ($list["$i"]["tel"]); ?>"  readonly='readonly'></br>
               贷款金额&nbsp;<input type="text" class="text input-large" name="borrowamt" value="<?php echo ($list["$i"]["borrowamt"]); ?>" readonly='readonly'></br>
               贷款期限&nbsp;<input type="text" class="text input-large" name="duration" value="<?php echo ($list["$i"]["duration"]); ?>" readonly='readonly'></br>
               贷款利率&nbsp;<input type="text" class="text input-large" name="rate" value="<?php echo ($list["$i"]["rate"]); ?>" readonly='readonly'></br>
               贷款抵押&nbsp;<input type="text" class="text input-large" name="category" value="<?php echo ($list["$i"]["category"]); ?>" readonly='readonly'></br>
               当前次数&nbsp;<input type="text" class="text input-large" name="nci" value="<?php echo ($list["$i"]["nci"]); ?>" readonly='readonly' ></br>
               当前期数&nbsp;<input type="text" class="text input-large" name="cursort" value="<?php echo ($list["$i"]["cursort"]); ?>" readonly='readonly' ></br>
               应还金额&nbsp;<input type="text" class="text input-large" name="shouldrepay" value="<?php echo ($list["$i"]["shouldrepay"]); ?>" readonly='readonly'>（元）</br>
               已还金额&nbsp;<input type='text' class='text input-large'  value='<?php echo ($list["$i"]["realrepay"]); ?>' readonly='readonly'/>（元）</br>
               应还日期&nbsp;<input type="text" class="text input-large time" name="shouldtime" value="<?php echo ($list["$i"]["shouldtime"]); ?>" readonly='readonly'></br>
               实还金额&nbsp;<input type="text" class="text input-large" name="realrepay"  onblur="num2ch(this.value,this.name+<?php echo ($i); ?>)">（元）
               <span id='realrepay<?php echo ($i); ?>' style='color:red;display:none;'></span>
             </br>
               实还时间&nbsp;<input type="date" class="text input-large " name="donetime"  value="<?php echo ($time); ?>" ></br>
               还款方式&nbsp;<select class="text input-large time" name='repaytype'>
                 <option  value='1'>银行转账</option>
                 <option  value='2'>现金还款</option>
                 <option  value='3'>其他</option>
               </select>
             </br>
                 还款凭证&nbsp;<input type="file"  name='pic1'>
            </div>
              <p><button class="btn btn-large btn-primary btn btn-default" type="submit">确 定</button></p>
    </form>
</div><?php endif; ?>
      <?php
 } ?>
</div>
<!-- every eof -->
</body>
</html>
<script type="text/javascript">
function num2ch(v,i) {
  var testreuslt = true;
  if (testreuslt) {
    showChineseAmount(v,i);
  }
  return testreuslt;
}
function showChineseAmount(v,i) {
    // console.log(v,i);
  var regamount = /^(([1-9]{1}[0-9]{0,})|([0-9]{1,}\.[0-9]{1,2}))$/;
  var reg = new RegExp(regamount);
  if (reg.test(v)) 
  {
    var amstr = v;
    var leng = amstr.toString().split('.').length;
    if (leng == 1) {
      $("#"+v).val(v + ".00");
    }
    $("#"+i).text(Arabia_to_Chinese(amstr));
    $("#"+i).show();
    $("#"+i).css("color","red");
  }else
  {
    $("#"+i).show();
    $("#"+i).text("请输入纯数字");
  }
}

    
</script>
<!-- 图片上传 -->