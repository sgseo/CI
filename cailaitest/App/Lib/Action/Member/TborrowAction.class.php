<?php
class TborrowAction extends MCommonAction
{
	public function index()
	{
		$this->display( );
	}

    public function summary(){
        $uid = $this->uid;
        $pre = C('DB_PREFIX');
        //$this->assign("dc",M('investor_detail')->where("investor_uid = {$this->uid}")->sum('substitute_money'));
        $this->assign("mx",getMemberBorrowScan($this->uid));
        $data['html'] = $this->fetch();
        exit(json_encode($data));
    }
	public function tendbacking()
	{
		$map = array();
		$map['investor_uid'] = $this->uid;
		$map['status'] = 4;
		$map['borrow_type'] = 9;
        
        
		$list = getTenderList($map,15);
        //$list = $this->getTendBacking();
		$this->assign("list",$list['list']);
		$this->assign("pagebar",$list['page']);
		$this->assign("total",$list['total_money']);
		$this->assign("num",$list['total_num']);
		//$this->display("Public:_footer");

        $this->assign('uid', $this->uid);
		$data['html'] = $this->fetch();
		exit(json_encode($data));
	}

	public function tenddone()
	{
		//$map['i.investor_uid'] = $this->uid;
//		$map['i.status'] = array("in","5,6");
		$map['investor_uid'] = $this->uid;
		$map['status'] = array("in","5,6");
		$map['borrow_type'] = 9;

		$list = getTenderList($map,15);
		//dump($list);die;
		$this->assign("list",$list['list']);
		$this->assign("pagebar",$list['page']);
		$this->assign("total",$list['total_money']);
		$this->assign("num",$list['total_num']);
		//$this->display("Public:_footer");

		$data['html'] = $this->fetch();
		exit(json_encode($data));
	}

	public function tenddetail()
	{
		$map['d.investor_uid'] = $this->uid;
		$map['d.status'] = 7;
		$list = gettdtenderlist($map,15);
		$this->assign("list", $list['list']);
		$this->assign("pagebar", $list['page']);
		$this->assign("total", $list['total_money']);
		$this->assign("num", $list['total_num']);
		$data['html'] = $this->fetch();
		exit(json_encode($data));
	}

	public function tenddetaildo()
	{
		//$map['d.investor_uid'] = $this->uid;
		//$map['d.status'] = 1;
		//$list = gettdtenderlist( $map,15);
		//$this->assign( "list", $list['list']);
		//$this->assign( "pagebar", $list['page']);
		//$this->assign( "total", $list['total_money']);
		//$this->assign( "num", $list['total_num']);
		//$this->display();
		
		$pre = C('DB_PREFIX');
		$status_arr =array('还未还','已还完','已提前还款','迟还','网站代还本金','逾期还款','','等待还款');
		$investor_id = intval($_GET['id']);
		$vo = M("borrow_investor i")->field("b.borrow_name")->join("{$pre}borrow_info b ON b.id=i.borrow_id")->where("i.investor_uid={$this->uid} AND i.id={$investor_id}")->find();
		if(!is_array($vo)) $this->error("数据有误");
		$map['invest_id'] = $investor_id;
		$list = M('investor_detail')->field(true)->where($map)->select();
		$this->assign("status_arr",$status_arr);
		$this->assign("list",$list);
		$this->assign("name",$vo['borrow_name'].$investor_id);
		$this->display();
		
		//$data['html'] = $this->fetch();//echo $data['html'];exit;
		//exit(json_encode($data));
	}

}

?>
