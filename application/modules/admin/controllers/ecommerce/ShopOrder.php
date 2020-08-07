<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class ShopOrder extends ADMIN_Controller
{

    private $num_rows = 20;

    public function __construct()
    {
        parent::__construct();
        $this->load->library('pagination');
        $this->load->model(array('Orders_model', 'Languages_model'));
    }

    public function index($page = 0)
    {
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Home Categories';
        $head['description'] = '!';
        $head['keywords'] = '';     

        $data['orders'] = $this->Orders_model->orderlist();
        $data['success_message']='';
        //print_r($data);die();
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/shoporders', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to shop categories'); 

        
    }


    public function editorder($id){
        //$orderid=$this->uri->segment('4');
        // die();
    $data = array();
        $head = array();
        $head['title'] = 'Administration - Order Edit';
        $head['description'] = '!';
        $head['keywords'] = ''; 
        $data['orderdetails']=$this->Orders_model->editdetails($id);
        //print_r($data);
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/editorders', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to shop order'); 
    }
    public function editorderdetails(){
    $id=$_POST['orderid'];
    $data=array();
    $data['product_name']=$_POST['product_name'];
    $data['product_size']=$_POST['product_size'];
    $data['product_color']=$_POST['product_color'];
    $result=$this->Orders_model->detailsedit($data,$id);
    if($result){
    $param=array();
    $param['mobile_no']=$_POST['mobile_no'];
    $param['payment_type']=$_POST['payment_type'];
    $param['final_amount']=$_POST['final_amount'];
    $this->Orders_model->order($param,$id);
     $data['orders'] = $this->Orders_model->orderlist();
     $data['success_message']='Your Order succesfully update';
      $head = array();
        $head['title'] = 'Administration - Order Edit';
        $head['description'] = '!';
        $head['keywords'] = ''; 
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/shoporders', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to shop categories');
  }else{
  $data['orders'] = $this->Orders_model->orderlist();
        $data['error_message']='Your update fails';
        $head = array();
        $head['title'] = 'Administration - Order Edit';
        $head['description'] = '!';
        $head['keywords'] = ''; 
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/shoporders', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to shop categories'); 
   }
  }

  public function delete($id){
    $query=$this->Orders_model->detele($id);
   if($query){
    $data=array();
       $data['orders'] = $this->Orders_model->orderlist();
        $data['success_message']='Order delete succesfully';
        $head = array();
        $head['title'] = 'Administration - Order Edit';
        $head['description'] = '!';
        $head['keywords'] = ''; 
        $this->load->view('_parts/header', $head);
        $this->load->view('ecommerce/shoporders', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to shop categories'); 
   }
  }    

}
