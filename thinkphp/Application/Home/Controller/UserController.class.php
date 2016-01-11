<?php
namespace Home\Controller;
use Think\Controller;
 header("content-type:text/html;charset=utf8");
 class UserController extends Controller
 {
 	/*
 	用户管理-默认
 	time:20150707
 	by lj
 	*/
 	public function index()
 	{
 		$this->show();
 	}

 	/*
 	用户管理-添加
 	time:20150707
 	by lj
 	*/
 	public function add()
 	{
 		$this->show();
 	}
 	/*
 	用户管理-编辑
 	time:20150707
 	by lj
 	*/
 	public function eidt()
 	{
 		$this->show();
 	}
 

 }//eof class 