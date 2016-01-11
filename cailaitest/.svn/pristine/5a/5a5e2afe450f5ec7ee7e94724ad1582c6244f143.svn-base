<?php
// 本类由系统自动生成，仅供测试用途
class AgreementAction extends MCommonAction {
	
 public function downfile(){
		$per = C('DB_PREFIX');
		$borrow_config = require C("APP_ROOT")."Conf/borrow_config.php";
		$invest_id=intval($_GET['id']);
		//$borrow_id=intval($_GET['id']);
		//old
		//$iinfo = M('borrow_investor')->field('id,borrow_id,investor_capital,investor_interest,deadline,investor_uid,add_time')->where("(investor_uid={$this->uid} OR borrow_uid={$this->uid}) AND id={$invest_id}")->find();
		$iinfo = M('borrow_investor')->field('id,borrow_id,investor_capital,investor_interest,deadline,investor_uid,add_time')->where("investor_uid={$this->uid} AND id={$invest_id}")->find();
		$investor_capital_big = cny($iinfo['investor_capital']);
		
		$borrow_id = $iinfo['borrow_id'];
		//dump( $borrow_id);
		//exit;
		$binfo = M('borrow_info bi')->field('bi.id,bi.repayment_type,bi.borrow_duration,bi.borrow_uid,bi.borrow_type,bi.borrow_use,bi.borrow_money,bi.full_time,bi.add_time,bi.borrow_interest_rate,bi.deadline,bi.second_verify_time,bi.collect_time,mi.real_name')->join("{$per}member_info mi ON bi.danbao=mi.uid")->find($borrow_id);
		//dump($iinfo);
		//dump(M("members m")->getlastsql());
		//exit;
		$mBorrow = M("members m")->join("{$per}member_info mi ON mi.uid=m.id")->field('mi.real_name,m.user_name,mi.idcard')->where("m.id={$binfo['borrow_uid']}")->find();
		//$mInvest = M("members m")->join("{$per}member_info mi ON mi.uid=m.id")->field('mi.real_name,m.user_name')->where("m.id={$iinfo['investor_uid']}")->find();
		$mInvest = M("members m")->join("{$per}member_info mi ON mi.uid=m.id")->field('mi.real_name,mi.address,mi.cell_phone,mi.idcard,m.user_name,m.user_email')->where("m.id={$iinfo['investor_uid']}")->find();
		//if(!is_array($iinfo)||!is_array($binfo)||!is_array($mBorrow)||!is_array($mInvest)) exit;
		
		$detail = M('investor_detail d')->field('d.borrow_id,d.investor_uid,d.borrow_uid,d.capital,sum(d.capital+d.interest-d.interest_fee) benxi,d.total')->where("d.borrow_id={$iinfo['borrow_id']} and d.invest_id ={$iinfo['id']}")->group('d.investor_uid')->find();

		//$detailinfo = M('investor_detail d')->join("{$per}borrow_investor bi ON bi.id=d.invest_id")->join("{$per}members m ON m.id=d.investor_uid")->field('d.borrow_id,d.investor_uid,d.borrow_uid,d.capital,sum(d.capital+d.interest-d.interest_fee) benxi,d.total,m.user_name,bi.investor_capital,bi.add_time')->where("d.borrow_id={$iinfo['borrow_id']} and d.invest_id ={$iinfo['id']}")->group('d.investor_uid')->find();
		$detailinfo = M('investor_detail d')->field('d.borrow_id,d.investor_uid,d.borrow_uid,(d.capital+d.interest-d.interest_fee) benxi,d.capital,d.interest,d.interest_fee,d.sort_order,d.deadline')->where("d.borrow_id={$iinfo['borrow_id']} and d.invest_id ={$iinfo['id']}")->select();
		
		
		$time = M('borrow_investor')->field('id,add_time')->where("borrow_id={$iinfo['borrow_id']} order by add_time asc")->limit(1)->find();
		
		if($binfo['repayment_type']==1){
				$deadline_last = strtotime("+{$binfo['borrow_duration']} day",$time['add_time']);
			}else{
				$deadline_last = strtotime("+{$binfo['borrow_duration']} month",$time['add_time']);
			}
		$this->assign('deadline_last',$deadline_last);
		$this->assign('detailinfo',$detailinfo);
		$this->assign('detail',$detail);

		$type1 = $this->gloconf['BORROW_USE'];
		$binfo['borrow_use'] = $type1[$binfo['borrow_use']];
		$ht=M('hetong')->field('hetong_img,name,dizhi,tel')->find();
		
		$this->assign("ht",$ht);
		$type = $borrow_config['REPAYMENT_TYPE'];
		//echo $binfo['repayment_type'];
		$binfo['repayment_name'] = $type[$binfo['repayment_type']];

		$iinfo['repay'] = getFloatValue(($iinfo['investor_capital']+$iinfo['investor_interest'])/$binfo['borrow_duration'],2);
		
		$this->assign("bid","bytp2pD");
		
		$this->assign('investor_capital_big',$investor_capital_big);
		$this->assign('iinfo',$iinfo);
		$this->assign('binfo',$binfo);
		$this->assign('mBorrow',$mBorrow);
		$this->assign('mInvest',$mInvest);
		$this->assign('borrow_id',$borrow_id);

		$detail_list = M('investor_detail')->field(true)->where("invest_id={$invest_id}")->select();
		$this->assign("detail_list",$detail_list);
		//echo "<pre>";print_r($binfo);echo "</pre>";exit;
		//$this->display("index");exit;
		Vendor('Mpdf.mpdf');
			$mpdf=new mPDF('UTF-8','A4','','',15,15,4,15);
			$mpdf->useAdobeCJK = true;
			$mpdf->SetAutoFont(AUTOFONT_ALL);
			$mpdf->SetDisplayMode('fullpage');
			$mpdf->SetAutoFont();
			$mpdf->SetHTMLFooter(' >>{PAGENO}<<');
			$mpdf->WriteHTML($this->fetch('index'));
			$mpdf->Output('cailaijinfu.pdf','I');
			exit;
		$this->display("index");
		
		//$html = $this->fetch('index');
		
		//$this->mypdf->writeHTML($html, true, false, true, false, '');
		
		
		//$this->mypdf->MultiCell(0, 5, "ssssssssssssssssssssssssssssssss", 0, 'J', 0, 2, '', '', true, 0, false);		
		
		//路径,x坐标,y坐标,图片宽度,图片高度（''表示自适应）,网址,
		//$mask = $this->mypdf->Image($this->pdfPath.'images/alpha.png', 130, 0, 100, '', '', '', '', false, 100, '', true);
		//$this->mypdf->Image($this->pdfPath.'images/image_with_alpha.png', 130, 0, 60, 60, '', '', '', false, 10, '', true, $mask);//出图的,放在后面图就在上层，放在前面图就在下层
		//$this->mypdf->Image($this->pdfPath.'images/236.png', 130, 200, 50, 50, '', '', '', false, 10, '', true,$html);//出图的,放在后面图就在上层，放在前面图就在下层

		// ---------------------------------------------------------
		
		//Close and output PDF document
		//$this->mypdf->Output('jiedaihetong.pdf', 'I');
		
    }
	
 public function downliuzhuanfile(){
		$per = C('DB_PREFIX');
		$borrow_config = require C("APP_ROOT")."Conf/borrow_config.php";
		$invest_id=intval($_GET['id']);
		//$borrow_id=intval($_GET['id']);
		//old
		//$iinfo = M('borrow_investor')->field('id,borrow_id,investor_capital,investor_interest,deadline,investor_uid,add_time')->where("(investor_uid={$this->uid} OR borrow_uid={$this->uid}) AND id={$invest_id}")->find();
		$iinfo = M('borrow_investor')->field('id,borrow_id,investor_capital,investor_interest,deadline,investor_uid,add_time')->where("investor_uid={$this->uid} AND id={$invest_id}")->find();
		$investor_capital_big = cny($iinfo['investor_capital']);
		
		$borrow_id = $iinfo['borrow_id'];
		//dump( $borrow_id);
		//exit;
		$binfo = M('borrow_info bi')->field('bi.id,bi.repayment_type,bi.borrow_duration,bi.borrow_uid,bi.borrow_type,bi.borrow_use,bi.borrow_money,bi.full_time,bi.add_time,bi.borrow_interest_rate,bi.deadline,bi.second_verify_time,bi.collect_time,mi.real_name,mi.stamp_img')->join("{$per}member_info mi ON bi.danbao=mi.uid")->find($borrow_id);
		//dump($iinfo);
		//dump(M("members m")->getlastsql());
		//exit;
		$mBorrow = M("members m")->join("{$per}member_info mi ON mi.uid=m.id")->field('mi.real_name,m.user_name,mi.idcard,mi.stamp_img')->where("m.id={$binfo['borrow_uid']}")->find();
		//$mInvest = M("members m")->join("{$per}member_info mi ON mi.uid=m.id")->field('mi.real_name,m.user_name')->where("m.id={$iinfo['investor_uid']}")->find();
		$mInvest = M("members m")->join("{$per}member_info mi ON mi.uid=m.id")->field('mi.real_name,mi.address,mi.cell_phone,mi.idcard,m.user_name,m.user_email')->where("m.id={$iinfo['investor_uid']}")->find();
		//if(!is_array($iinfo)||!is_array($binfo)||!is_array($mBorrow)||!is_array($mInvest)) exit;
		
		$detail = M('investor_detail d')->field('d.borrow_id,d.investor_uid,d.borrow_uid,d.capital,sum(d.capital+d.interest-d.interest_fee) benxi,d.total')->where("d.borrow_id={$iinfo['borrow_id']} and d.invest_id ={$iinfo['id']}")->group('d.investor_uid')->find();

		//$detailinfo = M('investor_detail d')->join("{$per}borrow_investor bi ON bi.id=d.invest_id")->join("{$per}members m ON m.id=d.investor_uid")->field('d.borrow_id,d.investor_uid,d.borrow_uid,d.capital,sum(d.capital+d.interest-d.interest_fee) benxi,d.total,m.user_name,bi.investor_capital,bi.add_time')->where("d.borrow_id={$iinfo['borrow_id']} and d.invest_id ={$iinfo['id']}")->group('d.investor_uid')->find();
		$detailinfo = M('investor_detail d')->field('d.borrow_id,d.investor_uid,d.borrow_uid,(d.capital+d.interest-d.interest_fee) benxi,d.capital,d.interest,d.interest_fee,d.sort_order,d.deadline')->where("d.borrow_id={$iinfo['borrow_id']} and d.invest_id ={$iinfo['id']}")->select();
		
		
		$time = M('borrow_investor')->field('id,add_time')->where("borrow_id={$iinfo['borrow_id']} order by add_time asc")->limit(1)->find();
		
		if($binfo['repayment_type']==1){
				$deadline_last = strtotime("+{$binfo['borrow_duration']} day",$time['add_time']);
			}else{
				$deadline_last = strtotime("+{$binfo['borrow_duration']} month",$time['add_time']);
			}
		$this->assign('deadline_last',$deadline_last);
		$this->assign('detailinfo',$detailinfo);
		$this->assign('detail',$detail);

		$type1 = $this->gloconf['BORROW_USE'];
		$binfo['borrow_use'] = $type1[$binfo['borrow_use']];
		$ht=M('hetong')->field('hetong_img,name,dizhi,tel')->find();
		
		$this->assign("ht",$ht);
		$type = $borrow_config['REPAYMENT_TYPE'];
		//echo $binfo['repayment_type'];
		$binfo['repayment_name'] = $type[$binfo['repayment_type']];
	//	dump($binfo['stamp_img']);exit;
		
		$iinfo['repay'] = getFloatValue(($iinfo['investor_capital']+$iinfo['investor_interest'])/$binfo['borrow_duration'],2);
		$this->assign("bid","bytp2pD");
		//print_r($type);
		$this->assign('investor_capital_big',$investor_capital_big);
		$this->assign('iinfo',$iinfo);
		$this->assign('binfo',$binfo);
		$this->assign('mBorrow',$mBorrow);
		$this->assign('mInvest',$mInvest);
		$this->assign('borrow_id',$borrow_id);

		$detail_list = M('investor_detail')->field(true)->where("invest_id={$invest_id}")->select();
		$this->assign("detail_list",$detail_list);
		//echo "<pre>";print_r($binfo);echo "</pre>";exit;
		//$this->display("transfer");exit;
		Vendor('Mpdf.mpdf');
			$mpdf=new mPDF('UTF-8','A4','','',15,15,4,15);
			$mpdf->useAdobeCJK = true;
			$mpdf->SetAutoFont(AUTOFONT_ALL);
			$mpdf->SetDisplayMode('fullpage');
			$mpdf->SetAutoFont();
			$mpdf->SetHTMLFooter(' >>{PAGENO}<<');
			$mpdf->WriteHTML($this->fetch('transfer'));
			$mpdf->Output('cailaijinfu.pdf','I');
			exit;		
	$this->display("transfer");
 }

}