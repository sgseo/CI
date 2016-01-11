<?php
/**
 * 手机验证码 author:zw
 */

class vcode_get extends api_comm  {
	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {

		//传入的用户名和密码
		$uname      = trim($this->request_arr['mobile']);
               
               if(preg_match("/^1[34578]\d{9}$/", $uname)){
                $ok = $this->isRegisted($uname); 
                   if(!$ok){
                       return $this->sendsmscode($uname);
                   }else{
                       $this->result['code'] = 52;
                       $this->result['msg'] = "手机号已经注册";
                       return false;
                   }
                    
                }else{
                     $this->result['code'] = 51;
                     $this->result['msg'] = "手机号不合法";
                    return false;
                }  

                
        }

         //判断用户是否已经注册
        private function isRegisted($mobile){
                $user = core::Singleton('user.dts_user');
		$isOrNot = $user->is_exist_cell_phone_number($mobile);unset($user);
                return $isOrNot;
        }
        
	private function sendsmscode($mobile) {
                $data['telephone'] = $mobile;
                $data['cur_time'] = time();   
                $arr = range(0,9);
                $arrs = array_rand($arr,6);
                $sendsms = "";
                foreach($arrs as $value){
                    $smscode .= $value; 
                }
                $data['telcode'] = $smscode;
                $user = core::Singleton('user.dts_user');
		$admin = $user->addCode($data);unset($user);
                sendsms($mobile, '欢迎注册财来网，您的注册短信验证码为' . $smscode . '，30分钟内有效!');  
                if($admin){
                    return true;
                }else{
                    return false;
                }
                
		
	}
    
 
}

?>