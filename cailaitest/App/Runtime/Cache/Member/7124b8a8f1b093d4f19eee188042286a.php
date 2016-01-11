<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


<link rel="stylesheet" type="text/css" href="__ROOT__/Style/H/css/css.css" />
<link rel="stylesheet" type="text/css" href="__ROOT__/Style/H/css/home.css" />
<link type="text/css" rel="stylesheet" href="__ROOT__/Style/JBox/Skins/Currently/jbox.css"/>
<link href="__ROOT__/Style/H/css/Mbmber.css?v=20150309" rel="stylesheet" type="text/css" /> 
<link href="__ROOT__/Style/H1/css/sf_style.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="__ROOT__/Style/H/css/index.css" />
<link rel="stylesheet" type="text/css" href="__ROOT__/Style/H/css/kefu.css" />
<link rel="stylesheet" type="text/css" href="__ROOT__/Style/H/css/style.css" />
<script language=javascript type="text/javascript" src="__ROOT__/Style/Js/jquery.js"></script>
<script language=javascript src="__ROOT__/Style/JBox/jquery.jBox.min.js" type=text/javascript></script>
<script language=javascript src="__ROOT__/Style/JBox/jquery.jBoxConfig.js" type=text/javascript></script>
<script type="text/javascript" src="__ROOT__/Style/Js/ui.core.js"></script>
<script type="text/javascript" src="__ROOT__/Style/Js/ui.tabs.js"></script>
<script type="text/javascript" src="__ROOT__/Style/My97DatePicker/WdatePicker.js" language="javascript"></script>
<script language="javaScript" type="text/javascript" src="__ROOT__/Style/H/js/backtotop.js"></script>
<script type="text/javascript" src="__ROOT__/Style/Js/utils.js"></script>
<script type="text/javascript">
	function makevar(v){
		var d={};
		for(i in v){
			var id = v[i];
			d[id] = $("#"+id).val();
			if(!d[id]) d[id] = $("input[name='"+id+"']:checked").val();
		}
		return d;
	}

	function ajaxGetData(url,targetid,data){
			if(!url) return;
			data = data||{};
			var thtml = '<div class="loding"><img src="__ROOT__/Style/Js/006.gif"align="absmiddle" />　信息正在加载中...,如长时间未加载完成，请刷新页面</div>';
			$("#"+targetid).html(thtml).show();
			
			$.ajax({
				url: url,
				data: data,
				timeout: 10000,
				cache: true,
				type: "get",
				dataType: "json",
				success: function (d, s, r) {
					if(d) $("#"+targetid).html(d.html);
				},
				error: '',
				complete: ''
			});
		
	}
	var currentUrl = window.location.href.toLowerCase();
	$(document).ready(function() {
		$('#rotate > ul').tabs();/* 第一个TAB渐隐渐现（{ fx: { opacity: 'toggle' } }），第二个TAB是变换时间（'rotate', 2000） */
		$('.dv_r_6 li a').click(function() { // 绑定单击事件
			var nowurl = $(this).attr('href');
			var vid = nowurl.split("#");
			try{
				if(currentUrl.indexOf(vid[0]) != -1 ){
					$('#rotate > ul').tabs('select', "#"+vid[1]); // 切换到第三个选项卡标签
					var geturl= $('#rotate > ul li a [href="#'+vid[1]+'"]').attr("ajax_href");
					ajaxGetData(geturl,vid[1]);
					return false;
				}
			}catch(ex){};
				return true;
		});
		
		$('.ajaxdata a').click(function(){
			var geturl = $(this).attr('ajax_href');
			var hasget = $(this).attr('get')||0;
			var nowurl = $(this).attr('href');
			console.log(geturl,nowurl);
			var vid = nowurl.split("#");
			if(hasget!=1) ajaxGetData(geturl,vid[1]);
			$(this).attr('get','1');
			$('html,body').animate({scorllTop:0},1000);
			return false;
		})
	});
	//ui
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
        $(function() {
            $(".dv_r_6 li,.dv_r_5 li").mousemove(function() {
                $(this).addClass("current");
            }).mouseout(function() {
                $(this).removeClass("current");
            });
        });
</script>

<title>我的账户-- <?php echo ($glo["web_name"]); ?></title>
<!--<?php echo ($uclogin); ?>-->
<link rel="stylesheet" type="text/css" href="__ROOT__/Style/JQtip/tip-yellowsimple/tip-yellowsimple.css" />
<script language="javascript" src="__ROOT__/Style/JQtip/jquery.poshytip.js" type="text/javascript"></script>
<!-- 图表的js -->
<!-- <script type="text/javascript" src="__ROOT__/Style/H/js/jscharts_mb.js" type="text/javascript"></script> -->

<script type="text/javascript">
	function displayDiv(num) {
		var obj = document.getElementById("udiv" + num);
		var obja = document.getElementById("ulink" + num);
		var objtop = document.getElementById("utop" + num);
		var objbottom = document.getElementById("ubottom" + num);

		if (obj.style.display == 'none') {
			objbottom.style.display = '';
			obj.style.display = '';
			objtop.style.backgroundImage = "url(__ROOT__/Style/M/images/account/uctop.jpg)";
			obja.innerHTML = "-";
		}
		else {
			obj.style.display = 'none';
			objbottom.style.display = 'none';
			objtop.style.backgroundImage = "url(__ROOT__/Style/M/images/account/ucall.jpg)";
			obja.innerHTML = "+";
		}
	}
	
	$(function(){
	$('.xtitle').poshytip({
		className: 'tip-yellowsimple',
		showOn: 'hover',
		alignTo: 'target',
		alignX: 'center',
		alignY: 'top',
		offsetX: 0,
		offsetY: 5
	});
});
</script> 
<style type="text/css">

.dw_2_show #fragment-3{ font-size:14px; width:725px;}
.fontred { color: #005B9F; }
.infolist { margin: 5px 0 10px 20px; border: solid 1px #ddd; padding: 2px; width: 715px; text-align: left; }
.infolist table td { height: 28px; }
.infolist .myfont { color: #ff6500; font-weight: bold; }
#pager a.current { background-color: #ddd; border: solid 1px #ccc; color: #fff; }
#pager a:hover { background-color: #ddd; border: solid 1px #ccc; color: red; }
.tdHeard, .tdContent { border: solid 1px #ccc; font-size:14px; }
.tdContent a { text-decoration: underline; }
.tdHeard { background-image: url(__ROOT__/Style/H/images/thbg.jpg); height: 29px; font-weight:normal; }
.divtitle { height: 20px; line-height: 30px; text-align: left; padding-left: 20px; font-size: 8px; text-indent: 25px; margin-top: 8px; margin-bottom: 1PX; }
#noinfotip .tdContent{width:auto}
.tdContent a{color:#03F; text-decoration:none}
 
</style>
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


<!--中部开始-->
<div class="Cmm" > 
<style type="text/css">
  .ok{
  color: #fff;
  background: #f39800;
  border: 1px solid red;
  }
</style>
<div class="user_list" > 
  <a class="dw_top" href="/member" style="border-top:1px solid #e5e5e5;">帐户总览</a>
  <?php if($hasbind == 0): ?><a class="dw_top" onclick="" href="<?php if($userType == 2): ?>/member/index/corpbind<?php else: ?>/member/index/bind<?php endif; ?>" style="background: #f39800; color: #fff;">开通汇付宝</a><?php endif; ?>
<div id="dw_m_left">
<div class="dv_r_5" > <a class="bt3"><span></span>资金管理</a> </div>
<div class="dw_navlist">
      <ul>
        <li><a href="__APP__/member/capital#fragment-2">资金明细</a></li> 
		<?php if($hasbind == 0): ?><li><a href="/member/index/bind">我要充值</a></li><?php else: ?><li><a href="__APP__/member/charge#fragment-1">我要充值</a></li><?php endif; ?> 
		<?php if($hasbind == 0): ?><li><a href="/member/index/bind">我要提现</a></li><?php else: ?><li><a href="__APP__/member/withdraw#fragment-1">我要提现</a></li><?php endif; ?>  
        <li><a href="__APP__/member/zwbank#fragment-1">银行帐户</a></li> 
      </ul>
    </div>   
    
<div class="dv_r_5"> <a class="bt4"><span></span>投资管理</a> </div>
<div class="dw_navlist">
<ul>
<li><a href="__APP__/member/tendout#fragment-3">散标投资</a></li> 
<li  class="last"><a href="__APP__/member/debt#fragment-1">债权转让</a></li> 
 
  </ul>
    </div>
    
    <div class="dv_r_5" > <a class="bt2"><span></span>借款管理</a> </div>
    <div class="dw_navlist">
      <ul>
        <li><a href="__APP__/member/borrowin#fragment-3">借款总表</a></li> 
        <!-- <li class="last"><a href="__APP__/member/huankuan#fragment-1">还款安排</a></li> -->
        <!-- 20150804 先注释掉 -->
      </ul>
    </div>
    
    <div class="dv_r_5" > <a class="bt6"><span></span>基本设置</a> </div>
    <div class="dw_navlist">
      <ul>
        <li><a href="__APP__/member/memberinfo#fragment-1">基本资料</a></li> 
        <li><a href="__APP__/member/verify?id=1#fragment-1">安全中心</a></li>
        <?php if($loginconfig['qq']['enable'] == '0' and $loginconfig['sina']['enable'] == '0'): ?><li class="last"><a href="__APP__/member/msg#fragment-1">系统消息</a></li>
          <?php else: ?>
          <li><a href="__APP__/member/msg#fragment-1">系统消息</a></li> 
        <li><a href="__APP__/member/user#fragment-1">我的头像</a></li><?php endif; ?>
      </ul>
    </div>
    
    <div class="dv_r_5 " > <a class="bt7"><span></span>我的奖励</a> </div>
    <div class="dw_navlist">
      <ul>
     <!--    <li><a href="/member/promotion#fragment-1">邀请好友</a></li>  -->
       <div class="dw_menulist">
        <li class="last"><a href="/member/bonus#fragment-3">推广明细</a></li>
		    <li class="last"><a href="/member/bonus#fragment-2">奖金记录</a></li>
      </ul>
    </div>
    <!-- 邀请好友 -->
   <div class="dw_menulist"><a href="__APP__/member/promotion/promotion/">邀请好友</a></div>
   <div class="dw_menulist"><a href="__APP__/member/promotion/myticket/">我的红包</a></div>
 
  </div>
 </div>
<script type="text/javascript">

dw_solid = function(a, b, c) {
  var a1 = $(a).children(),//dw_list
    b1 = $(a).children(b),
    c1 = $(a).children(c),
    lh = location.href;
  lh = lh.split(location.host)[1];
  c1.hide();
  lh == "/member/verify?id=1#fragment-3" && a1.eq(1).show();

  b1.each(function() {
    var next = $(this).next(),
      index = next.index(),
      sp = $('span', this),
      sibp = $('span', $(this).siblings(b)),
      aa = $('a', next);
    aa.each(function() {
      var ah = $(this).attr('href');
      if (lh == ah) {
        a1.eq(index).show();
        sp.addClass('on');
      }
    });

    $(this).click(function() {
      sp.toggleClass('on');
      sibp.removeClass('on');
      next.slideToggle().siblings(c).slideUp();
    })
  });

}
dw_solid("#dw_m_left", ".dv_r_5", ".dw_navlist");
$(window).load(function() {
  $('body,html').animate({
    scrollTop: 0
  }, 1);
});

$(".dw_navlist").each(function() {
  this.style.display = 'block';
});



</script>


<div id="hy_right" style="position:relative;"> 
<?php if($hasbind == 0): ?><div id="popbanner"><div class="popclose"></div><div class="clear"></div></div><div class="popbg"></div><?php endif; ?>   
 
<div class="dw_list">
<div class="dw_top"> 
<div class="touxiang"> <a href="__APP__/member/user#fragment-1" title="点击进行头像更换"> <img style="width:98px; height:98px;"  alt="点击进行头像更换" src="<?php echo (get_avatar($UID)); ?>"  /></a> </div>    
<div class="heng1"> <span><?php
$h=date('G'); if ($h<11) echo '早上好'; else if ($h<13) echo '中午好'; else if ($h<17) echo '下午好'; else echo '晚上好'; ?> , <font color="#f35a00"><?php if(!empty($_SESSION['real_name'])){echo $_SESSION['real_name']; }else{ echo $_SESSION['u_user_name'];} ?></font> ! </span> 
<a target="_blank" href="/member/index/tuoguanlogin" id="login" style="color:#666; font-size:16px;">[登录汇付宝]</a></div>

<div class="gradearea">
<span class="grade">
<i class="icon_planner" <?php if(($vip["id_status"]) == "1"): ?>style="background-position:-36px 0px"<?php endif; ?>  data-type="普通"></i> 
<i class="icon_realed" <?php if(($bank["bank_num"]) != "null"): ?>style="background-position:-108px 0px"<?php endif; ?>></i> 
<i class="icon_bindcard" <?php if(($vip["email_status"]) == "1"): ?>style="background-position:-180px 0px"<?php endif; ?>></i>
<i class="icon_bindcarded" <?php if(($vip["safequestion_status"]) == "1"): ?>style="background-position:-252px 0px"<?php endif; ?>></i>
</span> 

<span class="security_level">安全等级：<span>低</span> </span>
<span class="balancearea">注册时间： <span class="g-fr last_time"><?php echo (date('Y-m-d H:i:s',$minfo["reg_time"])); ?></span></span>                           
</div>
</div>
<div class="as_info">
<ul>
<li>资产总额：<span> <?php echo (fmoney($minfo['account_money']+$minfo['back_money']+$minfo['money_collect']+$minfo['money_freeze'])); ?></span></li>
<li>
可用余额：
<span><?php echo (fmoney($minfo['account_money']+$minfo['back_money'])); ?></span>
</li>
<li>
冻结总额：
<span>
  <?php echo (fmoney($minfo['money_freeze'])); ?>
</span>
</li>
<li>
待收总额：
<span><?php echo (fmoney($minfo['money_collect'])); ?></span>
</li>
<li>
待收本金：
<span><?php echo (fmoney($minfo['money_collect']-$benefit['interest_collection'])); ?></span> 
</li>
<li>
待收利息：
<span><?php echo (fmoney($benefit['interest_collection'])); ?></span>
</li>
</ul>
</div>
<div class="dw_p2" style="margin-top:18px;"> 
<?php if($hasbind == 0): ?><a href="/member/index/bind" class="dw_cz" title="充值" > 充值 </a>
<?php else: ?><a href="__APP__/member/charge#fragment-1" class="dw_cz" title="充值" > 充值 </a><?php endif; ?> 
<?php if($hasbind == 0): ?><a href="/member/index/bind"  class="dw_tixian"  title="提现"> 提现</a> 
<?php else: ?><a href="__APP__/member/withdraw#fragment-1"  class="dw_tixian"  title="提现"> 提现</a><?php endif; ?> 
<?php if($hasbind == 0): ?><a href="/invest/index"  class="dw_tz"  title="马上投资"> 马上投资 </a> 
<?php else: ?><a href="/invest/index"  class="dw_tz"  title="马上投资"> 马上投资</a><?php endif; ?> 
<a href="__APP__/member/promotion/promotion/" class="dw_yqhy"  title="邀请有奖"> 邀请有奖</a> 
</if>
</div>
</div> 
<div class="dw_list">
<div class="til-lr"><strong class="l">投资走势</strong><strong class="r">收款计划</strong></div>
<!-- 判断千万百元 -->
<input type='hidden' value='<?php echo ($char); ?>' id='char'/>

<div id="container" class="inv_charts"  style="width:450px; height: 250px; margin: 0 0;">your browser doesn't support the highcharts.</div>
<!-- <div class="inv_charts" id="chart_container" style='width:450px;'>your browser doesn't support the jscharts.</div>  -->
 
<!-- 由于jschart 不支持IE 所以更换higcharts -->
<script type="text/javascript">
var my = <?php echo ($arr); ?>;
var c=$("#char").val();//y轴的文字
$(function () {

    $('#container').highcharts({
          chart: {
                type: 'line',
                marginBottom:20,
                marginLeft:60,
        },
        navigation: {
            buttonOptions: {
                enabled: false
            }
        },//取消打印效果
        title: {
            text: '投资曲线图',
            x: -10 //center
        },
      
        colors:['#EA8245'], //设置线条颜色   
        credits: {
                text: '',
                //href: 'http://www.example.com'
            },   
        xAxis: {
            lineColor: '#EA8245',
            lineWidth: 1,
            categories: ['1', '2', '3', '4', '5', '6',
                '7', '8', '9', '10', '11', '12']
        },
        yAxis: {
            title: {
                text: c,
            },
            lineColor: '#EA8245',
            lineWidth: 1,
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: c
        },
        series: [{
            name: '月份',
            data: my//这个my是后台传输的数据
                }]
    });

});
        </script>
    </head>
    <body>
<script src="__ROOT__/Style/H/js/highcharts.js"></script>
<script src="__ROOT__/Style/H/js/exporting.js"></script>

<!-- 日期时间插件 -->
<script type="text/javascript" src="__ROOT__/Style/H/css/calendar/js/kalendar.js" ></script>
<link type="text/css"  rel="stylesheet" href="__ROOT__/Style/H/css/calendar/css/kalendar.css" ></link>
<div class="total-data" style='width:280px;'>
<div id='wrap' style="text-align:center;font:normal 14px/24px 'MicroSoft YaHei';">
  <!-- 因为日历初始显示的内容要根据js获得的日期-时间来确定，所以html中不写，在js中用另一种形式添加 -->
</div>

  <div class="list">
      <div  id='jj' style='display:none'>
         <a >预期收益&nbsp;&yen;<font color="#F45A00" id='tip'></font>元</a>
      </div>
  </div> <!-- list -->
<script type='text/javascript'>

    $(function(){
    var ali=<?php echo ($ali); ?>;
    console.log(ali);
    //这里为日期
    var y=ali.map(function(n){
      return n.substring(2,4);//从第二位开始截取到第四位 下标从1开始
    });
    //这里为收益
     var z=ali.map(function(n){
      return n.substring(5);
    });
    var x=z.map(function(v,k){
       return [y[k],v];;
      });

      for(var i in x)
      {
           var bbQ=x[i][1];
        $("#"+parseInt(x[i][0])).attr('data-amount',bbQ);
      }

      $("#day ul li").each(function(){
        var ea=$(this).attr('data-amount');
        var html=$(this).html();
        if(ea!=undefined)
        {       $(this).addClass('active');
              //解决 当天 有收款事件无法区别
                if($(this).hasClass('today'))
                {
                  $(this).css('color',"#f9f9f9");
                }
                $(this).mouseover(function(){
                $("#tip").html(ea);
                $("#jj").show().addClass(tip);
            }).mouseout(function(){
               $("#jj").hide();
            })
        }else{
            $(this).mouseover(function(){
                $("#jj").hide();
                //屏蔽空元素li出现mouseFloat样式
                if(!html)
                {
                  if($(this).hasClass('mouseFloat'))
                  {
                    $(this).removeClass('mouseFloat');
                  }
                }
            })
        }
      })

    })


</script>
</div><!-- total-data -->
</div><!-- eof dw_list -->

<div class="dw_list">
<div class="til-lr"><strong class="l">推荐项目</strong></div>
<div class="related_items">
<table width="765px" cellspadding="0" cellpadding="0" border="0">
<thead>
<tr>
<th width="28%">项目名称</th>
<th width="14%">项目金额（元）</th>
<th width="10%">年化收益率</th>
<th width="11%">项目期限</th>
<th width="16%">还款方式</th>
<th width="11%">操作</th>
</tr>
</thead>
<tbody> 
<!-- 循环结束 -->
<?php if(is_array($listBorrow["list"])): $i = 0; $__LIST__ = $listBorrow["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vb): $mod = ($i % 2 );++$i;?><tr>
<td> <?php echo getIco($vb);?><a href="<?php echo (getinvesturl($vb["id"])); ?>"title="<?php echo ($vb["borrow_name"]); ?>"><?php echo (cnsubstr($vb["borrow_name"],11)); ?></a></td> 
<td><?php echo (getmoneyformt($vb["borrow_money"])); ?></td>
<td><span><?php echo ($vb["borrow_interest_rate"]); ?></span>%</td>
<td>
            <?php if($vb['repayment_type'] == 1): echo ($vb["borrow_duration"]); ?>天
            <?php else: ?>
              <?php echo ($vb["borrow_duration"]); ?>个<?php endif; ?>
</td>
<td><?php echo ($vb["repayment_type"]); ?></td>
<td><a target="_blank" href="<?php echo (getinvesturl($vb["id"])); ?>" class="buy">加入</a></td>  
</tr><?php endforeach; endif; else: echo "" ;endif; ?>
<!-- 循环结束 -->
</tbody>
</table>
</div>
</div>
   
   

</div>
  <div style="clear:both"></div>
  <script type="text/javascript">
  $('#dwtipkff').click(function(){
  $(this).parent().hide();
  });
function huandong(a){
    var a1=$(a).children('ul').children();
    var a2=$(a).children('div').children();

    a1.click(function(){
    var index=$(this).index();
    $(this).addClass('on').siblings().removeClass("on");
    a2.hide().eq(index).show();
    if(index==2){
    var x={};
        $.ajax({
                url: "__URL__/zwtendbacking",
                data: x,
                timeout: 5000,
                cache: false,
                type: "get",
                dataType: "json",
                success: function (d, s, r) {

                    if(d) $("#fragment-3").html(d.html);//更新客户端 作个判断，避免报错

                }
            });
    
}
    if(index==3){
        var x={};
            $.ajax({
                    url: "__URL__/zwborrowpaying",
                    data: x,
                    timeout: 5000,
                    cache: false,
                    type: "get",
                    dataType: "json",
                    success: function (d, s, r) {
                        if(d) $("#fragment-4").html(d.html);//更新客户端 作个判断，避免报错

                    }
                });
    }

});
}
huandong('#dw_huadong');
function jfun_dogetpaypass(){
	var ux = $("#payemailname").val();
	if(ux==""){
		$.jBox.tip('请输入用户名或者邮箱','tip');
		return;
	}
	$.jBox.tip("邮件发送中......","loading");
	$.ajax({
		url: "__URL__/dogetpaypass",
		data: {"u":ux},
		//timeout: 5000,
		cache: false,
		type: "post",
		dataType: "json",
		success: function (d, s, r) {
			if(d){
				if(d.status==1){
					$.jBox.tip("发送成功，请去邮箱查收",'success');
					$.jBox.close(true);
				}else{
					$.jBox.tip("发送失败，请重试",'fail');
				}
			}
		}
	});

}

function getpaypassword() {
	$.jBox("get:__URL__/getpaypassword", {
		title: "找回支付密码",
		width: "auto",
		buttons: {'发送邮件':'jfun_dogetpaypass()','关闭': true }
	});   
}

$("#duizhang").click(function()
{
	$.ajax({
	type: "POST",
	url: "/member/index/duizhang",
	success: function(res){
		if(res==1)
		{
			window.location.href=window.location.href;
		}
	}
	});
})
</script>
</div> 
<style>
#popbanner{width:730px;height:109px;position: absolute;left: 42%;
		top: 30%;
		margin-top: -190px;
		margin-left: -355px;
		background: url(/UF/pop.png) no-repeat;
		z-index: 99999;
		display: none;
	}
	.popbg{
		background: #333;
		top: 0;
		left: 0;
		width: 100%;
		height: 100%;

		position: fixed;
		z-index: 9999;
		filter:alpha(opacity=40);
		-moz-opacity:0.4;
		opacity:0.4;
		display: none;
	}
	.popclose{
		width: 40px;
		height: 40px;
		float: right;
		cursor: pointer;
                position:absolute;
                top:0;
                left:95%;
	}
	.clear{
		clear: both;
	}
</style>


<script>
	function getCookie(c_name) {
		return "";
	}

	var popbg = $('.popbg');
	var popbanner = $('#popbanner');
	var popclose = $('.popclose');

	// ;//设置弹出
	if(getCookie('homepophide') == '') {
		// ;//设置背景层
		popbg.css({'width':$(window).width(),'height':$(document).height()}).show();
		popbanner.fadeIn();
	}

	// 关闭效果
	popclose.click(function(){
		popbg.hide();
		popbanner.hide();
		//setCookie('homepophide', 1, 30);
	})
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