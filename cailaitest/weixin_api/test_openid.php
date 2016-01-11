<?php
	$code = $_GET['code'];//获取code
	$weixin =  file_get_contents("https://api.weixin.qq.com/sns/oauth2/access_token?appid=wxb08ec4dac597012a&secret=d7a0119259c65251c8916522fdc59d54&code=".$code."&grant_type=authorization_code");//通过code换取网页授权access_token
	$jsondecode = json_decode($weixin); //对JSON格式的字符串进行编码
	$array = get_object_vars($jsondecode);//转换成数组
	$openid = $array['openid'];//输出openid
	echo $openid;
?>
