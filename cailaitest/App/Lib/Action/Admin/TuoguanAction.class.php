<?php

class TuoguanAction extends ACommonAction
{
    /**
    +----------------------------------------------------------
    * 默认操作
    +----------------------------------------------------------
    */
    public function index()
    {
		$tuoguan = FS("Webconfig/tuoguanconfig");
		
		$this->assign('tuoguan',$tuoguan);
        $this->display();
    }
    
     public function zwtransfer(){	
         if($_POST["type"] == "zw"){
             $uid =  M('members')->field('id')->where("user_name=".$_POST["usrTelephone"])->find();
             $zwMoney = M('member_money')->field('(account_money+back_money) all_money')->where("uid=".$uid['id'])->find();
	     echo json_encode($zwMoney);
             exit();
         }     
        $this->display();
    }
    
    public function zwdomer(){
        $zwTelephone = trim($_POST['zw_telephone']);
		$usr = M("members")->field("usrid")->where("user_name=".$zwTelephone)->find();
		$usrid = $usr['usrid'];
		$transamt = $_POST['money'];
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$res = $huifu->usrAcctPay($usrid,$transamt);
	}
	
    //商户转账给个人
    public function zwtoperson(){     	
			if($this->admin_id==135){
				$mobile = $_REQUEST['mobile']?$_REQUEST['mobile']:'';
				$money = $_REQUEST['money']?$_REQUEST['money']:'';
				
				//自动填充的需要回跳
				if($mobile!=''){
					$this->assign('need_return',1);
				}
				
				$this->assign('money',$money);
				$this->assign('mobile',$mobile);
				
				$this->display();
			}else{
				die("没有权限");
			}          
	}
	
         public function zwtodoperson(){
			
            if($this->admin_id!=135){
                    die("没有权限");
            }
            
             if($_POST["type"] == "zwperson"){
                 $pre = C('DB_PREFIX');
                 $zwfield = 'mi.real_name,mm.account_money+mm.back_money all_money';
                    $zwMoney =  M()->table($pre.'members m')->join("{$pre}member_info mi ON (m.user_name=mi.cell_phone AND m.id=mi.uid)")
                            ->join("{$pre}member_money mm ON (mi.uid=mm.uid)")->field($zwfield)->where("m.user_name=".$_POST["usrTelephone"])->find();       
                    echo json_encode($zwMoney);
                    exit();
             }

        $zwTelephone = trim($_POST['zw_telephone']);
		$usr = M("members")->field("usrid")->where("user_name=".$zwTelephone)->find();
		$usrid = $usr['usrid'];
		$transamt = $_POST['money'];
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$res = $huifu->transfer2($transamt,$usrid);    
        $this->assign('res',"转账操作已执行，请留意资金是否有变动");
        $need_return = $_REQUEST['need_return']?$_REQUEST['need_return']:'';
        if($need_return==1){
        	$this->redirect("borrow/repaylist"); 
        	
        }else{
        	$this->display();
        }       
	}
        
    public function save()
    {
		FS("tuoguanconfig",$_POST['tuoguan'],"Webconfig/");
		alogs("Tuoguan",0,1,'成功执行了托管账户管理的设置操作！');//管理员操作日志
		$this->success("操作成功",__URL__."/index/");
    }
	public function pay()
	{
		$this->display();
	}
	public function dopay()
	{
		$tuoguan = FS("Webconfig/tuoguanconfig");
		$usrid = $tuoguan['huifu']['MerCustId'];
		$transamt = $_POST['money'];
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$huifu->netSave($usrid,$transamt);
	}
	public function login()
	{
		$tuoguan = FS("Webconfig/tuoguanconfig");
		$usrid = $tuoguan['huifu']['MerCustId'];
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$huifu->userLogin($usrid);
	}
	
	public function withdraw()
	{
		$this->display();
	}
	
	public function dowithdraw()
	{
		//echo "<pre>";print_r($_POST);echo "</pre>";exit;
		$tuoguan = FS("Webconfig/tuoguanconfig");
		$usrid = $tuoguan['huifu']['MerCustId'];
		$transamt = $_POST['money'];
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$huifu->cash($usrid,$transamt);
	}
	
	public function dologin()
	{
	}
	
	//商户帐户信息
	public function queryaccts()
	{
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$res = $huifu->queryAccts();
		$accts = $res['AcctDetails'];
		
		$spedt = array();
		foreach($accts as $v)
		{
			if(strcmp($v['AcctType'],"BASEDT")==0)
			{
				$basedt = $v;
			}
			else if(strcmp($v['AcctType'],"MERDT")==0)
			{
				$merdt = $v;
			}
			else
			{
				$spedt[] = $v;
			}
		}
		
		$this->assign("basedt",$basedt);
		$this->assign("merdt",$merdt);
		$this->assign("spedt",$spedt);
		$this->display();
	}
	
	//交易状态查询
	public function transstat()
	{
		$this->display();
	}
	
	public function dotransstat()
	{
		//echo "<pre>";print_r($_POST);echo "</pre>";exit;
		$ordid = $_POST['ordid'];
		$orddate = $_POST['orddate'];
		$querytype = $_POST['type'];
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$res = $huifu->queryTransStat($ordid,$orddate,$querytype);
		$msg = $res['RespDesc'];
		echo $msg;
	}
	
	public function trf()
	{
		//echo "<pre>";print_r($_POST);echo "<pre>";exit;
		if(!empty($_POST))
		{
			$begindate = str_replace('-','',substr($_POST['start_time'],0,10));
			$enddate = str_replace('-','',substr($_POST['end_time'],0,10));
		}
		else if(!empty($_GET['begindate']))
		{
			$begindate = $_GET['begindate'];
			$enddate = $_GET['enddate'];
		}
		else
		{
			$begindate = date("Ymd",time());
			$enddate = date("Ymd",time());
		}
		if(!empty($_GET['p']))
		{
			$pagenum = $_GET['p'];
		}
		else
		{
			$pagenum = 1;
		}
		$pagesize = 20;
		
		$stat = array('S'=>"成功",'F'=>"失败",'I'=>"初始",'P'=>"部分成功",'H'=>"经办",'R'=>"拒绝");
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$res = $huifu->trfReconciliation($begindate,$enddate,$pagenum,$pagesize);
		$list = $res['TrfReconciliationDtoList'];
		$tatalitems = $res['TotalItems'];
		import("ORG.Util.Page");
		$p = new Page($tatalitems,$pagesize);
		$p->parameter = "begindate=$begindate&enddate=$enddate";
		$page = $p->show();
		foreach($list as $k=>$v)
		{
			$list[$k]['TransStat'] = $stat[$v['TransStat']];
		}
		
		$this->assign("list",$list);
		$this->assign("totalitems",$tatalitems);
		$this->assign("pagebar", $page);
		$this->display();
	}
	
	public function reconciliation()
	{
		if(!empty($_POST))
		{
			$begindate = str_replace('-','',substr($_POST['start_time'],0,10));
			$enddate = str_replace('-','',substr($_POST['end_time'],0,10));
		}
		else if(!empty($_GET['begindate']))
		{
			$begindate = $_GET['begindate'];
			$enddate = $_GET['enddate'];
		}
		else
		{
			$begindate = date("Ymd",time());
			$enddate = date("Ymd",time());
		}
		if(!empty($_GET['p']))
		{
			$pagenum = $_GET['p'];
		}
		else
		{
			$pagenum = 1;
		}
		$pagesize = 20;
		
		$stat = array('S'=>"成功",'F'=>"失败",'I'=>"初始",'P'=>"部分成功",'H'=>"经办",'R'=>"拒绝");
		
		//$querytype = "REPAYMENT";
		$querytype = $_REQUEST['type'];
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$res = $huifu->reconciliation($begindate,$enddate,$pagenum,$pagesize,$querytype);
		$list = $res['ReconciliationDtoList'];
		$tatalitems = $res['TotalItems'];
		import("ORG.Util.Page");
		$p = new Page($tatalitems,$pagesize);
		$p->parameter = "begindate=$begindate&enddate=$enddate&type=$querytype";
		$page = $p->show();
		foreach($list as $k=>$v)
		{
			$list[$k]['TransStat'] = $stat[$v['TransStat']];
		}
		
		$this->assign("list",$list);
		$this->assign("totalitems",$tatalitems);
		$this->assign("pagebar", $page);
		$this->display();
	}
	
	public function querycash()
	{
		if(!empty($_POST))
		{
			$begindate = str_replace('-','',substr($_POST['start_time'],0,10));
			$enddate = str_replace('-','',substr($_POST['end_time'],0,10));
		}
		else if(!empty($_GET['begindate']))
		{
			$begindate = $_GET['begindate'];
			$enddate = $_GET['enddate'];
		}
		else
		{
			$begindate = date("Ymd",time());
			$enddate = date("Ymd",time());
		}
		if(!empty($_GET['p']))
		{
			$pagenum = $_GET['p'];
		}
		else
		{
			$pagenum = 1;
		}
		$pagesize = 20;
		
		$stat = array('S'=>"成功",'F'=>"失败",'I'=>"初始",'P'=>"部分成功",'H'=>"经办",'R'=>"拒绝");
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$res = $huifu->cashReconciliation($begindate,$enddate,$pagenum,$pagesize);
		$list = $res['CashReconciliationDtoList'];
		$tatalitems = $res['TotalItems'];
		import("ORG.Util.Page");
		$p = new Page($tatalitems,$pagesize);
		$p->parameter = "begindate=$begindate&enddate=$enddate";
		$page = $p->show();
		foreach($list as $k=>$v)
		{
			$list[$k]['TransStat'] = $stat[$v['TransStat']];
		}
		
		$this->assign("list",$list);
		$this->assign("totalitems",$tatalitems);
		$this->assign("pagebar", $page);
		$this->display();
	}
	
	public function querysave()
	{
		if(!empty($_POST))
		{
			$begindate = str_replace('-','',substr($_POST['start_time'],0,10));
			$enddate = str_replace('-','',substr($_POST['end_time'],0,10));
		}
		else if(!empty($_GET['begindate']))
		{
			$begindate = $_GET['begindate'];
			$enddate = $_GET['enddate'];
		}
		else
		{
			$begindate = date("Ymd",time());
			$enddate = date("Ymd",time());
		}
		if(!empty($_GET['p']))
		{
			$pagenum = $_GET['p'];
		}
		else
		{
			$pagenum = 1;
		}
		$pagesize = 20;
		
		$stat = array('S'=>"成功",'F'=>"失败",'I'=>"初始",'P'=>"部分成功",'H'=>"经办",'R'=>"拒绝");
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$res = $huifu->saveReconciliation($begindate,$enddate,$pagenum,$pagesize);
		$list = $res['SaveReconciliationDtoList'];
		$tatalitems = $res['TotalItems'];
		import("ORG.Util.Page");
		$p = new Page($tatalitems,$pagesize);
		$p->parameter = "begindate=$begindate&enddate=$enddate";
		$page = $p->show();
		foreach($list as $k=>$v)
		{
			$list[$k]['TransStat'] = $stat[$v['TransStat']];
		}
		
		$this->assign("list",$list);
		$this->assign("totalitems",$tatalitems);
		$this->assign("pagebar", $page);
		$this->display();
	}
	
	//企业开户状态查询
	public function corpquery()
	{
		$this->display();
	}
	
	public function docorpquery()
	{
		$busicode = $_POST['busicode'];
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$res = $huifu->corpRegisterQuery($busicode);
		$msg = $res['AuditStat'];
		$stat = array('I'=>"初始",'T'=>"提交",'P'=>"审核中",'R'=>"审核拒绝",'F'=>"开户失败",'K'=>"开户中",'Y'=>"开户成功");
		echo $stat[$msg];
	}
}
?>