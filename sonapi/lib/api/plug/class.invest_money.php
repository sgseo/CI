<?php
/**
 * 在线投标
 */

class invest_money extends api_comm  {
	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {
      //解析出来的登录用户信息
		 $userId = intval($this->comm_user_infor['id']);
		 $transamt = intval($this->request_arr['money']); 
     $bid = (int)$this->request_arr['bid'];
     $user_name = $this->comm_user_infor['mobile'];
      //红包id 和红包面值 2015-09-11
     $redid=$this->request_arr['redid'];
     $redvalue=number_format($this->request_arr['redvalue'],2);
     /*把红包的处理程序写到这里（待完成）*/
      if($redvalue!=0)
      {
      $ext=array('Vocher'=>array('AcctId'=>'MDT000001','VocherAmt'=>$redvalue));
      $reqExt=$ext;
      }
            /*============201509-18 by lj=============*/
      //红包数据入表 active_redpacket
      $reddata=array();
      $reddata['borrow_id']=$bid;
      $reddata['redid']=$redid;
      $reddata['usetime']=time();

      //$reddata['is_used']='1';//因为是枚举字段所以要加上引号 否则修改不了

      $reddata['transamt']=$transamt;//投资的钱

      $usrid = get_user_usrid($userId);
		if(empty($usrid)){
			$this->result['code'] = 500;
			$this->result['msg'] = "账号未进行实名认证，请到更多->我的账户->身份认证";
			return ;
		}
  
     $m = $this->getMemberMoney($userId);  
     $amoney = $m['account_money']+$m['back_money'];
     //判断是否使用红包
     if($redvalue)
     {
     $transamt=$transamt-$redvalue;
     }
     if($amoney < $transamt){
         $this->result['code'] = 104;
         $this->result['msg'] = "您的账户金额小于投标的金额";
         $userData['account_money'] = $amoney;
         return $userData;//用户的金额小于投标的金额
     }
     $bi = $this->getBorrowInfo($bid);        
     if($userId==$bi['borrow_uid']){
         $this->result['code'] = 105;
         $this->result['msg'] = "自己不能投自己";
         return false;
     }
      // if($transamt % $bi['borrow_min'] !=0 ){
      //     $this->result['code'] =110;
      //     return false;//投资金额必须是最小投资金额的整数倍!；
      // } 
     
     if( $transamt > $bi['borrow_max'] && $bi['borrow_max'] > 0 ){
         $this->result['code'] = 108;
         return false;//投的金额大于了最大投资金额
     }
     if($bi['is_new']==1){
         $investMoney = $this->isFirstInvest($userId);
         if(!empty($investMoney) || $investMoney >= 100 ){
             $this->result['code'] = 109;
             return false;//该用户不是首次投标 不能投新手标
         }
     }
     $borrow_min = $bi['borrow_min'];
     $needMoney = $bi['borrow_money'] - $bi['has_borrow'];
     $okmoney = $transamt - $borrow_min; //小于0代表小于最小投资金额了
     $canmoney = $needMoney - $transamt;//小于0代表超过了满标总数了
     if($okmoney<0 || $needMoney <=0 || $canmoney < 0){
         $this->result['code'] = 106;
         $this->result['msg'] = "投的金额小于最小投标金额 或者标已经满了或者超过了满标总数了";
         return false;  //投的金额小于最小投标金额 或者标已经满了
     }
     
     $usrid  = $this->getInvestUsrid($userId);
     $borrowerInfo  = $this->getBorrowUsrid($bid);
     $borrowerid = $borrowerInfo['usrid'];
     $data['act'] = 'invest.money';
     $data['usrid'] = $usrid;
       if($redvalue)
     {
     $transamt=$transamt+$redvalue;
     }
     $data['transamt'] = $transamt;
     $data['borrowerid'] = $borrowerid;
     $data['borrowid'] = $bid; 
     //201509-11 lj
     $data['reqext']=$reqExt;
     file_put_contents('/tmp/zw2.txt',date('m-d H:i:s')."borrowerid ".print_r($borrowerid,true)."\n",FILE_APPEND); 
     file_put_contents('/tmp/zw2.txt',date('m-d H:i:s')."bid ".print_r($bid,true)."\n",FILE_APPEND); 
     file_put_contents('/tmp/zw2.txt',date('m-d H:i:s')."data ".print_r($data,true)."\n",FILE_APPEND);
     file_put_contents('/tmp/zw2.txt',date('m-d H:i:s')."reqExt ".print_r($reqExt,true)."\n",FILE_APPEND);
  
     $fordid=goHuiFuPlant($data);
     file_put_contents('/tmp/zw2.txt',date('m-d H:i:s')."\$fordid1023 ".print_r($fordid,true)."\n",FILE_APPEND);
     file_put_contents('/tmp/zw2.txt',date('m-d H:i:s')."\$fordid ".print_r($fordid['OrdId'],true)."\n",FILE_APPEND);
      file_put_contents('/tmp/zw2.txt',date('m-d H:i:s')."\$siyuandata: ".print_r($data,true)."\n",FILE_APPEND);
     $reddata['orderno']=$fordid['OrdId'];//订单号
      //解决 一次使用多张
      file_put_contents('/tmp/zw2.txt',date('m-d H:i:s')."\$reddata ".print_r($reddata,true)."\n",FILE_APPEND);
      $retu=$this->dealRed($reddata)?$this->dealRed($reddata):'meiyou';
      file_put_contents('/tmp/zw2.txt',date('m-d H:i:s')."\$retu ".print_r($retu,true)."\n",FILE_APPEND);
      return $fordid;

        }
          //处理红包业务
  private function dealRed($reddata) {               
    $user = core::Singleton('user.redpacket');
    $result = $user->dealRed($reddata);unset($user);           
    return $result;
  }
        
         //判断用户是否是首次投标
	private function isFirstInvest($userId) {               
                $user = core::Singleton('user.borrow_info');
		$result = $user->isFirstInvest($userId);unset($user);           
                return $result;
	}
        
        //5.10	获得投标人信息
	private function getMemberMoney($userId) {               
                $user = core::Singleton('user.member');
		$result = $user->getMemberMoney($userId);unset($user);           
                return $result;
	}
      //获得标详情
        private function getBorrowInfo($bid){
             $user = core::Singleton('user.borrow_info');
             $result = $user->getBorrowInfo($bid);unset($user);   
             return $result;
        }
     //获得客户号
        private function getInvestUsrid($userId){
             $user = core::Singleton('user.borrow_info');
             $result = $user->getInvestUsrid($userId);unset($user);   
             return $result;
        }
         //获得借款者客户号
        private function getBorrowUsrid($bid){
             $user = core::Singleton('user.borrow_info'); 
             $result = $user->getBorrowUsrid($bid);unset($user);   
             return $result;
        }
//        //跳转到汇付那边的平台
//        private function goHuiFuPlant($data){
//                require_once('config/config.comm.php');
//		$url = _INTERFACE_HUIFU_URL;
//		$res =  curl_send($url,http_build_query($data));
//
//            return json_decode($res,true);
//        }
}

?>