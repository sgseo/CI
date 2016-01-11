<?php
/**
 * 5.9	抵押物信息
 */

class borrow_detailpic extends api_comm  {
	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {
		
	        $bid      = $this->request_arr['bid'] ;// 产品id                                 
                $d = $this->getBorrowePic($bid); 
                $d = unserialize($d);
                if(empty($d)){  
                    return $data=array();
                }
                foreach($d as $k => $v){
                    $data[$k]['pic_url'] = $v['img'];
                    $data[$k]['pic_desc'] = $v['info'];
                }                            
                return $data;
        }
        //5.9	抵押物信息
	private function getBorrowePic($bid) {               
                $user = core::Singleton('user.borrow_info');
		$result = $user->getborrowDetailpic($bid);unset($user);           
                return $result;
	}
     
 
}

?>