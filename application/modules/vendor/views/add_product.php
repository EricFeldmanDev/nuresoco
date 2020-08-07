<style>
.ck-editor__editable {
    min-height: 100px;
    max-height: 250px;
}
.ck.ck-editor {
    width: 70%;
}
</style>
<?php
$uri = uri_string();
$timeNow = time();
$uri4=$this->uri->segment(4);
?>
<?php //$this->load->view('_parts/modals') ?>
<!--<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<link rel="stylesheet" href="<?= base_url('assets/bootstrap-select-1.12.1/bootstrap-select.min.css') ?>">-->
<section class="profile_section sidebar_bg rating_merchant_ww">
	<?php $this->load->view('_parts/sidebar_merchant') ?>
	<form method="POST" >
		<div class="profile_right" id="page-content-wrapper">
			<div class="col-md-12 margin_auto">
				<?php
				if ($this->session->flashdata('result_publish')) {
					?> 
					<div class="alert alert-success"><?= $this->session->flashdata('result_publish') ?></div> 
					<?php
				}

				if($uri4){?>
					<input type="hidden" name="nureso_express_status" value="1">	
				<?php }
				?>
				<div class="shipping_info_section ">
					<div class="inventory_section bg_grey">
						<h3>Basic Information</h3>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#product_name">Product name 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" name="product_name" class="form-control" placeholder="Acceptable: Men’s dress casual shirt navy" required>
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#category_id">Product Category 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<select name="category_id" class="form-control" required>
								<option value="">--Select Category--</option>
								<?php foreach($vendor_categories as $category){ ?>
									<option value="<?=$category['id']?>"><?=$category['name']?></option>
								<?php } ?>
							</select>
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#description">Description 
								<i class="fa fa-question-circle"></i></a>
								</label>
							<textarea name="description" id="description_editor" class="form-control" placeholder="Acceptable: This dress shirt is 1005 cotton and fits true to size"></textarea>
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group input_tags">
							<label>
								<a href="#" data-toggle="modal" data-target="#tags">Tags 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" name="tags_filter" class="form-control tags" placeholder="Acceptable: Shirts, men’s fashion, navy, blue, casual" autocomplete="off">
							<input type="hidden" name="tags" class="form-control tag_input">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
							<div class="related_tags">
							</div>
						</div>
						<div class="input-group all_selected_tags">
							<label></label>
							<div class="selected_tags">
							</div>
						</div>
						<div class="input-group unique_id">
							<label>
								<a href="#" data-toggle="modal" data-target="#unique_id">Unique ID 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" name="unique_id" class="form-control" placeholder="Acceptable: HSC0424PP" required>
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
					</div>
					
					<div class="inventory_section main_img_section bg_grey">
						<h3>Main Image</h3>
						<div class="col-md-12 col-sm-12 col-lg-5 col-xl-4 main_left">
							<div class="user_profile_ww">   
							    
								<img src="<?=WEB_URL.'images/default-product.jpg'?>" class='product_image' />
								<input type="file" name="product_image" id="product_image" accept="image/jpeg" style="display:none;"/>
								<input type="hidden" name="main_image_id" id="main_image_id"/>
							</div>
							<p><button type="button" class="btn btn-primary" id="select_image"><i class="fa fa-desktop"></i> Select from computer</button></p> 
						</div>
						<div class="col-md-12 col-sm-12 col-lg-7 col-xl-8 main_right">
							<h6>Counterfeit products are prohibited on Nureso</h6> 
							<p>Products with multiple high quality images get the most sales</p>
							<p>Add images that are at least 800x800 pixels</p>
							<p>Do not steal images from other merchants, or your product will be deleted</p>
							<p>For more information on Intellectual property rules check out the <strong><span class="skyblue">Brand University</span><span class="red"><sup>New</sup></span></strong></p>
						</div>
						<div class="clearfix"></div>
						<div class="additional_image_heading">
							<h3>Additional Images</h3>
						</div>
						
						<div class="drag_file"> 						
							<div class="col-md-5 col-sm-4 col-lg-3 col-xl-2 box_a border" id="box_div_1" data-div-id="box_div_1">
								<a href="javascript:void(0);" title="close" id="upload_close_1" class="upload_close"></a>
								<img src="<?=WEB_URL.'images/default-product.jpg'?>" class='additional_image box_b' />
								<input type="hidden" name="additional_image[0]" id="additional_image_1" />
								Click to Upload
							</div>
							<div class="col-md-5 col-sm-4 col-lg-3 col-xl-2 box_a border" id="box_div_2" data-div-id="box_div_2">
							    <a href="javascript:void(0);" title="close" id="upload_close_2" class="upload_close"></a>
								<img src="<?=WEB_URL.'images/default-product.jpg'?>" class='additional_image box_b' />
								<input type="hidden" name="additional_image[1]" id="additional_image_2" />
								Click to Upload
							</div>
							<div class="col-md-5 col-sm-4 col-lg-3 col-xl-2 box_a border" id="box_div_3" data-div-id="box_div_3">
							    <a href="javascript:void(0);" title="close" id="upload_close_3" class="upload_close"></a>
								<img src="<?=WEB_URL.'images/default-product.jpg'?>" class='additional_image box_b' />
								<input type="hidden" name="additional_image[2]" id="additional_image_3" />
								Click to Upload
							</div>  
							<div class="col-md-5 col-sm-4 col-lg-3 col-xl-2 box_a border" id="box_div_4" data-div-id="box_div_4">
							    <a href="javascript:void(0);" title="close" id="upload_close_4" class="upload_close"></a>
								<img src="<?=WEB_URL.'images/default-product.jpg'?>" class='additional_image box_b' />
								<input type="hidden" name="additional_image[3]" id="additional_image_4" />
								Click to Upload
							</div>  
							<div class="col-md-5 col-sm-4 col-lg-3 col-xl-2 box_a border" id="box_div_5" data-div-id="box_div_5">
							    <a href="javascript:void(0);" title="close" id="upload_close_5" class="upload_close"></a>
								<img src="<?=WEB_URL.'images/default-product.jpg'?>" class='additional_image box_b' />
								<input type="hidden" name="additional_image[4]" id="additional_image_5" />
								Click to Upload
							</div> 
							<input type="hidden" name="type" value="ADDITIONAL"/>
							<input type="file" name="product_image" id="product_additional_image" accept="image/jpeg" style="display:none;"/>
						</div>
					</div>
					
				</div>
			
				<div class="shipping_info_section">
					<div class="inventory_section bg_grey">
						<h3>Inventory & Shipping</h3>
						
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#price">Price 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" id="price" name="price" class="form-control" placeholder="Acceptable: £100.99" required >
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#quantity">Quantity 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="quantity" class="form-control" placeholder="Acceptable: 1200" required>
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>Shipping Type</label>
								<select name="shipping_type" id="shipping_type" class="form-control" required>
									<option value="">--Select Shipping Type--</option>
									<option value="free">Free Shipping</option>
									<option value="paid">Paid Shipping</option>
								</select>
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group shipping_price"> 
								<label>
									<a href="#" data-toggle="modal" data-target="#shipping">Shipping 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" id="shipping_val" name="shipping" class="form-control" placeholder="Acceptable: £4.00" required autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" maxlength="7">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>Earnings </label> 
								<input type="text" id="earnings" name="earnings" class="form-control" readonly>
							</div>
							<div class="input-group">
								<label>Shipping time </label> 
								<div class="form-check-label">
								  <span><input class="form-check-input shipping_time" type="checkbox" data-check-val="checkbox" name="shipping_time" value="5-10" > 5-10</span>
								  <span><input class="form-check-input shipping_time" type="checkbox" data-check-val="checkbox" name="shipping_time" value="7-14" > 7-14</span>
								  <span><input class="form-check-input shipping_time" type="checkbox" data-check-val="checkbox" name="shipping_time" value="10-15" > 10-15</span>
								  <span><input class="form-check-input shipping_time" type="checkbox" data-check-val="checkbox" name="shipping_time" value="14-21" > 14-21</span>
								  <span><input class="form-check-input shipping_time" type="checkbox" data-check-val="checkbox" name="shipping_time" value="21-28" > 21-28</span>
								  <div><span><input class="form-check-input shipping_time" id="estimate_other" type="checkbox" data-check-val="other" name="shipping_time" value="" > Other :</span></div>
									<div class="min_estimate_div">
										<div class="as1">Min estimate
											<div class="input-group min_estimate"> 
												<input type="text" class="form-control" id="min_estimate" name="min_estimate">
												<div class="input-group-append">
													<span class="input-group-text"><i class="fa fa-pencil"></i></span>
												</div>
											</div>
										</div>
										<div class="as2">Max estimate
											<div class="input-group min_estimate"> 
												<input type="text" class="form-control" id="max_estimate" name="max_estimate">
												<div class="input-group-append">
													<span class="input-group-text"><i class="fa fa-pencil"></i></span>
												</div>
											</div>
										</div>
									</div>
								</div>
									<div id="logistics_information"></div>
							</div>
						</form>
						<!--<p class="customize_choosen">Customize choosen price for shipping countries</p>-->
					</div>
				</div>
				<div class="shipping_info_section">
					<div class="inventory_section bg_grey">
						<h3>Logistics Information</h3>
						
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#declared_name">Declared name 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_declared_name" class="form-control">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#declared_local_name">Declared local name 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_local_name" class="form-control">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#pieces_included">Pieces included 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_pieces_included" class="form-control">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#package_length">Package length 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_package_length" class="form-control">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#package_width"> Package width
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_package_width" class="form-control">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#package_height ">Package height 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_package_height" class="form-control">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group"> 
								<label>
									<a href="#" data-toggle="modal" data-target="#package_weight">Package weight 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_package_weight" class="form-control">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#country_of_origin">country_of_origin 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_country_of_origin" class="form-control">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#custom_hs_code">Custom HS code 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_custom_hs_code" class="form-control">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#custom_declared_value">custom_declared_value 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_custom_declared_value" class="form-control">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#contains_powder">contains_powder 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_contains_powder" class="form-control">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#contains_liquid">Contains liquid 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_contains_liquid" class="form-control">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#contains_battery">Contains battery 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_contains_battery" class="form-control">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#contains_metal">Contains metal 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_contains_metal" class="form-control">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
						</form>
					</div>
					
					<div class="inventory_section bg_grey">
						<h3>Colors</h3>
						<ul class="color_ul">
							<?php 
							$colorArr = array();
							if(!empty($color_categories)){ 
								foreach($color_categories as $color)
								{
									$colorArr[$color['category']] = $color['details'];
							?>
								<li>
									<label>
										<input type="checkbox" class="color" data-color="<?=$color['category']?>" value="<?=$color['id']?>" /> <span class="color_box" style="background:<?=$color['details']?>;"></span> 
										<span class="color_name"><?=$color['category']?></span>
									</label>
								</li>
							<?php } } ?>
						</ul>
					</div>
					
				</div>
			
				<div class="margin_auto apparal_section sizing_apparel bg_grey">
					<h5 class="heading_app">Sizing</h5>
					<ul class="apparal_ul nav nav-tabs" role="tablist">
					<?php 
					  if(!empty($size_categories)){ 
						$i=0;
						foreach($size_categories as $category)
						{
					?>
						<li class="nav-item"><a class="nav-link <?= $i==0?'active':''?>" href="#a_<?=$category['id']?>" data-toggle="tab"><?=$category['category']?></a></li> 
					<?php $i++; 
						} 
					  } 
					?>
					</ul>
					<div class="clearfix"></div>
					<div class="tab-content">
						<?php 
						  if(!empty($size_categories)){ 
							$i=0;
							foreach($size_categories as $category)
							{
						?>
							<div id="a_<?=$category['id']?>" class="tab-pane <?= $i==0?'active':'fade'?>">
								<ul class="sizing_ul">
								<?php 
								  if(!empty($category['sub_categories'])){ 
									foreach($category['sub_categories'] as $sub_category)
									{
								?>
									<li><label><input type="checkbox" class="size_id category_identity_<?=$sub_category['size_category_id']?>" data-size_text="<?=$sub_category['size']?>" data-category_id="<?=$sub_category['size_category_id']?>" value="<?=$sub_category['id']?>"/> <?=$sub_category['size']?></label></li>     
								<?php
									} 
								  } 
								?>
								</ul>
							</div>
						<?php $i++; 
							} 
						  }
						?>
					</div>
					
					<div class="shipping_info_section ">
						<div class="border summary_section bg_grey">
							<h4>Product variations</h4><br>
							<div class="product_variations_main table table-responsive table-bordered">
								<div class="row product_variations product_variations_heading">
									<div class="product_variations_size">
										<h5>Size</h5> 
									</div>     
									<div class="product_variations_color">
										<h5>Color</h5>  
									</div>     
									<div class="product_variations_unique_id">
										<h5>Unique Id (SKU)</h5>  
									</div>     
									<div class="product_variations_price">
										<h5>Price</h5>  
									</div>     
									<div class="product_variations_quantity">
										<h5>Quantity</h5>  
									</div>     
									<div class="product_variations_earnings">
										<h5>Earnings</h5> 
									</div>     
									<div class="product_variations_logistucs">
										<h5>Logistics</h5> 
									</div>     
								</div>
								<div class="row product_variations" id="add-variations"> 
								</div>
							</div>
						</div>	
					</div>
					
					<div class="border summary_section bg_grey information_option">
						<h4>Optional information 
						<a href="#" data-toggle="collapse" data-target="#information"><i class="fa fa-plus"></i></a></h4> 
						<div id="information" class="collapse">
							<div class="inventory_section bg_grey">
								<div class="input-group">
									<label>
										<a href="#" data-toggle="modal" data-target="#msrp">MSRP 
										<i class="fa fa-question-circle"></i></a>
									</label>
									<input type="text" name="msrp" class="form-control" placeholder="Acceptable: £19.00">
									<div class="input-group-append">
										<span class="input-group-text"><i class="fa fa-pencil"></i></span>
									</div>
								</div>
								<div class="input-group">
									<label>
										<a href="#" data-toggle="modal" data-target="#brand">Brand
										<i class="fa fa-question-circle"></i></a>
									</label>
									<input type="text" name="brand" class="form-control" placeholder="Acceptable: Nike">
									<div class="input-group-append">
										<span class="input-group-text"><i class="fa fa-pencil"></i></span>
									</div>
								</div>
								<div class="input-group">
									<label>
										<a href="#" data-toggle="modal" data-target="#upc">UPC 
										<i class="fa fa-question-circle"></i></a>
									</label>
									<input type="text" name="upc" class="form-control" placeholder="Acceptable: 716393133224">
									<div class="input-group-append">
										<span class="input-group-text"><i class="fa fa-pencil"></i></span>
									</div>
								</div>
								<div class="input-group"> 
									<label>
										<a href="#" data-toggle="modal" data-target="#max_quantity"> Max Quantity 
										<i class="fa fa-question-circle"></i></a>
									</label>
									<input type="text" name="max_quantity" class="form-control" placeholder="Acceptable: 100">
									<div class="input-group-append">
										<span class="input-group-text"><i class="fa fa-pencil"></i></span>
									</div>
								</div>
								<div class="input-group">
									<label>
										<a href="#" data-toggle="modal" data-target="#landing_page_url"> Landing Page URL 
										<i class="fa fa-question-circle"></i></a>
									</label>
									<input type="text" name="landing_page_url" class="form-control" placeholder="Acceptable: http://www.amazon.com/gp/product/B008PE00DA/ref=s9_simh_gw_p193_d0_i3?ref=wish">
									<div class="input-group-append">
										<span class="input-group-text"><i class="fa fa-pencil"></i></span>
									</div>
								</div>
							</div>
							
						</div>
					</div>
					<div class="border summary_section bg_grey">
						<h4>Days until automatic refund</h4> 
						<p class="days_qq"><span>5</span> days until automatic refunded</p>
						<p>All order must be fulfill in 5days,or they will be automatically refunded</p>
					</div>
					<div class="border summary_section bg_grey">
						<!--
						<h4>Summary</h4> 
						<p class="warring_red">You are missing the product name</p>
						-->
						<div class="button_wr">
							<button type="button" class="btn btn-primary">Clear</button>   
							<button type="submit" class="btn btn-primary">Submit</button>   
						</div>
					</div>
				</div>  
			 
			</div>
		</div>
	</form>
</section>
<script>
isEditPage = false;
colorPHPArr = '<?php echo json_encode($colorArr) ?>';
addProductImage = '<?=base_url('addProductImage')?>';
getTags = '<?=base_url('getTags')?>';
productDefaultImage = '<?=WEB_URL.'images/default-product.jpg'?>';
tagArr = [];
</script>
<script src="<?= WEB_URL.'js/product.js' ?>"></script>

<script src="https://cdn.ckeditor.com/ckeditor5/11.2.0/classic/ckeditor.js"></script>
<script>
ClassicEditor
	.create( document.querySelector( '#description_editor' ) )
	.then( editor => {
			language = '#9AB8F3';
		} )
	.catch( error => {
		console.error( error );
	} );

	
$('form').on('submit',function(e){
	checkStatus = false;
	$('.shipping_time').each(function(){
		if($(this).is(":checked"))
		{
			checkStatus = true;
		}
	});
	if(!checkStatus)
	{
		alert('Please check shipping time also!');
		e.preventDefault();
	}
});
//$('button[type=submit], input[type=submit]').prop('disabled',true);
</script>
