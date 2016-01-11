<?php
/**
 * 4.3	标的信息
 */

class borrow_summary extends api_comm  {
	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {

		//传入的用户名和密码bname
	        $bid      = $this->request_arr['bid'] ;//借标（产品）id   
                if(!$bid){
                    $this->result['code'] = 107;
                    return $sdata = (object)array();
                }
                $data = $this->getSingleList($bid); 
                if(empty($data)){
                    return $sdata = (object)array();
                }
                $sdata['bname'] = $data['borrow_name'];
                $sdata['interest_rate'] = (float)$data['borrow_interest_rate'];
                $sdata['ratio'] = intval(number_format($data['has_borrow']/$data['borrow_money']*100,2,'.',''));
                $sdata['borrow_money'] = (float)$data['borrow_money'];
                $sdata['borrow_duration'] = (float)$data['borrow_duration'];
                $sdata['repayment_type'] = repaymentType($data['repayment_type']);
                $sdata['add_datetime'] = date('Y-m-d H:i:s',$data['add_time']);
                $sdata['borrow_min'] = (float)$data['borrow_min'];
                $sdata['borrow_max'] = (float)$data['borrow_max'];
                $sdata['is_new'] = (int)$data['is_new'];
                $sdata['can_invest_money'] = (float)($data['borrow_money']-$data['has_borrow']);
                $sdata['remained_time'] = (int)$data['collect_time']-time();  //剩余时间
                return $sdata;
        }
        //5.6	产品介绍
	private function getSingleList($bid) {               
                $user = core::Singleton('user.borrow_info');
		$borrowSingle = $user->getSingleBorrow($bid);unset($user);           
                return $borrowSingle;
	}
     
 
}

?>