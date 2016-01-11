<?php
require_once(dirname(__FILE__).'/../../www/header.php');
$objDb = core::db()->getConnect('CAILAI');
//扫描三天后应该有还款的标 在还款计划表里面
$time=strtotime(date('Y-m-d 00:00:00'));//今天开始的时候
$threedayslater=strtotime("+3 days",$time);//三天后的这个时候
$daythree=date("Y-m-d",$threedayslater);
$sql="SELECT oe.id,oe.hid,UNIX_TIMESTAMP(oe.shouldtime) as shouldtime,oe.shouldrepay,h.tel,h.cstname FROM `onethink_repayplan` as oe left join `onethink_house` as h on oe.hid=h.id where UNIX_TIMESTAMP(oe.shouldtime)=".$threedayslater;

$res = $objDb->query($sql,'array');
// $get_money = $res['sum'];//累计帮助企业和个人融资
$tel=$res['tel'];//手机号码
echo $tel;
$cstname=$res['cstname'];//用户名
echo $cstname;
$content="尊敬的财来网借款人".$cstname."您在财来网的借款将在3天后".$daythree.'日有一笔还款,请及时还款.[财来网OA提醒]';
echo $content;
sendsms($tel,$content);
//请求方法
 
/**
     * 发送短信提醒
     */
   function sendsms($tel,$content)
    {
        $surl='https://dev.cailai.com/index.php/returl/sonsend';

        $data['secret_key']='bc7cfba8367fdc117d2ac8e85a5effe3';

        $data['pname'] = 'ios';
        // 'PNAME'=>'ios',
        // 'SON_URL'=>//子公司短信api请求地址
        $data['mobile']='18621765451';
        $data['content']= $content;

        //模拟post 请求
        $ch = curl_init() ;  
        $fields = $data;
        curl_setopt($ch, CURLOPT_URL,$surl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//控制返回结果不让自动输出
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//对ssl 证书错误 不验证
        curl_setopt($ch, CURLOPT_POST,count($fields)) ; // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  
        curl_setopt($ch, CURLOPT_POSTFIELDS,$fields); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名          

        $result = curl_exec($ch);//其值为 成功为1 不成功为 no auth
    
        if($result==1)
        {
            $json['status']='ok';
            exit(json_encode($json));
        }else{
            $json['status']='no';
            exit(json_encode($json));
        }

    }