<?php if (!defined('THINK_PATH')) exit();?> <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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

<link rel="stylesheet" href="__ROOT__/Style/H/css/cljf.css?v=20150609" />
<script  type="text/javascript" src="__ROOT__/Style/H/js/backtotop.js"></script>
<script  type="text/javascript" src="__ROOT__/Style/H/js/index.js"></script>
<!-- 视频 -->
  <link href="__ROOT__/Style/H/css/video-js.css" rel="stylesheet" type="text/css">
  <!-- video.js must be in the <head> for older IEs to work. -->
  <script src="__ROOT__/Style/H/js/video.js"></script>

  <script>
    videojs.options.flash.swf = "video-js.swf";
  </script>
<!-- 视频 -->

<script type="text/javascript" src="__ROOT__/Style/H/js/common.js" language="javascript"></script>
<script type="text/javascript" src="__ROOT__/Style/H/js/jquery.kinMaxShow-1.0.min.js"></script>
<link rel="stylesheet" href="__ROOT__/Style/H/css/jquery.bxslider.css" />
<script  type="text/javascript" src="__ROOT__/Style/H/js/jquery.bxslider.js"></script>  
<script type="text/javascript">
var Transfer_invest_url = "__APP__/tinvest"; 
</script>
<script type="text/javascript">
function LoginSubmit() {
	$.jBox.tip("登陆中......",'loading');
	$.ajax({
		url: "__APP__/member/common/actlogin",
		data: {"sUserName": $("#uname").val(),"sPassword": $("#upass").val(),"sVerCode": $("#vcode").val(),"Keep":$("#loginstate").val()},
		timeout: 5000,
		cache: false,
		type: "post",
		dataType: "json",
		success: function (d, s, r) {
			if(d){
				if(d.status==0){
					$.jBox.tip(d.message);	
				}else{
					window.location.href="/";
				}
			}
		}
	});
}

function jfun_dogetpass(){
	var ux = $("#emailname").val();
	if(ux==""){
		$.jBox.tip('请输入用户名或者邮箱');
		return;
	}
	$.jBox.tip("邮件发送中......","loading");
	$.ajax({
		url: "__APP__/member/common/dogetpass/",
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
					$.jBox.tip("发送失败，请重试",'error');
				}
			}
		}
	});

}

function getPassWord() {
	$.jBox("get:__APP__/member/common/getpassword/", {
		title: "找回密码",
		buttons: {'发送邮件':'jfun_dogetpass()','关闭': true }
	});   
}

</script>
<script type="text/javascript">
$(function(){
	
	$("#kinMaxShow").kinMaxShow({
			//设置焦点图高度(单位:像素) 必须设置 否则使用默认值 500
			height:303,
			//设置焦点图 按钮效果
			button:{
			    //设置按钮上面不显示数字索引(默认也是不显示索引)
                            showIndex:false,
			    //按钮常规下 样式设置 ，css写法，类似jQuery的 $('xxx').css({key:value,……})中css写法。            
			    //【友情提示：可以设置透明度哦 不用区分浏览器 统一为 opacity，CSS3属性也支持哦 如：设置按钮圆角、投影等，只不过IE8及以下不支持】            
                            normal:{background:'url(/Style/H/images/button.png) no-repeat -38px 0',marginRight:'8px',border:'0',left:'28%',bottom:'0px',width:'38px'},
                            //当前焦点图按钮样式 设置，写法同上
                            focus:{background:'url(/Style/H/images/button.png) no-repeat 0 0',border:'0'}
			},
			//焦点图切换回调，每张图片淡入、淡出都会调用。并且传入2个参数(index,action)。index 当前图片索引 0为第一张图片，action 切入 或是 切出 值:fadeIn或fadeOut
			//函数内 this指向 当前图片容器对象 可用来操作里面元素。本例中的焦点图动画主要就是靠callback实现的。
			callback:function(index,action){
				switch(index){
					case 0 :
							if(action=='fadeIn'){
								$(this).find('.sub_1_1').animate({left:'70px'},600)
								$(this).find('.sub_1_2').animate({top:'60px'},600)
								
							}else{
								$(this).find('.sub_1_1').animate({left:'110px'},600)
								$(this).find('.sub_1_2').animate({top:'120px'},600)
								
							};
							break;
							
					case 1 :
							if(action=='fadeIn'){
								$(this).find('.sub_2_1').animate({left:'-100px'},600)
								$(this).find('.sub_2_2').animate({top:'60px'},600)
							}else{
								$(this).find('.sub_2_1').animate({left:'-160px'},600)	
								$(this).find('.sub_2_2').animate({top:'20px'},600)
							};
							break;
							
					case 2 :
							if(action=='fadeIn'){
								$(this).find('.sub_3_1').animate({right:'350px'},600)
								$(this).find('.sub_3_2').animate({left:'180px'},600)
							}else{
								$(this).find('.sub_3_1').animate({right:'180px'},600)	
								$(this).find('.sub_3_2').animate({left:'30px'},600)
							};
							break;	 	
				}
			}
		});
});

</script> 
<script type="text/javascript"> 
$(document).ready(function(){ 
  $(".Ctitle").find(".phc_wz").hover(function(){
    $(this).css("color", "#2A79D3");
  }, function(){
    $(this).css("color", "#f39904");
  }); 
if( $(".anNiuTB").length > 0)
{
    $(".phc_wz").fadeOut();
}
else
{
    $(".phc_wz").fadeIn();
}  
});
</script>    
<script type="text/javascript">  
 $(function(){
  $('#marquee').bxSlider({
        mode:'vertical', //默认的是水平
        displaySlideQty:1,//显示li的个数
        moveSlideQty: 1,//移动li的个数  
        captions: false,//自动控制
        auto: true,
        controls: false,//隐藏左右按钮
        autoControls : false,
        pause: 3000,
        autoHover: true,
		startSlide : 0,
		infiniteLoop : true
        
  });
}); 
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
 
<div class="banner">
    <div class="ibannerbox" >
			<div id="kinMaxShow">
			  <?php $_result=get_ad(4);if(is_array($_result)): $i = 0; $__LIST__ = $_result;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><div> <a href="<?php echo ($va["url"]); ?>"><img src="__ROOT__/<?php echo ($va["img"]); ?>" /></a> </div><?php endforeach; endif; else: echo "" ;endif; ?>
			</div>
        </div>
		<?php if($UID > 0): else: ?>
	<div class="login_box">
		<p style="padding-top:34px;height:42px;">年化收益率</p>
		<span><font size="7">8</font>%~<font size="7">15</font>%</span>
		<a href="/member/common/register/" class="login_btn"></a>
		<p style="color:#fff;text-indent:92px;font-size:14px;">已有账号？<a href="/member/common/login/" style="color:#ff6000">立即登录</a></p>
	</div><?php endif; ?>
</div>  
<div class="bodyer">
<div id="count-video">
<div class="count-list">
<ul>
<li>
<div class="count-img fl"></div>
<div class="count-num"><?php echo (getmoneyformt($statictis["get_money"])); ?>元</div>
<span>累计成交量</span>
</li>

<li class="middle">
<div class="count-img count-img2 fl"></div>
<div class="count-num"><?php echo (getmoneyformt($statictis["make_money"])); ?>元</div>
<span>为投资人赚取收益</span>
</li>

<li class="last">
<div class="count-img count-img3 fl"></div>
<div class="count-num"><?php echo (getmoneyformt($statictis["needgot_money"])); ?>元</div>
<span>昨日交易额</span>
</li>
</ul>
</div>
  <video id="example_video_1" class="video video-js vjs-default-skin" controls preload="none" width="253" height="141"
      poster="/Style/H/images/count/video.jpg"
      data-setup="{}">
    <source src="/Style/H/video/1280cailai.mp4" type='video/mp4' />
    <source src="/Style/H/video/1280cailai.mp4" type='video/webm' />
    <source src="/Style/H/video/1280cailai.mp4" type='video/ogg' /> 
    <p class="vjs-no-js">To view this video please enable JavaScript, and consider upgrading to a web browser that</p>
  </video>


</div>
 
<div class="zhiying_novice">
<div id="new_novice">
<div class="novice_content_left">
<div class="novice_title"><a href=""><img src="__ROOT__/Style/H/images/status/newicon.png" alt=""></a></div>
<div class="novice_item_title"><span>新手专区</span> <font color="#f39700">未投资过</font>的新用户专享</div> 

<div class="novice_content_property">
<div class="novice_bt"><i><?php echo $gary['rate'];?>%</i>年化收益</div>
<div class="novice_bt"><span><?php echo $gary['min'].'-'.$gary['max'];?></span> 投资区间（元） </div> 
<div class="novice_bt"><span><?php echo $gary['bidtime'];?></span> 投资期限（天）</div>
</div> 
<div class="novice_content_right"><a href="__APP__/invest/<?php echo $gary['id'].a;?>.html">立即体验</a></div> 
</div> 
</div>

<div class="Whatbox">
<div class="What">
<div class="Wleft"><span>官网公告</span> <a href="/cfkt/index.html" class="ckbtn"></a></div>
<div class="Wright" style='height:205px;'> 
<ul>
<!-- <marquee direction='up' scrollamount='2' onMouseOut='this.start()'  height='100px' onMouseOver='this.stop()'> -->
<?php if(is_array($noticeList["list"])): $i = 0; $__LIST__ = $noticeList["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$va): $mod = ($i % 2 );++$i;?><li>
<a href="<?php echo ($va["arturl"]); ?>" title="<?php echo ($va["title"]); ?>"><?php echo (cnsubstr($va["title"],8)); ?></a>
<span><?php echo (date("m-d",$va["art_time"])); ?></span>
</li><?php endforeach; endif; else: echo "" ;endif; ?>
<!-- </marquee> -->
<!-- <?php $xlist = getArticleList(array("type_id"=>37,"pagesize"=>4)); foreach($xlist['list'] as $kx => $va){ ?> 
<li></a>
<span>{$va.art_time|date="m-d",###}</span></li> 
             
<?php };$noticeList=NULL; ?> -->
</ul> 
</div>
</div>
</div>

</div>
<div class="zhiying">
<div class="Ctitle">理财专区 
<div class="phc_wz">财来网正在审核项目，很快将有新标发布！</div> 
<div class="phc_licai"><a href="/invest/index.html">进入理财专区</a></div>
</div> 
<div style="clear:both"></div> 
<div class="xin_list">
			<table>
				<tr>
					<th style="width:400px;">项目名称</th>
					<th style="width:90px;">抵押率</th>
					<th style="width:100px;">借款金额</th>
					<th style="width:100px;">年利率</th>
					<th style="width:100px;">借款期限</th>
					<th style="width:90px;">投标进度</th>
					<th style="width:90px;">&nbsp;</th>
				</tr>
                        <?php if(is_array($listBorrow["list"])): $i = 0; $__LIST__ = $listBorrow["list"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vb): $mod = ($i % 2 );++$i; if($vb["zw_show"] == 1): ?><tr style="color:#5b5b5b">
					<td style="text-align:left; padding-left:20px;" class="ilistimg"><?php echo getIco($vb);?><a href="<?php echo (getinvesturl($vb["id"])); ?>"title="<?php echo ($vb["borrow_name"]); ?>"><?php echo (cnsubstr($vb["borrow_name"],23)); ?></a></td>
                    <td class="dybj"><?php echo ($vb["borrow_mortgage_rate"]); ?>%</td>
					<td style="color:#5b5b5b"><?php echo (getmoneyformt($vb["borrow_money"])); ?>元</td>
					<td style="color:#5b5b5b"><span style="color:#f35a00; font-size:20px;"><?php echo ($vb["borrow_interest_rate"]); ?></span>%</td>
					<td style="color:#5b5b5b"><?php if($vb['repayment_type'] == 1): echo ($vb["borrow_duration"]); ?>天
						<?php else: ?>
							<?php echo ($vb["borrow_duration"]); ?>个月<?php endif; ?></td>
					<td><span class="ui-list-field"> <span class="ui-progressbar-mid ui-progressbar-mid-<?php echo (intval($vb["progress"])); ?>"><em><?php echo (intval($vb["progress"])); ?>%</em></span> </span>
						</td>
					<td style="padding-right:20px;"><?php if($vb["borrow_status"] == 3): ?><a href="javascript:;"><img class="anNiuYLB" src="__ROOT__/Style/H/images/status/touM.gif" /></a>
              <?php elseif($vb["borrow_status"] == 4): ?>
              <a href="javascript:;"><img class="anNiuDDFS" src="__ROOT__/Style/H/images/status/touM.gif" /></a>
              <?php elseif($vb["borrow_status"] == 6): ?>
              <a href="javascript:;"><img  class="anNiuHKZ" src="__ROOT__/Style/H/images/status/touM.gif"  /></a>
              <?php elseif($vb["borrow_status"] > 6): ?>
              <a href="<?php echo (getinvesturl($vb["id"])); ?>"><img class="anNiuYWC" src="__ROOT__/Style/H/images/status/touM.gif"  /></a>
              <?php else: ?>
              <a href="<?php echo (getinvesturl($vb["id"])); ?>"><img class="anNiuTB" src="__ROOT__/Style/H/images/status/touM.gif" /></a><?php endif; ?></td>
				</tr><?php endif; endforeach; endif; else: echo "" ;endif; ?>
 
			</table>
		</div>
        
        
<div class="Ctitle" style="margin-top:35px">转让专区
<div class="phc_wzs">其他投资人<span>转让项目</span>后，专区随时更新！</div> 
<div class="phc_licais"><a href="/debt/index">进入转让专区</a></div>
</div> 
<div style="clear:both"></div> 
<div class="xin_list">
			<table>
				<tr>
					<th style="width:420px;">借款标题</th> 
					<th style="width:120px;">借款利率</th>
					<th style="width:120px;">转让价格</th>
					<th style="width:130px;">待收本息</th>
					<th style="width:120px;">期数/总期数</th>
					<th class="dengji"  style="width:70px;">状态</th> 
					 
				</tr>
                
 				<script type="text/javascript">
					function buy_debt(invest_id)
					{
					    $.jBox("get:__APP__/Debt/buydebt?invest_id="+invest_id, {
					        title: "购买债权",
					        width: "auto",
					        buttons: {}
					    });
					}
				</script>
			

        <?php if(is_array($lists["data"])): $i = 0; $__LIST__ = $lists["data"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vb): $mod = ($i % 2 );++$i;?><tr height="60px" class="borrowlist borrowlistl <?php if(($key+1)%10 == 0): ?>delline<?php endif; ?>">
		    <td width="286" align="left" style="text-align:left;">
		    &nbsp;&nbsp;<?php echo getIco($vb);?>
		    <a href="<?php echo (getinvesturl($vb["id"])); ?>"title="<?php echo ($vb["borrow_name"]); ?>" ><?php echo (cnsubstr($vb["borrow_name"],20)); ?></a></td>
		   
			<td style="color:#5b5b5b"><span style="color:#f35a00; font-size:20px;"><?php echo ($vb["borrow_interest_rate"]); ?></span>%</td>
		    <td style="color:#5b5b5b"><span class="BL_time"><?php echo (($vb["transfer_price"])?($vb["transfer_price"]):0); ?></span>&nbsp;元</td>
		    <td style="color:#5b5b5b"><span class="BL_time">￥<?php echo (($vb['transfer_price']+$vb['interest'])?($vb['transfer_price']+$vb['interest']):0); ?></span>&nbsp;元</td>
		    <td style="color:#5b5b5b"> <span class="BL_time"><?php echo ($vb["period"]); ?></span>期/<span class="BL_time"><?php echo ($vb["total_period"]); ?></span>期
			</td>
		    <td class="dengji" width="160">
		        <?php if($vb["status"] == '2'): ?><a href="javascript:;" onclick="buy_debt('<?php echo ($vb["invest_id"]); ?>')">
					<img  src="__ROOT__/Style/H/images/status/kzr.gif" style="width: 100px; height: 39px;" /></a>
					<?php elseif($vb["status"] == '1'): ?>
		            <img   style="width: 100px; height: 39px;"  src="__ROOT__/Style/H/images/status/ywc.gif"  />
		            
		            <?php elseif($vb["status"] == '4'): ?>
		            <img  class="anNiuHKZ"  src="__ROOT__/Style/H/images/status/touM.gif"  /><?php endif; ?>
		                    
			      <input id="hid<?php echo ($vo["debt_id"]); ?>" type="hidden" value="<?php echo ($vo['valid']-time()); ?>" />
				  <script type="text/javascript">
			        var seconds<?php echo ($vo["debt_id"]); ?>;
			        var timer<?php echo ($vo["debt_id"]); ?>=null;
			        function setLeftTime<?php echo ($vo["debt_id"]); ?>() {
			            seconds<?php echo ($vo["debt_id"]); ?> = parseInt($("#hid<?php echo ($vo["debt_id"]); ?>").val(), 10);
			            timer<?php echo ($vo["debt_id"]); ?> = setInterval(showSeconds<?php echo ($vo["debt_id"]); ?>,1000);
			        }
			        
			        function showSeconds<?php echo ($vo["debt_id"]); ?>() {
			            var day1<?php echo ($vo["debt_id"]); ?> = Math.floor(seconds<?php echo ($vo["debt_id"]); ?> / (60 * 60 * 24));
			            var hour<?php echo ($vo["debt_id"]); ?> = Math.floor((seconds<?php echo ($vo["debt_id"]); ?> - day1<?php echo ($vo["debt_id"]); ?> * 24 * 60 * 60) / 3600);
			            var minute<?php echo ($vo["debt_id"]); ?> = Math.floor((seconds<?php echo ($vo["debt_id"]); ?> - day1<?php echo ($vo["debt_id"]); ?> * 24 * 60 * 60 - hour<?php echo ($vo["debt_id"]); ?> * 3600) / 60);
			            var second<?php echo ($vo["debt_id"]); ?> = Math.floor(seconds<?php echo ($vo["debt_id"]); ?> - day1<?php echo ($vo["debt_id"]); ?> * 24 * 60 * 60 - hour<?php echo ($vo["debt_id"]); ?> * 3600 - minute<?php echo ($vo["debt_id"]); ?> * 60);
			            
			            $("#loan_time<?php echo ($vo["debt_id"]); ?>").html(day1<?php echo ($vo["debt_id"]); ?> + " 天 " + hour<?php echo ($vo["debt_id"]); ?> + " 小时 " + minute<?php echo ($vo["debt_id"]); ?> + " 分 " + second<?php echo ($vo["debt_id"]); ?> + " 秒");
			            
			            seconds<?php echo ($vo["debt_id"]); ?>--;
			            if(seconds<?php echo ($vo["debt_id"]); ?>==0){
			               $("#endtime<?php echo ($vo["debt_id"]); ?>").html("已结束");
			               $("#buy_button").html('<img  class="anNiuHKZ" src="__ROOT__/Style/H/images/ywc.gif"  />'); 
			            }
			        }                
			        setLeftTime<?php echo ($vo["debt_id"]); ?>();
			    </script>
		</td>
		
	  </tr><?php endforeach; endif; else: echo "" ;endif; ?> 
 
			</table>
		</div>
        
<div style="clear:both"></div> 


<div class="aqbz_list">
<div class="aqbz_title">安全保障  <div class="phc_more"><a href="/borrow/anquanbaoz.html">查看更多</a></div></div>
<ul> 
<li>
<img src="__ROOT__/Style/H/images/status/aqbz1.jpg" alt="" />
<span>汇付天下第三方账户独立托管</span>
</li> 
<li>
<img src="__ROOT__/Style/H/images/status/aqbz2.jpg" alt="" />
<span>合作担保机构100%本息担保</span>
</li> 
<li>
<img src="__ROOT__/Style/H/images/status/aqbz3.jpg" alt="" />
<span>严格的借款人<br />审核准入制度</span>
</li> 
<li>
<img src="__ROOT__/Style/H/images/status/aqbz4.jpg" alt="" />
<span>双重风控审核<br />七道工序保障</span>
</li> 
<li>
<img src="__ROOT__/Style/H/images/status/aqbz5.jpg" alt="" />
<span>精细化资产管理<br />银行级数据安全</span>
</li> 
</ul>
</div>
  
<div class="border" >
<div class="border-title">近30日投资榜</div>
<div class="user-rank">

<div class="clearfix">
<div class="user-l fl">用户名</div>
<div class="user-m fl">投资金额</div>
<div class="user-r fl">获得收益</div>
</div>
<marquee direction='up' scrollamount='2' onMouseOut='this.start()'  height='150px' onMouseOver='this.stop()'>
<ul class="user-list">
<?php if(is_array($daren)): $i = 0; $__LIST__ = $daren;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><li>
<div class="user-l fl"><?php echo (substr($vo["username"],0,3)); ?>**</div>
<div class="user-m fl"><span><?php echo (getmoneyformt($vo["money"])); ?></span>元</div>
<div class="user-r fl"><span><?php echo (getmoneyformt($vo["got_money"])); ?></span>元</div>
</li><?php endforeach; endif; else: echo "" ;endif; ?> 
</ul>

</marquee>

</div>

</div> 


<div style="clear:both"></div>
<div class="Ctitle" style="margin-top:35px">合作伙伴</div>

<div style="clear:both"></div>
 <img src="__ROOT__/Style/H/images/status/yinhang.jpg" alt="" style="margin-top:35px;" />       
</div>
 
</div>
<script type="text/javascript" src="/Style/artDialog/jquery.artDialog.source.js?skin=aero"></script> 
<script type="text/javascript">
$(".btn001,.btn002,.btn003").click(function (){
var id = title = '';
	if(this.className == 'btn001'){
		id = '#pop_msg_1';
		title = '项目描述';
	}else if(this.className == 'btn002'){
		id = '#pop_msg_2';
		title = '担保机构简介及担保意见';
	}else if(this.className == 'btn003'){
		id = '#pop_msg_3';
		title = '风险控制措施';
	}
	
	$.artDialog({
		title: title,
		content: '<div style="width:600px; height:400px; float:left;">' + $(id).html() + "</div>",
		lock: true,
		opacity: 0.5,
		cancelVal: "关闭",
		cancel: true
	});
});
</script>
<script type="text/javascript">
		var lilenth = $(".list-h li").length+1;
		$(".list-h").css("width", lilenth * 156);
		var leftpos = 0;
		var leftcount = 0;

		$("#imgLeft").attr("src", "__ROOT__/Style/H/images/left_g.gif");
		$("#spec-left1").css("cursor", "default");

		if (lilenth > 1) {
			$(function() {
				$("#spec-right").click(function() {
					if (leftcount >= 0) {
						$("#imgLeft").attr("src", "__ROOT__/Style/H/images/scroll_left.gif");
						$("#spec-left1").css("cursor", "pointer");
					}
					if (lilenth - leftcount < 3) {
						$("#imgRight").attr("src", "__ROOT__/Style/H/images/right_g.gif");
						$("#spec-right").css("cursor", "default");
					}
					else {
						leftpos = leftpos - 156;
						leftcount = leftcount + 1;
						$(".list-h").animate({ left: leftpos }, "slow");
						if (lilenth - leftcount < 2) {
							$("#imgRight").attr("src", "__ROOT__/Style/H/images/right_g.gif");
							$("#spec-right").css("cursor", "default");
						}
					}

				});
			});


			$(function() {
				$("#spec-left1").click(function() {
					if (lilenth - leftcount > 2) {
						$("#imgRight").attr("src", "__ROOT__/Style/H/images/scroll_right.gif");
						$("#spec-right").css("cursor", "pointer");
					}

					if (leftcount < 1) {
						$("#imgLeft").attr("src", "__ROOT__/Style/H/images/left_g.gif");
						$("#spec-left1").css("cursor", "default");
					}
					else {
						leftpos = leftpos + 156;
						leftcount = leftcount - 1;
						$(".list-h").animate({ left: leftpos }, "slow");
						if (leftcount < 1) {
							$("#imgLeft").attr("src", "__ROOT__/Style/H/images/left_g.gif");
							$("#spec-left1").css("cursor", "default");
						}
					}

				}
				)
			})
		}
		else {
			$("#imgRight").attr("src", "__ROOT__/Style/H/images/right_g.gif");
			$("#spec-right").css("cursor", "default");
		}
		$(function() {
			var width = $("#preview").width();
			$("#spec-list1").css("width", 730).css("margin-right", 8);

		});

		$(function() {
			$("#spec-list1 img").bind("mouseover", function() {
				$(this).css({
					"border": "0px solid #FFFFFF",
					"padding": "0px"
				});
			}).bind("mouseout", function() {
				$(this).css({
					"border": "0px solid #ccc",
					"padding": "0px"
				});
			});
		})
		
	$(function() {
		$(".borrowlistp").bind("mouseover", function(){
			$(this).css("background", "#f8f8f8");
		})

		$(".borrowlistp").bind("mouseout", function(){
			$(this).css("background", "#fff");
		})


		$(".borrowlistl").bind("mouseover", function(){
			$(this).css("background", "#f8f8f8");
		})

		$(".borrowlistl").bind("mouseout", function(){
			$(this).css("background", "#fff");
		})

		$(".changecolor").bind("mouseover", function(){
			$(this).css("background", "#f8f8f8");
			$(this).css("color", "#007EB9");
		})

		$(".changecolor").bind("mouseout", function(){
			$(this).css("background", "#fff");
			$(this).css("color", "#737272");
		})
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