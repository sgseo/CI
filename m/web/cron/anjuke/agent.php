<?php
require_once(dirname(__FILE__).'/../../www/header.php');
$argv = $_SERVER["argv"];

$run_num = $argv[1]?$argv[1]:5000;


$agent = core::Singleton("comm.anjuke.agent"); 

$objDb = core::db()->getConnect('CAILAI');

$sql = "select agent_id from lzh_anjuke_agent order by id desc limit 1";
$res = $objDb->query($sql,'array');

$agent_id = $res['agent_id']?$res['agent_id']+1:1100000;
$run_num = $run_num+$agent_id;


while($agent_id  < $run_num){
	echo 'agent_id:'.$agent_id;
	$req =  $agent->get_message($agent_id);
	var_dump($req);
	$datetime = date('Y-m-d H:i:s',time());
	if(is_array($req)){
		echo 'success';
		$sql = sprintf("insert into lzh_anjuke_agent set name='%s',mobile='%s',shop='%s',agent_id='%s',city='%s',update_time='%s'",
$req['name'],$req['phone'],$req['shop'],$agent_id,$req['diqu'],$datetime);
		$objDb->query($sql);
	}	
	$agent_id++;
}

