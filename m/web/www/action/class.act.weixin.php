<?php
/**
 * 微信应用入口
 * @author whh
 */
class act_weixin extends action{

	
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
	}
	//分享
	function _wexinshareAct(){

	}
	//access_token
	function _accesstokenAct(){
		//$weixin = core::Singleton("comm.application.weixin");
		$test=core::Singleton('comm.remote.wxcurl');
		$test->curl_send(WX_URL_access_token);


		exit();
	}
}



?>