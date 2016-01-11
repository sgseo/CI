<?php
// +----------------------------------------------------------------------
// | Author: lijie 
// +----------------------------------------------------------------------
namespace Admin\Controller;
use Admin\Model\AuthRuleModel;
use Admin\Model\AuthGroupModel;
class BorrowController extends AdminController
{
   //借款信息录入
    public function index()
    {
        // $insert=D('House');
        // $data=$insert->create();
        // $insert->add($data);//返回的是本次插入的id
        $this->display();
    }
    //信息插入
    public function add()
    {
          echo '111' ;
        var_dump($_POST);
        die;
        //$insert=D('House');
        $data=$insert->create();
        $insert->add($data);//返回的是本次插入的id
    }
}