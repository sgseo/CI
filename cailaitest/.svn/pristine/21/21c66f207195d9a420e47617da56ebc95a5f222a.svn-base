<?php
header("Content-Type: text/html;charset=utf-8");
// 全局设置
class OrderAction extends MCommonAction
{
	
	public function index(){

	$this->display();
	}
	public function order(){
		
	$data['html'] = $this->fetch();
		exit(json_encode($data));
	}
	public function orderquery(){
		$platform='p1';//平台乾多多标识
		$LoanNo=$_POST['LoanNo'];//乾多多流水号
		$OrderNo=$_POST['OrderNo'];//网贷平台订单号
		$BatchNo=$_POST['BatchNo'];//网贷平台标号
		$BeginTime=$_POST['start_time'];//开始时间
		$EndTime=$_POST['end_time'];//结束时间
		  import("ORG.Loan.Escrow");
         //$url='http://218.4.234.150:88/main/loan/loanorderquery.action';
		
        $loan = new Escrow();
		
       // $orderdata =  $loan->orderquery($orderdata,$url);
		
			$out=$loan->loanOrder($platform,$LoanNo,$OrderNo,$BatchNo,$BeginTime, $EndTime);
			//echo $out;
	$this->assign('out',$out);
	
	//$data['html'] = $this->fetch();
	//dump(json_encode($data));	
		$this->display();
	}
}
?>