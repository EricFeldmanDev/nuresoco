<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Users extends ADMIN_Controller
{
	
	private $num_rows = 10;
	
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Users_model');
    }

    public function index($page = 0)
    {
        $this->login_check();
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Users';
        $head['description'] = '!';
        $head['keywords'] = '';
		
        unset($_SESSION['filter']);
        $user_name = null;
        if ($this->input->get('user_name') !== NULL) {
            $user_name = $this->input->get('user_name');
            $_SESSION['filter']['user_name'] = $user_name;
            $this->saveHistory('Search for user name - ' . $user_name);
        }
		
        $orderby = null;
        if ($this->input->get('order_by') !== NULL) {
            $orderby = $this->input->get('order_by');
            $_SESSION['filter']['order_by '] = $orderby;
        }
		
		$rowscount = $this->Users_model->usersCount($user_name);
		$data['users'] = $this->Users_model->getUsers($this->num_rows, $page, $user_name, $orderby);
        $data['links_pagination'] = pagination('admin/users', $rowscount, $this->num_rows, 3);
		//pr($data,1);
		
        $this->load->view('_parts/header', $head);
        $this->load->view('advanced_settings/users', $data);
        $this->load->view('_parts/footer');
        $this->saveHistory('Go to Admin Users');
    }
	
	public function deleteUser($id){
		
		$table='users_public';
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
		$this->session->set_flashdata('flashSuccess','User Has Been Deleted Successfully');
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
		$this->commonmodel->_update('users_public',array('status'=>$change_activation_status),$condition);
		$this->session->set_flashdata('flashSuccess','Status Has Been Updated Successfully');
		redirect($referrer);
	}
		
	public function change_spam_status(){
		$id_encode   		= $this->uri->segment(4);
		$id		  		= base64_decode($id_encode);
		$activation_status	= base64_decode($this->uri->segment(5));
		
		$this->load->library('user_agent');
		$referrer = $this->agent->referrer();
		
		$change_activation_status ='0';
		if($activation_status=='0'){
			$change_activation_status	=	'1';
			$message = 'User added to spam list successfully.';
		}
		if($activation_status=='1'){
			$change_activation_status	=	'0';
			$message = 'User removed from spam list successfully.';
		}
		
		$condition = array('id' => $id);
		$this->commonmodel->_update('users_public',array('is_spammer'=>$change_activation_status),$condition);
		$this->session->set_flashdata('flashSuccess',$message);
		redirect($referrer);
	}

}
