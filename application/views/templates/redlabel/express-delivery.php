<?php $this->load->view($template . '_parts/search_filter'); ?>
<section class="products_section">
    <div class="container-fluid">
        <!--<div class="heading_title wow bounceInLeft"><h1>Products</h1></div>-->
		<div id="product_section" class="main_products row mb-4">
		
		<?php shuffle($products);
         if (!empty($products)) {
			$rows = '';
			foreach($products as $row){
				$id=base64_encode($row['product_id']);
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
		  if($productsCount>$offset+$limit){
		?>
				<div class="row load_more_seller_products" style="display:none;">
					<div class="clearfix"></div>
					<img src="<?=IMG_URL.'ajax-loader.gif'?>" class="ajax-loader"/>
					<input type="button" id="loadMore" value="Load More" class="btm btn-primary" style="display: none;"/>
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