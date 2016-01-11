<?php
/**
 * 3.15	用户我的借款（还款中的借款） author:zw
 */

class borrowpaying_get extends api_comm  {

	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {
		
		//解析出来的登录用户信息
		$userId = $this->comm_user_infor['id'];		
   
                return $this->getBorrowPaying($userId);
	}	
	public function getBorrowPaying($userId){
		$zw = core::Singleton('user.borrow_info');
		return $zw->getBorrowPaying($userId);    
                
                
                
	}
}

?>