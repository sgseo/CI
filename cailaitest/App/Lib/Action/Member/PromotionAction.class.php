<?php
// 本类由系统自动生成，仅供测试用途
class PromotionAction extends MCommonAction {

    public function index(){
        
		$this->display();
    }

    public function promotion(){
		 $_P_fee=get_global_setting();
		 Vendor('Qrcode.phpqrcode');
		 //判断是否有二维码 有就不用在二次生成了
		// $icon='http://my.cailai.com/Style/H/images/erwei/qrcodeicon'.$this->uid.'.png';
		$icon=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'].'/Style/H/images/erwei/qrcodeicon'.$this->uid.'.png';
		// dump($icon);
		 $is_exists=get_headers($icon);
		 //dump($is_exists);
		 if($is_exists[0]!='HTTP/1.1 200 OK')
		 {
			 //设置二维码的内容 查询电话号码
			 $res=M('members')->getFieldById($this->uid,'user_name');

			 $value="http://m.cailai.com/index/register?p=".$res;
			 $pos='Style/H/images/erwei/qrcode'.$this->uid.'.png';
			 //dump(get_headers($pos));
			 $errorCorrectionLevel = 'L';//容错级别   
			 $matrixPointSize = 6;//生成图片大小   
			//生成二维码图片   
			 QRcode::png($value, $pos, $errorCorrectionLevel, $matrixPointSize, 2);   
			 $logo ='Style/H/img/cutlogo.png';//准备好的logo图片   
			 $QR = $pos;//已经生成的原始二维码图   

			 if ($logo) {  
			    $QR = imagecreatefromstring(file_get_contents($QR));   
			    $logo = imagecreatefromstring(file_get_contents($logo));   
			    $QR_width = imagesx($QR);//二维码图片宽度   
			    $QR_height = imagesy($QR);//二维码图片高度   
			    $logo_width = imagesx($logo);//logo图片宽度   
			    $logo_height = imagesy($logo);//logo图片高度   
			    $logo_qr_width = $QR_width / 5;   
			    $scale = $logo_width/$logo_qr_width;   
			    $logo_qr_height = $logo_height/$scale;   
			    $from_width = ($QR_width - $logo_qr_width) / 2;   
			    //重新组合图片并调整大小   
			    imagecopyresampled($QR, $logo, $from_width, $from_width, 0, 0, $logo_qr_width, $logo_qr_height,$logo_width, $logo_height); //$logo_qr_width, $logo_qr_height,   
			    //bool imagecopyresampled ( resource $dst_image , resource $src_image , int $dst_x , int $dst_y , int $src_x , int $src_y , int $dst_w , int $dst_h , int $src_w , int $src_h )
			}   
			//输出图片   
			$newicon="Style/H/images/erwei/qrcodeicon".$this->uid.'.png';
			imagepng($QR, $newicon); 
		 }//exists 结束
		  $this->myid=($this->uid);
		 $this->assign("reward",$_P_fee);	
		 $this->display();
    }

    public function promotionlog(){
		$map['uid'] = $this->uid;
		$map['type'] = array("in","1,13");
		$list = getMoneyLog($map,15);
		
		$totalR = M('member_moneylog')->where("uid={$this->uid} AND type in(1,13)")->sum('affect_money');
		$this->assign("totalR",$totalR);		
		$this->assign("CR",M('members')->getFieldById($this->uid,'reward_money'));		
		$this->assign("list",$list['list']);		
		$this->assign("pagebar",$list['page']);		

		$data['html'] = $this->fetch();
		exit(json_encode($data));
    }

	public function promotionfriend(){
		$pre = C('DB_PREFIX');
		$uid=session('u_id');
		$field = " m.id,m.user_name,m.reg_time,sum(ml.affect_money) jiangli ";
		$field1 = " m.id,m.user_name,m.reg_time";
		$vm = M("members m")->field($field)->join(" lzh_member_moneylog ml ON m.id = ml.target_uid ")->where(" m.recommend_id ={$uid} AND ml.type =13")->group("ml.target_uid")->select();
//                file_put_contents('/tmp/moneylog',date('m-d H:i:s')." back : ".print_r(M("members m")->getLastSql(),true)."\n",FILE_APPEND);
		$vm1 = M("members m")->field($field1)->where(" m.recommend_id ={$uid}")->group("m.id")->select();


		if(is_array($vm)){
			foreach($vm as $key => $val) {
				$temp = M("member_info")->field('real_name')->where(" uid ={$val[id]}")->limit(1)->select();
				$vm[$key]['real_name'] = $temp[0]['real_name'];
				unset($temp);
			}
		}
		if(is_array($vm1)){
			foreach($vm1 as $key1 => $val1) {
				$temp = M("member_info")->field('real_name')->where(" uid ={$val1[id]}")->limit(1)->select();
				$vm1[$key1]['real_name'] = $temp[0]['real_name'];
				unset($temp);
			}
		}
//file_put_contents('/tmp/frind',date('m-d H:i:s')." vm ".print_r($vm,true)."\n",FILE_APPEND);
//file_put_contents('/tmp/frind',date('m-d H:i:s')." vm1 ".print_r($vm1,true)."\n",FILE_APPEND);
		$this->assign("vm",$vm);	
		$this->assign("vm1",$vm1);
		$data['html'] = $this->fetch();
		exit(json_encode($data));
    }


    //我的现金券
    public function myticket()
    {
  			//分页处理
		import("ORG.Util.Page");
		$uid=$this->uid;
		$count = M('active_redpacket')->where('owner='.$uid)->count('id');
		$p = new Page($count, 10);
		$page = $p->show();
		$Lsql = "{$p->firstRow},{$p->listRows}";
		//分页处理
       	$redlist=M("active_redpacket")->where('owner='.$uid)->limit($Lsql)->order('is_success asc,shelftime asc,addtime asc')->select();

    	$this->redlist=$redlist;

    	//红包注释
    	$redtip=array('注册送红包','实名认证');

    	$this->redtip=$redtip;

    	$this->page=$page;

    	$this->display();
    }
}