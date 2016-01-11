<?php 
header("Content-type: text/html; charset=utf-8");
require_once(dirname(__FILE__).'/header.php');
core::Singleton('comm.remote.remote');
//phpinfo();
//gain phone number

$phone='0';
if(empty($_GET['phone'])){
    if(empty($_POST['phone'])){
       echo json_encode(array( 'code'=>26,'msg'=>"没有发生手机号",'stat'=>false));
        return;
    }else{
        $phone= $_POST['phone'];
    } 
}else{
    $phone=$_GET['phone'];
}

$lenght=strlen($phone);
if($lenght>12||$lenght<11){
   echo json_encode(array( 'code'=>27,'msg'=>'手机长度不符','stat'=>false));
    return;
}

//判断手机号单纯数字
if(!is_numeric($phone)){ 
     echo json_encode(array( 'code'=>28,'msg'=>'手机号无效','stat'=>false));
    return;
}
$data = array(
		'sname' => 'user.findpwd',
		'phone' => $phone,
);

  remote::$open_debug=1;
  $result=remote::send($data);
 echo $result;

  exit;
?>
