<?php
/**
 * 3.12	用户我的银行卡  author：zw
 */

class user_bank extends api_comm  {

	/**
	 * 设置响应的消息体  返回值必须是jsonD:\wamp\www\testcailai\Style\M\images\bank
	 * 
	 */
	public function get_response() {		
		//解析出来的登录用户信息
		$userId = $this->comm_user_infor['id'];
                $banks = array('ICBC'=>'工商银行','ABC'=>'农行','CMB'=>'招行','CCB'=>'建设银行','BCCB'=>'北京银行','BJRCB'=>'北京农村商业银行','BOC'=>'中国银行',
                    'BOCOM'=>'交通银行','CMBC'=>'民生银行','BOS'=>'上海银行','CBHB'=>'渤海银行','CEB'=>'光大银行','CIB'=>'兴业银行','CITIC'=>'中信银行','CZB'=>'浙商银行',
                    'GDB'=>'广发银行','HKBEA'=>'东亚银行','HXB'=>'华夏银行',
                    'HZCB'=>'杭州银行','NJCB'=>'南京银行','PINGAN'=>'平安银行','PSBC'=>'邮储银行','SDB'=>'深发银行','SPDB'=>'浦发','SRCB'=>'上海农村商业银行');
                $bankInfo = $this->getUserBank($userId);
                $data = array();
                $hostName = HOST_NAME;
                if(!empty($bankInfo)){
                    $data['bank_name'] = $banks[$bankInfo['bank_name']];
                    $data['bank_number'] = $bankInfo['bank_num'];
                    $data['is_quick'] = true;
                    $data['bank_icon'] = $hostName.'Style/M/images/bankicon/'.strtolower($bankInfo['bank_name']).'.png';
                    return $data;
                }else{
                    return $data = (object)array();
                }
		
	}
	
	public function getUserBank($userId){

		$member = core::Singleton('user.member_banks');
		return $member->getUserBank($userId);
	}


}

?>