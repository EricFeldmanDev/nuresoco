<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Blog extends ADMIN_Controller
{

    public function __construct(){
        parent::__construct();
        $this->load->model('Blog_model');        
    }

    public function index() {   
       $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - About Us';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data=$_POST;
        $this->load->view('_parts/header', $head);
        $this->load->view('textual_pages/About-us/addAboutPage');
        $this->load->view('_parts/footer');   
          
    }


   
    
}
