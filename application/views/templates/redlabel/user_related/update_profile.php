
<section class="profile_section sidebar_bg rating_merchant_ww">
    <?php $this->load->view('templates/redlabel/user_related/sidebar_user'); ?>

	<div class="col-md-9 profile_right">
	   <div class="col-md-10 shipping_info_section">
			<div class="user-dashboard">
			    <h3>EDIT PROFILE</h3>
				<div class="user_profile">
					<img src="<?= (is_file(UPLOAD_PHYSICAL_PATH.'user-images/'.$userDetails['profile_image']) && $userDetails['profile_image'] !="")?UPLOAD_URL.'user-images/'.$userDetails['profile_image']:WEB_URL.'images/profile_user.png' ?>"  id="user_profile_img" class="user_porfile_img"/>
				</div>
			</div>
			
			<div class="inventory_section user-dashboard-form">
				
				<?php
					if ($this->session->flashdata('flashError')) {
						?>
						<div class="alert alert-danger"><?= $this->session->flashdata('flashError') ?></div>
						<?php
					}
					if ($this->session->flashdata('flashSuccess')) {
						?>
						<div class="alert alert-success"><?= $this->session->flashdata('flashSuccess') ?></div>
						<?php
					}
				?>
				<form method="POST">
					<div class="input-group">
					    <label>Full name </label> 
						<input type="text" name="name" class="form-control" value="<?=$userDetails['name']?>">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					<div class="input-group">
					    <label>Email </label> 
						<input type="email" name="email" class="form-control" value="<?=$userDetails['email']?>" disabled>
					</div>
					<div class="input-group">
					    <label>Contact No. </label> 
						<input type="text" name="phone" class="form-control" placeholder="Contact No." value="<?=$userDetails['phone']?>">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					<div class="input-group">
					    <label>Address </label> 
						<input type="text" name="address" class="form-control" placeholder="Address" value="<?=$userDetails['address']?>">
						<div class="input-group-append">
							<span class="input-group-text"><i class="fa fa-pencil"></i></span>
						</div>
					</div>
					<div class="button_wr">
						<a href="<?=LANG_URL?>"><input type="button" class="btn btn-primary" value="Cancel"></a>
						<input type="submit" class="btn btn-primary" value="Save">   
					</div>
				</form>
				
			</div>
		</div>
	</div>
</section>
<script>
	function updateProfileImage(imgUrl){
		alert('img');
	}
</script>