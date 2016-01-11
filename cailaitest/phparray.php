<?php
//数组操作函数 回顾

$arr=array(1,2,3,5,5);
$brr=array(6,7,8,9,10);
$test=array_change_key_case($arr);
//var_dump($test);

//把数组分开为N个数组每个数组两个元素
//$test1=array_chunk($arr,2);
//var_dump($test1);

//统计每一个值出现的次数

$count=array_count_values($arr);

var_dump($count);

echo "<br/>";

$diff=array_diff($arr,$brr);
print_r($diff);
echo "<br/>";

$diff_key=array_diff_key($arr,$brr);

var_dump($diff_key);
echo "<br/>";

for($i=0;$i<=5;$i++)
{
	$a=array_fill($i,3,$i);
}
print_r($a);

echo "<br/>";

//交换键名 键值

$flip=array_flip($arr);
var_dump($flip);
echo "<br/>";
var_dump($arr);

$crr=array('a'=>'horse','b'=>'Dog','c'=>'pig');
$drr=array('0'=>'0','1'=>'1','2'=>'2');
print_r(array_merge($crr,$drr));
echo "<br/>";

//返回 所有元素值的 乘积
var_dump($arr);

$product=array_product($arr);

print_r($product);

echo "<br/>";

//截取

$slice=array_slice($arr,-3,-2);

print_r($slice);

echo "<br/>";

$sum=array_sum($arr);
var_dump($sum);
echo "<br/>";

$animals=array_values($crr);
print_r($animals);

echo "<br/>";

$com=compact(10);
var_dump($com);
echo "<br/>";
$frr=array('bird','wyav','whale','shark');
// list($a,$b,$c)=$frr;
// echo "i hava too many animals a ". $a." and a ". $b;
// echo "<br/>";

$nat=natsort($frr);
var_dump($frr);


echo "<br/>";

echo idate(d);


echo strtotime(date('Y-m-d H:i:s'));