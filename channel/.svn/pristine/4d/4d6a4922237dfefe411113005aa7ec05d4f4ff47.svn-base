<?php
namespace Home\Controller;
use Think\Controller;
 header("content-type:text/html;charset=utf8");
 class MenuController extends Controller
 {

 	public $partner_name;
	public $secret_key;
	public $url;
	public $month;

   public function _initialize()
   {
	 $this->partner_name=C(PNAME);
	 $this->secret_key=C(SECRET_KEY);
	 $this->url = C(API_URL);
   }
	/*
 	获取子公司所在区域的人的信息
 	time:20150707
 	by lj
 	*/
 	public function index()
 	{
 		$userId=session('myid');

 		$son = M("detail");

 		$son_location = $son->Field("son_location,son_phone")->where('user_id='.$userId)->find();

 		//获取表中的 电话 和身份证 前六位

 		$secret_key = $this->secret_key;

  		$data['pname'] =$this->partner_name; 

		$data['sname'] = 'areainfo.get';//待完成

		//$data['phone'] = '18621765451';//$son_location['son_phone'];

		$data['idno'] = $son_location['son_location'];

		//$data['search_month'] =$search_month?$search_month:date('m');



		$content = json_encode($data);

		$string = $content.$secret_key;

		$token = md5($string);

		$post['content'] = $content;
		
		$post['token'] = $token;

		//curl post 请求

		$url = $this->url ;  

		$fields = $post ;

		$ch = curl_init() ;  

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//控制返回结果不让自动输出

		curl_setopt($ch, CURLOPT_URL,$url);

		curl_setopt($ch, CURLOPT_POST,count($fields)) ; // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  

		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名  		

		$result = curl_exec($ch);

	
		$result = json_decode($result,1);


		if(!empty($_GET['real_name']))
		{
			$mobile=$_GET['real_name'];

			foreach ($result['data'] as $key => $value) 
			{
				if($value['real_name']==$mobile)
				{
					$k=$value;
				}
			}
			$res[]=$k;
			$this->result=$res;
			$this->spc=1;
			$this->cls=0;
		//	$this->single_bonus=$k['bonus'];//个人总贡献
			$this->show();
			return;
		}

		// 把数组存储到cookie 因为3.1开始支持 存储数组 首先要序列化

		cookie("menu",serialize($result));

		//把身份证中间八位隐藏掉
		foreach ($result['data'] as $key => $value)
		{
			$result['data'][$key]['idcard']=substr_replace($value['idcard'],'****',6,8);
			$result['data'][$key]['cell_phone']=substr_replace($value['cell_phone'],'****',3,4);
		}


		//模拟分页
		$count =count($result['data']);//总共有多少条函数

		$single_page_count = 10;//每页显示ds条

		$total=ceil($count/$single_page_count);//总页数

		$p=I('get.p')?I('get.p'):1;//当前的页码
	
		$cur_list_start = ($p-1)*$single_page_count;//当前页开始的那一条是第几条记录
		
		$this->p=$p;//页码

		$this->total=$total;//总页数

		$this->spc=$single_page_count;//每页显示多少条

		$this->cls=$cur_list_start;//每页的开始点

		$this->result=$result['data'];

 		$this->show();
 	}

 	/*
 	导出 区域 excel
 	time:20150707
 	by lj
 	*/
 	public function cl_to_excel()
 	{
 		import("Vendor.PhpExcel.PHPExcel");

 		$objPHPExcel = new \PhpExcel();

 		//反序列化数组

 		$list=unserialize(cookie('menu'));

 		$list=array_splice($list,2);

		$row=array();

		$row[0]=array('用户id','姓名','年龄','身份证号','手机号','地址','注册时间');

	
		$objPHPExcel->setActiveSheetIndex(0);

		//头部
			foreach ($row[0] as $key => $value) 
			{
				$cwr=chr(65+$key).'1';
				$objPHPExcel->getActiveSheet()->SetCellValue($cwr, $value);
			}

			foreach ($list['data'] as $key => $value) {
					$arr[$key][]=$value['uid'];
					$arr[$key][]=$value['real_name'];
					$arr[$key][]=$value['age'];
					$arr[$key][]=$value['idcard'];
					$arr[$key][]=$value['cell_phone'];
					$arr[$key][]=$value['address']?$value['address']:"暂无";
					$arr[$key][]=date('Y-m-d H:i:s',$value['reg_time']);
			}

		$total = count($arr);

		$cr = count($arr['0']);//获取每个数组有几个元素用来控制列

		for($i=0;$i<=$cr;$i++)
		{
			$cwr2=chr(64+$i+1);
			for($j=2;$j<=$total+2;$j++)
			{
				$cwr=$cwr2.$j;//abcdefg

				$objPHPExcel->getActiveSheet()->SetCellValue($cwr,' '.$arr[$j-2][$i]);
			}
		}
		
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$cr,$tip);

		$objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
		
		$objWriter->save(str_replace('.php', '.xls', __FILE__));
		
		$filename='区域划分.xls';

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
		header("Content-Type:application/force-download");
		header("Content-Type:application/vnd.ms-execl");
		header("Content-Type:application/octet-stream");
		header("Content-Type:application/download");
		header("Content-Disposition:attachment;filename=".$filename);
		header("Content-Transfer-Encoding:binary");
		$objWriter->save("php://output");
 	}
 	/*
 	机构管理-编辑
 	time:20150707
 	by lj
 	*/
 	public function eidt()
 	{
 		$this->show();
 	}
 

 }//eof class node