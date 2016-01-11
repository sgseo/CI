<?php
/**
 * 用户资产类
 */

class member_moneylog {

	/**
	 * 表
	 * @var unknown_type
	 */
    public $tbl = 'lzh_member_moneylog';

    
    
    
    
	/**
	 * 资产信息
	 * @param id $user_id 
	 * return Array
	 */
	public function getDealTotal($userId) {		
		$db = core::db()->getConnect('CAILAI', true);
		$sql = sprintf("SELECT count(*) FROM %s WHERE uid='%s'  and `type`!=23 ",$this->tbl,$userId);
		$num = $db->query($sql,1) ;                
		return $num;
	}
       //分页获得交易记录
        public function getDealRecord($userId,$offset,$pageSize){
            $db = core::db()->getConnect('CAILAI',true);        
            $sql = sprintf("SELECT type,affect_money,collect_money,info,add_time,account_money,back_money FROM %s WHERE uid='%s'  and `type`!=23 ORDER BY id DESC limit %s,%s ",
                    $this->tbl,$userId,$offset,$pageSize);
            $zw = $db->query($sql);       
            while($row = $db->fetchArray($zw)){
                $data['type'] = moneyType($row['type']);
                $data['affect_money'] = (float)$row['affect_money'];
                $data['collect_money'] = (float)$row['collect_money'];
                $data['desc'] = $row['info'];
                $data['account_money'] = (float)($row['account_money']+$row['back_money']);
                $data['date'] = date('Y-m-d H:i:s',$row['add_time']);
                $result[] = $data;
            }
            if(empty($result)){
                return  $result = (array)array();
            }
            return $result;
        }
}
?>