﻿<?php
   // header("content-type:text/html;charset=utf-8");
    define('MODE_NAME','cli');//必须是cli，采用CLI运行模式运行
    define('THINK_PATH',dirname(__FILE__).'/CORE/');
    
    require(THINK_PATH.'Core.php');
     function FS($filename,$data="",$path=""){
    	$path = C("WEB_ROOT").$path;
        echo $path;
    	if($data==""){
    		$f = explode("/",$filename);
    		$num = count($f);
    		if($num>2){
    			$fx = $f;
    			array_pop($f);
    			$pathe = implode("/",$f);
    			$re = F($fx[$num-1],'',$pathe."/");
    		}else{
    			isset($f[1])?$re = F($f[1],'',C("WEB_ROOT").$f[0]."/"):$re = F($f[0]);
    		}
    		return $re;
    	}else{
    		if(!empty($path)) $re = F($filename,$data,$path);
    		else $re = F($filename,$data);
    	}
    }
    import("ORG.Huifu.Huifu");
     
    $huifu = new Huifu();
    
     $mysqllink=mysql_connect('115.29.245.207','test','cailai1234567890');
      mysql_select_db('cailainew',$mysqllink);
      $sql="SELECT m.usrid as usrid,m.id as id,m.user_name as telephone,mm.money_freeze as money_freeze,mm.account_money as account_money,mm.back_money as back_money
       FROM lzh_members m LEFT JOIN lzh_member_money mm ON mm.uid=m.id WHERE usrid !=''";
     $data=mysql_query($sql,$mysqllink);
    while($row[]=mysql_fetch_array($data)){}
    $data=$row;
   
    //整合数据一部分是数据库，一部分是web端应用
    $select="SELECT real_name FROM lzh_member_info WHERE ";
   // $where="1=2";
    $sql='';
    $Money_data=array();
     $lenght=count($data);
     for($i=0;$i<$lenght;$i++){
           $id=$data[$i]['id'];
           $Money_data[$i]['uid']=$id;
            $sql=$select."uid={$id}";
             $name=mysql_query($sql,$mysqllink); 
           $Money_data[$i]['locmoney']=$data[$i]['account_money']+$data[$i]['back_money']; 
           $Money_data[$i]['money']=$data[$i]['account_money']+$data[$i]['back_money']+$data[$i]['money_freeze'];
          $Money_data[$i]['blackname']= $name[$i]['blackname'];
           
           $Money_data[$i]['money_freeze']=$data[$i]['money_freeze'];
              
              
         	$res = $huifu->queryBalanceBg($data[$i]['usrid']);
            $Money_data[$i]['FrzBal']= $res['FrzBal'];
            
            $Money_data[$i]['FrzBal']=explode(',',$Money_data[$i]['FrzBal']);
            $Money_data[$i]['FrzBal']=implode('',$Money_data[$i]['FrzBal']);
         
            $Money_data[$i]['AvlBal']=$res['AvlBal'];
            $Money_data[$i]['AvlBal']=implode('',explode(',',$Money_data[$i]['AvlBal']));
           
            $Money_data[$i]['AcctBal']= $res['AcctBal'];
             $Money_data[$i]['AcctBal']=implode('',explode(',',$Money_data[$i]['AcctBal']));
            //var_dump($res['AcctBal'],$Money_data[$i]['AcctBal']);
           // echo $Money_data[$i]['AcctBal'].'|'.$Money_data[$i]['money'].'|'.'<br/>';
            if( floatval($Money_data[$i]['AcctBal'])==floatval($Money_data[$i]['money']) ){
                $Money_data[$i]['flage']='red';
            }else{
               $Money_data[$i]['flage']='';
            }    
        }
        
        //插入数据
        $sql='';
        $insert="insert into lzh_member_moneyfuto(`uid`,`is_unsual`,`AvlBal`,`FrzBal`,`AccBal`,`money_freeze`,`money_usable`,`money_count`) values";
        $updata="update  lzh_member_moneyfuto SET ";
        $select=" SElECT uid from lzh_member_moneyfuto WHERE uid=";
        
         $lenght=count($Money_data);
        for($i=0;$i<$lenght;$i++){
            $uid=$Money_data[$i]['uid'];
            
            $is_unsual=$Money_data[$i]['flage']=='red'?'1':'2';
            $AvlBal=$Money_data[$i]['AvlBal'];
            $AcctBal=$Money_data[$i]['AcctBal'];
            $FrzBal=$Money_data[$i]['FrzBal'];
    
            $money_count=$Money_data[$i]['money'];
            
            $money_freeze=$Money_data[$i]['money_freeze'];
            $money_usable=$Money_data[$i]['locmoney'];
            
            $sql=$select.$uid;
            
            
            if(mysql_query($sql,$mysqllink)){
                $sql=$updata."`uid`={$uid},`is_unsual`={$is_unsual},`AvlBal`='{$AvlBal}',`FrzBal`='{$FrzBal}',`AccBal`='{$AcctBal}',`money_freeze`='{$money_freeze}',`money_usable`='{$money_usable}',`money_count`='{$money_count}' WHERE `uid`='{$uid}'";
            }else{
                $sql=$insert."('{$uid}','{$is_unsual}','{$AvlBal}','{$FrzBal}','{$AcctBal}','{$money_freeze}','{$money_usable}','{$money_count}')";
            }
            mysql_query($sql,$mysqllink); 
        }
 mysql_close($mysqllink);
 ?>