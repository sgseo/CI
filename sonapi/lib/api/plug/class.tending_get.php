<?php
/**
 * 4.2	投标进行中的标
 */

class tending_get extends api_comm  {
	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {
		//传入的用户名和密码
//		$pageSize      = $this->request_arr['page_size'] ?  $this->request_arr['page_size'] : 50;//每页显示数               
//                $currentPage      = $this->request_arr['page_num'] ? $this->request_arr['page_num'] : 1;  //页码,当前页
                $userId = intval($this->comm_user_infor['id']);
		$result = $this->getTending($userId);
                return (array)$result;

        
                
        }
        
        
	private function getTending($userId) {
               
                $user = core::Singleton('user.borrow_info');
		$investList = $user->getTending($userId);unset($user);           
                return $investList;
	}
//	private function getList($offset,$pageSize) {
//               
//                $user = core::Singleton('user.dts_user');
//		$borrowList = $user->getBorrowList($offset,$pageSize);unset($user);           
//                return $borrowList;
//	}
//    
//        private function getTotal(){
//                $user = core::Singleton('user.dts_user');
//		$total = $user->getBorrowTotal();unset($user);  
//                return $total;
//        }
 
}

?>