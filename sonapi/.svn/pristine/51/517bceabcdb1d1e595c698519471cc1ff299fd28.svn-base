<?php
/**
 * 3.16	用户我的投资（回收中的投资）   author:zw
 */

class tendbacking_get extends api_comm  {

	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {
		
		//解析出来的登录用户信息
		$userId = $this->comm_user_infor['id'];	
      
        $data =$this->getTendBacking($userId);
         return $data;
                
	}	
	public function getTendBacking($userId){
		$zw = core::Singleton('user.borrow_info');
		return $zw->getTendBacking($userId);    
                
                
                
	}
}

?>