<?php
/**
 * 5.10	投标记录
 */

class borrow_invest extends api_comm  {
	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {
		
	        $bid      = $this->request_arr['bid'] ;//借标（产品）id     
                //invest_type 1:自动投标  0：手动投标
                $d = $this->getBorrowInvest($bid);          
                if(empty($d)){
                    return $data=array();
                }
                
                return $d;
        }
        //5.10	投标记录
	private function getBorrowInvest($bid) {               
                $user = core::Singleton('user.borrow_info');
		$result = $user->getBorrowInvest($bid);unset($user);           
                return $result;
	}
     
 
}

?>