<?php

class deal {
	
	public function __construct(){
	
		
	}
	
	public function run($post){
		switch($post['CmdId']){
			case "UserRegister"://用户注册
				$this->user_reg($post);
				break;
			case "NetSave"://充值
				$this->net_save($post);
				break;
			case "Cash"://提现
				$this->cash($post);
				break;
			case "CashAudit"://提现复核
				$this->cash_audit($post);
				break;
		}
	}
	
	/**
	 * 基本上抄原来的
	 * @param unknown_type $post
	 * (
    [BgRetUrl] => http://plantformtest.cailai.com/notify/
    [ChkValue] => CEB8E15CB320D53DD7311098AB169F74C5AAE7D5A687B8CBB97084DEFA2D291E4CB52612695C49F6D6014F77CBC067233E9FAA5F9AC99D6D19983614920613B1319EC7BE6082C17DA52020C1F671C4AD3DA2CDA44F284FE8FDC48FF3E589DF93BF589A4988DA9B2B640F3D2D580B387AC9211F86220040FAA2FE32C4645ACDF6
    [CmdId] => UserRegister
    [IdNo] => 310224197262037631
    [IdType] => 00
    [MerCustId] => 6000060000758826
    [MerPriv] => 
    [RespCode] => 000
    [RespDesc] => 成功
    [RetUrl] => http://plantformtest.cailai.com/return/
    [TrxId] => 133533445665677000
    [UsrCustId] => 6000060001160844
    [UsrEmail] => hellowhh329w@163.com
    [UsrId] => clw_13818165029
    [UsrMp] => 13818165029
    [UsrName] => 确填写
)
	 */
	public function user_reg($post){
		//extract($post);

		$start = strpos($post['UsrId'],'_')+1;
		
		$username = substr($post['UsrId'],$start);
		$db = core::Singleton('comm.db.activeRecord');
		$db->connect('CAILAI');
		//通过用户名取用户信息,必须首先在本地存在
		$userinfo = $db->get_one(array('user_name' => $username), '', 'lzh_members');

		$data=array();
		$data['uid'] = $userinfo['id'];//用户UID
		$data['username'] = $userinfo['user_name'];//用户名
		$data['rescode'] = $post['RespCode'];//返回码
		$data['cmdid'] = $post['CmdId'];//消息类型
		$data['usrid'] = $post['UsrCustId'];//用户客户号
		$data['trxid'] = $post['TrxId'];//交易流水号
		$data['addtime'] = time();//记录时间
		
		$condition['uid'] = $data['uid'];
		$condition['cmdid'] = $data['cmdid'];
		$num = $db->count_all($condition, 'lzh_huifulog');
		
		if($num==0){
			$db->insert($data, 'lzh_huifulog');
		}
		
		if(strcmp($post['RespCode'],"000")==0)
		{                   
			//members表记录用户客户号
			$info = array();
			$info['usrid'] = $post['UsrCustId'];
			$condition = array();
			$condition['id'] = $data['uid'];
			$db->update($condition,$info, 'lzh_members',1);
				
			//member_info表记录实名信息
			$info1 = array();
			$info1['idcard'] = $post['IdNo'];
			$info1['real_name'] = urldecode($post['UsrName']);
			$condition = array();
			$condition['uid'] = $data['uid'];
			$db->update($condition,$info1, 'lzh_member_info',1);
			
			//member_status表记录实名状态（即是否实名）
			$info2 = array();
			$info2['id_status'] = 1;
			$condition = array();
			$condition['uid'] = $data['uid'];
			$b = $db->count_all($condition, 'lzh_members_status');
			if ($b == 1){
				$db->update($condition,$info2, 'lzh_members_status',1);
			}
			else{
				$info2['uid'] = $data['uid'];
				$db->insert($info2, 'lzh_members_status');
			}
		}
		unset($post,$info,$info1,$info2,$data);
		
		
	}
	
	
	/**
	 * 充值
	 * @param unknown_type $post
	 */
	public function net_save($post){
		
		$usrid = $post['UsrCustId'];
		$db = core::Singleton('comm.db.activeRecord');
		$db->connect('CAILAI');
		$info = $db->get_one(array('usrid' => $usrid), '', 'lzh_huifulog');
                
		$nowtime = time();
		$data = array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $post['RespCode'];//返回码
		$data['cmdid'] = $post['CmdId'];//消息类型
		$data['usrid'] = $post['UsrCustId'];//用户客户号
		$data['ordid'] = $post['OrdId'];//订单号
		$data['orddate'] = $post['OrdDate'];//订单日期
		$data['trxid'] = $post['TrxId'];//交易流水号
		$data['addtime'] = $nowtime;//记录时间
		
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		
		$num = $db->count_all($condition, 'lzh_huifulog');
		if($num===0){
			$db->insert($data, 'lzh_huifulog');
		}
		
		
		if(strcmp($post['RespCode'],"000")==0)
		{
			//member_paylog表记录充值日志
			$paylog = array();
			$paylog['uid'] = $info['uid'];//用户UID
			$paylog['usrid'] = $post['UsrCustId'];//用户客户号
			$paylog['ordid'] = $post['OrdId'];//订单号
			$paylog['orddate'] = $post['OrdDate'];//订单日期
			$paylog['transamt'] = $post['TransAmt'];//充值金额
			$paylog['trxid'] = $post['TrxId'];//交易流水号
			$paylog['feeamt'] = $post['FeeAmt'];//充值手续费
			$paylog['feecustid'] = $post['FeeCustId'];//手续费扣款客户号
			$paylog['feeacctid'] = $post['FeeAcctId'];//手续费扣款子账户号
			$paylog['addtime'] = $nowtime;//记录时间
				
			$condition['uid'] = $paylog['uid'];
			$condition['ordid'] = $paylog['ordid'];
			$num = $db->count_all($condition, 'lzh_member_paylog');
			//$num = M("member_paylog")->where($condition)->count();
		
			//----------------如果用户通过快捷支付的方式，那么相当于绑卡了, by whh 2015-03-05-------------
				
			if(trim($post['GateBusiId'])=='QP'){
				$bankdata['uid'] = $info['uid'];
				$bankdata['bank_num'] = $post['CardId'];//开户银行帐号
				$bankdata['bank_name'] = $post['GateBankId'];//开户银行代号
				$bankdata['add_ip'] = '';
				$bankdata['add_time'] = time();
				//M('member_banks')->add($bankdata);
				$db->insert($bankdata, 'lzh_member_banks');
				unset($bankdata);
			}
				
			//--------------------------------------------------------------------------------------------
			if($num==0)
			{
				//M("member_paylog")->add($paylog);
				$db->insert($paylog, 'lzh_member_paylog');
				//file_put_contents('/tmp/deal',date('m-d H:i:s')." uid : ".print_r($paylog['uid'],true)."\n",FILE_APPEND);
				//file_put_contents('/tmp/deal',date('m-d H:i:s')." TransAmt : ".print_r(str2val_money($post['TransAmt']),true)."\n",FILE_APPEND);
				//file_put_contents('/tmp/deal',date('m-d H:i:s')." ordid : ".print_r("充值订单号:".$paylog['ordid'],true)."\n",FILE_APPEND);
				//require_once('function/function.comm.php');
				memberMoneyLog($paylog['uid'],3,str2val_money($post['TransAmt']),"充值订单号:".$paylog['ordid'],0,'');
                                
//                                $info = $db->get_one(array('uid' => $info['uid']), '', 'lzh_member_info');
//                                
                                $bdb = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PWD);
                                $sql ="SELECT real_name FROM lzh_member_info WHERE uid = ? limit 1 ";
                                $stmt1 = $bdb->prepare($sql);
                                $stmt1->bindParam(1, $info['uid']);    //绑定第一个参数值
                                $stmt1->execute();
                                while($memberd = $stmt1->fetch(PDO::FETCH_ASSOC)){
                                    $memberInfo = $memberd;
                                }   
                                $bdb = null;
                                $timeT = date('Y-m-d H:i');
                                $sendms= "尊敬的财来网投资人{$memberInfo['real_name']}，您于{$timeT}分,在财来网汇付宝充值{$post['TransAmt']}元已到账。请关注投资标的信息。详情请咨询客户经理，或致电400-079-8558";
                                //取现成功发送短信
                                sendsms($info['username'], $sendms);
                                file_put_contents('/tmp/chongzhi.txt',"{$info['username']}:".print_r($sendms,true)."\n",FILE_APPEND);
			}
		}
		
	}
	
	
	/**
	 * 取现
	 * @param unknown_type $post
	 */
	public function cash($post){
		
		$usrid = $post['UsrCustId'];
		$db = core::Singleton('comm.db.activeRecord');
		$db->connect('CAILAI');
		$info = $db->get_one(array('usrid' => $usrid), '', 'lzh_huifulog');
		
		//$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		
		$nowtime = time();
		$data=array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $post['RespCode'];//返回码
		$data['cmdid'] = $post['CmdId'];//消息类型
		$data['usrid'] = $post['UsrCustId'];//用户客户号
		$data['ordid'] = $post['OrdId'];//订单号
		$data['orddate'] = '';
		$data['trxid'] = '';
		$data['addtime'] = $nowtime;//记录时间
		
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		/*
		$num = M("huifulog")->where($condition)->count();
		if($num==0)
		{
			M("huifulog")->add($data);
		}
		*/
		$num = $db->count_all($condition, 'lzh_huifulog');
		if($num==0){
			$db->insert($data, 'lzh_huifulog');
		}
		
		
		if(strcmp($post['RespCode'],"000")==0  )
		{
			//member_withdrawlog表记录取现日志
			$withdraw = array();
			$withdrawlog['uid'] = $info['uid'];//用户UID
			$withdrawlog['usrid'] = $post['UsrCustId'];//用户客户号
			$withdrawlog['ordid'] = $post['OrdId'];//订单号
			$withdrawlog['transamt'] = $post['TransAmt'];//取现金额
			$withdrawlog['status'] = 0;
			$withdrawlog['feeamt'] = $post['FeeAmt'];//取现手续费
			$withdrawlog['feecustid'] = $post['FeeCustId'];//手续费扣款客户号
			$withdrawlog['feeacctid'] = $post['FeeAcctId'];//手续费扣款子账户号
			$withdrawlog['servfee'] = $post['ServFee'];//服务费
			$withdrawlog['bankaccount'] = $post['OpenAcctId'];//开户银行帐号
			$withdrawlog['addtime'] = $nowtime;//记录时间
		
			$condition['uid'] = $withdrawlog['uid'];
			$condition['ordid'] = $withdrawlog['ordid'];
			
			//$num = M("member_withdrawlog")->where($condition)->count();
			$num = $db->count_all($condition, 'lzh_member_withdrawlog');
			if($num==0)
			{
				//M("member_withdrawlog")->add($withdrawlog);
				$db->insert($withdrawlog, 'lzh_member_withdrawlog');
		
				//取现复核
				$usrid = $data['usrid'];//用户客户号
				$ordid = $data['ordid'];//订单号
				$transamt = $withdrawlog['transamt'];//取现金额
				$auditflag = 'S';//通过
				
				
				//发起取现复核
				$obj = core::Singleton('huifu.huifu');
				$obj->cashAudit($usrid,$ordid,$transamt,$auditflag);
				
				/*
				import("ORG.Huifu.Huifu");
				$huifu = new Huifu();
				$huifu->cashAudit($usrid,$ordid,$transamt,$auditflag);
				*/
			}
		}
		
	}
	
	/**
	 * 取现复核
	 * @param unknown_type $post
	 */
	public function cash_audit($post){

		$usrid = $post['UsrCustId'];
		//$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		$db = core::Singleton('comm.db.activeRecord');
		$db->connect('CAILAI');
		$info = $db->get_one(array('usrid' => $usrid), '', 'lzh_huifulog');
		
		$data=array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $post['RespCode'];//返回码
		$data['cmdid'] = $post['CmdId'];//消息类型
		$data['usrid'] = $post['UsrCustId'];//用户客户号
		$data['ordid'] = $post['OrdId'];//订单号
		$data['orddate'] = '';
		$data['trxid'] = '';
		$data['addtime'] = time();//记录时间
		
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		$condition['cmdid'] = $data['cmdid'];
		
		//$num = M("huifulog")->where($condition)->count();
		$num = $db->count_all($condition, 'lzh_huifulog');
		if($num==0)
		{
			//M("huifulog")->add($data);
			$db->insert($data, 'lzh_huifulog');
			//请求正在处理中,就当作可以了 by whh 2015-03-05   汇付的技术反馈的
			if(strcmp($post['RespCode'],"000")==0 ||  strcmp($post['RespCode'],"999")==0 )
			{
				$map['uid'] = $info['uid'];
				$s['status'] = 1;
				
				//$result =M('member_withdrawlog')->where("ordid=".$data['ordid'])->save($s);
				$result = $db->update(array('ordid' => $data['ordid']), $s, 'lzh_member_withdrawlog');
		
				//$servfee = M('member_withdrawlog')->where("ordid=".$data['ordid'])->find();
				$servfee = $db->get_one(array('ordid' => $data['ordid']), '', 'lzh_member_withdrawlog');
				
				//$money = M('member_money')->where($map)->find();//会员资金
				$money = $db->get_one($map, '', 'lzh_member_money');
				file_put_contents('/tmp/money','$money:'.print_r($money,true)."\n",FILE_APPEND);
				$out_money =str2val_money($post['TransAmt']);//提现资金总金额
				$fees =str2val_money($servfee['servfee']);//总手续费
				$width_money = $out_money + $fees;
				
				unset($data);
				if(($money['back_money'] + $money['account_money'])<= $width_money ){//如果提现金额小于等于总金额
					$deduct = $out_money;//用户减少资金
				}else{
					$deduct = $width_money;//用户减少资金
				}
				if($money["back_money"]> $width_money ){
					$data['back_money'] = $money["back_money"]- $deduct ;
					$data['account_money'] = $money["account_money"];
				}else{
					$data['back_money']=0;
					$data['account_money'] = $money["account_money"]-$deduct + $money["back_money"];
				}
				//M("member_money")->where($map)->save($data);
				file_put_contents('/tmp/money','$map:'.print_r($map,true)."\n",FILE_APPEND);
				file_put_contents('/tmp/money','$$data:'.print_r($data,true)."\n",FILE_APPEND);
				$db->update($map, $data, 'lzh_member_money');
				$log_data = array();
				$log_data['uid']= $info['uid'];
				$log_data['type']= 29;
				$log_data['back_money']= $data['back_money'];
				$log_data['account_money']= $data['account_money'];
				$log_data['affect_money']= -$deduct;
				$log_data['collect_money']= $money['money_collect'];
				$log_data['freeze_money']= $money['money_freeze'];
				$fee = str2val_money($post['FeeAmt'])+str2val_money($servfee['servfee']);
				if(($money['back_money'] + $money['account_money'])<= $width_money ){//如果提现金额小于等于总金额
					$log_data['info']= "提现申请已通过，扣除实际手续费".$fees."元，到帐金额".($out_money-$fees)."元";
				}else{
					$log_data['info']= "提现申请已通过，扣除实际手续费".$fees."元，到帐金额".($out_money)."元";
				}
				$log_data['add_time']= time();
				$log_data['add_ip']= get_client_ip();
				$log_data['target_uid']= 0;
				$log_data['target_uname']= "@网站管理员@";
		
				//M("member_moneylog")->add($log_data);
				$db->insert($log_data, 'lzh_member_moneylog');
                                $mwhere = $info['uid'];
                                
                                $bdb = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PWD);
                                $sql ="SELECT real_name FROM lzh_member_info WHERE uid = ? limit 1 ";
                                $stmt1 = $bdb->prepare($sql);
                                $stmt1->bindParam(1, $mwhere);    //绑定第一个参数值
                                $stmt1->execute();
                                while($memberd = $stmt1->fetch(PDO::FETCH_ASSOC)){
                                    $memberInfo = $memberd;
                                }   
                                $bdb = null;
                                $timeT = date('Y-m-d H:i');
                                $sendms= "尊敬的财来网投资人{$memberInfo['real_name']}，您于{$timeT}分,在财来网汇付宝账号提现{$out_money}元，根据银行情况，将于1-2个工作日到账，敬请关注。详情请咨询客户经理，或致电400-079-8558";
                                //取现成功发送短信
                                sendsms($info['username'], $sendms);
                                file_put_contents('/tmp/zw11.txt',"{$info['username']}:".print_r($sendms,true)."\n",FILE_APPEND);
                                
			}
		}
	}
	
	
}
?>