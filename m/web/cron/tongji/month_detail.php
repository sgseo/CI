<?php
require_once(dirname(__FILE__).'/../../www/header.php');
//统计我的每个月的收益
$objDb = core::db()->getConnect('CAILAI');

		//当前月的第一天和最后一天
		//echo date('Y-m-t',strtotime("+2 month")); 后两个月的最后一天
		//die;
		$i=date('m');
		$firstday=strtotime(date('Y-'.$i.'-01 0:0:0'));
		$endday = strtotime(date('Y-'.($i+1).'-01 0:0:0'));

		if($i==12)
		{
			$endday = strtotime(date('Y-12-31 23:59:59'));
		}
		
		//查询这一个月的投资总额
		$sql="select investor_uid,sum(investor_capital) as ic from lzh_borrow_investor where add_time>=".$firstday." and add_time<".$endday." group by investor_uid";
		$res = $objDb->query($sql);
		while($row = mysql_fetch_assoc($res))
		{
			$rows[] = $row;
		}
		// echo "<pre/>";var_dump($rows);
		// die;
		//当前年月
		$year=date('Y');
		//英文缩写
		$month=array('jan','feb','mar','apr','may','jun','july','aug','sep','otm','nov','dece');
		$data['year']=$year;
		//echo "<pre/>"; var_dump($res);
		foreach ($rows as $key => $value) {
			$value['ic']=$value['ic']?$value['ic']:0;
				//数据更新
			$sql='update lzh_month_detail set year='.$year.",".$month[$i-1]."=".$value['ic']." where user_id=".$value['investor_uid'];
			//echo $sql."<br/>";
			$res= $objDb->query($sql);

		}
		//var_dump($res);
		// if(in_array('false',$res))
		// {
		// 	echo "数据更新失败";
		// }else{
		
		// 	echo "数据更新成功";
		// }