<?php
/**
 * 微信应用入口
 * @author whh
 */
class act_wx extends action{

	
	function runFirst() {
		ob_clean();
	}

	function _homeAct() {
	}
	
	/**
	 * 合法性验证
	 * 文档地址：http://mp.weixin.qq.com/wiki/index.php?title=%E6%8E%A5%E5%85%A5%E6%8C%87%E5%8D%97
	 */
	function _yanzhengAct() {
		define("TOKEN", "cailai123");
		$wechatObj = new wechatCallbackapiTest();
		$wechatObj->valid();
		exit;
	}

}
///////////////
class wechatCallbackapiTest
{
	public function valid()
    {
        $echoStr = $_REQUEST["echostr"];

        //valid signature , option
        if($this->checkSignature()){
			 file_put_contents('/tmp/debug',date('m-d H:i:s')." ".print_r($_REQUEST,true)."\n",FILE_APPEND);
			 file_put_contents('/tmp/debug',date('m-d H:i:s')." echoStr;".print_r($echoStr,true)."\n",FILE_APPEND);
        	echo $echoStr;
        }else{
			echo 'wrong';
		}
		exit;
    }

		
	private function checkSignature()
	{
        // you must define TOKEN by yourself
        if (!defined("TOKEN")) {
            throw new Exception('TOKEN is not defined!');
        }
        
        $signature = $_REQUEST["signature"];
        $timestamp = $_REQUEST["timestamp"];
        $nonce = $_REQUEST["nonce"];
        		
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
///
?>