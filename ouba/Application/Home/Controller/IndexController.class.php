<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
        public $salt;
    // public $secret_key;
    // public $url;
    // public $surl;

   public function _initialize()
   {
     $this->salt=C(SALT);
     // $this->secret_key=C(SECRET_KEY);
     // $this->url = C(API_URL);
     // $this->surl = C(SON_URL);
   }
    //登录展示页
    public function index(){
      $this->display('cl_login_ing');
    }
    //登录验证
    public function cl_login()
    {
        $member=D('ucenter_member');
        $username=I('post.username');
        $password=I('post.password');
        $password=md5(sha1($password.$this->salt));
        $pwd=$member->field('password,status,pid')->where('username='."'".$username."'")->find();
        if($pwd['password']===$password)
        {
            session('username',$username);
            session('status',$pwd['status']);//用以判断是否是超级管理员登录
            session('pid',$pwd['pid']);//判断是哪个机构的
            redirect('cl_login_in#7');
        }else{
            $this->error('用户名或密码错误');
        }
    }
    //登录成功
    public function cl_login_in()
    {
        $username=session('username');
        $this->username=$username;
        $this->display('cl_login');
    }

    public function cl_login_out(){
            session('username',null);
            $url=U('index/index');
            $this->success("退出ok",$url);
        }
}