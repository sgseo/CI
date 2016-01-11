<?php
class Tab extends CI_Controller{

function __construct(){

  parent::__construct();
  header("content-type:text/html;charset=utf-8");
}

function tatd(){

$this->load->library("table");

$list=$this->db->query("select * from user");

$this->table->set_heading("id","姓名","昵称","密码","电话","邮箱","操作");

$this->table->set_caption('User');//为表格添加一个标题

$tmpl = array (
                    'table_open'          => '<table border="1" cellpadding="4" cellspacing="0">',

                    'heading_row_start'   => '<tr >',
                    'heading_row_end'     => '</tr>',
                    'heading_cell_start'  => '<th style="color:blue">',
                    'heading_cell_end'    => '</th>',

                    'row_start'           => '<tr >',
                    'row_end'             => '</tr>',
                    'cell_start'          => '<td>',
                    'cell_end'            => '</td>',

                    'row_alt_start'       => '<tr style="color:red">',
                    'row_alt_end'         => '</tr>',
                    'cell_alt_start'      => '<td style="color:green">',
                    'cell_alt_end'        => '</td>',

                    'table_close'         => '</table>'
              );

  $this->table->set_template($tmpl);

  $arr=array('6','54','6541','000','456');

  $cell = array('data' => 'Blue', 'class' => 'highlight', 'colspan' => 2);

  $this->table->set_empty("&nbsp;");

  $brr=array("删除");

  //var_dump($this->table->make_columns($brr,1));

  //$this->table->add_row($cell);

 echo $this->table->generate($list);




}







}
