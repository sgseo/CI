<?php

class TestCronAction extends Action {

    function TestCronAction() {
    }
    public function index()
    {
    	file_put_contents('/tmp/debugCron',date('m-d H:i:s')." ".print_r("test Cron ok!",true)."\n",FILE_APPEND);
    }
}
?>