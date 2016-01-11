<?php
/**
 * 	我推荐的用户今天的投资记录 
 *  time:20150715
 * 	by lj
 */
class todayinvest_get extends api_comm  {

	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {
		
		//解析出来的登录用户信息
		//$userId = $this->request_arr['userId'];
	      
	    $userId = $this->comm_user_infor['id'];	

        $data =$this->getTodayInvest($userId);

        return $data;
                
	}	
	public function getTodayInvest($userId){
		$lj = core::Singleton('user.borrow_info');
		
		$result=$lj->getTodayInvest($userId);unset($lj);   

		return $result;
	}
}
?>