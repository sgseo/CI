<?php
// 本类由系统自动生成，仅供测试用途
class ReturlAction extends HCommonAction {

	public function __construct(){
		//file_put_contents('/tmp/debug_return',date('m-d H:i:s')." ".,FILE_APPEND);
		file_put_contents('/tmp/debug8',date('m-d H:i:s')." ".print_r($_SERVER['PHP_SELF'],true)."\n".print_r($_POST,true)."\n",FILE_APPEND);
	}
	
		           /* 子公司发送短信对外api*/
	 public function sonsend()
        {     
        	$data=$_POST;
	       	//验证权限
	     	$sname='ios';

	     	$mob=$data['mobile'];

	     	$co = $data['content'];

        	$sercret_key = 'bc7cfba8367fdc117d2ac8e85a5effe3';
        
        	if($data['pname']==$sname && $data['secret_key']==$sercret_key)
        	{
        		$res=sendsms($mob,$co);
        		echo $res;
        	}else{
        		echo "no auth";
        	}
        }
        



	//用户开户回调
	public function usrreg()
	{
		
		$usrid = $_POST['UsrId'];
		$start = strpos($usrid,'_')+1;
		$username = substr($usrid,$start);
		
		$condition['user_name'] = $username;
		$uid = M("members")->field("id")->where($condition)->find();
		
		$data=array();
		$data['uid'] = $uid['id'];//用户UID
		$data['username'] = $username;//用户名12:06
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['UsrCustId'];//用户客户号
		$data['trxid'] = $_POST['TrxId'];//交易流水号
		$data['addtime'] = time();//记录时间
		
		$condition['uid'] = $data['uid'];
		$condition['cmdid'] = $data['cmdid'];
		$num = M("huifulog")->where($condition)->count();
		if($num==0)
		{
			M("huifulog")->add($data);
		}
		
		if(strcmp($_POST['RespCode'],"000")==0)
		{

			//红包入库 红包期限30天 2015-08-28
			$addtime=time();//红包添加时间
			$rednum=date('YmdHis',$addtime);//红包序列号
			$shelftime=30;//红包有效期
			$facevalue=10;//红包的面值
			$overtime=$addtime+30*24*60*60;//红包过期时间 时间戳
			$owner=$uid['id'];//红包的拥有者
			$is_used='0';//是否使用 枚举类型需要加‘’
			$is_success='0';//是否使用成功
			$reddata['addtime']=$addtime;
			$reddata['rednum']=$rednum;
			$reddata['shelftime']=$shelftime;
			$reddata['facevalue']=$facevalue;
			$reddata['overtime']=$overtime;
			$reddata['owner']=$owner;
			$reddata['is_success']=$is_success;
			$reddata['is_used']=$is_used;
			$reddata['note']=1;//代表实名认证送的
			
			M('active_redpacket')->add($reddata);

			//members表记录用户客户号
			$info = array();
			$info['usrid'] = $_POST['UsrCustId'];
			$condition = array();
			$condition['id'] = $data['uid'];
			M("members")->where($condition)->save($info);
			
			//member_info表记录实名信息
			$info1 = array();
			$info1['idcard'] = $_POST['IdNo'];
			$info1['real_name'] = urldecode($_POST['UsrName']);
			$condition = array();
			$condition['uid'] = $data['uid'];
			M("member_info")->where($condition)->save($info1);
			
			//member_status表记录实名状态（即是否实名）
			$info2 = array();
			$info2['id_status'] = 1;
			$condition = array();
			$condition['uid'] = $data['uid'];
			$b = M('members_status')->where($condition)->count('uid');
			if ($b == 1)
			{
				M('members_status')->where($condition)->save($info2);
			}
			else
			{
				$info2['uid'] = $data['uid'];
				M('members_status')->add($info2);
			}
			$_SESSION['real_name'] = $info1['real_name'];
			header("Content-type: text/html; charset=utf-8");
			//redirect('/member', 3, '绑定成功，页面跳转中...');
			redirect('/member/common/regsuccess');
		}
		else
		{
			header("Content-type: text/html; charset=utf-8");
			echo urldecode($_POST['RespDesc']);
		}
	}
	
	//用户开户后台回调
	public function userregister()
	{
		$usrid = $_POST['UsrId'];
		$start = strpos($usrid,'_')+1;
		$username = substr($usrid,$start);
		
		$condition['user_name'] = $username;
		$uid = M("members")->field("id")->where($condition)->find();
		
		$data=array();
		$data['uid'] = $uid['id'];//用户UID
		$data['username'] = $username;//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['UsrCustId'];//用户客户号
		$data['trxid'] = $_POST['TrxId'];//交易流水号
		$data['addtime'] = time();//记录时间
		
		sleep(1);//防止与前台回调同步到达
		$condition['uid'] = $data['uid'];
		$condition['cmdid'] = $data['cmdid'];
		$num = M("huifulog")->where($condition)->count();
		
		

		if($num==0)
		{
			M("huifulog")->add($data);
		}
		
		if(strcmp($_POST['RespCode'],"000")==0)
		{
			//members表记录用户客户号
			$info = array();
			$info['usrid'] = $_POST['UsrCustId'];
			$condition = array();
			$condition['id'] = $data['uid'];
			M("members")->where($condition)->save($info);
			
			//member_info表记录实名信息
			$info1 = array();
			$info1['idcard'] = $_POST['IdNo'];
			$info1['real_name'] = urldecode($_POST['UsrName']);
			$condition = array();
			$condition['uid'] = $data['uid'];
			M("member_info")->where($condition)->save($info1);
			
			//member_status表记录实名状态（即是否实名）
			$info2 = array();
			$info2['id_status'] = 1;
			$condition = array();
			$condition['uid'] = $data['uid'];
			$b = M('members_status')->where($condition)->count('uid');
			if ($b == 1)
			{
				M('members_status')->where($condition)->save($info2);
			}
			else
			{
				$info2['uid'] = $data['uid'];
				M('members_status')->add($info2);
			}
		}
		echo "RECV_ORD_ID_".$_POST['TrxId'];
	}
	
	//企业开户后台回调
	public function corpregister()
	{
		$usrid = $_POST['UsrId'];
		$start = strpos($usrid,'_')+1;
		$username = substr($usrid,$start);
		
		$condition = array();
		$condition['user_name'] = $username;
		$uid = M("members")->field("id")->where($condition)->find();

		$data=array();
		$data['uid'] = $uid['id'];//用户UID
		$data['username'] = $username;//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['UsrCustId'];//用户客户号
		$data['trxid'] = $_POST['TrxId'];//交易流水号
		$data['merpriv'] = $_POST['MerPriv'];
		$data['addtime'] = time();//记录时间
		
		M("huifulog")->add($data);
		
		if(strcmp($_POST['RespCode'],"000")==0)
		{
			//members表记录用户客户号
			$info = array();
			$info['status'] = $_POST['AuditStat'];//审核状态
			$info['usrid'] = $_POST['UsrCustId'];//用户客户号
			$condition = array();
			$condition['id'] = $data['uid'];
			M("members")->where($condition)->save($info);
			
			//member_info表记录实名信息
			$info1 = array();
			$info1['real_name'] = urldecode($_POST['UsrName']);
			$condition = array();
			$condition['uid'] = $data['uid'];
			M("member_info")->where($condition)->save($info1);
			
			//member_status表记录实名状态（即是否实名）
			$info2 = array();
			$info2['id_status'] = 1;
			$condition = array();
			$condition['uid'] = $data['uid'];
			$b = M('members_status')->where($condition)->count('uid');
			if ($b == 1)
			{
				M('members_status')->where($condition)->save($info2);
			}
			else
			{
				$info2['uid'] = $data['uid'];
				M('members_status')->add($info2);
			}
			 //企业绑卡  by zxm
			//member_banks表记录帮卡信息
			$bank_info = M('member_banks')->field("uid,bank_num")->where("uid=".$data['uid'])->find();
			if(!empty($bank_info))
			{
				$bankdata['bank_num'] = $_POST['CardId'];//开户银行帐号
				$bankdata['bank_name'] = $_POST['OpenBankId'];//开户银行代号
				$bankdata['add_ip'] = get_client_ip();
				$bankdata['add_time'] = time();
				M('member_banks')->where("uid=".$data['uid'])->save($bankdata);
			}
			else
			{
				$bankdata['uid'] = $data['uid'];
				$bankdata['bank_num'] = $_POST['CardId'];//开户银行帐号
				$bankdata['bank_name'] = $_POST['OpenBankId'];//开户银行代号
				$bankdata['add_ip'] = get_client_ip();
				$bankdata['add_time'] = time();
				M('member_banks')->add($bankdata);
			}
		}
		echo "RECV_ORD_ID_".$_POST['TrxId'];
	}
	
	//用户绑卡后台回调
	public function bindcard()
	{
		$usrid = $_POST['UsrCustId'];
		$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		
		$data=array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['UsrCustId'];//用户客户号
		$data['trxid'] = $_POST['TrxId'];//交易流水号
		$data['addtime'] = time();//记录时间
		
		M("huifulog")->add($data);
		
		if(strcmp($_POST['RespCode'],"000")==0)
		{
			//member_banks表记录帮卡信息
			$bank_info = M('member_banks')->field("uid,bank_num")->where("uid=".$data['uid'])->find();
			if(!empty($bank_info))
			{
				$bankdata['bank_num'] = $_POST['OpenAcctId'];//开户银行帐号
				$bankdata['bank_name'] = $_POST['OpenBankId'];//开户银行代号
				$bankdata['add_ip'] = get_client_ip();
				$bankdata['add_time'] = time();
				M('member_banks')->where("uid=".$data['uid'])->save($bankdata);
			}
			else
			{
				$bankdata['uid'] = $data['uid'];
				$bankdata['bank_num'] = $_POST['OpenAcctId'];//开户银行帐号
				$bankdata['bank_name'] = $_POST['OpenBankId'];//开户银行代号
				$bankdata['add_ip'] = get_client_ip();
				$bankdata['add_time'] = time();
				M('member_banks')->add($bankdata);
			}
		}
		echo "RECV_ORD_ID_".$_POST['TrxId'];
	}
	
	//网银充值回调
	public function netreturn()
	{
		
		$usrid = $_POST['UsrCustId'];
		$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		
		$nowtime = time();
		$data = array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['UsrCustId'];//用户客户号
		$data['ordid'] = $_POST['OrdId'];//订单号
		$data['orddate'] = $_POST['OrdDate'];//订单日期
		$data['trxid'] = $_POST['TrxId'];//交易流水号
		$data['addtime'] = $nowtime;//记录时间
		
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		$num = M("huifulog")->where($condition)->count();
		
		if($num==0)
		{
			M("huifulog")->add($data);
		}

		
		if(strcmp($_POST['RespCode'],"000")==0)
		{

			//member_paylog表记录充值日志
			$paylog = array();
			$paylog['uid'] = $info['uid'];//用户UID
			$paylog['usrid'] = $_POST['UsrCustId'];//用户客户号
			$paylog['ordid'] = $_POST['OrdId'];//订单号
			$paylog['orddate'] = $_POST['OrdDate'];//订单日期
			$paylog['transamt'] = $_POST['TransAmt'];//充值金额
			$paylog['trxid'] = $_POST['TrxId'];//交易流水号
			$paylog['feeamt'] = $_POST['FeeAmt'];//充值手续费
			$paylog['feecustid'] = $_POST['FeeCustId'];//手续费扣款客户号
			$paylog['feeacctid'] = $_POST['FeeAcctId'];//手续费扣款子账户号
			$paylog['addtime'] = $nowtime;//记录时间
		
			$condition['uid'] = $paylog['uid'];
			$condition['ordid'] = $paylog['ordid'];
			$num = M("member_paylog")->where($condition)->count();
			if($num==0)
			{
				M("member_paylog")->add($paylog);
				memberMoneyLog($paylog['uid'],3,str2val_money($_POST['TransAmt']),"充值订单号:".$paylog['ordid'],0,'@网站管理员@');
			}
		
			

			$tuoguan = FS("Webconfig/tuoguanconfig");
			if($usrid == $tuoguan['huifu']['MerCustId'])
			{//商户充值
				header("Content-type: text/html; charset=utf-8");
				redirect('/admin/tuoguan/pay', 3, '充值成功，页面跳转中...');
			}
			else
			{//用户充值
				//
				$info2 = M("member_info")->field("real_name")->where("uid=".$paylog['uid'])->find();
				$msg = "尊敬的财来网投资人".$info2['real_name']."，您于".date('Y')."年".date('m')."月".date('d')."日".date('H').":".date('i')."分,在财来网汇付宝充值".$_POST['TransAmt']."元已到账。请关注投资标的信息。详情请咨询客户经理，或致电400-079-8558";
				sendsms($info['username'],$msg);

				                                $data=array(
                                    "member_id"=>$paylog['uid'],
                                    "content"=>$msg,
                                );
                                insert_push_information($data);//insert push information

				header("Content-type: text/html; charset=utf-8");
				redirect('/member', 3, '充值成功，页面跳转中...');
			}
		}
		else
		{
			header("Content-type: text/html; charset=utf-8");
			echo urldecode($_POST['RespDesc']);
		}
	}
	
	//网银充值后台回调
	public function netsave()
	{


		$usrid = $_POST['UsrCustId'];
		$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();

		//----------发短信----------------------
		/*
		$server_url = 'http://3tong.net/services/sms?wsdl';
		$user_name = 'dh21944';
		$password = 'kb21944.com';
		include_once(dirname(__FILE__)."/../../../Common/sms/dahan/class.dahansms.php");
		$dahan = new dahanClient();
		$dahan->Client($server_url,$user_name,$password);
		$res = $dahan->dahanSMS('13818164082',"您于".$info['username']." ".$_POST['OrdDate']."在财来网充值".$_POST['TransAmt']);
		*/

		
		//------------------------------
                
		
		$nowtime = time();
		$data = array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['UsrCustId'];//用户客户号
		$data['ordid'] = $_POST['OrdId'];//订单号
		$data['orddate'] = $_POST['OrdDate'];//订单日期
		$data['trxid'] = $_POST['TrxId'];//交易流水号
		$data['addtime'] = $nowtime;//记录时间
		
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		$num = M("huifulog")->where($condition)->count();
		if($num==0)
		{
			M("huifulog")->add($data);
		}
		
		if(strcmp($_POST['RespCode'],"000")==0)
		{
		
			
			//member_paylog表记录充值日志
			$paylog = array();
			$paylog['uid'] = $info['uid'];//用户UID
			$paylog['usrid'] = $_POST['UsrCustId'];//用户客户号
			$paylog['ordid'] = $_POST['OrdId'];//订单号
			$paylog['orddate'] = $_POST['OrdDate'];//订单日期
			$paylog['transamt'] = $_POST['TransAmt'];//充值金额
			$paylog['trxid'] = $_POST['TrxId'];//交易流水号
			$paylog['feeamt'] = $_POST['FeeAmt'];//充值手续费
			$paylog['feecustid'] = $_POST['FeeCustId'];//手续费扣款客户号
			$paylog['feeacctid'] = $_POST['FeeAcctId'];//手续费扣款子账户号
			$paylog['addtime'] = $nowtime;//记录时间
			
			sleep(1);//防止与前台回调同步到达
			$condition['uid'] = $paylog['uid'];
			$condition['ordid'] = $paylog['ordid'];
			$num = M("member_paylog")->where($condition)->count();

			//----------------如果用户通过快捷支付的方式，那么相当于绑卡了, by whh 2015-03-05-------------
			
			if(trim($_POST['GateBusiId'])=='QP'){
				$bankdata['uid'] = $info['uid'];
				$bankdata['bank_num'] = $_POST['CardId'];//开户银行帐号
				$bankdata['bank_name'] = $_POST['GateBankId'];//开户银行代号
				$bankdata['add_ip'] = get_client_ip();
				$bankdata['add_time'] = time();
				M('member_banks')->add($bankdata);
				unset($bankdata);
			}
			
			//--------------------------------------------------------------------------------------------


			if($num==0)
			{
				M("member_paylog")->add($paylog);
				memberMoneyLog($paylog['uid'],3,str2val_money($_POST['TransAmt']),"充值订单号:".$paylog['ordid'],0,'');
			}
		}
		
		echo "RECV_ORD_ID_".$_POST['TrxId'];
	}
	
	//取现回调
	public function quxian()
	{
		$usrid = $_POST['UsrCustId'];
		$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		
		$nowtime = time();
		$data=array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['UsrCustId'];//用户客户号
		$data['ordid'] = $_POST['OrdId'];//订单号
		$data['orddate'] = '';
		$data['trxid'] = '';
		$data['addtime'] = $nowtime;//记录时间
		
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		$num = M("huifulog")->where($condition)->count();
		if($num==0)
		{
			M("huifulog")->add($data);
		}
		
		if(strcmp($_POST['RespCode'],"000")==0)
		{
			//member_withdrawlog表记录取现日志
			$withdraw = array();
			$withdrawlog['uid'] = $info['uid'];//用户UID
			$withdrawlog['usrid'] = $_POST['UsrCustId'];//用户客户号
			$withdrawlog['ordid'] = $_POST['OrdId'];//订单号
			$withdrawlog['transamt'] = $_POST['TransAmt'];//取现金额
			$withdrawlog['status'] = 0;
			$withdrawlog['feeamt'] = $_POST['FeeAmt'];//取现手续费
			$withdrawlog['feecustid'] = $_POST['FeeCustId'];//手续费扣款客户号
			$withdrawlog['feeacctid'] = $_POST['FeeAcctId'];//手续费扣款子账户号
			$withdrawlog['servfee'] = $_POST['ServFee'];//服务费
			$withdrawlog['bankaccount'] = $_POST['OpenAcctId'];//开户银行帐号
			$withdrawlog['addtime'] = $nowtime;//记录时间
		
			$condition['uid'] = $withdrawlog['uid'];
			$condition['ordid'] = $withdrawlog['ordid'];
			$num = M("member_withdrawlog")->where($condition)->count();
			if($num==0)
			{
				M("member_withdrawlog")->add($withdrawlog);
				
				
				//取现复核
				$usrid = $data['usrid'];//用户客户号
				$ordid = $data['ordid'];//订单号
				$transamt = $withdrawlog['transamt'];//取现金额
				$auditflag = 'S';//通过
				
				import("ORG.Huifu.Huifu");
				$huifu = new Huifu();
				$huifu->cashAudit($usrid,$ordid,$transamt,$auditflag);
			}
		
			
			
			$tuoguan = FS("Webconfig/tuoguanconfig");
			$merid = $tuoguan['huifu']['MerCustId'];
			if($merid == $data['usrid'])
			{//商户取现
				header("Content-type: text/html; charset=utf-8");
				redirect('/admin/tuoguan/withdraw', 3, '取现成功，页面跳转中...');
			}
			else
			{//用户取现
				//
				//sendsms('13818164082',"您于"." ".date('m').'月'.date('d').'日'.date('H').':'.date('i')."在财来网提现".$_POST['TransAmt'].'元,提现手续费'.$_POST['ServFee'].'元');
				//sendsms($info['username'],"您于"." ".date('m').'月'.date('d').'日'.date('H').':'.date('i')."在财来网提现".$_POST['TransAmt'].'元');

/*
				$info2 = M("member_info")->field("real_name")->where("uid=".$withdrawlog['uid'])->find();
				$msg = "尊敬的财来网投资人".$info2['real_name']."，您于".date('Y')."年".date('m')."月".date('d')."日".date('H').":".date('i')."分,在财来网汇付宝账号提现".$_POST['TransAmt']."元，根据银行情况，将于1-2个工作日到账，敬请关注。详情请咨询客户经理，或致电400-079-8558";
				sendsms($info['username'],$msg);

                                $data=array(
                                    "member_id"=>$withdrawlog['uid'],
                                    "content"=>$msg,
                                );
                                 insert_push_information($data);// insert push information				*/

				header("Content-type: text/html; charset=utf-8");
				redirect('/member', 3, '取现成功，页面跳转中...');
			}
		}
		else
		{
			header("Content-type: text/html; charset=utf-8");
			echo urldecode($_POST['RespDesc']);
		}
	}
	
	//取现后台回调
	public function quxianreturn()
	{
		
		$usrid = $_POST['UsrCustId'];
		$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		
		$nowtime = time();
		$data=array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['UsrCustId'];//用户客户号
		$data['ordid'] = $_POST['OrdId'];//订单号
		$data['orddate'] = '';
		$data['trxid'] = '';
		$data['addtime'] = $nowtime;//记录时间
		
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		$num = M("huifulog")->where($condition)->count();
		if($num==0)
		{
			M("huifulog")->add($data);
		}
		
		
		if(strcmp($_POST['RespCode'],"000")==0  )
		{
			//member_withdrawlog表记录取现日志
			$withdraw = array();
			$withdrawlog['uid'] = $info['uid'];//用户UID
			$withdrawlog['usrid'] = $_POST['UsrCustId'];//用户客户号
			$withdrawlog['ordid'] = $_POST['OrdId'];//订单号
			$withdrawlog['transamt'] = $_POST['TransAmt'];//取现金额
			$withdrawlog['status'] = 0;
			$withdrawlog['feeamt'] = $_POST['FeeAmt'];//取现手续费
			$withdrawlog['feecustid'] = $_POST['FeeCustId'];//手续费扣款客户号
			$withdrawlog['feeacctid'] = $_POST['FeeAcctId'];//手续费扣款子账户号
			$withdrawlog['servfee'] = $_POST['ServFee'];//服务费
			$withdrawlog['bankaccount'] = $_POST['OpenAcctId'];//开户银行帐号
			$withdrawlog['addtime'] = $nowtime;//记录时间
		
			sleep(1);//防止与前台回调同步到达
			$condition['uid'] = $withdrawlog['uid'];
			$condition['ordid'] = $withdrawlog['ordid'];
			$num = M("member_withdrawlog")->where($condition)->count();
			if($num==0)
			{
				M("member_withdrawlog")->add($withdrawlog);
				
				//取现复核
				$usrid = $data['usrid'];//用户客户号
				$ordid = $data['ordid'];//订单号
				$transamt = $withdrawlog['transamt'];//取现金额
				$auditflag = 'S';//通过
				
				import("ORG.Huifu.Huifu");
				$huifu = new Huifu();
				$huifu->cashAudit($usrid,$ordid,$transamt,$auditflag);

				//----------------add by whh 2015-10-28---------------------------
				$info2 = M("member_info")->field("real_name")->where("uid=".$withdrawlog['uid'])->find();
				$msg = "尊敬的财来网投资人".$info2['real_name']."，您于".date('Y')."年".date('m')."月".date('d')."日".date('H').":".date('i')."分,在财来网汇付宝账号提现".$_POST['TransAmt']."元，根据银行情况，将于1-2个工作日到账，敬请关注。详情请咨询客户经理，或致电400-079-8558";
				sendsms($info['username'],$msg);

				$data=array(
					"member_id"=>$withdrawlog['uid'],
					"content"=>$msg,
				);
				 insert_push_information($data);// insert push information
				//---------------------------------------------------------------

			}
		}
		
		echo "RECV_ORD_ID_".$_POST['OrdId'];
	}
	
	//取现复核后台返回
	public function auditreturn()
	{
		if(!empty($_POST['RespType'])&&strcmp($_POST['RespType'],"Cash")==0) exit;
		$usrid = $_POST['UsrCustId'];
		$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		
		$data=array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['UsrCustId'];//用户客户号
		$data['ordid'] = $_POST['OrdId'];//订单号
		$data['orddate'] = '';
		$data['trxid'] = '';
		$data['addtime'] = time();//记录时间
		
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		$condition['cmdid'] = $data['cmdid'];
		$num = M("huifulog")->where($condition)->count();
		if($num==0)
		{
			M("huifulog")->add($data);
			//请求正在处理中,就当作可以了 by whh 2015-03-05   汇付的技术反馈的
			if(strcmp($_POST['RespCode'],"000")==0 ||  strcmp($_POST['RespCode'],"999")==0 )
			{
				$map['uid'] = $info['uid'];
				$s['status'] = 1;
				$result =M('member_withdrawlog')->where("ordid=".$data['ordid'])->save($s);
				
				$servfee = M('member_withdrawlog')->where("ordid=".$data['ordid'])->find();
				$money = M('member_money')->where($map)->find();//会员资金
				$out_money =str2val_money($_POST['TransAmt']);//提现资金总金额
				//$fees =str2val_money($_POST['FeeAmt'])+str2val_money($servfee['servfee']);//总手续费
				$fees =str2val_money($servfee['servfee']);//总手续费
				$width_money = $out_money + $fees;																				
				
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
				M("member_money")->where($map)->save($data);				
				$log_data = array();
				$log_data['uid']= $info['uid'];
				$log_data['type']= 29;
				$log_data['back_money']= $data['back_money'];
				$log_data['account_money']= $data['account_money'];
				$log_data['affect_money']= -$deduct;
				$log_data['collect_money']= $money['money_collect'];
				$log_data['freeze_money']= $money['money_freeze'];
				$fee = str2val_money($_POST['FeeAmt'])+str2val_money($servfee['servfee']);
				if(($money['back_money'] + $money['account_money'])<= $width_money ){//如果提现金额小于等于总金额	
					$log_data['info']= "提现申请已通过，扣除实际手续费".$fees."元，到帐金额".($out_money-$fees)."元";
				}else{
					$log_data['info']= "提现申请已通过，扣除实际手续费".$fees."元，到帐金额".($out_money)."元";
				}
				$log_data['add_time']= time();
				$log_data['add_ip']= get_client_ip();
				$log_data['target_uid']= 0;
				$log_data['target_uname']= "@网站管理员@";
				
				M("member_moneylog")->add($log_data);
				
			}
		}
		echo "RECV_ORD_ID_".$_POST['OrdId'];
	}
	
	//资金（货款）冻结
	public function usrfreeze()
	{
		$usrid = $_POST['UsrCustId'];
		$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		
		$data=array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['UsrCustId'];//用户客户号
		$data['ordid'] = $_POST['OrdId'];//订单号
		$data['orddate'] = $_POST['OrdDate'];//订单日期
		$data['merpriv'] = $_POST['MerPriv'];
		$data['trxid'] = $_POST['TrxId'];//交易流水号
		$data['addtime'] = time();//记录时间
		
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		$num = M("huifulog")->where($condition)->count();
		if($num==0)
		{
			M("huifulog")->add($data);
			
			if(strcmp($_POST['RespCode'],"000")==0)
			{
				$temp = base64_decode($data['merpriv']);
				$pos1 = strpos($temp,'{');
				$pos2 = strpos($temp,'}');
				$len = $pos2-$pos1+1;
				$merpriv = substr($temp,$pos1,$len);
				$merpriv = json_decode($merpriv,true);
			
				$borrowid = $merpriv['borrowid'];//标ID
				$data1 = array();
				$data1['freezetrxid'] = $data['trxid'];
				M('borrow_info')->where("id=".$borrowid)->save($data1);
				
				$_P_fee=get_global_setting();
				$binfo = M("borrow_info")->field("borrow_type,reward_type,reward_num,borrow_fee,borrow_money,borrow_uid,borrow_duration,repayment_type,manage_rate")->find($borrowid);
				memberMoneyLog($binfo['borrow_uid'],19,-$binfo['borrow_money']*$_P_fee['money_deposit']/100,"第{$borrowid}号标借款成功，冻结{$_P_fee['money_deposit']}%的保证金");
			}
		}
		echo "RECV_ORD_ID_".$_POST['OrdId'];
	}

	//资金(货款)解冻同步回调
	//资金（货款）解冻
	// public function unfreeze()
	// {
	// file_put_contents('/tmp/110',date('m-d H:i:s')."投标解冻返回\$_POST121:".print_r($_POST,true)."\n",FILE_APPEND);
	// if(strcmp($_POST['RespCode'],"000")==0){
	// 		$mem = new Memcache;
	// 		$mem->connect("127.0.0.1", 11211);
	// 		$key = $_POST['CmdId'].'-'.$_POST['OutCustId'];
	// 		$has = $mem->get($key);
	// 		if($has){
	// 			sleep(1);
	// 			return ;
	// 		}else{
	// 			//设置4秒
	// 			$mem->set($key,1,0,1);
	// 		}
	// 		unset($mem);
	// 	}

	// 	$data=array();
	// 	$data['uid'] = "";
	// 	$data['username'] = "";
	// 	$data['rescode'] = $_POST['RespCode'];//返回码
	// 	$data['cmdid'] = $_POST['CmdId'];//消息类型
	// 	$data['usrid'] = "";
	// 	$data['ordid'] = $_POST['OrdId'];//订单号
	// 	$data['orddate'] = $_POST['OrdDate'];//订单日期
	// 	$data['trxid'] = $_POST['TrxId'];//交易流水号
	// 	$data['merpriv'] = $_POST['MerPriv'];
	// 	$data['addtime'] = time();//记录时间
		
	// 	$condition['ordid'] = $data['ordid'];
	// 	$num = M("huifulog")->where($condition)->count();
	// 	if($num==0)
	// 	{
	// 		M("huifulog")->add($data);
			
	// 		if(strcmp($_POST['RespCode'],"000")==0)
	// 		{
	// 			$temp = base64_decode($data['merpriv']);
	// 			$pos1 = strpos($temp,'{');
	// 			$pos2 = strpos($temp,'}');
	// 			$len = $pos2-$pos1+1;
	// 			$merpriv = substr($temp,$pos1,$len);
	// 			$merpriv = json_decode($merpriv,true);
				
	// 			$borrowid = $merpriv['borrowid'];//标ID
	// 			$type = $merpriv['type'];//解冻类型（1：投标解冻 2：保证金解冻）
	// 			$sort_order = $merpriv['sort_order'];//期数
				
	// 			$pre = C('DB_PREFIX');
				
	// 			if($type == 1)
	// 			{
					
	// 			}
	// 			else if($type == 2)
	// 			{
	// 				//标信息
	// 				$binfo = M("borrow_info")->field("borrow_type,reward_type,reward_num,borrow_fee,borrow_money,borrow_uid,borrow_duration,repayment_type,manage_rate")->find($borrowid);
			
	// 				//解冻保证金
	// 				$_P_fee=get_global_setting();
	// 				$accountMoney_borrower = M('member_money')->field('account_money,money_collect,money_freeze,back_money')->find($binfo['borrow_uid']);
	// 				$datamoney_x['uid'] = $binfo['borrow_uid'];
	// 				$datamoney_x['type'] = 24;
	// 				$datamoney_x['affect_money'] = ($binfo['borrow_money']*$_P_fee['money_deposit']/100);
	// 				$datamoney_x['account_money'] = ($accountMoney_borrower['account_money'] + $datamoney_x['affect_money']);
	// 				$datamoney_x['collect_money'] = $accountMoney_borrower['money_collect'];
	// 				$datamoney_x['freeze_money'] = ($accountMoney_borrower['money_freeze']-$datamoney_x['affect_money']);
	// 				$datamoney_x['back_money'] = $accountMoney_borrower['back_money'];
	
	// 				//会员帐户
	// 				$mmoney_x['money_freeze']=$datamoney_x['freeze_money'];
	// 				$mmoney_x['money_collect']=$datamoney_x['collect_money'];
	// 				$mmoney_x['account_money']=$datamoney_x['account_money'];
	// 				$mmoney_x['back_money']=$datamoney_x['back_money'];
	
	// 				//会员帐户
	// 				$datamoney_x['info'] = "网站对{$binfo['id']}号标还款完成的解冻保证金";
	// 				$datamoney_x['add_time'] = time();
	// 				$datamoney_x['add_ip'] = get_client_ip();
	// 				$datamoney_x['target_uid'] = 0;
	// 				$datamoney_x['target_uname'] = '@网站管理员@';
	// 				$moneynewid_x = M('member_moneylog')->add($datamoney_x);
	// 				if($moneynewid_x) $bxid = M('member_money')->where("uid={$datamoney_x['uid']}")->save($mmoney_x);
				
	// 				//更新借款信息
	// 				$upborrowsql = "update `{$pre}borrow_info` set ";
	// 				$upborrowsql .= "`borrow_status`=7";
	// 				$upborrowsql .= " WHERE `id`={$borrowid}";
	// 				$upborrow_res = M()->execute($upborrowsql);
					
	// 				M()->execute("update `{$pre}investor_detail` set `status`=1 WHERE `borrow_id`={$borrowid} AND `sort_order`={$sort_order}");
	// 			}
	// 		}
	// 	}
	// 	echo '哈哈哈';
	// }

	
	//资金（货款）解冻
	public function usrunfreeze()
	{
		file_put_contents('/tmp/110',date('m-d H:i:s')."投标解冻返回异步：\$_POST121:".print_r($_POST,true)."\n",FILE_APPEND);
	if(strcmp($_POST['RespCode'],"000")==0){
			$mem = new Memcache;
			$mem->connect("127.0.0.1", 11211);
			$key = $_POST['CmdId'].'-'.$_POST['OutCustId'];
			$has = $mem->get($key);
			if($has){
				sleep(1);
				return ;
			}else{
				//设置4秒
				$mem->set($key,1,0,1);
			}
			unset($mem);
		}

		$data=array();
		$data['uid'] = "";
		$data['username'] = "";
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = "";
		$data['ordid'] = $_POST['OrdId'];//订单号
		$data['orddate'] = $_POST['OrdDate'];//订单日期
		$data['trxid'] = $_POST['TrxId'];//交易流水号
		$data['merpriv'] = $_POST['MerPriv'];
		$data['addtime'] = time();//记录时间
		
		$condition['ordid'] = $data['ordid'];
		$num = M("huifulog")->where($condition)->count();
		if($num==0)
		{
			M("huifulog")->add($data);
			
			if(strcmp($_POST['RespCode'],"000")==0)
			{
				$temp = base64_decode($data['merpriv']);
				$pos1 = strpos($temp,'{');
				$pos2 = strpos($temp,'}');
				$len = $pos2-$pos1+1;
				$merpriv = substr($temp,$pos1,$len);
				$merpriv = json_decode($merpriv,true);
				$res=M('borrow_investor')->getFieldByFreezetrxid($data['trxid'],'investor_capital');
				$money=$res['investor_capital'];
				$borrowid = $merpriv['borrowid'];//标ID
				$type = $merpriv['type'];//解冻类型（1：投标解冻 2：保证金解冻）
				$sort_order = $merpriv['sort_order'];//期数
				$investoruid=$merpriv['investoruid'];//投资者uid 123486
				$pre = C('DB_PREFIX');
				
				if($type == 1)
				{//
					//memberMoneyLog();//写入通知 8位流标解冻
					//$res = memberMoneyLog($investoruid,8,$money,"对{$borrow_id}号标进行投标解冻",$investoruid);
					

				}
				else if($type == 2)
				{
					//标信息
					$binfo = M("borrow_info")->field("borrow_type,reward_type,reward_num,borrow_fee,borrow_money,borrow_uid,borrow_duration,repayment_type,manage_rate")->find($borrowid);
			
					//解冻保证金
					$_P_fee=get_global_setting();
					$accountMoney_borrower = M('member_money')->field('account_money,money_collect,money_freeze,back_money')->find($binfo['borrow_uid']);
					$datamoney_x['uid'] = $binfo['borrow_uid'];
					$datamoney_x['type'] = 24;
					$datamoney_x['affect_money'] = ($binfo['borrow_money']*$_P_fee['money_deposit']/100);
					$datamoney_x['account_money'] = ($accountMoney_borrower['account_money'] + $datamoney_x['affect_money']);
					$datamoney_x['collect_money'] = $accountMoney_borrower['money_collect'];
					$datamoney_x['freeze_money'] = ($accountMoney_borrower['money_freeze']-$datamoney_x['affect_money']);
					$datamoney_x['back_money'] = $accountMoney_borrower['back_money'];
	
					//会员帐户
					$mmoney_x['money_freeze']=$datamoney_x['freeze_money'];
					$mmoney_x['money_collect']=$datamoney_x['collect_money'];
					$mmoney_x['account_money']=$datamoney_x['account_money'];
					$mmoney_x['back_money']=$datamoney_x['back_money'];
	
					//会员帐户
					$datamoney_x['info'] = "网站对{$binfo['id']}号标还款完成的解冻保证金";
					$datamoney_x['add_time'] = time();
					$datamoney_x['add_ip'] = get_client_ip();
					$datamoney_x['target_uid'] = 0;
					$datamoney_x['target_uname'] = '@网站管理员@';
					$moneynewid_x = M('member_moneylog')->add($datamoney_x);
					if($moneynewid_x) $bxid = M('member_money')->where("uid={$datamoney_x['uid']}")->save($mmoney_x);
				
					//更新借款信息
					$upborrowsql = "update `{$pre}borrow_info` set ";
					$upborrowsql .= "`borrow_status`=7";
					$upborrowsql .= " WHERE `id`={$borrowid}";
					$upborrow_res = M()->execute($upborrowsql);
					
					M()->execute("update `{$pre}investor_detail` set `status`=1 WHERE `borrow_id`={$borrowid} AND `sort_order`={$sort_order}");
				}
			}
		}
		echo "RECV_ORD_ID_".$_POST['OrdId'];
	}

	//主动投标回调
	public function initiativetender()
	{	//这里返回的值transamt包括红包
		file_put_contents('/tmp/110',date('m-d H:i:s')."投标回调代金券\$_POST120:".print_r($_POST,true)."\n",FILE_APPEND);
		//file_put_contents(filename, data)
		if(strcmp($_POST['RespCode'],"000")==0)
		{
			$usrid = $_POST['UsrCustId'];
			$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();

			//---------------------
			$yonghu_id =  $info['uid'];
			$jiner = $_POST['TransAmt'];
			$shoujihao =  $info['username'];
			//----------------------
			
			$data=array();
			$data['uid'] = $info['uid'];//用户UID
			$data['username'] = $info['username'];//用户名
			$data['rescode'] = $_POST['RespCode'];//返回码
			$data['cmdid'] = $_POST['CmdId'];//消息类型
			$data['usrid'] = $_POST['UsrCustId'];//用户客户号
			$data['ordid'] = $_POST['OrdId'];//订单号
			$data['orddate'] = $_POST['OrdDate'];//订单日期
			$data['trxid'] = $_POST['TrxId'];//交易流水号
			$data['merpriv'] = $_POST['MerPriv'];
			$data['addtime'] = time();//记录时间
			$reqext=$_POST['RespExt'];//代金券的内容json字符串
			$reqext=urldecode($reqext);
			$reqext=json_decode($reqext,1);
			$reqext=$reqext['Vocher']['VocherAmt'];
			file_put_contents('/tmp/dubug2',date('m-d H:i:s')."\$s1020_911".print_r($reqext,true)."\n",FILE_APPEND);
			if($reqext)
			{
			/*根据订单号修改现金券的使用状态*/
			$save['is_success']='1';
			M('active_redpacket')->where('orderno='.$data['ordid'])->save($save);//把代金券修改为成功
			$s1020_917=M()->_sql();
			file_put_contents('/tmp/dubug2',date('m-d H:i:s')."\$s1020_917".print_r($s1020_917,true)."\n",FILE_APPEND);
			}
		
			$condition['uid'] = $data['uid'];
			$condition['ordid'] = $data['ordid'];
			$num = M("huifulog")->where($condition)->count();
			if($num==0)
			{
				M("huifulog")->add($data);
				
				$temp = base64_decode($data['merpriv']);
				
				$pos1 = strpos($temp,'{');
				$pos2 = strpos($temp,'}');
				$len = $pos2-$pos1+1;
				$merpriv = substr($temp,$pos1,$len);
				$merpriv = json_decode($merpriv,true);
				$borrow_id = $merpriv['borrowid'];//标ID
				$money = str2val_money($_POST['TransAmt']);//交易金额
				$info = array();
				$info['ordid'] = $data['ordid'];//订单号
				$info['orddate'] = $data['orddate'];//订单日期
				$info['freezeordid'] = $_POST['FreezeOrdId'];//冻结订单号
				$info['freezetrxid'] = $_POST['FreezeTrxId'];//冻结流水号k
				

				//计算是否超标-----------------
				$biaodi_info = M("borrow_info")->field("borrow_name,borrow_money,has_borrow")->where("id={$borrow_id}")->find();
				if($biaodi_info['borrow_money']<$biaodi_info['has_borrow']+$money){
					$overtop['borrow_id'] = $borrow_id;
					$overtop['order_id'] = $data['ordid'];
					$overtop['money'] = $money;
					$overtop['uid'] = $data['uid'];
					$overtop['username'] = $data['username'];
					$arr = $_POST;
					if(is_array($arr)){
						foreach($arr as $k=>$v){
							$arr[$k] = urldecode($v);
						}
					}
					$overtop['huifu_return'] = addslashes(print_r($arr,true));
					
					M("borrow_overtop")->add($overtop);

					//--------------add by whh 2015-10-30-  同时发送短信-------------
					sendsms('13818164082',"标号".$borrow_id.",投资人".$data['username']."发生超标,请注意！");
					//---------------------------------------------------------------


					header("Content-type: text/html; charset=utf-8");
					redirect('/member', 3, '投标金额已超过标的金额，正在退款中...');
				}
				//------------------------------------
				
				$invest_info_id = M('borrow_investor')->add($info);
				file_put_contents('/tmp/dubug2',date('m-d H:i:s')."\$s1020_966money:".print_r($money,true)."\n",FILE_APPEND);
				file_put_contents('/tmp/dubug2',date('m-d H:i:s')."\$s1020_967reqext:".print_r($reqext,true)."\n",FILE_APPEND);
				$n = investMoney($data['uid'],$borrow_id,$money,0,$invest_info_id,$reqext);
				
				//--------------发短信 by whh--------------------
				$touziren_info = M("member_info")->field("real_name")->where("uid=".$yonghu_id)->find();
				
				$content="尊敬的财来网投资人".$touziren_info['real_name'].",您于".date("Y")."年".date("m")."月".date("d")."日".date("H").":".date("i")."分向《".$biaodi_info['borrow_name']."》标的投资".$jiner."元,资金已冻结，将于满标复审后计息，详情请致电400-079-8558";
				sendsms(text($shoujihao),$content);
				//file_put_contents('/tmp/debug9',date('m-d H:i:s')." ".print_r($_SERVER['PHP_SELF'],true)."\n".print_r($content,true)."\n",FILE_APPEND);
				unset($content,$touziren_info,$touziren_info,$biaodi_info);
				//-----------------------------------------------------

				
			}
			header("Content-type: text/html; charset=utf-8");
			redirect('/member', 3, '投标成功，页面跳转中...');
		}
		else
		{
			header("Content-type: text/html; charset=utf-8");
			echo urldecode($_POST['RespDesc']);
		}
	}

	//主动投标后台回调
	public function initiativetenderreturn()
	{
		$usrid = $_POST['UsrCustId'];
		$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		$data=array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['UsrCustId'];//用户客户号
		$data['ordid'] = $_POST['OrdId'];//订单号
		$data['orddate'] = $_POST['OrdDate'];//订单日期
		$data['trxid'] = $_POST['TrxId'];//交易流水号
		$data['merpriv'] = $_POST['MerPriv'];
		$data['addtime'] = time();//记录时间

		$reqext=$_POST['RespExt'];//代金券的内容json字符串
		$reqext=urldecode($reqext);
		$reqext=json_decode($reqext,1);
		$reqext=$reqext['Vocher']['VocherAmt'];
		
		file_put_contents('/tmp/dubug2',date('m-d H:i:s')."RespExt:1010hang-".print_r($_POST,true)."\n",FILE_APPEND);

		sleep(1);//防止与前台回调同步到达
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		$num = M("huifulog")->where($condition)->count();
		if($num==0)
		{
			M("huifulog")->add($data);
			$sql=M()->getLastSql();
			file_put_contents('/tmp/110',date('m-d H:i:s')."monthDataDetail(1020hang):".print_r($sql,true)."\n",FILE_APPEND);
			if(strcmp($_POST['RespCode'],"000")==0)
			{
				$temp = base64_decode($data['merpriv']);
				$pos1 = strpos($temp,'{');
				$pos2 = strpos($temp,'}');
				$len = $pos2-$pos1+1;
				$merpriv = substr($temp,$pos1,$len);
				$merpriv = json_decode($merpriv,true);
				
				$borrow_id = $merpriv['borrowid'];//标ID
				$money = str2val_money($_POST['TransAmt']);//交易金额

				//die;
				$info = array();
				$info['ordid'] = $data['ordid'];//订单号
				$info['orddate'] = $data['orddate'];//订单日期
				$info['freezeordid'] = $_POST['FreezeOrdId'];//冻结订单号
				$info['freezetrxid'] = $_POST['FreezeTrxId'];//冻结流水号

				//计算是否超标-----------------
				$biaodi_info = M("borrow_info")->field("borrow_name,borrow_money,has_borrow")->where("id={$borrow_id}")->find();
				if($biaodi_info['borrow_money']<$biaodi_info['has_borrow']+$money){
					$overtop['borrow_id'] = $borrow_id;
					$overtop['order_id'] = $data['ordid'];
					$overtop['money'] = $money;
					$overtop['uid'] = $data['uid'];
					$overtop['username'] = $data['username'];
					$arr = $_POST;
					if(is_array($arr)){
						foreach($arr as $k=>$v){
							$arr[$k] = urldecode($v);
						}
					}
					$overtop['huifu_return'] = addslashes(print_r($arr,true));
					
					M("borrow_overtop")->add($overtop);

					//--------------add by whh 2015-10-30-  同时发送短信-------------
					sendsms('13818164082',"标号".$borrow_id.",投资人".$data['username']."发生超标,请注意！");
					//---------------------------------------------------------------


					header("Content-type: text/html; charset=utf-8");
					redirect('/member', 3, '投标金额已超过标的金额，正在退款中...');
				}
				//------------------------------------
				$invest_info_id = M('borrow_investor')->add($info);
                $sql = M('borrow_investor')->getLastSql();
				 file_put_contents('/tmp/110',date('m-d H:i:s')."monthDataDetail(1041):".print_r($sql,true)."\n",FILE_APPEND);  
				$l = investMoney($data['uid'],$borrow_id,$money,0,$invest_info_id,$reqext);
			}
		}
		echo "RECV_ORD_ID_".$_POST['OrdId'];
	}
	
	/**
	 * 新手标回调 20150914 bylj
	 */
	public function ininewbietender()
	{
file_put_contents('/tmp/debugs',date('m-d H:i:s')."\$新手标同步回调post".print_r($_POST,true)."\n",FILE_APPEND);
		if(strcmp($_POST['RespCode'],"000")==0)
		{
			$usrid = $_POST['UsrCustId'];//借款人的userid
			$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
			//---------------------
			$yonghu_id =  $info['uid'];
			$jiner = $_POST['TransAmt'];
			$shoujihao =  $info['username'];

			$data=array();
			$data['uid'] = $info['uid'];//用户UID
			$data['username'] = $info['username'];//用户名
			$data['rescode'] = $_POST['RespCode'];//返回码
			$data['cmdid'] = $_POST['CmdId'];//消息类型
			$data['usrid'] = $_POST['UsrCustId'];//用户客户号
			$data['ordid'] = $_POST['OrdId'];//订单号
			$data['orddate'] = $_POST['OrdDate'];//订单日期
			$data['trxid'] = $_POST['TrxId'];//交易流水号
			$data['merpriv'] = $_POST['MerPriv'];
			$data['addtime'] = time();//记录时间
			$reqext=$_POST['RespExt'];//代金券的内容json字符串
			$reqext=urldecode($reqext);
			$reqext=json_decode($reqext,1);
			$reqext=$reqext['Vocher']['VocherAmt'];
			if($reqext)
			{
			/*根据订单号修改现金券的使用状态*/
			$save['is_success']=1;
			M('active_redpacket')->where('orderno='.$data['ordid'])->save($save);//把代金券修改为成功
			}
		
			$condition['uid'] = $data['uid'];
			$condition['ordid'] = $data['ordid'];
			$num = M("huifulog")->where($condition)->count();

			if($num==0)
			{
				M("huifulog")->add($data);
				$temp = base64_decode($data['merpriv']);
				$pos1 = strpos($temp,'{');
				$pos2 = strpos($temp,'}');
				$len = $pos2-$pos1+1;
				$merpriv = substr($temp,$pos1,$len);
				$merpriv = json_decode($merpriv,true);
				$borrow_id = $merpriv['borrowid'];//标ID
				$money = str2val_money($_POST['TransAmt']);//交易金额
				//查询标的利率和周期 2015-09-16
				$bininfo=M("newbie_bid")->field('borrow_uid,rate,bidtime')->where("id=".$borrow_id)->find();
			
				$info = array();
				$info['ordid'] = $data['ordid'];//订单号
				$info['orddate'] = $data['orddate'];//订单日期
				$info['freezeordid'] = $_POST['FreezeOrdId'];//冻结订单号
				$info['freezetrxid'] = $_POST['FreezeTrxId'];//冻结流水号
				$info['investid']=$data['uid'];
				$info['invest_money']=$jiner;
				$info['interest']=number_format(($jiner*$bininfo['bidtime']*($bininfo['rate']/100))/365,2);//* 利息多少 金额*时间*利率/365天
				$info['borrow_uid']=$bininfo['borrow_uid'];//2015-09-16添加一个借款人uid
				$info['invest_uid']=$data['uid'];
				$info['invest_time']=strtotime(date("Y-m-d H:i",time()));//逾期时刻
	
					//根据标号 查询借款人
				$borrow_uid=$bininfo['borrow_uid'];//1093行
				//根据借款人id 查询借款人的usrid
				$invest_usrid=M("members")->field('usrid,user_name')->where("id=".$borrow_uid)->find();
				$touzier=M("members")->field('usrid,user_name')->where("id=".$data['uid'])->find();//插入投资人电话（也就是用户名）
				//2015-09-22 插入之前首先查询是否有此人投资过 以防止异步也同时插入
				$ishas=M("newbie_record")->getFieldByInvest_id($data['uid'],'id');

				$info['username']=$touzier['user_name'];
				//要把投资者id插入 投资id 插入  投资时间 
				if(!$ishas)
				{
				$invest_info_id = M('newbie_record')->add($info);//换成新手标的表
				}
				//根据订单号查询投资人
				$invest=M('newbie_record')->field('invest_uid,ordid,orddate')->where('ordid='.$data['ordid'])->find();
	
				//通知投资人 2015-09-15 最后的1为借款人id
				memberMoneyLog($invest['invest_uid'],6,-($money-$reqext),"对{$borrow_id}号新手标进行投标",$borrow_uid);//
				//开始放款 2015-09-15 lj
				import("ORG.Huifu.Huifu");
				$huifu = new Huifu();
				//每次是单笔的复审 所以用loans方法 20150914
				$borrowercustid=$invest_usrid['usrid'];//600856564542 应该为借款人 的投资urid
				$transamt = $jiner;
				$Fee=0.00;
				$subordid=$invest['ordid'];
				$suborddate=$invest['orddate'];
				//商户号
				$tuoguan = FS("Webconfig/tuoguanconfig");
				$merCustId = $tuoguan['huifu']['MerCustId'];
				$divdetails = '';//[{"DivCustId":"'.$merCustId.'","DivAcctId":"MDT000001","DivAmt":"'.$Fee.'"}]
				$freezetrxid=$_POST['FreezeTrxId'];
				$borrowid=$borrow_id;//标号
				$investid=$data['uid'];//为投资者id
		
			// loans 调用的问题 这里的loans 就相当于 点击复审之后 给每一笔解冻，把钱打到借款人账号。就是所谓的放款
				$huifu->loans($usrid,$transamt,$borrowercustid,$Fee,$subordid,$suborddate,$divdetails,$freezetrxid,$borrowid,$investid,$reqext);
				//放款成功后继续回调 以后台回调为准 
				unset($content,$touziren_info,$touziren_info,$shijian,$biaodi_info);
			//-----------------------------------------------------				
			}
			header("Content-type: text/html; charset=utf-8");
			redirect('/member', 3, '投标成功(同步)，页面跳转中...');
		}
		else
		{
			header("Content-type: text/html; charset=utf-8");
			echo urldecode($_POST['RespDesc']);
		}
	}
	/**
	 * 新手标后台回调 20150914 bylj
	 */
		public function ininewbietenderreturn()
	{
		file_put_contents('/tmp/debugs',date('m-d H:i:s')."\$新手标同步回调post".print_r($_POST,true)."\n",FILE_APPEND);
			$usrid = $_POST['UsrCustId'];//借款人的userid
			$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
			$yonghu_id =  $info['uid'];
			$jiner = $_POST['TransAmt'];
			$shoujihao =  $info['username'];
			$data=array();
			$data['uid'] = $info['uid'];//用户UID
			$data['username'] = $info['username'];//用户名
			$data['rescode'] = $_POST['RespCode'];//返回码
			$data['cmdid'] = $_POST['CmdId'];//消息类型
			$data['usrid'] = $_POST['UsrCustId'];//用户客户号
			$data['ordid'] = $_POST['OrdId'];//订单号
			$data['orddate'] = $_POST['OrdDate'];//订单日期
			$data['trxid'] = $_POST['TrxId'];//交易流水号
			$data['merpriv'] = $_POST['MerPriv'];
			$data['addtime'] = time();//记录时间
			$reqext=$_POST['RespExt'];//代金券的内容json字符串
			$reqext=urldecode($reqext);
			$reqext=json_decode($reqext,1);
			$reqext=$reqext['Vocher']['VocherAmt'];
			if($reqext)
			{
			/*根据订单号修改现金券的使用状态*/
			$save['is_success']=1;
			M('active_redpacket')->where('orderno='.$data['ordid'])->save($save);//把代金券修改为成功
			}
		
			$condition['uid'] = $data['uid'];
			$condition['ordid'] = $data['ordid'];
			$num = M("huifulog")->where($condition)->count();

			if($num==0)
			{
				M("huifulog")->add($data);
				$temp = base64_decode($data['merpriv']);
				$pos1 = strpos($temp,'{');
				$pos2 = strpos($temp,'}');
				$len = $pos2-$pos1+1;
				$merpriv = substr($temp,$pos1,$len);
				$merpriv = json_decode($merpriv,true);
				$borrow_id = $merpriv['borrowid'];//标ID
				$money = str2val_money($_POST['TransAmt']);//交易金额
				//查询标的利率和周期 2015-09-16
				$bininfo=M("newbie_bid")->field('borrow_uid,rate,bidtime')->where("id=".$borrow_id)->find();
			
				$info = array();
				$info['ordid'] = $data['ordid'];//订单号
				$info['orddate'] = $data['orddate'];//订单日期
				$info['freezeordid'] = $_POST['FreezeOrdId'];//冻结订单号
				$info['freezetrxid'] = $_POST['FreezeTrxId'];//冻结流水号
				$info['investid']=$data['uid'];
				$info['invest_money']=$jiner;
				$info['interest']=number_format(($jiner*$bininfo['bidtime']*($bininfo['rate']/100))/365,2);//* 利息多少 金额*时间*利率/365天
				$info['borrow_uid']=$bininfo['borrow_uid'];//2015-09-16添加一个借款人uid
				$info['invest_uid']=$data['uid'];
				$info['invest_time']=strtotime(date("Y-m-d H:i",time()));//逾期时刻
	
					//根据标号 查询借款人
				$borrow_uid=$bininfo['borrow_uid'];//1093行
				//根据借款人id 查询借款人的usrid
				$invest_usrid=M("members")->field('usrid,user_name')->where("id=".$borrow_uid)->find();
				$touzier=M("members")->field('usrid,user_name')->where("id=".$data['uid'])->find();//插入投资人电话（也就是用户名）
				//2015-09-22 插入之前首先查询是否有此人投资过 以防止异步也同时插入
				$ishas=M("newbie_record")->getFieldByInvest_id($data['uid'],'id');

				$info['username']=$touzier['user_name'];
				//要把投资者id插入 投资id 插入  投资时间 
				if(!$ishas)
				{
				$invest_info_id = M('newbie_record')->add($info);//换成新手标的表
				}
				//根据订单号查询投资人
				$invest=M('newbie_record')->field('invest_uid,ordid,orddate')->where('ordid='.$data['ordid'])->find();
	
				//通知投资人 2015-09-15 最后的1为借款人id
				memberMoneyLog($invest['invest_uid'],6,-($money-$reqext),"对{$borrow_id}号新手标进行投标",$borrow_uid);//
				//开始放款 2015-09-15 lj
				import("ORG.Huifu.Huifu");
				$huifu = new Huifu();
				//每次是单笔的复审 所以用loans方法 20150914
				$borrowercustid=$invest_usrid['usrid'];//600856564542 应该为借款人 的投资urid
				$transamt = $jiner;
				$Fee=0.00;
				$subordid=$invest['ordid'];
				$suborddate=$invest['orddate'];
				//商户号
				$tuoguan = FS("Webconfig/tuoguanconfig");
				$merCustId = $tuoguan['huifu']['MerCustId'];
				$divdetails = '';//[{"DivCustId":"'.$merCustId.'","DivAcctId":"MDT000001","DivAmt":"'.$Fee.'"}]
				$freezetrxid=$_POST['FreezeTrxId'];
				$borrowid=$borrow_id;//标号
				$investid=$data['uid'];//为投资者id
		
			// loans 调用的问题 这里的loans 就相当于 点击复审之后 给每一笔解冻，把钱打到借款人账号。就是所谓的放款
				$huifu->loans($usrid,$transamt,$borrowercustid,$Fee,$subordid,$suborddate,$divdetails,$freezetrxid,$borrowid,$investid,$reqext);
				//放款成功后继续回调 以后台回调为准 
				unset($content,$touziren_info,$touziren_info,$shijian,$biaodi_info);
			}
		echo "RECV_ORD_ID_".$_POST['OrdId'];
		
	}
	//新手标扣款（放款）后台回调 2015-09-15
	/* 放款的时候 才算利息
	*@param $borrowid 放款的id
	*/
	public function newbieloansreturn()
	{	

		file_put_contents('/tmp/isnew2',date('m-d H:i:s')."\放款后台回调:".print_r($_POST,true)."\n",FILE_APPEND);

		if(strcmp($_POST['RespCode'],"000")==0){
			$mem = new Memcache;
			$mem->connect("127.0.0.1", 11211);
			$key = 'loansreturn-'.$_POST['CmdId'].'-'.$_POST['OutCustId'];			$has = $mem->get($key);
			$has = $mem->get($key);
			if($has){
				sleep(1);
				return ;
			}else{
				//设置4秒
				$mem->set($key,1,0,3);
			}
			unset($mem,$has,$key);
		}

		$usrid = $_POST['OutCustId'];

		$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		
		$data=array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['OutCustId'];//用户客户号（出账人客户号）
		$data['ordid'] = $_POST['OrdId'];//订单号
		$data['orddate'] = $_POST['OrdDate'];//订单日期
		$data['trxid'] = "";
		$data['merpriv'] = $_POST['MerPriv'];
		$data['addtime'] = time();//记录时间
		
		//解冻金额是否减掉
		$reqext=0;
		$reqext=$_POST['RespExt'];//代金券的内容json字符串
		$reqext=json_decode(urldecode($reqext),1);
		$reqext=$reqext['LoansVocherAmt'];
		
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		$num = M("huifulog")->where($condition)->count();
		if($num==0)
		{
			M("huifulog")->add($data);
			
			if(strcmp($_POST['RespCode'],"000")==0)
			{
				$temp = base64_decode($data['merpriv']);
				$pos1 = strpos($temp,'{');
				$pos2 = strpos($temp,'}');
				$len = $pos2-$pos1+1;
				$merpriv = substr($temp,$pos1,$len);
				$merpriv = json_decode($merpriv,true);
				
				$borrowid = $merpriv['borrowid'];//标ID
				$investid = $merpriv['investid'];//投资ID
				
				$binfo = M("newbie_bid")->field("borrow_uid,bidtime")->where("id=".$borrowid)->find();
				$binforecord=M('newbie_record')->field('borrow_uid,invest_money')->where('invest_uid='.$investid)->find();
				$asql1366=M()->getLastSql();
				file_put_contents('/tmp/isnew2',date('m-d H:i:s')."ret1366binfo-:".print_r($binfo,true)."\n",FILE_APPEND);
				file_put_contents('/tmp/isnew2',date('m-d H:i:s')."\$asql1366-:".print_r($asql1366,true)."\n",FILE_APPEND);
				//还款时间
				$endTime = strtotime(date("Y-m-d H:i",time()));//计息时刻
				$endTime=$endTime+$binfo['bidtime']*24*60*60;
				//更新投资信息
				$investinfo = array();
				$investinfo['repayment_time'] = $endTime;
				$investinfo['status'] = 4;//复审通过，还款中
				M("newbie_record")->where("investid=".$investid)->save($investinfo);
	
				//解冻保证金要减去代金券 20150831
					if($reqext)
					{
					$investor_capital = str2val_money($_POST['TransAmt']-$reqext);
					$tip="第{$borrowid}号标（新手标）复审通过，冻结本金成为待收金额.使用代金券{$reqext}元";
					}else{
					$investor_capital = str2val_money($_POST['TransAmt']);
					$tip="第{$borrowid}号标（新手标）复审通过，冻结本金成为待收金额.";
					}
					//因为要给代收金额加上代金券的钱 所以要添加一个变量。20150831 by lj
				memberMoneyLog($data['uid'],15,$investor_capital,$tip,$binfo['borrow_uid'],'',0,$reqext);		
			file_put_contents('/tmp/isnew2',date('m-d H:i:s')."投资的钱-:".print_r($investor_capital,true)."\n",FILE_APPEND);
				$daishou = M('newbie_record')->field('interest')->where("invest_uid = {$data['uid']}  and investid ={$investid}")->sum('interest');
				$daishousql=M()->getLastSql();
				file_put_contents('/tmp/isnew2',date('m-d H:i:s')."daishounew-:".print_r($daishou,true)."\n",FILE_APPEND);
				file_put_contents('/tmp/isnew2',date('m-d H:i:s')."daishousql-:".print_r($daishousql,true)."\n",FILE_APPEND);
			memberMoneyLog($data['uid'],28,$daishou,"第{$borrowid}号标(新手标)复审通过，应收利息成为待收利息",$binfo['borrow_uid']);
					//投标代金券放入客户代收金额*/	
					memberMoneyLog($binfo['borrow_uid'],17,$_POST['TransAmt'],"第{$borrowid}号标(新手标)复审通过，借款金额入帐");
					//投标代金券放入客户代收金额结束*/
					//	memberMoneyLog($binfo['borrow_uid'],18,-$binfo['borrow_fee'],"第{$borrowid}号标借款成功，扣除借款管理费");
					//借款保证金
					$_P_fee=get_global_setting();
					file_put_contents('/tmp/debugwhh',date('m-d H:i:s')."_P_fee:".print_r($_P_fee,true)."\n",FILE_APPEND);
					$info1 = M("members")->field("usrid")->find($binfo['borrow_uid']);
					$usrid = $info1['usrid'];
					$transamt = $_P_fee['money_deposit']*$binforecord['invest_money']/100;
					file_put_contents('/tmp/debugwhh',date('m-d H:i:s')."newtransamt:".print_r($transamt,true)."\n",FILE_APPEND);
					import("ORG.Huifu.Huifu");
					$huifu = new Huifu();
					$huifu->usrFreezeBg($usrid,$transamt,$borrowid);

				//把款打给借款人

			}
			
			echo "RECV_ORD_ID_".$_POST['OrdId'];
		}
		

	}

	//自动扣款（放款）后台回调
	public function loansreturn()
	{
		file_put_contents('/tmp/debugwhh',date('m-d H:i:s')."\$_POST:".print_r($_POST,true)."\n",FILE_APPEND);

		if(strcmp($_POST['RespCode'],"000")==0){
			$mem = new Memcache;
			$mem->connect("127.0.0.1", 11211);
			$key = 'loansreturn-'.$_POST['CmdId'].'-'.$_POST['OutCustId'];		
			$has = $mem->get($key);
			if($has){
				sleep(1);
				//return ;
			}else{
				//设置4秒
				$mem->set($key,1,0,1);
			}
			unset($mem,$has,$key);
		}

		$usrid = $_POST['OutCustId'];

		$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		
		$data=array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['OutCustId'];//用户客户号（出账人客户号）
		$data['ordid'] = $_POST['OrdId'];//订单号
		$data['orddate'] = $_POST['OrdDate'];//订单日期
		$data['trxid'] = "";
		$data['merpriv'] = $_POST['MerPriv'];
		$data['addtime'] = time();//记录时间


		
		//解冻金额是否减掉
		$reqext=0;
		$reqext=$_POST['RespExt'];//代金券的内容json字符串
		$reqext=json_decode(urldecode($reqext),1);
		$reqext=$reqext['LoansVocherAmt'];
		
		file_put_contents('/tmp/debugwhh',date('m-d H:i:s')."reqext:".print_r($reqext,true)."\n",FILE_APPEND);

		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		$num = M("huifulog")->where($condition)->count();
		$md=M()->getLastSql();
		file_put_contents('/tmp/debugwhh',date('m-d H:i:s')."\md:".print_r($md,true)."\n",FILE_APPEND);
		if($num==0)
		{
			M("huifulog")->add($data);
			
			if(strcmp($_POST['RespCode'],"000")==0)
			{
				$temp = base64_decode($data['merpriv']);
				$pos1 = strpos($temp,'{');
				$pos2 = strpos($temp,'}');
				$len = $pos2-$pos1+1;
				$merpriv = substr($temp,$pos1,$len);
				$merpriv = json_decode($merpriv,true);
				
				$borrowid = $merpriv['borrowid'];//标ID
				$investid = $merpriv['investid'];//投资ID
				
				$binfo = M("borrow_info")->field("borrow_type,reward_type,reward_num,borrow_fee,borrow_money,borrow_uid,borrow_duration,repayment_type,manage_rate")->find($borrowid);
				
				//还款时间
				$endTime = strtotime(date("Y-m-d",time())." 23:59:59");//逾期时刻
				
				if($binfo['borrow_type']==3 || $binfo['repayment_type']==1)
				{
					$deadline = strtotime("+{$binfo['borrow_duration']} day",$endTime);//天标或秒标
				}
				else
				{
					$deadline = strtotime("+{$binfo['borrow_duration']} month",$endTime);//月标
				}
				
				//更新投资信息
				$investinfo = array();
				$investinfo['deadline'] = $deadline;
				$investinfo['status'] = 4;//复审通过，还款中
				M("borrow_investor")->where("id=".$investid)->save($investinfo);
				
				//更新还款信息
				switch($binfo['repayment_type']){
					case 2://每月还款
					case 3://每季还本
					case 4://期未还本
						for($i=1;$i<=$binfo['borrow_duration'];$i++){
							$repaymentinfo = array();
							$deadlines=strtotime("+{$i} month",$endTime);//月还款时间
							$repaymentinfo['deadline'] = $deadlines;
							$repaymentinfo['status'] = 7;//复审通过，还款中
							M("investor_detail")->where("invest_id={$investid} AND  `sort_order` ={$i}")->save($repaymentinfo);
							
						}
						break;
					case 1://按天一次性还款
					case 5://一次性还款
						$repaymentinfo = array();
						$repaymentinfo['deadline'] = $deadline;//一次性还款时间
						$repaymentinfo['status'] = 7;//复审通过，还款中
						M("investor_detail")->where("invest_id=".$investid)->save($repaymentinfo);
						break;
				}
				//解冻保证金要减去代金券 20150831
					if($reqext)
					{
					$investor_capital = str2val_money($_POST['TransAmt']-$reqext);
					$tip="第{$borrowid}号标复审通过，冻结本金成为待收金额.使用代金券{$reqext}元";
					}else{
					$investor_capital = str2val_money($_POST['TransAmt']);
					$tip="第{$borrowid}号标复审通过，冻结本金成为待收金额.";
					}
					//因为要给代收金额加上代金券的钱 所以要添加一个变量。20150831 by lj
				memberMoneyLog($data['uid'],15,$investor_capital,$tip,$binfo['borrow_uid'],'',0,$reqext);

				 file_put_contents('/tmp/debugwhh',date('m-d H:i:s')."is_null_req:".print_r($reqext,true)."\n",FILE_APPEND);
				
				$daishou = M('investor_detail')->field('interest')->where("investor_uid = {$data['uid']} and borrow_id = {$borrowid} and invest_id ={$investid}")->sum('interest');
	
				memberMoneyLog($data['uid'],28,$daishou,"第{$borrowid}号标复审通过，应收利息成为待收利息",$binfo['borrow_uid']);
				//memberMoneyLog($vo['recommend_id'],13,$jiangli,$vo['user_name']."对{$borrow_id}号标投资成功，你获得推广奖励".$jiangli."元。",$v['investor_uid']);
				$id = M("borrow_investor")->field('id')->where("borrow_id=".$borrowid)->order('id desc')->find();
				
				if($id['id']==$investid)
				{
					$borrowinfo = array();
					$borrowinfo['deadline'] = $deadline;
					$borrowinfo['borrow_status'] = 6;
					M("borrow_info")->where("id=".$borrowid)->save($borrowinfo);//更新借款信息
					//投标代金券放入客户代收金额*/	
					memberMoneyLog($binfo['borrow_uid'],17,$binfo['borrow_money'],"第{$borrowid}号标复审通过，借款金额入帐");
					//投标代金券放入客户代收金额结束*/
					$total = M("borrow_info")->field("danbao,borrow_money")->where("id=".$borrowid)->find();
					//如果担保公司存在
					if($total['danbao'] != 0)
					{
						$Guar =M('members')->field("usrid,id")->where("id = ".$total['danbao'])->find();
						$guar_rate = M('member_guarrate')->where("uid = ".$total['danbao'])->find();//担保费率
						$rates_fee = $guar_rate['guarrate']*$binfo['borrow_money']/100;
						memberMoneyLog($binfo['borrow_uid'],104,-$rates_fee,"第{$borrowid}号标借款成功，扣除担保费");//借款者付出担保费
						memberMoneyLog($Guar['id'],105,$rates_fee,"第{$borrowid}号标借款成功，获得担保费");//担保者获得担保费
					}
					memberMoneyLog($binfo['borrow_uid'],18,-$binfo['borrow_fee'],"第{$borrowid}号标借款成功，扣除借款管理费");
					
					//借款保证金
					$_P_fee=get_global_setting();
					$info1 = M("members")->field("usrid")->find($binfo['borrow_uid']);
					$usrid = $info1['usrid'];
					$transamt = $_P_fee['money_deposit']*$total['borrow_money']/100;
					import("ORG.Huifu.Huifu");
					$huifu = new Huifu();
					$huifu->usrFreezeBg($usrid,$transamt,$borrowid);
				}
			}
			
				echo "RECV_ORD_ID_".$_POST['OrdId'];
		}
	
		
		
	}
	//自动扣款（还款）新手标后台回调 -2015-09-16
	public function newbie_repayment()
	{
		//file_put_contents("/tmp/isnew2", data)
		file_put_contents('/tmp/isnew2',date('m-d H:i:s').'\新手标后台回调post/-:'.print_r($_POST,true)."\n",FILE_APPEND);
		if(strcmp($_POST['RespCode'],"000")==0){
			$mem = new Memcache;
			$mem->connect("127.0.0.1", 11211);
			$key = $_POST['CmdId'].'-'.$_POST['InCustId'];//入账
			$has = $mem->get($key);
			if($has){
				sleep(1);
				return ;
			}else{
				//设置4秒
				$mem->set($key,1,0,6);
			}
			unset($mem);
		}
		$usrid = $_POST['OutCustId'];
		//echo $usrid;
		$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();

		//借款人的真实名字 by whh
		$jiekuan = M("member_info")->field("real_name")->where("uid=".$info['uid'])->find();
		
		$data=array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['OutCustId'];//用户客户号（出账人客户号）
		$data['ordid'] = $_POST['OrdId'];//订单号
		$data['orddate'] = $_POST['OrdDate'];//订单日期
		$data['trxid'] = "";
		$data['merpriv'] = $_POST['MerPriv'];
		$data['addtime'] = time();//记录时间
		$SubOrdId = $_POST['SubOrdId'];
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		$num = M("huifulog")->where($condition)->count();
		if($num==0)
		{
			M("huifulog")->add($data);
			
			if(strcmp($_POST['RespCode'],"000")==0)
			{
				$temp = base64_decode($data['merpriv']);
				$pos1 = strpos($temp,'{');
				$pos2 = strpos($temp,'}');
				$len = $pos2-$pos1+1;
				$merpriv = substr($temp,$pos1,$len);
				$merpriv = json_decode($merpriv,true);
				file_put_contents('/tmp/isnew2',date('m-d H:i:s').'\$merprivret1647/-:'.print_r($merpriv,true)."\n",FILE_APPEND);
				$repaymentid = $merpriv['investorid'];// newbie_record 里面的投资记录id
				$borrowid = $merpriv['borrowid'];//标ID
				$investorid = $merpriv['type'];//这里的type 其实是 投资者id 应该是参数顺序造成的
				//投资人真实姓名 by whh
				$touziren_info = M("member_info")->field("real_name")->where("uid=".$investorid)->find();
				//投资人投资金额 lj		
				$pre = C('DB_PREFIX');
				// $binfo = M("borrow_info i")->field("i.borrow_uid,i.has_pay,i.total,i.danbao,m.user_name")->join("{$pre}members m ON i.borrow_uid=m.id")->where("i.id=".$borrowid)->find();
				//$binfo = M("newbie_record")->field("id,invest_uid,borrow_type,borrow_money,bidtime,repayment_time")->find($borrow_id);
				$interestinfo = M("newbie_record")->field("invest_uid,invest_money,interest,borrow_uid")->where('id='.$repaymentid)
				                                  ->find();
	
				//投资人账户增加
				$accountMoney = M('member_money')->field('money_freeze,money_collect,account_money,back_money')->find($investorid);

				file_put_contents('/tmp/isnew2',date('m-d H:i:s').'\$accountMoney-ret-1664/-:'.print_r($accountMoney,true)."\n",FILE_APPEND);
				$datamoney['affect_money'] = str2val_money($_POST['TransAmt']);//交易金额（利息加本金）
				file_put_contents('/tmp/isnew2',date('m-d H:i:s').'\利息+本金/-:'.print_r($datamoney['affect_money'],true)."\n",FILE_APPEND);
				$datamoney['collect_money'] = $accountMoney['money_collect'] - $datamoney['affect_money'];
				//待收金额减少 
				$datamoney['freeze_money'] = $accountMoney['money_freeze'];//冻结金额不变
				$datamoney['account_money'] = $accountMoney['account_money'];//充值账户不变
				$datamoney['back_money'] = $accountMoney['back_money'] + $datamoney['affect_money'];//回款账户增加
		
				//投资人帐户
				$mmoney['money_freeze']=$datamoney['freeze_money'];
				$mmoney['money_collect']=$datamoney['collect_money'];
				$mmoney['account_money']=$datamoney['account_money'];
				$mmoney['back_money']=$datamoney['back_money'];
				//因为type 写死是1 所以 只有会员自己还款 不存在其他
				//投资人的消息通知
				$datamoney['uid'] = $investorid;//传递的投资人id
				$datamoney['type'] = 9;//会员还款
				$datamoney['info'] = "收到会员对{$borrowid}号标(新手标)的还款";
				$datamoney['add_time'] = time();
				$datamoney['add_ip'] = get_client_ip();
				$datamoney['target_uid'] = $interestinfo['borrow_uid'];
				$borrow_uname=M("member_info")->field("real_name")->where('uid='.$interestinfo['borrow_uid'])->find();//借款人的名字
				$datamoney['target_uname'] = $borrow_uname['real_name'];
				$moneynewid = M('member_moneylog')->add($datamoney);
				$moneynewidtouzisql=M()->getLastSql();
				file_put_contents('/tmp/isnew2',date('m-d H:i:s').'\$moneynewidtouzisql-1687/-:'.print_r($moneynewidtouzisql,true)."\n",FILE_APPEND);
				file_put_contents('/tmp/isnew2',date('m-d H:i:s').'\datamoney-1687/-:'.print_r($datamoney,true)."\n",FILE_APPEND);
				if($moneynewid)
				{
					M('member_money')->where("uid={$datamoney['uid']}")->save($mmoney);
					//add by zh 0309,0318
					$investorInfo=M('members')->field("user_phone")->where("id=".$investorid)->find();
					$mob=$investorInfo['user_phone'];				
					//by whh
					$content="尊敬的财来网投资人".$touziren_info['real_name'].",您借给".$jiekuan['real_name'].'的'.$interestinfo['invest_money']."元，".date("Y")."年".date("m")."月".date("d")."日".date("H").":".date("i")."收到(新手标)还款{$datamoney['affect_money']}元(利息{$interestinfo['interest']}元)。敬请查收。详情请咨询客户经理，或致电400-079-8558";

					sendsms(text($mob),$content);
					//add end
			      	$data=array(
                                    'member_id'=>$investorid,
                                    'content'=>$content,
                               );
                    insert_push_information($data);// insert push information 
				
				}//$moneynewid

					//对借款人的消息提示
				
					$vo = M("newbie_record")->field('repayment_time,invest_money,interest')->where("id=".$repaymentid)->find();
					$vosql=M()->getLastSql();

					file_put_contents('/tmp/isnew2',date('m-d H:i:s').'\$vosql-ret-1708/-:'.print_r($vosql,true)."\n",FILE_APPEND);
					file_put_contents('/tmp/isnew2',date('m-d H:i:s').'\$vo_x/-:'.print_r($vo,true)."\n",FILE_APPEND);
					$accountMoney_borrower = M('member_money')->field('money_freeze,money_collect,account_money,back_money')
					                                          ->find($interestinfo['borrow_uid']);
					$datamoney_x['uid'] = $interestinfo['borrow_uid'];
					$datamoney_x['type'] = 11;
		
			
					$datamoney_x['affect_money'] = -($vo['invest_money']+$vo['interest']);
					if(($datamoney_x['affect_money']+$accountMoney_borrower['back_money'])<0)
					{//如果需要还款的金额大于回款资金池资金总额
						$datamoney_x['account_money'] = floatval($accountMoney_borrower['account_money']+$accountMoney_borrower['back_money'] + $datamoney_x['affect_money']);
						$datamoney_x['back_money'] = 0;
					}
					else
					{
						$datamoney_x['account_money'] = $accountMoney_borrower['account_money'];
						$datamoney_x['back_money'] = floatval($accountMoney_borrower['back_money']) + $datamoney_x['affect_money'];//回款资金注入回款资金池
					}	
					$datamoney_x['collect_money'] = $accountMoney_borrower['money_collect'];
					$datamoney_x['freeze_money'] = $accountMoney_borrower['money_freeze'];
			
					//还款人帐户
					$mmoney_x['money_freeze']=$datamoney_x['freeze_money'];
					$mmoney_x['money_collect']=$datamoney_x['collect_money'];
					$mmoney_x['account_money']=$datamoney_x['account_money'];
					$mmoney_x['back_money']=$datamoney_x['back_money'];
			
					//还款人帐户
					$datamoney_x['info'] = "对{$borrowid}号标(新手标)还款";
					$datamoney_x['add_time'] = time();
					$datamoney_x['add_ip'] = get_client_ip();
					$datamoney_x['target_uid'] = 0;
					$datamoney_x['target_uname'] = '@网站管理员@';
					$moneynewid_x = M('member_moneylog')->add($datamoney_x);

					file_put_contents('/tmp/isnew2',date('m-d H:i:s').'\$datamoney_x/-:'.print_r($datamoney_x,true)."\n",FILE_APPEND);
					if($moneynewid_x)
					{
						$bxid = M('member_money')->where("uid={$datamoney_x['uid']}")->save($mmoney_x);
					}
					$datag = get_global_setting();
					// $credit_borrow = explode( "|", $datag['credit_borrow'] );
					// $day_span = ceil( ( $vo['repayment'] - time( ) ) / 86400 );
					// $credits_money = intval( $vo['capital'] / $credit_borrow[4] );
					// $credits_info = "对第{$borrow_id}号标的还款操作,获取投资积分";
			
					
					//更新借款信息 //操作记录表的status 已还 为7 2015-0916 lj
					$repayment_time = strtotime(date('Y-m-d H:i'));

					$upborrowsql = "update `{$pre}newbie_record` set ";
					
					$upborrowsql .= "`status`=7,`repayment_time`={$repayment_time}";//那么表示标已经还完

					$upborrowsql .= " WHERE `id`={$repaymentid}";

					$upborrow_res = M()->execute($upborrowsql);
			}
		//file_put_contents('/tmp/debugwhh',date('m-d H:i:s').'repayment_RECV_ORD_ID_:'.print_r($_POST['OrdId'],true)."\n",FILE_APPEND);
			echo "RECV_ORD_ID_".$_POST['OrdId'];
		}

		
	}

	//自动扣款（还款）后台回调
	public function repayment()
	{
		//sleep 0,4秒
		//$sleep = rand(0,4000000);
		//usleep($sleep);
		if(strcmp($_POST['RespCode'],"000")==0){
			$mem = new Memcache;
			$mem->connect("127.0.0.1", 11211);
			$key = $_POST['CmdId'].'-'.$_POST['InCustId'];//入账
			$has = $mem->get($key);
			if($has){
				sleep(1);
				return ;
			}else{
				//设置4秒
				$mem->set($key,1,0,6);
			}
			unset($mem);
		}
		$usrid = $_POST['OutCustId'];
		$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();

		//借款人的真实名字 by whh
		$jiekuan = M("member_info")->field("real_name")->where("uid=".$info['uid'])->find();
		
		$data=array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['OutCustId'];//用户客户号（出账人客户号）
		$data['ordid'] = $_POST['OrdId'];//订单号
		$data['orddate'] = $_POST['OrdDate'];//订单日期
		$data['trxid'] = "";
		$data['merpriv'] = $_POST['MerPriv'];
		$data['addtime'] = time();//记录时间
		

		$SubOrdId = $_POST['SubOrdId'];
		
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		$num = M("huifulog")->where($condition)->count();
		if($num==0)
		{
			M("huifulog")->add($data);
			
			if(strcmp($_POST['RespCode'],"000")==0)
			{
				$temp = base64_decode($data['merpriv']);
				$pos1 = strpos($temp,'{');
				$pos2 = strpos($temp,'}');
				$len = $pos2-$pos1+1;
				$merpriv = substr($temp,$pos1,$len);
				$merpriv = json_decode($merpriv,true);
				
				$investorid = $merpriv['investorid'];//投资人ID
				$borrowid = $merpriv['borrowid'];//标ID
				$repaymentid = $merpriv['repaymentid'];//还款ID
				$sort_order = $merpriv['sortorder'];//还款期数
				$type = $merpriv['type'];//还款类型（1：会员自己还，2：网站代还，3：担保公司代还）

				//投资人真实姓名 by whh
				$touziren_info = M("member_info")->field("real_name")->where("uid=".$investorid)->find();

				//投资人投资金额 by whh  存在一个人对一个标投多次的情况
				$touzijiner = M("borrow_investor")->field("investor_capital")->where("borrow_id=".$borrowid." and investor_uid=".$investorid." and ordid='".$SubOrdId."'")->find();
				
				$pre = C('DB_PREFIX');
				$binfo = M("borrow_info i")->field("i.borrow_uid,i.has_pay,i.total,i.danbao,m.user_name")->join("{$pre}members m ON i.borrow_uid=m.id")->where("i.id=".$borrowid)->find();
				//$binfo = M("borrow_info")->field("id,borrow_uid,borrow_type,borrow_money,borrow_duration,repayment_type,has_pay,total,deadline")->find($borrow_id);
				$interestinfo = M("investor_detail")->field("invest_id,capital,interest,interest_fee,interest_fee_yh")->find($repaymentid);
				
				//投资人账户增加
				$accountMoney = M('member_money')->field('money_freeze,money_collect,account_money,back_money')->find($investorid);
			
				$datamoney['uid'] = $investorid;
				if($type == 1)
				{
					$datamoney['type'] = 9;//会员还款
				}
				else if($type == 2)
				{
					$datamoney['type'] = 10;//网站代还
				}
				else if($type == 3)
				{
					$datamoney['type'] = 49;//担保公司代还
				}
				$datamoney['affect_money'] = str2val_money($_POST['TransAmt']);//交易金额（利息加本金）
				$datamoney['collect_money'] = $accountMoney['money_collect'] - $datamoney['affect_money'];//待收金额减少
				$datamoney['freeze_money'] = $accountMoney['money_freeze'];//冻结金额不变
				$datamoney['account_money'] = $accountMoney['account_money'];//充值账户不变
				$datamoney['back_money'] = $accountMoney['back_money'] + $datamoney['affect_money'];//回款账户增加
		
				//投资人帐户
				$mmoney['money_freeze']=$datamoney['freeze_money'];
				$mmoney['money_collect']=$datamoney['collect_money'];
				$mmoney['account_money']=$datamoney['account_money'];
				$mmoney['back_money']=$datamoney['back_money'];
				
				if($type == 1)
				{
					$datamoney['info'] = "收到会员对{$borrowid}号标第{$sort_order}期的还款";
				}
				else if($type == 2)
				{
					$datamoney['info'] = "网站对{$borrowid}号标第{$sort_order}期代还";
				}
				else if($type == 3)
				{
					$datamoney['info'] = "担保公司对{$borrowid}号标第{$sort_order}期代还";
				}
				$datamoney['add_time'] = time();
				$datamoney['add_ip'] = get_client_ip();
				$datamoney['target_uid'] = $binfo['borrow_uid'];
				$datamoney['target_uname'] = $binfo['user_name'];
				
				$moneynewid = M('member_moneylog')->add($datamoney);
				if($moneynewid)
				{
					M('member_money')->where("uid={$datamoney['uid']}")->save($mmoney);
					//add by zh 0309,0318
					$investorInfo=M('members')->field("user_phone")->where("id=".$investorid)->find();
					$mob=$investorInfo['user_phone'];
					//$content="收到对{$borrowid}号标第{$sort_order}期的还款{$datamoney['affect_money']}元,其中{$interestinfo['capital']}元，利息{$interestinfo['interest']}元";
					//$content="收到对{$borrowid}号标第{$sort_order}期的还款{$datamoney['affect_money']}元,利息{$interestinfo['interest']}元";
					
					//by whh
					$content="尊敬的财来网投资人".$touziren_info['real_name'].",您借给".$jiekuan['real_name'].'的'.$touzijiner['investor_capital']."元，".date("Y")."年".date("m")."月".date("d")."日".date("H").":".date("i")."收到第{$sort_order}期的还款{$datamoney['affect_money']}元(利息{$interestinfo['interest']}元)。敬请查收。详情请咨询客户经理，或致电400-079-8558";

					sendsms(text($mob),$content);
					//add end
					                                        $data=array(
                                            'member_id'=>$investorid,
                                            'content'=>$content,
                                        );
                                        insert_push_information($data);// insert push information 
				
				}
				/*  by whh 利息管理费不用处理
				//利息管理费
				$accountMoney_z = M('member_money')->field('money_freeze,money_collect,account_money,back_money')->find($investorid);
				$datamoney_z['uid'] = $investorid;
				$datamoney_z['type'] = 23;//利息管理费
				$datamoney_z['affect_money'] = -$interestinfo['interest_fee'];//扣管理费
				$datamoney_z['collect_money'] = $accountMoney_z['money_collect'];
				$datamoney_z['freeze_money'] = $accountMoney_z['money_freeze'];
				
				if(($accountMoney_z['back_money'] + $datamoney_z['affect_money'])<0){
					$datamoney_z['back_money'] =0;
					$datamoney_z['account_money'] = $accountMoney_z['account_money'] +$accountMoney_z['back_money']+ $datamoney_z['affect_money'];
				}else{
					$datamoney_z['account_money'] = $accountMoney_z['account_money'];
					$datamoney_z['back_money'] = $accountMoney_z['back_money'] + $datamoney_z['affect_money'];
				}
				
				//投资人帐户
				$mmoney_z['money_freeze']=$datamoney_z['freeze_money'];
				$mmoney_z['money_collect']=$datamoney_z['collect_money'];
				$mmoney_z['account_money']=$datamoney_z['account_money'];
				$mmoney_z['back_money']=$datamoney_z['back_money'];
				
				//投资人帐户
				$datamoney_z['info'] = "网站已将第{$borrowid}号标第{$sort_order}期还款的利息管理费扣除，优惠了".($interestinfo['interest_fee_yh']-$interestinfo['interest_fee'])."元";
				$datamoney_z['add_time'] = time();
				$datamoney_z['add_ip'] = get_client_ip();
				$datamoney_z['target_uid'] = 0;
				$datamoney_z['target_uname'] = '@网站管理员@';
				$moneynewid_z = M('member_moneylog')->add($datamoney_z);
				if($moneynewid_z)
				{
					M('member_money')->where("uid={$datamoney_z['uid']}")->save($mmoney_z);
				}
				*/
				
				$id = M("investor_detail")->field('id')->where("borrow_id={$borrowid} AND sort_order={$sort_order}")->order('id desc')->find();
				if($id['id'] == $repaymentid)
				{
					$vo = M("investor_detail")->field('deadline, sum(capital) as capital, sum(interest) as interest, sum(interest_fee) as interest_fee ')->where("borrow_id={$borrowid} AND sort_order={$sort_order}")->find();
						
					if($type == 1)
					{
						$accountMoney_borrower = M('member_money')->field('money_freeze,money_collect,account_money,back_money')->find($binfo['borrow_uid']);
						$datamoney_x['uid'] = $binfo['borrow_uid'];
						$datamoney_x['type'] = 11;
					}
					else if($type == 3)
					{
						$accountMoney_borrower = M('member_money')->field('money_freeze,money_collect,account_money,back_money')->find($binfo['danbao']);
						$datamoney_x['uid'] = $binfo['danbao'];
						$datamoney_x['type'] = 50;
					}
					$datamoney_x['affect_money'] = -($vo['capital']+$vo['interest']);
					if(($datamoney_x['affect_money']+$accountMoney_borrower['back_money'])<0)
					{//如果需要还款的金额大于回款资金池资金总额
						$datamoney_x['account_money'] = floatval($accountMoney_borrower['account_money']+$accountMoney_borrower['back_money'] + $datamoney_x['affect_money']);
						$datamoney_x['back_money'] = 0;
					}
					else
					{
						$datamoney_x['account_money'] = $accountMoney_borrower['account_money'];
						$datamoney_x['back_money'] = floatval($accountMoney_borrower['back_money']) + $datamoney_x['affect_money'];//回款资金注入回款资金池
					}	
					$datamoney_x['collect_money'] = $accountMoney_borrower['money_collect'];
					$datamoney_x['freeze_money'] = $accountMoney_borrower['money_freeze'];
			
					//还款人帐户
					$mmoney_x['money_freeze']=$datamoney_x['freeze_money'];
					$mmoney_x['money_collect']=$datamoney_x['collect_money'];
					$mmoney_x['account_money']=$datamoney_x['account_money'];
					$mmoney_x['back_money']=$datamoney_x['back_money'];
			
					//还款人帐户
					if($type == 1)
					{
						$datamoney_x['info'] = "对{$borrowid}号标第{$sort_order}期还款";
					}
					else if($type == 3)
					{
						$datamoney_x['info'] = "对{$borrowid}号标第{$sort_order}期代还";
					}
					$datamoney_x['add_time'] = time();
					$datamoney_x['add_ip'] = get_client_ip();
					$datamoney_x['target_uid'] = 0;
					$datamoney_x['target_uname'] = '@网站管理员@';
					$moneynewid_x = M('member_moneylog')->add($datamoney_x);
					if($moneynewid_x)
					{
						$bxid = M('member_money')->where("uid={$datamoney_x['uid']}")->save($mmoney_x);
					}
					
					
					
					$datag = get_global_setting();
					$credit_borrow = explode( "|", $datag['credit_borrow'] );
					$day_span = ceil( ( $vo['deadline'] - time( ) ) / 86400 );
					$credits_money = intval( $vo['capital'] / $credit_borrow[4] );
					$credits_info = "对第{$borrow_id}号标的还款操作,获取投资积分";
					if ( 0 <= $day_span && $day_span < 1 )
					{
									$credits_result = memberintegrallog( $binfo['borrow_uid'], 1, intval( $vo['capital'] / 1000 ), "对第{$borrow_id}号标进行了正常的还款操作,获取投资积分" );
									$idetail_status = 1;
					}
					else if ( -3 <= $day_span && $day_span < 0 )
					{
									$credits_result = membercreditslog( $binfo['borrow_uid'], 4, $credits_money * $credit_borrow[1], "对第{$borrow_id}号标的还款操作(迟到还款),扣除信用积分" );
									$idetail_status = 3;
					}
					else if ( $day_span < -3 )
					{
									$credits_result = membercreditslog( $binfo['borrow_uid'], 5, $credits_money * $credit_borrow[2], "对第{$borrow_id}号标的还款操作(逾期还款),扣除信用积分" );
									$idetail_status = 5;
					}
					else if ( 1 <= $day_span )
					{
									$credits_result = memberintegrallog( $binfo['borrow_uid'], 1, intval( $vo['capital'] * $day_span / 1000 ), "对第{$borrow_id}号标进行了提前还款操作,获取投资积分" );
									$idetail_status = 2;
					}
					
					
					//更新借款信息
					$upborrowsql = "update `{$pre}borrow_info` set ";
					$upborrowsql .= "`repayment_money`=`repayment_money`+{$vo['capital']}";
					$upborrowsql .= ",`repayment_interest`=`repayment_interest`+ {$vo['interest']}";
					$upborrowsql .= ",`has_pay`={$sort_order}";
					
					
					if ( $sort_order == $binfo['total'] )//如果当前还款期数等于最后一起
					{
						$upborrowsql .= ",`borrow_status`=7";//那么表示标已经还完
					}
					$upborrowsql .= ",`has_pay`={$sort_order}";
					//if ( $is_expired )
					//{
					//	$upborrowsql .= ",`expired_money`=`expired_money`+{$expired_money}";//逾期金额（已废弃）
					//}
					$upborrowsql .= " WHERE `id`={$borrowid}";
					$upborrow_res = M()->execute($upborrowsql);
					//更新投资表详情
					$receive_interest_yes =$interestinfo['interest'] - $interestinfo['interest_fee'];//利息减去利息管理费
					$upsql = "update `{$pre}borrow_investor` set ";
					$upsql .= "`receive_capital`=`receive_capital`+{$interestinfo['capital']},";
					$upsql .= "`receive_interest`=`receive_interest`+ {$receive_interest_yes},";
					if ( $type == 2 || $type == 3)
					{
						$total_s_invest = $interestinfo['capital'] + $receive_interest_yes;
						$upsql .= "`substitute_money` = `substitute_money` + {$total_s_invest},";
					}
					if ( $sort_order == $binfo['total'] )
					{
						$upsql .= "`status`=5,";
					}
					$upsql .= "`paid_fee`=`paid_fee`+{$interestinfo['interest_fee']}";
					$upsql .= " WHERE `id`={$interestinfo['invest_id']}";
					$upinfo_res = M()->execute( $upsql );
					//更新还款详情
					$updetail_res = M()->execute("update `{$pre}investor_detail` set `receive_capital`=`capital` ,`receive_interest`=(`interest`-`interest_fee`),`status` = {$idetail_status},`repayment_time`=".time()." WHERE `borrow_id`={$borrowid} AND `sort_order`={$sort_order}");
					
					
				}
			}
						file_put_contents('/tmp/debugwhh',date('m-d H:i:s').'repayment_RECV_ORD_ID_:'.print_r($_POST['OrdId'],true)."\n",FILE_APPEND);
			echo "RECV_ORD_ID_".$_POST['OrdId'];
		}

		
	}
	
	//自动扣款转账（商户用）后台回调
	public function transferret()
	{
//                file_put_contents("/tmp/transferret", date('m-d H:i:s')." return  ".print_r($_POST,true)."\n",FILE_APPEND);
                $usrid = $_POST['InCustId'];
		$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		
		$data=array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['InCustId'];//用户客户号（收款人客户号）
		$data['ordid'] = $_POST['OrdId'];//订单号
		$data['orddate'] = "";
		$data['trxid'] = "";
		$data['addtime'] = time();//记录时间
		$transAmt = $_POST['TransAmt'];
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		$num = M("huifulog")->where($condition)->count();        
                $memberMoneyTable = M('member_money');
                if($num==0)
		{
			M("huifulog")->add($data);
		}
                
		//处理推荐人奖励批量转账返回数据  zxm 2015-10-13
                $map=array(
                    'ordid'=>$data['ordid'],
                    'flag'=>'0',
                    'recommend_id'=>$data['uid'],
                );
                $arr=array(
                    'flag'=>'1',
                    'rescode'=>$data['rescode'],
                    'dealtime'=>time(),
                );
                $MemberAward=M("member_award");
                $MemberAward->where($map)->save($arr);
                $awardData=$MemberAward->where("ordid=".$data['ordid'])->find();
                
//                $s=M()->getlastsql();
//                file_put_contents('/tmp/zhosoft',date('m-d H:i:s')."SQL:".print_r($s,true)."\n",FILE_APPEND);
                $MM = M("member_money")->field("money_freeze,money_collect,account_money,back_money")->where("uid={$awardData['recommend_id']}")->find();
                $members=M("members")->where("id={$awardData['uid']}")->find();
                $_data['uid'] = $awardData['recommend_id'];
                $_data['type'] = '13';
                $_data['info'] = $members['user_name']."对{$awardData['bid']}号标投资成功，你获得推广奖励".$awardData['award_money']."元。";
                $_data['target_uid'] = $awardData['uid'];
                $_data['target_uname'] = M('members')->getFieldById($awardData['uid'],'user_name');
                $_data['add_time'] = time();
                $_data['add_ip'] = get_client_ip();
                $_data['affect_money'] = $awardData['award_money'];

                if(($MM['account_money']+$awardData['award_money'])<=0){
                    $_data['account_money'] = 0;
                    $_data['back_money'] = $MM['account_money']+$MM['back_money']+$awardData['award_money'];
                }else{
                    $_data['account_money'] = $MM['account_money']+$awardData['award_money'];
                    $_data['back_money'] = $MM['back_money'];
                }
                $_data['collect_money'] = $MM['money_collect'];		
                $_data['freeze_money'] = $MM['money_freeze'];

                $newid = M('member_moneylog')->add($_data);

                //帐户更新
                $mmoney['money_freeze']=$_data['freeze_money'];
                $mmoney['money_collect']=$_data['collect_money'];
                $mmoney['account_money']=$_data['account_money'];
                $mmoney['back_money']=$_data['back_money'];

                if($newid){
                    $xid = M('member_money')->where("uid={$awardData['recommend_id']}")->save($mmoney);
                }

                echo "RECV_ORD_ID_".$_POST['OrdId']; 
	}

	//自动扣款转账（商户用）后台回调
	public function transferret2()
	{
                $usrid = $_POST['InCustId'];
		$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		
		$data=array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['InCustId'];//用户客户号（收款人客户号）
		$data['ordid'] = $_POST['OrdId'];//订单号
		$data['orddate'] = "";
		$data['trxid'] = "";
		$data['addtime'] = time();//记录时间
		$transAmt = $_POST['TransAmt'];
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		$num = M("huifulog")->where($condition)->count();        
                $memberMoneyTable = M('member_money');
                if($num==0)
		{
			M("huifulog")->add($data);
		} 
            if(strcmp($_POST['RespCode'],"000")==0){
                    $accountMoney_z = M('member_money')->field('money_freeze,money_collect,account_money,back_money')->find($data['uid']);
                    $datamoney_z['uid'] = $data['uid'];
                    $datamoney_z['type'] = 188;
                    $datamoney_z['affect_money'] = str2val_money($_POST['TransAmt']);//转账给个人金额
                    $datamoney_z['collect_money'] = $accountMoney_z['money_collect']; 

                    $datamoney_z['freeze_money'] = $accountMoney_z['money_freeze'];


                    $datamoney_z['account_money'] = $accountMoney_z['account_money'] + $datamoney_z['affect_money'];
                    $datamoney_z['back_money'] = $accountMoney_z['back_money'] ;

                    //还款人帐户
                    $mmoney_z['money_freeze']=$datamoney_z['freeze_money'];
                    $mmoney_z['money_collect']=$datamoney_z['collect_money'];
                    $mmoney_z['account_money']=$datamoney_z['account_money'];
                    $mmoney_z['back_money']=$datamoney_z['back_money'];

                    //还款人帐户
                    $datamoney_z['info'] = "平台转账给个人".str2val_money($_POST['TransAmt'])."元";
                    $datamoney_z['add_time'] = time();
                    $datamoney_z['add_ip'] = get_client_ip();
                    $datamoney_z['target_uid'] = 0;
                    $datamoney_z['target_uname'] = '@网站管理员@';
                    $moneynewid_z = M('member_moneylog')->add($datamoney_z);
                    if($moneynewid_z)
                    {
                            M('member_money')->where("uid={$datamoney_z['uid']}")->save($mmoney_z);
                    }
			
            }	
		           
		echo "RECV_ORD_ID_".$_POST['OrdId']; 
	}


	//债权转让回调
	public function creditassign()
	{
		if(strcmp($_POST['RespCode'],"000")==0)
		{
			$usrid = $_POST['BuyCustId'];
			$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		
			$data=array();
			$data['uid'] = $info['uid'];//用户UID
			$data['username'] = $info['username'];//用户名
			$data['rescode'] = $_POST['RespCode'];//返回码
			$data['cmdid'] = $_POST['CmdId'];//消息类型
			$data['usrid'] = $_POST['BuyCustId'];//用户客户号
			$data['ordid'] = $_POST['OrdId'];//订单号
			$data['orddate'] = $_POST['OrdDate'];//订单日期
			$data['trxid'] = "";
			$data['merpriv'] = $_POST['MerPriv'];
			$data['addtime'] = time();//记录时间
		
			$condition['uid'] = $data['uid'];
			$condition['ordid'] = $data['ordid'];
			$num = M("huifulog")->where($condition)->count();
			if($num==0)
			{
				M("huifulog")->add($data);
				
				$temp = base64_decode($data['merpriv']);
				$pos1 = strpos($temp,'{');
				$pos2 = strpos($temp,'}');
				$len = $pos2-$pos1+1;
				$merpriv = substr($temp,$pos1,$len);
				$merpriv = json_decode($merpriv,true);
				
				$investid = $merpriv['investid'];//投资ID
				
				D("DebtBehavior");
				$Debt = new DebtBehavior($data['uid']);
				$Debt->buy($investid);



				$assign['investor'] = $data['uid'];
				$assign['ordid'] = $data['ordid'];
				$assign['orddate'] = $data['orddate'];
				M("borrow_investor")->where("id=".$investid)->save($assign);

			}
			header("Content-type: text/html; charset=utf-8");
			redirect('/member', 3, '债权转让成功，页面跳转中...');
		}
		else
		{
			header("Content-type: text/html; charset=utf-8");
			echo urldecode($_POST['RespDesc']);
		}
	}
	
	//债权转让后台回调
	public function creditassignret()
	{
		$usrid = $_POST['BuyCustId'];
		$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		
		$data=array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['BuyCustId'];//用户客户号
		$data['ordid'] = $_POST['OrdId'];//订单号
		$data['orddate'] = $_POST['OrdDate'];//订单日期
		$data['trxid'] = "";
		$data['merpriv'] = $_POST['MerPriv'];
		$data['addtime'] = time();//记录时间
		
		sleep(1);//防止与前台回调同步到达
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		$num = M("huifulog")->where($condition)->count();
		if($num==0)
		{
			M("huifulog")->add($data);
			
			if(strcmp($_POST['RespCode'],"000")==0)
			{
				$temp = base64_decode($data['merpriv']);
				$pos1 = strpos($temp,'{');
				$pos2 = strpos($temp,'}');
				$len = $pos2-$pos1+1;
				$merpriv = substr($temp,$pos1,$len);
				$merpriv = json_decode($merpriv,true);
				
				$investid = $merpriv['investid'];//投资ID
				
				D("DebtBehavior");
				$Debt = new DebtBehavior($data['uid']);
				$Debt->buy($investid);
				
				$assign['investor'] = $data['uid'];
				$assign['ordid'] = $data['ordid'];
				$assign['orddate'] = $data['orddate'];
				M("borrow_investor")->where("id=".$investid)->save($assign);
			}
		}
		echo "RECV_ORD_ID_".$_POST['OrdId'];
	}
	
	//自动投标计划
	public function tenderplan()
	{
		if(strcmp($_POST['RespCode'],"000")==0)
		{
			$usrid = $_POST['UsrCustId'];
			$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		
			$data=array();
			$data['uid'] = $info['uid'];//用户UID
			$data['username'] = $info['username'];//用户名
			$data['rescode'] = $_POST['RespCode'];//返回码
			$data['cmdid'] = $_POST['CmdId'];//消息类型
			$data['usrid'] = $_POST['UsrCustId'];//用户客户号
			$data['ordid'] = "";
			$data['orddate'] = "";
			$data['trxid'] = "";
			$data['addtime'] = time();//记录时间
			
			M("huifulog")->add($data);
			
			$set['invest_money'] = str2val_money($_POST['TransAmt']);
			
			$info1['uid'] = $data['uid'];
			$info1['add_ip'] = get_client_ip();
			$info1['add_time'] = time();
			$info1['invest_money'] = $set['invest_money'];
			$info1['is_use'] = 1;
			$info1['borrow_type'] = 1;
			$c = M('auto_borrow')->field('id')->where("uid=".$data['uid'])->select();

			if(is_array($c))
			{

				M('auto_borrow')->where("uid = ".$data['uid'])->save($info1);
			}
			else
			{	$info1['invest_time'] = time();
				M('auto_borrow')->add($info1);			
			}
			header("Content-type: text/html; charset=utf-8");
			redirect('/member', 3, '设置成功，页面跳转中...');
		}
		else
		{
			header("Content-type: text/html; charset=utf-8");
			echo urldecode($_POST['RespDesc']);
		}
	}
	
	//自动投标回调
	public function autotender()
	{
		echo "<pre>";print_r($_POST);echo "</pre>";exit;
	}
	
	//自动投标后台回调
	public function autotenderret()
	{
		$usrid = $_POST['UsrCustId'];
		$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		
		$data=array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['UsrCustId'];//用户客户号
		$data['ordid'] = $_POST['OrdId'];//订单号
		$data['orddate'] = $_POST['OrdDate'];//订单日期
		$data['trxid'] = $_POST['TrxId'];//交易流水号
		$data['merpriv'] = $_POST['MerPriv'];
		$data['addtime'] = time();//记录时间
		
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		$num = M("huifulog")->where($condition)->count();
		if($num==0)
		{
			M("huifulog")->add($data);
			
			if(strcmp($_POST['RespCode'],"000")==0)
			{
				$temp = base64_decode($data['merpriv']);
				$pos1 = strpos($temp,'{');
				$pos2 = strpos($temp,'}');
				$len = $pos2-$pos1+1;
				$merpriv = substr($temp,$pos1,$len);
				$merpriv = json_decode($merpriv,true);

				$borrow_id = $merpriv['borrowid'];//标ID
				$money = str2val_money($_POST['TransAmt']);
			
				$info = array();
				$info['ordid'] = $data['ordid'];
				$info['orddate'] = $data['orddate'];
				$info['freezeordid'] = $_POST['FreezeOrdId'];
				$info['freezetrxid'] = $_POST['FreezeTrxId'];
				$invest_info_id = M('borrow_investor')->add($info);
				
				investMoney($data['uid'],$borrow_id,$money,1,$invest_info_id);
			}
		}
		echo "RECV_ORD_ID_".$_POST['OrdId'];
	}
	
	//自动投标关闭回调
	public function planclose()
	{
		if(strcmp($_POST['RespCode'],"000")==0)
		{
			$usrid = $_POST['UsrCustId'];
			$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		
			$data=array();
			$data['uid'] = $info['uid'];//用户UID
			$data['username'] = $info['username'];//用户名
			$data['rescode'] = $_POST['RespCode'];//返回码
			$data['cmdid'] = $_POST['CmdId'];//消息类型
			$data['usrid'] = $_POST['UsrCustId'];//用户客户号
			$data['ordid'] = "";
			$data['orddate'] = "";
			$data['trxid'] = "";
			$data['addtime'] = time();//记录时间
			
			M("huifulog")->add($data);
			
			$info1['is_use'] = 0;
			$c = M('auto_borrow')->field('id')->where("uid=".$data['uid'])->select();
			if(is_array($c))
			{
				$i = 0;
				foreach($c as $v)
				{
					if(0 == $i)
					{
						$info1['borrow_type'] = 1;
					}
					else if(1 == $i)
					{
						$info1['borrow_type'] = 3;
					}
					M('auto_borrow')->where("id=".$v['id'])->save($info1);
					$i++;
				}
			}
			else
			{
				$i = 0;
				foreach($c as $v)
				{
					if(0 == $i)
					{
						$info1['borrow_type'] = 1;
					}
					else if(1 == $i)
					{
						$info1['borrow_type'] = 3;
					}
					M('auto_borrow')->add($info1);
					$i++;
				}
			}
			header("Content-type: text/html; charset=utf-8");
			redirect('/member', 3, '设置成功，页面跳转中...');
		}
		else
		{
			header("Content-type: text/html; charset=utf-8");
			echo urldecode($_POST['RespDesc']);
		}
	}
	
	//用户账户支付回调
	public function usrpay()
	{
		
		$usrid = $_POST['UsrCustId'];
		$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		
		
		$data=array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['UsrCustId'];//用户客户号
		$data['ordid'] = $_POST['OrdId'];//订单号
		$data['orddate'] = '';
		$data['trxid'] = '';
		$data['merpriv'] = '';
		$data['addtime'] = time();//记录时间
		
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		$num = M("huifulog")->where($condition)->count();
		if($num==0)
		{
			M("huifulog")->add($data);
			
			if(strcmp($_POST['RespCode'],"000")==0)
			{
				$accountMoney_z = M('member_money')->field('money_freeze,money_collect,account_money,back_money')->find($data['uid']);
				$datamoney_z['uid'] = $data['uid'];
				$datamoney_z['type'] = 51;
				$datamoney_z['affect_money'] = -str2val_money($_POST['TransAmt']);//偿还金额
				$datamoney_z['collect_money'] = $accountMoney_z['money_collect'];
				$datamoney_z['freeze_money'] = $accountMoney_z['money_freeze'];
				
				if(($accountMoney_z['back_money'] + $datamoney_z['affect_money'])<0)
				{
					$datamoney_z['back_money'] =0;
					$datamoney_z['account_money'] = $accountMoney_z['account_money'] +$accountMoney_z['back_money']+ $datamoney_z['affect_money'];
				}
				else
				{
					$datamoney_z['account_money'] = $accountMoney_z['account_money'];
					$datamoney_z['back_money'] = $accountMoney_z['back_money'] + $datamoney_z['affect_money'];
				}
				
				//投资人帐户
				$mmoney_z['money_freeze']=$datamoney_z['freeze_money'];
				$mmoney_z['money_collect']=$datamoney_z['collect_money'];
				$mmoney_z['account_money']=$datamoney_z['account_money'];
				$mmoney_z['back_money']=$datamoney_z['back_money'];
				
				//投资人帐户
				$datamoney_z['info'] = "偿还网站代还金额".str2val_money($_POST['TransAmt'])."元";
				$datamoney_z['add_time'] = time();
				$datamoney_z['add_ip'] = get_client_ip();
				$datamoney_z['target_uid'] = 0;
				$datamoney_z['target_uname'] = '@网站管理员@';
				$moneynewid_z = M('member_moneylog')->add($datamoney_z);
				if($moneynewid_z)
				{
					M('member_money')->where("uid={$datamoney_z['uid']}")->save($mmoney_z);
				}
				
				header("Content-type: text/html; charset=utf-8");
				redirect('/member', 3, '转账成功，页面跳转中...');
			}
			else
			{
				header("Content-type: text/html; charset=utf-8");
				echo urldecode($_POST['RespDesc']);
			}
		}
		
	}
	
	//用户账户支付后台回调
	public function usrpayret()
	{		
		$usrid = $_POST['UsrCustId'];
		$info = M("members")->field("id,user_name")->where("usrid=".$usrid)->find();
		//$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		$data=array();
		$data['uid'] = $info['id'];//用户UID
		$data['username'] = $info['user_name'];//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['UsrCustId'];//用户客户号
		$data['ordid'] = $_POST['OrdId'];//订单号
		$data['orddate'] = '';
		$data['trxid'] = '';
		$data['merpriv'] = '';
		$data['addtime'] = time();//记录时间
		
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		$num = M("huifulog")->where($condition)->count();
		if($num==0)
		{
			M("huifulog")->add($data);
			if(strcmp($_POST['RespCode'],"000")==0)
			{
				$accountMoney_z = M('member_money')->field('money_freeze,money_collect,account_money,back_money')->find($data['uid']);
				$datamoney_z['uid'] = $data['uid'];
				$datamoney_z['type'] = 51;
				$datamoney_z['affect_money'] = -str2val_money($_POST['TransAmt']);//偿还金额
				$datamoney_z['collect_money'] = $accountMoney_z['money_collect'];
				$datamoney_z['freeze_money'] = $accountMoney_z['money_freeze'];
				
				if(($accountMoney_z['back_money'] + $datamoney_z['affect_money'])<0)
				{
					$datamoney_z['back_money'] =0;
					$datamoney_z['account_money'] = $accountMoney_z['account_money'] +$accountMoney_z['back_money']+ $datamoney_z['affect_money'];
				}
				else
				{
					$datamoney_z['account_money'] = $accountMoney_z['account_money'];
					$datamoney_z['back_money'] = $accountMoney_z['back_money'] + $datamoney_z['affect_money'];
				}
				
				//还款人帐户
				$mmoney_z['money_freeze']=$datamoney_z['freeze_money'];
				$mmoney_z['money_collect']=$datamoney_z['collect_money'];
				$mmoney_z['account_money']=$datamoney_z['account_money'];
				$mmoney_z['back_money']=$datamoney_z['back_money'];
				
				//还款人帐户
				$datamoney_z['info'] = "偿还网站代还金额".str2val_money($_POST['TransAmt'])."元";
				$datamoney_z['add_time'] = time();
				$datamoney_z['add_ip'] = get_client_ip();
				$datamoney_z['target_uid'] = 0;
				$datamoney_z['target_uname'] = '@网站管理员@';
				$moneynewid_z = M('member_moneylog')->add($datamoney_z);
				if($moneynewid_z)
				{
					M('member_money')->where("uid={$datamoney_z['uid']}")->save($mmoney_z);
				}
			}
		}
		echo "RECV_ORD_ID_".$_POST['OrdId'];
	}
	
	//前台用户间转账回调
	public function usrtransfer()
	{
		$usrid = $_POST['UsrCustId'];
		$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		
		$data=array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['UsrCustId'];//用户客户号
		$data['ordid'] = $_POST['OrdId'];//订单号
		$data['orddate'] = '';
		$data['trxid'] = '';
		$data['merpriv'] = '';
		$data['addtime'] = time();//记录时间
		
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		$num = M("huifulog")->where($condition)->count();
		if($num==0)
		{
			M("huifulog")->add($data);
			
			if(strcmp($_POST['RespCode'],"000")==0)
			{
				//还款人
				$out = M('members')->field("user_name")->where("id=".$data['uid'])->find();
				//收款人
				$in = M('members')->field("id,user_name")->where("usrid='".$_POST['InUsrCustId']."'")->find();
				
				//还款人帐户
				$accountMoney_z = M('member_money')->field('money_freeze,money_collect,account_money,back_money')->find($data['uid']);
				$datamoney_z['uid'] = $data['uid'];
				$datamoney_z['type'] = 51;
				$datamoney_z['affect_money'] = -str2val_money($_POST['TransAmt']);//偿还金额
				$datamoney_z['collect_money'] = $accountMoney_z['money_collect'];
				$datamoney_z['freeze_money'] = $accountMoney_z['money_freeze'];
				
				if(($accountMoney_z['back_money'] + $datamoney_z['affect_money'])<0)
				{
					$datamoney_z['back_money'] =0;
					$datamoney_z['account_money'] = $accountMoney_z['account_money'] +$accountMoney_z['back_money']+ $datamoney_z['affect_money'];
				}
				else
				{
					$datamoney_z['account_money'] = $accountMoney_z['account_money'];
					$datamoney_z['back_money'] = $accountMoney_z['back_money'] + $datamoney_z['affect_money'];
				}
				
				//还款人帐户
				$mmoney_z['money_freeze']=$datamoney_z['freeze_money'];
				$mmoney_z['money_collect']=$datamoney_z['collect_money'];
				$mmoney_z['account_money']=$datamoney_z['account_money'];
				$mmoney_z['back_money']=$datamoney_z['back_money'];
				
				//还款人帐户
				$datamoney_z['info'] = "偿还担保公司（帐号：".$in['user_name']."）代还金额".str2val_money($_POST['TransAmt'])."元";
				$datamoney_z['add_time'] = time();
				$datamoney_z['add_ip'] = get_client_ip();
				$datamoney_z['target_uid'] = $in['id'];
				$datamoney_z['target_uname'] = $in['user_name'];
				$moneynewid_z = M('member_moneylog')->add($datamoney_z);
				if($moneynewid_z)
				{
					M('member_money')->where("uid={$datamoney_z['uid']}")->save($mmoney_z);
				}
				
				//收款人帐户
				$accountMoney_y = M('member_money')->field('money_freeze,money_collect,account_money,back_money')->find($in['id']);
				$datamoney_y['uid'] = $in['id'];
				$datamoney_y['type'] = 52;
				$datamoney_y['affect_money'] = str2val_money($_POST['TransAmt']);//接收偿还金额
				$datamoney_y['collect_money'] = $accountMoney_y['money_collect'];
				$datamoney_y['freeze_money'] = $accountMoney_y['money_freeze'];
				$datamoney_y['account_money'] = $accountMoney_y['account_money'];//充值账户不变
				$datamoney_y['back_money'] = $accountMoney_y['back_money'] + $datamoney_y['affect_money'];//回款账户增加
				
				//收款人帐户
				$mmoney_y['money_freeze']=$datamoney_y['freeze_money'];
				$mmoney_y['money_collect']=$datamoney_y['collect_money'];
				$mmoney_y['account_money']=$datamoney_y['account_money'];
				$mmoney_y['back_money']=$datamoney_y['back_money'];
				
				//收款人帐户
				$datamoney_y['info'] = "接收偿还金额".str2val_money($_POST['TransAmt'])."元（还款人帐号：".$out['user_name']."）";
				$datamoney_y['add_time'] = time();
				$datamoney_y['add_ip'] = get_client_ip();
				$datamoney_y['target_uid'] = $data['uid'];
				$datamoney_y['target_uname'] = $out['user_name'];
				$moneynewid_y = M('member_moneylog')->add($datamoney_y);
				if($moneynewid_y)
				{
					M('member_money')->where("uid={$datamoney_y['uid']}")->save($mmoney_y);
				}
				
				header("Content-type: text/html; charset=utf-8");
				redirect('/member', 3, '转账成功，页面跳转中...');
			}
			else
			{
				header("Content-type: text/html; charset=utf-8");
				echo urldecode($_POST['RespDesc']);
			}
		}
	}
	
	//前台用户间转账后台回调
	public function usrtransferret()
	{
		$usrid = $_POST['UsrCustId'];
		$info = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		
		$data=array();
		$data['uid'] = $info['uid'];//用户UID
		$data['username'] = $info['username'];//用户名
		$data['rescode'] = $_POST['RespCode'];//返回码
		$data['cmdid'] = $_POST['CmdId'];//消息类型
		$data['usrid'] = $_POST['UsrCustId'];//用户客户号
		$data['ordid'] = $_POST['OrdId'];//订单号
		$data['orddate'] = '';
		$data['trxid'] = '';
		$data['merpriv'] = '';
		$data['addtime'] = time();//记录时间
		
		$condition['uid'] = $data['uid'];
		$condition['ordid'] = $data['ordid'];
		$num = M("huifulog")->where($condition)->count();
		if($num==0)
		{
			M("huifulog")->add($data);
			
			if(strcmp($_POST['RespCode'],"000")==0)
			{
				//还款人
				$out = M('members')->field("user_name")->where("id=".$data['uid'])->find();
				//收款人
				$in = M('members')->field("id,user_name")->where("usrid='".$_POST['InUsrCustId']."'")->find();
				
				//还款人帐户
				$accountMoney_z = M('member_money')->field('money_freeze,money_collect,account_money,back_money')->find($data['uid']);
				$datamoney_z['uid'] = $data['uid'];
				$datamoney_z['type'] = 51;
				$datamoney_z['affect_money'] = -str2val_money($_POST['TransAmt']);//偿还金额
				$datamoney_z['collect_money'] = $accountMoney_z['money_collect'];
				$datamoney_z['freeze_money'] = $accountMoney_z['money_freeze'];
				
				if(($accountMoney_z['back_money'] + $datamoney_z['affect_money'])<0)
				{
					$datamoney_z['back_money'] =0;
					$datamoney_z['account_money'] = $accountMoney_z['account_money'] +$accountMoney_z['back_money']+ $datamoney_z['affect_money'];
				}
				else
				{
					$datamoney_z['account_money'] = $accountMoney_z['account_money'];
					$datamoney_z['back_money'] = $accountMoney_z['back_money'] + $datamoney_z['affect_money'];
				}
				
				//还款人帐户
				$mmoney_z['money_freeze']=$datamoney_z['freeze_money'];
				$mmoney_z['money_collect']=$datamoney_z['collect_money'];
				$mmoney_z['account_money']=$datamoney_z['account_money'];
				$mmoney_z['back_money']=$datamoney_z['back_money'];
				
				//还款人帐户
				$datamoney_z['info'] = "偿还担保公司（帐号：".$in['user_name']."）代还金额".str2val_money($_POST['TransAmt'])."元";
				$datamoney_z['add_time'] = time();
				$datamoney_z['add_ip'] = get_client_ip();
				$datamoney_z['target_uid'] = $in['id'];
				$datamoney_z['target_uname'] = $in['user_name'];
				$moneynewid_z = M('member_moneylog')->add($datamoney_z);
				if($moneynewid_z)
				{
					M('member_money')->where("uid={$datamoney_z['uid']}")->save($mmoney_z);
				}
				
				//收款人帐户
				$accountMoney_y = M('member_money')->field('money_freeze,money_collect,account_money,back_money')->find($in['id']);
				$datamoney_y['uid'] = $in['id'];
				$datamoney_y['type'] = 52;
				$datamoney_y['affect_money'] = str2val_money($_POST['TransAmt']);//接收偿还金额
				$datamoney_y['collect_money'] = $accountMoney_y['money_collect'];
				$datamoney_y['freeze_money'] = $accountMoney_y['money_freeze'];
				$datamoney_y['account_money'] = $accountMoney_y['account_money'];//充值账户不变
				$datamoney_y['back_money'] = $accountMoney_y['back_money'] + $datamoney_y['affect_money'];//回款账户增加
				
				//收款人帐户
				$mmoney_y['money_freeze']=$datamoney_y['freeze_money'];
				$mmoney_y['money_collect']=$datamoney_y['collect_money'];
				$mmoney_y['account_money']=$datamoney_y['account_money'];
				$mmoney_y['back_money']=$datamoney_y['back_money'];
				
				//收款人帐户
				$datamoney_y['info'] = "接收偿还金额".str2val_money($_POST['TransAmt'])."元（还款人帐号：".$out['user_name']."）";
				$datamoney_y['add_time'] = time();
				$datamoney_y['add_ip'] = get_client_ip();
				$datamoney_y['target_uid'] = $data['uid'];
				$datamoney_y['target_uname'] = $out['user_name'];
				$moneynewid_y = M('member_moneylog')->add($datamoney_y);
				if($moneynewid_y)
				{
					M('member_money')->where("uid={$datamoney_y['uid']}")->save($mmoney_y);
				}
			}
		}
		echo "RECV_ORD_ID_".$_POST['OrdId'];
	}
	
}
