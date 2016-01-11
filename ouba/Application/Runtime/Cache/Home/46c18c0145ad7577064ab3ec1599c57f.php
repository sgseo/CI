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
             jBox.open("get:/index.php/Home/Menu/impawn?id="+id, title, 300, 50, { buttons: { '关闭': true }, persistent: false });
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
                             url: "/index.php/Home/Menu/admityj",
                             data: {id:id,f:f.yourtip,s:3},
                             dataType: "json",
                             success: function(data){
                                        if(data==1)
                                          { 
                                            location.href = '/index.php/Home/Menu/admit?id='+id;
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
<style type="text/css">
        body {
            padding-bottom: 40px;
        }
        .sidebar-nav {
            padding: 9px 0;
        }

</style>
</head>
<body>
  <ol class="breadcrumb">
  <li><a href="#">业务管理-></a></li>
  <li class="active">项目审批</li>
  <!-- <li >十一月</li> -->
</ol>
<div style='margin:10px auto' >
<!-- 项目录入 -->
<form  class="table table-hover definewidth m10" style="padding-top:20px;" action="/index.php/Home/Menu/admit" method="post" enctype="multipart/form-data" >
<!-- 基础文档模型 -->
<div class="sidebar-frame">  
<div class='title_p'><span>借款核心信息</span></div> 
<!-- 金额利率类型期限标题借款人 -->
<div class='every_p'>
<span>借款标题:</span>
<input type="hidden" name='id' value="<?php echo ($returndata["id"]); ?>">
<input type="text"  name="title" value="<?php echo ($returndata["title"]); ?>"  required='required'>
</div>
<div class='every_p'>
<span>贷款金额 (元): </span>
<input type="text" class="width_338"  name="borrowamt" data-ideny='num2ch' value="<?php echo ($returndata["borrowamt"]); ?>" onblur='num2ch(this.value,this.name)'>
<div class="clear"></div>
<span id='borrowamt' style='color:red; text-align:center; line-height:15px;'></span>
</div>
<div class='every_p'>
<span>贷款期限 (月): </span>
<input type="text"  name="duration" value="<?php echo ($returndata["duration"]); ?>" >
</div>
<div class='every_p'>
<span>贷款利率 (0.8%-2%之间): </span>
<input type="text" class="width"  name="rate" value="<?php echo ($returndata["rate"]); ?>"  onblur="number(this.value,this.name)" >
<span id='rate' style='display:none;color:red'></span>
</div>

<span class="pledge_p"><div class='every_p'>
<span>请选择借款用途: </span>
<select name="loandest" >
<option value="0">请选择</option>
<?php if(is_array($pllist2)): $i = 0; $__LIST__ = $pllist2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["sort"]); ?>" <?php if(($returndata["loandest"]) == $vo["sort"]): ?>selected='selected'<?php endif; ?>><?php echo ($vo["condition"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>
</div></span>

<div class='every_p'>
<div class='son_p'>
<p><input type="radio" value="fang" name="category" id='fang' <?php if(($returndata["category"]) == "fang"): ?>checked="checked"<?php endif; ?>/><span>房屋抵押</span></p>
<p><input type="radio" value="car" name="category" id='car' <?php if(($returndata["category"]) == "car"): ?>checked="checked"<?php endif; ?>><span>车辆抵押</span></p>
</div>
</div> <!---->
</div>      

<!-- 借款人信息 -->
<div class="clear"></div>
<div class="sidebar-frame">             
<div class='title_p'><span>借款人信息</span></div> 
<!-- name age work tel huji wed -->
<div class='every_p'>
<span>借款人姓名: </span>
<input type="text" class="width_353"  name="cstname" value="<?php echo ($returndata["cstname"]); ?>" >
</div>
<div class='every_p'>
<span>身份证号: </span>
<input type="text"  name="idno" value="<?php echo ($returndata["idno"]); ?>"  maxlength='40'>
</div>
<div class='every_p'>
<span>借款人户籍: </span>
<input type="text" class="width_380"  name="domicile" value="<?php echo ($returndata["domicile"]); ?>"  maxlength='66'>
</div>
<div class='every_p'>
<span>借款人年龄: </span>
<input type="text" class="width_353"  name="age" value="<?php echo ($returndata["age"]); ?>"  maxlength='66'>
</div>
<div class='every_p'>
<span>手机号码: </span>
<input type="text"  name="tel" value="<?php echo ($returndata["tel"]); ?>"  maxlength='66'>
</div>
<div class='every_p'>
<span>借款人职业: </span>
<input type="text" class="width_380" name="work" value="<?php echo ($returndata["work"]); ?>"  maxlength='66'>
</div>
<div class='every_p'>
<span>借款人行业: </span>
<input type="text" class="width_380" name="work" value="<?php echo ($returndata["hang"]); ?>"  maxlength='66'>
</div>
<div class='every_p'>
<span>借款人单位: </span>
<input type="text" class="width_380" name="work" value="<?php echo ($returndata["workadd"]); ?>"  maxlength='66'>
</div>
<!--  
<input type="date"  name="loanstart" value="<?php echo ($returndata[""]); ?>"<span>"贷款开始日期">
-->
<div class='every_p'>
<div class='son_p'> 
<span style="margin-left:10px;">婚姻状况: </span>
<p><input  type="radio" value="1" name="wed" <?php if(($returndata["wed"]) == "1"): ?>checked="checked"<?php endif; ?>/>未婚</p>
<p><input  type="radio"  name="wed" value='2' <?php if(($returndata["wed"]) == "2"): ?>checked="checked"<?php endif; ?>/>已婚</p>
<p><input  type="radio"  name="wed" value='3' <?php if(($returndata["wed"]) == "3"): ?>checked="checked"<?php endif; ?>/>离异</p>
</div>
</div>
</div>  
<!-- 借款人信息 -->


<!-- 抵押物信息 -->
<div class="clear"></div>
<div class="sidebar-frame"> 
<div class='title_p'><span>抵押物信息</span></div>
<!-- 房子抵押 -->
<span id='house' >
<div class="every_p">
<span>房屋地址:</span>
<input type="text"  name="address" value="<?php echo ($returndata["address"]); ?>" >
</div>

<div class="every_p">
<span>房地产权证号:</span>
<input type="text" class="width_363"  name="pledgeno" value="<?php echo ($returndata["pledgeno"]); ?>">
</div>
<div class="every_p">
<span>房地产权人:</span>
<input type="text" class="width_363"  name="pledgepri" value="<?php echo ($returndata["pledgepri"]); ?>">
</div>
<div class="every_p">
<span>房屋面积(平方米):</span>
<input type="text" class="width_321"  name="area" value="<?php echo ($returndata["area"]); ?>" >
</div>
<div class="every_p">
<span>房龄(年):</span>
<input type="text" class="width_321"  name="houseage" value="<?php echo ($returndata["houseage"]); ?>" >
</div>

<span class="pledge_ps">
<div class="every_p">
<span>房屋类型:</span>
<select name="housetype"  required>
<option value="0">请选择</option>
<?php if(is_array($htlist)): $i = 0; $__LIST__ = $htlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["sort"]); ?>" <?php if(($returndata["housetype"]) == $vo["sort"]): ?>selected='selected'<?php endif; ?>><?php echo ($vo["housetype"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>
</div>
</span>

<div class='every_p'>
<span>市场价(元):</span>
<input type="text" class="width_333"  name="price" value="<?php echo ($returndata["price"]); ?>" onblur='num2ch(this.value,this.name)'>
<span id='price' style='display:none;color:red;'></span>
</div>
<div class="every_p">
<span>评估价(元):</span>
<input type="text" class="width_356"  name="estimateprice" value="<?php echo ($returndata["estimateprice"]); ?>"  onblur='num2ch(this.value,this.name)'>
<span id='estimateprice' style='display:none;color:red'></span>
</div>


<div class="every_p">
<div class='son_p'>
<p><input  type="radio" value="1" name="iscity"  <?php if(($returndata["iscity"]) == "1"): ?>checked=checked<?php endif; ?>/>内环</p>
<p><input  type="radio"  name="iscity" value='2' <?php if(($returndata["iscity"]) == "2"): ?>checked=checked<?php endif; ?>/>外环</p>
<p><input  type="radio" value="2" name="isloan" <?php if(($returndata["isloan"]) == "2"): ?>checked=checked<?php endif; ?>/>有租赁</p>
<p><input  type="radio"  name="isloan" value='1'  <?php if(($returndata["isloan"]) == "1"): ?>checked=checked<?php endif; ?> />无租赁</p>
</div>
</div>

<div class="every_p">
<span>产调情况:</span>
<input type="text"  name="residence" value="<?php echo ($returndata["chandiao"]); ?>" >
</div>

<div class="every_p">
<span>房屋户口:</span>
<input type="text"  name="residence" value="<?php echo ($returndata["residence"]); ?>" >
</div>

<div class="every_p">
<span>抵押金额:</span>
<input type="text"  name="residence" value="<?php echo ($returndata["pledgemoney"]); ?>" >
</div>

<div class="every_p">
<span>抵押成数:</span>
<input type="text"  name="residence" value="<?php echo ($returndata["pledgepercent"]); ?>" >
</div>

<span class="pledge_p">
<div class="every_p">
<span>请选择抵押情况</span>
<select name="pledge">
<option value='0'>请选择</option>
<?php if(is_array($pllist)): $i = 0; $__LIST__ = $pllist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["sort"]); ?>" <?php if(($returndata["pledge"]) == $vo["sort"]): ?>selected='selected'<?php endif; ?>><?php echo ($vo["condition"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>
</div>
</span>


<div class="clear"></div>

<input type="hidden" name='upperprice' value="<?php echo ($returndata["upperprice"]); ?>" id='upperprice'/>

<div class="every_p">
<span>备用房地址:</span>
<input type="text" class="width_353"  name="anotheradd" value="<?php echo ($returndata["anotheradd"]); ?>">
</div>
<div class="every_p">
<span>备用房面积:</span>
<input type="text" class="width_380"  name="anotherarea" value="<?php echo ($returndata["anotherarea"]); ?>">
</div>
<div class="every_p">
<span>产权证号:</span>
<input type="text" class="width_380"  name="anotheridno" value="<?php echo ($returndata["anotheridno"]); ?>">
</div>
<div class="every_p">
<span>市场价:</span>
<input type="text" class="width_380"  name="anotherprice" value="<?php echo ($returndata["anotherprice"]); ?>">
</div>
<div class="every_p">
<span>产调情况:</span>
<input type="text" class="width_380"  name="anotherchandiao" value="<?php echo ($returndata["anotherchandiao"]); ?>">
</div>
<div class="every_p">
<span>抵押金额:</span>
<input type="text" class="width_380"  name="anotherpledgemoney" value="<?php echo ($returndata["anotherpledgemoney"]); ?>">
</div>
</span>
<!-- 房子抵押 -->
<!-- 车子抵押 -->
<span id='ca' style="display:none">
<div class='every_p'>
<span>车子品牌:</span>
<input type="text"  name="carbrand" value="<?php echo ($returndata["carbrand"]); ?>" >
</div>
<div class='every_p'>
<span>车子型号:</span>
<input type="text"  name="cartype" value="<?php echo ($returndata["cartype"]); ?>" >
</div>
<div class='every_p'>
<span>车子估价(元):</span>
<input type="text"  name="carestimate" value="<?php echo ($returndata["carestimate"]); ?>"  onblur='num2ch(this.value,this.name)'>
<span id='carestimate' style='display:none;color:red'></span>
</div>
<div class='every_p'>
<span>请选择车辆购买日期:</span>
<input type="date"  name='carbuytime'  value='<?php echo ($returndata["carbuytime"]); ?>'/>
</div>
</span>
<!-- 车子抵押 -->
</div>
<!-- 抵押物信息结束 -->
 
 <!-- 借款人账户信息 -->
<div class="clear"></div>
<div class="sidebar-frame">  
<div class='title_p'><span>银行卡信息：收款银行卡</span></div>
<div class='every_p'>
<span>开户名: </span>
<input type="text" class="width_378"  name="bankname" value="<?php echo ($returndata["bankname"]); ?>" maxlength='66'>
</div>
<div class='every_p'>
<span>开户行: </span>
<input type="text" class="width_378"  name="bank" value="<?php echo ($returndata["bank"]); ?>" maxlength='66'>
</div>
<div class='every_p'>
<span>账号: </span>
<input type="text"  name="bankcard" value="<?php echo ($returndata["bankcard"]); ?>"  maxlength='66'>
</div>
</div>    
<!-- 借款人账户信息 -->

<div class="sidebar-frame"> 
  <div class='title_p'><span>尽职调查信息</span></div> 
  <div class='every_p'>
  <span>还款来源:</span>
  <input type="text" value='<?php echo ($returndata["repaysource"]); ?>' name='repaysource'  />
  </div>
  <div class='every_p'>
  <span>征信逾期次数:</span>
  <input type="text" value='<?php echo ($returndata["credit"]); ?>' name='credit'  />
  </div>
   <div class='every_p'>
  <span>流水余额:</span>
  <input type="text" value='<?php echo ($returndata["watermoney"]); ?>' name='watermoney'  />
  </div>
<div class="every_p">
  <span>负债情况:</span>
<div class='son_p'>
<p><input type="radio" name="debt" value="1" <?php if(($returndata["debt"]) == "1"): ?>checked=checked<?php endif; ?>/>抵押负债</p>
<p><input type="radio" name="debt" value="2" <?php if(($returndata["debt"]) == "2"): ?>checked=checked<?php endif; ?>/>无抵押负债</p>     
</div>
</div> 
   <div class='every_p'>
  <span>资产情况:</span>
  <input type="text" value='<?php echo ($returndata["capitalcon"]); ?>' name='capitalcon'  />
  </div>
   <div class='every_p'>
  <span>房产照片:</span>
  <input type="text" value='<?php echo ($returndata["credit"]); ?>' name=''  />
  </div>
    <div class='every_p'>
  <span>营业执照:</span>
  <input type="text" value='<?php echo ($returndata["credit"]); ?>' name=''  />
  </div>
    <div class='every_p'>
  <span>开户许可证:</span>
  <input type="text" value='<?php echo ($returndata["credit"]); ?>' name=''  />
  </div>
    <div class='every_p'>
  <span>行驶证:</span>
  <input type="text" value='<?php echo ($returndata["credit"]); ?>' name=''  />
  </div>
    <div class='every_p'>
  <span>涉法涉诉:</span>
  <input type="text" value='<?php echo ($returndata["law"]); ?>' name='law'  />
  </div>
    <div class='every_p'>
  <span>担保人姓名:</span>
  <input type="text" value='<?php echo ($returndata["dbname"]); ?>' name='dbname'  />
  </div>

   <div class='every_p'>
  <span>身份证号:</span>
  <input type="text" value='<?php echo ($returndata["dbidno"]); ?>' name='dbidno'  />
  </div>

</div>     
    <!-- 业务信息 -->
<div class="clear"></div>
<div class="sidebar-frame"> 
<div class='title_p'><span>业务信息</span></div>
<span class="pledge_p">
<div class='every_p'>
<span>业务来源: </span>
<select name="source">
<option value='0'>请选择</option>
<?php if(is_array($list)): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><option value="<?php echo ($vo["id"]); ?>" <?php if(($returndata["source"]) == $vo["id"]): ?>selected='selected'<?php endif; ?>><?php echo ($vo["organization"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>
</div>
</span>

<div class="clear"></div>
<span class="pledge_p1">
<div class='every_p'>
<span>请选择业务员: </span>
<select name="salesman">
<option value='0'>请选择</option>
<?php if(is_array($plist)): $i = 0; $__LIST__ = $plist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if(($returndata["salesman"]) == $vo["id"]): ?>selected='selected'<?php endif; ?>><?php echo ($vo["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>
</div>
</span>
</div>
<!-- 风控意见 -->

<div class="clear"></div>
<div class="sidebar-frame"> 
<div class='title_p'><span>风控初审意见</span></div>
 <div class='every_p'>
  <span>风控人:</span>
  <input type="text" value='<?php echo ($returndata["username"]); ?>'   />
  <input type="hidden" value='<?php echo ($returndata["riskearly"]); ?>' name='riskearly'  />
  </div>
 <div class='every_p'>
  <span>初审意见:</span>
  <input type="text" value='<?php echo ($returndata["fpyj"]); ?>' name='fpyj'  />
  </div>

</div>

<div class="clear"></div>
<div class="sidebar-frame"> 
<div class='title_p'><span>风控终审意见</span></div>
 <div class='every_p'>
  <span>借款人:</span>
  <input type="text" value='<?php echo ($returndata["cstname"]); ?>' name='cstname'  />
  </div>
 <div class='every_p'>
  <span>批准金额:</span>
  <input type="text" value='<?php echo ($returndata["aprovemoney"]); ?>' name='aprovemoney'  />
  </div>
   <div class='every_p'>
  <span>批准期限:</span>
  <input type="text" value='<?php echo ($returndata["aprovelimit"]); ?>' name='aprovelimit'  />
  </div>
   <div class='every_p'>
  <span>批准利率:</span>
  <input type="text" value='<?php echo ($returndata["aproverate"]); ?>' name='aproverate'  />
  </div>

  <span class="pledge_p">
<div class='every_p'>
<span>请选择资金来源: </span>
<select name="capitalsource">
<option value="0">请选择</option>
<?php if(is_array($list)): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><option value="<?php echo ($vo["id"]); ?>" <?php if(($returndata["capitalsource"]) == $vo["id"]): ?>selected='selected'<?php endif; ?>><?php echo ($vo["organization"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>
</div>
</span>
  <div class='every_p'>
  <span>客户画像:</span>
  <input type="text" value='<?php echo ($returndata["portrait"]); ?>' name='portrait'  />
  </div>
</div>

<!-- 房款方案 -->
<!-- 过桥人信息 -->
<div class="clear"></div>
<div class="sidebar-frame">  
<div class='title_p'><span>是否有过桥</span></div>
<div class="every_p">
<div class='son_p'>
<p><input type="radio" name="bridge" value="1" <?php if(($returndata["bridge"]) == "1"): ?>checked="checked"<?php endif; ?> />有</p>
<p><input type="radio" name="bridge" value="0" <?php if(($returndata["bridge"]) == "2"): ?>checked="checked"<?php endif; ?>/> 无</p>     
</div>
</div> 

<span class='bridge_p bridge' > 
<div class='every_p'>
<span>过桥金额: </span>
<input type="text" class="width_340"  maxlength='20' name='bridgemoney' value='<?php echo ($returndata["bridgemoney"]); ?>'/>
</div>
<div class='every_p'>
<span>贷款人: </span>
<input type="text"   maxlength='20' name='bridgedebtname'/>
</div>
<div class='every_p'>
<span>公证委托人: </span>
<input type="text"   maxlength='20' name='bridgewtname' />
</div>
<div class='every_p'>
<span>贷款人账号: </span>
<input type="text"   maxlength='20' name='bridgedebtaccount'/>
</div>
<div class='every_p'>
<span>开户行: </span>
<input type="text"   maxlength='20' name='bridgedebtaccountbank'/>
</div>

<div class='every_p'>
<span>放款金额1: </span>
<input type="text"   maxlength='20' />
</div>

<div class='every_p'>
<span>放款条件: </span>
<input type="text"   maxlength='20' />
</div>

<div class='every_p'>
<span>放款金额2: </span>
<input type="text"   maxlength='20' />
</div>

<div class='every_p'>
<span>放款条件2: </span>
<input type="text"   maxlength='20' />
</div>

<div class='every_p '>
<span>请选择过桥人: </span>
<select name="bridgename">
<option value='0'>请选择过桥人</option>
<?php if(is_array($blist)): $k = 0; $__LIST__ = $blist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><option value="<?php echo ($vo["uid"]); ?>" <?php if(($returndata["bridgename"]) == $vo["uid"]): ?>selected='selected'<?php endif; ?>><?php echo ($vo["nickname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>
</div>

<div class="clear"></div>
<div class='every_p'>
<span>过桥人开户行: </span>
<input type="text" class="width_340" id='bank' maxlength='20'  readonly='readonly'/>
</div>
<div class='every_p'>
<span>过桥人账号: </span>
<input type="text" class="width_353"  id='account' maxlength='20' readonly='readonly'/>
</div>

</span>
         
</div>

<!-- 其他信息 -->
<!-- 
<div class="clear"></div>
<div class="sidebar-frame"> 
<div class='title_p'><span>其他信息</span></div>


<span class="pledge_p"><div class='every_p'>
<span>请选择风控初审: </span>
<select name="riskearly">
<option value='0'>请选择</option>
<?php if(is_array($elist)): $i = 0; $__LIST__ = $elist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if(($returndata["riskearly"]) == $vo["id"]): ?>selected='selected'<?php endif; ?>><?php echo ($vo["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>
</div></span>

<span class="pledge_p2"><div class='every_p'>
<span>请选择风控终审: </span>
<select name="riskfinal">
<option value='0'>请选择</option>
<?php if(is_array($flist)): $i = 0; $__LIST__ = $flist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["id"]); ?>" <?php if(($returndata["riskfinal"]) == $vo["id"]): ?>selected='selected'<?php endif; ?>><?php echo ($vo["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>
</div></span>

</div> -->

<!-- 图片信息 -->
<div class='clear'></div>
<div class="sidebar-frame" style='margin:10px auto;border:none'> 
  <div class="sidebar-s"> 
    <input  type='submit' class="btn btn-large btn-primary btn btn-default"  style='margin:10px 10px;'value='初审通过'/>
      <input class="btn btn-large btn-primary btn btn-default"  onclick='del(<?php echo ($vo["id"]); ?>);' type='button' value='初审拒绝'/>
    </div>
</div>

</form>
</div> 
</body>
</html>

<script type="text/javascript">
    $(function(){
        $("#fang").click(function()
        {
            $("#house").show();
            $("#ca").hide();
        });
        $("#car").click(function(){
            $("#house").hide();
            $("#ca").show();
        });


    });

    
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

function number(i,n)
{
  if(i>2||i<0.8)
  {
    $("#"+n).text('贷款利率介于0.8-2之间').show();
  }
}

$(function () {       
        var bridge=$('input[name=bridge][value=2]');
        var bridgeis=$('input[name=bridge][value=1]');

        bridge.click(function(){
             $(".bridge").hide();
        });
        bridgeis.click(function(){
            $(".bridge").show();
        });
        if(bridge.attr('checked'))
        {
           $(".bridge").hide();
        }

        //当选择不同的过桥人的时候显示相应的信息
        $("select[name=bridgename]").change(function(){
          var id=$(this).val();
          // console.log(id);
          $.ajax({
                    type:'POST',
                    url:"/index.php/Home/Menu/bridgecontent",
                    data:{id:id},
                    dataType:"json",
                    success:function(b){
                        $('#bank').val(b[0]['bridgeaddress']);
                        $('#nickname').val(b[0]['nickname']);
                        $("#account").val(b[0]['bridgeaccount']);
                    }
                });
        })
    });

</script>
<!-- 图片上传 -->
<script type="text/javascript">


      //过桥人信息要展示出来
    var newid1=$("select[name=bridgename] option[selected]").val();
    $.ajax({
                    type:'POST',
                    url:"/index.php/Home/Menu/bridgecontent",
                    data:{id:newid1},
                    dataType:"json",
                    success:function(b){
                        $('#bank').val(b[0]['bridgeaddress']);
                        $('#nickname').val(b[0]['nickname']);
                        $("#account").val(b[0]['bridgeaccount']);
                    }
                });
</script>