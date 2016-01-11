<?php
class WotouziAction extends HCommonAction {
	  public $Detb;
	 public function __construct()
        {
            parent::__construct();
            D("DebtBehavior");
            $this->Debt  = new DebtBehavior($this->uid);
        }
	public function index(){

	    //正在进行的贷款
	    $parm=array();
	    $searchMap = array();
	    $searchMap['b.borrow_status'] = array("in",'2,4,6,7');
	    $searchMap['b.borrow_type'] = array("neq",'9');
	    $parm['map'] = $searchMap;
	    $parm['limit'] = 3;
	    $parm['orderby']="b.borrow_status ASC,b.id DESC";
	    $listBorrow = getBorrowList($parm);
	    $this->assign("listBorrow",$listBorrow);
	    
	    //企业直投列表开始
	    $parm = array();
	    $searchMap = array();
		$searchMap['bi.borrow_status']=array("in",'2,4,6,7');
	    $parm['map'] = $searchMap;
	    $parm['limit'] = 3;
	    $listTBorrow = getTBorrowList($parm);
	    $this->assign("listTBorrow",$listTBorrow);
	
        // 债权转让
        $pre = C('DB_PREFIX');
        $condition = 'd.status in(2,4) AND b.borrow_status in(2,4,6,7)';
        $field = 'd.transfer_price, d.status, d.money, d.total_period, d.period, d.valid, d.id as debt_id, i.id as invest_id,';
       	$field .= 'i.investor_uid, i.deadline, b.id, b.borrow_name, b.borrow_interest_rate,b.borrow_status,';
        $field .= 'b.borrow_duration,m.credits, m.user_name';
        $list = M("invest_detb d")
        ->join("{$pre}borrow_investor i ON d.invest_id=i.id")
        ->join("{$pre}borrow_info b ON i.borrow_id = b.id")
        ->join("{$pre}members m ON i.investor_uid=m.id")
        ->field($field)
        ->where($condition)
        ->limit('0,3')
        ->order("d.status asc")
        ->select();
        //exit(M()->getlastsql());
		$this->assign('list', $list);
		$this->display();  
    }	
	
	 /**
        * 购买债权提示框
        * 
        */
        public function buydebt()
        {
			//
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
            $result = $Debt->buy($paypass, $invest_id);

            if($result === 'TRUE'){
                ajaxmsg('购买成功');
            }else{
                ajaxmsg($result, 1);
            }
        }
	
	
	
  }
	
?>