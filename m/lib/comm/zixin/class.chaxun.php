<?php
include "class.SoapClientAuth.php";
class chaxun{
	
	public function get_message(){
		ini_set('soap.wsdl_cache_enabled',0);
		ini_set('soap.wsdl_cache_ttl',0);
		

		$url = 'https://vpn.shanghai-cis.com.cn/+webvpn+/index.html';
		
		$post_data = array(
				'tgroup' =>'',
				'next' =>'',
				'tgcookieset' =>'',
				'username'=>'shcljradmin',
				'password'=>'xm8hwvax',
				'Login'=>'登录',				
		);
		$headers = array(
			"Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8",
			"Accept-Encoding:gzip, deflate",
			"Accept-Language:zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3",
			"Connection:keep-alive",
			"Cookie:webvpnx=; webvpnlogin=1; webvpn_state=7@B765E4B420124F7716AA4EA6E75577BC397E7B19; csc_next=%2F%2BCSCO
%2B00756767633A2F2F6A6A6A2E617370662E70627A%2B%2B%2Fwebservice%2Fbatchcredit%3Fwsdl; webvpnlogin=1; webvpnLang=en",
			"Host:vpn.shanghai-cis.com.cn",
			"Referer:https://vpn.shanghai-cis.com.cn/+CSCOE+/logon.html",
			"User-Agent:Mozilla/5.0 (Windows NT 6.1; rv:39.0) Gecko/20100101 Firefox/39.0"
		);
		$link = $this->curl($url,$headers,$post_data);
		$reg = '/webvpn=\s*([^;]+);/is';

		if (preg_match_all($reg,$link['header'],$p))
			$cookiestr = implode(';',$p[1]);
			

		/*
		$options = 	array(
			'location'=>'',
			'uri'=>'',
			'login'=>'shcljradmin',
			'password'=>'z9vpzzu0',
			'trace'=>true,
			'targetNamespace'=>'http://webservice.creditreport.p2p.sino.com/',
			'cookies'=>array('webvpn='.$cookiestr)		
		);
		*/
		
		$context = stream_context_create( array (
            'ssl' => array (
                'verify_peer' => false,
                'allow_self_signed' => true
            ),
        ));
		
		$client = new SoapClientAuth("../../web/www/wsdl.txt", array(  
		    'location' => 'https://vpn.shanghai-cis.com.cn/+CSCO+00756767633A2F2F6A6A6A2E61737066677266672E70627A3A38303830++/webservice/batchcredit?wsdl', // 设置server路径
            'uri' => 'https://vpn.shanghai-cis.com.cn/+CSCO+00756767633A2F2F6A6A6A2E61737066677266672E70627A3A38303830++/webservice/batchcredit?wsdl',
            'login' => 'shcljradmin', // HTTP auth login
            'password' => 'z9vpzzu0', // HTTP auth password
            'trace'=>true,
            'targetNamespace'=>'http://webservice.creditreport.p2p.sino.com/',
			'stream_context'=>$context,
            'cookies'=>array('webvpn='.$cookiestr)
		 ));
		 //$client->__setCookie('webvpn',$cookiestr);

  		// $u = new SoapHeader('http://webservice.creditreport.p2p.sino.com/','MySoapHeader',array('UserName'=>'shcljradmin','PassWord'=>'z9vpzzu0','Accept'=>'text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8','Content-Type'=>'application/x-www-form-urlencoded'),false);

		//添加soapheader
		//$client->__setSoapHeaders($u);

 		
 		

		$param = array(
            'orgcode'=>'Q10152900H5C00',
            'secret'=>'7lr9mgem',
            'plate'=>'1',
            'certtype'=>'0',
            'certno'=>'330823198205055517',
            'name'=>'王红华',
            'reason'=>'06',
            'createtype'=>'1'
        );

		$ret = $client->queryCredit($param);


		
    	$array = $this->objectToArray($ret);
    	
    	$result = json_decode($array['return'],true);
    	var_Dump($result);
		//var_Dump($result[0]['result']);
		  
 
		exit;
	
	}
	
	function objectToArray($e){
	    $e=(array)$e;
	    foreach($e as $k=>$v){
	        if( gettype($v)=='resource' ) return;
	        if( gettype($v)=='object' || gettype($v)=='array' )
	            $e[$k]=(array)$this->objectToArray($v);
	    }
    	return $e;
	}
	
	function curl($url,$headers=array(),$post_data=''){
	    $ch = curl_init();
	    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // 跳过证书检查
	    //curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, true);  // 从证书中检查SSL加密算法是否存在
	    curl_setopt($ch, CURLOPT_URL, $url);
	    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	    curl_setopt($ch, CURLOPT_HEADER, true);
	    curl_setopt($ch, CURLOPT_POST, true);
	    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
	    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
	    $response = curl_exec($ch);
	    $errmsg = curl_error($ch);
	
	    $pos = strpos($response,"\r\n\r\n");
	    return array(
	        'code'=>curl_getinfo($ch,CURLINFO_HTTP_CODE),
	        'header'=>substr($response,0,$pos),
	        'body'=>substr($response,$pos+4),
	        'error'=>$errmsg
	    );
	    //curl_close($ch);
	}
	


}