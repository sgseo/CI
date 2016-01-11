<?php
/**
 * 3.13	用户我的交易记录 author:zw
 */

class deal_record extends api_comm  {

	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {

		//传入的参数
		
		//解析出来的登录用户信息
		$userId = $this->comm_user_infor['id'];		
                $pageSize      = $this->request_arr['page_size'] ? $this->request_arr['page_size'] : 15; //  每页显示数
                $pageNum      = $this->request_arr['page_num'] ? $this->request_arr['page_num']:1;//当前页       
                $total =  $this->getDealTotal($userId);
                $totalPage = ceil($total/$pageSize);
                $offset = ($pageNum-1)*$pageSize;
                if($pageNum < 0 || $pageNum > $totalPage){
                    return $data = (array)array();
                }
                $data = $this->getDealRecord($userId,$offset,$pageSize);
                return $data;
                
	}	
	public function getDealRecord($userId,$offset,$pageSize){
		$zw = core::Singleton('user.member_moneylog');
		return $zw->getDealRecord($userId,$offset,$pageSize);        
                
	}

       //获得交易总数
        public function getDealTotal($userId){
             $zw = core::Singleton('user.member_moneylog');
	     return $zw->getDealTotal($userId);
        }
}

?>