<?php
class verify extends CI_Controller{

function __construct()  
    {  
       parent::__construct();  
       //载入验证码模型  
      $this->load->model("Verify_model");  
     // header("content-type:text/html;charset=utf-8");
    }  

public function test(){
  
  $this->load->helper("captcha");//载入验证码类

  $word="254646";

  $cap=array("word"=>$word,"img_path"=>'./captcha/','img_url'=>'http://localhost/ci/captcha/','expiration'=>'100');

  $capt=create_captcha($cap);
/*
  echo time();
  echo "*";
  echo $capt['time'];
*/
  $ip_address=$this->input->ip_address();

  $data=array('captcha_time'=>$capt['time'],'ip_address'=>$ip_address,'word'=>$capt['word']);

  $query = $this->Verify_model->verify($data);//调用model下的方法把生成的 验证码 存入数据库

  //echo $this->db->last_query();

  echo $capt['image'];

  $this->load->view("verify/verify.html");

}

public function ver(){

$word=$this->input->post("verify");

$ip_address=$this->input->ip_address();

$count=$this->Verify_model->del_ver($word,$ip_address);

if($count==0)
{
  echo "must enter captcha";
}else{
  echo "ok";
}

 }

 public function date(){
    
    $this->load->helper("date");


 }
}