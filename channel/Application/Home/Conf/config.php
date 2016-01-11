<?php
return array(
	//'配置项'=>'配置值'
'SHOW_PAGE_TRACE' =>true,
'URL_CASE_INSENSITIVE' => true, //默认false 表示URL区分大小写 true则表示不区分大小写
'URL_MODEL' => 2, //URL模式 0:普通模式 1：PATHINFO模式 2：REWRITE模式 3：兼容模式
'VAR_URL_PARAMS' => '', // PATHINFO URL参数变量
'URL_PATHINFO_DEPR' => '/', //PATHINFO URL分割符
'URL_HTML_SUFFIX' => '.html',
'URL_ROUTER_ON' => true,
'DEFAULT_GROUP'     =>'Home',//默认分组
'PNAME'=>'ios',
'SECRET_KEY'=>'bc7cfba8367fdc117d2ac8e85a5effe3',
'API_URL'=>'http://apitest.cailai.com/v1.0/',
'SON_URL'=>'https://dev.cailai.com/index.php/returl/sonsend'//子公司短信api请求地址
 );