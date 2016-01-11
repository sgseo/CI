<?php
    /**
    * 乾多多 第三方托管接口类
    * @timg 2014-04-24 14:39
    * @author  zhangjili 404851763@qq.com
    * 
    */
	
    class Escrow
    {
        public $url_arr=array(); //接口URL地址
        private $plat_form_money_moremore; // 平台乾多多标识
        private $antistate = 0;

        public function __construct(){
            $loan = FS("Webconfig/loanconfig");
            $this->plat_form_money_moremore = $loan['pfmmm']; // 平台乾多多标识
            import("ORG.Loan.RSA");
            $this->rsa = new RSA($loan['private_key'], $loan['public_key']);
            
            $this->url_arr = array(
                'register'=>'http://218.4.234.150:88/main/loan/toloanregisterbind.action', //开户接口地址
				'withdraw'=>'http://218.4.234.150:88/main/loan/toloanwithdraws.action',
				'charge'=>'http://218.4.234.150:88/main/loan/toloanrecharge.action', //充值地址
                'transfer' => 'http://218.4.234.150:88/main/loan/loan.action', // 转账接口
				'orderquery'=>'http://218.4.234.150:88/main/loan/loanorderquery.action',//对账接口
                'balance' => 'http://218.4.234.150:88/main/loan/balancequery.action', // 余额查询接口
				'authorize'=>'http://218.4.234.150:88/main/loan/toloanauthorize.action',//授权接口
                'audit' => 'http://218.4.234.150:88/main/loan/toloantransferaudit.action', // 审核接口
                

            );
			/**
			$this->url_arr = array(
                'register'=>'https://www.moneymoremore.com/loan/toloanregisterbind.action', //开户接口地址
				'withdraw'=>'https://www.moneymoremore.com/loan/toloanwithdraws.action',
				'charge'=>'https://www.moneymoremore.com/loan/toloanrecharge.action', //充值地址
                'transfer' => 'https://www.moneymoremore.com/loan/loan.action', // 转账接口
				'orderquery'=>'https://www.moneymoremore.com/loan/loanorderquery.action',//对账接口
                'balance' => 'https://www.moneymoremore.com/loan/balancequery.action', // 余额查询接口
				'authorize'=>'https://www.moneymoremore.com/loan/toloanauthorize.action',//授权接口
                'audit' => 'https://www.moneymoremore.com/loan/toloantransferaudit.action', // 审核接口
            );
			*/
        } 
       
        /**
        * curl 模拟发送数据
        * 
        */
        public function postDate($data, $url)
        {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
            curl_setopt($ch, CURLOPT_POST, TRUE); 
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data); 
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,  FALSE);

            $ret = curl_exec($ch);
            curl_close($ch);
            return $ret;
        } 
        
        /**
        * 注册账户
        * 
        * @param string $mobile  //手机号  
        * @param string $email  //email
        * @param string $realname // 真实姓名
        * @param string  $identification_no // 身份证/营业执照号
        * @param string $loan_plat_form_account //用户在网贷平台账号  
        * @param string  $plat_form_money_moremore //乾多多标识
        * @param integer $register_type  // 1:全自动， 2:半自动
        * @param integer $account_type  //账户类型  空：个人账户，1：企业账户
        * @param string $image1 // 身份证/营业执照正面
        * @param string $image2 // 身份证/营业执照背面 
        * @param string $remark1 // 备注1
        * @param string $remark2 // 备注2 
        * @param string $remark3 // 备注3
        * 
        * 
        */
        public function registerAccount( $mobile, $email, $realname, $identification_no,  $loan_plat_form_account, $register_type=2, $account_type='', $image1='', $image2='',
               $remark1='', $remark2='', $remark3='')
        {
             $data['RegisterType'] = $register_type; 
             $data['AccountType'] = $account_type;
             $data['Mobile'] = $mobile;
             $data['Email'] = $email;
             $data['RealName'] = $realname;
             $data['IdentificationNo'] = $identification_no;
             $data['Image1'] = $image1;
             $data['Image2'] = $image2;
             $data['LoanPlatformAccount'] = $loan_plat_form_account;
             $data['PlatformMoneymoremore'] = $this->plat_form_money_moremore; // 平台乾多多标识
             $data['RandomTimeStamp'] = $this->getRandomTimeStamp(); // 随机时间戳，启用防抵赖时必填
             $data['Remark1'] = $remark1;
             $data['Remark2'] = $remark2;
             $data['Remark3'] = $remark3;

             $data['ReturnURL'] = C('WEB_URL').U("member/bank/bindReturn");//返回地址  
             $data['NotifyURL'] = C('WEB_URL').U("member/Notify/bind");// 后台通知地址  

             $str = implode('',$data);
             if($this->antistate == 1){
                 $str = strtoupper(md5($str));
             }
             
             $data['SignInfo']  = $this->rsa->sign($str); // 签名
             
             return $data;
            
        }

        public function registerVerify($data)
        {
            $AccountType = $data["AccountType"];
            $AccountNumber = $data["AccountNumber"];
            $Mobile = $data["Mobile"];
            $Email = $data["Email"];
            $RealName = $data["RealName"];
            $IdentificationNo = $data["IdentificationNo"];
            $LoanPlatformAccount = $data["LoanPlatformAccount"];
            $MoneymoremoreId = $data["MoneymoremoreId"];
            $PlatformMoneymoremore = $data["PlatformMoneymoremore"];
            $RandomTimeStamp = $data["$RandomTimeStamp"];
            $Remark1 = $data["$Remark1"];
            $Remark2 = $data["$Remark2"];
            $Remark3 = $data["$Remark3"];
            $ResultCode = $data["ResultCode"];
            $SignInfo = $data["SignInfo"];    
            
            $dataStr = $AccountNumber.$Mobile.$Email.$RealName.$IdentificationNo.$LoanPlatformAccount.$MoneymoremoreId.$PlatformMoneymoremore.$RandomTimeStamp.$Remark1.$Remark2.$Remark3.$ResultCode;
            if($this->antistate == 1)
            {
                $dataStr = strtoupper(md5($dataStr));
            }
            return $this->rsa->verify($dataStr,$SignInfo);
        }
        

        /**
		*提现
		* @param string $WithdrawMoneymoremore  提现人
		* @param string $OrderNo 订单号
		* @param string $CardNo  卡号
		* @param string $CardType 卡类型
		* @param string $BankCode 银行代码
		* @param string $BranchBankName 开户行名称
		* @param string $Province 开户行省份
		* @param string $city  开户行城市
		* @param string $FeePercent 平台承担手续费比例
		* @param string $Amount  提现金额
		* @param string $$PlatformMoneymoremore = "p67";
		*/
		public function withdraw($arr){
			
			$arr['ReturnURL'] = C('WEB_URL')."/member/withdraw/withdrawreturn";//返回地址
			$arr['NotifyURL'] = C('WEB_URL')."/notice/withdraw"; // 通知地址
			$dataStr = array('WithdrawMoneymoremore','PlatformMoneymoremore','OrderNo','Amount','FeePercent','CardNo','CardType','BankCode','BranchBankName','Province','City','RandomTimeStamp','Remark1','Remark2','Remark3','ReturnURL','NotifyURL');
			foreach($dataStr as $v){
			$str .= "$arr[$v]";
			}
			
			//dump($str);exit;
			if($this->antistate == 1)
			{
				$str = strtoupper(md5($str));
			}
			$arr['SignInfo'] = $this->rsa->sign($str);
			
			$arr['CardNo'] = $this->rsa->encrypt($arr['CardNo']);
			
			
		
			//$a=$this->rsa->decrypt($arr['CardNo']);
			
		//dump($a);exit;
			return $arr;
		
		}

		public function withdrawverify(){
			$WithdrawMoneymoremore = $_POST["WithdrawMoneymoremore"];
			$PlatformMoneymoremore = $_POST["PlatformMoneymoremore"];
			$LoanNo = $_POST["LoanNo"];
			$OrderNo = $_POST["OrderNo"];
			$Amount = $_POST["Amount"];
			$FeePercent = $_POST["FeePercent"];
			$Fee = $_POST["Fee"];
			$FreeLimit = $_POST["FreeLimit"];
			$RandomTimeStamp = $_POST["$RandomTimeStamp"];
			$Remark1 = $_POST["$Remark1"];
			$Remark2 = $_POST["$Remark2"];
			$Remark3 = $_POST["$Remark3"];
			$ResultCode = $_POST["ResultCode"];
			$SignInfo = $_POST["SignInfo"];
			
			$dataStr = $WithdrawMoneymoremore.$PlatformMoneymoremore.$LoanNo.$OrderNo.$Amount.$FeePercent.$Fee.$FreeLimit.$RandomTimeStamp.$Remark1.$Remark2.$Remark3.$ResultCode;
			//if($this->antistate == 1)
			//{
				$str = strtoupper(md5($str));
			//}
			$SignInfo=$this->rsa->sign($dataStr);
			$verifySignature = $this->rsa->verify($dataStr,$SignInfo);
			return $verifySignature;
		
		}
        /**
        * 生成form 表单
        * 
        * @param array $data // 数组形式
        * @param string $url_k  // url_arr 函数 key值
        */
        public function setForm($data,$url_k)
        {   
            header("Content-type: text/html; charset=utf-8");  
            $form =  '
            <form method="post" name="Forms" id="binding" action="'.$this->url_arr[$url_k].'" enctype="multipart/form-data">';
                           
           foreach($data as $k=>$v){
               $form .= '<input type="hidden" name="'.$k.'" value = "'.$v.'">';
           }
              
            $form .=  '</form>
                <script>
                  Forms.submit();
                </script>
            ';
            return $form;
        }
        
        
        public function getRandomNum($length)
        {
            $output='';
            for($a=0;$a<$length;$a++)
            {
                $output.=chr(mt_rand(48,57));//生成php随机数
            }
            return $output;
        }
        
        public function getTimeStamp()
        {
            $output=gmdate('YmdHis', time() + 3600 * 8).floor(microtime()*1000);
            return $output;
        }
        
        public function getRandomTimeStamp()
        {
            $output=$this->getRandomNum(2).$this->getTimeStamp();
            //return $output;
            return ''; //暂不使用
        }
		
    
    /**
    * 乾多多充值
    * 
    * @param mixed $RechargeMoneymoremore    要充值的账号的钱多多标识 m1 p1以m或p开头
    * @param mixed $PlatformMoneymoremore   P1开通钱多多账号为平台账号时生成，以p开头 
    * @param mixed $OrderNo      平台钱多多单号
    * @param mixed $Amount        金额 必须大于1
    * @param mixed $ReturnURL      页面返回地址
    * @param mixed $NotifyURL      后台通知地址
    * @param mixed $RechargeType   充值类型 空：网银充值 1：代扣充值 
    * @param mixed $CardNo       银行卡号 代扣时必填
    * @param mixed $RandomTimeStamp   随即时间戳 防抵御时必填
    * @param mixed $Remark1     备注
    * @param mixed $Remark2     备注
    * @param mixed $Remark3     备注
    * @return string
    */
    public function Moneymoremorecharge ($RechargeMoneymoremore, $PlatformMoneymoremore, $OrderNo, $Amount, $ReturnURL, $NotifyURL, $RechargeType='', $CardNo='',  $Remark1='', $Remark2='', $Remark3='') 
    {
        $data['RechargeMoneymoremore'] = $RechargeMoneymoremore;
        $data['PlatformMoneymoremore'] = $PlatformMoneymoremore;
        $data['OrderNo'] = $OrderNo;
        $data['Amount'] = $Amount;
        $data['RechargeType'] =  $RechargeType;
        $data['CardNo'] = $CardNo;
        $data['RandomTimestamp'] = $this->getRandomTimeStamp();//时间戳
        $data['Remark1'] = $Remark1;
        $data['Remark2'] = $Remark2;
        $data['Remark3'] = $Remark3;
        $data['ReturnURL'] = $ReturnURL;//返回地址
        $data['NotifyURL'] = $NotifyURL; // 通知地址
 
        $str = implode('',$data);
        
        if($this->antistate == 1){        //加密数据
            $str = strtoupper(md5($str));
        }
        
        if (!empty($CardNo)) {        //银行卡号加密
            $data['CardNo'] = $this->rsa->encrypt($CardNo);
        }
        
        $data['SignInfo']  = $this->rsa->sign($str); // 签名
        return $data;
    }
    /**
    * 充值验证
    * 
    */
    public function chargeVerify($data)
    {

        if (!empty($data["CardNoList"]))
        {
            $data["CardNoList"] = $this->rsa->decrypt($data["CardNoList"]);
            if (empty($data["CardNoList"]))
            {
                $data["CardNoList"] = "";
            }
        }
        
        $dataStr = implode('',$data);
        
        if($this->antistate == 1)
        {
            $dataStr = strtoupper(md5($dataStr));
        }
        $SignInfo =  $this->rsa->sign($dataStr);
        return  $this->rsa->verify($dataStr,$SignInfo);
    }
    

    /**
    * 转账接口
    * 
    * @param string $LoanJsonList    json 格式转账类型  参与签名是源字符串  提交用urlencode编码为utf8
    * @param string $ReturnURL   返回地址  
    * @param string $NotifyURL   后台通知地址
    * @param int $TransferAction   转账类型 1：投标  2：还款
    * @param int $Action      操作类型 1：手动转账 2：自动转账
    * @param int $TransferType  转账方式 1：桥连 2:直连
    * @param int $NeedAudit   是否通过审核 空：需要审核 1：自动通过
    * @param string $Remark1   备注1
    * @param string $Remark2   备注2
    * @param string $Remark3   备注3
    */
    public function transfer($LoanJsonList, $ReturnURL, $NotifyURL, $TransferAction=1, $Action=1, $TransferType=2, $NeedAudit='', $Remark1='', $Remark2='', $Remark3='')
    {  
        $data['LoanJsonList'] = $LoanJsonList;
        $data['PlatformMoneymoremore'] =  $this->plat_form_money_moremore; //平台乾多多标识 
        $data['TransferAction'] = $TransferAction;
        $data['Action'] = $Action;
        $data['TransferType'] = $TransferType;
        $data['NeedAudit'] = $NeedAudit;
        $data['Remark1'] = $Remark1;
        $data['Remark2'] = $Remark2;
        $data['Remark3'] = $Remark3;
        $data['RandomTimeStamp'] = $this->getRandomTimeStamp(); //随机时间戳
        $data['ReturnURL'] = $ReturnURL ; // 返回地址  
        $data['NotifyURL'] = $NotifyURL ; // 通知地址  
        
        $dataStr = implode('',$data);
        
        if($this->antistate == 1)
        {
            $dataStr = strtoupper(md5($dataStr));
        }
       
        $data['SignInfo'] =  $this->rsa->sign($dataStr);

        $data['LoanJsonList'] =  urlencode($data['LoanJsonList']);
        
        return $data;
    }
    /**
    * loanJsonList 方法
    * 
    * @param string $LoanOutMoneymoremore  付款人乾多多标识 m或p开头
    * @param string $LoanInMoneymoremore  收款人乾多多标识 m或p开头 
    * @param string $OrderNo  网贷平台订单号
    * @param string $BatchNo  网贷平台标号
    * @param double $Amount  金额
    * @param double $FullAmount  满标金额
    * @param string $TransferName  用途
    * @param string $Remark  备注
    * @param string $SecondaryJsonList   二次分配列表 转换成的json对象
    */
    public function loanJsonList($LoanOutMoneymoremore, $LoanInMoneymoremore, $OrderNo, $BatchNo, $Amount, $FullAmount='', $TransferName='', $Remark='', $SecondaryJsonList='')
    {
        $data['LoanOutMoneymoremore'] = $LoanOutMoneymoremore;
        $data['LoanInMoneymoremore'] = $LoanInMoneymoremore;
        $data['OrderNo'] = $OrderNo;
        $data['BatchNo'] = $BatchNo;
        $data['Amount'] = $Amount;
        $data['FullAmount'] = $FullAmount;
        $data['TransferName'] = $TransferName;
        $data['Remark']  = $Remark;
        $data['SecondaryJsonList'] = $SecondaryJsonList;
        return $data;
        
    }
    
    /**
    * 二次分配jsonlist
    * 
    * @param string $LoanInMoneymoremore   二次收款人乾多多标识
    * @param double $Amount   二次分配金额
    * @param string $TransferName  用途
    * @param string $Remark   备注
    * @return json
    */
    public function secondaryJsonList($LoanInMoneymoremore, $Amount, $TransferName='', $Remark='')
    {
        $data['LoanInMoneymoremore'] = $LoanInMoneymoremore;
        $data['Amount'] = $Amount;
        $data['TransferName'] = $TransferName;
        $data['Remark'] = $Remark;
        
        return $data;
    }
    
    /**
    * 转账认证
    * 
    */
    public function loanVerify($data)
    {
        $data['LoanJsonList'] = utf8_decode($data['LoanJsonList']);     
        $dataStr = implode('',$data);
        
        if($this->antistate == 1)
        {
            $dataStr = strtoupper(md5($dataStr));
        }
        $SignInfo =  $this->rsa->sign($dataStr);
        return  $this->rsa->verify($dataStr,$SignInfo);
    }


	 /**
    * 对账接口
    * 
    */
	public function orderQuery($data,$url='http://218.4.234.150:88/main/loan/loanorderquery.action'){
		$orderdata['PlatformMoneymoremore']=$data['PlatformMoneymoremore'];//平台标识
		$orderdata['LoanNo']=$data['LoanNo']; //乾多多流水号 
		$orderdata['OrderNo']=$data['OrderNo']; //平台订单号 
		$orderdata['BatchNo']=$data['BatchNo']; //平台标号 
		$orderdata['BeginTime']=$data['BeginTime']; //开始时间 
		$orderdata['EndTime']=$data['EndTime']; //结束时间 
		 $str = implode('',$orderdata);
             if($this->antistate == 1){
                 $str = strtoupper(md5($str));
             }
          
             $orderdata['SignInfo']  = $this->rsa->sign($str); // 签名
			// dump($orderdata);exit;
             //dump($orderdata);exit;
			
             return $this->postDate($orderdata,$this->url_arr['orderquery']);
	}

    
    /**
    * 余额查询接口
    * 
    * @param mixed $PlatformId  // 查询账户的乾多多标识 以m,p开头
    * @param mixed $PlatformType // 平台乾多多账户类型 1托管 2自有
    */
    public function balance($PlatformId, $PlatformType=1)
    {    
        $data['PlatformId'] = $PlatformId;                 
        $data['PlatformType'] = $PlatformType;
        $data['PlatformMoneymoremore'] = $this->plat_form_money_moremore;
        $dataStr = implode('',$data);
        if($this->antistate == 1)
        {
            $dataStr = strtoupper(md5($dataStr));
        }
        $data['SignInfo'] =   $this->rsa->sign($dataStr);
        
        return $this->postDate($data,$this->url_arr['balance']);
    }

	 /**
    * 授权接口
    * 
    * 
    * 
    */
	public function Authorize($MoneyId,$Platform,$TypeOpen,$TypeClose,$Remark1,$Remark2,$Remark3,$ReturnURL,$NotifyURL){
		$authdata['MoneymoremoreId']=$MoneyId;//用户乾多多标识
		$authdata['PlatformMoneymoremore']=$Platform;//平台乾多多标识
		$authdata['AuthorizeTypeOpen']=$TypeOpen;//开启授权类型1.投标 2.还款。3.二次分配审核。将所有数字有英文(,)连成字符串
		$authdata['AuthorizeTypeClose']=$TypeClose;//关闭授权类型1.投标 2.还款。3.二次分配审核。将所有数字有英文(,)连成字符串
		$authdata['Remark1']=$Remark1;
		$authdata['Remark2']=$Remark2;
		$authdata['Remark3']=$Remark3;
		$authdata['ReturnURL']=$ReturnURL; // 返回地址
		$authdata['NotifyURL']=$NotifyURL; // 通知地址
		//dump($authdata);
		 $str = implode('',$authdata); 
             if($this->antistate == 1){
                 $str = strtoupper(md5($str));
             }
        // dump($str);
             $authdata['SignInfo']  = $this->rsa->sign($str); // 签名
			//$a=$authdata['SignInfo'];
			//echo $a;
			//dump($authdata);
			//dump($this->rsa->decrypt($a));
			//exit;
             return $authdata;
	
	}
   public function Authorizereturn(){
		$MoneymoremoreId = $_POST["MoneymoremoreId"];
		$PlatformMoneymoremore = $_POST["PlatformMoneymoremore"];
		$AuthorizeTypeOpen = $_POST["AuthorizeTypeOpen"];
		$AuthorizeTypeClose = $_POST["AuthorizeTypeClose"];
		$AuthorizeType = $_POST["AuthorizeType"];
		$RandomTimeStamp = $_POST["RandomTimeStamp"];
		$Remark1 = $_POST["Remark1"];
		$Remark2 = $_POST["Remark2"];
		$Remark3 = $_POST["Remark3"];
		$ResultCode = $_POST["ResultCode"];
		$SignInfo = $_POST["SignInfo"];
		
		$dataStr =  $MoneymoremoreId.$PlatformMoneymoremore.$AuthorizeTypeOpen.$AuthorizeTypeClose.$AuthorizeType.$RandomTimeStamp.$Remark1.$Remark2.$Remark3.$ResultCode;
		

		 if($this->antistate == 1){
			$dataStr = strtoupper(md5($dataStr));
		 }
		
		$sign = $this->rsa->sign($dataStr);
		$verifySignature= $this->rsa->verify($dataStr,$sign);
		//dump($verifySignature);exit;
		return $verifySignature;
		
   }
   //后台路径
	public function authorizenotify(){
		
		$MoneymoremoreId = $_POST["MoneymoremoreId"];
		$PlatformMoneymoremore = $_POST["PlatformMoneymoremore"];
		$AuthorizeTypeOpen = $_POST["AuthorizeTypeOpen"];
		$AuthorizeTypeClose = $_POST["AuthorizeTypeClose"];
		$AuthorizeType = $_POST["AuthorizeType"];
		$RandomTimeStamp = $_POST["RandomTimeStamp"];
		$Remark1 = $_POST["Remark1"];
		$Remark2 = $_POST["Remark2"];
		$Remark3 = $_POST["Remark3"];
		$ResultCode = $_POST["ResultCode"];
		$SignInfo = $_POST["SignInfo"];
		//dump($_POST);
		$dataStr = $MoneymoremoreId.$PlatformMoneymoremore.$AuthorizeTypeOpen.$AuthorizeTypeClose.$AuthorizeType.$RandomTimeStamp.$Remark1.$Remark2.$Remark3.$ResultCode;

		/*if($this->antistate == 1)
		{
			$dataStr = strtoupper(md5($dataStr));
		}*/
		//dump($this->antistate);
		$dataStr = strtoupper(md5($dataStr));
		$sign = $this->rsa->sign($dataStr);
		$verifySignature = $this->rsa->verify($dataStr,$sign);
		
		//dump($verifySignature);exit;
		return $verifySignature;
		
	}

	public function loanOrder($platform,$LoanNo,$OrderNo,$BatchNo,$BeginTime, $EndTime)
	{
		$trackData = array(
				'PlatformMoneymoremore'=>$platform,
				'LoanNo'=>$LoanNo,
				'OrderNo'=>$OrderNo,
				'BatchNo'=>$BatchNo,
                'BeginTime' => $BeginTime,
                'EndTime'   => $EndTime,
            );

		$dataStr = implode('',$trackData);
        
        $trackData['SignInfo'] =  $this->rsa->sign($dataStr);
	
		return $this->postDate($trackData, $this->url_arr['orderquery']);

	}
    /**
    * 审核接口
    * 
    * @param string $LoanNoList   用，号连接的流水号
    * @param interger $AuditType  1：通过，2：退回，3二次分配同意，4：二次分配不同意
    * @param string $ReturnURL  返回地址
    * @param string $NotifyURL  后台通知地址
    * @param string $Ramark1   备注1
    * @param string $Ramark2    备注2
    * @param string $Ramark3    备注3
    */
    public function loanAudit($LoanNoList, $AuditType, $ReturnURL, $NotifyURL, $Remark1='', $Remark2='', $Remark3='')
    {
         $data['LoanNoList'] = $LoanNoList;
         $data['PlatformMoneymoremore'] =  $this->plat_form_money_moremore;
         $data['AuditType'] = intval($AuditType);
         $data['RandomTimeStamp'] = $this->getRandomTimeStamp(); //随机时间戳
         $data['Remark1']  = $Remark1;
         $data['Remark2']  = $Remark2;
         $data['Remark3']  = $Remark3;
         $data['ReturnURL'] = $ReturnURL;
         $data['NotifyURL'] = $NotifyURL;
         
         $dataStr = implode('', $data);
         if($this->antistate == 1)
         {
            $dataStr = strtoupper(md5($dataStr));
         }
         $data['SignInfo'] = $this->rsa->sign($dataStr);
         return $data;
    }
    
    /**
    * 审核认证
    * 
    */
    public function loanAuditVerify($data)
    { 
        $dataStr = implode('',$data);
        
        if($this->antistate == 1)
        {
            $dataStr = strtoupper(md5($dataStr));
        }
        $SignInfo =  $this->rsa->sign($dataStr);
        return  $this->rsa->verify($dataStr,$SignInfo);
    }
 }
?>
