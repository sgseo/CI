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
  <ol class="breadcrumb">
  <li><a href="#">业务管理-></a></li>
  <li class="active">贷款预览</li>
  <!-- <li >十一月</li> -->
</ol>
<style type="text/css">
        body {
            padding-bottom</td><td>40px;
        }
        .sidebar-nav {
            padding</td><td>9px 0;
        }
        table ,td, tr{
          width: 250px;
          border：1px solid #dddddd;
          border-color:inherit;
          height:30px;
        }
        .table tr td{
          border:1px solid #ddd;
          /*text-align: center;*/
          vertical-align: middle;

        }

</style>
</head>
<body>
<div style='margin:1px auto;width:70%;'>
<!-- 项目录入 -->
<form  style="padding-top:2px; " action="/index.php/Home/Menu/add" method="post" enctype="multipart/form-data" >
<!-- 基础文档模型 -->
<table class='table  definewidth m10 t' >
<tr><td colspan='6' style='text-align:center; border:1px solid #ddd'><h2>贷款项目信息表</h2></td></tr>
<tr><td colspan='6'>一、借款核心信息：</td></tr>
<!-- 金额利率类型期限标题借款人 -->
<tr>
   <td>借款标题</td>
   <td><input type="text"  name="title"  readonly='readonly' value="<?php echo ($data["title"]); ?>" ></td>
   <td>贷款金额 (元)</td>
   <td>
   <input type="text"   name="borrowamt" data-ideny='num2ch'  readonly='readonly' value="<?php echo ($data["borrowamt"]); ?>" onblur='num2ch(this.value,this.name)'>
    <span id='borrowamt' style='color:red; text-align:center; line-height:15px;'>
   </td>
    <td>贷款期限 (月) </td>
    <td>
    <input type="text"  name="duration"  readonly='readonly' value="<?php echo ($data["duration"]); ?>" >
   </td>
</tr>

<tr>
  <td>
    贷款利率 (0.8%-2%之间)
  </td>
  <td>
<input type="text"   name="rate"  readonly='readonly' value="<?php echo ($data["rate"]); ?>"  onblur="number(this.value,this.name)" >
<span id='rate' style='display:none;color:red'>
  </td>
  <td>
  <input  type="radio"  readonly='readonly' value="fang" name="category" id='fang' <?php if(($data["category"]) == "fang"): ?>checked="checked"<?php endif; ?>/>
  房屋抵押
  </td>
  
  <td>
    <input type="radio"  readonly='readonly' value="car" name="category" id='car' <?php if(($data["category"]) == "car"): ?>checked="checked"<?php endif; ?>>车辆抵押
  </td>

<td>
借款人姓名
</td>
<td>
<input type="text"   name="cstname"  readonly='readonly' value="<?php echo ($data["cstname"]); ?>" >
</td>
</tr>


<tr><td colspan='6'>二、借款人信息</td></tr>
<tr>
  <td>
  身份证号</td>
  <td>
<input type="text"  name="idno"  readonly='readonly' value="<?php echo ($data["idno"]); ?>"  maxlength='40'>
</td>
<td>
借款人户籍
</td>
<td>
<input type="text"   name="domicile"  readonly='readonly' value="<?php echo ($data["domicile"]); ?>"  maxlength='40'>
</td>
<td>
  借款人年龄
</td>
<td>
<input type="text"   name="age"  readonly='readonly' value="<?php echo ($data["age"]); ?>"  maxlength='40'>
  
</td>
</tr>
<tr>
<td>
  手机号码</td>
  <td>
<input type="text"  name="tel"  readonly='readonly' value="<?php echo ($data["tel"]); ?>"  maxlength='40'>
</td>
<td>
婚姻状况
</td>

<td>
<input  type="radio"  readonly='readonly' value="1" name="wed" <?php if(($data["wed"]) == "1"): ?>checked="checked"<?php endif; ?>/>未婚
<input  type="radio"  name="wed"  readonly='readonly' value='2' <?php if(($data["wed"]) == "2"): ?>checked="checked"<?php endif; ?>/>已婚
<input  type="radio"  name="wed"  readonly='readonly' value='3' <?php if(($data["wed"]) == "3"): ?>checked="checked"<?php endif; ?>/>离异
</td>
<td>
  借款人职业</td>
  <td>
<input type="text"  name="work"  readonly='readonly' value="<?php echo ($data["work"]); ?>"  maxlength='40'>
</td>
</tr>

<tr><td colspan='6'>三、抵押物信息</td></tr>
<tr>
  <td>
   <input  type="radio"  readonly='readonly' value="1" name="iscity" <?php if(($data["iscity"]) == "1"): ?>checked="checked"<?php endif; ?>/>内环
<input  type="radio"  name="iscity"  readonly='readonly' value='2' <?php if(($data["iscity"]) == "2"): ?>checked="checked"<?php endif; ?>/>非内环
<input  type="radio"  readonly='readonly' value="2" name="isloan" <?php if(($data["isloan"]) == "2"): ?>checked="checked"<?php endif; ?>/>有租赁
<input  type="radio"  name="isloan"  readonly='readonly' value='1' <?php if(($data["isloan"]) == "1"): ?>checked="checked"<?php endif; ?>/>无租赁
  </td>
  <td>
    抵押情况
  </td>
  <td>
<select name="pledge">
<option  readonly='readonly' value='0'>请选择</option>
<?php if(is_array($pllist)): $i = 0; $__LIST__ = $pllist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option  readonly='readonly' value="<?php echo ($vo["sort"]); ?>" <?php if(($data["pledge"]) == $vo["sort"]): ?>selected='selected'<?php endif; ?>><?php echo ($vo["condition"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>
  </td>
  <td>
    房屋类型
  </td>
  <td>
<select name="housetype"  required>
<option  readonly='readonly' value="0">请选择</option>
<?php if(is_array($htlist)): $i = 0; $__LIST__ = $htlist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option  readonly='readonly' value="<?php echo ($vo["id"]); ?>" <?php if(($data["housetype"]) == $vo["id"]): ?>selected='selected'<?php endif; ?>><?php echo ($vo["housetype"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>
  </td>
  <td>
    房屋地址
<input type="text"  name="address"  readonly='readonly' value="<?php echo ($data["address"]); ?>" >
  </td>
  <tr>
  <td>
    房屋市场价(元)
  </td>
    <td>
<input type="text" class="width_333"  name="price"  readonly='readonly' value="<?php echo ($data["price"]); ?>"  onblur='num2ch(this.value,this.name)'>
<span id='price' style='display:none;color:red;'>
  </td>
  <td>
    房屋评估价(元)  </td>
      <td>
<input type="text" class="width_356"  name="estimateprice"  readonly='readonly' value="<?php echo ($data["estimateprice"]); ?>" onblur='num2ch(this.value,this.name)'>
<span id='estimateprice' style='display:none;color:red'>
    
  </td>
  <td>
    房屋户口  </td>
    <td>
<input type="text"  name="residence"  readonly='readonly' value="<?php echo ($data["residence"]); ?>" >
  </td>
</tr>
<tr>
  <td>
    房屋面积(平方米)  </td>
      <td>
<input type="text" class="width_321"  name="area"  readonly='readonly' value="<?php echo ($data["area"]); ?>" >
  </td>
  <td>
    房地产权证号  </td>
      <td>
<input type="text" class="width_363"  name="pledgeno"  readonly='readonly' value="<?php echo ($data["pledgeno"]); ?>">
  </td>
<td>
  备用房地址  </td>
    <td>
<input type="text"   name="anotheradd"  readonly='readonly' value="<?php echo ($data["anotheradd"]); ?>">
</td>
<tr>
<td>
  备用房面积  </td>
    <td>
<input type="text"   name="anotherarea"  readonly='readonly' value="<?php echo ($data["anotherarea"]); ?>">
</td>
</tr>
<!-- <span > -->
<tr class='ca' style="display:none"><td colspan='6'>车辆</td></tr>
 <tr class='ca' style="display:none">
<td>车子品牌  </td>
  <td>
<input type="text"  name="carbrand"  readonly='readonly' value="<?php echo ($data["carbrand"]); ?>" >
</td>

  <td>车子型号  </td>
  <td>
<input type="text"  name="cartype"  readonly='readonly' value="<?php echo ($data["cartype"]); ?>" >
</td>
<td>车子估价(元)  </td>
  <td>
<input type="text"  name="carestimate"  readonly='readonly' value="<?php echo ($data["carestimate"]); ?>"  onblur='num2ch(this.value,this.name)'>
<span id='carestimate' style='display:none;color:red'>
</td>
<tr class='ca' style="display:none">
<td>
车辆购买日期  </td>
  <td>
<input type="date"  readonly='readonly' value='<?php echo ($data["carbuytime"]); ?>' name='carbuytime'  />
</td>
</tr>
<!-- </span> -->



<tr><td colspan='6'>四、借款人账户信息</td></tr>
<tr>
  <td>开户名</td>
  <td><input type="text" class="width_378"  name="bankname"  readonly='readonly' value="<?php echo ($data["bankname"]); ?>" maxlength='40'></td>
  <td>
    银行卡号
  </td>
  <td>
<input type="text"  name="bankcard"  readonly='readonly' value="<?php echo ($data["bankcard"]); ?>"  maxlength='40'>
  </td>
  <td>
    开户行</td>
    <td>
<input type="text" class="width_378"  name="bank"  readonly='readonly' value="<?php echo ($data["bank"]); ?>" maxlength='40'>
  </td>
</tr>

<tr><td colspan='6'>过桥信息</td></tr>
<tr>
  <td>是否有过桥</td>
  <td>
    <input type="radio" name="bridge"  readonly='readonly' value="1" <?php if(($data["bridge"]) == "1"): ?>checked="checked"<?php endif; ?>/>有
<input type="radio" name="bridge"  readonly='readonly' value="0" <?php if(($data["bridge"]) == "0"): ?>checked="checked"<?php endif; ?>/> 无   
  </td>
  <td>
    请选择过桥人</td>
    <td>
<select name="bridgename">
<option  readonly='readonly' value='0'>请选择过桥人</option>
<?php if(is_array($blist)): $k = 0; $__LIST__ = $blist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><option  readonly='readonly' value="<?php echo ($vo["uid"]); ?>"  <?php if(($data["bridgename"]) == $vo["uid"]): ?>selected='selected'<?php endif; ?>><?php echo ($vo["nickname"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>
  </td>

  <td>
    过桥人开户行</td>
    <td>
<input type="text" class="width_340"  id='bank' maxlength='40' readonly='readonly'/>
  </td>
  <tr>
  <td>
    过桥人账号
  </td>
    <td>
<input type="text"   id='account' maxlength='40' readonly='readonly'/>
  </td>
  <td>
    过桥人开户名</td>
    <td>
<input type="text"  id='nickname' maxlength='40' readonly='readonly'/>
  </td>
</tr>

<tr><td colspan='6'>五、抵押人信息</td></tr>
<tr>
  <td>
    抵押人姓名</td>
    <td>
<input type="text"   readonly='readonly' value='<?php echo ($data["pledgename"]); ?>' name='pledgename' />
  </td>
  <td>
  抵押人电话</td>
  <td>
<input type="text"   readonly='readonly' value='<?php echo ($data["pledgetel"]); ?>' name='pledgetel' />
</td>
<td>
  抵押人身份证号码</td>
  <td>
<input type="text" class="width_338"  readonly='readonly' value='<?php echo ($data["pledgeidno"]); ?>' name='pledgeidno' />
</td>
</tr>





<tr><td colspan='6'>六、其他信息</td></tr>
<tr>
  <td>资金来源</td>
  <td>
<select name="capitalsource">
<option  readonly='readonly' value="0">请选择</option>
<?php if(is_array($list)): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><option  readonly='readonly' value="<?php echo ($vo["id"]); ?>" <?php if(($data["capitalsource"]) == $vo["id"]): ?>selected='selected'<?php endif; ?>><?php echo ($vo["organization"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>
</td>

<td>
借款用途</td>
<td>
<select name="loandest" >
<option  readonly='readonly' value="0">请选择</option>
<?php if(is_array($pllist2)): $i = 0; $__LIST__ = $pllist2;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option  readonly='readonly' value="<?php echo ($vo["sort"]); ?>" <?php if(($data["loandest"]) == $vo["sort"]): ?>selected='selected'<?php endif; ?>><?php echo ($vo["condition"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>
</td>


<td>业务来源单位</td>
<td>
<select name="source">
<option  readonly='readonly' value='0'>请选择</option>
<?php if(is_array($list)): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><option  readonly='readonly' value="<?php echo ($vo["id"]); ?>" <?php if(($data["source"]) == $vo["id"]): ?>selected='selected'<?php endif; ?>><?php echo ($vo["organization"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>
</td>

<tr>
<td>业务员</td>
<td>
<select name="salesman">
<option  readonly='readonly' value='0'>请选择</option>
<?php if(is_array($plist)): $i = 0; $__LIST__ = $plist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option  readonly='readonly' value="<?php echo ($vo["id"]); ?>" <?php if(($data["salesman"]) == $vo["id"]): ?>selected='selected'<?php endif; ?>><?php echo ($vo["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>
</td>


<td>风控初审</td>
<td>
<select name="riskearly">
<option  readonly='readonly' value='0'>请选择</option>
<?php if(is_array($elist)): $i = 0; $__LIST__ = $elist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option  readonly='readonly' value="<?php echo ($vo["id"]); ?>" <?php if(($data["riskearly"]) == $vo["id"]): ?>selected='selected'<?php endif; ?>><?php echo ($vo["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>
</td>

<td>
风控终审</td>
<td>
<select name="riskfinal">
<option  readonly='readonly' value='0'>请选择</option>
<?php if(is_array($flist)): $i = 0; $__LIST__ = $flist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option  readonly='readonly' value="<?php echo ($vo["id"]); ?>" <?php if(($data["riskfinal"]) == $vo["id"]): ?>selected='selected'<?php endif; ?>><?php echo ($vo["username"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
</select>
</td>

</tr>

<tr><td colspan='6'>七、征信情况</td></tr>
<tr>
  <td>
    征信逾期次数  </td>
      <td>
  <input type="text" value='<?php echo ($data["credit"]); ?>' readonly='readonly' name='credit'  />
  </td>
 <td>
   负债情况</td>
   <td>
<input type="radio" name="debt" value="1" <?php if(($data["debt"]) == "1"): ?>checked=checked<?php endif; ?>/>抵押负债
<input type="radio" name="debt" value="2" <?php if(($data["debt"]) == "2"): ?>checked=checked<?php endif; ?>/>无抵押负债     
</td>
<td>
  备注信息  
   </td>
    <td>
<textarea name="tip" placeholder="备注信息" rows='5' cols='80'><?php echo ($data["tip"]); ?></textarea>
  
</td>


</tr>
<tr>
  <td colspan='3' style='text-align:center'>
<button class="btn btn-large btn-primary btn btn-default" type='submit' >确认提交</button>
</td>
<td colspan='3' style='text-align:center'>
<button class="btn btn-large btn-primary btn btn-default" type='button' id='reset'>返回修改</button>
</td>

</tr>

</table>
</form>
</td> 

</body>
</html>

<script type="text/javascript">
    $(function(){
        $("#fang").click(function()
        {
            $("#house").show();
            $(".ca").hide();
        });
        $("#car").click(function(){
            $("#house").hide();
            $(".ca").show();
        });

        $("#reset").click(function(){
         $("form").attr('action','/index.php/Home/Menu/index');
         $('form').submit();
        });


    });


      var qf=1;
    $("input:button").click(function(){
      var name=$(this).attr("id");
      qf+=1;
      var button="<div class='adder'><input type='file'  name='"+name+qf+"' />"
                  +"<a href='javascript:void(0);'' onclick='del(this);'>"
                  +"<input type='button' onlick='del(this)'  readonly='readonly' value='-' />"
                  +"</td></a>";
       $(this).after(button);
    });
    function del(a)
    {
      $(a).parent().remove();
    }
    
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
        var bridge=$("input[name=bridge][ readonly='readonly' value=0]");
        var bridgeis=$("input[name=bridge][ readonly='readonly' value=1]");
        bridge.click(function(){
             $(".bridge").hide();
        });
        bridgeis.click(function(){
            $(".bridge").show();
        });

        //当选择不同的过桥人的时候显示相应的信息
        $("select[name=bridgename]").change(function(){
          var id=$(this).val();
          var text=$(this).text();
          $.ajax({
                    type:'post',
                    url:"/index.php/Home/Menu/bridgecontent",
                    data:{id:id},
                    dataType:"json",
                    success:function(b){
                        $('#bank').val(b[0]['bridgeaddress']);
                        $('#nickname').val(b[0]['nickname']);
                        $("#account").val(b[0]['bridgeaccount']);
                    }
                });
        });

        //过桥人信息要展示出来
    var newid1=$("select[name=bridgename] option[selected]").val();
    if(newid1)
    {
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
  }
    });

</script>
<!-- 图片上传 -->