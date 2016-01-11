<?php

class req_consumer extends request {
	function req_consumer() {
		$this->doAttr[] = 'attestation';
        $this->doAttr[] = 'personmoney';
        $this->doAttr[] = 'changePwd';
        $this->doAttr[] = 'recharge';
        $this->doAttr[]='withdrawals';
         $this->doAttr[]='ubank';
         $this->doAttr[]='dealhisory';
         $this->doAttr[]='recommend';
         $this->doAttr[]='borrowpaying';
         $this->doAttr[]='tendbacking';
         $this->doAttr[]='tending';
         $this->doAttr[]='bindcard';
         $this->doAttr[]='buy';
	}
}