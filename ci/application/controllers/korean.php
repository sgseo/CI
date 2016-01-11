<?php
class Korean extends CI_Controller{

  public function __construct(){

    parent::__construct();

  }

  public function china(){

  
    $config['protocal']="smtp";//邮件的协议
    $config['smtp_host']="smtp.exmail.qq.com";//smtp 的服务器
    $config['smtp_user']="124307954@qq.com";//你的smtp 的账号
    $config['smtp_pass']="taohua521";//你的smtp的密码
    $config['charset']="utf-8";
    $config['port']='25';
    $config['wordwrap']=true;//是否自动换行
    $config['mailtype']="html";//邮件的类型
    //$config['crlf']="\r\n"; 
   // $config['newline']="\r\n";
    $this->load->library("email");

    //$this->email->set_newline("\r\n");

    $this->email->initialize($config);//初始化 配置 方法

    $this->email->from("124307954@qq.com","i am suck");

   // $list=array("508440335@qq.com");

    $this->email->to("508440335@qq.com");

    $this->email->subject("ceshi 222");

    $this->email->message("32132121321");

//echo $this->email->print_debugger();
    if(!$this->email->send())
    {

      echo "ok";
  // show_error($this->email->print_debugger());
    }


   
  }



}