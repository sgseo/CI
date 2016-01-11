<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends HCommonAction {

	public function usrpay()
	{
		$usrid = "6000060000435300";
		$transamt = 100;
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$res = $huifu->usrAcctPay($usrid,$transamt);
	}
	
	public function usrtransfer()
	{
		$usrid = "6000060000435300";
		$incustid = "6000060000443612";
		$transamt = 100;
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$res = $huifu->usrTransfer($usrid,$incustid,$transamt);
	}
	
	public function queryaccts()
	{
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$res = $huifu->queryAccts();
		echo "<pre>";print_r($res);echo "</pre>";exit;
	}
	
	public function transstat()
	{
		$ordid = "201411141525192877";
		$orddate = "20141114";
		$querytype = "R";
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$res = $huifu->queryTransStat($ordid,$orddate,$querytype);
		echo "<pre>";print_r($res);echo "</pre>";exit;
	}
	
	public function trf()
	{
		$begindate = "20141113";
		$enddate = "20141113";
		$pagenum = 1;
		$pagesize = 20;
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$res = $huifu->trfReconciliation($begindate,$enddate,$pagenum,$pagesize);
		echo "<pre>";print_r($res);echo "</pre>";exit;
	}
	
	public function reconciliation()
	{
		$begindate = "20141113";
		$enddate = "20141114";
		$pagenum = 1;
		$pagesize = 20;
		$querytype = "REPAYMENT";
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$res = $huifu->reconciliation($begindate,$enddate,$pagenum,$pagesize,$querytype);
		echo "<pre>";print_r($res);echo "</pre>";exit;
	}
	
	public function cash()
	{
		$begindate = "20141113";
		$enddate = "20141114";
		$pagenum = 1;
		$pagesize = 20;
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$res = $huifu->cashReconciliation($begindate,$enddate,$pagenum,$pagesize);
		echo "<pre>";print_r($res);echo "</pre>";exit;
	}
	
	public function save()
	{
		$begindate = "20141113";
		$enddate = "20141114";
		$pagenum = 1;
		$pagesize = 20;
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$res = $huifu->saveReconciliation($begindate,$enddate,$pagenum,$pagesize);
		echo "<pre>";print_r($res);echo "</pre>";exit;
	}
	
	public function usrunfreeze()
	{
		$trxid = "201409290000201925";
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$huifu->usrUnFreeze($trxid);
	}
	
	public function duizhang()
	{
		$usrid = "6000060000699141";
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$res = $huifu->queryBalanceBg($usrid);
                echo "<pre>";print_r($res);echo "</pre>";
	}
	
    public function index()
	{
		$per = C('DB_PREFIX');
	    $Bconfig = require C("APP_ROOT")."Conf/borrow_config.php";
		
		//网站公告
		$parm['type_id'] = 9;
		$parm['limit'] =7;
		$this->assign("noticeList",getArticleList($parm));
		//网站公告
    
		/*
		//正在进行的贷款
		$searchMap = array();
		$searchMap['borrow_status']=array("in",'2,4,6,7');
		$searchMap['is_tuijian']=array("in",'0,1');
		$searchMap['deadline']=strtotime("deadline");
		$parm=array();
		$parm['map'] = $searchMap;
		$parm['limit'] = 1;
		$parm['orderby']="b.id DESC,b.borrow_status ASC";
		$listBorrow = getBorrowList($parm);
		$this->assign("listBorrow",$listBorrow);
		
		
		
		//散标开始
		
		$Bconfig = require C("APP_ROOT")."Conf/borrow_config.php";
		$per = C('DB_PREFIX');

		//预发标的借款
		$parm=array();
		$searchMap = array();
		$searchMap['borrow_status']=array("in",'9');
		$searchMap['b.borrow_status']=0;
		
		$parm['map'] = $searchMap;
		$parm['limit'] = 5;
		$parm['orderby']="b.id DESC";
		
		
		
		 $list = getBorrowList($parm);
		 //dump($list);die;
		  $this->assign("list",$list);
		///////////////债权转让开始  gwf 2014-10-21//////////////
	
		$map = array();
		$map['d.status']=array("in","2,4");
		$parm = array();
		$parm['map'] = $map;
		D("DebtBehavior");
		$Debt = new DebtBehavior();
		$lists = $Debt->listAll($parm ,3, true);
		$this->assign("lists", $lists);
		
		///////////////债权转让结束  gwf 2014-10-21//////////////
	
		///////////////企业直投推荐开始  gwf 2014-10-21//////////////
	
		$parm = array();
		$searchMap = array();
		$parm['limit'] =1;
		$parm['map'] = $searchMap;
		$parm['orderby'] = "bi.is_tuijian desc,bi.id desc";
		$listTBorrowa = getTBorrowList($parm);
		$this->assign("listTBorrowa",$listTBorrowa);
	 
		///////////////企业直投推荐开始  gwf 2014-10-21//////////////	 	
	*/
	
		//的借款
		
		//还款中的借款总额 @董强
		$map = array();
		$map['borrow_status'] = array("in","6,7");
		$Repayment = M("borrow_info")->field("SUM(borrow_money) as money")->where($map)->select();
		$this->assign("Repayment_money",$Repayment[0]['money']);
		//还款中的借款总额 END
		
		//正常还款完成利息总额 @董强
		$where = array();
		$where['status'] = array("in","5,6,7");
		$Repayment_lx = M("borrow_investor")->field("SUM(investor_interest) as investor_interest")->where($where)->select();
		$this->assign("investor_interest",$Repayment_lx[0]['investor_interest']);
		//正常还款完成利息总额 END//
		$parm=array();
		$searchMap = array();
		$searchMap['b.borrow_status'] = array('neq','3');
		$searchMap['b.borrow_type'] = array("neq","9");
		$parm['map'] = $searchMap;
		$parm['limit'] = 3;
		$parm['orderby']="b.id DESC";
		$list = getBorrowList($parm);
		//dump($list);die;
		$this->assign("list",$list);
		  
		///////////////企业直投列表开始  gwf 2014-10-21//////////////
		$parm = array();
		$searchMap = array();
		$searchMap['bi.borrow_status'] = array('neq','3');
		$searchMap['bi.borrow_type'] = array("eq","9");
		$parm['map'] = $searchMap;
		$parm['limit'] = 3;
		$parm['orderby'] = "bi.borrow_status ASC";
		$listTBorrow = getTBorrowList($parm);
	
		$this->assign("listTBorrow",$listTBorrow);
		///////////////企业直投列表结束  gwf 2014-10-21//////////////
    
		$this->display();
	

	
    /****************************募集期内标未满,自动流标 新增 2013-03-13****************************/
    //流标返回
    $mapT = array();
    $mapT['collect_time']=array("lt",time());
    $mapT['borrow_status'] = 2;
    $tlist = M("borrow_info")->field("id,borrow_uid,borrow_type,borrow_money,first_verify_time,borrow_interest_rate,borrow_duration,repayment_type,collect_day,collect_time")->where($mapT)->select();
    if(empty($tlist)) exit;
    foreach($tlist as $key=>$vbx){
    $borrow_id=$vbx['id'];
    //流标
    $done = false;
    $borrowInvestor = D('borrow_investor');
    $binfo = M("borrow_info")->field("borrow_type,borrow_money,borrow_uid,borrow_duration,repayment_type")->find($borrow_id);
    $investorList = $borrowInvestor->field('id,investor_uid,investor_capital')->where("borrow_id={$borrow_id}")->select();
    M('investor_detail')->where("borrow_id={$borrow_id}")->delete();
    if($binfo['borrow_type']==1) $limit_credit = memberLimitLog($binfo['borrow_uid'],12,($binfo['borrow_money']),$info="{$binfo['id']}号标流标");//返回额度
    $borrowInvestor->startTrans();
    
    $bstatus = 3;
    $upborrow_info = M('borrow_info')->where("id={$borrow_id}")->setField("borrow_status",$bstatus);
    //处理借款概要
    $buname = M('members')->getFieldById($binfo['borrow_uid'],'user_name');
    //处理借款概要
    if(is_array($investorList)){
    $upsummary_res = M('borrow_investor')->where("borrow_id={$borrow_id}")->setField("status",$type);
    foreach($investorList as $v){
    MTip('chk15',$v['investor_uid']);//sss
    $accountMoney_investor = M("member_money")->field(true)->find($v['investor_uid']);
    $datamoney_x['uid'] = $v['investor_uid'];
    $datamoney_x['type'] = ($type==3)?16:8;
    $datamoney_x['affect_money'] = $v['investor_capital'];
    $datamoney_x['account_money'] = ($accountMoney_investor['account_money'] + $datamoney_x['affect_money']);//投标不成功返回充值资金池
    $datamoney_x['collect_money'] = $accountMoney_investor['money_collect'];
    $datamoney_x['freeze_money'] = $accountMoney_investor['money_freeze'] - $datamoney_x['affect_money'];
    $datamoney_x['back_money'] = $accountMoney_investor['back_money'];
    
    //会员帐户
    $mmoney_x['money_freeze']=$datamoney_x['freeze_money'];
    $mmoney_x['money_collect']=$datamoney_x['collect_money'];
    $mmoney_x['account_money']=$datamoney_x['account_money'];
    $mmoney_x['back_money']=$datamoney_x['back_money'];
    
    //会员帐户
    $_xstr = ($type==3)?"复审未通过":"募集期内标未满,流标";
    $datamoney_x['info'] = "第{$borrow_id}号标".$_xstr."，返回冻结资金";
    $datamoney_x['add_time'] = time();
    $datamoney_x['add_ip'] = get_client_ip();
    $datamoney_x['target_uid'] = $binfo['borrow_uid'];
    $datamoney_x['target_uname'] = $buname;
    $moneynewid_x = M('member_moneylog')->add($datamoney_x);
    if($moneynewid_x) $bxid = M('member_money')->where("uid={$datamoney_x['uid']}")->save($mmoney_x);
    }
    }else{
    $moneynewid_x = true;
    $bxid=true;
    $upsummary_res=true;
    }
    
    if($moneynewid_x && $upsummary_res && $bxid && $upborrow_info){
    $done=true;
    $borrowInvestor->commit();
    }else{
    $borrowInvestor->rollback();
    }
    if(!$done) continue;
    
    
    MTip('chk11',$vbx['borrow_uid'],$borrow_id);
    $verify_info['borrow_id'] = $borrow_id;
    $verify_info['deal_info_2'] = text($_POST['deal_info_2']);
    $verify_info['deal_user_2'] = 0;
    $verify_info['deal_time_2'] = time();
    $verify_info['deal_status_2'] = 3;
    if($vbx['first_verify_time']>0) M('borrow_verify')->save($verify_info);
    else  M('borrow_verify')->add($verify_info);
    
    $vss = M("members")->field("user_phone,user_name")->where("id = {$vbx['borrow_uid']}")->find();
    SMStip("refuse",$vss['user_phone'],array("#USERANEM#","ID"),array($vss['user_name'],$verify_info['borrow_id']));
    //@SMStip("refuse",$vss['user_phone'],array("#USERANEM#","ID"),array($vss['user_name'],$verify_info['borrow_id']));
    //updateBinfo
    $newBinfo=array();
    $newBinfo['id'] = $borrow_id;
    $newBinfo['borrow_status'] = 3;
    $newBinfo['second_verify_time'] = time();
    $x = M("borrow_info")->save($newBinfo);
    }
    /****************************募集期内标未满,自动流标 新增 2013-03-13****************************/
	
    
    }
	/**
        * 购买债权提示框
        * 
        */
        public function buydebt()
        {
			if(!$this->uid)  ajaxmsg("请先登陆",0);
            $invest_id = intval($_REQUEST['invest_id']);
            !$invest_id && ajaxmsg(L('参数错误'),0);
            $debt = M("invest_detb")->field("transfer_price, money")->where("invest_id={$invest_id}")->find();
            $buy_user = M("member_money")->field("account_money, back_money")->where("uid={$this->uid}")->find();
            $account =  $buy_user['account_money'] + $buy_user['back_money'];
            
            $this->assign('debt', $debt);
            $this->assign('account', $account);
            $this->assign('invest_id', $invest_id);
            $d['content'] = $this->fetch();
            echo json_encode($d);
            
        }
        
        /**
        * 确认购买
        * 流程： 检测购买条件
        * 购买
        */
        public function buy()
        {
            $paypass = strval($_REQUEST['paypass']);
            $invest_id = intval($_REQUEST['invest_id']);
            
            D("DebtBehavior");
            $Debt = new DebtBehavior($this->uid);
            // 检测是否可以购买  密码是否正确，余额是否充足
            //$result = $Debt->buy($paypass, $invest_id);
			$result = $Debt->buy($invest_id);

            if($result === 'TRUE'){
                ajaxmsg('购买成功');
            }else{
                ajaxmsg($result, 1);
            }
        }

  }
	
