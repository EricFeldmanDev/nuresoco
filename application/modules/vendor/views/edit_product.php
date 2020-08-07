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
?>
<?php //$this->load->view('_parts/modals') ?>
<!--<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<link rel="stylesheet" href="<?= base_url('assets/bootstrap-select-1.12.1/bootstrap-select.min.css') ?>">-->
<section class="profile_section sidebar_bg rating_merchant_ww">
	<?php $this->load->view('_parts/sidebar_merchant') ?>
	<form method="POST" >
		<div class="col-md-9 profile_right">
			<div class="col-md-12 margin_auto">
				<?php
				if ($this->session->flashdata('result_publish')) {
					?> 
					<div class="alert alert-success"><?= $this->session->flashdata('result_publish') ?></div> 
					<?php
				}
				?>
				<div class="shipping_info_section ">
					<div class="inventory_section bg_grey">
						<h3>Basic Information</h3>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#product_name">Product name 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" name="product_name" class="form-control" placeholder="Acceptable: Men’s dress casual shirt navy" value="<?=$productDetails['product_name']?>" required >
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#category_id">Product Category 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<select name="category_id" class="form-control" required >
								<option value="">--Select Category--</option>
								<?php foreach($vendor_categories as $category){ ?>
									<option value="<?=$category['id']?>" <?=$productDetails['category_id']==$category['id']?'selected':''?>><?=$category['name']?></option>
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
							<textarea name="description" id="description_editor" class="form-control" placeholder="Acceptable: This dress shirt is 1005 cotton and fits true to size"><?=$productDetails['description']?></textarea>
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group input_tags">
							<label>
								<a href="#" data-toggle="modal" data-target="#tags">Tags 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" name="tags_filter" class="form-control tags" placeholder="Acceptable: Shirts, men’s fashion, navy, blue, casual" autocomplete="off"  >
							<input type="hidden" name="tags" class="form-control tag_input" value="<?=implode(',',array_column($productDetails['tags'],'tag'))?>">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
							<div class="related_tags">
							</div>
						</div>
						<div class="input-group all_selected_tags">
							<label></label>
							<div class="selected_tags <?=!empty($productDetails['tags'])?'selected_tag_active':''?>">
							<?php 
							if(!empty($productDetails['tags']))
							{
								$i=0;
								foreach($productDetails['tags'] as $tags)
								{
							?>
								<span><?=$tags['tag']?> 
									<!--<i class="fa fa-close" data-tag-arr-val="<?=$i++?>"></i>-->
								</span>
							<?php } } ?>
							</div>
						</div>
						<div class="input-group unique_id">
							<label>
								<a href="#" data-toggle="modal" data-target="#unique_id">Unique ID 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" name="unique_id" value="<?=$productDetails['unique_id']?>" class="form-control" placeholder="Acceptable: HSC0424PP" required >
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
					</div>
					
					<div class="inventory_section main_img_section bg_grey">
						<h3>Main Image</h3>
						<div class="col-md-12 col-sm-12 col-lg-5 col-xl-4 main_left">
							<div class="user_profile_ww">   
							    <?php if(is_file(UPLOAD_PHYSICAL_PATH.'product-images/'.$productDetails['image']) && $productDetails['image'] !=''){ ?>
									<img src="<?=UPLOAD_URL.'product-images/'.$productDetails['image']?>" class='product_image' />
								<?php }else{?>
									<img src="<?=WEB_URL.'images/default-product.jpg'?>" class='product_image' />
								<?php }?>
								<input type="file" name="product_image" id="product_image" accept="image/jpeg" style="display:none;"/>
								<input type="hidden" name="main_image_id" id="main_image_id" value="<?=$productDetails['main_image_id']?>"/>
							</div>
							<p><button type="button" class="btn btn-primary" id="select_image"><i class="fa fa-desktop"></i> Update from computer</button></p> 
						</div>
						<div class="col-md-12 col-sm-12 col-lg-7 col-xl-8 main_right">
							<h6>Counterfeit products are prohibited on Nureso</h6> 
							<p>Products with multiple high quality images get the most sales</p>
							<p>Add images that are at least 1200x1200 pixels</p>
							<p>Do not steal images from other merchants, or your product will be deleted</p>
							<p>For more information on Intellectual property rules check out the <strong><span class="skyblue">Brand University</span><span class="red"><sup>New</sup></span></strong></p>
						</div>
						<div class="clearfix"></div>
						<div class="additional_image_heading">
							<h3>Additional Images</h3>
						</div>
						
						<div class="drag_file"> 						
							<div class="col-md-5 col-sm-4 col-lg-3 col-xl-2 box_a border" id="box_div_1" data-div-id="box_div_1">
								<?php if(isset($productDetails['additional_images'][0]) && is_file(UPLOAD_PHYSICAL_PATH.'product-images/'.$productDetails['additional_images'][0]['image']) && $productDetails['additional_images'][0]['image'] !=''){ ?>
									<a href="javascript:void(0);" title="close" id="upload_close_1" class="upload_close"><i class="fa fa-close"></i></a>
									<img src="<?=UPLOAD_URL.'product-images/'.$productDetails['additional_images'][0]['image']?>" class='additional_image box_b' />
									<input type="hidden" name="old_additional_image[<?=$productDetails['additional_images'][0]['pi_id']?>]" id="additional_image_1" value="<?=$productDetails['additional_images'][0]['image']?>"/>
								<?php }else{?>
									<a href="javascript:void(0);" title="close" id="upload_close_1" class="upload_close"></a>
									<img src="<?=WEB_URL.'images/default-product.jpg'?>" class='additional_image box_b' />
									<input type="hidden" name="additional_image[0]" id="additional_image_1" />
								<?php }?>
								Click to Upload
							</div>
							<div class="col-md-5 col-sm-4 col-lg-3 col-xl-2 box_a border" id="box_div_2" data-div-id="box_div_2">
							    <?php if(isset($productDetails['additional_images'][1]) && is_file(UPLOAD_PHYSICAL_PATH.'product-images/'.$productDetails['additional_images'][1]['image']) && $productDetails['additional_images'][1]['image'] !=''){ ?>
									<a href="javascript:void(0);" title="close" id="upload_close_2" class="upload_close"><i class="fa fa-close"></i></a>
									<img src="<?=UPLOAD_URL.'product-images/'.$productDetails['additional_images'][1]['image']?>" class='additional_image box_b' />
									<input type="hidden" name="old_additional_image[<?=$productDetails['additional_images'][1]['pi_id']?>]" id="additional_image_2" value="<?=$productDetails['additional_images'][1]['image']?>"/>
								<?php }else{?>
									<a href="javascript:void(0);" title="close" id="upload_close_2" class="upload_close"></a>
									<img src="<?=WEB_URL.'images/default-product.jpg'?>" class='additional_image box_b' />
									<input type="hidden" name="additional_image[1]" id="additional_image_2" />
								<?php }?>
								Click to Upload
							</div>
							<div class="col-md-5 col-sm-4 col-lg-3 col-xl-2 box_a border" id="box_div_3" data-div-id="box_div_3">
							    <?php if(isset($productDetails['additional_images'][2]) && is_file(UPLOAD_PHYSICAL_PATH.'product-images/'.$productDetails['additional_images'][2]['image']) && $productDetails['additional_images'][2]['image'] !=''){ ?>
									<a href="javascript:void(0);" title="close" id="upload_close_3" class="upload_close"><i class="fa fa-close"></i></a>
									<img src="<?=UPLOAD_URL.'product-images/'.$productDetails['additional_images'][2]['image']?>" class='additional_image box_b' />
									<input type="hidden" name="old_additional_image[<?=$productDetails['additional_images'][2]['pi_id']?>]" id="additional_image_3" value="<?=$productDetails['additional_images'][2]['image']?>"/>
								<?php }else{?>
									<a href="javascript:void(0);" title="close" id="upload_close_3" class="upload_close"></a>
									<img src="<?=WEB_URL.'images/default-product.jpg'?>" class='additional_image box_b' />
									<input type="hidden" name="additional_image[2]" id="additional_image_3" />
								<?php }?>
								Click to Upload
							</div>  
							<div class="col-md-5 col-sm-4 col-lg-3 col-xl-2 box_a border" id="box_div_4" data-div-id="box_div_4">
							    <?php if(isset($productDetails['additional_images'][3]) && is_file(UPLOAD_PHYSICAL_PATH.'product-images/'.$productDetails['additional_images'][3]['image']) && $productDetails['additional_images'][3]['image'] !=''){ ?>
									<a href="javascript:void(0);" title="close" id="upload_close_4" class="upload_close"><i class="fa fa-close"></i></a>
									<img src="<?=UPLOAD_URL.'product-images/'.$productDetails['additional_images'][3]['image']?>" class='additional_image box_b' />
									<input type="hidden" name="old_additional_image[<?=$productDetails['additional_images'][3]['pi_id']?>]" id="additional_image_4" value="<?=$productDetails['additional_images'][3]['image']?>"/>
								<?php }else{?>
									<a href="javascript:void(0);" title="close" id="upload_close_4" class="upload_close"></a>
									<img src="<?=WEB_URL.'images/default-product.jpg'?>" class='additional_image box_b' />
									<input type="hidden" name="additional_image[3]" id="additional_image_4" />
								<?php }?>
								Click to Upload
							</div>  
							<div class="col-md-5 col-sm-4 col-lg-3 col-xl-2 box_a border" id="box_div_5" data-div-id="box_div_5">
							    <?php if(isset($productDetails['additional_images'][4]) && is_file(UPLOAD_PHYSICAL_PATH.'product-images/'.$productDetails['additional_images'][4]['image']) && $productDetails['additional_images'][4]['image'] !=''){ ?>
									<a href="javascript:void(0);" title="close" id="upload_close_5" class="upload_close"><i class="fa fa-close"></i></a>
									<img src="<?=UPLOAD_URL.'product-images/'.$productDetails['additional_images'][4]['image']?>" class='additional_image box_b' />
									<input type="hidden" name="old_additional_image[<?=$productDetails['additional_images'][4]['pi_id']?>]" id="additional_image_5" value="<?=$productDetails['additional_images'][4]['image']?>"/>
								<?php }else{?>
									<a href="javascript:void(0);" title="close" id="upload_close_5" class="upload_close"></a>
									<img src="<?=WEB_URL.'images/default-product.jpg'?>" class='additional_image box_b' />
									<input type="hidden" name="additional_image[4]" id="additional_image_5" />
								<?php }?>
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
								<input type="text" id="price" name="price" class="form-control" placeholder="Acceptable: $100.99" required  value="<?=$productDetails['price']?>">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#quantity">Quantity 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="quantity" class="form-control" value="<?=$productDetails['quantity']?>" placeholder="Acceptable: 1200" required >
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>Shipping Type</label>
								<select name="shipping_type" id="shipping_type" class="form-control" required>
									<option value="">--Select Shipping Type--</option>
									<option value="free" <?=$productDetails['shipping_type']=='free'?'selected':''?>>Free Shipping</option>
									<option value="paid" <?=$productDetails['shipping_type']=='paid'?'selected':''?>>Paid Shipping</option>
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
								<input type="text" id="shipping_val" name="shipping" value="<?=$productDetails['shipping']?>" class="form-control" placeholder="Acceptable: $4.00" required autocomplete="off" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" maxlength="7">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>Earnings </label> 
								<input type="text" id="earnings" name="earnings" class="form-control" value="<?=$productDetails['earnings']?>" readonly >
							</div>
							<div class="input-group">
								<label>Shipping time </label>
								<div class="form-check-label">
								  <span><input class="form-check-input shipping_time" type="checkbox" data-check-val="checkbox" name="shipping_time" value="5-10" <?=$productDetails['shipping_time']=='5-10'?'checked':''?>   > 5-10</span>
								  <span><input class="form-check-input shipping_time" type="checkbox" data-check-val="checkbox" name="shipping_time" value="7-14" <?=$productDetails['shipping_time']=='7-14'?'checked':''?>   > 7-14</span>
								  <span><input class="form-check-input shipping_time" type="checkbox" data-check-val="checkbox" name="shipping_time" value="10-15" <?=$productDetails['shipping_time']=='10-15'?'checked':''?>   > 10-15</span>
								  <span><input class="form-check-input shipping_time" type="checkbox" data-check-val="checkbox" name="shipping_time" value="14-21" <?=$productDetails['shipping_time']=='14-21'?'checked':''?>   > 14-21</span>
								  <span><input class="form-check-input shipping_time" type="checkbox" data-check-val="checkbox" name="shipping_time" value="21-28" <?=$productDetails['shipping_time']=='21-28'?'checked':''?>  > 21-28</span>
								  <div><span><input class="form-check-input shipping_time" id="estimate_other" type="checkbox" data-check-val="other" name="shipping_time" value="" <?=$productDetails['shipping_time']==''?'checked':''?>> Other :</span></div>
									<div class="min_estimate_div">
										<div class="as1">Min estimate
											<div class="input-group min_estimate"> 
												<input type="text" class="form-control" id="min_estimate" name="min_estimate" value="<?=$productDetails['min_estimate']?>">
												<div class="input-group-append">
													<span class="input-group-text"><i class="fa fa-pencil"></i></span>
												</div>
											</div>
										</div>
										<div class="as2">Max estimate
											<div class="input-group min_estimate"> 
												<input type="text" class="form-control" id="max_estimate" name="max_estimate" value="<?=$productDetails['max_estimate']?>">
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
								<input type="text" name="default_declared_name" class="form-control" value="<?=$productDetails['default_declared_name']?>" required>
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#declared_local_name">Declared local name 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_local_name" class="form-control" value="<?=$productDetails['default_local_name']?>" required> 
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#pieces_included">Pieces included 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_pieces_included" class="form-control" value="<?=$productDetails['default_pieces_included']?>" required>
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#package_length">Package length 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_package_length" class="form-control" value="<?=$productDetails['default_package_length']?>" required>
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#package_width"> Package width
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_package_width" class="form-control" value="<?=$productDetails['default_package_width']?>" required>
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#package_height ">Package height 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_package_height" class="form-control" value="<?=$productDetails['default_package_height']?>" required>
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group"> 
								<label>
									<a href="#" data-toggle="modal" data-target="#package_weight">Package weight 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_package_weight" class="form-control" value="<?=$productDetails['default_package_weight']?>">
								<div class="input-group-append" required>
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#country_of_origin">country_of_origin 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_country_of_origin" class="form-control" value="<?=$productDetails['default_country_of_origin']?>" required>
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#custom_hs_code">Custom HS code 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_custom_hs_code" class="form-control" value="<?=$productDetails['default_custom_hs_code']?>" required>
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#custom_declared_value">custom_declared_value 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_custom_declared_value" class="form-control" value="<?=$productDetails['default_custom_declared_value']?>" required>
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#contains_powder">contains_powder 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_contains_powder" class="form-control" value="<?=$productDetails['default_contains_powder']?>"required>
								<div class="input-group-append" >
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#contains_liquid">Contains liquid 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_contains_liquid" class="form-control" value="<?=$productDetails['default_contains_liquid']?>" required>
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#contains_battery">Contains battery 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_contains_battery" class="form-control" value="<?=$productDetails['default_contains_battery']?>" required>
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#contains_metal">Contains metal 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" name="default_contains_metal" class="form-control" value="<?=$productDetails['default_contains_metal']?>" required>
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
										<input type="checkbox" class="color" data-color="<?=$color['category']?>" value="<?=$color['id']?>" <?=in_array($color['id'],$selectedColorIDs)?'checked':''?> /> <span class="color_box" style="background:<?=$color['details']?>;"></span> 
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
						<li class="nav-item"><a class="nav-link <?=$category['id']==$sizeMainId?'active':''?>" href="#a_<?=$category['id']?>" data-toggle="tab"><?=$category['category']?></a></li> 
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
							<div id="a_<?=$category['id']?>" class="tab-pane <?=$category['id']==$sizeMainId?'active':''?>">
								<ul class="sizing_ul">
								<?php 
								  if(!empty($category['sub_categories'])){ 
									foreach($category['sub_categories'] as $sub_category)
									{
									//pr($size_categories,1);
								?>
									<li><label><input type="checkbox" class="size_id category_identity_<?=$sub_category['size_category_id']?>" data-size_text="<?=$sub_category['size']?>" data-category_id="<?=$sub_category['size_category_id']?>" value="<?=$sub_category['id']?>" <?=in_array($sub_category['id'],$selectedSizeIDs)?'checked':''?> /> <?=$sub_category['size']?></label></li>     
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
									<?php
										foreach($productSizeColor as $sizeColor){
										if($sizeColor['size_id']!=0 && $sizeColor['color_id']!=0)
										{
											$fiels_name = 'old_size_color['.$sizeColor['psc_id'].']['.$sizeColor['size_id'].']['.$sizeColor['color_id'].']';
											$modal_id = 'modal_id_'.$sizeColor['size_id'].'_'.$sizeColor['color_id'];
										}elseif($sizeColor['size_id']!=0 && $sizeColor['color_id']==0)
										{
											$fiels_name = 'old_size['.$sizeColor['psc_id'].']['.$sizeColor['size_id'].']';
											$modal_id = 'modal_id_'.$sizeColor['size_id'];
										}elseif($sizeColor['size_id']==0 && $sizeColor['color_id']!=0)
										{
											$fiels_name = 'old_color['.$sizeColor['psc_id'].']['.$sizeColor['color_id'].']';
											$modal_id = 'modal_id_'.$sizeColor['color_id'];
										}
									?>
										<div class="variation_div <?=$sizeColor['size_id']!=0?'remove_'.$sizeColor['size_id']:''?> <?=$sizeColor['color_id']!=0?'remove_'.$sizeColor['color_id']:''?>" data-size-id="<?=$sizeColor['size_id']!=0?$sizeColor['size_id']:''?>" data-color-id="<?=$sizeColor['color_id']!=0?$sizeColor['color_id']:''?>" >

											<div class="product_variations_size">
												<p><?=$sizeColor['size_text']?></p>
											</div>

											<div class="product_variations_color">
												<span class="color_box" style="background:<?=$sizeColor['color_code']?>;"></span>
												<span class="color_name"><?=$sizeColor['color_text']?></span>
											</div>

											<div class="product_variations_unique_id">
												<div class="input-group">
													<input type="text" name="<?=$fiels_name?>[variations_unique_id]" class="form-control variations_unique_id" value="<?=$sizeColor['variations_unique_id']?>" placeholder="Acceptable: HSC42">
													<div class="input-group-append">
														<span class="input-group-text"><i class="fa fa-pencil"></i></span>
													</div>
												</div>
											</div>
											<div class="product_variations_price">
												<div class="input-group">
													<input type="text" name="<?=$fiels_name?>[variations_price]" class="form-control variation_price_val" value="<?=$sizeColor['variations_price']?>" placeholder="500.00">
													<div class="input-group-append">
														<span class="input-group-text"><i class="fa fa-pencil"></i></span>
													</div>
												</div>
											</div>
											<div class="product_variations_quantity">
												<div class="input-group">
													<input type="text" name="<?=$fiels_name?>[quantity]" class="form-control" value="<?=$sizeColor['quantity']?>" placeholder="120">
													<div class="input-group-append">
														<span class="input-group-text"><i class="fa fa-pencil"></i></span>
													</div>
												</div>
											</div>
											<div class="product_variations_earnings">
												<div class="form-group">
													<input type="text" name="<?=$fiels_name?>[variations_earnings]" class="form-control variation_earning_val" value="<?=$sizeColor['variations_earnings']?>" placeholder="$453.00" readonly>
												</div>
											</div>
											<div class="product_variations_logistucs">
												<div class="form-check">
												 <label class="form-check-label">
													<input type="radio" class="form-check-input radio_button" name="<?=$fiels_name?>[logistic_detail]" value="default" <?=$sizeColor['logistic_detail']=='default'?'checked':''?> >default <i class="fa fa-paper-plane default-paper-plane" <?=$sizeColor['logistic_detail']=='custom'?'style="display:none;"':''?>></i>
												  </label>
												</div>
												<div class="form-check">
												  <label class="form-check-label">
												   <input type="radio" class="form-check-input radio_button" name="<?=$fiels_name?>[logistic_detail]" value="custom" <?=$sizeColor['logistic_detail']=='custom'?'checked':''?> data-is-clicked="<?=$sizeColor['logistic_detail']=='custom'?'YES':'NO'?>">custom
													<a href="#" data-toggle="modal" data-target="#<?=$modal_id?>">
														<i class="fa fa-paper-plane" <?=$sizeColor['logistic_detail']=='default'?'style="display:none;"':''?>></i>
													</a>
												  </label>
												</div>
											</div>
											<div class="modal_div">
												<div class="modal merchant_modal custom_field_modal" id="<?=$modal_id?>">
													<div class="modal-dialog">
														<div class="modal-content">
															<div class="modal-header">
																<h4 class="modal-title">Custom Logistics Information</h4>
																<button type="button" class="close" data-dismiss="modal">&times;</button>
															</div>
															<div class="modal-body">
																<div class="inventory_section bg_grey">
																	<ul class="custom_ul_ww">
																		<li class="modal_size_text"><strong>Size:</strong> <?=$sizeColor['size_text']?></li>
																		<li class="modal_color_text"><strong>Color:</strong> <?=$sizeColor['color_text']?></li>
																		<li class="modal_sku_text"><strong>SKU:</strong> <?=$sizeColor['variations_unique_id']?></li>
																	</ul>
																	<div class="input-group">
																		<label>
																			<a href="#" data-toggle="modal" data-target="#declared_name">Declared name
																			<i class="fa fa-question-circle"></i></a>
																		</label>
																		<input type="text" name="<?=$fiels_name?>[declared_name]" class="form-control declared_name" value="<?=$sizeColor['declared_name']?>">
																		<div class="input-group-append">
																			<span class="input-group-text"><i class="fa fa-pencil"></i></span>
																		</div>
																	</div>
																	<div class="input-group">
																		<label>
																			<a href="#" data-toggle="modal" data-target="#declared_local_name">Declared local name 
																			<i class="fa fa-question-circle"></i></a>
																		</label>
																		<input type="text" name="<?=$fiels_name?>[local_name]"  value="<?=$sizeColor['local_name']?>" class="form-control local_name">
																		<div class="input-group-append">
																			<span class="input-group-text"><i class="fa fa-pencil"></i></span>
																		</div>
																	</div>
																	<div class="input-group">
																		<label>
																			<a href="#" data-toggle="modal" data-target="#pieces_included">Pieces included 
																			<i class="fa fa-question-circle"></i></a>
																		</label>
																		<input type="text" name="<?=$fiels_name?>[pieces_included]" class="form-control pieces_included" value="<?=$sizeColor['pieces_included']?>">
																		<div class="input-group-append">
																			<span class="input-group-text"><i class="fa fa-pencil"></i></span>
																		</div>
																	</div>
																	<div class="input-group">
																		<label>
																			<a href="#" data-toggle="modal" data-target="#package_length">Package length 
																			<i class="fa fa-question-circle"></i></a>
																		</label>
																		<input type="text" name="<?=$fiels_name?>[package_length]" class="form-control package_length" value="<?=$sizeColor['package_length']?>">
																		<div class="input-group-append">
																			<span class="input-group-text"><i class="fa fa-pencil"></i></span>
																		</div>
																	</div>
																	<div class="input-group">
																		<label>
																			<a href="#" data-toggle="modal" data-target="#package_width"> Package width 
																			<i class="fa fa-question-circle"></i></a>
																		</label>
																		<input type="text" name="<?=$fiels_name?>[package_width]" class="form-control package_width" value="<?=$sizeColor['package_width']?>">
																		<div class="input-group-append">
																			<span class="input-group-text"><i class="fa fa-pencil"></i></span>
																		</div>
																	</div>
																	<div class="input-group">
																		<label>
																			<a href="#" data-toggle="modal" data-target="#package_height ">Package height 
																			<i class="fa fa-question-circle"></i></a>
																		</label>
																		<input type="text" name="<?=$fiels_name?>[package_height]" class="form-control package_height" value="<?=$sizeColor['package_height']?>">
																		<div class="input-group-append">
																			<span class="input-group-text"><i class="fa fa-pencil"></i></span>
																		</div>
																	</div>
																	<div class="input-group">
																		<label>
																			<a href="#" data-toggle="modal" data-target="#package_weight">Package weight 
																			<i class="fa fa-question-circle"></i></a>
																		</label>
																		<input type="text" name="<?=$fiels_name?>[package_weight]" class="form-control package_weight" value="<?=$sizeColor['package_weight']?>">
																		<div class="input-group-append">
																			<span class="input-group-text"><i class="fa fa-pencil"></i></span>
																		</div>
																	</div>
																	<div class="input-group">
																		<label>
																			<a href="#" data-toggle="modal" data-target="#country_of_origin">Country of Origin
																			<i class="fa fa-question-circle"></i></a>
																		</label>
																		<input type="text" name="<?=$fiels_name?>[country_of_origin]" class="form-control country_of_origin" value="<?=$sizeColor['country_of_origin']?>">
																		<div class="input-group-append">
																			<span class="input-group-text"><i class="fa fa-pencil"></i></span>
																		</div>
																	</div>
																	<div class="input-group">
																		<label>
																			<a href="#" data-toggle="modal" data-target="#custom_hs_code">Custom HS code 
																			<i class="fa fa-question-circle"></i></a>
																		</label>
																		<input type="text" name="<?=$fiels_name?>[custom_hs_code]" class="form-control custom_hs_code" value="<?=$sizeColor['custom_hs_code']?>">
																		<div class="input-group-append">
																			<span class="input-group-text"><i class="fa fa-pencil"></i></span>
																		</div>
																	</div>
																	<div class="input-group">
																		<label>
																			<a href="#" data-toggle="modal" data-target="#custom_declared_value">Custom Declared Value 
																			<i class="fa fa-question-circle"></i></a>
																		</label>
																		<input type="text" name="<?=$fiels_name?>[custom_declared_value]" class="form-control custom_declared_value" value="<?=$sizeColor['custom_declared_value']?>">
																		<div class="input-group-append">
																			<span class="input-group-text"><i class="fa fa-pencil"></i></span>
																		</div>
																	</div>
																	<div class="input-group">
																		<label>
																			<a href="#" data-toggle="modal" data-target="#contains_powder">Contains Powder
																			<i class="fa fa-question-circle"></i></a>
																		</label>
																		<input type="text" name="<?=$fiels_name?>[contains_powder]" class="form-control contains_powder" value="<?=$sizeColor['contains_powder']?>">
																		<div class="input-group-append">
																			<span class="input-group-text"><i class="fa fa-pencil"></i></span>
																		</div>
																	</div>
																	<div class="input-group">
																		<label>
																			<a href="#" data-toggle="modal" data-target="#contains_liquid">Contains liquid 
																			<i class="fa fa-question-circle"></i></a>
																		</label>
																		<input type="text" name="<?=$fiels_name?>[contains_liquid]" class="form-control contains_liquid" value="<?=$sizeColor['contains_liquid']?>">
																		<div class="input-group-append">
																			<span class="input-group-text"><i class="fa fa-pencil"></i></span>
																		</div>
																	</div>
																	<div class="input-group">
																		<label>
																			<a href="#" data-toggle="modal" data-target="#contains_battery">Contains battery
																			<i class="fa fa-question-circle"></i></a>
																		</label>
																		<input type="text" name="<?=$fiels_name?>[contains_battery]" class="form-control contains_battery" value="<?=$sizeColor['contains_battery']?>">
																		<div class="input-group-append">
																			<span class="input-group-text"><i class="fa fa-pencil"></i></span>
																		</div>
																	</div>
																	<div class="input-group">
																		<label>
																			<a href="#" data-toggle="modal" data-target="#contains_metal">Contains metal 
																			<i class="fa fa-question-circle"></i></a>
																		</label>
																		<input type="text" name="<?=$fiels_name?>[contains_metal]" class="form-control contains_metal" value="<?=$sizeColor['contains_metal']?>">
																		<div class="input-group-append">
																			<span class="input-group-text"><i class="fa fa-pencil"></i></span>
																		</div>
																	</div>
																</div>
															</div>
															<div class="modal-footer">
																<button type="button" class="btn btn-danger" data-dismiss="modal">Save</button>
																<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									<?php } ?>
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
									<input type="text" name="msrp" class="form-control" value="<?=$productDetails['msrp']?>" placeholder="Acceptable: $19.00">
									<div class="input-group-append">
										<span class="input-group-text"><i class="fa fa-pencil"></i></span>
									</div>
								</div>
								<div class="input-group">
									<label>
										<a href="#" data-toggle="modal" data-target="#brand">Brand
										<i class="fa fa-question-circle"></i></a>
									</label>
									<input type="text" name="brand" class="form-control" value="<?=$productDetails['brand']?>" placeholder="Acceptable: Nike">
									<div class="input-group-append">
										<span class="input-group-text"><i class="fa fa-pencil"></i></span>
									</div>
								</div>
								<div class="input-group">
									<label>
										<a href="#" data-toggle="modal" data-target="#upc">UPC 
										<i class="fa fa-question-circle"></i></a>
									</label>
									<input type="text" name="upc" class="form-control" value="<?=$productDetails['upc']?>" placeholder="Acceptable: 716393133224">
									<div class="input-group-append">
										<span class="input-group-text"><i class="fa fa-pencil"></i></span>
									</div>
								</div>
								<div class="input-group"> 
									<label>
										<a href="#" data-toggle="modal" data-target="#max_quantity"> Max Quantity 
										<i class="fa fa-question-circle"></i></a>
									</label>
									<input type="text" name="max_quantity" class="form-control" value="<?=$productDetails['max_quantity']?>" placeholder="Acceptable: 100">
									<div class="input-group-append">
										<span class="input-group-text"><i class="fa fa-pencil"></i></span>
									</div>
								</div>
								<div class="input-group">
									<label>
										<a href="#" data-toggle="modal" data-target="#landing_page_url"> Landing Page URL 
										<i class="fa fa-question-circle"></i></a>
									</label>
									<input type="text" name="landing_page_url" class="form-control" value="<?=$productDetails['landing_page_url']?>" placeholder="Acceptable: http://www.amazon.com/gp/product/B008PE00DA/ref=s9_simh_gw_p193_d0_i3?ref=wish">
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
						<h4>Summary</h4> 
						<!-- <p class="warring_red">You are missing the product name</p> -->
						<div class="button_wr">
							<button type="button" class="btn btn-primary">Clear</button>   
							<input type="submit" class="btn btn-primary" value="Submit">  
						</div>
					</div>
					
				</div>  
			 
			</div>
		</div>
	</form>
</section>
<script>
isEditPage = true;
sizeArr = [];
alreadyAddedSingleSizeKeys = [];
colorArr = [];
alreadyAddedSingleColorKeys = [];
<?php foreach($productSizeColor as $sizeColorDetails){?>
	sizeArr[<?=$sizeColorDetails['size_id']?>] = '<?=$sizeColorDetails['size_text']?>';
	colorArr[<?=$sizeColorDetails['color_id']?>] = '<?=$sizeColorDetails['color_text']?>';
<?php } ?>
<?php if(empty($selectedColorIDs) && !empty($selectedSizeIDs)){ foreach($selectedSizeIDs as $sizeIds){?>
	alreadyAddedSingleSizeKeys.push(<?=$sizeIds?>);
<?php } } ?>
<?php if(empty($selectedSizeIDs) && !empty($selectedColorIDs)){ foreach($selectedColorIDs as $colorIds){?>
	alreadyAddedSingleColorKeys.push(<?=$colorIds?>);
<?php } } ?>
colorPHPArr = '<?php echo json_encode($colorArr) ?>';
addProductImage = '<?=base_url('addProductImage')?>';
getTags = '<?=base_url('getTags')?>';
productDefaultImage = '<?=WEB_URL.'images/default-product.jpg'?>';
tagArr = [];
<?php if(!empty($productDetails['tags']))
{
	foreach($productDetails['tags'] as $tag)
	{
?>
	tagArr.push('<?=$tag['tag']?>');
<?php }
}	?>
console.log(tagArr);
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
	} ).setReadOnly(true);
//$('button[type=submit], input[type=submit]').prop('disabled',true);
</script>
