<?php
namespace Home\Controller;
use Think\Controller;
 header("content-type:text/html;charset=utf8");
 class RoleController extends Controller
 {
   public $salt;
   public $surl;
   public $partner_name;
   public $secret_key;
   public function _initialize()
   {
	 $this->salt=C(SALT);
	 $this->surl=C(SURL);
	 $this->partner_name=C(PNAME);
	 $this->secret_key=C(SECRET_KEY);
   }
 	/*
	*/
	public function index(){
		$list=M('organization')->select();
		$this->list=$list;
		$this->show();
	}

	/**
	 * 机构列表
	 */
	public function indexlist()
	{
		$username=I('post.username');
		if($username)
		{
			$list=M('ucenter_member')->alias('um')->field('um.*,ou.status as ocstatus')->join('onethink_ucstatus as ou on um.status=ou.id','left')->
			where('username like '."'%".$username."%'")->select();
			$this->list=$list;
			$this->display();
			return;
		}
		$count=M('ucenter_member')->alias('um')->field('um.*,ou.status as ocstatus')->join('onethink_ucstatus as ou on um.status=ou.id','left')->count();
		$page=new \Think\Page($count,30);
		$show=$page->show();
		$list=M('ucenter_member')->alias('um')
		->field('um.*,ou.status as ocstatus')
		->join('onethink_ucstatus as ou on um.status=ou.id','left')
		->limit($page->firstRow.','.$page->listRows)
		->select();
		$this->list=$list;
		$this->page=$show;
		$this->display();
	}

	//添加会员
	public function add()
	{
		$um=M('ucenter_member');
		$data=$um->create();
	 foreach (@$_FILES as $key => $value) {
        	if($value['error']!=4)
        	{
        		$class[]=$key;
        	}
        }
       $res=A('menu')->propic();
       foreach ($class as $key => $value) {
       		$data[$value]=$res[$key];
       }
		$pwd=md5(sha1(I('post.pwd').$this->salt));
		$data['reg_time']=time();
		$data['reg_ip']=ip2long($_SERVER['REMOTE_ADDR']);
		$data['pwd']=$pwd;
		$hasthis=$um->getFieldByUsername($username,'id');
		if(!$hasthis)
		{
			$added=$um->add($data);
			if($added)
			{
			$op=array();
			$op['opname']=session('username');
			$op['optime']=time();
			$op['opdata']=serialize($data);
			$op['opip']=$data['reg_ip'];
			$op['optip']=$op['opname']."添加了一个角色id为".$added;
			$op['optbname']='ucenter_member';
			$op['opthatid']=$added;
			M('dts')->add($op);
			$this->success('成员已经添加成功');
			}
		}else{
			$this->error('嘿嘿，此用户名已经存在');
		}

	}

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

	
	
	public function remember()
	{	

		$this->show();
	}//eof rem



	public function messagesend()
	{
		$time=strtotime(date('Y-m-d 00:00:00'));//今天开始的时候
		$threedayslater=strtotime("+3 days",$time);//三天后的这个时候
		$daythree=date("Y-m-d",$threedayslater);
		$res=M('repayplan')
		->alias('as oe')
		->field('oe.id,oe.hid,UNIX_TIMESTAMP(oe.shouldtime) as shouldtime,oe.shouldrepay,h.tel,h.cstname,oum.username,oum.mobile')
		->join('onethink_house as h on oe.hid=h.id','left')
		->join('onethink_ucenter_member as oum on h.respid=oum.id','left')
		->where("UNIX_TIMESTAMP(oe.shouldtime)=".$threedayslater." and h.source!=2 and oe.realrepay=0")
		->select();
		foreach ($res as $key => $value) 
		{	
		   $mobile=$value['mobile'];//手机号码
		   // echo $mobile;
		   $content="亲爱的财来网同事:".$value['username']."，你有个客户".$value['cstname']."电话(".$value['tel'].")"."，在财来网的借款将在3天后".$daythree.'号有一笔还款,金额为'.$value['shouldrepay'].'请及时催收。';
		   dump($this->sendsms($mobile,$content));
		   $this->sendsms("13186871846",$content);
		   echo "如果出现1代表已经成功"."</br>";
		}

		$zzx=M('repayplan')
		->alias('as oe')
		->field('oe.id,oe.hid,UNIX_TIMESTAMP(oe.shouldtime) as shouldtime,oe.shouldrepay,h.tel,h.cstname,oum.username,oum.mobile')
		->join('onethink_house as h on oe.hid=h.id','left')
		->join('onethink_ucenter_member as oum on h.respid=oum.id','left')
		->where("UNIX_TIMESTAMP(oe.shouldtime)=".$threedayslater." and h.source=2 and oe.realrepay=0")
		->select();
		foreach ($zzx as $key => $value) 
		{	
		    $mobile='13306709388';//手机号码
		   // echo $mobile;
		   $content="亲爱的财来网同事:周子祥，你有个客户".$value['cstname']."电话(".$value['tel'].")"."，在财来网的借款将在3天后".$daythree.'号有一笔还款,金额为'.$value['shouldrepay'].'请及时催收。';
		   dump($this->sendsms($mobile,$content));
		   $this->sendsms("13186871846",$content);
		   echo "如果出现1代表已经成功"."</br>";
		}


	}



	/**
	 * 发送短信提醒
	 */
	public function sendsms($mobile,$content)
	{
        $surl=$this->surl;;

       	$data['secret_key']=$this->secret_key;

  		$data['pname'] = $this->partner_name;

  		$data['mobile']=$mobile;

  		$data['content']= $content;

  		//模拟post 请求
	    $ch = curl_init() ;  
	  	$fields = $data;
		curl_setopt($ch, CURLOPT_URL,$surl);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//控制返回结果不让自动输出
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//对ssl 证书错误 不验证
		curl_setopt($ch, CURLOPT_POST,count($fields)) ; // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  
		curl_setopt($ch, CURLOPT_POSTFIELDS,$fields); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名  		

		$result = curl_exec($ch);//其值为 成功为1 不成功为 no auth
	
		return $result;
		// return $result;
		// if($result==1)
		// {
		// 	$json['status']='ok';
		// 	//return $json['status'];
		// 	// echo ok;
		// 	//exit(json_encode($json));
		// }else{
		// 	$json['status']='no';
		// 	// echo no;
		// 	//return $json['status'];
		// 	//exit(json_encode($json));
		// }

	}

	/**
	 * 我的任务--展示页
	 */

	public function mytask()
	{
		$username=session('username');
		//->where('status=1')
		$uid=M('ucenter_member')->getFieldByUsername($username,'id');
		$count=M('house as h')->field('h.*,os.id as oid,os.status')->join('onethink_status as os on h.status=os.id')->where('h.respid='.$uid.' and h.status=4')->order('h.id desc')->count();
		$Page=new \Think\Page($count,30);
		$show=$Page->show();
		$list=M('house as h')->field('h.*,os.id as oid,os.status')->join('onethink_status as os on h.status=os.id')->where('h.respid='.$uid.' and h.status=4')->order('h.id desc')->
		limit($Page->firstRow.','.$Page->listRows)
		->select();
		$this->page=$show;
		$this->uid=$uid;
		$this->list=$list;
		$this->display();
	}

	/**
	 * 任务完成确认--
	 */
	public function taskconfirm()
	{
		$uid=I('get.uid',0);//负责人id
		$taskid=I('get.taskid',0);//任务id
		$house=M('house');
		$data['status']=5;//5为已完成
		$data['finishtime']=time();
		$res=$house->where('id='.$taskid.' and respid='.$uid)->save($data);
		// echo M()->_sql();
		// die;
		if($res!==false)
		{
			$op=array();
			$op['opname']=session('username');
			$op['optime']=time();
			$op['opdata']=serialize($data);
			$op['opip']=ip2long($_SERVER['REMOTE_ADDR']);
			$op['optip']=$op['opname']."完成了一个项目id为：".$taskid;
			$op['optbname']='house';
			$op['opthatid']=$taskid;
			M('dts')->add($op);
			$this->success('已经确认');
		}else{
			$this->error('确认失败');
		}

	}

	/**
	 * 已完成的任务
	 */
	public function donetask()
	{
		$house=M('house as h');
		$data['status']=5;//5为已完成
		$data['finishtime']=time();
		$username=session('username');
		$res=$house->join('onethink_ucenter_member as oum on h.respid=oum.id','left')
		     ->join('onethink_status as os on h.status=os.id')
		     ->field('h.*,oum.status as oums,os.status')->where('oum.username='."'".$username."'".' and h.status=5')->select();
		// echo M()->_Sql();
		// echo M()->getDbError();
		$this->list=$res;
		$this->display();

	}
	/**
	 * 2015-11-16
	 * 风控复核
	 * 银行 银行卡  姓名  是否有过桥 过桥人 过桥卡号
	 */
	public function riskcontrol()
	{
		$cstname=I('post.cstname',0);
		$pid=session('pid');//资金来源
		 // echo $pid;
		if($pid!=1)
		{
		 $condition['h.capitalsource']=$pid;
		}
 		
		$condition['h.status']=5;
		if($cstname)
		{
			$condition['h.cstname']=array('like','%'.$cstname.'%');
			// $list=M('house')->alias('as h')->where($condition)->select();
			$list=M('house')
		      ->alias('as h')
		      ->field('h.*,os.status')
		      ->join('onethink_status as os on h.status=os.id','left')
		      ->where($condition)
		      ->order('add_time desc')
		      ->select();
			$this->list=$list;
			$this->show();
			return;
		}
		$count      = M('house')->alias('as h')->where($condition)->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		// $list = M('house')->order('add_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		$list=M('house')
		      ->alias('as h')
		      ->field('h.*,os.status,oum.username')
		      ->join('onethink_status as os on h.status=os.id','left')
		      ->join('onethink_ucenter_member as oum on h.salesman=oum.id','left')
		      ->where($condition)
		      ->order('add_time desc')
		      ->limit($Page->firstRow.','.$Page->listRows)
		      ->select();
		       // echo M()->getlastSql();
		// dump($list);
		$this->pid=$pid;
		$this->list=$list;
		$this->page=$show;
		$this->display();
	}

	/**
	 * 2015-11-16 riskdetail 风控复核详细
	 * @id 
	 */
	public function riskdetail()
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
 		$this->display();
	}
	/**
	 * 2015-11-17 riskadd 风控详细 @author yee
	 */
	public function riskadd()
	{
		$data=M('house')->create();
		$id=I('post.id');
		$data['checksec']=session('username');
		$data['status']='9';//9为已复审
		$res=M('house')->where('id='.$id)->save($data);
		if($res!==false)
		{
		//更新状态
		
 		// M('house')->where('id='.$data['hid'])->save($h);
		$op=array();
		$op['opname']=session('username');
		$op['optime']=time();
		$op['opdata']=serialize($data);
		$op['opip']=ip2long($_SERVER['REMOTE_ADDR']);
		$op['optip']=$op['opname']."复审一个项目id为：".$id;
		$op['optbname']='house';
		$op['opthatid']=$id;
		M('dts')->add($op);

		 $url=U('Role/riskcontrol');
		 $message='复核成功';
		 $this->success($message,$url);
		}else{
		 //$url=U('Role/riskcontrol');
		 $message='复核失败';
		 $this->error($message);
		}
	}


	public function manageadd()
	{
		$data=M('organization')->create();
		foreach (@$_FILES as $key => $value) {
        	if($value['error']!=4)
        	{
        		$class[]=$key;
        	}
        }
       $res=A('menu')->propic();
       foreach ($class as $key => $value) {
       		$data[$value]=$res[$key];
       }
        $result=M('organization')->add($data);
		if($result)
		{
		 $this->success('添加成功');
		}else{
		 $this->error('添加失败');
		}
	}

	/**
	 * 机构列表
	 */

	public function managelist()
	{
		$count=M('organization')->alias('o')->field('o.*,orz.oxz')
		->join('onethink_orxz as orz on o.xingzhi=orz.id')->count();
		$page=new \Think\Page($count,30);
		$show=$page->show();
		$list=M('organization')->alias('o')->field('o.*,orz.oxz')
		->join('onethink_orxz as orz on o.xingzhi=orz.id')
		->limit($page->firstRow.','.$page->listRows)
		->select();
		$this->list=$list;
		$this->page=$show;
		$this->display();
	}

	public function riskasync()
	{
		$idarr=I('post.id');
		$data['checkname']=session('username');
		$data['checktip']="同意";
		$data['ispass']=1;//1为通过
		// $idarr=json_decode($idarr,1);
		foreach (@$idarr as $key => $value) {
			$data['hid']=$value;
			M('checksec')->add($data);
			$h['status']='9';//9为已复审
 		    M('house')->where('id='.$data['hid'])->save($h);
		}
		 
		$op=array();
		$op['opname']=session('username');
		$op['optime']=time();
		$op['opdata']=serialize($data);
		$op['opip']=ip2long($_SERVER['REMOTE_ADDR']);
		$op['optip']=$data['checkname']."复审一个项目id为：".$data['hid'];
		$op['optbname']='house';
		$op['opthatid']=$data['hid'];
		M('dts')->add($op);

		echo 1;
	}
	//过桥人贷款
	public function manage()
	{
		$list=M('organization')->select();
		$this->list=$list;
		$this->display();
	}

	public function bridgeadd()
	{
		$bridge=M('member_info');
		$data=$bridge->create();
		$res=$bridge->add($data);
		if($res)
		{
		$op=array();
		$op['opname']=session('username');
		$op['optime']=time();
		$op['opdata']=serialize($data);
		$op['opip']=ip2long($_SERVER['REMOTE_ADDR']);
		$op['optip']=$op['opname']."添加了一个名叫：".$data['nickname']."的过桥放款人";
		$op['optbname']='house';
		$op['opthatid']=$res;
		M('dts')->add($op);
		$this->success("添加成功");
		}else{
			$this->error("添加失败");
		}
	}

	/**
	 * 业务员催收日历
	 */
	public function calendar()
	{
		$username=session('username');
		$id=M('ucenter_member')->getFieldByUsername($username,'id');
		$month=date("m");
		$year=date('Y');

		// echo $id;
		$res=M('repayplan')
		->alias('as oe')
		->field('oe.id,oe.hid,oe.shouldtime as shouldtime,oe.shouldrepay ,h.tel,h.cstname,oum.username,oum.mobile')
		->join('onethink_house as h on oe.hid=h.id')
		->join('onethink_ucenter_member as oum on h.respid=oum.id')
		->where("h.respid=".$id.' and Month(oe.shouldtime)='.$month." and Year(oe.shouldtime)=".$year)
		->group('h.cstname,shouldtime')
		->order('UNIX_TIMESTAMP(oe.shouldtime)')
		->select();
		// echo M()->_sql();
		// dump($res);
		// die;
		foreach (@$res as $key => $value) {

			$value['tel']=$value['tel']?$value['tel']:"xxxxxxxxxxx";//为了保持电话数据长度一致性
			 $calendar[]=$value['shouldtime']."&姓名：".$value['cstname'].".&电话：".$value['tel'].".&金额：".$value['shouldrepay']."元;";
		}
		$res=json_encode($calendar);
 		// dump($res);
		$this->res=$res;
		$this->display();
	}



/**
 * UPDATE 2015-12-09 测试修改
 */
		public function update()
		{

			$sql="SELECT `id`,`shouldtime`,`realrepay`,`donetime`,`operatetime`,`operator`,
			`repaytype`,`shouldrepay`,`cursort`,`totalsort`,`hid`,max(cursort) as mcursort FROM (SELECT *  from `onethink_repayplan`  ORDER BY cursort desc) as h GROUP BY hid";
			$res=M()->query($sql);
			$arr=array();
			foreach (@$res as $key => $value) {
				$ta['cursort']=$res[$key]['cursort']+1;
				M('repayplan')->where("id=".$value['id'])->save($ta);
				array_push($arr,M('repayplan')->where('id='.($value['id']-1))->find());
			}
			foreach ($arr as $key => $value) {
				$data['shouldtime']=$res[$key]['shouldtime'];
				$data['shouldrepay']=$value['shouldrepay'];
				$data['realrepay']=$value['realrepay'];
				$data['donetime']=$data['shouldtime'];
				$data['operatetime']=$value['operatetime'];
				$data['operator']=$value['operator'];
				$data['repaytype']=$value['repaytype'];
				$data['cursort']=$value['cursort']+1;
				$data['totalsort']=$value['totalsort'];
				$data['hid']=$value['hid'];
				M('repayplan')->add($data);//fetchSql(true)->
				echo M()->_sql()."</br>";
			}

		}
		//这里主要更改 最后一期的钱和应还日期和实还日期
		public function update2()
		{
			$sql="SELECT `id`,`shouldtime`,`realrepay`,`donetime`,`operatetime`,`operator`,
			`repaytype`,`shouldrepay`,`cursort`,`totalsort`,`hid`,max(shouldrepay) as shouldrepay FROM (SELECT *  from `onethink_repayplan`  ORDER BY shouldrepay desc) as h GROUP BY hid";
			$res=M()->query($sql);
			// dump($res);
			$arr=array();
			foreach (@$res as $key => $value) {
				echo ($value['id']-1)."<br/>";
				array_push($arr,M('repayplan')->where('id='.($value['id']-1))->find());
			}
		
			// die;
			foreach ($arr as $key => $value) {
				
					if($value['donetime']=="0000-00-00")
					{
						$data['donetime']=$value['donetime'];
						echo $value['cursort'];
						M("repayplan")->where("cursort=".($value['cursort']+1)." and hid=".$value['hid'])->save($data);
						echo M()->_sql()."</br>";
					}
			}
		}

		/**
		 * 催收管理--2015-12-11
		 *
		 *
		 */
		public function debt()
		{
			$name=session('username');
			$name=M('ucenter_member')->field('id')->where('username='."'".$name."'")->find();
			$this->name=$name['id'];
			if(session('status')==8 && session('pid')==1)
			{
				$condition['h.respid']=$name['id'];
			}
			$today=date('Y-m-d');
			$a3days=date('Y-m-d',strtotime( '+3 days' ));
			$this->today=$today;//默认为今天的时间
			$this->a3days=$a3days;//默认结束时间为3天后
			//默认情况
			 $condition['unix_timestamp(r.shouldtime)']=array('between',strtotime($today).",".strtotime($a3days));
			 $starttime=I('get.starttime');
			 if($starttime)
			 {
				$shouldtime[0]=$starttime?strtotime($starttime):strtotime($today);
				$condition['unix_timestamp(r.shouldtime)']=array('in',$shouldtime);
				$this->today=$starttime;
			 }

			 $endtime=I('get.endtime');
			 if($endtime)
			 {
 				$shouldtime[1]=$endtime?strtotime($endtime):strtotime($a3days);
 				$condition['unix_timestamp(r.shouldtime)']=array('between',$shouldtime);
 				$this->a3days=$endtime;
			 }

			 if(I('get.source'))
			 {
			 $condition['h.source']=I('get.source');
			 $this->hsource=I('get.source');
			 }
			 if(I('get.cstname'))
			 {
			 $condition['h.cstname']=array("like",I('get.cstname'));
			  $this->hcstname=I('get.cstname');
			 }
			 if(I('get.salesman'))
			 {
			 $condition['h.respid']=I('get.salesman');
			  $this->hsalesman=I('get.salesman');
			 }
			 $con=I('get.con');//0全部1为未还2为已还
			 if($con==1)
			 {
			 	$condition['r.realrepay']=array('eq',0);
			 	$this->hcon=I('get.con');
			 }else if($con==2)
			 {
			 	$condition['r.realrepay']=array('neq',0);
			 	$this->hcon=I('get.con');
			 }
			$condition['h.status']=array('between','7,8');
			// dump($condition);
			//业务来源与业务员 下拉列表数据
			$sales=M('ucenter_member')->field('id,username')->where('status=8 and pid=1')->select();
			$this->sales=$sales;//业务员列表
			$source=M('organization')->field('id,organization')->select();
			$this->source=$source;//业务来源
			//引入分页
			$count = M("house")
			     ->alias('h')
			     ->field('h.id,r.hid,r.cursort,r.totalsort,r.shouldtime,r.shouldrepay,r.realrepay,h.respid,oum.username,oum.mobile,h.title,h.cstname,osg.organization as source,ocg.organization as capitalsource')
			     ->join("onethink_repayplan as r on r.hid=h.id",'left')
			     ->join("onethink_ucenter_member as oum on h.respid=oum.id",'left')
			     ->join('onethink_organization as osg on h.source=osg.id','left')
			     ->join('onethink_organization as ocg on h.capitalsource=ocg.id','left')
			     ->where($condition)
			     ->count();// 查询满足要求的总记录数
			$Page   = new \Think\Page($count,20);// 实例化分页类 传入总记录数和每页显示的记录数(25)
			//分页跳转的时候保证搜索条件
			foreach($condition as $key=>$val) {
   				 $Page->parameter[$key]   =   urlencode($val);
				}
			$show  = $Page->show();// 分页显示输出
				$list=M("house")
			     ->alias('h')
			     ->field('h.id,r.hid,r.cursort,r.totalsort,r.shouldtime,r.shouldrepay,r.realrepay,h.respid,oum.username,oum.mobile,h.title,h.cstname,osg.organization as source,ocg.organization as capitalsource')
			     ->join("onethink_repayplan as r on r.hid=h.id",'left')
			     ->join("onethink_ucenter_member as oum on h.respid=oum.id",'left')
			     ->join('onethink_organization as osg on h.source=osg.id','left')
			     ->join('onethink_organization as ocg on h.capitalsource=ocg.id','left')
			     ->where($condition)
			     ->limit($Page->firstRow.','.$Page->listRows)
			     ->select();
			$this->empty="<td style='color:red'>暂无相关数据</td>";
			$this->page=$show;
			$this->list=$list;
			//为了下拉列表
			$this->condition=$condition;
			$this->display();
		}

	/**
	 * 做单过程页2016-01-06 lj
	 */

	public function process()
	{
		$house=M('house as h');
		$cstname=I('post.cstname',0);
		if($cstname)
		{
			$condition['cstname']=array("like",'%'.$cstname.'%');
			$list=M('house as h')->field('h.*,os.status as ostatus,oum.id as oumid,oum.username')->join('onethink_ucenter_member as oum on h.respid=oum.id','left')
		      ->join('onethink_status as os on h.status=os.id','left')
		      ->join('onethink_organization as oo on h.capitalsource=oo.organization','left')
		      ->where($condition)->order('h.add_time desc')->select();
		}

		$count      = M('house as h')
		      ->field('h.*,os.status as ostatus,oum.id as oumid,oum.username,oo.organization as capitalsource')
		      ->join('onethink_ucenter_member as oum on h.respid=oum.id','left')
		      ->join('onethink_status as os on h.status=os.id','left')
		      ->join('onethink_organization as oo on h.capitalsource=oo.organization','left')
		      ->where($condition)->limit($Page->firstRow.','.$Page->listRows)
		      ->order('h.add_time desc')
		      ->count('h.id');// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$this->assign('page',$show);// 赋值分页输出
		$list=M('house as h')
		      ->field('h.*,os.status as ostatus,oum.username,oo.organization as capitalsource')
		      ->join('onethink_ucenter_member as oum on h.salesman=oum.id','left')
			  ->join('onethink_status as os on h.status=os.id','left')
		      ->join('onethink_organization as oo on h.capitalsource=oo.organization','left')
		      // ->join('onethink_process as op on h.id=op.hid','left')
		      ->where($condition)
		      ->limit($Page->firstRow.','.$Page->listRows)
		      ->order('h.add_time desc')->select();
	
		$this->list=$list;
		// dump($list);
		$this->display();
	}

	/**
	 * 做单过程详细页
	 */
	public function	processdetail()
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
 		$this->display();

	}
	/**
	 * 复确认
	 */

	public function fsconfirm()
	{
		$id=$_POST['id'];
		$data[$_POST['name']]=$_POST['val'];
		$res=M('house')->where('id='.$id)->save($data);
		if($res!==false)
		{
			echo 1;//成功
		}else{
			echo 2;//失败
		}
	}

	public function testsuc()
	{	
		$url=U('Menu/admitshow');
		$this->success('贷款录入完成,进入贷款审批流程',$url);
		// $this->error('贷款录入完成,进入贷款审批流程');
	}

 }//eof class role
