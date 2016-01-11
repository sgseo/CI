<?php
class Time extends CI_Controller{

  public function __construct(){

      parent::__construct();

  }

  function test(){
  ini_set('date.timezone','PRC');//people republic of china
    $this->load->helper("date");
  //  echo timezone_menu("UP8");
  // $datestring = "Year: %Y Month: %m Day: %d - %h:%i %a";
    $time = time();

  // echo standard_date("DATE_ATOM", $time);

    $timestamp=local_to_gmt($time);//转化为时间戳 gmt greenwich mean time 格林尼治时间
  //$timezone="PRC";//people republic of china
  //  echo gmt_to_local($timestamp,$timezone,true);

    $mysql = '20061124092345';

    $unix = mysql_to_unix($mysql);

    $past_time='19900926092633';

    $a=strtotime($past_time);

    echo local_to_gmt($past_time);
     // $time=time();
    echo timespan($past_time,$time);///$past_time 一定是个时间戳





  }


}