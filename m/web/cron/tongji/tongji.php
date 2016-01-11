<?php
require_once(dirname(__FILE__).'/../../www/header.php');

//用于官方统计
	
$objDb = core::db()->getConnect('CAILAI');

//首页统计
$sql = "SELECT SUM(investor_capital) as sum FROM `lzh_borrow_investor`";
$res = $objDb->query($sql,'array');
$get_money = $res['sum'];//累计帮助企业和个人融资
    	
$sql2 = "SELECT SUM(investor_interest) as sum FROM `lzh_borrow_investor`";
$res2 = $objDb->query($sql2,'array');
$make_money = $res2['sum'];//为投资人赚取收益
		
//$sql3 = "select sum(capital+interest) as sum from lzh_investor_detail where repayment_time=0";//待收余额
$date = date('Y-m-d',strtotime(" -1 day"));
$date_start = strtotime($date.' 00:00:00');
$date_end = strtotime($date.' 23:59:59');   	
$sql3 = "SELECT SUM(borrow_money) as sum FROM `lzh_borrow_info` where add_time>{$date_start} and add_time<{$date_end}";
$res3 = $objDb->query($sql3,'array');
$needgot_money = $res3['sum']?$res3['sum']:0;//昨日交易额
//首页统计入库
    	
$sql4 = "truncate `lzh_home_tongji`";
$objDb->query($sql4);
$sql4 = "insert into `lzh_home_tongji` set get_money='{$get_money}',make_money='{$make_money}',needgot_money='{$needgot_money}'";
$objDb->query($sql4);
    	
//投资榜
$sql5 = "truncate `lzh_amount_top`";
$objDb->query($sql5);
$before_30 = strtotime(date('Y-m-d H:i:s',strtotime('- 30 day')));
$sql5 = "select b.cell_phone,SUM(investor_capital) as sum1,SUM(investor_interest) as sum2 from `lzh_borrow_investor` a inner join `lzh_member_info` b on a.investor_uid = b.uid where add_time>'{$before_30}'  group by investor_uid order by sum1 desc limit 30";
$res5 = $objDb->query($sql5);   	    	
while($row = mysql_fetch_assoc($res5)){
    $sql5 = "insert into `lzh_amount_top` set username='{$row['cell_phone']}',money='{$row['sum1']}',got_money='{$row['sum2']}'";
    $objDb->query($sql5);
}
exit;
