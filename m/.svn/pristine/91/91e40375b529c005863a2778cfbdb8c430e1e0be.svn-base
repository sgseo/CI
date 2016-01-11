<?php

function postArrayToString($req=array()){
	$tmp= array();
	foreach($req as $key => $value){
		array_push($tmp,  "$key=".urlencode($value));
	}
	return implode("&", $tmp);
}


function request($request_url,$postData=array()){//echo "<pre>";print_r ($postData);echo "</pre>";exit;
	$post_string= postArrayToString($postData);
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $request_url);
	curl_setopt($ch, CURLOPT_POST,strlen($post_string));
	curl_setopt($ch, CURLOPT_HEADER, 0);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $post_string);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//禁止直接显示获取的内容 重要
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); //不验证证书下同
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); //
	$result=curl_exec($ch);
	curl_close($ch);
	return $result;
}

//将表示金额的字符串转换成数字
//字符串格式：###,###.##
function str2val_money($str)
{
	return floatval(str_replace(',', '', $str));
}


// 获取客户端IP地址
function get_client_ip() {
	static $ip = NULL;
	if ($ip !== NULL) return $ip;
	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$arr = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
		$pos =  array_search('unknown',$arr);
		if(false !== $pos) unset($arr[$pos]);
		$ip   =  trim($arr[0]);
	}elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
		$ip = $_SERVER['HTTP_CLIENT_IP'];
	}elseif (isset($_SERVER['REMOTE_ADDR'])) {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	// IP地址合法验证
	$ip = (false !== ip2long($ip)) ? $ip : '0.0.0.0';
	return $ip;
}

//网站基本设置
function get_global_setting(){
	$list=array();	
        $db = core::Singleton('comm.db.activeRecord');
        $db->connect('CAILAI');
        $list_t = $db->get_all('',array(0, 200),'','lzh_global');      
        foreach($list_t as $key => $v){
                $list[$v['code']] = de_xie($v['text']);
        }
	return $list;
}

//在前台显示时去掉反斜线,传入数组，最多二维
function de_xie($arr){
	$data=array();
	if(is_array($arr)){
		foreach($arr as $key=>$v){
			if(is_array($v)){
				foreach($v as $skey=>$sv){
					if(is_array($sv)){
							
					}else{
						$v[$skey] = stripslashes($sv);
					}
				}
				$data[$key] = $v;
			}else{
				$data[$key] = stripslashes($v);
			}
		}
	}else{
		$data = stripslashes($arr);
	}
	return $data;
}
//调用 API 返回数组
function transferAPI($data,$time=5,$headers=array(),$return='body'){
    core::Singleton('comm.remote.remote'); 
            
    remote::$open_debug=openDebug;
    // 判断 登陆的 登陆后把 cookie 发送 出去 呀！
    $temp=is_login();
    $headers=(($temp==false)?$headers:$temp);
    $result = remote::send($data,$time,$headers,$return);
        
    return  json_decode($result, TRUE);
}

//请求 POST GET
function V($arg){
     $v=0;
     if( !empty($_POST[$arg]) ){
        $v=(  is_numeric($_POST[$arg])?$_POST[$arg]:0 );
     }
     return $v;
}
function D($arg){
         $v=0;
     if( !empty($_GET[$arg]) ){
        $v=(  is_numeric($_GET[$arg])?$_GET[$arg]:0 );
     }
     return $v;
}
 //判断登陆的   
 function is_login(){
         $version= $_COOKIE["version"];
        if(empty($version)){
            return false;
        }
        $header[] = 'Cookie:session_id='.$version;
        return $header;
 }
   

//输出cookie
function outCookie($sid,$key){
  header('Set-Cookie: '.$key.'='.$sid.'; expires='.gmstrftime('%A, %d-%b-%Y %H:%M:%S',time() + (86400)).'; path=/; domain=cailai.com');
}

/**分页**/
//
function page(){
    if(empty($_GET['page'])){
            $_GET['page']="1_5";
        }
        $p=array();
      $p['page_num']= strstr($_GET['page'],'_',true);
      $p['page_size']=trim(strstr($_GET['page'],'_'),'_');
      return $p;
}
//页面跳转
//url 可以是 /控制器/页面 的形式
function skip($url=null){
    if(empty($url)){
        $url =$_SERVER['HTTP_REFFERER'];
    }
    if(empty($url)||$url=='index'){
        $url=BASEURL;
    }
    if(is_numeric($url)){
        echo  "<script type='text/javascript'> window.history.go(".$url.");</script>";
        exit();
    }
    if(preg_match('/^\w+\\\w+/',$url)){
        $url=BASEURL.'\\'.$url;
    }
    header('Location:'.$url);
}
//验证返回的结果
//$msg!=null是弹出错误信息，不跳转，负责跳转到登陆页面
function AskForSuccess($data,$msg=null){
    if($data['code']==0){
        if(!empty($data['data'])){
              return $data['data'];
        }else{
            return true;
        }
    }else if($msg!=null){
        return 0;
    }else{
        skip('/user/login'); //跳转登陆
       //exit('异常');
    }
}
//跳转页面
function autoRedirect($reqData){
    //echo "<pre>";print_r($reqData);echo "</pre>";exit;
    $autoUrl=HFURL;
    
	$tmp = array();
	$html= <<<HTML
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<head><body onload="document.getElementById('autoRedirectForm').submit();">
<div class="margin:10px;font-size:14px;">正在跳转...</div>
<form id="autoRedirectForm" method="POST" action="{$autoUrl}">
HTML;
	foreach($reqData as $key => $value){
		$html.='<input type="hidden" value=\''.$value.'\' name="'.$key.'" />';
		$tmp[$key] = $value;
	}
	$html.="</form>";
	$html.="</body></html>";;
	print $html;
	exit;
}
 //圆球
function autoHUtu ($i){
     
       $c=$i;
         if($c==100){$c=99.99;}
         $c=360*($c/100);
         $hudu=(2*3.14/360)*$c;
       
         $x=32+sin($hudu)*30;
         $y=32-cos($hudu)*30;
         if($c<=180){               
            $d="M32,2 A30,30,0,0,1,{$x},{$y}";
         }else{                    
            $d="M32,2 A30,30,0,1,1,{$x},{$y}";
         }                                                    
          return $d;
 }

  //因为百分比逼一样，有些 x位置
function autoX ($i){
$i=strlen( strval($i) );
	$j=25;
	if($i-1<=0){
		return 25;
	}
	$j=$j-( ($i-1)*5);
return $j;
}
?>