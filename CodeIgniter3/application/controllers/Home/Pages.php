<?php
class Pages extends CI_Controller{
    public function __Construct()
    {
        parent::__Construct();
    }
    public function view($p1,$p2)
    {   
        echo $p1.$p2;
    }
}