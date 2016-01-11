<?php
namespace Home\Controller;
use Think\Controller;
 header("content-type:text/html;charset=utf8");
 class RoleController extends Controller
 {
 	
 	public $partner_name;
	public $secret_key;
	public $url;
	public $surl;

   public function _initialize()
   {
	 $this->partner_name=C(PNAME);
	 $this->secret_key=C(SECRET_KEY);
	 $this->url = C(API_URL);
	 $this->surl = C(SON_URL);
   }
 	/*
		我的推荐人 api cl_invite
		time:20150706
		by lj
	*/
		public function index(){


		$secret_key = $this->secret_key;

  		$data['pname'] = $this->partner_name;

		$data['sname'] = 'user.recommend';

		$content = json_encode($data);

		$string = $content.$secret_key;

		$token = md5($string);

		$post['content'] = $content;
		$post['token'] = $token;

		//curl post 请求

		$url = $this->url;  
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
		curl_close($ch);

		$result = json_decode($result,1);//返回 调用成功 等一系列参数 可以获取到 推荐的人

		cookie('role',serialize($result));

		foreach($result as $rs=>$key)
		{
			if(is_array($key))
			{
				foreach ($key as $v=>$k) {
					$total_bonus+=$k['bonus'];
				}
			}
		}
				//查询手机号
		//$_POST['mobile']='13300003333';

		if(!empty($_POST['mobile']))
		{
			$mobile=$_POST['mobile'];

			foreach ($result['data'] as $key => $value) 
			{
				if($value['mobile']==$mobile)
				{
					$k=$value;
				}
			}
			$res[]=$k;
			$this->result=$res;
			$this->spc=1;
			$this->cls=0;
			$this->single_bonus=$k['bonus'];//个人总贡献
			$this->show();
			return;
		}
				//自分页
		$count =count($result['data']);//总共有多少条函数

		$single_page_count = 5;//每页显示五条

		$total=ceil($count/$single_page_count);//总页数

		$p=$_GET['p']?$_GET['p']:1;//当前的页码
	
		$cur_list_start = ($p-1)*$single_page_count;//当前页开始的那一条是第几条记录
		
		$this->p=$p;//页码

		$this->total=$total;//总页数

		$this->spc=$single_page_count;//每页显示多少条

		$this->cls=$cur_list_start;//每页的开始点

		$this->result=$result['data'];

		//当日的投资

		$data['sname'] = 'todayinvest.get';

		$content = json_encode($data);

		$string = $content.$secret_key;

		$token = md5($string);

		$post['content'] = $content;

		$post['token'] = $token;

		//curl post 请求

		$url = $this->url;  

		$fields = $post ;

		$ch = curl_init() ;  

		curl_setopt($ch, CURLOPT_COOKIE , "session_id=".session('session_id') );//
		curl_setopt($ch, CURLOPT_URL,$url) ; 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true) ;
		curl_setopt($ch, CURLOPT_POST,count($fields)) ; // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  
		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名 
		$list = curl_exec($ch);

		$list=json_decode($list,1);

	
		
		//自分页
		$tcount =count($list['data']);//总共有多少条函数

		$tsingle_page_count = 10;//每页显示五条

		$ttotal=ceil($tcount/$tsingle_page_count);//总页数

		$tp=$_GET['tp']?$_GET['tp']:1;//当前的页码
	
		$tcur_list_start = ($tp-1)*$tsingle_page_count;//当前页开始的那一条是第几条记录
		
		$this->tp=$tp;//页码

		$this->ttotal=$ttotal;//总页数

		$this->tspc=$tsingle_page_count;//每页显示多少条

		$this->tcls=$tcur_list_start;//每页的开始点

		$this->tinvestors=$list['data'];

		$this->total_bonus=$total_bonus;//总贡献奖金

		$this->show();
	}


	/*
		下载推荐人信息
		time:20150708
		by lj
	*/

	public function cl_to_excel()
	{
		import("Vendor.PhpExcel.PHPExcel");

		$objPHPExcel=new \PhpExcel();
	//	var_dump(cookie('role'));

		$list=unserialize(cookie('role'));

		$list = array_splice($list,2);

		$row[0]=array('推荐者的id','推荐者姓名','推荐者电话','推荐者贡献额度','推荐者注册时间');

		$objPHPExcel->setActiveSheetIndex(0);

		//合并单元格：
		//$objPHPExcel->getActiveSheet()->mergeCells('B1:F1');
		//头部
			foreach ($row[0] as $key => $value) 
			{
				$cwr=chr(65+$key).'1';
				$objPHPExcel->getActiveSheet()->SetCellValue($cwr, $value);
			}

			foreach ($list['data'] as $key => $value) {
					$arr[$key][]=$value['id'];
					$arr[$key][]=$value['real_name'];
					$arr[$key][]=$value['mobile'];
					$arr[$key][]=$value['bonus'];
					$arr[$key][]=date('Y-m-d',$value['reg_date']);
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

		$objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
		
		$objWriter->save(str_replace('.php', '.xls', __FILE__));
		
		$filename='推荐人.xls';

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
	 *推荐的人的具体投资
	 *time:20150708
	 * by lj
	 */
	public function rectendback()
	{
		$secret_key = $this->secret_key;

  		$data['pname'] = $this->partner_name;

		$data['sname'] = 'rectendbacking.get';

		$data['userId'] = intval($_GET['userId']);

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
		$result=json_decode($result,1);
		//分页
		$count =count($result['data']);//总共有多少条函数

		$single_page_count = 10;//每页显示五条

		$total=ceil($count/$single_page_count);//总页数

		$p=$_GET['p']?$_GET['p']:1;//当前的页码
	
		$cur_list_start = ($p-1)*$single_page_count;//当前页开始的那一条是第几条记录

		$real_name=$_GET['real_name'];

		$this->real_name=$real_name;//传递真实姓名
		
		$this->condi=$data['userId'];//get 分页的条件传递

		$this->p=$p;//页码

		$this->total=$total;//总页数

		$this->spc=$single_page_count;//每页显示多少条

		$this->cls=$cur_list_start;//每页的开始点

		$this->reclist=$result['data'];
		
		$this->show();	
	}//eof rec

	/**
	 * 推荐人的资金状况api
	 * time:20150709
	 * by lj
	 */
	public function remember()
	{		
		$secret_key = $this->secret_key;

  		$data['pname'] = $this->partner_name;

		$data['sname'] = 'remember.capital';

		$data['userId'] = I('get.userId');

		$phone=I('get.phone');

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
		$result=json_decode($result,1);

		$this->reclist=$result['data'];

		$real_name=I('get.real_name');

		$this->phone=$phone;

		$this->real_name=$real_name;//传递真实姓名

		$this->show();
	}//eof rem

	/**
	 * 发送短信提醒
	 */
	public function sendsms()
	{
		$mobile = I('post.mobile');

        $content = I('post.content');

        $surl=$this->surl;;

       	$data['secret_key']=$this->secret_key;

  		$data['pname'] = $this->partner_name;

  		$data['mobile']=$mobile;

  		$data['content']= $content;

  		//模拟post 请求
	    $ch = curl_init() ;  
	  	$fields = $data;
		curl_setopt($ch, CURLOPT_URL,$surl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//控制返回结果不让自动输出
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//对ssl 证书错误 不验证
		curl_setopt($ch, CURLOPT_POST,count($fields)) ; // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  
		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名  		

		$result = curl_exec($ch);//其值为 成功为1 不成功为 no auth
	
		if($result==1)
		{
			$json['status']='ok';
			exit(json_encode($json));
		}else{
			$json['status']='no';
			exit(json_encode($json));
		}

	}



 }//eof class role