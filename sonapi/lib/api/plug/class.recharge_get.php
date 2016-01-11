<?php
/**
 * 发起充值
 */

class recharge_get extends api_comm  {

	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {

		//传入的参数,充值的金额 amount
		$amount      = $this->request_arr['amount'];
		
		//解析出来的用户id 和 用户 手机号码
		$user_id = $this->comm_user_infor['id'];
		$user_name = $this->comm_user_infor['mobile'];
		
		//汇付那边标记的用户id
//		$usrid =  $this->get_user_usrid($user_id);
                
//                $realName = getRealName($user_id);
//                if(empty($realName['real_name'])){
//                   return get_authentication_param($user_name);
//                    exit;
//                }
                
                $usrid = get_user_usrid($user_id);             
		if(empty($usrid)){
			$this->result['code'] = 500;
			$this->result['msg'] = "账号还未进行实名认证，请到更多->我的账户->身份认证";
			return ;
		}
		
		$data['act'] = 'recharge.get';
		$data['usrid'] = $usrid;
		$data['amount'] = $amount;
		
		return goHuiFuPlant($data);
	}

	
//	public function get_recharge_param($data){
//	
//		require_once('config/config.comm.php');
//		$url = _INTERFACE_HUIFU_URL;
//		$res =  curl_send($url,http_build_query($data));
//		
//		return json_decode($res,true);
//		//return $res;
//	}
	


}

?>