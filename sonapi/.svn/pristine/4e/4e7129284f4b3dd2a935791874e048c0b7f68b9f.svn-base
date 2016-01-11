<?php
class redpacket {

    public $active_redpacket = "lzh_active_redpacket";

    public function dealRed($redata) {
        $db = core::db()->getConnect('CAILAI', true);
        $redid=$redata['redid'];
        $borrow_id=$redata['borrow_id'];
        $usetime=$redata['usetime'];
        //$is_used=$redata['is_used'];
        $transamt=$redata['transamt'];
        $orderno=$redata['orderno'];
        file_put_contents('/tmp/zw2.txt',date('m-d H:i:s')."\$redarr ".print_r($redarr,true)."\n",FILE_APPEND);

        if(is_array($redid)){
          foreach ($redid as $key => $value) 
      {
        file_put_contents('/tmp/zw2.txt',date('m-d H:i:s')."\$redarr ".print_r($redid,true)."\n",FILE_APPEND);
        $sql = sprintf("update %s set borrow_id=%s,usetime=%s,transamt=%s,orderno=%s WHERE id = %s",$this->active_redpacket,$borrow_id,$usetime,$transamt,$orderno,$value);    
        $zw= $db->query($sql);
      }
        }
      
       return $zw;
    }

}
