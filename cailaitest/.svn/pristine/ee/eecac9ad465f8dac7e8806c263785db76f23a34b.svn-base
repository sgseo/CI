<?php
header("Content-type: text/html; charset=utf-8");
/**
*乾多多 授权接口类
* @timg 2014-05-06 14:39
* @author  shaorui 1460313704@qq.com
**/
class AuthorizeAction extends MCommonAction{
	public function index(){
		
		$this->display();
	}
	public function shouquan(){
	
		$data['html'] = $this->fetch();
		exit(json_encode($data));
	
	}
	public function authorize($auth){ 
		//dump($_POST);
		$vau=M('escrow_account')->where("uid={$this->uid}")->find();
		$MoneyId=$vau['qdd_marked'];//用户乾多多标识
		$Platform=$vau['platform_marked'];//平台乾多多标识//"";//
		$str=implode(',',$auth);
		//dump($auth);
		$TypeOpen=$str;//$_POST['AuthorizeTypeOpen'];//开启授权类型1.投标 2.还款。3.二次分配审核。将所有数字有英文(,)连成字符串
		$TypeClose="";//$_POST['AuthorizeTypeClose'];//关闭授权类型1.投标 2.还款。3.二次分配审核。将所有数字有英文(,)连成字符串
		$Remark1='';//$_POST['Remark1'];
		$Remark2='';//$_POST['Remark2'];
		$Remark3='';//$_POST['Remark3'];
		$ReturnURL='http://'.$_SERVER['HTTP_HOST'].U("/member/authorize/authorizereturn"); // 返回地址
		$NotifyURL='http://'.$_SERVER['HTTP_HOST']."/Notice/authorizenotify"; // 通知地址
			$row=M("escrow_account")->where("uid=".$this->uid)->find();
			//dump($row);exit;
			$open=explode(',',$TypeOpen);
			
			$close=explode(',',$TypeClose); 
		
		import("ORG.Loan.Escrow");
		$loan = new Escrow();
		//dump($loan);
		$authdata =  $loan->authorize($MoneyId,$Platform,$TypeOpen,$TypeClose,$Remark1,$Remark2,$Remark3,$ReturnURL,$NotifyURL);
		//dump($authdata);exit;
		$form =  $loan->setForm($authdata,'authorize');
		echo $form;
		//return $form;
	}
	//返回页面
	public function authorizereturn(){ 
		$open = $_POST["AuthorizeTypeOpen"];
		$close = $_POST["AuthorizeTypeClose"];
		
		import("ORG.Loan.Escrow");
		$loan = new Escrow();
		if($loan->Authorizereturn($_POST)){

		    $msg = L($_REQUEST['ResultCode']);
			$_REQUEST['ResultCode'] == 88  && $msg = '授权成功';

		}else{
		$msg='未知错误';
		}
		
		$jump_url = session('authorize_jump');
		session('authorize_jump',null);
		!$jump_url && $jump_url = U('/member');
		$this->assign('jump_url', $jump_url);
       $this->assign('msg', $msg);
        $this->display();
		
		
	}
	//后台路径
	public function authorizenotify(){
	
		$MoneymoremoreId = $_POST["MoneymoremoreId"];
		$PlatformMoneymoremore = $_POST["PlatformMoneymoremore"];
		$AuthorizeTypeOpen = $_POST["AuthorizeTypeOpen"];
		$AuthorizeTypeClose = $_POST["AuthorizeTypeClose"];
		$AuthorizeType = $_POST["AuthorizeType"];
		$RandomTimeStamp = $_POST["RandomTimeStamp"];
		$Remark1 = $_POST["Remark1"];
		$Remark2 = $_POST["Remark2"];
		$Remark3 = $_POST["Remark3"];
		$ResultCode = $_POST["ResultCode"];
		$SignInfo = $_POST["SignInfo"];
		
		//$dataStr = //$MoneymoremoreId.$PlatformMoneymoremore.$AuthorizeTypeOpen.$AuthorizeTypeClose.$AuthorizeType.$RandomTimeStamp.$Remark1.$Remark2.$Remark3.$ResultCode;
		import("ORG.Loan.Escrow");
		$loan = new Escrow();
		if($verifySignature = $loan->Authorizenotify($_POST)){
			
		}
		$model=M('escrow_account');
		//dump($AuthorizeTypeOpen);
		$Open=explode(',',$AuthorizeTypeOpen);
		$close=explode(',',$AuthorizeTypeClose);
		if($ResultCode=='88'){
			
				
					
				if(is_array($Open)){
						
						if(in_array('1',$Open)){
						$auth['invest_auth']='1';
						}
				
						if(in_array('2',$Open)){
						$auth['repayment']='1';
						}
							
				
						if(in_array('3',$Open)){
						$auth['secondary_percent']='1';
						}
				}
				if(is_array($close)){
						if(in_array('1',$close)){
						$auth['invest_auth']='0';
						}
						if(in_array('2',$close)){
						$auth['repayment']='0';
						}
						if(in_array('3',$close)){
						$auth['secondary_percent']='0';
						}
				}
				//dump($auth);
			
				
				$nid=$model->where("uid=".$this->uid)->save($auth);
				//dump($nid);exit;
			
		}
		
		
	}

}

?>