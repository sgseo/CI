<?php
/**
  *qqqqqqqqqq
  */  
 
//define your token
define("TOKEN", "cailai123");
$wechatObj = new wechatCallbackapiTest();
$wechatObj->valid();

class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_GET["echostr"];

        //valid signature , option
        if($this->checkSignature()){
			file_put_contents('/tmp/debug',date('H:i:s').': '.print_r(file_get_contents('php://input', 'r'),true). ' '.print_r($_REQUEST,true) . ' '.print_r($_SERVER,true),FILE_APPEND);
        	echo $echoStr;
        	exit;
        }
    }

	
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_GET["signature"];
        $timestamp = $_GET["timestamp"];
        $nonce = $_GET["nonce"];
        		
		$token = TOKEN;
		$tmpArr = array($token, $timestamp, $nonce);
        // use SORT_STRING rule
		sort($tmpArr, SORT_STRING);
		$tmpStr = implode( $tmpArr );
		$tmpStr = sha1( $tmpStr );
		
		if( $tmpStr == $signature ){
			return true;
		}else{
			return false;
		}
	}
}

?>