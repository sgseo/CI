<?php
    /**
    *  托管相关配置
    *  @author  张继立  2014-05-12
    */
    class TrustAction extends ACommonAction
    {
        public function index()
        {
            $loanconfig = FS("Webconfig/loanconfig");

            $this->assign('loan',$loanconfig);
            $this->display();
        }
        /**
        * 保存参数
        * 
        */
        public function save()
        {
            FS("loanconfig",$_POST['loan'],"Webconfig/");
            alogs("Age",0,1,'托管设置操作成功！');//管理员操作日志
            $this->success("操作成功",__URL__."/index/");
        }
    }
?>
