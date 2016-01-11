<?php
/**
 * 借款投资者表
 */

class borrow_investor {

         //表名	
        private $table = 'lzh_borrow_investor';
        private $table2 = 'lzh_members';
       
         //5.10	投标记录
       public function getBorrowInvest($bid){
                $db = core::db()->getConnect('CAILAI',true);        
                $sql = sprintf("SELECT m.user_name,bi.investor_capital,bi.add_time LEFT JOIN %s AS m ON (m.id=bi.investor_uid) FROM %s AS bi WHERE bi.borrow_id = %s",
                $this->table1,$this->table,$bid);
                $zw = $db->query($sql,1);
                return $zw;
       }
    
	

}
?>