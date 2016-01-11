<?php

class req_user extends request {
	function req_user() {
		$this->doAttr[] = 'login';
        $this->doAttr[]='isreg';
        $this->doAttr[]='quit';
        $this->doAttr[]='info';
	}
}