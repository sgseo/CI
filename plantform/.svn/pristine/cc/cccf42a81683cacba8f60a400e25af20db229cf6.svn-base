<?php
/**
 * app下载
 * @author whh
 *
 */
class act_app extends action
{
	
    public function runFirst() {
		$uagent_obj = core::Singleton('comm.helper.uagent_info');
		$mobile_client="http://a.app.qq.com/o/simple.jsp?pkgname=com.cailai.app";
		$pc_client="http://www.cailai.com/borrow/app.html";
		if ($uagent_obj->DetectMobileQuick() == $uagent_obj->true ){
				
			header ('Location: '.$mobile_client);
		}else{
			header ('Location: '.$pc_client);
		}
		exit;
    }

	public function _homeAct(){

	}

}

?>
