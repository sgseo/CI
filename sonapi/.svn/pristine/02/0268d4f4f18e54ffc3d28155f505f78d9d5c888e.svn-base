<?php
/**
 * 4.3	标的信息
 */

class borrow_pact extends api_comm  {
	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {

		//传入的用户名和密码bname
	       $bid      = $this->request_arr['bid'] ;//借标（产品）id
            $data=$this-> getPact($bid);
            //生成借款编号 
           $data['ppid']='CAILAI-0001-'.date('Ymd',$data['first_verify_time']).'-'.$data['id'];
           $data['rday']='每月';
            $data['rtype'] = repaymentType($data['repayment_type']);
           $data['borrow_use_text']= pactUse($data['borrow_use']);
           return $data;
        }
        //5.6	产品介绍
	private function getPact($bid) {               
                $user = core::Singleton('user.borrow_info');
                $bpact = $user->getPact($bid);unset($user);           
                return $bpact;
	}
 
}

?>