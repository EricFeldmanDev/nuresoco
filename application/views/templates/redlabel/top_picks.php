<link href="https://cdn.jsdelivr.net/jquery.slick/1.3.15/slick.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
<div class="container-fluid">   
	<div class="text-right p-2"><button class="btn btn-primary" id="showMoreBundles">Show more bundles</button></div>   
	<div id="product_bundle_section">
		<h3 class="no_found" style="display:none;">No Product bundles found!</h3>
		<div class="slider" style="width:100%;">
		<?php if(!empty($product_bundles)) {
			shuffle($product_bundles); $rows = '';	
			foreach($product_bundles as $row) {
				$id = base64_encode($row['main_bundle']);
				$product_id = base64_encode($row['product_id']);
				$productName = escape_product_name($row['product_name']); 
				$product_ids = [$product_id]; $express = ''; $verified = '';
				if($row['nureso_express_status']== '1') 
					$express = '<img src="'.LANG_URL.'/assets/web/images/prd_1.png" class="express_img"/>';
				if($row['is_product_verified']== '1')
					$verified = '<img src="'.LANG_URL.'/assets/web/images/prd_3.png" class="express_img express_img1"/>';				
				$rows .= '<div class="fadeInUp">					
						<div class="filter-item" data-id="'.base64_encode($row['product_id']).'">
							<div class="d-flex">
								<div class="bundle_images" data-href="'.base_url('product_bundle-details/'.$productName.'/'.$product_id.'/'.$id).'">
									<div class="image_container"><img src="'.get_small_image($row['image']).'" style="width:100%"/></div>';
				if(sizeof($row['product_bundles'])>0) {
					foreach($row['product_bundles'] as $bundle) {
						$rows .= '<div class="image_container"><img src="'.get_small_image($bundle['image']).'" style="width:100%"/></div>';
						$product_ids[] = base64_encode($bundle['product_id']);
					}
				}
				$rows .= ' 		</div>
								<div class="express_container">
									<div class="d-flex justify-content-end">'.$verified.$express.'</div>
									<div class="mt-auto"><button class="btn btn-primary btn-buy-bundle" data-id="'.$row['product_id'].'" data-bundle="'.$row['main_bundle'].'">Buy Bundle</button></div>
								</div>
							</div>
							<input type="hidden" name="product_ids" value="'.implode(',', $product_ids).'"/>							
						</div>
					</div>';
			}
			echo $rows;
		}?>		
		</div>
	</div>
	<script>
		$(document).ready(function() {
			$('.slider').slick({                
				slidesToShow: 4,
				slidesToScroll: 4,
				arrows: false,
				dots: true,
				infinite: false,
				pauseOnHover: true,
				cssEase: 'linear',
				responsive: [{
					breakpoint: 1200,
					settings: {
						slidesToShow: 3,
						slidesToShow: 3
					}
				},{
					breakpoint: 900,
					settings: {
						slidesToShow: 2,
						slidesToShow: 2
					}
				}, {
					breakpoint: 768,
					settings: {
						slidesToShow: 1,
						slidesToScroll: 1
					}
				}]
			});
		});
	</script>
	<?php $this->load->view($template . '_parts/search_filter'); ?>
	<div id="product_section" class="main_products row mb-4">
	<?php if(!empty($recentproduct)){ 	
		shuffle($recentproduct); $rows = '';
	foreach ($recentproduct as $key => $row) {
		$id = base64_encode($row['product_id']);
		$productName = escape_product_name($row['product_name']); 
		$rows .= '<div class="col-sm-12 col-md-4 col-lg-3 col-xl-2 filter wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
			<div class="row">				
				<div class="filter-item" data-id="'.$id.'">
					<div class="d-flex">
						<div class="thumb-imgs">
							<a href="javascript:">
								<img src="'.get_small_image($row['image'], '100').'">
							</a>';
							foreach($row['products_addition_image'] as $addImag){
								$rows .='<a href="javascript:"> 
									<img src="'.get_small_image($addImag['image'], '100').'" width="555" height="320" />
								</a>';
							}
		$rows .= '		</div>
						<div class="main-img" data-href="'.base_url('products-details/'.$productName.'/'.$id).'">
							<img src="'.get_small_image($row['image']).'">
						</div>
					</div>
					<div class="d-flex mt-2" data-href="'.base_url('products-details/'.$productName.'/'.$id).'">
						<span class="p-name block-with-text">'.$row['product_name'].'</span>
						<span class="p-price">£'.$row['price'].'</span>						
					</div>					
					<div class="d-flex mt-2 justify-content-around">';
						if($row['nureso_express_status']=='1'){
							$rows .= '<img src="'.LANG_URL.'/assets/web/images/prd_1.png" class="express_img"/>';
						}
						if($row['is_product_verified']=='1'){
							$rows .= '<img src="'.LANG_URL.'/assets/web/images/prd_3.png" class="express_img express_img1"/>';
						}
						if($row['solds']) {
							$rows .= '<span class="b-button">'.$row['solds'].'</span>';
						}
		$rows .= '		<a href="javascript:" class="b-button">Buy</a>
					</div>
				</div>
			</div>
		</div>';
	}
	echo $rows; 
	if($productsCount>$offset+$limit){ ?>
		<div class="row load_more_seller_products" style="display:none;">
			<div class="clearfix"></div>
			<img src="<?=IMG_URL.'ajax-loader.gif'?>" class="ajax-loader"/>
			<input type="button" id="loadMore" value="Load More" class="btm btn-primary" style="display: none;"/>
		</div>
	<?php }
	} elseif($offset<1) { ?>
		<br><h1 style="color: #ccc;" class="no-product-found">No Product Found !</h1>
	<?php } ?>
    </div>
    <p style="display: none;" class="noproductavilable"></p>
</div> 	

<div class="modal" id="productModal">
  	<div class="modal-dialog modal-lg modal-dialog-centered">
    	<div class="modal-content">
			<!-- Modal Header -->
			<div class="modal-header">
				<h4 class="modal-title">Add to Cart</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<!-- Modal body -->
			<div class="modal-body detials_right">
				<h5 class="product_name"></h5> 
				<h6>Price : <span id="price"></span></h6>
				<div class="add_and_buy_btn">
					<a class="option" data-goto="<?= base_url('shopping-cart')?>" href="javascript:void(0);" data-id="">
						<button type="button" class="btn btn-primary buyNow cursor_disable">Add to cart</button>
					</a>
					<a class="option_1" data-goto="<?=base_url('shopping-cart')?>" href="javascript:void(0);" data-id="">
						<button type="button" class="btn btn-primary buyNow cursor_disable">Buy Now</button>
					</a>
					<p>Please select size and colour</p>
					<div id="notificator" class="alert" style="display:none;"></div>
					
					<div class="size_color_drop row">						
						<div class="col-md-6 col-sm-6">
							<div class="form-group size">
								<select class="form-control" id="selectsize">
									<option value="">Select Size</option>									
								</select>
							</div> 
						</div>						
						<div class="col-md-6 col-sm-6"> 
							<div class="form-group color">
								<select class="form-control" id="selectcolour">
									<option value="">Select Colour</option>									
								</select>
							</div> 
						</div>
					</div>					
					<div class="quantity_ak"><span>Quantity : </span>
						<div class="quantity">
						  <input type="number" id="quantity" min="1" max="350" step="1" value="1" readonly>
						</div>
					</div>
				</div>
			</div>
		</div>
  	</div>
</div>