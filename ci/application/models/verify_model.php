<?php
class Verify_model extends CI_Model{

  function del_ver($word,$ip_address){
      // 首先删除旧的验证码
      $expiration=time()-100;//减去100s

      $this->db->where("captcha_time <".$expiration);

      $this->db->delete("captcha");

    // 然后再看是否有验证码存在
      $this->db->where(array("word"=>$word,"ip_address"=>$ip_address));

      $this->db->where("captcha_time >".$expiration);

      $result=$this->db->get("captcha");

    //echo $this->db->last_query();


      $total=$result->num_rows();

      return $total;//

  }





}