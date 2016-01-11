<?php
 namespace Home\Controller;
 use Think\Controller;
 header("content-type:text/html;charset=utf8");
class IndexController extends Controller {

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
    public function index(){
      $this->display("cl_login_ing");
    }

    /*
	 *	登录界面 
	 *	time:20150707
	 *	by lj
     */
    public function cl_login_ing()
    
    {
    	$this->show();
    }
	/*
		财来网 登录 api 接口。
		time:20150716

	*/
  	public function cl_login(){
        //接口地址
  		//$partner_name = 'ios';

  		$secret_key = $this->secret_key;

  		$data['pname'] = $this->partner_name;
		$data['sname'] = 'user.login';

		$data['mobile'] = I('post.mobile');
		$data['passwd'] = I('post.passwd');

		$content = json_encode($data);

		$string = $content.$secret_key;

		$token = md5($string);

		$post['content'] = $content;
		$post['token'] = $token;

		//curl post 请求

		$url = $this->url;  

		$fields = $post ;

		$ch = curl_init() ;  

		curl_setopt($ch, CURLOPT_HEADER,1);//获取http header内容

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//控制返回结果不让自动输出

		curl_setopt($ch, CURLOPT_URL,$url);

		curl_setopt($ch, CURLOPT_POST,count($fields)) ; // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  

		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名  		

		$result = curl_exec($ch);

		curl_close($ch); 
		//获取返回值body
		preg_match_all('|{(.*)}}|U', $result, $body);

		$bcontent = implode(';', $body[0]);	
		//或许返回信息
		$bdata = json_decode($bcontent,1);

		if($bdata['code'] == 0)//code 为0 代表调用成功
		{
			//获取session_id
			preg_match_all('|Set-Cookie: (.*);|U', $result, $arr);
			
			$session = implode(';', $arr[1]);
			
			$session_id=substr($session,11);

			//登录者的id
			session('myid',$bdata['data']['id']);

			session('session_id',$session_id);

			$this->bdata=$bdata;

			$this->show();
		}else{
			$this->error($bdata['msg']);
		}
		
	}//eof cl_login

		/*
		 *退出子公司系统
		 *time:20150709
		 *by lj
		 */
		public function cl_login_out(){

			session('session_id',null);
			$url=U('index/cl_login_ing');
			$this->success("退出ok",$url);
		}

		/**
		 * 回款计划 
		 * time:20150710
		 * by lj		 
		 */
		public function cl_moneyback()
		{
		$secret_key = $this->secret_key;

  		$data['pname'] =$this->partner_name; 
		$data['sname'] = 'receive.plan';

		$search_month = I("get.month");

		$data['search_month'] =$search_month?$search_month:date('m');

		//echo $data['search_month'];
		//$data['search_year']='2016';
		//下载输出的时候要用到
		session('month',$data['search_month']);
	
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

		curl_setopt($ch, CURLOPT_COOKIE , "session_id=".session('session_id') );//

		curl_setopt($ch, CURLOPT_URL,$url);

		curl_setopt($ch, CURLOPT_POST,count($fields)) ; // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  

		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名  		

		$result = curl_exec($ch);

		$result = json_decode($result,1);

		//var_dump($result);die;

		curl_close($ch); 
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

		//get 方式提交的 需要传递月份
		$this->m=$data['search_month'];

		$status_arr=array('未通过','已还完','已提前还款','迟还','网站代还本金','逾期贷款','逾期未还','还款中');

		$this->status_arr=$status_arr;

		$this->result=$result['data'];

		$this->show();

		}//eof money

		/**
		 * 导出excel功能
		 * time:20150713
		 * by lj
		 */

		public function cl_to_excel()
		{
		import("Vendor.PhpExcel.PHPExcel");

		$secret_key = $this->secret_key;

  		$data['pname'] =$this->partner_name; 
		$data['sname'] = 'receive.plan';

		$data['search_month'] =session('month');

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

		curl_setopt($ch, CURLOPT_COOKIE , "session_id=".session('session_id') );//

		curl_setopt($ch, CURLOPT_URL,$url);

		curl_setopt($ch, CURLOPT_POST,count($fields)) ; // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  

		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名  		

		$result = curl_exec($ch);

		$result = json_decode($result,1);

		curl_close($ch); 

		$list=$result['data'];

		$objPHPExcel = new \PhpExcel();

		$row=array();

		$row[0]=array('借款标号','借款人id','借款人姓名','应收利息','应收本金','利息管理费','标的状态','应还日期','逾期罚金','预期总收益');
		//标的状态
		$bid_status=array('未通过','已还完','已提前还款','迟还','网站代还本金','逾期贷款','逾期未还','还款中');
	
		$objPHPExcel->setActiveSheetIndex(0);

		//合并单元格：
		//$objPHPExcel->getActiveSheet()->mergeCells('B1:F1');
		//头部
			foreach ($row[0] as $key => $value) 
			{
				$cwr=chr(65+$key).'1';
				$objPHPExcel->getActiveSheet()->SetCellValue($cwr, $value);
			}

			foreach ($list as $key => $value) {
					$arr[$key][]=$value['borrow_id'];
					$arr[$key][]=$value['borrow_uid'];
					$arr[$key][]=$value['real_name'];
					$arr[$key][]=($value['interest']?$value['interest']:0);
					$arr[$key][]=$value['capital'];
					$arr[$key][]=($value['interest_fee']?$value['interest_fee']:0);
					$arr[$key][]=$bid_status[$value['status']];
					$arr[$key][]=date('Y-m-d',$value['deadline']);
					$arr[$key][]=$value['expired_money'];
					$arr[$key][]=$value['interest']+$value['capital']-$value['interest_fee'];
					
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
		$status_arr=array('注释1-8代表的状态','1未通过','2已还完','3已提前还款','4迟还','5网站代还本金','6逾期贷款','7逾期未还','8还款中');
		//注释
		$tip=implode($status_arr,',');
	
		$objPHPExcel->getActiveSheet()->SetCellValue('A'.$cr,$tip);
	

		$objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
		
		$objWriter->save(str_replace('.php', '.xls', __FILE__));
		
		$filename='回款计划.xls';

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


		  /*我的红包测试*/
		 public function cl_reds()
		 {
		 	$secret_key = $this->secret_key;

	  		$data['pname'] =$this->partner_name; 

			$data['sname'] = 'redpacket';

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

			curl_setopt($ch, CURLOPT_COOKIE , "session_id=".session('session_id') );//

			curl_setopt($ch, CURLOPT_URL,$url);

			curl_setopt($ch, CURLOPT_POST,count($fields)) ; // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  

			curl_setopt($ch, CURLOPT_POSTFIELDS,$fields); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名  		

			$result = curl_exec($ch);

			$result = json_decode($result,1);
			
			var_dump($result);
			
			curl_close($ch); 

		 }


}