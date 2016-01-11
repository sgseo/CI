<?php
/**
 * 3.14	用户我的推荐 author:zw
 */

class user_recommend extends api_comm  {

	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {

		//传入的参数
		
		//解析出来的登录用户信息
		$userId = $this->comm_user_infor['id'];		
               if(empty($userId)){
                  return (array)array();
               }
                return $this->getUserRecommend($userId);
	}	
	public function getUserRecommend($userId){
		$zw = core::Singleton('user.member');
		return $zw->getUserRecommend($userId);    
                
                
                
	}
}

?>