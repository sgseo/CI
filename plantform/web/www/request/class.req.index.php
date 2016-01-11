<?php

class req_index extends request {
	function req_index() {
		$this->doAttr[] = 'home';
		$this->doAttr[] = 'test';
	}
}