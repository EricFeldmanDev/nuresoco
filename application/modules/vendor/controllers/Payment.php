<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Payment extends VENDOR_Controller
{

    private $num_rows = 1000;

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Products_model');
    }

    /* public function index(){
       $data = array();
       $head = array();
       $head['title'] = lang('vendor_products');
       $head['description'] = lang('vendor_products');
       $head['keywords'] = '';

       $this->load->view('_parts/header', $head);
       $this->load->view('promote');
       $this->load->view('_parts/footer');
       
    } */

    /*public function provider_payment(){
        // echo 'd'; exit;

        $data['title'] = 'Payment Service';
        $this->load->library('user_agent');
        $referrer = $this->agent->referrer();
        $post=$this->input->post();
        if($post){
                $validation_post = array(
                    array('field' => 'business_name','label' => 'Busniess Name','rules' => 'trim|required'),
                    array('field' => 'business_address', 'label' =>'Business Address', 'rules' => 'trim|required'),
                    array('field' => 'business_city', 'label' =>'Busniess City', 'rules' => 'trim|required'),
                    array('field' => 'business_state', 'label' =>'Busniess State', 'rules' => 'trim|required'),
                    array('field' => 'business_postal_code', 'label' =>'Busniess Postal Code ', 'rules' => 'trim|required'),
                    array('field' => 'routing_number', 'label' =>'Routing Number', 'rules' => 'trim|required'),
                    array('field' => 'account_number', 'label' =>'Account Number', 'rules' => 'trim|required'),
                    array('field' => 'country', 'label' =>'Country', 'rules' => 'trim|required'),
                    array('field' => 'email', 'label' =>'Email', 'rules' => 'trim|required'),
                    array('field' => 'first_name', 'label' =>'First Name', 'rules' => 'trim|required'),
                    array('field' => 'last_name', 'label' =>'Last Name', 'rules' => 'trim|required'),
                    array('field' => 'dob', 'label' =>'Date Of birth', 'rules' => 'trim|required'),
                    array('field' => 'address', 'label' =>'Account Holder Address', 'rules' => 'trim|required'),
                    array('field' => 'city', 'label' =>'Account Holder City', 'rules' => 'trim|required'),
                    array('field' => 'state', 'label' =>'Account Holder State', 'rules' => 'trim|required'),
                    array('field' => 'postal_code', 'label' =>'Account Holders Postal Code', 'rules' => 'trim|required')
                );

                $this->load->library('form_validation');
                $this->form_validation->set_rules($validation_post);
                if($this->form_validation->run() === TRUE) {
                    if($this->provider_payment_model->provider_payment($post))
                    {
                        $this->session->set_flashdata("flashSuccess","Payment Details Have Added Successfully!");
                    }else{
                        $this->session->set_flashdata("flashError","An error occured Or Stripe account not responsnding!");
                    }
                    redirect($referrer);
                }else{
                    $this->session->set_flashdata("flashError","All Fields Are Mandatory!");
                }
        }
            //$provider_id = $this->site_santry->get_provider_auth_data('id');
            $this->load->model('provider_model');
            $data['appointment_links'] = $this->provider_model->getAppointedLinks();
            $data['paymentDetails'] = $this->provider_model->get_payment_details();
            $data['provider_details'] = $this->provider_payment_model->checkProvider($provider_id);
            $this->layout->view('providers/payment',$data);
    }*/
    



}
