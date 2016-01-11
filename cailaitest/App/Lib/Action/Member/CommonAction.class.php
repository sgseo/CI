<?php
// 本类由系统自动生成，仅供测试用途
/**
 * Class CommonAction
 */
class CommonAction extends MCommonAction {
	var $notneedlogin=true;
    public function index(){
		$this->display();
    }
	
    public function login(){
		$loginconfig = FS("Webconfig/loginconfig");//判断快捷登录是否开启
		$this->assign("loginconfig",$loginconfig);
		$this->display();
    }
	
    public function register(){
		$loginconfig = FS("Webconfig/loginconfig");//判断快捷登录是否开启
		$this->assign("loginconfig",$loginconfig);
		// modify fang@4.11.06
		if(empty($_GET['invite'])){
			$_SESSION['tmp_invite_user'] = null;
			$this->assign('username', '');
		}else{
			$un = M('members')->getFieldById(text($_GET['invite']),'user_name');
			if($un){
				$_SESSION['tmp_invite_user'] = $_GET['invite'];
				$this->assign('username', $un);
			}
		}
		$this->display();
    }
	 public function corpregister(){
		$loginconfig = FS("Webconfig/loginconfig");//判断快捷登录是否开启
		$this->assign("loginconfig",$loginconfig);
		if($_GET['invite']){
			//$uidx = M('members')->getFieldByUserName(text($_GET['invite']),'id');
			//if($uidx>0) session("tmp_invite_user",$uidx);
			session("tmp_invite_user",$_GET['invite']);
		}
		$this->display();
    }
	
	
	
	private function actlogin_bak(){
		(false!==strpos($_POST['sUserName'],"@"))?$data['user_email'] = text($_POST['sUserName']):$data['user_name'] = text($_POST['sUserName']);
		$vo = M('members')->field('id,user_name,user_email,user_pass')->where($data)->find();
		if($vo){
			$this->_memberlogin($vo['id']);
			ajaxmsg();
		}else{
			ajaxmsg("用户名不存在",0);	
		}
	}
	
	
	public function actlogin(){
		
		setcookie('LoginCookie','',time()-10*60,"/");
		//uc登陆
		
		$loginconfig = FS("Webconfig/loginconfig"); 
		$uc_mcfg  = $loginconfig['uc'];
		if($uc_mcfg['enable']==1){
			require_once C('APP_ROOT')."Lib/Uc/config.inc.php";
			require C('APP_ROOT')."Lib/Uc/uc_client/client.php";
		}
		
		//uc登陆
		if($_SESSION['verify'] != md5(trim(strtolower($_POST['sVerCode'])))) 
		{
			ajaxmsg("验证码错误!",0);
		}		
		(false!==strpos($_POST['sUserName'],"@"))?$data['user_email'] = text(trim($_POST['sUserName'])):$data['user_name'] = text(trim($_POST['sUserName']));
		$vo = M('members')->field('id,user_name,user_email,user_pass,is_ban')->where($data)->find();
		if($vo['is_ban']==1) ajaxmsg("您的帐户已被冻结，请联系客服处理！",0);
		
		if(!is_array($vo)){
			ajaxmsg("用户名或者密码错误！",0);
		}else{
			       
			if($vo['user_pass'] == md5($_POST['sPassword']) ){
				$this->_memberlogin($vo['id']);
				ajaxmsg();
			}else{//本站登陆不成功
				ajaxmsg("用户名或者密码错误！",0);
			}

		}
	}
	
	public function actlogout(){
		$this->_memberloginout();
		$loginconfig = FS("Webconfig/loginconfig");
		$this->assign("uclogout",de_xie($logout));
		$this->success("注销成功",__APP__."/");
	}
		
	private function ucreguser($reg){
		$data['user_name'] = text($reg['txtUser']);
		$data['user_pass'] = md5($reg['txtPwd']);
		$data['user_email'] = text($reg['txtEmail']);
		$count = M('members')->where("user_email = '{$data['user_email']}' OR user_name='{$data['user_name']}'")->count('id');
		if($count>0) return "登陆失败,UC用户名冲突,用户名或者邮件已经有人使用";
		$data['reg_time'] = time();
		$data['reg_ip'] = get_client_ip();
		$data['last_log_time'] = time();
		$data['last_log_ip'] = get_client_ip();
		$newid = M('members')->add($data);
		
		if($newid){
			session('u_id',$newid);
			session('u_user_name',$data['user_name']);
			return $newid;
		}
		return "登陆失败,UC用户名冲突";
	}
	
	/*public function regtemp(){
		session('email_temp',text($_POST['txtEmail']));
	    session('name_temp',text($_POST['txtUser']));
		session('pwd_temp',md5($_POST['txtPwd']));
		session('rec_temp',text($_POST['txtRec']));
		ajaxmsg();
	}*/
	
	public function regaction(){
		
		$data['user_name'] = text($_POST['txtUser']);
		$data['user_pass'] = md5($_POST['txtPwd']);
		$data['user_phone'] = text(trim($_POST['txtTelephone']));
		$data['user_email'] = text($_POST['txtEmail']);
		$info['cell_phone'] = text(trim($_POST['txtTelephone']));
		$data['user_type'] = text(trim($_POST['txtUserType']));//会员类型
		$data['busi_code'] = text(trim($_POST['txtBusiCode']));//企业营业执照编号
		
		file_put_contents('/tmp/temp',date('m-d H:i:s')." post : ".print_r($_POST,true)."\n",FILE_APPEND);
		file_put_contents('/tmp/temp',date('m-d H:i:s')." session: ".print_r($_SESSION,true)."\n",FILE_APPEND);

		//判断短信验证码 是否填对
		if( $_SESSION['regsmscodeinfo']['smscode'] != trim($_POST['txtSMS']) ) {
			echo '请填写正确的短信验证码';
			return;
			exit;
		}

		//uc注册
		$loginconfig = FS("Webconfig/loginconfig");
		$uc_mcfg  = $loginconfig['uc'];
		$uc_mcfg['enable'] =0;
		if($uc_mcfg['enable']==1){
			//require_once C('APP_ROOT')."Lib/Uc/config.inc.php";
			//require C('APP_ROOT')."Lib/Uc/uc_client/client.php";
			require_once "uc_client/config.inc.php";
			require "uc_client/client.php";
			$uid = uc_user_register($data['user_name'], $_POST['txtPwd'], $data['user_email']);
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
		}else {
			$data['recommend_id'] = 0;
		}
		
		$newid = M('members')->add($data);
		
		if($newid){

			//红包入库 红包期限30天 2015-08-28
			$addtime=time();//红包添加时间
			$rednum=date('YmdHis',$addtime);//红包序列号
			$shelftime=30;//红包有效期
			$facevalue=10;//红包的面值
			$overtime=$addtime+30*24*60*60;//红包过期时间 时间戳
			$owner=$newid;//红包的拥有者
			$is_used='0';//是否使用 枚举类型需要加‘’
			$is_success='0';//是否使用成功
			$reddata['addtime']=$addtime;
			$reddata['rednum']=$rednum;
			$reddata['shelftime']=$shelftime;
			$reddata['facevalue']=$facevalue;
			$reddata['overtime']=$overtime;
			$reddata['owner']=$owner;
			$reddata['is_success']=$is_success;
			$reddata['is_used']=$is_used;
			$reddata['note']=0;//代表注册送的
			
			M('active_redpacket')->add($reddata);

			//$updata['cell_phone'] = session("temp_phone");
			$b = M('member_info')->where("uid = {$newid}")->count('uid');
			if ($b == 1){
				$newid = M("member_info")->where("uid={$newid}")->save($info);
			}else{
				//$info['uid'] = $this->uid;
				$info['uid'] = $newid;
				M('member_info')->add($info);
				


			} 
			session('u_id',$newid);
			session('u_user_name',$data['user_name']);
                        $_SESSION['real_name'] = $data['user_name'];
			//return $newid;
			echo 1;
		}
		
		
	}
	
	public function corpregaction()
	{
		//echo "<pre>";print_r($_POST);echo "</pre>";exit;
		$data['user_name'] = text($_POST['txtUser']);
		$data['user_pass'] = md5($_POST['txtPwd']);
		$data['user_phone'] = text($_POST['txtTelephone']);
		$data['user_email'] = text($_POST['txtEmail']);
		//$info['real_name'] = text($_POST['txtRealname']);
		$data['busi_code'] = text($_POST['txtBusicode']);
		$data['isdanbao'] = $_POST['isdanbao'];
		$data['iscorp'] = 1;
		$info['cell_phone'] = text($_POST['txtTelephone']);
		
		
		
		$data['reg_time'] = time();
		$data['reg_ip'] = get_client_ip();
		$data['last_log_time'] = time();
        $data['last_log_ip'] = get_client_ip();
		//$global = get_global_setting();
		//$data['reward_money'] = $global['reg_reward'];//新注册用户奖励
		
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
			session('u_id',$newid);
			session('u_user_name',$data['user_name']);
			//return $newid;
			echo 1;
		}
		
		
	}
	public function sendphone() {
		$smsTxt = FS("Webconfig/smstxt");
		$smsTxt = de_xie($smsTxt);
		$phone = text($_POST['cellphone']);
		$xuid = M('members') -> getFieldByUserPhone($phone, 'id');
		if ($xuid > 0 && $xuid <> $this -> uid) ajaxmsg("", 2);

		$code = rand_string_reg(6, 1, 2);
		$datag = get_global_setting();
		$is_manual = $datag['is_manual'];
		
		if ($is_manual == 0) { // 如果未开启后台人工手机验证，则由系统向会员自动发送手机验证码到会员手机，
			$res = sendsms($phone, str_replace(array("#UserName#", "#CODE#"), array(session('u_user_name'), $code), $smsTxt['verify_phone']));
			
		} else { // 否则，则由后台管理员来手动审核手机验证
			$res = true;
			$phonestatus = M('members_status') -> getFieldByUid($this -> uid, 'phone_status');
			if ($phonestatus == 1) ajaxmsg("手机已经通过验证", 1);
			$updata['phone_status'] = 3; //待审核
			$updata1['user_phone'] = $phone;
			$a = M('members') -> where("id = {$this->uid}") -> count('id');
			if ($a == 1) $newid = M("members") -> where("id={$this->uid}") -> save($updata1);
			else {
				M('members') -> where("id={$this->uid}") -> setField('user_phone', $phone);
			} 

			$updata2['cell_phone'] = $phone;
			$b = M('member_info') -> where("uid = {$this->uid}") -> count('uid');
			if ($b == 1) $newid = M("member_info") -> where("uid={$this->uid}") -> save($updata2);
			else {
				$updata2['uid'] = $this -> uid;
				M('member_info') -> add($updata2);
			} 
			$c = M('members_status') -> where("uid = {$this->uid}") -> count('uid');
			if ($c == 1) $newid = M("members_status") -> where("uid={$this->uid}") -> save($updata);
			else {
				$updata['uid'] = $this -> uid;
				$newid = M('members_status') -> add($updata);
			} 
			if ($newid) {
				ajaxmsg();
			} else ajaxmsg("验证失败", 0); 
			// ////////////////////////////////////////////////////////////
		} 
		// $res = sendsms($phone,str_replace(array("#UserName#","#CODE#"),array(session('u_user_name'),$code),$smsTxt['verify_phone']));
		if ($res) {
			session("temp_phone", $phone);
			ajaxmsg();
		} else ajaxmsg("", 0);
	}
	
	public function validatephone() {
		if (session('code_temp')==text($_POST['code'])) {
			$updata['phone_status'] = 1;
			if (!session("temp_phone")) {
				ajaxmsg("验证失败", 0);
			}
            $mid = $this->regaction();
			
			$newid = setMemberStatus($mid, 'phone', 1, 10, '手机');
			if ($newid) {
				ajaxmsg();
			} else{
				ajaxmsg("验证失败", 0);
			}
		} else {
			
			$this->regaction();
			ajaxmsg("验证校验码不对，请重新输入！", 2);
		} 
	} 
	
	public function emailverify(){
		$code = text($_GET['vcode']);
		$uk = is_verify(0,$code,1,60*1000);
		if(false===$uk){
			$this->error("验证失败");
		}else{
			$this->assign("waitSecond",3);
            setMemberStatus($uk, 'email', 1, 9, '邮箱');  
			$this->success("验证成功",__APP__."/member");
		}
	}
	
	public function getpasswordverify(){
		$code = text($_GET['vcode']);
		$uk = is_verify(0,$code,7,60*1000);
		if(false===$uk){
			$this->error("验证失败");
		}else{
			session("temp_get_pass_uid",$uk);
			$this->display('getpass');
		}
	}
	
	public function setnewpass(){
		$d['content'] = $this->fetch();
		echo json_encode($d);
	}
	
	public function dosetnewpass(){
		$per = C('DB_PREFIX');
		$uid = session("temp_get_pass_uid");
		$oldpass = M("members")->getFieldById($uid,'user_pass');
		if($oldpass == md5($_POST['pass'])){
			$newid = true;
		}else{
			$newid = M()->execute("update {$per}members set `user_pass`='".md5($_POST['pass'])."' where id={$uid}");
		}
		
		if($newid){
			session("temp_get_pass_uid",NULL);
			ajaxmsg();
		}else{
			ajaxmsg('',0);
		}
	}
	
	
	public function ckuser(){
		$map['user_name'] = text(trim($_POST['UserName']));
		$count = M('members')->where($map)->count('id');
		if ($count>0) {
			$json['status'] = 0;
			exit(json_encode($json));
        } else {
			$json['status'] = 1;
			exit(json_encode($json));
        }
	}
	
	public function checkphone()
	{
		$map['user_phone'] = text(trim($_POST['Telephone']));
		$count = M('members')->where($map)->count('id');
        
		if ($count>0) {
			$json['status'] = 0;
			exit(json_encode($json));
        } else {
			$json['status'] = 1;
			exit(json_encode($json));
        }
	}
        //检查企业营业执照编号  by zxm
        public function checkBusiCode()
	{
		$map['busi_code'] = text(trim($_POST['BusiCode']));
		$count = M('members')->where($map)->count('id');
        
		if ($count>0) {
			$json['status'] = 0;
			exit(json_encode($json));
        } else {
			$json['status'] = 1;
			exit(json_encode($json));
        }
	}

	/*
	 *******************************************************************************************************************
	 * 修改用户注册、忘记找回密码部分
	 *******************************************************************************************************************
	 */

	// 注册时 短信验证码验证
	public function checksmscode()
	{
		$mobile = text($_POST['mobile']);
		$smscode = text($_POST['smscode']);

		// 取出验证码信息
		$regsmscodeinfo = empty($_SESSION['regsmscodeinfo']) ? '' : $_SESSION['regsmscodeinfo'];
		if(empty($regsmscodeinfo)) {
			$json['status'] = 0;
			exit(json_encode($json));
		}

		// 过期或者错误，返回0
		if(time() - $regsmscodeinfo['time'] > 1800 || $regsmscodeinfo['smscode'] != $smscode || $mobile != $regsmscodeinfo['mobile']) {
			$json['status'] = 0;
			exit(json_encode($json));
		}

		$json['status'] = 1;
		exit(json_encode($json));
	}


	// 注册时 发送验证码短信
	public function sendsmscode()
	{
		$mobile = text(trim($_POST['mobile']));
                //
                $textCode = text(strtolower(trim($_POST['tcode'])));
                if($_SESSION['verify'] != md5($textCode)){
                    $json['status'] = 3;
                    exit(json_encode($json));
                }
                $exptime = time()-24*60*60;
                $data['telephone'] = $mobile;
                $data['cur_time'] = array('gt',$exptime);
                $memberTable = M('member_zc');
                $admin = $memberTable->field('id,telephone,num,cur_time')->where($data)->find();
		if(is_array($admin) && count($admin) > 0){
                    if($admin['num'] < 20){
                        $ndata['num'] = $admin['num'] + 1;
                        $memberTable->where('id='.$admin['id'])->save($ndata);
                    }else{  
                        $json['status'] = 2; 
                        exit(json_encode($json));
                    }
                }else {
                    $datas['telephone'] = $mobile;
                    $datas['num'] = 1;
                    $datas['cur_time'] = time();
                    $memberTable->add($datas);
                }
                //
		$arr = range(0, 9);
		$keys = array_rand($arr, 6);
		$smscode = '';
		foreach($keys as $key) {
			$smscode .= $key;
		}

		$_SESSION['regsmscodeinfo'] = array(
			'smscode' => $smscode,
			'mobile' => $mobile,
			'time' => time()
		);
		sendsms($mobile, '欢迎注册财来网，您的注册短信验证码为' . $smscode . '，30分钟内有效!');

		$json['status'] = 1;

		// 特别注意： 上线时，请将下面一句改成$json['smscode'] = '';
		$json['smscode'] = $smscode;
		// 返回信息
		exit(json_encode($json));
	}


	// 忘记密码
	public function findpwd()
	{
		$this->display();
	}

	// 忘记密码 修改密码
	public function changepwd()
	{
		// 取出验证码信息
		$findpwdsmscodeinfo = empty($_SESSION['findpwdsmscodeinfo']) ? '' : $_SESSION['findpwdsmscodeinfo'];
		$mobile = text($_POST['mobile']);
		$smscode = text($_POST['smscode']);
		// 短信验证码验证
		if(empty($findpwdsmscodeinfo) || time() - $findpwdsmscodeinfo['time'] > 600 || $findpwdsmscodeinfo['smscode'] != $smscode || $mobile != $findpwdsmscodeinfo['mobile']) {
			$json['status'] = 0;
			exit(json_encode($json));
		}


		$pass= md5($_POST['pass']);
		$mobile= $_POST['mobile'];
		$newid = M('members')->where("user_name='{$mobile}' and user_phone='{$mobile}'")->setField('user_pass',$pass);
		if($newid){
			// 注销session
			unset($_SESSION['findpwdsmscodeinfo']);
			$json['status'] = 1;
			exit(json_encode($json));
		} else {
			$json['status'] = 2;
			exit(json_encode($json));
		}
	}

	// 忘记密码 验证短信
	public function checkfindpwdsms()
	{
		$mobile = text($_POST['mobile']);
		$smscode = text($_POST['smscode']);
		// 取出验证码信息
		$findpwdsmscodeinfo = empty($_SESSION['findpwdsmscodeinfo']) ? '' : $_SESSION['findpwdsmscodeinfo'];
		if(empty($findpwdsmscodeinfo)) {
			$json['status'] = 0;
			exit(json_encode($json));
		}

		// 过期或者错误，返回0
		if(time() - $findpwdsmscodeinfo['time'] > 600 || $findpwdsmscodeinfo['smscode'] != $smscode || $mobile != $findpwdsmscodeinfo['mobile']) {
			$json['status'] = 0;
			exit(json_encode($json));
		}

		$json['status'] = 1;
		exit(json_encode($json));
	}

	// 忘记密码 发送忘记密码短信 判断用户是否存在
	public function sendfindpwdsms()
	{
		$mobile = text($_POST['mobile']);
		if(empty($mobile)) {
			$json['status'] = 0;
			// 返回信息
			exit(json_encode($json));
		}

		// 判断用户是否存在
		$count = M('members')->where("user_phone={$mobile}")->count('id');
		if(empty($count)) {
			$json['status'] = 0;
			// 返回信息
			exit(json_encode($json));
		}

		// 处理验证码发送
		$arr = range(0, 9);
		$keys = array_rand($arr, 6);
		$smscode = '';
		foreach($keys as $key) {
			$smscode .= $key;
		}

		$_SESSION['findpwdsmscodeinfo'] = array(
			'smscode' => $smscode,
			'mobile' => $mobile,
			'time' => time()
		);
		sendsms($mobile, '您在财来网修改了账号密码，如不是本人操作，请联系财来网客服。本次的验证码是' . $smscode . '，10分钟内有效!');

		$json['status'] = 1;
		// 特别注意： 上线时，请将下面一句改成$json['smscode'] = '';
		$json['smscode'] = $smscode;
		// 返回信息
		exit(json_encode($json));
	}


	
	public function ckemail(){
		$map['user_email'] = text($_POST['Email']);
		$count = M('members')->where($map)->count('id');

		
		if ($count>0) {
			$json['status'] = 0;
			exit(json_encode($json));
        } else {
			$json['status'] = 1;
			exit(json_encode($json));
        }
	}
	public function emailvsend(){
		session('email_temp',text($_POST['email']));
		$mid = $this->regaction();
				
		$status=Notice(8,$mid);
		if($status) ajaxmsg('邮件已发送，请注意查收！',1);
		else ajaxmsg('邮件发送失败,请重试！',0);
		
    }
	public function ckcode(){
		if( $_SESSION['verify'] != md5(strtolower((trim($_POST['sVerCode']))))) {
			echo (0);
		 }else{
			echo (1);
        }
	}
	
	public function verify(){
		import("ORG.Util.Image");
		Image::buildImageVerify();
		}
	
	/*public function regsuccess(){
		$this->assign('userEmail',M('members')->getFieldById($this->uid,'user_email'));
		$d['content'] = $this->fetch();
		echo json_encode($d);
	}*/
	public function regsuccess(){
	
	//$this->assign('userEmail',M('members')->getFieldById($this->uid,'user_email'));
		//$d['content'] = $this->fetch();
		//echo json_encode($d);
		$this->display();
	}


	public function getpassword(){
		$d['content'] = $this->fetch();
		echo json_encode($d);
	}

	public function dogetpass(){
		(false!==strpos($_POST['u'],"@"))?$data['user_email'] = text($_POST['u']):$data['user_name'] = text($_POST['u']);
		$vo = M('members')->field('id')->where($data)->find();
		if(is_array($vo)){
			$res = Notice(7,$vo['id']);
			if($res) ajaxmsg();
			else ajaxmsg('',0);
		}else{
			ajaxmsg('',0);
		}
	}
    public function register2(){
		$this->display();
	}

	public function phone(){
		$this->assign("phone",$_GET['phone']);
		$data['content'] = $this->fetch();
		exit(json_encode($data));
		
	}
	
	//跳过手机验证
	public function skipphone(){
		$this->regaction();
		ajaxmsg();
		
	}
	//推荐人检测
	public function ckInviteUser(){	
		$map = array();
		$json = array();
		$map['user_name'] = text(trim($_POST['InviteUserName']));
		$aa = M('members')->field('id')->where($map)->find();
		if(!empty($aa['id'])){
			$_SESSION['tmp_invite_user'] = $aa['id'];
			$json['status'] = 1;
			exit(json_encode($json));
		}else{
			$map = array();
			$map['user_name'] = text(trim($_POST['InviteUserName']));
			$map['u_group_id'] = 26;
			$aa = M('ausers')->field('id')->where($map)->find();
			if(!empty($aa['id'])){
				$_SESSION['tmp_invite_user'] = $aa['id'];
				$json['status'] = 1;
				exit(json_encode($json));
			}else{
			
				$_SESSION['tmp_invite_user'] = 0;
				$json['status'] = 0;
				exit(json_encode($json));
			}
		}
	}
}