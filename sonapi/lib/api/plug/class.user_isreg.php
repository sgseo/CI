<?php
/**
 * c判断用户是否已经注册
 */

class user_isreg extends api_comm  {
	
	public function get_response() {

		//传入的用户名和密码
		$mobile      = $this->request_arr['mobile'];
                if(preg_match("/^1[34578]\d{9}$/", $mobile)){  
                    $ok = $this->isRegisted($mobile); 
                    if($ok){
                        return true;
                    }else{
                        return false;
                    }
                   
                }else{
                    return true;//手机号不合法
                }
        }

        //判断用户是否已经注册
        private function isRegisted($mobile){
                $user = core::Singleton('user.dts_user');
		$isOrNot = $user->is_exist_cell_phone_number($mobile);unset($user);
                return $isOrNot;
        }
}
?>