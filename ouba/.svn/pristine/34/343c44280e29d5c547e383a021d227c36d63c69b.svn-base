<?php
/**
 * z注：此类只供测试一些方法或者函数使用 
 */
namespace Home\Controller;
use Think\Controller;
 header("content-type:text/html;charset=utf8");

class TestController extends Controller{

	public function index()
	{
		
		$ceo = array('apple','jobs','microsoft','Nadella','Larry Page','Eric');

		//$this->list=$ceo;

		echo (100%101);

		$this->show();

	}

    public function printer()
    {
        $this->display();
    }

    public function idnomodify()
    {
        $res=M('house')->field("id,SUBSTRING(idno,7,4) as idno")->select();
        foreach ($res as $key => $value) {
           $data['age']=2015-$value['idno'];
           dump($data);
          M('house')->where('id='.$value['id'])->save($data);
        }
    }

    public function likemax()
    { 
     //  $a=4;$b=7;$c=5;
     //  $d=$a>$b?$a:$b;
     //  echo "<br/>".$d;

     //  $f=$d>$c?$d:$c;
      echo gethostbyname('www.cailai.com');
     // echo  "<br/>".$f;
      $array=array("马","羊","猴","鸡","狗",'猪',"鼠","牛","虎","兔","龙","蛇"); 
      $animal=floor((2018-1990)%12);
      echo "今年应该是:".$array[$animal]."年";
      $this->display();
    }
    //mysql 上下两条数据交换
    public function changeud()
    { 
       $list=M('re')->field('id,totalsort,cursort,hid,shouldtime,shouldrepay,donetime,cursort,operator,repaytype')->where('cursort=totalsort')->select();
       $list2=M('re')->field('id,totalsort,cursort,hid,shouldtime,shouldrepay,donetime,cursort,operator,repaytype')->where('cursort=totalsort-1')->select();
       foreach ($list as $key => $value) 
       {
          $data['cursort']=$value['cursort'];
          $data['shouldtime']=$value['shouldtime'];
          $data['shouldrepay']=$value['shouldrepay'];
          $data['realrepay']=$value['realrepay'];
          $data['donetime']=$value['donetime'];
          $data['cursort']=$value['cursort'];
          $data['operator']=$value['operator'];
          $data['repaytype']=$value['repaytype'];
          M('re')->where('id='.$list2[$key]['id'])->save($data);
          echo M()->_sql()."</br>";
          echo 111;
        }
    }
  $timedelta(hours=8);
  timestrptime()
  

}