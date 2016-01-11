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
<div class="wrap2">
	<div id="hy_left">
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

	</div>
	<div id="hy_right">
            <div class="box">
				<div class="Menubox1" id="rotate">
					<ul class="menu ajaxdata">
						<li><a href="#fragment-1" ajax_href="__URL__/charge/">账户充值</a></li>
 						<li><a href="#fragment-2" ajax_href="__URL__/chargelog/">充值记录</a></li>
					</ul>
				</div> 
				<div class="contentright">
					<div id="fragment-1" style="display:none">
						<!--充值总表-->
					</div>
					<div id="fragment-2" style="display:none">
						<!--借记卡充值-->
					</div>
					<div id="fragment-3" style="display:none">
						<!--线下充值-->
					</div>
				</div>
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