<?php
/**
 * 月份的收款计划
 * time:20150709
 * by lj
 */

class receive_plan extends api_comm{

	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {
				//解析出来的用户id 
	 	
	 		$userId = $this->comm_user_infor['id'];		

	 		$search_month=$this->request_arr['search_month']?$this->request_arr['search_month']:date('m');//获取用户搜索的月份

	 		$year=$this->request_arr['search_year']?$this->request_arr['search_year']:date('Y');

	        $zw = $this->getReceivePlan($userId,$year,$search_month);

            return $zw;	
	}
        private function getReceivePlan($userId,$year,$search_month){
            $user = core::Singleton('user.receive');
			$result=$user->getMyInvest($userId,$year,$search_month);unset($user); 
			return $result;
        }
	    





}