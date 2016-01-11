<?php
class Menu extends CI_Controller{

  public $partner_name;
    public $secret_key;
    public $url;

    public function __construct(){
        parent::__construct();
        $this->partner_name=config_item('pname');
        $this->secret_key=config_item('secret_key');
        $this->url=config_item('api_url');
        $this->load->helper('url');
        $this->load->library('session');
        //$this->load->library('cookie');
        $this->load->database();
        
    }
    public function index(){

        $userId='123486';//$this->session->myid;
        $son_location =$this->db->select('son_location,son_phone')->get_where('detail',array('user_id'=>$userId),1);
        foreach ($son_location->result() as $value) {
            $son['son_location']=$value->son_location;
            $son['son_phone']=$value->son_phone;
        }
        //获取表中的 电话 和身份证 前六位
        $secret_key = $this->secret_key;

        $data['pname'] =$this->partner_name; 

        $data['sname'] = 'areainfo.get';//待完成

        $data['idno'] = $son['son_location'];

      //  $data['search_month'] =$search_month?$search_month:date('m');

        $content = json_encode($data);

        $string = $content.$secret_key;

        $token = md5($string);

        $post['content'] = $content;
        
        $post['token'] = $token;

        //curl post 请求

        $url = $this->url ;  

        $fields = $post ;

        $ch = curl_init() ;  

        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);//控制返回结果不让自动输出

        curl_setopt($ch, CURLOPT_URL,$url);

        curl_setopt($ch, CURLOPT_POST,count($fields)) ; // 启用时会发送一个常规的POST请求，类型为：application/x-www-form-urlencoded，就像表单提交的一样。  
        curl_setopt($ch, CURLOPT_POSTFIELDS,$fields); // 在HTTP中的“POST”操作。如果要传送一个文件，需要一个@开头的文件名          

        $result = curl_exec($ch);
        
        //echo curl_error($ch);
      
        $result = json_decode($result,1);

       // $cookie=array('area'=>$result['data']);

        $this->session->set_userdata('area',$result['data']);

        $data['result']=$result['data'];

        $mobile=$this->input->post('real_name');

         //把身份证中间八位隐藏掉
        foreach ($result['data'] as $key => $value)
        {
            $result['data'][$key]['idcard']=substr_replace($value['idcard'],'****',6,8);
            $result['data'][$key]['cell_phone']=substr_replace($value['cell_phone'],'****',3,4);
        }
       //模拟分页
        $count =count($result['data']);//总共有多少条函数

        $single_page_count = 10;//每页显示ds条

        $total=ceil($count/$single_page_count);//总页数

        $p=$this->input->get('p')?$this->input->get('p'):1;//当前的页码
    
        $cur_list_start = ($p-1)*$single_page_count;//当前页开始的那一条是第几条记录
        
        $data['p']=$p;//页码

        $data['total']=$total;//总页数
        
        $data['result']=$result['data'];


        if(!empty($mobile))
        {
            foreach ($result['data'] as $key => $value) 
            {
                if($value['real_name']==$mobile)
                {
                    $k=$value;
                }
            }
            $res[]=$k;
            $data['result']=$res;
        //return;
        }

        $data['result']=array_slice($data['result'], $cur_list_start, $single_page_count);

        $this->load->view("home/menu/index",$data);

    }
    /**
     * 区域用户导出
     */
    public function area_import()
    {
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');
        //要导出的数据
        $aim=$this->session->area;
        //导出后第一行
        $row=array('用户id','姓名','年龄','身份证','手机','地址','注册时间');
        
        $objPHPExcel = new PHPExcel();

        $objPHPExcel->setActiveSheetIndex(0);

        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

        foreach ($row as $key => $value) 
        {
            $cwr=chr(65+$key).'1';
            $objPHPExcel->getActiveSheet()->SetCellValue($cwr, $value);
        }
/*"uid"]=> string(6) "123762" ["cell_phone"]=> string(11) "13822220003" ["idcard"]=> string(18) "330823191255550003" ["real_name"]=> string(9) "两句话" ["age"]=> string(1) "0" ["address"]=> string(0) "" ["reg_time"]=> string(10) "1441010603" }*/
        foreach ($aim as $key => $value)
        {
            $arr[$key][]=$value['uid'];
            $arr[$key][]=$value['cell_phone'];
            $arr[$key][]=$value['idcard'];
            $arr[$key][]=$value['real_name'];
            $arr[$key][]=$value['age'];
            $arr[$key][]=$value['address'];
            $arr[$key][]=date('Y-m-d',$value['reg_time']);
        }

        $total = count($arr);//34

        $cr = count($arr['0']);//获取每个数组有几个元素用来控制列 9

        for($i=0;$i<$cr;$i++)
        {
            $cwr2=chr(64+$i+1);
            for($j=2;$j<$total+2;$j++)
            {
                $cwr=$cwr2.$j;//abcdefg
                $objPHPExcel->getActiveSheet()->SetCellValue($cwr,' '.$arr[$j-2][$i]);
            }
        }

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');

        //发送标题强制用户下载文件
        $filename='同一地区用户.xls';
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control:must-revalidate,post-check=0,pre-check=0");
        header("Content-Type:application/force-download");
        header("Content-Type:application/vnd.ms-execl");
        header("Content-Type:application/octet-stream");
        header("Content-Type:application/download");
        header("Content-Disposition:attachment;filename=".$filename);
        header("Content-Transfer-Encoding:binary");

        $objWriter->save('php://output');

    }
	
}
