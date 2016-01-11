<?php

$data = array(
		'sname' => 'express.get',
		'brand' => "sf",
		'no' => "212180769458",
);

$result =remote::send($data); 
print_R(json_decode($result));

?>



<?php

class remote {
	//授权账号
	public static  $pname = 'ios';

	//授权账号
	public static  $url   = 'http://dts.kuaidihelp.com/api.php';

	//key值
	public static  $key   = '40b208cae52648af9b368382ac10304f';

	//timeout
	public static  $timeout   = 5;

	//debug信息
	public static  $debug = NULL;
	
	//
	public static  $open_debug = 0;

	//session_id的值
	public static $session_id = '';

	public  function __set($name, $value) {

		self::$name = $value;
	}

	public  function __get($name) {

		return self::$name;
	}

	/**
	 *
	 * @param string $url  请求的地址
	 * @param array  $post_data   post数组
	 * @param int    $timeout  超时设置
	 * @param sting  $headers  http头
	 * @param string $return   http响应数据。可以是code， header，body，error
	 */
	public static function send($post_data = array(), $timeout = 5, $headers = array(), $return = 'body'){
		if(self::$open_debug) self::$debug[] = self::$url;
		$request = self::get_request($post_data);unset($post_data);
		$post_string = '';
		if(!empty($request)){
			if(self::$open_debug)  self::$debug[] = $request;
			$post_string = http_build_query($request, '', '&');unset($request);
		}
		$response = self::curl_send( self::$url, $post_string, empty($timeout) ? self::$timeout : $timeout, empty($headers) ? array() : $headers);
		unset($post_string,$timeout,$headers);
		if(self::$open_debug) self::$debug[] = $response;
		if(strpos($response['header'],'session_id=')){
			self::$session_id = substr(strstr($response['header'],'session_id='),11,33);
		}
		self::reset();
		return isset($response[$return]) ? $response[$return] : $response;
	}

	public static function help(){
		$msg  = 'send方法使用说明：'."\n";
		$msg .= '第一个参数$post_data :  提交的数组'."\n";
		$msg .= '第二个参数$timeout :    超时时间，默认为5秒'."\n";
		$msg .= '第三个参数$headers :    header头信息，默认为空'."\n";
		$msg .= '第四个参数$return :     返回数据，默认为body'."\n";
		echo $msg;
	}
	
	public static function reset(){
		self::$pname = 'androidc';
		self::$url = 'http://dts.kuaidihelp.com/api.php';
		self::$key = '9ebfea665766969ddf7ee98ef9bd9d38';
		self::$timeout = 5;
	}

	public static function get_request($post_data){
		if(!empty($post_data)){
			$config['pname'] = self::$pname;
			$data = array_merge($config,$post_data);unset($config);
			$json_data = json_encode($data);unset($data);
			$request = array(
					'content' => $json_data,//请求内容
					'token'   => md5($json_data.self::$key),//token值
			);
			unset($json_data);
			return $request;
		}
	}

	/**
	 * curl请求
	 * @param unknown_type $url
	 * @param unknown_type $post_data
	 * @param unknown_type $timeout
	 * @param unknown_type $headers
	 * @return multitype:NULL unknown
	 */
	public static function curl_send($url,$post_data='',$timeout=3,$headers=array(),$crt_path=false){
		print_r($post_data);
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Expect:')); 
		if(!empty($headers)){
			$headers = array_unique($headers);
			curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);			
		}
		if(!empty($post_data)){
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

}
?>