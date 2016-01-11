<?php
/**
 * c用户登陆 
 */

class user_findpwd extends api_comm  {
    
	private $tbl_findpwd = 'tbl_findpwd_code';
	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
     private $numberTab='';
     //private $validTime=1800;
    //  private $validTime=1;
     public function get_response() {
		//传入的用户名和密码
		$uname = trim($this->request_arr['phone']);
 	             
        if(preg_match("/^1[34578]\d{9}$/", $uname)){
            $this->numberTab='lzh_members';
           
            $ok = $this->isRegisted($uname);
                   if($ok){
                    $smscode= rand(1000,9999);
                    
                   $sql=sprintf("select telephone,cur_time from `%s` where telephone='%s' limit 1;",$this->tbl_findpwd,$uname);
                  
                   $dbc=core::db()->getConnect('DTS');
                   $cut=$dbc->query($sql);
                   $p=$dbc->fetchArray($cut);//[0]['telephone'];
                    $oldtime=$p['cur_time']+$validTime;
                   $time=time();
                   if($p['telephone']==$uname){
                       $sql=sprintf("update `%s` set `telephone`='%s',`vcode`='%s',`cur_time`='%s' where `telephone`='%s'",$this->tbl_findpwd,$uname,$smscode,$time,$uname);
                    }else{
                    
                        $sql=sprintf('insert into `%s`(`telephone`,`vcode`,`cur_time`) values("%s","%s","%s")',$this->tbl_findpwd,$uname,$smscode,$time);
                    }
                 
                    $stat=$dbc->query($sql);
                    if($stat){
                       $res= sendsms($uname, '您的注册短信验证码为'.$smscode.'，30分钟内有效!');
                       exit( json_encode(array( 'code'=>66,'msg'=>"成功",'stat'=>true)));
                    }else{
                       exit(json_encode(array( 'code'=>67,'msg'=>"写入数据库失败",'stat'=>false)) );
                    }    
                     
                   }else{
                      exit( json_encode(array( 'code'=>25,'msg'=>"手机号没有注册",'stat'=>false)));
                   }
            }
        }
        
        // 手机号码是否注册
        //mobil 手机号码
        private function isRegisted($mobile){
            
            if(empty($mobile)){  return false;  }
            $sql=sprintf("select user_phone  from `%s` where user_phone='%s';",$this->numberTab,$mobile);
            $number=core::db()->getConnect('CAILAI');
            $cnt=$number->query($sql);
            return $cnt;
        }
        
   
}
?>
﻿