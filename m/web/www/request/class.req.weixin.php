<?php

class req_weixin extends request {
	function req_weixin() {
		$this->doAttr[] = 'home';
		$this->doAttr[] = 'token';
        $this->doAttr[] = 'yanzheng';
		$this->doAttr[] = 'menu';
		$this->doAttr[] = 'test';
		$this->doAttr[]='weixin';
		$this->doAttr[] = 'accesstoken';
	}
}