<?php

class req_index extends request {
	function req_index() {
		$this->doAttr[] = 'home';
        $this->doAttr[] = 'more';
        $this->doAttr[] = 'know';
		$this->doAttr[] = 'test';
        $this->doAttr[]='register';
        $this->doAttr[]='uinfo';
        $this->doAttr[]='banner';
        $this->doAttr[]='vcode';
        $this->doAttr[]='findpwd';
	}
}