<?php

/*
 * Dsc: APP端申请借款
 * Author:zxm
 * Time:2015-8-10
 * * */

define('IS_APP', 'app');

class application_borrow {

    public $tbl = "lzh_application_borrow";

    public function setApplicationBorrow($data) {
        $db = core::db()->getConnect('CAILAI', true);
        $sql = sprintf('INSERT INTO `%s`(`user_phone`,`borrow_use`,`borrow_duration`,`borrow_money`) VALUES("%s","%s","%s","%s")', $this->tbl, $data['user_phone'], $data['borrow_use'], $data['borrow_duration'], $data['borrow_money']);
        $db->query($sql);
        return mysql_insert_id();
    }

}
