<?php
// 本类由系统自动生成，仅供测试用途
class BankAction extends MCommonAction {

    public function index(){
		$this->display();
    }

    public function bank(){
		$ids = M('members_status')->getFieldByUid($this->uid,'id_status');
		if($ids==1){
			$voinfo = M("member_info")->field('idcard,real_name')->find($this->uid);
			$vobank = M("member_banks")->field(true)->where("uid = {$this->uid} and bank_num !=''")->find();
			$vobank['bank_province'] = M('bankarea')->getFieldByName("{$vobank['bank_province']}",'id');
			$vobank['bank_city'] = M('bankarea')->getFieldByName("{$vobank['bank_city']}",'id');

			$this->assign("voinfo",$voinfo);
			$this->assign("vobank",$vobank);
			$this->assign("bank_list",$this->gloconf['BANK_NAME']);
			$this->assign('edit_bank', $this->glo['edit_bank']);
			$data['html'] = $this->fetch();
		}
		else  $data['html'] = '<script type="text/javascript">alert("您还未完成身份验证，请先进行实名认证");window.location.href="'.__APP__.'/member/verify?id=1#fragment-3";</script>';

		exit(json_encode($data));
    }
	public function bindbank()
	{
		$info = M("members")->field("usrid")->where("id=".$this->uid)->find();
		$usrid = $info['usrid'];
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$info = $huifu->userBindCard($usrid);
		exit;

	    $bank_info = M('member_banks')->field("uid, bank_num")->where("uid=".$this->uid)->find();
	
		!$bank_info['uid'] && $data['uid'] = $this->uid;
		$data['bank_num'] = text($_POST['account']);
		$data['bank_name'] = text($_POST['bank_name']);
		$data['bank_address'] = text($_POST['bankaddress']);
		$data['bank_province'] = text($_POST['province_name']);
		$data['bank_city'] = text($_POST['city_name']);
		$data['add_ip'] = get_client_ip();
		$data['add_time'] = time();
		if($bank_info['uid']){
			/////////////////////新增银行卡修改锁定开关 开始 20130510 fans///////////////////////////
			if(intval($this->glo['edit_bank'])!= 1 && $bank_info['bank_num']){
				ajaxmsg("为了您的帐户资金安全，银行卡已锁定，如需修改，请联系客服", 0 );
			}
			/////////////////////新增银行卡修改锁定开关 结束 20130510 fans///////////////////////////
			$old = text($_POST['oldaccount']);
			if($bank_info['bank_num'] && $old <> $bank_info['bank_num']) ajaxmsg('原银卡号不对',0);
			$newid = M('member_banks')->where("uid=".$this->uid)->save($data);
		}else{
			$newid = M('member_banks')->add($data);
			
			$info = M("huifulog")->field("usrid")->where("uid=".$this->uid)->find();
			$usrid = $info['usrid'];
			$bankaccount = text($_POST['account']);
			$bankcode = text($_POST['bank_code']);
			$prov_code = text($_POST['province_code']);
			$prov = M("bankarea")->field("code")->where("id=".$prov_code)->find();
			$bankprov = $prov['code'];
			$city_code = text($_POST['city_code']);
			$city = M("bankarea")->field("code")->where("id=".$city_code)->find();
			$bankarea = $city['code'];
			//$isdefault = $_POST['isdefault']?'Y':'N';
			import("ORG.Huifu.Huifu");
			$huifu = new Huifu();
			$info = $huifu->BgBindCard($usrid,$bankaccount,$bankcode,$bankprov,$bankarea,$isdefault);
			
			$usrid = $info['UsrCustId'];
			$username = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
			$data=array();
			$data['uid'] = $username['uid'];
			$data['username'] = $username['username'];
			$data['rescode'] = $info['RespCode'];
			$data['cmdid'] = $info['CmdId'];
			$data['usrid'] = $info['UsrCustId'];
			$data['trxid'] = "";//没有交易流水号
			$data['addtime'] = time();
			
			//file_put_contents("C:/c.txt",json_encode($info));
			M("huifulog")->add($data);
		}
		if($newid){
			MTip('chk2',$this->uid);
			ajaxmsg();
		}
		else ajaxmsg('操作失败，请重试',0);
	}
	
	public function delcard()
	{
		$info = M("members")->field("usrid")->where("id=".$this->uid)->find();
		$usrid = $info['usrid'];
		$bankinfo = M('member_banks')->field("bank_num")->where("uid=".$this->uid)->find();
		$bankaccount = $bankinfo['bank_num'];
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$info = $huifu->delCard($usrid,$bankaccount);
		
		$usrid = $info['UsrCustId'];
		$username = M("huifulog")->distinct(true)->field("uid,username")->where("usrid=".$usrid)->find();
		$data=array();
		$data['uid'] = $username['uid'];
		$data['username'] = $username['username'];
		$data['rescode'] = $info['RespCode'];
		$data['cmdid'] = $info['CmdId'];
		$data['usrid'] = $info['UsrCustId'];
		$data['trxid'] = "";//没有交易流水号
		$data['addtime'] = time();
		M("huifulog")->add($data);
		
		if(strcmp($_POST['RespCode'],"000")==0)
		{
			$bank['bank_num'] = '';
			M('member_banks')->where("uid=".$this->uid)->save($bank);
		}
	}
	
	
	public function getarea(){
		$rid = intval($_GET['rid']);
		if(empty($rid)) return;
		$map['reid'] = $rid;
		$alist = M('area')->field('id,name')->order('sort_order DESC')->where($map)->select();
		if(count($alist)===0){
			$str="<option value=''>--该地区下无下级地区--</option>\r\n";
		}else{
			foreach($alist as $v){
				$str.="<option value='{$v['id']}'>{$v['name']}</option>\r\n";
			}
		}
		$data['option'] = $str;
		$res = json_encode($data);
		echo $res;
	}
	
	//获取银行区划代码，针对托管账号
	public function getbankarea(){
		$rid = intval($_GET['rid']);
		if(empty($rid)&&$rid!=0) return;
		$map['pid'] = $rid;
		$alist = M('bankarea')->field('id,name')->where($map)->select();
		
		if(count($alist)===0){
			$str="<option value=''>--该地区下无下级地区--</option>\r\n";
		}else{
			foreach($alist as $v){
				$str.="<option value='{$v['id']}'>{$v['name']}</option>\r\n";
			}
		}
		$data['option'] = $str;
		$res = json_encode($data);
		echo $res;
	}	

}