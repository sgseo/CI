<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        //读取经验
        $M=M('article');
        $res=$M->select();
        $this->res=$res;
        $this->show();
    }
     public function about(){
        $this->show();
    }
     public function blog(){
        $this->show();
    }
     public function contact(){
        $this->show();
    }
     public function gallery(){
        $this->show();
    }
     public function services(){
        $this->show();
    }
     public function single(){
        $this->show();
    }


}