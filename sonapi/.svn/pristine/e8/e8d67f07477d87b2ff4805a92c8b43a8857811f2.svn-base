<?php
/**
 * 	推荐用户的交易记录 
 *  time:20150708
 * 	by lj
 */
class tendbacking_get extends api_comm  {

	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {
		
		//解析出来的登录用户信息
		$userId = $this->$request_arr['id'];	
                $a = $this->getTendBacking($userId);            
                $data =$this->getTendBacking($userId);
                 return $data;
                
	}	
	public function getTendBacking($userId){
		$zw = core::Singleton('user.borrow_info');
		return $zw->getTendBacking($userId);    
                
                
                
	}
}
?>