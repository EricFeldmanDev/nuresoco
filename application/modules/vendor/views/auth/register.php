
<section class="user_ww_section">
    <div class="container"> 
		<div class="row"> 
			<div class="col-md-6 user_ww_left">  
				<h1>Merchants</h1>
			</div>
			<div class="col-md-6 user_ww_right">  
				<ul class="sk_wrapp_ul black_ul">
					<li><a class="sk_wrapp_link" href="javascript:void(0);">Merchent</a></li> 
					<li><a class="sk_wrapp_link" href="<?= LANG_URL . '/vendor/login'?>">Login</a></li> 
					<li><a class="sk_wrapp_link active" href="<?= LANG_URL . '/vendor/register'?>">Register</a></li> 
				</ul>
			</div>
		</div>
	</div>
</section>
<section class="merchants_form_section">
    <div class="container">
        <div class="col-md-12 merchants_box_wraap">
		    <div class="row_bar_section">
				<ul class="row_bar_ul">
					
					<li class="" id="bar-1">
						<div class="row_bar_width"></div> 
						<div class="round_row"></div> 
						<p>Shop Preferences</p>
					</li>
					<li class="" id="bar-2">
						<div class="row_bar_width"></div>
						<div class="round_row"></div> 
						<p>Name Your Shop</p>
					</li>
					<li class="" id="bar-3">
						<div class="row_bar_width"></div>
						<div class="round_row"></div>
						<p>How You’ll get Paid </p>
					</li>
					<li>
						<div class="round_row"></div> 
						<p>Set up Billing</p>
					</li>
				</ul>
			</div>
		</div>
		<?php
		if ($this->session->flashdata('error_register')) {
			?>
			<div class="alert alert-danger"><?= implode('<br>', $this->session->flashdata('error_register')) ?></div>
			<?php
		}
		?>
	</div>
</section>
<form action="" method="post" id="frmregister">
	<section class="merchants_form_section" id="shop-preferences">
		<div class="container">
			<div class="col-md-12 merchants_box_wraap">
				<div class="row">
					<div class="merchants_box_heading"> 
						<h3>Add Your Contact Information</h3>
					</div>
					<div class="input-group col-md-6 form_merchant">
						<label>Full Name</label> 
						<input type="text" name="vendor_name" class="form-control" placeholder="Full Name" value="<?= $this->session->flashdata('vendor_name') ? $this->session->flashdata('vendor_name') : '' ?>">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					<div class="input-group col-md-6 form_merchant">
						<label>Email</label> 
						<input type="email" name="vendor_email" class="form-control" placeholder="Email" value="<?= $this->session->flashdata('vendor_email') ? $this->session->flashdata('vendor_email') : '' ?>">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					<div class="input-group col-md-12 form_merchant" style="margin:0px 0px 5px 0px;">
						<label>Street Address</label> 
						<input type="text" name="vendor_street_1" class="form-control" placeholder="Street Address" value="<?= $this->session->flashdata('vendor_street_1') ? $this->session->flashdata('vendor_street_1') : '' ?>">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					<div class="input-group col-md-12 form_merchant">
						<input type="text" name="vendor_street_2" class="form-control" placeholder="Street Address 2 (optional)" value="<?= $this->session->flashdata('vendor_street_2') ? $this->session->flashdata('vendor_street_2') : '' ?>">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					<div class="input-group col-md-6 form_merchant">
						<label>Country/Region</label> 
						<select name="vendor_country" id="vendor_country" class="form-control">
							<option value="">-- Select Country --</option>
							<?php 
							foreach($countries as $key => $country)
							{
							?>
								<option value="<?=$key?>" <?=(($this->session->flashdata('vendor_country')) && $this->session->flashdata('vendor_country')==$key)?'selected':''?>><?=$country?></option>
							<?php 
							}	
							?>
						</select>
					</div>
					<div class="input-group col-md-6 form_merchant">
						<label>State</label>
						<select name="vendor_state" id="vendor_state" class="form-control">
							<option value="">-- Select Country First--</option>
						</select>
					</div>
					<div class="input-group col-md-6 form_merchant">
						<label>City</label> 
						<select name="vendor_city" id="vendor_city" class="form-control">
							<option value="">-- Select State First--</option>
						</select>
					</div>
					<div class="input-group col-md-6 form_merchant">
						<label>Zipcode/Postal Code</label> 
						<input type="text" name="vendor_postal_code" class="form-control" placeholder="Zipcode/Postal Code" value="<?= $this->session->flashdata('vendor_postal_code') ? $this->session->flashdata('vendor_postal_code') : '' ?>">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					<div class="input-group col-md-6 form_merchant">
						<label>Password</label> 
						<input type="password" name="vendor_password" class="form-control" placeholder="Password">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					<div class="input-group col-md-6 form_merchant">
						<label>Confirm Password</label> 
						<input type="password" name="vendor_confirm_password" class="form-control" placeholder="Confirm Password">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					<div class="input-group col-md-6 form_merchant">
						<label>Phone Number</label> 
						<input type="text" name="vendor_phone_country_code" class="form-control" placeholder="Country Code" value="<?= $this->session->flashdata('vendor_phone_country_code') ? $this->session->flashdata('vendor_phone_country_code') : '' ?>">
						<input type="text" name="vendor_phone_area" class="form-control" placeholder="Area" value="<?= $this->session->flashdata('vendor_phone_area') ? $this->session->flashdata('vendor_phone_area') : '' ?>">
						<input type="text" name="vendor_phone_number" class="form-control" placeholder="Number" value="<?= $this->session->flashdata('vendor_phone_number') ? $this->session->flashdata('vendor_phone_number') : '' ?>">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
						<div class="exp_ww">
							<p>Ex. +1 - 234 - 5678910</p>  
							<p>Ex. +86 - 0 - 13912345678</p>  
							<p>Ex. +86 - 21 - 65142545</p>  
						</div>
					</div>
				</div> 		
				<div class="input-group col-md-12 form_merchant">
					<div class="save_button_div">
						<button type="button" id="next-1" class="btn btn-primary pull-right">Next</button>  
					</div>
				</div>
			</div> 		
		</div>	
	</section>

	<section class="merchants_form_section" id="name-your-shop">
		<div class="container">
			<div class="col-md-12 merchants_box_wraap">
				<div class="row">
					<div class="merchants_box_heading"> 
						<h3>Tell us About your Store</h3>
					</div>
					<div class="input-group col-md-12 form_merchant">
						<label>Store Name</label> 
						<input type="text" name="store_name" class="form-control" placeholder="Your store name" value="<?= $this->session->flashdata('store_name') ? $this->session->flashdata('store_name') : '' ?>">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					<div class="input-group col-md-12 form_merchant">
						<label>What store platform are you currently using?</label> 
						<input type="text" name="current_plateform" class="form-control" placeholder="URL Link to store" value="<?= $this->session->flashdata('current_plateform') ? $this->session->flashdata('current_plateform') : '' ?>">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					<div class="input-group col-md-12 form_merchant">
						<label>How much revenue did your store make last year?(USD)</label> 
						<input type="text" name="revenue_last_year" class="form-control" placeholder="Revenue Last year (USD)" value="<?= $this->session->flashdata('revenue_last_year') ? $this->session->flashdata('revenue_last_year') : '' ?>">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					<div class="input-group col-md-6 form_merchant">
						<label>Where is your inventory/warehouse located?</label> 
						<input type="number" name="warehouse_location" min="1" max="10" class="form-control" placeholder="Choose one" value="<?= $this->session->flashdata('warehouse_location') ? $this->session->flashdata('warehouse_location') : '' ?>">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					<div class="input-group col-md-6 form_merchant">
						<label style="opacity:0;">a</label> 
						<input type="text"name="province" class="form-control" placeholder="State/Province/Region" value="<?= $this->session->flashdata('province') ? $this->session->flashdata('province') : '' ?>">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					<div class="input-group col-md-6 form_merchant">
						<label>Country/Region</label> 
						<select name="country" id="country" class="form-control">
							<option value="">-- Select Country --</option>
							<?php 
							foreach($countries as $key => $country)
							{
							?>
								<option value="<?=$key?>" <?=(($this->session->flashdata('country')) && $this->session->flashdata('country')==$key)?'selected':''?>><?=$country?></option>
							<?php 
							}	
							?>
						</select>
					</div>
					<div class="input-group col-md-6 form_merchant">
						<label>State</label>
						<select name="state" id="state" class="form-control">
							<option value="">-- Select Country First--</option>
						</select>
					</div>
					<div class="input-group col-md-6 form_merchant">
						<label>City</label> 
						<select name="city" id="city" class="form-control">
							<option value="">-- Select State First--</option>
						</select>
					</div>
					<div class="input-group col-md-6 form_merchant">
						<label>Zipcode/Postal Code</label> 
						<input type="text" name="pincode" class="form-control" placeholder="Zipcode/Postal Code">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					<div class="input-group col-md-7 form_merchant prodcut_cat">
						<label>Product Categories</label> 
						<?php 
						$categories = shopcategories();
						foreach($categories as $category){ ?>
							<span><label><input name="categories[]" type="checkbox" value="<?=$category['id']?>" checked onclick="return false"/> <?=$category['name']?></label></span>
						<?php } ?>
					</div>
				</div> 		
				<div class="input-group col-md-12 form_merchant">
					<div class="save_button_div">
						<button type="button" id="prev-1" class="btn btn-primary pull-left">Previous</button>  
						<button type="button" id="next-2" class="btn btn-primary pull-right">Next</button>  
					</div>
				</div>
			</div> 		
		</div>	
	</section>

	<section class="merchants_form_section" id="stock-your-shop">
		<div class="container">
			<div class="col-md-12 merchants_box_wraap">
				<div class="row">
					<div class="merchants_box_heading"> 
						<div class="reg_pay_logo"><img src="/assets/imgs/paypal-logo_new.png"></div> 
						<h3>How You’ll get Paid</h3>
					</div>

					<div class="col-md-6 left_er_form"> 
					<div class="left-merchants_box">
						<div class="form-group to_start">
							<label>To start, where is your bank located?</label>
							<select name="getpaid_bank_location" id="getpaid_bank_location" class="form-control">
								<option value="">-- Select Country --</option>
								<?php 
								foreach($countries as $key => $country)
								{
								?>
									<option value="<?=$key?>" <?=(($this->session->flashdata('getpaid_bank_location')) && $this->session->flashdata('getpaid_bank_location')==$key)?'selected':''?>><?=$country?></option>
								<?php 
								}	
								?>
							</select>
							<p class="didnt_country"><a href="#">Didn’t your country?</a></p>
						</div> 
						<div class="form-group where_should">
							<label>Where Should we pay your funds?</label>
							<p><i class="fa fa-lock"></i> Your information is protected using 55L encryption and security</p>
						</div>
						
						<div class="form-group">
							<label>paypal first name</label>
							<input type="text" name="paypal_first_name" class="form-control" placeholder="paypal first name" value="<?= $this->session->flashdata('paypal_first_name') ? $this->session->flashdata('paypal_first_name') : '' ?>" required>
						</div>
						<div class="form-group">
							<label>paypal last name</label>
							<input type="text" name="paypal_last_name" class="form-control" placeholder="paypal last name" value="<?= $this->session->flashdata('paypal_last_name') ? $this->session->flashdata('paypal_last_name') : '' ?>" required>
						</div>
						<div class="form-group">
							<label>paypal Email</label>
							<input type="email" name="paypal_email" class="form-control" placeholder="paypal email" value="<?= $this->session->flashdata('paypal_email') ? $this->session->flashdata('paypal_email') : '' ?>" required>
						</div> 
						<!-- <div class="form-group">
							<label>Account Number</label>
							<input type="text" name="getpaid_account_number" class="form-control" placeholder="Account Number" value="<?= $this->session->flashdata('account_number') ? $this->session->flashdata('account_number') : '' ?>">
						</div>  -->
					</div> 
					</div>
					<div class="col-md-6 left_er_form"> 
					<div class="right-merchants_box">
						<div class="form-group tell_us">
							<!-- <label>Tell us a little bit about yourse If</label>
							<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s.<a href="#" class="learn_more">Learn More</a></p> -->
						</div>
						<div class="form-group">
							<label>Country of residence</label>
							<select name="getpaid_residence_country" id="getpaid_residence_country" class="form-control">
								<option value="">-- Select Country --</option>
								<?php
								foreach($countries as $key => $country)
								{
								?>
									<option value="<?=$key?>" <?=(($this->session->flashdata('getpaid_residence_country')) && $this->session->flashdata('getpaid_residence_country')==$key)?'selected':''?>><?=$country?></option>
								<?php 
								}	
								?>
							</select>
						</div>
						<div class="form-group">
							<label>First Name</label>
							<input type="text" name="getpaid_first_name" class="form-control" placeholder="First Name" value="<?= $this->session->flashdata('getpaid_first_name') ? $this->session->flashdata('getpaid_first_name') : '' ?>">
						</div>
						<div class="form-group">
							<label>Last Name</label>
							<input type="text" name="getpaid_last_name" class="form-control" placeholder="Last Name" value="<?= $this->session->flashdata('getpaid_last_name') ? $this->session->flashdata('getpaid_last_name') : '' ?>">
						</div>
						<div class="form-group">
							<label>Date of Birth</label>
							<input type="date" name="getpaid_dob" class="form-control" placeholder="Date of Birth" value="<?= $this->session->flashdata('getpaid_dob') ? $this->session->flashdata('getpaid_dob') : '' ?>">
						</div>
						      <h4>Home Address </h4>
						      	<div class="row">
							<div class="form-group col-md-6 home_add">
								<label>Number</label>
								<input type="text" name="getpaid_number" class="form-control" placeholder="Number" value="<?= $this->session->flashdata('getpaid_number') ? $this->session->flashdata('getpaid_number') : '' ?>">
							</div>
							<div class="form-group col-md-6 home_add">
								<label>Street Name</label>
								<input type="text" name="getpaid_street_name" class="form-control" placeholder="Street Name" value="<?= $this->session->flashdata('getpaid_street_name') ? $this->session->flashdata('getpaid_street_name') : '' ?>">
							</div>
							<div class="form-group col-md-6 home_add">
								<label>City</label>
								<input type="text" name="getpaid_city" class="form-control" placeholder="City" value="<?= $this->session->flashdata('city') ? $this->session->flashdata('city') : '' ?>">
							</div>
							<div class="form-group col-md-6 home_add">
								<label>Country <small>optional</small></label>
								<input type="text" name="getpaid_country" class="form-control" placeholder="Street Name" value="<?= $this->session->flashdata('getpaid_country') ? $this->session->flashdata('getpaid_country') : '' ?>">
							</div>
							<div class="form-group col-md-6 home_add">
								<label>Postal code</label>
								<input type="text" name="getpaid_postal_code" class="form-control" placeholder="Postal code" value="<?= $this->session->flashdata('getpaid_postal_code') ? $this->session->flashdata('getpaid_postal_code') : '' ?>">
							</div>
							<div class="form-group col-md-6 home_add">
								<label>Phone Number</label>
								<input type="text" name="getpaid_phone_number" class="form-control" placeholder="Phone Number" value="<?= $this->session->flashdata('getpaid_phone_number') ? $this->session->flashdata('getpaid_phone_number') : '' ?>">
							</div>
							<div class="form-group col-md-12">
								<div class="form-group col-md-12 form-check">
									<label class="form-check-label">
										<input class="form-check-input" type="checkbox" name="terms" id="terms" value="1"> I Agree to the <a href="<?=LANG_URL.'/privacy-policy'?>">Privacy Policy</a>
										<small style="display:none;" class="help-block" data-bv-validator="notEmpty" data-bv-for="terms" id="error_terms" data-bv-result="INVALID" >Check this box for agree with our policies</small>
									</label>
								</div>
							</div>
						</div>
					</div>
					</div>
				</div>
				<div class="input-group col-md-12 form_merchant">
					<div class="save_button_div">
						<button type="button" id="prev-2" class="btn btn-primary pull-left">Previous</button>  
						<button type="submit" id="save" name="register" class="btn btn-primary pull-right">Save & Continue</button>
					</div>
				</div>
			</div> 		
		</div>	
	</section>
</form>
<script>
$('#vendor_country').on('change',function(){
	var country_id = $(this).val();
	
	$.ajax({
		url: "<?=base_url('vendor/getStates')?>",
		type: "POST",
		data: {'country_id':country_id},
		success: function (response) {
		  $('#vendor_state').html(response);
		},
	});
});
$('#vendor_state').on('change',function(){
	var state_id = $(this).val();
	
	$.ajax({
		url: "<?=base_url('vendor/getCities')?>",
		type: "POST",
		data: {'state_id':state_id},
		success: function (response) {
		  $('#vendor_city').html(response);
		},
	});
});
$('#country').on('change',function(){
	var country_id = $(this).val();
	
	$.ajax({
		url: "<?=base_url('vendor/getStates')?>",
		type: "POST",
		data: {'country_id':country_id},
		success: function (response) {
		  $('#state').html(response);
		},
	});
});
$('#state').on('change',function(){
	var state_id = $(this).val();
	
	$.ajax({
		url: "<?=base_url('vendor/getCities')?>",
		type: "POST",
		data: {'state_id':state_id},
		success: function (response) {
		  $('#city').html(response);
		},
	});
});

$('#name-your-shop').hide();
$('#stock-your-shop').hide();
$('#get-paid').hide();
$('#next-1').on('click',function(){
	$("html, body").animate({ scrollTop: 100 }, 1000);
	$('#bar-1').addClass('active');
	$('#shop-preferences').hide();
	$('#name-your-shop').show();
});
$('#next-2').on('click',function(){
	$("html, body").animate({ scrollTop: 100 }, 1000);
	$('#bar-2').addClass('active');
	$('#name-your-shop').hide();
	$('#stock-your-shop').show();
});
$('#prev-2').on('click',function(){
	$("html, body").animate({ scrollTop: 100 }, 1000);
	$('#bar-2').removeClass('active');
	$('#name-your-shop').show();
	$('#stock-your-shop').hide();
});
$('#prev-1').on('click',function(){
	$("html, body").animate({ scrollTop: 100 }, 1000);
	$('#bar-1').removeClass('active');
	$('#shop-preferences').show();
	$('#name-your-shop').hide();
});
</script>
<script src="<?= base_url('assets/web/bootstrap_validator/bootstrap_validator.js') ?>"></script>
<script>
$(document).ready(function() {
    $('#frmregister')
        .bootstrapValidator({
            framework: 'bootstrap',
            //excluded: [':disabled'],
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
            },
            fields: {
            	vendor_name: {
                    validators: {
                        notEmpty: {
                            message: 'This field is required'
                        },
                    }
                },
				/* contact_number: {
                    validators: {
                        notEmpty: {
                            message: 'This field is required'
                        },
						stringLength: {
							max:12,
							min: 06,
                            message: 'The mobile number must be 06 to 12 digits '
                        },
						regexp: {							
							regexp: /^[0-9][0-9]{0,15}$/,
							message: 'Invalid mobile number'
						},
                
                    }
                }, */
			
				vendor_email: {
                    validators: {
                        notEmpty: {
                            message: 'This field is required'
                        },
						regexp: {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: 'Please enter a valid email address'
                        },
						 remote: {
							url: '<?= LANG_URL . '/vendor/checkUseremail' ?>',
							type: 'POST',
							message: 'This email id already exists',
						}, 
                    }
                },
				vendor_password: {
                    validators: {
                        notEmpty: {
                            message: 'This field is required'
                        },
						identical: {
                            field: 'vendor_confirm_password',
                            message: 'The password and its confirm must be the same'
                        },
                    }
                },
                vendor_confirm_password: {
                    validators: {
                        notEmpty: {
                            message: 'This field is required'
                        },
                        identical: {
                            field: 'vendor_password',
                            message: 'The password and its confirm must be the same'
                        },
                    }
                },
            }
        })
        .on('error.validator.bv', function(e, data) {
            data.element
                .data('bv.messages')
                // Hide all the messages
                .find('.help-block[data-bv-for="' + data.field + '"]').hide()
                // Show only message associated with current validator
                .filter('[data-bv-validator="' + data.validator + '"]').show();
        });
});
$('#terms').on('click',function(e){
	terms = $('#terms').is(':checked');
	if(terms){	
		$('#error_terms').hide();
		$('#save').prop('disabled',false);

	}
});
$('form').on('submit',function(e){
	terms = $('#terms').is(':checked');
	if(!terms)
	{	
		$('#error_terms').show();
		e.preventDefault();
	}
});
</script> 



<!--
<div class="auth-page">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4"> 
            <?php
            if ($this->session->flashdata('error_register')) {
                ?>
                <div class="alert alert-danger"><?= implode('<br>', $this->session->flashdata('error_register')) ?></div>
                <?php
            }
            ?>
            <div class="vendor-login">
                <h1><?= lang('user_register_page') ?></h1><br>
                <form method="POST" action="">
                    <input type="text" name="u_email" value="<?= $this->session->flashdata('email') ? $this->session->flashdata('email') : '' ?>" placeholder="<?= lang('email') ?>">
                    <input type="password" name="u_password" placeholder="<?= lang('password') ?>">
                    <input type="password" name="u_password_repeat" placeholder="<?= lang('password_repeat') ?>">
                    <input type="submit" name="register" class="login submit" value="<?= lang('register_me') ?>">
                </form>
            </div>
        </div>
    </div>
</div>-->
<style type="text/css">
	.left-merchants_box {
    border: 1px solid #ccc;
    padding: 20px 30px;
    border-radius: 4px;
    background: #fff;
}
.right-merchants_box {
    border: 1px solid #ccc;
    padding: 20px 30px;
    background: #fff;
    border-radius: 4px;
}
.right-merchants_box .panel-default>.panel-heading {
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 3px;
}
.collhead a {
    width: 100%;
    position: relative;
    padding-left: 4px;
    padding-right: 290px;
    font-size: 17px;
    font-weight: 600;
    color: #000;
    padding: 5px auto!important;
    padding-top: 5px;
    padding-bottom: 5px;
    background: transparent;
}
.reg_pay_logo
{
	margin-bottom: .9rem;
}
.reg_pay_logo img
{
  width: 250px;
  height: auto;
}
</style>