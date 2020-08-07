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
		<div class="dashboard_title d-flex">Nureso Merchant Dashboard
			<div class="ml-auto">
				<a href="<?=base_url('vendor/product_bundles')?>" class="btn btn-primary btn-theme active" style="font-size:0.8em;">Product Bundles</a>
				<a href="javascript:" class="ml-3 dashboard_collapse"><i class="fa fa-chevron-down"></i></a>
			</div>			
		</div>
		<div class="dashboard open">
			<div class="dashboard_container">
				<a href="<?=LANG_URL.'/vendor/products'?>" class="dashboard_item top"><div class="img"><img src="<?=WEB_URL?>images/dashboard/01.png"/></div><p>All Products</p></a>
				<a href="<?=LANG_URL.'/vendor/products/express'?>" class="dashboard_item top"><div class="img"><img src="<?=WEB_URL?>images/dashboard/15.png"/></div><p>Express Products</p></a>
				<a href="<?=LANG_URL.'/vendor/sales-merchant'?>" class="dashboard_item top"><div class="img"><img src="<?=WEB_URL?>images/dashboard/02.png"/></div><p>Sales</p></a>
				<a href="<?=LANG_URL.'/vendor/notifications'?>" class="dashboard_item top"><div class="img"><img src="<?=WEB_URL?>images/dashboard/03.png"/></div><p>Notification</p></a>
				<a href="<?=LANG_URL.'/vendor/inbox'?>" class="dashboard_item top"><div class="img"><img src="<?=WEB_URL?>images/dashboard/04.png"/></div><p>Inbox</p></a>

			</div>
			<div class="dashboard_container">
				<a href="<?=LANG_URL.'/vendor/review-rating'?>" class="dashboard_item"><div class="img"><img src="<?=WEB_URL?>images/dashboard/05.png"/></div><p>Rating & Reviews</p></a>
				<a href="<?=LANG_URL.'/vendor/user-account'?>" class="dashboard_item"><div class="img"><img src="<?=WEB_URL?>images/dashboard/06.png"/></div><p>User Account</p></a>
				<a href="billing_address.php" class="dashboard_item"><div class="img"><img src="<?=WEB_URL?>images/dashboard/07.png"/></div><p>Billing address</p></a>
				<a href="<?=LANG_URL.'/vendor/payment-setting'?>" class="dashboard_item"><div class="img"><img src="<?=WEB_URL?>images/dashboard/08.png"/></div><p>Payment info</p></a>
				<a href="<?=LANG_URL.'/vendor/change-password'?>" class="dashboard_item"><div class="img"><img src="<?=WEB_URL?>images/dashboard/09.png"/></div><p>Forgot password</p></a>
			</div>		
		</div>
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

	$('.dashboard_collapse').click(function() {
		var d = $('.dashboard');
		if(d.hasClass('open')) {
			d.slideUp('slow');
			d.removeClass('open');
			$(this).children('i').removeClass('fa-chevron-down').addClass('fa-chevron-up');
		} else {
			d.slideDown('slow');
			d.addClass('open');
			$(this).children('i').removeClass('fa-chevron-up').addClass('fa-chevron-down');
		}
	})
</script>