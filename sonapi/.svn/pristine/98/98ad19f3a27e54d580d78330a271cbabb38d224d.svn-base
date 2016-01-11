<?php
/**
 * 借款详情表
 */
 
class borrow_info {

         //表名	
        private $table = 'lzh_borrow_info';
        private $tableid = 'lzh_investor_detail';
        private $tablemi = 'lzh_member_info';
        private $tablebi = 'lzh_borrow_investor';
        private $tablem = 'lzh_members';
        
      //获得用户真实姓名
      public function getRealName($userId){
            $db = core::db()->getConnect('CAILAI', true);
            $sql = sprintf("SELECT real_name FROM %s WHERE uid = '%s' ",$this->tablemi,$userId);
			 file_put_contents('/tmp/debug',date('m-d H:i:s')." ".print_r($sql,true)."\n",FILE_APPEND);
            $zw = $db->query($sql,'array');
            return $zw;
      }  
     //获得投标进行中的标
       public function getTending($userId){
            $db = core::db()->getConnect('CAILAI', true);
            $field = 'bo.id,bo.borrow_money,bo.borrow_name,bo.borrow_interest_rate,bo.borrow_duration,b.investor_capital,b.investor_interest,b.add_time,m.real_name';
            $sql = sprintf("SELECT {$field} FROM %s AS b LEFT JOIN %s AS bo ON b.borrow_id=bo.id LEFT JOIN %s AS m ON b.borrow_uid= m.uid WHERE b.investor_uid = '%s' AND b.status =1 GROUP BY b.id ORDER BY b.add_time DESC",$this->tablebi,$this->table,$this->tablemi,$userId);
            $zw = $db->query($sql);
            while($row = $db->fetchArray($zw)){
                $zrow['id'] = (int)$row['id'];
                $zrow['real_name'] = $row['real_name'];
                $zrow['borrow_name'] = $row['borrow_name'];
                $zrow['borrow_money'] = (float)$row['borrow_money'];
                $zrow['borrow_interest_rate'] = (float)$row['borrow_interest_rate'];
                $zrow['borrow_duration'] = (int)$row['borrow_duration'];
                $zrow['investor_capital'] = (float)$row['investor_capital'];               
                $zrow['benxi'] = (float)($row['investor_capital'] + $row['investor_interest']);
                $zrow['add_time'] = date('Y-m-d',$row['add_time']);
                $data[] = $zrow;
            }
            return $data;
       }  
          //判断用户是否是首次投标
        public function isFirstInvest($userId){
                $db = core::db()->getConnect('CAILAI', true);
                $sql = sprintf("SELECT investor_capital FROM %s WHERE investor_uid = '%s' ",$this->tablebi,$userId);
                $zw = $db->query($sql,1);
                return $zw;
        }
        
         //获得借款者商户id
        public function getBorrowUsrid($bid){
                $db = core::db()->getConnect('CAILAI', true);
                $sql = sprintf("SELECT usrid FROM %s AS b LEFT JOIN %s AS m ON (m.id=b.borrow_uid) WHERE b.id = '%s' ",$this->table,$this->tablem,$bid);
                $zw = $db->query($sql,'array');
                return $zw;
        }
        
 		//获得当日交易总金额
        public function getBorrowamountsum($date_start,$date_end,$where){
        		if($where == ''){
    				$where = " 1=1 ";
    			} 	 
                $db = core::db()->getConnect('CAILAI', true);
                $sql = sprintf("SELECT sum(borrow_money) as borrow_sum FROM %s WHERE %s AND add_time>%s and add_time<%s",$this->table,$where,$date_start,$date_end);
                $zw = $db->query($sql,'array');
                return $zw;
        }
        
        //获得用户id
        public function getInvestUsrid($userId){
                $db = core::db()->getConnect('CAILAI', true);
                $sql = sprintf("SELECT usrid FROM %s WHERE id = '%s' ",$this->tablem,$userId); 
                $zw = $db->query($sql,1);
                return $zw;
        }
           //获得标的详情
        public function getBorrowInfo($bid){
                $db = core::db()->getConnect('CAILAI', true);
                $sql = sprintf("SELECT borrow_uid,borrow_status,borrow_money,borrow_max,has_borrow,borrow_type,borrow_min,borrow_max,is_new,money_collect FROM %s WHERE id = '%s' ",$this->table,$bid); 
                $zw = $db->query($sql,'array');
                return $zw;
        }
        
        //获得投标记录
        public function getBorrowInvest($bid){
             $db = core::db()->getConnect('CAILAI', true);
             $sql = sprintf("SELECT b.investor_capital AS invest_money,b.add_time AS invest_time,b.is_auto AS invest_type,m.user_name AS invest_name,b.invest_channel FROM %s AS b LEFT JOIN %s AS m ON b.investor_uid = m.id WHERE b.borrow_id = '%s' ORDER BY b.id desc  ",
                     $this->tablebi,$this->tablem,$bid);
             $zw = $db->query($sql);
             while($row = $db->fetchArray($zw)){
                $row['invest_name'] = hidecard($row['invest_name'],5);
                $row['invest_money'] = (float)$row['invest_money'];
                $data[] = $row;
             }
             return $data;
        }

		//获得投标记录
        public function getBorrowInvestnew($bid,$where){
             $db = core::db()->getConnect('CAILAI', true);
             $sql = sprintf("SELECT b.id,b.investor_uid as investorid,b.investor_capital AS invest_money,b.add_time AS invest_time,b.is_auto AS invest_type,m.user_name AS invest_name,b.invest_channel FROM %s AS b LEFT JOIN %s AS m ON b.investor_uid = m.id WHERE b.borrow_id = '%s' AND %s ORDER BY b.id desc  ",
                     $this->tablebi,$this->tablem,$bid,$where);
             $zw = $db->query($sql);
             while($row = $db->fetchArray($zw)){
                $row['invest_name'] = hidecard($row['invest_name'],5);
                $row['invest_money'] = (float)$row['invest_money'];
                $data[] = $row;
             }
             return $data;
        }
        
        //3.16	用户我的投资（回收中的投资）
        public function getTendBacking($userId){
             $db = core::db()->getConnect('CAILAI', true);
             $sql = sprintf("SELECT bi.id AS invest_id, b.id AS bid,b.borrow_name AS bname,m.real_name AS borrow_uname,
              bi.investor_capital AS invest_money,b.borrow_interest_rate,b.total AS total_periods,
              b.has_pay AS payed_periods,d.deadline FROM %s AS bi LEFT JOIN %s AS b ON b.id = bi.borrow_id LEFT JOIN %s 
              AS m ON m.uid = bi.borrow_uid LEFT JOIN %s AS d ON d.borrow_id = b.id WHERE (b.borrow_type <> 9) 
               AND bi.investor_uid = '%s'  AND d.status = 7 
              AND b.borrow_status=6 GROUP BY bi.id ORDER BY d.deadline ASC  ",
                     $this->tablebi,$this->table,$this->tablemi,$this->tableid,$userId);
             $zw = $db->query($sql);
             $data = array();
             while($row = $db->fetchArray($zw)){
                $row['bid'] = (int)$row['bid'];
                $row['invest_money'] = (float)$row['invest_money'];
                $row['total_periods'] = (int)$row['total_periods'];
                $row['borrow_interest_rate'] = (float)$row['borrow_interest_rate'];
                $row['payed_periods'] = (int)$row['payed_periods'];                
                $row['next_pay_date'] = date('Y-m-d',$row['deadline']);
//              $row['repayment_money'] = (float)($row['receive_capital'] + $row['receive_interest']);
                $row['repayment_money'] = (float)$this->getRepayment($row['invest_id']);
                unset($row['deadline']);
//                unset($row['receive_capital']);
//                unset($row['receive_interest']);
                $data[] = $row;
             }
             return (array)$data;
        }
    
        //    7.14 用户我的投资 所有的投资
        public function getAllbid($userId){
             $db = core::db()->getConnect('CAILAI', true);
             $sql = sprintf("SELECT bi.id AS invest_id, b.id AS bid,b.borrow_name AS bname,m.real_name AS borrow_uname,
              bi.investor_capital AS invest_money,bi.add_time AS atime,b.borrow_interest_rate,b.total AS total_periods,
              b.has_pay AS payed_periods,d.deadline FROM %s AS bi LEFT JOIN %s AS b ON b.id = bi.borrow_id LEFT JOIN %s 
              AS m ON m.uid = bi.borrow_uid LEFT JOIN %s AS d ON d.borrow_id = b.id WHERE (b.borrow_type <> 9) 
               AND bi.investor_uid = '%s' GROUP BY bi.id ORDER BY d.deadline ASC  ",
                     $this->tablebi,$this->table,$this->tablemi,$this->tableid,$userId);
             $zw = $db->query($sql);
             $data = array();
             while($row = $db->fetchArray($zw)){
                $row['bid'] = (int)$row['bid'];
                $row['invest_money'] = (float)$row['invest_money'];
                $row['total_periods'] = (int)$row['total_periods'];
                $row['borrow_interest_rate'] = (float)$row['borrow_interest_rate'];
                $row['payed_periods'] = (int)$row['payed_periods'];                
                $row['next_pay_date'] = date('Y-m-d',$row['deadline']);
                $row['atime'] = $row['atime'];//投资时间
                $row['repayment_money'] = (float)$this->getRepayment($row['invest_id']);
                unset($row['deadline']);
                $data[] = $row;
             }
             return (array)$data;
        }


         //    7.15-7.16 我推荐的用户 今天有谁投资了
        public function getTodayInvest($userId){
             $db = core::db()->getConnect('CAILAI', true);
       
             $today_start = mktime(0,0,0,date('m'),date('d'),date('Y'));
    
             $today_end = $today_start+86400;
            
             $sql = sprintf("SELECT lbi.borrow_id as borrow_id,lbi.investor_uid ,lbi.borrow_uid ,lif.borrow_name,lif.borrow_money,lif.borrow_interest_rate,lbi.investor_capital,lbi.add_time,mi.real_name,mii.real_name as borrow_real_name,mi.cell_phone
                    from %s as lbi left join %s as lif on lbi.borrow_id = lif.id left join %s as m on lbi.investor_uid=m.id left join %s as mi on lbi.investor_uid=mi.uid left join %s as mii on lbi.borrow_uid=mii.uid where m.recommend_id=%s  and lbi.add_time > %s and lbi.add_time < %s",
                     $this->tablebi,$this->table,$this->tablem,$this->tablemi,$this->tablemi,$userId,$today_start,$today_end);

             $zw = $db->query($sql);
             $data = array();
             while($row = $db->fetchArray($zw)){
                $row['bid'] = (int)$row['borrow_id'];
                $row['invest_uid'] = $row['invest_uid'];
                $row['borrow_name'] = (int)$row['borrow_name'];
                $row['borrow_interest_rate'] = (float)$row['borrow_interest_rate'];
                $row['borrow_money'] = (float)$row['borrow_money'];                
                $row['investor_capital'] = $row['investor_capital'];
                $row['add_time'] = $row['add_time'];//投资时间
                $row['ireal_name'] = $row['real_name'];//投资人的名称
                $row['borrow_real_name'] = $row['borrow_real_name'];//借款人的名称
                $row['cell_phone']=$row['cell_phone'];
                $data[] = $row;
             }
             return (array)$data;
        }

        public function getRepayment($investId){
             $db = core::db()->getConnect('CAILAI', true);
             //SELECT SUM(capital+interest) FROM `lzh_investor_detail` WHERE invest_id =10366
             $sql = sprintf("SELECT SUM(capital+interest) FROM `lzh_investor_detail` WHERE invest_id =%s AND repayment_time!=0",$investId);
             $zw = $db->query($sql,1);
             return $zw;
        }
        
         //3.15	用户我的借款（还款中的借款）
        public function getBorrowPaying($userId){
            $db = core::db()->getConnect('CAILAI', true);
            $sql = sprintf("SELECT bi.id AS bid, bi.borrow_name AS bname, bi.repayment_type, bi.borrow_money , bi.repayment_money, bi.borrow_interest_rate, bi.total AS total_periods, bi.has_pay AS payed_periods, d.deadline FROM  %s AS bi LEFT JOIN %s AS d ON d.borrow_id = bi.id WHERE (bi.borrow_uid = '%s') AND (bi.borrow_status = '%s') GROUP BY bi.id ORDER BY d.deadline DESC ",$this->table,$this->tableid,$userId,6);
            $zw = $db->query($sql);
            $data = array();
            while($row = $db->fetchArray($zw)){
                $row['bid'] = (int)$row['bid'];
                $row['total_periods'] = (int)$row['total_periods'];
                $row['payed_periods'] = (int)$row['payed_periods'];
                $row['borrow_money'] = (float)$row['borrow_money'];
                $row['repayment_money'] = (float)$row['repayment_money'];
                $row['borrow_interest_rate'] = (float)$row['borrow_interest_rate'];
                $row['next_pay_date'] = date('Y-m-d',$row['deadline']);
                unset($row['deadline']);
                $row['repayment_type'] = repaymentType($row['repayment_type']);
                $data[] = $row;               
            }         
             return $data = (array)$data;
           
        } 
       
	/**
	 * 获得产品介绍
	 * @param id 
	 * return Array
	 */
	public function getSingleBorrow($bid) {
                $db = core::db()->getConnect('CAILAI',true);        
                $sql = sprintf("SELECT borrow_status,borrow_name,borrow_duration,borrow_interest_rate,borrow_mortgage_rate,borrow_money,repayment_type,has_borrow,add_time,borrow_min,borrow_max,is_new,collect_time FROM %s WHERE length(toubiao_telephone)<11 AND id = %s limit 1",
                        $this->table,$bid);
                $zw = $db->query($sql,'array');
                return $zw;
	}
        

		//5.4	精选产品
        public function getLastBorrow(){
                $db = core::db()->getConnect('CAILAI',true);        
                //$sql = sprintf("SELECT id ,borrow_name,borrow_duration,borrow_interest_rate,borrow_money,borrow_min,has_borrow FROM %s WHERE borrow_status IN (%s,%s,%s,%s) AND toubiao_telephone='' ORDER BY id DESC limit 1",'lzh_borrow_info',2,4,6,7);
				$sql = sprintf("SELECT id ,borrow_name,borrow_duration,borrow_interest_rate,borrow_money,borrow_min,has_borrow FROM %s WHERE borrow_status IN (%s,%s,%s,%s) AND ( toubiao_telephone='' or toubiao_telephone='0' )  ORDER BY borrow_money-has_borrow DESC ,id DESC limit 1",'lzh_borrow_info',2,4,6,7);
                
                $zw = $db->query($sql,'array');
                return $zw;
        }

        
       //5.7	产品详情（html5）
       public function getBorrowDescription($bid) {    
                $db = core::db()->getConnect('CAILAI',true);        
                $sql = sprintf("SELECT borrow_info FROM %s WHERE length(toubiao_telephone)<11 AND id = %s limit 1",
                        $this->table,$bid);
                $zw = $db->query($sql,1);
                return $zw;
       }   
       //5.8	借款人信息//m.id,m.customer_name,m.customer_id,m.user_name,m.reg_time,m.credits,fi.*,mi.*,mm.*
       public function getBorrowerInfo($bid){ 
                $db = core::db()->getConnect('CAILAI',true);  
                $filed = "bi.borrow_uid,mi.sex,mi.age,mi.education,mi.marry,fi.fin_monthin,m.user_email,m.customer_name,fi.fin_car,m.integral,mi.zy,mm.credit_limit,mi.province,mi.city,mm.account_money,mm.back_money,mm.money_collect,mm.money_freeze ";
                $sql = sprintf("SELECT $filed FROM`lzh_borrow_info` bi  LEFT JOIN lzh_members m ON m.id = bi.borrow_uid LEFT JOIN lzh_member_financial_info fi ON bi.borrow_uid=fi.uid  LEFT JOIN `lzh_member_info` mi ON mi.uid=bi.borrow_uid  LEFT JOIN `lzh_member_money` mm ON mm.uid=bi.borrow_uid WHERE bi.id=%s",$bid);
                $zw = $db->query($sql,"array ");  
                $borrow_uid = $zw['borrow_uid'];
                unset($zw['borrow_uid']);
                $zw['fin_monthin'] = getMoneyFormt($zw['fin_monthin']);
                $zw['integral'] = (int)$zw['integral'];
                $zw['credit_limit'] = (float)$zw['credit_limit'];
                if($zw['fin_car'] == NULL){
                    $zw['fin_car'] = '未填写';
                }
                //借款次数相关
                $sql2 = sprintf("SELECT `borrow_status`, COUNT(id) AS num,SUM(borrow_money) AS money,SUM(repayment_money) AS repayment_money FROM `lzh_borrow_info` WHERE borrow_uid = %s GROUP BY borrow_status ",$borrow_uid);
                $zw2 = $db->query($sql2);   
                while($row = $db->fetchArray($zw2)){               
                    $borrowCount[$row['borrow_status']] = $row;               
                } 
                
                //借出情况相关
                $field3 = "status,count(id) as num,sum(investor_capital) as investor_capital,sum(reward_money) as reward_money,sum(investor_interest) as investor_interest,sum(receive_capital) as receive_capital,sum(receive_interest) as receive_interest,sum(invest_fee) as invest_fee";                             
                $sql3 = sprintf("SELECT {$field3} FROM `lzh_borrow_investor` WHERE investor_uid = %s GROUP BY STATUS  ",$borrow_uid);
                $zw3 = $db->query($sql3); 
                $_reward_money = 0;
                while($v = $db->fetchArray($zw3)){               
                    $investStatus[$v['status']]=$v;
		    $_reward_money+=floatval($v['reward_money']);              
                } 
                          
                
                $rowtj['jkze'] = getFloatValue(floatval($borrowCount[6]['money']+$borrowCount[7]['money']+$borrowCount[8]['money']+$borrowCount[9]['money']),2);//借款总额
                $rowtj['jcze'] = getFloatValue(floatval($investStatus[4]['investor_capital']),2);//借出总额
                $rowtj['ysze'] = getFloatValue(floatval($investStatus[4]['receive_capital']),2);//应收总额
                $rowtj['yhze'] = getFloatValue(floatval($borrowCount[6]['repayment_money']+$borrowCount[7]['repayment_money']+$borrowCount[8]['repayment_money']+$borrowCount[9]['repayment_money']),2);//应还总额
                
                
                $data2['yhze'] = getMoneyFormt(getFloatValue(floatval($borrowCount[6]['repayment_money']+$borrowCount[7]['repayment_money']+$borrowCount[8]['repayment_money']+$borrowCount[9]['repayment_money']),2));//应还总额
                $data2['dhze'] = getMoneyFormt(getFloatValue($rowtj['jkze']-$rowtj['yhze'],2));//待还总额
                $data2['jcze'] = getMoneyFormt(getFloatValue(floatval($investStatus[4]['investor_capital']),2));//借出总额
                $data2['ysze'] = getMoneyFormt(getFloatValue(floatval($investStatus[4]['receive_capital']),2));//应收总额
                $data2['dsze'] = getMoneyFormt(getFloatValue($rowtj['jcze']-$rowtj['ysze'],2));//待收总额
                $data2['fz'] = getMoneyFormt(getFloatValue($rowtj['jcze']-$rowtj['jkze'],2));
                $data2['jkcgcs'] = (int)($borrowCount[6]['num']+$borrowCount[7]['num']+$borrowCount[8]['num']+$borrowCount[9]['num']);//借款成功次数
                $data2['zcze'] = getMoneyFormt(getFloatValue(floatval($zw['account_money']+$zw['back_money']+$zw['money_collect']+$zw['money_freeze']),2));//资产总额
                
                //还款情况相关
                $field4="status,sort_order,borrow_id,sum(capital) as capital,sum(interest) as interest";
                $sql4 = sprintf("SELECT {$field4} FROM `lzh_investor_detail` WHERE borrow_uid = %s GROUP BY sort_order, borrow_id ",$borrow_uid);
                $zw4 = $db->query($sql4); 
                while($v = $db->fetchArray($zw4)){               
//                    $repaymentStatus[$v['status']]['capital']+=$v['capital'];//当前状态下的数金额
//                    $repaymentStatus[$v['status']]['interest']+=$v['interest'];//当前状态下的数金额
                    $repaymentStatus[$v['status']]['num']++;//当前状态下的总笔数            
                } 
                $data2['repayment1'] = (int)$repaymentStatus[1]['num'];//正常还款次数：
                $data2['repayment3'] = (int)$repaymentStatus[3]['num'];//迟还次数：
                $data2['repayment2'] = (int)$repaymentStatus[2]['num'];//提前还款次数：：
                $data2['repayment6'] = (int)$repaymentStatus[6]['num'];//待还款笔数：
                $data2['repayment4'] = (int)$repaymentStatus[4]['num'];//网站代还次数：：：
                $data2['repayment5'] = (int)$repaymentStatus[5]['num'];//逾期还款笔数：：  
                $areaList = getArea();
                $data2['location'] = $areaList[$zw['province']].$areaList[$zw['city']];
                unset($zw['province'],$zw['city']);
                $zz = array_merge($zw,$data2);      
                return $zz;
    
       }
       //5.9	抵押物信息
       public function getborrowDetailpic($bid){
                $db = core::db()->getConnect('CAILAI',true);        
                $sql = sprintf("SELECT updata FROM %s WHERE id = %s limit 1",
                        $this->table,$bid);
                $zw = $db->query($sql,1);
                return $zw;
       }
      //6.0 借款合同表
      public function  getPact($bid){
        $db = core::db()->getConnect('CAILAI',true);
        $sql= sprintf('SELECT `id`,`borrow_use`,`borrow_duration`,`borrow_money`,`first_verify_time`,`borrow_interest_rate`,`second_verify_time`,`repayment_type`,`manage_rate`,`borrow_uid`,`borrow_fee` FROM %s where `id`=%s limit 1',$this->table,$bid);
         $ht = $db->query($sql);
         $row = $db->fetchArray($ht);
        $sqli= sprintf('SELECT `borrow_uid`,`investor_uid` ,`investor_capital`,`receive_capital` FROM %s WHERE `borrow_id`=%s',$this->tablebi,$bid);
         $ht=$db->query($sqli);
      $i=0;
       while($v = $db->fetchArray($ht)){ 
          $row['investor'][$i]['capital']=($v['investor_capital']+$v['receive_capital']);
          $sqlp=sprintf('SELECT `cell_phone` FROM %s WHERE `uid`=%s limit 1',$this->tablemi,$v["investor_uid"]);
          $up=$db->query($sqlp,1);
          $row['investor'][$i]['phone']=$up;
          ++$i;
       }
       
        $row['aged1_30']='0.05';
        $row['agedm1_30']='0.3';
       
        $row['aged30']='0.1';
        $row['agedm30']='0.5';
       
       $sqlp=sprintf('SELECT `cell_phone` FROM %s WHERE `uid`=%s limit 1',$this->tablemi,$row["borrow_uid"]);
       $row['PacePhone']=$db->query($sqlp,1);
         return $row;
      }

}
?>