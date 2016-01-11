<?php
/**
 * c用户登陆 
 */

class user_login extends api_comm  {
	
	public $login_type = 'c'; //表c端用户

	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {

		//传入的用户名和密码
		$uname      = $this->request_arr['mobile'];
		$upwd       = $this->request_arr['passwd'];
		if(empty($uname) || empty($upwd)) {
			$this->result['code'] = 9999; 
//                        $this->result['msg'] = '参数错误';
                        return $result = (object)array(); 
		}
		
		if(!$this->result['code']) {//授权通过

			$a =  $this->login($uname, $upwd);
                        if($a === false){
                            $this->result['code'] = 56;
//                            $this->result['msg'] = '用户名或密码错误';
                            return $result = (object)array();
                        }
                        return $a;
		}else{
                    $this->result['code'] = 55;
                     $this->result['msg'] = '用户名或密码为空';
                    return $result = (object)array();
                }
	}


	//模拟返回值: json
	public function login($uname,$upwd) {
		
		$user = core::Singleton('user.dts_user');
		$userinfo = $user->login($uname,$upwd);unset($user);
		if($userinfo){
			$session_id = $this->login_type . $userinfo['session_id'];
			//设置header cookie值
			header("Set-Cookie: session_id=".$session_id."; expires=" . strftime("%A, %d-%b-%Y %H:%M:%S", time() + (86400)) .  '; path=/; domain=cailai.com');
			
			//转化成接口所需要的格式
			$userinfo2['id'] = (int)$userinfo['id'] ;
			$userinfo2['mobile'] = $userinfo['user_name'] ;
			$userinfo2['reg_time'] = date('Y-m-d H:i:s',$userinfo['reg_time']) ;
			$userinfo2['real_name'] = $userinfo['real_name'] ;
			unset($userinfo);
			return $userinfo2;
		}
		return false;
	}

}

?>