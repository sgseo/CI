<?php
// 本类由系统自动生成，仅供测试用途
class TendoutAction extends MCommonAction {

    public function index(){
		//print_r($this);
		$this->display();
    }
	 public function tindex(){
		$this->display();
    }
    public function summary(){
		$uid = $this->uid;
		$pre = C('DB_PREFIX');
		
		$this->assign("dc",M('investor_detail')->where("investor_uid = {$this->uid}")->sum('substitute_money'));
		$this->assign("mx",getMemberBorrowScan($this->uid));
		$data['html'] = $this->fetch();
		exit(json_encode($data));
    }
	
	public function tending(){
		//$map['i.investor_uid'] = $this->uid;
//		$map['i.status'] = 1;
		$map['investor_uid'] = $this->uid;
		$map['status'] = 1;
		$map['Borrow.borrow_type'] = array('neq',9);

		
		$list = getTenderList($map,15);
		//-----------------------------add by whh 2015-03-19---start------------------
		//显示真实姓名
		if(is_array($list['list'])){
			foreach($list['list'] as $key => $val){
				$borrow_uid = $val['borrow_uid'];
				$map = " uid = $borrow_uid "; 
				$real_name = M("member_info")->field('real_name')->where($map)->limit(1)->select();
				$list['list'][$key]['real_name'] = $real_name[0]['real_name'];
				unset($real_name);
			}
		}
		//-------------------------------------end------------------------
		
		$this->assign("list",$list['list']);
		$this->assign("pagebar",$list['page']);
		$this->assign("total",$list['total_money']);
		$this->assign("num",$list['total_num']);
		$data['html'] = $this->fetch();
		exit(json_encode($data));
	}

	public function tendbacking(){
		$map['investor_uid'] = $this->uid;
		$map['status'] = 4;
		$map['Borrow.borrow_type'] = array('neq',9);
        
		$list = getTenderList($map,15);

		//-----------------------------add by whh 2015-03-19---start------------------
		//显示真实姓名
		if(is_array($list['list'])){
			foreach($list['list'] as $key => $val){
				$borrow_uid = $val['borrow_uid'];
				$map = " uid = $borrow_uid "; 
				$real_name = M("member_info")->field('real_name')->where($map)->limit(1)->select();
				$list['list'][$key]['real_name'] = $real_name[0]['real_name'];
				unset($real_name);
			}
		}
		//-------------------------------------end------------------------

	   //$list = $this->getTendBacking();
		$this->assign("list",$list['list']);
		$this->assign("pagebar",$list['page']);
		$this->assign("total",$list['total_money']);
		$this->assign("num",$list['total_num']);
		//$this->display("Public:_footer");

        $this->assign('uid', $this->uid);
		$data['html'] = $this->fetch();
		$data['uid'] = $this;

		exit(json_encode($data));
	}

    public function getTendBacking()
    {
        import("ORG.Util.Page"); 
       $map = "(investor_uid={$this->uid} or debt_uid={$this->uid}) and status=4"; 
       $count = M("borrow_investor")->where($map)->count("id");
       $Page = new Page($count, 14);
       $list['list'] = M("borrow_investor i")
            ->join(C('DB_PREFIX')."borrow_info b ON i.borrow_id=b.id")
            ->join(C('DB_PREFIX')."members m ON i.investor_uid=m.id")
            ->join(C('DB_PREFIX')."invest_detb d ON i.id=d.invest_id")
            ->field("i.borrow_id, b.borrow_name, m.user_name as borrow_user, 
                     i.investor_capital, b.borrow_interest_rate, i.receive_interest, i.receive_capital,
                     b.total, b.has_pay, i.id, d.period, d.status, i.debt_uid")
            ->where("(i.investor_uid={$this->uid} or i.debt_uid={$this->uid}) and i.status=4")
            ->limit($Page->firstRow.','.$Page->listRows)
            ->select();
       $list['page']=$Page->show();
       return $list;
    }

	public function tenddone(){
		//$map['i.investor_uid'] = $this->uid;
//		$map['i.status'] = array("in","5,6");
		$map['investor_uid'] = $this->uid;
		$map['status'] = array("in","5,6");
		$map['Borrow.borrow_type'] = array('neq',9);

		$list = getTenderList($map,15);

		//-----------------------------add by whh 2015-03-19---start------------------
		//显示真实姓名
		if(is_array($list['list'])){
			foreach($list['list'] as $key => $val){
				$borrow_uid = $val['borrow_uid'];
				$map = " uid = $borrow_uid "; 
				$real_name = M("member_info")->field('real_name')->where($map)->limit(1)->select();
				$list['list'][$key]['real_name'] = $real_name[0]['real_name'];
				unset($real_name);
			}
		}
		//-------------------------------------end------------------------

		$this->assign("list",$list['list']);
		$this->assign("pagebar",$list['page']);
		$this->assign("total",$list['total_money']);
		$this->assign("num",$list['total_num']);
		//$this->display("Public:_footer");

		$data['html'] = $this->fetch();
		exit(json_encode($data));
	}

	public function tendbreak(){
		$map['d.status'] = array('neq',0);
		$map['d.repayment_time'] = array('eq',"0");
		$map['d.deadline'] = array('lt',time());
		$map['d.investor_uid'] = $this->uid;
		$map['Borrow.borrow_type'] = array('neq',9);
		
		$list = getMBreakInvestList($map,15);
		//-----------------------------add by whh 2015-03-19---start------------------
		//显示真实姓名
		if(is_array($list['list'])){
			foreach($list['list'] as $key => $val){
				$borrow_uid = $val['borrow_uid'];
				$map = " uid = $borrow_uid "; 
				$real_name = M("member_info")->field('real_name')->where($map)->limit(1)->select();
				$list['list'][$key]['real_name'] = $real_name[0]['real_name'];
				unset($real_name);
			}
		}
		//-------------------------------------end------------------------

		$this->assign("list",$list['list']);
		$this->assign("pagebar",$list['page']);
		$this->assign("total",$list['total_money']);
		$this->assign("num",$list['total_num']);
		//$this->display("Public:_footer");
	
		$data['html'] = $this->fetch();
		exit(json_encode($data));
	}

    public function tendoutdetail(){
		$pre = C('DB_PREFIX');
		$status_arr =array('还未还','已还完','已提前还款','迟还','网站代还本金','逾期还款','','等待还款');
		$investor_id = intval($_GET['id']);
		$vo = M("borrow_investor i")->field("b.borrow_name")->join("{$pre}borrow_info b ON b.id=i.borrow_id")->where("i.investor_uid={$this->uid} AND i.id={$investor_id}")->find();
		if(!is_array($vo)) $this->error("数据有误");
		$map['invest_id'] = $investor_id;
		$list = M('investor_detail')->field(true)->where($map)->select();
                  file_put_contents('/tmp/tend2',date('m-d H:i:s')." back : ".print_r( M('investor_detail')->getLastSql(),true)."\n",FILE_APPEND);
		$this->assign("status_arr",$status_arr);
		$this->assign("list",$list);
		$this->assign("name",$vo['borrow_name'].$investor_id);
		$this->display();
    }

    //新手标展示页面
    public function newbietender(){
		$invest_uid = $this->uid;//登陆者id 也为投资新手标的id
		//
		$newlist=M('newbie_record')->field("invest_money,interest")->where('invest_uid='.$invest_uid)->find();
		$borrow_uid=M("newbie_bid")->field("borrow_uid,rate,bidtime")->where('id=1')->find();
		//$real_name=M("member_info")->field("real_name")->where('uid='.$borrow_uid['borrow_uid'])->find();
		$this->newlist=$newlist;
		$this->borrow_uid=$borrow_uid;
		//$this->real_name=$real_name;
		$data['html'] = $this->fetch();
		exit(json_encode($data));
	}



}