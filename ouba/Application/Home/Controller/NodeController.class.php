<?php
namespace Home\Controller;
use Think\Controller;
 header("content-type:text/html;charset=utf8");
 class NodeController extends Controller
 {
	public $partner_name;
	public $secret_key;
	public $url;

  //  public function _initialize()
  //  {
	 // $this->partner_name=C(PNAME);
	 // $this->secret_key=C(SECRET_KEY);
	 // $this->url = C(API_URL);
  //  }

		//显示标的抵押物信息jbox块2015-11-02 lj
	public function impawn()
	{
		$id=I('get.id',0);
		$list=M('house as h')->field('h.category,h.carbrand,h.cartype,h.carestimate,h.carbuytime,h.address,h.iscity,h.pledge,oh.housetype,h.estimateprice,h.area,h.price,h.residence')
		     ->join('onethink_housetype as oh on h.housetype=oh.id','left')
		     ->where('h.id='.$id)->find();
		   if($list['iscity']==1)
		   {
		   	$list['iscity']='否';
		   }else{
		   	$list['iscity']='是';
		   }
		   if($list['pledge']==1)
		   {
		   	$list['pledge']="清房";
		   }else if($list['pledge']==2)
		   {
		   	$list['pledge']="一抵";
		   }else{
		   	$list['pledge']='按揭';
		   }

		if($list['category']=='car')
		{
		$html="<table border='1px'><tr><td>车品牌</td><td>车类型</td><td>车估价(元)</td><td>车购买时间</td></tr>";
		$html.="<tr><td>".$list['carbrand']."</td><td>".$list['cartype']."</td><td>".$list['carestimate']."</td><td>".date('Ymd',$list['carbuytime'])."</td></tr></table>";
		}else if($list['category']=='fang'){
		$html="<table border='1px'><tr><td>房屋地址</td><td>是否主城区</td><td>抵押情况</td><td>房屋面积（平米）</td><td>房屋市场价(元)</td><td>房屋评估价(元)</td><td>房屋类型</td><td>房屋户口</td></tr>";
		$html.="<tr><td>".$list['address']."</td><td>".$list['iscity']."</td><td>".$list['pledge']."</td>
				<td>".$list['area']."</td><td>".$list['price']."</td><td>".$list['estimateprice']."</td><td>".$list['housetype']."<td>".$list['residence']."</td></tr></table>";
		}else{
			$html='暂无数据';
		}
		echo $html;
	}

 	/*
		登录者个人资产统计 api 接口 
		time:20150706
	*/

	public function index()
	{	
		$User = M('house'); // 实例化User对象
 		$cstname=I('post.cstname',0);
 		if($cstname)
		{
			$list=$User->where('cstname='."'".$cstname)->select();
			$this->list=$list;
			$this->show();
			return;
		}
		$count      = $User->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,10);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $User->order('add_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->display(); // 输出模板

	}
	/**
	 * 2015-11-03 操作日志 showlog @author lj
	 */
	public function showlog()
	{
	  $id=I('get.id',0);
	  $count=M('dts as d')->join('onethink_house as h on d.opthatid=h.id')->where("d.optbname='house' and d.opthatid=".$id)->count();
	  $Page= new \Think\Page($count,10);
	  $show=$Page->show();
	  $list=M('dts as d')
		  ->field("d.*,h.id as hid,h.title,oum.id as oumid,oum.username")
		  ->join('onethink_house as h on d.opthatid=h.id')
		  ->join('onethink_ucenter_member as oum on d.oprespid=oum.id','left')
		  ->where("d.opthatid=".$id)
		  ->order('d.optime desc')
		  ->limit($Page->firstRow.','.$Page->listRows)->select();

	  $this->page=$show;
	  $this->list=$list;
	  //标的信息
	  $hlist=M('house as h')->field("h.*,o.organization as source,oi.organization as capitalsource,oum.username")
	         ->join('onethink_organization as o on h.source=o.id','left')
	         ->join('onethink_organization as oi on h.capitalsource=oi.id','left')
	         ->join('onethink_housetype as oh on h.housetype=oh.id','left')
	         ->join('onethink_ucenter_member as oum on h.respid=oum.id','left')
	         ->where('h.id='.$id)->find();
	         // echo M()->_sql();
	  $this->hlist=$hlist;
	  // dump($hlist);
	  //图片
	  $plist2=M('picture')
	         ->alias('p')
	         ->field('p.*,otp.newclass')
	  		 ->join('onethink_temp_picture as otp on p.newpictype=otp.id')
	  		 ->where('p.pid='.$id.' and p.status!=1')
	         ->order('p.create_time desc,p.newpictype')
		     ->select();
	  $cp2=count($plist2);

	  $pcount=M('picture')
	         ->alias('p')
	         ->field('p.*,ofc.id as ofcid,ofc.class_name')
	  		 ->join('onethink_file_class as ofc on p.file_class_id=ofc.id')
	  		 ->where('p.pid='.$id.' and p.status!=1')->count();
	  $pcount=$cp2+$pcount;
	  $plist=M('picture')
	         ->alias('p')
	         ->field('p.*,ofc.id as ofcid,ofc.class_name')
	  		 ->join('onethink_file_class as ofc on p.file_class_id=ofc.id')
	  		 ->where('p.pid='.$id.' and p.status!=1')
	         ->order('p.create_time desc,p.file_class_id')
		     ->select();
	
	$plist=array_merge($plist,$plist2);
	  // die;
	//外围高度为总张数*图片高度
	  $pcount=$pcount<3?3:$pcount;
	  $pheight=ceil($pcount/3)*360;//
	  $this->pheight=$pheight;
	  $this->plist=$plist;

	  $totaltimes=$hlist['totaltimes'];//次标的的放款总次数
	  //还款计划

	  $rplist=M('repayplan as rp')
	         ->field("rp.*,p.id as pid,p.path")
	         ->join('onethink_picture as p on rp.hid=p.pid and rp.cursort=p.sort','left')
	         ->where('rp.hid='.$id)
	         ->order("rp.id")
	         ->select();

	  $this->rplist=$rplist;
	  $this->display();

	}
 	/*
 	投资记录
 	time:20150717
 	by lj
 	*/
 	public function invest_record()
 	{
 		import("Vendor.PhpExcel.PHPExcel");

 		$objPHPExcel = new \PhpExcel();

 		$list=session('bidlist');

		$list=array_splice($list,2);

		$row=array();

		$row[0]=array('借款标号','借款名称','借款人姓名','投资金额','已还本息','年利率','总共期限','已经期数','下一还款时间');
	
		$objPHPExcel->setActiveSheetIndex(0);
		//头部
			foreach ($row[0] as $key => $value) 
			{
				$cwr=chr(65+$key).'1';
				$objPHPExcel->getActiveSheet()->SetCellValue($cwr, $value);
			}

			foreach ($list['data'] as $key => $value)
			{
					$arr[$key][]=$value['bid'];
					$arr[$key][]=$value['bname'];
					$arr[$key][]=$value['borrow_uname'];
					$arr[$key][]=$value['invest_money'];
					$arr[$key][]=$value['repayment_money'];
					$arr[$key][]=$value['borrow_interest_rate'];
					$arr[$key][]=$value['total_periods'];
					$arr[$key][]=$value['payed_periods'];
					$arr[$key][]=$value['next_pay_date'];
			}
		
		$total = count($arr);	

		$cr = count($arr['0']);//获取每个数组有几个元素用来控制列

		for($i=0;$i<=$cr;$i++)
		{
			$cwr2=chr(64+$i+1);
			for($j=2;$j<=$total+2;$j++)
			{
				$cwr=$cwr2.$j;//abcdefg
				$objPHPExcel->getActiveSheet()->SetCellValue($cwr,$arr[$j-2][$i]);
			}
		}
		$objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
		
		$objWriter->save(str_replace('.php', '.xls', __FILE__));
		
		$filename='投资记录.xls';

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
		header("Content-Type:application/force-download");
		header("Content-Type:application/vnd.ms-execl");
		header("Content-Type:application/octet-stream");
		header("Content-Type:application/download");
		header("Content-Disposition:attachment;filename=".$filename);
		header("Content-Transfer-Encoding:binary");
		$objWriter->save("php://output");

 	}
 	/*
 	机构管理-编辑
 	time:20150707
 	by lj
 	*/
 	public function deal_record()
 	{
 		import("Vendor.PhpExcel.PHPExcel");

 		$objPHPExcel = new \PhpExcel();

 		$list=session('deallist');

		$list=array_splice($list,2);

		//echo P;var_dump($list);die;

		$row=array();

		$row[0]=array('交易时间','交易类型','影响金额','代收金额','说明','可用金额');
	
		$objPHPExcel->setActiveSheetIndex(0);
		//头部
			foreach ($row[0] as $key => $value) 
			{
				$cwr=chr(65+$key).'1';
				$objPHPExcel->getActiveSheet()->SetCellValue($cwr, $value);
			}

			foreach ($list['data'] as $key => $value) {
					$arr[$key][]=$value['date'];
					$arr[$key][]=$value['type'];
					$arr[$key][]=$value['affect_money'];
					$arr[$key][]=$value['collect_money'];
					$arr[$key][]=$value['desc'];
					$arr[$key][]=$value['account_money'];
			
			}
		
		$total = count($arr);	

		$cr = count($arr['0']);//获取每个数组有几个元素用来控制列

		for($i=0;$i<=$cr;$i++)
		{
			$cwr2=chr(64+$i+1);
			for($j=2;$j<=$total+2;$j++)
			{
				$cwr=$cwr2.$j;//abcdefg
				$objPHPExcel->getActiveSheet()->SetCellValue($cwr,$arr[$j-2][$i]);
			}
		}
		$objWriter = new \PHPExcel_Writer_Excel5($objPHPExcel);
		
		$objWriter->save(str_replace('.php', '.xls', __FILE__));
		
		$filename='交易记录.xls';

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
		header("Content-Type:application/force-download");
		header("Content-Type:application/vnd.ms-execl");
		header("Content-Type:application/octet-stream");
		header("Content-Type:application/download");
		header("Content-Disposition:attachment;filename=".$filename);
		header("Content-Transfer-Encoding:binary");
		$objWriter->save("php://output");

 	}
 	/**
 	 * 财务审批展示--20151015
 	 */
 	public function confirm()
 	{
 		$house=M('house as h');
 		$cstname=I('post.cstname');
 		$condition['h.status']=array(in,array('6','9','10'));//5为完成
 		if($cstname)
 		{
		$condition['h.cstname']=array('like','%'.$cstname.'%');
		}
		$this->empty='<td style="color:red">没有相应数据</td>';
		//分页
		$count      = $house->where($condition)->count();// 查询满足要求的总记录数
		// echo $count;
		$Page       = new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $house->field('h.*,os.id as oid,os.status as ostatus')->join('onethink_status as os on h.status=os.id','left')->where($condition)->order('h.add_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->display();
 	}

 	/**
 	 * 处理贷款--依据凭证
 	 */
 	public function loan()
 	{
 		$list=M('organization')->select();
 		$plist=M('ucenter_member')->where('status=8 or part_time=8')->select();
 		$blist=M('member_info')->where("type='bridge'")->select();
 		$elist=M('ucenter_member')->where('authority=1 or authority=12')->select();
 		$flist=M('ucenter_member')->where('authority=12')->select();
 		$htlist=M('housetype')->select();//房屋类型
 		$pllist=M('pcondition')->where('pandl=1')->select();//抵押类型
 		$pllist2=M('pcondition')->where('pandl=2')->select();//2为消费用途
 		
 		$this->plist=$plist;
		$this->list=$list;
		$this->blist=$blist;
		$this->elist=$elist;
		$this->flist=$flist;
		$this->htlist=$htlist;
		$this->pllist=$pllist;
		$this->pllist2=$pllist2;
		$this->data=$data;

		// $this->return=$this->returndata;//定义属性


 		$id=I('get.id');
 		$returndata=M('house')->find($id);
 		$riskearly=M('ucenter_member')->where('id='.$returndata['riskearly'])->find();
 		$returndata['username']=$riskearly['username'];
 		// dump($returndata);
 		foreach ($returndata as $key => $value) {
 			if($value)
 			{
 	 			$return[$key]=$value;
 			}
			
 		}
 		foreach ($return as $key => $value) {
 			if($value=='0.00')
 			{
 				unset($return[$key]);
 			}
 		}
 		$this->returndata=$return;
		// $house=M('house');
		$time=date('Y-m-d');
		$this->time=$time;
		// $list=$house->field('id,title,duration,rate,borrowamt,cstname,idno')->find($id);
		// $this->list=$list;
		//dump($list);
		$this->display();
 	}


 		/**
 	 * 处理贷款--依据凭证--入库
 	 *
 	 */
 	public function loanadd()
 	{
 		if(!I('post.loantime')){
 			$this->error('具体放款时间必须录入');
 		}
 		$house=M('house');
		$data=array();
		$id=I('post.id');
		$loanamt=str_replace(',','',I('post.loanamt'));
		$data['loantime']=strtotime(I('post.loantime'));
		$data['confirmer']=session('username');
		//图片插入
		if($_FILES['proof']['error']!=4)
		{
		$pictype='proof';
		$res=A('Menu')->propic($id,$pictype);
		//$house->where()->save();
		foreach ($res as $key => $value) {
	 		$pdata['path']=$value;//去掉. (./upload)前面的点
	 		$pdata['pictype']=$pictype;//
	 		$pdata['create_time']=time();
	 		$pdata['pid']=$id;
	 		$pdata['status']=0;
	 		//为了app 删除pc端上传的图片
 		    $dotpos=strpos($pdata['path'],".");//点的位置
            $itapos=strrpos($pdata['path'],"/")+1;//“/”最后一次出现的位置
            $pdata['file_name']=substr($pdata['path'],$itapos,$dotpos-$itapos);//
            
	 		$pdata['file_class_id']=14;//打款凭证
	 		$pic=M('picture')->add($pdata);
			}
		}
			//插入还款计划表并计算分期 11-05
			$data['rate']=I('post.rate');
			$data['duration']=I('post.duration');

			$lbamt=$house->field('loanamt,borrowamt')->find($id);

			$data['loanamt']=$loanamt+$lbamt['loanamt'];//加上之前有过放款的部分如果没有$lbamt['loanamt']则为零
			if($data['loanamt']<=$lbamt['borrowamt'])
			{
				$done=$house->where('id='.$id)->save($data);//修改house表的loanamt
			}else{
				$this->error('总共放款的总额不应超过借款总额');
				// return ;
			}
			$newloanamt=str_replace(',','',I('post.loanamt'));
		if($done!==false)
		{
			$rpdata['totalsort']=$data['duration']+1;//一共多少期
		
			$rpdata['shouldrepay']=($newloanamt*($data['rate']/100));//一期应该还多少
			$rpdata['hid']=$id;
			$lbamt2=$house->field('loanamt,borrowamt')->find($id);//第二次查询
			//解决多次放款 2015-12-17@lj
			if($lbamt2['loanamt']==$lbamt2['borrowamt'])//如果一次性还清了 
			{
				// echo "我日最后一笔";
				//已放款   那么状态就改为已经放款完毕 
				$lastci=M('repayplan')->field('nci')->where('hid='.$id)->order('shouldtime desc')->find();
				if($lastci['nci']!=1)
				{
					$lastci['nci']=$lastci['nci']+1;//为了区分最后一次和第一次
					// $hdata['totaltimes']=$lastci['nci'];
					// $hdata['totaltimes']=$lastci['nci'];
				}
					$rpdata['nci']=$lastci['nci'];
					
					$hdata['status']=6;
					M('house')->where('id='.$id)->save($hdata);
				for($i=1;$i<=$data['duration']+1;$i++)
				{
					$n=$i-1;
					$rpdata['shouldtime']=strtotime("+$n months",$data['loantime']);
					$rpdata['shouldtime']=date('Y-m-d',$rpdata['shouldtime']);
					$rpdata['cursort']=$i;
					// echo $i;
					if($i==$data['duration']+1)
					{
						$rpdata['shouldrepay']=$newloanamt;
					}
				M('repayplan')->add($rpdata);//生成一次还款计划
				// echo "w r".M()->_sql();
				}
			}else if($newloanamt>0 && $newloanamt<($lbamt2['borrowamt']-$lbamt2['loanamt']))
			{  //输入金额不足借款金额
			
				//并且与前几次放款总和不超过借款总额
				if($lbamt2['loanamt']<$lbamt2['borrowamt'])
				{
					//上一次放款是第几次
					//修改最新状态
					$leatest['status']=10;//部分放款
					M('house')->where('id='.$id)->save($leatest);//标记为部分放款

					$lastci=M('repayplan')->field('nci')->where('hid='.$id)->order('shouldtime desc')->find();
					
					$rpdata['nci']=$lastci['nci']+1;//上一次加一次就是这一次
					$hdata['totaltimes']=$lastci['nci'];
					M('house')->where('id='.$id)->save($hdata);//把每一次的总次数改为当前第几次放款
					for($i=1;$i<=$data['duration']+1;$i++)
					{
						$n=$i-1;
						$rpdata['shouldtime']=strtotime("+$n months",$data['loantime']);
						$rpdata['shouldtime']=date('Y-m-d',$rpdata['shouldtime']);
						$rpdata['cursort']=$i;

						// echo $i;
						if($i==$data['duration']+1)
						{
							$rpdata['shouldrepay']=$newloanamt;
						}
					    M('repayplan')->add($rpdata);
					    // echo "这是第".$rpdata['nci']."次".M()->_sql();
					}
				}
			}//除第一次以外插入完成
		//行为日志

			//操作日志
			$op=array();
			$op['opname']=session('username');
			$op['optime']=time();
			$op['opdata']=serialize($data);
			$op['opip']=ip2long($_SERVER['REMOTE_ADDR']);
			$op['optip']=$op['opname']."给项目id为：".$id."放款";
			$op['optbname']='house';
			$op['opthatid']=$id;
			M('dts')->add($op);
			$url=U('Node/confirm');
 			$this->success('提交成功',$url);
 		}else{
 			$this->error('提交失败');
 		}
 	}

 	public function phpinfo()
 	{
 		echo phpinfo();
 	}


 	//测试修改loanamt
 	public function testamt()
 	{
 		$res=M('house')->field("id,borrowamt")->where('loanamt=999999.99')->select();
 		foreach ($res as $key => $value) {
			
			// $data['id']=$value['id'];
			$data['loanamt']=$value['borrowamt'];
			M("house")->where("id=".$value['id'])->save($data);

	 		}
 	}

 	public function add()
 	{
 		dump($_FILES);
 		var_dump($_POST);
 		$this->display();
 		// git@github.com:GStepOne/firstmy.git
 	}


 	/**
 	 * 
 	 */

 }//eof class node