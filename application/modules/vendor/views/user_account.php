<section class="profile_section sidebar_bg rating_merchant_ww">
    <?php $this->load->view('_parts/sidebar_merchant') ?>
	<div class="profile_right" id="page-content-wrapper">
		<form method="POST" />
			<div class="payment_setting col-md-12"> 
				<div class="row">
					
					<?php if($this->session->flashdata('result_failed')) { ?>
						<div class="alert alert-danger alert-full"><?= $this->session->flashdata('result_failed') ?></div> 
					<?php } ?>
					<?php if($this->session->flashdata('result_success')) { ?> 
						<div class="alert alert-success alert-full"><?= $this->session->flashdata('result_success') ?></div> 
					<?php } ?>
					<?php 
						$oldMerchantCode = $revenue_share['initiate_merchant_number'];
						$merchant_id = $oldMerchantCode+$vendor_details['id'];
					?>
					<div class="col-md-12 user_account_title"><h4>Setting</h4></div>
					<div class="input-group col-md-6 form_merchant">
						<label>Full Name</label>
						<input type="text" class="form-control" name="name" placeholder="Full Name" value="<?=$vendor_details['name']?>" required>
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					<div class="input-group col-md-6 form_merchant">
						<label>Phone Number</label> 
						<input type="text" name="vendor_phone_number" class="form-control" placeholder="9876543210"  oninput="this.value = this.value.replace(/[^0-9]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" maxlength = "12" value="<?=$vendor_details['vendor_phone_number']?>">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					<div class="input-group col-md-6 form_merchant">
						<label>Email</label> 
						<input type="email" name="email" class="form-control" placeholder="Email" value="<?=$vendor_details['email']?>" disabled>
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					<div class="input-group col-md-6 form_merchant">
						<label>Store Name</label> 
						<input type="email" name="store_name" class="form-control" placeholder="Store Name" value="<?=$vendor_details['store_name']?>" disabled>
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					
					<div class="col-md-12 user_account_title"><h4>General Information</h4></div>
					<div class="input-group col-md-6 form_merchant">
						<label>Merchant Id</label> 
						<input type="text" class="form-control" name="merchant_id" placeholder="Merchant Id" value="<?=$merchant_id?>" disabled>
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					
					<div class="input-group col-md-6 form_merchant">
						<label>Business Email</label> 
						<input type="email" name="business_email" class="form-control" placeholder="Business Email" value="<?=$vendor_details['business_email']?>">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					
					<div class="input-group col-md-6 form_merchant">
						<label>Revenue share</label> 
						<input type="text" class="form-control" placeholder="Revenue share" value="<?=$revenue_share['revenue_share']?>%" disabled>
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					
					<div class="col-md-12 user_account_title"><h4>Categories</h4></div>
					
					<div class="input-group col-md-8 form_merchant prodcut_cat">
						<label>Product Categories</label> 
						<?php 
						$categories = shopcategories();
						foreach($categories as $category){ ?>
							<span><label><input name="categories[]" type="checkbox" value="<?=$category['id']?>" <?=in_array($category['id'],$vendor_selected_categories)?'checked onclick="return false"':''?>/> <?=$category['name']?></label></span>
						<?php } ?>
					</div>
				</div> 		
				
					<div class="col-md-12 save_button_div">
						<button type="submit" class="btn btn-primary">Save</button>
					</div>
				</div> 
			</div> 
		</form> 
	</div>
</section>