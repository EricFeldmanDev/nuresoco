<section class="profile_heading_section wish_list">
    <div class="container">
	    <div class="ak_w"> 
            <img src="<?=WEB_URL?>images/wishlist.png"/> <h1>MY W<span>I</span>SH LIST</h1> 
		</div>
    </div> 	
</section>

<div class="clearfix"></div>

<section class="review_search_section wishlist_search">
    <div class="container">
	    <div class="col-md-10 rw_rcrh">
            <div class="input-group wishlist_search_box">
				<input type="text" class="form-control product_name" placeholder="Search product...">
				<div class="input-group-append">
					<span class="input-group-text search_click"><i class="fa fa-search" aria-hidden="true"></i></span>
				</div>
		    </div> 
			<div class="dropdown wishlist_categori_btn">
			    <div class="form-group">
					<select class="form-control drop_bg wishlist_categories">
						<option value="all">All Categories</option>
						<?php foreach($nav_categories as $category){ ?>
							<option value="<?=$category['id']?>"><?=$category['name']?></option>
						<?php } ?>
					</select>
				</div>
			</div>
	    </div> 
	</div> 	
</section>

<div class="clearfix"></div>

<section class="products_section">
    <div class="container-fluid">
		<div id="product_section" class="wishlist_products">
		<?php
		 if (!empty($products)) {
		 foreach($products as $key) :
			$id=base64_encode($key['product_id']);
			$productName = escape_product_name($key['product_name']);
			?>
			<div class="col-md-4 col-sm-4 col-lg-3 col-xl-2 product_ak wow fadeInUp">
				<div class="row">
					<a href="<?=LANG_URL.'/products-details/'.$productName.'/'.$id?>"><div class="porduct_img"><img src="<?=UPLOAD_URL.'product-images/'.$key['image']?>"/></div></a>
					<a href="javascript:void(0);" class="wishlist_close" data-product_id="<?=$id?>"><i class="fa fa-close"></i></a>
					<div class="product_dsp">
						<span><?=$key['product_name']?></span>
						<a href="<?=LANG_URL.'/products-details/'.$productName.'/'.$id?>"><button class="product_btn">£ <?=$key['price']?></button></a>
					</div>
				</div>
			</div>
		<?php  endforeach;
		 } else { ?>
			<br>
		   <h1 style="color: #ccc;">No product added in wishlist !</h1>
		<?php } ?>	
        </div>
    </div>
</section>

<script>
var removeFromWishlistURL = '<?=base_url('home/removeFromWishlist/');?>';
var wishlistFilterURL = '<?=base_url('home/wishlistFilter/');?>';
var loginCheck = false;
<?php if($this->session->userdata('logged_user') && !empty($this->session->userdata('logged_user'))){ ?>
	loginCheck = true;
<?php } ?>
$('.wishlist_close').on('click',function(){
	var product_id = $(this).data('product_id');
	var a_attr = $(this);
	if(loginCheck===true)
	{
		$.ajax({
			url: removeFromWishlistURL,
			type: "POST",
			data: {'product_id':product_id},
			//dataType: 'json',
			success: function (response) {
			  if(response != '')
			  {
				if(response == 'already')
				{
					alert('This product is already removed from wishlist!');
				}else if(response === 0){
					alert('An erro occured.Please try again later!');
				}else{
					a_attr.parents('.product_ak').remove();
					var wishlistText = $('.cart-wishlist-items').html();
					wishlistText = wishlistText.replace('(','');
					wishlistText = wishlistText.replace(')','');
					wishlistText = parseInt(wishlistText)-1;
					if(wishlistText==0)
					{
						$('.cart-wishlist-items').html('');
					}else{
						$('.cart-wishlist-items').html('('+wishlistText+')');
					}
				}
			  }else{
				alert('An erro occured.Please try again later!');
			  }
			},
		});
	}else{
		window.location.href = "<?=base_url('login')?>";
	}
});

$('.wishlist_categories').on('change',function(){
	var category_id = $('.wishlist_categories').val();
	var product_name = $('.product_name').val();
	if(category_id!='')
	{
		wishlistProducts(category_id,product_name);
	}else{
		alert('An error occured.Please try again!');
	}
});

$('.search_click').on('click',function(){
	var category_id = $('.wishlist_categories').val();
	var product_name = $('.product_name').val();
	if(category_id!='')
	{
		wishlistProducts(category_id,product_name);
	}else{
		alert('An error occured.Please try again!');
	}
});

function wishlistProducts(category_id,product_name){
	
	$('#product_section').addClass('ajax_load');
	$.ajax({
		url: wishlistFilterURL,
		type: "POST",
		data: {'category_id':category_id,'product_name':product_name},
		//dataType: 'json',
		success: function (response){
			setTimeout(function() {
			  $('#product_section').removeClass('ajax_load');
			  $('.wishlist_products').html(response);
			}, 0);
		}
	});
}
</script>