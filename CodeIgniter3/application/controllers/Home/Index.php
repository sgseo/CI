<?php
class Index extends CI_Controller{

	public function __construct(){

		parent::__construct();
		
		$this->partner_name=config_item('pname');
		
		$this->secret_key=config_item('secret_key');
		
		$this->url = config_item('api_url');

	    $this->load->helper('url');

	    $this->load->library('session');

	    $this->load->helper('form');

	    $this->load->library('parser');
	}
	/**
	 * 20150720子公司系统 我的汇款计划
	 */
	public function cl_moneyback()
	{
		 //接口地址
   		$secret_key = $this->secret_key;

  		$data['pname'] = $this->partner_name;

		$data['sname'] = 'receive.plan';

		$data['search_month']=$this->input->post('month')?$this->input->post('month'):date('m');
		
		$content = json_encode($data);

		$string = $content.$secret_key;

		$token = md5($string);

		$post['content'] = $content;

		$post['token'] = $token;

		$session_id=$this->session->session_id;
		//curl post 请求
		$url = $this->url;  

		$fields = $post ;

		$ch = curl_init() ;  

		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//控制返回结果不让自动输出

		curl_setopt($ch, CURLOPT_COOKIE,'session_id='.$session_id);

		curl_setopt($ch, CURLOPT_URL,$url);

		curl_setopt($ch, CURLOPT_POST,count($fields)) ; // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  

		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名  		

		$result = curl_exec($ch);

		$bdata=json_decode($result,1);	

		$this->session->set_userdata('bdata',$bdata);

		if($bdata['code'] == 0)//code 为0 代表调用成功
		{	
			$this->load->view('home/index/cl_moneyback',$bdata);
		}else{
			echo $bdata['msg'];
		}

			curl_close($ch); 
	}

	
	



}
