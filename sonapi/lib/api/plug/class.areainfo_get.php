<?php
/**
 * 子公司 所在区域的 注册人信息
 * time 2015 07 14
 * by lj
 */
class areainfo_get  extends api_comm{
	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {
				//解析出来的用户id 
	 	
	 		//$userId = $this->comm_user_infor['id'];		

	 		$idno=$this->request_arr['idno'];//获取用户身份证号码

	 	//	$phone=$this->request_arr['phone'];//获取用户手机号码

            $zw = $this->getAreaInfo($idno);
            
            return $zw;
		
	}
        private function getAreaInfo($idno){
            $user = core::Singleton('user.area');
			$result=$user->getArea($idno);unset($user); 
			return $result;
        }
	    

}