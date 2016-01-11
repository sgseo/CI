<?php
// 全局设置
class BlacklistAction extends ACommonAction
{
    /**
    +----------------------------------------------------------
    * 默认操作
    +----------------------------------------------------------
    */
    public function index()
    {
        if($_POST['type'] == "zwdel"){
            $id = $_POST['id'];
           $result = M('blacklist')->where("id=$id")->delete();
           if($result){
               $data['status'] = 1;
           }else{
               $data['status'] = 0;
           }           
            echo json_encode($data);exit;
        }
        if(!empty($_POST['searchtel'])){
            $zwdata = M('blacklist')->where('telephone = '.trim($_POST['searchtel']))->select();
            $this->assign('backlist',$zwdata);
            $this->display();
            exit;
        }
//		//分页处理
                import("ORG.Util.Page");
                $total = M('blacklist')->count();
                $p = new Page($total,2);
                $page = $p->show();
                $Lsql = "{$p->firstRow},{$p->listRows}";
               
		$zwdata = M('blacklist')->order('id DESC')->limit($Lsql)->select();
                
                $this->assign('backlist',$zwdata);		
		$this->assign('page',$page);
                $this->display();
    }
	public function add(){
            
            if(isset($_POST['telephone']) && strlen($_POST['telephone'])==11){
                $zwdata['telephone'] = trim($_POST['telephone']);
                $zwdata['blackname'] = $_POST['name'];
                $result = M('blacklist')->add($zwdata);
                if($result){
                    echo "添加成功！";
                    exit;
                }else{
                    echo "添加失败";
                    exit;
                }
            }else{
                echo "请正确填写号码！";
            }
		 $this->display();
	}


}
?>