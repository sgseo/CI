<?php
/**
 *4.4	标的介绍
 */

class borrow_detail extends api_comm  {
	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {
		
	        $bid      = $this->request_arr['bid'] ;//借标（产品）id   
                if(!$bid){
                    $this->result['code'] = 107;
                    return $sdata = (object)array();
                }
                $data = $this->getDescription($bid); 
                $ddata=array(); 
                if(empty($data)){
                    return (object)$ddata;
                }
                $ddata['desc'] = $data;
                return $ddata;
        }
        //5.6	产品介绍
	private function getDescription($bid) {               
                $user = core::Singleton('user.borrow_info');
		$result = $user->getBorrowDescription($bid);unset($user);           
                return $result;
	}
     
 
}

?>