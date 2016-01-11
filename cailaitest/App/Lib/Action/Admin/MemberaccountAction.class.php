<?php
// 全局设置
class MemberaccountAction extends ACommonAction
{
    private $_PageCurrent;  // 当前页号
    private $_PageSize;     // 当前条数
    private $_url;
    /**
    +----------------------------------------------------------
    * 默认操作   即使数据
    +----------------------------------------------------------
    */
    
    public function duizhang(){
        if(empty($_POST)||empty($_POST[searchtel])){
            //分页处理
            import("ORG.Util.Page");
             $dbObj=M('member_moneyfuto mf');
             $total = $dbObj->count();
            $p = new Page($total,2);
             $page = $p->show();
             $Lsql = "{$p->firstRow},{$p->listRows}";
           
            $data= $dbObj->where('1=1')->order('uid ASC')->limit($Lsql)->select();

            $dbObj=M('member_info');
            
            //获取分页的条数
          
            $backlist=array();
            $row=null;
            $lenght=count($data);
            for($i=0;$i<$lenght;$i++){
                
                $uid=$data[$i]['uid'];
                $row=$dbObj->field('real_name,cell_phone')->where("uid='{$uid}'")->find();
                $backlist[$i]['blackname']=$row['real_name'];
                $backlist[$i]['id']=$uid;
                 $backlist[$i]['telephone']=$row['cell_phone'];
                 
                $backlist[$i]['locmoney']=$data[$i]['money_usable'];
                $backlist[$i]['money_freeze']=$data[$i]['money_freeze'];
                $backlist[$i]['money']=$data[$i]['money_count'];

                $backlist[$i]['Webmoney_money']=$data[$i]['AvlBal'];
                $backlist[$i]['Webmoney_freeze']=$data[$i]['FrzBal'];
                $backlist[$i]['Acc']=$data[$i]['AccBal'];
             //   echo $data[$i]['is_unsual'],'<br/>';
                $backlist[$i]['flage']=(($data[$i]['is_unsual']=='1')?'red':'');
             //   if($data[$i]['flage'])
               
            }
            	$this->assign('page',$page);
              $this->assign('backlist',$backlist); 
              $this->display();
               return;
        }
         $phone=$_POST['searchtel'];
         $pre = C('DB_PREFIX');
          $members=M('members m');
          $data= $members->field("m.usrid as usrid,m.id as id,m.user_name as telephone,
          mm.money_freeze as money_freeze,mm.account_money as account_money,mm.back_money as back_money")
          ->where("m.user_name='{$phone}' AND usrid !=''")->join("{$pre}member_money mm ON mm.uid=m.id")->select();
  
       
          $members=M('member_info');
          
    
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
   
          $lenght=count($data);
          for($i=0;$i<$lenght;$i++){
              $id=$data[$i]['id'];
              $name=  $members->field('real_name')->where("uid={$id}")->find();
               $data[$i]['locmoney']=number_format($data[$i]['account_money']+$data[$i]['back_money'],2); 
               $data[$i]['money']=number_format($data[$i]['account_money']+$data[$i]['back_money']+$data[$i]['money_freeze'],2);
              $data[$i]['blackname']= '<b>'.$name['real_name'].'</b>';
           
              $data[$i]['money_freeze']=number_format($data[$i]['money_freeze'],2);
              
              
         	$res = $huifu->queryBalanceBg($data[$i]['usrid']);
            $data[$i]['Webmoney_freeze']=$res['FrzBal'];
            $data[$i]['Webmoney_money']=$res['AvlBal'];
            $data[$i]['Acc']= $res['AcctBal'];
            if($data[$i]['Acc']!=$data[$i]['money']){
                $data[$i]['flage']='red';
            }else{
                $data[$i]['flage']='';
            }
            
          }
          $this->assign('backlist',$data); 
          $this->display();
    }
    
    /*
      会员补绑界面 2015-07-02
      
    */
    public function memberrec()
    {
        if(empty($_POST)||empty($_POST[searchtel])){
            import("ORG.Util.Page");
           
            $member_info = M('members m');

            $total = $member_info->count();
            
            $p = new Page($total,6);
            
            $page = $p->show();
            
            $Lsql = "{$p->firstRow},{$p->listRows}";
              
            $pre = C('DB_PREFIX');

            $minfo = $member_info->join("{$pre}member_info sm on m.id=sm.uid")->join("{$pre}member_info am on m.recommend_id = am.uid")->where('1=1')->field("m.id,m.user_name,m.user_phone,m.recommend_id,sm.real_name as sreal_name,am.uid,am.cell_phone,am.real_name")->order('m.id ASC')->limit($Lsql)->select();

            $this->minfo=$minfo;

            $this->page=$page;

            $this->display();
            return;
          }

            $phone=$_POST['searchtel'];
            $pre = C('DB_PREFIX');

            $member_info = M('members m');

            $data = $member_info->join("{$pre}member_info sm on m.id=sm.uid")
                                   ->join("{$pre}member_info am on m.recommend_id = am.uid")
                                   ->where('m.user_phone='.$phone)
                                   ->field("m.id,m.user_name,m.user_phone,m.recommend_id,sm.real_name as sreal_name,am.uid,am.cell_phone,am.real_name")
                                   ->select();

     
            $this->minfo=$data;

            $this->display();
    }
      /*
      会员补绑处理界面 2015-07-02
      @parm id 接收到要修改的id
      m:modify a:add rec ：recommended
    */
      public function marec()
      {
                                
        //$model = D(ucfirst($this->getActionName()));
        //setBackUrl();
        //接收要修改或者添加的id
        $id= $_GET['id'];
        //判断查询是否有推荐人
         $member_info = M('members m');
        //表前缀
         $pre = C('DB_PREFIX');

         $minfo = $member_info->join("{$pre}member_info sm on m.id=sm.uid")->join("{$pre}member_info am on m.recommend_id = am.uid")
                              ->where('m.id='.$id)
                              ->field("m.id,m.user_name,m.user_phone,m.recommend_id,sm.real_name as sreal_name,am.uid,am.cell_phone,am.real_name")
                              ->find();

         $this->minfo=$minfo;
         
         $this->display();
      }

       /*
      会员补绑处理数据 2015-07-02
      @parm id 接收到要修改的id
      
    */
      public function marecsave()
      {
        //获取修改的id
        $modifyid = $_POST['modifyid'];

        $member_info = M('members m');

        $rec_id=$member_info->where("user_phone=".$_POST['rec_phone'])->getField("id");

        $data['recommend_id']=$rec_id;
        //表前缀
        $pre = C('DB_PREFIX');

        $res = $member_info->where("id=".$modifyid)->save($data);
         
         if($res===false)
         {
          $this->error("修改推荐人失败");
         }else{
          $this->success("修改推荐人成功");
         }
      }
}
?>