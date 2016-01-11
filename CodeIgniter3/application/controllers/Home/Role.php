<?php
class Role extends CI_Controller{

	public $partner_name;
	public $secret_key;
	public $url;

	public function __construct(){

		parent::__construct();
		$this->partner_name=config_item('pname');
		$this->secret_key=config_item('secret_key');
		$this->url = config_item('api_url');
	    $this->load->helper('url');
	    $this->load->library('session');
	    //$this->load->library('session');
	}
	/**
	 * 20150720 我的推荐
	 */
	public function index()
	{

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

		$session_id=$this->session->session_id;

		curl_setopt($ch, CURLOPT_URL,$url) ;  
		curl_setopt($ch, CURLOPT_COOKIE,'session_id='.$session_id);
		curl_setopt($ch, CURLOPT_POST,count($fields)) ; // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名 
		$result = curl_exec($ch);  
		$result = json_decode($result,1);//返回 调用成功 等一系列参数 可以获取到 推荐的人
		//var_dump($result);
		$this->session->set_userdata('role',$result['data']);

		$total_bonus=0;
		foreach($result as $rs=>$key)
		{
			if(is_array($key))
			{
				foreach ($key as $v=>$k) {
					$total_bonus+=$k['bonus'];
				}
			}
		}


		//查询手机号$_POST['mobile']='13300003333';
		$mobile=$this->input->post('mobile');

		if(!empty($mobile))
		{
			foreach ($result['data'] as $key => $value) 
			{
				if($value['mobile']==$mobile)
				{
					$k=$value;
				}
			}
			$res[]=$k;
			$data['result']=$res;
			$data['total_bonus']=$k['bonus'];
		}

			$data['total_bonus']=$total_bonus;
		//自分页
		// $count =count($result['data']);//总共有多少条函数

		// $single_page_count = 5;//每页显示五条

		// $total=ceil($count/$single_page_count);//总页数

		// $p=$this->input->get('p')?$this->input->get('p'):1;//当前的页码
	
		// $cur_list_start = ($p-1)*$single_page_count;//当前页开始的那一条是第几条记录
		
		// $data['p']=$p;//页码

		// $data['total']=$total;//总页数

		// $data['result']=$result['data'];
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

		curl_setopt($ch, CURLOPT_COOKIE , "session_id=".$this->session->session_id);//
		curl_setopt($ch, CURLOPT_URL,$url) ; 
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,true) ;
		curl_setopt($ch, CURLOPT_POST,count($fields)) ; // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  
		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名 
		$list = curl_exec($ch);

		$list=json_decode($list,1);

		$data['tinvestors']=$list['data'];
		
		// //自分页
		// $tcount =count($list['data']);//总共有多少条函数

		// $tsingle_page_count = 10;//每页显示五条

		// $ttotal=ceil($tcount/$tsingle_page_count);//总页数

		// $tp=$this->input->get('tp)]?$this->input->get('tp)]:1;//当前的页码
	
		// $tcur_list_start = ($tp-1)*$tsingle_page_count;//当前页开始的那一条是第几条记录
		
		// $this->tp=$tp;//页码

		// $this->ttotal=$ttotal;//总页数

		// $this->tspc=$tsingle_page_count;//每页显示多少条

		// $this->tcls=$tcur_list_start;//每页的开始点

		// $this->tinvestors=$list['data'];

		// $this->total_bonus=$total_bonus;//总贡献奖金

		// $this->show();

		$this->load->view('home/role/index.html',$data);
	}

	
}
