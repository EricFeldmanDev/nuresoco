<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends MY_Controller
{

    private $registerErrors = array();
    private $user_id;

    public function __construct()
    {
       // echo LANG_URL; exit;
        parent::__construct();
        $this->load->library('email');
        if($this->session->userdata('logged_user'))
        {
            redirect(LANG_URL);
        }
    }

    public function index() 
    {
        show_404();
    }

    public function login()
    {
		if ($this->input->post()) {
            $result = $this->Public_model->checkPublicUserIsValid($_POST);
			if ($result !== false) {
				/* && $result['verification_status']==1 */
                if($result['status']==1 && $result['delete_status']==0)
				{
					$_SESSION['logged_user'] = $result; //id of user
					// if($this->session->userdata('login_redirection_page')!='')
					// {
					// 	$login_redirection_page = $this->session->userdata('login_redirection_page');
					// 	$this->session->unset_userdata('login_redirection_page');
					// 	redirect($login_redirection_page);
					// }else{                        
						redirect(LANG_URL);
					// }
				}/* elseif($result['verification_status']==0){
					$this->session->set_flashdata('flashError', 'Please verify your email id first.');
				} */elseif($result['delete_status']==1){
					//$this->session->set_flashdata('flashError', 'Your account is deleted by administrator.');
					$this->session->set_flashdata('flashError', 'You are not registered with us.Please register first!');
				}elseif($result['status']==0){
					$this->session->set_flashdata('flashError', 'Your account is deactivated by administrator.');
				}
            } else {
                $this->session->set_flashdata('flashError', lang('wrong_user'));
            }
        }
        $head = array();
        $data = array();
        $head['title'] = lang('user_login');
        $head['description'] = lang('user_login');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
		
		$this->load->library('user_agent');
		$referrer = $this->agent->referrer();
		$this->session->set_userdata('login_redirection_page',$referrer);
        $this->render('login', $head, $data);
    }

    public function register()
    {
        if ($this->input->post()) {
            $result = $this->registerValidate();
            if ($result == false) {
                $this->session->set_flashdata('flashError', $this->registerErrors);
                redirect(LANG_URL . '/register');
            } else {
                //$this->session->set_flashdata('success', 'An verification link sent on your email.Please verify first and login here!');
				$this->session->set_flashdata('success', 'login in here');
                //$_SESSION['logged_user'] = $this->user_id; //id of user
                redirect(LANG_URL . '/login');
            }
        }
        $head = array();
        $data = array();
        $head['title'] = lang('user_register');
        $head['description'] = lang('user_register');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $this->render('signup', $head, $data);
    }

    public function verifyUserAccount($email,$verification_token)
    {
		$this->Public_model->verifyUserAccount($email,$verification_token);
    }

    public function myaccount()
    {
        if (isset($_POST['update'])) {
            $_POST['id'] = $_SESSION['logged_user'];
            $count_emails = $this->Public_model->countPublicUsersWithEmail($_POST['email'], $_POST['id']);
            if ($count_emails == 0) {
                $this->Public_model->updateProfile($_POST);
            }
            redirect(LANG_URL . '/myaccount');
        }
        $head = array();
        $data = array();
        $data['userInfo'] = $this->Public_model->getUserProfileInfo($_SESSION['logged_user']);
        $head['title'] = lang('my_acc');
        $head['description'] = lang('my_acc');
        $head['keywords'] = str_replace(" ", ",", $head['title']);
        $this->render('user', $head, $data);
    }
	
	public function verify_forgot_password($email,$token)
	{
		$data = array();
        $head = array();
        $head['title'] = lang('user_forgotten_page');
        $head['description'] = lang('recover_password');
        $head['keywords'] = '';
		$condition = array('email'=>$email,'status'=>'1','delete_status'=>'0');
		$details = $this->db->select('*')->from('users_public')->where($condition)->get();
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
						$newPass = md5($newPass);
						$update_data = array('password'=>$newPass,'forgot_verify_code'=>'','verification_token'=>'','verification_status'=>'1');
						$this->commonmodel->_update('users_public',$update_data,array('id'=> $emailDetails['id']));
						$this->session->set_flashdata('success','Password changed successfully.You can login now.');
						redirect('login');
					}
				}else{
					$this->render('change_forgot_password', $head, $data);
				}
			}else{
				$this->session->set_flashdata('flashError',array('This link is expired.Please try again by forgot password section.'));
				redirect('login');
			}
		}else{
			$this->session->set_flashdata('flashError',array('You are not register with us.Please register first.'));
			redirect('login');
		}
	}

    public function forgotten()
    {
        if (isset($_POST['u_email'])) {
            $user = $this->Public_model->getUserInfoFromEmail($_POST['u_email']);
			if ($user != null) {
			
				$mod_date	=	date('Y-m-d H:i:s');
				$token	=	md5($this->get_token(15));
				$detail 	= 	array(
							'forgot_verify_code'	=> $token,
							'updated_at'			=>	$mod_date,
						);
				$email_link = base_url('forgot-password-vefication/'.$_POST['u_email'].'/'.$token);
				$subject = NAME_IN_MAIL.' Forgot Password';
				$message = 'Hello,<br/>';
				$message .= '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Your '.NAME_IN_MAIL.' password recovery url is <a href="'.$email_link.'">'.$email_link.'</a><br/>';
				$message .= 'Thank you<br/>';
				$message .= NAME_IN_MAIL.' Team';
				
                $this->sendmail->sendTo($_POST['u_email'], NAME_IN_MAIL, $subject, $message);
				$this->commonmodel->_update('users_public', $detail, array('email'=>trim($_POST['u_email'])));
                $this->session->set_flashdata('success', 'An vefication mail sent on your email id.Please verify to login');
                redirect(LANG_URL . '/login');
            }
        }

        $data = array();
        $head = array();
        $head['title'] = lang('user_forgotten_page');
        $head['description'] = lang('recover_password');
        $head['keywords'] = '';

		$this->render('recover_pass', $head, $data);
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

    public function logout()
    {
        unset($_SESSION['logged_user']);
        redirect(LANG_URL);
    }

    private function registerValidate()
    {
        $errors = array();
        if (mb_strlen(trim($_POST['name'])) == 0) {
            $errors[] = lang('please_enter_name');
        }
        /* if (mb_strlen(trim($_POST['phone'])) == 0) {
            $errors[] = lang('please_enter_phone');
        } */
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = lang('invalid_email');
        }
        if (mb_strlen(trim($_POST['pass'])) == 0) {
            $errors[] = lang('enter_password');
        }
        if (mb_strlen(trim($_POST['pass_repeat'])) == 0) {
            $errors[] = lang('repeat_password');
        }
        if ($_POST['pass'] != $_POST['pass_repeat']) {
            $errors[] = lang('passwords_dont_match');
        }
        $count_emails = $this->Public_model->countPublicUsersWithEmail($_POST['email']);
		//pr($count_emails,1);
        if ($count_emails > 0) {
            $errors[] = lang('user_email_is_taken');
        }
        if (!empty($errors)) {
            $this->registerErrors = $errors;
            return false;
        }
        $this->user_id = $this->Public_model->registerUser($_POST);
        return true;
    }

    public function myserach(){
        echo "string";
        print_r($_POST);
    }

}
