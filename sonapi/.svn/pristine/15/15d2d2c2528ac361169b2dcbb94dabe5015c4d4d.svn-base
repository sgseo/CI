<?php
/**
 * 4.2	标的列表
 */

class borrow_list extends api_comm  {
	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {
		//传入的用户名和密码
		$pageSize      = $this->request_arr['page_size'] ?  $this->request_arr['page_size'] : 50;//每页显示数               
                $currentPage      = $this->request_arr['page_num'] ? $this->request_arr['page_num'] : 1;  //页码,当前页
                $total = $this->getTotal(); //总页数
                $pageNum = ceil($total/$pageSize);
                $data = (array)array();
                //传入的页数参数$currentPage 大于总页数 $pageNum，则返回空数组
                If($currentPage>$pageNum || $currentPage == 0){
                    return $data;
                }
                $offset = ($currentPage-1)*$pageSize;
                $listData = $this->getList($offset,$pageSize);
                //id ,,,,,,has_borrow,
                if(empty($listData)){
                     return $data;
                }
                foreach($listData as $k=>$v){
                    $backList[$k]['bid'] = (int)$v['id'];
                    $backList[$k]['bname'] = $v['borrow_name'];
                    $backList[$k]['interest_rate'] = (int) $v['borrow_interest_rate'];
                    $backList[$k]['ratio'] = intval(number_format($v['has_borrow']/$v['borrow_money']*100,2,'.',''));
                    $backList[$k]['borrow_money'] = floatval(number_format($v['borrow_money'],2,'.',''));
                    $backList[$k]['borrow_duration'] = (float)$v['borrow_duration'];
                    $backList[$k]['borrow_type'] = repaymentType($v['repayment_type']);
                    $backList[$k]['borrow_min'] = intval($v['borrow_min']); 
                    
                    if($v['borrow_status'] == 3){
                        $backList[$k]['borrow_status'] = '已流标';  
                    }elseif($v['borrow_status'] == 4){
                        $backList[$k]['borrow_status'] = '复审中'; 
                    }elseif($v['borrow_status'] == 6){
                        $backList[$k]['borrow_status'] = '还款中';  
                    }elseif($v['borrow_status'] > 6){
                        $backList[$k]['borrow_status'] = '已完成'; 
                    }else{
                        $backList[$k]['borrow_status'] = '立即投标'; 
                    }      
              
                }
                return $backList;
                
        }
	private function getList($offset,$pageSize) {
               
                $user = core::Singleton('user.dts_user');
		$borrowList = $user->getBorrowList($offset,$pageSize);unset($user);           
                return $borrowList;
	}
     //获取借标总数
        private function getTotal(){
                $user = core::Singleton('user.dts_user');
		$total = $user->getBorrowTotal();unset($user);  
                return $total;
        }
 
}

?>