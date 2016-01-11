<?php
/**
 * 	推荐用户的交易记录 
 *  time:20150906
 * 	by lj
 */
class redpacket extends api_comm  {

	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {
		
		//解析出来的登录用户信息
		$userId =$this->comm_user_infor['id'];	
        $data =$this->reds($userId);
        return $data;
                
	}	
	public function reds($userId){
		$zw = core::Singleton('user.receive');
		return $zw->reds($userId);    
                
	}
}
?>