<?php
require_once(dirname(__FILE__).'/../../www/header.php');
//查询今天有没有还款 因为新手标 的发布ID 是固定的 所以先写死 123487
$objDb = core::db()->getConnect('CAILAI');
        //获取当天的日期
        $startday=strtotime(date('Y-m-d').'0:0:0');
        $endday=strtotime(date('Y-m-d').'23:59:59');
        //查询这一个月的投资总额
        $sql="select invest_uid from lzh_newbie_record where status=4 and repayment_time <= ".$endday." and repayment_time >=".$startday;
        echo $sql;
        //die;
        $res = $objDb->query($sql);
        while($row = mysql_fetch_assoc($res))
        {
            $rows[] = $row;
        }
   
        $url='https://dev.cailai.com/invest/newbie_repayment';
        foreach ($rows as $key => $value) 
        {
            echo $value['invest_uid'];
        var_dump(send_post($url,$value));
        }
        //die;
        // if(in_array($res,'false'))
        // {
        //     echo "数据更新成功";
        // }else{
        //     echo "数据更新失败";
        // }

        function send_post($url, $fields)
        {
           $ch = curl_init() ;  

            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//控制返回结果不让自动输出

            curl_setopt($ch, CURLOPT_URL,$url);
            
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//跳过证书验证

            curl_setopt($ch, CURLOPT_POST,count($fields)) ; // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  

            curl_setopt($ch, CURLOPT_POSTFIELDS,$fields); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名          

            $result = curl_exec($ch);

            $bdata=json_decode($result,1);  

            echo curl_error($ch);

            return $result;

        }
