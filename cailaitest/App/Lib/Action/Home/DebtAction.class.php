<?php
    /**
    * 普通标债权转让控制器类
    * 
    * @author  zhangjili 404851763@qq.com
    * @time 2014-01-03 16:28
    * @copyright lvmaque 超级版
    * @link www.lvmaque.com
    */
    class DebtAction extends HCommonAction
    {
	    public function test()
		{
			echo 1;
			exit;
		}
        
        /**
        * 债权转让列表
        * 
        */
        public function index()
        {
			$curl = $_SERVER['REQUEST_URI'];
		$urlarr = parse_url($curl);
		parse_str($urlarr['query'],$surl);//array获取当前链接参数，2.
       $urlArr = array('borrow_status','borrow_duration','leve');
		$leveconfig = FS("Webconfig/leveconfig");
		foreach($urlArr as $v){
			$newpars = $surl;//用新变量避免后面的连接受影响
			unset($newpars[$v],$newpars['type'],$newpars['order_sort'],$newpars['orderby']);//去掉公共参数，对掉当前参数
			foreach($newpars as $skey=>$sv){
				if($sv=="all") unset($newpars[$skey]);//去掉"全部"状态的参数,避免地址栏全满
			}
			
			$newurl = http_build_query($newpars);//生成此值的链接,生成必须是即时生成
			$searchUrl[$v]['url'] = $newurl;
			$searchUrl[$v]['cur'] = empty($_GET[$v])?"all":text($_GET[$v]);
		}
		$searchMap['borrow_status'] = array("all"=>"不限制","2"=>"进行中","4"=>"复审中","6"=>"还款中","7"=>"已完成");
		$searchMap['borrow_duration'] = array("all"=>"不限制","0-3"=>"3个月以内","3-6"=>"3-6个月","6-12"=>"6-12个月","12-24"=>"12-24个月");
		$searchMap['leve'] = array("all"=>"不限制","{$leveconfig['1']['start']}-{$leveconfig['1']['end']}"=>"{$leveconfig['1']['name']}","{$leveconfig['2']['start']}-{$leveconfig['2']['end']}"=>"{$leveconfig['2']['name']}","{$leveconfig['3']['start']}-{$leveconfig['3']['end']}"=>"{$leveconfig['3']['name']}","{$leveconfig['4']['start']}-{$leveconfig['4']['end']}"=>"{$leveconfig['4']['name']}","{$leveconfig['5']['start']}-{$leveconfig['5']['end']}"=>"{$leveconfig['5']['name']}","{$leveconfig['6']['start']}-{$leveconfig['6']['end']}"=>"{$leveconfig['6']['name']}","{$leveconfig['7']['start']}-{$leveconfig['7']['end']}"=>"{$leveconfig['7']['name']}");

		$search = array();
		//搜索条件
		foreach($urlArr as $v){
			if($_GET[$v] && $_GET[$v]<>'all'){
				switch($v){
					case 'leve':
						$barr = explode("-",text($_GET[$v]));
						$search["m.credits"] = array("between",$barr);
					break;
					case 'borrow_status':
						$search["b.".$v] = intval($_GET[$v]);
					break;
					default:
						$barr = explode("-",text($_GET[$v]));
						$search["b.".$v] = array("between",$barr);
					break;
				}
			}
		}
	
		if($search['b.borrow_status']==0){
			$search['b.borrow_status']=array("in","2,4,6,7");
		}
		$str = "%".urldecode($_REQUEST['searchkeywords'])."%";
		if($_GET['is_keyword']=='1'){
			$search['m.user_name']=array("like",$str);
		}elseif($_GET['is_keyword']=='2'){
			$search['b.borrow_name']=array("like",$str);
			
		}
		
		$parm['map'] = $search;
        
	
        D("DebtBehavior");
        $Debt = new DebtBehavior();
		
        $list = $Debt->listAll($parm);

        $this->assign("list", $list);
		A("Home/Invest")->blank();
        $this->fang=session('fang');
		$this->zong=session('zong');
		$this->che=session('che');


		$this->assign("searchUrl",$searchUrl);
    	$this->assign("searchMap",$searchMap);


    	//左侧页面
    	$left=A('Home/Invest')->invest_ad();
    	
    	$this->left =$left;
    	
        $this->display();  
        }
        
        /**
        * 购买债权提示框
        * 
        */
        public function buydebt()
        {
			if(!$this->uid)  ajaxmsg("请先登陆",0);
            $invest_id = intval($_REQUEST['invest_id']);
            !$invest_id && ajaxmsg(L('参数错误'),0);
            $debt = M("invest_detb")->field("transfer_price, money")->where("invest_id={$invest_id}")->find();
            $buy_user = M("member_money")->field("account_money, back_money")->where("uid={$this->uid}")->find();
            $account =  $buy_user['account_money'] + $buy_user['back_money'];
            
            $this->assign('debt', $debt);
            $this->assign('account', $account);
            $this->assign('invest_id', $invest_id);
            $d['content'] = $this->fetch();
            echo json_encode($d);
            
        }
        
        /**
        * 确认购买
        * 流程： 检测购买条件
        * 购买
        */
        public function buy()
        {
            //$paypass = strval($_REQUEST['paypass']);
            $invest_id = intval($_REQUEST['invest_id']);
            //echo $invest_id;exit;
            D("DebtBehavior");
            $Debt = new DebtBehavior($this->uid);
            // 检测是否可以购买  密码是否正确，余额是否充足
            //$result = $Debt->buy($paypass, $invest_id);
			$debt_info = M('invest_detb')->field("transfer_price,sell_uid,debt_fee,money")->where("invest_id={$invest_id}")->find();
			$info = M("borrow_investor")->field("borrow_id,investor_uid,borrow_uid,investor_capital,investor_interest,ordid,orddate")->where("id=".$invest_id)->find();
			$info1 = M("members")->field("usrid")->where("id=".$debt_info['sell_uid'])->find();
			$info2 = M("members")->field("usrid")->where("id=$this->uid")->find();
			$info3 = M("members")->field("usrid")->where("id=".$info['borrow_uid'])->find();
			$sellcustid = $info1['usrid'];//转让人
			$creditamt = $info['investor_capital'];//转让金额（必须是本金）
			$dealamt = $debt_info['transfer_price'];//承接金额（转让金额上下浮动10%）
			$Fee = $debt_info['debt_fee'];
			$biddetails = array();
			$biddetails['BidOrdId'] = $info['ordid'];//原投标订单号
			$biddetails['BidOrdDate'] = $info['orddate'];//原投标订单日期
			$biddetails['BidCreditAmt'] = $info['investor_capital'];//从原投标订单中转出的本金
			$details = array();
			$details['BorrowerCustId'] = $info3['usrid'];//借款人
			$details['BorrowerCreditAmt'] = $info['investor_capital'];//
			$details['PrinAmt'] = "0.00";//已还本金
			$biddetails['BorrowerDetails'] =$details;
			$biddetails = json_encode($biddetails);
			$str1=array('{','}');
			$str2=array('[{','}]');
			$biddetails = str_replace($str1,$str2,$biddetails);
			$biddetails = '{"BidDetails":'.$biddetails.'}';
			$info2 = M("members")->field("usrid")->where("id=$this->uid")->find();
			$buycustid = $info2['usrid'];//承接人
			
			import("ORG.Huifu.Huifu");
			$huifu = new Huifu();
			$huifu->creditAssign($sellcustid,$creditamt,$dealamt,$biddetails,$Fee,$buycustid,$invest_id);
			exit;
			//$result = $Debt->buy($invest_id);

            if($result === 'TRUE'){
                ajaxmsg('购买成功');
            }else{
                ajaxmsg($result, 1);
            }
        }
    }
?>
