<?php

class act_bond extends action
{
 
	/*
    *标的信息
    *
    */
    public function _summaryAct(){
      $bid=  D('bid'); //1197
      $data['sname']='borrow.summary';
       $data['bid']=$bid;
       $recode=transferAPI($data);
        $recode=$recode['data'];
        $recode['format_money']=$recode['borrow_money']/10000;
        $recode['format_moneyAble']=number_format($recode['can_invest_money']);
        
        if(!empty($recode)){
            $this->view->assign('bid',$bid);
            if($recode['can_invest_money']>0&&$recode['ratio']!=100 ){
                 $butColor='m_lijiqianggou';
             $this->view->assign('href',"/consumer/buy?min=100&bid={$bid}");
             $this->view->assign('Msgtag','立即抢购');
            }else{
                 $butColor='m_lijiqianggouG';
                 $this->view->assign('href',"#");
                  $this->view->assign('Msgtag','抢购已经结束');
            }
            $this->view->assign('recode',$recode); 
                $this->view->assign('ButColor',$butColor);
        }else{
            exit('异常');
        }
    } 
    
    /*
    * 标列表
    */
    public function _listAct(){
        $data['sname']='borrow.list';
       
        $data['page_num']=0;
       $data['page_size']=10;
     
        $data=transferAPI($data);
       $datalist=array();
        if($data['code']==0){
            $temp=$data['data'];

           foreach($temp as $key=>$value){
               $datalist[$key]['bname']=$value['bname'];
                $datalist[$key]['borrow_type']=$value['borrow_type'];
                $datalist[$key]['interest_rate']= sprintf('%.2f',$value['interest_rate']);
                $datalist[$key]['borrow_duration']=$value['borrow_duration'];
                $datalist[$key]['bid']=$value['bid'];
                if($value["borrow_type"] == '按天到期还款' ){
                    $datalist[$key]['timetype']='天';
                }else{
                    $datalist[$key]['timetype']='月';
                }
                $m=$value['borrow_money']/10000;
               $datalist[$key]['borrow_money']=$m;
               $datalist[$key]['ratio']=$value['ratio'];
                $datalist[$key]['d']=autoHUtu($value['ratio']);
                $datalist[$key]['x']=autoX($value['ratio']);
               if($value['borrow_status']=='立即投标'){
                $datalist[$key]['status']='#F39800';
                $datalist[$key]['borrow_status']=$value['borrow_status'];
                 $butColor='m_lijiqianggou';
                $datalist[$key]['mBut']='m_toub'; 
               }else{
                 $datalist[$key]['borrow_status']=$value['borrow_status'].'&nbsp;&nbsp;';
                $datalist[$key]['status']='#AAA';
               }
            }
            $this->view->assign('page',($p['page_num']+1).'_'.$p['page_size']);
        
            $this->view->assign('bondlist',$datalist);
        }else{
           exit('异常'); 
        }
    }
    
    //ajax 加载 后面的链表内容
    public function _listLoadingAct(){
      exit();
       if(!PAGE_NUM||empty($_GET['Current_page'])){  exit('delEvent');}
       $data=array('sname'=>'borrow.list','page_size'=>PAGE_NUM,'page_num'=>$_GET['Current_page']);     
       $data= transferAPI($data);
       if(empty($data['data'])){ exit('delEvent'); }
       $temp=$data['data'];
       foreach($temp as $key=>$value){
               $datalist[$key]['bname']=$value['bname'];
                $datalist[$key]['borrow_type']=$value['borrow_type'];
                $datalist[$key]['interest_rate']=$value['interest_rate'];
                $datalist[$key]['borrow_duration']=$value['borrow_duration'];
                $datalist[$key]['bid']=$value['bid'];
                if($value["borrow_type"] == '按天到期还款' ){
                    $datalist[$key]['timetype']='天';
                }else{
                    $datalist[$key]['timetype']='月';
                }
                $m=toStrMoney($value['borrow_money']);
               $datalist[$key]['borrow_money']=$m['money'];
               $datalist[$key]['digit']=$m['digit'];
               $datalist[$key]['ratio']=$value['ratio'];
               if($value['borrow_status']=='立即投标'){
                $datalist[$key]['status']='ljtb';
               }
               if($value['borrow_status']=='复审中'){
                $datalist[$key]['status']='fsz';
               }
               if($value['borrow_status']=='还款中'){
                $datalist[$key]['status']='fxz';
               }
               if($value['borrow_status']=='已完成'){
                $datalist[$key]['status']='ywc';
               }
            }

            $this->view->assign('bondlist',$datalist); 
        
    }
    
    //标的介
    public function _detailAct(){
         $bid=D('bid');
        $data['sname']='borrow.detail';
       $data['bid']=$bid;
      $data=transferAPI($data);
      $data=AskForSuccess($data);

      $this->view->assign('data',$data);
    }
    
    //标的抵押物信息
    public function _detailpicAct(){
        $data['sname']='borrow.detailpic';
        $data['bid']=D('bid');
       $data=transferAPI($data);  
       $this->view->assign('imgUrl', imgUrl);  
      $this->view->assign('d', json_encode($data['data']));
    }
    
    
    //标的投标记录
    public function _investAct(){
        $bid=D('bid');
        $data['sname']='borrow.invest';
        $data['bid']=$bid;
       $data=AskForSuccess(transferAPI($data));
       $d=array();

        $J['sname']='borrow.summary';
        $J['bid']=$bid;
        $J=AskForSuccess(transferAPI($J));
        $this->view->assign('rate',$J['interest_rate']);

       foreach($data as $k=>$vl){
        foreach($vl as $key=>$v){
            if($key=="invest_time"){
                $d[$k][$key]= date('Y-m-d H:i:s',$v);
            }else{
                $d[$k][$key]= $v;
            }
        }   
       }
       //var_dump($d);
       $this->view->assign('d',$d);
    }
    
    //标的的借款人信息 
    public function _uinfoAct(){
        $bid=D('bid');
        $data['sname']='borrow.uinfo';
        $data['bid']=$bid;
       $data=  transferAPI($data);
          $data=AskForSuccess($data);
          $this->view->assign('d',$data);
        //var_dump();
    }
    //资产安全
    public function _safeAct(){
        
    }
    //合同
    public function _pactAct(){
        $bid=D('bid');
        $data['sname']='borrow.pact';
        $data['bid']=$bid;
        $data=transferAPI($data);
      $data['data']['first_verify_time']= date('Y年m月d',$data['data']['first_verify_time']);
        $this->view->assign('data',$data['data']);
    
    }
 
    public function runFirst() {
      ob_clean();
    }
}

?>