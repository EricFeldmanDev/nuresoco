<?php

class Vendorprofile_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }
   public function paypaldetailsupdate($param,$id){
	   	//echo $id;die();
	    $this->db->where('id',$id);
		$this->db->update('vendors',$param);  
       return $id;
	}

    public function getVendorInfoFromEmail($email)
    {
        $this->db->where('email', $email);
        $result = $this->db->get('vendors');
        return $result->row_array();
    }

    public function getRevenueShare()
    {
        $this->db->where('id', '1');
        $result = $this->db->get('site_setting');
        return $result->row_array();
    }
    public function getstatus($id)
    {
        $this->db->where('created_on', $id);
        $result = $this->db->get('orders');
        return $result->row_array();
    }

    public function getVendorByUrlAddress($urlAddr)
    {
        $this->db->where('url', $urlAddr);
        $result = $this->db->get('vendors');
        return $result->row_array();
    }

    public function getUnseenNotificationsCount($vendor_id)
    {
        $this->db->where('seen_status', '0');
        $this->db->where('to_id', $vendor_id);
        $this->db->where('to_notification', 'VENDOR');
        $this->db->order_by('notification_id', 'DESC');
        $result = $this->db->get('notifications');
		return $result->num_rows();
    }

    public function getNotifications($vendor_id)
    {
        $this->db->where('to_id', $vendor_id);
        $this->db->where('to_notification', 'VENDOR');
        $this->db->order_by('notification_id', 'DESC');
        $result = $this->db->get('notifications');
        $notifications = $result->result_array();
		$responseArr = array();
		foreach($notifications as $notification)
		{
			$tempArr = array();
			$tempArr = $notification;
			if($notification['seen_status']=='0')
			{
				$this->db->where('notification_id',$notification['notification_id']);
				$this->db->update('notifications',array('seen_status'=>'1'));
			}
			$tempArr['name'] = '';
			if($notification['from_notification']!='0')
			{
				if($notification['from_notification']=='USER')
				{
					$this->db->select('profile_image,name');
					$this->db->where('id',$notification['from_id']);
					$result1 = $this->db->get('users_public');
					$imageDetails = $result1->row_array();
					$tempArr['name'] = $imageDetails['name'];
					$profile_image = $imageDetails['profile_image'];
					if($profile_image!='' && is_file(UPLOAD_PHYSICAL_PATH.'user-images/'.$profile_image))
					{
						$image = UPLOAD_URL.'user-images/'.$profile_image;
					}else{
						$image = WEB_URL.'images/profile_user.png';
					}
				}
				$tempArr['image'] = $image;
			}
			$responseArr[] = $tempArr;
		}
		//pr($responseArr,1);
        return $responseArr;
    }

    public function saveNewVendorDetails($post, $vendor_id)
    {
        if (!$this->db->where('id', $vendor_id)->update('vendors', array(
                    'name' => $post['vendor_name'],
                    'url' => $post['vendor_url']
                ))) {
            log_message('error', print_r($this->db->error(), true));
        }
    }

    public function isVendorUrlFree($vendorUrl)
    {
        $this->db->where('url', $vendorUrl);
        $num = $this->db->count_all_results('vendors');
        if ($num > 0) {
            return false;
        } else {
            return true;
        }
    }
     public function getOrdersByMonth($id){     	
  //       $this->db->select('orders.vender_payment_status,orders.shipping_status,orders.id,orders.order_code,orders.shipping_charges,orders.street,orders.final_amount,orders. user_id,orders.mobile_no,orders.country_id,orders.city_id,orders.state_id,orders.address,orders.transation_id,orders.payment_type,orders.status,orders.created_on,ordered_products.product_image,ordered_products.product_name,ordered_products.product_size,ordered_products.product_color,ordered_products.quantity');
		// $this->db->from('orders');
		// $this->db->join('ordered_products', 'ordered_products.order_id = orders.id', 'left');
		// $this->db->join('products','products.product_id=ordered_products.product_id');
		// $this->db->where('orders.user_id',$id);
		 $sql="SELECT  `product_shipping_status`,`order_id`,`product_id`,`product_size`,`product_image`,`product_name`,`product_image`,`quantity`,`price`,`mobile_no`,`vender_payment_status`,`shipping_status`, `street`,`order_code`,`shipping_amount`,`final_amount`,`country_id`,`city_id`,`state_id`,`address`,`transation_id`,`product_color`,`payment_type`,`created_on` FROM `ordered_products` left join orders on ordered_products.order_id = orders.id where ordered_products.product_id in (select product_id from products where vendor_id='".$id."') order by orders.id DESC ";
		//die();
		//$this->db->order_by("id", "DESC");
		return $this->db->query($sql)->result();
		//$query=$this->db->get();
		//echo $this->db->last_query();die();
        //return $query->result_array();
     }

    // public function getOrdersByMonth($vendor_id)
    // {
    //     $result = $this->db->query("SELECT YEAR(FROM_UNIXTIME(date)) as year, MONTH(FROM_UNIXTIME(date)) as month, COUNT(id) as num FROM vendors_orders WHERE vendor_id = $vendor_id GROUP BY YEAR(FROM_UNIXTIME(date)), MONTH(FROM_UNIXTIME(date)) ASC");
    //     $result = $result->result_array();
    //     $orders = array();
    //     $years = array();
    //     foreach ($result as $res) {
    //         if (!isset($orders[$res['year']])) {
    //             for ($i = 1; $i <= 12; $i++) {
    //                 $orders[$res['year']][$i] = 0;
    //             }
    //         }
    //         $years[] = $res['year'];
    //         $orders[$res['year']][$res['month']] = $res['num'];
    //     }
    //     return array(
    //         'years' => array_unique($years),
    //         'orders' => $orders
    //     );
    // }
    
    public function changestatus($order_id,$product_id){
		$this->db->set('product_shipping_status', '1'); //value that used to update column  
		$this->db->where('order_id', $order_id); //which row want to upgrade  
		$this->db->where('product_id', $product_id); //which row want to upgrade  
		$this->db->update('ordered_products');
		//echo $this->db->last_query();die();
		return $id;
    }

    public function updateProfileImage($vendor_id)
    {
		$response = array();
		if($vendor_id!="")
		{
			if($_FILES['profile_image']['name']!="")
			{
				$result = $this->do_upload_by_ajax('profile_image');
				if($result['error']=='no')
				{
					$imgName = $result['upload_data']['file_name'];
					$arr = array();
					$arr['image'] = $imgName;
					
					$this->db->where('id',$vendor_id);
					$this->db->update('vendors',$arr);
					$response['error'] = 'no';
					$response['msg'] = UPLOAD_URL.'vendor-images/'.$imgName;
				}else{
					$response['error'] = 'yes';
					$response['msg'] = $result['msg'];
				}
			}
		}else{
			$response['error'] = 'yes';
			$response['msg'] = 'User id can not be blank.';
		}
		return $response;
    }

    
    
	public function do_upload_by_ajax($submited_name)
	{
		
		$filename = $_FILES[$submited_name]['name'];
		$ext = pathinfo($filename, PATHINFO_EXTENSION);
		
		$random_key = $this->random_key(10);
		$image_name =date("Ymdhis").$random_key.$ext;
		$folderPath = UPLOAD_PHYSICAL_PATH.'vendor-images/';
		if(!is_dir($folderPath))
		{
			mkdir($folderPath,777,true);
		}
		
		$config['file_name']         	= $image_name;
		$config['upload_path']          = $folderPath;
		$config['allowed_types']        = 'jpg|jpeg|png';
		$config['max_size']             = 1024;
		$config['max_width']            = 1024;
		$config['max_height']           = 768;
		$this->load->library('upload', $config);
		if(!$this->upload->do_upload($submited_name))
		{
			$data = array('error' => 'yes','msg' => $this->upload->display_errors());
		}else{
			$data = array('error' => 'no','upload_data' => $this->upload->data());
		}
		return $data;
	}
	
	public function random_key($length=10)
	{
		$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
		$email_token = '';
		for ($i = 0; $i < $length; $i++) {
			  $email_token .= $characters[rand(0, strlen($characters) - 1)];
		}
		return $email_token;
	}
	
	public function check_vendor_pass($vendor_id,$password)
	{
		$this->db->select('password')
					->from('vendors')
					->where('id',$vendor_id);
		$data = $this->db->get();
		if($data->num_rows() > 0){
			$result = $data->row_array();
			if(empty($result) || !password_verify($password, $result['password']))
			{
				return 1;
			}else{
				return 0;
			}
		}else{
			return 1;
		}
	}









    ##################### Provider payment start #######################


    public function provider_payment($post)
	{
		
		$provider_mail=$_SESSION['logged_vendor']; 
		$provider_id=$this->getProviderByEmail($provider_mail);

		$data=array();
		$data['provider_id']=$provider_id;
		$data['business_name']=$post['business_name'];
		$data['business_street_address']=$post['business_address'];
		$data['business_city']=$post['business_city'];
		$data['business_state']=$post['business_state'];
		$data['business_postal_code']=$post['business_postal_code'];
		$data['business_routing_number']=$post['routing_number'];
		$data['business_account_number']=$post['account_number'];
		$data['business_country']=$post['country'];
		$data['business_email']=$post['email'];
		$data['first_name']=$post['first_name'];
		$data['last_name']=$post['last_name'];
		$data['dob']=$post['dob'];
		$data['street_address']=$post['address'];
		$data['city']=$post['city'];
		$data['state']=$post['state'];
		$data['postal_code']=$post['postal_code'];
		$data['created_on'] = date('Y-m-d H:i:s');

		
		
		$chkProvider=$this->checkProvider($provider_id);
    	if(empty($chkProvider)){
			$response = $this->create_account($post);
			if(!empty($response))
			{
				$data['account_id'] = $response['account_id'];
				$data['person_id'] = $response['person_id'];
				$data['modified_on'] = date('Y-m-d H:i:s');
				if($this->db->insert('provider_stripe_details',$data))
				{
					return true;
					
				}else{
					return false;
				}
			}else{
				return false;
			}
		}else{
			$account_id = $chkProvider['account_id'];
			$person_id = $chkProvider['person_id'];
			$response = $this->update_account($post,$account_id,$person_id);
			if(!empty($response))
			{
				$data['modified_on'] = date('Y-m-d H:i:s');
				
				$this->db->where('provider_id',$provider_id);
				if($this->db->update('provider_stripe_details',$data))
				{
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
	}


	public function updateVendorStripeStatus($stripe_status=""){
		if($stripe_status!=''){
			$provider_mail=$_SESSION['logged_vendor']; 
			$provider_id=$this->getProviderByEmail($provider_mail);
			$updateData=array();
			$updateData['stripe_payment_details_status']=$stripe_status;
			$update=$this->db->update('vendors',$updateData,array('id'=>$provider_id));
			if($update){
				return true;
			}
			else {
				return false;
			}
		}
		else {
			return false;
		}
	}
	public function checkProvider($provider_id="")
	{
		if($provider_id!=""){
			$this->db->select('*');
			$this->db->from('provider_stripe_details');
			$this->db->where('provider_id',$provider_id);
			$get=$this->db->get();
			if($get->num_rows() > 0) 
			{
				$response = $get->row_array();
				return $response;
			}else{
				return array();
			}
		}else{
			return array();
		}
	}

	public function getProviderByEmail($provider_email="")
	{
		if($provider_email!=""){
			$this->db->select('id');
			$this->db->from('vendors');
			$this->db->where('email',$provider_email);
			$get=$this->db->get();
			if($get->num_rows() > 0) 
			{
				$response = $get->row_array();
				return $response['id'];
			}else{
				return array();
			}
		}else{
			return array();
		}
	}
	
	public function create_account($post)
    {
		require_once('application/libraries/stripe/vendor/autoload.php');
		//pr($post,1);	
		
		\Stripe\Stripe::setApiKey(STRIPE_SECRET);
		
		$account_token = $_POST['account-token'];
		$person_token = $_POST['person-token'];
		$external_account = array(
							  "object" => "bank_account",
							  "country" => "US",
							  "currency" => "USD",
							  "routing_number" => $post['routing_number'],
							  "account_number" => $post['account_number'],
							  "legal_name" => $post['business_name'],
							  "account_holder_name" => $post['business_name'],
							);
							
		$accountDetails = \Stripe\Account::create([
		
							  "country" => "FR",
							  "type" => "custom",
							  "account_token" => $account_token,
							  "email" => $post['email'],
							  "external_account" => $external_account,
							]);
		if($accountDetails)
		{
			//\Stripe\Stripe::setApiKey(STRIPE_SECRET);
			$dob = $post['dob'];
			$day = date('d',strtotime($dob));
			$month = date('m',strtotime($dob));
			$year = date('Y',strtotime($dob));

			$personDetails = \Stripe\Account::createPerson(
				$accountDetails['id'],
				[
					'first_name' => $post['first_name'],
					'last_name'  => $post['last_name'],
					'relationship' =>	array(
										'account_opener'    => true,
										'director'  => false,
										'owner'	 => true,
										'percent_ownership' => 100,
										'title' => null,
									),
					
					'dob' 	 =>	array(
										'day'    => $day,
										'month'  => $month,
										'year'	 => $year,
									),
					'address' 	 =>	array(
										'line1' => $post['address'],
										'city' => $post['city'],
										'state' => $post['state'],
										'postal_code' => $post['postal_code'],
									),
				]
			);
			$response = array();
			$response['account_id'] = $accountDetails['id'];
			$response['person_id'] = $personDetails['id'];
			return $response;
		}else
		{
			return array();
		}
    }
	
	public function update_account($post,$account_id,$person_id)
    {
    	require_once('application/libraries/stripe/vendor/autoload.php');
		//pr($post,1);	
		
		$account_token = $_POST['account-token'];
		$person_token = $_POST['person-token'];

		\Stripe\Stripe::setApiKey(STRIPE_SECRET);
		$external_account = array(
							  "object" => "bank_account",
							  "country" => "US",
							  "currency" => "USD",
							  "routing_number" => $post['routing_number'],
							  "account_number" => $post['account_number'],
							  "account_holder_name" => $post['business_name'],
							);
							
		$accountDetails = \Stripe\Account::update($account_id,
							[
		
							  //"country" => "FR",
							  //"type" => "custom",
							  "account_token" => $account_token,
							  "email" => $post['email'],
							  "external_account" => $external_account,
							]);
		//pr($accountDetails,1);
		if($accountDetails)
		{
			//\Stripe\Stripe::setApiKey(STRIPE_SECRET);
			$dob = $post['dob'];
			$day = date('d',strtotime($dob));
			$month = date('m',strtotime($dob));
			$year = date('Y',strtotime($dob));

			$personDetails = \Stripe\Account::updatePerson($account_id,$person_id,
				[
					'first_name' => $post['first_name'],
					'last_name'  => $post['last_name'],
					'relationship' =>	array(
										'account_opener'    => true,
										'director'  => false,
										'owner'	 => true,
										'percent_ownership' => 100,
										'title' => null,
									),
					
					'dob' 	 =>	array(
										'day'    => $day,
										'month'  => $month,
										'year'	 => $year,
									),
					'address' 	 =>	array(
										'line1' => $post['address'],
										'city' => $post['city'],
										'state' => $post['state'],
										'postal_code' => $post['postal_code'],
									),
				]
			);
			$response = array();
			$response['account_id'] = $account_id;
			$response['person_id'] = $person_id;
			return $response;
		}else
		{
			return array();
		}
    }

    public function getServiceByAptId($appointment_id=''){
	    if($appointment_id!=''){
		   	$this->db->select('s.title');
		   	$this->db->from('appointments ap');
		   	$this->db->join('services s','s.service_id=ap.service_id','left');
		   	$this->db->where('ap.appointment_id',$appointment_id);
		   	$get=$this->db->get();
		   	if($get->num_rows() > 0){
		   		$result=$get->row_array();
		   		return $result['title'];
		   	}
		   	else {
		   		return '';
		   	}
	    } 
	    else {
	    	return '';
	    }
    }
	
	public function create_charge($stripeAccountId,$stripeToken,$appointment_id,$amount)
    {
    	
    	$appointment_service=$this->getServiceByAptId($appointment_id);
		require_once('application/libraries/stripe/vendor/autoload.php');
		\Stripe\Stripe::setApiKey(STRIPE_SECRET);
		
		$charge = \Stripe\Charge::create([
			'amount' => $amount*100,
			'currency' => 'usd',
			'description' => $appointment_service,
			'source' => $stripeToken,
			'transfer_group' => 'ORDER_'.$appointment_id,
		]);
		if($charge)
		{
			return $charge;
		}else{
			return array();
		}
    }
	
	
	
	######################## Paypal Payment Gateway #####################
		
	public function checkPaypalProvider($provider_id="")
	{
		if($provider_id!=""){
			$this->db->select('*');
			$this->db->from('provider_paypal_details');
			$this->db->where('provider_id',$provider_id);
			$get=$this->db->get();
			if($get->num_rows() > 0) 
			{
				$response = $get->row_array();
				return $response;				
			}else{
				return array();
			}
		}else{
			return array();
		}
	}

 	public function vendor_paypal_payment($post,$provider_id){
 		$data=array();
 		$data['provider_id']=$provider_id;
 		$data['paypal_first_name']=$post['paypal_first_name'];
 		$data['paypal_last_name']=$post['paypal_last_name'];
 		$data['paypal_email']=$post['paypal_email'];
 		$data['created_on']=date('Y-m-d H:i:s');
 		$data['modified_on']=date('Y-m-d H:i:s');
 		$chkPaypalProvider=$this->checkPaypalProvider($provider_id);
 		if(!$chkPaypalProvider){
 			$inserted=$this->db->insert('provider_paypal_details',$data);
 			if($inserted){
 				return true;
 			}
 			else {
 				return false;
 			}
 		}
 		else {
 			$this->db->where('provider_id',$provider_id);
 			$updated=$this->db->update('provider_paypal_details',$data);
 			if($updated){
 				return true;
 			}
 			else {
 				return false;
 			}
 		}

 	}

 	public function getcity($id)
 	{
     $this->db->where('id',$id);
     $query=$this->db->get('cities');
     //echo $this->db->last_query();die();
     return $query->row_array(); 
 	}
 	public function getstate($id)
 	{
     $this->db->where('id',$id);
     $query=$this->db->get('states');
     //echo $this->db->last_query();die();
     return $query->row_array(); 
 	}
 	public function getcountry($id)
 	{
     $this->db->where('id',$id);
     $query=$this->db->get('countries');
     //echo $this->db->last_query();die();
     return $query->row_array(); 
 	}

	

}
