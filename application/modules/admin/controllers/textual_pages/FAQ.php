<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class FAQ extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Faq_model');
        
    }

    
   
    public function index() {
        $page='faq';
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - FAQ';
        $head['description'] = '!';
        $head['keywords'] = '';  
        $data['data']=$this->Faq_model->getContent();
        $this->load->view('_parts/header', $head);
        $this->load->view('textual_pages/FAQ/allFaqContent',$data);
        $this->load->view('_parts/footer');
    }

    public function addFAQ() {   
       $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - FAQ';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data=$_POST;
        if($data){
           $addData=$this->Faq_model->addFAQ($data);
           if($addData==1){
             $this->session->set_userdata('message','Content Have Added Successfully');
             redirect(WEB_ROOT."admin/faq");
           }
        }

       $this->load->view('_parts/header', $head);
       $this->load->view('textual_pages/FAQ/addFAQPage');
       $this->load->view('_parts/footer');      
    }
    
    public function updateFAQ($id) {
        $id=base64_decode($id);
        $page='about-us';
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - About Us';
        $head['description'] = '!';
        $head['keywords'] = ''; 
        if($_POST){
          $data=$this->Faq_model->updateFAQ($_POST);
          if($data==1){
            $this->session->set_userdata('upd_msg','FAQ have updated succesfully');
            redirect(WEB_ROOT."admin/faq");  
          } 
        } 
        $data['data']=$this->Faq_model->getFAQbyId($id);
        $this->load->view('_parts/header', $head);
        $this->load->view('textual_pages/FAQ/updateFAQPage', $data);
        $this->load->view('_parts/footer');
    }

    public function removeFAQcontent($id) {   
      $del=$this->Faq_model->removeFAQ($id);
      if($del==1){
         $this->session->set_userdata('del_msg','FAQ Content have deleted ');
        redirect(WEB_ROOT."admin/faq");
      }
       redirect(WEB_ROOT."admin/faq");
    }



   
   
    
}
