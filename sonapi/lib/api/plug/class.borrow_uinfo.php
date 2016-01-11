<?php
/**
 * 5.8	借款人信息
 */

class borrow_uinfo extends api_comm  {
	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {
		
	        $bid      = $this->request_arr['bid'] ;//借标（产品）id                                           
                $data = $this->getBorrower($bid); 
                $ddata=array();
                if(empty($data)){
                    return (object)$ddata;
                }
                $data['age'] = (int)$data['age'];                
                return (array)$data;
        }
        //5.6	产品介绍
	private function getBorrower($bid) {               
                $user = core::Singleton('user.borrow_info');
		$result = $user->getBorrowerInfo($bid);unset($user);
		if(isset($result['user_email'])){//敏感信息不显示
			unset($result['user_email']);
		}
                return $result;
	}
     
 
}

?>