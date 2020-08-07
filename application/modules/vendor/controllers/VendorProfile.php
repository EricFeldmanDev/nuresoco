<?php

/*
 * @Author:    Kiril Kirkov
 *  Gitgub:    https://github.com/kirilkirkov
 */
if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class VendorProfile extends VENDOR_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model(array('Auth_model', 'Vendorprofile_model'));
    }

    public function index()
    {
        $data = array();
        $head = array();
        $head['title'] = lang('vendor_dashboard');
        $head['description'] = lang('vendor_home_page');
        $head['keywords'] = '';
        $data['success_msg']='Product has Been Shipped Successfully';
        $data['ordersByMonth'] = $this->Vendorprofile_model->getOrdersByMonth($this->vendor_id);
        // echo "<pre>";
        // print_r($data['ordersByMonth']);die();
        $this->load->view('_parts/header', $head);        
        $this->load->view('home', $data);
		$this->load->view('_parts/modals');
        $this->load->view('_parts/footer');
    }

    public function changeshippingstatus(){
    	 $data = array();
        $head = array();
        $head['title'] = lang('vendor_dashboard');
        $head['description'] = lang('vendor_home_page');
        $head['keywords'] = '';
    	$order_id=$this->uri->segment(4);
    	$product_id=$this->uri->segment(5);
    	
    	$data=$this->Vendorprofile_model->changestatus($order_id,$product_id);
    	if ($data) {
       redirect('vendor/sales-merchant');
    	}else{
    	redirect('vendor/sales-merchant');
    	}
    }

    public function notifications()
    {
        $data = array();
        $head = array();
        $head['title'] = 'Notifications';
        $head['description'] = lang('vendor_home_page');
        $head['keywords'] = '';
        $data['notifications'] = $this->Vendorprofile_model->getNotifications($this->vendor_id);
		$this->load->view('_parts/header', $head);
        $this->load->view('notifications', $data);
		$this->load->view('_parts/modals');
        $this->load->view('_parts/footer');
    }

    public function inbox($product_id='',$user_id='')
    {
        $data = array();
        $head = array();
        $head['title'] = 'Inbox';
        $head['description'] = lang('vendor_home_page');
        $head['keywords'] = '';
		
		if($product_id!='' && $user_id!='')
		{
			$data['chatMessages'] = $this->Public_model->getChatMessages(base64_decode($product_id),base64_decode($user_id),$this->vendor_id);
		}
		$data['vendor_details'] = $this->Vendorprofile_model->getVendorInfoFromEmail($this->session->userdata('logged_vendor'));
		$data['chatProducts'] = $this->Public_model->getChatProducts('',$this->vendor_id);
		//pr($data['chatProducts'],1);
		//pr($data['chatProducts'],1);
		$this->load->view('_parts/header', $head);
        $this->load->view('inbox', $data);
		$this->load->view('_parts/modals');
        $this->load->view('_parts/footer');
    }
	
    public function getChatMessages()
    {
		if(!$this->input->is_ajax_request())
		{
			exit('No direct script access allowed');
		}
		if($this->input->post())
		{
			$product_id = $this->input->post('product_id');
			$user_id = $this->input->post('user_id');
			$chatMessages = $this->Public_model->getChatMessages(base64_decode($product_id),base64_decode($user_id),$this->vendor_id);
			if(!empty($chatMessages)){
				foreach($chatMessages as $chatMessage)
				{
					if($chatMessage['message_from']=='USER')
					{
			?>
						<div class="chat_ww chat_left">
							<img src="<?= (is_file(UPLOAD_PHYSICAL_PATH.'user-images/'.$chatMessage['user_profile_image']) && $chatMessage['user_profile_image'] !="")?UPLOAD_URL.'user-images/'.$chatMessage['user_profile_image']:WEB_URL.'images/profile_user.png' ?>"/> 
							<p class="text-left"><?=$chatMessage['message']?><time><?=date('d/m/Y h:i A',strtotime($chatMessage['message']))?> </time></p>
						</div>
			<?php 
					}else{
			?>
						<div class="chat_ww chat_right">
							<p class="text-left"><?=$chatMessage['message']?><time><?=date('d/m/Y h:i A',strtotime($chatMessage['message']))?> </time></p>
							<img src="<?= (is_file(UPLOAD_PHYSICAL_PATH.'vendor-images/'.$chatMessage['vendor_profile_image']) && $chatMessage['vendor_profile_image'] !="")?UPLOAD_URL.'vendor-images/'.$chatMessage['vendor_profile_image']:WEB_URL.'images/profile_user.png' ?>"/> 
						</div>
			<?php 
					}
				}
			}
		}else{
			exit('No direct script access allowed');
		}
    }
	
    public function send_message_by_ajax()
    {
		if(!$this->input->is_ajax_request())
		{
			exit('No direct script allowed.');
		}
		if($this->input->post())
		{
			$product_id = $this->input->post('product_id');
			$product_id = base64_decode($product_id);
			
			$user_id = $this->input->post('user_id');
			$user_id = base64_decode($user_id);
			
			$productDetails = $this->Public_model->getProductDetails($product_id);
			if($productDetails!='')
			{
				$vendor_id = $this->vendor_id;
				$messageStatus = $this->Public_model->checkIfmessagedOnProduct($product_id,$user_id,$vendor_id);
				if(!$messageStatus)
				{
					$insertArr = array();
					$insertArr['product_id'] = $product_id;
					$insertArr['user_id'] = $user_id;
					$insertArr['vendor_id'] = $vendor_id;
					$insertArr['created_on'] = date('Y-m-d H:i:s');
					$insertArr['modify_on'] = date('Y-m-d H:i:s');
					if($this->db->insert('message_products',$insertArr))
					{
						$mp_id = $this->db->insert_id();
						$message = $this->input->post('message');
						
						$insertMessageArr = array();
						$insertMessageArr['mp_id'] = $mp_id;
						$insertMessageArr['message_from'] = 'VENDOR';
						$insertMessageArr['message'] = $message;
						$insertMessageArr['message_type'] = 'TEXT';
						$insertMessageArr['created_on'] = date('Y-m-d H:i:s');
						$insertMessageArr['modify_on'] = date('Y-m-d H:i:s');
						$this->db->insert('messages',$insertMessageArr);
					
						$this->db->where('mp_id',$mp_id);
						$this->db->update('message_products',array('last_message_on'=>date('Y-m-d H:i:s')));
						echo 'sent';
					}else{
						echo 'error';
					}
				}else{
					$mp_id = $messageStatus;
					$message = $this->input->post('message');
					
					$insertMessageArr = array();
					$insertMessageArr['mp_id'] = $mp_id;
					$insertMessageArr['message_from'] = 'VENDOR';
					$insertMessageArr['message'] = $message;
					$insertMessageArr['message_type'] = 'TEXT';
					$insertMessageArr['created_on'] = date('Y-m-d H:i:s');
					$insertMessageArr['modify_on'] = date('Y-m-d H:i:s');
					$this->db->insert('messages',$insertMessageArr);
					
					$this->db->where('mp_id',$mp_id);
					$this->db->update('message_products',array('last_message_on'=>date('Y-m-d H:i:s')));
					echo 'sent';
				}
			}else{
				echo 'error';
			}
		}else{
			exit('No direct script allowed.');
		}
    }

    public function changeVendorImage()
	{
		$response = array();
		$response['error'] = 'yes';
		$response['msg'] = "You can't hit this url directly";
		if($_FILES)
		{
			$response = $this->Vendorprofile_model->updateProfileImage($this->vendor_id);
		}
		echo json_encode($response,true);
	}

    public function user_account()
    {
        $data = array();
        $head = array();
        $head['title'] = lang('vendor_dashboard');
        $head['description'] = lang('vendor_home_page');
        $head['keywords'] = '';
		
		$this->load->library('user_agent');
		$referrer = $this->agent->referrer();
		if($this->input->post())
		{
			$post = $this->input->post();
			//pr($post,1);
			if($post['name']=='')
			{
				$this->session->set_flashdata('result_failed',"Name can't be blank!");
				redirect($referrer);
			}
			$updateArr = array();
			$updateArr['name'] = $post['name'];
			$updateArr['vendor_phone_number'] = $post['vendor_phone_number'];
			$updateArr['business_email'] = $post['business_email'];
			$this->db->where('id',$this->vendor_id);
			$this->db->update('vendors',$updateArr);
			
			$this->db->where('vendor_id',$this->vendor_id);
			$this->db->delete('vendor_categories');
			
			$insertArr = array();
			foreach($post['categories'] as $categories)
			{
				$tempArr = array();
				$tempArr['vendor_id'] = $this->vendor_id;
				$tempArr['category_id'] = $categories;
				$tempArr['created_on'] = date('Y-m-d H:i:s');
				$tempArr['modify_date'] = date('Y-m-d H:i:s');
				$insertArr[] = $tempArr;
			}
			$this->db->insert_batch('vendor_categories',$insertArr);
			
			$this->session->set_flashdata('result_success',"Details updated successfully!");
			redirect($referrer);
		}
		
        $vendor_categories = $this->Public_model->getVendorCategories($this->vendor_id);
		$vendor_selected_categories = array();
		foreach($vendor_categories as $vendor_category)
		{
			$vendor_selected_categories[] = $vendor_category['id'];
		}
		$data['vendor_selected_categories'] = $vendor_selected_categories;
		$data['revenue_share'] = $this->Vendorprofile_model->getRevenueShare();
		$data['vendor_details'] = $this->Vendorprofile_model->getVendorInfoFromEmail($this->session->userdata('logged_vendor'));
		$this->load->view('_parts/header', $head);
        $this->load->view('user_account', $data);
		$this->load->view('_parts/modals');
        $this->load->view('_parts/footer');
    }
    
    public function init_payment(){
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

      public function payment_setting(){
      	if(isset($_POST['paypal_submit'])){
      		$vendor_id=$this->input->post('vendorid');
      		$param['paypal_first_name']=$this->input->post('paypal_first_name');
      		$param['paypal_last_name']=$this->input->post('paypal_last_name');
      		$param['paypal_email']=$this->input->post('paypal_email');
      		$updatedetails=$this->Vendorprofile_model->paypaldetailsupdate($param,$vendor_id);
      	    if($updatedetails){
      		$this->session->set_flashdata('result_success',"Update details");	
      	    }else{
      	    	$this->session->set_flashdata('result_failed','Failed');
      	    }  		

      	}
	      	$data = array();
	        $head = array();
	        $head['title'] = lang('vendor_dashboard');
	        $head['description'] = lang('vendor_home_page');
	        $head['keywords'] = '';
	        $data['vendor_details']=$this->Vendorprofile_model->getVendorInfoFromEmail($this->session->userdata('logged_vendor'));  
        
        //print_r($data);
	        $this->load->view('_parts/header', $head);
	        $this->load->view('payment_setting', $data);
			$this->load->view('_parts/modals');
	        $this->load->view('_parts/footer');
      }

    public function changePassword(){
        $data = array();
        $head = array();
        $head['title'] = lang('vendor_dashboard');
        $head['description'] = lang('vendor_home_page');
        $head['keywords'] = '';
		
		$this->load->library('user_agent');
		$referrer = $this->agent->referrer();
		
		if($this->input->post())
		{
			$post = $this->input->post();
			if($post['old_password']=='' || $post['passsword']=='' || $post['confirm_passsword']=='')
			{
                $this->session->set_flashdata('flashError', "Please fill all required fields!");
				redirect($referrer);
				exit;
			}
			
			$checkRecord = $this->Vendorprofile_model->check_vendor_pass($this->vendor_id,$post['old_password']);
			if($checkRecord!=0)
			{
                $this->session->set_flashdata('flashError', "Old password is incorrect.Please fill correct password.!");
				redirect($referrer);
				exit;
			}
			
			$updateStatus = $this->Auth_model->updateVendorPassword($this->vendor_email,$post['passsword']);
			if ($updateStatus) {
                $this->session->set_flashdata('flashSuccess', 'Profile updated successfully.');
            } else {
                $this->session->set_flashdata('flashError', 'An error occured.Please try again later!');
            }
			redirect($referrer);
		}
		
		$this->load->view('_parts/header', $head);
        $this->load->view('change_pass', $data);
		$this->load->view('_parts/modals');
        $this->load->view('_parts/footer');
    }
	
	public function checkVendorPassword(){
		
		$json=array();
		$password = $this->input->post('old_password');
		$data = $this->Vendorprofile_model->check_vendor_pass($this->vendor_id,$password);
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

    public function logout()
    {
        unset($_SESSION['logged_vendor']);
        delete_cookie('logged_vendor');
        redirect(LANG_URL . '/vendor/login');
    }

    public function provider_payment(){
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
                    if($this->Vendorprofile_model->provider_payment($post))
                    {
                        $this->session->set_flashdata("flashSuccess","Payment Details Have Added Successfully!");
                    }else{
                        $this->session->set_flashdata("flashError","An error occured Or Stripe account not responsnding!");
                    }
                }else{
                    $this->session->set_flashdata("flashError","All Fields Are Mandatory!");
                }
        }
            $provider_id=$this->vendor_id;
            $data['provider_details'] = $this->Vendorprofile_model->checkProvider($provider_id);
            if(!empty($data['provider_details'])){
            	$stripe_status='1';
            	$this->Vendorprofile_model->updateVendorStripeStatus($stripe_status);
            }
            $head = array();
            $head['title'] = lang('user_forgotten_page');
            $head['description'] = lang('recover_password');
            $head['keywords'] = '';

            $this->load->view('_parts/header_auth', $head);
            $this->load->view('payment_setting', $data);
            $this->load->view('_parts/footer_auth');

         //   $this->layout->view('providers/payment',$data);
    }

}
