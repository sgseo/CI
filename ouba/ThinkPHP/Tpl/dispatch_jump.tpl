<?php
    if(C('LAYOUT_ON')) {
        echo '{__NOLAYOUT__}';
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>跳转提示</title>
<style type="text/css">
*{ padding: 0; margin: 0; }
body{ background: #fff; font-family: '微软雅黑'; color: #333; font-size: 16px;width: 30%; height:350px;margin: 300px auto;}
.system-message{ padding: 24px 48px;margin: 50px auto; border:1px solid #f7f7f7; border-radius:10px;background-color: #f7f7f7}
.system-message h1{ font-size: 36px; font-weight: normal; line-height: 120px; margin-bottom: 12px; }
.system-message .jump{ padding-top: 10px}
.system-message .jump a{ color: #333;}
.system-message .success,.system-message .error{ line-height: 1.8em; font-size: 27px }
.system-message .detail{ font-size: 12px; line-height: 20px; margin-top: 12px; display:none}
.newjump{font-size:20px;line-height: 1.8em; width: 30%; }
p,img{height:27px; }
</style>
</head>
<body>
<div class="system-message">
<?php if(isset($message)) {?>

<p class="success">
    <div style='width:27px;float:left;margin-right:10px;'>
    <img src='__PUBLIC__/Images/g.png' height='27px' alt=''/> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
    </div>
    <div style='width:270px;float:left'>
    <?php echo($message."……"); ?></p>
    </div>
<?php }else{?>
<!-- <span style='font-size:15px;'></span> -->
<p class="error">
    <div style='width:27px;float:left;margin-right:10px;'>
    <img src='__PUBLIC__/Images/x.png' height='27px' alt=''/> &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
    </div>
    <div style='width:270px;float:left'>
    <?php echo($error); ?></p>
    </div>
<?php }?>
<!-- <p class="detail"></p> -->
 <p class="newjump">
    <div style='width:300px;margin:0 40px 0 2px;'>
页面自动 <a id="href" href="<?php echo($jumpUrl); ?>">跳转</a> 等待时间： <b id="wait"><?php echo 10; ?></b>
<!-- ($waitSecond) -->
    </div>
</p>
</div>
<script type="text/javascript">
(function(){
var wait = document.getElementById('wait'),href = document.getElementById('href').href;
var interval = setInterval(function(){
	var time = --wait.innerHTML;
	if(time <= 0) {
		location.href = href;
		clearInterval(interval);
	};
}, 1000);
})();
</script>
</body>
</html>
