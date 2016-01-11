<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends MCommonAction {
    public function index(){             
	//	$this->duizhang();
		$ucLoing = de_xie($_COOKIE['LoginCookie']);
		setcookie('LoginCookie','',time()-10*60,"/");
		$this->assign("uclogin",$ucLoing);
		
		$this->assign("unread",$read=M("inner_msg")->where("uid={$this->uid} AND status=0")->count('id'));
		$this->assign("mstatus", M('members_status')->field(true)->find($this->uid));
		$danbao = M('borrow_investor')->where("borrow_uid=".$this->uid)->sum("guar_fee");
		$this->assign("danbao",$danbao);
		//die(M()->getlastsql());
		//echo $danbao;exit;
		//查询会员状态
		$vip_status = M("members_status as ms")
						 ->field("ms.phone_status,ms.id_status,ms.email_status,ms.safequestion_status,lmb.uid")
						 ->join("left join lzh_member_banks as lmb on ms.uid=lmb.uid")
						 ->where('ms.uid='.$this->uid)
						 ->find();

		$this->vip=$vip_status;

		$minfo =getMinfo($this->uid,true);


		$pin_pass = $minfo['pin_pass'];

		$has_pin = (empty($pin_pass))?"no":"yes";
		$this->assign("has_pin",$has_pin);
		$this->assign("memberinfo", M('members')->find($this->uid));
		$this->assign("memberdetail", M('member_info')->find($this->uid));
		$this->assign("minfo",$minfo);
		//加上新手标的利息 2015-09-18
		$benefit=get_personal_benefit($this->uid);
		//dump($benefit);
		//查询新手标的代收利息
		$newbieinterest=M('newbie_record')->field('interest')->where('investid='.$this->uid.' and status=4')->find();
		//echo M()->getLastSql();
		$benefit['interest_collection']=$benefit['interest_collection']+$newbieinterest['interest'];
	
		$this->assign('benefit', $benefit);
		//var_dump(get_personal_benefit($this->uid));
        $this->assign('out', get_personal_out($this->uid));

		$this->assign("bank",M('member_banks')->field('bank_num')->find($this->uid));
		$info = getMemberDetail($this->uid);
		$this->assign("info",$info);
		
		$this->assign("kflist",get_admin_name());
		$list=array();
		$pre = C('DB_PREFIX');
		$rule = M('ausers u')->field('u.id,u.qq,u.phone')->join("{$pre}members m ON m.customer_id=u.id")->where("u.is_kf =1 and m.customer_id={$minfo['customer_id']}")->select();
		foreach($rule as $key=>$v){
			$list[$key]['qq']=$v['qq'];
			$list[$key]['phone']=$v['phone'];
		}
		$this->assign("kfs",$list);
		
		$_SX = M('investor_detail')->field('deadline,interest,capital')->where("investor_uid = {$this->uid} AND status=7")->order("deadline ASC")->find();
		$lastInvest['gettime'] = $_SX['deadline'];
		$lastInvest['interest'] = $_SX['interest'];
		$lastInvest['capital'] = $_SX['capital'];
		$this->assign("lastInvest",$lastInvest);
		
		$_SX="";
		$_SX = M('investor_detail')->field('deadline,sum(interest) as interest,sum(capital) as capital')->where("borrow_uid = {$this->uid} AND status=7")->group("borrow_id,sort_order")->order("deadline ASC")->find();
		$lastBorrow['gettime'] = $_SX['deadline'];
		$lastBorrow['interest'] = $_SX['interest'];
		$lastBorrow['capital'] = $_SX['capital'];
		$this->assign("lastBorrow",$lastBorrow);
		$map=array();
		$map['uid'] = $this->uid;
		$Log_list = getMoneyLog($map,4);
		$this->assign("Log_list",$Log_list['list']);
		$this->assign("list",get_personal_count($this->uid));
                
                //以下是我的投资详细
        $zwmap['investor_uid'] = $this->uid;
		$zwmap['status'] = 4;
		$zwmap['Borrow.borrow_type'] = array('neq',9);
        
		$zwlist = getTenderList($zwmap,1);		
		//显示真实姓名
		if(is_array($zwlist['list'])){
			foreach($zwlist['list'] as $zwkey => $zwval){
				$borrow_uid = $zwval['borrow_uid'];
				$zwmap = " uid = $borrow_uid "; 
				$real_name = M("member_info")->field('real_name')->where($zwmap)->limit(1)->select();
				$zwlist['list'][$zwkey]['real_name'] = $real_name[0]['real_name'];
				unset($real_name);
			}
		}
		//曲线走势图
		$result=M("month_detail")->where("user_id=".$this->uid)->find();
		//去掉前三个
		$res=array_slice($result,3);

		foreach ($res as $key => $value) {
				$arr[]=$value;
		}

		if(max($arr)>=10000)
		{
			foreach ($arr as $key => $value) {
				$brr[]=$value/10000;
			}
			$this->char="万元";
		}else if(max($arr)>=1000){
			foreach ($arr as $key => $value) {
				$brr[]=$value/1000;
			}
			$this->char="千元";
		}else if(max($arr)>=100){
			foreach ($arr as $key => $value) {
				$brr[]=$value/100;
			}
			$this->char="百元";
		}else{
			foreach ($arr as $key => $value) {
				$brr[]=$value;
			}
			$this->char="元";
		}

		if(count($brr)==0)
		{
			$brr=array(0,0,0,0,0,0,0,0,0,0,0,0);
			$this->char="元";
		}
		$brr=json_encode($brr);
		
		$this->arr=$brr;//传输到前端
	
			//日历数据 具体日期具体还款
		$month=date('m');

		$firstday=date('Y-'.$month.'-01 00:00:00');
     	
       	$firstsec = strtotime(date('Y-'.$month.'-01 00:00:00')); //零点零分零秒
      	
      	$lastsec = strtotime(date('Y-m-d  23:59:59', strtotime($firstday."+1 month -1 day"))); //要查询的月末

      	$investor_uid=$this->uid;
  		//借款编号  借款者id 应收本金 应收利息  利息管理费 标的状态 还款时间 逾期罚金 借款者真实姓名

  		$caldata=M('investor_detail as lid')->field('lid.capital,lid.interest,lid.interest_fee,lid.deadline,lid.expired_money')
  		                                    ->join("LEFT JOIN lzh_member_info as lmi on lid.borrow_uid = lmi.uid")
  		                                    ->where("lid.investor_uid=".$investor_uid ." and lid.repayment_time = '0' and lid.deadline>".$firstsec ." and lid.deadline<".$lastsec)
  		                                    ->order('lid.deadline')
  		                                    ->select();
  		foreach ($caldata as $key => $value) 
  		{
  		$calender[]=array(date('md',$value['deadline']),($value['capital']+$value['interest']+$value['expired_money']-$value['interest_fee']));
  		}

  		$temp = array();
		foreach ($calender as $key => $value)
		{
			$key = $value['0'];
			$temp[$key] = isset($temp[$key]) ? $value['1'] + $temp[$key] : $value['1'];
		}
		foreach ($temp as $key => $value)
		{
			//$result[] = array('date' => $key, 'money' => $value);
			$result[] = array($key=>$value);
		}

   		$res=array_slice($result,15);

   		foreach ($res as $key => $value) {
   			foreach ($value as $k => $v) {
   				$ali[]=$k.'&'.$v;
   			}
   		}

   		$this->ali=json_encode($ali);//最新日历数据遍历

  		 // echo "<pre/>";var_dump($ali);
  		//日历结束

   		//推荐项目
   		//正在进行的贷款
	    $searchMap = array();
	    $searchMap['Borrow.borrow_status']=array("eq",'2');
	    $searchMap['Borrow.is_tuijian']=array("in",'0,1');
	    $searchMap['Borrow.borrow_type'] = array("neq",9);
	    $searchMap['Borrow.is_new'] = array("eq",0);
	    $listBorrow = getBorrowList($searchMap,3);
		
		$this->listBorrow=$listBorrow;

  		$this->assign("list",$zwlist['list']);
		$this->assign("pagebar",$zwlist['page']);
        $this->assign('uid', $this->uid);
        //我的投资结束
                
                
                
                
		$this->display();
    }
    
    //我的投资
    	public function zwtendbacking(){
		$map['investor_uid'] = $this->uid;
		$map['status'] = 4;
		$map['Borrow.borrow_type'] = array('neq',9);
        
		$list = getTenderList($map,8);

		//-----------------------------add by zw 2015-04-10---start------------------
		//显示真实姓名
		if(is_array($list['list'])){
			foreach($list['list'] as $key => $val){
				$borrow_uid = $val['borrow_uid'];
				$map = " uid = $borrow_uid "; 
				$real_name = M("member_info")->field('real_name')->where($map)->limit(1)->select();
				$list['list'][$key]['real_name'] = $real_name[0]['real_name'];
				unset($real_name);
			}
		}
		//-------------------------------------end------------------------

	   //$list = $this->getTendBacking();
		$this->assign("list",$list['list']);
		$this->assign("pagebar",$list['page']);
		$this->assign("total",$list['total_money']);
		$this->assign("num",$list['total_num']);
		//$this->display("Public:_footer");

                $this->assign('uid', $this->uid);
		$data['html'] = $this->fetch();
		$data['uid'] = $this;

		exit(json_encode($data));
	}
    //给所有的人的 统计投资数据填充
	public function test()
	{	
		//当前月的第一天和最后一天
		for($i=1;$i<=12;$i++)
		{

		$firstday=strtotime(date('Y-'.$i.'-01 0:0:0'));
		$endday = strtotime(date('Y-'.($i+1).'-01 0:0:0'));
		if($i==12)
		{
			$endday = strtotime(date('Y-'.$i.'-31 23:59:59'));
		}
		//查询这一个月的投资总额
		$res=M("borrow_investor")->field("investor_uid,sum(investor_capital) as ic")->where("add_time>=".$firstday." and add_time<".$endday)->group("investor_uid")->select();
		//当前年月
		$year=date('Y');
		//英文缩写
		$month=array('jan','feb','mar','apr','may','jun','july','aug','sep','otm','nov','dece');
		$data['year']=$year;
		//echo "<pre/>"; var_dump($res);
		foreach ($res as $key => $value) {
			$data[$month[$i-1]]=$value['ic']?$value['ic']:0;
				//数据更新
			$save=M("month_detail")->where('user_id='.$value['investor_uid'])->save($data);
			unset($data[$month[$i-1]]);//防止重复添加
			echo M()->getlastsql()."<br/>";

		}
		
		}
	}
    
        public function zwborrowpaying()
	{
		$membertype = member_type($this->uid);
		if($membertype['status']==1)
		{
			$map['danbao'] = $this->uid;
		}
		else
		{
			$map['borrow_uid'] = $this->uid;
		}
		$map['borrow_status'] = 6;		
//		$map['status'] = 7;
		$list = getBorrowList2($map,8);
		$this->assign("list",$list['list']);
		$this->assign("pagebar",$list['page']);
        
		$data['html'] = $this->fetch();
		exit(json_encode($data));
	}
    

	/**************新增找回支付密码  2013-10-02  fan*********************************/
		public function getpaypassword(){
		$d['content'] = $this->fetch();
		echo json_encode($d);
	}
	
	//找回支付密码
	public function dogetpaypass(){
		(false!==strpos($_POST['u'],"@"))?$data['user_email'] = text($_POST['u']):$data['user_name'] = text($_POST['u']);
		$vo = M('members')->field('id')->where($data)->find();
		if(is_array($vo)){
			$res = Notice(10,$vo['id']);
			if($res) ajaxmsg();
			else ajaxmsg('',0);
		}else{
			ajaxmsg('',0);
		}
	}
	
	//验证码验证
	public function getpaypasswordverify(){
		$code = text($_GET['vcode']);
		$uk = is_verify(0,$code,7,60*1000);
		if(false===$uk){
			$this->error("验证失败");
		}else{
			session("temp_get_paypass_uid",$uk);
			$this->display('getpaypass');
		}
	}
	
	//设置新支付密码
	public function setnewpaypass(){
		$d['content'] = $this->fetch();
		echo json_encode($d);
	}
	
	//处理支付密码
	public function dosetnewpaypass(){
		$per = C('DB_PREFIX');
		$uid = session("temp_get_paypass_uid");
		$oldpass = M("members")->getFieldById($uid,'pin_pass');
		if($oldpass == md5($_POST['paypass'])){
			$newid = true;
		}else{
			$newid = M()->execute("update {$per}members set `pin_pass`='".md5($_POST['paypass'])."' where id={$uid}");
		}
		
		if($newid){
			session("temp_get_paypass_uid",NULL);
			ajaxmsg();
		}else{
			ajaxmsg('',0);
		}
	}
	
	//绑定托管账号
	public function bind()
	{
		$info = array();

		$field="m.user_phone,m.user_email,m.user_name";
		//$pre = C('DB_PREFIX');
		//$result = M("members m")->field($field)->join("{$pre}member_info mi ON m.id=mi.uid")->where("m.id={$this->uid}")->find();
		$result = M("members m")->field($field)->where("m.id={$this->uid}")->find();
		
		$username = $result['user_name'];
		$telephone = $result['user_phone'];
		$email = $result['user_email'];
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$huifu->userRegister($username,$telephone,$email);
	}
	
	//企业托管绑定
	public function corpbind()
	{
		$info = array();
		
		$field = "mi.real_name,m.busi_code,m.user_name,m.isdanbao";
		$pre = C('DB_PREFIX');
		$result = M("members m")->field($field)->join("{$pre}member_info mi ON m.id=mi.uid")->where("m.id={$this->uid}")->find();
		
		$username = $result['user_name'];
		$busicode = $result['busi_code'];
		if($result['isdanbao'] == 1)
		{
			$guartype = 'Y';
		}
		else
		{
			$guartype = 'N';
		}
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$huifu->corpRegister($username,$busicode,$guartype);
	}
	
	//对账
	public function duizhang()
	{
		$usr = M("members")->field("usrid")->where("id=".$this->uid)->find();
		$usrid = $usr['usrid'];
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$result = $huifu->queryBalanceBg($usrid);
		if(strcmp($result['RespCode'],"000")==0)
		{
			$accountval = $result['AvlBal'];
			$freezeval = $result['FrzBal'];
			$moneyinfo = M("member_money")->where("uid=".$this->uid)->find();
			$account_money = str2val_money($accountval) - str2val_money($moneyinfo['back_money']);
			$freeze_money = str2val_money($freezeval);
			
			$data['money_freeze'] = $freeze_money;
			$data['account_money'] = $account_money;
			M("member_money")->where("uid=".$this->uid)->save($data);		
		}
		else
		{
			header("Content-type: text/html; charset=utf-8");
			echo $_POST['RespDesc'];
		}
		
	}
	
	//托管登录
	public function tuoguanlogin()
	{
		$usr = M("members")->field("usrid")->where("id=".$this->uid)->find();
		$usrid = $usr['usrid'];//用户客户号
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$huifu->userLogin($usrid);
	}
}
