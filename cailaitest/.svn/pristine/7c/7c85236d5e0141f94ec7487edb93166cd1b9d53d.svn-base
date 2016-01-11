<?php
    /**
    *  债权转让
    */
    class DebtAction extends MCommonAction
    {
        public $Detb;

        public function __construct()
        {
            parent::__construct();
            D("DebtBehavior");
            $this->Debt  = new DebtBehavior($this->uid);
        }
        /**
        * 债权转让默认页
        * 
        */
        public function index()
        {
           $this->display();
        }
		
		public function checkdebt()
		{
			$invest_id = isset($_POST['id'])?intval($_POST['id']):0;
			!$invest_id && ajaxmsg(L('parameter_error'),0);
			$info = M("borrow_investor")->field("add_time")->where("id=".$invest_id)->find();
			$t = strtotime("+1 month",$info['add_time']);
			$now = time();
			if($t>$now)
			{
				$data['status'] = 1;
				echo json_encode($data);
			}
			else
			{
				$data['status'] = 1;
				echo json_encode($data);
			}
		}
        /**
        * 可流转的标
        * 
        */
        public function change()
        {
           $list = $this->Debt->canTransfer();
           $this->assign('list', $list);
           $data['html'] = $this->fetch();
           exit(json_encode($data));
           //dump($list);
        }
        public function sellhtml()
        {
            $invest_id = isset($_GET['id'])? intval($_GET['id']):0;
            !$invest_id && ajaxmsg(L('parameter_error'),0);
            $info = $this->Debt->countDebt($invest_id);
            $this->assign('info', $info);
            $datag = get_global_setting();
            $this->assign('debt_fee', $datag['debt_fee']);
            $this->assign('invest_id', $invest_id);
            
            $borrow = M('borrow_investor i')
            ->join(C('DB_PREFIX')."borrow_info b ON i.borrow_id = b.id")
            ->field("borrow_name,investor_capital")
            ->where("i.id=".$invest_id)
            ->find();
            $this->assign("borrows", $borrow);
            
            $d['content'] = $this->fetch();
            echo json_encode($d);
        }
        public function sell()
        {
            $money = floatval($_POST['money']);
            //$paypass = $_POST['paypass'];
            $invest_id = intval($_POST['invest_id']);
            //if($money && $paypass && $invest_id){
			if($money && $invest_id){
				//$result = $this->Debt->sell($invest_id, $money, $paypass);
				$result = $this->Debt->sell($invest_id, $money);
                if($result ==='TRUE')
                {
                    ajaxmsg('债权转让购买成功');   
                }else{
                    ajaxmsg($result,0);
                }
            }else{
                ajaxmsg('债权转让购买失败',0);
            }
            
            
        }
        /**
        * 进行中的债权
        * 
        */
        public function onBonds()
        {
            $list = $this->Debt->onBonds();
            $this->assign('list', $list);
            $data['html'] = $this->fetch();
            exit(json_encode($data));
        }
        /**
        *    成功的债权
        * 
        */
        public function successClaims()
        {
            $list = $this->Debt->successDebt();
            $this->assign('list', $list);
            $data['html'] = $this->fetch();
            exit(json_encode($data));
        }
        /**
        * 已购买的债权
        * 
        */
        public function buydetb()
        {
            $list = $this->Debt->buydetb();
            $this->assign('list', $list);
            $data['html'] = $this->fetch();
            exit(json_encode($data)); 
        }
        /**
        * 回收中的债权
        * 
        */
        public function ondetb()
        {
            $list = $this->Debt->onDetb();
            $this->assign('list', $list);
            $data['html'] = $this->fetch();
            exit(json_encode($data));
        }
        
        /**
        * 撤销转让债权ajax
        * 
        */
        public function cancelhtml()
        {
            $invest_id = $_REQUEST['invest_id'];
            $this->assign('invest_id', $invest_id);
            
            $d['content'] = $this->fetch();
            echo json_encode($d);
        }
        /**
        *  撤销债权转让
        * 
        */
        public function cancel()
        {
            $invest_id = $_REQUEST['invest_id'];
            !$invest_id && ajaxmsg(L('parameter_error'), 0);
        
            if($this->Debt->cancel($invest_id)) {
                ajaxmsg(L('撤销成功'), 1);
            }else{  
                ajaxmsg(L('撤销失败'), 0);
            }
            
        }
        
        /**
        * 取消的债权软让
        * 
        */
        public function cancellist()
        {
            $list = $this->Debt->cancelList();
            $this->assign('list', $list);
            $data['html'] = $this->fetch();
            exit(json_encode($data));
        }
        
        public function  agreement()
        {
            $invest_id = $this->_get('invest_id','trim',0);
            $ht=M('hetong')->field('hetong_img,name,dizhi,tel')->find(); 
            $content = M("article_category")->field("type_content, type_name")->where("type_nid='agreement_debt'")->find();
            $this->assign('content', $content['type_content']);
            $this->assign('title', $content['type_name']);
            $this->assign('ht', $ht);
            
            $debt = M("invest_detb d")
                    ->join(C('DB_PREFIX')."borrow_investor i ON d.invest_id=i.id")
                    ->join(C('DB_PREFIX')."borrow_info b ON i.borrow_id=b.id")
                    ->join(C('DB_PREFIX')."members m ON d.sell_uid=m.id")
                    ->field("d.serialid, d.buy_time, d.transfer_price, d.buy_uid, m.user_name, b.borrow_name, b.id, b.borrow_interest_rate, b.total, b.has_pay")
                    ->where("d.invest_id={$invest_id}")->find();
            $debt_total = $this->Debt->getAlsoPeriods($invest_id);
            $this->assign('debt_total', $debt_total);
            $buy_user = M("members")->field("user_name")->where("id={$debt['buy_uid']}")->find();
            $this->assign('buy_user', $buy_user['user_name']);
            $this->assign('debt', $debt);

			if(isset($_GET['debug'])) {
				 echo '<pre>';
				 echo 'ht';
				 echo '<pre>';
				 print_r($ht);
				 echo '<pre>';
				 echo 'content';
				 echo '<pre>';
				 print_r($content);
				 echo '<pre>';
				 echo 'debt_total';
				 echo '<pre>';
				 print_r($debt_total);
				 echo '<pre>';
				 print_r($buy_user);
				 echo '<pre>';
				 print_r($debt);
			}

            $this->display();

        }
       
    }
?>
