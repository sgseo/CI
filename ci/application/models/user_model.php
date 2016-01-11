<?php  
     class User_model extends CI_Model {  
    //获取用户信息  
     public function cha($num=0,$offset=0)  
    {  
          
            $data = '';  
             //SQL语句的select部分，这里查询user表的所有字段  
            $this->db->select("u.id,u.name,u.nickname,i.b_thumb");
            $this->db->from("user as u");
            $this->db->join("img as i",'u.id=i.pid');
            $this->db->order_by("u.id asc");
            //运行选择查询语句并且返回结果集给$data
            if($num||$offset) 
            {
            $data=$this->db->get('',$num,$offset);     
            return $data;  
            }else{
              $data=$this->db->get('');
              $total_num=$data->num_rows();
              return $total_num;  
            }
         
     }

    public function add($name,$nickname){
      
      $data=array("name"=>$this->input->post('name'),"nickname"=>$this->input->post('nickname'));
     
      $result= $this->db->insert("user",$data);

      $this->db->close();

      return $result;  
     
    }
    public function dele(){

     $this->db->where("id",$this->input->post('deleid'));

     $result=$this->db->delete("user");

     $this->db->close();

     return $result;

    }

      public function modify(){

        $data=array("name"=>$this->input->post('name'),"nickname"=>$this->input->post('nickname'));

        $this->db->where("id",$this->input->post('deleid'));

        $result=$this->db->update("user",$data);

        
        $this->db->close();

        return $result;
    }

    public function upld(){

      //配置图片存放目录
      $config['upload_path']="./upload/source/".date("Y/m/d");//文件上传目录  
      if(!file_exists("./upload/source/".date("Y/m/d"))){  
                mkdir("./upload/source/".date("Y/m/d"),0777,true);//原图路径  
         }
      if(!file_exists("./upload/big_thumb/".date("Y/m/d"))){  
        mkdir("./upload/big_thumb/".date("Y/m/d"),0777,true);//大缩略图路径  
      } 
      /* 
      if(!file_exists("./upload/small_thumb/".date("Y/m/d"))){  
         mkdir("./upload/small_thumb/".date("Y/m/d"),0777,true);//小缩略图路径  
        }  */
      $config['allowed_types']="jpg|png|gif|txt";//允许上传的类型

      $config['max_size']="200000";

      $this->load->library("upload",$config);

      if($this->upload->do_upload("img"))//表单中name=img
      {
        $data=$this->upload->data();//返回上传图片的信息
      // var_dump($data);
        $this->load->library("image_lib");//载入图像处理类库
        //大缩略图配置参数
        $config_big_thumb['image_library']="gd2";//gd图库
        $config_big_thumb['source_image']=$data['full_path'];//["full_path"]=> string(64) "E:/wamp/www/ci/upload/source/2014/11/19/20120212144545_Qxcsy.jpg"
        // ["full_name"]=> Jellyfish2.jpg
        $config_big_thumb['new_image']= "./upload/big_thumb/".date("Y/m/d")."/".$data['file_name'];
        $config_big_thumb['create_thumb']=true;
        $config_big_thumb['width']=300;//大缩略图宽度
        $config_big_thumb['height']=300;//大缩略图高度
        $config_big_thumb['thumb_marker']="_300_300";//缩略图名字后加上 "_300_300",可以代表是一个300*300的缩略图  

        $this->image_lib->initialize($config_big_thumb);//初始化大缩略图参数
        $this->image_lib->resize();//生成大缩略图   

        $sql_name=substr($config_big_thumb['new_image'],0,-4).$config_big_thumb['thumb_marker'].$data['file_ext'];//保持数据的名字跟图片的名字保持一致
     
      //  echo $sql_name;

        //插入数据库
        $data_array = array('b_thumb' => $sql_name,'pid'=>$this->input->post('deleid'));

        $result=$this->db->insert("img",$data_array);
        
      //  echo $this->db->last_query();
        return $result;

      }

      }//upld end

     

     }  
?>