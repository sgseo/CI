<?php

/**
 * Class act_index
 */
class act_user extends action{
	//用户登陆
	public function _loginAct(){
        $phone=V('mobile');
    	$pas=$_POST['pwd'];
        if(empty($phone)||empty($pas)){ return 0;}
    $data=array('sname'=>'user.login','mobile'=>$phone,'passwd'=>$pas);
       
     core::Singleton('comm.remote.remote');
     
     $result = remote::send($data);
    
     setcookie("version", remote::$session_id, time()+3600*12,'/','cailai.com');
     $data=json_decode($result,TRUE);
     if($data['code']!=0){
            $this->view->assign('tipMsg',$data['msg']);
     }
     setcookie("uid",md5(uniqid()).$data['data']['mobile'], time()+3600*12,'/','cailai.com');
     if(empty(remote::$session_id)){
        $this->view->assign('n',$phone);
       return 0;
     }else{
       skip();
     }
      
  }
  //用户账户信息
  public function _infoAct(){
    $data['sname']='realname.get';
     $result=transferAPI($data);
     $result=AskForSuccess($result);
     $this->view->assign('d',$result);
     $this->view->assign('p',substr( $_COOKIE['uid'],32) );
  }
  
  public function _quitAct(){
    setcookie("version", "", time(0,0,0,1,1,99),'/','cailai.com');
     setcookie("uid", "", mktime(0,0,0,1,1,99),'/','cailai.com');
     $this->view->assign('Base',BASEURL);
     $this->view->assign('BENNERTIME',BENNERTIME);
  }
  
  
    public function _isregAct(){
      exit();
       $phone= V('mobile');
       $data['sname']='user.isreg';
       $data['mobile']=$phone;
       $result=transferAPI($data);
        
       // var_dump($result);
     }
    
    public function runFirst() {
        ob_clean();
    }
}

?>