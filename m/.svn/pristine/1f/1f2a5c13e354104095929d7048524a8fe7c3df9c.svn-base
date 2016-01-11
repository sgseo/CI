<?php

/**
 * Class act_index
 */
class act_index extends action
{
    /**
     *
     */
    public function runFirst() {
    	 ob_clean();
    }
    /**
     *  精选标
     */
    public function _homeAct(){
    	core::Singleton('comm.remote.remote'); 
        $data['sname']='topborrow.get';
        $data=transferAPI($data);        
        if($data['code']==0){
            if($data['ratio']){
                core::Singleton('comm.remote.remote'); 
                $data['sname']='topborrow.get';
                 $data=transferAPI($data);
            }
            $this->view->assign('bondname',$data["data"]["bname"]);
            $this->view->assign('rate',sprintf('%.1f',$data["data"]["interest_rate"]));
            $this->view->assign('deadline',$data['data']["borrow_duration"]);
            $this->view->assign('ratio',$data['data']["ratio"]);
           
            $this->view->assign('min', str2val_money($data['data']["borrow_min"]) );
            $monery= $data['data']["borrow_money"]/10000;
            $this->view->assign('money','<i>'.$monery.'</i>'); 
            $this->view->assign('bid',$data['data']['id']);
        }
         $data['sname']='banner.get';  
         $data['latest_time']=time();
         $data=transferAPI($data);   
         $a=$img='';
          if($data['code']==0){
            foreach($data['data'] as $k=>$d){
                 $img=$img.','.'"'.$d['pic_url'].'"';
                 $a=$a.','.'"'.$d['link'].'"';
            }
            $this->view->assign('img',trim($img,',') );
            $this->view->assign('a',trim($a,',') );
            $this->view->assign('BENNERTIME',BENNERTIME);
          }
	}
	/**
    *  注册
    */
    public function _registerAct(){
        if(empty($_POST)||empty($_POST['mobile'])||empty($_POST['pwd']) ){
            return 0;
        }
        $phone= V('mobile');
        $pwd=$_POST['pwd'];
        $rec=V('recommended');
        $telcode=V('telcode');
        
        $data=array(
            'sname'=>'user.reg',
            'mobile'=>$phone,
            'passwd'=>$pwd,
            'recommended'=>$rec,
            'telcode'=>$telcode
        );
       $data= transferAPI($data);
      if($data['code']!=0){
         $this->view->assign('n',$phone);
        $this->view->assign('msg',$data['msg']);
      }else{
        skip('/user/login');
      }
        
    }
    //Banner 广告
    public function _bannerAct(){
        exit();
        $data['sname']='banner.get';
        $data['latest_time']=time();
       
    }
    //更多
    public function _moreAct(){
      $is_login=is_login();
      
       if(!empty($is_login)||$is_login!=false){
          $user='<li><a href="/user/info"><img src="/statics/images/u1.jpg" alt=""> 我的账户</a></li>';
          //$quit='<li><a onclick="quit()" href="/user/quit?id='.mt_rand(99,99999).'"><img src="/statics/images/u6.jpg" alt="" /> 退出</a></li>';
          $quit='<li><a onclick="quit()"><img src="/statics/images/u6.jpg" alt="" /> 退出</a></li>';
       }else{
        $user='<li><a href="/user/login"><img src="/statics/images/u1.jpg" alt=""> 我的账户</a></li>';
          $quit='';
       }
       $this->view->assign('li_user',$user); 
       $this->view->assign('li_quit',$quit); 
       $this->view->assign('IOSDown',IOSDown);
       $this->view->assign('androidDown',androidDown);
    }
    //了解财来
    public function _knowAct(){
        
    }
	public function _testAct(){

		$word = 'hello';
		$data[] = array('id'=>1,'name'=>'my test');
		$data[] = array('id'=>2,'name'=>'my test2');
		$this->view->assign("word",$word);
		$this->view->assign("d",$data);
	}
    //验证码获取
    public function _vcodeAct(){
        $data['sname']='vcode.get';
        $data['mobile']=V('mobile');
        $data= transferAPI($data);
        if($data['msg']=='调用成功'){
            $str=sprintf("var code='%s';var msg='%s';var data='%s';",$data['code'],'发送成功如果没有收到请检查，手机号码',$data['data']);
              //echo  $str;
        }else{
              $str=sprintf("var code='%s';var msg='%s';var data='%s';",$data['code'],$data['msg'],$data['data']);
              //echo  $str;
        }
     
       exit( trim($str) );  
    }
  //找回密码
    public function _findpwdAct(){

    }
}
?>