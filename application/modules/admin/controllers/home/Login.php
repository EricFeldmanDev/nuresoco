<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Login extends ADMIN_Controller
{

    public function index()
    {
        $data = array();
        $head = array();
        $head['title'] = 'Administration - Login';
        $head['description'] = '';
        $head['keywords'] = '';
        $this->load->view('_parts/header', $head);
        if ($this->session->userdata('logged_in')) {
            redirect('admin/home');
        } else {
            $this->form_validation->set_rules('username', 'Username', 'trim|required');
            $this->form_validation->set_rules('password', 'Password', 'trim|required');
            if ($this->form_validation->run($this)) {
                $result = $this->Home_admin_model->loginCheck($_POST);
                if (!empty($result)) {
                    //echo "yes1";
                    $_SESSION['last_login'] = $result['last_login'];
                    $this->session->set_userdata('logged_in', $result['username']);
                    //echo "yes2";
                    //$this->saveHistory('User ' . $result['username'] . ' logged in');
                    //echo "yes3";die;
                    redirect('admin/home');
                } else {
                    $this->saveHistory('Cant login with - User: ' . $_POST['username'] . ' and Pass: ' . $_POST['username']);
                    $this->session->set_flashdata('err_login', 'Wrong username or password!');
                    redirect('admin');
                }
            }
            $this->load->view('home/login');
        }
        $this->load->view('_parts/footer');
    }
	
	// **************** Only copied from another controller... Do changes accordingly.. **************** START
	
	/* public function verify_forgot_password($email,$token)
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
					$this->load->view('_parts/header', $head);
					$this->load->view('home/change_forgot_password');
					$this->load->view('_parts/footer');
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

		$this->load->view('_parts/header', $head);
		$this->load->view('home/recover_pass');
		$this->load->view('_parts/footer');
    }
	
	public function get_token($length=10)
	{
		$characters = '0123456789';
		$otp_token = '';
		for ($i = 0; $i < $length; $i++) {
			  $otp_token .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $otp_token;
	} */
	
	// **************** Only copied from another controller... Do changes accordingly.. **************** END
	
}
