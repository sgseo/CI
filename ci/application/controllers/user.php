<?php  
     class User extends CI_Controller{  
    //构造函数  
    function __construct()  
    {  
       parent::__construct();  
       //载入用户模型  
      $this->load->model("User_model");  
      $this->load->helper('url');
      $this->load->library('session');//加载 session 类
      $this->load->helper('html');
      $this->load->library('parser');
      header("content-type:text/html;charset=utf-8");
    }  
    //显示用户信息列表  
   public function index() 
    { //调用用户模型中的get方法，将结果集返回给$query  
      $this->load->library('javascript');//加载javascript类库
  
      $this->load->library('pagination');       //导入分页类   
 
      $config['base_url'] = base_url().'index.php/user/index/'; //导入分页类URL(就是要实现分页的那个模板页的路径)

      $total_rows=$this->User_model->cha();

      $config['total_rows'] = $total_rows;  //计算总记录数

      $config['per_page'] = '2';         //每页显示的记录数

      $config['cur_tag_open'] = '[';
      //“当前页”链接的打开标签。
      $config['cur_tag_close'] = ']';
      //“当前页”链接的关闭标签。
      $config['full_tag_open'] = '';     

      $config['full_tag_close'] = '';
     //将结果集作为关联数组返回           
      $data['url'] = base_url();

      $this->pagination->initialize($config); //初始化分类页
   
      $list=$this->User_model->cha($config['per_page'],$this->uri->segment(3));//每一页的内容

      $data['userList']=$list->result_array();

      $data['page']=$this->pagination->create_links(); 

      $item=$this->session->userdata('ip_address');

      $user=array('name' =>'jhon' ,'mail'=>'123@qq.com' );

      $this->session->set_userdata($user);

      $this->parser->parse('user/user',$data);

     }  

    public function add(){
      //载入验证类
      $this->load->library("form_validation");

      //获取 传送的 参数

      $name=$this->input->post("name");

      $nickname=$this->input->post("nickname");

      $password=$this->input->post('password');

      $confirm=$this->input->post('confirm');

      $mail=$this->input->post('mail');

      $this->form_validation->set_rules('name', 'name', 'required');
      $this->form_validation->set_rules('nickname', 'nickname', 'required');
      $this->form_validation->set_rules('password', 'Password', 'required');
      //$this->form_validation->set_rules('password', 'Password', 'required');
      $this->form_validation->set_rules('confirm', 'Password Confirmation', 'required|matches[password]');
      $this->form_validation->set_rules('mail', 'Email', 'required|valid_email');


      if($this->form_validation->run()==false){
        echo validation_errors();
        echo "wrong";
      }else{

        echo "一切ok";
      }
 
      $result=$this->User_model->add($name,$nickname);

    }

    PUBLIC function DELE()
    {
      $data=$this->User_model->dele();

      if($data){
                echo "ok";
               }else{
           
          
        
               }
    }

    public function modify(){

    
   
      $result=$this->User_model->modify();
    

      if($result)
      {
       // show_error('没有更新');
      }else{
        
      }


    }

    public function upld(){

       
       $result=$this->User_model->upld();

       if($result)
       {
        echo "111";
       }else{
        echo "222";
       }

      }

      public function secret(){

        $this->load->library("encrypt");//加载encrypt加密类

        //接收加密 字符串
        //$sec=$this->input->post('password');
        $sec="123456";
        //进行加密
        $new_sec=$this->encrypt->encode($sec);

        echo $new_sec;
      }


        function valid(){

          $this->load->helper('email');

        if (valid_email('email@somesite.com'))
        {
            echo 'email is valid';
        }
        else
        {
            echo 'email is not valid';
        }

        }
//segment
        function  seg(){

         // $str="http//localhost/ci/index.php/user/seg";//你的url地址
         //  echo $this->uri->segment(3,'no');//no 如果没有第三部分就输出 no 你可以自定义。

          // echo $this->uri->slash_segment(2,'leading');// /seg slash_segment()的leading 就是在前面添加一个斜杠 "/"
          //echo $this->uri->slash_segment(2,'both');// /seg/ 就是在前面和后面各添加一个斜杠 "/"
        // echo $this->uri->slash_segment(2); // /seg
          var_dump($this->uri->uri_to_assoc(3));// 把url的index.php后面的各个分段  组成一个数组 array() array(1) { ["seg"]=> bool(false) }

          $array = array('product' => 'shoes', 'size' => 'large', 'color' => 'red');

          echo $this->uri->assoc_to_uri($array);
        }


    } //eof user
?>