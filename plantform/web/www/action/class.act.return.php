<?php
error_reporting(E_ALL ^ E_NOTICE);
/**
 * Class act_index
 */
class act_return extends action
{
    /**
     *
     */
    public function runFirst() {
    	file_put_contents('/tmp/plantfromtest',date('m-d H:i:s')." return  ".print_r($_POST,true)."\n",FILE_APPEND);
    	//echo "<pre>";
    	
//    	foreach($_POST as $k => $v){
////    		print_r($k);
//    		echo ' = ' . urldecode($v)."\n";
//    	}
    }

    /**
     * 汇付通知返回页面
     */
    public function _homeAct()
    {

//      $data =  file_get_contents('huifuerror.php');
//      $a = require_once('huifuerror.php');
//     print_r($a);exit;
//      exit;
//        
//        
//    	$post = $_POST;
//    	header("Content-type: text/html; charset=utf-8");
//    	echo urldecode($_POST['RespDesc']);
//    	echo "<hr>";
//    	echo "<pre>";
//    	print_r($post);
//    	//file_put_contents('/tmp/plantfromtest',date('m-d H:i:s')." return  ".print_r($_POST,true)."\n",FILE_APPEND);
//    	exit;
	}
        
        
        /**
         *(
    [UsrCustId] => 6000060001486306
    [TransAmt] => 100.00
    [FeeCustId] => 6000060001486306
    [BgRetUrl] => https%3A%2F%2Ftest.cailai.com%2Fhome%2Freturl%2Fquxianreturn
    [OpenBankId] => ICBC
    [RetUrl] => http%3A%2F%2Fplantformtest.cailai.com%2Freturn%2Fquxian
    [MerPriv] => 
    [RespExt] => 
    [ServFee] => 0.30
    [FeeAcctId] => MDT000001
    [RespCode] => 000
    [FeeAmt] => 2.00
    [RespDesc] => %E6%88%90%E5%8A%9F
    [OpenAcctId] => 6222021001017653236
    [ChkValue] => 4888715C79A0517068D6CE1CE5EAE4C28F83841BD298535C01FD0DAB0B63E5B42FED268475DFF735CD33B9E54CF2307AD287BDB48CC01847F309682B4CD66A38934182D302E6220D7425AC637CFA6FE35872A114EA052935CE71BA62F10D0C257F99F3A4EEAED16BDDDFF53D1816FEF06D54ABA83BA401EB5492BC109433F9C3
    [MerCustId] => 6000060000758826
    [ServFeeAcctId] => MDT000001
    [OrdId] => 201506042011514213
    [RealTransAmt] => 100.00
    [CmdId] => Cash  取现
         * 
         * 
         * //充值
         *   [CardId] => 
    [UsrCustId] => 6000060001486306   6000060001486306
    [BgRetUrl] => https://test.cailai.com/home/returl/netsave
    [TransAmt] => 500.00
    [FeeCustId] => 6000060000758826
    [GateBankId] => CIB
    [MerPriv] => 
    [RetUrl] => http://plantformtest.cailai.com/return/netreturn
    [TrxId] => 201506040000179322
    [FeeAcctId] => MDT000001
    [RespCode] => 000
    [GateBusiId] => B2C
    [FeeAmt] => 1.25
    [CashierSysId] => 0000179322
    [RespDesc] => 成功
    [OrdDate] => 20150604
    [ChkValue] => 8DA73CB2B6458C623C23096268135A7343AF2F4D3FBB2CA6BB62C9553ADEF568088E642D7D0E85AA80760895BAD473E71DE0636E5BAF428AB4893F3ED928C869DA3400709BE843BBEA402262E1F9F44B3CCD9325617A08AEB37A68C7CBBE9B57C72D67FBE7893F28E8F62DE3BC67A2796453B7CDC350213E7B45FD09E560DD53
    [MerCustId] => 6000060000758826
    [OrdId] => 201506042012513834
    [Version] => 10
    [CmdId] => NetSave
    [CashierAcctDate] => 20150604
) 
         */
      
        //汇付宝认证
         public function _userregisterAct(){
            if(strcmp($_POST['RespCode'],"000")==0){ 
                $url = HOST_NAME.'Style/H/images/apppic.jpg';
                $word = '恭喜您认证成功！';
                
                //注册成功，添加红包 开始 by zxm 2015-09-21
                
                $arr=explode("_", $_POST['UsrId']);
                $map['usrid'] = $arr[1];
                $map['addtime']=time();//红包添加时间
                $map['rednum']=date('YmdHis',$map['addtime']);//红包序列号
                $map['shelftime']=30;//红包有效期
                $map['facevalue']=10;//红包的面值
                $map['overtime']=$map['addtime']+30*24*60*60;//红包过期时间 时间戳
//                $map['owner']=$uid;//红包的拥有者
                $map['is_success']='0';//是否使用成功
                $map['is_used']='0';//是否使用 枚举类型需要加‘’
                $map['note']=0;//代表注册送的
                
                addMemberRedpacket($map);
                //注册成功，添加红包 结束
                
                
            }else{
                $huifuerror = require_once('huifuerror.php');
                $errorms = $_POST['RespCode'];
                $backerror = $huifuerror[$errorms];
                $url = HOST_NAME.'Style/H/images/appshib.jpg';
                $word = "<span class='error'>".$backerror."</span>";
            }
            $this->view->assign("url",$url);
            $this->view->assign("word",$word);
        }
        //充值  尊敬的财来网投资人王红华，您于6月4号18:05分充值成功1000元。

         public function _netreturnAct(){
              $money = $_POST['TransAmt'];
              $m = date('m',time());
              $d = date('d',time());
              $mi = date('H:i',time());
              if(strcmp($_POST['RespCode'],"000")==0){
                $realName = realNameGet($_POST['UsrCustId']) ;
                $userName = $realName['real_name'];
                $url = HOST_NAME.'Style/H/images/apppic.jpg';
                $word = "<b>尊敬的财来网投资人{$userName}</b>您于{$m}月{$d}号 {$mi}分充值成功 <span> $money </span>元。<br/>详情请咨询客户经理或致电400-079-8558";
            }else{
                $huifuerror = require_once('huifuerror.php');
                $errorms = $_POST['RespCode'];
                $backerror = $huifuerror[$errorms];
                $url = HOST_NAME.'Style/H/images/appshib.jpg';
                 $word = "<span class='error'>".$backerror."</span>";
            }
               
                $this->view->assign("url",$url);
                $this->view->assign("word",$word);
                $this->view->assign("money",$money);
        }
        //提现
	 public function _quxianAct(){
             $money = $_POST['TransAmt'];
             $m = date('m',time());
             $d = date('d',time());
             $mi = date('H:i',time());
            if(strcmp($_POST['RespCode'],"000")==0){ 
                $realName = realNameGet($_POST['UsrCustId']) ;
                $userName = $realName['real_name'];
                $url = HOST_NAME.'Style/H/images/apppic.jpg';
                $word = "<b>尊敬的财来网投资人{$userName}</b>您于{$m}月{$d}号 {$mi}分提现 <span> $money </span>元,提现资金将于1-2个工作日到账，请注意查收。<br/>详情请咨询客户经理或致电400-079-8558";
            }else{                
                $huifuerror = require_once('huifuerror.php');
                $errorms = $_POST['RespCode'];
                $backerror = $huifuerror[$errorms];
                $url =HOST_NAME.'Style/H/images/appshib.jpg';
                $word = "<span class='error'>".$backerror."</span>";
            }     
                $this->view->assign("url",$url);
                $this->view->assign("word",$word);
                $this->view->assign("money",$money);
                
        }
        //投标
	public function _initiativetenderAct()
	{
             $money = $_POST['TransAmt'];
             $m = date('m',time());
             $d = date('d',time());
             $mi = date('H:i',time());
            if(strcmp($_POST['RespCode'],"000")==0){
                $subOrdId=$_POST['OrdId'];
                $db_user = core::db()->getConnect('CAILAI');
                $sql= "update lzh_active_redpacket set is_success='1' where orderno="."'".$subOrdId."'";
                $rs = $db_user->query($sql);
                file_put_contents('/tmp/debugs',date('m-d H:i:s')."\siyuan".print_r($_POST,true)."\n",FILE_APPEND);
                file_put_contents('/tmp/debugs',date('m-d H:i:s')."\siyuansql".print_r($sql,true)."\n",FILE_APPEND);
                file_put_contents('/tmp/debugs',date('m-d H:i:s')."\siyuanrs".print_r($rs,true)."\n",FILE_APPEND);
                $realName = realNameGet($_POST['UsrCustId']) ;
                $userName = $realName['real_name'];
                $url = HOST_NAME.'Style/H/images/apppic.jpg';
                $word = "<b>尊敬的财来网投资人{$userName}</b>您于{$m}月{$d}号 {$mi}分投资 <span> $money </span>元,资金已冻结，将于满标复审后开始计息。<br/>详情请咨询客户经理或致电400-079-8558";
            }else{
                $huifuerror = require_once('huifuerror.php');
                $errorms = $_POST['RespCode'];
                $backerror = $huifuerror[$errorms];
                $url = HOST_NAME.'Style/H/images/appshib.jpg';
                 $word = "<span class='error'>".$backerror."</span>";
            }     
                $this->view->assign("url",$url);
                $this->view->assign("word",$word);
                $this->view->assign("money",$money);
  
}
        //注册成功，添加红包 by zxm 2015-09-21
        private function  addMemberRedpacket($data){
            $user = core::Singleton('user.dts_user');
            $result = $user->addMemberRedpacket($data);unset($user);		
            return $result;
        }

       
}

?>