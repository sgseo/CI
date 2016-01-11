<?php
class layout extends CI_Controller{

  function __construct(){

    parent::__construct();

  }

  function lay()
  {

   $this->load->library("Hulk_template");
    //加载子视图
   $this->hulk_template->parse("test");

  }








}