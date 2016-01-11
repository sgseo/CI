<?php
/**
 *4.1	精选标
 */

class topborrow_get extends api_comm  {
	/**
	 * 4.1	精选标
	 * 
	 */
	public function get_response() {
	
//            $list[$key]['progress'] = number_format($v['has_borrow']/$v['borrow_money']*100,2);
//            
             $data = $this->getTopBorrow();
             if(empty($data)){
                 return $rdata=(object)array();
             }
             $rdata['id'] = (int)$data['id'];
             $rdata['bname'] = $data['borrow_name'];
             $rdata['interest_rate'] = (float)$data['borrow_interest_rate'];
             $rdata['ratio'] = intval(number_format($data['has_borrow']/$data['borrow_money']*100,2,'.',''));
             $rdata['borrow_money'] = (float)$data['borrow_money'];
             $rdata['borrow_duration'] = (float)$data['borrow_duration'];
             $rdata['borrow_min'] = (float)$data['borrow_min'];
              return $rdata;
                
        }
	private function getTopBorrow() {
                $zw = core::Singleton('user.borrow_info');
		return  $zw->getLastBorrow();	
	}
    
 
}

?>