<?php
/*手机短信发送
*$phone: 收件人手机号
*$content: 发送内容
*$homeShopId: 发送的网点的home_shop_id(统计用)
*$userType: 接收者类型(yewuyuan或yonghu)(统计用)
*$note: 备注信息(统计用)
*$ywy_app_id: 业务员ID(统计用)
*$channel: 1-默认，不审核；2-需要人工审核
*/
//根据汇付返回UsrCustId获得用户真实姓名
//
//获得用户的真实姓名
function realNameGet($usrid){
     $bdb = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PWD);
                                $sql ="SELECT real_name FROM lzh_members AS m LEFT JOIN lzh_member_info AS mi ON m.id=mi.uid WHERE m.usrid = ? limit 1 ";
                                $stmt1 = $bdb->prepare($sql);
                                $stmt1->bindParam(1, $usrid);    //绑定第一个参数值
                                $stmt1->execute();
                                while($memberd = $stmt1->fetch(PDO::FETCH_ASSOC)){
                                    $memberInfo = $memberd;
                                }
                                return $memberInfo;
}

function getBorrowName($borrow_id){
     $bdb = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PWD);
                                $sql ="SELECT borrow_name FROM lzh_borrow_info WHERE id = ? limit 1 ";
                                $stmt1 = $bdb->prepare($sql);
                                $stmt1->bindParam(1, $borrow_id);    //绑定第一个参数值
                                $stmt1->execute();
                                while($memberd = $stmt1->fetch(PDO::FETCH_ASSOC)){
                                    $borrowInfo = $memberd;
                                }
                                return $borrowInfo;
}


//获得用户的真实姓名
function getRealName($uid){
     $bdb = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PWD);
                                $sql ="SELECT real_name FROM lzh_member_info WHERE uid = ? limit 1 ";
                                $stmt1 = $bdb->prepare($sql);
                                $stmt1->bindParam(1, $uid);    //绑定第一个参数值
                                $stmt1->execute();
                                while($memberd = $stmt1->fetch(PDO::FETCH_ASSOC)){
                                    $memberInfo = $memberd;
                                }
                                return $memberInfo;
}
//发送短信
function sendsms($mob,$content){
        $server_url = 'http://3tong.net/services/sms?wsdl';
	$user_name = 'dh21944';
	$password = 'kb21944.com';
	include_once dirname(dirname(__FILE__))."/sms/dahan/class.dahansms.php";
	$dahan = new dahanClient();
	$dahan->Client($server_url,$user_name,$password);
	$res = $dahan->dahanSMS($mob,$content);
        
        //插入数据库中短信信息
        $currenttime = date('Y-m-d H:i:s',time());
        $bdb = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PWD);
        $sql = sprintf("INSERT INTO %s (telephone,send_content,back_result,send_time) VALUES ('%s','%s','%s','%s') ",'lzh_sendsms',$mob,addslashes($content),addslashes($res),$currenttime);
        $stmt1 = $bdb->prepare($sql); 
        $stmt1->execute();     
        $bdb = null;
       // file_put_contents('a.txt',date('m-d H:i:s')." ".print_r($res,true)."\n",FILE_APPEND);
	return true;
}

//获得时间天数
function get_times($data=array()){
	if (isset($data['time']) && $data['time']!=""){
		$time = $data['time'];//时间
	}elseif (isset($data['date']) && $data['date']!=""){
		$time = strtotime($data['date']);//日期
	}else{
		$time = time();//现在时间
	}
	if (isset($data['type']) && $data['type']!=""){ 
		$type = $data['type'];//时间转换类型，有day week month year
	}else{
		$type = "month";
	}
	if (isset($data['num']) && $data['num']!=""){ 
		$num = $data['num'];
	}else{
		$num = 1;
	}
	
	if ($type=="month"){
		$month = date("m",$time);
		$year = date("Y",$time);
		$_result = strtotime("$num month",$time);
		$_month = (int)date("m",$_result);
		if ($month+$num>12){
			$_num = $month+$num-12;
			$year = $year+1;
		}else{
			$_num = $month+$num;
		}
		
		if ($_num!=$_month){
		
			$_result = strtotime("-1 day",strtotime("{$year}-{$_month}-01"));
		}
	}else{
		$_result = strtotime("$num $type",$time);
	}
	if (isset($data['format']) && $data['format']!=""){ 
		return date($data['format'],$_result);
	}else{
		return $_result;
	}

}

//等额本息法
//贷款本金×月利率×（1+月利率）还款月数/[（1+月利率）还款月数-1] 
//a*[i*(1+i)^n]/[(1+I)^n-1] 
//（a×i－b）×（1＋i）
/*
money,year_apr,duration,borrow_time(用来算还款时间的),type(==all时，返回还款概要)

*/
function EqualMonth ($data = array()){
	if (isset($data['money']) && $data['money']>0){
		$account = $data['money'];
	}else{
		return "";
	}
	
	if (isset($data['year_apr']) && $data['year_apr']>0){
		$year_apr = $data['year_apr'];
	}else{
		return "";
	}
	
	if (isset($data['duration']) && $data['duration']>0){
		$duration = $data['duration'];
	}
	if (isset($data['borrow_time']) && $data['borrow_time']>0){
		$borrow_time = $data['borrow_time'];
	}else{
		$borrow_time = time();
	}
	$month_apr = $year_apr/(12*100);
	$_li = pow((1+$month_apr),$duration);
	$repayment = round($account * ($month_apr * $_li)/($_li-1),4);
	$_result = array();
	if (isset($data['type']) && $data['type']=="all"){
		$_result['repayment_money'] = $repayment*$duration;
		$_result['monthly_repayment'] = $repayment;
		$_result['month_apr'] = round($month_apr*100,4);
	}else{
		//$re_month = date("n",$borrow_time);
		for($i=0;$i<$duration;$i++){
			if ($i==0){
				$interest = round($account*$month_apr,4);
			}else{
				$_lu = pow((1+$month_apr),$i);
				$interest = round(($account*$month_apr - $repayment)*$_lu + $repayment,4);
			}
			$_result[$i]['repayment_money'] = getFloatValue($repayment,4);
			$_result[$i]['repayment_time'] = get_times(array("time"=>$borrow_time,"num"=>$i+1));
			$_result[$i]['interest'] = getFloatValue($interest,4);
			$_result[$i]['capital'] = getFloatValue($repayment-$interest,4);
		}
	}
	return $_result;
}

function getFloatValue($f,$len)
{
  return  number_format($f,$len,'.','');   
} 
//到期还本，按月付息
/**
 * by whh 2015-03-16
 * 新的算法
 * 1. 先算总共需要还的利息
 * 2. 计算每期需要还的利息
 * 3. 最后一期 = 总需还利息 - 其他期需还利息
 */
function EqualEndMonthBYWHH ($data = array()){
  
  //借款的月数
  if (isset($data['month_times']) && $data['month_times']>0){
	  $month_times = $data['month_times'];
  }

  //借款的总金额
  if (isset($data['account']) && $data['account']>0){
	  $account = $data['account'];
  }else{
	  return "";
  }
  
  //借款的年利率
  if (isset($data['year_apr']) && $data['year_apr']>0){
	  $year_apr = $data['year_apr'];
  }else{
	  return "";
  }
  
  //借款的时间
  if (isset($data['borrow_time']) && $data['borrow_time']>0){
	  $borrow_time = $data['borrow_time'];
  }else{
	  $borrow_time = time();
  }

  //总利息
  $all_lixi = $left_lixi = (( $year_apr * $month_times ) / 1200) * $account ;
  
  //月利率
  $month_apr = $year_apr/(12*100);
  
  
  
  //$re_month = date("n",$borrow_time);
  $_yes_account = 0 ;
  $repayment_account = 0;//总还款额
  $_all_interest=0;
  
  $interest = round($account*$month_apr,2);//利息等于应还金额乘月利率
  for($i=0;$i<$month_times;$i++){
	  $capital = 0;
	  if ($i+1 == $month_times){
		  $capital = $account;//本金只在最后一个月还，本金等于借款金额除季度
	  }
	  
	  $_result[$i]['repayment_account'] = $interest+$capital;
	  $_result[$i]['repayment_time'] = get_times(array("time"=>$borrow_time,"num"=>$i+1));
	  $_result[$i]['interest'] = $interest;
	  $_result[$i]['capital'] = $capital;
	  $_all_interest += $interest;

	  if ($i+1 == $month_times){
		$_result[$i]['interest'] = $left_lixi;
		$_result[$i]['repayment_account'] = $_result[$i]['interest']+$capital;
	  }else{
		$left_lixi = $left_lixi - $interest;  
	  }
  }
  if (isset($data['type']) && $data['type']=="all"){
	  $_resul['repayment_account'] = $account + $interest*$month_times;
	  $_resul['monthly_repayment'] = $interest;
	  $_resul['month_apr'] = round($month_apr*100,4);
	  $_resul['interest'] = $_all_interest;
	  return $_resul;
  }else{
	  return $_result;
  }
}



//按季等额本息法
function EqualSeason ($data = array()){
  //借款的月数
  if (isset($data['month_times']) && $data['month_times']>0){
	  $month_times = $data['month_times'];
  }
  //按季还款必须是季的倍数
  if ($month_times%3!=0){
	  return false;
  }
  //借款的总金额
  if (isset($data['account']) && $data['account']>0){
	  $account = $data['account'];
  }else{
	  return "";
  }
  //借款的年利率
  if (isset($data['year_apr']) && $data['year_apr']>0){
	  $year_apr = $data['year_apr'];
  }else{
	  return "";
  }
  
  //借款的时间 --- 什么时候开始借款，计算还款的
  if (isset($data['borrow_time']) && $data['borrow_time']>0){
	  $borrow_time = $data['borrow_time'];
  }else{
	  $borrow_time = time();
  }
  
  //月利率
  $month_apr = $year_apr/(12*100);
  
  //得到总季数
  $_season = $month_times/3;
  
  //每季应还的本金
  $_season_money = round($account/$_season,4);
  
  //$re_month = date("n",$borrow_time);
  $_yes_account = 0 ;
  $repayment_account = 0;//总还款额
  $_all_interest = 0;//总利息
  for($i=0;$i<$month_times;$i++){
	  $repay = $account - $_yes_account;//应还的金额
	  
	  $interest = round($repay*$month_apr,4);//利息等于应还金额乘月利率
	  $repayment_account = $repayment_account+$interest;//总还款额+利息
	  $capital = 0;
	  if ($i%3==2){
		  $capital = $_season_money;//本金只在第三个月还，本金等于借款金额除季度
		  $_yes_account = $_yes_account+$capital;
		  $repay = $account - $_yes_account;
		  $repayment_account = $repayment_account+$capital;//总还款额+本金
	  }
	  
	  $_result[$i]['repayment_money'] = getFloatValue($interest+$capital,4);
	  $_result[$i]['repayment_time'] = get_times(array("time"=>$borrow_time,"num"=>$i+1));
	  $_result[$i]['interest'] = getFloatValue($interest,4);
	  $_result[$i]['capital'] = getFloatValue($capital,4);
	  $_all_interest += $interest;
  }
  if (isset($data['type']) && $data['type']=="all"){
	  $_resul['repayment_money'] = $repayment_account;
	  $_resul['monthly_repayment'] = round($repayment_account/$_season,4);
	  $_resul['month_apr'] = round($month_apr*100,4);
	  $_resul['interest'] = $_all_interest;
	  return $_resul;
  }else{
	  return $_result;
  }
}
/////////////////////////////////////////一次性还款//////////////////////////////////////
//到期还本，按月付息
function EqualEndMonthOnly($data = array()){
  
  //借款的月数
  if (isset($data['month_times']) && $data['month_times']>0){
	  $month_times = $data['month_times'];
  }

  //借款的总金额
  if (isset($data['account']) && $data['account']>0){
	  $account = $data['account'];
  }else{
	  return "";
  }
  
  //借款的年利率
  if (isset($data['year_apr']) && $data['year_apr']>0){
	  $year_apr = $data['year_apr'];
  }else{
	  return "";
  }
  
  //借款的时间
  if (isset($data['borrow_time']) && $data['borrow_time']>0){
	  $borrow_time = $data['borrow_time'];
  }else{
	  $borrow_time = time();
  }
  
  //月利率
  $month_apr = $year_apr/(12*100);
  
  $interest = getFloatValue($account*$month_apr*$month_times,4);//利息等于应还金额*月利率*借款月数

  if (isset($data['type']) && $data['type']=="all"){
	  $_resul['repayment_account'] = $account + $interest;
	  $_resul['monthly_repayment'] = $interest;
	  $_resul['month_apr'] = round($month_apr*100,4);
	  $_resul['interest'] = $interest;
	  $_resul['capital'] = $account;
	  return $_resul;
  }
}


//到期还本，按月付息
function EqualEndMonth ($data = array()){
  
  //借款的月数
  if (isset($data['month_times']) && $data['month_times']>0){
	  $month_times = $data['month_times'];
  }

  //借款的总金额
  if (isset($data['account']) && $data['account']>0){
	  $account = $data['account'];
  }else{
	  return "";
  }
  
  //借款的年利率
  if (isset($data['year_apr']) && $data['year_apr']>0){
	  $year_apr = $data['year_apr'];
  }else{
	  return "";
  }
  
  
  //借款的时间
  if (isset($data['borrow_time']) && $data['borrow_time']>0){
	  $borrow_time = $data['borrow_time'];
  }else{
	  $borrow_time = time();
  }
  
  //月利率
  $month_apr = $year_apr/(12*100);
  
  
  
  //$re_month = date("n",$borrow_time);
  $_yes_account = 0 ;
  $repayment_account = 0;//总还款额
  $_all_interest=0;
  
  $interest = round($account*$month_apr,4);//利息等于应还金额乘月利率
  for($i=0;$i<$month_times;$i++){
	  $capital = 0;
	  if ($i+1 == $month_times){
		  $capital = $account;//本金只在最后一个月还，本金等于借款金额除季度
	  }
	  
	  $_result[$i]['repayment_account'] = $interest+$capital;
	  $_result[$i]['repayment_time'] = get_times(array("time"=>$borrow_time,"num"=>$i+1));
	  $_result[$i]['interest'] = $interest;
	  $_result[$i]['capital'] = $capital;
	  $_all_interest += $interest;
  }
  if (isset($data['type']) && $data['type']=="all"){
	  $_resul['repayment_account'] = $account + $interest*$month_times;
	  $_resul['monthly_repayment'] = $interest;
	  $_resul['month_apr'] = round($month_apr*100,4);
	  $_resul['interest'] = $_all_interest;
	  return $_resul;
  }else{
	  return $_result;
  }
}

function postArrayToString($req=array()){
	$tmp= array();
	foreach($req as $key => $value){
		array_push($tmp,  "$key=".urlencode($value));
	}
	return implode("&", $tmp);
}


function request($request_url,$postData=array()){//echo "<pre>";print_r($postData);echo "</pre>";exit;
	$post_string= postArrayToString($postData);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $request_url);
	curl_setopt($ch, CURLOPT_POST,strlen($post_string));
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//禁止直接显示获取的内容 重要
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书下同
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //
	$result=curl_exec($ch);
	curl_close($ch);
	return $result;
}

//将表示金额的字符串转换成数字
//字符串格式：###,###.##
function str2val_money($str)
{
	return floatval(str_replace(',', '', $str));
}



function memberMoneyLog($uid,$type,$amoney,$info="",$target_uid="",$target_uname="",$fee=0,$reqext=0){
	$xva = floatval($amoney);
	if(empty($xva)) return true;
	$done = false;
	
	$db = core::Singleton('comm.db.activeRecord');
	$db->connect('CAILAI');
	
	//$MM = M("member_money")->field("money_freeze,money_collect,account_money,back_money")->find($uid);
	$MM = $db->get_one(array('uid' => $uid), '', 'lzh_member_money');
	
	
	if(!is_array($MM)||empty($MM)){
		//M("member_money")->add(array('uid'=>$uid));
		//$MM = M("member_money")->field("money_freeze,money_collect,account_money,back_money")->find($uid);
		$db->insert(array('uid'=>$uid), 'lzh_member_money');
		$MM = $db->get_one(array('uid' => $uid), '', 'lzh_member_money');
	}
	
	//$Moneylog = D('member_moneylog');
	if(in_array($type,array("71","72","73"))) $type_save=7;
	else $type_save = $type;

	if($target_uname=="" && $target_uid>0){
		$tmp = $db->get_one(array('id' => $target_uid), '', 'lzh_members');
		$tname = $tmp['user_name'];
		//$tname = M('members')->getFieldById($target_uid,'user_name');
	}else{
		$tname = $target_uname;
	}
	if($target_uid=="" && $target_uname==""){
		$target_uid=0;
		$tname = '@网站管理员@';
	}
	//$Moneylog->startTrans();
	$data['uid'] = $uid;
	$data['type'] = $type_save;
	$data['info'] = $info;
	$data['target_uid'] = $target_uid;
	$data['target_uname'] = $tname;
	$data['add_time'] = time();
	$data['add_ip'] = get_client_ip();
	switch($type){
		/////////////////////////////////////////
		case 5://撤消提现
			$data['affect_money'] = $amoney;

			if(($MM['back_money']+$amoney+$fee)<0){//提现手续费先从回款余额资金池里扣，不够再去充值资金池里减少
				$data['back_money'] = 0;
				$data['account_money'] = $MM['account_money']+$MM['back_money']+$amoney+$fee;
			}else{
				$data['back_money'] = $MM['back_money'];
				$data['account_money'] = $MM['account_money']+$amoney+$fee;
			}

			$data['collect_money'] = $MM['money_collect'];
			$data['freeze_money'] = $MM['money_freeze']-$amoney;
			break;
		case 4://提现冻结
			//case 5://撤消提现
		case 6://投标冻结
		case 37://投企业直投冻结
			$data['affect_money'] = $amoney;
 //file_put_contents('/tmp/4.txt',date('m-d H:i:s')." 冻结的金额减去代金：".print_r($reqext,true)."\n"
     file_put_contents('/tmp/4.txt',date('m-d H:i:s')." 冻结的金额减去代金：".print_r($reqext,true)."\n",FILE_APPEND);
     file_put_contents('/tmp/4.txt',date('m-d H:i:s')." 冻结的真是金额：".print_r($data['affect_money'],true)."\n",FILE_APPEND);
			if(($MM['back_money']+$amoney+$fee)<0){//提现手续费先从回款余额资金池里扣，不够再去充值资金池里减少
				$data['back_money'] = 0;
				$data['account_money'] = $MM['account_money']+$MM['back_money']+$amoney+$fee+$reqext;
			}else{
				$data['back_money'] = $MM['back_money']+$amoney+$fee+$reqext;
				$data['account_money'] = $MM['account_money'];
			}

			$data['collect_money'] = $MM['money_collect'];
			$data['freeze_money'] = $MM['money_freeze']-$amoney-$reqext;
            file_put_contents('/tmp/4.txt',date('m-d H:i:s')." 冻结金额：".print_r($data['freeze_money'],true)."\n",FILE_APPEND);
			break;
		case 12://提现失败
			$data['affect_money'] = $amoney;

			if(($MM['account_money']+$MM['back_money'])>abs($fee)){
				if(($MM['back_money']+$amoney+$fee)<0){//提现手续费先从回款余额资金池里扣，不够再去充值资金池里减少
					$data['back_money'] = 0;
					$data['account_money'] = $MM['account_money']+$MM['back_money']+$amoney+$fee;
				}else{
					$data['back_money'] = $MM['back_money']+$amoney+$fee;
					$data['account_money'] = $MM['account_money'];
				}
				$data['collect_money'] = $MM['money_collect'];
				$data['freeze_money'] = $MM['money_freeze']-$amoney;
			}else{
				if(($MM['back_money']+$amoney+$fee)<0){//提现手续费先从回款余额资金池里扣，不够再去充值资金池里减少
					$data['back_money'] = 0;
					$data['account_money'] = $MM['account_money']+$MM['back_money']+$amoney;
				}else{
					$data['back_money'] = $MM['back_money']+$amoney;
					$data['account_money'] = $MM['account_money'];
				}
				$data['collect_money'] = $MM['money_collect'];
				$data['freeze_money'] = $MM['money_freeze']-$amoney+$fee;
			}
			break;
				
		case 29://提现成功
			$data['affect_money'] = $amoney;
			$data['account_money'] = $MM['account_money'];
			$data['back_money'] = $MM['back_money'];
			$data['collect_money'] = $MM['money_collect'];
			$data['freeze_money'] = $MM['money_freeze']+$amoney+$fee;
			break;
		case 36://提现通过，处理中
			$data['affect_money'] = $amoney;
			if(($MM['account_money']+$MM['back_money'])>abs($fee)){
				if(($MM['back_money']+$fee)<0){//提现手续费先从回款余额资金池里扣，不够再去充值资金池里减少
					$data['account_money'] = $MM['account_money']+$MM['back_money']+$fee;
					$data['back_money'] = 0;
				}else{
					$data['account_money'] = $MM['account_money'];
					$data['back_money'] = $MM['back_money']+$fee;
				}
				$data['collect_money'] = $MM['money_collect'];
				$data['freeze_money'] = $MM['money_freeze'];
			}else{
				$data['account_money'] =$MM['account_money'];
				$data['back_money'] = $MM['back_money'];
				$data['collect_money'] = $MM['money_collect'];
				$data['freeze_money'] = $MM['money_freeze']+$fee;
			}
			break;
			////////////////////////////////////////
		case 19://借款保证金
			$data['affect_money'] = $amoney;
			if(($MM['account_money']+$amoney)<0){
				$data['account_money'] = 0;
				$data['back_money'] = $MM['account_money']+$MM['back_money']+$amoney;
			}else{
				$data['account_money'] = $MM['account_money']+$amoney;
				$data['back_money'] = $MM['back_money'];
			}
			$data['collect_money'] = $MM['money_collect'];
			$data['freeze_money'] = $MM['money_freeze']-$amoney;
			break;
		case 8://流标解冻
			//case 19://借款保证金
		case 24://还款完成解冻
		case 34://预投标奖励撤销
			$data['affect_money'] = $amoney;
			if(($MM['account_money']+$amoney)<0){
				$data['account_money'] = 0;
				$data['back_money'] = $MM['account_money']+$MM['back_money']+$amoney;
			}else{
				$data['account_money'] = $MM['account_money']+$amoney;
				$data['back_money'] = $MM['back_money'];
			}
			$data['collect_money'] = $MM['money_collect'];
			$data['freeze_money'] = $MM['money_freeze'];
			break;
		case 3://会员充值
		case 17://借款金额入帐
		case 18://借款管理费
		case 20://投标奖励
		case 21://支付投标奖励
		case 40://企业直投续投奖励
		case 41://企业直投投标奖励
		case 42://支付企业直投投标奖励
			$data['affect_money'] = $amoney;
			if(($MM['account_money']+$amoney)<0){
				$data['account_money'] = 0;
				$data['back_money'] = $MM['account_money']+$MM['back_money']+$amoney;
			}else{
				$data['account_money'] = $MM['account_money']+$amoney;
				$data['back_money'] = $MM['back_money'];
			}
			$data['collect_money'] = $MM['money_collect'];
			$data['freeze_money'] = $MM['money_freeze'];
			break;
		case 9://会员还款
		case 10://网站代还
			$data['affect_money'] = $amoney;
			$data['account_money'] = $MM['account_money'];
			$data['collect_money'] = $MM['money_collect']-$amoney;
			$data['freeze_money'] = $MM['money_freeze'];
			$data['back_money'] = $MM['back_money']+$amoney;
			break;
		case 15://投标成功冻结资金转为待收资金
		case 39://企业直投投标成功冻结资金转为待收资金
			$data['affect_money'] = $amoney;//+$reqext
			$data['account_money'] = $MM['account_money'];
			$data['collect_money'] = $MM['money_collect']+$amoney;
			$data['freeze_money'] = $MM['money_freeze']-$amoney;
			$data['back_money'] = $MM['back_money'];
			break;
		case 28://投标成功利息待收
		case 38://企业直投投标成功利息待收
		case 73://单独操作待收金额
			$data['affect_money'] = $amoney;
			$data['account_money'] = $MM['account_money'];
			$data['collect_money'] = $MM['money_collect']+$amoney;
			$data['freeze_money'] = $MM['money_freeze'];
			$data['back_money'] = $MM['back_money'];
			break;
		case 72://单独操作冻结金额
		case 33://续投奖励(预奖励)
		case 35://续投奖励(取消)
			$data['affect_money'] = $amoney;
			$data['account_money'] = $MM['account_money'];
			$data['collect_money'] = $MM['money_collect'];
			$data['freeze_money'] = $MM['money_freeze']+$amoney;
			$data['back_money'] = $MM['back_money'];
			break;
		case 188;//平台转入
		case 71://单独操作可用余额
		default:
			$data['affect_money'] = $amoney;
			if(($MM['account_money']+$amoney)<=0){
				$data['account_money'] = 0;
				$data['back_money'] = $MM['account_money']+$MM['back_money']+$amoney;
			}else{
				$data['account_money'] = $MM['account_money']+$amoney;
				$data['back_money'] = $MM['back_money'];
			}
			//$data['account_money'] = $MM['account_money']+$amoney;
			$data['collect_money'] = $MM['money_collect'];
			$data['freeze_money'] = $MM['money_freeze'];
			//$data['back_money'] = $MM['back_money'];
			break;
				
	}
	
	//$newid = M('member_moneylog')->add($data);
	$newid = $db->insert($data, 'lzh_member_moneylog');
	
	//帐户更新
	$mmoney['money_freeze']=$data['freeze_money'];
	$mmoney['money_collect']=$data['collect_money'];
	$mmoney['account_money']=$data['account_money'];
	$mmoney['back_money']=$data['back_money'];
	//if($newid) $xid = M('member_money')->where("uid={$uid}")->save($mmoney);
	if($newid){
		
		//$xid = M('member_money')->where("uid={$uid}")->save($mmoney);
		$condition['uid']=$uid;
		$xid = $db->update($condition,$mmoney, 'lzh_member_money',1);
	}
	if($xid){
		$done = true;
		//$Moneylog->commit();
	}else{
		//$Moneylog->rollback();
	}
	return $done;
}


// 获取客户端IP地址
function get_client_ip() {
	static $ip = NULL;
	if ($ip !== NULL) return $ip;
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		$pos =  array_search('unknown',$arr);
		if(false !== $pos) unset($arr[$pos]);
		$ip   =  trim($arr[0]);
	}elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}elseif (isset($_SERVER['REMOTE_ADDR'])) {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	// IP地址合法验证
	$ip = (false !== ip2long($ip)) ? $ip : '0.0.0.0';
	return $ip;
}

//网站基本设置
function get_global_setting(){
	$list=array();	
        $db = core::Singleton('comm.db.activeRecord');
        $db->connect('CAILAI');
        $list_t = $db->get_all('',array(0, 200),'','lzh_global');      
        foreach($list_t as $key => $v){
                $list[$v['code']] = de_xie($v['text']);
        }
	return $list;
}

//在前台显示时去掉反斜线,传入数组，最多二维
function de_xie($arr){
	$data=array();
	if(is_array($arr)){
		foreach($arr as $key=>$v){
			if(is_array($v)){
				foreach($v as $skey=>$sv){
					if(is_array($sv)){
							
					}else{
						$v[$skey] = stripslashes($sv);
					}
				}
				$data[$key] = $v;
			}else{
				$data[$key] = stripslashes($v);
			}
		}
	}else{
		$data = stripslashes($arr);
	}
	return $data;
}

//function investMoney($uid用户UID 即投资人,$borrow_id标id,$money交易金额,$invest_info_id投标订单id){
function investMoney($uid,$borrow_id,$money,$_is_auto=0,$invest_info_id,$reqext=0){//2015-09-30 lj 红包最后一笔扣不了钱
   // require_once('config/config.db.php');
	$pre = DB_PREFIX;
	$done = false;
	$datag = get_global_setting();
	//$fee_invest_manage = explode("|",$datag['fee_invest_manage']);
	/////////////////////////////锁表  zhang 2015-5-5////////////////////////////////////////////////
        
	$bdb = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PWD);
	$bdb->beginTransaction();
	$bId = $borrow_id;
		   
	$sql ="SELECT suo FROM lzh_borrow_info_lock WHERE id = ? FOR UPDATE";
        $stmt1 = $bdb->prepare($sql);
	$stmt1->bindParam(1, $bId);    //绑定第一个参数值
        $stmt1->execute();
 
	/////////////////////////////锁表   zhang 2015-5-5////////////////////////////////////////////////
         $sqlbi = 'SELECT borrow_uid,borrow_money,borrow_interest_rate,borrow_type,borrow_duration,repayment_type,has_borrow,reward_money,money_collect,manage_rate,danbao FROM lzh_borrow_info WHERE id = ? limit 1';
         $stmt2 = $bdb->prepare($sqlbi);
         $stmt2->bindParam(1,$borrow_id);
         $stmt2->execute();
         while($rowbi = $stmt2->fetch(PDO::FETCH_ASSOC)){
             $binfo = $rowbi;
         }    
	//新加入了奖金reward_money到资金总额里
         
        $sql = "SELECT m.user_leve,m.time_limit,mm.account_money,mm.back_money,mm.money_collect FROM {$pre}members AS m LEFT JOIN {$pre}member_money mm ON mm.uid=m.id WHERE m.id= ? limit 1";
        $stmt = $bdb->prepare($sql);
	$stmt->bindParam(1, $uid);    //绑定第一个参数值
        $stmt->execute();
//        var_dump($stmt2->queryString);
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {        
            $vminfo = $row;     
        }     
          
//	$vminfo = getMinfo($uid,'m.user_leve,m.time_limit,mm.account_money,mm.back_money,mm.money_collect');
//	if(($vminfo['account_money']+$vminfo['back_money']+$binfo['reward_money'])<$money) {
//		return "您当前的可用金额为：".($vminfo['account_money']+$vminfo['back_money']+$binfo['reward_money'])." 对不起，可用余额不足，不能投标";
//	}
//	
//	////////////新增投标时检测会员的待收金额是否大于标的设置的代收金额限制，大于就可投标，小于就不让投标 2013-08-26 fan//////////////
//	
//	if($binfo['money_collect']>0){//判断是否设置了投标待收金额限制
//		if($vminfo['money_collect']<$binfo['money_collect']){
//			return "对不起，此标设置有投标待收金额限制，您当前的待收金额为".$vminfo['money_collect']."元，小于该标设置的待收金额限制".$binfo['money_collect']."元。";
//		}
//	}
	
	////////////新增投标时检测会员的待收金额是否大于标的设置的代收金额限制，大于就可投标，小于就不让投标 2013-08-26 fan//////////////
	
	//不同会员级别的费率
	//($vminfo['user_leve']==1 && $vminfo['time_limit']>time())?$fee_rate=($fee_invest_manage[1]/100):$fee_rate=($fee_invest_manage[0]/100);
	$fee_rate=$datag['fee_invest_manage']/100;
	//投入的钱
	$havemoney = $binfo['has_borrow'];     
//	if(($binfo['borrow_money'] - $havemoney -$money)<0) 
//	{
//		return "对不起，此标还差".($binfo['borrow_money'] - $havemoney)."元满标，您最多投标".($binfo['borrow_money'] - $havemoney)."元";
//	}
 
        $sql = "SELECT SUM(investor_capital) AS investor_capital FROM {$pre}borrow_investor WHERE borrow_id = ? LIMIT 1";
        $stmt = $bdb->prepare($sql);
        $stmt->bindParam(1,$borrow_id);
        $stmt->execute();
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $borrow_invest = $row;
        }
       
//	$borrow_invest = M("borrow_investor")->where('borrow_id = {$borrow_id}')->sum('investor_capital');//新加投资金额检测
  
                /***获取积分比率****/
//        $fee = M('members')->where("id=".$uid)->getField('integral');
        $sql = "SELECT integral FROM {$pre}members WHERE id=? limit 1";
        $stmt = $bdb->prepare($sql);
        $stmt->bindParam(1,$uid);
        $stmt->execute();
//        
//        file_put_contents('/tmp/444',date('m-d H:i:s')."monthDataDetail".print_r($sql,true)."\n",FILE_APPEND);  
//        
        
        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
            $fee = $row;
        }
        $fs = $fs = require_once('config/config.leveinvestconfig.php');
        foreach($fs as $val)
        {
                if($fee > $val['start'] && $fee < $val['end'])
                {
                        $rate = floatval($val['rate'])/100;
                        break;
                }
        }
        /***获取积分比率结束****/
        
        $investinfo['status'] = 1;//等待复审
        $investinfo['borrow_id'] = $borrow_id;
        $investinfo['investor_uid'] = $uid;  //投资者
        $investinfo['borrow_uid'] = $binfo['borrow_uid'];   //借款者
        $investinfo['investor_fee'] = $binfo['manage_rate']*$money;   //管理费
        if($binfo['danbao'] != 0)
		{
//			$guarrate=M("member_guarrate")->field("guarrate")->where("uid={$binfo['danbao']}")->find();//担保费率
                        $sql = "SELECT guarrate FROM {$pre}member_guarrate WHERE uid=? limit 1";
                        $stmt = $bdb->prepare($sql);
                        $stmt->bindParam(1,$binfo['danbao']);
                        $stmt->execute();
                        while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                            $fee = $row;
                        }                       
			$investinfo['guar_fee'] = $guarrate['guarrate']*$money/100;
		}
                
                /////////////////////////////////////新加投资金额检测/////////////////////////////////////////////
		if($borrow_invest['investor_capital']>$binfo['borrow_money']){
			$investinfo['investor_capital'] = $binfo['borrow_money'] - $binfo['has_borrow'];
		}else{
			$investinfo['investor_capital'] = $money;
		}
		/////////////////////////////////////新加投资金额检测/////////////////////////////////////////////
                
                $investinfo['is_auto'] = $_is_auto;
		$investinfo['add_time'] = time();
		//还款详细公共信息START
                
                
        $handler=mysql_connect(DB_HOST,DB_USER,DB_PWD);
        mysql_select_db(DB_NAME);
        mysql_query("SET AUTOCOMMIT=0");//设置为不自动提交，因为MYSQL默认立即执行
        mysql_query("START TRANSACTION");//开始事务定义
		//还款概要公共信息START
		$savedetail=array();
	switch($binfo['repayment_type']){
			case 1://按天到期还款
				//还款概要START
				$investinfo['investor_interest'] = getFloatValue($binfo['borrow_interest_rate']/360*$investinfo['investor_capital']*$binfo['borrow_duration']/100,4);
				$investinfo['invest_fee'] = getFloatValue($fee_rate * $investinfo['investor_interest']*(1 - $rate),4);//修改投资人的天标利息管理费2013-03-19 fan
				$investinfo['invest_fee_yh'] = getFloatValue($fee_rate * $investinfo['investor_interest'],4);//修改投资人的天标利息管理费2013-03-19 fan
				//$invest_info_id = M('borrow_investor')->add($investinfo);
//				M('borrow_investor')->where("id=".$invest_info_id)->save($investinfo);
                                foreach ($investinfo as $key => $val) {			
                                        $upSql .= "{$key}={$val},";

                                    }
                                    $upSql = rtrim($upSql,",");
                                    $sql = sprintf("UPDATE %s SET $upSql where id=%s","{$pre}borrow_investor",$invest_info_id);
                               
                               $rtype = mysql_query($sql);
				//还款概要END
				$investdetail['borrow_id'] = $borrow_id;
				$investdetail['invest_id'] = $invest_info_id;
				$investdetail['investor_uid'] = $uid;
				$investdetail['borrow_uid'] = $binfo['borrow_uid'];
				$investdetail['capital'] = $investinfo['investor_capital'];
				$investdetail['interest'] = $investinfo['investor_interest'];
				$investdetail['interest_fee'] = $fee_rate * $investinfo['invest_fee']*(1 - $rate);
				$investdetail['interest_fee_yh'] = $fee_rate * $investinfo['invest_fee'];
				$investdetail['status'] = 0;
				$investdetail['sort_order'] = 1;
				$investdetail['total'] = 1;
				$savedetail[] = $investdetail;
			break;
			case 2://每月还款
				//还款概要START
				$monthData['type'] = "all";
				$monthData['money'] = $investinfo['investor_capital'];
				$monthData['year_apr'] = $binfo['borrow_interest_rate'];
				$monthData['duration'] = $binfo['borrow_duration'];
				$repay_detail = EqualMonth($monthData);
				$investinfo['investor_interest'] = ($repay_detail['repayment_money'] - $investinfo['investor_capital']);
				$investinfo['invest_fee'] = getFloatValue($fee_rate * $investinfo['investor_interest']*(1 - $rate),4);
				$investinfo['invest_fee_yh'] = getFloatValue($fee_rate * $investinfo['investor_interest'],4);
				//$invest_info_id = M('borrow_investor')->add($investinfo);
                                
//				M('borrow_investor')->where("id=".$invest_info_id)->save($investinfo);
        			foreach ($investinfo as $key => $val) {			
                                    $upSql .= "{$key}={$val},";

                                }
                                $upSql = rtrim($upSql,",");
                                $sql = sprintf("UPDATE %s SET $upSql where id=%s","{$pre}borrow_investor",$invest_info_id);
                               
                                $rtype = mysql_query($sql);
				//还款概要END
				
				$monthDataDetail['money'] = $investinfo['investor_capital'];
				$monthDataDetail['year_apr'] = $binfo['borrow_interest_rate'];
				$monthDataDetail['duration'] = $binfo['borrow_duration'];
				$repay_list = EqualMonth($monthDataDetail);
				$i=1;

				//file_put_contents(C('WEB_ROOT').'a.txt', json_encode($repay_list));exit;
				
				foreach($repay_list as $key=>$v){
					$investdetail['borrow_id'] = $borrow_id;
					$investdetail['invest_id'] = $invest_info_id;
					$investdetail['investor_uid'] = $uid;
					$investdetail['borrow_uid'] = $binfo['borrow_uid'];
					$investdetail['capital'] = $v['capital'];
					$investdetail['interest'] = $v['interest'];
					$investdetail['interest_fee'] = getFloatValue($fee_rate*$v['interest']*(1 - $rate),4);
					$investdetail['interest_fee_yh'] = getFloatValue($fee_rate*$v['interest'],4);
					$investdetail['status'] = 0;
					$investdetail['sort_order'] = $i;
					$investdetail['total'] = $binfo['borrow_duration'];
					$i++;
					$savedetail[] = $investdetail;
				}

			break;
			case 3://按季分期还款
				//还款概要START

				$monthData['month_times'] = $binfo['borrow_duration'];
				$monthData['account'] = $investinfo['investor_capital'];
				$monthData['year_apr'] = $binfo['borrow_interest_rate'];
				$monthData['type'] = "all";
				$repay_detail = EqualSeason($monthData);
				
				$investinfo['investor_interest'] = ($repay_detail['repayment_money'] - $investinfo['investor_capital']);
				$investinfo['invest_fee'] = getFloatValue($fee_rate * $investinfo['investor_interest']*(1 - $rate),4);
				$investinfo['invest_fee_yh'] = getFloatValue($fee_rate * $investinfo['investor_interest'],4);
				//$invest_info_id = M('borrow_investor')->add($investinfo);
//				M('borrow_investor')->where("id=".$invest_info_id)->save($investinfo);
			       foreach ($investinfo as $key => $val) {			
                                    $upSql .= "{$key}={$val},";

                                }
                                $upSql = rtrim($upSql,",");
                                $sql = sprintf("UPDATE %s SET $upSql where id=%s","{$pre}borrow_investor",$invest_info_id);
                               
                                $rtype = mysql_query($sql);
				//还款概要END				
				$monthDataDetail['month_times'] = $binfo['borrow_duration'];
				$monthDataDetail['account'] = $investinfo['investor_capital'];
				$monthDataDetail['year_apr'] = $binfo['borrow_interest_rate'];
				$repay_list = EqualSeason($monthDataDetail);
				$i=1;
				foreach($repay_list as $key=>$v){
					$investdetail['borrow_id'] = $borrow_id;
					$investdetail['invest_id'] = $invest_info_id;
					$investdetail['investor_uid'] = $uid;
					$investdetail['borrow_uid'] = $binfo['borrow_uid'];
					$investdetail['capital'] = $v['capital'];
					$investdetail['interest'] = $v['interest'];
					$investdetail['interest_fee'] = getFloatValue($fee_rate*$v['interest']*(1 - $rate),4);
					$investdetail['interest_fee_yh'] = getFloatValue($fee_rate*$v['interest'],4);
					$investdetail['status'] = 0;
					$investdetail['sort_order'] = $i;
					$investdetail['total'] = $binfo['borrow_duration'];
					$i++;
					$savedetail[] = $investdetail;
				}
			break;
			case 4://每月还息到期还本
				$monthData['month_times'] = $binfo['borrow_duration'];
				$monthData['account'] = $investinfo['investor_capital'];
				$monthData['year_apr'] = $binfo['borrow_interest_rate'];
				$monthData['type'] = "all";
				$repay_detail = EqualEndMonth($monthData);
				
				$investinfo['investor_interest'] = ($repay_detail['repayment_account'] - $investinfo['investor_capital']);
				$investinfo['invest_fee'] = getFloatValue($fee_rate * $investinfo['investor_interest']*(1 - $rate),4);
				$investinfo['invest_fee_yh'] = getFloatValue($fee_rate * $investinfo['investor_interest'],4);
				//$invest_info_id = M('borrow_investor')->add($investinfo);
                                
                                
                                foreach ($investinfo as $key => $val) {			
                                    $upSql .= "{$key}={$val},";

                                }
                                $upSql = rtrim($upSql,",");
                                $sql = sprintf("UPDATE %s SET $upSql where id=%s","{$pre}borrow_investor",$invest_info_id);
                               
                                $rtype = mysql_query($sql);
//				M('borrow_investor')->where("id=".$invest_info_id)->save($investinfo);
				//还款概要END
				
				$monthDataDetail['month_times'] = $binfo['borrow_duration'];
				$monthDataDetail['account'] = $investinfo['investor_capital'];
				$monthDataDetail['year_apr'] = $binfo['borrow_interest_rate'];

				//file_put_contents('/tmp/abc',date('m-d H:i:s')."monthDataDetail".print_r($monthDataDetail,true)."\n",FILE_APPEND);

				$repay_list = EqualEndMonthBYWHH($monthDataDetail);
				//file_put_contents('/tmp/abc',date('m-d H:i:s')."repay_list".print_r($repay_list,true)."\n",FILE_APPEND);
				$i=1;
				foreach($repay_list as $key=>$v){
					$investdetail['borrow_id'] = $borrow_id;
					$investdetail['invest_id'] = $invest_info_id;
					$investdetail['investor_uid'] = $uid;
					$investdetail['borrow_uid'] = $binfo['borrow_uid'];
					$investdetail['capital'] = $v['capital'];
					$investdetail['interest'] = $v['interest'];
					$investdetail['interest_fee'] = getFloatValue($fee_rate*$v['interest']*(1 - $rate),4);
					$investdetail['interest_fee_yh'] = getFloatValue($fee_rate*$v['interest'],4);
					$investdetail['status'] = 0;
					$investdetail['sort_order'] = $i;
					$investdetail['total'] = $binfo['borrow_duration'];
					$i++;
					$savedetail[] = $investdetail;
				}
			//	file_put_contents('/tmp/abc',date('m-d H:i:s')."savedetail".print_r($savedetail,true)."\n",FILE_APPEND);
			break;
			case 5://一次性还款
				$monthData['month_times'] = $binfo['borrow_duration'];
				$monthData['account'] = $investinfo['investor_capital'];
				$monthData['year_apr'] = $binfo['borrow_interest_rate'];
				$monthData['type'] = "all";
				$repay_detail = EqualEndMonthOnly($monthData);
				
				$investinfo['investor_interest'] = ($repay_detail['repayment_account'] - $investinfo['investor_capital']);
				$investinfo['invest_fee'] = getFloatValue($fee_rate * $investinfo['investor_interest']*(1 - $rate),4);
				$investinfo['invest_fee_yh'] = getFloatValue($fee_rate * $investinfo['investor_interest'],4);
				//$invest_info_id = M('borrow_investor')->add($investinfo);
                                $sql = sprintf("UPDATE %s SET investor_interest =%s,invest_fee =%s,invest_fee_yh=%s where id=%s","{$pre}borrow_investor",$investinfo['investor_interest'],$investinfo['invest_fee'],$investinfo['invest_fee_yh'],$invest_info_id);
                                $rtype = mysql_query($sql);
//				M('borrow_investor')->where("id=".$invest_info_id)->save($investinfo);
				//还款概要END				
				$monthDataDetail['month_times'] = $binfo['borrow_duration'];
				$monthDataDetail['account'] = $investinfo['investor_capital'];
				$monthDataDetail['year_apr'] = $binfo['borrow_interest_rate'];
				$monthDataDetail['type'] = "all";
				$repay_list = EqualEndMonthOnly($monthDataDetail);
				$investdetail['borrow_id'] = $borrow_id;
				$investdetail['invest_id'] = $invest_info_id;
				$investdetail['investor_uid'] = $uid;
				$investdetail['borrow_uid'] = $binfo['borrow_uid'];
				$investdetail['capital'] = $repay_list['capital'];
				$investdetail['interest'] = $repay_list['interest'];
				$investdetail['interest_fee'] = getFloatValue($fee_rate*$repay_list['interest']*(1 - $rate),4);
				$investdetail['interest_fee_yh'] = getFloatValue($fee_rate*$repay_list['interest'],4);
				$investdetail['status'] = 0;
				$investdetail['sort_order'] = 1;
				$investdetail['total'] = 1;
				$savedetail[] = $investdetail;
				
			break;
		}
                
		foreach ($savedetail as $key => $val) {
//			$invest_defail_id = M('investor_detail')->add($val);//保存还款详情
                   $vol =  ' ('.implode(',',array_keys($val)).')';
                   $vlaue = ' ('.implode(',',$val).')';
                   
                   $invest_defail_id = mysql_query("INSERT INTO {$pre}investor_detail {$vol} VALUES {$vlaue}");
                   
		}
//		$last_have_money = M("borrow_info")->getFieldById($borrow_id,"has_borrow");
                $result = mysql_query("SELECT has_borrow FROM {$pre}borrow_info WHERE id = $borrow_id  LIMIT 1");
                while($row = mysql_fetch_assoc($result)){
                    $last_have_money = $row['has_borrow'];
                }
//                $last_have_money = $last_have_money['has_borrow'];
                $lasthavemoney = $last_have_money+$money;
                $sql = "update {$pre}borrow_info set `has_borrow`= {$lasthavemoney},borrow_times=borrow_times+1 WHERE `id`={$borrow_id}";
		$upborrow_res = mysql_query($sql);	
		//更新投标进度             
	if($invest_defail_id && $rtype && $upborrow_res){//还款概要和详情投标进度都保存成功
               $bdb->commit();
                mysql_query("COMMIT");//执行事务
//		$investMoney->commit();
        file_put_contents('/tmp/4.txt',date('m-d H:i:s')." comminvest:：".print_r($reqext,true)."\n",FILE_APPEND);
		$res = memberMoneyLog($uid,6,-($money-$reqext),"对{$borrow_id}号标进行投标",$binfo['borrow_uid']);
                            //($uid,$type,$amoney,$info="",$target_uid="",$target_uname="",$fee=0,$reqext=0){
		$today_reward = explode("|",$datag['today_reward']);
		if($binfo['repayment_type']=='1'){//如果是天标，则执行1个月的续投奖励利率
			$reward_rate = floatval($today_reward[0]);
		}else{
			if($binfo['borrow_duration']==1){
				$reward_rate = floatval($today_reward[0]);
			}else if($binfo['borrow_duration']==2){
				$reward_rate = floatval($today_reward[1]);
			}else{
				$reward_rate = floatval($today_reward[2]);
			}
		}
		////////////////////////////////////////回款续投奖励规则 fan 2013-07-20////////////////////////////
		//$reward_rate = floatval($datag['today_reward']);//floatval($datag['today_reward']);//当日回款续投奖励利率
		if($binfo['borrow_type']!=3){//如果是秒标(borrow_type==3)，则没有续投奖励这一说
			$vd['add_time'] = array("lt",time());
			$vd['investor_uid'] = $uid;
			//$borrow_invest_count = M("borrow_investor")->where($vd)->count('id');//检测是否投过标且大于一次
                        $sqlbic = sprintf("SELECT count(id) AS total FROM %s WHERE investor_uid=%s AND add_time<%s","{$pre}borrow_investor",$uid,time());
//                        $borrow_invest_count = mysql_query("SELECT count(id) FROM {$pre}borrow_investor WHERE investor_uid")
                        $resultbic = mysql_query($sqlbic);
                        while($rowbic = mysql_fetch_assoc($resultbic)){
                            $borrow_invest_count = $rowbic['total'];
                        }
			if($reward_rate>0 && $vminfo['back_money']>0 && $borrow_invest_count>0){//首次投标不给续投奖励
				if($money>$vminfo['back_money']){//如果投标金额大于回款资金池金额，有效续投奖励以回款金额资金池总额为标准，否则以投标金额为准
					$reward_money_s = $vminfo['back_money'];
				}else{
					$reward_money_s = $money;
				}
				
				$save_reward['borrow_id'] = $borrow_id;
				$save_reward['reward_uid'] = $uid;
				$save_reward['invest_money'] = $reward_money_s;//如果投标金额大于回款资金池金额，有效续投奖励以回款金额资金池总额为标准，否则以投标金额为准
				$save_reward['reward_money'] = $reward_money_s*$reward_rate/1000;//续投奖励
				$save_reward['reward_status'] = 0;
				$save_reward['add_time'] = time();
				$save_reward['add_ip'] = get_client_ip();
				//$newidxt = M("today_reward")->add($save_reward);
                                $vol =  ' ('.implode(',',array_keys($save_reward)).')';
                                $vlaue = ' ('.implode(',',$save_reward).')';
                                $invest_defail_id = mysql_query("INSERT INTO {$pre}today_reward {$vol} VALUES {$vlaue}");                             				
			}else{
				$result = true;
			}
		}  
		/////////////////////////回款续投奖励结束 2013-05-10 Dqsy///////////////////////////////
		
	
			//////////////////////邀请奖励开始////////////////////////////////////////
                     $sqlm = sprintf("SELECT user_name,recommend_id,usrid FROM %s WHERE id = %s LIMIT 1","{$pre}members",$uid);
                     $result =  mysql_query($sqlm);
                     $vo = mysql_fetch_assoc($result);                
//			$vo = M('members')->field('user_name,recommend_id,usrid')->find($uid);
                     $sql = sprintf("SELECT usrid FROM %s WHERE id = %s LIMIT 1 ","{$pre}members",$vo['recommend_id']); 
                     $result = mysql_query($sql);
                     $recommend_usrid = mysql_fetch_assoc($result);
//			$recommend_usrid = M('members')->field("usrid")->where("id = {$vo['recommend_id']}")->find();
			$_rate = $datag['award_invest']/1000;//推广奖励
			$jiangli = getFloatValue($_rate * $investinfo['investor_capital'],2);
			
			if($vo['recommend_id']!=0){                 
                            $obj = core::Singleton('huifu.huifu');
                            $obj->transfer($jiangli,$recommend_usrid['usrid']);
			    memberMoneyLog($vo['recommend_id'],13,$jiangli,$vo['user_name']."对{$borrow_id}号标投资成功，你获得推广奖励".$jiangli."元。",$uid);
			}
			/////////////////////邀请奖励结束/////////////////////////////////////////
		//$aaa = M('investor_detail')->where('invest_id =2629')->count();
		//if($aaa !=3 ){
		//	exit('aaaaa');
		//}
		if( ($lasthavemoney) == $binfo['borrow_money']){
			borrowFull($borrow_id,$binfo['borrow_type']);//满标，标记为还款中，更新相关数据
		}
		if(!$res){//没有正常记录和扣除帐户余额的话手动回滚
		//	M('investor_detail')->where("invest_id={$invest_info_id}")->delete();
	   	//	M('borrow_investor')->where("id={$invest_info_id}")->delete();
			//更新投标进度
		//	$upborrowsql = "update `{$pre}borrow_info` set ";
		//	$upborrowsql .= "`has_borrow`=".$havemoney.",`borrow_times`=`borrow_times`-1";
		//	$upborrowsql .= " WHERE `id`={$borrow_id}";
		//	$upborrow_res = M()->execute($upborrowsql);
			//更新投标进度
			$done = false;
		}else{
			$done = true;
		}
	}else{
		 mysql_query("ROOLBACK");
	}
         mysql_query("SET AUTOCOMMIT=1");
         mysql_close($handler);
	return $done;
}
//组合MySQL插入语句
// function mysqlAttr($mysqlValue,$table){
//    foreach ($mysqlValue as $key => $val) {
////			$invest_defail_id = M('investor_detail')->add($val);//保存还款详情
//                   $vol =  ' ('.implode(',',array_keys($val)).')';
//                   $vlaue = ' ('.implode(',',$val).')';
//                   
//                   $invest_defail_id ("INSERT INTO {$pre}investor_detail {$vol} VALUES {$vlaue}");
//                   
//		}
//}
//满标处理
function borrowFull($borrow_id,$btype = 0){
	$pre = DB_PREFIX;
	if($btype==3){//秒还标
		borrowApproved($borrow_id);
		sleep(3);
		borrowRepayment($borrow_id,1);
	}else{
            
                                $dd = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME,DB_USER,DB_PWD);
                                $sql = "update %s set borrow_status='%s',full_time = '%s' where id= %s ";
                                $sql = sprintf($sql,"{$pre}borrow_info",4,time(),$borrow_id);
                                $stmt1 = $dd->prepare($sql);                              
                                $result = $stmt1->execute();
                                $dd = null;
                 file_put_contents('/tmp/investmoney.txt',date('m-d H:i:s')."$result".print_r($sql,true)."\n",FILE_APPEND);  
	}
}

//借款成功，进入复审处理
/*
**$borrowid 标ID
**/
//function borrowApproved($borrowid)
//{
//	
//	/////////////////////////////////////////////////////汇付托管 2014-10-09 gwf///////////////////////////////////////////////////////////////
//	/*********************************************************放款操作*******************************************************************************/
//	$pre = C('DB_PREFIX');
//	$field = "b.id,b.investor_uid,b.borrow_uid,b.investor_capital,b.ordid,b.orddate,b.freezeordid,b.freezetrxid,m.usrid,b.investor_fee,b.guar_fee,m.user_name";
//	$investinfo = M("borrow_investor b")->field($field)->join("{$pre}members m ON b.investor_uid=m.id")->where("b.borrow_id=".$borrowid." AND b.status=1")->select();
//	//echo "<pre>";print_r($investinfo);echo "</pre>";exit;
//		
//	//借款人
//	$borrowuid = $investinfo[0]['borrow_uid'];
//	$info1 = M("members")->field("usrid")->where("id=".$borrowuid)->find();
//	$borrowercustid = $info1['usrid'];
//	$borrow_member = M('member_info')->field("real_name")->where("uid = ".$borrowuid)->find();
//
//	
//	//商户客户号
//	$tuoguan = FS("Webconfig/tuoguanconfig");
//	$merCustId = $tuoguan['huifu']['MerCustId'];
//	
//	$total = M("borrow_info")->field("borrow_name,danbao,borrow_money")->where("id=".$borrowid)->find();
//	//如果担保公司存在
//	if($total['danbao'] != 0)
//	{
//		$Guar =M('members')->field("usrid,id")->where("id = ".$total['danbao'])->find();
//		$guar_rate = M('member_guarrate')->where("uid = ".$total['danbao'])->find();//担保费率 					
//		$Guar_merCustId = $Guar['usrid'];//担保merCustId
//	}
//	
//	//初始化汇付参数
//	$usrid = array();//用户客户号
//	$transamt = array();//交易金额
//	$Fee = array();//手续费
//	$subordid = array();//订单号
//	$suborddate = array();//订单日期
//	$divdetails = array();//借款详情
//	$isunfreeze = array();//是否冻结
//	$freezetrxid = array();//冻结订单号
//	$investid = array();//投资ID
//		
//	$i = 0;
//	foreach($investinfo as $v)
//	{
//		
//		$investor_member = M('member_info')->field("real_name")->where("uid = ".$v['investor_uid'])->find();
//
//		$usrid[$i] = $v['usrid'];
//		$transamt[$i] = $v['investor_capital'];
//		$Fee[$i] = number_format($v['investor_fee'],2,'.','');//借款管理费（分开收取）
//		$subordid[$i] = $v['ordid'];
//		$suborddate[$i] = $v['orddate'];
//		
//		$divdetails[$i] = '[{"DivCustId":"'.$merCustId.'","DivAcctId":"MDT000001","DivAmt":"'.$Fee[$i].'"}]';
//		//担保费
//		if($total['danbao'] != 0 && $v['guar_fee']!=0 )
//		{
//			$Guar_fee[$i]=number_format($v['guar_fee'],2,'.','');//担保费（分开收取）
//			$divdetails[$i] = '[';
//			$divdetails[$i] .='{"DivCustId":"'.$merCustId.'","DivAcctId":"MDT000001","DivAmt":"'.$Fee[$i].'"},';
//			$divdetails[$i] .='{"DivCustId":"'.$Guar_merCustId.'","DivAcctId":"MDT000001","DivAmt":"'.$Guar_fee[$i].'"}';
//			$divdetails[$i] .= ']';
//				
//			$Fee[$i] = $v['investor_fee']+$v['guar_fee'];
//			$Fee[$i] = number_format($Fee[$i],2,'.','');  //综合费用
//		}
//		
//		$isunfreeze[$i] = 'Y';
//		$freezetrxid[$i] = $v['freezetrxid'];
//		$investid[$i] = $v['id'];
//		
//		$i++;
//
//		sendsms($v['user_name'], '尊敬的财来网投资人'.$investor_member['real_name'].','.$total['borrow_name'].'已投标完成，你借给'.$borrow_member['real_name'].'的'.$v['investor_capital'].'元资金已划拨，开始计息。详情请咨询客户经理，或致电400-079-8558');
//	}
//	
//	import("ORG.Huifu.Huifu");
//	$huifu = new Huifu();
//	file_put_contents('/tmp/debugs',date('m-d H:i:s')."\$usrid".print_r($usrid,true)."\n",FILE_APPEND);
//	file_put_contents('/tmp/debugs',date('m-d H:i:s')."\$transamt".print_r($transamt,true)."\n",FILE_APPEND);
//	file_put_contents('/tmp/debugs',date('m-d H:i:s')."\$borrowercustid".print_r($borrowercustid,true)."\n",FILE_APPEND);
//	file_put_contents('/tmp/debugs',date('m-d H:i:s')."\$Fee".print_r($Fee,true)."\n",FILE_APPEND);
//	file_put_contents('/tmp/debugs',date('m-d H:i:s')."\$subordid".print_r($subordid,true)."\n",FILE_APPEND);
//	file_put_contents('/tmp/debugs',date('m-d H:i:s')."\$suborddate".print_r($suborddate,true)."\n",FILE_APPEND);
//	file_put_contents('/tmp/debugs',date('m-d H:i:s')."\$divdetails".print_r($divdetails,true)."\n",FILE_APPEND);
//	file_put_contents('/tmp/debugs',date('m-d H:i:s')."\$freezetrxid".print_r($freezetrxid,true)."\n",FILE_APPEND);
//	file_put_contents('/tmp/debugs',date('m-d H:i:s')."\$borrowid".print_r($borrowid,true)."\n",FILE_APPEND);
//	file_put_contents('/tmp/debugs',date('m-d H:i:s')."\$investid".print_r($investid,true)."\n",FILE_APPEND);
//	$huifu->loans_multi($usrid,$transamt,$borrowercustid,$Fee,$subordid,$suborddate,$divdetails,$freezetrxid,$borrowid,$investid);
//	exit;
//	
//	$pre = C('DB_PREFIX');
//	$done = false;
//	$_P_fee = get_global_setting();
//	$invest_integral = $_P_fee['invest_integral'];//投资积分
//	
//	//借款信息
//	$binfo = M("borrow_info")->field("borrow_type,reward_type,reward_num,borrow_fee,borrow_money,borrow_uid,borrow_duration,repayment_type,manage_rate")->find($borrow_id);
//	
//	//投资列表
//	$borrowInvestor = D('borrow_investor');
//	$investorList = $borrowInvestor->field('id,borrow_id,investor_uid,investor_capital,investor_interest,reward_money')->where("borrow_id={$borrow_id}")->select();
//	
//	//借款天数、还款时间
//	$endTime = strtotime(date("Y-m-d",time())." ".$_P_fee['back_time']);
//	if($binfo['borrow_type']==3 || $binfo['repayment_type']==1){//天标或秒标
//		$deadline_last = strtotime("+{$binfo['borrow_duration']} day",$endTime);
//	}else{//月标
//		$deadline_last = strtotime("+{$binfo['borrow_duration']} month",$endTime);
//	} 
//	$getIntegralDays = intval(($deadline_last-$endTime)/3600/24);//借款天数
//     
//	$_investor_num = count($investorList);
//    
//	
//				
//			//////////////////////////////////////////////////////汇付托管 END////////////////////////////////////////////////////////////////////////////
//	
//	foreach($investorList as $key=>$v)
//	{
//		$_reward_money=0;
//		if($binfo['reward_type']>0)
//		{
//			$investorList[$key]['reward_money'] = getFloatValue($v['investor_capital']*$binfo['reward_num']/100,4);
//		}
//		else
//		{
//			$investorList[$key]['reward_money'] = 0;
//		}
//
//		MTip('chk14',$v['investor_uid'],$borrow_id);//sss
//		$upsummary_res = M()->execute("update `{$pre}borrow_investor` set `deadline`={$deadline_last},`status`=4,`reward_money`='".$investorList[$key]['reward_money']."' WHERE `id`={$v['id']} ");
//	}
//	    //更新投资概要
//	    //更新借款信息
//	    $upborrow_res = M()->execute("update `lzh_borrow_info` set `deadline`={$deadline_last},`borrow_status`=6  WHERE `id`={$borrow_id}");
//	    //更新借款信息
//	    //更新投资详细
//
//	    switch($binfo['repayment_type']){
//		    case 2://每月还款
//		    case 3://每季还本
//		    case 4://期未还本
//			    for($i=1;$i<=$binfo['borrow_duration'];$i++){
//				    $deadline=0;
//				    $deadline=strtotime("+{$i} month",$endTime);
//				    $updetail_res = M()->execute("update `lzh_investor_detail` set `deadline`={$deadline},`status`=7 WHERE `borrow_id`={$borrow_id} AND `sort_order`=$i");
//			    }
//		    break;
//		    case 1://按天一次性还款
//			case 5://一次性还款
//				    $deadline=0;
//				    $deadline=$deadline_last;
//				    $updetail_res = M()->execute("update `{$pre}investor_detail` set `deadline`={$deadline},`status`=7 WHERE `borrow_id`={$borrow_id}");
//		    break;
//	    }
//	
//	//更新投资详细
//
//	// 当以上操作没有异常正确执行后执行下面的工作
//	if($done){
//		//借款者帐户
//			$_P_fee=get_global_setting();
//			
//			$_borraccount = memberMoneyLog($binfo['borrow_uid'],17,$binfo['borrow_money'],"第{$borrow_id}号标复审通过，借款金额入帐");//借款入帐
//			
//		if($total['danbao'] != 0){
//				$rates_fee = $guar_rate['guarrate']*$binfo['borrow_money']/100;
//					memberMoneyLog($binfo['borrow_uid'],104,-$rates_fee,"第{$borrow_id}号标借款成功，扣除担保费");//借款者付出担保费
//					memberMoneyLog($Guar['id'],105,$rates_fee,"第{$borrow_id}号标借款成功，获得担保费");//担保者获得担保费
//			}
//		if(!$_borraccount) return false;//借款者帐户处理出错
//			$_borrfee = memberMoneyLog($binfo['borrow_uid'],18,-$binfo['borrow_fee'],"第{$borrow_id}号标借款成功，扣除借款管理费");//借款
//		if(!$_borrfee) return false;//借款者帐户处理出错
//			$_freezefee = memberMoneyLog($binfo['borrow_uid'],19,-$binfo['borrow_money']*$_P_fee['money_deposit']/100,"第{$borrow_id}号标借款成功，冻结{$_P_fee['money_deposit']}%的保证金");//冻结保证金
//			
//		if(!$_freezefee) return false;//借款者帐户处理出错
//		
//		
//		//借款者帐户
//		//投资者帐户
//		$_investor_num = count($investorList);
//		$_remoney_do = true;
//		foreach($investorList as $v){
//			
//			//////////////////////////增加投资者的投资积分 2013-08-28 fans////////////////////////////////////
//		
//			$integ = intval($v['investor_capital']*$getIntegralDays*$invest_integral/1000);
//			//$reintegral = memberIntegralLog($v['investor_uid'],2,$integ,"第{$borrow_id}号标复审通过，应获积分");
//			$reintegral = memberIntegralLog($v['investor_uid'],2,$integ,"第{$borrow_id}号标复审通过，应获积分：".$integ."分,投资金额：".$v['investor_capital']."元,投资天数：".$getIntegralDays."天");
//			if(isBirth($v['investor_uid'])){
//				$reintegral = memberIntegralLog($v['investor_uid'],2,$integ,"亲，祝您生日快乐，本站特赠送您{$integ}积分作为礼物，以表祝福。");
//			}
//			//////////////////////////增加投资者的投资积分 2013-08-28 fans////////////////////////////////////
//			
//			//////////////////////////处理待收金额为负的问题/////////////////////
//			$wmap['investor_uid'] = $v['investor_uid'];
//			$wmap['borrow_id'] = $v['borrow_id'];
//			$daishou = M('investor_detail')->field('interest')->where("investor_uid = {$v['investor_uid']} and borrow_id = {$v['borrow_id']} and invest_id ={$v['id']}")->sum('interest');//待收金额
//			//dump($daishou);exit;
//			//////////////////////////处理待收金额为负的问题/////////////////////
//			//投标奖励
//			if($v['reward_money']>0){
//				$_remoney_do = false;
//				$_reward_m = memberMoneyLog($v['investor_uid'],20,$v['reward_money'],"第{$borrow_id}号标复审通过，获取投标奖励",$binfo['borrow_uid']);
//				$_reward_m_give = memberMoneyLog($binfo['borrow_uid'],21,-$v['reward_money'],"第{$borrow_id}号标复审通过，支付投标奖励",$v['investor_uid']);
//				if($_reward_m && $_reward_m_give) $_remoney_do = true;
//			}
//			//投标奖励
//			
//			$remcollect = memberMoneyLog($v['investor_uid'],15,$v['investor_capital'],"第{$borrow_id}号标复审通过，冻结本金成为待收金额",$binfo['borrow_uid']);
//			//$reinterestcollect = memberMoneyLog($v['investor_uid'],28,$v['investor_interest'],"第{$borrow_id}号标复审通过，应收利息成为待收金额",$binfo['borrow_uid']);
//			$reinterestcollect = memberMoneyLog($v['investor_uid'],28,$daishou,"第{$borrow_id}号标复审通过，应收利息成为待收利息",$binfo['borrow_uid']);
//			//////////////////////邀请奖励开始////////////////////////////////////////
//			$vo = M('members')->field('user_name,recommend_id')->find($v['investor_uid']);
//			$_rate = $_P_fee['award_invest']/1000;//推广奖励
//			$jiangli = getFloatValue($_rate * $v['investor_capital'],2);
//			if($vo['recommend_id']!=0){
//				if(($binfo['borrow_type']=='1' || $binfo['borrow_type']=='2' || $binfo['borrow_type']=='5') && $binfo['repayment_type']!='1'){
//				memberMoneyLog($vo['recommend_id'],13,$jiangli,$vo['user_name']."对{$borrow_id}号标投资成功，你获得推广奖励".$jiangli."元。",$v['investor_uid']);
//				}
//			}
//			/////////////////////邀请奖励结束/////////////////////////////////////////
//			
//		}
//		if(!$_remoney_do||!$remcollect||!$reinterestcollect) return false;//投资者帐户处理出错
//		/////////////////////////回款续投奖励预奖励取消开始 2013-05-10 fans///////////////////////////////
//		$listreward =M("today_reward")->field("reward_uid,reward_money")->where("borrow_id={$borrow_id} AND reward_status=0")->select();
//		if(!empty($listreward))
//		{
//			foreach($listreward as $v)
//			{
//				$vo = M('members')->field('user_name,recommend_id,usrid')->where("id = {$v['reward_uid']}")->find();
//				
//					import("ORG.Huifu.Huifu");
//					$huifu = new Huifu();
//					$huifu->transfer($v['reward_money'],$vo['usrid']);
//				membermoneylog($v['reward_uid'],34,$v['reward_money'],"续投奖励({$borrow_id}号标)预奖励到账",0,"@网站管理员@");
//			}
//			$updata_s['deal_time'] = time();
//			$updata_s['reward_status'] = 1;
//			M("today_reward")->where("borrow_id={$borrow_id} AND reward_status=0")->save($updata_s);
//		}
//		/////////////////////////回款续投奖励预奖励取消结束 2013-05-10 fans///////////////////////////////
//	}
//    
//	return $done;
//}
//
//
////还款处理
///*
//**$borrowid 标ID
//**$sort_order 还款期数
//**$type 还款类型（1：会员自己还，2：网站代还，3：担保公司代还）
//**/
//function borrowRepayment($borrowid,$sort_order,$type=1)
//{
//	$pre = C('DB_PREFIX');
//	$done = false;
//	$borrowDetail = D('investor_detail');
//	$binfo = M("borrow_info")->field("id,borrow_uid,borrow_type,borrow_money,borrow_duration,repayment_type,has_pay,total,deadline,danbao")->find($borrowid);
//	$b_member=M('members')->field("user_name")->find($binfo['borrow_uid']);
//	if( $binfo['has_pay']>=$sort_order) return "本期已还过，不用再还";
//	if( $binfo['has_pay'] == $binfo['total'])  return "此标已经还完，不用再还";
//	if( ($binfo['has_pay']+1)<$sort_order) return "对不起，此借款第".($binfo['has_pay']+1)."期还未还，请先还第".($binfo['has_pay']+1)."期";
//	//if( $binfo['deadline']>time() && $type==2)  return "此标还没逾期，不用代还";
//	
//	////////////////////////////////////////////////////还款操作 gwf 2014-10-29///////////////////////////////////////////////////////////////////////
//	$tuoguan = FS("Webconfig/tuoguanconfig");
//	$merCustId = $tuoguan['huifu']['MerCustId'];
//	$repayinfo = M('investor_detail d')
//					->join(C('DB_PREFIX')."members m ON d.investor_uid=m.id")
//					->join(C('DB_PREFIX')."borrow_investor i ON d.invest_id=i.id")
//					->field("d.id,d.invest_id,d.investor_uid,d.capital,d.interest,d.interest_fee,d.borrow_uid,d.interest_fee_yh,m.usrid,i.ordid,i.orddate")
//					->where("d.borrow_id={$borrowid} AND d.sort_order={$sort_order}")->select();
//	//echo "<pre>";print_r($repayinfo);echo "</pre>";exit;
//		
//	//还款人
//	if($type == 1)
//	{//借款人自己还
//		$borrow_uid = $repayinfo[0]['borrow_uid'];
//		$info1 = M("members")->field("usrid")->where("id=".$borrow_uid)->find();
//		$usrid = $info1['usrid'];//借款人客户号
//	}
//	else if($type == 2)
//	{
//		$tuoguan = FS("Webconfig/tuoguanconfig");
//		$usrid = $tuoguan['huifu']['MerCustId'];
//	}
//	else if($type == 3)
//	{//担保公司代还
//		if($binfo['danbao'] == 0) return "担保公司不存在";
//		$info1 = M("members")->field("usrid")->where("id=".$binfo['danbao'])->find();
//		$usrid = $info1['usrid'];//担保公司客户号
//	}
//		
//	//还款汇付接口数据初始化
//	$transamt=array();//本息
//	$investor =array();//投资人
//	$investorid =array();//投资人
//	$Fee =array();//利息管理费
//	$divdetails =array();//利息管理费详情
//	$subordid =array();//订单号
//	$suborddate =array();//订单日期
//	$repaymentid = array();//还款ID
//		
//	$i = 0;
//	foreach($repayinfo as $v)
//	{
//		$transamt[$i] = $v['capital'] + $v['interest'];//本息
//		$investor[$i] = $v['usrid'];//投资人
//		$investorid[$i] = $v['investor_uid'];//投资人ID
//		$Fee[$i] = number_format($v['interest_fee'],2,'.','');//利息管理费
//		if($v['interest_fee'] == 0)
//		{
//			$divdetails[$i] = '';
//		}
//		else
//		{
//			$divdetails[$i] = '[{"DivCustId":"'.$merCustId.'","DivAcctId":"MDT000001","DivAmt":"'.$Fee[$i].'"}]';
//		}
//		$subordid[$i] = $v['ordid'];//订单号
//		$suborddate[$i] = $v['orddate'];//订单日期
//		$repaymentid[$i] = $v['id'];
//			
//		$i++;
//	}
//	
//	//最后一笔还款
//	if($binfo['total'] == ($binfo['has_pay']+1) && $type==1)
//	{
//		//解除冻结保证金
//		$borrowtrxid = M("borrow_info")->field("freezetrxid")->where("id=".$borrowid)->find();
//		$freezetrxid = $borrowtrxid['freezetrxid'];
//		import("ORG.Huifu.Huifu");
//		$huifu = new Huifu();
//		$huifu->usrUnFreeze($freezetrxid,$borrowid,$sort_order,$type);
//		$huifu->repayment_multi($usrid,$transamt,$Fee,$investor,$divdetails,$subordid,$suborddate,$borrowid,$sort_order,$repaymentid,$investorid,$type);
//	}else{
//		import("ORG.Huifu.Huifu");
//		$huifu = new Huifu();
//		$huifu->repayment_multi($usrid,$transamt,$Fee,$investor,$divdetails,$subordid,$suborddate,$borrowid,$sort_order,$repaymentid,$investorid,$type);
//	}
//	
//		
//	////////////////////////////////////////////////////还款操作 END///////////////////////////////////////////////////////////////////////
//	exit;
//	//企业直投与普通标,判断还款期数不一样
//	$voxe = $borrowDetail->field('sort_order,sum(capital) as capital, sum(interest) as interest,sum(interest_fee) as interest_fee,deadline,substitute_time')->where("borrow_id={$borrow_id}")->group('sort_order')->select();
//	foreach($voxe as $ee=>$ss){
//		if($ss['sort_order']==$sort_order) $vo = $ss;
//	}
//	
//	if($vo['deadline']<time()){//此标已逾期
//		$is_expired = true;
//		if($vo['substitute_time']>0) $is_substitute=true;//已代还
//		else $is_substitute=false;
//		//逾期的相关计算
//		$expired_days = getExpiredDays($vo['deadline']);
//		$expired_money = getExpiredMoney($expired_days,$vo['capital'],$vo['interest']);
//		$call_fee = getExpiredCallFee($expired_days,$vo['capital'],$vo['interest']);
//		//逾期的相关计算
//	}else{
//		$is_expired = false;
//		$expired_days = 0;
//		$expired_money = 0;
//		$call_fee = 0;
//	}
//	//企业直投与普通标,判断还款期数不一样
//	MTip('chk25',$binfo['borrow_uid'],$borrow_id);//sss
//	$accountMoney_borrower = M('member_money')->field('money_freeze,money_collect,account_money,back_money')->find($binfo['borrow_uid']);
//	if($type==1 && $binfo['borrow_type']<>3 && ($accountMoney_borrower['account_money']+$accountMoney_borrower['back_money'])<($vo['capital']+$vo['interest']+$expired_money+$call_fee)) return "帐户可用余额不足，本期还款共需".($vo['capital']+$vo['interest']+$expired_money+$call_fee)."元，请先充值";
//	if($is_substitute && $is_expired){//已代还后的会员还款，则只需要对会员的帐户进行操作后然后更新还款时间即可返回
//		$borrowDetail->startTrans();
//			$datamoney_x['uid'] = $binfo['borrow_uid'];//借款人
//			$datamoney_x['type'] = 11;
//			$datamoney_x['affect_money'] = -($vo['capital']+$vo['interest']);
//			if(($datamoney_x['affect_money']+$accountMoney_borrower['back_money'])<0){//如果需要还款的金额大于回款资金池资金总额
//				$datamoney_x['account_money'] = $accountMoney_borrower['account_money']+$accountMoney_borrower['back_money'] + $datamoney_x['affect_money'];
//				$datamoney_x['back_money'] = 0;
//			}else{
//				$datamoney_x['account_money'] = $accountMoney_borrower['account_money'];
//				$datamoney_x['back_money'] = $accountMoney_borrower['back_money'] + $datamoney_x['affect_money'];//回款资金注入回款资金池
//			}	
//			$datamoney_x['collect_money'] = $accountMoney_borrower['money_collect'];
//			$datamoney_x['freeze_money'] = $accountMoney_borrower['money_freeze'];
//			
//			//会员帐户
//			$mmoney_x['money_freeze']=$datamoney_x['freeze_money'];
//			$mmoney_x['money_collect']=$datamoney_x['collect_money'];
//			$mmoney_x['account_money']=$datamoney_x['account_money'];
//			$mmoney_x['back_money']=$datamoney_x['back_money'];
//			//会员帐户
//			$datamoney_x['info'] = "对{$borrow_id}号标第{$sort_order}期还款";
//			$datamoney_x['add_time'] = time();
//			$datamoney_x['add_ip'] = get_client_ip();
//			$datamoney_x['target_uid'] = 0;
//			$datamoney_x['target_uname'] = '@网站管理员@';
//			$moneynewid_x = M('member_moneylog')->add($datamoney_x);
//			if($moneynewid_x) $bxid_1 = M('member_money')->where("uid={$datamoney_x['uid']}")->save($mmoney_x);
//		//逾期了
//			//逾期罚息
//			$accountMoney = M('member_money')->field('money_freeze,money_collect,account_money,back_money')->find($binfo['borrow_uid']);
//			$datamoney_x = array();
//			$mmoney_x=array();
//			
//			$datamoney_x['uid'] = $binfo['borrow_uid'];
//			$datamoney_x['type'] = 30;
//			$datamoney_x['affect_money'] = -($expired_money);
//			if(($datamoney_x['affect_money']+$accountMoney['back_money'])<0){//如果需要还款的逾期罚息金额大于回款资金池资金总额
//				$datamoney_x['account_money'] = $accountMoney['account_money']+$accountMoney['back_money'] + $datamoney_x['affect_money'];
//				$datamoney_x['back_money'] = 0;
//			}else{
//				$datamoney_x['account_money'] = $accountMoney['account_money'];
//				$datamoney_x['back_money'] = $accountMoney['back_money'] + $datamoney_x['affect_money'];//回款资金注入回款资金池
//			}	
//			$datamoney_x['collect_money'] = $accountMoney['money_collect'];
//			$datamoney_x['freeze_money'] = $accountMoney['money_freeze'];
//			
//			//会员帐户
//			$mmoney_x['money_freeze']=$datamoney_x['freeze_money'];
//			$mmoney_x['money_collect']=$datamoney_x['collect_money'];
//			$mmoney_x['account_money']=$datamoney_x['account_money'];
//			$mmoney_x['back_money']=$datamoney_x['back_money'];
//			//会员帐户
//			$datamoney_x['info'] = "{$borrow_id}号标第{$sort_order}期的逾期罚息";
//			$datamoney_x['add_time'] = time();
//			$datamoney_x['add_ip'] = get_client_ip();
//			$datamoney_x['target_uid'] = 0;
//			$datamoney_x['target_uname'] = '@网站管理员@';
//			$moneynewid_x = M('member_moneylog')->add($datamoney_x);
//			if($moneynewid_x) $bxid_2 = M('member_money')->where("uid={$datamoney_x['uid']}")->save($mmoney_x);
//			
//			//催收费
//			$accountMoney_2 = M('member_money')->field('money_freeze,money_collect,account_money,back_money')->find($binfo['borrow_uid']);
//			$datamoney_x = array();
//			$mmoney_x=array();
//			
//			$datamoney_x['uid'] = $binfo['borrow_uid'];
//			$datamoney_x['type'] = 31;
//			$datamoney_x['affect_money'] = -($call_fee);
//			if(($datamoney_x['affect_money']+$accountMoney_2['back_money'])<0){//如果需要还款的催收费金额大于回款资金池资金总额
//				$datamoney_x['account_money'] = $accountMoney_2['account_money']+$accountMoney_2['back_money'] + $datamoney_x['affect_money'];
//				$datamoney_x['back_money'] = 0;
//			}else{
//				$datamoney_x['account_money'] = $accountMoney_2['account_money'];
//				$datamoney_x['back_money'] = $accountMoney_2['back_money'] + $datamoney_x['affect_money'];//回款资金注入回款资金池
//			}	
//			$datamoney_x['collect_money'] = $accountMoney_2['money_collect'];
//			$datamoney_x['freeze_money'] = $accountMoney_2['money_freeze'];
//				
//			//会员帐户
//			$mmoney_x['money_freeze']=$datamoney_x['freeze_money'];
//			$mmoney_x['money_collect']=$datamoney_x['collect_money'];
//			$mmoney_x['account_money']=$datamoney_x['account_money'];
//			$mmoney_x['back_money']=$datamoney_x['back_money'];
//			//会员帐户
//			$datamoney_x['info'] = "网站对借款人收取的第{$borrow_id}号标第{$sort_order}期的逾期催收费";
//			$datamoney_x['add_time'] = time();
//			$datamoney_x['add_ip'] = get_client_ip();
//			$datamoney_x['target_uid'] = 0;
//			$datamoney_x['target_uname'] = '@网站管理员@';
//			$moneynewid_x = M('member_moneylog')->add($datamoney_x);
//			if($moneynewid_x) $bxid_3 = M('member_money')->where("uid={$datamoney_x['uid']}")->save($mmoney_x);
//		
//		//逾期了
//			$updetail_res = M()->execute("update `{$pre}investor_detail` set `repayment_time`=".time().",`status`=5 WHERE `borrow_id`={$borrow_id} AND `sort_order`={$sort_order}");
//			//更新借款信息
//			$upborrowsql = "update `{$pre}borrow_info` set ";
//			$upborrowsql .= ",`substitute_money`=0";
//			$upborrowsql .= ",`borrow_status`=10";//会员在网站代还后，逾期还款
//			$upborrowsql .= "`repayment_money`=`repayment_money`+{$vo['capital']}";
//			$upborrowsql .= ",`repayment_interest`=`repayment_interest`+ {$vo['interest']}";
//			if ( $sort_order == $binfo['total'] )
//			{
//				$upborrowsql .= ",`borrow_status`=7";
//			}
//			$upborrowsql .= ",`has_pay`={$sort_order}";
//			if ( $is_expired )
//			{
//				$upborrowsql .= ",`expired_money`=`expired_money`+{$expired_money}";
//			}
//			$upborrowsql .= " WHERE `id`={$borrow_id}";
//			$upborrow_res = M()->execute($upborrowsql);
//			//更新借款信息
//
//		if($updetail_res&&$bxid_1&&$bxid_2&&$bxid_3&&$upborrow_res){
//		//if($updetail_res&&$upborrow_res){
//			$borrowDetail->commit() ;
//            //撤销转让的债权 ,完成还款更改债权转让状态
//            cancelDebt($borrow_id);
//			return true;
//		}else{
//			$borrowDetail->rollback() ;
//			return false;
//		}
//	}
//
//
//
//	
//	//企业直投与普通标,判断还款期数不一样
//	  $detailList = $borrowDetail->field('invest_id,investor_uid,capital,interest,interest_fee,borrow_id,total,interest_fee_yh')->where("borrow_id={$borrow_id} AND sort_order={$sort_order}")->select();
//	//企业直投与普通标,判断还款期数不一样
//	
//	/*************************************逾期还款积分与还款状态处理开始 20130509 fans***********************************/
//	$datag = get_global_setting();
//	$credit_borrow = explode("|",$datag['credit_borrow']);
//	if($type==1){//客户自己还款才需要记录这些操作
//		$day_span = ceil(($vo['deadline']-time())/(3600*24));
//		$credits_money = intval($vo['capital']/$credit_borrow[4]);
//		$credits_info = "对第{$borrow_id}号标的还款操作,获取投资积分";
//		if($day_span>=0 && $day_span<1){//正常还款
//			//$credits_result = memberCreditsLog($binfo['borrow_uid'],3,$credits_money*$credit_borrow[0],$credits_info);
//			$credits_result = memberIntegralLog($binfo['borrow_uid'],1,intval($vo['capital']/1000),"对第{$borrow_id}号标进行了正常的还款操作,获取投资积分");//还款积分处理
//			$idetail_status=1;
//		}elseif($day_span>=-3 && $day_span<0){//迟还
//			$credits_result = memberCreditsLog($binfo['borrow_uid'],4,$credits_money*$credit_borrow[1],"对第{$borrow_id}号标的还款操作(迟到还款),扣除信用积分");
//			$idetail_status=3;
//		}elseif($day_span<-3){//逾期还款
//			$credits_result = memberCreditsLog($binfo['borrow_uid'],5,$credits_money*$credit_borrow[2],"对第{$borrow_id}号标的还款操作(逾期还款),扣除信用积分");
//			$idetail_status=5;
//		}elseif($day_span>=1){//提前还款
//			//$credits_result = memberCreditsLog($binfo['borrow_uid'],6,$credits_money*$credit_borrow[3],$credits_info);
//			$credits_result = memberIntegralLog($binfo['borrow_uid'],1,intval($vo['capital'] * $day_span/1000),"对第{$borrow_id}号标进行了提前还款操作,获取投资积分");//还款积分处理
//			$idetail_status=2;
//		}
//		if(!$credits_result) return "因积分记录失败，未完成还款操作";
//	}
//	/*************************************逾期还款积分与还款状态处理结束 20130509 fans***********************************/
//	
//	$borrowDetail->startTrans();
//	//对借款者帐户进行减少
//	$bxid = true;
//	if($type==1){
//		$bxid = false;
//		
//			$datamoney_x['uid'] = $binfo['borrow_uid'];
//			$datamoney_x['type'] = 11;
//			$datamoney_x['affect_money'] = -($vo['capital']+$vo['interest']);
//			if(($datamoney_x['affect_money']+$accountMoney_borrower['back_money'])<0){//如果需要还款的金额大于回款资金池资金总额
//				$datamoney_x['account_money'] = floatval($accountMoney_borrower['account_money']+$accountMoney_borrower['back_money'] + $datamoney_x['affect_money']);
//				$datamoney_x['back_money'] = 0;
//			}else{
//				$datamoney_x['account_money'] = $accountMoney_borrower['account_money'];
//				$datamoney_x['back_money'] = floatval($accountMoney_borrower['back_money']) + $datamoney_x['affect_money'];//回款资金注入回款资金池
//			}	
//			$datamoney_x['collect_money'] = $accountMoney_borrower['money_collect'];
//			$datamoney_x['freeze_money'] = $accountMoney_borrower['money_freeze'];
//			
//			//会员帐户
//			$mmoney_x['money_freeze']=$datamoney_x['freeze_money'];
//			$mmoney_x['money_collect']=$datamoney_x['collect_money'];
//			$mmoney_x['account_money']=$datamoney_x['account_money'];
//			$mmoney_x['back_money']=$datamoney_x['back_money'];
//			
//			//会员帐户
//			$datamoney_x['info'] = "对{$borrow_id}号标第{$sort_order}期还款";
//			$datamoney_x['add_time'] = time();
//			$datamoney_x['add_ip'] = get_client_ip();
//			$datamoney_x['target_uid'] = 0;
//			$datamoney_x['target_uname'] = '@网站管理员@';
//			$moneynewid_x = M('member_moneylog')->add($datamoney_x);
//			if($moneynewid_x) $bxid = M('member_money')->where("uid={$datamoney_x['uid']}")->save($mmoney_x);
//			
//		//逾期了
//		if($is_expired){
//			//逾期罚息
//			if($expired_money>0){
//				$accountMoney = M('member_money')->field('money_freeze,money_collect,account_money,back_money')->find($binfo['borrow_uid']);
//				$datamoney_x = array();
//				$mmoney_x=array();
//				
//				$datamoney_x['uid'] = $binfo['borrow_uid'];
//				$datamoney_x['type'] = 30;
//				$datamoney_x['affect_money'] = -($expired_money);
//				if(($datamoney_x['affect_money']+$accountMoney['back_money'])<0){//如果需要还款的逾期罚息金额大于回款资金池资金总额
//					$datamoney_x['account_money'] = $accountMoney['account_money']+$accountMoney['back_money'] + $datamoney_x['affect_money'];
//					$datamoney_x['back_money'] = 0;
//				}else{
//					$datamoney_x['account_money'] = $accountMoney['account_money'];
//					$datamoney_x['back_money'] = $accountMoney['back_money'] + $datamoney_x['affect_money'];//回款资金注入回款资金池
//				}	
//				$datamoney_x['collect_money'] = $accountMoney['money_collect'];
//				$datamoney_x['freeze_money'] = $accountMoney['money_freeze'];
//				
//				//会员帐户
//				$mmoney_x['money_freeze']=$datamoney_x['freeze_money'];
//				$mmoney_x['money_collect']=$datamoney_x['collect_money'];
//				$mmoney_x['account_money']=$datamoney_x['account_money'];
//				$mmoney_x['back_money']=$datamoney_x['back_money'];
//				
//				//会员帐户
//				$datamoney_x['info'] = "{$borrow_id}号标第{$sort_order}期的逾期罚息";
//				$datamoney_x['add_time'] = time();
//				$datamoney_x['add_ip'] = get_client_ip();
//				$datamoney_x['target_uid'] = 0;
//				$datamoney_x['target_uname'] = '@网站管理员@';
//				$moneynewid_x = M('member_moneylog')->add($datamoney_x);
//				if($moneynewid_x) $bxid = M('member_money')->where("uid={$datamoney_x['uid']}")->save($mmoney_x);
//			}
//			
//			//催收费
//			if($call_fee>0){
//				$accountMoney_borrower = M('member_money')->field('money_freeze,money_collect,account_money,back_money')->find($binfo['borrow_uid']);
//				$datamoney_x = array();
//				$mmoney_x=array();
//				
//				$datamoney_x['uid'] = $binfo['borrow_uid'];
//				$datamoney_x['type'] = 31;
//				$datamoney_x['affect_money'] = -($call_fee);
//				if(($datamoney_x['affect_money']+$accountMoney_borrower['back_money'])<0){//如果需要还款的催收费金额大于回款资金池资金总额
//					$datamoney_x['account_money'] = $accountMoney_borrower['account_money']+$accountMoney_borrower['back_money'] + $datamoney_x['affect_money'];
//					$datamoney_x['back_money'] = 0;
//				}else{
//					$datamoney_x['account_money'] = $accountMoney_borrower['account_money'];
//					$datamoney_x['back_money'] = $accountMoney_borrower['back_money'] + $datamoney_x['affect_money'];//回款资金注入回款资金池
//				}	
//				$datamoney_x['collect_money'] = $accountMoney_borrower['money_collect'];
//				$datamoney_x['freeze_money'] = $accountMoney_borrower['money_freeze'];
//				
//				//会员帐户
//				$mmoney_x['money_freeze']=$datamoney_x['freeze_money'];
//				$mmoney_x['money_collect']=$datamoney_x['collect_money'];
//				$mmoney_x['account_money']=$datamoney_x['account_money'];
//				$mmoney_x['back_money']=$datamoney_x['back_money'];
//				
//				//会员帐户
//				$datamoney_x['info'] = "网站对借款人收取的第{$borrow_id}号标第{$sort_order}期的逾期催收费";
//				$datamoney_x['add_time'] = time();
//				$datamoney_x['add_ip'] = get_client_ip();
//				$datamoney_x['target_uid'] = 0;
//				$datamoney_x['target_uname'] = '@网站管理员@';
//				$moneynewid_x = M('member_moneylog')->add($datamoney_x);
//				if($moneynewid_x) $bxid = M('member_money')->where("uid={$datamoney_x['uid']}")->save($mmoney_x);
//			}
//		}
//		//逾期了
//
//
//	}
//	//对借款者帐户进行减少
//	//更新借款信息
//	$upborrowsql = "update `{$pre}borrow_info` set ";
//	$upborrowsql .= "`repayment_money`=`repayment_money`+{$vo['capital']}";
//	$upborrowsql .= ",`repayment_interest`=`repayment_interest`+ {$vo['interest']}";
//	//if($sort_order == $binfo['total']) $upborrowsql .= ",`borrow_status`=7";//还款完成
//	$upborrowsql .= ",`has_pay`={$sort_order}";
//	//如果是网站代还的，则记录代还金额
//	if($type==2){
//		$total_subs = ($vo['capital']+$vo['interest']);
//		$upborrowsql .= ",`substitute_money`=`substitute_money`+ {$total_subs}";
//		//$upborrowsql .= ",`has_pay`={$binfo['has_pay']}+1";//网站代还款完成
//		if( $binfo['has_pay']+1 == $binfo['total']){
//			$upborrowsql .= ",`borrow_status`=9";//网站代还款完成
//		}
//		
//	}
//	//如果是网站代还的，则记录代还金额
//	if($type==1){
//	  	//$upborrowsql .= ",`has_pay`={$sort_order}";//代还则不记录还到第几期，避免会员还款时，提示已还过
//		if($sort_order == $binfo['total']){
//			$upborrowsql .= ",`borrow_status`=7";//还款完成
//		}
//	}
//	
//	if($is_expired)  $upborrowsql .= ",`expired_money`=`expired_money`+{$expired_money}";//代还则不记录还到第几期，避免会员还款时，提示已还过
//	$upborrowsql .= " WHERE `id`={$borrow_id}";
//	$upborrow_res = M()->execute($upborrowsql);
//	//更新借款信息
//	
//	//更新还款详情表
//	if($type==2){//网站代还
//		$updetail_res = M()->execute("update `{$pre}investor_detail` set `receive_capital`=`capital`,`substitute_time`=".time()." ,`substitute_money`=`substitute_money`+{$total_subs},`status`=4 WHERE `borrow_id`={$borrow_id} AND `sort_order`={$sort_order}");
//	}else if($is_expired){
//		$updetail_res = m( )->execute( "update `{$pre}investor_detail` set `receive_capital`=`capital` ,`receive_interest`=(`interest`-`interest_fee`),`repayment_time`=".time().",`call_fee`={$call_fee},`expired_money`={$expired_money},`expired_days`={$expired_days},`status`={$idetail_status} WHERE `borrow_id`={$borrow_id} AND `sort_order`={$sort_order}" );
//	}else{
//		$updetail_res = M()->execute("update `{$pre}investor_detail` set `receive_capital`=`capital` ,`receive_interest`=(`interest`-`interest_fee`),`repayment_time`=".time().", `status`={$idetail_status} WHERE `borrow_id`={$borrow_id} AND `sort_order`={$sort_order}");
//	}
//	//更新还款详情表
//	//更新还款概要表
//	$smsUid = "";
//	foreach($detailList as $v){
//        //用于判断是否债权转让 ,债权转让日志不一样
//        $debt = M("invest_detb")->field("serialid")->where("invest_id={$v['invest_id']} and status=1")->find();
//      
//		$getInterest = $v['interest'] - $v['interest_fee'];
//		$upsql = "update `{$pre}borrow_investor` set ";
//		$upsql .= "`receive_capital`=`receive_capital`+{$v['capital']},";
//		$upsql .= "`receive_interest`=`receive_interest`+ {$getInterest},";
//		if($type==2){
//			$total_s_invest = $v['capital'] + $getInterest;
//			$upsql .= "`substitute_money` = `substitute_money` + {$total_s_invest},";
//		}
//		if($sort_order == $binfo['total']) $upsql .= "`status`=5,";//还款完成
//		$upsql .= "`paid_fee`=`paid_fee`+{$v['interest_fee']}";
//		$upsql .= " WHERE `id`={$v['invest_id']}";
//		$upinfo_res = M()->execute($upsql);
//		
//		//对投资帐户进行增加
//		if($upinfo_res){
//			$accountMoney = M('member_money')->field('money_freeze,money_collect,account_money,back_money')->find($v['investor_uid']);
//			$datamoney['uid'] = $v['investor_uid'];
//			$datamoney['type'] = ($type==2)?"10":"9";
//			$datamoney['affect_money'] = ($v['capital']+$v['interest']);//先收利息加本金，再扣管理费
//			//$datamoney['account_money'] = $accountMoney['account_money'];
//			$datamoney['collect_money'] = $accountMoney['money_collect'] - $datamoney['affect_money'];
//			$datamoney['freeze_money'] = $accountMoney['money_freeze'];
//
//			///////////////秒标回款不进入汇款资金池，也就可实现秒标回款不给回款续投奖励的功能了 2013-08-23 fan//////////////////
//
//			if($binfo['borrow_type']<>3 ){//如果不是秒标，那么回的款会进入回款资金池，如果是秒标，回款则会进入充值资金池
//				$datamoney['account_money'] = $accountMoney['account_money'];
//				$datamoney['back_money'] = ($accountMoney['back_money'] + $datamoney['affect_money']);
//			}else{
//				$datamoney['account_money'] = $accountMoney['account_money'] + $datamoney['affect_money'];
//				$datamoney['back_money'] = $accountMoney['back_money'];
//			}
//
//			///////////////秒标回款不进入汇款资金池，也就可实现秒标回款不给回款续投奖励的功能了 2013-08-23 fan//////////////////
//			
//			//会员帐户
//			$mmoney['money_freeze']=$datamoney['freeze_money'];
//			$mmoney['money_collect']=$datamoney['collect_money'];
//			$mmoney['account_money']=$datamoney['account_money'];
//			$mmoney['back_money']=$datamoney['back_money'];
//
//			//会员帐户
//			$datamoney['info'] = ($type==2)?"网站对{$v['borrow_id']}号标第{$sort_order}期代还":"收到会员对{$v['borrow_id']}号标第{$sort_order}期的还款";
//            //如果债权流水号存在
//            $debt['serialid'] &&  $datamoney['info'] = ($type==2)?"网站对{$debt['serialid']}号债权第{$sort_order}期代还":"收到会员对{$debt['serialid']}号债权第{$sort_order}期的还款";
//			$datamoney['add_time'] = time();
//			$datamoney['add_ip'] = get_client_ip();
//			if($type==2){
//				$datamoney['target_uid'] = 0;
//				$datamoney['target_uname'] = '@网站管理员@';
//			}else{
//				$datamoney['target_uid'] = $binfo['borrow_uid'];
//				$datamoney['target_uname'] = $b_member['user_name'];
//			}
//			$moneynewid = M('member_moneylog')->add($datamoney);
//			if($moneynewid){
//				$xid = M('member_money')->where("uid={$datamoney['uid']}")->save($mmoney);
//			}
//			
//			if($type==2){//如果是网站代还
//				MTip('chk18',$v['investor_uid'],$borrow_id);//sss
//			}else{
//				MTip('chk16',$v['investor_uid'],$borrow_id);//sss
//			}
//			$smsUid .= (empty($smsUid))?$v['investor_uid']:",{$v['investor_uid']}";
//			
//			//利息管理费
//			$xid_z = true;
//			if($v['interest_fee']>0 && $type==1){
//				$xid_z = false;
//				$accountMoney_z = M('member_money')->field('money_freeze,money_collect,account_money,back_money')->find($v['investor_uid']);
//				$datamoney_z['uid'] = $v['investor_uid'];
//				$datamoney_z['type'] = 23;
//				$datamoney_z['affect_money'] = -($v['interest_fee']);//扣管理费
//				
//				$datamoney_z['collect_money'] = $accountMoney_z['money_collect'];
//				$datamoney_z['freeze_money'] = $accountMoney_z['money_freeze'];
//				if(($accountMoney_z['back_money'] + $datamoney_z['affect_money'])<0){
//					$datamoney_z['back_money'] =0;
//					$datamoney_z['account_money'] = $accountMoney_z['account_money'] +$accountMoney_z['back_money']+ $datamoney_z['affect_money'];
//				}else{
//					$datamoney_z['account_money'] = $accountMoney_z['account_money'];
//					$datamoney_z['back_money'] = ($accountMoney_z['back_money'] + $datamoney_z['affect_money']);
//				}
//				
//				//会员帐户
//				$mmoney_z['money_freeze']=$datamoney_z['freeze_money'];
//				$mmoney_z['money_collect']=$datamoney_z['collect_money'];
//				$mmoney_z['account_money']=$datamoney_z['account_money'];
//				$mmoney_z['back_money']=$datamoney_z['back_money'];
//				
//				//会员帐户
//				$datamoney_z['info'] = "网站已将第{$v['borrow_id']}号标第{$sort_order}期还款的利息管理费扣除优惠了".($v['interest_fee_yh']-$v['interest_fee'])."元";
//				$datamoney_z['add_time'] = time();
//				$datamoney_z['add_ip'] = get_client_ip();
//				$datamoney_z['target_uid'] = 0;
//				$datamoney_z['target_uname'] = '@网站管理员@';
//				$moneynewid_z = M('member_moneylog')->add($datamoney_z);
//				if($moneynewid_z) $xid_z = M('member_money')->where("uid={$datamoney_z['uid']}")->save($mmoney_z);
//			}
//		   //利息管理费
//		}
//		//对投资帐户进行增加
//		
//	}
//	//更新还款概要表
//	//echo "$updetail_res && $upinfo_res && $xid &&$upborrow_res && $bxid && $xid_z";
//	if($updetail_res && $upinfo_res && $xid &&$upborrow_res && $bxid && $xid_z){
//		$borrowDetail->commit() ;
//         //撤销转让的债权 ,完成还款更改债权转让状态
//         cancelDebt($borrow_id);
//         
//		$_last = true;
//		if($binfo['total'] == ($binfo['has_pay']+1) && $type==1){
//			$_last=false;
//			$borrowtrxid = M("borrow_info")->field("freezetrxid")->where("id=".$borrow_id)->find();
//			$freezetrxid = $borrowtrxid['freezetrxid'];
//			import("ORG.Huifu.Huifu");
//			$huifu = new Huifu();
//			$huifu->usrUnFreeze($freezetrxid);
//			$_is_last = lastRepayment($binfo);//最后一笔还款
//			if($_is_last) $_last = true;
//		}
//		$done=true;
//
//		$vphone = M("member_info")->field("cell_phone")->where("uid in({$smsUid}) and cell_phone !=''")->select();
//		$sphone = "";
//		foreach($vphone as $v){
//			$sphone.=(empty($sphone))?$v['cell_phone']:",{$v['cell_phone']}";
//		}
//		SMStip("payback",$sphone,array("#ID#","#ORDER#"),array($borrow_id,$sort_order));
//
//	}else{
//		$borrowDetail->rollback();
//	}
//	
//	return $done;
//}


        //注册成功，添加红包 by zxm 2015-09-22
        function addMemberRedpacket($map){
//            file_put_contents('/tmp/app',date('H:i:s').': '.print_r($map,true),FILE_APPEND);

            $db  = core::db()->getConnect('CAILAI',true);
            $ssql=  sprintf("SELECT id FROM lzh_members WHERE user_name=%s",$map['usrid']);
            $res=$db->query($ssql,1);
//            
//            file_put_contents('/tmp/app',date('H:i:s').': '.print_r($res,true),FILE_APPEND);
//            file_put_contents('/tmp/app',date('H:i:s').': '.print_r($ssql,true),FILE_APPEND);
            $sql = sprintf("insert into %s set addtime='%s',rednum='%s',shelftime='%s',facevalue='%s',overtime='%s',owner='%s',is_success='%s',is_used='%s',note='%s'",'lzh_active_redpacket',$map['addtime'],$map['rednum'],$map['shelftime'],$map['facevalue'],$map['overtime'],$res,$map['is_success'],$map['is_used'],$map['note']);
//            file_put_contents('/tmp/app',date('H:i:s').': '.print_r($sql,true),FILE_APPEND);
            $result = $db->query($sql);
            return mysql_insert_id();
        }


?>