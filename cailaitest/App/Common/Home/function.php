						<?php
						//新手标
						function getNewBorrowList($parm=array()){
						if(empty($parm['map'])) return;
						$map= $parm['map'];
						$orderby= $parm['orderby'];
						if($parm['pagesize']){
						//分页处理
						import("ORG.Util.Page");
						$count = M('borrow_info b')->where($map)->count('b.id');
						$p = new Page($count, $parm['pagesize']);
						$page = $p->show();
						$Lsql = "{$p->firstRow},{$p->listRows}";
						//分页处理
						}else{
						$page="";
						$Lsql="{$parm['limit']}";
						}
						
						$pre = C('DB_PREFIX');
						$suffix=C("URL_HTML_SUFFIX");
						$field = "b.id,b.borrow_name,b.borrow_type,b.borrow_status,b.borrow_money,b.borrow_min,b.borrow_max,b.borrow_interest_rate,b.borrow_duration,b.repayment_type,b.collect_time,b.add_time,b.has_borrow,b.deadline,b.toubiao_telephone";
						$list = M('borrow_info b')->field($field)->where($map)->order($orderby)->limit($Lsql)->select();	
						foreach($list as $key=>$v){
						$list[$key]['progress'] = getFloatValue($v['has_borrow']/$v['borrow_money']*100,2);
						$list[$key]['burl'] = MU("Home/invest","invest",array("id"=>$v['id'],"suffix"=>$suffix));		
						
						}
						$row=array();
						$row['list'] = $list;
						$row['page'] = $page;
						return $row;
						}
						//新手标 by lj  2015-09-08
						function getNewBie($parm=array())
						{
							if(empty($parm['map'])) return;
						$map= $parm['map'];
						$orderby= $parm['orderby'];
						if($parm['pagesize']){
						//分页处理
						import("ORG.Util.Page");
						$count = M('newbie_bid b')->where($map)->count('b.id');
						$p = new Page($count, $parm['pagesize']);
						$page = $p->show();
						$Lsql = "{$p->firstRow},{$p->listRows}";
						//分页处理
						}else{
						$page="";
						$Lsql="{$parm['limit']}";
						}
						
						$pre = C('DB_PREFIX');
						$suffix=C("URL_HTML_SUFFIX");
						$field = "b.id,b.bidname,b.borrow_uid,b.bidtime,b.rate";
						$list = M('newbie_bid b')->field($field)->where($map)->order($orderby)->limit($Lsql)->select();	
						$row=array();
						$row['list'] = $list;
						$row['page'] = $page;
						return $row;
						}
						
						
						//获取借款列表
						function getBorrowList($parm=array()){
						if(empty($parm['map'])) return;
						$map= $parm['map'];
						$orderby= $parm['orderby']."borrow_money-has_borrow DESC ,id DESC";
						if($parm['pagesize']){
						//分页处理
						import("ORG.Util.Page");
						$count = M('borrow_info b')->where($map)->count('b.id');
						// return $sql= M()->getLastSql();
						//  die;
						$p = new Page($count, $parm['pagesize']);
						$page = $p->show();
						$Lsql = "{$p->firstRow},{$p->listRows}";
						//分页处理
						}else{
						$page="";
						$Lsql="{$parm['limit']}";
						}
						$pre = C('DB_PREFIX');
						$suffix=C("URL_HTML_SUFFIX");
						
						$field = "b.id,b.borrow_name,b.borrow_type,b.reward_type,b.borrow_times,b.borrow_status,b.borrow_money,b.borrow_use,b.repayment_type,b.borrow_min,b.borrow_interest_rate,b.borrow_mortgage_rate,b.borrow_duration,b.collect_time,b.add_time,b.province,b.has_borrow,b.has_vouch,b.city,b.area,b.reward_type,b.reward_num,b.password,m.user_name,m.id as uid,m.credits,m.customer_name,b.is_tuijian,b.deadline,b.danbao,b.borrow_info,b.risk_control,b.toubiao_telephone";
						//	$field = "b.id,b.borrow_name,b.borrow_type,b.reward_type,b.borrow_times,b.borrow_status,b.borrow_money,b.borrow_use,b.repayment_type,b.borrow_min,b.borrow_interest_rate,b.borrow_duration,b.collect_time,b.add_time,b.province,b.has_borrow,b.has_vouch,b.city,b.area,b.reward_type,b.reward_num,b.password,m.user_name,m.id as uid,m.credits,m.customer_name,b.is_tuijian,b.deadline,b.danbao,b.borrow_info,b.risk_control";
						$list = M('borrow_info b')->field($field)->join("{$pre}members m ON m.id=b.borrow_uid")->where($map)->order($orderby)->limit($Lsql)->select();
						//ORDER BY borrow_money-has_borrow DESC ,id DESC
						// echo M()->getLastSql();
						// die;
						$areaList = getArea();
						foreach($list as $key=>$v){
						
						if(strlen($v['toubiao_telephone']) >= 11){
						$userTelephone = $_SESSION['u_user_name'];
						if(strpos($v['toubiao_telephone'],$userTelephone) !== false){
						//此标是否在前端显示
						$list[$key]['zw_show'] = 1;
						}else{
						$list[$key]['zw_show'] = 0;
						}
						}else{
						$list[$key]['zw_show'] = 1;
						}
						
						
						$list[$key]['location'] = $areaList[$v['province']].$areaList[$v['city']];
						$list[$key]['biao'] = $v['borrow_times'];
						$list[$key]['need'] = $v['borrow_money'] - $v['has_borrow'];
						$list[$key]['leftdays'] = getLeftTime($v['collect_time']);
						$list[$key]['progress'] = getFloatValue($v['has_borrow']/$v['borrow_money']*100,2);
						$list[$key]['vouch_progress'] = getFloatValue($v['has_vouch']/$v['borrow_money']*100,2);
						$list[$key]['burl'] = MU("Home/invest","invest",array("id"=>$v['id'],"suffix"=>$suffix));
						
						//新加
						$list[$key]['lefttime']=$v['collect_time']-time();
						
						if($v['deadline']==0){
						$endTime = strtotime(date("Y-m-d",time()));
						if($v['repayment_type']==1) {
						$list[$key]['repaytime'] = strtotime("+{$v['borrow_duration']} day",$endTime);
						}else {
						$list[$key]['repaytime'] = strtotime("+{$v['borrow_duration']} month",$endTime);
						}
						}else{
						$list[$key]['repaytime']=$v['deadline'];//还款时间
						}
						
						$list[$key]['publishtime']=$v['add_time']+60*60*24*3;//预计发标时间=添加时间+1天
						
						if($v['danbao']!=0 ){
						$danbao = M('article')->field("id,title")->where("type_id =7 and id ={$v['danbao']}")->find();
						$list[$key]['danbao']=$danbao['title'];//担保机构
						}else{
						$list[$key]['danbao']='暂无担保机构';//担保机构
						}
						
						}
						$row=array();
						$row['list'] = $list;
						$row['page'] = $page;
						$row['count']=$count;
						return $row;
						}
						
						//获取特定栏目下文章列表
						function getArticleList($parm){
						if(empty($parm['type_id'])) return;
						//$map['type_id'] = $parm['type_id'];
						$type_id= intval($parm['type_id']);
						$Allid = M("article_category")->field("id")->where("parent_id = {$type_id}")->select();
						$newlist = array();
						array_push($newlist,$parm['type_id']);
						
						foreach ($Allid as $ka => $v) {
						array_push($newlist,$v["id"]);
						}
						$map['type_id']= array("in",$newlist);
						
						$Osql="sort_order desc,id DESC";//id DESC,
						$field="id,title,art_set,art_time,art_url,art_img,art_info";
						//查询条件 
						if($parm['pagesize']){
						//分页处理
						import("ORG.Util.Page");
						$count = M('article')->where($map)->count('id');
						$p = new Page($count, $parm['pagesize']);
						$page = $p->show();
						$Lsql = "{$p->firstRow},{$p->listRows}";
						//分页处理
						}else{
						$page="";
						$Lsql="{$parm['limit']}";
						}
						
						$data = M('article')->field($field)->where($map)->order($Osql)->limit($Lsql)->select();
						
						$suffix=C("URL_HTML_SUFFIX");
						$typefix = get_type_leve_nid($map['type_id']);
						$typeu = implode("/",$typefix);
						foreach($data as $key=>$v){
						if($v['art_set']==1) $data[$key]['arturl'] = (stripos($v['art_url'],"http://")===false)?"http://".$v['art_url']:$v['art_url'];
						//elseif(count($typefix)==1) $data[$key]['arturl'] = 
						else $data[$key]['arturl'] = MU("Home/{$typeu}","article",array("id"=>$v['id'],"suffix"=>$suffix));
						}
						$row=array();
						$row['list'] = $data;
						$row['page'] = $page;
						
						return $row;
						}
						
						//获取特定栏目下文章列表 $parm['pagesize']=15;
						//               $parm['type_id']=$typeid;
						function zwgetArticleList($parm){
						if(empty($parm['type_id'])) return;
						//$map['type_id'] = $parm['type_id'];
						$type_id= intval($parm['type_id']);
						$Allid = M("article_category")->field("id")->where("parent_id = {$type_id}")->select();
						$newlist = array();
						array_push($newlist,$parm['type_id']);
						
						foreach ($Allid as $ka => $v) {
						array_push($newlist,$v["id"]);
						}
						$map['type_id']= array("in",$newlist);
						
						$Osql="sort_order desc,id DESC";//id DESC,
						$field="id,title,art_set,art_time,art_url,art_img,art_info";
						//查询条件 
						if($parm['pagesize']){
						//分页处理
						import("ORG.Util.Page");
						$count = M('article')->where($map)->count('id');
						$p = new Page($count, $parm['pagesize']);
						$page = $p->show();
						$Lsql = "{$p->firstRow},{$p->listRows}";
						//分页处理
						}else{
						$page="";
						$Lsql="{$parm['limit']}";
						}
						
						$data = M('article')->field($field)->where($map)->order($Osql)->limit($Lsql)->select();
						
						$suffix=C("URL_HTML_SUFFIX");
						$typefix = get_type_leve_nid($type_id);
						$typeu = implode("/",$typefix);
						foreach($data as $key=>$v){
						if($v['art_set']==1) $data[$key]['arturl'] = (stripos($v['art_url'],"http://")===false)?"http://".$v['art_url']:$v['art_url'];
						//elseif(count($typefix)==1) $data[$key]['arturl'] = 
						else $data[$key]['arturl'] = MU("Home/{$typeu}","article",array("id"=>$v['id'],"suffix"=>$suffix));
						}
						$row=array();
						$row['list'] = $data;
						$row['page'] = $page;
						
						return $row;
						}
						
						
						function getCommentList($map,$size){
						$Osql="id DESC";
						$field=true;
						//查询条件 
						if($size){
						//分页处理
						import("ORG.Util.Page");
						$count = M('comment')->where($map)->count('id');
						$p = new Page($count, $size);
						$p->parameter .= "type=commentlist&";
						$p->parameter .= "id={$map['tid']}&";
						$page = $p->show();
						$Lsql = "{$p->firstRow},{$p->listRows}";
						//分页处理
						}
						
						$data = M('comment')->field($field)->where($map)->order($Osql)->limit($Lsql)->select();
						foreach($data as $key=>$v){
						}
						$row=array();
						$row['list'] = $data;
						$row['page'] = $page;
						$row['count'] = $count;
						
						return $row;
						}
						//排行榜
						function getRankList($map,$size)
						{
						$field = "investor_uid,sum(investor_capital) as total";
						$list = M("borrow_investor")->field($field)->where($map)->group("investor_uid")->order("total DESC")->limit($size)->select();
						foreach($list as $k=>$v )
						{
						$list[$k]['user_name'] = M("members")->getFieldById($v['investor_uid'],"user_name");
						}
						return $list;
						}
						
						//获取借款列表
						function getMemberDetail($uid){
						$pre = C('DB_PREFIX');
						$map['m.id'] = $uid;
						//$field = "*";
						$list = M('members m')->field(true)->join("{$pre}member_banks mbank ON m.id=mbank.uid")->join("{$pre}member_contact_info mci ON m.id=mci.uid")->join("{$pre}member_house_info mhi ON m.id=mhi.uid")->join("{$pre}member_department_info mdpi ON m.id=mdpi.uid")->join("{$pre}member_ensure_info mei ON m.id=mei.uid")->join("{$pre}member_info mi ON m.id=mi.uid")->join("{$pre}member_financial_info mfi ON m.id=mfi.uid")->where($map)->limit($Lsql)->find();
						return $list;
						}
						//获取企业直投借款列表
						function getTBorrowList($parm =array())
						{
						$map = $parm['map'];
						$order = $parm['orderby'];
						$map['bi.borrow_type'] = 9;
						if($parm['pagesize'])
						{
						import( "ORG.Util.Page" );
						$count = M("borrow_info bi")->where($map)->count("bi.id");
						//exit(M()->getLastSql());
						$p = new Page($count, $parm['pagesize']);
						$page = $p->show();
						$Lsql = "{$p->firstRow},{$p->listRows}";
						}else{
						$page = "";
						$Lsql = "{$parm['limit']}";
						}
						$pre = C("DB_PREFIX");
						$suffix =C("URL_HTML_SUFFIX");
						$field = 'bi.id,bi.borrow_name,bi.borrow_money,has_borrow,bi.borrow_duration,borrow_use_text,borrow_guarantee_text,flat_comment,bi.borrow_min,guarantee_comment,borrow_miaoshu,flat_comment_yijing,borrow_cuoshi,borrow_capital,topic,swf_data,';
						$field .= 'bi.borrow_interest_rate,bi.borrow_status,bi.deadline,bi.danbao,bi.topic,m.credits,borrow_type';
						$list = M("borrow_info bi")->field($field)->join("{$pre}members m ON m.id=bi.borrow_uid")->where($map)->order($order)->limit($Lsql)->select();
						//dump($list);die();
						//exit(M()->getLastSql());
						foreach($list as $key => $rows)
						{
						$list[$key]['deadline'] = date("Y-m-d",$rows['deadline']);
						$list[$key]['progress'] = ceil($rows['has_borrow']/$rows['borrow_money']*100);
						$list[$key]['need'] = getfloatvalue(($rows['borrow_money'] - $rows['has_borrow']), 2);
						//$list[$key]['danbao']= empty($rows['danbao']) ? '暂无担保机构' : M('article')->getFieldById($rows['danbao'], 'title');
						$list[$key]['danbao']= empty($rows['danbao']) ? '暂无担保机构' : M('member_info')->getFieldByUid($rows['danbao'], 'real_name');
						}
						
						$row = array();
						$row['list'] = $list;
						$row['page'] = $page;
						return $row;
						}
						//在线客服
						function get_qq($type){
						$list = M('qq')->where("type = $type and is_show = 1")->order("qq_order DESC")->select();
						return $list;
						}
						
						//手机专用
						function getleixing($map){
						
						if($map['borrow_type']==2) $str=4;//担保标
						elseif($map['borrow_type']==3) $str=5;//秒还标
						elseif($map['borrow_type']==4) $str=6;//净值标
						elseif($map['borrow_type']==1) $str=3;//信用标
						elseif($map['borrow_type']==5) $str=7;//抵押标
						return $str;
						} 