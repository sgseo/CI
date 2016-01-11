<?php 

class Email extends CI_Controller{
  
public function __construct(){
 parent::__construct();
 header("content-type:text/html;charset=utf-8");
}
 
function sendmailto()
{
  $config['protocol'] = 'smtp';//采用smtp方式      
  $config['smtp_host'] = 'smtp.163.com';//简便起见，只支持163邮箱             
  $config['smtp_user'] = "a898798@163.com";//你的邮箱帐号             
  $config['smtp_pass'] = "124307954";//你的邮箱密码             
  $config['charset'] = 'utf-8';             
  $config['wordwrap'] = TRUE;              
  $config['mailtype'] = "html";              
  $this->load->library('email');//加载email类            
   $this->email->initialize($config);//参数配置              
   $this->email->from('a898798@163.com', '我是发件人'); 
   $list=array("124307954@qq.com","867700123@qq.com");
   $this->email->to($list);      
   $this->email->subject("ci的mail测试发送");              
   $this->email->message("测试测试发送，群组发送");    
   //显示发送邮件的结果，加载到res_view.php视图文件中             
   if(!$this->email->send())
   {                 
    echo "123";
    
   }else{
    echo "success"  ;
        }

}

}//eof class email