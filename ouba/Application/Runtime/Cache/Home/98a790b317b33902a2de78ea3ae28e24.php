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
             jBox.open("get:/index.php/Home/Role/impawn?id="+id, title, 300, 50, { buttons: { '关闭': true }, persistent: false });
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
                             url: "/index.php/Home/Role/admityj",
                             data: {id:id,f:f.yourtip,s:3},
                             dataType: "json",
                             success: function(data){
                                        if(data==1)
                                          { 
                                            location.href = '/index.php/Home/Role/admit?id='+id;
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
<form action="/index.php/Home/Role/add" method="post" class="definewidth m20" enctype='multipart/form-data'>
    <table class="table table-bordered table-hover definewidth m10">
        <tr>
            <td width="10%" class="tableleft">隶属机构</td>
            <td><select  name="pid">
                <?php if(is_array($list)): $k = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($k % 2 );++$k;?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["organization"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select></td>
        </tr>
        <tr>
            <td class="tableleft">角色选择</td>
            <td>
                <input type="radio" name="status" value="8" checked='checked'/> 业务员  
                <input type="radio" name="status" value="2"/> 贷款录入
                <input type="radio" name="authority" value="1"/> 风控初审
                <input type="radio" name="authority" value="2"/> 风控终审
                <!-- <input type="radio" name="status" value="9"/> 过桥贷款人 -->
                <input type="radio" name="status" value="3"/> 风控复核
                <input type="radio" name="status" value="6"/> 财务人员
                <input type="radio" name="status" value="4"/> 抵押权人（授权委托人）
             </td>
        </tr>
            
            <tr>
            <td width="10%" class="tableleft">角色名称</td>
            <td><input type="text" name="username"/></td>
        </tr>
            <tr>
            <td width="10%" class="tableleft">角色密码</td>
            <td><input type="password" name="pwd"/></td>
        </tr>

        <tr>
            <td width="10%" class="tableleft">身份证号码</td>
            <td><input type="text" name="idno"/></td>
        </tr>
        <tr>
            <td width="10%" class="tableleft">身份证照片</td>
            <td><input type="file" name="idnopic"/></td>
        </tr>

         <tr>
            <td width="10%" class="tableleft">户口</td>
            <td><input type="text" name="hukou"/></td>
        </tr>
          <tr>
            <td width="10%" class="tableleft">户口本照片</td>
            <td><input type="file" name="hkpic"/></td>
        </tr>
            <tr>
            <td width="10%" class="tableleft">联系方式</td>
            <td><input type="text" name="mobile"/></td>
        </tr>
        
             <tr>
            <td width="10%" class="tableleft">银行账号户名</td>
            <td><input type="text" name="accountname"/></td>
        </tr>

             <tr>
            <td width="10%" class="tableleft">账号</td>
            <td><input type="text" name="account"/></td>
        </tr>

           <tr>
            <td width="10%" class="tableleft">开户行</td>
            <td><input type="text" name="accountaddress"/></td>
        </tr>
 
     <!--        <tr>
            <td class="tableleft">角色权限</td>
            <td>
                <input type="radio" name="authority" value="1"/> 初审
                <input type="radio" name="authority" value="2"/> 终审
            </td>
        </tr> -->
      
        <tr>
            <td class="tableleft"></td>
            <td>
                <button type="submit" class="btn btn-primary btn-large" type="button">添加</button> &nbsp;&nbsp;
            </td>
        </tr>
    </table>
</form>
<!-- 过桥人 -->
 <div class="form-inline definewidth m20">添加过桥贷款人 &there4;</div>：
<form action="/index.php/Home/Role/bridgeadd" method="post" class="definewidth m20">
    <table class="table table-bordered table-hover definewidth m10">
   
        <tr>
            <td width="10%" class="tableleft">过桥人名称</td>
            <td><input type="text" name="nickname"/></td>
        </tr>
        <tr>
            <td width="10%" class="tableleft">身份证号</td>
            <td><input type="text" name="idno" maxlength='18'/></td>
        </tr>
         <tr>
            <td width="10%" class="tableleft">联系电话</td>
            <td><input type="text" name="tel" maxlength='12'/></td>
        </tr>
         <tr>
            <td width="10%" class="tableleft">银行账户</td>
            <td><input type="text" name="bridgeaccount" maxlength='18'/></td>
        </tr>
    
         <tr>
            <td width="10%" class="tableleft">开户行</td>
            <td><input type="text" name="bridgeaddress" maxlength='22'/></td>
        </tr>
  
          <tr>
            <td width="10%" class="tableleft">联系QQ</td>
            <td><input type="text" name="qq" maxlength='12'/></td>
        </tr>
          <tr>
            <td width="10%" class="tableleft">婚姻状况</td>
            <td>
                <input type="radio" name="wed" value="1" checked='checked'/> 未婚  
                <input type="radio" name="wed" value="2"/> 已婚
                <input type="radio" name="wed" value="3"/> 离异
            </td>
        </tr>
          <tr>
            <td width="10%" class="tableleft">年龄</td>
            <td><input type="number" name="age"/></td>
        </tr>
          <tr>
            <td width="10%" class="tableleft">职业</td>
            <td><input type="text" name="work"/></td>
            <input type='hidden' name='type'  value='bridge'/>
        </tr>
<!--         <tr>
            <td class="tableleft">角色选择</td>
            <td>
                <input type="radio" name="status" value="8" checked='checked'/> 业务员  
                <input type="radio" name="status" value="2"/> 前台
                <input type="radio" name="status" value="9"/> 合作机构
            </td>
        </tr>
            <tr>
            <td class="tableleft">角色权限</td>
            <td>
                <input type="radio" name="status" value="1"/> 初审
                <input type="radio" name="status" value="2"/> 终审
            </td>
        </tr> -->
      
        <tr>
            <td class="tableleft"></td>
            <td>
                <button type="submit" class="btn btn-primary" type="button">保存</button> &nbsp;&nbsp;
                <!-- <button type="button" class="btn btn-success" name="backid" id="backid">返回列表</button> -->
            </td>
        </tr>
    </table>
</form>
</body>
</html>
<script>
    $(function () {
        $(':checkbox[name="group[]"]').click(function () {
            $(':checkbox', $(this).closest('li')).prop('checked', this.checked);
        });

        $('#backid').click(function(){
                window.location.href="index.html";
         });
    });
</script>