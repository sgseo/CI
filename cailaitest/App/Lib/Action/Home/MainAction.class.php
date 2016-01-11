<?php

class MainAction extends HCommonAction {
		
				public function index(){
			   $jsoncode = file_get_contents("php://input"); 
	   $arr = array();
	   $arr = json_decode($jsoncode,true);
       //普通标翻页
	   if(is_array($arr) && isset($arr['id']) && isset($arr['type']) && isset($arr['num'])){
	       $type = $arr['type'];
		   $id = intval($arr['id']);
		   $num = intval($arr['num']);
	   }else{
	       $type = 2;
		   $num = 5;
	   }
	   //流转标翻页
	   if(is_array($arr) && isset($arr['tid']) && isset($arr['ttype']) && isset($arr['tnum'])){
	       $ttype = $arr['ttype'];
		   $tid = intval($arr['tid']);
		   $tnum = intval($arr['tnum']);
	   }else{
	       $ttype = 2;
		   $tnum = 5;
	   }
		//alogsm("Main",0,1,$jsoncode);

		$per = C('DB_PREFIX');
		//普通标	
		if($type == 1){
			$searchMap['borrow_status']=array("in",'2,4,6,7');
			$searchMap['b.borrow_type'] = array("neq","9");
			$searchMap['b.id']=array("gt",$id);
			$parm['map'] = $searchMap;
			$parm['limit'] = $num;
			$parm['orderby']="b.borrow_status ASC,b.id asc";
		}elseif($type == 0){
		    $searchMap['borrow_status']=array("in",'2,4,6,7');
		    $searchMap['b.borrow_type'] = array("neq","9");
			$searchMap['b.id']=array("lt",$id);
			$parm['map'] = $searchMap;
			$parm['limit'] = $num;
			$parm['orderby']="b.borrow_status ASC,b.id DESC";
		}else{
		    $searchMap['borrow_status']=array("in",'2,4,6,7');
		    $searchMap['b.borrow_type'] = array("neq","9");
			$parm['map'] = $searchMap;
			$parm['limit'] = $num ;
			$parm['orderby']="b.borrow_status ASC,b.id DESC";
		}
		$list = getBorrowList($parm);
		//$_list = $list;
		foreach($list['list'] as $key =>$v){
		  $_list[$key]['uid'] = intval($v['uid']);
		  $_list[$key]['type'] = getleixing($v);
		  $_list[$key]['id'] = intval($v['id']);
		  $_list[$key]['borrow_name'] = $v['borrow_name'];
		  $_list[$key]['borrow_interest_rate'] = $v['borrow_interest_rate'];
		  if($v['repayment_type']==1){
		      $_list[$key]['borrow_duration'] = $v['borrow_duration']."天";
		  }else{
		      $_list[$key]['borrow_duration'] = $v['borrow_duration']."个月";
		  }
		  
		  
		  $_list[$key]['repayment_type'] = $v['repayment_type'];
		  $_list[$key]['borrow_money'] =$v['borrow_money'];
		  $_list[$key]['progress'] =$v['progress'];
		  $_list[$key]['credits'] =$v['credits'];
		  $_list[$key]['user_name'] =$v['user_name'];
		  $_list[$key]['imgpath'] =get_avatar(intval($v['uid']));
		  $_list[$key]['suo'] = empty($v['password'])?0:1;//是否定向标
		  if($v['reward_type']==1){
		      $_list[$key]['reward']=$v['reward_num']."%";
		  }elseif($v['reward_type']==2){
		      $_list[$key]['reward']=$v['reward_num']."元";
		  }else{
		      $_list[$key]['reward']="0";
		  }
		}
		$m_list['list']= $_list;
		//企业直投
			$parmt = array();
		if($ttype == 1){
			$searchMapt['bi.borrow_status']=array("in","2,4,6,7");	
			//$searchMapt['bi.borrow_type'] = 9;
			$searchMapt['bi.id']=array("gt",$tid);
			$parmt['map'] = $searchMapt;
			$parmt['limit'] = $tnum;
		    $parmt['orderby']="bi.borrow_status ASC,bi.id asc";
		}elseif($ttype == 0){
			$searchMapt['bi.borrow_status']=array("in","2,4,6,7");   
			//$searchMapt['bi.borrow_type'] = 9;
			$searchMapt['bi.id']=array("lt",$tid);
			$parmt['map'] = $searchMapt;
			$parmt['limit'] = $tnum;
			$parmt['orderby']="bi.borrow_status ASC,bi.id DESC";
		}else{
			$searchMapt['bi.borrow_status']=array("in","2,4,6,7");
	        //$searchMapt['bi.borrow_type'] = 9;

			$parmt['map'] = $searchMapt;
			$parmt['limit'] = $tnum;

				$parmt['orderby']="bi.borrow_status ASC,bi.id DESC";
		}
		//print_r($parmt);die();
		 $tlist = getTBorrowList($parmt);
		foreach($tlist['list'] as $key =>$v){
		  $_tlist[$key]['uid'] = intval($v['uid']);
		  $_tlist[$key]['type'] = 2;
		  $_tlist[$key]['id'] = intval($v['id']);
		  $_tlist[$key]['borrow_name'] = $v['borrow_name'];
		  $_tlist[$key]['borrow_interest_rate'] = $v['borrow_interest_rate'];
		  if($v['repayment_type']==1){
		      $_tlist[$key]['borrow_duration'] = $v['borrow_duration']."天";
		  }else{
		      $_tlist[$key]['borrow_duration'] = $v['borrow_duration']."个月";
		  }
		  
		  
		  $_tlist[$key]['repayment_type'] = $v['repayment_type'];
		  $_tlist[$key]['borrow_money'] =$v['borrow_money'];
		  $_tlist[$key]['progress'] =$v['progress'];
		  $_tlist[$key]['credits'] =$v['credits'];
		  $_tlist[$key]['user_name'] =$v['user_name'];
		  $_tlist[$key]['imgpath'] =get_avatar(intval($v['uid']));
		  $_tlist[$key]['suo'] = empty($v['password'])?0:1;//是否定向标
		  if($v['reward_type']==1){
		      $_tlist[$key]['reward']=$v['reward_num']."%";
		  }elseif($v['reward_type']==2){
		      $_tlist[$key]['reward']=$v['reward_num']."元";
		  }else{
		      $_tlist[$key]['reward']="0";
		  }
		}
		$m_list['tlist']= $_tlist;

		//////////////////////////////////////////////债券转让//////////////////////////////////////////////////
  //   	$search1 = array();
		// $search1['b.borrow_status']=array("in","2,4,6,7");
		// $parm1['map'] = $search1;
		// D("DebtBehavior");
		// $Debt = new DebtBehavior();
		// $dlist = $Debt->listAll($parm1);
		// foreach($dlist['data'] as $key =>$v){
		//   $_dlist[$key]['uid'] = intval($v['uid']);
		//   $_dlist[$key]['type'] = 9;
		//   $_dlist[$key]['id'] = intval($v['id']);
		//   $_dlist[$key]['borrow_name'] = $v['borrow_name'];
		//   $_dlist[$key]['credits'] =$v['credits'];
		//   $_dlist[$key]['borrow_interest_rate'] = $v['borrow_interest_rate']."%";
		//   $_dlist[$key]['transfer_price'] = $v['transfer_price'];
		//   $_dlist[$key]['money'] =$v['money'];
		//   $_dlist[$key]['period'] =$v['period'];
		//   $_dlist[$key]['total_period'] =$v['total_period'];
		//   $_dlist[$key]['status'] = $v['status'];
		// }
		// $m_list['dlist']= $_dlist;
		echo ajaxmsg($m_list);
		//$this->display();
    }
		public function index_bak(){
		$jsoncode = file_get_contents("php://input");
		$arr = array();
		$arr = json_decode($jsoncode,true);
//		$datag = get_global_setting();
//		$newversion = $datag['apkversion'];
//		if(is_array($arr)&&(!empty($arr))&&(!empty($arr['version']))&&((int)$arr['version'])<$newversion){
//		    $m_list['upversion'] = 1;
//			$m_list['path'] = $datag['apkpath'];
//		}else{
//		    $m_list['upversion'] = 0;
//		}
		//alogsm("Main",0,1,$jsoncode);
		$per = C('DB_PREFIX');
		//print_r($arr);die();
       //普通标翻页
	   if(is_array($arr) && isset($arr['id']) && isset($arr['type']) && isset($arr['num'])){
	       $type = $arr['type'];
		   $id = intval($arr['id']);
		   $num = intval($arr['num']);
	   }else{
	       $type = 2;
		   $num = 5;
	   }
	   //企业标翻页
	   if(is_array($arr) && isset($arr['tid']) && isset($arr['ttype']) && isset($arr['tnum'])){
	       $ttype = $arr['ttype'];
		   $tid = intval($arr['tid']);
		   $tnum = intval($arr['tnum']);
	   }else{
	       $ttype = 2;
		   $tnum = 5;
	   }
		//普通标	
		if($type == 1){
			$searchMap['borrow_status']=array("in",'2,4,6,7');
			$searchMap['b.borrow_type'] = array("neq","9");
			$searchMap['b.id']=array("gt",$id);
			$parm['map'] = $searchMap;
			$parm['limit'] = $num;
			$parm['orderby']="b.borrow_status ASC,b.id asc";
		}elseif($type == 0){
		    $searchMap['borrow_status']=array("in",'2,4,6,7');
			$searchMap['b.borrow_type'] = array("neq","9");
			$searchMap['b.id']=array("lt",$id);
			$parm['map'] = $searchMap;
			$parm['limit'] = $num;
			$parm['orderby']="b.borrow_status ASC,b.id DESC";
		}else{
		    $searchMap['borrow_status']=array("in",'2,4,6,7');
			$searchMap['b.borrow_type'] = array("neq","9");
			$parm['map'] = $searchMap;
			$parm['limit'] = $num ;
			$parm['orderby']="b.borrow_status ASC,b.id DESC";
		}
		//$searchMap['borrow_status']=array("in",'2,4,6,7');

		//$parm['map'] = $searchMap;
		//$parm['limit'] = 10;

		//$parm['orderby']="b.borrow_status ASC,b.id DESC";
		
		$list = getBorrowList($parm);
		//$_list = $list;
		foreach($list['list'] as $key =>$v){
		  $_list[$key]['uid'] = intval($v['uid']);
		  $_list[$key]['type'] = getleixing($v);
		  $_list[$key]['id'] = intval($v['id']);
		  $_list[$key]['borrow_name'] = $v['borrow_name'];
		  $_list[$key]['borrow_interest_rate'] = $v['borrow_interest_rate'];
		  if($v['repayment_type']==1){
		      $_list[$key]['borrow_duration'] = $v['borrow_duration']."天";
		  }else{
		      $_list[$key]['borrow_duration'] = $v['borrow_duration']."个月";
		  }
		  
		  
		  $_list[$key]['repayment_type'] = $v['repayment_type'];
		  $_list[$key]['borrow_money'] =$v['borrow_money'];
		  $_list[$key]['progress'] =$v['progress'];
		  $_list[$key]['credits'] =$v['credits'];
		  $_list[$key]['user_name'] =$v['user_name'];
		  $_list[$key]['imgpath'] =get_avatar(intval($v['uid']));
		  $_list[$key]['suo'] = empty($v['password'])?0:1;//是否定向标
		  if($v['reward_type']==1){
		      $_list[$key]['reward']=$v['reward_num']."%";
		  }elseif($v['reward_type']==2){
		      $_list[$key]['reward']=$v['reward_num']."元";
		  }else{
		      $_list[$key]['reward']="0";
		  }
		}
		$m_list['list']= $_list;
		//企业直投
		$parmt = array();
		if($ttype == 1){
			$searchMapt['bi.borrow_status']=array("in","2,4,6,7");	
			$searchMapt['bi.borrow_type'] = 9;
			$parmt['map'] = $searchMapt;
			$parmt['limit'] = $tnum;

			$parmt['orderby']="bi.borrow_status ASC,bi.id DESC,bi.add_time DESC";
		}elseif($ttype == 0){
			$searchMapt['bi.borrow_status']=array("in","2,4,6,7");   
			$searchMapt['bi.borrow_type'] = 9;
			$parmt['map'] = $searchMapt;
			$parmt['limit'] = $tnum;
			$parmt['orderby']="bi.borrow_status ASC,bi.id DESC,bi.add_time DESC";
		}else{
			$searchMapt['bi.borrow_status']=array("in","2,4,6,7");
	        $searchMapt['bi.borrow_type'] = 9;

			$parmt['map'] = $searchMapt;
			$parmt['limit'] = $tnum;

			$parmt['orderby']="bi.borrow_status ASC,bi.id DESC,bi.add_time DESC";
		}
		//$searchMapt['bi.borrow_type'] = 9;
		//$searchMap['borrow_status']=2;
		//$searchMapt['is_show'] = array('in','0,1');
		//$searchMapt['bi.borrow_status']=array("in","2,4,6,7");
		// $searchMap['b.borrow_status']=0;
		// $searchMap['deadline']=strtotime("deadline");
		// $search['bi.borrow_status']=array("in","2,4,6,7");

		//$searchMap['b.borrow_type'] =9;
		//$parmt['map'] = $searchMapt;
		//$parmt['limit'] = 10;
		//$parmt['orderby'] = "b.is_show desc,b.id DESC";
		// $parm['orderby']="bi.borrow_status ASC,bi.id DESC,bi.add_time DESC";
		 $tlist = getTBorrowList($parmt);
		foreach($tlist['list'] as $key =>$v){
		  // $_tlist[$key]['uid'] = intval($v['uid']);
		  // $_tlist[$key]['type'] = 2;
		  // $_tlist[$key]['id'] = intval($v['id']);
		  // $_tlist[$key]['borrow_name'] = $v['borrow_name'];
		  // $_tlist[$key]['borrow_interest_rate'] = $v['borrow_interest_rate'];
		  // $_tlist[$key]['borrow_duration'] = $v['borrow_duration']."个月";
		  // $_tlist[$key]['per_transfer'] = $v['per_transfer'];
		  // $_tlist[$key]['borrow_money'] =$v['borrow_money'];
		  // $_tlist[$key]['progress'] =$v['progress'];
		  // $_tlist[$key]['credits'] =$v['credits'];
		  // $_tlist[$key]['user_name'] =$v['user_name'];
		  // $_tlist[$key]['imgpath'] =get_avatar(intval($v['uid']));
		  // $_tlist[$key]['reward'] = $v['reward_rate']."%";
		  $_tlist[$key]['uid'] = intval($v['uid']);
		  $_tlist[$key]['type'] = 2;
		  $_tlist[$key]['id'] = intval($v['id']);
		  $_tlist[$key]['borrow_name'] = $v['borrow_name'];
		  $_tlist[$key]['borrow_interest_rate'] = $v['borrow_interest_rate'];
		  if($v['repayment_type']==1){
		      $_tlist[$key]['borrow_duration'] = $v['borrow_duration']."天";
		  }else{
		      $_tlist[$key]['borrow_duration'] = $v['borrow_duration']."个月";
		  }
		  
		  
		  $_tlist[$key]['repayment_type'] = $v['repayment_type'];
		  $_tlist[$key]['borrow_money'] =$v['borrow_money'];
		  $_tlist[$key]['progress'] =$v['progress'];
		  $_tlist[$key]['credits'] =$v['credits'];
		  $_tlist[$key]['user_name'] =$v['user_name'];
		  $_tlist[$key]['imgpath'] =get_avatar(intval($v['uid']));
		  $_tlist[$key]['suo'] = empty($v['password'])?0:1;//是否定向标
		  if($v['reward_type']==1){
		      $_tlist[$key]['reward']=$v['reward_num']."%";
		  }elseif($v['reward_type']==2){
		      $_tlist[$key]['reward']=$v['reward_num']."元";
		  }else{
		      $_tlist[$key]['reward']="0";
		  }
		}
		//$m_list['tlist']= $_tlist;
		//////////////////////////////////////////////债券转让//////////////////////////////////////////////////
  //   	$search1 = array();
		// $search1['b.borrow_status']=array("in","2,4,6,7");
		// $parm1['map'] = $search1;
		// D("DebtBehavior");
		// $Debt = new DebtBehavior();
		// $dlist = $Debt->listAll($parm1);
		// foreach($dlist['data'] as $key =>$v){
		//   $_dlist[$key]['uid'] = intval($v['uid']);
		//   $_dlist[$key]['type'] = 9;
		//   $_dlist[$key]['id'] = intval($v['id']);
		//   $_dlist[$key]['borrow_name'] = $v['borrow_name'];
		//   $_dlist[$key]['credits'] =$v['credits'];
		//   $_dlist[$key]['borrow_interest_rate'] = $v['borrow_interest_rate']."%";
		//   $_dlist[$key]['transfer_price'] = $v['transfer_price'];
		//   $_dlist[$key]['money'] =$v['money'];
		//   $_dlist[$key]['period'] =$v['period'];
		//   $_dlist[$key]['total_period'] =$v['total_period'];
		//   $_dlist[$key]['status'] = $v['status'];
		// }
		// $m_list['dlist']= $_dlist;
		echo ajaxmsg($m_list);
		
		//$this->assign("Sorder",$Sorder);
//		$this->assign("searchMap",$maprow);
//		$this->assign("Bconfig",$Bconfig);
//		$this->assign("mainlist",$list);
		
		
		//$this->display();
    }
	//普通标详细信息
	public function detail(){
		$jsoncode = file_get_contents("php://input");
		//alogsm("detail",0,1,$jsoncode);
		$arr = array();
		$arr = json_decode($jsoncode,true);
		
		if (!is_array($arr)||empty($arr)||empty($arr['id'])||!in_array($arr['type'],array(3,4,5,6,7))) {
		   ajaxmsg("查询错误！",0);
		}


		$pre = C('DB_PREFIX');
		$id = intval($arr['id']);
		//$id = 30;
		$Bconfig = require C("APP_ROOT")."Conf/borrow_config.php";
		
		
		//borrowinfo
		
		$borrowinfo = M("borrow_info bi")->field('bi.id as bid,bi.*,ac.title,ac.id')->join('lzh_article ac on ac.id= bi.danbao')->where('bi.id='.$id)->find();
		if(!is_array($borrowinfo) || ($borrowinfo['borrow_status']==0 && $this->uid!=$borrowinfo['borrow_uid']) ) ajaxmsg("数据有误",0);
		$borrowinfo['biao'] = $borrowinfo['borrow_times'];
		$borrowinfo['need'] = $borrowinfo['borrow_money'] - $borrowinfo['has_borrow'];
		$borrowinfo['lefttime'] =$borrowinfo['collect_time'] - time();
		$borrowinfo['progress'] = getFloatValue($borrowinfo['has_borrow']/$borrowinfo['borrow_money']*100,2);
		
		//$list['type'] = 1;
		$list['id'] = $id;
		$list['type'] = getleixing($borrowinfo);
		$list['borrow_name'] = $borrowinfo['borrow_name'];
		$list['borrow_money'] = $borrowinfo['borrow_money'];
		$list['borrow_interest_rate'] = $borrowinfo['borrow_interest_rate'];
		$list['repayment_type'] = $borrowinfo['repayment_type'];
		
		if($list['repayment_type']==1){
		    $list['borrow_duration'] = $borrowinfo['borrow_duration']."天";
		}else{
		    $list['borrow_duration'] = $borrowinfo['borrow_duration']."个月";
		}
		$list['huankuan_type'] = $Bconfig['REPAYMENT_TYPE'][$borrowinfo['repayment_type']];
		$list['borrow_use'] = $Bconfig['REPAYMENT_TYPE'][$borrowinfo['borrow_use']];
		$list['borrow_min'] = $borrowinfo['borrow_min'];
		$list['borrow_max'] = $borrowinfo['borrow_max']=="0"?"无":"{$borrowinfo['borrow_max']}";
		$list['progress'] = $borrowinfo['progress'];
		$list['need'] = $borrowinfo['need'];
		if ($borrowinfo['lefttime'] > 0){
		    $left_tian = floor($borrowinfo['lefttime']/ (60 * 60 * 24));
			$left_hour = floor(($borrowinfo['lefttime'] - $left_tian * 24 * 60 * 60)/3600);
			$left_minute = floor(($borrowinfo['lefttime'] - $left_tian * 24 * 60 * 60 - $left_hour * 60 * 60)/60);
			$left_second = floor($borrowinfo['lefttime'] - $left_tian * 24 * 60 * 60 - $left_hour * 60 * 60 - $left_minute *60);
			$list['lefttime'] = $left_tian.",".$left_hour.",".$left_minute.",".$left_second;
		}else {
		    $list['lefttime'] ="已结束";
		}
		$list['borrow_info'] = $borrowinfo['borrow_info'];
		$list['invest_num'] = M("borrow_investor")->where("borrow_id={$id}")->count("id");
		
		$minfo = M("members")->where("id={$borrowinfo['borrow_uid']}")->find();
		$list['user_name'] = $minfo['user_name'];
		$list['imgpath'] = get_avatar($borrowinfo['borrow_uid']);
		$list['addtime'] = date("Y-m-d",$borrowinfo['add_time']);
		if($borrowinfo['reward_type']==1){
		    $list['reward'] = $borrowinfo['reward_num']."%";
		}elseif($borrowinfo['reward_type']==2){
		    $list['reward'] = $borrowinfo['reward_num'];
		}else{
		    $list['reward']="0";
		}
		echo ajaxmsg($list);
		
		
		//评论
		//$cmap['tid'] = $id;
//		$clist = getCommentList($cmap,5);
//		$this->assign("Bconfig",$Bconfig);
//		$this->assign("gloconf",$this->gloconf);
//		$this->assign("commentlist",$clist['list']);
//		$this->assign("commentpagebar",$clist['page']);
//		$this->assign("commentcount",$clist['count']);
//		$this->display();
    }
	//普通标投标记录
	public function investlog(){
	    $jsoncode = file_get_contents("php://input");
		$arr = array();
		$arr = json_decode($jsoncode,true);
		if (!is_array($arr)||empty($arr)||empty($arr['id'])) {
		   ajaxmsg("查询错误！",0);
		}
		$pre = C('DB_PREFIX');
		$id = intval($arr['id']);
		//$id = 16;
		$fieldx = "bi.investor_capital,bi.add_time,m.user_name,bi.is_auto";
		$investinfo = M("borrow_investor bi")->field($fieldx)->join("{$pre}members m ON bi.investor_uid = m.id")->where("bi.borrow_id={$id}")->order("bi.id DESC")->select();
		foreach($investinfo as $key=>$v){
			$list[$key]['user_name'] = $v['user_name'];
			$list[$key]['investor_capital'] = $v['investor_capital'];
			$list[$key]['add_time'] = date("Y-m-d",$v['add_time']);
			
		}
		$_list['list'] = $list;
		if(is_array($list)&&!empty($list)){
		    echo ajaxmsg($_list);
		}else echo ajaxmsg("暂无投标记录",0);
		
	}
	//企业直投投标记录
	public function tinvestlog(){
	    $jsoncode = file_get_contents("php://input");
		$arr = array();
		$arr = json_decode($jsoncode,true);
		if (!is_array($arr)||empty($arr)||empty($arr['id'])) {
		   ajaxmsg("查询错误！",0);
		}
		$pre = C('DB_PREFIX');
		$id = intval($arr['id']);
		$id = 4;
		$fieldx = "bi.investor_capital,bi.add_time,m.user_name,bi.is_auto";
		$fieldx = "bi.investor_capital,bi.transfer_month,bi.transfer_num,bi.add_time,m.user_name,bi.is_auto,bi.final_interest_rate";
		$investinfo = M("transfer_borrow_investor bi")->field($fieldx)->join("{$pre}members m ON bi.investor_uid = m.id")->where("bi.borrow_id={$id}")->order("bi.id DESC")->select();
		foreach($investinfo as $key=>$v){
			$list[$key]['user_name'] = $v['user_name'];
			$list[$key]['investor_capital'] = $v['investor_capital'];
			$list[$key]['add_time'] = date("Y-m-d",$v['add_time']);
			
		}
		$_list['list'] = $list;
		if(is_array($list)&&!empty($list)){
		    echo ajaxmsg($_list);
		}else echo ajaxmsg("暂无投标记录",0);
	}
	
	public function test()
	{
	    //$vm = getMinfo('159',"m.pin_pass,mm.invest_vouch_cuse,mm.money_collect");
		  $vm = getMinfo('159','m.pin_pass,mm.account_money,mm.back_money,mm.money_collect');

	   // $vm = getMinfo($this->uid,"m.pin_pass,mm.invest_vouch_cuse,mm.money_collect");
		$amoney = $vm['account_money']+$vm['back_money'];
		ajaxmsg($vm,1);

	}
	
	public function ajax_invest(){
		
        $jsoncode = file_get_contents("php://input");
		//alogsm("ajax_invest",0,1,session("u_id").$jsoncode);

		if(!$this->uid) {
			ajaxmsg("请先登陆",0);
			exit;
		}
		$arr = array();
		$arr = json_decode($jsoncode,true);
		if (intval($arr['uid'])!=$this->uid){
			ajaxmsg("查询错误！",0);
		}
		if (!is_array($arr)||empty($arr)||empty($arr['id'])||!in_array($arr['type'],array(3,4,5,6,7))) {
		   ajaxmsg("查询错误！",0);
		}
		$pre = C('DB_PREFIX');
		$id=intval($arr['id']);
		//$id=23;
		$Bconfig = require C("APP_ROOT")."Conf/borrow_config.php";
		$field = "id,borrow_uid,borrow_money,borrow_status,borrow_type,has_borrow,has_vouch,borrow_interest_rate,borrow_duration,repayment_type,collect_time,borrow_min,borrow_max,password,borrow_use,money_collect";
		$vo = M('borrow_info')->field($field)->find($id);
		if($this->uid == $vo['borrow_uid']) ajaxmsg("不能去投自己的标",0);
		if($vo['borrow_status'] <> 2) ajaxmsg("只能投正在借款中的标",0);
	
		
		$vo['need'] = $vo['borrow_money'] - $vo['has_borrow'];
		if($vo['need']<0){
			ajaxmsg("投标金额不能超出借款剩余金额",0);
		}
		$vo['lefttime'] =$vo['collect_time'] - time();
		$vo['progress'] = getFloatValue($vo['has_borrow']/$vo['borrow_money']*100,4);//ceil($vo['has_borrow']/$vo['borrow_money']*100);
		$vo['uname'] = M("members")->getFieldById($vo['borrow_uid'],'user_name');
		$time1 = microtime(true)*1000;
		$vm = getMinfo($this->uid,'m.pin_pass,mm.account_money,mm.back_money,mm.money_collect');
		//$vm = getMinfo(159,"m.pin_pass,mm.invest_vouch_cuse,mm.money_collect");
		$amoney = $vm['account_money']+$vm['back_money'];
		//ajaxmsg($amoney);die();
		////////////////////////////////////待收金额限制 2013-08-26  fan///////////////////
		if($binfo['money_collect']>0){
			if($vm['money_collect']<$binfo['money_collect']) {
				ajaxmsg("此标设置有投标待收金额限制，您账户里必须有足够的待收才能投此标",0);
			}
		}
		////////////////////////////////////待收金额限制 2013-08-26  fan///////////////////
		
		////////////////////投标时自动填写可投标金额在投标文本框 2013-07-03 fan////////////////////////
		//ajaxmsg($amoney);die();
		if($amoney<floatval($vo['borrow_min'])){
			ajaxmsg("您的账户可用余额小于本标的最小投标金额限制，不能投标！",0);
		}elseif($amoney>=floatval($vo['borrow_max']) && floatval($vo['borrow_max'])>0){
			$toubiao = intval($vo['borrow_max']);
		}else if($amoney>=floatval($vo['need'])){
			$toubiao = intval($vo['need']);
		}else{
			$toubiao = floor($amoney);
		}
		$vo['toubiao'] =$toubiao;
		////////////////////投标时自动填写可投标金额在投标文本框 2013-07-03 fan////////////////////////
		// $pin_pass = $vm['pin_pass'];
		// $has_pin = (empty($pin_pass))?"no":"yes";
//		$this->assign("has_pin",$has_pin);
//		$this->assign("vo",$vo);
//		$this->assign("account_money",$amoney);
//		$this->assign("Bconfig",$Bconfig);
//		$this->assign("gloconf",$this->gloconf);
//		$data['content'] = $this->fetch();
//		ajaxmsg($data);
        $data['type'] = $arr['type'];
		$data['id'] = $id;
		//$data['has_pin'] = $has_pin=='yes'?1:0;
		$data['borrow_min'] = $vo['borrow_min'];
		$data['borrow_max'] = $vo['borrow_max']=="0"?"无":"{$vo['borrow_max']}";
		$data['need'] = $vo['need'];
		$data['toubiao'] = $vo['toubiao'];
		$data['password'] = empty($vo['password'])?0:1;;
		$data['account_money'] = $amoney;

		
		
		ajaxmsg($data);
	}
	

	public function investcheck(){
		$jsoncode = file_get_contents("php://input");
		//alogsm("investcheck",0,1,session("u_id").$jsoncode);
		if(!$this->uid) {
			ajaxmsg('请先登录',0);
			exit;
		}
		$arr = array();
		$arr = json_decode($jsoncode,true);
		if (!is_array($arr)||empty($arr)||empty($arr['borrow_id'])||!in_array($arr['type'],array(3,4,5,6,7))) {
		   ajaxmsg("查询错误1！",0);
		}
		if (intval($arr['uid'])!=$this->uid){
			ajaxmsg("查询错误2！",0);
		}
		$pre = C('DB_PREFIX');
		//$_pin = $arr['pin'];
		$borrow_id = intval($arr['borrow_id']);
		$money = intval($arr['transamt']);
		//$_pin = "123456";
//		$borrow_id = 23;
//		$money = 100;
       // $pin = md5($_pin);
		$borrow_pass = $arr['borrow_pass'];
		//$vm = getMinfo($this->uid,'m.pin_pass,mm.account_money,mm.back_money,mm.money_collect');
		$vm = getMinfo($this->uid,'m.pin_pass,mm.account_money,mm.back_money,mm.money_collect');
		$amoney = $vm['account_money']+$vm['back_money'];
		$uname = session('u_user_name');
		//$pin_pass = $vm['pin_pass'];
		$amoney = floatval($amoney);
		
		$binfo = M("borrow_info")->field('borrow_money,has_borrow,has_vouch,borrow_max,borrow_min,borrow_type,password,money_collect')->find($borrow_id);
		//if($binfo['has_vouch']<$binfo['borrow_money'] && $binfo['borrow_type'] == 2) ajaxmsg("此标担保还未完成，您可以担保此标或者等担保完成再投标",3);
		if(!empty($binfo['password'])){
			if(empty($borrow_pass)) ajaxmsg("此标是定向标，必须验证投标密码",3);
			else if($binfo['password']<>md5($borrow_pass)) ajaxmsg("投标密码不正确",3);
		}
		////////////////////////////////////待收金额限制 2013-08-26  fan///////////////////
		if($binfo['money_collect']>0){
			if($vm['money_collect']<$binfo['money_collect']) {
				ajaxmsg("此标设置有投标待收金额限制，您账户里必须有足够的待收才能投此标",3);
			}
		}
		////////////////////////////////////待收金额限制 2013-08-26  fan///////////////////
		//投标总数检测
		$capital = M('borrow_investor')->where("borrow_id={$borrow_id} AND investor_uid={$this->uid}")->sum('investor_capital');
		if(($capital+$money)>$binfo['borrow_max']&&$binfo['borrow_max']>0){
			$xtee = $binfo['borrow_max'] - $capital;
			ajaxmsg("您已投标{$capital}元，此投上限为{$binfo['borrow_max']}元，你最多只能再投{$xtee}",3);
		}
		
		$need = $binfo['borrow_money'] - $binfo['has_borrow'];
		$caninvest = $need - $binfo['borrow_min'];
		if( $money>$caninvest && ($need-$money)<>0 ){
			$msg = "尊敬的{$uname}，此标还差{$need}元满标,如果您投标{$money}元，将导致最后一次投标最多只能投".($need-$money)."元，小于最小投标金额{$binfo['borrow_min']}元，所以您本次可以选择<font color='#FF0000'>满标</font>或者投标金额必须<font color='#FF0000'>小于等于{$caninvest}元</font>";
			if($caninvest<$binfo['borrow_min']) $msg = "尊敬的{$uname}，此标还差{$need}元满标,如果您投标{$money}元，将导致最后一次投标最多只能投".($need-$money)."元，小于最小投标金额{$binfo['borrow_min']}元，所以您本次可以选择<font color='#FF0000'>满标</font>即投标金额必须<font color='#FF0000'>等于{$need}元</font>";

			ajaxmsg($msg,3);
		}
		
		if(($need-$money)<0 ){
			$this->error("尊敬的{$uname}，此标还差{$need}元满标,您最多只能再投{$need}元",3);
		}
		
		//if($pin<>$pin_pass) ajaxmsg("支付密码错误，请重试!",0);
		if($money>$amoney){
			$msg = "尊敬的{$uname}，您准备投标{$money}元，但您的账户可用余额为{$amoney}元，请先去充值!";
			ajaxmsg($msg,2);
		}else{
			$msg = "尊敬的{$uname}，您的账户可用余额为{$amoney}元，您确认投标{$money}元吗？";
			$_msg['type'] = 1;
			$_msg['id'] = $borrow_id;
			$_msg['message'] = $msg;
			ajaxmsg($_msg,1);
		}
	}
	
	
	public function investmoney(){
		$jsoncode = file_get_contents("php://input");
		//alogsm("investmoney",0,1,session("u_id").$jsoncode);
		if(!$this->uid) {
			ajaxmsg('请先登录',0);
			exit;
		}
		$arr = array();
		$arr = json_decode($jsoncode,true);
		if (intval($arr['uid'])!=$this->uid){
			ajaxmsg("查询错误！",0);
		}
		if (!is_array($arr)||empty($arr)||empty($arr['borrow_id'])||empty($arr['money'])||!in_array($arr['type'],array(3,4,5,6,7))) {
		   ajaxmsg("查询错误！",0);
		}
		
		$pre = C('DB_PREFIX');
		//$_pin = $arr['pin'];
		//$pin = md5($_pin);
		$borrow_id = intval($arr['borrow_id']);
		$money = intval($arr['transamt']);
//		$_pin = "123456";
//		$pin = md5($_pin);
//		$borrow_id = 23;
//		$money = 60;
//		
		$borrow_pass = $arr['borrow_pass'];
				
		$m = M("member_money")->field('account_money,back_money,money_collect')->find($this->uid);
		$amoney = $m['account_money']+$m['back_money'];
		$uname = session('u_user_name');
		if($amoney<$money) ajaxmsg("尊敬的{$uname}，您准备投标{$money}元，但您的账户可用余额为{$amoney}元，请先去充值再投标.",3);
		
		//$vm = getMinfo($this->uid,'m.pin_pass,mm.account_money,mm.back_money,mm.money_collect');
		//$pin_pass = $vm['pin_pass'];
		
		//if($pin<>$pin_pass) ajaxmsg("支付密码错误，请重试",2);

		$binfo = M("borrow_info")->field('borrow_money,borrow_max,has_borrow,has_vouch,borrow_type,borrow_min,money_collect')->find($borrow_id);
		
		////////////////////////////////////待收金额限制 2013-08-26  fan///////////////////
		if($binfo['money_collect']>0){
			if($m['money_collect']<$binfo['money_collect']) {
				ajaxmsg("此标设置有投标待收金额限制，您账户里必须有足够的待收才能投此标",3);
			}
		}
		////////////////////////////////////待收金额限制 2013-08-26  fan///////////////////
		
		//投标总数检测
		$capital = M('borrow_investor')->where("borrow_id={$borrow_id} AND investor_uid={$this->uid}")->sum('investor_capital');
		if(($capital+$money)>$binfo['borrow_max']&&$binfo['borrow_max']>0){
			$xtee = $binfo['borrow_max'] - $capital;
			ajaxmsg("您已投标{$capital}元，此投上限为{$binfo['borrow_max']}元，你最多只能再投{$xtee}",3);
		}
		//if($binfo['has_vouch']<$binfo['borrow_money'] && $binfo['borrow_type'] == 2) $this->error("此标担保还未完成，您可以担保此标或者等担保完成再投标");
		$need = $binfo['borrow_money'] - $binfo['has_borrow'];
		$caninvest = $need - $binfo['borrow_min'];
		if( $money>$caninvest && ($need-$money)<>0 ){
			$msg = "尊敬的{$uname}，此标还差{$need}元满标,如果您投标{$money}元，将导致最后一次投标最多只能投".($need-$money)."元，小于最小投标金额{$binfo['borrow_min']}元，所以您本次可以选择<font color='#FF0000'>满标</font>或者投标金额必须<font color='#FF0000'>小于等于{$caninvest}元</font>";
			if($caninvest<$binfo['borrow_min']) $msg = "尊敬的{$uname}，此标还差{$need}元满标,如果您投标{$money}元，将导致最后一次投标最多只能投".($need-$money)."元，小于最小投标金额{$binfo['borrow_min']}元，所以您本次可以选择<font color='#FF0000'>满标</font>即投标金额必须<font color='#FF0000'>等于{$need}元</font>";

			ajaxmsg($msg,3);
		}
		if(($need-$money)<0 ){
			ajaxmsg("尊敬的{$uname}，此标还差{$need}元满标,您最多只能再投{$need}元",3);
		}else{
			/////////////////////////////////////////////////////汇付托管 2014-10-09///////////////////////////////////////////////////////////////
			$pre = C('DB_PREFIX');
			$info1 = M("huifulog")->distinct(true)->field("usrid")->where("uid=".$this->uid)->find();
			$info2 = M("huifulog h")->distinct(true)->field("h.usrid")->join("{$pre}borrow_info s ON s.borrow_uid=h.uid")->where("s.id = $borrow_id")->find();
			$usrid = $info1['usrid'];
			$borrowerid = $info2['usrid'];
			$transamt = $money;
			$type = "S";//表示散标
			$borrowid = $borrow_id;
			import("ORG.Huifu.Huifu");
			$huifu = new Huifu();
			$huifu->initiativeTender($usrid,$transamt,$borrowerid,$type,$borrowid);
			/////////////////////////////////////////////////////汇付托管 END///////////////////////////////////////////////////////////////
			//$done = investMoney($this->uid,$borrow_id,$money);
		}
		
		//$this->display("Public:_footer");
		//$this->assign("waitSecond",1000);
		/*if($done===true) {
			$_msg['type'] = $arr['type'];
			$_msg['id'] = $borrow_id;
			$_msg['message'] = "恭喜成功投标{$money}元";
			ajaxmsg($_msg,1);
			
		}else if($done){
			ajaxmsg($done,3);
		}else{
			ajaxmsg("对不起，投标失败，请重试!",3);
		}*/
	}
	
	public function tdetail(){
		
        $jsoncode = file_get_contents("php://input");
		//alogsm("tdetail",0,1,session("u_id").$jsoncode);
		$arr = array();
		$arr = json_decode($jsoncode,true);
		if (!is_array($arr)||empty($arr)||empty($arr['id'])||$arr['type']!=2) {
		   ajaxmsg("查询错误！",0);
		}
		if (intval($arr['uid'])!=$this->uid){
			ajaxmsg("查询错误！",0);
		}

		$pre = C('DB_PREFIX');
		$id = intval($arr['id']);
		//$id = 4;
		$Bconfig = require C("APP_ROOT")."Conf/borrow_config.php";

		//borrowinfo
		//$borrowinfo = M("borrow_info")->field(true)->find($id);
		
		//d//$borrowinfo = M("transfer_borrow_info b")->join("{$pre}transfer_detail d ON d.borrow_id=b.id")->field(true)->find($id);
		//a
		$borrowinfo = M("borrow_info bi")->field('bi.*,ac.title,ac.id as aid')->join('lzh_article ac on ac.id= bi.danbao')->where('bi.id='.$id)->find();
		/*if(!is_array($borrowinfo) || $borrowinfo['is_show'] == 0){
			$this->error("数据有误或此标已认购完");
		}*/
		//$borrowinfo['progress'] = getfloatvalue($borrowinfo['transfer_out']/$borrowinfo['transfer_total'] * 100, 2);
		//$borrowinfo['need'] = getfloatvalue(($borrowinfo['transfer_total'] - $borrowinfo['transfer_out'])*$borrowinfo['per_transfer'], 2 );
		$borrowinfo['updata'] = unserialize($borrowinfo['updata']);
		$list['type'] = 2;
		$list['borrow_name'] = $borrowinfo['borrow_name'];
		$list['id'] = $id;
		$list['borrow_interest_rate'] = $borrowinfo['borrow_interest_rate'];
		$list['borrow_duration'] = $borrowinfo['borrow_duration']."个月";
		$list['deadline'] = date("Y-m-d",$borrowinfo['deadline']);
		//$minfo = M("members")->where("id={$borrowinfo['borrow_uid']}")->find();
		$minfo = M("members m")->field("m.id,m.customer_name,m.customer_id,m.user_name,m.reg_time,m.credits,fi.*,mi.*,mm.*")->join("{$pre}member_financial_info fi ON fi.uid = m.id")->join("{$pre}member_info mi ON mi.uid = m.id")->join("{$pre}member_money mm ON mm.uid = m.id")->where("m.id={$borrowinfo['borrow_uid']}")->find();

		$list['credits']=$minfo['credits'];
		$list['borrow_money'] = $borrowinfo['borrow_money'];
		if($borrowinfo['danbao']!=0 ){
			$danbao = M('article')->field("id,title")->where("type_id =7 and id ={$borrowinfo['danbao']}")->find();
			$borrowinfo['danbao']=$danbao['title'];//担保机构
		}else{
			$borrowinfo['danbao']='暂无担保机构';//担保机构
		}
		$list['danbao']=$borrowinfo['danbao'];
		$list['borrow_status']=$borrowinfo['borrow_status'];
		$list['repayment_type']=$Bconfig['REPAYMENT_TYPE'][$borrowinfo['repayment_type']];

		$list['need'] = $borrowinfo['borrow_money'] - $borrowinfo['has_borrow'];
		$list['swf_data']=$borrowinfo['swf_data'];
		$list['borrow_use_text']=$borrowinfo['borrow_use_text'];
		$list['guarantee_comment']=$borrowinfo['guarantee_comment'];
		$list['flat_comment_yijing']=$borrowinfo['flat_comment_yijing'];
		$list['imgpath'] = get_avatar($borrowinfo['borrow_uid']);
		$list['progress'] = getFloatValue($borrowinfo['has_borrow']/$borrowinfo['borrow_money']*100,2);
		$list['b_img'] = $borrowinfo['topic'];
		//$list['b_img'] = $borrowinfo['b_img'];
		//$list['b_img'] = $borrowinfo['b_img'];
		// $list['transfer_out'] = $borrowinfo['transfer_out'];
		// $list['per_transfer'] = $borrowinfo['per_transfer'];
		// $list['progress'] = $borrowinfo['progress'];
		// $list['borrow_max'] = $borrowinfo['borrow_max'];
		// $list['transfer_total'] = $borrowinfo['transfer_total'];
		// $list['transfer_leave'] = $borrowinfo['transfer_total']-$borrowinfo['transfer_out'];
		// $list['transfer_back'] = $borrowinfo['transfer_back'];
		// $list['borrow_breif'] = $borrowinfo['borrow_breif'];
		// $list['reward'] = $borrowinfo['reward_rate']."%";
		// $list['min_month'] = $borrowinfo['min_month'];
		// $list['huankuan_type'] = "一次性还款";
		// $minfo = M("members")->where("id={$borrowinfo['borrow_uid']}")->find();
		// $list['user_name'] = $minfo['user_name'];
		// $list['imgpath'] = get_avatar($borrowinfo['borrow_uid']);
	    $list['addtime'] = date("Y-m-d",$borrowinfo['add_time']);
		ajaxmsg($list);
		// $borrowinfo['biao'] = $borrowinfo['borrow_times'];
		//$borrowinfo['need'] = $borrowinfo['borrow_money'] - $borrowinfo['has_borrow'];
		// $borrowinfo['lefttime'] =$borrowinfo['collect_time'] - time();
		// $borrowinfo['progress'] = getFloatValue($borrowinfo['has_borrow']/$borrowinfo['borrow_money']*100,2);
		// $borrowinfo['deadline'] = date("Y-m-d",$borrowinfo['deadline']);
		
    }
    	public function tajax_invest()
    	{
    		$jsoncode=file_get_contents("php://input");
    		if(!$this->uid) {
			ajaxmsg("请先登陆",0);
			exit;
			}
		$arr = array();
		$arr = json_decode($jsoncode,true);
		if (intval($arr['uid'])!=$this->uid){
			ajaxmsg("查询错误！",0);
		}
		if (!is_array($arr)||empty($arr)||empty($arr['borrow_id'])||$arr['type']!=2) {
		   ajaxmsg("查询错误！",0);
		}
		$pre = C('DB_PREFIX');
		$id=intval( $arr['borrow_id'] );
		//$investMoney = intval($_GET['num']);
		$field = "id,borrow_uid,borrow_money,borrow_status,borrow_type,has_borrow,has_vouch,borrow_interest_rate,borrow_duration,repayment_type,collect_time,borrow_min,borrow_max,password,borrow_use,money_collect";
		$vo = M('borrow_info')->field($field)->find($id);
		if($this->uid == $vo['borrow_uid']) ajaxmsg("不能去投自己的标",0);
		if($vo['borrow_status'] <> 2) ajaxmsg("只能投正在借款中的标",0);
		
		////////////////////////////////////待收金额限制 2013-08-26  fan///////////////////
		// if($binfo['money_collect']>0){
		// 	if($vm['money_collect']<$binfo['money_collect']) {
		// 		ajaxmsg("此标设置有投标待收金额限制，您账户里必须有足够的待收才能投此标",3);
		// 	}
		// }
		////////////////////////////////////待收金额限制 2013-08-26  fan///////////////////
		//$vm = getMinfo($this->uid,'m.pin_pass,mm.account_money,mm.back_money,mm.money_collect');
		
		//$pin_pass = $vm['pin_pass'];
		//$has_pin = (empty($pin_pass))?"no":"yes";
		// $this->assign("has_pin",$has_pin);
		// $this->assign("investMoney",$investMoney);
		// $this->assign("vo",$vo);
		//$data['content'] = $this->fetch();
		$list['type'] = 2;
		$list['id'] = $id;
		$borrowinfo = M("borrow_info bi")->field('bi.*,ac.title,ac.id as aid')->join('lzh_article ac on ac.id= bi.danbao')->where('bi.id='.$id)->find();
		$list['need']=$borrowinfo['borrow_money'] - $borrowinfo['has_borrow'];
		$vm = getMinfo($this->uid,'m.pin_pass,mm.account_money,mm.back_money,mm.money_collect');
		$amoney = $vm['account_money']+$vm['back_money'];
		$list['account_money'] = $amoney;//可用余额
		ajaxmsg($list);


    	}
	
		public function tajax_invest_bak()	{
				
        $jsoncode = file_get_contents("php://input");
		//alogsm("tajax_invest",0,1,session("u_id").$jsoncode);
		if(!$this->uid) {
			ajaxmsg("请先登陆",0);
			exit;
		}
		$arr = array();
		$arr = json_decode($jsoncode,true);
		if (intval($arr['uid'])!=$this->uid){
			ajaxmsg("查询错误！",0);
		}
		if (!is_array($arr)||empty($arr)||empty($arr['borrow_id'])||$arr['type']!=2) {
		   ajaxmsg("查询错误！",0);
		}


		$pre = c( "DB_PREFIX" );
		$id = intval( $arr['borrow_id'] );

//		$id = 4;
//		$num = 3;
//      $month = 9;
		$Bconfig = require( C("APP_ROOT" )."Conf/borrow_config.php" );
		$field = "id,borrow_uid,borrow_money,borrow_interest_rate,borrow_duration,repayment_type,transfer_out,transfer_back,transfer_total,per_transfer,is_show,deadline,min_month,increase_rate,reward_rate";
		$vo = M("transfer_borrow_info" )->field($field)->find($id);
		if ($this->uid == $vo['borrow_uid'])
		{
			ajaxmsg("不能息投自己的标", 0);
		}
		// if ($vo['transfer_out'] == $vo['transfer_total'])
		// {
		// 	ajaxmsg( "此标可认购份数为0", 0 );
		// }
		if ($vo['is_show'] == 0)
		{
			ajaxmsg( "只能投正在借款中的标", 0 );
		}
		$vo['transfer_leve'] = $vo['transfer_total'] - $vo['transfer_out'];
		$vo['uname'] = M("members")->getFieldById($vo['borrow_uid'], "user_name");
		//$vm = getMinfo($this->uid,'m.pin_pass,mm.account_money,mm.back_money,mm.money_collect');
		$amoney = $vm['account_money']+$vm['back_money'];
		//$pin_pass = $vm['pin_pass'];
		//$has_pin = empty( $pin_pass ) ? 0 : 1;
		
//		$this->assign( "has_pin", $has_pin );
//		$this->assign( "vo", $vo );
//		$this->assign( "account_money", $amoney);
//		$this->assign( "Bconfig", $Bconfig );
//		$this->assign( "num", $num );
		
		
		
//		$list['uname'] = $vo['uname'];
//		$list['borrow_money'] = $vo['borrow_money'];
		$rate = $vo['borrow_interest_rate'];
//		$list['transfer_total'] = $vo['transfer_total'];
//		$list['transfer_out'] = $vo['transfer_out'];
//		$list['transfer_leave'] = $vo['transfer_total']-$vo['transfer_out'];
//		$list['borrow_duration'] = $vo['borrow_duration'];
		

		
		$list['type'] = 2;
		$list['id'] = $id;
		//$list['has_pin'] = $has_pin ;//是否设置支付密码
		$list['account_money'] = $amoney;//可用余额
		$list['min_month'] = $vo['min_month'];//最小认购期限
		$list['borrow_duration'] = $vo['borrow_duration'];//最大认购期限
		$list['transfer_leave'] = $vo['transfer_total']-$vo['transfer_out'];//剩余多少份
		$list['per'] = $vo['per_transfer'];//每份多少钱
		
		// if($has_pin == 0){
		//     ajaxmsg("投标前请先设置支付密码", 0);
		// }
//		$total = $num*$per;
//		$interest_rate = $rate+($month-$min_month)*$increase_rate;
//	    $interest = $interest_rate*$total*$month/(12*100);
//	    $reward = $reward_rate*$total*$month/100;
//		
//		$list['except_income'] = $interest+$reward;
//	    $list['interest_income'] = $interest;
//	    $list['reward_income'] = $reward;
//		$list['month'] = $month;
//		$list['num'] = $num;
//		$list['total'] = $total;
//		$list['rate'] = $interest_rate;
		
		ajaxmsg($list);
	}
	public function tinvestcheck()
	{
			$jsoncode = file_get_contents("php://input");
		//alogsm("tinvestcheck",0,1,session("u_id").$jsoncode);
		if(!$this->uid) {
			ajaxmsg('请先登录',0);
			exit;
		}
		$arr = array();
		$arr = json_decode($jsoncode,true);
		if (intval($arr['uid'])!=$this->uid){
			ajaxmsg("查询错误！",0);
		}
		if (!is_array($arr)||empty($arr)||empty($arr['borrowercustid'])||empty($arr['transamt'])||$arr['type']!=2) {
		   ajaxmsg("查询错误！",0);
		}
		$pre = C("DB_PREFIX");


		//$pin = md5($_POST['pin']);
		$borrow_id = $arr['borrowercustid'];
		$money = $arr['transamt'];
		$vm = getMinfo($this->uid,'m.pin_pass,mm.account_money,mm.back_money,mm.money_collect');
		$amoney = $vm['account_money']+$vm['back_money'];
		$uname = session('u_user_name');
		//$pin_pass = $vm['pin_pass'];
		$amoney = floatval($amoney);
		$uid = $this->uid;
		$binfo = M("borrow_info")->field('borrow_money,has_borrow,has_vouch,borrow_max,borrow_min,borrow_type,password,money_collect,borrow_uid')->find($borrow_id);
		// if(!empty($binfo['password'])){
		// 	if(empty($_POST['borrow_pass'])) ajaxmsg("此标是定向标，必须验证投标密码",3);
		// 	else if($binfo['password']<>md5($_POST['borrow_pass'])) ajaxmsg("投标密码不正确",3);
		// }
		////////////////////////////////////待收金额限制 2013-08-26  fan///////////////////
		if($binfo['money_collect']>0){
			if($vm['money_collect']<$binfo['money_collect']) {
				ajaxmsg("此标设置有投标待收金额限制，您账户里必须有足够的待收才能投此标",3);
			}
		}
		//限制投标不能为0元
		////////////////////////////////////待收金额限制 2013-08-26  fan///////////////////
		//投标总数检测
		$capital = M('borrow_investor')->where("borrow_id={$borrow_id} AND investor_uid={$this->uid}")->sum('investor_capital');
		if(($capital+$money)>$binfo['borrow_max']&&$binfo['borrow_max']>0){
			$xtee = $binfo['borrow_max'] - $capital;
			ajaxmsg("您已投标{$capital}元，此投上限为{$binfo['borrow_max']}元，你最多只能再投{$xtee}",3);
		}
		if($uid == $binfo['borrow_uid']){
			ajaxmsg("不能投资自己的借款标",3);
		}
		$need = $binfo['borrow_money'] - $binfo['has_borrow'];
		$caninvest = $need - $binfo['borrow_min'];
		if( $money>$caninvest && ($need-$money)<>0 ){
			$msg = "尊敬的{$uname}，此标还差{$need}元满标,如果您投标{$money}元，将导致最后一次投标最多只能投".($need-$money)."元，小于最小投标金额{$binfo['borrow_min']}元，所以您本次可以选择<font color='#FF0000'>满标</font>或者投标金额必须<font color='#FF0000'>小于等于{$caninvest}元</font>";
			if($caninvest<$binfo['borrow_min']) $msg = "尊敬的{$uname}，此标还差{$need}元满标,如果您投标{$money}元，将导致最后一次投标最多只能投".($need-$money)."元，小于最小投标金额{$binfo['borrow_min']}元，所以您本次可以选择<font color='#FF0000'>满标</font>即投标金额必须<font color='#FF0000'>等于{$need}元</font>";

			ajaxmsg($msg,3);
		}
		if(($binfo['borrow_min']-$money)>0 ){
		
			ajaxmsg("尊敬的{$uname}，本标最低投标金额为{$binfo['borrow_min']}元，请重新输入投标金额",3);
			//$this->error("尊敬的{$uname}，本标最低投标金额为{$binfo['borrow_min']}元，请重新输入投标金额",3);
		}
		if(($need-$money)<0 ){
			$this->error("尊敬的{$uname}，此标还差{$need}元满标,您最多只能再投{$need}元",3);
		}
		
		//if($pin<>$pin_pass) ajaxmsg("支付密码错误，请重试!",0);
		if($money>$amoney){
			$msg = "尊敬的{$uname}，您准备投标{$money}元，但您的账户可用余额为{$amoney}元，您要先去充值吗？";
			ajaxmsg($msg,2);
		}else{
			$msg = "尊敬的{$uname}，您的账户可用余额为{$amoney}元，您确认投标{$money}元吗？";
			$_msg['message'] = $msg;
			$_msg['type'] = 2;
			$_msg['id'] = $borrow_id;
			ajaxmsg($_msg,1);
		}
	}
	public function tinvestcheck_bak()
	{
		$jsoncode = file_get_contents("php://input");
		//alogsm("tinvestcheck",0,1,session("u_id").$jsoncode);
		if(!$this->uid) {
			ajaxmsg('请先登录',0);
			exit;
		}
		$arr = array();
		$arr = json_decode($jsoncode,true);
		if (intval($arr['uid'])!=$this->uid){
			ajaxmsg("查询错误！",0);
		}
		if (!is_array($arr)||empty($arr)||empty($arr['borrow_id'])||empty($arr['num'])||empty($arr['month'])||$arr['type']!=2) {
		   ajaxmsg("查询错误！",0);
		}

		
		
		$pre = C("DB_PREFIX");
		
        //$_pin = $arr['pin'];
		$_borrow_id = $arr['borrow_id'];
		$_tnum = $arr['num'];
		$_month = $arr['month'];
		
//		$_pin = "123456";
//		$_borrow_id = 4;
//		$_tnum = 3;
//		$_month = 3;
		
		//$pin = md5($_pin);
		$borrow_id = intval($_borrow_id);
		$tnum = intval($_tnum);
		$month = intval($_month);
		$m = M("member_money")->field('account_money,back_money,money_collect')->find($this->uid);
		$amoney = $m['account_money']+$m['back_money'];
		$uname = session("u_user_name");
		//$vm = getMinfo($this->uid,"m.pin_pass");
		//$pin_pass = $vm['pin_pass'];
		$amoney = floatval($amoney);
		$binfo = M("transfer_borrow_info")->field( "transfer_out,transfer_back,transfer_total,per_transfer,is_show,deadline,min_month,increase_rate,reward_rate,borrow_duration")->find($borrow_id);
		$max_month = $binfo['borrow_duration'];//getTransferLeftmonth($binfo['deadline']);
		$min_month = $binfo['min_month'];
		$max_num = $binfo['transfer_total'] - $binfo['transfer_out'];
		if($month < $min_month || $max_month < $month)
		{
			ajaxmsg("本标认购期限只能在'".$min_month."个月---".$max_month."个月'之间", 3);
		}
		if ($max_num < $tnum)
		{
			ajaxmsg( "本标还能认购最大份数为".$max_num."份，请重新输入认购份数", 3 );
		}
		$money = $binfo['per_transfer'] * $tnum;
		// if ($pin != $pin_pass)
		// {
		// 	ajaxmsg( "支付密码错误，请重试", 0);
		// }
		if ($amoney < $money)
		{
			$msg = "尊敬的{$uname}，您准备认购{$money}元，但您的账户可用余额为{$amoney}元，您要先去充值吗？";
			ajaxmsg($msg, 2);
		}
		else
		{
			$msg = "尊敬的{$uname}，您的账户可用余额为{$amoney}元，您确认认购{$money}元吗？";
			$_msg['type'] = 2;
			$_msg['id'] = $borrow_id;
			$_msg['message'] = $msg;
			ajaxmsg($_msg, 1);
		}
	}
	
	public function tinvestmoney()
	{
		$jsoncode = file_get_contents("php://input");
		//alogsm("tinvestmoney",0,1,session("u_id").$jsoncode);
		if(!$this->uid) {
			ajaxmsg('请先登录',0);
			exit;
		}
		$arr = array();
		$arr = json_decode($jsoncode,true);
		if (intval($arr['uid'])!=$this->uid){
			ajaxmsg("查询错误！",0);
		}
		if (!is_array($arr)||empty($arr)||empty($arr['borrow_id'])||empty($arr['num'])||empty($arr['month'])||$arr['type']!=2) {
		   ajaxmsg("查询错误！",0);
		}

		
       // $_pin = $arr['pin'];
		$_borrow_id = $arr['borrow_id'];
		$_tnum = $arr['num'];
		$_month = $arr['month'];
		
//		$_pin = "1234567";
//		$_borrow_id = 4;
//		$_tnum = 3;
//		$_month = 3;

		$borrow_id = intval($_borrow_id);
		$tnum = intval($_tnum);
		$month = intval($_month);
		$m = M("member_money")->field('account_money,back_money,money_collect')->find($this->uid);
		$amoney = $m['account_money']+$m['back_money'];
		$uname = session("u_user_name");
		$binfo = M("transfer_borrow_info")->field( "borrow_uid,borrow_interest_rate,transfer_out,transfer_back,transfer_total,per_transfer,is_show,deadline,min_month,increase_rate,reward_rate,borrow_duration")->find($borrow_id);
		
		if($this->uid == $binfo['borrow_uid']) ajaxmsg("不能去投自己的标",0);
		$max_month = $binfo['borrow_duration'];//getTransferLeftmonth($binfo['deadline']);
		$min_month = $binfo['min_month'];
		$max_num = $binfo['transfer_total'] - $binfo['transfer_out'];
		if($month < $min_month || $max_month < $month){
			ajaxmsg( "本标认购期限只能在'".$min_month."个月---".$max_month."个月'之间",3);
			
		}
		if($max_num < $tnum){
			ajaxmsg( "本标还能认购最大份数为".$max_num."份，请重新输入认购份数",3);
			
		}
		$money = $binfo['per_transfer'] * $tnum;
		if($amoney < $money){
			ajaxmsg( "尊敬的{$uname}，您准备认购{$money}元，但您的账户可用余额为{$amoney}元，请先去充值再认购.",__APP__."/member/charge#fragment-1",2);
			
		}
		//$vm = getMinfo($this->uid,"m.pin_pass,mm.invest_vouch_cuse,mm.money_collect");
		//$pin_pass = $vm['pin_pass'];
		//$pin = md5($_pin);
		// if ($pin != $pin_pass){
		// 	ajaxmsg( "支付密码错误，请重试",0);
			
		// }
		$done = TinvestMoney($this->uid,$borrow_id,$tnum,$month);//投企业直投
		if($done === true){
			
			$_msg['type'] = 2;
			$_msg['id'] = $borrow_id;
			$_msg['message'] = "恭喜成功认购{$tnum}份,共计{$money}元";
			ajaxmsg($_msg,1);
			
		}else if($done){
			ajaxmsg($done,3);
		}else{
			ajaxmsg("对不起，认购失败，请重试!",3);
			
		}
	}
	
	public function gg_list() {
	    
		
		 
       $id = M('article_category')->where("type_name = '网站公告'")->getField('id');
       $list=M('article')->where("type_id = {$id} ")->order('id desc')->limit('10')->select();
	   foreach ($list as $key=>$v){
		 $_list[$key]['id'] = $v['id'];
	     $_list[$key]['title'] = $v['title'];
	     $_list[$key]['art_time'] = date("Y-m-d",$v['art_time']);
	   }
	   $m_list['list']= $_list;
	   ajaxmsg($m_list);
		
	}
	public function gg_list_add() {
	    $jsoncode = file_get_contents("php://input");
		//alogsm("gg_list_add",0,1,$jsoncode);

		$arr = array();
		$arr = json_decode($jsoncode,true);
		if (!is_array($arr)||empty($arr)||empty($arr['id'])||empty($arr['num'])) {
		   ajaxmsg("查询错误！",0);
		}
		$num = $arr['num'];
		$id = $arr['id'];
//		$num = 3;
//		$id = 151;
       $listid = M('article_category')->where("type_name = '网站公告'")->getField('id');
       $list=M('article')->where("type_id = {$listid} and id > {$id}")->order('id')->limit("{$num}")->select();
	   foreach ($list as $key=>$v){
		 $_list[$key]['id'] = $v['id'];
	     $_list[$key]['title'] = $v['title'];
	     $_list[$key]['art_time'] = date("Y-m-d",$v['art_time']);
	   }
	   $m_list['list']= $_list;
	   if(is_array($m_list['list'])){
	       ajaxmsg($m_list);
	   }else{
	       ajaxmsg();
	   }
		
	}
	public function gg_show() {
	   //$id = 100;
		$jsoncode = file_get_contents("php://input");
		//alogsm("gg_show",0,1,$jsoncode);
		
		$arr = array();
		$arr = json_decode($jsoncode,true);
//		if (!is_array($arr)||empty($arr)||empty($arr['id'])) {
//		   ajaxmsg("查询错误！",0);
//		}
        $id = $arr["id"];
        $content=M('article')->find($id);
		$_content['id'] = $content['id'];
		$_content['title'] = $content['title'];
		$_content['art_time'] = date("Y-m-d H:i",$content['art_time']);
		$_content['art_content'] = $content['art_content'];
        ajaxmsg($_content);
		
		
	}
	//检测是否可以更新新版本
	public function version(){
		$jsoncode = file_get_contents("php://input");
		//alogsm("version",0,1,$jsoncode);
		$arr = array();
		$arr = json_decode($jsoncode,true);
		$datag = get_global_setting();
		$newversion = $datag['apkversion'];
		if(is_array($arr)&&(!empty($arr))&&(!empty($arr['version']))&&((float)$arr['version'])<((float)$newversion)){
		    $content['path'] = $datag['apkpath'];
			ajaxmsg($content,0);
		}else{
		    ajaxmsg();
		}
		
	}
}
