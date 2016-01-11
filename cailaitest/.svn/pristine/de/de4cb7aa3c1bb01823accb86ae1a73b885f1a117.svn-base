<?php

class TransferAction extends MCommonAction {

    public function index()
	{
		$this->display();
    }
	
	public function mer()
	{
		$vo = M('member_money')->field('(account_money+back_money) all_money')->where("uid=".$this->uid)->find();
		
		$this->assign("vo",$vo);
		$data['html'] = $this->fetch();
		exit(json_encode($data));
	}
	
	public function domer()
	{
		$usr = M("members")->field("usrid")->where("id=$this->uid")->find();
		$usrid = $usr['usrid'];
		$transamt = $_POST['money'];
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$res = $huifu->usrAcctPay($usrid,$transamt);
	}
	
	public function guar()
	{
		$vo = M('member_money')->field('(account_money+back_money) all_money')->where("uid=".$this->uid)->find();
		
		$this->assign("vo",$vo);
		$data['html'] = $this->fetch();
		exit(json_encode($data));
	}
	
	public function doguar()
	{
		$usr = M("members")->field("usrid")->where("id=$this->uid")->find();
		$usrid = $usr['usrid'];
		
		$receive_account = $_POST['receive_account'];
		$incust = M("members")->field("usrid")->where("user_name='".$receive_account."'")->find();
		$incustid = $incust['usrid'];
		
		$transamt = $_POST['money'];
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$res = $huifu->usrTransfer($usrid,$incustid,$transamt);
	}

}