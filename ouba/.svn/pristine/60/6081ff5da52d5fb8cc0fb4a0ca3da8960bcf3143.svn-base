<?php
namespace Home\Controller;
use Think\Controller;
header("content-type:text/html;charset=utf-8");
 class MenuController extends Controller
 {

 	public $partner_name;
	public $secret_key;
	public $url;
	public $month;
	public $reset;

   public function _initialize()
   {
	 $this->partner_name=C(PNAME);
	 $this->secret_key=C(SECRET_KEY);
	 $this->url = C(API_URL);
   }
	/*
 	项目录入--前台小孟
 	time:20153013
 	by lj
 	*/
 	public function index()
 	{	
 		$returndata=$_POST;
 		if(is_array($returndata))
 		{
 			$this->returndata=$returndata;
 		}
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
 		$this->show();
 	}
 	/**
 	 * 展示页
 	 */
 	public function likeindex()
	{	
		$data=$_POST;
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
		$this->display();
	}




 	/**
 	 * 小孟查看
 	 */
 	public function showlist()
 	{
 		// 实例化User对象
 		$User = M('house as h'); 
 		$cstname=I('post.cstname',0);
 		if($cstname)
		{
			$list=$User->where('cstname like '."'%".$cstname."%'")->select();
			$this->list=$list;
			$this->show();
			return;
		}
		$count      = $User->where("status<=9")->count();// 查询满足要求的总记录数

		$Page       = new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $User
		       ->field('h.*,os.id as oid,os.status as ostatus')
		       ->join('onethink_status as os on h.status=os.id','left')
		       // ->where("h.status=1")
		       ->where("h.status<=9")
		       ->order('h.add_time desc')
		       ->limit($Page->firstRow.','.$Page->listRows)
		       ->select();
		$this->assign('list',$list);// 赋值数据集
		$this->page=$show;// 赋值分页输出
		$this->display(); // 输出模板
 	}
	//2015-11-3 修改展示页面
 	public function modifyshow()
 	{
 		$id=I('get.id',0);
 		$data=M('house')->find($id);

 		$olist=M('organization')->select();
 		$plistywy=M('ucenter_member')->where('status=8 or part_time=8')->select();//业务员
 		$blist=M('member_info')->where("type='bridge'")->select();//过桥
 		$elist=M('ucenter_member')->where('authority=1 or authority=12')->select();//初审
 		$flist=M('ucenter_member')->where('authority=12')->select();//终审
 		$htlist=M('housetype')->select();//房屋类型
 		$pllist=M('pcondition')->where('pandl=1')->select();//抵押类型
 		$pllist2=M('pcondition')->where('pandl=2')->select();//2为消费用途
 		$pictypelist=M('file_class')->field('id,class_name')->select();//文件类型

 		$this->pictypelist=$pictypelist;
 		$this->plist=$plist;
		$this->list=$olist;//资金和业务来源
		$this->blist=$blist;
		$this->elist=$elist;
		$this->flist=$flist;
		$this->htlist=$htlist;
		$this->pllist=$pllist;
		$this->pllist2=$pllist2;
		$this->id=$id;
 		$this->data=$data;
 		// picshow
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

	  $Page= new \Think\Page($pcount,30);
	  $pshow=$Page->show();
	  $plist=M('picture')
	         ->alias('p')
	         ->field('p.*,ofc.id as ofcid,ofc.class_name')
	  		 ->join('onethink_file_class as ofc on p.file_class_id=ofc.id')
	  		 ->where('p.pid='.$id.' and p.status!=1')
	         ->order('p.create_time desc,p.file_class_id')
		     // ->limit($Page->firstRow.','.$Page->listRows)
		     ->select();
	
	$plist=array_merge($plist,$plist2);
	  // die;
	//外围高度为总张数*图片高度
		if($pcount<3)
		{
		  $pcount=3;
		}
	  $pheight=ceil($pcount/3)*230;
	  $this->pheight=$pheight;
	  $this->plist=$plist;
	  $this->plistywy=$plistywy;

 		$this->display();
 	}
 		//2015-11-3 修改逻辑
 	public function modify()
 	{
 		$house=M('house');
 		$data=$house->create();
 		$data['borrowamt']=str_replace(',','',$data['borrowamt']);
 		$data['estimateprice']=str_replace(',','', $data['estimateprice']);
 		$data['price']=str_replace(',','', $data['price']);
 		$list=$house->where('id='.$data['id'])->save($data);//->fetchSql(true)
 		// $this->redirect('menu/picshow?id='.$data['id']);
 		if($list!==false)
 		{
 			$this->success('修改成功');
 		}else{
 			$this->error('修改失败');
 		}
 	}

 	//删除-逻辑页
 	public function del()
 	{
 		$id=I('get.id',0);
 		$list=M('house')->delete($id);

 		if($list!==false)
 		{
 			//开始删图片
 			$res=M('picture')->field('path')->where('pid='.$id)->select();
 			if(!empty($res))
 			{
 				foreach ($res as $key => $value) {
 					unlink('Uploads/'.$path); 
 				}
 			}
 			$this->success('删除成功');
 		}else{
 			$this->error('删除失败');
 		}
 	}
 	/**
 	 * 打印合同详细页
 	 */

 	public function printerdetail()
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
 	/*项目审批-操作页
 	time:20153013
 	by lj
 	*/
 	public function admitshow()
 	{

 		$User = M('house'); // 实例化User对象
 		$cstname=I('post.title',0);
 		if($cstname)
		{
		$list=$User->alias('as h')->field('h.*,o.organization,os.status as status')
        ->join('onethink_organization as o on h.source=o.id')
        ->join('onethink_status as os on os.id=h.status')
        ->where('title like '."'%".$cstname."%'".' and h.status in (1,3)')
		->order('h.add_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
			$this->list=$list;
			$this->show();
			return;
		}
		// ->where('status=1')
		$count      = $User->alias('as h')->field('h.*,o.organization')
        ->join('onethink_organization as o on h.source=o.id')
        ->where('h.status=1')->count();// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$list = $User->alias('as h')->field('h.*,o.organization,os.status as status')
        ->join('onethink_organization as o on h.source=o.id')
        ->join('onethink_status as os on os.id=h.status')
        ->where('h.status in (1,3)')
		->order('h.add_time desc')->limit($Page->firstRow.','.$Page->listRows)->select();
		
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->display(); // 输出模板
 	}

 	/*
 	项目审批-通过
 	time:20153013
 	by lj
 	*/
 	public function admit()
 	{	
 		$id=I('post.id');
 		$house=M('house');
 		$data=$house->create();
 		$data['borrowamt']=str_replace(',','',$data['borrowamt']);
 		$data['estimateprice']=str_replace(',','', $data['estimateprice']);
 		$data['price']=str_replace(',','', $data['price']);
 		$data['update_time']=time();//审批通过的时间
 		$data['status']=4;
 		$res=$house->where('id='.$id)->save($data);//->fetchSql(true)
 		// echo M()->_sql();
 		// die;
 		if($res!==false)
 		{	
			$op=array();
			$op['opname']=session('username');
			$op['optime']=time();
			$op['opdata']=serialize($data);
			$op['opip']=ip2long($_SERVER['REMOTE_ADDR']);
			$op['optip']=$op['opname']."审批通过了一个项目id为：".$id;
			$op['optbname']='house';
			$op['opthatid']=$id;
			M('dts')->add($op);
 			$this->success('项目审批通过，等待分配做单业务员');
 		}else{
 			$this->error('审批失败');
 		}
 	}
 	//项目审批通过

 	public function admitfuck()
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
 	/*
 	项目审批-拒绝
 	time:20153013
 	by lj
 	*/
 	public function refuse()
 	{
 		$id=I('get.id');
 		$house=M('house');
 		$data['status']=3;
 		$data['update_time']=time();
 		$res=$house->where('id='.$id)->save($data);
 		if($res!==false)
 		{
 			$op=array();
			$op['opname']=session('username');
			$op['optime']=time();
			$op['opdata']=serialize($data);
			$op['opip']=ip2long($_SERVER['REMOTE_ADDR']);
			$op['optip']=$op['opname']."拒绝通过了一个项目id为：".$id;
			$op['optbname']='house';
			$op['opthatid']=$id;
			M('dts')->add($op);

 			$this->success('已拒绝');
 		}else{
 			$this->error('审核失败');
 		}
 		//$this->show();
 	}
 	/*
 	项目分配-列表
 	time:20153013
 	by lj
 	*/
	public function allotlist()
	{
		$house=M('house as h');
		$status=I('get.status');
		if($status)
		{
			$condition['h.status']=$status;
		}else{
			$condition['h.status']=array('in',array('2','3','4'));
		}
		$cstname=I('post.cstname',0);
		if($cstname)
		{
			$condition['cstname']=array("like",'%'.$cstname.'%');
			$list=M('house as h')->field('h.*,os.status as ostatus,oum.id as oumid,oum.username')->join('onethink_ucenter_member as oum on h.respid=oum.id','left')
		      ->join('onethink_status as os on h.status=os.id')
		      ->where($condition)->order('h.add_time desc')->select();
		}

		$count      = $house->join('onethink_ucenter_member as oum on h.respid=oum.id','left')->where($condition)->count('h.id');// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$this->assign('page',$show);// 赋值分页输出
		// $condition['h.status']=array('elt','4');
		$list=M('house as h')->field('h.*,os.status as ostatus,oum.id as oumid,oum.username')->join('onethink_ucenter_member as oum on h.respid=oum.id','left')
		      ->join('onethink_status as os on h.status=os.id')
		      ->where($condition)->limit($Page->firstRow.','.$Page->listRows)->order('h.add_time desc')->select();
		
		$salesman=M('ucenter_member um')->field('um.id,um.username')
 		     // ->join('onethink_house as h on um.id=h.respid','left')
 		     ->where('um.status=8 or um.part_time')
 		     ->select();
 		$this->salesman=$salesman;
		$this->list=$list;
		// dump($list);
		$this->display();
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
 	/*
 	借款项目-录入
 	time:20153013
 	by lj
 	*/
 	public function add()
 	{
 		$house=M('house');
 		$data=$house->create();
 		$data['borrowamt']=str_replace(',','', $data['borrowamt']);
 		$data['estimateprice']=str_replace(',','', $data['estimateprice']);
 		$data['price']=str_replace(',','', $data['price']);
 		$data['add_time']=time();
 		$data['carbuytime']=strtotime($data['carbuytime']);
 		$success=$house->add($data);

      
 		if($success)
 		{	
 			$process=array();
 			$process['hid']=$success;
 			M('process')->add($process);//把做单过程写进去
 			$op=array();
			$op['opname']=session('username');
			$op['optime']=time();
			$op['opdata']=serialize($data);
			$op['opip']=ip2long($_SERVER['REMOTE_ADDR']);
			$op['optip']=$op['opname']."添加了一个项目id为：".$success."标题为：".$data['title'];
			$op['optbname']='house';
			$op['opthatid']=$success;
			M('dts')->add($op);
 			$this->redirect('menu/picshow?id='.$success);
 		}
 	}
 	/**
 	 * 图片添加页
 	 */
 	public function picshow()
 	{
 		$pid=I('get.id');
 		// $url=I('get.url');
 		$list=M('file_class')->field('id,class_name')->select();
 		//图片
	  $plist2=M('picture')
	         ->alias('p')
	         ->field('p.*,otp.newclass')
	  		 ->join('onethink_temp_picture as otp on p.newpictype=otp.id')
	  		 ->where('p.pid='.$pid.' and p.status!=1')
	         ->order('p.create_time desc,p.newpictype')
		     ->select();
	  $cp2=count($plist2);

	  $pcount=M('picture')
	         ->alias('p')
	         ->field('p.*,ofc.id as ofcid,ofc.class_name')
	  		 ->join('onethink_file_class as ofc on p.file_class_id=ofc.id')
	  		 ->where('p.pid='.$pid.' and p.status!=1')->count();
	  $pcount=$cp2+$pcount;

	  $Page= new \Think\Page($pcount,30);
	  $pshow=$Page->show();
	  $plist=M('picture')
	         ->alias('p')
	         ->field('p.*,ofc.id as ofcid,ofc.class_name')
	  		 ->join('onethink_file_class as ofc on p.file_class_id=ofc.id')
	  		 ->where('p.pid='.$pid.' and p.status!=1')
	         ->order('p.create_time desc,p.file_class_id')
		     ->select();
	  $plist=array_merge($plist,$plist2);
	//外围高度为总张数*图片高度
		if($pcount<3)
		{
		  $pcount=3;
		}
	  $pheight=ceil($pcount/3)*230;
	  $this->pheight=$pheight;
	  $this->plist=$plist;
      $this->pid=$pid;//为图片的pid //via
	  $this->list=$list;
	  $this->display('picshow');	
 	}
 	/**
 	 * 最新图片 处理方式
 	 *
 	 */
 	public function newpic()
 	{
 		$pid=I('post.pid');//已上传的标的id

 		$picname=I('post.picname');//这里是图片的类型

	    foreach (@$_FILES as $key => $value) {
        	if($value['error']!=4)
        	{
        		$class[]=$key;
        	}
        }
      	$res=$this->propic($picname);
      	//处理新添加的类
  		$newclass=I('post.newclass');
		if($newclass && !empty($class))
		{
			$tempdata['newclass']=$newclass;
			$newtype=M('temp_picture')->add($tempdata);//先插入图片类型
		}
      	foreach (@$res as $key => $value) 
      	{
      		$pdata['path']=$value;//去掉. (./upload)前面的点
	 		$pdata['create_time']=time();
	 		$pdata['pid']=$pid;
	 		if($newclass)
	 		{
	 		$pdata['newpictype']=$newtype;
	 		}
			//为了app 删除pc端上传的图片
			$dotpos=strpos($pdata['path'],".");//点的位置
	        $itapos=strrpos($pdata['path'],"/")+1;//“/”最后一次出现的位置
	        $pdata['file_name']=substr($pdata['path'],$itapos,$dotpos-$itapos);//
	        $pdata['file_class_id']=$picname;
	   		$pic[]=M('picture')->add($pdata);
		 }    	
		 if(!empty($pic))
		 {	
		 	$this->success("操作成功",$url,1);
		 }
 	}

 	/*
 	*项目图片公共方法
 	*@param $id 具体项目id
 	*@param $path 图片子路径（用于图片分类）
 	*@return $fullpath 全路径
 	*/
 	public function propic($path)
 	{
 		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','mp4');// 设置附件上传类型
		$upload->rootPath  =      './Uploads/'; // 设置附件上传根目录
		$upload->savePath  =      $path.'/'; // 设置附件上传（子）目录
		//$upload->saveName  = '';//保留原名
		// 上传文件 
		$info   =   $upload->upload();

		if(!$info) {// 上传错误提示错误信息
			if(($upload->getError())!='没有上传的文件！');
			{
				$fullpath=$this->error($upload->getError());
			}
		    
		}else{// 上传成功 获取上传文件信息
			foreach($info as $file){
   			    $fullpath[]=$file['savepath'].$file['savename'];
   			 }
			
		}
		return $fullpath;
 	
 	}
 	/**
 	 * 分配业务给业务员 2015-30-14
 	 */
 	public function allocate()
 	{
 		$member=M('ucenter_member');

 		// $list=M('ucenter_member um')->field('um.id,um.username')
 		//      ->join('onethink_house as h on um.id=h.respid','left')
 		//      ->where('um.status=8')
 		//      ->select();
 		$house=M('house');
 		$count      = $house->where('status=8')->count($id);// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$this->assign('page',$show);// 赋值分页输出
 		$list=M('ucenter_member um')->field('um.*,h.title,count(h.respid) as hid,h.respid')
 		     ->join('onethink_house as h on um.id=h.respid','left')
 		     ->where('um.status=8')
 			 ->group('um.username')
 			 ->limit($Page->firstRow.','.$Page->listRows)
 			 ->order('um.id')
 		     ->select();

 		$propid=I('get.propid',0);//项目id

 		$this->propid=$propid;
 		$this->list=$list;
 		$this->display();
 	}

 	/**
 	 * 确定分配业务给业务员 2015-30-14
 	 */
 	public function allocated()
 	{
 		$propid=$_GET['propid'];//项目id
 		$respid=$_GET['respid'];//如果不存则为零（负责人id）
 		$member=M('house');
 		$data['respid']=$respid;
 		$data['status']=4;
 		$data['fptime']=time();
 		$res=$member->where('id='.$propid)->save($data);
 		if($res!==false)
 		{
 			$op=array();
			$op['opname']=session('username');
			$op['optime']=time();
			$op['opdata']=serialize($data);
			$op['opip']=ip2long($_SERVER['REMOTE_ADDR']);
			if(!$first){
			$op['optip']=$op['opname']."分配一个项目给负责人id为：".$respid;
			}else{
			$op['optip']=$op['opname']."重新分配一个项目给负责人id为：".$respid;
			}
			$op['optbname']='house';
			$op['opthatid']=$propid;
			$op['oprespid']=$respid;
			M('dts')->add($op);
 			echo 1;
 		}else{
 			echo '分配出现问题，请联系网站管理员';
 		}
 		//$this->display();
 	}
 	/**
 	 * 重新分配 2015-30-14
 	 */
 	public function reallocate()
 	{

 		$propid=I('get.propid',0);//项目id
 		$house=M('house');
 		$count      = $house->where('status=8')->count($id);// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$this->assign('page',$show);// 赋值分页输出
 		$list=M('ucenter_member um')->field('um.*,h.title,count(h.respid) as hid,h.respid')
 		     ->join('onethink_house as h on um.id=h.respid','left')
 		     ->where('um.status=8')
 			 ->group('um.username')
 			 ->limit($Page->firstRow.','.$Page->listRows)
 			 ->order('um.id')
 		     ->select();
 		$house=M('house'); 		
 		$res=M('ucenter_member um')->field('um.username')->join('onethink_house h on um.id=h.respid','left')->where('um.id='.$propid)->find();
		$propid=I('get.propid',0);//项目id
 		$this->res=$res['username'];
 		$this->propid=$propid;
 		$this->list=$list;
 		$this->display();
 		//$this->display();
 	}

 	/**
 	 * 删除图片--@author lj 11-04
 	 */
 	public function unlink()
 	{
 		//接收异步的传输值
 		$id=$_POST['id'];
 		$path=$_POST['pic'];
 		$path='Uploads/'.$path;
 		
 	if(unlink($path))
 	    {
 		$res=M('picture')->delete($id);
 		if($res!==false)
	 		{
 			   echo 1;
		    }else{
		       echo 3;
		    }
 		}else{
 			echo 2;//图片物理删除失败
 		}
 		// echo 1;
 	}
 	/**
 	 * 2015-11-13 审批意见 @author lj
 	 */
 	public function admityj()
 	{
 			//接收异步的传输值
 		$id=$_POST['id'];
 		$content=$_POST['f'];
 		$data['status']=$_POST['s'];
 		$data['id']=$id;
 		$data['fpyj']=$content;
 		$res=M('house')->where('id='.$id)->save($data);
 		if($res!==false)
 		{
 			echo 1;
 		}else{
 			echo 2;
 		}
 		// echo json_encode($content);

 	}
 /**
  * 数字汉字转化器
  */
	public function sz2hz()
	{
		$num=I('post.v',0);
		if(is_numeric($num))
		{
			echo num2ch($num);
		}else{
			echo 1;
		}
	 	
	}

	/**
	 * 异步调用过桥人信息
	 */
	public function bridgecontent()
	{
		$id=I('post.id');
		$list=M('member_info')->field('nickname,bridgeaccount,bridgeaddress')->where('uid='.$id)->select();
		echo json_encode($list);
	}
	//打印合同 2015-12-14
	public function printer()
	{
		$house=M('house as h');
		$status=I('get.status');
		if($status)
		{
			$condition['h.status']=$status;
		}else{
			$condition['h.status']=array('eq','2');
		}
		$condition['capitalsource']=4;
		$count      = $house->join('onethink_ucenter_member as oum on h.respid=oum.id','left')->where($condition)->count('h.id');// 查询满足要求的总记录数
		$Page       = new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		$this->assign('page',$show);// 赋值分页输出
	     $condition['h.status']=array('elt','4');
		$list=M('house as h')->field('h.*,os.status as ostatus,oum.id as oumid,oum.username,oo.organization as capitalsource')->join('onethink_ucenter_member as oum on h.respid=oum.id','left')
		      ->join('onethink_status as os on h.status=os.id')
		      ->join('onethink_organization as oo on h.capitalsource=oo.id')
		      ->where($condition)->limit($Page->firstRow.','.$Page->listRows)->order('h.add_time desc')->select();
		$this->list=$list;
		$this->display();
	}

	//抵押合同预览页
	public function peldge()
	{ 
		$id=I('get.id');
		$res=M('house')->find($id);
		$this->res=$res;
		$this->display();
	}
	//信托贷款合同预览页
	public function contract()
	{   
		$id=I('get.id');
		$res=M('house')->find($id);


		$this->res=$res;
		$this->display();
	}

	//三方借款协议 2015-12-18 lj
	public function threes(){
		$id=I('get.id');
		$res=M('house')->alias('h')
		     ->field('h.*,omi.nickname,omi.idno as omidno,omi.haddress,omi.bridgeaccount,omi.bridgeaddress,op.condition')
		     ->join('onethink_member_info as omi on h.bridgename=omi.uid','left')
		     ->join('onethink_pcondition as op on h.loandest=op.sort')
		     ->where('h.id='.$id.' and op.pandl=2')
		     ->find();
		$this->res=$res;
		$this->display();

	}
	//信托合同弹出信息
	public function hetong(){
		$id=$_GET['id'];
		$res=M('house')->find($id);
		$pledge=M('pcondition')->field("condition")->where('pandl=2 and sort='.$res['loandest'])->find();
		$html="<table class='table_tan' cellpadding='1' cellspacing='1' >
		<tr><td width='25%'>合同编号</td><td>".$id."</td></tr>
		<tr><td width='25%'>抵押人</td><td>".$res['pledgename']."</td></tr>
		<tr><td>身份证号码</td><td>".$res['idno']."</td></tr>
		<tr><td width='25%'>联系地址</td><td>".$res['address']."</td></tr>
		<tr><td width='25%'>联系电话</td><td>".$res['tel']."</td></tr>
		<tr><td width='25%'>贷款金额</td><td>".$res['borrowamt']."</td></tr>
		<tr><td width='25%'>贷款用途</td><td>".$pledge['condition']."</td></tr>
		<tr><td width='25%'>贷款利息</td><td>".$res['rate']."</td></tr>
		<tr><td width='25%'>贷款期限</td><td>".$res['duration']."</td></tr>
		<tr><td width='25%'>预收利息</td><td>2个月</td></tr>
		<tr><td width='25%'>收款人户名</td><td>".$res['bankname']."</td></tr>
		<tr><td width='25%'>收款人账号</td><td>".$res['bank']."</td></tr>
		<tr><td width='25%'>收款人开户行</td><td>".$res['bankcard']."</td></tr></table>";
		echo $html;
	}
	/**
	 * 抵押合同
	 */
	public function peldgeload(){
		$id=I('get.id');
		$res=M('house')->alias('h')->field('h.*,op.condition')
			->join('onethink_pcondition as op on h.pledge=op.sort','left')
			->where('h.id='.$id.' and op.pandl=1')
			->select();
		if($res[0]['isloan']==1)
		{
			$res[0]['isloan']='无租赁';
		}else if($res[0]['isloan']==2){
			$res[0]['isloan']='有租赁';
		}
		$html="<table class='table_tan' cellpadding='1' cellspacing='1' >
		<tr><td width='25%'>抵押权人</td><td>".$res['0']['pledgename']."</td></tr>
		<tr><td width='25%'>贷款合同编号</td><td>WX-SD-【201619003】-302-【".$res[0]['id']."】</td></tr>
		<tr><td width='25%'>抵押合同编号</td><td>WX-SD-【201619003】-303-【".$res[0]['id']."】</td></tr>
		<tr><td width='25%'>抵押人</td><td>".$res['0']['pledgename']."</td></tr>
		<tr><td width='25%'>抵押人身份证号</td><td>".$res['0']['pledgeidno']."</td></tr>
		<tr><td width='25%'>联系地址</td><td>".$res['0']['address']."</td></tr>
		<tr><td width='25%'>联系电话</td><td>".$res['0']['tel']."</td></tr>
		<tr><td width='25%'>债权本金</td><td>".$res['0']['borrowamt']."</td></tr>
		<tr><td width='25%'>债权期限</td><td>".$res['0']['duration']."</td></tr>
		<tr><td width='25%'>房地产权利人</td><td>".$res['0']['pledgename']."</td></tr>
		<tr><td width='25%'>房地产坐落</td><td>".$res['0']['address']."</td></tr>
		<tr><td width='25%'>房地产面积</td><td>".$res['0']['area']."</td></tr>
		<tr><td width='25%'>房地产权产权证号</td><td>".$res['0']['pledgeno']."</td></tr>
		<tr><td width='25%'>房地产协议价</td><td>".$res['0']['estimateprice']."</td></tr>
		<tr><td width='25%'>现有抵押情况</td><td>".$res['0']['condition']."</td></tr>
		<tr><td width='25%'>现有租赁情况</td><td>".$res['0']['isloan']."</td></tr>
		</table>";
		echo $html;
	}

	//三方借款协议
	public function threesload()
	{
		$id=I('get.id');
		$res=M('house')->alias('h')->field("h.*,omi.nickname,omi.bridgeaccount,omi.bridgeaddress,omi.idno as moidno")
		->join('onethink_member_info as omi on h.bridgename=omi.uid','left')
		->select();
		// echo M()->_sql();
		$html="<table class='table_tan' cellpadding='1' cellspacing='1' >
		<tr><td width='25%'>甲方:出借人</td><td>万向信托有限公司</td></tr>
		<tr><td width='25%'>乙方:借款人</td><td>".$res['0']['cstname']."</td></tr>
		<tr><td width='25%'>借款人身份证号码</td><td>".$res['0']['idno']."</td></tr>
		<tr><td width='25%'>丙方:过桥人</td><td>".$res['0']['nickname']."</td></tr>
		<tr><td width='25%'>过桥人身份证号</td><td>".$res['0']['moidno']."</td></tr>
		<tr><td width='25%'>信托贷款合同签订日期</td><td></td></tr>
		<tr><td width='25%'>过桥借款金额</td><td>".$res['0']['bridgemoney']."</td></tr>
		<tr><td width='25%'>过桥借款期限</td><td>".$res['0']['bridgedura']."</td></tr>
		<tr><td width='25%'>过桥借款利息</td><td>".$res['0']['bridgerate']."</td></tr>
		<tr><td width='25%'>借款人账户户名</td><td>".$res['0']['bankname']."</td></tr>
		<tr><td width='25%'>借款人账号</td><td>".$res['0']['bankcard']."</td></tr>
		<tr><td width='25%'>借款人开户行</td><td>".$res['0']['bank']."</td></tr>
		<tr><td width='25%'>过桥人账户户名</td><td>".$res['0']['nickname']."</td></tr>
		<tr><td width='25%'>过桥人账号</td><td>".$res['0']['bridgeaccount']."</td></tr>
		<tr><td width='25%'>过桥人开户行</td><td>".$res['0']['bridgeaddress']."</td></tr>
		</table>";
		echo $html;
	}

	

 }//eof class menu