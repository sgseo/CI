<?php
/**
 * 发起认证
 */

class authentication_get extends api_comm  {

	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {

		//解析出来的用户id 和 用户 手机号码
		//$user_id = $this->comm_user_infor['id'];
		$user_name = $this->comm_user_infor['mobile'];
	        $user_id = (int)$this->comm_user_infor['id'];
                
                $realName = $this->getRealName($user_id);
                if(!empty($realName['real_name'])){
                    $data['isVerified'] = false;
                    return $data;
                }
                
		//电话与用户名一样
		$telephone = $user_name;
		//email拼凑
		$email = $user_name . '@163.com';
		
		$data = array(
				'act' => 'user.reg',
				'username' => $user_name,
				'telephone' => $telephone,
				'email' => $email
		);
		
		return $this->get_authentication_param($data);
	}
	
	public function get_authentication_param($data){
		require_once('config/config.comm.php');
		$url = _INTERFACE_HUIFU_URL;
		$res =  curl_send($url,http_build_query($data));
		
		return json_decode($res,true);
		//return $res;
	}
	
	private function getRealName($user_id){
             $user = core::Singleton('user.borrow_info');
             $result = $user->getRealName($user_id);unset($user);           
             return $result;
        }


}

?>