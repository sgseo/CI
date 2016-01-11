<?php

/**
 * Class act_index
 */
class act_invset extends action
{
    //投标
    public function _comedAct(){

        $data['sname']='invest.money';
        $data['money']=V('m');
        $data['bid']=V('bid');
        $result=transferAPI($data);
      //  var_dump($result);exit();
        if($result['code']==0){
             autoRedirect($result['data']);
             return 0;
        }
      else  if($result['code']==500){
             $this->view->assign('skip','location.href="/user/info"'); 
             $this->view->assign('msg',$result['msg']); 
        }
       else if($result['code']==104){
             $this->view->assign('skip','location.href="/bond/list?page=1#"'); 
             $this->view->assign('msg',$result['msg']); 
        }
       else if($result['code']==105){
             $this->view->assign('skip','location.href="/bond/list?page=1#"'); 
             $this->view->assign('msg',$result['msg']); 
        }
       else if($result['code']==106){
             $this->view->assign('skip','location.href="/bond/list?page=1#"'); 
             $this->view->assign('msg',$result['msg']); 
        }
       else if($result['code']==108){
             $this->view->assign('skip','location.href="/bond/list?page=1#"'); 
             $this->view->assign('msg',$result['msg']); 
        }
       else if($result['code']==109){
             $this->view->assign('skip','location.href="/bond/list?page=1#"'); 
             $this->view->assign('msg',$result['msg']); 
        }
       else if($result['code']==110){
               $this->view->assign('skip','location.href="/bond/list?page=1#"');  
             $this->view->assign('msg',$result['msg']); 
        }
        else{
           $this->view->assign('skip','location.href="/bond/list?page=1#"'); 
          $this->view->assign('msg',$result['code'].'错误信息'.$result['msg']);
        }
		 $this->view->assign('BENNERTIME', BENNERTIME);
      }
    //投标进行中的标
    public function _comedingAct(){
        exit();  
        $data['sname']='tending.get';
        $result=transferAPI($data);

    }
    public function runFirst() {
      ob_clean();
    }
}
?>