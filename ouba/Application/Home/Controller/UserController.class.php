<?php
namespace Home\Controller;
use Think\Controller;
 header("content-type:text/html;charset=utf8");
 class UserController extends Controller
 {
 	/*
 	用户管理-默认
 	time:20150707
 	by lj
 	*/
 	public function index()
 	{
        $User=M('house as h');
        $cstname=I('post.cstname',0);
        if($cstname)
        {
            $condition['h.cstname']=array('like','%'.$cstname.'%');
        }
        $condition['h.status']=array('in','6,8,10');
      
         //查询满足要求的总记录数
        $count=$User->where($condition)->count();
     
        $Page       = new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        $condition['op.realrepay']=array('eq',0);
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list=$User->field('h.*,os.id as oid,os.status,min(op.cursort) as cursort,op.totalsort,op.id as opid')
              ->join('onethink_status as os on h.status=os.id','left')
              ->join('onethink_repayplan as op on h.id=op.hid','left')
              ->where($condition)
              ->group('h.title')
              ->limit($Page->firstRow.','.$Page->listRows)
              ->order('h.add_time desc')
              ->select();
              // dump($list);
        $this->assign('page',$show);// 赋值分页输出  
        $this->list=$list;
        $this->display();
 	}
// 100*1.25/
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


    /**
     * 贷后管理首页--
     */
    public function loanreturn()
    {
       $id=I('get.id',0);
       //查询一共分几次放款
       $res=M('repayplan')->field('id,max(nci) as nci')->where('hid='.$id)->select();
       $totaltimes=$res[0]['nci'];//这笔贷款分为多少
       $this->totaltimes=$totaltimes;
       for($i=1;$i<=$totaltimes;$i++)
       {
       $list[$i]=M('house as h')
            ->field("h.id,h.title,h.cstname,h.idno,h.tel,h.borrowamt,h.duration,h.rate,h.category,h.respid,rp.shouldtime,rp.shouldrepay,rp.realrepay,min(rp.cursort) as cursort,rp.nci")
            ->join('onethink_repayplan as rp on h.id=rp.hid','left')
            ->where('h.id='.$id.' and rp.realrepay < rp.shouldrepay and nci='.$i)
            ->find();
       }
        $this->list=$list;
        //还款计划
        $rplist=M('repayplan as rp')
               ->field("rp.*,p.id as pid,p.path")
               ->join('onethink_picture as p on rp.hid=p.pid and rp.cursort=p.sort','left')
               ->where('rp.hid='.$id)
               ->order("rp.id")
               ->select();
         // dump($rplist);
         // echo M()->_Sql();
        $this->rplist=$rplist;

        $this->time=date('Y-m-d');

       
       $this->display();
    }
/*
 	用户管理-编辑
 	time:20150707
 	by lj
 	*/
 	public function eidt()
 	{
 		$this->show();
 	}
    /**
     * 贷后管理-还款
     */
    public function save()
    {
        if(!I('post.donetime')){$this->error('具体还款日期必须填写');}
          $hid=I('post.id',0);//贷款id
        $respid=I('post.respid',0);
        $data['duration']=I('post.duration',0);
        $data['cursort']=I('post.cursort',0);//期数
        $data['realrepay']=I('post.realrepay',0);
        $data['donetime']=I('post.donetime',0);
        $data['repaytype']=I('post.repaytype',0);
        $data['operatetime']=date("Y-m-d H:i:s",time());
        $data['shouldrepay']=I('post.shouldrepay');
        $data['operator']=session('username');
        $nci=I('post.nci');

        //具体哪期的还款信息更新
        //是否已经有还款
        $sy=M('repayplan')->field('id,realrepay,shouldrepay,rtimes')->where('cursort='.$data['cursort']." and hid=".$hid.' and nci='.$nci)->find();
        //如果第一次还款 还完 或者 没还完 两种情况
        if($data['realrepay']==$sy['shouldrepay'])
        {   $data['rtimes']=1;
            $res=M('repayplan')->where('cursort='.$data['cursort']." and hid=".$hid.' and nci='. $nci)->save($data);
                     //成功之后 更新标的的状态
        
        }else if($data['realrepay']<$sy['shouldrepay'] && ($sy['realrepay']+$data['realrepay'])<=$sy['shouldrepay'])//第一次没有还完
        {
            $data['rtimes']=$sy['rtimes']+1;
            $data['realrepay']=$data['realrepay']+$sy['realrepay'];//把此次还款加到以往的还款金额上去
            $res=M('repayplan')->where('cursort='.$data['cursort']." and hid=".$hid.' and `nci`='. $nci)->save($data);
        }else{
            $this->error('一期多次还款总额不应超过这期的还款总额');
        }

         //判断所有的还款计划均已实行完毕 假如这个标的所有的真实已还的钱大于零小于借款金额 那就说明在还款中 如果等于借款金额了那就证明已经换完了
            $sumreal=M('repayplan')->where("hid=".$hid)->sum('realrepay');
            $borrowamt=M('house')->getFieldById($hid,'borrowamt');
            
        if($sumreal['tp_sum']>0 &&  $sumreal['tp_sum']<$borrowamt)
            {  
                $last['status']=8;//还款中
                M('house')->where('id='.$hid)->save($last);
            }else if($sumreal['tp_sum']==$borrowamt){
                $last['status']=7;//已还完
                M('house')->where('id='.$hid)->save($last);
            }
            

        if($res!==false)
        {
            //添加多个操作人*****2015-11-17 @auther lj(备用)
            // $cdata=array();
            // $cdata['hid']=$hid;
            // $cdata['sort']=$data['cursort'];
            // $cdata['create_time']=$data['operatetime'];
            // $cdata['operator']=$data['operator'];
            // M('check')->add($cdata);
            if($_FILES['pic1']['size']!='' && $_FILES['pic1']['error']!=4 )
            {
                $pictype='proof';//打款凭证第几期就是几
                $pres=A('menu')->propic($hid,$pictype);//打款凭证
                //把地址加入pic表
                $pdata['pid']=$hid;
                $pdata['pictype']=$pictype;
                $pdata['path']=$pres['0'];
                $dotpos=strpos($pdata['path'],".");//点的位置
                $itapos=strrpos($pdata['path'],"/")+1;//“/”最后一次出现的位置
                $pdata['file_name']=substr($pdata['path'],$itapos,$dotpos-$itapos);//
                $pdata['create_time']=time();
                $pdata['sort']=$data['cursort'];
                $pdata['file_class_id']=19;//还款凭证
                // dump($pdata);
                M('picture')->add($pdata);
                // echo M()->_sql();
            }
             // die;
   
            //操作日志记录 还款
            $op=array();
            $op['opname']=session('username');
            $op['optime']=time();
            $op['opdata']=serialize($data);
            $op['opip']=ip2long($_SERVER['REMOTE_ADDR']);
            $op['optip']=$op['opname']."给项目id为：".$hid."第".$data['cursort']."/".$data['duration']."期进行还款";
            //2015-11-03 每条具体操作日志
            $op['optbname']='repay';
            $op['opthatid']=$hid;
            $op['oprespid']=$respid;
            M('dts')->add($op);
            $url=U('User/index');
             $this->success('数据处理成功',$url);
        }else{
            $this->error('数据处理失败');
        }
        
     }

     public function logop()
     {
        $opname=I('post.opname',0);
        if($opname)
        {
            $condition['opname']=$opname;
        }else{
            $condition='1=1';
        }
        $User=M('dts');
        $count=$User->where($condition)->count();
        $Page       = new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list=$User->where($condition)->limit($Page->firstRow.','.$Page->listRows)->order('optime desc')->select();
        $this->assign('page',$show);// 赋值分页输出  

        // $list=->where($condition)->order('optime desc')->select();
        $this->empty="<td>暂时没有数据</td>";
        $this->list=$list;
        $this->display();
     }

        /*
    贷款结束
    time:201511-05
    by lj
    */
    public function end()
    {
        $User=M('house as h');
        $status=I('get.status',0);
        $cstname=I('post.cstname',0);
        if($status)
        {
            $condition['h.status']=$status;

        }else{
            $condition['h.status']=array('in',"8,7");
        }
        if($cstname)
        {
             $condition['h.cstname']=array('like','%'.$cstname.'%');
        }
         //查询满足要求的总记录数
        $count=$User->where($condition)->count();
        $Page       = new \Think\Page($count,30);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
        // 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list=$User->where($condition)->field('h.*,os.id as oid,os.status')
                   ->join('onethink_status as os on h.status=os.id','left')
                   ->limit($Page->firstRow.','.$Page->listRows)
                   ->order('h.add_time desc')
                   ->select();
        // echo M()->_Sql();
        // dump($list);
        $this->assign('page',$show);// 赋值分页输出  
        $this->list=$list;
        $this->display();
    }
 }//eof class 