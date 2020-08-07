<div class="container-fluid">
	<div class="mobile_search_panel filter_product search_box_panel">
		<a href="javascript:" class="btn_cancel_search"><i class="fa fa-chevron-left"></i> Cancel</a>
		<h2 class="mobile_search_title">Search</h2>
		<div class="search_header">
			<div class="d-flex" style="padding: 4px 0 4px 0px;">
				<div class="search-group">				
					<a href="javascript:" class="btn_search"><i class="fa fa-search"></i></a>				
					<input type="text" name="search_data" class="form-control" placeholder="Search product..." autocomplete="off" value="<?php if(isset($search_data)){ echo $search_data;  } ?>" required onkeyup="liveSearch(this)">
					<ul class="search_product" style="display:none;" >
					</ul>						
					<a href="javascript:" class="btn_search_clear"><i class="fa fa-times"></i></a>
				</div>										
			</div>
			<div class="search_option" style="display:none;">
				<?php if(!isset($search_mode)) $search_mode = 'product'; ?>
				<p>Browse by:</p>
				<div class="d-flex">
					<div class="search_option_item product flex-fill <?php if($search_mode == 'product') echo 'active'?>"><p>Product</p></div>
					<div class="search_option_item product_bundle flex-fill <?php if($search_mode == 'product_bundle') echo 'active'?>"><p>Product Bundle</p></div>
				</div>
			</div>
		</div>
		<?php $this->load->view($template . '_parts/search_filter'); ?>
	</div>
	<?php if($search_mode == 'product')	{?>
	<div id="product_section" class="main_products row mb-4 search_result">
		<?php 		
		if($filter){
			shuffle($filter); 
			$rows = '';
			foreach ($filter as $key => $row) {
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
		}else{
			echo '<div class="notfound">No Product Found</div>';
		}?>
	</div>
	<?php } else { ?>
	<div id="product_bundle_section" class="row mb-4 search_result">
		<?php if(!empty($filter)) {
			shuffle($filter); $rows = '';	
			foreach($filter as $row) {
				$id = base64_encode($row['main_bundle']);
				$product_id = base64_encode($row['product_id']);
				$productName = escape_product_name($row['product_name']); 
				$product_ids = [$product_id]; $express = ''; $verified = '';
				if($row['nureso_express_status']== '1') 
					$express = '<img src="'.LANG_URL.'/assets/web/images/prd_1.png" class="express_img"/>';
				if($row['is_product_verified']== '1')
					$verified = '<img src="'.LANG_URL.'/assets/web/images/prd_3.png" class="express_img express_img1"/>';				
				$rows .= '<div class="col-sm-12 col-md-6 col-lg-4 col-xl-3 filter wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
					<div class="row">
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
									<div class="text-right">'.$verified.$express.'</div>
									<div class="mt-auto"><button class="btn btn-primary btn-buy-bundle" data-id="'.$row['product_id'].'" data-bundle="'.$row['main_bundle'].'">Buy Bundle</button></div>
								</div>
							</div>
							<input type="hidden" name="product_ids" value="'.implode(',', $product_ids).'"/>							
						</div>
					</div>
				</div>';
			}
			echo $rows;
		}?>
	</div>
	<?php } ?>
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