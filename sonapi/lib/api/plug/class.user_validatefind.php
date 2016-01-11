<?php
class user_validatefind extends api_comm  {
    private $tbl_findpwd = 'tbl_findpwd_code';
    private $numberTab='lzh_members';
    public function get_response() {
        $code = trim($this->request_arr['code']);
        $pwd=trim($this->request_arr['pwd']);
        $phone=$this->validateCode($code);
        if($phone==false){
             exit( json_encode(array( 'code'=>16,'msg'=>"大哥你手晚了一步，验证码已经过了30分钟，或者验证码无效...",'stat'=>true)));
        }else{
            
            $this->changePwd($phone,$pwd);
            
            exit( json_encode(array( 'code'=>15,'msg'=>"修改成功",'stat'=>true)));
        }
    }
    
    //验证码有效期类
   //成功放回手机号，失败放回 false
    public function validateCode($code){
        $sql=sprintf("select telephone,cur_time from `%s` where vcode='%s' limit 1;",$this->tbl_findpwd,$code);
                  
        $dbc=core::db()->getConnect('DTS');
        $cut=$dbc->query($sql);
        $p=$dbc->fetchArray($cut);//[0]['telephone'];
        // exit(var_dump($p) );
        //判断验证码是否有效
         if(empty($p['cur_time'])){
             exit( json_encode(array( 'code'=>14,'msg'=>"验证码无效",'stat'=>true)));
             return false;
        }
        
        $oldtime=$p['cur_time'];
        $time=time()-1800;
        $this->bug=$oldtime.'|'.$time;
        if($oldtime<=$time){
            return false;
        }else{
            return $p['telephone'];
        }
    }
    //修改密码
    //mobile 号码
    //pwd 新密码
    private function changePwd($mobile,$pwd){
            
            if(empty($mobile)){  return false;  }
            $sql=sprintf("update `%s` set user_pass='%s' where user_phone='%s';",$this->numberTab,$pwd,$mobile);
            $number=core::db()->getConnect('CAILAI');
            $cnt=$number->query($sql);
    }
}