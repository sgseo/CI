<?php
/**
 * 发起取现
 */

class withdrawals_get extends api_comm  {

	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {
		
		//传入的参数,取消的金额 amount
		$amount      = $this->request_arr['amount'];
		
		//解析出来的用户id 和 用户 手机号码
		 $user_id = $this->comm_user_infor['id'];
		 $user_name = $this->comm_user_infor['mobile'];
		 
                $blackList = $this->getBlackList();
                 if(in_array($user_name,$blackList)){
                     $this->result['code'] = 113;
                     return;
                 }
                 
		 $usrid = get_user_usrid($user_id);
		 if(empty($usrid)){
		 	$this->result['code'] = 500;
		 	$this->result['msg'] = "账号还未进行实名认证，请到更多->我的账户->身份认证";
		 	return ;
		 }
		 
                 //判断用户是否实名认证
		//$realName = getRealName($user_id);
//                 if(empty($realName['real_name'])){
//                   return get_authentication_param($user_name);
//                    exit;
//                }
                
		//手续费的算法还需要调整 千3
		$fee = ( $amount * 3 )/1000;
		
		//汇付那边标记的用户id
	        $usrid = get_user_usrid($user_id);;
		
                //判断用户是否绑定银行卡               
                 $bankInfo = getBankNum($user_id);
                if(empty($bankInfo)){
                	$this->result['code'] = 501;
                	$this->result['msg'] = "该账号暂未绑定银行卡，请到更多->我的账户->绑定银行卡";
                	return ;
                    //return bandBank($usrid);
                }
                
                $userMoney = $this->getUserMoney($user_id);         
                $accountMoney = $userMoney['account_money'] + $userMoney['back_money'];
                if($amount > $accountMoney){
                        $this->result['code'] = 112;
                	$this->result['msg'] = "提现金额不能超过账号余额";
                	return false ;
                }
              
		$data['act'] = 'withdrawals.get';
		$data['usrid'] = $usrid;
		$data['amount'] = $amount;
		$data['fee'] = $fee;
		$data['cashChl'] = '';//取款方式
		//return $data;
		return goHuiFuPlant($data);
	}
	
        public function getUserMoney($user_id){
	
		$member = core::Singleton('user.member');
		return $member->getUserMoney($user_id);
	}
        
        public function getBlackList(){
	
		$member = core::Singleton('user.member');
		return $member->getBlackList();
	}
        
//	
        
//         //跳转到汇付那边的平台
//        private function goHuiFuPlant($data){
//                require_once('config/config.comm.php');
//		$url = _INTERFACE_HUIFU_URL;
//		$res =  curl_send($url,http_build_query($data));
//
//            return json_decode($res,true);
//        }
	


}


/*
 * 原来的代码
 * 
 * $transamt = $_POST['money'];//提现金额
		$cashChl=$_POST['cashChl'];//提现方式zh&hgq
		$totalinvestor = M("borrow_investor")->where("investor_uid=".$this->uid)->sum("investor_capital");//充值资金池的投资金额
		$borrow_cap = M("borrow_info")->where("borrow_uid=".$this->uid)->sum("borrow_money");//累计借款金额
		$totalpay = M("member_paylog")->where("uid=".$this->uid)->sum("transamt");//累计充值金额
		$totalwithdraw = M("member_withdrawlog")->where("uid=".$this->uid)->sum("transamt");
		$account = M("member_money")->field("account_money,back_money")->where("uid=".$this->uid)->find();
		$accountmoney = $account['account_money']+$account['back_money'];//充值资金池可用余额+回款资金池可用余额
		
		if($transamt>$accountmoney)
		{
			echo "余额不足，不允许提现！";exit;
		}
		else if($totalinvestor+$borrow_cap<$totalwithdraw)
		{
			$datag = get_global_setting();
			$fee_tqtx = $datag['fee_tqtx'];
			$feerate = explode('|',$fee_tqtx);
			$fee = $transamt*$feerate[0]/100;
		}
		else
		{
			$datag = get_global_setting();
			$fee_tqtx = $datag['fee_tqtx'];
			$feerate = explode('|',$fee_tqtx);
			$cae = ($totalinvestor+$borrow_cap)-$totalwithdraw;
			if($cae>=$transamt)
			{
				$fee = $transamt*$feerate[1]/100;
			}
			else
			{
				$fee = ($cae*$feerate[1]+($transamt-$cae)*$feerate[0])/100;
			}
		}
		//echo $fee;exit;
		
		$info = M("members")->field("usrid")->where("id=".$this->uid)->find();
		$usrid = $info['usrid'];
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$huifu->cash($usrid,$transamt,$fee,$cashChl);//增加$cashChl参数zh&hgq
 */
?>