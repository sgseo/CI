<?php
    class AwardsAction extends ACommonAction
    {  
        /**
        * 邀请奖励 列表
        * 
        */
        public function invite()
        {
            
            $map=array();
            $map['m.recommend_id'] = array('neq','');
            if($_REQUEST['uname']){
                $map['m1.user_name'] = array("like",urldecode($_REQUEST['uname'])."%");
                $search['uname'] = urldecode($_REQUEST['uname']);    
            }
            if($_REQUEST['realname']){
                $map['mi.real_name'] = urldecode($_REQUEST['realname']);
                $search['realname'] = $map['mi.real_name'];    
            }
           
            if($_REQUEST['bj']){
                $map['mm.invite_money'] = array($_REQUEST['bj'],$_REQUEST['money']);
                
                $search['bj'] = $_REQUEST['bj'];    
                $search['money'] = $_REQUEST['money'];    
            }

            //分页处理
            import("ORG.Util.Page");
            
            $count = M('members m')
                        ->join("{$this->pre}member_money mm ON mm.uid=m.id")
                        ->join("{$this->pre}member_info mi ON mi.uid=m.id")
                        ->where($map)
                        ->group("m.recommend_id")
                        ->count('m.id');
            

            $p = new Page($count, C('ADMIN_PAGE_SIZE'));
            $page = $p->show();
            $Lsql = "{$p->firstRow},{$p->listRows}";
            //分页处理
            $field= 'm1.user_phone,m1.reg_time,m1.user_name,m1.customer_name,m1.user_leve,m1.time_limit,mi.real_name,
                        m1.user_email,m.recommend_id as id,m1.is_borrow,m1.is_vip, mm.invite_money';
            $list = M('members m')->field($field)
                        ->join("{$this->pre}members m1 ON m1.id=m.recommend_id")
                        ->join("{$this->pre}member_money mm ON mm.uid=m.recommend_id")
                        ->join("{$this->pre}member_info mi ON mi.uid=m.recommend_id")
                        ->where($map)
                        ->limit($Lsql)
                        ->order('invite_money DESC')
                        ->group("m.recommend_id")
                        ->select();
            foreach($list as $v)
            {
                if($v['recommend_id']<>0){
                    $v['recommend_name'] = M("members")->getFieldById($v['recommend_id'],"user_name");
                 }else{
                    $v['recommend_name'] ="<span style='color:#000'>无推荐人</span>";
                 }
                 
                ($v['user_leve']==1 && $v['time_limit']>time())?$v['user_type'] = "<span style='color:red'>VIP会员</span>":$v['user_type'] = "普通会员";
                $row[]=$v;    
            }
            $this->assign('list', $row);
            $this->assign('pagebar', $page);
            $this->assign("bj", array("gt"=>'大于',"eq"=>'等于',"lt"=>'小于'));
            $this->assign("search", $search);
            $this->display();
        }
        
        /**
        * 调整邀请奖励余额
        * 
        */
        public function inviteedit()
        {
            $this->assign("id",intval($_GET['id']));
            $this->display();
        }
        
        public function doInviteEdit()
        {
            if($this->isPost()){
                
                $invite_money = floatval($_POST['invite_money']);
                $info =  text($_POST['info']);
                $uid = intval($_POST['id']);           
                if(updateInvite($uid, $invite_money, $info)){
                    $this->success("处理成功！", U('invite'));  exit; 
                }else{
                    $this->error("处理失败", U('invite'));
                } 
            }
            $this->error("参数错误", U('invite'));    
        }
        /**
        * 邀请奖励记录
        * 
        */
        public function inviteLog()
        {
            $map=array();
            if($_REQUEST['uname']){
                $map['m.user_name'] = array("like",urldecode($_REQUEST['uname'])."%");
                $search['uname'] = urldecode($_REQUEST['uname']);    
            }

           
            if($_REQUEST['bj']){
                $map['i.affect_money'] = array($_REQUEST['bj'],$_REQUEST['money']);
                
                $search['bj'] = $_REQUEST['bj'];    
                $search['money'] = $_REQUEST['money'];    
            }
        

        
            //分页处理
            import("ORG.Util.Page");
            $count = M('invite_awards i')->join("{$this->pre}member m ON i.uid=m.id")->where($map)->count('i.id');
            
            $p = new Page($count, C('ADMIN_PAGE_SIZE'));
            $page = $p->show();
            $Lsql = "{$p->firstRow},{$p->listRows}";
            //分页处理
            $field= 'm.id as uid,m.user_name,i.*';
            $list = M('invite_awards i')->field($field)->join("{$this->pre}members m ON i.uid=m.id")->where($map)->limit($Lsql)->order('i.id DESC')->select();

            $this->assign('list', $list);
            $this->assign('pagebar', $page);
            $this->assign("bj", array("gt"=>'大于',"eq"=>'等于',"lt"=>'小于'));
            $this->assign("search", $search);
            $this->display();
        }

		public function inviteTotal()
		{
			$uid = intval($_GET['id']);
			$vm = '';
			$field = " m.id,m.user_name,sum(ia.affect_money) jiangli, sum(ia.invest_money) as invest_money";
			$vm = M("members m")->field($field)->join(" lzh_invite_awards ia ON m.id = ia.target_uid ")->where(" m.recommend_id ={$uid} ")->group("ia.target_uid")->select();
			$admin_add = M('invite_awards')->where("uid={$uid} and target_uid=0 and affect_money>0")->sum(affect_money);	 
			$admin_minus = M('invite_awards')->where("uid={$uid} and target_uid=0 and affect_money<0")->sum(affect_money);
	
			$this->assign('admin_add', $admin_add);
			$this->assign('admin_minus', $admin_minus);
			$this->assign('list',$vm);
			$this->display();
		}
    }
?>
