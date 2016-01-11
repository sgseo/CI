<?php
// 全局设置
class RepaymentAction extends ACommonAction
{
    /**
    +----------------------------------------------------------
    * 默认操作
    +----------------------------------------------------------
    */
   public function index()
    {
		$map['borrow_status'] = 6;
		
		if($_GET['start_time']&&$_GET['end_time']){
			$_GET['start_time'] = strtotime($_GET['start_time']." 00:00:00");
			$_GET['end_time'] = strtotime($_GET['end_time']." 23:59:59");
			
			if($_GET['start_time']<$_GET['end_time']){
				$map['add_time']=array("between","{$_GET['start_time']},{$_GET['end_time']}");
				$search['start_time'] = $_GET['start_time'];
				$search['end_time'] = $_GET['end_time'];
			}
		}
		$map['status'] = 7;
		$list = getBorrowList($map,10);
		//echo "<pre>";print_r($list);echo "</pre>";exit;
		$this->assign('search',$search);
		$this->assign("list",$list['list']);
		$this->assign("pagebar",$list['page']);
        $this->display();
    }
	
	public function borrowdetail(){
		$pre = C('DB_PREFIX');
		$borrow_id = intval($_GET['id']);
		$list = getBorrowInvest($borrow_id,$this->uid);
		//echo "<pre>";print_r($list);echo "</pre>";exit;
		
		$this->assign("list",$list);
		$this->display();
    }

    public function repayment()
	{
		$borrowid = intval($_POST['bid']);
		$sort_order = intval($_POST['sort_order']);
		$type = 2;
		
		borrowRepayment($borrowid,$sort_order,$type);
    }
	
	public function unfreeze()
	{
		$borrowid = intval($_POST['bid']);
		$sort_order = intval($_POST['sort_order']);
		
		$borrowtrxid = M("borrow_info")->field("freezetrxid")->where("id=".$borrowid)->find();
		$freezetrxid = $borrowtrxid['freezetrxid'];
		$type = 2;
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$huifu->usrUnFreeze($freezetrxid,$borrowid,$sort_order,$type);
	}

}
?>