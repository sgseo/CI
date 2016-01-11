<?php
    class TinvestAction extends HCommonAction
    {
        public function tdetail() 
        {    
            if($_GET['type']=='commentlist'){
                //评论
                $cmap['tid'] = intval($_GET['id']);
                $clist = getCommentList($cmap,5);
                $this->assign("commentlist",$clist['list']);
                $this->assign("commentpagebar",$clist['page']);
                $this->assign("commentcount",$clist['count']);
                $data['html'] = $this->fetch('commentlist');
                exit(json_encode($data));
            }


            $pre = C('DB_PREFIX');
            $id = intval($_GET['id']);
            $Bconfig = require C("APP_ROOT")."Conf/borrow_config.php";
            
            //合同ID
            if($this->uid){
                $invs = M('transfer_borrow_investor')->field('id')->where("borrow_id={$id} AND (investor_uid={$this->uid} OR borrow_uid={$this->uid})")->find();
                if($invs['id']>0) $invsx=$invs['id'];
                elseif(!is_array($invs)) $invsx='no';
            }else{
                $invsx='login';
            }
            $this->assign("invid",$invsx);
            //合同ID
            //borrowinfo
            //$borrowinfo = M("borrow_info")->field(true)->find($id);
            $borrowinfo = M("transfer_borrow_info b")->join("{$pre}transfer_detail d ON d.borrow_id=b.id")->field(true)->find($id);
            /*if(!is_array($borrowinfo) || $borrowinfo['is_show'] == 0){
                $this->error("数据有误或此标已认购完");
            }*/
            $borrowinfo['progress'] = getfloatvalue($borrowinfo['transfer_out']/$borrowinfo['transfer_total'] * 100, 2);
            $borrowinfo['need'] = getfloatvalue(($borrowinfo['transfer_total'] - $borrowinfo['transfer_out'])*$borrowinfo['per_transfer'], 2 );
            $borrowinfo['updata'] = unserialize($borrowinfo['updata']);
            $this->assign("vo", $borrowinfo);
                                    
                                
            //此标借款利息还款相关情况
            //memberinfo
            $memberinfo = M("members m")->field("m.id,m.customer_name,m.customer_id,m.user_name,m.reg_time,m.credits,fi.*,mi.*,mm.*")->join("{$pre}member_financial_info fi ON fi.uid = m.id")->join("{$pre}member_info mi ON mi.uid = m.id")->join("{$pre}member_money mm ON mm.uid = m.id")->where("m.id={$borrowinfo['borrow_uid']}")->find();
            $areaList = getArea();
            $memberinfo['location'] = $areaList[$memberinfo['province']].$areaList[$memberinfo['city']];
            $memberinfo['location_now'] = $areaList[$memberinfo['province_now']].$areaList[$memberinfo['city_now']];
            $this->assign("minfo",$memberinfo);
            //memberinfo
            
            //investinfo
            $fieldx = "bi.investor_capital,bi.transfer_month,bi.transfer_num,bi.add_time,m.user_name,bi.is_auto,bi.final_interest_rate";
            $investinfo = M("transfer_borrow_investor bi")->field($fieldx)->join("{$pre}members m ON bi.investor_uid = m.id")->where("bi.borrow_id={$id}")->order("bi.id DESC")->select();
            $this->assign("investinfo",$investinfo);
            //investinfo
            
            $oneday = 86400;
            $time_1 = time() - 30 * $oneday.",".time();
            $time_6 = time() - 180 * $oneday.",".time();
            $time_12 = time() - 360 * $oneday.",".time();
            $mapxr['borrow_id'] = $id;
            $this->assign("time_all_out", M("transfer_borrow_investor")->where($mapxr)->sum("transfer_num"));
            $mapxr['add_time'] = array("between","{$time_1}");
            $this->assign("time_1_out", M("transfer_borrow_investor")->where($mapxr)->sum("transfer_num"));
            $mapxr['add_time'] = array("between","{$time_6}");
            $this->assign("time_6_out",M("transfer_borrow_investor")->where($mapxr)->sum("transfer_num"));
            $mapxr['add_time'] = array("between","{$time_12}");
            $this->assign("time_12_out",M("transfer_borrow_investor")->where($mapxr)->sum("transfer_num"));
            
            $mapxr = array();
            $mapxr['borrow_id'] = $id;
            $mapxr['status'] = 2;
            $this->assign("time_all_back", M("transfer_borrow_investor")->where($mapxr)->sum("transfer_num"));
            $mapxr['back_time'] = array("between","{$time_1}");
            $this->assign("time_1_back",M("transfer_borrow_investor")->where($mapxr)->sum("transfer_num"));
            $mapxr['back_time'] = array("between","{$time_6}");
            $this->assign("time_6_back", M("transfer_borrow_investor")->where($mapxr)->sum("transfer_num"));
            $mapxr['back_time'] = array("between","{$time_12}");
            $this->assign("time_12_back", M("transfer_borrow_investor")->where($mapxr)->sum("transfer_num"));
            
          
            $this->assign("Bconfig",$Bconfig);
            $this->display();
        } 
        
        public function invest()
        {
            if(!$this->uid){
                if($this->isAjax()){
                    die("请先登录后投资");   
                }else{
                    $this->redirect('M/pub/login');       
                }
            }
            if($this->isAjax()){
                $borrow_id = intval($this->_get('bid'));
                $tnum = intval($_POST['cnum']);
                $pre = c( "DB_PREFIX" );

                $m = M("member_money")->field('account_money,back_money,money_collect')->find($this->uid);
                $amoney = $m['account_money']+$m['back_money'];
                $uname = session("u_user_name");
                $binfo = M("transfer_borrow_info")
                        ->field( "borrow_uid,borrow_interest_rate,transfer_out,transfer_back,transfer_total,
                                per_transfer,is_show,deadline,min_month,increase_rate,reward_rate,borrow_duration")
                        ->find($borrow_id);
                
                if($this->uid == $binfo['borrow_uid']) ajaxmsg("不能去投自己的标",0);
                $month = $binfo['borrow_duration'];//手机版默认投资最大期限
                $max_num = $binfo['transfer_total'] - $binfo['transfer_out'];
                if($max_num < $tnum){
                    die("本标还能认购最大份数为".$max_num."份，请重新输入认购份数" );
                }
                $money = $binfo['per_transfer'] * $tnum;
                if($amoney < $money){
                    die( "尊敬的{$uname}，您准备认购{$money}元，但您的账户可用余额为{$amoney}元，请先去充值再认购");
                }
                $vm = getMinfo($this->uid,"m.pin_pass,mm.invest_vouch_cuse,mm.money_collect");
                $pin_pass = $vm['pin_pass'];
                $pin = md5($_POST['paypass']);
                if ($pin != $pin_pass){
                    die( "支付密码错误，请重试" );
                }
                $done = TinvestMoney($this->uid,$borrow_id,$tnum,$month);//投企业直投
                if($done === true){
                    die('TRUE');
                }else if($done){
                    die($done);
                }else{
                    die("很遗憾，认购失败，请重试!");
                }
                
            }else{
                $borrow_id = $this->_get('bid');
                $pre = C('DB_PREFIX'); 
                $borrowinfo = M("transfer_borrow_info b")->join("{$pre}transfer_detail d ON d.borrow_id=b.id")->field(true)->find($borrow_id);

                $borrowinfo['progress'] = getfloatvalue($borrowinfo['transfer_out']/$borrowinfo['transfer_total'] * 100, 2);
                $borrowinfo['need'] = getfloatvalue(($borrowinfo['transfer_total'] - $borrowinfo['transfer_out'])*$borrowinfo['per_transfer'], 2 );
                $borrowinfo['updata'] = unserialize($borrowinfo['updata']);
                $this->assign("vo", $borrowinfo);    
                
                $user_info = M('member_money')
                                ->field("account_money+back_money as money ")
                                ->where("uid='{$this->uid}'")
                                ->find();
                $this->assign('user_info', $user_info);
                $paypass = M("members")->field('pin_pass')->where('id='.$this->uid)->find();
                $this->assign('paypass', $paypass['pin_pass']);
                $this->display();   
            }
        }
        
    
    }
?>
