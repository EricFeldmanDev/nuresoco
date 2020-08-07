<?php 
$uri = uri_string();
$uri1 = $this->uri->segment(1);
?>
<div class="col-md-3 profile_left sidebar_left">
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
 					<img src="<?= (is_file(UPLOAD_PHYSICAL_PATH.'user-images/'.$userDetails['profile_image']) && $userDetails['profile_image'] !="")?UPLOAD_URL.'user-images/'.$userDetails['profile_image']:WEB_URL.'images/profile_user.png' ?>" />
					<a href="javascript:void(0);" id="camera"><i class="fa fa-camera"></i></a>
					<input type="file" name="profile_image" id="profile_image" accept="image/jpeg" style="display:none;"/>
					<h6><?=$userDetails['name']?></h6>
				</div>
			</form>
			<h5>My profile</h5>  	
			<li>
				<a href="<?=LANG_URL.'/update-profile'?>" class="sidebar_menu_link <?= $uri=='update-profile' ? 'active' : '' ?>" ><i class="fa fa-pencil"></i> Edit Profile</a>
			</li>
			<li>
				<a href="<?=LANG_URL.'/notifications'?>" class="sidebar_menu_link <?= $uri=='notifications' ? 'active' : '' ?>" ><i class="fa fa-bell"></i> Notifications</a>
			</li>
			<li>
				<a href="<?=LANG_URL.'/inbox'?>" class="sidebar_menu_link <?= $uri1=='inbox' ? 'active' : '' ?>" ><i class="fa fa-envelope"></i> Inbox</a>
			</li>
			<li>
				<a href="<?= LANG_URL.'/shopping-cart'?>" class="sidebar_menu_link"><i class="fa fa-shopping-cart"></i> My Cart</a>
			</li>				
			<li>
				<a href="<?= LANG_URL . '/wishlist' ?>" class="sidebar_menu_link <?= $uri=='wishlist' ? 'active' : '' ?>"><i class="fa fa-heart"></i> Favourite Products</a>
			</li> 				
			<h5>My Orders</h5>  
		<!-- 	<li>
				<a href="<?=LANG_URL.'/check-order'?>" class="sidebar_menu_link <?= $uri=='check-order' ? 'active' : '' ?>">	
					<img src="<?=WEB_URL?>images/sl_1.png" class="icon_img_w"/>	
					<img src="<?=WEB_URL?>images/sl_white_1.png" class="icon_img_active"/> Check order
				</a>
			</li>  -->				
			<!--<li>
				<a href="#" class="sidebar_menu_link"><img src="<?=WEB_URL?>images/sl_2.png"/> Track order</a>
			</li>--> 				
			<li>
				<a href="<?=LANG_URL.'/order-history'?>" class="sidebar_menu_link <?= ($uri=='order-history' || $uri1=='order-track' || $uri1=='write-review') ? 'active' : '' ?>"><i class="fa fa-history"></i> Order History</a>
			</li> 	
			<h5>Rating</h5>				
			<li>
				<a href="#" class="sidebar_menu_link"><img src="<?=WEB_URL?>images/sl_3.png"/> Give Feedback</a>
			</li>				
			<h5>Settings</h5>
			<li>
				<a href="billing_address.php" data-toggle="modal" data-target="#billing_address" class="sidebar_menu_link"><i class="fa fa-credit-card"></i> Billing address</a>
			</li>
			<li>
				<a href="<?=LANG_URL.'/payment-setting'?>" class="sidebar_menu_link <?= $uri=='payment-setting' ? 'active' : '' ?>"><i class="fa fa-credit-card"></i> Payment Setting</a>
			</li>				
			<li>
				<a href="<?=LANG_URL.'/change-password'?>" class="sidebar_menu_link <?= $uri=='change-password' ? 'active' : '' ?>"><i class="fa fa-lock"></i> Change Password</a>
			</li>				
			<li>
				<a href="<?=LANG_URL.'/logout'?>"><button type="button" class="btn btn-primary user_logout">Logout</button></a>
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
			url: "<?=base_url('changeProfileImage')?>",
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
				alert(response.error);
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