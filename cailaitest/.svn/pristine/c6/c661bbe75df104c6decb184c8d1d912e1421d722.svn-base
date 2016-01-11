<?php
    /**
    *  债权转让
    */
    class ZwbankAction extends MCommonAction
    {
      
        public function index()
             
        {
 

           $this->display();
        }

       public function zbank(){
            $id = $_SESSION['u_id'];
            $pre = C("DB_PREFIX");
            $banks = array('ICBC'=>'工商银行','ABC'=>'农行','CMB'=>'招行','CCB'=>'建设银行','BCCB'=>'北京银行','BJRCB'=>'北京农村商业银行','BOC'=>'中国银行',
                'BOCOM'=>'交通银行','CMBC'=>'民生银行','BOS'=>'上海银行','CBHB'=>'渤海银行','CEB'=>'光大银行','CIB'=>'兴业银行','CITIC'=>'中信银行','CZB'=>'浙商银行',
                'GDB'=>'广发银行','HKBEA'=>'东亚银行','HXB'=>'华夏银行',
                'HZCB'=>'杭州银行','NJCB'=>'南京银行','PINGAN'=>'平安银行','PSBC'=>'邮储银行','SDB'=>'深发银行','SPDB'=>'浦发','SRCB'=>'上海农村商业银行');
                      
            $mBankInfo = M("members m")->join("{$pre}member_banks b ON m.id=b.uid")->field('m.usrid,b.bank_num,b.bank_name')->where("m.id={$id}")->find();
            
            $merCustId = '6000060000758826';
            $usrCustId = $mBankInfo['usrid'];
//            $cardId = $mBankInfo['bank_num'];
            
            import("ORG.Huifu.Huifu");
            $huifu = new Huifu();
            $k = $huifu->zwqueryCardInfo($merCustId,$usrCustId,$cardId);
            
            if(!empty($k['UsrCardInfolist'])){
                foreach($k['UsrCardInfolist'] as $zwkey=>$zwvalue){
                    $zwBankInfos[$zwkey]['UsrName'] = $zwvalue['UsrName'];
                    $zwbankId = $zwvalue['BankId'];
                    $zwBankInfos[$zwkey]['BankId'] = $zwvalue['BankId'];
                    $zwBankInfos[$zwkey]['CardKey'] = $zwvalue['CardId']; 
                    $zwBankInfos[$zwkey]['BankName'] = $banks[$zwbankId];
                    $zwBankInfos[$zwkey]['IsDefault'] = $zwvalue['IsDefault'];
                }
            }
            $this->assign("zwBankInfo",$zwBankInfos);	
            $data['html'] = $this->fetch();
            exit(json_encode($data));
        
       }



    }
?>
