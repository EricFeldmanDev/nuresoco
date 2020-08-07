<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Promote extends VENDOR_Controller
{

    private $num_rows = 20;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Promote_model');
    }

    public function index(){
       $data = array();
       $head = array();
       $head['title'] = lang('promote_page');
       $head['description'] = lang('promote_page');
       $head['keywords'] = '';
       $this->load->view('_parts/header', $head);
       $this->load->view('promote');
       $this->load->view('_parts/footer');
       
    }

    public function products(){
       $v_id=$this->vendor_id;
       $data = array();
       $head = array();
       $head['title'] = lang('vendor_products');
       $head['description'] = lang('vendor_products');
       $head['keywords'] = '';
       $data['products']=$this->Promote_model->getProducts($v_id);
       $this->load->view('_parts/header', $head);
       $this->load->view('promote_product',$data);
       $this->load->view('_parts/footer');
       
    }

    public function promote_now($id){
       
       $v_id=$this->vendor_id;
       $data = array();
       $head = array();
       $head['title'] = lang('promote_now');
       $head['description'] = lang('promote_now');
       $head['keywords'] = '';
       $this->load->view('_parts/header', $head);
       $this->load->view('promote_now_people',$data);
       $this->load->view('_parts/footer');  
    }

    public function promote_total_spend(){ 
       $v_id=$this->vendor_id;
       $data = array();
       $head = array();
       $head['title'] = lang('promote_total_spend');
       $head['description'] = lang('promote_total_spend');
       $head['keywords'] = '';
       $data['post']=$_POST;
       $this->load->view('_parts/header', $head);
       $this->load->view('promote_total_spend',$data);
       $this->load->view('_parts/footer');
       
    }

    public function promote_preview(){
       
       $data = array();
       $head = array();
       $head['title'] = lang('promote_total_spend');
       $head['description'] = lang('promote_total_spend');
       $head['keywords'] = '';
       
	   $post = $this->input->post();   
	   $post['budget']= (BUDGET_PERDAY_VALUE * $this->input->post('duration'));
	   $data['post'] = $post;
       $this->load->view('_parts/header', $head);
       $this->load->view('promote_preview',$data);
       $this->load->view('_parts/footer');
    }    

    public function promote_now_submit($id){
       
	   $v_id=$this->vendor_id;
       $data = array();
       $head = array();
       $head['title'] = lang('promote_total_spend');
       $head['description'] = lang('promote_total_spend');
       $head['keywords'] = '';
       
	   
	   $post = $this->input->post();
	   $post['p_id'] = base64_decode($id);
	   $post['budget']= (BUDGET_PERDAY_VALUE * $this->input->post('duration'));
	   if(isset($_POST['btnSub'])) $this->Promote_model->submitForm($post,$v_id);
       redirect('vendor/promoteProducts');
    }    


}
