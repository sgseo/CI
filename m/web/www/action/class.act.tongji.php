<?php

/**
 * Class act_tongji
 */
class act_tongji extends action
{
    /**
     *
     */
    public function runFirst() {
    	 
    }
    
    /**
     *  用于给网贷之家提供数据
     */
    public function _wangdaizhijiaAct(){


    	$page_size = $_REQUEST['page_size']?$_REQUEST['page_size']:20;
    	$page_num = $_REQUEST['page_num']?$_REQUEST['page_num']:1;
    	$date = $_REQUEST['date']?$_REQUEST['date']:date('Y-m-d',time());
		$date_start = $date.' 00:00:00';
		$date_end = $date.' 23:59:59';
    	$result = array();
    	
    	
    	core::Singleton('comm.remote.remote');
    	//获取当日投标总金额
    	$data['sname'] = 'borrow.amount.sum';    	
    	$data['date'] = $date;
    	$data['where'] = array('borrow_money='=>'has_borrow');
    	$amount_sumarr = transferAPI($data);
    	$amount_sum = $amount_sumarr['data']['borrow_sum'];
    	
    	unset($data);
    	//借贷人信息
		$data['sname'] = 'borrow.list.new';
    	$data['page_size'] = $page_size;
    	$data['page_num'] = $page_num;
    	$data['where'] = array('borrow_money='=>'has_borrow','add_time>'=>strtotime($date_start),'add_time<'=>strtotime($date_end));
        $borrow_list = transferAPI($data);       

        $sum = $borrow_list['data']['sum']?$borrow_list['data']['sum']:0;
        $totalPage = ceil($sum/$page_size);
        if(is_array($borrow_list['data']['list'])){
        	foreach($borrow_list['data']['list'] as $k=>$v){
        		//借贷人信息
        		$result['borrowList'][$k]['projectId'] = $v['bid'];
        		$result['borrowList'][$k]['title'] = $v['bname'];
        		$result['borrowList'][$k]['amount'] = $v['borrow_money'];
        		$result['borrowList'][$k]['schedule'] = $v['ratio'];
        		$result['borrowList'][$k]['interestRate'] = $v['interest_rate'].'%';
        		$result['borrowList'][$k]['deadline'] = $v['borrow_duration'];
        		$result['borrowList'][$k]['deadlineUnit'] = $v['borrow_type']==1?'天':'月';
        		$result['borrowList'][$k]['reward'] = 0;
        		$result['borrowList'][$k]['type'] = '抵押标';
        		$result['borrowList'][$k]['userName'] = $v['borrow_uid'];
        		$result['borrowList'][$k]['loanUrl'] = "https://www.cailai.com/invest/{$v['bid']}.html";
        		$result['borrowList'][$k]['successTime'] = date('Y-m-d H:i:s',$v['full_time']);
        		
        		//1代表：按天到期还款,即使按天；2代表：按月分期还款；3代表：按季分期还款；4：每月还息到期还本；5：一次性还款；1是按天别的都是按月
        		switch($v['borrow_type']){
        			case 1:
        				$repayment_type = 1;
        			break;
        			case 2:
        				$repayment_type = 2;
        			break;
        			case 3:
        				$repayment_type = 3;
        			break;
        			case 4:
        				$repayment_type = 5;
        			break;
        			default:
        				$repayment_type = 5;
        			break;       			
        		}       		
        		$result['borrowList'][$k]['repaymentType'] = $repayment_type;
        		//投资人信息
        		unset($data);
       			$data['sname'] = 'borrow.invest.new';
       			$data['bid'] = $v['bid'];
        		$investor_list = transferAPI($data);

        		if(is_array($investor_list['data'])){
        			foreach($investor_list['data'] as $i=>$j){
        				$result['borrowList'][$k]['subscribes'][$i]['subscribeUserName'] = $j['investorid'];
        				$result['borrowList'][$k]['subscribes'][$i]['amount'] = $j['invest_money'];
        				$result['borrowList'][$k]['subscribes'][$i]['validAmount'] = $j['invest_money'];
        				$result['borrowList'][$k]['subscribes'][$i]['addDate'] = date('Y-m-d H:i:s',$j['invest_time']);
						$result['borrowList'][$k]['subscribes'][$i]['status'] = 1;
        				$result['borrowList'][$k]['subscribes'][$i]['type'] = $j['invest_type'];
						
        			}
        		}
        		
        		//var_dump($investor_list);
        		//var_dump($result);
    			//exit;
        	}   	
        }
        
        //拼接返回数据
        $result['totalPage'] = $totalPage;//总页数
        $result['totalCount'] = $sum;//标总数
        $result['currentPage'] = $page_num;//当前页数
        $result['totalAmount'] = $amount_sum;//当天借款标总金额
		echo $result = json_encode($result);
		exit;
	}
	
	/**
     *  网贷天眼借款数据
     */
    public function _wangdaitianyanjiekuanAct(){
    	$status = $_REQUEST['status']?$_REQUEST['status']:'2';
    	$time_from = $_REQUEST['time_from']?$_REQUEST['time_from']:date('Y-m-d',time()).' 00:00:00';
    	$time_to = $_REQUEST['time_to']?$_REQUEST['time_to']:date('Y-m-d',time()).' 23:59:59';
    	$page_size = $_REQUEST['page_size']?$_REQUEST['page_size']:20;
    	$page_index = $_REQUEST['page_index']?$_REQUEST['page_index']:1;
    	
    	//借贷人信息
    	$data = array();
    	if($status==0){
    		$data['where']['borrow_money<>'] = 'has_borrow';
    	}else if($status==1){
    		$data['where']['borrow_money='] = 'has_borrow';
    	}   	
    	
    	$data['sname'] = 'borrow.list.new';
    	$data['page_size'] = $page_size;
    	$data['page_num'] = $page_index;
    	$data['where']['add_time>'] = strtotime($time_from);
    	$data['where']['add_time<'] = strtotime($time_to);
        $borrow_list = transferAPI($data);  
        if(!empty($borrow_list['data'])){
        	$sum = $borrow_list['data']['sum']?$borrow_list['data']['sum']:0;
        	$totalPage = ceil($sum/$page_size);
        	
        	$result['result_code'] = 1;
        	$result['result_msg'] = '数据获取成功';
        	$result['page_count'] = $totalPage;
        	$result['page_index'] = $page_index;
			
        	if(is_array($borrow_list['data']['list'])){
	        	foreach($borrow_list['data']['list'] as $k=>$v){
	        		$result['loans'][$k]['id'] = $v['bid'];
	        		$result['loans'][$k]['url'] = "https://www.cailai.com/invest/{$v['bid']}.html";
	        		$result['loans'][$k]['platform_name'] = '财来网';
	        		$result['loans'][$k]['title'] = $v['bname'];
	        		$result['loans'][$k]['username'] = $v['borrow_uid'];
	        		$result['loans'][$k]['userid'] = $v['borrow_uid'];
	        		$result['loans'][$k]['status'] = $v['full_time']==0?0:1;
	        		$result['loans'][$k]['c_type'] = 2;
	        		$result['loans'][$k]['amount'] = $v['borrow_money'];
	        		$result['loans'][$k]['rate'] = sprintf("%.4f",$v['interest_rate']/100);
	        		$result['loans'][$k]['period'] = $v['borrow_duration'];
        			$result['loans'][$k]['p_type'] = $v['borrow_type']==1?0:1;
	        		
        			//1代表：按天到期还款,即使按天；2代表：按月分期还款；3代表：按季分期还款；4：每月还息到期还本；5：一次性还款；1是按天别的都是按月
	        		switch($v['borrow_type']){
	        			case 1:
	        				$repayment_type = 3;
	        			break;
	        			case 2:
	        				$repayment_type = 1;
	        			break;
	        			case 3:
	        				$repayment_type = 5;
	        			break;
	        			case 4:
	        				$repayment_type = 2;
	        			break;
	        			case 5:
	        				$repayment_type = 4;
	        			break;
	        			default:
	        				$repayment_type = 0;
	        			break;       			
	        		}  
        			$result['loans'][$k]['pay_way'] = $repayment_type;
        			$result['loans'][$k]['process'] = intval(number_format($v['has_borrow']/$v['borrow_money']*100,2,'.',''))/100;
        			$result['loans'][$k]['reward'] = 0;
        			$result['loans'][$k]['guarantee'] = 0;
  					$result['loans'][$k]['start_time'] = date('Y-m-d H:i:s',$v['add_time']);
  					$result['loans'][$k]['end_time'] = $v['full_time']==0?date('Y-m-d H:i:s',$v['dead_line']):date('Y-m-d H:i:s',$v['full_time']);
	        		$result['loans'][$k]['invest_num'] = 0;
	        		$result['loans'][$k]['c_reward'] = 0;
	        	}
        	}
        }else{
        	$result['code'] = -1;
        	$result['result_msg'] = "未授权的访问！";     	
        	$result['page_count'] = 0;
        	$result['page_index'] = 0;
        	$result['loans'] = null;
        }
        
        
       echo $result = json_encode($result);
	   exit;    	
    }
    
/**
     *  网贷天眼投资数据
     */
    public function _wangdaitianyantouziAct(){
    	$id = $_REQUEST['id']?$_REQUEST['id']:'';
    	$page_size = $_REQUEST['page_size']?$_REQUEST['page_size']:20;
    	$page_index = $_REQUEST['page_index']?$_REQUEST['page_index']:1;
    	$time_from = $_REQUEST['time_from']?$_REQUEST['time_from']:'';
    	$time_to = $_REQUEST['time_to']?$_REQUEST['time_to']:'';
    	
    	
    	//投资人信息
       	$data['sname'] = 'borrow.invest.new';
       	$data['bid'] = $id;
       	if($time_from!=''){
       		$data['where']['b.add_time>'] = strtotime($time_from);
       	}
       	if($time_to!=''){
       		$data['where']['b.add_time<'] = strtotime($time_to);
       	}  	
        $investor_list = transferAPI($data);
             
        if(!empty($investor_list['data'])){
        	
        	$result['result_code'] = 1;
        	$result['result_msg'] = '数据获取成功';
        	$result['page_count'] = 1;
        	$result['page_index'] = 1;
        	
	        if(is_array($investor_list['data'])){
	        	foreach($investor_list['data'] as $k=>$v){
	        		$result['loans'][$k]['id'] = $id;
	        		$result['loans'][$k]['link'] = '';
	        		$result['loans'][$k]['useraddress'] = '';
	        		$result['loans'][$k]['username'] = $v['investorid'];
	        		$result['loans'][$k]['userid'] = $v['investorid'];
	        		$result['loans'][$k]['type'] = '';
	        		$result['loans'][$k]['money'] = sprintf("%.2f",$v['invest_money']);
	        		$result['loans'][$k]['account'] = sprintf("%.2f",$v['invest_money']);
	        		$result['loans'][$k]['status'] = '';
					$result['loans'][$k]['add_time'] = date('Y-m-d H:i:s',$v['invest_time']);
	        	}
	        }
        	
        }else{
        	$result['code'] = -1;
        	$result['result_msg'] = "未授权的访问！";     	
        	$result['page_count'] = 0;
        	$result['page_index'] = 0;
        	$result['loans'] = null;
        }

       echo $result = json_encode($result);
	   exit; 
        
    	
    }
	
}
?>