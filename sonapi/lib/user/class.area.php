<?php
/**
 * 所在区域信息
 * time:20150714
 * by lj
 */
class area{
	  
	  //表名	
      private $table_lmi = 'lzh_member_info';//个人信息表
      private $table_m = 'lzh_members';
 
      public function getArea($idno)
      {
         $db = core::db()->getConnect('CAILAI', true);

         $sql = sprintf("SELECT lmi.uid,lmi.cell_phone,lmi.idcard,lmi.real_name,lmi.age,lmi.address,m.reg_time From %s as lmi  left join %s as m on lmi.uid=m.id where lmi.idcard like '%s%s%s' order by m.reg_time desc",$this->table_lmi,$this->table_m,'%',$idno,'%');

          $zw=$db->query($sql);
          
          $data = array();
    
         while($row = $db->fetchArray($zw)){
              $data['uid'] = $row['uid'];
              $data['cell_phone'] = $row['cell_phone'];
              $data['idcard'] = $row['idcard'];
              $data['real_name'] = $row['real_name'];
              $data['age'] = $row['age'];
              $data['address']=$row['address'];
              $data['reg_time']=$row['reg_time'];
              $result[] = $data;
          }
          if(empty($result)){
              return  $result = (array)array();
          }
          return $result;
        }







}