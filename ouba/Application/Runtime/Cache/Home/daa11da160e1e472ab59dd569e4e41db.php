<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <title></title>
    <meta name="viewport" id="viewport" content="width=device-width, initial-scale=1"/> 
    <meta charset="UTF-8">
    <link rel="stylesheet" type="text/css" href="/Public/Css/bootstrap.css" />
    <link id="skin" rel="stylesheet" href="/Public/Images/Pink/jbox.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Css/bootstrap-responsive.css" />
    <link rel="stylesheet" type="text/css" href="/Public/Css/style.css" />
    <link rel="stylesheet" type="text/css" href="/Public/webuploader015/webuploader.css">
    <link rel="stylesheet" type="text/css" href="/Public/Css/index.css" />
    <!-- <link href="/Public/bootstrap-datetimepicker/css/bootstrap.min.css" rel="stylesheet" media="screen"> -->
    <link rel="stylesheet" href="//cdn.bootcss.com/bootstrap/3.3.5/css/bootstrap-theme.min.css"/>
    <link href="/Public/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css" rel="stylesheet" media="screen">
    <link rel="stylesheet" type="text/css" href="/Public/Css/index.css" />
    <script type="text/javascript" src="/Public/Js/jquery.js"></script>
    <script type="text/javascript" src="/Public/Js/bootstrap.js"></script>
    <script type="text/javascript" src="/Public/Js/ckform.js"></script>
    <script type="text/javascript" src="/Public/Js/common.js"></script>
    <script type="text/javascript" src="/Public/Js/amounttochinese.js"></script>
    <script type="text/javascript" src="/Public/webuploader015/webuploader.js"></script>
   <!-- 时间插件 -->
    <script type="text/javascript" src="/Public/bootstrap-datetimepicker/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/Public/bootstrap-datetimepicker/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/Public/bootstrap-datetimepicker/js/locales/bootstrap-datetimepicker.fr.js" charset="UTF-8"></script>
    <script type="text/javascript" src="/Public/Js/js/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="/Public/Js/js/jquery.jBox.src.js"></script>

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
    <script type="text/javascript">
        /* jBox 全局设置 */
        var _jBoxConfig = {};
        _jBoxConfig.defaults = {
            id: null, /* 在页面中的唯一ID，如果为null则自动为随机ID,一个ID只会显示一个jBox */
            top: '15%', /* 窗口离顶部的距离,可以是百分比或像素(如 '100px') */
            border: 5, /* 窗口的外边框像素大小,必须是0以上的整数 */
            opacity: 0.2, /* 窗口隔离层的透明度,如果设置为0,则不显示隔离层 */
            timeout: 0, /* 窗口显示多少毫秒后自动关闭,如果设置为0,则不自动关闭 */
            showType: 'fade', /* 窗口显示的类型,可选值有:show、fade、slide */
            showSpeed: 'fast', /* 窗口显示的速度,可选值有:'slow'、'fast'、表示毫秒的整数 */
            showIcon: true, /* 是否显示窗口标题的图标，true显示，false不显示，或自定义的CSS样式类名（以为图标为背景） */
            showClose: true, /* 是否显示窗口右上角的关闭按钮 */
            draggable: true, /* 是否可以拖动窗口 */
            dragLimit: true, /* 在可以拖动窗口的情况下，是否限制在可视范围 */
            dragClone: false, /* 在可以拖动窗口的情况下，鼠标按下时窗口是否克隆窗口 */
            persistent: true, /* 在显示隔离层的情况下，点击隔离层时，是否坚持窗口不关闭 */
            showScrolling: true, /* 是否显示浏览的滚动条 */
            ajaxData: {},  /* 在窗口内容使用post:前缀标识的情况下，ajax post的数据，例如：{ id: 1 } 或 "id=1" */
            iframeScrolling: 'auto', /* 在窗口内容使用iframe:前缀标识的情况下，iframe的scrolling属性值，可选值有：'auto'、'yes'、'no' */

            title: 'jBox', /* 窗口的标题 */
            width: 350, /* 窗口的宽度，值为'auto'或表示像素的整数 */
            height: 'auto', /* 窗口的高度，值为'auto'或表示像素的整数 */
            bottomText: '', /* 窗口的按钮左边的内容，当没有按钮时此设置无效 */
            buttons: { '确定': 'ok' }, /* 窗口的按钮 */
            buttonsFocus: 0, /* 表示第几个按钮为默认按钮，索引从0开始 */
            loaded: function (h) { }, /* 窗口加载完成后执行的函数，需要注意的是，如果是ajax或iframe也是要等加载完http请求才算窗口加载完成，参数h表示窗口内容的jQuery对象 */
            submit: function (v, h, f) { return true; }, /* 点击窗口按钮后的回调函数，返回true时表示关闭窗口，参数有三个，v表示所点的按钮的返回值，h表示窗口内容的jQuery对象，f表示窗口内容里的form表单键值 */
            closed: function () { } /* 窗口关闭后执行的函数 */
        };
        _jBoxConfig.stateDefaults = {
            content: '', /* 状态的内容，不支持前缀标识 */
            buttons: { '确定': 'ok' }, /* 状态的按钮 */
            buttonsFocus: 0, /* 表示第几个按钮为默认按钮，索引从0开始 */
            submit: function (v, h, f) { return true; } /* 点击状态按钮后的回调函数，返回true时表示关闭窗口，参数有三个，v表示所点的按钮的返回值，h表示窗口内容的jQuery对象，f表示窗口内容里的form表单键值 */
        };
        _jBoxConfig.tipDefaults = {
            content: '', /* 提示的内容，不支持前缀标识 */
            icon: 'info', /* 提示的图标，可选值有'info'、'success'、'warning'、'error' */
            top: '40%', /* 提示离顶部的距离,可以是百分比或像素(如 '100px') */
            width: 'auto', /* 提示的高度，值为'auto'或表示像素的整数 */
            height: 'auto', /* 提示的高度，值为'auto'或表示像素的整数 */
            opacity: 0, /* 窗口隔离层的透明度,如果设置为0,则不显示隔离层 */
            timeout: 5000, /* 提示显示多少毫秒后自动关闭,必须是大于0的整数 */
            closed: function () { } /* 提示关闭后执行的函数 */
        };
        _jBoxConfig.messagerDefaults = {
            content: '', /* 信息的内容，不支持前缀标识 */
            title: 'jBox', /* 信息的标题 */
            icon: 'none', /* 信息图标，值为'none'时为不显示图标，可选值有'none'、'info'、'question'、'success'、'warning'、'error' */
            width: 350, /* 信息的高度，值为'auto'或表示像素的整数 */
            height: 'auto', /* 信息的高度，值为'auto'或表示像素的整数 */
            timeout: 3000, /* 信息显示多少毫秒后自动关闭,如果设置为0,则不自动关闭 */
            showType: 'slide', /* 信息显示的类型,可选值有:show、fade、slide */
            showSpeed: 600, /* 信息显示的速度,可选值有:'slow'、'fast'、表示毫秒的整数 */
            border: 0, /* 信息的外边框像素大小,必须是0以上的整数 */
            buttons: {}, /* 信息的按钮 */
            buttonsFocus: 0, /* 表示第几个按钮为默认按钮，索引从0开始 */
            loaded: function (h) { }, /* 窗口加载完成后执行的函数，参数h表示窗口内容的jQuery对象 */
            submit: function (v, h, f) { return true; }, /* 点击信息按钮后的回调函数，返回true时表示关闭窗口，参数有三个，v表示所点的按钮的返回值，h表示窗口内容的jQuery对象，f表示窗口内容里的form表单键值 */
            closed: function () { } /* 信息关闭后执行的函数 */
        };
        _jBoxConfig.languageDefaults = {
            close: '关闭', /* 窗口右上角关闭按钮提示 */
            ok: '确定', /* $.jBox.prompt() 系列方法的“确定”按钮文字 */
            yes: '是', /* $.jBox.warning() 方法的“是”按钮文字 */
            no: '否', /* $.jBox.warning() 方法的“否”按钮文字 */
            cancel: '取消' /* $.jBox.confirm() 和 $.jBox.warning() 方法的“取消”按钮文字 */
        };

        $.jBox.setDefaults(_jBoxConfig);
        var title='抵押信息';

        function demo08(id) {
             jBox.open("get:/index.php/Home/Node/impawn?id="+id, title, 300, 50, { buttons: { '关闭': true }, persistent: false });
        }

     function del(id)
        {
            // var html = "<div style='padding:10px;'>审批意见：<textarea  id='yourtip' name='yourtip'></textarea</div>";
             var html = '<div class="msg-div">' +
                        '<p></p><div class="field" style="margin:5px 5px;">&nbsp;&nbsp<textarea id="yourtip" name="yourtip"></textarea></div>' +
                        // '<div class="errorBlock" style="display: none;"></div>' +
                        '</div>';
            var submit = function (v, h, f) {
                if (f.yourtip == '') {
                    jBox.tip("请输入您的审批意见。", 'error', { focusId: "yourtip" }); // 关闭设置 yourname 为焦点
                    return false;
                }
                 $.ajax({
                             type: "POST",
                             url: "/index.php/Home/Node/admityj",
                             data: {id:id,f:f.yourtip,s:3},
                             dataType: "json",
                             success: function(data){
                                        if(data==1)
                                          { 
                                            location.href = '/index.php/Home/Node/admit?id='+id;
                                          }else{
                                            jBox.tip('操作失败.','failure');
                                           //alert(data);
                                          }
                                      }
                         });
                return true;
            };

            jBox(html,{showType:'slide',width:400,title: "审批意见",submit: submit, loaded: function (h) {
              }
            });
        }
</script>
<script type="text/javascript">
function num2ch(v,i) {

  var testreuslt = true;
  if (testreuslt) {
    showChineseAmount(v,i);
  }
  var newdou=formatNum(v);
  $('input[name='+i+']').val(newdou);
  var newv=$("#"+i).text();
  $('#upperprice').val(newv);
  return testreuslt;
}

function formatNum(str){
var newStr = "";
var count = 0;
 
if(str.indexOf(".")==-1){
   for(var i=str.length-1;i>=0;i--){
 if(count % 3 == 0 && count != 0){
   newStr = str.charAt(i) + "," + newStr;
 }else{
   newStr = str.charAt(i) + newStr;
 }
 count++;
   }
   str = newStr + ".00"; //自动补小数点后两位
   // console.log(str)
}
else
{
   for(var i = str.indexOf(".")-1;i>=0;i--){
 if(count % 3 == 0 && count != 0){
   newStr = str.charAt(i) + "," + newStr;
 }else{
   newStr = str.charAt(i) + newStr; //逐个字符相接起来
 }
 count++;
   }
   str = newStr + (str + "00").substr((str + "00").indexOf("."),3);
   // console.log(str)
 }
 return str;
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
<ol class="breadcrumb">
  <li class="active">标的详情</li>
</ol>
<style>
        .ims img{
          height: 220px;
          margin: 10px auto;
        }
</style>
<link rel="stylesheet" href="/Public/Css/click.css">
<script type="text/javascript" src="/Public/Js/jquery-1.11.0.min.js"></script>
<script type="text/javascript" src="/Public/Js/jquey-bigic.js"></script>
   <div class="form-inline definewidth m20">标的信息&nbsp;</div>
   <table class="table table-bordered table-hover definewidth m10" >
    <thead>
    <tr>
        <th>借款标号</th>
        <th>借款标题</th>
        <th>客户姓名</th>
        <th>身份证号码</th>
        <th>联系电话</th>
        <th>贷款金额(元)</th>
        <th>贷款期限(月)</th>
        <th>贷款利率（%）</th>
          <th>业务员</th>
        <th>客户来源</th>
       
        <th>资金来源</th>

        <th>贷款类型</th>
        <!-- <th>图片</th> -->
        <!-- 客户姓名，身份证号码，联系电话，贷款金额，期限，利率， -->
    </tr>
    </thead>
   
         <tr>
            <td><?php echo ($hlist["id"]); ?></td>
            <td><?php echo ($hlist["title"]); ?></td>
            <td><?php echo ($hlist["cstname"]); ?></td>
            <td><?php echo ($hlist["idno"]); ?></td>
            <td><?php echo ($hlist["tel"]); ?></td>
            <td><?php echo ($hlist["borrowamt"]); ?></td>
            <td><?php echo ($hlist["duration"]); ?></td>
            <td><?php echo ($hlist["rate"]); ?></td>
            <td><?php echo ($hlist["username"]); ?></td>
            <td><?php echo ($hlist["source"]); ?></td>
            <td><?php echo ($hlist["capitalsource"]); ?></td>

            <td>
           <?php if(($hlist["category"]) == "car"): ?>车抵押&nbsp;<input type="button" value="&nabla;" onclick="demo08(<?php echo ($hlist["id"]); ?>);" /><?php endif; ?>
           <?php if(($hlist["category"]) == "fang"): ?>房抵押&nbsp;<input type="button" value="&nabla;" onclick="demo08(<?php echo ($hlist["id"]); ?>);" /><?php endif; ?>
           </td>
            <!-- <td><a href='/index.php/Home/Node/showlog?id=<?php echo ($hlist["id"]); ?>'>查看日志</a></td> -->
        </tr>
    </volist>
    
    </table>

<!-- 抵押信息 -->
 <div class="form-inline definewidth m20">抵押信息 &nbsp;</div>
   <table class="table table-bordered table-hover definewidth m10" >
    <thead>
    <tr>
        <th>抵押类型</th>
        <?php if(($hlist["category"]) == "fang"): ?><th>房屋地址</th>
        <th>房屋面积（平米）</th>
        <th>房屋价格（元）</th>
        <th>房屋户口</th>
        <th>是否为主城区</th>
        <th>是否有租赁</th>
        <th>抵押情况</th>
        <th>评估价</th>
        <th>产权证号</th>
        <th>备用房地址</th>
        <th>备用房面积</th><?php endif; ?>
        <?php if(($hlist["category"]) == "car"): ?><th>车子品牌</th>
        <th>车子型号</th>
        <th>车辆价格（元）</th>
        <th>购买日期</th><?php endif; ?>
        <!-- <th>贷款类型</th> -->
        <!-- <th>图片</th> -->
        <!-- 客户姓名，身份证号码，联系电话，贷款金额，期限，利率， -->
    </tr>
    </thead>
   
         <tr>
            <?php if(($hlist["category"]) == "fang"): ?><td>房屋抵押</td>
            <td><?php echo ($hlist["address"]); ?></td>
            <td><?php echo ($hlist["area"]); ?></td>
            <td><?php echo ($hlist["price"]); ?></td>
            <td><?php echo ($hlist["residence"]); ?></td>
            <td>
                <?php if(($hlist["iscity"]) == "2"): ?>否<?php endif; ?>
                <?php if(($hlist["iscity"]) == "1"): ?>是<?php endif; ?>
            </td>
            <td>  <?php if(($hlist["isloan"]) == "2"): ?>是<?php endif; ?>
                <?php if(($hlist["isloan"]) == "1"): ?>否<?php endif; ?></td>
            <td>  <?php if(($hlist["pledge"]) == "1"): ?>清房<?php endif; ?>
                <?php if(($hlist["pledge"]) == "2"): ?>一抵<?php endif; ?>
                 <?php if(($hlist["pledge"]) == "3"): ?>按揭<?php endif; ?>
                   <?php if(($hlist["pledge"]) == "4"): ?>转单<?php endif; ?>
            </td>
            <td><?php echo ($hlist["estimateprice"]); ?></td>
            <td><?php echo ($hlist["pledgeno"]); ?></td>
            <td><?php echo ($hlist["anotheradd"]); ?></td>
            <td><?php echo ($hlist["anotherarea"]); ?></td><?php endif; ?>
            <?php if(($hlist["category"]) == "car"): ?><td>车抵押</td>
            <td><?php echo ($hlist["carbrand"]); ?></td>
            <td><?php echo ($hlist["cartype"]); ?></td>
            <td><?php echo ($hlist["carestimate"]); ?></td>
            <td><?php echo (date(Ymd,$hlist["carbuytime"])); ?></td><?php endif; ?>
        </tr>
    </volist>
    
    </table>

<!-- 图片上传 -->
    <!-- 图片展示区 -->
      <div class="form-inline definewidth m20">图片展示 &nbsp;</div>
    
    <!--          <div class="row">
                 <?php if(is_array($plist)): $k = 0; $__LIST__ = $plist;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><div class="col-xs-6 col-md-3">
                    <a href="#" class="thumbnail">
                       <?php if(($vo["file_type"]) != "2"): ?><img src="/Uploads/<?php echo ($vo["path"]); ?>" width='420px'  title='点击图片进行放大'/><?php endif; ?>
                    </a>
                  </div><?php endforeach; endif; else: echo "$empty" ;endif; ?>
                </div> -->

       <div class='pic_strap definewidth m10 table-bordered' style='border:1px solid #ccc;width:100%;height:<?php echo ($pheight); ?>px;'>
        <div class='nine' style='margin:0px auto;width:100%;height:100%;'>
        <?php if(is_array($plist)): $k = 0; $__LIST__ = $plist;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><div class='ims' style=' float:left;width:25%;height:300px;border:1px solid #999;margin:50px 3% 0px 3%;overflow:hidden'>
                <?php if(($vo["file_type"]) != "2"): ?><img src="/Uploads/<?php echo ($vo["path"]); ?>" width='420px' class='img-thumbnail img-circle' title='点击图片进行放大'/><?php endif; ?>
                <?php if(($vo["file_type"]) == "2"): ?><video src="/Uploads/<?php echo ($vo["path"]); ?>" controls="controls" >
                    您的浏览器不支持 video 标签。
                    </video><?php endif; ?>
         </div><?php endforeach; endif; else: echo "$empty" ;endif; ?>
      </div>
  </div>

     <!-- 我的个人信息结束 -->
     <div class='page'>
          <?php echo ($pager); ?>
    </div>
     <!-- 还款计划 -->
     <div class="form-inline definewidth m20" id='001'>还款计划 &nbsp;</div>
<table class="table table-bordered table-hover definewidth m10" >
    <thead>
    <tr>
     
        <th>标号</th>
        <th>计划日期</th>
        <th>计划还款(元)</th>
        <th>实际还款(元)</th>
        <th>实还时间</th>
        <th>当前次数</th>
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
       <tr style='border:<?php echo ($vo["nci"]); ?>px solid red;'>
            <td><?php echo ($vo["cursort"]); ?></td>
            <td><?php echo ($vo["shouldtime"]); ?></td>
            <td><?php echo ($vo["shouldrepay"]); ?></td>
            <td><?php echo ($vo["realrepay"]); ?></td>
            <td><?php if(($vo["donetime"]) != "0000-00-00"): echo ($vo["donetime"]); endif; ?></td>
            <td>第<?php echo ($vo["nci"]); ?>次放款</td>
            <td><?php echo ($vo["cursort"]); ?></td>
            <td><?php
 if($vo['repaytype']==1) { echo "银行转账"; }else if($vo['repaytype']==2) { echo "现金还款"; }else if($vo['repaytype']==3){ echo "其他"; }else{ } ?></td>
            <td><?php echo ($vo["operator"]); ?></td>
            <td><?php if(($vo["operatetime"]) != "0000-00-00 00:00:00"): echo ($vo["operatetime"]); endif; ?></td>
            <td><?php echo ($vo["operator2"]); ?></td>
            <td><?php if(($vo["operator2time"]) != "0000-00-00 00:00:00"): echo ($vo["operator2time"]); endif; ?></td>
            <td><?php if(($vo["path"]) != ""): ?><img src="/Uploads/<?php echo ($vo["path"]); ?>" width='170px' height='170px' class='scale' title='点击图片进行放大'/><?php endif; ?></td>
        </tr>
        <!--  <tr><td colspan='13'><?php if($vo["totalsort"] == $k): ?>这是第<?php echo ($k); ?>次放款的计划<?php endif; ?></td></tr> --><?php endforeach; endif; else: echo "" ;endif; ?>
    </table>
     <!-- 我的个人信息结束 -->
     <div class='page' >
          <?php echo ($pager); ?>
    </div>

    <!-- 行为列表 -->
    <div class="form-inline definewidth m20">行为列表 &nbsp;</div>
<table class="table table-bordered table-hover definewidth m10" >
    <thead>
    <tr>
     
        <th>操作标号</th>
        <th>操作标题</th>
        <th>操作者</th>
        <th>操作ip</th>
        <th>操作时间</th>
        <!-- <th>行为备注</th> -->
         <th>所在表id</th>
       
        <!-- 客户姓名，身份证号码，联系电话，贷款金额，期限，利率， -->
    </tr>
    </thead>
    <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "$empty" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
            <td><?php echo ($vo["id"]); ?></td>
            <td><?php echo ($vo["optip"]); ?>,<?php if(($vo["oprespid"]) != "0"): ?>负责人姓名：<?php echo ($vo["username"]); ?>。<?php endif; ?>标题为：<?php echo ($vo["title"]); ?>。</td>
            <td><?php echo ($vo["opname"]); ?></td>
            <td><?php echo (long2ip($vo["opip"])); ?></td>
            <td><?php echo (date('Y-m-d H:i:s',$vo["optime"])); ?></td>
            <!-- <td><?php echo ($vo["optip"]); ?></td> -->
            <!-- <td><?php echo ($vo["optbname"]); ?></td> -->
            <td><?php echo ($vo["opthatid"]); ?></td>
           
        </tr><?php endforeach; endif; else: echo "$empty" ;endif; ?>
    
    </table>
     <!-- 我的个人信息结束 -->
     <div class='page' >
          <?php echo ($page); ?>
    </div>

</body>
</html>
<script type="text/javascript">
  $(function(){
        $('img').bigic();
    });
</script>
<style type="text/css">
    img{
        vertical-align: bottom;
    }
</style>