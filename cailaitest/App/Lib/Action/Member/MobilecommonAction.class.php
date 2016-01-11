<?php
class MobilecommonAction extends MMCommonAction {
    var $notneedlogin=true;


	public function login(){
		$name = $_POST['name'];
		$password = $_POST['password'];
		//$android['password']=$password;
		//$android['android']=$name;
        //$suoid = M("android")->add($android);
		$content = array();
		$content['name']= $name;
		$content['password']= $password;
		echo json_encode($content);
    }
	//登陆+uc（宜境顺荣）
	public function actlogin(){
	
		$jsoncode = file_get_contents("php://input");
		$arr = array();
		$arr = json_decode($jsoncode,true);	
		setcookie('LoginCookie','',time()-10*60,"/");
		//uc登陆
		$loginconfig = FS("Webconfig/loginconfig"); 
		$uc_mcfg  = $loginconfig['uc'];
		$uc_mcfg['enable'] = 0;
		if($uc_mcfg['enable']==1){
			//require_once C('APP_ROOT')."Lib/Uc/config.inc.php";
			//require C('APP_ROOT')."Lib/Uc/uc_client/client.php";
		}
		require_once "uc_client/config.inc.php";
		require "uc_client/client.php";
		
		//uc登陆
		/*if($_SESSION['verify'] != md5(strtolower($_POST['sVerCode']))) 
		{
			ajaxmsg("验证码错误!",0);
		}*/
		
		//(false!==strpos($_POST['sUserName'],"@"))?$data['user_email'] = text($_POST['sUserName']):$data['user_name'] = text($_POST['sUserName']);
		
		(false!==strpos($arr['sUserName'],"@"))?$data['user_email'] = text($arr['sUserName']):$data['user_name'] = text($arr['sUserName']);
		
		list($uid, $username, $password, $email) = uc_user_login(text($arr['sUserName']), text($arr['sPassword']));

		if($uid > 0) {
			$vo = M('members')->field('id,user_name,user_email,user_pass,is_ban')->where($data)->find();
			if($vo['is_ban']==1) ajaxmsg("您的帐户已被冻结，请联系客服处理！",0);

			if(empty($vo)) {
				$regdata = array();
				$regdata['id'] = 
				$regdata['user_name'] = text($arr['sUserName']);
				$regdata['user_pass'] = md5(text($arr['sPassword']));
				$regdata['user_email'] = $email;
				$regdata['reg_time'] = time();
				$regdata['user_email'] = $email;
				
				M('members')->add($regdata);
			}
			//setcookie('LoginCookie',$logincookie,time()+10*60,"/");
			$this->_memberlogin($vo['id']);
			//ajaxmsg(stripslashes(uc_user_synlogin($uid)), 1);
			$arr2 = array();
	            $arr2['type'] = 'actlogin';
				$arr2['deal_user'] = $vo['user_name'];
	            $arr2['tstatus'] = '1';
				$arr2['deal_time'] = time();
	            $arr2['deal_info'] = $vo['user_name']."登录成功_".$jsoncode;
	            $newid = M("auser_dologs")->add($arr2);
				
				$mess = array();
			    $mess['uid'] = intval(session("u_id"));
				$mess['username'] = $vo['user_name'];
				$mess['phone'] = intval(session("u_user_phone"));
				$mess['head'] = get_avatar($mess['uid']);//头像
				$minfo = getMinfo($mess['uid'],true);
				$mess['credits'] = getLeveIco($minfo['credits'],3);//会员等级
				$membermoney = M("member_money")->field(true)->where("uid={$mess['uid']}")->find();
				if(is_array($membermoney)){
					$mess['mayuse'] = $membermoney['account_money']+$membermoney['back_money'];//可用	
			        $mess['freeze'] = $membermoney['money_freeze'];//冻结
			        $mess['collect'] = $membermoney['money_collect'];//代收
					$mess['total'] = $mess['mayuse']+$mess['freeze']+$mess['collect'];//总额
				}else{
				    $mess['total'] = 0;
			        $mess['mayuse'] = 0;
			        $mess['freeze'] = 0;
			        $mess['collect'] = 0;
				}
			    
				ajaxmsg($mess);
		}else {
			ajaxmsg("用户名或者密码错误！",0);
		}
		
		/*if(!is_array($vo)){
			//本站登陆不成功，偿试uc登陆及注册本站
			if($uc_mcfg['enable']==1){
				list($uid, $username, $password, $email) = uc_user_login(text($_POST['sUserName']), text($_POST['sPassword']));
				if($uid > 0) {
					$regdata['txtUser'] = text($_POST['sUserName']);
					$regdata['txtPwd'] = text($_POST['sPassword']);
					$regdata['txtEmail'] = $email;
					$newuid = $this->ucreguser($regdata);
                     
					if(is_numeric($newuid)&&$newuid>0){
						$logincookie = uc_user_synlogin($uid);//UC同步登陆
						
						setcookie('LoginCookie',$logincookie,time()+10*60,"/");
						$this->_memberlogin($newuid);
						ajaxmsg();//登陆成功
					}else{
						ajaxmsg($newuid,0);
					}
				}
			}
			//本站登陆不成功，偿试uc登陆及注册本站
			ajaxmsg("用户名密码错误！",0);
		}else{
			       
			if($vo['user_pass'] == md5($_POST['sPassword']) ){//本站登陆成功，uc登陆及注册UC
				//uc登陆及注册UC
				if($uc_mcfg['enable']==1){
					//$dataUC = uc_get_user($vo['user_name']);
					list($uid, $username, $password, $email) = uc_user_login(text($_POST['sUserName']), text($_POST['sPassword']));
					if($uid > 0) {
						$logincookie = uc_user_synlogin($uid);//UC同步登陆
						setcookie('LoginCookie',$logincookie,time()+10*60,"/");
						//echo $logincookie;
					}else{
						$uid = uc_user_register($vo['user_name'], $_POST['sPassword'], $vo['user_email']);
						if($uid>0){
							$logincookie = uc_user_synlogin($dataUC[0]);//UC同步登陆
							setcookie('LoginCookie',$logincookie,time()+10*60,"/");
							//echo $logincookie;
						}
					}
				}
				//uc登陆及注册UC
				$this->_memberlogin($vo['id']);
				ajaxmsg();
			}else{//本站登陆不成功
				ajaxmsg("用户名或者密码错误！",0);
			}

		}*/
	}
	//登录
	public function actlogin_bak(){
		//setcookie('LoginCookie','',time()-10*60,"/");
		
		//if($_SESSION['verify'] != md5(strtolower($_POST['sVerCode']))) 
		//{
		//	ajaxmsg("验证码错误!",0);
		//}
		$jsoncode = file_get_contents("php://input");
		//alogsm("android_login",0,1,session("u_id").$jsoncode);
//		$arr2 = array();
//	    $arr2['type'] = 'actlogin';
//		
//	    $arr2['tstatus'] = '1';
//		$arr2['deal_time'] = time();
//	    $arr2['deal_info'] = $jsoncode;
//	    $newid = M("auser_dologs")->add($arr2);
		$arr = array();
		$arr = json_decode($jsoncode,true);
		(false!==strpos($arr['sUserName'],"@"))?$data['user_email'] = text($arr['sUserName']):$data['user_name'] = text($arr['sUserName']);
		$vo = M('members')->field('id,user_name,user_email,user_pass,is_ban')->where($data)->find();
		if($vo['is_ban']==1) ajaxmsg("dd您的帐户已被冻结，请联系客服处理！",0);
		if(is_array($vo)){
				
			if($vo['user_pass'] == md5($arr['sPassword']) ){//本站登陆成功
				
				$this->_memberlogin($vo['id']);
				//alogs("login",'','1',session("u_id")."登录成功");
				$arr2 = array();
	            $arr2['type'] = 'actlogin';
				$arr2['deal_user'] = $vo['user_name'];
	            $arr2['tstatus'] = '1';
				$arr2['deal_time'] = time();
	            $arr2['deal_info'] = $vo['user_name']."登录成功_".$jsoncode;
	            $newid = M("auser_dologs")->add($arr2);
				
				$mess = array();
			    $mess['uid'] = intval(session("u_id"));
				$mess['username'] = $vo['user_name'];
				$mess['phone'] = intval(session("u_user_phone"));
				$mess['head'] = get_avatar($mess['uid']);//头像
				$minfo = getMinfo($mess['uid'],true);
				$mess['credits'] = getLeveIco($minfo['credits'],3);//会员等级
				$membermoney = M("member_money")->field(true)->where("uid={$mess['uid']}")->find();
				if(is_array($membermoney)){
					$mess['mayuse'] = $membermoney['account_money']+$membermoney['back_money'];//可用	
			        $mess['freeze'] = $membermoney['money_freeze'];//冻结
			        $mess['collect'] = $membermoney['money_collect'];//代收
					$mess['total'] = $mess['mayuse']+$mess['freeze']+$mess['collect'];//总额
				}else{
				    $mess['total'] = 0;
			        $mess['mayuse'] = 0;
			        $mess['freeze'] = 0;
			        $mess['collect'] = 0;
				}
			    
				ajaxmsg($mess);
			}else{//本站登陆不成功
//			    $arr2 = array();
//	            $arr2['type'] = 'actlogin';
//				$arr2['deal_user'] = $vo['user_name'];
//	            $arr2['tstatus'] = '1';
//				$arr2['deal_time'] = time();
//	            $arr2['deal_info'] = $vo['user_name']."登录密码错误，登录失败_".$jsoncode;
//	            $newid = M("auser_dologs")->add($arr2);
				
				ajaxmsg("kk用户名或者密码错误！",0);
			}

		}else {
//		        $arr2 = array();
//	            $arr2['type'] = 'actlogin';
//				
//	            $arr2['tstatus'] = '1';
//				$arr2['deal_time'] = time();
//	            $arr2['deal_info'] = "用户名或密码错误，登录失败_".$jsoncode;
//	            $newid = M("auser_dologs")->add($arr2);
				
				ajaxmsg("kk用户名或者密码错误！",0);
		}
	}
	//注册+ucenter（宜境顺荣）
		public function regaction(){
		$jsoncode = file_get_contents("php://input");
		$arr = array();
		$arr = json_decode($jsoncode,true);
		if (!is_array($arr)||empty($arr)) {
		  ajaxmsg("提交信息错误，请重试.",0);
		}
		if ($arr['name']==""||$arr['password']==""||$arr['email']=="") {
		  ajaxmsg("提交信息错误，请重试!",0);
		}
		//$data['user_name'] = text($_POST['txtUser']);
		//$data['user_pass'] = md5($_POST['txtPwd']);
		//$data['user_phone'] = text($_POST['txtTelephone']);
		//$data['user_email'] = text($_POST['txtEmail']);
		//$info['cell_phone'] = text($_POST['txtTelephone']);
		
		$data['user_name'] = text($arr['name']);
		$data['user_pass'] = text(md5($arr['password']));
		$data['user_email'] = text($arr['email']);
		//$data['user_phone'] = text($arr['phone']);
		//$info['cell_phone'] = text($arr['phone']);
		
		//uc注册
		$loginconfig = FS("Webconfig/loginconfig");
		$uc_mcfg  = $loginconfig['uc'];
		$uc_mcfg['enable'] =1;
		if($uc_mcfg['enable']==1){
			//require_once C('APP_ROOT')."Lib/Uc/config.inc.php";
			//require C('APP_ROOT')."Lib/Uc/uc_client/client.php";
			require_once "uc_client/config.inc.php";
			require "uc_client/client.php";
			$uid = uc_user_register($data['user_name'], $arr['password'], $data['user_email']);
			if($uid <= 0) {
			
				if($uid == -1) {
					ajaxmsg('用户名不合法',0);
				} elseif($uid == -2) {
					ajaxmsg('包含要允许注册的词语',0);
				} elseif($uid == -3) {
					ajaxmsg('用户名已经存在',0);
				} elseif($uid == -4) {
					ajaxmsg('Email 格式有误',0);
				} elseif($uid == -5) {
					ajaxmsg('Email 不允许注册',0);
				} elseif($uid == -6) {
					ajaxmsg('该 Email 已经被注册',0);
				} else {
					ajaxmsg('未定义',0);
				}
			}
		}
		//uc注册
		
		$data['reg_time'] = time();
		$data['reg_ip'] = get_client_ip();
		$data['last_log_time'] = time();
        $data['last_log_ip'] = get_client_ip();
		//$global = get_global_setting();
		//$data['reward_money'] = $global['reg_reward'];//新注册用户奖励
		$data['id'] = $uid;
		if(session("tmp_invite_user")) {
			$data['recommend_id'] = session("tmp_invite_user");
		}else if(session('rec_temp')){
			$Rectemp = session('rec_temp');
		    $Retemp1 = M('members')->field("id")->where("user_name = '{$Rectemp}'")->find();
		    if($Retemp1['id']>0){
				$data['recommend_id'] = $Retemp1['id'];//推荐人为投资人
			}
		}
		
		$newid = M('members')->add($data);
		
		if($newid){
			//$updata['cell_phone'] = session("temp_phone");
			$b = M('member_info')->where("uid = {$newid}")->count('uid');
			if ($b == 1){
				$newid = M("member_info")->where("uid={$newid}")->save($info);
			}else{
				//$info['uid'] = $this->uid;
				$info['uid'] = $newid;
				M('member_info')->add($info);
			} 
			//session('u_id',$newid);
			//session('u_user_name',$data['user_name']);
			//return $newid;
			//echo 1;
			$mess = array();
			$mess['uid'] = $newid;
			$mess['username'] = $data['user_name'];
			$mess['head'] = get_avatar($newid);
			$mess['total'] = 0;
			$mess['mayuse'] = 0;
			$mess['freeze'] = 0;
			$mess['collect'] = 0;
			ajaxmsg($mess);
		}
		
		
	}
	//注册（原来）
	public function regaction_bak(){
		
		$jsoncode = file_get_contents("php://input");
		
		$arr = array();
		
		$arr = json_decode($jsoncode,true);
		
		if (!is_array($arr)||empty($arr)) {
		  ajaxmsg("提交信息错误，请重试.",0);
		}
		if ($arr['name']==""||$arr['password']==""||$arr['email']=="") {
		  ajaxmsg("提交信息错误，请重试!",0);
		}
		
		
		$data['user_name'] = text($arr['name']);
		$data['user_pass'] = md5($arr['password']);
		$data['user_email'] = text($arr['email']);
		
		$count = M('members')->where("user_email = '{$data['user_email']}' OR user_name='{$data['user_name']}'")->count('id');
		if($count>0) {
//			$arr2 = array();
//	        $arr2['type'] = 'regaction(';
//			$arr2['deal_user'] = $data['user_name'];
//	        $arr2['tstatus'] = '1';
//			$arr2['deal_time'] = time();
//	        $arr2['deal_info'] = $data['user_name']."注册失败，用户名或者邮件已经有人使用_".$jsoncode;
//	        $newid = M("auser_dologs")->add($arr2);
			ajaxmsg("kk注册失败，用户名或者邮件已经有人使用" ,0);
		}
		
		
		$data['reg_time'] = time();
		$data['reg_ip'] = get_client_ip();
		$data['lastlog_time'] = time();
		$data['lastlog_ip'] = get_client_ip();
		if(session("tmp_invite_user"))  $data['recommend_id'] = session("tmp_invite_user");
		$newid = M('members')->add($data);
		
		if($newid){
			//session('u_id',$newid);
			//session('u_user_name',$data['user_name']);
			//memberMoneyLog($newid,1,$this->glo['award_reg'],"注册奖励");
//			$arr2 = array();
//	        $arr2['type'] = 'regaction(';
//			$arr2['deal_user'] = $data['user_name'];
//	        $arr2['tstatus'] = '1';
//			$arr2['deal_time'] = time();
//	        $arr2['deal_info'] = $data['user_name']."注册成功_".$jsoncode;
//	        $newid = M("auser_dologs")->add($arr2);
			
			Notice(1,$newid,array('email',$data['user_email']));
			//$msg = array('uid'=>$newid);
			$mess = array();
			$mess['uid'] = $newid;
			$mess['username'] = $data['user_name'];
			$mess['head'] = get_avatar($newid);
			$mess['total'] = 0;
			$mess['mayuse'] = 0;
			$mess['freeze'] = 0;
			$mess['collect'] = 0;
			ajaxmsg($mess);
			//ajaxmsg();
		}
		else  ajaxmsg("注册失败，请重试",0);
	}
	//注销登录(宜境顺荣)
	public function mactlogout(){
		$this->_memberloginout();
		//uc登陆
		//$loginconfig = FS("Webconfig/loginconfig");
		//$uc_mcfg  = $loginconfig['uc'];

		/*if($uc_mcfg['enable']==1){
			require_once C('APP_ROOT')."Lib/Uc/config.inc.php";
			require C('APP_ROOT')."Lib/Uc/uc_client/client.php";
			$logout = uc_user_synlogout();
			echo $logout;
		}*/
		require_once "uc_client/config.inc.php";
		require "uc_client/client.php";		
		echo uc_user_synlogout();
		
		//uc登陆
		$this->assign("uclogout",de_xie($logout));
		$this->success("注销成功",__APP__."/");
	}
	//原来的东西
	public function mactlogout_bak(){
		$this->_memberloginout();
		ajaxmsg("注销成功");
		
	}
	
	
}