<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Welcome extends CI_Controller {

    public function __construct(){
        parent::__construct();

    }
    public function index()
    {
        $this->load->library('hulk_template');
        $this->hulk_template->parse('lay/welcome_message');
        //$this->load->view('welcome_message');
    }
}
