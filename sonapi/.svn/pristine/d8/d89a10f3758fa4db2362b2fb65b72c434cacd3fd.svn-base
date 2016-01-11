<?php
/**
 * 发起取现
 */

class bind_bank extends api_comm  {

	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {
		//解析出来的用户id 和 用户 手机号码
		 $user_id = $this->comm_user_infor['id'];
		 $user_name = $this->comm_user_infor['mobile'];
          
                  //判断用户是否实名认证
//		$realName = getRealName($user_id);
//                 if(empty($realName['real_name'])){
//                   return get_authentication_param($user_name);
//                    exit;
//                }
		 
		 
	        $usrid = get_user_usrid($user_id);
	        if(empty($usrid)){
	        	$this->result['code'] = 500;
	        	$this->result['msg'] = "账号还未进行实名认证，请到更多->我的账户->身份认证";
	        	return ;
	        }
                $bankInfo = getBankNum($user_id);
                if(empty($bankInfo)){
                    return bandBank($usrid);
                }else{
                    $this->result['code'] = 111;
                    $this->result['msg'] = "该账号已绑定银行卡";
                    return false;
                }
               
		
	}
	    

}

?>