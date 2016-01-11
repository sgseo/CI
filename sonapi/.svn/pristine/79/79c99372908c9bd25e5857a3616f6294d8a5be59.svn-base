<?php
/**
 * banner
 */

class banner_get extends api_comm  {

	/**
	 * 设置响应的消息体  返回值必须是json
	 * 
	 */
	public function get_response() {

		//传入的参数
		$latest_time      = $this->request_arr['latest_time'];
		//return array("11111111111");
		return $this->get_banner($latest_time);
	}
	
	public function get_banner($latest_time){
		
		$banner = core::Singleton('banner.dts_banner');
		return  $banner->get_banner($latest_time);
	}


}

?>