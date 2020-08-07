<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class CustomerSupport extends ADMIN_Controller {
    private $num_rows = 10;
    public function __construct() {
        parent::__construct();
        $this->load->model('CustomerMail_model');
        $this->load->library('Pagination');
        $this->load->helper('url');
    }

    
    public function paginations() {   
       $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - About Us';
        $head['description'] = '!';
        $head['keywords'] = '';
        
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = $this->CustomerMail_model->total_mails();
        if ($total_records > 0){
            $data["mailData"] = $this->CustomerMail_model->get_mails($this->num_rows, $start_index);
            $data['links'] = pagination('admin/customer-mails', $total_records, $this->num_rows, 3);
        }

        /*$params = array();
        $limit_per_page = 10;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = $this->CustomerMail_model->total_mails();
        if ($total_records > 0) {
            $data["mailData"] = $this->CustomerMail_model->get_mails();     
            
        }*/

        //$data['mailData']=$this->CustomerMail_model->get_allMails();
        $this->load->view('_parts/header', $head);
        $this->load->view('textual_pages/Customer-support/allMailsDetails',$data);
        $this->load->view('_parts/footer');   
          
    }


    public function removeData($id) { 

      $del=$this->CustomerMail_model->removeData($id);
      if($del==1){
         $this->session->set_userdata('del_msg','List have deleted succesfully');
        redirect(WEB_ROOT."admin/customer-mails");
      }
       redirect(WEB_ROOT."admin/customer-mails");
    }


   
    
}
