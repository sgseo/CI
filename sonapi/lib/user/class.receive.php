<?php

/**
 * 收款计划
 * time:20150709
 * by lj
 */
class receive {

    //表名	
    private $table_lid = 'lzh_investor_detail'; //我的投资详细表
    private $table_lmi = 'lzh_member_info';
    private $table_lbi = 'lzh_borrow_info';

    private $table_red = 'lzh_active_redpacket';

    /**
     * 获取我的投标记录
     * @param month 要查询的月份
     */
    public function getMyInvest($userId, $year, $month) {
        $db = core::db()->getConnect('CAILAI', true);

        //$year=$year?$year:date('Y');


        $firstday = date($year . '-' . $month . '-01 00:00:00');

        $firstsec = strtotime(date($year . '-' . $month . '-01 00:00:00')); //零点零分零秒

        $lastsec = strtotime(date('Y-m-d  23:59:59', strtotime($firstday . "+1 month -1 day"))); //要查询的月末
        //借款编号  借款者id 应收本金 应收利息  利息管理费 标的状态 还款时间 逾期罚金 借款者真实姓名
        $sql = sprintf("SELECT lid.borrow_id,lid.borrow_uid,lid.capital,lid.interest,
        					lid.interest_fee,lid.status,lid.deadline,lid.expired_money,lmi.real_name 
                  FROM %s as lid left join %s as lmi on lid.borrow_uid = lmi.uid WHERE lid.investor_uid=%s and lid.repayment_time = '0'
        					and lid.deadline>$firstsec and lid.deadline<$lastsec", $this->table_lid, $this->table_lmi, $userId);

        $zw = $db->query($sql);
        $data = array();
        while ($row = $db->fetchArray($zw)) {

            $data['borrow_id'] = $row['borrow_id'];
            $_sql = sprintf("SELECT borrow_name FROM %s WHERE  id=%s", $this->table_lbi, $data['borrow_id']);
            $res = $db->query($_sql, 1);
            $data['borrow_name'] = $res;
            $data['borrow_uid'] = $row['borrow_uid'];
            $data['capital'] = $row['capital'];
            $data['interest'] = (float) ($row['interest']);
            $data['interest_fee'] = (float) ($row['interest_fee']);
            $data['status'] = "已完成"; //$row['status'];
            $data['deadline'] = $row['deadline'];
            $data['expired_money'] = $row['expired_money'];
            $data['real_name'] = $row['real_name'];
            $result[] = $data;
        }
        if (empty($result)) {
            return $result = (array) array();
        }
        return $result;
    }
    
    //by zxm 2015-08-31
    public function getMyAllInvest($userId, $year, $month) {
        $db = core::db()->getConnect('CAILAI', true);
        $firstday = date($year . '-' . $month . '-01 00:00:00');
        $firstsec = strtotime(date($year . '-' . $month . '-01 00:00:00')); //零点零分零秒
        $lastsec = strtotime(date('Y-m-d  23:59:59', strtotime($firstday . "+1 month -1 day"))); //要查询的月末
        //借款编号  借款者id 应收本金 应收利息  利息管理费 标的状态 还款时间 逾期罚金 借款者真实姓名
        $sql = sprintf("SELECT lid.borrow_id,lid.borrow_uid,lid.capital,lid.interest,
        					lid.interest_fee,lid.status,lid.repayment_time,lid.deadline,lid.expired_money,lmi.real_name 
                  FROM %s as lid left join %s as lmi on lid.borrow_uid = lmi.uid WHERE lid.investor_uid=%s and 
        					 lid.deadline>$firstsec and lid.deadline<$lastsec  order by lid.deadline ASC", $this->table_lid, $this->table_lmi, $userId);

        $zw = $db->query($sql);
        $data = array();
        while ($row = $db->fetchArray($zw)) {

            $data['borrow_id'] = $row['borrow_id'];
            $_sql = sprintf("SELECT borrow_name FROM %s WHERE  id=%s", $this->table_lbi, $data['borrow_id']);
            $res = $db->query($_sql, 1);
            $data['borrow_name'] = $res;
            $data['borrow_uid'] = $row['borrow_uid'];
            $data['capital'] = $row['capital'];
            $data['interest'] = (float) ($row['interest']);
            $data['interest_fee'] = (float) ($row['interest_fee']);
            if ($row['status'] == 2) {
                $data['status'] = "已偿还";
            } else {
                $data['status'] = "未偿还";
            }
            $data['repayment_time'] = $row['repayment_time'];//实际还款时间
            $data['deadline'] = $row['deadline'];//最终还款时间
            $data['expired_money'] = $row['expired_money'];
            $data['real_name'] = $row['real_name'];
            $result[] = $data;
        }
        if (empty($result)) {
            return $result = (array) array();
        }
        return $result;
    }


      public function reds($userId){

        $db = core::db()->getConnect('CAILAI', true);

        $sql=sprintf("SELECT * from %s where owner=%s",$this->table_red,$userId);

        $lj=$db->query($sql);

        $data = array();

        while ($row=$db->fetchArray($lj)) {
            $result[]=$row;
        }

        if(empty($result)){
              return  $result = (array)array();
          }
          return $result;
      

      }




}
//eof class
