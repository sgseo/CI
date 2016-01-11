<?php
    class NotifyAction extends HCommonAction
    {
        
        /**
        * 复审不通过处理
        * 
        */
        public function auditNo()
        {
            import("ORG.Loan.Escrow");
            $loan = new Escrow();
            if($loan->loanAuditVerify($_POST)){
               if($_POST['ResultCode']==88){ 

                     $borrow_id = loanBorrowId($_POST['LoanNoList']);
                    if(!$borrow_id){
						die('ERROR');
                    }
					$borrow = M("borrow_info")->field('borrow_uid, first_verify_time, borrow_status')->where("id={$borrow_id}")->find();
					if($borrow['borrow_status']!=4){
						die('SUCCESS');
					}
                    
                    $appid = borrowRefuse($borrow_id,3);
                    if(!$appid){
                       echo 'ERROR';exit;  
                    } 
                    MTip('chk12',$borrow['borrow_uid'],$borrow_id);
                    //保存当前数据对象
                    $borrow_save = array(
                        'second_verify_time'=>time(),
                        'borrow_status'=>5,
                    );
                    if ($result = M('borrow_info')->where("id={$borrow_id}")->save($borrow_save)) { //保存成功
                            preg_match('/([0-9]+)/', $_POST['Remark1'], $id_arr);    
                            $admin_id = $id_arr[0];
                            $verify_info['borrow_id'] = intval($borrow_id);
                            $verify_info['deal_info_2'] = text($_POST['Remark1']);
                            $verify_info['deal_user_2'] = $admin_id;
                            $verify_info['deal_time_2'] = time();
                            $verify_info['deal_status_2'] = 5;
                            if($borrow['first_verify_time']>0) M('borrow_verify')->save($verify_info);
                            else  M('borrow_verify')->add($verify_info);
                        alogs("borrowApproved",$result,1,'复审操作成功！');//管理员操作日志
						notifyMsg('复审不通过',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'SUCCESS');
                        echo 'SUCCESS';exit;
                    } else {
                        alogs("borrowApproved",$result,0,'复审操作失败！');//管理员操作日志
						notifyMsg('复审不通过',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'ERROR');
                        echo 'ERROR';exit;
                    }    
               
               } 
			   notifyMsg('复审不通过',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], '');
            }
        
            
        }
        
        /**
        * 复审成功处理
        * 
        */
        public function  auditYes()
        {
            import("ORG.Loan.Escrow");
            $loan = new Escrow();
            if($loan->loanAuditVerify($_POST)){
               if($_POST['ResultCode']==88){ 
                    $borrow_id = loanBorrowId($_POST['LoanNoList']);
                    if(!$borrow_id){
						die('ERROR');
                    }
					$borrow = M("borrow_info")->field('borrow_uid, first_verify_time, borrow_status')->where("id={$borrow_id}")->find();
					if($borrow['borrow_status']!=4){
						die('SUCCESS');
					}
                    
                    $appid = borrowApproved($borrow_id);
                    if(!$appid){
                        die('ERROR'); 
                    }
                    MTip('chk9',$borrow['borrow_uid'], $borrow_id);
                    $vss = M("members")->field("user_phone,user_name")->where("id = {$borrow['borrow_uid']}")->find();
                    SMStip("approve",$vss['user_phone'],array("#USERANEM#","ID"),array($vss['user_name'],$borrow_id));

                    //保存当前数据对象
                    $borrow_save = array(
                        'second_verify_time'=>time(),
                        'borrow_status'=>6,
                    );
                    if ($result = M('borrow_info')->where("id={$borrow_id}")->save($borrow_save)) { //保存成功
                            preg_match('/([0-9]+)/', $_POST['Remark1'], $id_arr);    
                            $admin_id = $id_arr[0];
                            $verify_info['borrow_id'] = intval($borrow_id);
                            $verify_info['deal_info_2'] = text($_POST['Remark1']);
                            $verify_info['deal_user_2'] = $admin_id;
                            $verify_info['deal_time_2'] = time();
                            $verify_info['deal_status_2'] = 6;
                            if($borrow['first_verify_time']>0) M('borrow_verify')->save($verify_info);
                            else  M('borrow_verify')->add($verify_info);
                        alogs("borrowApproved",$result,1,'复审操作成功！');//管理员操作日志
						notifyMsg('复审通过',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'SUCCESS');
                        echo 'SUCCESS';exit;
                    } else {
                        alogs("borrowApproved",$result,0,'复审操作失败！');//管理员操作日志
						notifyMsg('复审通过',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'ERROR');
                        echo 'ERROR';exit;
                    }    
               
               } 
			   notifyMsg('复审通过',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], '');
            } 
        }
        
        /**
        * 流标处理
        * 
        */
        public function  auditBids()
        {

            import("ORG.Loan.Escrow");
            $loan = new Escrow();
			
            if($loan->loanAuditVerify($_POST)){
			   $str = '';
               if($_POST['ResultCode']==88){
                     $borrow_id = loanBorrowId($_POST['LoanNoList']);
					 if(!$borrow_id){
                        echo 'error';exit;
                    }
                    $borrow = M("borrow_info")->field('borrow_uid, first_verify_time, borrow_status')->where("id={$borrow_id}")->find();
                    if($borrow['borrow_status']!=2){
                        echo 'SUCCESS';exit;
                    }
                    //流标返回
                    $appid = borrowRefuse($borrow_id,2);
                    if(!$appid) {
                        alogs("borrowRefuse",0,0,'流标操作失败！');//管理员操作日志
                        echo 'error';exit;
                    }else{
                        alogs("borrowRefuse",0,1,'流标操作成功！');//管理员操作日志
                    }
                    MTip('chk11',$borrow['borrow_uid'],$borrow_id);
                    $vss = M("members")->field("user_phone,user_name")->where("id = {$borrow['borrow_uid']}")->find();
                    SMStip("refuse",$vss['user_phone'],array("#USERANEM#","ID"),array($vss['user_name'],$verify_info['borrow_id']));
                    
                    //保存当前数据对象
                    $borrow_save = array(
                        'second_verify_time'=>time(),
                        'borrow_status'=>3,
                    );
                    if ($result = M('borrow_info')->where("id={$borrow_id}")->save($borrow_save)) { //保存成功
                            preg_match('/([0-9]+)/', $_POST['Remark1'], $id_arr);    
                            $admin_id = $id_arr[0];
                            //流标操作相当于复审
                            $verify_info['borrow_id'] = $borrow_id;
                            $verify_info['deal_info_2'] = text($_POST['Remark1']);
                            $verify_info['deal_user_2'] = $admin_id;
                            $verify_info['deal_time_2'] = time();
                            $verify_info['deal_status_2'] = 3;
                            if($borrow['first_verify_time']>0) M('borrow_verify')->save($verify_info);
                            else  M('borrow_verify')->add($verify_info);
							notifyMsg('流标',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'SUCCESS');
                            $str =  'SUCCESS';
                    } else {
						notifyMsg('流标',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'ERROR');
                       $str =  'error';
                    }     
               }
			   notifyMsg('流标',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], $str);
			   echo $str;exit;
            }
        }
        /**
		* 代还款
		**/
        public function bDetail()
        {
            if($_POST['ResultCode']=='88'){ 
                import("ORG.Loan.Escrow");
                $loan = new Escrow();
                if($loan->loanVerify($_POST)){
					$str = '';
					if(empty($_POST['Action'])){//空为冻结 暂不处理
						notifyMsg('代还冻结',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'SUCCESS');
						echo  "SUCCESS";exit;
					}elseif(intval($_POST['Action'])==1){
						$info = explode("_",$_POST['Remark1']);
						$expired = explode('/', $_POST['Remark2']);
						$vo = M('investor_detail')->where("borrow_id={$info[0]} AND sort_order={$info[1]} AND substitute_money>0")->find();
						if(is_array($vo)){ $str = 'SUCCESS';}
						elseif(borrowRepayment($info[0], $info[1], $expired, 2)){
							
							$str = 'SUCCESS';
						}   
					}
					notifyMsg('代还',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], $str);
					echo $str;exit;
                }
            }
        }
		/**
		**	 转账
		**
		**/
		public function transfer()
		{
			import("ORG.Loan.Escrow");
			$loan = new Escrow();
			if($loan->loanVerify($_POST) && $_POST['ResultCode']==88){
				if(empty($_POST['Action'])){//空为冻结 暂不处理
					notifyMsg('转账冻结',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'SUCCESS');
                     echo "SUCCESS";exit;
				}elseif(intval($_POST['Action'])==1){

					$loan_list = json_decode(urldecode($_POST['LoanJsonList']), true);
					isset($loan_list[0]) ? $transfer_info = $loan_list[0]:$transfer_info = $loan_list;
					$orders = $transfer_info['OrderNo'];
					$transfer = M('transfer')->field('status, loanno, uid')->where("orders='{$orders}'")->find();
					if($transfer['status']!=1){
						$arr['status'] = 1;
						$arr['loanno'] = $transfer_info['LoanNo'];
						if(M('transfer')->where("orders='{$orders}'")->save($arr)){
							if(membermoneylog( $transfer['uid'],7,$transfer_info['Amount'],$transfer_info['Remark'],0,"@网站管理员@")){
								notifyMsg('转账',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'SUCCESS');
								echo "SUCCESS";exit;
							}
							else{
								$arr['status'] = 0;
								//$arr['loanno'] = $transfer['LoanNo'];
								M('transfer')->where("orders='{$orders}'")->save($arr);
								notifyMsg('转账',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], 'ERROR');
							}
						}
					}
				}
				notifyMsg('转账',$_POST, 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'], '');
			}
		}
    }  
?>
