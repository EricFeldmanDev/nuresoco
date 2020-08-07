<?php

class Auth_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function registerVendor($post)
    {
		unset($post['terms']);
		//pr($post,1);
		$vendor_email = $post['vendor_email'];
		$vendor_name = $post['vendor_name'];
		$verification_token = hash('sha256',md5($vendor_email.rand(10001,99999)));
		$verificationLink = base_url('vendor/verify-account/'.$vendor_email.'/'.$verification_token);
		
		$input = array('verification_token' => trim($verification_token));
		foreach($post as $key => $vals)
		{
			if($key=='vendor_password')
			{
				$input['password'] = password_hash($vals, PASSWORD_DEFAULT);
			}elseif($key=='vendor_name')
			{
				$input['name'] = trim($vals);
			}elseif(!($key=='vendor_email' || $key=='vendor_confirm_password' || $key=='categories' || $key=='register')){
				$input[$key] = trim($vals);
			}
		}
		
		$verification_status = $this->check_if_vendor_verified($vendor_email);
		$verification_status = $verification_status['verification_status'];
		if($verification_status===false)
		{
			$input['email'] = trim($vendor_email);
			$input['verification_status'] = 1;
			$db_status = $this->db->insert('vendors', $input);
			$vendor_id = $this->db->insert_id();
		}else{
			$vendor_id = $verification_status['id'];
			$this->db->where('email',$vendor_email);
			$db_status = $this->db->update('vendors', $input);
			
			$this->db->where('vendor_id', $vendor_id);
			$this->db->delete('vendor_categories');
		}
		
		if(isset($post['categories']) && !empty($post['categories']))
		{
			$categories = $post['categories'];
			$categoriesArr = array();
			foreach($categories as $categ)
			{
				$tempArr = array();
				$tempArr['vendor_id'] = $vendor_id;
				$tempArr['category_id'] = $categ;
				$tempArr['created_on'] = date('Y-m-d H:i:s');
				$tempArr['modify_date'] = date('Y-m-d H:i:s');
				$categoriesArr[] = $tempArr;
			}
			if(!empty($categoriesArr))
			{
				$this->db->insert_batch('vendor_categories',$categoriesArr);
			}
		}
		
        if (!$db_status) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }else{
			$myDomain = 'w3ondemand';
			$this->sendmail->sendTo($vendor_email, 'Verify your account', 'Verification link for ' . $myDomain, 'Hello,<br> your verification link is ' . $verificationLink);
			$this->session->set_flashdata('success', 'An verification link sent on your email.Please verify first and login here!');
		}
    }

    public function countVendorsWithEmail($email)
    {
        $this->db->where('email', $email);
        return $this->db->count_all_results('vendors');
    }

    public function verifyAccount($email,$verification_token)
    {
        $this->db->where('email', $email);
        $this->db->where('verification_token', $verification_token);
        $this->db->where('verification_status', '0');
        $checkRecord = $this->db->count_all_results('vendors');
		if($checkRecord>0)
		{
			$updateArr = array();
			$updateArr['verification_status'] = 1;
			$updateArr['verification_token'] = '';
			$this->session->set_flashdata('success', 'Your email id is verfied.You can login now!');
			$this->db->where('email',$email);
			$this->db->update('vendors',$updateArr);
		}else{
			$this->session->set_flashdata('login_error', 'Link is expired or you already used before!');
		}
		redirect(LANG_URL . '/vendor/login');
    }

    public function checkVendorExsists($post)
    {
        $this->db->where('email', $post['u_email']);
        $query = $this->db->get('vendors');
        $count = $query->num_rows();
        $row = $query->row_array();
		//print_r($count,1);exit;
		if($count==0)
		{
			$this->session->set_flashdata('error_register', array('You are not registered with us.Please register first!'));
			redirect(LANG_URL . '/vendor/register');
		}elseif($row['verification_status']==0)
		{
			$this->session->set_flashdata('login_error', 'Your email id is not verfied yet.Please verify first!');
			redirect(LANG_URL . '/vendor/login');
		}elseif($row['delete_status']==1)
		{
			$this->session->set_flashdata('login_error', 'Your account is deleted by administrator!');
			redirect(LANG_URL . '/vendor/login');
		}elseif($row['status']==0)
		{
			$this->session->set_flashdata('login_error', 'Your account is blocked by administrator!');
			redirect(LANG_URL . '/vendor/login');
		}
		
        if (empty($row) || !password_verify($post['u_password'], $row['password'])) {
            return false;
        }
        return true;
    }	
	
	public function check_user_email($user_email){
		$this->db->select('email')
					->from('vendors')
					->where('email',$user_email)
					->where('verification_status','1');
		//$this->db->where('status','1');
		$this->db->where('delete_status','0');
		$data = $this->db->get();
		
		if($data->num_rows() > 0){
			return 1;
		}else{
			return 0;
		}
	}
	
	public function check_if_vendor_verified($user_email){
		$this->db->select('id,verification_status')
					->from('vendors')
					->where('email',$user_email);
		$this->db->where('delete_status','0');
		$data = $this->db->get();
		
		if($data->num_rows() > 0){
			$result = $data->row_array();
			$verification_status = $result['verification_status'];
			$id = $result['id'];
			
			$responseArr = array();
			$responseArr['id'] = $id;
			$responseArr['verification_status'] = $verification_status;
			return $responseArr;
		}else{
			//echo 'd'; exit; 
			return array('verification_status'=>false);
		}
	}

    public function updateVendorPassword($email,$newPass='')
    {
		if($newPass=='')
		{
			$newPass = str_shuffle(bin2hex(openssl_random_pseudo_bytes(4)));
		}
        $this->db->where('email', $email);
        if (!$this->db->update('vendors', ['password' => password_hash($newPass, PASSWORD_DEFAULT)])) {
            log_message('error', print_r($this->db->error(), true));
            show_error(lang('database_error'));
        }
        return $newPass;
    }

    public function getShopCategories($limit = null, $start = null)
    {
        $limit_sql = '';
        if ($limit !== null && $start !== null) {
            $limit_sql = ' LIMIT ' . $start . ',' . $limit;
        }

        $query = $this->db->query('SELECT translations_first.*,shop_categories.sub_for FROM shop_categories_translations as translations_first LEFT JOIN shop_categories ON shop_categories.sub_for = translations_first.id ORDER BY position ASC ' . $limit_sql);
        $arr = array();
		//pr($query->result(),1);
        foreach ($query->result() as $shop_categorie) {
		//var_dump($shop_categorie->sub_for);
			if($shop_categorie->sub_for===NULL)
			{
				$arr[] = array(
					'id' => $shop_categorie->id,
					'abbr' => $shop_categorie->abbr,
					'name' => $shop_categorie->name
				);
			}
        }
        return $arr;
    }






}
