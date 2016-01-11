<?php
class agent{
	
	public function get_message($id){
		//进行数据抓取，可能需要抓取两次		
		$response = $this->socket('shanghai.anjuke.com', $id);
		$name = "";$phone = "";$shop = "";$diqu = "shanghai";
		$pattern = "/location:.*\/\/(.*)\//isU";//location: http://chengdu.anjuke.com/shop/view/1100000"
		$is_matched = preg_match_all($pattern,$response['header'],$matches);
		if($is_matched){
			$response = $this->socket($matches[1][0], $id);
			$diqu_array = explode('.',$matches[1][0]);
			$diqu = $diqu_array[0];
		}
		
		$gz_body = $this->gzdecode($response['body']);
		
		
		//进行正则匹配,有两套规则
		$pattern = "/<div\s+class=\"profile_content\">(.*)<\/dl>\s*<\/div>/isU";
		$is_matched = preg_match_all($pattern,$gz_body,$matches);
		if($is_matched){
			$pattern = "/<b>(.*)<\/b><span>.*([\dxaz]*)<\/span>.*<a.*>(.*)<\/a>/isU";
			$is_matched = preg_match_all($pattern, $matches[1][0], $matches2);
			if($is_matched){
				$name = trim($matches2[1][0]);
				$phone = trim($matches2[2][0]);
				$shop = $matches2[3][0]=='更多'?'':trim($matches2[3][0]);		
			}
		}
		
		$pattern = "/<div\s+class=\"profile_content\s+profile_spe\">(.*)<\/div>\s*<\/div>/isU";
		$is_matched = preg_match_all($pattern,$gz_body,$matches);
		if($is_matched){
			$pattern = "/<h4>(.*)<\/h4>.*<a.*>(.*)<\/a>.*<span>.*([\dxaz]*)<\/span>/isU";
			$is_matched = preg_match_all($pattern, $matches[1][0], $matches2);
			if($is_matched){
				$name = trim($matches2[1][0]);
				$shop = $matches2[2][0]=='向他提问'?'':trim($matches2[2][0]);
				$phone = trim($matches2[3][0]);		
			}
		}
		if($name=="" && $shop=="" &$phone=="")
			$result = "";
		else 
			$result = array("name"=>$name,"shop"=>$shop,"phone"=>$phone,"diqu"=>$diqu);
			
		return $result;				
	}
	
	function socket($host,$id){
		$socket = &core::Singleton('comm.remote.Socket');
		$msg = "GET /shop/view/$id HTTP/1.1
Accept:text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Encoding:gzip, deflate
Accept-Language:zh-CN,zh;q=0.8,en-US;q=0.5,en;q=0.3
Connection:keep-alive
Cookie:aQQ_ajkguid=AB96CA53-D062-0EB5-1ED0-08CBA5A3E796; lps=http%3A%2F%2Fshanghai.anjuke.com%2Fshop%2Fview
%2F1744936%7C; ctid=11; sessid=2A6D3042-6B75-1196-02F0-CD1E2E0267AB; twe=2
Host:$host
User-Agent:Mozilla/5.0 (Windows NT 6.1; rv:39.0) Gecko/20100101 Firefox/39.0\r\n";	
		$msg .= "\r\n";	
		$response = $socket->sendhttp($msg,$host,80);
		return $response;		
	}
	
	public function gzdecode ($data) {
		$flags = ord(substr($data, 3, 1));
		$headerlen = 10;
		$extralen = 0;
		$filenamelen = 0;
		if ($flags & 4) {
			$extralen = unpack('v' ,substr($data, 10, 2));
			$extralen = $extralen[1];
			$headerlen += 2 + $extralen;
		}
		if ($flags & 8) // Filename
			$headerlen = strpos($data, chr(0), $headerlen) + 1;
		if ($flags & 16) // Comment
			$headerlen = strpos($data, chr(0), $headerlen) + 1;
		if ($flags & 2) // CRC at end of file
			$headerlen += 2;
		$unpacked = @gzinflate(substr($data, $headerlen));
		if ($unpacked === FALSE)
			$unpacked = $data;
		return $unpacked;
	}









}