<?php

/**
projects/plantform/web/www/view/help/*
projects/plantform/web/www/action/class.act.help.php
projects/plantform/web/www/request/class.req.help.php
projects/plantform/web/www/params/class.params.php
 * Class act_help
 */
class act_help extends action
{
    /**
     *
     */
    public function runFirst() {
    	
    	
    }


    /**
     * 
     */
    public function _homeAct(){
    	
	}
	
	//http://plantformtest.cailai.com/help/detail?id=1
	public function _detailAct()
	{
		$id = ($_GET['id']);
		if($id){
			$tpl = 'help/'.$id.'.html';
		}
//		echo $tpl;
		$this->view->display($tpl);
		exit;
	}
}

?>