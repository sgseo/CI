<?php
// 本类由系统自动生成，仅供测试用途
class BorrowdetailAction extends MCommonAction {

    public function index(){
		$this->assign("bid",intval($_GET['id']));
		$this->display();
    }

    public function borrowdetail(){
		$pre = C('DB_PREFIX');
		$borrow_id = intval($_GET['id']);
		$list = getBorrowInvest($borrow_id,$this->uid);
		$membertype = member_type($this->uid);
		if($membertype['status']==1)
		{
			$isdanbao = 1;
		}
		
		$this->assign("isdanbao",$isdanbao);
		$this->assign("list",$list);
		$data['html'] = $this->fetch();
		exit(json_encode($data));
    }

    public function repayment(){
		$pre = C('DB_PREFIX');
		$borrow_id = intval($_POST['bid']);
		$sort_order = intval($_POST['sort_order']);
		
		//$vo = M("borrow_info")->field('id')->where("id={$borrow_id} AND borrow_uid={$this->uid}")->find();
		//if(!is_array($vo)) ajaxmsg("数据有误",0);
		$vo = M("borrow_info")->field('borrow_uid,danbao')->where("id={$borrow_id}")->find();
		if(($vo['borrow_uid']==$this->uid) && ($vo['danbao']==$this->uid))
		{
			ajaxmsg("担保公司不能为借款人",0);
		}
		else if($vo['borrow_uid']==$this->uid)
		{
			$type = 1;
		}
		else if($vo['danbao']==$this->uid)
		{
			$type = 3;
		}
		else
		{
			ajaxmsg("数据有误",0);
		}
		$res = borrowRepayment($borrow_id,$sort_order,$type);
		//$this->display("Public:_footer");
		if(true===$res) ajaxmsg();
		elseif(!empty($res)) ajaxmsg($res,0);
		else ajaxmsg("还款失败，请重试或联系客服",0);
    }
	
	public function unfreeze()
	{
		$borrowid = intval($_POST['bid']);
		$sort_order = intval($_POST['sort_order']);
		
		$borrowtrxid = M("borrow_info")->field("freezetrxid")->where("id=".$borrowid)->find();
		$freezetrxid = $borrowtrxid['freezetrxid'];
		$type = 2;
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$huifu->usrUnFreeze($freezetrxid,$borrowid,$sort_order,$type);
	}

}