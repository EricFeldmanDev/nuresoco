<?php //print_r($_SESSION['logged_user']['id']); ?>
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
       <!--  <div class="heading_title wow bounceInLeft"><h1>Top Categories & Products </h1></div> -->
       
		<div id="categories-slider" class="owl-carousel">
		<?php
		foreach($home_categories as $home_category){ 
           // echo UPLOAD_PHYSICAL_PATH.'categories/'.$home_category['image'];
			?>
			<a href="<?=LANG_URL.'/products-filter/'.base64_encode($home_category['id'])?>"><div class="item wow fadeInUp"><img src="<?= base_url().'assets/uploads/categories/'.$home_category['image']; ?>" title="<?=$home_category['name']?>" /></div></a>
		<?php } ?>
		</div>
    </div> 	
</section>

<div class="clearfix"></div>
<?php $this->load->view($template . '_parts/search_filter'); ?>
<section class="products_section">
    <div class="container-fluid">
        <!--<div class="heading_title wow bounceInLeft"><h1>Products</h1></div>-->
		<div id="product_section" class="main_products">
		<?php 
		$rows = '';
		if(!empty($recentproduct)){ 
       		shuffle($recentproduct);
			foreach ($recentproduct as $key => $row) {
				$id=base64_encode($row['product_id']);
				$productName = escape_product_name($row['product_name']);
				$rows .= '<div class="col-md-4 col-sm-4 col-lg-3 col-xl-2 product_ak wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
					<div class="row">
						<a href="'.base_url('products-details/'.$productName.'/'.$id).'"><div class="porduct_img"><img src="'.get_small_image($row['image']).'"></div></a>
						<a href="javascript:void(0);" class="add_to_wishlist" data-product_id="'.$id.'">
												<i class="fa fa-heart-o"></i>
							<i class="fa fa-heart" style="display:none;"></i>
						</a>
						<div class="product_dsp">
							<span>'.$row['product_name'].'</span>
							<div class="ww">';
							if($row['is_product_verified']=='1'){
								$rows .= '<img src="'.LANG_URL.'/assets/web/images/prd_3.png" class="express_img express_img1"/>';
							}
							if($row['nureso_express_status']=='1'){
								$rows .= '<img src="'.LANG_URL.'/assets/web/images/prd_1.png" class="express_img"/>';
							}
				$rows .= '  <a href="'.LANG_URL.'/products-details/'.$productName.'/'.$id.'"><button class="product_btn">£ '.$row['price'].'</button></a>
							</div>
						</div>
					</div>
				</div>';
			}        
       	}		
        if (!empty($products)) {
			shuffle($products);
			foreach($products as $key){				
				$id=base64_encode($key['product_id']);
				$productName = escape_product_name($key['product_name']);			
				$rows .= '<div class="col-md-4 col-sm-4 col-lg-3 col-xl-2 product_ak wow fadeInUp">
				<div class="row">
					<a href="'.LANG_URL.'/products-details/'.$productName.'/'.$id.'"><div class="porduct_img"><img src="'.get_small_image($key['image']).'"/></div></a>
					<a href="javascript:void(0);" class="add_to_wishlist" data-product_id="'.$id.'">';					
					$blankHeartStyle = '';
					$filledHeartStyle = 'style="display:none;"';
					if(in_array($key['product_id'],$wishlist_Product_ids)){
						$blankHeartStyle = 'style="display:none;"';
						$filledHeartStyle = '';
					}
						$rows .= '<i class="fa fa-heart-o" '.$blankHeartStyle.'></i>
						<i class="fa fa-heart" '.$filledHeartStyle.'></i>
					</a>
					<div class="product_dsp">
						<span>'.$key['product_name'].'</span>
						<div class="ww">';
						if($key['is_product_verified']=='1'){
							$rows .'<img src="'.LANG_URL.'/assets/web/images/prd_3.png" class="express_img express_img1"/>';
						} 
						if($key['nureso_express_status']=='1'){
							$rows .= '<img src="'.LANG_URL.'/assets/web/images/prd_1.png" class="express_img"/>';
						}
						$rows .= '<a href="'.LANG_URL.'/products-details/'.$productName.'/'.$id.'"><button class="product_btn">£ '.$key['price'].'</button></a>
						</div>
					</div>
				</div>
			</div>';
			}
		  	if($productsCount>$offset+$limit){
				$rows .= '<div class="row load_more_seller_products" style="display:none;">
					<div class="clearfix"></div>
					<img src="'.IMG_URL.'ajax-loader.gif" class="ajax-loader"/>
					<input type="button" id="loadMore" value="Load More" class="btm btn-primary" style="display: none;"/>
				</div>';
			}
		} elseif($offset<1) {
			$rows .= '<br><h1 style="color: #ccc;" class="no-product-found">No Product Found !</h1>';
		}
		echo $rows;
		?>
        </div>
        <p style="display: none;" class="noproductavilable"></p>
    </div> 	
</section>
<script>


</script>