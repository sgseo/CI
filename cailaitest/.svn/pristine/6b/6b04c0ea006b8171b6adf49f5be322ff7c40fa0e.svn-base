<?php
class TborrowAction extends ACommonAction
{

	function _MyInit(){
		$this->assign('action', ACTION_NAME);
		$borrow_config = require C("APP_ROOT")."Conf/borrow_config.php";
		unset($borrow_config['REPAYMENT_TYPE'][1]);
		$this->assign("repayment_type",$borrow_config['REPAYMENT_TYPE']);
		$this->assign("bj", array("gt"=>'大于',"eq"=>'等于',"lt"=>'小于'));
	}
	
	// 后台发标页面
	function add(){
		$vo = M('members')->field("id,user_name")->where("is_transfer=1")->select();//查询出所有流转会员
		$userlist = array();
		if(is_array($vo)){
			foreach($vo as $key => $v){
				$userlist[$v['id']]=$v['user_name'];
			}
		}
		$this->assign("userlist",$userlist);//流转会员
		
		//$this->firm=M("article")->where("type_id=7")->field("id,title")->select();
		$map['m.iscorp'] = 1;
		$map['m.isdanbao'] = 1;
		$map['m.status'] = 'Y';
		$pre = C('DB_PREFIX');
		$field = "m.id,m.user_name,mi.real_name";
		$this->firm=M("members m")->field($field)->join("{$pre}member_info mi ON m.id=mi.uid")->where($map)->select();
		
		//echo M()->getlastsql();exit;
		$this->display();
	}
	
	public function getguarrate()
	{
		$uid = intval($_POST['uid']);
		$guar = M("member_guarrate")->where("uid=".$uid)->find();
		echo $guar['guarrate'];
	}
	 // 解析查询条件并返回
	protected function parse_query($status){
		
		$condition = 'borrow_type = 9 AND borrow_status ='.$status;
		$search = array();
		$search['borrow_type'] = 9;
		$search['borrow_status'] = $status;
		if(empty($_REQUEST)){
			$this->assign('query',http_build_query($search));
			return $condition;
		}
		
		if(!empty($_REQUEST['username'])){
			if($uid = M('members')->getFieldByUserName($_REQUEST['username'], 'id')){
				$search['username'] = $_REQUEST['username'];
				$condition .= " AND borrow_uid = {$uid}";
			}
		}
		
		if(!empty($_REQUEST['money']) && !empty($_REQUEST['bj'])){
			if($_REQUEST['bj'] == 'gt'){
				$condition .= " AND borrow_money > {$_REQUEST['money']}";
			}elseif($_REQUEST['bj'] == 'lt'){
				$condition .= " AND borrow_money = {$_REQUEST['money']}";
			}else{			
				$condition .= " AND borrow_money = {$_REQUEST['money']}";
			}
				$search['bj'] = $_REQUEST['bj'];
				$search['money'] = $_REQUEST['money'];
				
				
		}
		
		if(!empty($_REQUEST['borrow_duration'])){
			$search['borrow_duration'] = $_REQUEST['borrow_duration'];
			$condition .= " AND borrow_duration = {$_REQUEST['borrow_duration']}";
		}
		$this->assign("bj", array("gt"=>'大于',"eq"=>'等于',"lt"=>'小于'));
		$this->assign("search", $search);
		$this->assign('query',http_build_query($search));
		return $condition;
	}
	
	protected function custom_list($status){
		import("ORG.Util.Page");
		$pre = C('DB_PREFIX');
		
		$condition = $this->parse_query($status);
		
		$count = M('borrow_info')->where($condition)->count();
		$Page = new Page($count, C('ADMIN_PAGE_SIZE'));
		$pagebar = $Page->show();
		$offset = "{$Page->firstRow},{$Page->listRows}";
		$field = 'bi.id,bi.borrow_name,bi.borrow_money,bi.has_borrow,add_time,bi.borrow_duration,bi.repayment_type,';
		$field .= 'm.user_name';
		$list = M('borrow_info bi')->field($field)->join("{$pre}members m ON m.id=bi.borrow_uid")->where($condition)->limit($offset)->order('id desc')->select();
		$this->assign('list', $list);		
		$this->assign('pagebar', $pagebar);
		
	}
	
	// 投资中
	function underway(){
		//$this->custom_list(2);
		$condition = 'borrow_type = 9 AND borrow_status = 2';
		$search = array();
		$search['borrow_type'] = 9;
		$search['borrow_status'] = 2;
		if(empty($_REQUEST)){
			$this->assign('query',http_build_query($search));
			return $condition;
		}
		
		if(!empty($_REQUEST['username'])){
			if($uid = M('members')->getFieldByUserName($_REQUEST['username'], 'id')){
				$search['username'] = $_REQUEST['username'];
				$condition .= " AND borrow_uid = {$uid}";
			}
		}
		
		if(!empty($_REQUEST['money']) && !empty($_REQUEST['bj'])){
			if($_REQUEST['bj'] == 'gt'){
				$condition .= " AND borrow_money > {$_REQUEST['money']}";
			}elseif($_REQUEST['bj'] == 'lt'){
				$condition .= " AND borrow_money = {$_REQUEST['money']}";
			}else{			
				$condition .= " AND borrow_money = {$_REQUEST['money']}";
			}
				$search['bj'] = $_REQUEST['bj'];
				$search['money'] = $_REQUEST['money'];
				
				
		}
		
		if(!empty($_REQUEST['borrow_duration'])){
			$search['borrow_duration'] = $_REQUEST['borrow_duration'];
			$condition .= " AND borrow_duration = {$_REQUEST['borrow_duration']}";
		}
		import("ORG.Util.Page");
		$pre = C('DB_PREFIX');		
		$count = M('borrow_info')->where($condition)->count();
		$Page = new Page($count, C('ADMIN_PAGE_SIZE'));
		$pagebar = $Page->show();
		$offset = "{$Page->firstRow},{$Page->listRows}";
		$field = 'bi.id,bi.borrow_name,bi.borrow_money,bi.has_borrow,add_time,bi.borrow_duration,bi.repayment_type,';
		$field .= 'm.user_name';
		$list = M('borrow_info bi')->field($field)->join("{$pre}members m ON m.id=bi.borrow_uid")->where($condition)->limit($offset)->order('id desc')->select();
		$this->assign('list', $list);		
		$this->assign('pagebar', $pagebar);
		$this->assign("bj", array("gt"=>'大于',"eq"=>'等于',"lt"=>'小于'));
		$this->assign("search", $search);
		$this->assign('query',http_build_query($search));
		$this->display();
	}
	// 已流标
	function turnoff(){
		//$this->custom_list(3);
		$condition = 'borrow_type = 9 AND borrow_status = 3 ';
		$search = array();
		$search['borrow_type'] = 9;
		$search['borrow_status'] = 3;
		if(empty($_REQUEST)){
			$this->assign('query',http_build_query($search));
			return $condition;
		}
		
		if(!empty($_REQUEST['username'])){
			if($uid = M('members')->getFieldByUserName($_REQUEST['username'], 'id')){
				$search['username'] = $_REQUEST['username'];
				$condition .= " AND borrow_uid = {$uid}";
			}
		}
		
		if(!empty($_REQUEST['money']) && !empty($_REQUEST['bj'])){
			if($_REQUEST['bj'] == 'gt'){
				$condition .= " AND borrow_money > {$_REQUEST['money']}";
			}elseif($_REQUEST['bj'] == 'lt'){
				$condition .= " AND borrow_money = {$_REQUEST['money']}";
			}else{			
				$condition .= " AND borrow_money = {$_REQUEST['money']}";
			}
				$search['bj'] = $_REQUEST['bj'];
				$search['money'] = $_REQUEST['money'];
				
				
		}
		
		if(!empty($_REQUEST['borrow_duration'])){
			$search['borrow_duration'] = $_REQUEST['borrow_duration'];
			$condition .= " AND borrow_duration = {$_REQUEST['borrow_duration']}";
		}
		import("ORG.Util.Page");
		$pre = C('DB_PREFIX');		
		$count = M('borrow_info')->where($condition)->count();
		$Page = new Page($count, C('ADMIN_PAGE_SIZE'));
		$pagebar = $Page->show();
		$offset = "{$Page->firstRow},{$Page->listRows}";
		$field = 'bi.id,bi.borrow_name,bi.borrow_money,bi.has_borrow,add_time,bi.borrow_duration,bi.repayment_type,';
		$field .= 'm.user_name';
		$list = M('borrow_info bi')->field($field)->join("{$pre}members m ON m.id=bi.borrow_uid")->where($condition)->limit($offset)->order('id desc')->select();
		$this->assign('list', $list);		
		$this->assign('pagebar', $pagebar);
		$this->assign("bj", array("gt"=>'大于',"eq"=>'等于',"lt"=>'小于'));
		$this->assign("search", $search);
		$this->assign('query',http_build_query($search));
		$this->display();
	}
	// 待复审
	function review(){
		//$this->custom_list(4);
		$condition = 'borrow_type = 9 AND borrow_status = 4 ';
		$search = array();
		$search['borrow_type'] = 9;
		$search['borrow_status'] =4;
		
		if(empty($_REQUEST)){
			$this->assign('query',http_build_query($search));
			return $condition;
		}
		
		if(!empty($_REQUEST['username'])){
			if($uid = M('members')->getFieldByUserName($_REQUEST['username'], 'id')){
				$search['username'] = $_REQUEST['username'];
				$condition .= " AND borrow_uid = {$uid}";
			}
		}
		
		if(!empty($_REQUEST['money']) && !empty($_REQUEST['bj'])){
			if($_REQUEST['bj'] == 'gt'){
				$condition .= " AND borrow_money > {$_REQUEST['money']}";
			}elseif($_REQUEST['bj'] == 'lt'){
				$condition .= " AND borrow_money = {$_REQUEST['money']}";
			}else{			
				$condition .= " AND borrow_money = {$_REQUEST['money']}";
			}
				$search['bj'] = $_REQUEST['bj'];
				$search['money'] = $_REQUEST['money'];
				
				
		}
		
		if(!empty($_REQUEST['borrow_duration'])){
			$search['borrow_duration'] = $_REQUEST['borrow_duration'];
			$condition .= " AND borrow_duration = {$_REQUEST['borrow_duration']}";
		}
		
		import("ORG.Util.Page");
		$pre = C('DB_PREFIX');		
		$count = M('borrow_info')->where($condition)->count();
		$Page = new Page($count, C('ADMIN_PAGE_SIZE'));
		$pagebar = $Page->show();
		$offset = "{$Page->firstRow},{$Page->listRows}";
		$field = 'bi.id,bi.borrow_name,bi.borrow_money,bi.has_borrow,add_time,bi.borrow_duration,bi.repayment_type,';
		$field .= 'm.user_name';
		$list = M('borrow_info bi')->field($field)->join("{$pre}members m ON m.id=bi.borrow_uid")->where($condition)->limit($offset)->order('id desc')->select();
		$this->assign('list', $list);		
		$this->assign('pagebar', $pagebar);
		$this->assign("bj", array("gt"=>'大于',"eq"=>'等于',"lt"=>'小于'));
		$this->assign("search", $search);
		$this->assign('query',http_build_query($search));
		$this->display();
	}
	// 复审未通过
	function reject(){
		//$this->custom_list(5);
		$condition = 'borrow_type = 9 AND borrow_status = 5 ';
		$search = array();
		$search['borrow_type'] = 9;
		$search['borrow_status'] = 5;
		if(empty($_REQUEST)){
			$this->assign('query',http_build_query($search));
			return $condition;
		}
		
		if(!empty($_REQUEST['username'])){
			if($uid = M('members')->getFieldByUserName($_REQUEST['username'], 'id')){
				$search['username'] = $_REQUEST['username'];
				$condition .= " AND borrow_uid = {$uid}";
			}
		}
		
		if(!empty($_REQUEST['money']) && !empty($_REQUEST['bj'])){
			if($_REQUEST['bj'] == 'gt'){
				$condition .= " AND borrow_money > {$_REQUEST['money']}";
			}elseif($_REQUEST['bj'] == 'lt'){
				$condition .= " AND borrow_money = {$_REQUEST['money']}";
			}else{			
				$condition .= " AND borrow_money = {$_REQUEST['money']}";
			}
				$search['bj'] = $_REQUEST['bj'];
				$search['money'] = $_REQUEST['money'];
				
				
		}
		
		if(!empty($_REQUEST['borrow_duration'])){
			$search['borrow_duration'] = $_REQUEST['borrow_duration'];
			$condition .= " AND borrow_duration = {$_REQUEST['borrow_duration']}";
		}
		import("ORG.Util.Page");
		$pre = C('DB_PREFIX');		
		$count = M('borrow_info')->where($condition)->count();
		$Page = new Page($count, C('ADMIN_PAGE_SIZE'));
		$pagebar = $Page->show();
		$offset = "{$Page->firstRow},{$Page->listRows}";
		$field = 'bi.id,bi.borrow_name,bi.borrow_money,bi.has_borrow,add_time,bi.borrow_duration,bi.repayment_type,';
		$field .= 'm.user_name';
		$list = M('borrow_info bi')->field($field)->join("{$pre}members m ON m.id=bi.borrow_uid")->where($condition)->limit($offset)->order('id desc')->select();
		$this->assign('list', $list);		
		$this->assign('pagebar', $pagebar);
		$this->assign("bj", array("gt"=>'大于',"eq"=>'等于',"lt"=>'小于'));
		$this->assign("search", $search);
		$this->assign('query',http_build_query($search));
		$this->display();
	}
	// 还款中
	function repayment(){
		//$this->custom_list(6);
		$condition = 'borrow_type = 9 AND borrow_status = 6';
		$search = array();
		$search['borrow_type'] = 9;
		$search['borrow_status'] = 6;

		if(empty($_REQUEST)){
			$this->assign('query',http_build_query($search));
			return $condition;
		}

		if(!empty($_REQUEST['username'])){
			if($uid = M('members')->getFieldByUserName($_REQUEST['username'], 'id')){
				$condition .= " AND borrow_uid = {$uid}";
			}
			$search['username'] = $_REQUEST['username'];
		}
		
		if(!empty($_REQUEST['money']) && !empty($_REQUEST['bj'])){
			if($_REQUEST['bj'] == 'gt'){
				$condition .= " AND borrow_money > {$_REQUEST['money']}";
			}elseif($_REQUEST['bj'] == 'lt'){
				$condition .= " AND borrow_money = {$_REQUEST['money']}";
			}else{			
				$condition .= " AND borrow_money = {$_REQUEST['money']}";
			}
				$search['bj'] = $_REQUEST['bj'];
				$search['money'] = $_REQUEST['money'];
				
				
		}
		
		if(!empty($_REQUEST['borrow_duration'])){
			$search['borrow_duration'] = $_REQUEST['borrow_duration'];
			$condition .= " AND borrow_duration = {$_REQUEST['borrow_duration']}";
		}
		import("ORG.Util.Page");
		$pre = C('DB_PREFIX');		
		$count = M('borrow_info')->where($condition)->count();
		$Page = new Page($count, C('ADMIN_PAGE_SIZE'));
		$pagebar = $Page->show();
		$offset = "{$Page->firstRow},{$Page->listRows}";
		$field = 'bi.id,bi.borrow_name,bi.borrow_money,bi.has_borrow,add_time,bi.borrow_duration,bi.repayment_type,';
		$field .= 'm.user_name';
		$list = M('borrow_info bi')->field($field)->join("{$pre}members m ON m.id=bi.borrow_uid")->where($condition)->limit($offset)->order('id desc')->select();
		$this->assign('list', $list);		
		$this->assign('pagebar', $pagebar);
		$this->assign("bj", array("gt"=>'大于',"eq"=>'等于',"lt"=>'小于'));		
		$this->assign("search", $search);
		$this->assign('query',http_build_query($search));

		
		$this->display();
	}
	// 已完成
	function completed(){
		//$this->custom_list(7);
		$condition = 'borrow_type = 9 AND borrow_status = 7';
		$search = array();
		$search['borrow_type'] = 9;
		$search['borrow_status'] = 7;
		if(empty($_REQUEST)){
			$this->assign('query',http_build_query($search));
			return $condition;
		}
		
		if(!empty($_REQUEST['username'])){
			if($uid = M('members')->getFieldByUserName($_REQUEST['username'], 'id')){
				$search['username'] = $_REQUEST['username'];
				$condition .= " AND borrow_uid = {$uid}";
			}
		}
		
		if(!empty($_REQUEST['money']) && !empty($_REQUEST['bj'])){
			if($_REQUEST['bj'] == 'gt'){
				$condition .= " AND borrow_money > {$_REQUEST['money']}";
			}elseif($_REQUEST['bj'] == 'lt'){
				$condition .= " AND borrow_money = {$_REQUEST['money']}";
			}else{			
				$condition .= " AND borrow_money = {$_REQUEST['money']}";
			}
				$search['bj'] = $_REQUEST['bj'];
				$search['money'] = $_REQUEST['money'];
				
				
		}
		
		if(!empty($_REQUEST['borrow_duration'])){
			$search['borrow_duration'] = $_REQUEST['borrow_duration'];
			$condition .= " AND borrow_duration = {$_REQUEST['borrow_duration']}";
		}
		import("ORG.Util.Page");
		$pre = C('DB_PREFIX');		
		$count = M('borrow_info')->where($condition)->count();
		$Page = new Page($count, C('ADMIN_PAGE_SIZE'));
		$pagebar = $Page->show();
		$offset = "{$Page->firstRow},{$Page->listRows}";
		$field = 'bi.id,bi.borrow_name,bi.borrow_money,bi.has_borrow,add_time,bi.borrow_duration,bi.repayment_type,';
		$field .= 'm.user_name';
		$list = M('borrow_info bi')->field($field)->join("{$pre}members m ON m.id=bi.borrow_uid")->where($condition)->limit($offset)->order('id desc')->select();
		$this->assign('list', $list);		
		$this->assign('pagebar', $pagebar);
		$this->assign("bj", array("gt"=>'大于',"eq"=>'等于',"lt"=>'小于'));
		$this->assign("search", $search);
		$this->assign('query',http_build_query($search));
		$this->display();
	}

	public function doAdd(){
		if(empty($_POST)){
			$this->error('数据不正确');
		}
		

		//dump($_POST);die();
		// 组装数据存库
		$data = $_POST;
		//dump($data);die;
		$data['add_time'] = time();
		$data['can_auto'] =$_POST['is_auto'];
		$data['deadline'] = time() + $_POST['borrow_duration'] * 30 * 24 * 3600;
		$data['borrow_status'] = 2;
		$data['borrow_use_text']=$_POST['borrow_use_text'];
		$data['borrow_guarantee_text']=$_POST['borrow_guarantee_text'];
		$data['borrow_miaoshu']=$_POST['borrow_miaoshu'];
		$data['flat_comment_yijing']=$_POST['flat_comment_yijing'];
		$data['borrow_cuoshi']=$_POST['borrow_cuoshi'];
		$data['borrow_capital']=$_POST['borrow_capital'];
		$data['manage_rate']=$_POST['manage_rate']/100;
		$data['borrow_fee'] = $data['manage_rate']*$data['borrow_money'];
		$data['add_ip'] = get_client_ip();
		$data['swf_data'] = array();
		$data['borrow_type'] = 9;
		$data['collect_time'] = time() + ($_POST['collect_day'] * 24 * 3600);
		$data['borrow_min'] = $_POST['borrow_mix'];
		if($data['borrow_min']  == 0){
			$this->error("最小投标金额不能为空");
		}
		
		$bigf = get_global_setting();
		$dabao_feil = $data['danbao_fee']/100;
		$danbao_fee = $dabao_feil * $data['borrow_money'];
		$ji_moeny = $data['borrow_fee'] + $danbao_fee;
		$big_fee = $data['borrow_money'] * $bigf['maxtenderrate'];
		
		if($ji_moeny >= $big_fee){
			$this->error("手续费不能大于最大投资费");
		}
		if($data['repayment_type']=='1' || $data['repayment_type']=='5'){
			$data['total'] = 1;
		}else{
			$data['total'] = $data['borrow_duration'];//分几期还款
		}
		
		if(!empty($_FILES['imgfile']['name'])){
			$this->saveRule = date("YmdHis",time()).rand(0,1000);
			$this->savePathNew = C('ADMIN_UPLOAD_DIR').'Product/';
			$this->thumbMaxWidth = C('PRODUCT_UPLOAD_W');
			$this->thumbMaxHeight = C('PRODUCT_UPLOAD_H');
			$info = $this->CUpload();
			$data['topic'] = $info[0]['savepath'].$info[0]['savename'];
		}
		
		if(is_array($_POST['swfimglist'])){
			$rows = array();
			foreach ($_POST['swfimglist'] as $key=> $value){
				$rows[$key] = array('info'=> $_POST['picinfo'][$key], 'img'=> $value);
			}
			unset($_POST['swfimglist'], $_POST['picinfo']);
			$data['swf_data'] = json_encode($rows);
		}
		//dump($data);die;
		if ($id = M('borrow_info')->add($data)) { //保存成功
			
			if($data['borrow_status']== 2 && $_POST['is_auto']==1) {
				autoInvest($id);
			}
			$data = array();
			$data['borrow_id'] = $id;
			$data['deal_user'] = $this->admin_id;
			$data['deal_time'] = time();
			$data['deal_info'] = '企业标，系统默认值';
			$data['deal_status'] = 2;
			M('borrow_verify')->add($data);

			
			
			alogs("Tborrow",$id,1,'成功执行了企业直投信息的添加操作！');//管理员操作日志
			//成功提示
			$this->assign('jumpUrl', __URL__.'/underway');
			$this->success('新增成功');
		}else{
			alogs("Tborrow",$id,0,'执行企业直投信息的添加操作失败！');//管理员操作日志
			$this->error('新增失败');
		}
	}
	//swf上传图片
	public function swfUpload(){
		if($_POST['picpath']){
			$imgpath = substr($_POST['picpath'],1);
			if(in_array($imgpath,$_SESSION['imgfiles'])){
				unlink(C("WEB_ROOT").$imgpath);
				$thumb = get_thumb_pic($imgpath);
				$res = unlink(C("WEB_ROOT").$thumb);
				if($res) $this->success("删除成功","",$_POST['oid']);
				else $this->error("删除失败","",$_POST['oid']);
			}else{
				$this->error("图片不存在","",$_POST['oid']);
			}
		}else{
			$this->savePathNew = C('ADMIN_UPLOAD_DIR').'Product/' ;
			$this->thumbMaxWidth = C('PRODUCT_UPLOAD_W');
			$this->thumbMaxHeight = C('PRODUCT_UPLOAD_H');
			$this->saveRule = date("YmdHis",time()).rand(0,1000);
			$info = $this->CUpload();
			$data['product_thumb'] = $info[0]['savepath'].$info[0]['savename'];
			if(!isset($_SESSION['count_file'])) $_SESSION['count_file']=1;
			else $_SESSION['count_file']++;
			$_SESSION['imgfiles'][$_SESSION['count_file']] = $data['product_thumb'];
			echo "{$_SESSION['count_file']}:".__ROOT__."/".$data['product_thumb'];//返回给前台显示缩略图
		}
	}
	
	// 复审
	function edit(){
		if(empty($_GET['id'])){
			$this->error('数据错误');
		}
		
		$map = M('borrow_info')->find($_GET['id']);
		//echo "<pre>";print_r($map);echo "</pre>";exit;
		$this->assign('guarantee', empty($map['danbao']) ? '无担保' : M('member_info')->getFieldByUid($map['danbao'], 'real_name'));
		$this->assign('map', $map);
		$this->display();
	}
	// 复审
	function doEdit()
	{
		if(empty($_POST))
		{
			$this->error('数据不正确', U('/Admin/Tborrow/review'));
		}
		$id = intval($_POST['id']);
		
		$data = array();
		$data['borrow_id'] = $id;
		$data['deal_user_2'] = $this->admin_id;
		$data['deal_time_2'] = time();
		$data['deal_info_2'] = $_POST['deal_info'];
		$data['deal_status_2'] = $_POST['borrow_status'];
		//second_verify_time = time();
		//$update = array();
		//$update['borrow_id'] = $_POST['id'];
		//$update['borrow_status'] = $_POST['borrow_status'];
		
		if($data['deal_status_2'] == 6)
		{
			$appid = borrowApproved($id);
			if(!$appid) $this->error("复审失败", U('/Admin/Tborrow/review'));
		}
		
		if($data['deal_status_2'] == 5){
			
			$refid = borrowRefuse($id,3);
			if(!$refid) $this->error("复审失败", U('/Admin/Tborrow/review'));
		}
		
		//exit('1231');
		$results = M('borrow_info')->where('id = '.$id )->find();
		if($results['borrow_status'] == 6 || $results['borrow_status'] == 5  ){
			M('borrow_verify')->where("borrow_id={$id}")->save($data);
			alogs("Tborrow",$result,1,'复审操作成功！');//管理员操作日志
			//成功提示
			$this->success('复审操作成功', U('/Admin/Tborrow/review'));
		}else{
			
			alogs("Tborrow",$result,0,'复审操作失败！');//管理员操作日志
			$this->error('复审操作失败', U('/Admin/Tborrow/review'));
		}
	}
	public function doinvest()
    {
		
		$borrow_id = intval($_REQUEST['borrow_id']);
		$map=array();
		
		$map['bi.borrow_id'] = $borrow_id;
		//分页处理
		import("ORG.Util.Page");
		$count = M('borrow_investor bi')->join("{$this->pre}members m ON m.id=bi.investor_uid")->where($map)->count('bi.id');
		$p = new Page($count, C('ADMIN_PAGE_SIZE'));
		$page = $p->show();
		$Lsql = "{$p->firstRow},{$p->listRows}";
		//分页处理
		
		$field= 'bi.id bid,b.id,bi.investor_capital,bi.investor_interest,bi.invest_fee,bi.add_time,bi.is_auto,m.user_name,m.id mid,m.user_phone,b.borrow_duration,b.repayment_type,m.customer_name,b.borrow_type,b.borrow_name';
		$list = M('borrow_investor bi')->field($field)->join("{$this->pre}members m ON m.id=bi.investor_uid")->join("{$this->pre}borrow_info b ON b.id=bi.borrow_id")->where($map)->limit($Lsql)->order("bi.id DESC")->select();
		//exit("123123");
		$list = $this->_listFilter($list);
		
		//dump($list);exit;
        $this->assign("list", $list);
        $this->assign("pagebar", $page);
        $this->display();
    }
	
	public function _listFilter($list){
		session('listaction',ACTION_NAME);
		$Bconfig = require C("APP_ROOT")."Conf/borrow_config.php";
	 	$listType = $Bconfig['REPAYMENT_TYPE'];
	 	$BType = $Bconfig['BORROW_TYPE'];
		$row=array();
		$aUser = get_admin_name();
		foreach($list as $key=>$v){
			$v['repayment_type_num'] = $v['repayment_type'];
			$v['repayment_type'] = $listType[$v['repayment_type']];
			$v['borrow_type'] = $BType[$v['borrow_type']];
			if($v['deadline']) $v['overdue'] = getLeftTime($v['deadline']) * (-1);
			if($v['borrow_status']==1 || $v['borrow_status']==3 || $v['borrow_status']==5){
				$v['deal_uname_2'] = $aUser[$v['deal_user_2']];
				$v['deal_uname'] = $aUser[$v['deal_user']];
			}
			
			if($v['is_auto']==1){
				$v['is_auto']="自动投标";
			}else{
				$v['is_auto']="手动投标";
			}
			
			$row[$key]=$v;
		}
		return $row;
	}
	
}

?>
