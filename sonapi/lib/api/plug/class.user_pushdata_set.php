<?php

/*
 * Dsc:Set Push Data
 * Author:zxm
 * Time:2015-7-14
 * * */

class user_pushdata_set extends api_comm {

    /**
     * 设置响应的消息体  返回值必须是json
     * 
     */
    public function get_response() {

        //解析出来的登录用户信息
        $userId = $this->comm_user_infor['id'];	
        $channelId = $this->request_arr['channelId'];
        $data = $this->setUserChannelId($userId, $channelId);
        return $data;
    }

    public function setUserChannelId($userId, $channelId) {
        $user = core::Singleton('user.user_push');
        $result = $user->setUserChannelId($userId, $channelId);
        unset($user);
        if ($result) {
            return $result;
        } else {
            return false;
        }
    }

}
