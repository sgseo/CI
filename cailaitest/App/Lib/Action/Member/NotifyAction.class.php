<?php
    /**
    * 乾多多后台通知地址汇总
    */
    class NotifyAction extends MCommonAction
    {
        var $notneedlogin=true;
        /**
        * 充值通知地址
        * 
        */
        public function charge()
        {
            import("ORG.Loan.Escrow");
            $loan = new Escrow();
            if($loan->chargeVerify($_POST) && $_POST['ResultCode']=='88'){
				$str = '';
                $orders  = $_POST['OrderNo'];
                $id = substr($orders,12);
                $info = M('member_payonline')->where('id='.$id)->find();
                if($info['status']==1){
                     $str = 'SUCCESS';
                }else{
                    $updata = array(
                        'status'=>'1',
                        'loan_no'=> $_POST['LoanNo'],
                        );
                    if(memberMoneyLog($info['uid'],3,$_POST['Amount'],"在线充值"))
                    {
                        M("member_payonline")->where('id='.$id)->save($updata);//核实成功，
						$str = "SUCCESS";
                       
                    }else{
						$str = 'ERROR';
					}
                }
				notifyMsg('充值',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], $str);
				echo $str; exit;
            }
        }
        
        /**
        * 绑定接口
        * 
        */
        public function bind()
        {
            if($_POST['ResultCode']=='88'){
                import("ORG.Loan.Escrow");
                $loan = new Escrow();
                if($loan->registerVerify($_POST)){
					$str = '';
                    $user = M('members')->field('id')->where("user_name='{$_POST['LoanPlatformAccount']}'")->find();
                     $data = array(
                       'type' => $_POST['AccountType'],
                       'account'=>$_POST['AccountNumber'],
                       'mobile' => $_POST['Mobile'],
                       'email' => $_POST['Email'],
                       'real_name' => $_POST['RealName'],
                       'id_card'  => $_POST['IdentificationNo'],
                       'uid' => $user['id'],
                       'platform' => '',
                       'platform_marked' => $_POST['PlatformMoneymoremore'],
                       'qdd_marked' => $_POST['MoneymoremoreId'],
                       'add_time' => time(),
                    );
                    if(M('escrow_account')->add($data)){
						
                        $str = "SUCCESS";
                    }else{
						$str = "ERROR";
					}
					notifyMsg('绑定账号',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], $str);
					echo $str;exit;
                }
            }
        }

        /**
        * 提现通知地址
        * 
        */
        public function withdraw(){
             if($_POST['ResultCode']=='88'){
                import("ORG.Loan.Escrow");
                $loan = new Escrow();
                if($loan->withdrawVerify($_POST)){
                
                    $updata['withdraw_status'] = 1;
                    $id = $_REQUEST['OrderNo'];
                    $vo = M('member_withdraw')->field('uid,money,fee,member_status')->where("id='{$id}'")->find();
                    //if($vo['status']!=0 || !is_array($vo)) return;
                    $xid = $withdrawlog->where("uid={$vo['uid']} AND id='{$id}'")->save($updata);
                    
                    $tmoney = floatval($vo['money'] - $vo['fee']);
                    memberMoneyLog($this->uid,4,-$withdraw_money,"提现,默认自动扣减手续费".$fee."元",'0','@网站管理员@',0);
                    MTip('chk6',$this->uid);
                    if(M('member_withdraw')->save($updata)){
						notifyMsg('提现',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'SUCCESS');
                        echo "SUCCESS";exit;
                    } 
					notifyMsg('提现',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], '');
                }
            }
        }

                //后台路径

    public function authorizenotify(){
        
        
        //dump($_POST);
        $AuthorizeTypeOpen = $_POST["AuthorizeTypeOpen"];
        $AuthorizeTypeClose = $_POST["AuthorizeTypeClose"];
        $MoneymoremoreId=$_POST['MoneymoremoreId'];
    
        if($_POST["ResultCode"]=='88'){ 
        import("ORG.Loan.Escrow");

        $loan = new Escrow();
        if($loan->Authorizenotify($_POST)){
            
        $escrow=M('escrow_account');
        $open = $AuthorizeTypeOpen;    
        strpos(',', $AuthorizeTypeOpen)&& $open = explode(',',$AuthorizeTypeOpen);
        $close = $AuthorizeTypeClose;
        strpos(',', $AuthorizeTypeClose)&& $close = explode(',',$AuthorizeTypeClose);
            
                
                if(strstr($close,'1')){
                    
                    $auth['invest_auth']='0';
                }else if(strstr($open,'1')){
                    $auth['invest_auth']='1';
                }
                if(strstr($close,'2')){
                    
                    $auth['repayment']='0';
                }else if(strstr($open,'2')){
                    $auth['repayment']='1';
                }
                if(strstr($close,'3')){
                    
                    $auth['secondary_percent']='0';
                }else if(strstr($open,'3')){
                    $auth['secondary_percent']='1';
                }
    

                $info = $escrow->field('uid')->where(array(qdd_marked =>$MoneymoremoreId))->find();
                
                //dump($info);
                $nid=$escrow->where(array('uid'=>$info['uid']))->save($auth);
           
                if($nid) echo 'SUCCESS';
                
            }
        
        }
     }
        
        /**
        * 还款后台通知地址
        * 
        */
        public function detail()
        {
            if($_POST['ResultCode']=='88'){ 
                import("ORG.Loan.Escrow");
                $loan = new Escrow();
                if($loan->loanVerify($_POST)){ 
					$str = '';
					if($_POST['Action']==1){	  
						$info = explode("_",$_POST['Remark1']);
						$expired = explode('/', $_POST['Remark2']);
						
						if(borrowRepayment($info[0], $info[1], $expired)){
							$str = "SUCCESS";
						} 
					}elseif(empty($_POST['Action'])){
						notifyMsg('还款冻结',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'SUCCESS');
						die("SUCCESS");
					}
					notifyMsg('还款',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], $str);
					echo $str;
                }
            }
        }
        /**
        * vip 后台通知
        * 
        */
        public function vip()
        {
            import("ORG.Loan.Escrow");
            $loan = new Escrow();
            if($loan->loanVerify($_POST)){

                $loan_list = json_decode(urldecode($_POST['LoanJsonList']), true);
                isset($loan_list[0]) ? $vip_loan_info = $loan_list[0]:$vip_loan_info = $loan_list;
                $orders = $vip_loan_info['OrderNo'];
                $vip_id = substr($orders, 12);
                $vip_info = M('vip_apply')->field(true)->where("id={$vip_id}")->find(); 

                $apply['loanno']=$vip_loan_info['LoanNo'];
                if(!$vip_info['loanno'] && M('vip_apply')->where("id={$vip_id}")->save($apply)){
					memberMoneyLog($vip_info['uid'],52,-$vip_info['vip_fee'],"升级VIP冻结");
					notifyMsg('VIP申请',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'SUCCESS');
                    die("SUCCESS");
                }
				notifyMsg('VIP申请',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], '');
            }
        }
        
        /**
        * 审核vip 后台通知地址
        * 
        */
        public function auditVip()
        {
			import("ORG.Loan.Escrow");
            $loan = new Escrow();
            if($loan->loanAuditVerify($_POST) && $_POST['ResultCode']==88){ 
                $status =  intval($_POST['AuditType']);
                preg_match('/([0-9]+)/', $_POST['Remark1'], $id_arr);    
                $save['deal_time'] = time();
                $save['deal_user'] =  $id_arr[0];
                $save['status'] = $status;
                $save['deal_info'] =  $_POST['Remark1'];
                $apply =  M('vip_apply')->field("id, status")->where("loanno='{$_POST['LoanNoList']}'")->find();

                if(!$apply['status'] && auditVIP($apply['id'], $status, $save)){
                    echo "SUCCESS";
					notifyMsg('VIP审核',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'SUCCESS');
					exit;
                }
				notifyMsg('VIP审核',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], '');
            }
            
        }
		
		/**
        * 企业直投还款
        * 
        */
        public function edetail()
        {
            if($_POST['ResultCode']=='88'){ 
                import("ORG.Loan.Escrow");
                $loan = new Escrow();
                if($loan->loanVerify($_POST)){
					if(intval($_POST['Action'])==1){
						$info = explode("_",$_POST['Remark1']);
						if(repaymentEnterprise($info[0], $info[1]) == 'TRUE'){
							notifyMsg('直投还款',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'SUCCESS');
							echo 'SUCCESS';exit;
						} 
					}else{
						notifyMsg('直投还款冻结',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'SUCCESS');
						echo 'SUCCESS';exit; 
					}
					notifyMsg('直投还款',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], '');
                }
            }
        }
        
    }
?>
