<?php
/**
 * 注：已经废弃了这个notify地址
 * @author whh
 *
 */
class act_notify extends action
{
	
    public function runFirst() {
    	
    	$this->log($_POST);
    	//exit;
    }

    /**
     * post过来的格式:
     * 认证返回：Array
(
    [BgRetUrl] => https%3A%2F%2Fwww.cailai.com%2Fhome%2Freturl%2Fuserregister
    [ChkValue] => 381A724624D8EB04C2320447C3B1F7D12C3E58B36CCC47FB6D936438D2ADAE42599FBE1E4510D27E86350130E7FBAD59DC43C72C658ED8D7B41AD907252A7C422FCE9A71096ED9CF090146D7EDDE1CB137D7A908C59B97F3AB30AF794A572A5020D4CBE81FB128B9C8006B8BFE9AF994A2D211306BAE0652A46161151D175237
    [CmdId] => UserRegister
    [IdNo] => 330823197710288720
    [IdType] => 00
    [MerCustId] => 6000060019165477
    [MerPriv] => 
    [RespCode] => 000
    [RespDesc] => %E6%88%90%E5%8A%9F
    [RetUrl] => https%3A%2F%2Fwww.cailai.com%2Fhome%2Freturl%2Fusrreg
    [TrxId] => 380362458023432190
    [UsrCustId] => 6000060030917411
    [UsrEmail] => 13857006075%40139.com
    [UsrId] => clw_13857006075
    [UsrMp] => 13857006075
    [UsrName] => %E7%8E%8B%E4%B8%BD%E9%9C%9E
)

	充值返回：
	(
    [BgRetUrl] => http://plantformtest.cailai.com/notify/
    [CardId] => 
    [CashierAcctDate] => 20150423
    [CashierSysId] => 0000146934
    [ChkValue] => 9378DD51F5FB093565ABFDAB4826E5B68672F3F6B08D276675355D26E876489EA55ED674EAB849AE5D3353422904346EEC7B844078675CF79F2A41F7F293475EBB25A4CEE0DEB5C62A25087E2E44E29C808C46C8FA0828DA9168BA0725274264AE4579BA710FC98D261BEB4BAFEA2BE13FC51FC31CF287287CAF8F0EC660A312
    [CmdId] => NetSave
    [FeeAcctId] => MDT000001
    [FeeAmt] => 0.50
    [FeeCustId] => 6000060000758826
    [GateBankId] => CIB
    [GateBusiId] => B2C
    [MerCustId] => 6000060000758826
    [MerPriv] => 
    [OrdDate] => 20150423
    [OrdId] => 201504231714048262
    [RespCode] => 000
    [RespDesc] => 成功
    [RetUrl] => http://plantformtest.cailai.com/return/
    [TransAmt] => 200.00
    [TrxId] => 201504230000146934
    [UsrCustId] => 6000060000888160
    [Version] => 10
)
*/

 public function _homeAct(){
    	$post = $_POST; unset($_POST);
    	$is_avail = $this->is_avail($post);
    	 
    	if($is_avail){//业务处理
    		
    		file_put_contents('/tmp/plantformnotify2',date('m-d H:i:s')." back : ".print_r(json_encode($post),true)."\n",FILE_APPEND);
    		
    		$obj = core::Singleton('cailai.deal');
    		$obj->run($post);
    	}else{
    		//echo '验证不通过';
    	}
    	
    	//认证，充值
    	if($post['CmdId']=='UserRegister' || $post['CmdId']=='NetSave'){
    		echo "RECV_ORD_ID_".$post['TrxId'];
    	}elseif($post['CmdId']=='Cash' ||$post['CmdId']=='CashAudit'){//取现
    		echo "RECV_ORD_ID_".$post['OrdId'];
    	}
    	exit;
	}


        public function _initiativetenderreturnAct(){
                file_put_contents('/tmp/4.txt',date('m-d H:i:s')." returnplant异步：".print_r($_POST,true)."\n",FILE_APPEND);
                $is_avail = $this->is_avail($_POST);
                if($is_avail){                  
                                    $usrid = $_POST['UsrCustId'];
                    $db = core::Singleton('comm.db.activeRecord');
                    $db->connect('CAILAI');
                    $info = $db->get_one($where = array('usrid' => $usrid),'','lzh_huifulog');   
    //                file_get_contents('/tmp/3',json_encode($_POST));
                    //$info = M("huifulog")->distinct(true)->field("uid,username")->where('usrid' => $usrid)->find();
                    $data=array();
                    $data['uid'] = $info['uid'];//用户UID
                    $data['username'] = $info['username'];//用户名
                    $data['rescode'] = $_POST['RespCode'];//返回码
                    $data['cmdid'] = $_POST['CmdId'];//消息类型
                    $data['usrid'] = $_POST['UsrCustId'];//用户客户号
                    $data['ordid'] = $_POST['OrdId'];//订单号
                    $data['orddate'] = $_POST['OrdDate'];//订单日期
                    $data['trxid'] = $_POST['TrxId'];//交易流水号
                    $data['merpriv'] = $_POST['MerPriv'];
                    $data['addtime'] = time();//记录时间
                    //防止钱投完使用红包不扣款的bug出现
                    $reqext=$_POST['RespExt'];//代金券的内容json字符串
                    $reqext=urldecode($reqext);
                    $reqext=json_decode($reqext,1);
                    $reqext=$reqext['Vocher']['VocherAmt'];
                     file_put_contents('/tmp/4.txt',date('m-d H:i:s')." returnplant异步红包：".print_r($reqext,true)."\n",FILE_APPEND);
                    sleep(1);//防止与前台回调同步到达
                    $condition['uid'] = $data['uid'];
                    $condition['ordid'] = $data['ordid'];
                    $num = $db->count_all($condition, 'lzh_huifulog');
                    if($num===0)
                    {
    //                        $db = core::Singleton('comm.db.activeRecord');
    //                        $db->connect('CAILAI');
                            $db->insert($data,'lzh_huifulog');
                            if(strcmp($_POST['RespCode'],"000")==0)
                            {
                                    $temp = base64_decode($data['merpriv']);
                                    $pos1 = strpos($temp,'{');
                                    $pos2 = strpos($temp,'}');
                                    $len = $pos2-$pos1+1;
                                    $merpriv = substr($temp,$pos1,$len);
                                    $merpriv = json_decode($merpriv,true);
    //				file_put_contents('/tmp/4.txt',date('m-d H:i:s')." return  ".print_r($merpriv,true)."\n",FILE_APPEND);
                                    $borrow_id = $merpriv['borrowid'];//标ID
                                    $money = str2val_money($_POST['TransAmt']);//交易金额
                                    $info = array();
                                    $info['ordid'] = $data['ordid'];//订单号
                                    $info['orddate'] = $data['orddate'];//订单日期
                                    $info['freezeordid'] = $_POST['FreezeOrdId'];//冻结订单号
                                    $info['freezetrxid'] = $_POST['FreezeTrxId'];//冻结流水号
    //                                $db = core::Singleton('comm.db.activeRecord');
                                    $db->connect('CAILAI');
                                    $invest_info_id = $db->insert($info,'lzh_borrow_investor');
    //				$invest_info_id = M('borrow_investor')->add($info);
                                    //剪去红包的钱 才是真正扣掉的钱
                                    //$money=$money-$reqext;
                                     file_put_contents('/tmp/4.txt',date('m-d H:i:s')." returnplant真钱：".print_r($money,true)."\n",FILE_APPEND);
                                    $l = investMoney($data['uid'],$borrow_id,$money,0,$invest_info_id,$reqext);                                  
                                    $borrowName = getBorrowName($borrow_id);
                                $realName = getRealName($data['uid']);
                                $content="尊敬的财来网投资人".$realName['real_name'].",您于".date("Y")."年".date("m")."月".date("d")."日".date("H").":".date("i")."分向".$borrowName['borrow_name']."标的投资".$money."元,资金已冻结，将于满标复审后计息，详情请咨询客户经理，或致电400-079-8558";
				sendsms(trim($data['username']),$content);
                            }                         
                    }                
                    echo "RECV_ORD_ID_".$_POST['OrdId'];
                }

                exit;
	}
     
	
	
	/**
	 * 检查数据是否被伪造
	 */
	public function is_avail($post){
		
		$result = check_is_avail($post);
		
		return $result  ? true : false ;
	}
	
	
	
	public function log($post){
	
		file_put_contents('/tmp/plantformnotify1',date('m-d H:i:s')." post : ".print_r($post,true)."\n",FILE_APPEND);
		
	}
	
	
	public function _testAct($post){
	
		/*
		$data['BgRetUrl']= 'http://plantformtest.cailai.com/notify/';
		$data['ChkValue'] = '0332110FD0DEE6D515B7810C24D6E575EB2053412F6F0610B2C32094FD2F4954927E2040716261D90DB4BB589E86F26087E7E52E5CAC317A813BFA0DAE86D02CBF1E9DC1A52F9365B14F6E1D06578D9573DF1327D4172267CDA1A24BA9B20AE4C19B63F0BE8D0CD227484488BAF7CB5C418969AAB8518010C4435B04E35C48E1';
		$data['CmdId'] = 'UserRegister';
		$data['IdNo'] = '310224198212027330';
		$data['IdType'] = '00';
		$data['MerCustId'] = '6000060000758826';
		$data['MerPriv'] = '';
		$data['RespCode'] = '000';
		$data['RespDesc'] = '成功';
		$data['RetUrl'] = 'http://plantformtest.cailai.com/return/';
		$data['TrxId'] = '609263496721460683';
		$data['UsrCustId'] = '6000060001163903';
		$data['UsrEmail'] = 'hellowhh359w@163.com';
		$data['UsrId'] = 'clw_13818165059';
		$data['UsrMp'] = '13818165059';
		$data['UsrName'] = '个人信息';
	
		$is_avail = $this->is_avail($data);
		var_dump($is_avail);

		return $result  ? true : false ;
		*/
	}
	
}





/**
 * 合法性检查
 * @param unknown_type $post
 * @return boolean
 */
function check_is_avail($post){

	if(isset($post['CmdId']) && isset($post['ChkValue']) && !empty($post['CmdId']) && !empty($post['ChkValue']) ){
		extract($post);
		switch($CmdId){
			case "UserRegister"://用户注册
				$signKeys[] = 'CmdId';
				$signKeys[] = 'RespCode';
				$signKeys[] = 'MerCustId';
				$signKeys[] = 'UsrId';
				$signKeys[] = 'UsrCustId';
				$signKeys[] = 'BgRetUrl';
				$signKeys[] = 'TrxId';
				$signKeys[] = 'RetUrl';
				$signKeys[] = 'MerPriv';
				break;
			case "NetSave"://充值
				$signKeys[] = 'CmdId';
				$signKeys[] = 'RespCode';
				$signKeys[] = 'MerCustId';
				$signKeys[] = 'UsrCustId';
				$signKeys[] = 'OrdId';
				$signKeys[] = 'OrdDate';
				$signKeys[] = 'TransAmt';
				$signKeys[] = 'TrxId';
				$signKeys[] = 'RetUrl';
				$signKeys[] = 'BgRetUrl';
				$signKeys[] = 'MerPriv';
				break;
			case "Cash"://取现
				$signKeys[] = 'CmdId';
				$signKeys[] = 'RespCode';
				$signKeys[] = 'MerCustId';
				$signKeys[] = 'OrdId';
				$signKeys[] = 'UsrCustId';
				$signKeys[] = 'TransAmt';
				$signKeys[] = 'OpenAcctId';
				$signKeys[] = 'OpenBankId';
				$signKeys[] = 'FeeAmt';
				$signKeys[] = 'FeeCustId';
				$signKeys[] = 'FeeAcctId';
				$signKeys[] = 'ServFee';
				$signKeys[] = 'ServFeeAcctId';
				$signKeys[] = 'RetUrl';
				$signKeys[] = 'BgRetUrl';
				$signKeys[] = 'MerPriv';
				$signKeys[] = 'RespExt';
				break;
			case "CashAudit"://取现复核
				$signKeys[] = 'CmdId';
				$signKeys[] = 'RespCode';
				$signKeys[] = 'MerCustId';
				$signKeys[] = 'OrdId';
				$signKeys[] = 'UsrCustId';
				$signKeys[] = 'TransAmt';
				$signKeys[] = 'OpenAcctId';
				$signKeys[] = 'OpenBankId';
				$signKeys[] = 'AuditFlag';
				$signKeys[] = 'RetUrl';
				$signKeys[] = 'BgRetUrl';
				$signKeys[] = 'MerPriv';
				break;
                        case "InitiativeTender"://主动投资
                                    $signKeys[] = 'CmdId';
                                    $signKeys[] = 'RespCode';
                                    $signKeys[] = 'MerCustId';
                                    $signKeys[] = 'OrdId';
                                    $signKeys[] = 'OrdDate';
                                    $signKeys[] = 'TransAmt';
                                    $signKeys[] = 'UsrCustId';
                                    $signKeys[] = 'TrxId';
                                    $signKeys[] = 'IsFreeze';
                                    $signKeys[] = 'FreezeOrdId';
                                    $signKeys[] = 'FreezeTrxId';
                                    $signKeys[] = 'RetUrl';
                                    $signKeys[] = 'BgRetUrl';
                                    $signKeys[] = 'MerPriv';
                                    $signKeys[] = 'RespExt';                                   
                                    break;
		}
	}

        
	if(is_array($signKeys)){
		$obj = core::Singleton('huifu.Chinapnr');
		$ret =  $obj->reactResponse(json_encode($post), $signKeys);
		return $ret == null ? 0 : 1 ;
	}

	return 0;
}

?>