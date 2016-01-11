<?php
/**
 * 我的银行卡
 */

class member_banks {

	/**
	 * 表
	 * @var unknown_type
	 */
    private $tbl = 'lzh_member_banks';

   
    //3.14	获得银行卡
    public function getUserBank($userId){
        $db = core::db()->getConnect('CAILAI', true);
        $sql = sprintf("SELECT m.bank_name,m.bank_num FROM %s AS m where m.uid='%s' ",$this->tbl,$userId);
        $zw = $db->query($sql,'array');     
        return $zw;
//                
    }
    
	

}
?>