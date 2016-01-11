<?php
    header("Content-type: text/html; charset=utf-8");
    require_once(dirname(__FILE__).'/header.php');
    core::Singleton('comm.remote.remote');

    if(empty($_POST)|| empty($_POST['code'])|| empty($_POST['pwd'])){
         echo json_encode(array( 'code'=>86,'msg'=>"填写信息不全,或者密码不可为空",'stat'=>false));
         return false;
    }
    $code=$_POST['code'];
    if(!is_numeric($code))
        {
             echo json_encode(array( 'code'=>87,'msg'=>"验证码时数字",'stat'=>false));
            return false;
        }
    $pwd=$_POST['pwd'];
     $lenght=strlen($pwd);
    if($lenght<6){
        echo json_encode(array( 'code'=>88,'msg'=>"验证码时数字",'stat'=>false));
        return false;
    }
    $pwd=md5($pwd);   
    $data = array(
		'sname' => 'user.validatefind',
		'code' => $code,
        'pwd'=>$pwd
    );
    remote::$open_debug=1;
      $result=remote::send($data);
    var_dump( $result);

?>