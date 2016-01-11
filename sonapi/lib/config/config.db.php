<?php
/**
 * 全站数据库连接配置文
 */

// 防止重复include本文
if(!defined('CONFIG_DB_INCLUDED')){
	define('CONFIG_DB_INCLUDED',1);

	$GLOBALS['CAILAI_MASTER']	= array('HOST'=>'115.29.245.207:3306','USER'=>'test','PASS'=>'cailai1234567890','NAME'=>'cailainew');
	$GLOBALS['CAILAI_SLAVE']	= array('HOST'=>'115.29.245.207:3306','USER'=>'test','PASS'=>'cailai1234567890','NAME'=>'cailainew');
	
	$GLOBALS['DTS_MASTER']	= array('HOST'=>'115.29.245.207:3306','USER'=>'test','PASS'=>'cailai1234567890','NAME'=>'dts');
	$GLOBALS['DTS_SLAVE']	= array('HOST'=>'115.29.245.207:3306','USER'=>'test','PASS'=>'cailai1234567890','NAME'=>'dts');
        
        //push 数据库
        $GLOBALS['CAILAIPUSH_MASTER']	= array('HOST'=>'115.29.245.207:3306','USER'=>'test','PASS'=>'cailai1234567890','NAME'=>'cailaipush');
	$GLOBALS['CAILAIPUSH_SLAVE']	= array('HOST'=>'115.29.245.207:3306','USER'=>'test','PASS'=>'cailai1234567890','NAME'=>'cailaipush');
	

}
?>