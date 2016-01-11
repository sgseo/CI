<?php

/**
 * Class act_index
 */
class act_index extends action
{
    /**
     *
     */
    public function runFirst() {
    	
    	
    }


    /**
     * 
     */
    public function _homeAct(){
    	
	}
	
	public function _testAct()
	{
		
		/*
		//实名认证测试
		$url = "http://huifutest.cailai.com/index.php";
		$content = file_get_contents($url);
		$c = json_decode($content,true);
		$data = $c['data'];
		*/
		/*
		$data['Version'] = '10';
		$data['CmdId'] = 'UserRegister';
		$data['MerCustId'] = '6000060000758826';
		$data['BgRetUrl'] = 'http://plantformtest.cailai.com/notify/';
		$data['RetUrl'] = 'http://plantformtest.cailai.com/return/';
		$data['UsrId'] = '13818164082';
		$data['UsrName'] = '';
		$data['IdType'] = '';
		$data['IdNo'] = '';
		$data['UsrMp'] = '13818181818';
		$data['UsrEmail'] = 'hellowhh@163.com';
		$data['MerPriv'] = '';
		$data['CharSet'] = '';
		$data['ChkValue'] = '1C10A6FF667BA9648E210336AD957BAD1EC1286F04E639D1D7B44D8E8977C18DF57C010F04536E95D312FA1BECC37FC7B89B1A8170E30EEB9BD521E514F04866D19E1473B9A45E7884DD1708D936CC2ED269570F501AA2F412F4D64DEB18895781A718795FE3AE392CFE11D3570BB7547D037351DCCACD1D0A77639AEC11A185';
		*/
		
		autoRedirect($data);
		exit;
	}
}



function autoRedirect($reqData){//echo "<pre>";print_r($reqData);echo "</pre>";exit;
	$tmp = array();
	$html= <<<HTML
<html><head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<head><body onload="document.getElementById('autoRedirectForm').submit();">
<div class="margin:10px;font-size:14px;">正在跳转...</div>
<form id="autoRedirectForm" method="POST" action="http://mertest.chinapnr.com/muser/publicRequests">
HTML;
	foreach($reqData as $key => $value){
		$html.='<input type="hidden" value=\''.$value.'\' name="'.$key.'" />';
		$tmp[$key] = $value;
	}
	$html.="</form>";
	$html.="</body></html>";
	//file_put_contents('/tmp/autoRedirect',date('m-d H:i:s')."autoRedirect ".print_r($autoRedirect,true)."\n",FILE_APPEND);
	file_put_contents('/tmp/autoRedirect',date('m-d H:i:s')."autoRedirect ".print_r($tmp,true)."\n",FILE_APPEND);
	print $html;
	exit;
}
?>