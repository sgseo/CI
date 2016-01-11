<?php
class Test extends CI_controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    //测试查询
    public function selscore()
    {
        $q=$this->db->select('id,age,score,name,grade')->get_where("chengji",array('id'=>'1'));
       // echo $this->db->last_query();

        foreach ($q->result_array() as $row)
            {
                $res[]=$row;
            }
            var_dump($q->result_array());
    }
    //测试插入
    public function testadd()
    {
        $data=array(array('age'=>8,"score"=>61,"name"=>'lj',"grade"=>'E'),array('age'=>'9',"score"=>62,'name'=>'xm',"grade"=>'E'));
       $sql=$this->db->insert_string('chengji',$data);//只是返回sql语句并不执行
       echo $sql;
       // $this->db->set('name',"wangba")->insert('chengji');
        $res=$this->db->insert_batch('chengji',$data);
        var_dump($res);
    }

    public function testred()
    {
         $this->db->select_sum("age",'dog');
         $query=$this->db->get('chengji');
       //  echo "<pre/>";var_dump($query);
       //  var_dump($query->result());
         foreach ($query->result() as $row)
            {
                $ccc= $row->dog;
            }

            echo $ccc;
    }
    public function join()
    {
        $this->db->select('*');
        $this->db->from('chengji as a');
        $this->db->join('grade as b', 'a.id = b.id','right');
        $this->db->where('a.id!=',2);
        $query = $this->db->get_compiled_select();
        echo $query;
        // foreach ($query->result() as $row)
        //     {
        //         $ccc[]= $row->age;
        //     }
        //     var_dump($ccc);
    }
    public function wherein()
    {   
        $names=array('xixi','lj','xm');
        $this->db->where_in('name',$names);
        echo $this->db->get_compiled_select('chengji');
    }

    public function like()
    {
        $this->db->like('name','jlj');
         echo $this->db->get_compiled_select('chengji');
    }
    public function groupby()
    {
        $this->db->group_by('name');
       echo $this->db->get_compiled_select('chengji');
    }
    public function replace()
    {
        $data = array(
        'name'  => 'My name',
        'score'  => '90'
        );
        $this->db->replace('chengji', $data);
    }
    public function testnum()
    {
        $num='113.455';
        $num2='0.34';
        $num3=53.65;
        $num4=65.01;
        $num5=66.44;
        echo number_format($num,2);
    }
}