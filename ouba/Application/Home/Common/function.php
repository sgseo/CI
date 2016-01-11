  <?php
  /**
     * 数字转化为汉字
     *
     */
 function num2ch($num) //整体读取转换  
 {  
  // $num_real = del0($num);//去掉前面的“0”  
  $num_real=$num;
  $numlen = strlen($num_real);  //获取长度
   
  if($numlen >= 9)//如果满九位，读取“亿”位  
  {  
   $y=substr($num_real, -9, 1);  
   //echo $y;  
   //123456789
   $wsbq = substr($num_real, -8, 4);  
   $gsbq = substr($num_real, -4);  
   $a = num_r(del0($gsbq));  
   $b = num_r(del0($wsbq))."万";  
   $c = num_r(del0($y))."亿";  
  }  
  elseif($numlen <= 8 && $numlen >= 5) //如果大于等于“万”  
  {  
   $wsbq = substr($num_real, 0, $numlen-4);  
   $gsbq = substr($num_real, -4);  
   $a = num_r(del0($gsbq));  
   $b = num_r(del0($wsbq))."万";  
   $c="";  
  }  
  elseif($numlen <= 4) //如果小于等于“千”  
  {  
   $gsbq = substr( $num_real, -$numlen);  
   $a = num_r(del0($gsbq));  
   $b="";  
   $c="";  
  }  
  $ch_num = $c.$b.$a;  
   
  return $ch_num ;  
 }  
   
  function del0($num) //去掉数字段前面的0  
 {  
  return "".intval($num);  
 }  
   
  function n2c($x) //单个数字变汉字  
 {  
  $arr_n = array("零","壹","贰","叁","肆","伍","陆","柒","捌","玖","拾");  
  return $arr_n[$x];  
 }  
   
   
  function num_r($abcd) //读取数值（4位）  
 {  
  $arr= array();  
  $str = ""; //读取后的汉字数值  
  $flag = 0; //该位是否为零  
  $flag_end = 1; //是否以“零”结尾  
  $size_r = strlen($abcd);  
  for($i=0; $i<$size_r; $i++)  
  {  
   $arr[$i] = $abcd{$i};  //有点out 为什么不用函数呢 split
  }  
  $arrlen = count($arr);  
  for($j=0; $j<$arrlen; $j++)  
  {  
   $ch = n2c($arr[$arrlen-1-$j]); //从后向前转汉字  
     
   if($ch == "零" && $flag == 0)  
   { //如果是第一个零  
    $flag = 1; //该位为零  
    $str = $ch.$str; //加入汉字数值字符串  
    continue;  
   }  
   elseif($ch == "零")  
   { //如果不是第一个零了  
    continue;  
   }  
   $flag = 0; //该位不是零  
   switch($j)  
   {  
    case 0: $str = $ch; $flag_end = 0; break; //第一位（末尾），没有以“零”结尾  
    case 1: $str = $ch."拾".$str; break; //第二位  
    case 2: $str = $ch."佰".$str; break; //第三位  
    case 3: $str = $ch."仟".$str; break; //第四位  
   }  
  }  
  if($flag_end == 1) //如果以“零”结尾  
  {  
   mb_internal_encoding("UTF-8");  
   $str = mb_substr($str, 0, mb_strlen($str)-1); //把“零”去掉  
  }  
  return $str;  
 }  

?>