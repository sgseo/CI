<?php
/**
 * 前台用户类
 */

class dts_user {

	/**
	 * 用户表
	 * @var unknown_type
	 */
    public $tbl_user = 'lzh_members';
    public $tbl_login = 'tbl_user_login';

	/**
	 * 15天内未操作保持登陆状态
	 * @var unknown_type
	 */
	public $avail_time = '1296000';
    public $overtime   = 60;
    public $exp_date = 600;

//    //用户退出
//    public function loginout($real_session_id){
//        $db  = core::db()->getConnect('DTS');
//        $sql = sprintf("DELETE FROM %s WHERE login_session= '%s'",$this->tbl_login,$real_session_id);
//        return  $db->query($sql);
//    }
    //用户修改密码
    public function modifyUserPassword($userId,$passwd){
                $now   = @time();
		$db  = core::db()->getConnect('CAILAI');
		$sql = sprintf("UPDATE %s SET user_pass='%s' WHERE id = %s",$this->tbl_user,$passwd,$userId);              
		return $db->query($sql);
    }
    
    //分页获取借标数
    public function getBorrowList($offset,$pageSize){
            $db = core::db()->getConnect('CAILAI',true);        
           // $sql = sprintf("SELECT id ,borrow_name,borrow_duration,borrow_interest_rate,borrow_money,borrow_min,has_borrow,repayment_type,borrow_status FROM %s WHERE borrow_status IN (%s,%s,%s,%s) AND LENGTH(toubiao_telephone) <11 ORDER BY id DESC limit %s,%s ",
           //         'lzh_borrow_info',2,4,6,7,$offset,$pageSize);
   $sql = sprintf("SELECT id ,borrow_name,borrow_duration,borrow_interest_rate,borrow_money,borrow_min,has_borrow,repayment_type,borrow_status FROM %s WHERE borrow_status IN (%s,%s,%s,%s) AND LENGTH(toubiao_telephone) <11 ORDER BY borrow_money-has_borrow DESC ,id DESC limit %s,%s ",
                   'lzh_borrow_info',2,4,6,7,$offset,$pageSize);
      

            $zw = $db->query($sql);
            while($row = $db->fetchArray($zw)){
                $data[] = $row;
            }
            return $data;
    }
    
//分页获取借标数
    public function getBorrowListnew($offset,$pageSize,$where = ''){
    		if($where == ''){
    			$where = " 1=1 ";
    		} 	   	
            $db = core::db()->getConnect('CAILAI',true);        
   			$sql = sprintf("SELECT id ,borrow_name,full_time,add_time,deadline,borrow_uid,borrow_duration,borrow_interest_rate,borrow_money,borrow_min,has_borrow,repayment_type,borrow_status FROM %s WHERE 
%s AND borrow_status IN (%s,%s,%s,%s) AND LENGTH(toubiao_telephone) <11 ORDER BY borrow_money-has_borrow DESC ,id ASC limit %s,%s ",'lzh_borrow_info',$where,2,4,6,7,$offset,$pageSize);
   			$zw = $db->query($sql);
            while($row = $db->fetchArray($zw)){
                $data[] = $row;
            }
            return $data;
    }
    
    //获取借标总数
    public function getBorrowTotal(){
            $db = core::db()->getConnect('CAILAI',true);        
            $sql = sprintf("SELECT count(*) AS total FROM %s",'lzh_borrow_info');
            $zw = $db->query($sql,1);
            return $zw;
    }
    
 	//获取借标总数
    public function getBorrowTotalnew($data = ''){
    		if($data == ''){
    			$data = " 1=1 ";
    		} 	
            $db = core::db()->getConnect('CAILAI',true);        
            $sql = sprintf("SELECT count(*) AS total FROM %s where %s ",'lzh_borrow_info',$data);
            $zw = $db->query($sql,1);
            return $zw;
    }
        
    //添加用户首次注册信息
    public function addFirstMemberInfo($datam){
            $db = core::db()->getConnect('CAILAI');        
            $sql = sprintf("INSERT INTO %s SET uid = '%s',cell_phone = '%s'",
                    "lzh_member_info",$datam['uid'],$datam['cell_phone']);
            $result = $db->query($sql);
            return $result;
    }
    //添加注册用户
    public function addRegistUser($datar){             
            $mobile = $datar['user_name'];
            $passwd = $datar['user_pass'];
            $user_phone = $datar['user_phone'];
            $user_email = $datar['user_email'];
            $recommend_id = $datar['recommend_id'] ;
            $reg_time = $datar['reg_time'];
            $reg_ip = $datar['reg_ip'];
            $last_log_time = $datar['last_log_time'];
            $last_log_ip = $datar['last_log_ip'];
            $from_channel = $datar['from_channel'];
            $db = core::db()->getConnect('CAILAI');        
            $sql = sprintf("INSERT INTO %s SET user_name = '%s',user_pass = '%s',user_phone = '%s',user_email='%s',recommend_id='%s',reg_time='%s',reg_ip='%s',last_log_time='%s',last_log_ip='%s',from_channel='%s'",
                    "lzh_members",$mobile,$passwd,$user_phone,$user_email,$recommend_id,$reg_time,$reg_ip,$last_log_time,$last_log_ip,$from_channel);
            $result = $db->query($sql);
             return mysql_insert_id();

            
    }
    
    //获取推荐人ID
    public function fetchRegisterid($register){
            $db = core::db()->getConnect('CAILAI', true);
            $sql = sprintf("SELECT id FROM %s WHERE user_name='%s' LIMIT 1",'lzh_members',$register);
            $registerInfo = $db->query($sql,'array') ;
           return $registerInfo['id'];
    }
    
   //获取验证码 
     public function fetchCode($mobile){
            $db = core::db()->getConnect('DTS', true);
            $sql = sprintf("SELECT telcode FROM %s WHERE telephone='%s'ORDER BY id DESC LIMIT 1",'tbl_register_code',$mobile);
            $codeInfo = $db->query($sql,'array') ;
           return $codeInfo;
       }
 
    /**
	 * 获取短信验证码 操作表member_zc
	 * @param $string $user_name
	 * @param $string $user_pwd
	 *
	 * 返回值 user_id,user_name,session_id
	 * return boolean
	 */
       public function addCode($data){
           $db = core::db()->getConnect('DTS');
           $mobile = $data['telephone'];
           $cur_time =  $data['cur_time'];
           $telcode = $data['telcode'];
           $sql = sprintf("insert into %s set telephone='%s',cur_time='%s',telcode='%s'",'tbl_register_code',$mobile,$cur_time,$telcode);   
           $codeInfos = $db->query($sql);
           return $codeInfos;
       }
	/**
	 * 用户登陆
	 * @param $string $user_name
	 * @param $string $user_pwd
	 *
	 * 返回值 id,user_name,reg_time,real_name,session_id
	 * return boolean
	 */
	public function  login($user_name, $user_pwd) {

		$db = core::db()->getConnect('CAILAI', true);
		$user_name = addslashes($user_name);
		$user_pwd  = md5($user_pwd);
		$sql = sprintf("SELECT id,user_name,reg_time FROM %s WHERE user_name='%s' AND `user_pass`='%s'  LIMIT 1",$this->tbl_user,$user_name,$user_pwd);
		$user_info = $db->query($sql,'array') ;
		if($user_info['id']) {
			
			$session_id = $this->get_session($user_info['id'],$user_info['user_name']);
			$user_info['session_id'] = $session_id;
			$this->set_login($user_info['id'],$user_info['user_name'],$session_id);
			
			$sql = "select real_name from lzh_member_info where uid = ".$user_info['id'] ." limit 1" ;
			$user_info['real_name'] = $db->query($sql,1);
			
			return $user_info;//id, user_name,session_id
		} else {
			return false;
		}

	}

    /**
     * 判断手机号是否已经注册
     * @param $string $user_name
     * return  boolean
     */
    public function  is_exist_cell_phone_number($cell_phone_number) {

        $db = core::db()->getConnect('CAILAI', true);
        $cell_phone_number = addslashes($cell_phone_number);
        $sql = sprintf("SELECT COUNT(*) FROM %s WHERE user_name = '%s'  LIMIT 1",'lzh_members',$cell_phone_number);   
        //string '0' (length=1)
        return $db->query($sql,1) ? true : false ;
    }


	/**
	 * 设置服务端登录情况
	 * @param unknown_type $user_id
	 * @param unknown_type $user_name
	 * @param unknown_type $session_id
	 */
	public function set_login($user_id,$user_name,$session_id) {

		if(!$user_id or !$user_name) return ;
		$db  = core::db()->getConnect('DTS');
		$now = @time();

		$sql = sprintf("insert into %s set user_name='%s', user_id='%s', login_session='%s', update_datetime='%s'",$this->tbl_login,$user_name,$user_id,$session_id,$now);
		$db->query($sql);

	}

	
	/**
	 * 设置服务端登录情况
	 * @param unknown_type $user_id
	 * @param unknown_type $user_name
	 * @param unknown_type $session_id
	 */
	public function get_login_uid($session_id) {
		
		$db  = core::db()->getConnect('DTS', true);
		$now = @time();
		$sql = sprintf("select user_name,user_id,update_datetime from  %s where login_session='%s' limit 1",$this->tbl_login,$session_id);
		$data = $db->query($sql,'array');
		$update_datetime = $data['update_datetime'];
		
		$now = @time();
		
		if($update_datetime) {
			$diff        = $now - $this->avail_time;
			if( $diff < $update_datetime ) {
				
				//ldd add
				if($now - $update_datetime > 3600){
					$this->update_login($session_id);
				}
				$d['id'] = $data['user_id'];
				$d['mobile'] = $data['user_name'];
				return $d;
			}
		}
		return false;
	}

	/**
	 * 清除已经过期的
	 * 为了保留历史数据方便查询
	 */
	public function clear_login() {
		/*
		$now   = @time();
		$diff  = ($now - $this->avail_time);
		$db  = core::db()->getConnect('TUSER');
		$sql = sprintf("delete from %s where update_datetime < %s",$this->tbl_login,$diff);
		$db->query($sql);
		*/
	}
	
	/**
	 * 更新最后使用时间
	 * @param unknown_type $session_id
	 */
	public function update_login($session_id) {
	
		$now   = @time();
		$db  = core::db()->getConnect('DTS');
		$sql = sprintf("update %s set update_datetime='%s' where login_session = '%s' limit 1",$this->tbl_login,$now,$session_id);
		$db->query($sql);
	}


	/**
	 * 设置登录后的seesson
	 * @param unknown_type $user_id
	 * @param unknown_type $user_name
	 */
	public function get_session($user_id,$user_name) {
		$rand = rand(1,100000);
		$now  = time();
		$str  = $user_id.$user_name.$now.$rand;
		unset($rand,$now);
		return md5($str);
	}
	
	/**
	 * 根据用户名获取用户lzh_members表的信息
	 * 
	 * @param int $user_id
	 * @return array 
	 */
	public function get_user_info($user_id){
		
		$db = core::db()->getConnect('CAILAI', true);
		$cell_phone_number = addslashes($cell_phone_number);
		$sql = sprintf("SELECT * FROM `%s` WHERE id = '%s'  LIMIT 1",'lzh_members',$user_id);
		return $db->query($sql,'array');
	}
        
        //转让标,分页获取借标数 by zxm
        public function getBorrowDebtList($offset,$pageSize){
                $db = core::db()->getConnect('CAILAI',true);
                $sql=  sprintf("SELECT d.transfer_price, d.status, d.money, d.total_period, d.period, d.valid, d.id as debt_id, i.id as invest_id,i.investor_uid, i.deadline, b.id, b.borrow_name, b.borrow_interest_rate,b.borrow_status,b.borrow_type,b.borrow_duration,b.repayment_type, m.user_name FROM %s d JOIN  %s i ON d.invest_id=i.id JOIN %s b ON i.borrow_id = b.id JOIN %s m ON i.investor_uid=m.id WHERE d.status not in(3,99) order by debt_id DESC  limit %s,%s",'lzh_invest_detb','lzh_borrow_investor','lzh_borrow_info','lzh_members',$offset,$pageSize);    
                $zw = $db->query($sql);
                while($row = $db->fetchArray($zw)){
                    $data[] = $row;
                }
                return $data;
        }
	//转让标,获取借标总数 by zxm
        public function getBorrowDebtTotal(){
                $db = core::db()->getConnect('CAILAI',true);        
                $sql = sprintf("SELECT count(*) AS total FROM %s WHERE status NOT IN (3,99)",'lzh_invest_detb');
                $zw = $db->query($sql,1);
                return $zw;
        }
        //注册成功，添加红包 by zxm 2015-09-21
        // public function addMemberRedpacket($map){
        //     $db = core::db()->getConnect('CAILAI',true);
        //     $sql = sprintf("insert into %s set addtime='%s',rednum='%s',shelftime='%s',facevalue='%s',overtime='%s',owner='%s',is_success='%s',is_used='%s',note='%s'",'lzh_active_redpacket',$map['addtime'],$map['rednum'],$map['shelftime'],$map['facevalue'],$map['overtime'],$map['owner'],$map['is_success'],$map['is_used'],$map['note']);
        //     $result = $db->query($sql);
        //     return mysql_insert_id();
        // }
}
?>