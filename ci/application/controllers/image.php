<?php
class Image extends CI_Controller{

function __construct(){

  parent::__construct();
  $this->load->library('image_lib');   
header("content-type:text/html;charset=utf-8");
  $this->load->helper('url');
}


function resize(){

      $config['image_library']='gd2';//设置图片gd2库

      $config['source_image']="./upload/source/2014/11/19/20131227233154_3aeeS.jpg";//原图的地址
      //  echo $config['source_image'];
      //  die;
      $config['create_thumb']=TRUE;//创建缩略图

      $config['maintain_ratio']=TRUE;

      $config['width']=500;

      $config['height']=300;

      $config['new_image']="coco.jpg";

     $config['thumb_marker']="酸奶_ivy";

     // $this->load->library("image_lib",$config);

      $this->image_lib->initialize($config);//如果配置了$config 就不需要这句了

      if(!$this->image_lib->resize())
      {
      echo   $this->image_lib->display_errors();

      }else{
          echo "handle ok";

      }

  }

  function watermark()
  {
    $config['image_library']='gd2';//设置图片gd2库
    $config['source_image']="./upload/source/2014/11/19/20131227233154_3aeeS.jpg";
    $config['wm_text']="copy_right32123121";//设置你要添加的水印内容
    $config['wm_type']='text';
    $config['wm_font_path'] = './system/fonts/texb.ttf';
    $config['wm_font_color']="ffffff";//水印的颜色；
    $config['wm_font_size']="14";
    $config['wm_vrt_alignment'] = 'middle';//设置水印图像的垂直对齐方式
    $config['wm_hor_alignment'] = 'center';//设置水印图像的水平对齐方式
    $config['wm_padding']='20';//水印与图片边缘的距离。防止水印打到边部显示不全部
    $this->image_lib->initialize($config);

    if(!$this->image_lib->watermark())
    {
      echo $this->image_lib->display_errors();
    }else{

      echo "ok111";
    }


  }
}//eof image