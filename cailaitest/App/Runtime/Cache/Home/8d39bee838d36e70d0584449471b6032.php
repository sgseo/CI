<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta property="qc:admins" content="7570776233633" />
<meta http-equiv="X-UA-Compatible" content="IE=8" />
<link rel="shortcut icon" href="/Style/H/images/favicon.ico" type="image/x-icon" />
<link rel="stylesheet" type="text/css" href="__ROOT__/Style/H/css/index.css" />
<link rel="stylesheet" type="text/css" href="__ROOT__/Style/H/css/css.css" />
<link rel="stylesheet" type="text/css" href="__ROOT__/Style/H/css/kefu.css" />
<link type="text/css" rel="stylesheet" href="__ROOT__/Style/JBox/Skins/Currently/jbox.css"/>
<link rel="stylesheet" type="text/css" href="__ROOT__/Style/H/css/style.css" />
<script type="text/javascript" src="__ROOT__/Style/H/js/jquery.min.js"></script>
<script type="text/javascript" src="__ROOT__/Style/Js/jquery.js"></script>
<script  src="__ROOT__/Style/JBox/jquery.jBox.min.js" type="text/javascript"></script>
<script  src="__ROOT__/Style/JBox/jquery.jBoxConfig.js" type="text/javascript"></script>
<script type="text/javascript" src="__ROOT__/Style/Js/utils.js"></script>
<script type="text/javascript">
    var browser=navigator.appName;
    var b_version=navigator.appVersion;
    var version=b_version.split(";"); 
    if(version.length>1) var trim_Version=version[1].replace(/[ ]/g,"");

    if(browser=="Microsoft Internet Explorer" && (trim_Version=="MSIE5.0" || trim_Version=="MSIE6.0")) 
        alert("您正在使用的浏览器版本过低，有些网站效果会显示不出来，建议升级后再使用本网站。"); 

	function makevar(v){
		var d={};
		for(i in v){
			var id = v[i];
			d[id] = $("#"+id).val();
			if(!d[id]) d[id] = $("input[name='"+id+"']:checked").val();
			if(!d[id]) d[id] = $("input[name='"+id+"']").val();
			if(typeof d[id] == "undefined") d[id] = "";
		}
		return d;
	}
    function addBookmark(title, url) {
        if (window.sidebar) {
            window.sidebar.addPanel(title, url, "");
        }
        else if (document.all) {
            window.external.AddFavorite(url, title);
        }
        else if (window.opera && window.print) {
            return true;
        }
    }
    function SetHome(obj, vrl) {
        try {
            obj.style.behavior = 'url(#default#homepage)'; obj.setHomePage(vrl);
            NavClickStat(1);
        }
        catch (e) {
            if (window.netscape) {
                try {
                    netscape.security.PrivilegeManager.enablePrivilege("UniversalXPConnect");
                }
                catch (e) {
                    alert("抱歉！您的浏览器不支持直接设为首页。请在浏览器地址栏输入“about:config”并回车然后将[signed.applets.codebase_principal_support]设置为“true”，点击“加入收藏”后忽略安全提示，即可设置成功。");
                }
                var prefs = Components.classes['@mozilla.org/preferences-service;1'].getService(Components.interfaces.nsIPrefBranch);
                prefs.setCharPref('browser.startup.homepage', vrl);
            }
        }
    }
     
// 修复 IE 下 PNG 图片不能透明显示的问题
function fixPNG(myImage) {
var arVersion = navigator.appVersion.split("MSIE");
var version = parseFloat(arVersion[1]);
if ((version >= 5.5) && (version < 7) && (document.body.filters))
{
     var imgID = (myImage.id) ? "id='" + myImage.id + "' " : "";
     var imgClass = (myImage.className) ? "class='" + myImage.className + "' " : "";
     var imgTitle = (myImage.title) ? "title='" + myImage.title   + "' " : "title='" + myImage.alt + "' ";
     var imgStyle = "display:inline-block;" + myImage.style.cssText;
     var strNewHTML = "<span " + imgID + imgClass + imgTitle

   + " style=\"" + "width:" + myImage.width

   + "px; height:" + myImage.height

   + "px;" + imgStyle + ";"

   + "filter:progid:DXImageTransform.Microsoft.AlphaImageLoader"

   + "(src=\'" + myImage.src + "\', sizingMethod='scale');\"></span>";
     myImage.outerHTML = strNewHTML;
} } 


</script>

<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title><?php echo ($vo["borrow_name"]); ?>-我要投资-<?php echo ($glo["web_name"]); ?></title>
<meta http-equiv="keywords" content="<?php echo ($glo["web_keywords"]); ?>" />
<meta http-equiv="description" content="<?php echo ($glo["web_descript"]); ?>" />
<link rel="stylesheet" href="__ROOT__/Style/H/css/reset.css" />
<link rel="stylesheet" href="__ROOT__/Style/H/css/detail.css?v=20150316" />
<link rel="stylesheet" type="text/css" href="__ROOT__/Style/fancybox/jquery.fancybox-1.3.2.css" media="screen" />


<script type="text/javascript">
function videoverify(){
	var msg = "申请视频认证后会直接从帐户扣除认证费用<?php echo (($glo["fee_video"])?($glo["fee_video"]):0); ?>元，然后客服会联系您进行认证。<br/><font style='color:red'>确定要申请认证吗?</font>";
	var content = '<div class="jbox-custom"><p>'+ msg +'</p><div class="jbox-custom-button"><span onclick="$.jBoxl.close()">暂不申请</span><span onclick="dovideo(true)">确认申请</span></div></div>';
  	$.jBox(content, {title:'视频认证'});
}
function dovideo(v, h, f) {
	if (v == true){
        $.ajax({
            url: "__APP__/common/video",
            data: {},
            timeout: 5000,
            cache: false,
            type: "get",
            dataType: "json",
            success: function (d, s, r) {
              	if(d){
					if(d.status==1) $.jBox.tip(d.message, 'success');
					else $.jBox.tip(d.message, 'error');
				}
            }
        });
	}
	return true;
};
// 自定义按钮
function faceverify(){
	var msg = "<font style='color:red'>确定要申请现场认证吗?</font>";
	var content = '<div class="jbox-custom"><p>'+ msg +'</p><div class="jbox-custom-button"><span onclick="$.jBoxl.close()">暂不申请</span><span onclick="doface(true)">确认申请</span></div></div>';
  	$.jBox(content, {title:'现场认证'});
}
function doface(v, h, f) {
	if (v == true){
        $.ajax({
            url: "__APP__/common/face",
            data: {},
            timeout: 5000,
            cache: false,
            type: "get",
            dataType: "json",
            success: function (d, s, r) {
              	if(d){
					if(d.status==1) $.jBox.tip(d.message, 'success');
					else $.jBox.tip(d.message, 'error');
				}
            }
        });
	}
	return true;
};
  $(function  () {
   	 var xiaowei_p= $("#xiaowei li");
   	 if(true)
   	 {
   	   xiaowei_p.parent().parent().css('background','url(__ROOT__/Style/H/images/hover_bg.gif) no-repeat center right');
   	 }
   });

  
</script>
<script type=text/javascript><!--//--><![CDATA[//><!--
function menuFix() {
// @Modify fangjixiang 20140509
var ele__ = document.getElementById("nav");
if(!ele__) return false;

var sfEls = ele__.getElementsByTagName("li");
for (var i=0; i<sfEls.length; i++) {
sfEls[i].onmouseover=function() {
this.className+=(this.className.length>0? " ": "") + "sfhover";
}
sfEls[i].onMouseDown=function() {
this.className+=(this.className.length>0? " ": "") + "sfhover";
}
sfEls[i].onMouseUp=function() {
this.className+=(this.className.length>0? " ": "") + "sfhover";
}
sfEls[i].onmouseout=function() {
this.className=this.className.replace(new RegExp("( ?|^)sfhover\\b"),
"");
}
}
}
window.onload=menuFix;
//--><!]]></script>
<link rel="stylesheet" type="text/css" href="__ROOT__/Style/H/css/home.css" />
</head><body>
<!--头部开始-->
<?php if($UID > '0'): ?><div class="first_top">
  <div class="dv_header top ">
    <!--迷你导航-->

<div class="dw_bgx dw_mini">
<div class="Cmml00" style="margin-top: 0;">
<?php
 $dws= session('u_user_name'); ?>
<div class="fl dw_Cbg zuo">

<div class="fl" >全国免费热线: <?php $dw_kefu=get_qq(2);echo($dw_kefu[0]["qq_num"]); ?>  欢迎访问<b><a href="http://www.cailai.com">上海财来网</a></b>!</div>
</div>
<div class="fr">
<div class="fl">
<a class="right_a" href="__APP__/member/index" >我的账户：<?php echo session('u_user_name');?></a><a  class="right_a" href="__APP__/member/msg#fragment-1" >消息(<?php echo (($unread)?($unread):0); ?>)</a><a  class="right_a" href="__APP__/member/common/actlogout" >退出</a>

</div>
<div class="fliphonebg"><div class="fliphone"><a href="/borrow/app.html" target="_blank">手机客户端</a></div></div>

<div class="top_center">
<ul> 
<a target="_blank" href="http://weibo.com/cailaiwang"> 

<li class="hover_sina"> 
<div class="weibo_c"><img src="__ROOT__/Style/H/images/count/top_sina.png" /></div>
</li></a>

<li class="hover_weixin">
<div class="weibo_c weixin_c"><img src="__ROOT__/Style/H/images/count/top_weixin.png" /></div>
</li>

</ul>
</div>

<div class="fl " id="dw_qun">
<ul id="erji">
<li class=" dw_Cbg eq1 iqqHide">
<span>官方群号</span>
<div>
<?php $_result=get_qq(1);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vq): $mod = ($i % 2 );++$i;?><p><?php echo ($vq["qq_num"]); ?></p><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
</li>
<li class="dw_Cbg eq2 iqqHide">
<span>在线客服</span>
<div class="eq201">
        <?php $_result=get_qq(0);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vq): $mod = ($i % 2 );++$i;?><a class="icoTc" href="tencent://Message/?Uin=<?php echo ($vq["qq_num"]); ?>&amp;websiteName=<?php echo ($vq["qq_title"]); ?>&amp;Menu=ye"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo ($vq["qq_num"]); ?>:52" alt="点击这里给我发消息" title="点击这里给我发消息"/>&nbsp;<?php echo (cnsubstr($vq["qq_title"],6,0,"utf-8",false)); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
</li> 
</ul>
</div>
<div class="fl" > <div id="dw_kefu">  <div class="QQkefu"></div>   <div class="dw_show"></div></div></div>
</div>
</div>
</div>
<!--迷你导航结束-->


  </div>
</div>

  <?php else: ?>
   <div class="first_top">
		<div class="dv_header top ">

<!--迷你导航-->

<div class="dw_bgx dw_mini">
<div class="Cmml00" style="margin-top: 0;">
<?php
 $dws= session('u_user_name'); ?>
<div class="fl dw_Cbg zuo">
<div class="fl" >全国免费热线: <?php $dw_kefu=get_qq(2);echo($dw_kefu[0]["qq_num"]); ?> 欢迎访问<b><a href="http://www.cailai.com">上海财来网</a></b>!</div>
</div>
<div class="fr">

<div class="fl">
    <a class="fl orangebg" href="/member/common/login/">立即登录</a>
    <a href="/member/common/register/" class="fl orange" >免费注册</a>
</div>
<div class="fliphonebg"><div class="fliphone"><a href="/borrow/app.html" target="_blank">手机客户端</a></div></div>

<div class="top_center">
<ul> 
<a target="_blank" href="http://weibo.com/cailaiwang"> 
<li class="hover_sina"> 
<div class="weibo_c"><img src="__ROOT__/Style/H/images/count/top_sina.png" /></div>
</li></a>

<li class="hover_weixin">
<div class="weibo_c weixin_c"><img src="__ROOT__/Style/H/images/count/top_weixin.png" /></div>
</li>
</ul>
</div> 

<div class="fl " id="dw_qun">
<ul id="erji">
<li class=" dw_Cbg eq1 iqqHide">
<span>官方群号</span>
<div>
<?php $_result=get_qq(1);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vq): $mod = ($i % 2 );++$i;?><p><?php echo ($vq["qq_num"]); ?></p><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
</li>
<li class="dw_Cbg eq2 iqqHide">
<span>在线客服</span>
<div class="eq201">
        <?php $_result=get_qq(0);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vq): $mod = ($i % 2 );++$i;?><a class="icoTc" href="tencent://Message/?Uin=<?php echo ($vq["qq_num"]); ?>&amp;websiteName=<?php echo ($vq["qq_title"]); ?>&amp;Menu=ye"><img border="0" src="http://wpa.qq.com/pa?p=2:<?php echo ($vq["qq_num"]); ?>:52" alt="点击这里给我发消息" title="点击这里给我发消息"/>&nbsp;<?php echo (cnsubstr($vq["qq_title"],6,0,"utf-8",false)); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
</div>
</li> 
</ul>
<div class="fl">

</div>
</div>
<div class="fl" > <div id="dw_kefu">  <div class="QQkefu"></div>   <div class="dw_show"></div></div></div>
</div>
</div>
</div>
<!--迷你导航结束-->	
		</div>
	</div><?php endif; ?>
<script type="text/javascript">
  function  erji(a, b, c, d) {
        $(a).children(b).each(function() {
            var a1 = $(this).children(c),
             b2 = $(this).children(d),
             index=$(this).index();
            if (a1.html()) $(this).hover(function() {
                a1.show();
                
            index==0 && $(this).css({'background-position':'0px -62px'});
            index==1 && $(this).css({'background-position':'0px -124px'});
                b2.css({

                    'color':'#fff'
                });
            }, function() {
                a1.hide();
                 index==0 && $(this).css({'background-position':'0px -31px'});
            index==1 && $(this).css({'background-position':'0px -93px'});
                b2.css({

                    'color':'#fff'
                });
            });
        });
    }



erji('#erji','li','div','h1');
</script>
<div class="Nav">
  <div class="contain">
    <div class="N_logo"><a href="/"><img class="ilogo"  src="/Style/H/img/logo.png" alt=""/></a></div>
    <div class="Nav_nav">
      <div class="menu">
        <ul class="navigation-list" id="dw_ul">
          <?php $typelist = getTypeList(array('type_id'=>0,'limit'=>9)); foreach($typelist as $vtype=> $va){ ?>
          <li class="navigation-item "> <a href="<?php echo ($va["turl"]); ?>" class="navigation-item-name"><?php echo ($va["type_name"]); ?>
            <?php $sontypelist = getTypeList(array('type_id'=>$va['id'],'limit'=>8,'notself'=>true)); if($sontypelist != null){ ?>
              <span class="iarrow-down"></span>
            <?php } ?>
            </a>
            <div class="navigation-list-two-con" id="dw_ul2">
                <?php if($sontypelist != null){ ?>
              <div class="navigation-list-two">
                <?php $sontypelist = getTypeList(array('type_id'=>$va['id'],'limit'=>8,'notself'=>true)); ?>
                <span class="loanImg nav-sanjiao"></span>

                <ul class="navigation-two-list" id="erji_nav">
                  <?php $sontypelist = getTypeList(array('type_id'=>$va['id'],'limit'=>8,'notself'=>true)); foreach($sontypelist as $sonvtype){ ?>
                  <li><a href="<?php echo ($sonvtype["turl"]); ?>"  ><?php echo ($sonvtype["type_name"]); ?></a></li>
                  <?php } ?>
                </ul>

              </div>
                <?php } ?>
            </div>
          </li>
          <?php } ?>
         
        </ul>
      </div>
    </div>
   
    <script language="javascript">
                   $(document).ready(function(){
			
						
					$("#ui-nav-item-link").mouseover(function(){
						$("#ui-nav-dropdown").show()
						}).mouseout(function(){
							$("#ui-nav-dropdown").hide()
							});
						$(".ui-nav-dropdown-item").mouseover(function(){
							$(this).css({"background":"#027BC0"}).mouseout(function(){
								$(this).css({"background":"#fff"})
															});

							})
						
					  })
 
                     </script>
  </div>
</div>

<div class="state_main">
  <div class="xw_main_state">
    <div class="state_project"> 
    <div class="phc_dybt"> <span class="tailuser">借款用户&nbsp;:&nbsp;<?php echo ($minfo["user_name2"]); ?>&nbsp;<!--<?php echo (getleveico($minfo["credits"],2)); ?>--></span><span style="display:block; float:left;"><?php echo getIco($vo);?></span> <?php echo (cnsubstr($vo["borrow_name"],26)); ?>&nbsp; </div>
      <div class="project_left" <?php if(($vo["borrow_status"]) != "2"): ?>style="background:url(/Style/H/images/invest/ymb.jpg) no-repeat right 100px "<?php endif; ?>>
       
        <div class="clear"></div>
        <p> <span class="width1">借款金额</span> <span class="width2">年利率</span> <span class="width3">借款期限</span> </p>
        <ul>
          <li class="bt"><span class="width1"><strong style="color:#f39700">￥<?php echo (getmoneyformt($vo["borrow_money"])); ?></strong>元</span><span class="width2"><strong style="color:#f39700"><?php echo ($vo["borrow_interest_rate"]); ?></strong>&nbsp;%/年&nbsp;</span> <span class="width3">&nbsp;<strong style="color:#f39700"><?php echo ($vo["borrow_duration"]); ?> </strong>
            <?php if($vo["repayment_type"] == 1): ?>天
              <?php else: ?>
              个月<?php endif; ?>
            </span></li>
          <li> <span class="width1">还款方式：<?php echo ($Bconfig['REPAYMENT_TYPE'][$vo['repayment_type']]); ?></span>投标进度：
		  <em class="progress"><em class="precent" style="width:<?php echo ($vo["progress"]); ?>%"></em> </em>&nbsp;<?php echo (intval($vo["progress"])); ?>%
		  </li>
          <li> <span class="width1">借款用途：<?php echo ($gloconf['BORROW_USE'][$vo['borrow_use']]); ?></span><span>抵押率：
            <i style="color:#f35a00; font-style:normal; font-size:18px;"><?php echo ($vo["borrow_mortgage_rate"]); ?>%</i></span>
            <?php if($vo["money_collect"] > 0): ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="width3" style="color:red;"> 待收限制：
              <?php echo (fmoney($vo["money_collect"])); ?>元 </span>
              <?php else: endif; ?>
          </li>
          <li> 
        <?php if($vo["danbao"] == 0): ?><span class="width1">发布时间 : <?php echo (date("Y-m-d H:i",$vo["add_time"])); ?></span><?php else: ?>
        <span class="width1">担保公司 :<a class="newdanbao"  href="/news/<?php echo ($vo["danbao"]); ?>.html"> <?php echo ($vo["title"]); ?></a></span><?php endif; ?><span>剩余时间：<span id="endtime"><span class="red"><span  id="loan_time">-- 天 -- 小时 -- 分 -- 秒</span></span></span></span>

 </li>
        </ul>
      </div>
      
      <div class="project_right" >
        <div class="phc_lcjsj"><a href="/tools/tool.html">理财计算器</a>我要投标</div>
        <form method="get" action="">
          <p class="remain"> <span>您的可用余额：</span> <strong>
            <?php if(session('u_id') ==''): ?>￥0.00元
            <?php else: ?> <?php echo (getmoneyformt($investInfo['account_money']+$investInfo['back_money'])); ?>元<?php endif; ?></strong>
             <?php if(session('hasbind') == 0): ?><a class="fRight icon-gree-link f16 mr20" style="padding:3px 15px;" href="__APP__/member/index/bind" target="_blank">充值</a>
                     <?php else: ?>
                        <a class="fRight icon-gree-link f16 mr20" style="padding:3px 15px;" href="__APP__/member/charge#fragment-1" target="_blank">充值</a><?php endif; ?>   
            

          </p>
          <p class="differ"> 
            <?php if($vo["borrow_status"] > 5): ?>已满标&#12288;&#12288;
			<?php if($hetong == 1): ?><a href="__APP__/home/agreement/downfile?id=<?php echo ($vo["id"]); ?>" target="_blank" class="bot03">借款合同:<img src="__ROOT__/Style/H/images1/pdficon.png"></a><?php endif; ?>
              <?php else: ?>
              满标还差:<?php echo (getmoneyformt($vo["need"])); ?>元<?php if($hetong == 1): ?><a href="__APP__/home/agreement/downfile?id=<?php echo ($vo["id"]); ?>" target="_blank" class="bot03">借款合同:<img src="__ROOT__/Style/H/images1/pdficon.png" style="width:22px;"></a><?php endif; endif; ?>
          </p>
          <p>
            <?php if(session('u_id') ==''): ?><input  value="请先登录" type="text" class="state_text"  onclick="location.href='/member/common/login/'"/>
			<?php elseif($vo["borrow_status"] == 5): ?>
              <input  value="此标已满" type="text" class="state_text" disabled="disabled"/>
            <?php else: ?>
              <input id="input_money"  style="color:#999;" onkeypress="EnterPress(event)" onkeydown="EnterPress()" onkeyup="enter_value(this)" value="请输入投资金额" type="text" class="state_text" onfocus="ZinputFocus(this)" onblur="this.style.color='#333'" /><?php endif; ?> 
         
          <input type="button" class="popTip"  value="红包" id="useTicket" onclick='addred()' title='点击使用红包' /> 
      
              </p>  
              <div class="clear"></div>
          <p id="zwyl" style="padding:9px 0 0 0; color:#f45a00;"><span id='qian'></span></p>
          <p class="info" style="font-weight:normal"></p> 
          <?php if($vo["borrow_status"] == 3): ?><div class="tailttb ptailttb">已流标</div>
            <?php elseif($vo["borrow_status"] == 4): ?>
            <div class="tailttb ptailttb">复审中</div>
            <?php elseif($vo["borrow_status"] == 6): ?>
            <div class="tailttb ptailttb">还款中</div>
            <?php elseif($vo["borrow_status"] == 5): ?>
            <div class="tailttb ptailttb">已流标</div>
            <?php elseif($vo["borrow_status"] > 6): ?>
            <div class="tailttb ptailttb">已完成</div>
            <?php else: ?>
          <p class="money" style="font-size:13px;"><?php if($vo["borrow_max"] != 0): ?><span>
          最多投资金额:<?php echo (($vo["borrow_max"])?($vo["borrow_max"]):"无限制"); ?></span><?php endif; ?>起投金额:<?php echo (fmoney($vo["borrow_min"])); ?> </p> 
        
            <div id="toubiao" class="tailttb"  onclick="invest(<?php echo ($vo["id"]); ?>,<?php echo ($vo["borrow_duration"]); ?>);">立即投标</div><?php endif; ?>
        </form>
      </div>
    </div>
    <div class="clear"></div>

<div class="state_info">
<ul class="state_info_nav" id="state_info_nav">
<li class="active"><a class="invest-tab" href="javascript:void(0)" onclick="showTail('userintro',this);">借款者信息</a></li>
<li class=""><a class="invest-tab current" href="javascript:void(0)" onclick="showTail('picintro',this);">抵押物信息</a></li>
<li class=""><a class="last-invest-tab" href="javascript:void(0)" onclick="showTail('record',this);">投资记录</a></li>
</ul>
<div class="clear"></div>
  
<div class="state_info_con"  id="userintro" style="display:none;">     
<div class="state_info_kk">
<div class="bt-title">银行级别安全审核</div>
<div class="state_tubiao">
<ul>
<?php if(($charge["house"]) == "1"): ?><li><img src="__ROOT__/Style/H/images/invest/tubiao1.jpg" /></li><?php endif; ?>
<?php if(($charge["mortgage"]) == "1"): ?><li><img src="__ROOT__/Style/H/images/invest/tubiao2.jpg" /></li><?php endif; ?>
<?php if(($charge["contract"]) == "1"): ?><li><img src="__ROOT__/Style/H/images/invest/tubiao3.jpg" /></li><?php endif; ?>
<?php if(($charge["credit"]) == "1"): ?><li><img src="__ROOT__/Style/H/images/invest/tubiao4.jpg" /></li><?php endif; ?>
<?php if(($charge["bank"]) == "1"): ?><li><img src="__ROOT__/Style/H/images/invest/tubiao5.jpg" /></li><?php endif; ?>
<?php if(($charge["marriage"]) == "1"): ?><li><img src="__ROOT__/Style/H/images/invest/tubiao6.jpg" /></li><?php endif; ?>
<?php if(($charge["identity"]) == "1"): ?><li><img src="__ROOT__/Style/H/images/invest/tubiao7.jpg" /></li><?php endif; ?>
</ul>
</div>
<div class="clear"></div> 
<table class="table-xq" cellpadding="1" cellspacing="1">
  <tr>
    <td class="bg">项目描述</td>
    <td><?php echo ($charge["description"]); ?></td>
  </tr>
  <tr>
    <td class="bg">借款人信息</td>
    <td>
    <span class="width5">性别：<?php echo (($minfo["sex"])?($minfo["sex"]):"未填写"); ?></span>
<span class="width6">年龄：<?php echo (($minfo["age"])?($minfo["age"]):"0"); ?>岁（<?php echo (getagename($minfo["age"])); ?>）</span>
<span class="width7">学历：<?php echo (($minfo["education"])?($minfo["education"]):"未填写"); ?></span> 
<span class="width8">户籍所在地：<?php echo (($minfo["location"])?($minfo["location"]):"未填写"); ?></span>
</td>
  </tr>
  <tr>
    <td class="bg">还款来源</td>
    <td><?php echo ($charge["source"]); ?>
</td>
  </tr>
  <tr>
    <td class="bg">抵/质押情况</td>
    <td><?php echo ($charge["pledge"]); ?>
</td>
  </tr>
  <tr>
    <td class="bg">风险控制及防范措施</td>
    <td><?php echo ($charge["risk"]); ?>
</td>
  </tr>
</table>
   
    
</div> 
<div class="clear"></div>             

</div>

<div class="state_info_con"  id="picintro" style="display:block;">
<div class="state_info_kk"> 
<div class="bt-title">抵押物图片</div> 
<div id="preview">
                  <div id="spec-n5">
                    <div class="spec-button spec-left" id="spec-left" style="cursor: default;"> 
                      <img id="imgLeft" src="__ROOT__/Style/H/images/left_g.gif"></div>
                    <div id="spec-list" class="bot05">
                      <div class="bot06">
                        <ul class="list-h bot07">
                          <?php $i=0;foreach(unserialize($vo['updata']) as $v){ $i++; ?>
                          <li id="display2"> 
                            <a href="__ROOT__/<?php echo $v['img']; ?>" title="<?php echo $v['info']; ?>" rel="img_group" class="zwimg">
                              <img  title="<?php echo $v['info']; ?>" src="__ROOT__/<?php echo $v['img']; ?>"> 
                            </a> 
                            <span>
                            <span id='change[]'><?php echo $v['info']; ?></span>
                            </span>
                          </li>
                          <?php } ?>
                        </ul>
                      </div>
                    </div>
                    <div class="spec-button" id="spec-right" style="cursor:pointer;"> <img id="imgRight" src="__ROOT__/Style/H/images/invest/scroll_right.png"></div>
                  </div>
                </div>
       
<div class="clear"></div>         
<div class="img_desc_wp">
<ul>
  
<li class="fcz"><a href="javascript:void(0)" class='met_fcz <?php if(in_array('房产证',$bottom)): ?>cur<?php endif; ?>'></a>
<li class="txqz"><a href="javascript:void(0)" class='met_txqz <?php if(in_array('他项权证',$bottom)): ?>cur<?php endif; ?>'></a>
<li class="dyht"><a href="javascript:void(0)" class='met_dyht <?php if(in_array('抵押合同',$bottom)): ?>cur<?php endif; ?>'></a>
<li class="jkrxx"><a href="javascript:void(0)" class='met_jkrxx <?php if(in_array('借款人身份证',$bottom)): ?>cur<?php endif; ?>'></a>
<li class="dyqr"><a href="javascript:void(0)" class='met_dyqr <?php if(in_array('抵押权人身份证',$bottom)): ?>cur<?php endif; ?>'></a>
<li class="qt"><a href="javascript:void(0)" class='met_qt <?php if(in_array('其他',$bottom)): ?>cur<?php endif; ?>'></a>
</li>

</ul>
</div> 

<script type="text/javascript">
								var lilenth = $(".list-h li").length+1;
								$(".list-h").css("width", lilenth * 530);
								var leftpos = 0;
								var leftcount = 0;
				
								$("#imgLeft").attr("src", "__ROOT__/Style/H/images/invest/left_g.png");
								$("#spec-left").css("cursor", "default");
				
								if (lilenth > 1) {
									$(function() {
										$("#spec-right").click(function() { 
											if (leftcount >= 0) {
												$("#imgLeft").attr("src", "__ROOT__/Style/H/images/invest/left_g.png");
												$("#spec-left").css("cursor", "pointer");
											}
											if (lilenth - leftcount < 3) {
												$("#imgRight").attr("src", "__ROOT__/Style/H/images/invest/right_g.png");
												$("#spec-right").css("cursor", "default");
											}
											else {
												leftpos = leftpos - 530;
												leftcount = leftcount + 1;
												$(".list-h").animate({ left: leftpos }, "slow");
												if (lilenth - leftcount < 3) {
													$("#imgRight").attr("src", "__ROOT__/Style/H/images/invest/right_g.png");
													$("#spec-right").css("cursor", "default");
												}
											}
				
										});
									});
				
				
									$(function() {
										$("#spec-left").click(function() {
											if (lilenth - leftcount > 2) {
												$("#imgRight").attr("src", "__ROOT__/Style/H/images/invest/scroll_right.png");
												$("#spec-right").css("cursor", "pointer");
											}
				
											if (leftcount < 1) {
												$("#imgLeft").attr("src", "__ROOT__/Style/H/images/invest/scroll_left.png");
												$("#spec-left").css("cursor", "default");
											}
											else {
												leftpos = leftpos + 530;
												leftcount = leftcount - 1;
												$(".list-h").animate({ left: leftpos }, "slow");
												if (leftcount < 1) {
													$("#imgLeft").attr("src", "__ROOT__/Style/H/images/invest/scroll_left.png");
													$("#spec-left").css("cursor", "default");
												}
											}
				
										}
										)
									})
								}
								else {
									$("#imgRight").attr("src", "__ROOT__/Style/H/images/invest/scroll_right.png");
									$("#spec-right").css("cursor", "default");
								}
								$(function() {
									var width = $("#preview").width();
									$("#spec-list").css("width", 530).css("margin-left", 60);
				
								});
				
								$(function() {
									$("#spec-list a").bind("mouseover", function() {
										$(this).css({
											"border": "1px solid #ccc", 
										});
									}).bind("mouseout", function() {
										$(this).css({
											"border": "1px solid #ccc", 
										});
									});
								})
								</script>
<div class="clear"></div>
</div>      
     

</div>

<div class="state_info_con"  id="record" style="display:none;">
<div class="bidbox">
<table class="bid" cellspacing="0" width="100%">
            <thead>
              <tr class="">
                <th class="" width="148">投标人</th>
                <th class="" width="148">投标类型</th>
                <th class="" width="158">投标金额</th>
                <th class="" width="198">投标时间</th>
              </tr>
            </thead>
            <tbody id="investrecord" class="tender-list">
            </tbody>			
           
          </table>
        </div>
        <div class="totalAmount posa fn-clear" id="totalAmount" style="left: 751px; ">
          <p class="f16">已投标金额</p>
          <p><em class="f24" id="total-money"><?php echo (getmoneyformt($vo["has_borrow"])); ?></em>元</p>
          <p class="f16 mt20">加入人次</p>
          <p><em class="f24" id="total-time"><?php echo (($vo["borrow_times"])?($vo["borrow_times"]):"0"); ?></em>人</p>
        </div>
      </div>
    </div>
  </div>
</div>

<form class="ajax-invest" method="post" name="investForm" id="investForm" action="__URL__/investmoney">
	<input type="hidden" name="borrow_id" id="borrow_id" value="<?php echo ($vo["id"]); ?>" />
	<input type="hidden" name="money" id="money" />
  <input type="hidden" name='redvalue' value='0.00' id='redvalue'/><!-- 红包面值 -->
  <input type='hidden' name='redid' value='0' id='redid'/><!-- 红包id -->  
</form>
<script type="text/javascript">
 borrow_min = <?php echo (($vo["borrow_min"])?($vo["borrow_min"]):0); ?>;
 borrow_max = <?php echo (($vo["borrow_max"])?($vo["borrow_max"]):0); ?>;
</script>

<script type="text/javascript" src="__ROOT__/Style/fancybox/jquery.fancybox-1.3.2.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("a[rel=img_group]").fancybox({
			'transitionIn'		: 'none',
			'transitionOut'		: 'none',
			'titlePosition' 	: 'over',
			'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
				return '<span id="fancybox-title-over">Image ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
			}
		});
  
		ajax_show(1);
		      
	});
       
        
	function ajax_show(p)
	{
	   $.get("__URL__/investRecord?borrow_id=<?php echo ($borrow_id); ?>&p="+p, function(data){
		  $("#investrecord").html(data);
	   });

	   $(".pages a").removeClass('current');
	   $(".pages a").eq(p).addClass("current");
	}

	$(function() {
		$(".borrowlist5").bind("mouseover", function(){
			$(this).css("background", "#c9edff");
		})

		$(".borrowlist5").bind("mouseout", function(){
			$(this).css("background", "#fff");
		})


		$(".borrowlist3").bind("mouseover", function(){
			$(this).css("background", "#c9edff");
		})

		$(".borrowlist3").bind("mouseout", function(){
			$(this).css("background", "#fff");
		})
	});

</script>
<input id="hid" type="hidden" value="<?php echo ($vo["lefttime"]); ?>" />
<script type="text/javascript">
	function showht(){
		var status = '<?php echo ($invid); ?>';
		if(status=="no"){
			$.jBox.tip("您未投此标");
		}else if(status=="login"){
			$.jBox.tip("请先登陆");
		}else{
			window.location.href="__APP__/member/agreement/downfile?id="+status;
		}
	}

	var seconds;
	var pers = <?php echo (($vo["progress"])?($vo["progress"]):0); ?>/100;
	var timer=null;
	function setLeftTime() {
		seconds = parseInt($("#hid").val(), 10);
		timer = setInterval(showSeconds,1000);
	}
	
	function showSeconds() {
		var day1 = Math.floor(seconds / (60 * 60 * 24));
		var hour = Math.floor((seconds - day1 * 24 * 60 * 60) / 3600);
		var minute = Math.floor((seconds - day1 * 24 * 60 * 60 - hour * 3600) / 60);
		var second = Math.floor(seconds - day1 * 24 * 60 * 60 - hour * 3600 - minute * 60);
		if (day1 < 0) {
			clearInterval(timer);
			$("#loan_time").html("投标已经结束！");
		} else if (pers >= 1) {
			clearInterval(timer);
			$("#loan_time").html("投标已经结束！");
		} else {
			$("#loan_time").html(day1 + " 天 " + hour + " 小时 " + minute + " 分 " + second + " 秒");
		}
		seconds--;
	}                
	if (pers >= 1) {
		$("#loan_time").html("投标已经结束！");
	}else{
		setLeftTime();
	}
	$(document).ready(function(){
		if($("#display2").length>0){ 
			$('#display1').show();
		}
						
	});
</script>
<link rel="stylesheet" href="__ROOT__/Style/H/css/cljf.css" />
<div class="footer">
    <div class="foot_box">
 <div class="phc_footerbk">
 <div class="foot_box01">
        	<span>友情链接</span>
            <ul>
			<?php $_result=get_home_friend(1);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vf): $mod = ($i % 2 );++$i;?><li><a href="<?php echo ($vf["link_href"]); ?>" class="xe007" target="_blank" rel="nofollow"><?php echo ($vf["link_txt"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>	
			</ul>
        </div> 
        <div class="foot_box02">
        
			<div class="foot_right">
			 
			</div> 
			<div class="foot_left">
            <span>关于我们</span> 
				<ul>
					<li><a target="_blank" href="__ROOT__/about/intro">公司简介</a></li>
					<li><a target="_blank" href="__ROOT__/cfkt/index.html">官方公告</a></li>
					<li><a target="_blank" href="__ROOT__/about/team">管理团队</a></li>
					<li><a target="_blank" href="__ROOT__/about/org">组织架构</a></li>
					<li><a target="_blank" href="__ROOT__/about/transparent">透明交易</a></li>  
					<li><a target="_blank" href="__ROOT__/about/parter">合作伙伴</a></li>
					<li><a target="_blank" href="__ROOT__/about/invite">招贤纳士</a></li> 
				</ul> 
			</div>
		</div>	
</div> 
<div class="phc_wexin">
<table width="100%">
  <tr>
    <td><span style="font-size:14px">微信服务号</span></td>
    <td><span style="font-size:14px">关注新浪微博</span></td>
  </tr>
  <tr>
    <td><img src="__ROOT__/Style/H/pic/wexin.jpg" title="微信服务号" ></td>
    <td><img src="__ROOT__/Style/H/pic/weibo.jpg" title="关注新浪微博" ></td>
  </tr>
</table> 
</div>
<div class="phc_phonekf">
<span><b><a href="http://www.cailai.com">财来网</a></b>客服免费热线</span>
<div class="clear"></div>
<div class="phc_footer_tel">400-079-8558</div>
<p>(工作时间 9：00-18：00)</p>

<div class="clear"></div>
<br />
<span>官方QQ群</span>
<div class="clear"></div>
<div class="phc_footer_tel">253481952</div>


</div>
<div class="clear"></div>
</div>

<div id="footer_bg">
<div class="foot_box06">Copyright © 2014 上海财来金融信息服务股份有限公司 版权所有 沪ICP备14053618号 
<span>地址：上海市浦东新区世纪大道1090号斯米克大厦622室</span> <!-- <?php echo ($glo["bottom"]); ?>--></div> 
<div class="foot_wlogo">
 
			<img src="__ROOT__/Style/H/pic/xin_w.png" title="财来网荣获中国电子商务协会“诚信网站”认证殊荣">
            <img src="__ROOT__/Style/H/pic/kex.png" title="财来网已通过中网权威数据库对比，获得“互联网金融行业认证”，您可放心使用。">
            <img src="__ROOT__/Style/H/pic/xinlogo.png" title="财来网已经成为中国互联网信用评价中心网络诚信联盟成员，并且完成企业信用评级">
			<img src="__ROOT__/Style/H/pic/norton.png" title="财来网已引入VeriSign SSL加密技术，您的隐私及个人资料安全已受最高级别的保护。">
			<img src="__ROOT__/Style/H/pic/an_icon.png" title="财来网已经完成在公安机关的信息备案，您可了解网站相关备案信息。">
			<img src="__ROOT__/Style/H/pic/icon6.png">
		</div>
</div>		
</div>  
<!--右侧工具箱-->
<div class="toolBar" >
	<a href="javascript:void(0);" onclick="jumpqq()" id="BizQQWPA" class="tbkf"></a>
	<a href="http://weibo.com/cailaiwang" title="关注新浪微博" target="_blank" class="tbewm"></a> 
</div>
 
</body>
</html>

<script>
var _hmt = _hmt || [];
(function() {
  var hm = document.createElement("script");
  hm.src = "//hm.baidu.com/hm.js?22f91ed09d952501310eed8de7761492";
  var s = document.getElementsByTagName("script")[0]; 
  s.parentNode.insertBefore(hm, s);
})();

 function jumpqq(){
         window.open("http://wpa.b.qq.com/cgi/wpa.php?ln=2&uin=4000798558");
    }

</script>


<script language="javascript" src="__ROOT__/Style/H/js/index.js"></script>
<script language="javascript" src="__ROOT__/Style/H/js/borrow.js"></script>
<script>
function invest(id){
	
	var needMoney = <?php echo ($vo["need"]); ?>;
	var password = "<?php echo ($vo["password"]); ?>";
	var num = $('#input_money').val();
	var borrow_max = isNaN(parseInt(<?php echo ($vo["borrow_max"]); ?>))?0:parseInt(<?php echo ($vo["borrow_max"]); ?>);
	var borrow_min = <?php echo ($vo["borrow_min"]); ?>;
	var money = parseInt($("#input_money").val())+parseInt($("#redvalue").val());//加上投资劝金额
	$("#money").val(money);
  var redvalue=$("#redvalue").val();
	
	if(password != ''){
		if(isNaN(num) || num%borrow_min!=0 ||  (borrow_max>0&&num > Math.min(needMoney,borrow_max))){
			$('#input_money').val(borrow_min);
			$('.info').html("<font color='red'>请输入正确投资金额！</font>");
		}else{
			$('.info').html('');
			$.jBox("get:__URL__/ajax_invest?id="+id+"&num="+num, {title: "立即投标"});
		}
	
	}
		var borrow_id = $("#borrow_id").val();
  if(money<borrow_min){
	$.jBox.tip("本标最低投标金额为"+borrow_min+"元，请重新输入投标金额");  
	return false;
  }
  $.ajax({
	  url: "__URL__/investcheck",
	  type: "post",
	  dataType: "json",
	  data: {"money":money,'borrow_id':borrow_id,'redvalue':redvalue},
	  success: function(d) {
			  if (d.status == 1) {
				  investmoney = money;
				  $.jBox.confirm(d.message, "会员投标提示", isinvest, { buttons: { '确认投标': true, '暂不投标': false},top:'40%' });
			  } 
			  else if(d.status == 2)// 无担保贷款多次提醒
			  {
				  var content = '<div class="jbox-custom"><p>'+ d.message +'</p><div class="jbox-custom-button"><span onclick="$.jBox.close()">取消</span><span onclick="ischarge(true)">去充值</span></div></div>';
				  	$.jBox(content, {title:'会员投标提示'});
			  }
			  else if(d.status == 3)// 无担保贷款多次提醒
			  {
				  $.jBox.tip(d.message);
			  }else{
				  $.jBox.tip(d.message);  
			  }
	  }
  });
}
var investmoney = 0;
var borrowidMS = 0;
var borrow_min = 0;
var borrow_max = 0;

function PostData(id,money) {
  var pin = $("#pin").val();
  var borrow_pass = (typeof $("#borrow_pass").val()=="undefined")?"":$("#borrow_pass").val();
  var borrow_id = $("#borrow_id").val();
  if(pin==""){
	$.jBox.tip("请输入支付密码");  
	return false;
  }
  if(money<borrow_min){
	$.jBox.tip("本标最低投标金额为"+borrow_min+"元，请重新输入投标金额");  
	return false;
  }
  $.ajax({
	  url: "__URL__/investcheck",
	  type: "post",
	  dataType: "json",
	  data: {"money":money,'pin':pin,'borrow_id':borrow_id,"borrow_pass":borrow_pass,'redvalue':redvalue},
	  success: function(d) {
			  if (d.status == 1) {
				  investmoney = money;
				  $.jBox.confirm(d.message, "会员投标提示", isinvest, { buttons: { '确认投标': true, '暂不投标': false},top:'40%' });
			  }
			 
			  else if(d.status == 2)// 无担保贷款多次提醒
			  {
				  var content = '<div class="jbox-custom"><p>'+ d.message +'</p><div class="jbox-custom-button"><span onclick="$.jBox.close()">取消</span><span onclick="ischarge(true)">去充值</span></div></div>';
				  	$.jBox(content, {title:'会员投标提示'});
			  }
			  else if(d.status == 3)// 无担保贷款多次提醒
			  {
				  $.jBox.tip(d.message);
			  }else{
				  $.jBox.tip(d.message);  
			  }
	  }
  });
}
 
      function ZinputFocus(zwinput){
                zwinput.value = ""; 
                zwinput.style.color='#333'
                $("#zwyl").html("");
      }

//投资金额
	$('#input_money').blur(function(){

       BlurMoney();
    });
       
	function BlurMoney() {
		var pat =  /^\d+$/;
		var str = $('#input_money').val();
		if (str == "") {
                        $("#zwyl").html("");
			$('.info').html("<font style='color:#f35900'>输入的金额不能为空！</font>");
			return false;
		}
    $("#redvalue").val(0);
		var needMoney = <?php echo ($vo["need"]); ?>;
		var borrow_max = isNaN(parseInt(<?php echo ($vo["borrow_max"]); ?>))?0:parseInt(<?php echo ($vo["borrow_max"]); ?>);
		var borrow_min = <?php echo ($vo["borrow_min"]); ?>;
		if(str>needMoney){
			$('#input_money').val('请输入投资金额');
			$('.info').html("<font style='color:red'>投资金额不能大于所借金额</font>");
                        $("#zwyl").html("");
		}else if(str<borrow_min){
			$('#input_money').val('请输入投资金额');
			$('.info').html("<font style='color:red'>投资金额不能小于起投金额</font>");
                        $("#zwyl").html("");
		}else if(str>borrow_max && borrow_max!=0 && str<=needMoney){
			$('#input_money').val('请输入投资金额');
			$('.info').html("<font style='color:red'>投资金额不能大于最大金额限制</font>");
                        $("#zwyl").html("");
		}else{
			$('#input_money').val(str);
			$('.info').html("");
                       
		}


		// if(parseInt(str)%parseInt(borrow_min)){
		// 	$('.info').html("<font style='color:red'>请填写起投金额的整数倍</font>");
		// 	$('#input_money').val('请输入投资金额');
  //                       $("#zwyl").html("");
		// 	return false;
		// }else{
		// 	$('#input_money').val(str);
		// 	$('.info').html("");
		// }
	}
	// 提交支付当前要投标表单
	function isinvest(d){

	if(d===true) document.forms.investForm.submit();
	}	
	// 充值
	function ischarge(d){
	if(d===true) location.href='/member/charge#fragment-1';
	}	
	// 新风格
        var znll = "<?php echo ($vo["borrow_interest_rate"]); ?>";    
        var zjkqx = "<?php echo ($vo["borrow_duration"]); ?>";
	function enter_value(owner){
        
		var num = owner.value,re=/^\d*$/;
                var zghdlx = parseFloat(znll)/(100*12)*parseFloat(zjkqx)*num;
			if(!re.test(num)){
			 isNaN(parseInt(num))?owner.value=<?php echo ($vo["borrow_min"]); ?>:owner.value=parseInt(num);
			}else{
                            if(num <= parseFloat("<?php echo ($vo["need"]); ?>")){
                                 $("#zwyl").html("还款完成后收益：<font style='color:red'>"+zghdlx.toFixed(2)+"</font>元");
                            }else{
                                $("#zwyl").html("此次投标只能投<font style='color:red'><?php echo (getmoneyformt($vo["need"])); ?></font>元");
                            }
                           
                        }
                      
                     
            
	}
        function EnterPress(e){ //传入 event 
            var e = e || window.event; 
            if(e.keyCode == 13){ 
              if(e && e.preventDefault){  
                    e.preventDefault();  
                }  
                //IE中组织浏览器行为  
                else{  
                    window.event.returnValue=false; 
                    window.event.cancelBubble = true;
                }  

             $('#toubiao').click();
            return false;
            } 
        } 
</script>
 

       <!-- 现金券的使用 -->
          <script type='text/javascript'>
          //确定使用哪个红包
           function jfun_red() {
            //红包的id 放进一个数组
            var redid=new Array();
             $("input[name^=redpacket]:checked").each(function(){
                redid.push($(this).val());
             });
            //红包的总值
             var redvalue=0;
            $("input[name^=redpacket]:checked").each(function(){
                  redvalue+=parseInt($(this).attr('face-value'));
             });
             //红包id
             $("#redid").val(redid);
             //提示语
             $("#qian").html('已使用现金券:'+redvalue+'元');
             //红包面值
             $("#redvalue").val(redvalue);

             //$.jBox.tip("数据处理中......", "loading");
             var redvalue= $("#redvalue").val();
            if(redvalue!=0)
            {
             $.jBox.tip("已选择面值"+redvalue+'元现金券', "success");
            }
             $.jBox.close(true);

                     //获取千分之10% 1%
              var str = $('#input_money').val();
              var redvalue=$("#redvalue").val();

              if((str/10)<redvalue)
              {
                $('.info').html("<font style='color:red'>红包总额不能超过所投资金额的10%</font>");
                $("#zwyl").html("");
                $("#redid").val("");
                 $("#redvalue").val('0.00');
                return false;
              }

           }

          function addred()
           {
            var im=$("#input_money").val();
            if(im>=100)
              {
                $.jBox("get:__URL__/redpacket/",{title:"我的现金券",buttons:{'就这个了': 'jfun_red()','关闭': true},width:500,height:400});
              }else{
                $.jBox.tip("只有投资金额大于100元才允许使用代金券（红包）", "error");
              }
           }
          </script>