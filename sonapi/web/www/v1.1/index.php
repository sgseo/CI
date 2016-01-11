<?php
/**
 * 
 */
$json = file_get_contents('php://input', 'r');
file_put_contents('/tmp/whh',date('H:i:s').': '.print_r($json,true),FILE_APPEND);

$tmp = json_decode($json);
$token = @$tmp['token'];
unset($tmp['token']);
$content = json_encode($tmp);

file_put_contents('/tmp/whh',date('H:i:s').': '.print_r($tmp,true),FILE_APPEND);
exit;
// 引入核心文件
require_once(dirname(__FILE__).'/../header.php');
// 引入管理类
$api = core::Singleton('api.api');

echo $content;
echo $token;
exit;
/*

file_put_contents('D:\test.txt',date('H:i:s').': '.print_r($token,true),FILE_APPEND);
exit;

 
$content = '{"pname":"web","sname":"banner.get","latest_time":"2015-04-13 11:12"}';
$token = '36a332242972cadd5c0ee25180b2d4a1';
 *  * */
 
if(ini_get("magic_quotes_gpc")=="1"){
	$content = stripslashes($content);
}
$result  = $api->exec($content,$token);
echo $result;//是json格式的
?>