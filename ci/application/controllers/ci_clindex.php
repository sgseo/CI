<?php
class Ci_clindex extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		header("content-type:text/html;charset=utf-8");
		//$this->load->library('db');
	}
 

	public function index()
	{
		var_dump($this->db->get("detail"));
		echo $this->db->getlastsql();
	}
}