<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>我要借款-<?php echo ($glo["web_name"]); ?></title>
<meta name="keywords" content="<?php echo ($glo["web_keywords"]); ?>" />
<meta name="description" content="<?php echo ($glo["web_descript"]); ?>" />
<meta property="wb:webmaster" content="37afd1196b6d28b7" />
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

<link href="__ROOT__/Style/H/css/cljf.css" rel="stylesheet" type="text/css" />
<style>
.phc_shenqing{ width:80%; padding:20px 20px 20px 36px; font-size:16px; height:auto; line-height:44px; font-family:"Microsoft YaHei",Arial,Helvetica,sans-serif;}
.phc_shenqing span{ font-size:18px; font-weight:normal;}
.img_center{ margin:10px auto; display:block; text-align:center;} 
</style>

<div class="bodyer">
<div class="zhiying borrowZhiying">
<div class="zybox">
<div class="yuebox diy" >
<div class="phc_dy">发布抵押标</div>
<div class="phc_shenqing">
<span>申请条件: </span> 20-55周岁的中国公民、有固定工作、有稳定收入 <br />
<span>必要申请资料: </span> 二代身份证、个人信用报告、无法院诉讼信息定收入 
</div>
 
</div>

</div>
</div>
<div class="jiek_box">
<div class="jiek_top">借款流程</div>
<img src="__ROOT__/Style/H/pic/jiekuanliucheng.jpg" class="img_center"> 
<div class="clear"></div>  
<a href="__ROOT__/borrow/post/mortgage.html" class="jiek_btn">申请借款</a>   
</div>
    
<div class="tis_box">
		温馨提示：以下描述适用于所有借款产品。
	</div>
	<div class="jiek_box">
		<div class="jiek_top">借款方式</div>
		<div class="JK_box">
			<dl>
				<dt>借款额度：</dt>
				<dd>10,000-1000,000</dd>
			</dl>
			<dl>
				<dt>借款年利率：</dt>
				<dd>10%-24%<img src="__ROOT__/Style/H/pic/jisuanqi.png"></dd>
			</dl>
			<dl>
				<dt>借款期限：</dt>
				<dd>3、6、9、12、18、24、36个月</dd>
			</dl>
			<dl>
				<dt>审核时间：</dt>
				<dd>1-3个工作日</dd>
			</dl>
			<dl>
				<dt>还款方式：</dt>
				<dd>>先息后本，等额本息，一次性还款</dd>
			</dl>
		</div>
	</div>
	<div class="jiek_box" style="margin-bottom:25px;">
		<div class="jiek_top">费用说明</div>
		<div class="JK_box JK_box1"> 
			<h5>每月还款额</h5>
			<p>本金及利息支付给投资人</p>
			<p>借款管理费由财来网收取</p>
		</div>
	</div>
</div>


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