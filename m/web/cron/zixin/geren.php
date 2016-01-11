<?php
require_once(dirname(__FILE__).'/../../www/header.php');
require_once (dirname(__FILE__).'/../../../lib/comm/excel/PHPExcel.php');
//require_once (dirname(__FILE__).'/../../../lib/comm/zip/zip.php');
$obpe = new PHPExcel();
$obpe_pro = $obpe->getProperties();
$obpe_pro->setCreator('cailai')//设置创建者
         ->setLastModifiedBy(date('Y-m-d H:i:s',time()));//设置时间

$p2p = "Q10152900H5C00";//P2P机构代码
$objDb = core::db()->getConnect('CAILAI');
$sql = "select * from lzh_member_info a left join lzh_member_contact_info b on a.uid=b.uid left join lzh_member_department_info
 c on a.uid=c.uid where a.real_name <>'' and a.idcard<>''";	
$res = $objDb->query($sql);
while($row = mysql_fetch_assoc($res)){
	$rows[] = $row;
}

$sql = "select * from lzh_area";	
$res = $objDb->query($sql);
while($row = mysql_fetch_assoc($res)){
	$rows2[] = $row;
}

if(is_array($rows)){
	//-----------------------------------身份信息-----------------------------------	
	$obpe->setactivesheetindex(0)
		->setCellValue('A1', 'P2P机构代码')->setCellValue('B1', '姓名')->setCellValue('C1', '证件类型')->setCellValue('D1', '证件号码')
		->setCellValue('E1', '性别')->setCellValue('F1', '出生日期')->setCellValue('G1', '婚姻状况')->setCellValue('H1', '最高学历')
		->setCellValue('I1', '最高学位')->setCellValue('J1', '住宅电话')->setCellValue('K1', '手机号码')->setCellValue('L1', '单位电话')
		->setCellValue('M1', '电子邮箱')->setCellValue('N1', '通讯地址')->setCellValue('O1', '通讯地址邮政编码')->setCellValue('P1', '户籍地址')
		->setCellValue('Q1', '配偶姓名')->setCellValue('R1', '配偶证件类型')->setCellValue('S1', '配偶证件号码')->setCellValue('T1', '配偶工作单位')
		->setCellValue('U1', '配偶联系电话')->setCellValue('V1', '第一联系人姓名')->setCellValue('W1', '第一联系人关系')->setCellValue('X1', '第一关系人联系电话')
		->setCellValue('Y1', '第二联系人姓名')->setCellValue('Z1', '第二联系人关系')->setCellValue('AA1', '第二关系人联系电话');
	$obpe->getActiveSheet()->setTitle('身份信息');
	foreach($rows as $k=>$v){
		$k = $k+2;
		//性别
		switch($v['sex']){
		 	case '男':$sex = 1;break;
		 	case '女':$sex = 2;break;
		 	default:$sex = 0;break;
		}
		//出生日期  310104199009272817
		$both = strlen($v['idcard'])==18?substr($v['idcard'],6,8):'19'.substr($v['idcard'],6,6);
		//婚姻状况
		switch($v['marry']){
		 	case '未婚':$marry = 10;break;
		 	case '已婚':$marry = 20;break;
		 	default:$marry = 90;break;
		}
		//学历
		switch($v['education']){
		 	case '高中以下':$education = 60;break;
		 	case '大专或本科':$education = 20;break;
		 	case '硕士或硕士以上':$education = 10;break;
		 	default:$education = 99;break;
		}
		//省市区地址
		$address = $v['address']?$v['address']:'暂缺';
		if($v['province']){
			$address = $rows2[$v['province']-1]['name'].$rows2[$v['city']-1]['name'].$rows2[$v['area']-1]['name'].$address;
		}
		//联系人
		switch($v['contact1_re']){
		 	case '家庭成员':$contact1_re = 8;break;
		 	case '朋友':$contact1_re = 6;break;
		 	case '商业伙伴':$contact1_re = 5;break;
		 	default:$contact1_re = 8;break;
		}
		$contact1_tel = $v['contact1_tel']?substr($v['contact1_tel'],0,7).'XXXX':'暂缺';
		
	    /* @func 设置列 */
		
		
		
	    $obpe->getactivesheet()->setcellvalue('A'.$k, $p2p);$obpe->getactivesheet()->setcellvalue('B'.$k, $v["real_name"]);
	    $obpe->getactivesheet()->setcellvalue('C'.$k, '0');$obpe->getActiveSheet()->setCellValueExplicit('D'.$k,$v["idcard"],PHPExcel_Cell_DataType::TYPE_STRING);
	    $obpe->getactivesheet()->setcellvalue('E'.$k, $sex);$obpe->getactivesheet()->setcellvalue('F'.$k, $both);
	    $obpe->getactivesheet()->setcellvalue('G'.$k, $marry);$obpe->getactivesheet()->setcellvalue('H'.$k, $education);
	    $obpe->getactivesheet()->setcellvalue('I'.$k, '9');$obpe->getactivesheet()->setcellvalue('J'.$k, ' ');
	    $obpe->getactivesheet()->setcellvalue('K'.$k, ' ');$obpe->getactivesheet()->setcellvalue('L'.$k, ' ');
	    $obpe->getactivesheet()->setcellvalue('M'.$k, ' ');$obpe->getactivesheet()->setcellvalue('N'.$k, $address);
	    $obpe->getactivesheet()->setcellvalue('O'.$k, '999999');$obpe->getactivesheet()->setcellvalue('P'.$k, ' ');
	    $obpe->getactivesheet()->setcellvalue('Q'.$k, ' ');$obpe->getactivesheet()->setcellvalue('R'.$k, ' ');
	    $obpe->getactivesheet()->setcellvalue('S'.$k, ' ');$obpe->getactivesheet()->setcellvalue('T'.$k, ' ');
	    $obpe->getactivesheet()->setcellvalue('U'.$k, ' ');$obpe->getactivesheet()->setcellvalue('V'.$k, $v['contact1']?$v['contact1']:'暂缺');
	    $obpe->getactivesheet()->setcellvalue('W'.$k, $contact1_re);$obpe->getactivesheet()->setcellvalue('X'.$k, $contact1_tel);               
		$obpe->getactivesheet()->setcellvalue('Y'.$k, ' ');$obpe->getactivesheet()->setcellvalue('Z'.$k, ' ');
		$obpe->getactivesheet()->setcellvalue('AA'.$k, ' ');		
	}

	//-----------------------------------职业信息-----------------------------------	
	$obpe->createSheet();
	$obpe->setActiveSheetIndex(1)
		->setCellValue('A1', 'P2P机构代码')->setCellValue('B1', '姓名')->setCellValue('C1', '证件类型')->setCellValue('D1', '证件号码')
		->setCellValue('E1', '职业')->setCellValue('F1', '单位名称')->setCellValue('G1', '单位所属行业')->setCellValue('H1', '单位地址')
		->setCellValue('I1', '单位地址邮政编码')->setCellValue('J1', '本单位工作起始年份')->setCellValue('K1', '职务')->setCellValue('L1', '职称')
		->setCellValue('M1', '年收入');
	$obpe->getActiveSheet()->setTitle("职业信息");
	foreach($rows as $k=>$v){
		$k = $k+2;		
		//年收入
		switch($v['income']){
		 	case '5000以下':$income = 36000;break;
		 	case '5000-10000':$income = 60000;break;
		 	case '10000-50000':$income = 120000;break;
		 	case '50000以上':$income = 600000;break;
		 	default:$income = 84000;break;
		}
		
		/* @func 设置列 */
	    $obpe->getactivesheet()->setcellvalue('A'.$k, $p2p);$obpe->getactivesheet()->setcellvalue('B'.$k, $v["real_name"]);
	    $obpe->getactivesheet()->setcellvalue('C'.$k, '0');$obpe->getActiveSheet()->setCellValueExplicit('D'.$k,$v["idcard"],PHPExcel_Cell_DataType::TYPE_STRING);
		$obpe->getactivesheet()->setcellvalue('E'.$k, 'Z');
		$obpe->getactivesheet()->setcellvalue('F'.$k, $v["department_name"]?$v["department_name"]:'暂缺');
		$obpe->getactivesheet()->setcellvalue('G'.$k, 'Z');$obpe->getactivesheet()->setcellvalue('H'.$k, ' ');
		$obpe->getactivesheet()->setcellvalue('I'.$k, ' ');$obpe->getactivesheet()->setcellvalue('J'.$k, ' ');
		$obpe->getactivesheet()->setcellvalue('K'.$k, '9');$obpe->getactivesheet()->setcellvalue('L'.$k, '9');
		$obpe->getactivesheet()->setcellvalue('M'.$k, $income);
	}
	//-----------------------------------居住信息-----------------------------------
	
	$obpe->createSheet();
	$obpe->setActiveSheetIndex(2)
		->setCellValue('A1', 'P2P机构代码')->setCellValue('B1', '姓名')->setCellValue('C1', '证件类型')->setCellValue('D1', '证件号码')
		->setCellValue('E1', '居住地址')->setCellValue('F1', '居住地址邮政编码')->setCellValue('G1', '居住状况');
	$obpe->getActiveSheet()->setTitle("居住信息");
	foreach($rows as $k=>$v){
		$k = $k+2;
		//省市区地址
		$address = $v['address']?$v['address']:'暂缺';
		if($v['province']){
			$address = $rows2[$v['province']-1]['name'].$rows2[$v['city']-1]['name'].$rows2[$v['area']-1]['name'].$address;
		}			
		
		/* @func 设置列 */
	    $obpe->getactivesheet()->setcellvalue('A'.$k, $p2p);$obpe->getactivesheet()->setcellvalue('B'.$k, $v["real_name"]);
	    $obpe->getactivesheet()->setcellvalue('C'.$k, '0');$obpe->getActiveSheet()->setCellValueExplicit('D'.$k,$v["idcard"],PHPExcel_Cell_DataType::TYPE_STRING);
		$obpe->getactivesheet()->setcellvalue('E'.$k, $address);$obpe->getactivesheet()->setcellvalue('F'.$k, '999999');
		$obpe->getactivesheet()->setcellvalue('G'.$k, '9');
					
	}	
			
}
//-----------------------------------贷款申请信息-----------------------------------
	
	$obpe->createSheet();
	$obpe->setActiveSheetIndex(3)
		->setCellValue('A1', 'P2P机构代码')->setCellValue('B1', '贷款申请号')->setCellValue('C1', '姓名')->setCellValue('D1', '证件类型')
		->setCellValue('E1', '证件号码')->setCellValue('F1', '贷款申请类型')->setCellValue('G1', '贷款申请金额')->setCellValue('H1', '贷款申请月数')
		->setCellValue('I1', '贷款申请时间')->setCellValue('J1', '贷款申请状态');
	$obpe->getActiveSheet()->setTitle("贷款申请信息");
	
unset($rows);
$sql = "select * from lzh_member_info a inner join lzh_borrow_info b on a.uid=b.borrow_uid  where a.real_name <>'' 
and a.idcard<>'' and b.second_verify_time!=0";	
$res = $objDb->query($sql);
while($row = mysql_fetch_assoc($res)){
	$rows[] = $row;
}
if(is_array($rows)){
	//-----------------------------------贷款业务信息-----------------------------------
$obpe->createSheet();
	$obpe->setActiveSheetIndex(4)
		->setCellValue('A1', 'P2P机构代码')->setCellValue('B1', '贷款类型')->setCellValue('C1', '贷款合同号码')->setCellValue('D1', '业务号')
		->setCellValue('E1', '发生地点')->setCellValue('F1', '开户日期')->setCellValue('G1', '到期日期')->setCellValue('H1', '币种')
		->setCellValue('I1', '授信额度')->setCellValue('J1', '贷款金额')->setCellValue('K1', '最大负债额')->setCellValue('L1', '担保方式')
		->setCellValue('M1', '还款频率')->setCellValue('N1', '还款月数')->setCellValue('O1', '剩余还款月数')->setCellValue('P1', '协定还款期数')
		->setCellValue('Q1', '协定期还款额')->setCellValue('R1', '结算/应还款日期')->setCellValue('S1', '最近一次实际还款日期')->setCellValue('T1', '本月应还款金额')
		->setCellValue('U1', '本月实际还款金额')->setCellValue('V1', '余额')->setCellValue('W1', '当前逾期期数')->setCellValue('X1', '当前逾期总额')
		->setCellValue('Y1', '逾期31-60天未归还贷款本金')->setCellValue('Z1', '逾期61-90天未归还贷款本金')->setCellValue('AA1', '逾期91-180天未归还贷款本金')
		->setCellValue('AB1', '逾期180天以上未归还贷款本金')->setCellValue('AC1', '累计逾期期数')->setCellValue('AD1', '最高逾期期数')->setCellValue('AE1', '五级分类状态')
		->setCellValue('AF1', '账户状态')->setCellValue('AG1', '24月（账户）还款状态')->setCellValue('AH1', '账户拥有者信息提示')->setCellValue('AI1', '姓名')
		->setCellValue('AJ1', '证件类型')->setCellValue('AK1', '证件号码');
		
	$obpe->getActiveSheet()->setTitle("贷款业务信息");
	foreach($rows as $k=>$v){
		$k = $k+2;

		//借款用途
		switch($v['borrow_use']){
		 	case '1':$borrow_use = 99;break;
		 	case '2':$borrow_use = 41;break;
		 	case '3':$borrow_use = 91;break;
		 	case '4':$borrow_use = 91;break;
		 	case '5':$borrow_use = 99;break;
		 	case '6':$borrow_use = 41;break;
		 	case '7':$borrow_use = 99;break;
		 	default:$borrow_use = 99;break;
		}
		//协定期还款额
		$each_duration = sprintf("%.2f", ($v['borrow_money']+$v['borrow_interest'])/$v['borrow_duration']);
		//应还款日期&实际还款日期
		$qi = ($v['total']-$v['has_pay'])==0?0:($v['total']-$v['has_pay']);
		//$deadline = date('Ymd',$v['deadline']);
		//$actual_day = ($v['total']-$v['has_pay'])==0?date('Ymd',$v['deadline']):date('Ymd',strtotime($deadline." - {$qi} month"));
		//本月还款金额(连续两次还款日)
		$two_money = ($v['total']-$v['has_pay'])==0?0:$each_duration*2;
		//本金余额(未偿还的本金)
		$no_money = $v['borrow_money']/$v['total']*($v['total']-$v['has_pay']);
		

		/* @func 设置列 */
	    $obpe->getactivesheet()->setcellvalue('A'.$k, $p2p);$obpe->getactivesheet()->setcellvalue('B'.$k, $borrow_use);
	    $obpe->getactivesheet()->setcellvalue('C'.$k, ' ');$obpe->getactivesheet()->setcellvalue('D'.$k, $v['id']);
		$obpe->getactivesheet()->setcellvalue('E'.$k, '310000');$obpe->getactivesheet()->setcellvalue('F'.$k, date('Ymd',$v['second_verify_time']));
		$obpe->getactivesheet()->setcellvalue('G'.$k, date('Ymd',$v['deadline']));$obpe->getactivesheet()->setcellvalue('H'.$k, 'CNY');		
		$obpe->getactivesheet()->setcellvalue('I'.$k, $v['borrow_money']);$obpe->getactivesheet()->setcellvalue('J'.$k, $v['borrow_money']);
		$obpe->getactivesheet()->setcellvalue('K'.$k, $v['borrow_money']);$obpe->getactivesheet()->setcellvalue('L'.$k, '2');
		$obpe->getactivesheet()->setcellvalue('M'.$k, '99');$obpe->getactivesheet()->setcellvalue('N'.$k, $v['borrow_duration']);
		$obpe->getactivesheet()->setcellvalue('O'.$k, $v['total']-$v['has_pay']);$obpe->getactivesheet()->setcellvalue('P'.$k, $v['total']);
		$obpe->getactivesheet()->setcellvalue('Q'.$k, $each_duration);$obpe->getactivesheet()->setcellvalue('R'.$k, date('Ymd',$v['second_verify_time']));
		$obpe->getactivesheet()->setcellvalue('S'.$k, date('Ymd',$v['second_verify_time']));$obpe->getactivesheet()->setcellvalue('T'.$k, $two_money);
		$obpe->getactivesheet()->setcellvalue('U'.$k, $two_money);$obpe->getactivesheet()->setcellvalue('V'.$k, sprintf("%.2f", $no_money));
		$obpe->getactivesheet()->setcellvalue('W'.$k, 0);$obpe->getactivesheet()->setcellvalue('X'.$k, 0);
		$obpe->getactivesheet()->setcellvalue('Y'.$k, 0);$obpe->getactivesheet()->setcellvalue('Z'.$k, 0);
		$obpe->getactivesheet()->setcellvalue('AA'.$k, 0);$obpe->getactivesheet()->setcellvalue('AB'.$k, 0);
		$obpe->getactivesheet()->setcellvalue('AC'.$k, 0);$obpe->getactivesheet()->setcellvalue('AD'.$k, 0);
		$obpe->getactivesheet()->setcellvalue('AE'.$k, 9);$obpe->getactivesheet()->setcellvalue('AF'.$k, 1);
		$obpe->getactivesheet()->setcellvalue('AG'.$k, '///////////////////////N');$obpe->getactivesheet()->setcellvalue('AH'.$k, 2);
		$obpe->getactivesheet()->setcellvalue('AI'.$k, $v['real_name']);$obpe->getactivesheet()->setcellvalue('AJ'.$k, 0);						
		$obpe->getActiveSheet()->setCellValueExplicit('AK'.$k,$v["idcard"],PHPExcel_Cell_DataType::TYPE_STRING);

		
		
	}

}

//-----------------------------------贷款合同信息-----------------------------------	
	$obpe->createSheet();
	$obpe->setActiveSheetIndex(5)
		->setCellValue('A1', 'P2P机构代码')->setCellValue('B1', '贷款合同号码')->setCellValue('C1', '贷款合同生效日期')->setCellValue('D1', '贷款合同终止日期')
		->setCellValue('E1', '币种')->setCellValue('F1', '贷款合同金额')->setCellValue('G1', '合同有效状态');
	$obpe->getActiveSheet()->setTitle("贷款合同信息");
	
//-----------------------------------担保信息----------------------------------	
	$obpe->createSheet();
	$obpe->setActiveSheetIndex(6)
		->setCellValue('A1', 'P2P机构代码')->setCellValue('B1', '业务号')->setCellValue('C1', '担保人姓名')->setCellValue('D1', '担保人证件类型')
		->setCellValue('E1', '担保人证件号码')->setCellValue('F1', '担保金额')->setCellValue('G1', '担保状态');
	$obpe->getActiveSheet()->setTitle("担保信息");
	
//-----------------------------------投资人信息----------------------------------	
	$obpe->createSheet();
	$obpe->setActiveSheetIndex(7)
		->setCellValue('A1', 'P2P机构代码')->setCellValue('B1', '业务号')->setCellValue('C1', '投资人姓名')->setCellValue('D1', '投资人证件类型')
		->setCellValue('E1', '投资人证件号码')->setCellValue('F1', '投资人投资金额');
	$obpe->getActiveSheet()->setTitle("投资人信息");
	
//-----------------------------------特殊交易信息----------------------------------	
	$obpe->createSheet();
	$obpe->setActiveSheetIndex(8)
		->setCellValue('A1', 'P2P机构代码')->setCellValue('B1', '姓名')->setCellValue('C1', '证件类型')->setCellValue('D1', '证件号码')
		->setCellValue('E1', '业务号')->setCellValue('F1', '特殊交易类型')->setCellValue('G1', '发生日期')->setCellValue('H1', '变更月数')
		->setCellValue('I1', '发生金额')->setCellValue('J1', '明细信息');
	$obpe->getActiveSheet()->setTitle("特殊交易信息");






$objWriter = PHPExcel_IOFactory::createWriter($obpe, 'Excel5');//Excel5 Excel2007
$time = time();
$file_name = $p2p.date('Ym',time()).'C'.substr($time,strlen($time)-2,2).'1';
$objWriter->save($file_name.'.xls');

//$archive = new PHPZip(); 
//$archive->Zip('test.txt', $file_name.'.zip');



exit;



