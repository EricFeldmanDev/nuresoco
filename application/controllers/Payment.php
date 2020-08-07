<?php

/*
 * Only vendors class
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends MY_Controller
{


    public function __construct()
    {
        parent::__construct();
        $this->load->model('Payment_model');
        /*if(!$this->site_santry->is_login()){
            redirect('');
        }*/
    }


    public function payment_success($payment_id=""){
        $head['title'] = 'Payment Success';
        $head['description'] = '';
        $head['keywords'] = '';
        $data['vendorInfo'] = '';
        $this->render('checkout_parts/payment_success', $head, $data);
    }

    public function payment_form(){
        $data=array();
        $head['title'] = 'Payment Form';
        $head['description'] = '';
        $head['keywords'] = '';
        //$data['vendorInfo'] = '';
        $data['countries'] = $this->Payment_model->get_countries();
        // echo "<pre>";
        // print_r($data['countries']);die();
        if(!empty($_SESSION['logged_user']['id'])){            
        $data['details']=$this->Payment_model->getbillingaddress($_SESSION['logged_user']['id']);
        // print_r($_SESSION['logged_user']['id']);
        // print_r($data['details']);
        }
        $data['states'] = array('Select Country First');
        $data['cities'] = array('Select State First');
        // echo "<pre>";
        // print_r($data);
        $data['cartItems'] = $this->shoppingcart->getCartItems();
        $this->render('checkout_parts/payment_form', $head, $data);
    }

    public function payment_failed(){
        $head['title'] = 'Payment Faild';
        $head['description'] = '';
        $head['keywords'] = '';
        $data['vendorInfo'] = '';
        $this->render('checkout_parts/payment_failed', $head, $data);
    }

    public function userPayment(){
        $head['title'] = 'User Payment';
        $head['description'] = '';
        $head['keywords'] = '';
        $data['cartItems']=$this->shoppingcart->getCartItems();
        $data['vendorInfo'] = '';
        $this->render('checkout_parts/user_payment', $head, $data);
    }

    public function product_address(){
       $this->load->library('user_agent');
       $referrer = $this->agent->referrer();
       $user_id=$_SESSION['logged_user']['id'];
       $post=$this->input->post();
       if($post){
        redirect('payment/userPayment'); 
       } 
    }
    
    public function stripepayment(){
    // $fulldata['datav']=$this->input->post();
     $billingform=$this->input->post();
       $user_id=$_SESSION['logged_user']['id'];
     //$userid=$this->input->post('user_id');
     $check=$this->Payment_model->checkuser($user_id);
     if($check>0){
     	
     $data=array(
                 'full_name'=>$this->input->post('full_name'),
                 'address'  =>$this->input->post('address'),
                 'mobile'   =>$this->input->post('mobile'),
                 'country'  =>$this->input->post('country'),
                 'state'    =>$this->input->post('state'),
                 'city'     =>$this->input->post('city'),
                 'postal_code'=>$this->input->post('postal_code'),
                 'street'   =>$this->input->post('street')
                );
     //print_r($data);die();
     $this->Payment_model->updatebillingaddress($user_id,$data);
     }else{
     	//echo "li";die();
     $this->Payment_model->addresssave($billingform);
     }     
     //$this->load->view('product_form',$fulldata);
     $data['details']=$this->input->post();
     $data['countries'] = $this->Payment_model->get_countries();
     $data['state']=$this->Payment_model->getstatename($data['details']['state']);
     
     $data['city']=$this->Payment_model->getcityname($data['details']['city']);
     //print_r($data['city']);
     $this->render('checkout_parts/payment_form', $head, $data);


    }
    public function check()
    {
        //echo "string";die();
        //check whether stripe token is not empty
        if(!empty($_POST['stripeToken']))
        {


            //get token, card and user info from the form
        $token  = $_POST['stripeToken'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $card_num = $_POST['card_num'];
        $card_cvc = $_POST['cvc'];
        $card_exp_month = $_POST['exp_month'];
        $card_exp_year = $_POST['exp_year'];
        $street=$_POST['street'];
        $user_id=$_SESSION['logged_user']['id'];
        $orderDetails=$this->shoppingcart->getCartItems();
        //print_r($orderDetails);die();
        
        $discount_code='';
        $price = round(str_replace(',','',$orderDetails['finalSum']));
        $totalSum=round($price)*100;
        $discountCode_percentage='';
        $couponDiscountAmount='';
        if($this->session->userdata('discount_code')!='' && $this->session->userdata('discount_code_percentage')!=''){
            $discount_code=$this->session->userdata('discount_code');
            $discountCode_percentage=$this->session->userdata('discount_code_percentage');  
            $totalSum=round(($price-($price*$discountCode_percentage)/100)*100);
            $couponDiscountAmount=($price*$discountCode_percentage)/100;
          
        }  
        try {
                       //include Stripe PHP library
            require_once APPPATH."third_party/stripe/init.php";
            
            //set api key
            $stripe = array(
              "secret_key"      => STRIPE_SECRET,
              "publishable_key" => STRIPE_KEY
            );
            
            \Stripe\Stripe::setApiKey($stripe['secret_key']);            

            //add customer to stripe
            $customer = \Stripe\Customer::create(array(
                'email' => $email,
                'source'  => $token
            ));
            
            //item information
            $itemName = "Ondemand";
            $itemNumber = rand(111111,999999);
            $itemPrice =$totalSum ;
            $currency = "GBP";
            $orderID = "SKA92712382139";
            
            //charge a credit or a debit card
            $charge = \Stripe\Charge::create(array(
                'customer' => $customer->id,
                'amount'   => $itemPrice,
                'currency' => $currency,
                'description' => $itemNumber,
                'metadata' => array(
                'item_id' => $itemNumber
                )
            ));
            
            //retrieve charge details
            $chargeJson = $charge->jsonSerialize();
            //check whether the charge is successful
            if($chargeJson['amount_refunded'] == 0 && empty($chargeJson['failure_code']) && $chargeJson['paid'] == 1 && $chargeJson['captured'] == 1)
            {
                //order details 
                $amount = $chargeJson['amount'];
                $balance_transaction = $chargeJson['balance_transaction'];
                $currency = $chargeJson['currency'];
                $status = $chargeJson['status'];
                $date = date("Y-m-d H:i:s");            
                $post = $this->Payment_model->getbillingaddress($_SESSION['logged_user']['id']);
                                       
                $post['coupon_code']=$discount_code;
                $post['coupon_percentage']=$discountCode_percentage;
                $post['finalsum']=$price;
                $post['coupon_discount_amount']=$couponDiscountAmount;
                //insert tansaction data into the database
                $dataDB = array( 
                    'name' =>$name,                   
                    'email' => $email, 
                    'card_num' => $card_num, 
                    'card_cvc' => $card_cvc, 
                    'card_exp_month' => $card_exp_month, 
                    'card_exp_year' => $card_exp_year, 
                    'item_name' => $itemName,                    
                    'final_amount' => $price, 
                    'item_price_currency' => $currency, 
                    'final_amount' => $amount,
                    'item_price_currency'=> $currency,              
                    'transation_id' => $balance_transaction, 
                    'payment_status' => $status,
                    'created_on' => $date,
                    'modified_on' => $date,
                    'street' =>$street
                );
                $orderIdArray=$this->Payment_model->add_order_request($orderDetails,$post,$user_id,$dataDB);
                if ($orderIdArray) {
                     $data['insertID']=$orderIdArray;
                     if($orderIdArray && $status == 'succeeded'){
                        $this->shoppingcart->clearShoppingCart();
                        $this->load->view('payment_success',$data);
                        //redirect('Welcome/payment_success','refresh');
                    }else{                    
                      echo "Transaction has been failed";
                    }
                }
                else
                {
                    echo "not inserted. Transaction has been failed";
                }

            }
            else
            {
                echo "Invalid Token";
                $statusMsg = "";
            }
            }
            //catch exception
            catch(Exception $e) {
              echo 'Message: ' .$e->getMessage();
              $this->session->set_flashdata('error_message',$e->getMessage());
              redirect('payment/payment_form');
            }     
          
        }
    }

    public function initiate_payment(){
        $this->load->library('user_agent');
        $referrer = $this->agent->referrer();
        $user_id=$_SESSION['logged_user']['id'];
        $orderDetails=$this->shoppingcart->getCartItems();
        $discount_code='';
        $price = round(str_replace(',','',$orderDetails['finalSum']));
        $totalSum=round($price);
        $discountCode_percentage='';
        $couponDiscountAmount='';
        if($this->session->userdata('discount_code')!='' && $this->session->userdata('discount_code_percentage')!=''){
            $discount_code=$this->session->userdata('discount_code');
            $discountCode_percentage=$this->session->userdata('discount_code_percentage');  
            $totalSum=$price-($price*$discountCode_percentage)/100;
            $couponDiscountAmount=($price*$discountCode_percentage)/100;
          
        }
        if($this->input->post())
        { 
            $post = $this->input->post();            
            $post['coupon_code']=$discount_code;
            $post['coupon_percentage']=$discountCode_percentage;
            $post['finalsum']=$totalSum;
            $post['coupon_discount_amount']=$couponDiscountAmount;
            $paymentDetails = $this->paynow($orderDetails,$post,$user_id);
            if($paymentDetails){
                $this->session->set_flashdata('flashSuccess','');
                redirect('payment/userPayment');
            }else{
                $this->session->set_flashdata('flashError','Payment Failed!');
            }
        }else{
            $this->session->set_flashdata('flashError',"You can't hit this url directly!");
        }
    }    

    public function paynow($orderDetails,$post,$user_id) 
    {    
       
        if(!empty($orderDetails)){
            $orderIdArray=$this->Payment_model->add_order_request($orderDetails,$post,$user_id);
            if(!empty($orderIdArray))
            {
                $finalsum=$post['finalsum'];
                $response = $this->Payment_model->pay_delayed_chained($orderDetails,$finalsum,$orderIdArray['order_id']);
                //pr($response,1);
                if(empty($response['Errors']))
                {
                    if($response['Ack']=='Success')
                    {

                        $updateArr=array();
                        $updateArr['transation_id']=$response['PayKey'];
                        $this->commonmodel->_update('orders',$updateArr,array('id'=>$orderIdArray['order_id']));
                        /*$updateArr['paypal_paykey']=$response['PayKey'];
                        $this->commonmodel->_update('orders',$updateArr,array('payment_id'=>$paymentDetails['payment_id']));*/
                        redirect($response['RedirectURL']);
                    }else{
                         $this->payment_failed_data($orderIdArray);
                    }
                }else{
                    // $this->session->set_flashdata('paypalError',$response['Errors'][0]['Message']);
                    // redirect('payment/payment_failed');       
                    $this->payment_failed_data($orderIdArray);
                }    
            }else{
                redirect('payment/payment_failed');
            }
            /* if($payment){
                $transaction_id=$payment['balance_transaction'];
                $paid_amount=$payment['amount']/100;
                $created_timestamp=$payment['created'];
                $created_date=date('Y-m-d',$created_timestamp);
                $success_data=array();
                $success_data['transaction_id']=$transaction_id;
                $success_data['paid_amount']=$paid_amount;
                $success_data['created_date']=$created_date;
                $this->session->set_userdata('success_data',$success_data);
                redirect('payment/payment_success');
            }else{
                redirect('payment/payment_failed');
            } */
        }else{
            return false;
        }
    }
    public function thirdparty_payment(){
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
    public function payment_details($paypal_key="",$payment_id)
    {
        $this->config->load('paypal');
        $config = array(
            'Sandbox' => $this->config->item('Sandbox'),            // Sandbox / testing mode option.
            'APIUsername' => $this->config->item('APIUsername'),    // PayPal API username of the API caller
            'APIPassword' => $this->config->item('APIPassword'),    // PayPal API password of the API caller
            'APISignature' => $this->config->item('APISignature'),  // PayPal API signature of the API caller
            'APISubject' => '',                                     // PayPal API subject (email address of 3rd party user that has granted API permission for your app)
            'APIVersion' => $this->config->item('APIVersion'),      // API version you'd like to use for your call.  You can set a default version in the class and leave this blank if you want.
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
        // Prepare request arrays
        if($paypal_key){
            $PaymentDetailsFields = array(
                                        'PayKey' => $paypal_key,
                                        );
                                        
            $PayPalRequestData = array('PaymentDetailsFields' => $PaymentDetailsFields);
            $PayPalResult = $this->paypal_adaptive->PaymentDetails($PayPalRequestData);
            if(!$this->paypal_adaptive->APICallSuccessful($PayPalResult['Ack']))
            {
                $errors = array('Errors'=>$PayPalResult['Errors']);
                $this->payment_failed_data($payment_id);
              //  $this->load->view('paypal/samples/error',$errors);
            }
            else
            {
               return $PayPalResult;
                // Successful call.  Load view or whatever you need to do here. 
            }
            
        }
        else {
            echo 'error'; die;
        }
    }

    public function paypal_payment_success($payment_id="")
    {
            $payment_id = base64_decode($payment_id);
            $orderDetails = array();
            $orderDetails = $this->Payment_model->getOrderDetailsByid($payment_id);
            if(!empty($orderDetails))
            {
                

                $paypal_paykey=$this->getPayKeyByPayId($payment_id);  
                $paymentDetails=$this->payment_details($paypal_paykey,$payment_id);
                if($paymentDetails){
                    $updateArr = array();
                    $updateArr['payment_status'] = 'SUCCESS';
                    $this->commonmodel->_update('orders',$updateArr,array('id'=>$payment_id));
                    $userDetails=$this->commonmodel->_get_data('users_public',array('id'=>$orderDetails['id']));
                    $userMail=$userDetails[0]['email'];   
                    //pr($appointmentDetails,1);
                    $data=array('amount'=>$orderDetails['final_amount'],'date'=>$orderDetails['modified_on'],'transation_id'=>$paypal_paykey,'email'=>$userMail);
                    $this->session->set_userdata('successData',$data);
                    redirect('payment/payment_success');    
                }else {
                    $this->payment_failed_data($payment_id);
                }
                //pr($paypal_paykey,1);
            }else{
                redirect('payment/payment_failed');
            }
            
           
    }
    public function payment_failed_data($orderIdArray)
    {
        $order_id = $orderIdArray['order_id'];
        $updateArr = array();
        $updateArr['payment_status'] = 'FAILED';
        $updateArr['order_id'] = date('Y-m-d H:i:s');
        $this->commonmodel->_update('orders',$updateArr,array('id'=>$order_id));
        
       /* $condition = array();
        $condition['appointment_id'] = $appointment_id;
        $condition['payment_id'] = $paymentDetails['payment_id'];
        $condition['payment_token'] = $paymentDetails['payment_token'];
        
        $updateArr = array();
        $updateArr['payment_status'] = 'FAILED';
        $this->commonmodel->_update('payments',$updateArr,$condition);*/
        
        $this->session->set_flashdata('flashError','Payment Failed!');
        redirect('payment/payment_failed');
        //pr($paymentDetails,1);
    }

    public function getPayKeyByPayId($payment_id=''){
        if($payment_id!=''){
            $this->db->select('transation_id'); 
            $this->db->from('orders');    
            $this->db->where('id',$payment_id);
            $get=$this->db->get();
            if($get->num_rows()>0){
                $result=$get->row_array();
                return $result['transation_id'];
            }   
            else {
               return '';
            }
        }
        else {
            return '';
        }
    }


    public function get_states(){
        $country_id=$this->input->post('country_id');
        if($country_id){
          $states=$this->Payment_model->get_states($country_id);
          print_r($states);
          echo $states;     
        }
    }



    public function get_cities(){
        $state_id=$this->input->post('state_id');
        if($state_id){
           $cities=$this->Payment_model->get_cities($state_id);
           echo $cities;
        }
    }

    public function unset_discountCode(){
        unset($_SESSION['discount_code']);
        unset($_SESSION['discount_code_percentage']);
        
    }

    /*public function initiate_payment()
    {
        $this->load->library('user_agent');
        $referrer = $this->agent->referrer();
        if($this->input->post())
        {
            $post = $this->input->post();
            if($appointmentDetails = $this->user_model->checkIfAppointmentExitst($appointment_id))
            {
                //pr($appointmentDetails); die;
                if($appointmentDetails['payment_status']!='SUCCESSFULL')
                {
                    if($paymentDetails = $this->user_model->add_payment_request($appointmentDetails,'STRIPE'))
                    {
                        //pr($paymentDetails,1);
                        $stripeToken = $post['stripeToken'];
                        $this->paynow($paymentDetails,$stripeToken,'STRIPE');
                    }else{
                        $this->session->set_flashdata('flashSuccess','Payment Failed!');
                    }
                }else{
                    $this->session->set_flashdata('flashError','You already paid for this appointment!');
                }
            }else{
                $this->session->set_flashdata('flashError','Appointment not found!');
            }
            redirect($referrer);
        }else{
            $this->session->set_flashdata('flashError',"You can't hit this url directly!");
            redirect($referrer);
        }
    }
    */


    

}