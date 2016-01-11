<?php
return array(
	//'配置项'=>'配置值'
	// 添加数据库配置信息
'DB_TYPE'=>'mysql',// 数据库类型
'DB_HOST'=>'127.0.0.1',// 服务器地址
'DB_NAME'=>'son_',// 数据库名
'DB_USER'=>'root',// 用户名
'DB_PWD'=>'root',// 密码
'DB_PORT'=>3306,// 端口
'DB_PREFIX'=>'son_',// 数据库表前缀
'DB_CHARSET'=>'utf8',// 数据库字符集
'TMPL_DETECT_THEME' => true, // 自动侦测模板主题
'LANG_SWITCH_ON'	=>true,//开启语言包
'URL_MODEL'=>2, // 如果你的环境不支持PATHINFO 请设置为3,设置为2时配合放在项目入口文件一起的rewrite规则实现省略index.php/
'URL_CASE_INSENSITIVE'=>true,//关闭大小写为true.忽略地址大小写
'TMPL_CACHE_ON'    => false,        // 是否开启模板编译缓存,设为false则每次都会重新编译
'TMPL_STRIP_SPACE'      => false,       // 是否去除模板文件里面的html空格与换行
'SYS_URL'	=>array('Home'),
'URL_CASE_INSENSITIVE'  =>  true, 
'SHOW_PAGE_TRACE' =>true,
);