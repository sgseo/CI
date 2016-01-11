<?php 



echo 'hello';
exit;
function curlrequest($url,$data,$method='post'){
	$ch = curl_init(); //初始化CURL句柄
	curl_setopt($ch, CURLOPT_URL, $url); //设置请求的URL
	curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //设为TRUE把curl_exec()结果转化为字串，而不是直接输出
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method); //设置请求方式
	 
	curl_setopt($ch,CURLOPT_HTTPHEADER,array("X-HTTP-Method-Override: $method"));//设置HTTP头信息
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);//设置提交的字符串
	$document = curl_exec($ch);//执行预定义的CURL
	if(!curl_errno($ch)){
		$info = curl_getinfo($ch);
		echo 'Took ' . $info['total_time'] . ' seconds to send a request to ' . $info['url'];
	} else {
		echo 'Curl error: ' . curl_error($ch);
	}
	curl_close($ch);
	 
	return $document;
}

$url = 'http://apitest.cailai.com/v1.1/index.php';
$arr = array('id'=>1,'name'=>'whh');
$arr = array('5','a');
$data = json_encode($arr,JSON_FORCE_OBJECT);//强制变成对象
$return = curlrequest($url, $data, 'put');
exit;

header("Content-type: text/html; charset=utf-8");
require_once(dirname(__FILE__).'/header.php');
core::Singleton('comm.remote.remote');


//$data = array(
//		'sname' => 'user.isreg',//系统参数，调用接口
//		'mobile' => '13818164082',//应用查参数，快递品牌
//);
//$result = remote::send($data,'',$header);
//print_r(json_decode($result));//打印结果，body属性返回格式为json格式
//////print_r(remote::$debug);
////echo "\n\n";
//exit;

//用户登陆

$data = array(
		'sname' => 'user.login',//系统参数，调用接口
		'mobile' => '13100030002',//应用查参数，快递品牌
		'passwd'    => '111111',//应用查参数，快递单号
);
remote::$open_debug=1;
$result = remote::send($data);
print_r(json_decode($result,true));unset($result);//这里可以得到uid
$session_id = remote::$session_id;//获取session_id
echo $session_id;
print_r(remote::$debug);
exit;





//用户认证，前提是需要先登录
/*
$data = array(
		'sname' => 'authentication.get',//系统参数，调用接口
);
$header[] = 'Cookie:session_id=c0ed08610c5d71082095b861a0737dba2';
$result = remote::send($data,'',$header);

$res = json_decode($result,true);//打印结果，body属性返回格式为json格式
//exit;
//print_R($res);
if($res['code']==0){
	//autoRedirect($res['data']);
}else{
	//print_R($res);
}
//print_r(remote::$debug);
echo "\n\n";
exit;
*/
//$data = array(
//		'sname' => 'invest.money',//系统参数，调用接口	
////                'mobile' => '18521362829',
//                'bid' => 1119,
//                'money'=>200,
//               
//);
////remote::$open_debug=1;
//$header[] = 'Cookie:session_id=c247b3a739d0e50383e583085e7329dde';
//$result = remote::send($data,'',$header);
//print_r($result);//打印结果，body属性返回格式为json格式
//print_r (json_decode($result,true));
////print_r(remote::$debug);
//echo "\n\n";
//exit;


//$db = core::Singleton('comm.db.activeRecord');
//                $db->connect('CAILAI');
//                $sql = "SELECT * FROM lzh_borrow_info WHERE id=1023";
//                $info = $db->query($sql);   
//                print_r($info);
//
//exit;
$data = array(
		'sname' => 'invest.money',//系统参数，调用接口	
//                'mobile' => '18521362829',
                'bid' => 1121,
                'money'=>20000,
               
);
//remote::$open_debug=1;
$header[] = 'Cookie:session_id=c577f57d7e5402f63056738ef83501611';
$result = remote::send($data,'',$header);
$res = json_decode($result,true);//打印结果，body属性返回格式为json格式
print_r($res);exit;
if($res['code']==0){
   
	autoRedirect($res['data']);
}else{
	//print_R($res);
}
echo "\n\n";
exit;




// //用户取现
//$data = array(
//		'sname' => 'withdrawals.get',//系统参数，调用接口
//		'amount'    => '400',
//);
//$header[] = 'Cookie:session_id=c02a8cc0dfc8157721f78b3a946ba7643';
//$result = remote::send($data,'',$header);
//$res = json_decode($result,true);//打印结果，body属性返回格式为json格式
//print_R($res);exit;
////print_r(remote::$debug);
//if($res['code']==0){
//	autoRedirect($res['data']);
//}else{
//	//print_R($res);
//}
//
//exit;





function autoRedirect($reqData){//echo "<pre>";print_r($reqData);echo "</pre>";exit;
	$tmp = array();
	$html= <<<HTML
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<head><body onload="document.getElementById('autoRedirectForm').submit();">
<div class="margin:10px;font-size:14px;">正在跳转...</div>
<form id="autoRedirectForm" method="POST" action="http://mertest.chinapnr.com/muser/publicRequests">
HTML;
	foreach($reqData as $key => $value){
		$html.='<input type="hidden" value=\''.$value.'\' name="'.$key.'" />';
		$tmp[$key] = $value;
	}
	$html.="</form>";
	$html.="</body></html>";
	//file_put_contents('/tmp/autoRedirect',date('m-d H:i:s')."autoRedirect ".print_r($autoRedirect,true)."\n",FILE_APPEND);
	//file_put_contents('/tmp/autoRedirect',date('m-d H:i:s')."autoRedirect ".print_r($reqData,true)."\n",FILE_APPEND);
	print $html;
	exit;
}
