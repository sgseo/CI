<?php
class Area extends CI_Controller{

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
        
        echo curl_error($ch);
      
        $result = json_decode($result,1);

    // if(!empty($_GET['real_name']))
    //     {
    //         $mobile=$_GET['real_name'];

    //         foreach ($result['data'] as $key => $value) 
    //         {
    //             if($value['real_name']==$mobile)
    //             {
    //                 $k=$value;
    //             }
    //         }
    //         $res[]=$k;
    //         $this->result=$res;
    //         $this->spc=1;
    //         $this->cls=0;
    //     //  $this->single_bonus=$k['bonus'];//个人总贡献
    //         $this->show();
    //         return;
    //     }

    //     // 把数组存储到cookie 因为3.1开始支持 存储数组 首先要序列化

    //     cookie("menu",serialize($result));

    //     //把身份证中间八位隐藏掉
    //     foreach ($result['data'] as $key => $value)
    //     {
    //         $result['data'][$key]['idcard']=substr_replace($value['idcard'],'****',6,8);
    //         $result['data'][$key]['cell_phone']=substr_replace($value['cell_phone'],'****',3,4);
    //     }


    //     //模拟分页
    //     $count =count($result['data']);//总共有多少条函数

    //     $single_page_count = 10;//每页显示ds条

    //     $total=ceil($count/$single_page_count);//总页数

    //     $p=I('get.p')?I('get.p'):1;//当前的页码
    
    //     $cur_list_start = ($p-1)*$single_page_count;//当前页开始的那一条是第几条记录
        
    //     $this->p=$p;//页码

    //     $this->total=$total;//总页数

    //     $this->spc=$single_page_count;//每页显示多少条

    //     $this->cls=$cur_list_start;//每页的开始点

    //     $this->result=$result['data'];

        //$this->show();
        $this->load->view("home/area/index.html");

    }

}