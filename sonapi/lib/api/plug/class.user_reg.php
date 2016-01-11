<?php
/**
 * c用户注册
 */

class user_reg extends api_comm  {

    	public function get_response() {

		//传入的用户名和密码
		$mobile      = $this->request_arr['mobile'];
		$passwd   = $this->request_arr['passwd'];
                $telcode     = $this->request_arr['telcode'];
                $register     = $this->request_arr['recommended'];
                $from_channel     = $this->request_arr['pname'];

               if(!$telcode){
                   $this->result['code'] = 50;
                   $this->result['msg'] = "验证码不能为空";
                   return $data = (object)array();;//操作失败
               }
               if(strlen($passwd) < 6){
                   $this->result['code'] = 58;   
                   return false;//密码不能小于6位
               }
                if(preg_match("/^1[34578]\d{9}$/", $mobile)){  
                    $ok = $this->isRegisted($mobile);                 
                    if(!$ok){
                        $code = $this->getelCode(trim($mobile));
                        if($telcode == $code['telcode']){
                                $register = trim($register);
                                if(!empty($register)){
                                   $registerid = $this->getRecommenderid($register); 
                                    if($registerid){
                                        $datar['recommend_id'] = $registerid;
                                    }else{
                                        $this->result['code'] = 57;
                                        $this->result['msg'] = '推荐人手机号不存在';
                                         return false;//推荐人不存在
                                    }
                                   
                                }else{
                                    $datar['recommend_id'] = 0;
                                }                            
                                $datar['user_name'] = $mobile;
                                $datar['user_pass'] = md5($passwd);
                                $datar['user_phone'] = $mobile;
                                $datar['user_email'] = $mobile.'@139.com';
                                
                                $datar['reg_time'] = time();
                                $datar['reg_ip'] = get_client_ip();
                                $datar['last_log_time'] = time();
                                $datar['last_log_ip'] = get_client_ip();
								$datar['from_channel'] = $from_channel;

                                $uid = $this->addRegister($datar);
                                file_put_contents('/tmp/reguser',date('m-d H:i:s')." 密码：$passwd : ".print_r($datar,true)."\n",FILE_APPEND);
                                if($uid){
                                    $info['cell_phone'] = $mobile;
                                    $info['uid'] = $uid;
                                    $mresult = $this->addMemberInfo($info);
                                    $data['id'] = $uid;//操作成功
                                    $data['mobile'] = $mobile;//验证码正确
                                    $data['real_name'] = '';//手机号ok
                                    $data['reg_time'] = $datar['reg_time'];
                                    return $data;
                                }else{ 
                                    $this->result['code'] = 54;
                                    $this->result['msg'] = "注册失败";
                                    return $data = (object)array();;//操作失败
                                }
                    
                        }else{
                            $this->result['code'] = 53;
                            $this->result['msg'] = "验证码不正确";
                            return $data = (object)array();//验证码不正确
                        }
                    }else{
                       $this->result['code'] = 52;
                       $this->result['msg'] = "手机号已经注册";
                       return $data = (object)array();//手机号已经注册
                    }
                   
                }else{
                   $this->result['code'] = 51;
                   $this->result['msg'] = "手机号不合法";
                    return $data = (object)array();//手机号不合法
                }                 
                
                
        }
   
        //判断用户是否已经注册
        private function isRegisted($mobile){
                $user = core::Singleton('user.dts_user');
		$isOrNot = $user->is_exist_cell_phone_number($mobile);unset($user);
                return $isOrNot;
        }
//
//	//获得手机验证码
	private function getelCode($mobile) {	
		$user = core::Singleton('user.dts_user');
		$codeInfo = $user->fetchCode($mobile);unset($user);
		if($codeInfo){
			
			return $codeInfo;
		}
		return false;
	}
        
        //添加注册用户
        private function addRegister($datar) {
		
            	
            
		$user = core::Singleton('user.dts_user');
		$result = $user->addRegistUser($datar);unset($user);
		if($result){
			return $result;
                        
		}else{
                    return false;
                }
		
	}
        //获得推荐人id
       private function getRecommenderid($register){
               $user = core::Singleton('user.dts_user');
               $registerid = $user->fetchRegisterid($register);unset($user);
               if(!empty($registerid)){
                   return $registerid;
               }else{
                   return false;
               }
               
       }
       
         //添加注册用户信息
        private function addMemberInfo($datam) {
		$user = core::Singleton('user.dts_user');
		$result = $user->addFirstMemberInfo($datam);unset($user);		
		return $result;
		
	}

}

?>