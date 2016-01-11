<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class C3_index extends CI_Controller{

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
		$this->load->view('home/index/cl_login_ing.html');
	}

		public function c3_cl_login()
	{
		$this->load->library('parser');
		 //接口地址
  		//$partner_name = 'ios';

  		$secret_key = $this->secret_key;

  		$data['pname'] = $this->partner_name;
		$data['sname'] = 'user.login';

		$data['mobile'] = $this->input->post('mobile');//I('post.mobile');
		$data['passwd'] = $this->input->post('passwd');//I('post.passwd');

		//echo "<pre/>";var_dump($data);

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
			$this->session->set_userdata('session_self_id',$bdata['data']['id']);

			$this->session->set_userdata('session_id',$session_id);

			$this->parser->parse('home/index/cl_login',$bdata['data']);

		}else{
			echo $bdata['msg'];
		}

		
	}



}