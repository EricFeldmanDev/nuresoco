<?php

class Payment_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function add_order_request($orderDetails,$post,$user_id,$data){
    	$paymentstatus=$data['payment_status'];
    	$orderKey=rand(9999,99999);
    	$orderData=array();
    	$orderData['user_id']=$user_id;
    	$orderData['name']=$data['name'];
    	$orderData['email']=$data['email'];
    	$orderData['card_num']=$data['card_num'];
    	$orderData['card_cvc']=$data['card_cvc'];
    	$orderData['card_exp_month']=$data['card_exp_month'];
    	$orderData['card_exp_year']=$data['card_exp_year'];
    	$orderData['order_code']=$orderKey;
    	$orderData['item_price_currency']=$data['item_price_currency'];
    	$orderData['address']=$post['address'];
    	$orderData['mobile_no']=$post['mobile'];
    	$orderData['country_id']=$post['country'];
    	$orderData['state_id']=$post['state'];
    	$orderData['city_id']=$post['city'];
    	$orderData['payment_type']='stripe';
    	$orderData['transation_id']=$data['transation_id'];
    	$orderData['street']=$post['street'];
    	$orderData['payment_status']=$paymentstatus;
    	$orderData['shipping_charges']='';
    	$orderData['amount_before_discount']=$orderDetails['finalSum'];
    	$orderData['final_amount']='';
    	$orderData['coupon_code']=$post['coupon_code'];
    	$orderData['postal_code']=$post['postal_code'];
    	$orderData['coupon_percentage']=$post['coupon_percentage'];
    	$orderData['coupon_charges']=$post['coupon_discount_amount'];
    	$orderData['created_on']=date('Y-m-d H:i:s');
    	$orderData['modified_on']=date('Y-m-d H:i:s');
    	$this->db->insert('orders',$orderData);
    	$order_id=$this->db->insert_id(); 
    	if($order_id>0){
    		$productData=array();
    		foreach ($orderDetails['array'] as $products) {
    			$productData['order_id']=$order_id;
    			$productData['product_id']=$products['product_id'];
    			$productData['product_image']=$products['image'];
    			$productData['product_name']=$products['product_name'];
    			$productData['product_size']=$products['size'];
    			$productData['product_color']=$products['color'];
    			$productData['shipping_type']=$products['shipping_type'];
    			$productData['shipping_amount']=$products['shipping'];
    			$productData['price']=$products['price'];
    			$productData['quantity']=$products['cart_quantity'];
    			//print_r($products);die();
    			$productData['product_height']='';
    			$productData['product_width']='';
    			$productData['product_length']=''; 
    			$productData['product_weight']=''; 
    			$productData['created_at']=date('Y-m-d H:i:s'); 
    			$productData['modified_at']=date('Y-m-d H:i:s');
    			$inserted=$this->db->insert('ordered_products',$productData); 
    		}
    		if($inserted){
    			$updateArr=array();
    			$updateArr['final_amount']=$post['finalsum'];
		        $this->db->update('orders',$updateArr,array('id'=>$order_id));
				return $order_id;
    			/* $createCharge=$this->create_charge($order_id,$stripToken,$post['finalsum']);
    			if(!empty($createCharge)){
    				if($createCharge['status']=='succeeded'){
    					$updateArr=array();
		        		$updateArr['charge_id']=$createCharge['id'];
		        		$updateArr['transation_id']=$createCharge['balance_transaction'];
		        		$updateArr['payment_status']='SUCCESS';
		        		$updateArr['final_amount']=$post['finalsum'];
		        		$this->db->update('orders',$updateArr,array('id'=>$order_id));
						return $createCharge;
                        //pr($createCharge,1);
					}
					else {
						return array();
					}	
    			}
    			else {
    				return array();
    			} */
    		}else {
    			return array();
    		}
    	}
	}
	
	public function pay_delayed_chained($orderDetails,$finalsum,$payment_id)
    {
    	$res  = array();
		foreach($orderDetails['array'] as $vals){

		    if(array_key_exists($vals['paypal_email'],$res)){
		        $res[$vals['paypal_email']]['sum_price'] += str_replace(',', '',$vals['sum_price']);
		    }
		    else{
				$res[$vals['paypal_email']]['sum_price'] = str_replace(',', '',$vals['sum_price']);
		    }
		}
		$orderDetails['finalSum'] = str_replace(',', '',$finalsum);

		// Prepare request arrays
		$PayRequestFields = array(
								'ActionType' => 'PAY_PRIMARY', 								// Required.  Whether the request pays the receiver or whether the request is set up to create a payment request, but not fulfill the payment until the ExecutePayment is called.  Values are:  PAY, CREATE, PAY_PRIMARY
								'CancelURL' => base_url('payment/payment_failed'), 									// Required.  The URL to which the sender's browser is redirected if the sender cancels the approval for the payment after logging in to paypal.com.  1024 char max.
								'CurrencyCode' => 'GBP', 								// Required.  3 character currency code.
								'FeesPayer' => 'PRIMARYRECEIVER', 									// The payer of the fees.  Values are:  SENDER, PRIMARYRECEIVER, EACHRECEIVER, SECONDARYONLY
								'IPNNotificationURL' => '', 						// The URL to which you want all IPN messages for this payment to be sent.  1024 char max.
								'Memo' => '', 										// A note associated with the payment (text, not HTML).  1000 char max
								'Pin' => '', 										// The sener's personal id number, which was specified when the sender signed up for the preapproval
								'PreapprovalKey' => '', 							// The key associated with a preapproval for this payment.  The preapproval is required if this is a preapproved payment.  
								'ReturnURL' => base_url('payment/paypal_payment_success/'.base64_encode($payment_id)), 									// Required.  The URL to which the sener's browser is redirected after approvaing a payment on paypal.com.  1024 char max.
								'ReverseAllParallelPaymentsOnError' => FALSE, 			// Whether to reverse paralel payments if an error occurs with a payment.  Values are:  TRUE, FALSE
								'SenderEmail' => '', 								// Sender's email address.  127 char max.
								'TrackingID' => ''									// Unique ID that you specify to track the payment.  127 char max.
								);
								
		$ClientDetailsFields = array(
								'CustomerID' => '', 								// Your ID for the sender  127 char max.
								'CustomerType' => '', 								// Your ID of the type of customer.  127 char max.
								'GeoLocation' => '', 								// Sender's geographic location
								'Model' => '', 										// A sub-identification of the application.  127 char max.
								'PartnerName' => ''									// Your organization's name or ID
								);
								
		$FundingTypes = array('ECHECK', 'BALANCE', 'CREDITCARD');
		//$invoiceId = rand(10000,99999).'-ABCDEF';
		$invoiceId = $payment_id;
		$Receivers = array();
		$Receiver = array(
						'Amount' => $orderDetails['finalSum'], 											// Required.  Amount to be paid to the receiver.
						'Email' => PAYPAL_RECEIVER_ID, 				// Receiver's email address. 127 char max.
						'InvoiceID' => $invoiceId, 											// The invoice number for the payment.  127 char max.
						'PaymentType' => 'GOODS', 										// Transaction type.  Values are:  GOODS, SERVICE, PERSONAL, CASHADVANCE, DIGITALGOODS
						'PaymentSubType' => '', 									// The transaction subtype for the payment.
						'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''), // Receiver's phone number.   Numbers only.
						'Primary' => 'true'												// Whether this receiver is the primary receiver.  Values are boolean:  TRUE, FALSE
						);

    
		array_push($Receivers,$Receiver);
		
		if(!empty($res))
		{
			foreach($res as $key => $amount)
			{
				$amount = $amount['sum_price'];
				$providerAmount = $amount - (($amount * ADMIN_PERCENTAGE)/100);
				$Receiver = array(
								'Amount' => $providerAmount, // Required.  Amount to be paid to the receiver.
								'Email' => $key, 												// Receiver's email address. 127 char max.
								'InvoiceID' => $invoiceId, 											// The invoice number for the payment.  127 char max.
								'PaymentType' => 'GOODS', 										// Transaction type.  Values are:  GOODS, SERVICE, PERSONAL, CASHADVANCE, DIGITALGOODS
								'PaymentSubType' => '', 									// The transaction subtype for the payment.
								'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => ''), // Receiver's phone number.   Numbers only.
								'Primary' => 'false'												// Whether this receiver is the primary receiver.  Values are boolean:  TRUE, FALSE
								);
				array_push($Receivers,$Receiver);
			}
			
		}
		
		$SenderIdentifierFields = array(
										'UseCredentials' => ''						// If TRUE, use credentials to identify the sender.  Default is false.
										);
										
		$AccountIdentifierFields = array(
										'Email' => '', 								// Sender's email address.  127 char max.
										'Phone' => array('CountryCode' => '', 'PhoneNumber' => '', 'Extension' => '')								// Sender's phone number.  Numbers only.
										);
										
		$PayPalRequestData = array(
							'PayRequestFields' => $PayRequestFields, 
							'ClientDetailsFields' => $ClientDetailsFields, 
							'FundingTypes' => $FundingTypes, 
							'Receivers' => $Receivers, 
							'SenderIdentifierFields' => $SenderIdentifierFields, 
							'AccountIdentifierFields' => $AccountIdentifierFields
							);
		// Load PayPal library
		//pr($PayPalRequestData,1);
		$this->config->load('paypal');
		$config = array(
			'Sandbox' => $this->config->item('Sandbox'), 			// Sandbox / testing mode option.
			'APIUsername' => $this->config->item('APIUsername'), 	// PayPal API username of the API caller
			'APIPassword' => $this->config->item('APIPassword'), 	// PayPal API password of the API caller
			'APISignature' => $this->config->item('APISignature'), 	// PayPal API signature of the API caller
			'APISubject' => '', 									// PayPal API subject (email address of 3rd party user that has granted API permission for your app)
			'APIVersion' => $this->config->item('APIVersion'), 		// API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
			'DeviceID' => $this->config->item('DeviceID'), 
			'ApplicationID' => $this->config->item('ApplicationID'), 
			'DeveloperEmailAccount' => $this->config->item('DeveloperEmailAccount')
		);
		
		if($config['Sandbox'])
		{
			// Show Errors
			error_reporting(E_ALL);
			ini_set('display_errors', '1');	
		}
		
		$this->load->library('paypal/Paypal_adaptive', $config);	

		$PayPalResult = $this->paypal_adaptive->Pay($PayPalRequestData);
		//pr($PayPalResult,1);
		
		if(!$this->paypal_adaptive->APICallSuccessful($PayPalResult['Ack']))
		{
			$errors = array('Errors'=>$PayPalResult['Errors']);
			return $errors;
			/*echo 'Paypal Payment error';
			print_r($errors); die();*/
			//$this->load->view('paypal/samples/error',$errors);
		}
		else
		{
			// Successful call.  Load view or whatever you need to do here.
			return $PayPalResult;
			/*echo '<pre />';
			print_r($PayPalResult);
			die;*/
			//echo '<p><a href="' . $PayPalResult['RedirectURL'] . '">PROCEED TO PAYPAL</a></p>';
		}
	}

	public function checkuser($id){
		$this->db->where('user_id',$id);
		$query=$this->db->get('billing_address');
		//echo $this->db->last_query();die();
		return $query->row_array(); 
	}
    
    public function updatebillingaddress($id,$data){
      $this->db->update('billing_address',$data,array('user_id'=>$id));
      //echo $this->db->last_query();die();
      return $id;
    }

	public function get_countries(){
    	$this->db->select('*');
    	$qry=$this->db->get('countries');
    	$result=$qry->result_array();
		// $new=array('Select Country');
		// foreach ($result as $val) {
		// 	$new[$val['id']]=$val['name'];
		// }
    	return $result=$qry->result_array();
    }

    public function get_states($country_id){
    	$this->db->select('*');
    	$this->db->where('country_id',$country_id);
    	$query=$this->db->get('states');
    	$output = '<option value="">Select Country First</option>';
	  	foreach($query->result() as $row)
	  	{
	   		$output .= '<option data-state-id="'.$row->id.'" value="'.$row->id.'">'.$row->name.'</option>';
	  	}
		return $output;
    }

    public function get_cities($state_id){
    	$this->db->select('*');
    	$this->db->where('state_id',$state_id);
    	$query=$this->db->get('cities');
    	$output = '<option value="">Select State First</option>';
		foreach($query->result() as $row)
		{	
			$output .= '<option value="'.$row->id.'">'.$row->name.'</option>';
		}
		return $output;
    }	


     public function getOrderDetailsByid($order_id)
	{
		$this->db->select('*');
		$this->db->where('id',$order_id);
		$this->db->where('status','1');
		$this->db->where('delete_status','0');
		$query = $this->db->get('orders');
		if($query->num_rows()>0)
		{
			$response = $query->row_array();
			return $response;
		}else{
			return false;
		}
    }
	public function addresssave($post){
	  	$this->db->insert('billing_address',$post);
	  	return $this->db->last_query();
    }
	public function getbillingaddress($id){
		$this->db->where('user_id',$id);
		$query=$this->db->get('billing_address');
		return $query->row_array(); 
	}
	public function getstatename($id){
      $this->db->where('id',$id);
      $query=$this->db->get('states');
      return $query->row_array(); 
	}
	public function getcityname($id){
		$this->db->where('id',$id);
		$query=$this->db->get('cities');		
		return $query->row_array();
	}

    public function create_charge($orderId,$stripeToken,$amount)
    {
    	
    	require_once('application/libraries/stripe/vendor/autoload.php');
		\Stripe\Stripe::setApiKey(STRIPE_SECRET);
		
		$charge = \Stripe\Charge::create([
			'amount' => $amount*100,
			'currency' => 'usd',
			'description' =>'' ,
			'source' => $stripeToken,
			'transfer_group' => 'ORDER_'.$orderId,
		]);
		if($charge)
		{
			return $charge;
		}else{
			return array();
		}
    }
}


