<?php
// 全局设置
class WithdrawlogwaitAction extends ACommonAction
{
    /**
    +----------------------------------------------------------
    * 默认操作 待审核提现
    +----------------------------------------------------------
    */
	public function index()
    {$map=array();
		if($_REQUEST['uid'] && $_REQUEST['uname']){
			$map['w.uid'] = $_REQUEST['uid'];
			$search['uid'] = $map['w.uid'];	
			$search['uname'] = urldecode($_REQUEST['uname']);	
		}
		
		if($_REQUEST['uname'] && !$search['uid']){
			$map['m.user_name'] = array("like",urldecode($_REQUEST['uname'])."%");
			$search['uname'] = urldecode($_REQUEST['uname']);	
		}
		
		/*if($_REQUEST['deal_user']){
			$map['w.deal_user'] = urldecode($_REQUEST['deal_user']);
			$search['deal_user'] = $map['w.deal_user'];	
		}
		
		if(!empty($_REQUEST['bj']) && !empty($_REQUEST['money'])){
			$map['w.withdraw_money'] = array($_REQUEST['bj'],$_REQUEST['money']);
			$search['bj'] = $_REQUEST['bj'];	
			$search['money'] = $_REQUEST['money'];	
		}*/

		if(!empty($_REQUEST['start_time']) && !empty($_REQUEST['end_time'])){
			$timespan = strtotime(urldecode($_REQUEST['start_time'])).",".strtotime(urldecode($_REQUEST['end_time']));
			$map['w.addtime'] = array("between",$timespan);
			$search['start_time'] = urldecode($_REQUEST['start_time']);	
			$search['end_time'] = urldecode($_REQUEST['end_time']);	
		}elseif(!empty($_REQUEST['start_time'])){
			$xtime = strtotime(urldecode($_REQUEST['end_time']));
			$map['w.addtime'] = array("gt",$xtime);
			$search['start_time'] = $xtime;	
		}elseif(!empty($_REQUEST['end_time'])){
			$xtime = strtotime(urldecode($_REQUEST['end_time']));
			$map['w.addtime'] = array("lt",$xtime);
			$search['end_time'] = $xtime;	
		}
		//if(session('admin_is_kf')==1)	$map['m.customer_id'] = session('admin_id');
	
		//分页处理
		import("ORG.Util.Page");
		$map['w.status'] =0;
		$count = M('member_withdraw w')->join("{$this->pre}members m ON m.id=w.uid ")->where($map)->count('w.id');
		$p = new Page($count, C('ADMIN_PAGE_SIZE'));
		$page = $p->show();
		$Lsql = "{$p->firstRow},{$p->listRows}";
		//分页处理

		$field= 'w.*,m.user_name,mi.real_name,w.id,w.uid,(mm.account_money+mm.back_money) all_money';
		$list = M('member_withdrawlog w')->field($field)->join("lzh_members m ON w.uid=m.id")->join("lzh_member_info mi ON w.uid=mi.uid")->join("lzh_member_money mm on w.uid = mm.uid")->where($map)->order(' w.id DESC ')->limit($Lsql)->select();
		
		$listType = C('WITHDRAW_STATUS');
		unset($listType[1],$listType[2],$listType[3]);
		$this->assign("bj", array("gt"=>'大于',"eq"=>'等于',"lt"=>'小于'));
        $this->assign("list", $list);
		$this->assign("status",$listType);
        $this->assign("pagebar", $page);
        $this->assign("search", $search);
        $this->assign("query", http_build_query($search));
		
        $this->display();
    }
	//编辑
    public function edit() {
        $model = M('member_withdrawlog');
        $id = intval($_REQUEST['id']);
        $vo = $model->find($id);
	 	$listType = C('WITHDRAW_STATUS');
		unset($listType[0],$listType[2]);
		$this->assign('type_list',$listType);

	 	$field= 'w.*,m.user_name,mi.real_name,w.id,w.uid,(mm.account_money+mm.back_money) all_money,mb.bank_num,mb.bank_province,mb.bank_city,mb.bank_address,mb.bank_name';
		$list = M('member_withdrawlog w')->field($field)->join("lzh_members m ON w.uid=m.id")->join("lzh_member_info mi ON w.uid=mi.uid")->join("lzh_member_money mm on w.uid = mm.uid")->join("lzh_member_banks mb on w.uid = mb.uid")->where("w.id=$id")->order(' w.id ASC ')->limit($Lsql)->select();
		//echo "<pre>";print_r($list);echo "</pre>";exit;
		foreach($list as $v){
			$vo['uname'] =$v['user_name'];
			$vo['real_name'] = $v['real_name'];
			$vo['bank_num'] =$v['bank_num'];
			$vo['bank_province'] = $v['bank_province'];
			$vo['bank_city'] =$v['bank_city'];
			$vo['bank_address'] = $v['bank_address'];
			$vo['bank_name'] =$v['bank_name'];
			$vo['all_money'] =$v['all_money'];
			$vo['withdraw_money'] = $v['transamt'];
			$vo['feeamt'] = $v['feeamt'];
		}
	 //////////////////////////////////////
        $this->assign('vo', $vo);
        $this->display();
    }

	 public function doEdit() {
        $model = D("member_withdrawlog");
		$status = intval($_POST['status']);
		$id = intval($_POST['id']);
		$deal_info = $_POST['deal_info'];
		
		$usrid=$_POST['usrid'];//用户客户号
		$ordid=$_POST['ordid'];//订单号
		$transamt=$_POST['transamt'];//交易金额						
		if($status==1)
		{
			$auditflag = "S";
		}
		else
		{
			$auditflag = "R";
		}
		
		//$secondfee = floatval($_POST['withdraw_fee']);
		$info = $model->field('addtime')->where("id={$id} and (withdraw_status!=0)")->find();
        if($info['add_time']){
            $this->error("此提现初审已处理过，请不要重复处理！");   
        }
        if (false === $model->create()) {
            $this->error($model->getError());
        }
        //保存当前数据对象
		$model->status = $status;
		$model->deal_info = $deal_info;
		$model->deal_time=time();
		//$model->deal_user=session('adminname');
		////////////////////////
		$field= 'w.*,w.id,w.uid,(mm.account_money+mm.back_money) all_money,w.feeamt';
		$vo = M("member_withdrawlog w")->field($field)->join("lzh_member_money mm on w.uid = mm.uid")->find($id);
		$um = M('members')->field("user_name,user_phone")->find($vo['uid']);
		$member_money = M('member_money')->field("(back_money +account_money) as moneys")->where("uid = ".$vo['uid'])->find();
		if($member_money['moneys'] < ($transamt + $vo['feeamt'] )){
			$this->error(L('用户余额不足,无法提现'));
		}
		
		if($status == 1){
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		//exit("222");
			$res = $huifu->cashAudit($usrid,$ordid,$transamt,$auditflag);
		}	
		//exit("333");
		$result = $model->save();
        if ($result) { //保存成功
			alogs("withdraw",$id,$status,$deal_info);//管理员操作日志
          //成功提示
            $this->assign('jumpUrl', __URL__);
            $this->success(L('修改成功'));
        } else {
			alogs("withdraw",$id,$status,'提现处理操作失败！');//管理员操作日志
			//$this->assign("waitSecond",10000);
            //失败提示
            $this->error(L('修改失败'));
        }
    }
	
	public function _listFilter($list){
	 	$listType = C('WITHDRAW_STATUS');
		$row=array();
		foreach($list as $key=>$v){
			$v['withdraw_status'] = $listType[$v['withdraw_status']];
			$v['uname'] = M("members")->getFieldById($v['uid'],'user_name');
			$v['real_name'] = M("member_info")->getFieldById($v['uid'],'real_name');
			$row[$key]=$v;
		}
		return $row;
	}
	
}
?>