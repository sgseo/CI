<?php
    /**
    *  债权转让
    */
    class ZwbaoAction extends MCommonAction
    {
      
        public function index()
        {
           $this->display();
        }
		
	public function zwbzj(){     
                //$info = M("members")->field("usrid")->where("id=".$this->uid)->find();
		//$usrid = $info['usrid'];
		$transamt = $_POST['zw_money'];
		
		import("ORG.Huifu.Huifu");
		$huifu = new Huifu();
		$huifu->zwtransfer($transamt);
        }	
    
       
    }
?>
