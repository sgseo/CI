<?php

/**
 * Class act_index
 */
class act_consumer extends action{
	
    //用户实名认证
    public function _attestationAct(){
        $data['sname']='authentication.get';
        $data['mobile']=V('mobile');
        $result=transferAPI($data);
        $data=AskForSuccess($result); 
       if( isset($data['isVerified'])) { return 0;}
        if( count($data)>1){
            autoRedirect($data);
        }
    }
    
    //用户的资产 autotenderplan.view
    public function _personmoneyAct(){
        $data['sname']='member.capital';
        $result=transferAPI($data); 
          $data=AskForSuccess($result);

        $this->view->assign('data',$data); 
          
    }
    
    // 用户修改密码
    public function _changePwdAct(){
        if(empty($_POST)||empty($_POST['p'])){
            return 0;
        }
        $data['sname']='password.modify';
        $data['passwd']=V('passwd');
        $result=transferAPI($data);
        if($result['code']==0){
            skip('/user/login');
        }
          
    }
    
    //用户充值
    public function _rechargeAct(){
        if(empty($_POST)||empty($_POST['m'])){
            return 0;
        }
         $data['sname']='recharge.get';
        $data['amount']=V('m');
        $result=transferAPI($data);
        $result=AskForSuccess($result,true);
        autoRedirect($result);
    }
    //用户提现
    public function _withdrawalsAct(){
        if(empty($_POST)||empty($_POST['m'])){
            return 0;
        }
        $data['sname']='withdrawals.get';
        $data['amount']=V('m');
        $result=transferAPI($data);
        $result=AskForSuccess($result,true);
       autoRedirect($result);
    }
    //用户我的银行卡 
    public function _ubankAct(){
        $data['sname']='user.bank';
        $result=transferAPI($data);
       $data=AskForSuccess($result);
       if(!is_array($data)){ 
            $data=array();
           $tag='<div class="m_card"><a href="/consumer/bindcard">绑定银行卡</a></div>';
           $this->view->assign('msg',$tag); 
       }else{
       $this->view->assign('msg','<div class="m_card"><a href="/consumer/bindcard">你已经绑定银行卡</a></div>'); 
       $this->view->assign('d',$data);
       }
    }
    // 我的交易记录
    public function _dealhisoryAct(){
        $psize=V('page_size');
        $pnum=V('page_num');
        $pszie=(empty($psize)?5:$psize);
        $pnum=(empty($pnum)?0:$pnum);
        $data['sname']='deal.record';
        $data['page_size']=$psize;
        $data['page_num']=$pnum;
        $result = transferAPI($data);
       $data=AskForSuccess($result);
       $this->view->assign('d',$data);
    }
    //用户我的推荐
    public function _recommendAct(){
        $data['sname']='user.recommend';
        $result=transferAPI($data);
        $data=AskForSuccess($result);
        $this->view->assign('d',$data);
    }
    //用户我的借款
    public function _borrowpayingAct(){
        $data['sname']='borrowpaying.get';
        $result=transferAPI($data);
         $data=AskForSuccess($result);
          if(empty($data)||$data===true){
            $this->view->assign('display',1);
          }else{
             $this->view->assign('display',0);
          }
         
        $this->view->assign('d',$data);
    }
    //用户我的投资
    public function _tendbackingAct(){
        $data['sname']='tendbacking.get';
        $result=transferAPI($data);
       $result= AskForSuccess($result); 
       $this->view->assign('d',$result);  
    }
    //用户进行中的投标
    public function _tendingAct(){
        $data['sname']='tending.get';
        $result=transferAPI($data);
         $result= AskForSuccess($result); 
       $this->view->assign('d',$result);
    }
    
    //绑定银行卡
    public function _bindcardAct(){
        $data['sname']='bind.bank';
        $result=transferAPI($data);
        if($result['code']==111){
            skip('/consumer/ubank');
        }else{
            $result= AskForSuccess($result); 
             autoRedirect($result);
        }
        
    }
    //buy 投资
    public function _buyAct(){
        if(empty($_GET['bid'])||$_GET['min']!=100){
           skip('/bond/list');
        }else{
           
                $data['sname']='borrow.summary';
                $data['bid']=$_GET['bid'];
                $data=transferAPI($data);
               
                 $data=AskForSuccess($data);
                //通过投标比例是否可以在投标
                if($data['ratio']>=100){
                    $this->view->assign('mg','m_goumaibutg'); //控件class 为jquery 绑定事
                    $this->view->assign('qg','投标已经结束');
                }else{
                      $this->view->assign('mg','m_goumaibut cd-popup-trigger');
                       $this->view->assign('clickevnt','onclick="subt()"');
                    $this->view->assign('qg','立即投标');
                }
                $this->view->assign('bid',$_GET['bid']);
                $this->view->assign('Min',$data['borrow_min']);
                $this->view->assign('Max',$data['borrow_max']);       
                $this->view->assign('rate',$data['interest_rate']);
                $this->view->assign('Moonf',$data['borrow_duration']/12);
                unset($data);
                $data['sname']='member.capital';
                $data=transferAPI($data);
                $data=AskForSuccess($data);
                $this->view->assign('account_money',$data['account_money']);    
        }
    }
    
    public function runFirst() {
        ob_clean();
        if( is_login()==false ){ 
             skip('/user/login'); //跳转登陆
        }
    }
}
?>