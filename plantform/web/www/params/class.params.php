<?
class params extends urlparse {

	function params() {
		//模块注册
		array_push($this->actionList,'index');
		array_push($this->actionList,'huifu');
		array_push($this->actionList,'return');
		array_push($this->actionList,'notify');
		array_push($this->actionList,'app');
		array_push($this->actionList,'help');
	}

	function runFirst() {
		
	}
}
?>