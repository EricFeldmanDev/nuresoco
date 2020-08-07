<section class="profile_section sidebar_bg rating_merchant_ww">
    <?php $this->load->view('_parts/sidebar_merchant') ?>
    <?php //print_r($vendor_details); 
    //print_r($_SESSION);
     ?>
	<div class="profile_right" id="page-content-wrapper">
	
		<?php $this->load->view('_parts/validation-paypal-errors.php'); ?>
		<?=form_open_multipart(base_url('vendor/payment-setting'),array('class'=>'my-form'))?>
			<div class="payment_setting col-md-6">
				    <h3 class="pay_head">Payment Setting</h3>
				<div class="row">
					<input type="hidden" name="vendorid" value="<?php echo $vendor_details['id']; ?>">
					<?php if($this->session->flashdata('result_failed')) { ?> 
						<div class="alert alert-danger alert-full"><?= $this->session->flashdata('result_failed') ?></div> 
					<?php } ?>
					<?php if($this->session->flashdata('result_success')) { ?> 
						<div class="alert alert-success alert-full"><?= $this->session->flashdata('result_success') ?></div> 
					<?php } ?>
					<div class="row justify-content-center" style="padding: 8px 24px;">													
						<div class="col-md-12">
							<div class="paypal">
							   <img src="<?php base_url(); ?>/assets/imgs/paypal-logo_new.png" alt="logo" class="pay_logo">
							</div>   
						</div>
						
						<div class="form-group col-md-12">
							<label class="form-label">First Name</label>
							<?php
								$data = array(
								'name'			=> 'paypal_first_name',
								'id'			=> 'paypal_first_name',
								'required'		=> "required",
								'class'			=>"form-control",
								'value'			=> !empty($vendor_details)?$vendor_details['paypal_first_name']:'',
								);
								echo form_input($data);
							?>
							
						</div>
						<div class="form-group col-md-12">
							<label class="form-label">Last Name</label>
							<?php
								$data = array(
								'name'			=> 'paypal_last_name',
								'id'			=> 'paypal_last_name',
								'required'		=> "required",
								'class'			=>"form-control",
								'value'			=> !empty($vendor_details)?$vendor_details['paypal_last_name']:'',
								);
								echo form_input($data);
							?>
							
						</div>
						<div class="form-group col-md-12">
							<label class="form-label">Email</label>
							<?php
								$data = array(
								'name'			=> 'paypal_email',
								'id'			=> 'paypal_email',
								'type'			=> 'email',
								'required'		=> "required",
								'class'			=>"form-control",
								'value'			=> !empty($vendor_details)?$vendor_details['paypal_email']:'',
								);
								echo form_input($data);
							?>
						</div>
						<div class="col-md-12 text-right save_button_div">
							<button type="submit" class="btn btn-primary btnSub" name="paypal_submit">SUBMIT</button>
						</div>
					</div>
				</div> 
			</div> 
		<?=form_close()?>
	</div>
</section>


<style type="text/css">
    .pay_head
    {
    	padding: 12px 8px;
    	background-color: rgb(240, 245, 247);
    	font-size: 20px;
        font-weight: 700;
        border-width: 1px;
        border-style: solid;
        border-color: rgb(212, 227, 235);
        border-image: initial;
        text-align: center;
    }
    .payment_setting 
    {
    	margin: 0 auto;
    	border:2px solid;
    	border-color: rgb(212, 227, 235);
    	padding: 0px;
    }
    .pay_logo
    {
    	height: 50px;
    	width: 200px;
    }
    .paypal {
    text-align: center;
    margin-bottom: 1rem;
    }
    .color_red
    {
    	font-size: 15px !important;
    }
</style>
