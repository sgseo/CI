<?php
define('openDebug',1);  //curl  调试

define('BASEURL','http://mtest.cailai.com/');   //基础页面
define('HFURL','http://mertest.chinapnr.com/muser/publicRequests');  //汇付天下
define('IOSDown','https://itunes.apple.com/cn/app/cai-lai-wang-li-cai/id1002974034?l=en&mt=8'); //IOS APP 下载地址
define('androidDown','http://www.cailai.com/Style/cailai.apk'); //IOS APP 下载地址
define('imgUrl','https://test.cailai.com/');  //抵押物信息图片

define('BENNERTIME',5000); //首页精选标时间控制
define('PAGE_NUM',20);//链表页面每次加载的 数量
//微信相关的
$grant_type='grant_type'; //获取access_token填写client_credential
$appid='wxb62466b76562242b';   //第三方用户唯一凭证
$secret='d888d4f8c55b6c31e3450347f7af0d88';  //第三方用户唯一凭证密钥，即appsecret
define('WX_URL_access_token',"https://api.weixin.qq.com/cgi-bin/token?grant_type={$grant_type}&appid={$appid}&secret={$secret}");  //access_token url
define('WX_USERAGENT','Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.69 Safari/537.36');  //用户代理字符串

?>