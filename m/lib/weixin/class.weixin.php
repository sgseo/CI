<?php
/**
 * 微信管理
 */

class weixin {
	
	public $token  = 'cailai123';

	public function weixin(){
		//require_once ("config/config.weixin.php");
	}
	
	public function checkSignature($signature,$timestamp,$nonce){
	$token = $this->token;
	$tmpArr = array($token, $timestamp, $nonce);
	sort($tmpArr, SORT_STRING);
	$tmpStr = implode( $tmpArr );
	$tmpStr = sha1( $tmpStr );
	
	if( $tmpStr == $signature ){
		return true;
	}else{
		return false;
	}
}

	public function check($signature,$timestamp,$nonce) {
		
		if($signature && $timestamp && $nonce && $this->has_token()) {
			$token = $this->token;
			$tmpArr = array($token, $timestamp, $nonce);
			sort($tmpArr, SORT_STRING);
			$tmpStr = implode( $tmpArr );
			$tmpStr = sha1( $tmpStr );
			if( $tmpStr == $signature ){
				return true;
			}
		}
		return false;
	}
		
	public function has_token(){

		return true;
	}
}