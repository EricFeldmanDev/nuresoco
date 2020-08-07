<section class="slider_section">
	<div id="owl-demo" class="owl-carousel">
	<?php foreach($sliders as $slider){ ?>
		<div class="item"><img src="<?=UPLOAD_URL.'sliders/'.$slider['slider_image']?>" alt="">
		    <div class="ak-owl-carousel-content">
			    <div class="container">
				    <h1 class="wow fadeInDown"><?=str_replace(' ','<br>',strtoupper($slider['slider_text']))?></h1> 
					<br>
					<!--<a href="#"><button class="btn btn-primary btn-theme wow fadeInUp">View More</button></a>-->
				</div>
            </div> 			
		</div>
	<?php } ?>
	</div>
</section>
<div class="clearfix"></div>

<section class="categories_section">
    <div class="container-fluid">
        <div class="heading_title wow bounceInLeft"><h1>Top Categories <span class="mobile_show">& Products</span></h1></div>
		<div id="categories-slider" class="owl-carousel">
		<?php foreach($home_categories as $home_category){ ?>
			<a href="<?=LANG_URL.'/products-filter/'.base64_encode($home_category['id'])?>"><div class="item wow fadeInUp"><img src="<?php if($home_category['image']){ echo base_url('assets/uploads/categories/'.$home_category['image']); }else{ echo  UPLOAD_URL.'categories/default-category-img.png'; } ?>" title="<?=$home_category['name']?>" /></div></a>
		<?php } ?>
		</div>
    </div> 	
</section>

<div class="clearfix"></div>


<section class="products_section">
    <div class="container-fluid">
        <div class="heading_title wow bounceInLeft"><h1>Products</h1></div>
		<div id="product_section" class="main_products">
		
		<?php shuffle($products);
         if (!empty($products)) {
			foreach($products as $key) :
			$id=base64_encode($key['product_id']);
			$productName = escape_product_name($key['product_name']);
			?>
			<div class="col-md-3 col-sm-4 col-lg-3 col-xl-2 product_ak wow fadeInUp">
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
						<a href="<?=LANG_URL.'/products-details/'.$productName.'/'.$id?>"><button class="product_btn">£ <?=$key['price']?></button></a>
					</div>
				</div>
			</div>
		<?php  endforeach; 
		  if($productsCount>$offset+$limit){
		?>
				<div class="row load_more_seller_products">
					<div class="clearfix"></div>
					<input type="button" id="loadMore" value="Load More" class="btm btn-primary"/>
				</div>
		<?php }
			} elseif($offset<1) { ?>
			<br><h1 style="color: #ccc;" class="no-product-found">No Product Found !</h1>
		<?php }else{
			echo 'all_products_loaded';
		} ?>
        </div>
    </div> 	
</section>
<script>
var filterProductsURL = '<?=base_url('home/filterProducts/'.$this->uri->segment(2));?>';
var offset = 0;
var limit = <?=$limit?>;
$('#product_section').on('click','#loadMore',function(){
	
	offset = limit + offset;
	$.ajax({
		url: filterProductsURL,
		type: "POST",
		data: {'product_name':'', 'category_id':'<?=FASHION_CATEG_ID?>', 'offset': offset},
		//dataType: 'json',
		success: function (response) {
		  if(response != '')
		  {
			$('#product_section').find('.load_more_seller_products').remove();
			setTimeout(function() {
			  $('#product_section').removeClass('ajax_load');
			  if(response!='all_products_loaded')
			  {
				$('#product_section').append(response);
			  }
			}, 0);
		  }else{
			$('#product_section').html('');
		  }
		},
	});
});
</script>