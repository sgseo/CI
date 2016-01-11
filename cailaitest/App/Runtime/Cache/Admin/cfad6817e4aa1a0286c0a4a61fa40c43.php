<?php if (!defined('THINK_PATH')) exit();?><html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo ($ts['site']['site_name']); ?>后台管理</title>

<script type="text/javascript" src="__ROOT__/Style/A/js/jquery.js"></script>

<link rel="stylesheet" type="text/css" href="/Style/A/js/tbox/box.css"/>
<script type="text/javascript" src="__ROOT__/Style/A/js/common.js"></script>
<script type="text/javascript" src="__ROOT__/Style/A/js/tbox/box.js"></script>
<link rel="stylesheet" href="__ROOT__/Style/A/css/style.css">

<script language="javascript" type="text/javascript" src="__ROOT__/Style/A/js/jquery.min.js"></script>
<script type="text/javascript" src="/Style/artDialog/jquery.artDialog.source.js?skin=aero"></script>
<!--[if lte IE 6]>
<script src="__ROOT__/Style/A/js/png.js" type="text/javascript"></script>    
<script type="text/javascript">   
DD_belatedPNG.fix('.logo');  
</script>
<![endif]--> 

 <script type="text/javascript">
$(function(){
    var t_height = $(document).height()-80;
    $("#FrameTitle").css('top',t_height+'px');
})
</script> 


<script language="javascript" type="text/javascript"> 


/* 按下F5时仅刷新iframe页面 */
function inactiveF5(e) {
	return ;
	e=window.event||e;
	var key = e.keyCode;
	if (key == 116){
		parent.MainIframe.location.reload();
		if(document.all) {
			e.keyCode = 0;
			e.returnValue = false;
		}else {
			e.cancelBubble = true;
			e.preventDefault();
		}
	}
}

function nof5() {
    return ;
	if(window.frames&&window.frames[0]) {
		window.frames[0].focus();
		for (var i_tem = 0; i_tem < window.frames.length; i_tem++) {
			if (document.all) {
				window.frames[i_tem].document.onkeydown = new Function("var e=window.frames[" + i_tem + "].event; if(e.keyCode==116){parent.MainIframe.location.reload();e.keyCode = 0;e.returnValue = false;};");
			}else {
				window.frames[i_tem].onkeypress = new Function("e", "if(e.keyCode==116){parent.MainIframe.location.reload();e.cancelBubble = true;e.preventDefault();}");
			}
		} //END for()
	} //END if()
}

function refresh() {
	parent.MainIframe.location.reload();
}
document.onkeydown=inactiveF5;

function txxt(){
	ui.box.load("/admin/common/sms", {title:"通讯系统"});
}
</script> 
<script>
function changeClock()
{
	var d = new Date();
	document.getElementById("clock").innerHTML = d.getFullYear() + "-" + (d.getMonth() + 1) + "-" + d.getDate() + " " + d.getHours() + ":" + d.getMinutes() + ":" + d.getSeconds();
}
window.setInterval(changeClock, 1000);
</script>
</head>

<body scroll="no" style="margin:0; padding:0;" onLoad="nof5()">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3">
		<div class="header"><!-- 头部 begin -->
		    <div class="logo"></div>
			<div class="nav_sub">
			<!--  <div class="nav_sub1"><span >当前用户：<?php echo session('admin_user_name');?></span>&nbsp;&nbsp; &nbsp;&nbsp; <span >欢迎登陆融天下管理系统&nbsp;&nbsp; 今天是：</span>
			 <span id="clock"style="width:10px;"></span>
			 </div> -->
			 <div class="nav_sub2">
             <a href="__APP__/" target="_blank"><img src="__ROOT__/Style/A/images/qiantai.png "/>查看前台</a> 
			  <a href="javascript:void(0);" onClick="txxt();"><img src="__ROOT__/Style/A/images/tongxun.png" /> 通讯系统</a> 
			  <a href="javascript:void(0);" onClick="refresh();"><img src="__ROOT__/Style/A/images/shuaxin.png" /> 刷新</a> 
			  <a href="javascript:void(0);" onClick="switch_sub_menu('16', '/admin/global/cleanall.html');"><img src="__ROOT__/Style/A/images/qinkong.png" /> 清空缓存</a>  
             <a href="__URL__/logout"><img src="__ROOT__/Style/A/images/tuichu.png" /> 退出</a><br/>
		      <div id="TopTime"></div>
			  </div>
		    </div>
		    <div class="pf_sub">
              <div class="skin">   
                 <div> 
                 <!--<script type="text/javascript">writeCSSLinks();</script> -->
                 </div>                 
              </div> 
			  
		    </div>

		    <div class="main_nav">
		    	<?php foreach($menu_left as $keyt => $menu_1) {if($menu_1[2]==0) continue; ?>
		    		<a id="channel_<?php echo $keyt; ?>" href="javascript:void(0)" onClick="switchChannel('<?php echo $keyt; ?>');" hidefocus="true" style="outline:none;"><?php echo $menu_1[0]; ?></a>
		    	<?php } ?>
			</div> 
 
</div>
		<div class="header_line"></div>
	</td>
  </tr>
  <tr >
  	<td width="200px" height="100%" valign="top" id="FrameTitle"   style="background:url(__ROOT__/Style/A/images/left_bg01.gif) repeat-y 0 0;"> <!-- style="background:url(__ROOT__/Style/A//images/left_bg01.gif) repeat-y 0 0;" --> 
  		<div class="LeftMenu" >
		<?php $iterator = 1; $home_url = ''; $j = 1 ; ?>
  		<!-- 第一级菜单，即大频道 -->
  		<?php foreach($menu_left as $key => $menu_1) { ?>
	      	<ul class="MenuList" id="root_<?php echo ($key); ?>" style="display:none;">
	      	<!-- 第二级菜单 -->
			
		    <?php foreach($menu_1['low_title'] as $key2 => $menu_2) { if($menu_2[2]==0) continue;?>
		        <li class="treemenu" id="munu_qh">
		          <a id="root_<?php echo ($key2); echo ($iterator); ?>" class="actuator" href="javascript:void(0)" onClick="switch_root_menu('<?php echo ($key2); echo ($iterator); ?>');" hidefocus="true" style="outline:none;"><?php echo $menu_2[0]; ?></a>
		          <ul id="tree_<?php echo ($key2); echo ($iterator); ?>" class="submenu">
				  
		          	<!-- 第三级菜单 -->
		          	<?php foreach($menu_1[$key2] as $key3 => $menu_3) { if($menu_3[2]==0) continue;?>
                        <!--<?php $home_url = empty($home_url) ? $menu_3_url : $home_url; ?>-->
		            	<li><a id="menu_<?php echo ($j); ?>" href="javascript:void(0)" onClick="switch_sub_menu('<?php echo ($j); ?>', '<?php echo ($menu_3['1']); ?>');" class="submenuA" hidefocus="true" style="outline:none;"><?php echo ($menu_3['0']); ?></a></li>
					<?php $j++ ;} ?>
		          	<!-- 第三级菜单 -->
					
		          </ul>
		        </li>
				
			<?php } ?>
	      	<!-- 第二级菜单 -->
	      	</ul>
			
		<?php ++ $iterator;} ?>
  		<!-- 第一级菜单，即大频道 -->
		</div>
	</td>
    <td>
   	  <iframe onload="nof5()" id="MainIframe" name="MainIframe" scrolling="yes" src="" width="100%" height="100%" frameborder="0" noresize> </iframe>
	</td>
  </tr>
</table>
<!-- 底部开始 -->
<div class="footer">
  <div class="nav_sub1"><span >当前用户：<?php echo session('admin_user_name');?></span>&nbsp;&nbsp; &nbsp; <span >欢迎登陆财来网管理系统&nbsp;&nbsp; 今天是：</span>
			 <span id="clock"style="width:10px;"></span>&nbsp;&nbsp;<span>版权所有：财来网管理系统</span>
 </div>

</div>
<!-- 底部结束 -->
</body>

<script type="text/javascript">
	var current_channel   = null;
	var current_menu_root = null;
	var current_menu_sub  = null;
	var viewed_channel	  = new Array();
	
	$(document).ready(function(){
		switchChannel('0');
		$(".submenuA").click(function(){
		
			$(this).addClass("submenuB");
		})
		
		
	});
	
	//切换频道（即头部的tab）
	function switchChannel(channel) {
		if(current_channel == channel) return false;
		
		$('#channel_'+current_channel).removeClass('on');
		$('#channel_'+channel).addClass('on');
		
		$('#root_'+current_channel).css('display', 'none');
		$('#root_'+channel).css('display', 'block');
		
		var tmp_menulist = $('#root_'+channel).find('a');
		tmp_menulist.each(function(i, n) {
			// 防止重复点击ROOT菜单
			if( i == 0 && $.inArray($(n).attr('id'), viewed_channel) == -1 ) {
				$(n).click();
				viewed_channel.push($(n).attr('id'));
			}
			if ( i == 1 ) {
				$(n).click();
			}
		});

		current_channel = channel;
	}
	
	function switch_root_menu(root) {
		root = $('#tree_'+root);
		if (root.css('display') == 'block') {
			root.css('display', 'none');
			root.parent().css('backgroundImage', 'url(__ROOT__/Style/A/images/ArrOffaa.png)');
		}else {
			root.css('display', 'block');
			root.parent().css('backgroundImage', 'url(__ROOT__/Style/A/images/Arronaa.png)');
		}
	}
	
	function switch_sub_menu(sub, url) {
		if(current_menu_sub) {
			$('#menu_'+current_menu_sub).attr('class', 'submenuA');
		}
		$('#menu_'+sub).attr('class', 'submenuB');
		current_menu_sub = sub;

		parent.MainIframe.location = url;
	}
	/*
	function resetEscAndF5(e) {
		e = e ? e : window.event;
		actualCode = e.keyCode ? e.keyCode : e.charCode;
		if(actualCode == 116 && parent.MainIframe) {
			parent.MainIframe.location.reload();
			if(document.all) {
				e.keyCode = 0;
				e.returnValue = false;
			} else {
				e.cancelBubble = true;
				e.preventDefault();
			}
		}
	}
	
	function _attachEvent(obj, evt, func, eventobj) {
		eventobj = !eventobj ? obj : eventobj;
		if(obj.addEventListener) {
			obj.addEventListener(evt, func, false);
		} else if(eventobj.attachEvent) {
			obj.attachEvent('on' + evt, func);
		}
	}
	
	_attachEvent(document.documentElement, 'keydown', resetEscAndF5);
	_attachEvent(window, 'keydown', resetEscAndF5, parent.frames[0]);
	*/
</script>
</html>