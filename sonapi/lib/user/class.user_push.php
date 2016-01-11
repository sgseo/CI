<?php

/*
 * Dsc: App push
 * Author:zxm
 * Time:2015-7-14
 * * */
define('IS_APP', 'app');

class user_push {

    public $tbl_device = "push_device";

    public function setUserChannelId($data) {
        $db = core::db()->getConnect('CAILAIPUSH', true);
        $_sql = sprintf('SELECT * FROM `%s` WHERE channel_id="%s"', $this->tbl_device, $data['channel_id']);
        //判断是否存在，已经存在则不存库；如果channel_id存在，member_id不同，则更新；
//        return $data;
        $row = $db->query($_sql, 2);
        if ($row['channel_id'] != $data['channel_id'] && $row['member_id'] != $data['member_id']) {
            $sql = sprintf('INSERT INTO `%s`(`member_id`,`member_phone`,`channel_id`,`is_app`,`device_type`) VALUES("%s","%s","%s","%s","%s")', $this->tbl_device, $data['member_id'], $data['member_phone'], $data['channel_id'], IS_APP, $data['device_type']);
            $db->query($sql);
            return mysql_insert_id();
        } else if ($row['channel_id'] == $data['channel_id'] && $row['member_id'] == $data['member_id']) {
            return "已经存在";
        } else if ($row['channel_id'] == $data['channel_id'] && $row['member_id'] != $data['member_id']) {
            $sql = sprintf("UPDATE %s SET member_id='%s',member_phone='%s' WHERE channel_id='%s'", $this->tbl_device, $data['member_id'], $data['member_phone'], $data['channel_id']);
            $db->query($sql);
            return "更新成功";
        };
    }

}
