<?php
    /**
    * 乾多多转账功能
    * 记录查询
    * @author zhangjili 2014-06-09
    */
    class TransferAction extends ACommonAction
    {
        /**
        * 转账操作
        * 
        */
        public function index()
        {   
            if($this->isPost()){
				$transfer['username'] = text($_POST['user']);
				$user = M('members')->field('id, user_name')->where("user_name='{$transfer['username'] }'")->find();
				if(!$user['id']){
					$this->error('用户不存在');
				}	
				$user_qdd = M('escrow_account')->field('qdd_marked')->where("uid={$user['id']}")->find();
				if(!$user_qdd['qdd_marked']){
					$this->error('对方没有绑定托管账号');
				}

				$transfer['money'] = floatval($_POST['money']);
				if($transfer['money'] <= 0.00){
					$this->error('资金必须大于0.00元');
				}
				$transfer['remark'] = text($_POST['remark']);
				if(!trim($transfer['remark'])){
					$this->error('备注不能为空');
				}

				$transfer['uid'] = $user['id'];
				$transfer['orders'] = 'zz'.build_order_no();
				$transfer['operator'] = session('admin_user_name');
				$transfer['operator_id'] = $this->admin_id;
				$transfer['add_time'] = time();
				$transfer['add_ip'] = get_client_ip();
				
				if($id = M('transfer')->add($transfer)){
					$loanconfig = FS("Webconfig/loanconfig");
					import("ORG.Loan.Escrow");
					$loan = new Escrow();
					$loanList[] = $loan->loanJsonList($loanconfig['pfmmm'], $user_qdd['qdd_marked'], $transfer['orders'], 'zhuanzhang', $transfer['money'], '','转账',$transfer['remark']);
					$loanJsonList = json_encode($loanList);
					$returnURL = 'http://'.$_SERVER['HTTP_HOST'].U("returnurl");
					$notifyURL = 'http://'.$_SERVER['HTTP_HOST'].U("Home/Notify/transfer");
					$data =  $loan->transfer($loanJsonList, $returnURL , $notifyURL,3,1,2,1);
					
					$form =  $loan->setForm($data, 'transfer');
					echo $form;
					exit;
					//$this->success("转账成功!");
				}else{
					$this->error('转账失败');
				}
            }else{
				$user_name = isset($_GET['user_name'])? urldecode($_GET['user_name']):'';
				$this->assign('user_name',$user_name);
                $this->display();
            }
        }  
        
        /**
        * 转账返回地址
        * 
        */
        public function returnUrl()
        {
            import("ORG.Loan.Escrow");
			$loan = new Escrow();
			if($loan->loanVerify($_POST)){
				$lang = L('invest');  
				$msg = $lang[$_POST['ResultCode']];
				if($_POST['ResultCode']!=88){
					$this->error($_POST['Message'], U('index')); 
				}else{
					$this->success('转账成功', U('index'));
					exit;
				}
			}
			$msg = "返回信息被篡改";
			$this->error($msg, U('index')); 
        } 
        
        /**
        * 转账记录
        * 
        */
        public function  record()
        {
			//$map['loanno'] = array('eq','');
            //分页处理
			import("ORG.Util.Page");
			$count = M('transfer')->where($map)->count('id');
			$p = new Page($count, C('ADMIN_PAGE_SIZE'));
			$page = $p->show();
			$Lsql = "{$p->firstRow},{$p->listRows}";
			//分页处理
			
			$field= '*';
			$list = M('transfer')->field($field)->where($map)->limit($Lsql)->order("id DESC")->select();
			$this->assign("list", $list);
			$this->assign("pagebar", $page);
			$this->assign('status',array('0'=>'未处理','1'=>'转账成功','2'=>'转账退回'));
			
			$this->display();
        } 
    }
?>
