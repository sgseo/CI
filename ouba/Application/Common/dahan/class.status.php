<?php
/**
 * 大汉三通
 * 通知留言应用哪些已经送达
 * 
 * 自动脚本  
 */
set_time_limit(0);

/**
 * 初始化数据库读写加载，待测试
 *
 * @access  private
 */

$request_time = date('Y-m-d H:i:s');
$request_data = '';
$link = '';

$msgid = $argv[1] ? $argv[1] : '';
if(empty($msgid)){
	echo 'please add msgid ';exit;
}

//上线注意这里
$url = "http://www.10690300.com/http/sms/Report";
$post['message'] = '<?xml version="1.0" encoding="UTF-8"?><message><account>dh51111</account><password>'.md5('3mL?IW~*').'</password><msgid>'.$msgid.'</msgid><phone></phone></message>';
$post_string = http_build_query($post, '', '&');
$link = curl_send($url,$post_string);unset($post_string,$post);

//记录请求回执日志
$response_time = date('Y-m-d H:i:s');
if(isset($link['body'])){
	$body = $link['body'];
	$response_data =   print_R($body,true);unset($link);
	$has_response = 1;
}else{
	$response_data =   print_R($link,true);
}
print_R($response_data);
exit;

 function curl_send($url,$post_data='',$timeout=3,$headers=array(),$crt_path=false){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, true);
	curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);

	if(!empty($headers)){
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	}
	if(!empty($post_data)){
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:'));
		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
	}
	if($crt_path){
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_CAINFO, $crt_path);
	}else{
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	}
	$response = curl_exec($ch);
	$errmsg = curl_error($ch);
	//print_r($response);
	$pos = strpos($response,"\r\n\r\n");
	$infor = array(
			'code'=>curl_getinfo($ch,CURLINFO_HTTP_CODE),
			'header'=>substr($response,0,$pos),
			'body'=>substr($response,$pos+4),
			'error'=>$errmsg
	);
	curl_close($ch);
	return $infor;
}
