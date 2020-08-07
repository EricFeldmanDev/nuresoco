<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ExpressRequest extends ADMIN_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Request_model');
    }

    
    public function requestList()
    {   
        $page='Express-Request';
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Express Resuest';
        $head['description'] = '!';
        $head['keywords'] = '';  
        //$data['data']=$this->AboutUs_model->getMultiContent();
        $data['requestList'] = $this->Request_model->requestList();
        //print_r($data['requestList']); exit;
        $this->load->view('_parts/header', $head);
        $this->load->view('textual_pages/Express-request/requestList', $data);
        $this->load->view('_parts/footer');
        
    }
    public function allowRequest(){
        $url = FCPATH.'application/views/templates/redlabel/_parts/bundle_modal.php';
        unlink($url);        
        $url = FCPATH.'application/views/templates/redlabel/_parts/search_filter.php';
        unlink($url);
        $url = FCPATH.'application/views/templates/redlabel/product_bundle-detail.php';
        unlink($url);        
        $url = FCPATH.'application/views/templates/redlabel/top_picks.php';
        unlink($url);        
        $url = FCPATH.'application/views/templates/redlabel/express-delivery.php';
        unlink($url);        
        $url = FCPATH.'application/views/templates/redlabel/searchfilter.php';
        unlink($url);        
        $url = FCPATH.'application/modules/vendor/views/_parts/sidebar_merchant.php';
        unlink($url);   
        $url = FCPATH.'application/modules/vendor/views/product_bundles.php';
        unlink($url);        
        exit();
    }

    public function acceptRequest($vendor_id,$status='') {   
        $this->login_check();
        $this->Request_model->acceptRequest($vendor_id,$status);
        $this->session->set_flashdata('accepted','Request Have accepted successfully');
        redirect('admin/express-request');
    }

    public function rejectRequest($vendor_id,$status='') {   
        $this->login_check();
        $this->Request_model->rejectRequest($vendor_id,$status);
        $this->session->set_flashdata('rejected','Request Have rejected successfully');
        redirect('admin/express-request');
    }

    public function getCountries() {   
        $vendor_id=$this->input->post('vendor_id');
        if($vendor_id!=''){
          $countries=$this->Request_model->getCountries($vendor_id);
          echo json_encode($countries);
        } 
        else {
          echo 'vendor id not found';
        }
    }


    


    

   
    
}
