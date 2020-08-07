<link rel="stylesheet" href="<?=base_url().'assets/css/datepicker3.css'?>" />
<script src="<?=base_url().'assets/js/bootstrap-datepicker.js'?>"></script>

<section class="profile_section sidebar_bg rating_merchant_ww">
    <?php $this->load->view('_parts/sidebar_merchant') ?>
    <?php //pr($provider_details);?>
	<div class="col-md-9 profile_right">
	
		<?php $this->load->view('_parts/validation-errors.php'); ?>
		<?=form_open(base_url('vendor/payment'),array('class'=>'my-form'))?>
			<div class="payment_setting col-md-12"> 
				<h3>Payment Setting</h3>
				<div class="row">
					
					<?php if($this->session->flashdata('result_failed')) { ?> 
						<div class="alert alert-danger alert-full"><?= $this->session->flashdata('result_failed') ?></div> 
					<?php } ?>
					<?php if($this->session->flashdata('result_success')) { ?> 
						<div class="alert alert-success alert-full"><?= $this->session->flashdata('result_success') ?></div> 
					<?php } ?>

					 
					
					<!--<div class="col-md-6 form-group">
						<label>Bank Name</label>
						<input type="text" name="getpaid_bank_name" class="form-control" placeholder="Bank Name" value="<?=$userDetails['getpaid_bank_name']?>">
					</div>
					<div class="col-md-6 form-group">
						<label>Name of account holder</label>
						<input type="text" name="getpaid_account_holder" class="form-control" placeholder="Name of account holder" value="<?=$userDetails['getpaid_account_holder']?>">
					</div>
					<div class="col-md-6 form-group">
						<label>Short code</label>
						<input type="text" name="getpaid_short_code" class="form-control" placeholder="Short code" value="<?=$userDetails['getpaid_short_code']?>">
					</div>
					<div class="col-md-6 form-group">
						<label>Account Number</label>
						<input type="text" name="getpaid_account_number" class="form-control" placeholder="Account Number" value="<?=$userDetails['getpaid_account_number']?>">
					</div>
					<div class="col-md-6 save_button_div">
						<button type="submit" class="btn btn-primary">Save</button>
					</div>-->
					<div class="col-md-12">
						<h4 class="color_red">Business</h4>
					</div> 
					<?php //pr($provider_details,1);?>
					<div class="form-group col-md-12">
						<label class="form-label">Business name</label>
						<?php
							$data = array(
							'name'			=> 'business_name',
							'required'		=> "required",
							'class'			=> "form-control inp-company-name",
							'value'			=> !empty($provider_details)?$provider_details['business_name']:'',
							);
							echo form_input($data);
						?>
						
					</div>
					<div class="form-group col-md-12">
						<label class="form-label">Business Tax ID</label>
						<?php
							$data = array(
							'name'			=> 'business_tax_id',
							'required'		=> "required",
							'class'			=> "form-control inp-company-tax-id",
							'value'			=> !empty($provider_details)?$provider_details['business_name']:'',
							);
							!empty($provider_details['business_tax_id'])?$data['readonly']='readonly':$data;
							echo form_input($data);
						?>
					</div>
					<div class="form-group col-md-12">
						<label class="form-label">Business Phone</label>
						<?php
							$data = array(
							'name'			=> 'business_phone',
							'id'			=> 'business_phone',
							'class'			=> "form-control inp-company-phone",
							'value'			=> !empty($provider_details)?$provider_details['business_phone']:'',
							);
							!empty($provider_details['business_phone'])?$data['readonly']='readonly':$data;
							echo form_input($data);
						?>
					</div>

					<div class="form-group col-md-12">
						<?php
							$data = array(
							'type'			=> 'hidden',
							'name'			=> 'business_url',
							'class'			=> "form-control business-url",
							'value'			=> !empty($provider_details)?$provider_details['business_url']:'www.nureso.com',
							);
							echo form_input($data);
						?>
					</div>

					<div class="form-group col-md-12">
						<label class="form-label">Street Address Line</label>
						<?php
							$data = array(
								'name'			=> 'business_address',
								'required'		=> "required",
								'rows'			=> "2",
								'class'			=> "form-control inp-company-street-address1",
								'value'			=> !empty($provider_details)?$provider_details['business_street_address']:'',
							);
							echo form_textarea($data);
						?>
						
					</div>
					<div class="form-group col-md-4">
						<label class="form-label">City</label>
						<?php
							$data = array(
							'name'			=> 'business_city',
							'required'		=> "required",
							'class'			=>"form-control inp-company-city",
							'value'			=> !empty($provider_details)?$provider_details['business_city']:'',
							);
							echo form_input($data);
						?>
					</div>
					<div class="form-group col-md-4">
						<label class="form-label">State</label>
						<?php
							$data = array(
							'name'			=> 'business_state',
							'required'		=> "required",
							'class'			=>"form-control inp-company-state",
							'value'			=> !empty($provider_details)?$provider_details['business_state']:'',
							);
							echo form_input($data);
						?>
						
					</div>
					<div class="form-group col-md-4">
						<label class="form-label">Postal Code</label>
						<?php
							$data = array(
							'name'			=> 'business_postal_code',
							'required'		=> "required",
							'class'			=>"form-control inp-company-zip",
							'value'			=> !empty($provider_details)?$provider_details['business_postal_code']:'',
							);
							echo form_input($data);
						?>
						
					</div>
					<div class="form-group col-md-6">
						<label class="form-label">Routing Number</label>
						<?php
							$data = array(
							'name'			=> 'routing_number',
							'required'		=> "required",
							'class'			=>"form-control",
							'value'			=> !empty($provider_details)?$provider_details['business_routing_number']:'',
							);
							echo form_input($data);
						?>
						
					</div>
					<div class="form-group col-md-6">
						<label class="form-label">Account Number</label>
						<?php
							$data = array(
							'name'			=> 'account_number',
							'required'		=> "required",
							'class'			=>"form-control",
							'value'			=> !empty($provider_details)?$provider_details['business_account_number']:'',
							);
							echo form_input($data);
						?>

						
					</div>
					<div class="col-md-6 form-group to_start">
						<label>Select Country</label>
						<?php
							$data = array(
							'name'			=> 'country',
							'required'		=> "required",
							'class'			=>"form-control",
							'value'			=> !empty($provider_details)?$provider_details['business_country']:'',
							);
							echo form_input($data);
						?>
						<!-- <select name="getpaid_country" id="getpaid_country" class="form-control">
							<option value="">-- Select Country --</option>
							<?php 
							foreach($countries as $key => $country)
							{
							?>
								<option value="<?=$key?>" <?=($userDetails['getpaid_country']==$key)?'selected':''?>><?=$country?></option>
							<?php 
							}	
							?>
						</select> -->
					</div>
					<div class="form-group col-md-6">
						<label class="form-label">Email</label>
						<?php
							$data = array(
							'name'			=> 'email',
							'required'		=> "required",
							'class'			=>"form-control",
							'type'          =>'email',
							'value'			=> !empty($provider_details)?$provider_details['business_email']:'',
							);
							echo form_input($data);
						?>
					</div>
					
					<div class="col-md-12">
						<h4 class="color_red">Account Holder's</h4>
					</div>
					
					<div class="form-group col-md-6">
						<label class="form-label">First Name</label>
						<?php
							$data = array(
							'name'			=> 'first_name',
							'required'		=> "required",
							'class'			=>"form-control inp-person-first-name",
							'value'			=> !empty($provider_details)?$provider_details['first_name']:'',
							);
							echo form_input($data);
						?>
						
					</div>
					<div class="form-group col-md-6">
						<label class="form-label">Last Name</label>
						<?php
							$data = array(
							'name'			=> 'last_name',
							'required'		=> "required",
							'class'			=>"form-control inp-person-last-name",
							'value'			=> !empty($provider_details)?$provider_details['last_name']:'',
							);
							echo form_input($data);
						?>	
					</div>

					<div class="form-group col-md-6">
						<label class="form-label">Phone Number</label>
						<?php
							$data = array(
							'name'			=> 'phone',
							'id'			=> 'phone',
							'class'			=>"form-control inp-person-phone",
							'value'			=> !empty($provider_details)?$provider_details['phone']:'',
							);
							echo form_input($data);
						?>
					</div>

					<div class="form-group col-md-6">
						<label class="form-label">Email</label>
						<?php
							$data = array(
							'name'			=> 'email',
							'id'			=> 'email',
							'type'			=> 'email',
							'class'			=>"form-control inp-person-email",
							'value'			=> !empty($provider_details)?$provider_details['email']:'',
							);
							echo form_input($data);
						?>
					</div>

					<div class="form-group col-md-6">
						<label class="form-label">SSN Last 4 Digit</label>
						<?php
							$data = array(
							'name'			=> 'ssn_last_4',
							'id'			=> 'ssn_last_4',
							'type'			=> "number",
							'min'			=> "4",
							'max'			=> "4",
							'class'			=>"form-control inp-person-ssn",
							'value'			=> !empty($provider_details)?$provider_details['ssn_last_4']:'',
							);
							if(!empty($provider_details) && $provider_details['ssn_last_4']!=''){
								$data['readonly'] = 'readonly';
							}
							echo form_input($data);
						?>
					</div>

					<div class="form-group col-md-6">
						<label class="form-label">Job Title</label>
						<?php
							$data = array(
							'name'			=> 'job_title',
							'id'			=> 'job_title',
							'class'			=>"form-control inp-person-job-title",
							'value'			=> !empty($provider_details)?$provider_details['job_title']:'',
							);
							!empty($provider_details['job_title'])?$data['readonly']='readonly':$data;
							echo form_input($data);
						?>
					</div>

					<div class="form-group col-md-12">
						<label class="form-label">Date of Birth</label>
						<?php
							$data = array(
							'id'       		=>	'datepicker',
							'name'			=> 'dob',
							'required'		=> "required",
							'readonly'		=> 'readonly',
							'class'			=>"form-control",
							'placeholder' 	=> 'YYYY/MM/DD',
							'value'			=> !empty($provider_details)?date('Y-m-d',strtotime($provider_details['dob'])):'',
							);
							echo form_input($data);
						?>
						
					</div>
					<!-- <div class="form-group col-md-6">
						<label class="form-label">Tax ID</label>
						<input type="text" name="tax_id" value="" id="tax_id" required="required" class="form-control inc-tax-id"  />
						
					</div> -->
					<div class="form-group col-md-12">
						<label class="form-label">Street Address Line</label>
						<?php
							$data = array(
								'name'			=> 'address',
								'required'		=> "required",
								'rows'			=> "2",
								'class'			=> "form-control",
								'value'			=> !empty($provider_details)?$provider_details['street_address']:'',
							);
							echo form_textarea($data);
						?>
						
					</div>
					<div class="form-group col-md-4">
						<label class="form-label">City</label>
						<?php
							$data = array(
							'name'			=> 'city',
							'required'		=> "required",
							'class'			=>"form-control",
							'value'			=> !empty($provider_details)?$provider_details['city']:'',
							);
							echo form_input($data);
						?>
						
					</div>
					<div class="form-group col-md-4">
						<label class="form-label">State</label>
						<?php
							$data = array(
							'name'			=> 'state',
							'required'		=> "required",
							'class'			=>"form-control",
							'value'			=> !empty($provider_details)?$provider_details['state']:'',
							);
							echo form_input($data);
						?>
						
					</div>
					<div class="form-group col-md-4">
						<label class="form-label">Postal Code</label>
						<?php
							$data = array(
							'name'			=> 'postal_code',
							'required'		=> "required",
							'class'			=>"form-control",
							'value'			=> !empty($provider_details)?$provider_details['postal_code']:'',
							);
							echo form_input($data);
						?>
						
					</div>
					<div class="form-group form-check payment_checkbox col-md-12">
						<label class="form-check-label">
						  By registering your account, you agree to our <a href="#">Services Agreement</a> and the <a href="https://stripe.com/fr/connect-account/legal">Stripe Connected Account Agreement</a>.
						</label>
					</div>
					<div class="col-md-12 save_button_div">
						<button type="submit" class="btn btn-primary pull-right">Save</button>
					</div>
					<input type="hidden" name="account-token" id="account-token">
					<input type="hidden" name="person-token" id="person-token">				
					
				</div> 
			</div> 
		<?=form_close()?>
	</div>
</section>


<script src="https://js.stripe.com/v3/"></script>
<script >

const stripe = Stripe('<?=STRIPE_KEY?>');
const myForm = document.querySelector('.my-form');
myForm.addEventListener('submit', handleForm);

async function handleForm(event) {
  event.preventDefault();

  const accountResult = await stripe.createToken('account', {
	business_type: 'company',
    company: {
      name: document.querySelector('.inp-company-name').value,
      //tax_id: document.querySelector('.inc-tax-id').value,
      address: {
        line1: document.querySelector('.inp-company-street-address1').value,
        city: document.querySelector('.inp-company-city').value,
        state: document.querySelector('.inp-company-state').value,
        postal_code: document.querySelector('.inp-company-zip').value,
      },
    },
    tos_shown_and_accepted: true,
  });

  const personResult = await stripe.createToken('person', {
    person: {
      first_name: document.querySelector('.inp-person-first-name').value,
      last_name: document.querySelector('.inp-person-last-name').value,
    },
  });

  if (accountResult.token && personResult.token) {
    document.querySelector('#account-token').value = accountResult.token.id;
    document.querySelector('#person-token').value = personResult.token.id;
    myForm.submit();
  }
}

$('#datepicker').datepicker({
	onRenderYear: function(date) {
		//Disable picking dates from any year apart from 2015/2016
		if (date.getFullYear() < 2015 || date.getFullYear() > 2016)
			return ['disabled']
	},
	format: 'yyyy/mm/dd',
	startView: 'decade',
	minView: 'decade',
	autoclose: true,
	minDate: new Date(''),
	maxDate: new Date(),
});

</script>