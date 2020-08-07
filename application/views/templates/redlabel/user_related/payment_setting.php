<section class="profile_section sidebar_bg rating_merchant_ww">
    <?php $this->load->view('templates/redlabel/user_related/sidebar_user'); ?>
	<div class="col-md-9 profile_right">
		<form method="POST" />
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
					<div class="form-group col-md-12">
						<label class="form-label">Business name</label>
						<input type="text" name="business_name" value="" required="required" class="form-control inp-company-name"  />
						
					</div>
					<div class="form-group col-md-12">
						<label class="form-label">Street Address Line</label>
						<textarea name="business_address" cols="40" rows="2" required="required" class="form-control inp-company-street-address1" ></textarea>
						
					</div>
					<div class="form-group col-md-4">
						<label class="form-label">City</label>
						<input type="text" name="business_city" value="" required="required" class="form-control inp-company-city"  />
					</div>
					<div class="form-group col-md-4">
						<label class="form-label">State</label>
						<input type="text" name="business_state" value="" required="required" class="form-control inp-company-state"  />
						
					</div>
					<div class="form-group col-md-4">
						<label class="form-label">Postal Code</label>
						<input type="text" name="business_postal_code" value="" required="required" class="form-control inp-company-zip"  />
						
					</div>
					<div class="form-group col-md-6">
						<label class="form-label">Routing Number</label>
						<input type="text" name="routing_number" value="" required="required" class="form-control"  />
						
					</div>
					<div class="form-group col-md-6">
						<label class="form-label">Account Number</label>
						<input type="text" name="account_number" value="" required="required" class="form-control"  />

						
					</div>
					<div class="col-md-6 form-group to_start">
						<label>Select Country</label>
						<select name="getpaid_country" id="getpaid_country" class="form-control">
							<option value="">-- Select Country --</option>
							<?php 
							foreach($countries as $key => $country)
							{
							?>
								<option value="<?=$key?>" <?=($userDetails['getpaid_country']==$key)?'selected':''?>><?=$country?></option>
							<?php 
							}	
							?>
						</select>
					</div>
					<div class="form-group col-md-6">
						<label class="form-label">Email</label>
						<input type="email" name="email" value="" required="required" class="form-control"  />
					</div>
					
					<div class="col-md-12">
						<h4 class="color_red">Account Holder's</h4>
					</div>
					
					<div class="form-group col-md-6">
						<label class="form-label">First Name</label>
						<input type="text" name="first_name" value="" required="required" class="form-control inp-person-first-name"  />
						
					</div>
					<div class="form-group col-md-6">
						<label class="form-label">Last Name</label>
						<input type="text" name="last_name" value="" required="required" class="form-control inp-person-last-name"  />
						
					</div>
					<div class="form-group col-md-6">
						<label class="form-label">Date of Birth</label>
						<input type="text" name="dob" value="" id="datepicker" required="required" readonly="readonly" class="form-control" placeholder="YYYY/MM/DD"  />
						
					</div>
					<div class="form-group col-md-6">
						<label class="form-label">Tax ID</label>
						<input type="text" name="tax_id" value="" id="tax_id" required="required" class="form-control inc-tax-id"  />
						
					</div>
					<div class="form-group col-md-12">
						<label class="form-label">Street Address Line</label>
						<textarea name="address" cols="40" rows="2" required="required" class="form-control" ></textarea>
						
					</div>
					<div class="form-group col-md-4">
						<label class="form-label">City</label>
						<input type="text" name="city" value="" required="required" class="form-control"  />
						
					</div>
					<div class="form-group col-md-4">
						<label class="form-label">State</label>
						<input type="text" name="state" value="" required="required" class="form-control"  />
						
					</div>
					<div class="form-group col-md-4">
						<label class="form-label">Postal Code</label>
						<input type="text" name="postal_code" value="" required="required" class="form-control"  />
						
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
		</form> 
	</div>
</section>