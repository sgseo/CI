<?php
class Node extends CI_Controller{


	public $partner_name;
	public $secret_key;
	public $url;
	public $month;


	public function __construct(){

		parent::__construct();
		
		$this->partner_name=config_item('pname');
		
		$this->secret_key=config_item('secret_key');
		
		$this->url = config_item('api_url');

	    $this->load->helper('url');

	    $this->load->library('session');
	}
	/**
	 * 20150720子公司系统功首页
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
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_COOKIE , "session_id=".$this->session->userdata('session_id'));//
		curl_setopt($ch, CURLOPT_POST,count($fields)) ; // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  
		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名 
		
		$result = curl_exec($ch);  
		
		$result = json_decode($result,1);

		curl_close($ch);

		//data 传值
		$data['result']=$result['data'];

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
		curl_setopt($ch, CURLOPT_COOKIE , "session_id=".$this->session->userdata('session_id'));//
		curl_setopt($ch, CURLOPT_POST,count($fields)); // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  
		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名 

		$res=curl_exec($ch);  

		$bidlist = json_decode($res,1);

		$this->session->set_userdata('bidlist',$bidlist['data']);

		$data['bidlist']=$bidlist['data'];
		//投资记录的分页
		$count =count($bidlist['data']);//总共有多少条函数

		$single_page_count = 5;//每页显示五条

		$total=ceil($count/$single_page_count);//总页数

		$p=$this->input->get('p')?$this->input->get('p'):1;//当前的页码
	
		$cur_list_start = ($p-1)*$single_page_count;//当前页开始的那一条是第几条记录
		
		$data['p']=$p;

		$data['total']=$total;//总页数
		//用slice函数截取 
		$data['bidlist']=array_slice($data['bidlist'],$cur_list_start,$single_page_count);

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
		curl_setopt($ch, CURLOPT_COOKIE , "session_id=".$this->session->userdata('session_id'));//
		curl_setopt($ch, CURLOPT_POST,count($fields)); // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  
		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名 

		$res=curl_exec($ch);  

		$deallist = json_decode($res,1);

		$this->session->set_userdata('deallist',$deallist['data']);

		$data['deallist']=$deallist['data'];

		$dcount =count($deallist['data']);//总共有多少条函数

		$dsingle_page_count = 5;//每页显示五条

		$dtotal=ceil($dcount/$dsingle_page_count);//总页数

		$dp=$this->input->get('dp')?$this->input->get('dp'):1;//流水dealist当前的页码
	
		$dcur_list_start = ($dp-1)*$dsingle_page_count;//当前页开始的那一条是第几条记录

		$data['deallist']=array_slice($data['deallist'],$dcur_list_start,$dsingle_page_count);

		$data['dp']=$dp;

		$data['dtotal']=$dtotal;
		
	    $this->load->view('home/node/index',$data);
	}


	//导出功能
	public function cl_invest_import()
	{
		//导入类库
		$this->load->library('PHPExcel');

		$this->load->library('PHPExcel/IOFactory');
		//导出的是投标列表
		$list=$this->session->userdata('bidlist');
		//设置excel表格标题行
		$row=array();

		$row[0]=array('借款标号','借款名称','借款人姓名','投资金额','已还本息','年利率','总共期限','已经期数','下一还款时间');;

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->setActiveSheetIndex(0);

		$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

		foreach ($row[0] as $key => $value) 
		{
			$cwr=chr(65+$key).'1';
			$objPHPExcel->getActiveSheet()->SetCellValue($cwr, $value);
		}

		foreach ($list as $key => $value)
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

		$total = count($arr);//34

		$cr = count($arr['0']);//获取每个数组有几个元素用来控制列 9

		for($i=0;$i<$cr;$i++)
		{
			$cwr2=chr(64+$i+1);
			for($j=2;$j<$total+2;$j++)
			{
				$cwr=$cwr2.$j;//abcdefg
				$objPHPExcel->getActiveSheet()->SetCellValue($cwr,$arr[$j-2][$i]);
			}
		}

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');

		//发送标题强制用户下载文件
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

		$objWriter->save('php://output');

	}
	
	/**
	 * 99乘法表
	 */
	function by99()
	{
		for ($i=1;$i<=9;$i++) 
		{ 
			for($j=1;$j<=9;$j++)
			{
				$ij=$i*$j;
				if($j<=$i)
				{
				$html="<td style='border:1px solid red'>".$j."x".$i."=".$ij."&nbsp;</td>";
				echo $html;
				}
			}
			echo "<br/>";
		}
	}
	/**
	 * 我的交易记录
	 */
	public function deal_record()
	{
		//导入类库
		$this->load->library('PHPExcel');

		$this->load->library('PHPExcel/IOFactory');
		//导出的是投标列表
		$list=$this->session->userdata('deallist');
		//设置excel表格标题行
		$row=array();

		$row[0]=array('交易时间','交易类型','影响金额','代收金额','说明','可用余额');

		$objPHPExcel = new PHPExcel();

		$objPHPExcel->setActiveSheetIndex(0);

		$objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

		foreach ($row[0] as $key => $value) 
		{
			$cwr=chr(65+$key).'1';
			$objPHPExcel->getActiveSheet()->SetCellValue($cwr, $value);
		}

		foreach ($list as $key => $value)
		{
			$arr[$key][]=$value['date'];
			$arr[$key][]=$value['type'];
			$arr[$key][]=$value['affect_money'];
			$arr[$key][]=$value['collect_money'];
			$arr[$key][]=$value['desc'];
			$arr[$key][]=$value['account_money'];
			
		}

		$total = count($arr);//34

		$cr = count($arr['0']);//获取每个数组有几个元素用来控制列 9

		for($i=0;$i<$cr;$i++)
		{
			$cwr2=chr(64+$i+1);
			for($j=2;$j<$total+2;$j++)
			{
				$cwr=$cwr2.$j;//abcdefg
				$objPHPExcel->getActiveSheet()->SetCellValue($cwr,$arr[$j-2][$i]);
			}
		}

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');

		//发送标题强制用户下载文件
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

		$objWriter->save('php://output');

	}
}
