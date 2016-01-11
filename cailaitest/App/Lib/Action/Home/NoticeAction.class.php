<?php
 class NoticeAction extends HCommonAction{
	
	
	public function withdraw()
	{
		import("ORG.Loan.Escrow");
        $loan = new Escrow();
        if($loan->withdrawVerify($_POST)){
             $orders = $_POST['OrderNo'];
             $id = substr($orders,12);
             $vo = M('member_withdraw')->field('uid,withdraw_money,withdraw_fee,withdraw_status, loanno')->where("id={$id}")->find();
             $uid=$vo['uid'];
		     if($_POST['ResultCode']=='88' && !$vo['withdraw_status']){ // 成功
                $FreeLimit=$_POST['FreeLimit'];
                $FeeWithdraws=$_POST['FeeWithdraws'];
                $Amount=$_POST['Amount'];
            
                $updata['withdraw_status'] = 1;
                $updata['second_fee'] = $_POST['FeeWithdraws'];
                $updata['withdraw_fee'] = $FeeWithdraws;
				$updata['loanno'] = $_POST['LoanNo'];
                $xid = M('member_withdraw')->where("uid={$vo['uid']} AND id={$id}")->save($updata);
				
                if($xid){
                    $amoney=$_POST['Amount']-$_POST['FeeWithdraws'];
                    memberMoneyLog($uid,29,$_POST['Amount'],"提现成功,扣除实际手续费".$FeeWithdraws."元，到帐金额".$amoney."元",'0','@网站管理员@',0);
                    MTip('chk6',$uid);
                    echo "SUCCESS";
					notifyMsg('提现',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'SUCCESS');
					exit;
                }
            }elseif($_POST['ResultCode']=='89' && $vo['withdraw_status']==1){ //退回资金
                $updata['withdraw_status'] = 2;
                $xid = M('member_withdraw')->where("uid={$uid} AND id={$id}")->save($updata); 
                if($xid){
                    memberMoneyLog($uid,5,$_POST['Amount'],"提现退回资金{$_POST['Amount']}元",'0','@网站管理员@',0);
					notifyMsg('提现退回',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'SUCCESS');
                    echo "SUCCESS";  exit;  
                }
            }
			notifyMsg('提现',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], '');
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
 
 }

?>