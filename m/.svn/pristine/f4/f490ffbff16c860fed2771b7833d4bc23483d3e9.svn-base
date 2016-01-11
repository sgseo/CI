<?php
require_once(dirname(__FILE__).'/../../www/header.php');

//用于汇付天下用户账户资金检测

$argv = $_SERVER["argv"];

$mobile = $argv[1]?$argv[1]:'';
if($mobile){
	$where = " user_name={$mobile}";
}else{
	$where = ' last_update is null ';
}


//查询检查列表
$objDb = core::db()->getConnect('CAILAI');
$sql = "SELECT id,usrid FROM `lzh_members_moneycheck` where {$where} limit 50 ";	
echo $sql;
$res = $objDb->query($sql);

while($row = mysql_fetch_assoc($res)){
	$rows[] = $row;
}
if(!is_array($rows)){
	echo '查询失败！';exit;
}

foreach($rows as $k=>$v){
	$huifu_account = '';
	$huifu_avail = '';
	$huifu_freeze = '';
	
	$cailai_account = '';
	$cailai_avail = '';
	$cailai_freeze = '';
		
	//获取汇付天下数据	
	
	$res = file_get_contents("https://www.cailai.com/index/duizhang?usrid={$v['usrid']}");
	$res = json_decode($res,true);
	if(is_array($res)){
		$huifu_account = $res['AcctBal']?str_replace(',','',$res['AcctBal']):'';
		$huifu_avail = $res['AvlBal']?str_replace(',','',$res['AvlBal']):'';
		$huifu_freeze = $res['FrzBal']?str_replace(',','',$res['FrzBal']):'';
	}
	unset($res);	
	//获取财来网数据	
	$sql = "SELECT money_freeze,account_money,back_money FROM `lzh_member_money` where uid={$v['id']}";
	$res = $objDb->query($sql,'array');
	if(is_array($res)){
	$cailai_avail = sprintf("%.2f", $res['account_money']+$res['back_money']);
	$cailai_freeze = $res['money_freeze']?sprintf("%.2f",$res['money_freeze']):'';
	$cailai_account = sprintf("%.2f",$cailai_avail+$cailai_freeze);
	}
	
	if($huifu_account == $cailai_account && $huifu_avail == $cailai_avail && $huifu_freeze == $cailai_freeze)
		$is_equal = 1;
	else 
		$is_equal = 0;
	$last_update = date('Y-m-d H:i:s',time());
	//入库
	$sql = "update `lzh_members_moneycheck` set cailai_account = '{$cailai_account}',cailai_avail = '{$cailai_avail}',
cailai_freeze = '{$cailai_freeze}',huifu_account = '{$huifu_account}',huifu_avail = '{$huifu_avail}',huifu_freeze =
'{$huifu_freeze}',last_update = '{$last_update}',is_equal = '{$is_equal}' where id='{$v['id']}'";
echo $sql;
	$objDb->query($sql);
	sleep(1);
}








exit;
