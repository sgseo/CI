<?php
/**
 * banner
 */

class dts_banner {

    public $tbl = 'tbl_banner';

	public function  get_banner($latest_time) {

		$db = core::db()->getConnect('DTS', true);
		$sql = sprintf("SELECT pic_url,`desc`,`link`,`need_update` FROM %s ",$this->tbl);
		$ret = $db->query($sql);
		while($row = $db->fetchArray($ret)){
			$data[] = $row ;	
		}
		return $data;
	}

	
}
?>