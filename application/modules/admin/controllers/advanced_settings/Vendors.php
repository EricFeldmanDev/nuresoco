<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Vendors extends ADMIN_Controller
{
	
	private $num_rows = 10;
	
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Vendors_model');
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Vendors';
        $head['description'] = '!';
        $head['keywords'] = '';
		
        unset($_SESSION['filter']);
        $vendor_name = null;
        if ($this->input->get('vendor_name') !== NULL) {
            $vendor_name = $this->input->get('vendor_name');
            $_SESSION['filter']['vendor_name'] = $vendor_name;
            $this->saveHistory('Search for vendor name - ' . $vendor_name);
        }
		
        $orderby = null;
        if ($this->input->get('order_by') !== NULL) {
            $orderby = $this->input->get('order_by');
            $_SESSION['filter']['order_by '] = $orderby;
        }
		
		$data['totalVendorsCount'] = $this->Vendors_model->vendorsCount();
		$rowscount = $this->Vendors_model->vendorsCount($vendor_name);
		$data['vendors'] = $this->Vendors_model->getVendors($this->num_rows, $page, $vendor_name, $orderby);
		
        $data['links_pagination'] = pagination('admin/vendors', $rowscount, $this->num_rows, 3);
		//pr($data,1);
		
        $this->load->view('_parts/header', $head);
        $this->load->view('advanced_settings/vendors', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Admin Users');
    }

    public function venderpayment(){
    	$data = array();
        $head = array();
        $head['title'] = 'Administration - Vendors payment';
        $head['description'] = '!';
        $head['keywords'] = '';
        $data['successmessage']='';
    	$venderid=$this->uri->segment('4');
    	$data['result']=$this->Vendors_model->orderpayment($venderid);
    	// echo "<pre>";
    	// print_r($data);die();
    	$this->load->view('_parts/header', $head);
        $this->load->view('advanced_settings/vendorpayment', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Admin Users');
    }

    public function paymentstatus(){
    	$orderid=$this->uri->segment('4');
    	
        $row=$this->Vendors_model->changestatus($orderid);
        if ($row) {
          redirect('admin/vendors');
        }

    }
	
	public function deleteVendor($id){
		
		$table='vendors';
		$id=base64_decode($id);
		
		$this->load->library('user_agent');
		$referrer = $this->agent->referrer();
		
		$condition = array('id' => $id);
		$rows = $this->commonmodel->_get_data_row('',$table,$condition);
		if($rows<1)
		{
			$this->session->set_flashdata('flashError','Please select valid entry.');
			redirect($referrer);
			exit;
		}
		
		$data = array('delete_status'=>'1');
		$this->commonmodel->_update($table, $data, $condition);
		$this->session->set_flashdata('flashSuccess','Vendor Has Been Deleted Successfully');
		redirect($referrer);
	}
		
	public function change_activation_status(){
		$id_encode   		= $this->uri->segment(4);
		$id		  		= base64_decode($id_encode);
		$activation_status	= base64_decode($this->uri->segment(5));
		
		$this->load->library('user_agent');
		$referrer = $this->agent->referrer();
		
		$change_activation_status ='0';
		if($activation_status=='0'){
			$change_activation_status	=	'1';
		}
		if($activation_status=='1'){
			$change_activation_status	=	'0';
		}
		
		$condition = array('id' => $id);
		$this->commonmodel->_update('vendors',array('status'=>$change_activation_status),$condition);
		$this->session->set_flashdata('flashSuccess','Status Has Been Updated Successfully');
		redirect($referrer);
	}

}
