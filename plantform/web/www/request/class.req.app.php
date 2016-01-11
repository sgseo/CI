<?php

class req_app extends request {
	function req_notify() {
		$this->doAttr[] = 'home';
	}
}