<?php
/**
 * 我的资产
 */

class member_capital extends api_comm  {

	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {

		//传入的参数		 
		//解析出来的登录用户信息
		$user_id = $this->comm_user_infor['id'];
//		$user_name = $this->comm_user_infor['mobile'];
                if($user_id){
                   return $myCapital = $this->get_capital($user_id);
                    
                }else{
                    return $data = (object)array();
                }
		
	}
	
	public function get_capital($user_id){

		$member = core::Singleton('user.member');
		return $member->get_capital($user_id);
	}


}

?>