<?php
namespace Home\Controller;
use Think\Controller;
class AdminController extends Controller {
    //后台登录

    //登录框页面
    public function snail_admin_login()
    {
        $this->show();
    }
    //后台登录页
    public function snail_login()
    {
        $this->show();
    }
    //登录处理页
    public function snail_login_ing()
    {
        $username=I('post.username');
        $pwd=I('post.password').'salt';//salt
        $mdPw=md5($pwd);
        $uid=M("admin")->field('id')->where(' username = '."'".$username."'".' and password='."'".$mdPw."'")->find();
        if($uid)
        {
            $_SESSION['username']=$username;
            //登录成功
             $message="登录成功";
             $url="snail_login";
            $this->success($message,$url);
        }else{
            //登录失败
            $message="登录失败,用户名或密码错误";
            $this->error($message);
        }
    }
    //添加我们的经验
    public function addexp()
    {
        $this->show();
    }

    //添加expin
    public function addexpin()
    {

        $title=I('post.exp');
        $content=I('post.info');
        $data['exp']=$title;
        $data['info']=$content;
        $data['addtime']=time();
        $Art=M('experence');
        $id=$Art->add($data);
        //处理图片
        if($id)
        {
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =     './Uploads/exp/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $upload->saveName = time().'_'.mt_rand();
            //文章图片地址
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            }else{// 上传成功
            $src=$upload->rootPath.$info['month']['savepath'].$info['month']['savename'];
            $data['imgsrc']=$src;
            $Art->where('id='.$id)->save($data);
            }
                 $this->success('添加成功！');
        }

    }
    //添加我的小伙伴
    public function addnewbie()
    {
          $this->show();
    }

    public function newbiein()
    {
       $username=I('post.username');
        
        $pwd=I('post.password');

        $repwd=I('post.repwd');

        if($pwd!=$repwd)
        {
            $this->error('两次密码不一致');
        }

        $mdPw=md5($pwd."salt");

        $User = M("admin"); // 实例化User对象

        $id=$User->getFieldByUsername($username,'id');

        if($id)
        {
            $this->error('此用户名已经存在');
        }

        $res=$User->add(array('username'=>$username,'password'=>$mdPw));

        if($res)
        {
            $this->success('添加成功');
        }else{
           echo  $this->getDbError();
        }
    }
    //添加文章页
    public function addarticle()
    {
        $this->show();
    }
    //文章入库in
    public function addarticlein()
    {
        $title=I('post.title');
        $content=I('post.content');
        $data['title']=$title;
        $data['content']=$content;
        $data['addtime']=time();
        $Art=M('article');
        $id=$Art->add($data);
        //处理图片
        if($id)
        {
            $upload = new \Think\Upload();// 实例化上传类
            $upload->maxSize   =     3145728 ;// 设置附件上传大小
            $upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
            $upload->rootPath  =     './Uploads/article/'; // 设置附件上传根目录
            $upload->savePath  =     ''; // 设置附件上传（子）目录
            $upload->saveName = time().'_'.mt_rand();
            //文章图片地址
            $info   =   $upload->upload();
            if(!$info) {// 上传错误提示错误信息
                $this->error($upload->getError());
            }else{// 上传成功
            $src=$upload->rootPath.$info['month']['savepath'].$info['month']['savename'];
            $data['imgsrc']=$src;
            $Art->where('id='.$id)->save($data);
            }
                 $this->success('添加成功！');
        }
    }

    public function cl_login_out()
    {
        unset($_SESSION['username']);
        $this->success('退出成功','snail_admin_login');
    }


}