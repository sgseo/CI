<?php
class EmptyAction extends Action{
	//空模块
	/*
    public function _empty($name) {
		$this->assign("jumpUrl",'/');
		$this->error('Empty Action<BR>非法操作，请与管理员联系');

		
	}
	*/

	public function _empty(){ 
        header("HTTP/1.0 404 Not Found");//使HTTP返回404状态码 
        $this->display("Public:404"); 
    } 

	public function index(){ 
        header("HTTP/1.0 404 Not Found");//使HTTP返回404状态码 
        $this->display("Public:404"); 
    } 

}