<link rel="stylesheet" href="<?php echo base_url(); ?>/assets/web/css/style.css" />    
<!-- jQuery is used only for this example; it isn't required to use Stripe -->
<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script> -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" />

    <!-- Stripe JavaScript library -->
    <script type="text/javascript" src="https://js.stripe.com/v2/"></script>    
    <script type="text/javascript">
        //set your publishable key
        var key='<?php echo STRIPE_KEY; ?>';
        //alert(key);
        Stripe.setPublishableKey(key);
        
        //callback to handle the response from stripe
        function stripeResponseHandler(status, response) {
            if (response.error) {
                //enable the submit button
                $('#payBtn').removeAttr("disabled");
                //display the errors on the form
                // $('#payment-errors').attr('hidden', 'false');
                $('#payment-errors').addClass('alert alert-danger');
                $("#payment-errors").html(response.error.message);
            } else {
                var form$ = $("#paymentFrm");
                //get token id
                var token = response['id'];
                //insert the token into the form
                form$.append("<input type='hidden' name='stripeToken' value='" + token + "' />");
                //submit form to the server
                form$.get(0).submit();
            }
        }
        $(document).ready(function() {
            //on form submit
            $("#paymentFrm").submit(function(event) {
                //disable the submit button to prevent repeated clicks
                $('#payBtn').attr("disabled", "disabled");
                
                //create single-use token to charge the user
                Stripe.createToken({
                    number: $('#card_num').val(),
                    cvc: $('#card-cvc').val(),
                    exp_month: $('#card-expiry-month').val(),
                    exp_year: $('#card-expiry-year').val()
                }, stripeResponseHandler);
                
                //submit from callback
                return false;
            });
        });
    </script>
<section class="initiate_payment section_padding">
   <?php //print_r($details); ?>
   <div class="">
      <div class="col-md-8 margin_auto">
         <div id="accordion" class="checkout">
            <div class="checkout-step">
               <div role="tab" id="headingOne" class="tabheading">
                  <h4 class="checkout-step-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" > Delivery Address </a> </h4>
               </div>
               <div id="collapseOne" class="panel-collapse collapse show">
                  <div class="checkout-step-body">
                     <div class="checout-address-step">
                        <div class="row">
                           <form action="<?php echo base_url('payment/stripepayment')?>" method="post" id="payment-form">
                              <input type="hidden" name="user_id" value="<?php print_r($_SESSION['logged_user']['id']); ?>">
                              <div class="inventory_section">
                                 <div class="input-group">
                                    <label>Full Name :</label>
                                    <input type="text" name="full_name" id="full_name" required="required" class="form-control" placeholder="Full Name" value="<?php echo $details['full_name']; ?>">
                                 </div>
                              </div>
                              <div class="inventory_section">
                                 <div class="input-group">
                                    <label>Address :</label>
                                    <textarea name="address" id="address" required="required" class="form-control"><?php echo $details['address']; ?></textarea>
                                 </div>
                              </div>
                              <div class="inventory_section">
                                 <div class="input-group">
                                    <label>Mobile Number :</label>
                                    <input type="text" name="mobile" id="mobile" required="required" class="form-control" placeholder="Mobile Number" value="<?php echo $details['mobile']; ?>">
                                 </div>
                              </div>
                              <div class="inventory_section">
                                 <div class="input-group">
                                    <label>Country :</label>
                                    <select name="country" id="country" required="required" class="form-control">
                                       <?php 
                                          foreach ($countries as $key => $value) {?>
                                       <option value="<?php echo $value['id']; ?>" <?php if($value['id']==$details['country']){echo "selected"; } ?> ><?php echo $value['name']; ?></option>
                                       <?php  } ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="inventory_section">
                                 <div class="input-group">
                                    <label>State :</label>
                                    <select name="state" id="state" required="required" class="form-control state">
                                      <?php 
                                        
                                        $state=$this->Payment_model->getstatename($details['state']);
                                         
                                       if ($state) {?>
                                      <option value="<?php echo $state['id']; ?>" ><?php echo $state['name']; ?></option>
                                     <?php } ?>

                                    </select>
                                 </div>
                              </div>
                              <div class="inventory_section">
                                 <div class="input-group">
                                    <label>City :</label>
                                    <select name="city" id="city" required="required" class="form-control">
                                      <?php 
                                        $city=$this->Payment_model->getcityname($details['city']);

                                      if ($city) {?>
                                      <option value="<?php echo $city['id']; ?>" ><?php echo $city['name']; ?></option>
                                     <?php } ?>
                                    </select>
                                 </div>
                              </div>
                              <div class="inventory_section">
                                 <div class="input-group">
                                    <label>Zip/Postal Code :</label>
                                    <input type="text" name="postal_code" id="postal_code" required="required" class="form-control" placeholder="Zip/Postal Code" value="<?php echo  $details['postal_code']; ?>">
                                 </div>
                              </div>
                              <div class="inventory_section">
                                 <div class="input-group">
                                    <label>street :</label>
                                    <input type="text" name="street" id="street" required="required" class="form-control" placeholder="street" value="<?php echo  $details['street'];?>">
                                 </div>
                              </div>
                              <div class="checkout_action_button">
                             <!--  <button class="btn btn-secondary cancel" type="reset">Cancel</button> -->
                              <button type="submit" id="step1">Use This Address</button>
                              </div> 
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="common-details">
                 <div class="username">User</div>
                 <div class="orherinfo">
                    <div class="leftinfo"><?php if($details){
                       echo $details['address'];
                    }else{
                      echo "Please add Address";
                    } ?></div>
                    <a class="rightinfo" id="reopenstep1"><i class="fa fa-pencil"></i> &nbsp; Edit</a>
                 </div>
               </div>
            </div>
            <div class="panel checkout-step">
               <div role="tab" id="headingTwo" class="tabheading">
                  <h4 class="checkout-step-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"> Payment </a> </h4>
                  <?php if($this->session->flashdata('error_message')) {echo $this->session->flashdata('error_message'); }?>
               </div>
               <div id="collapseTwo" class="panel-collapse collapse">
                  <div class="checkout-step-body">
                     <div class="row">
                        <div class="col-sm-12 paymentmethod">
                           <img src="<?php echo base_url(); ?>assets/imgs/visa.png" class="paymentcard">
                           <img src="<?php echo base_url(); ?>assets/imgs/Mcard.png" class="paymentcard">
                           <img src="<?php echo base_url(); ?>assets/imgs/AEX.png" class="paymentcard">
                           <img src="<?php echo base_url(); ?>assets/imgs/DISC.png" class="paymentcard">
                        </div>
                        <br>
                        <div class="stripepayment">
                           <div class="col-sm-12 mystripe">
                                 <div class="card-body">
                                    <?php if (validation_errors()): ?>
                                    <div class="alert alert-danger" role="alert">
                                       <strong>Oops!</strong>
                                       <?php echo validation_errors() ;?> 
                                    </div>
                                    <?php endif ?>
                                    <div id="payment-errors"></div>
                                    <form method="post" id="paymentFrm" enctype="multipart/form-data" action="<?php echo base_url(); ?>payment/check">
                                       <input type="hidden" name="full_name" value="<?php echo $data['full_name']; ?>">
                                       <input type="hidden" name="address" value="<?php echo $data['address']; ?>">
                                       <input type="hidden" name="mobile" value="<?php echo $data['mobile']; ?>">
                                       <input type="hidden" name="country" value="<?php echo $data['country']; ?>">
                                       <input type="hidden" name="state" value="<?php echo $data['state']; ?>">
                                       <input type="hidden" name="city" value="<?php echo $data['city']; ?>">
                                       <input type="hidden" name="postal_code" value="<?php echo $data['postal_code']; ?>">
                                       <input type="hidden" name="street" value="<?php echo $data['street']; ?>">
                                       <div class="form-group">
                                          <input type="text" name="name" class="form-control" placeholder="Name" value="<?php echo set_value('name'); ?>" required>
                                       </div>
                                       <div class="form-group">
                                          <input type="email" name="email" class="form-control" placeholder="email@you.com" value="<?php echo set_value('email'); ?>" required />
                                       </div>
                                       <div class="form-group">
                                          <input type="number" name="card_num" id="card_num" class="form-control" placeholder="Card Number" autocomplete="off" value="<?php echo set_value('card_num'); ?>" required>
                                       </div>
                                       <div class="row">
                                          <div class="col-sm-8">
                                             <div class="row">
                                                <div class="col-sm-6">
                                                   <div class="form-group">
                                                      <input type="text" name="exp_month" maxlength="2" class="form-control" id="card-expiry-month" placeholder="MM" value="<?php echo set_value('exp_month'); ?>" required>
                                                   </div>
                                                </div>
                                                <div class="col-sm-6">
                                                   <div class="form-group">
                                                      <input type="text" name="exp_year" class="form-control" maxlength="4" id="card-expiry-year" placeholder="YYYY" required="" value="<?php echo set_value('exp_year'); ?>">
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                          <div class="col-sm-4">
                                             <div class="form-group">
                                                <input type="text" name="cvc" id="card-cvc" maxlength="3" class="form-control" autocomplete="off" placeholder="CVC" value="<?php echo set_value('cvc'); ?>" required>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="form-group text-right">
                                          <button class="btn btn-secondary cancel" type="reset">Cancel</button>
                                          <button type="submit" id="payBtn" class="btn btn-success">Submit Payment</button>
                                       </div>
                                    </form>
                                 </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <div class="common-details">
                 <a class="addnew" id="reopenstep2"><i class="fa fa-plus"></i> &nbsp; New Payment Method</a>
               </div>
            </div>
            <div class="panel checkout-step">
               <div role="tab" id="headingThree" class="tabheading">
                  <h4 class="checkout-step-title"> <a class="collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseThree"> Items In Cart </a> </h4>
               </div>
               <div id="collapseThree" class="panel-collapse collapse show">
                  <div class="checkout-step-body">

                    <?php //echo "<pre>"; print_r($cartItems);
                    foreach ($cartItems as $key => $value) {
                   foreach ($value as $key => $value2) {
                                       
                     ?>
                     <div class="cartitemsrc">
                       <div class="cartimag">
                          
                          <img  src="<?php echo base_url('assets/uploads/product-images/'.$value2['image']);?>">
                       </div>
                       <div class="cartproductinfo">
                         <h4><?php echo $value2['product_name']; ?></h4>
                         <!-- <p>Black, Size 1 bottle</p> -->
                         <p>Shipping: <?php if($value2['shipping']>0) { echo $value['shipping']; }else{echo "free"; } ?></p>
                         <p>Shipping days: <?php echo $value2['shipping_time'].' days'; ?></p>
                         <!-- <input type="text" class="cartquantity"> --> Quantity: <?php echo $value2['cart_quantity']; ?>
                       </div>
                       <div class="cartproductprice">
                         <h4><span class="oldprice"><?php echo $value2['sum_price']; ?></span></h4>
                       </div>
                     </div>
                     <?php } }?>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</section>
<script type="text/javascript">
$(document).ready(function () {
  $('#collapseOne').hide();
  $(document).on('click', '#step1', function () {
    $('#collapseOne').hide();
    $('#collapseTwo').addClass('show');
  });
  $(document).on('click', '#collapseOne', function () {
    $('#collapseTwo').hide();
  });
  $(document).on('click', '#reopenstep1', function () {
    $('#collapseOne').addClass('show');
    $('#collapseOne').show();
    $('.orherinfo').hide();
  });
  $(document).on('click', '#reopenstep2', function () {
    $('#collapseTwo').addClass('show');
    $('#collapseTwo').show();
  });
  $(document).on('click','.cancel',function(){
    $('#collapseOne').toggle();
    $('.orherinfo').toggle();
  });



});


$('#country').change(function () {
  var country_id = $(this).val();
  if (country_id != '0') {
    $.ajax({
      url: "<?=base_url();?>payment/get_states",
      method: "POST",
      data: {
        country_id: country_id
      },
      success: function (data) {
        $('#state').html(data);
        $('#city').html('<option value="">Select City</option>');
      }
    });
  } else {
    $('#state').html('<option value="">Select State</option>');
    $('#city').html('<option value="">Select City</option>');
  }
});

$('#state').change(function () {
  var state_id = $(this).val();
  if (state_id != '') {
    $.ajax({
      url: "<?php echo base_url(); ?>payment/get_cities",
      method: "POST",
      data: {
        state_id: state_id
      },
      success: function (data) {
        $('#city').html(data);
      }
    });
  } else {
    $('#city').html('<option value="">Select City</option>');
  }
});
</script>
<style type="text/css">
   .checkout-wrapper{padding-top: 40px; padding-bottom:40px; background-color: #fafbfa;}
   .checkout{    
   background-color: #fff;
   font-size: 14px;
   margin-bottom: 60px;
    float: left;
   }
   .cartimag img {
    width: 100%;
}
  .group label {
    text-align: left;
    letter-spacing: 0;
  }
   .panel{margin-bottom: 0px;}
   .checkout-step-body {
   padding: 10px 50px;
   padding-top: 30px;
   border-left: 1px solid rgb(212, 227, 235);
   border-right: 1px solid rgb(212, 227, 235);
   }
   .checkout-step-title {
   margin: 0px;
   }
   .checout-address-step{}
   .checout-address-step .form-group{margin-bottom: 18px;display: inline-block;
   width: 100%;}
   .checkout-step-body{padding-left: 60px; padding-top: 30px;}
   .checkout-step-active{display: block;}
   .checkout-step-disabled{display: none;}
   .tabheading{
   background-color: rgb(240, 245, 247);
   font-size: 18px;
   font-weight: 700;
   padding: 12px 24px;
   border-width: 1px;
   border-style: solid;
   border-color: rgb(212, 227, 235);
   border-image: initial;
   }
   .checkout-step-title a {
   color: rgb(25, 42, 50);
   font-size: 18px;
   font-weight: 900;
   }
   a.cancel {
    background: #01578b;
    border: 0;
    padding: 8px 15px;
    color: #fff;
    border-radius: 5px;
    margin-top: 10px;
    cursor: pointer;
    transition: 0.5s;
}
.checkout_action_button{
  float: right;
  width: 100%;
  position: relative;
}
</style>
