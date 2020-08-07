<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Auth extends VENDOR_Controller
{

    private $registerErrors = array();

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Auth_model', 'Vendorprofile_model'));
    }

    public function index()
    {
        show_404();
    }

    public function login()
    {
        
        $data = array();
        $head = array();
        $head['title'] = lang('user_login_page');
        $head['description'] = lang('open_your_account');
        $head['keywords'] = '';

        if (isset($_POST['login'])) {
            $result = $this->verifyVendorLogin();
            if ($result == false) {
                $this->session->set_flashdata('login_error', lang('login_vendor_error'));
                redirect(LANG_URL . '/vendor/login');
            } else {
                $remember_me = false;
                if (isset($_POST['remember_me'])) {
                    $remember_me = true;
                }
                $this->setLoginSession($_POST['u_email'], $remember_me);
                redirect(LANG_URL . '/vendor/sales-merchant');
            }
        }
        $this->load->view('_parts/header_auth', $head);
        $this->load->view('auth/login', $data);
        $this->load->view('_parts/footer_auth');
    }

    private function verifyVendorLogin()
    {
        return $this->Auth_model->checkVendorExsists($_POST);
    }

    public function register()
    {
        $data = array();
        $head = array();
        $head['title'] = lang('user_register_page');
        $head['description'] = lang('create_account');
        $head['keywords'] = '';
		//print_r($_POST,1);exit;
        if ($_POST) {
            $result = $this->registerVendor();
			if ($result == false) {
                $this->session->set_flashdata('error_register', $this->registerErrors);
                $this->session->set_flashdata('email', $_POST);
                redirect(LANG_URL . '/vendor/register');
            } else {
                $sess_array=$this->input->post('vendor_email');
                $this->session->set_userdata('logged_vendor', $sess_array);
                redirect(LANG_URL . '/vendor/sales-merchant');
                //$this->setLoginSession($_POST['vendor_email'], false);
                //redirect(LANG_URL . '/vendor/login');
            }
        }
		$data['categories'] = $this->Auth_model->getShopCategories();
		$data['countries'] = $this->Public_model->getCountries();
		//pr($data['categories'],1);
        $this->load->view('_parts/header_auth', $head);
        $this->load->view('auth/register', $data);
        $this->load->view('_parts/footer_auth');
    }
    public function temporaryVendorInfo(){
        return $this->deleteVendorInfo();
    }

    public function shoppingApproach()
    {
        $data = array();
        $head = array();
        $head['title'] = lang('user_register_page');
        $head['description'] = lang('create_account');
        $head['keywords'] = '';
        $this->load->view('_parts/header_auth', $head);
        $this->load->view('auth/shopping-approach', $data);
        $this->load->view('_parts/footer_auth');
    }

    public function successstory()
    {
        $data = array();
        $head = array();
        $head['title'] = lang('user_register_page');
        $head['description'] = lang('create_account');
        $head['keywords'] = '';
        $this->load->view('_parts/header_auth', $head);
        $this->load->view('auth/story', $data);
        $this->load->view('_parts/footer_auth');
    }

    public function change_theme($theme = 'light')
    {
		if($theme=='dark')
		{
			$_SESSION['vendor_theme'] = 'dark';
		}else{
			$_SESSION['vendor_theme'] = 'light';
		}
		$this->load->library('user_agent');
		$referrer = $this->agent->referrer();
		redirect($referrer);
    }

    public function getStates()
    {
		$post = $this->input->post();
		$country_id = $post['country_id'];
		$response = $this->Public_model->getStates($country_id);
		echo $response;
    }

    public function getCities()
    {
		$post = $this->input->post();
		$state_id = $post['state_id'];
		$response = $this->Public_model->getCities($state_id);
		echo $response;
    }

    public function verifyAccount($email,$verification_token)
    {
		$this->Auth_model->verifyAccount($email,$verification_token);
    }

    private function registerVendor()
    {

        $errors = array();
        if (mb_strlen(trim($_POST['vendor_password'])) == 0) {
            $errors[] = lang('please_enter_password');
        }
        if (mb_strlen(trim($_POST['vendor_confirm_password'])) == 0) {
            $errors[] = lang('please_repeat_password');
        }
        if ($_POST['vendor_password'] != $_POST['vendor_confirm_password']) {
            $errors[] = lang('passwords_dont_match');
        }
        if (!filter_var($_POST['vendor_email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = lang('vendor_invalid_email');
        }
        $count_emails = $this->Auth_model->countVendorsWithEmail($_POST['vendor_email']);
        if ($count_emails > 0) {
			$verificationStatus = $this->Auth_model->check_if_vendor_verified($_POST['vendor_email']);
			$verificationStatus = $verificationStatus['verification_status'];
			if ($verificationStatus==1) {
				$errors[] = lang('vendor_email_is_taken');
			}
        }
        if (!empty($errors)) {
            $this->registerErrors = $errors;
            return false;
        }
        $this->Auth_model->registerVendor($_POST);
        return true;
    }
	
	public function verify_forgot_password($email,$token)
	{
		$data = array();
        $head = array();
        $head['title'] = lang('user_forgotten_page');
        $head['description'] = lang('recover_password');
        $head['keywords'] = '';
		$condition = array('email'=>$email,'status'=>'1','delete_status'=>'0');
		$details = $this->db->select('*')->from('vendors')->where($condition)->get();
		if($details->num_rows()>0)
		{
			$emailDetails = $details->result_array();
			$emailDetails = $emailDetails[0];
			if($emailDetails['forgot_verify_code']!="")
			{
				if($this->input->post())
				{
					if($this->input->post('password') != $this->input->post('confirmpassword'))
					{
						$this->load->library('user_agent');
						$this->session->set_flashdata('flashError',array("Password doesn't match.Please enter same password."));
						redirect($this->agent->referrer());
					}else{						
						$newPass = $this->input->post('password');
						$newPass = password_hash($newPass, PASSWORD_DEFAULT);
						$update_data = array('password'=>$newPass,'forgot_verify_code'=>'','verification_token'=>'','verification_status'=>'1');
						$this->commonmodel->_update('vendors',$update_data,array('id'=> $emailDetails['id']));
						$this->session->set_flashdata('success','Password changed successfully.You can login now.');
						redirect('vendor/login');
					}
				}else{
					$data['title'] = 'Reset password';					
					$this->load->view('_parts/header_auth', $head);
					$this->load->view('auth/change_forgot_password', $data);
					$this->load->view('_parts/footer_auth');
				}
			}else{
				$this->session->set_flashdata('flashError',array('This link is expired.Please try again by forgot password section.'));
				redirect('vendor/login');
			}
		}else{
			$this->session->set_flashdata('flashError',array('You are not register with us.Please register first.'));
			redirect('vendor/login');
		}
	}

    public function forgotten()
    {
        if (isset($_POST['u_email'])) {
            $vendor = $this->Vendorprofile_model->getVendorInfoFromEmail($_POST['u_email']);
            if ($vendor != null) {
			
				$mod_date	=	date('Y-m-d H:i:s');
				$token	=	md5($this->get_token(15));
				$detail 	= 	array(
							'forgot_verify_code'	=> $token,
							'updated_at'			=>	$mod_date,
						);
				$email_link = base_url('vendor/forgot-password-vefication/'.$_POST['u_email'].'/'.$token);
				$subject = NAME_IN_MAIL.' Forgot Password';
				$message = 'Hello,<br/>';
				$message .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Your '.NAME_IN_MAIL.' password recovery url is <a href="'.$email_link.'">'.$email_link.'</a><br/>';
				$message .= 'Thank you<br/>';
				$message .= NAME_IN_MAIL.' Team';
				
                $this->sendmail->sendTo($_POST['u_email'], NAME_IN_MAIL, $subject, $message);
				$this->commonmodel->_update('vendors', $detail, array('email'=>trim($_POST['u_email'])));
                $this->session->set_flashdata('success', 'An vefication mail sent on your email id.Please verify to login');
                redirect(LANG_URL . '/vendor/login');
            }
        }

        $data = array();
        $head = array();
        $head['title'] = lang('user_forgotten_page');
        $head['description'] = lang('recover_password');
        $head['keywords'] = '';

        $this->load->view('_parts/header_auth', $head);
        $this->load->view('auth/recover_pass', $data);
        $this->load->view('_parts/footer_auth');
    }
	
	public function get_token($length=10)
	{
		$characters = '0123456789';
		$otp_token = '';
		for ($i = 0; $i < $length; $i++) {
			  $otp_token .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $otp_token;
	}
	
	public function check_useremail(){
		$json=array();
		$user_email = $this->input->post('vendor_email');
		
		$data = $this->Auth_model->check_user_email($user_email);
		
		if($data > 0){
				$isAvailable = false; 
				$json=array('valid' => $isAvailable	);
		}else{
				$isAvailable = true; 
				$json=array('valid' => $isAvailable	);
		}
		echo json_encode($json);
		exit;
	}



    

}
