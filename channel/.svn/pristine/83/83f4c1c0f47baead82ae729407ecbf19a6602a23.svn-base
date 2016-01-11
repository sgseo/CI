<?php
namespace Home\Controller;
use Think\Controller;
 header("content-type:text/html;charset=utf8");
 class NodeController extends Controller
 {
	public $partner_name;
	public $secret_key;
	public $url;

   public function _initialize()
   {
	 $this->partner_name=C(PNAME);
	 $this->secret_key=C(SECRET_KEY);
	 $this->url = C(API_URL);
   }

 		/*
 	机构管理-默认
 	time:20150707
 	by lj
 	*/
 	/*
		登录者个人资产统计 api 接口 
		time:20150706
	*/

	public function index()
	{	
		$secret_key = $this->secret_key;

  		$data['pname'] = $this->partner_name;

		$data['sname'] = 'member.capital';

		$content = json_encode($data);

		$string = $content.$secret_key;

		$token = md5($string);

		$post['content'] = $content;
		$post['token'] = $token;

		//curl post 请求

		$url = $this->url ;  
		$fields = $post ;
	
		$ch = curl_init() ;  
	
		curl_setopt($ch, CURLOPT_URL,$url) ;  
		curl_setopt($ch, CURLOPT_COOKIE , "session_id=".session('session_id') );//
		curl_setopt($ch, CURLOPT_POST,count($fields)) ; // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  
		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名 

		ob_start();  
		curl_exec($ch);  
		$result = ob_get_contents();  
		ob_end_clean();  
		
		$result = json_decode($result,1);

		curl_close($ch);

		//获取投资记录
		$data['sname']='tendbacking.get';

		$content = json_encode($data);

		$string = $content.$secret_key;

		$token = md5($string);

		$post['content'] = $content;

		$post['token'] = $token;

		$fields = $post ;

		$ch = curl_init() ;  
	
		curl_setopt($ch, CURLOPT_URL,$url) ;  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_COOKIE , "session_id=".session('session_id') );//
		curl_setopt($ch, CURLOPT_POST,count($fields)); // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  
		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名 

		$res=curl_exec($ch);  

		$bidlist = json_decode($res,1);
		
		session('bidlist',$bidlist);

		$count =count($bidlist['data']);//总共有多少条函数

		$single_page_count = 5;//每页显示五条

		$total=ceil($count/$single_page_count);//总页数

		$p=$_GET['p']?$_GET['p']:1;//当前的页码
	
		$cur_list_start = ($p-1)*$single_page_count;//当前页开始的那一条是第几条记录
		
		$this->p=$p;//页码

		$this->total=$total;//总页数

		$this->spc=$single_page_count;//每页显示多少条

		$this->cls=$cur_list_start;//每页的开始点

		$this->bidlist=$bidlist;//个人投资列表

		//我的交易记录(流水记录)

		$data['sname']='deal.record';

		$content = json_encode($data);

		$string = $content.$secret_key;

		$token = md5($string);

		$post['content'] = $content;

		$post['token'] = $token;

		$fields = $post ;

		$ch = curl_init() ;  
	
		curl_setopt($ch, CURLOPT_URL,$url) ;  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_COOKIE , "session_id=".session('session_id') );//
		curl_setopt($ch, CURLOPT_POST,count($fields)); // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  
		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名 

		$res=curl_exec($ch);  

		$deallist = json_decode($res,1);

		session('deallist',$deallist);

		$dcount =count($deallist['data']);//总共有多少条函数

		$dsingle_page_count = 6;//每页显示五条

		$dtotal=ceil($dcount/$dsingle_page_count);//总页数

		$dp=$_GET['dp']?$_GET['dp']:1;//流水dealist当前的页码
	
		$dcur_list_start = ($dp-1)*$dsingle_page_count;//当前页开始的那一条是第几条记录
		
		$this->dp=$dp;//页码

		$this->dtotal=$dtotal;//总页数

		$this->dspc=$dsingle_page_count;//每页显示多少条

		$this->dcls=$dcur_list_start;//每页的开始点

		$this->deallist=$deallist;//个人交易记录

		$this->result=$result;//用户个人财产信息

		$this->show();

	}
 	/*
 	投资记录
 	time:20150717
 	by lj
 	*/
 	public function invest_record()
 	{
 		import("Vendor.PhpExcel.PHPExcel");

 		$objPHPExcel = new \PhpExcel();

 		$list=session('bidlist');

		$list=array_splice($list,2);

		$row=array();

		$row[0]=array('借款标号','借款名称','借款人姓名','投资金额','已还本息','年利率','总共期限','已经期数','下一还款时间');
	
		$objPHPExcel->setActiveSheetIndex(0);
		//头部
			foreach ($row[0] as $key => $value) 
			{
				$cwr=chr(65+$key).'1';
				$objPHPExcel->getActiveSheet()->SetCellValue($cwr, $value);
			}

			foreach ($list['data'] as $key => $value)
			{
					$arr[$key][]=$value['bid'];
					$arr[$key][]=$value['bname'];
					$arr[$key][]=$value['borrow_uname'];
					$arr[$key][]=$value['invest_money'];
					$arr[$key][]=$value['repayment_money'];
					$arr[$key][]=$value['borrow_interest_rate'];
					$arr[$key][]=$value['total_periods'];
					$arr[$key][]=$value['payed_periods'];
					$arr[$key][]=$value['next_pay_date'];
			}
		
		$total = count($arr);	

		$cr = count($arr['0']);//获取每个数组有几个元素用来控制列

		for($i=0;$i<=$cr;$i++)
		{
			$cwr2=chr(64+$i+1);
			for($j=2;$j<=$total+2;$j++)
			{
				$cwr=$cwr2.$j;//abcdefg
				$objPHPExcel->getActiveSheet()->SetCellValue($cwr,$arr[$j-2][$i]);
			}
		}
		$objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
		
		$objWriter->save(str_replace('.php', '.xls', __FILE__));
		
		$filename='投资记录.xls';

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
 	public function deal_record()
 	{
 		import("Vendor.PhpExcel.PHPExcel");

 		$objPHPExcel = new \PhpExcel();

 		$list=session('deallist');

		$list=array_splice($list,2);

		//echo P;var_dump($list);die;

		$row=array();

		$row[0]=array('交易时间','交易类型','影响金额','代收金额','说明','可用金额');
	
		$objPHPExcel->setActiveSheetIndex(0);
		//头部
			foreach ($row[0] as $key => $value) 
			{
				$cwr=chr(65+$key).'1';
				$objPHPExcel->getActiveSheet()->SetCellValue($cwr, $value);
			}

			foreach ($list['data'] as $key => $value) {
					$arr[$key][]=$value['date'];
					$arr[$key][]=$value['type'];
					$arr[$key][]=$value['affect_money'];
					$arr[$key][]=$value['collect_money'];
					$arr[$key][]=$value['desc'];
					$arr[$key][]=$value['account_money'];
			
			}
		
		$total = count($arr);	

		$cr = count($arr['0']);//获取每个数组有几个元素用来控制列

		for($i=0;$i<=$cr;$i++)
		{
			$cwr2=chr(64+$i+1);
			for($j=2;$j<=$total+2;$j++)
			{
				$cwr=$cwr2.$j;//abcdefg
				$objPHPExcel->getActiveSheet()->SetCellValue($cwr,$arr[$j-2][$i]);
			}
		}
		$objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
		
		$objWriter->save(str_replace('.php', '.xls', __FILE__));
		
		$filename='交易记录.xls';

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
 

 }//eof class node