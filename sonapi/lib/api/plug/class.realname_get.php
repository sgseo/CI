<?php
/**
 * 发起取现
 */

class realname_get extends api_comm  {

	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {
		//解析出来的用户id 和 用户 手机号码
		 $user_id = (int)$this->comm_user_infor['id'];
	         
                 $zw = $this->getRealName($user_id);
                 if(!$zw['real_name']){
                     return (object)array();
                 }
               return $zw;
		
	}
        private function getRealName($user_id){
             $user = core::Singleton('user.borrow_info');
             $result = $user->getRealName($user_id);unset($user);           
             return $result;
        }
	    

}

?>