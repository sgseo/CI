<?php
/**
 * 3.5	用户修改密码
 */

class password_modify extends api_comm  {
	

	public function get_response() {

		//传入的用户名和密码
		$userId = $this->comm_user_infor['id'];	  
                $passwd = trim($this->request_arr['passwd']);
                 if(strlen($passwd) < 6){
                    return false;
                }
                 file_put_contents('/tmp/passwd',date('m-d H:i:s')." passwd : ".print_r($passwd,true)."\n",FILE_APPEND);
                $passwd   = md5($passwd);
               
                $ok = $this->modifyUserPass($userId,$passwd);
                 if($ok){
                    
                     return true;
                 }else{
                     return false;
                 }                       
                
        }

        //3.5	用户修改密码
        private function modifyUserPass($userId,$passwd){
                $user = core::Singleton('user.dts_user');
		$isOrNot = $user->modifyUserPassword($userId,$passwd);unset($user);
                return $isOrNot;
        }

}

?>