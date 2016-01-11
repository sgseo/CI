<?php
// 本类由系统自动生成，仅供测试用途
class AboutAction extends HCommonAction
{

    public function index()
    {
                $is_subsite=false;
		$row=array();
                $type_list = get_type_list('acategory','id,type_nid,type_set');
               
                        $type_nid = get_type_leve();//获得所有栏目自己的nid的组合  //根据type_nid获得id                       
                        $xurl_tmp = explode("/",trim($_SERVER['REQUEST_URI'],'/'));//获得组合的type_nid   Array ( [0] => [1] => cfkt [2] => ) 
                        $zu = $xurl_tmp[0];//组合  cfkt
                        //print_r($type_nid);
                        $typeid = $type_nid[$zu];
                        $typeset = $type_list[$typeid]['type_set'];
                if($typeset==1){//列表
                        $templet = "list_index";
                }else{//单页
                        $templet = "index_index";
                }                          
            if($typeset==1){
                $parm['pagesize']=15;
                $parm['type_id']=$typeid;
                $list = zwgetArticleList($parm);     
                $vo = D('Acategory')->find($typeid);
//                if($vo['parent_id']<>0) $this->assign('cname',D('Acategory')->getFieldById($vo['parent_id'],'type_name'));
//                else $this->assign('cname',$vo['type_name']);
                $this->assign("vo",$vo);
                $this->assign("list",$list['list']);
                $this->assign("pagebar",$list['page']);
            }else{
                     $vo = D('Acategory')->find($typeid);
//                    if($vo['parent_id']<>0) $this->assign('cname',D('Acategory')->getFieldById($vo['parent_id'],'type_name'));
//                     else $this->assign('cname',$vo['type_name']);
               
                $this->assign("vo",$vo);
            }
        $this->assign("active_bar",'index');
        $this->display($templet);
   }

    // 简介
    public function intro()
    {
        $this->assign("active_bar",'intro');
        $this->display();
    }

    // 管理团队
    public function team()
    {
        $this->assign("active_bar",'team');
        $this->display();
    }

    // 组织架构
    public function org()
    {
        $this->assign("active_bar",'org');
        $this->display();
    }

    //
    public function parter()
    {
        $this->assign("active_bar",'parter');
        $this->display();
    }

    public function secure()
    {
        $this->assign("active_bar",'secure');
        $this->display();
    }

    public function rule()
    {
        $this->assign("active_bar",'rule');
        $this->display();
    }

    public function invite()
    {
        $this->assign("active_bar",'invite');
        $this->display();
    }

    public function transparent()
    {
        $this->assign("active_bar",'transparent');
        $this->display();
    }
     public function college()
    {
         $id = intval($_GET['id']);
		if($_GET['type']=="subsite") {
			$vo = M('article_area')->find($id);
		}else {
			$vo = M('article')->find($id);
			$tid = $vo['type_id'];
			$wo = M('article_category')->find($tid);
			$this->assign("wo",$wo);
		}
                $this->assign("active_bar",'index');
		$this->assign("vo",$vo);
                $this->display();
    }
     public function contact()
    {
        $this->assign("active_bar",'contact');
        $this->display();
    }
    
}