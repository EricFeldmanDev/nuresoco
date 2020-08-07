<section class="products_section product_filter">
    <div class="container-fluid">
	<?php if($product_name!=''){ ?>
		<div class="heading_title wow bounceInLeft"><h4>Showing results from all categories: <span>"<?=$product_name?>"</span></h4></div>
	<?php }elseif($category_name!=''){ ?>
		<div class="heading_title wow bounceInLeft"><h4>Showing results from: <span>"<?=$category_name?>"</span></h4></div>
	<?php } ?>
		<div id="product_section" class="main_products">
		
		<?php shuffle($products);
         if (!empty($products)) {
			foreach($products as $key) :
			$id=base64_encode($key['product_id']);
			$productName = escape_product_name($key['product_name']);
			?>
			<div class="col-md-3 col-sm-6 col-lg-3 col-xl-2 product_ak wow fadeInUp">
				<div class="row">
					<a href="<?=LANG_URL.'/products-details/'.$productName.'/'.$id?>"><div class="porduct_img"><img src="<?=UPLOAD_URL.'product-images/'.$key['image']?>"/></div></a>
					<a href="javascript:void(0);" class="add_to_wishlist" data-product_id="<?=$id?>">
					<?php
						$blankHeartStyle = '';
						$filledHeartStyle = 'style="display:none;"';
						if(in_array($key['product_id'],$wishlist_Product_ids))
						{
							$blankHeartStyle = 'style="display:none;"';
							$filledHeartStyle = '';
						}
					?>
						<i class="fa fa-heart-o" <?=$blankHeartStyle?>></i>
						<i class="fa fa-heart" <?=$filledHeartStyle?>></i>
					</a>
					<div class="product_dsp">
						<span><?=$key['product_name']?></span>
						<div class="ww">
							<?php if($key['is_product_verified']=='1'){ ?>
								<img src="<?=LANG_URL.'/assets/web/'?>images/prd_3.png" class="express_img express_img1"/>
							<?php } ?>
							<!--
							<img src="<?=LANG_URL.'/assets/web/'?>images/prd_1.png" class="express_img"/>
							-->
							<a href="<?=LANG_URL.'/products-details/'.$productName.'/'.$id?>"><button class="product_btn">£ <?=$key['price']?></button></a>
						</div>
					</div>
				</div>
			</div>
		<?php  endforeach; 
		  if($productsCount>$offset+$limit){
		?>
				<div class="row load_more_seller_products" style="display:none;">
					<div class="clearfix"></div>
					<img src="<?=IMG_URL.'ajax-loader.gif'?>" class="ajax-loader"/>
				<!--
					<input type="button" id="loadMore" value="Load More" class="btm btn-primary"/>
				-->
				</div>
		<?php }
			} elseif($offset<1) { ?>
			<br><h1 style="color: #ccc;">No Product Found !</h1>
		<?php }else{
			echo 'all_products_loaded';
		} ?>
        </div>
        <p style="display: none;" class="noproductavilable"></p>
    </div> 	
</section>
<!-- <div class="col-sm-12"><?php if(isset($products)) echo $links; ?></div> -->
<script>
var filterProductsURL = '<?=base_url('home/filterProducts/'.$this->uri->segment(2));?>';
var offset = 0;
var limit = <?=$limit?>;
var counter=0;

$(window).scroll(function () {
	if ($(window).scrollTop() == $(document).height() - $(window).height() && counter < 2) {
		filterProductNow1();
	}
});
function filterProductNow1(){
	offset = parseInt(limit) + parseInt(offset);
	$.ajax({
		url: filterProductsURL,
		type: "POST",
		data: {'product_name':'<?=$product_name?>', 'offset': offset, 'category_id': '<?=$this->uri->segment(2);?>'},
		//dataType: 'json',
		success: function (response) {
		  if(response != '')
		  {
			//$('#product_section').find('.load_more_seller_products').remove();
			$('#product_section').find('.load_more_seller_products').show();
			setTimeout(function() {
			
			  $('#product_section').find('.load_more_seller_products').hide();
			  $('#product_section').removeClass('ajax_load');
			  if(response!='all_products_loaded')
			  {
				$('#product_section').append(response);
			  }
			}, 0);
		  }else{
		  	$('.noproductavilable').show();
			$('.noproductavilable').html('No Product Avilable');
			//$('#product_section').html('');
		  }
		},
	});
}

/* var addToWishlistURL = '<?=base_url('home/addToWishlist/');?>';
var loginCheck = false;
<?php if($this->session->userdata('logged_user') && !empty($this->session->userdata('logged_user'))){ ?>
	loginCheck = true;
<?php } ?>
$('#product_section').on('click','.add_to_wishlist',function(){
	var product_id = $(this).data('product_id');
	var a_attr = $(this);
	if(loginCheck===true)
	{
		$.ajax({
			url: addToWishlistURL,
			type: "POST",
			data: {'product_id':product_id},
			//dataType: 'json',
			success: function (response) {
			  if(response != '')
			  {
				if(response == 'already')
				{
					alert('This product is already added in wishlist!');
				}else if(response === 0){
					alert('An erro occured.Please try again later!');
				}else{
					a_attr.find('.fa-heart-o').hide();
					a_attr.find('.fa-heart').show();
					var wishlistText = $('.cart-wishlist-items').html();
					if(wishlistText=='')
					{
						wishlistText = 1;
					}else{
						wishlistText = wishlistText.replace('(','');
						wishlistText = wishlistText.replace(')','');
						wishlistText = parseInt(wishlistText)+1;
					}
					$('.cart-wishlist-items').html('('+wishlistText+')');
				}
			  }else{
				alert('An erro occured.Please try again later!');
			  }
			},
		});
	}else{
		window.location.href = "<?=base_url('login')?>";
	}
}); */
</script>