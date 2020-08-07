<?php 
$uri = uri_string();
$uri1 = $this->uri->segment(1);
$uri2 = $this->uri->segment(2);
$uri3 = $this->uri->segment(3);
//echo $uri3; die;
$uri4 = $this->uri->segment(4);
?>
<div class="profile_left sidebar_left" id="sidebar-wrapper">
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#ak_menu2">
		<i class="fa fa-bars"></i>
	</button>
	<div class="row mobile_open collapse" id="ak_menu2"> 
		<div class="input-group sidebar_search">
			<!--
			<input type="text" class="form-control" placeholder="Search product...">
			<div class="input-group-append">
				<span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
			</div>
			-->
		</div>
		<ul class="sidebar_menu_ul">
			<form method="POST" class="changeImageForm">
				<div class="user_profile_ww">                   
 					<img src="<?= (is_file(UPLOAD_PHYSICAL_PATH.'vendor-images/'.$vendor_image) && $vendor_image !="")?UPLOAD_URL.'vendor-images/'.$vendor_image:WEB_URL.'images/profile_user.png' ?>" />
					<a href="javascript:void(0);" id="camera"><i class="fa fa-camera"></i></a>
			        <input type="file" name="profile_image" id="profile_image" accept="image/jpeg"
					<h6><?=$vendor_name?></h6>
				</div>
			</form>
			<h5>For Merchant</h5>  
			
			
			<li>
				<a href="<?=LANG_URL.'/vendor/sales-merchant'?>" class="sidebar_menu_link <?= $uri2=='sales-merchant' ? 'active' : '' ?>">
					<img src="<?=WEB_URL?>images/sl_2.png"/> Sales
				</a>
			</li>
			<li>
				<a href="<?=LANG_URL.'/vendor/products'?>" class="sidebar_menu_link <?= (($uri2=='products' && $uri3=='') || ($uri2=='add' && $uri3=="product" && $uri4=='') || ($uri2=='edit' && $uri3=="product"))? 'active' : '' ?>">
					<img src="<?=WEB_URL?>images/sl_1.png" class="icon_img_w"/>
					<img src="<?=WEB_URL?>images/sl_white_1.png" class="icon_img_active"/> All Products 
				</a>
	
			</li>
			<?php if($this->vendor_express_status=='ACCEPT'){?>
				<li>
					<<a href="<?=LANG_URL.'/vendor/products/express'?>" class="dashboard_item top"><div class="img"><img src="<?=WEB_URL?>images/dashboard/15.png"/></div><p>Express Products</p></a>
					</a>
				</li>	
			<?php } ?>

			<li>
				<a href="<?=LANG_URL.'/vendor/notifications'?>" class="sidebar_menu_link <?= ($uri2=='notifications')? 'active' : '' ?>">
					<i class="fa fa-bell"></i> Notifications
				</a>
			</li>
			<li>
				<a href="<?=LANG_URL.'/vendor/inbox'?>" class="sidebar_menu_link <?= $uri2=='inbox' ? 'active' : '' ?>" ><i class="fa fa-envelope"></i> Inbox</a>
			</li>
			<h5>Customer Rating</h5>
			<li>
				<a href="<?=LANG_URL.'/vendor/review-rating'?>" class="sidebar_menu_link <?= $uri2=='review-rating' ? 'active' : '' ?>">
					<img src="<?=WEB_URL?>images/sl_3.png"/> Rating & Reviews
				</a>
			</li>
			<h5>Support</h5>  
			<li>
				<a href="<?=LANG_URL.'/vendor/'?>" class="sidebar_menu_link">
					<img src="<?=WEB_URL?>images/sl_4.png"/> Support
				</a>
			</li> 
			<li>
				<a href="<?=LANG_URL.'/vendor/user-account'?>" class="sidebar_menu_link <?= $uri2=='user-account' ? 'active' : '' ?>">
					<img src="<?=WEB_URL?>images/sl_5.png"/> User Account
				</a>
			</li>
			<h5>Setting</h5>  
			<li>
				<a href="billing_address.php" data-toggle="modal" data-target="#billing_address" class="sidebar_menu_link"><i class="fa fa-credit-card"></i> Billing address</a>
			</li>
			<li>
				<a href="<?=LANG_URL.'/vendor/payment-setting'?>" class="sidebar_menu_link <?= $uri2=='payment-setting' ? 'active' : '' ?>"><i class="fa fa-credit-card"></i> Payment Setting</a>
			</li>
			<li>
				<a href="<?=LANG_URL.'/vendor/change-password'?>" class="sidebar_menu_link <?= $uri2=='change-password' ? 'active' : '' ?>"><i class="fa fa-lock"></i> Change Password</a>
			</li>				
			<li>
				<a href="<?=LANG_URL.'/vendor/logout'?>"><button type="button" class="btn btn-primary user_logout">Logout</button></a>
			</li>
		</ul>
	</div>
</div>
<script>
	$('.changeImageForm').on('submit',function(e){
		var formData = new FormData($(this)[0]);
		var current_uri = '<?=$uri?>';
		var form = $(this).find('img');
		$.ajax({
			url: "<?=base_url('changeVendorImage')?>",
			type: "POST",
			data: formData,
			dataType: 'json',
			success: function (response) {
			  if(response.error == 'no')
			  {
				form.attr('src',response.msg);
				if(current_uri=='update-profile')
				{
					$('#user_profile_img').attr('src',response.msg);
				}
			  }else{
				alert(response.msg);
			  }
			},
			cache: false,
			contentType: false,
			processData: false
		});
		e.preventDefault();
	});
	
	$('#profile_image').on('change',function(e){
		$(this).parents('form').submit();
	});
	
	$('#camera').click(function(){
		$(this).parents('.changeImageForm').find('#profile_image').trigger('click');
	});
</script>