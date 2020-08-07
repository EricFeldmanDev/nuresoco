<?php
$timeNow = time();
?>
<?php $this->load->view('_parts/modals') ?>
<!--<script src="<?= base_url('assets/ckeditor/ckeditor.js') ?>"></script>
<link rel="stylesheet" href="<?= base_url('assets/bootstrap-select-1.12.1/bootstrap-select.min.css') ?>">-->
<section class="profile_section sidebar_bg rating_merchant_ww">
	<?php $this->load->view('_parts/sidebar_merchant') ?>
	<?php
	if ($this->session->flashdata('result_publish')) {
		?> 
		<div class="alert alert-success"><?= $this->session->flashdata('result_publish') ?></div> 
		<?php
	}
	?>
	<div class="col-md-9 profile_right">
		<div class="col-md-12 margin_auto">
			<div class="shipping_info_section ">
				<div class="inventory_section bg_grey">
					<h3>Basic Information</h3>
					<form>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#product_name">Product name 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control" placeholder="Acceptable: Men’s dress casual shirt navy">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#description">Description 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control" placeholder="Acceptable: This dress shirt is 1005 cotton and fits true to size">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#tags">Tags 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control" placeholder="Acceptable: Shirts, men’s fashion, navy, blue, casual">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#unique_id">Unique ID 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control" placeholder="Acceptable: HSC0424PP">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
					</form>
				</div>
				
				<div class="inventory_section main_img_section bg_grey">
					<h3>Main Image</h3>
					<div class="col-md-12 col-sm-12 col-lg-5 col-xl-4 main_left">
						<p><button type="button" class="btn btn-primary drag_file">Drag file here</button></p> 
						<span>or...</span>
						<p><button type="button" class="btn btn-primary"><i class="fa fa-desktop"></i> Select from computer</button></p>   
						<span>or...</span>
						<p><button type="button" class="btn btn-primary"><i class="fa fa-globe"></i> Web address (url)</button></p>   
					</div>
					<div class="col-md-12 col-sm-12 col-lg-7 col-xl-8 main_right">
						<h6>Counterfeit products are prohibited on Wish</h6> 
						<p>Products with multiple high quality images get the most sales</p>
						<p>Add images that are at least 800x800 pixels</p>
						<p>Do not steal images from other merchants, or your product will be deleted</p>
						<p>For more information on Intellectual property rules check out the <strong><span class="skyblue">Brand University</span><span class="red"><sup>New</sup></span></strong></p>
					</div>
					<div class="clearfix"></div>
					<div class="additional_image">
						<h3>Additional Image</h3>
						<button type="button" class="btn btn-primary"><i class="fa fa-desktop"></i> Select from computer</button>
						<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#web_address">
							<i class="fa fa-globe"></i> Web address (url)
						</button>
					</div>
					
					<div class="drag_file"> 
						<div class="col-md-5 col-sm-4 col-lg-3 col-xl-2 box_a border">Drag file here</div>  
						<div class="col-md-5 col-sm-4 col-lg-3 col-xl-2 box_a border">Drag file here</div>  
						<div class="col-md-5 col-sm-4 col-lg-3 col-xl-2 box_a border">Drag file here</div>  
						<div class="col-md-5 col-sm-4 col-lg-3 col-xl-2 box_a border">Drag file here</div>  
						<div class="col-md-5 col-sm-4 col-lg-3 col-xl-2 box_a border">Drag file here</div> 
					</div>
				</div>
				
			</div>
		
			<div class="shipping_info_section">
				<div class="inventory_section bg_grey">
					<h3>Inventory & Shipping</h3>
					<form>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#price">Price 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control" placeholder="Acceptable: $100.99">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#quantity">Quantity 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control" placeholder="Acceptable: 1200">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group"> 
							<label>
								<a href="#" data-toggle="modal" data-target="#shipping">Shipping 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control" placeholder="Acceptable: $4.00">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group">
							<label>Earnings </label> 
							<input type="text" class="form-control" disabled>
						</div>
						<div class="input-group">
							<label>Shipping time </label> 
							<div class="form-check-label">
							  <span><input class="form-check-input" type="checkbox"> 5-10</span>
							  <span><input class="form-check-input" type="checkbox"> 7-14</span>
							  <span><input class="form-check-input" type="checkbox"> 10-15</span>
							  <span><input class="form-check-input" type="checkbox"> 14-21</span>
							  <span><input class="form-check-input" type="checkbox"> 21-28</span>
							  <div><span><input class="form-check-input" type="checkbox"> other :</span></div>
								<div class="min_estimate_div">
									<div class="as1">Min estimate
										<div class="input-group min_estimate"> 
											<input type="text" class="form-control">
											<div class="input-group-append">
												<span class="input-group-text"><i class="fa fa-pencil"></i></span>
											</div>
										</div>
									</div>
									<div class="as2">Max estimate
										<div class="input-group min_estimate"> 
											<input type="text" class="form-control">
											<div class="input-group-append">
												<span class="input-group-text"><i class="fa fa-pencil"></i></span>
											</div>
										</div>
									</div>
								</div>
							  
							</div>
						</div>
					</form>
					<p class="customize_choosen">Customize choosen price for shipping countries</p>
				</div>
				
			</div> 
		
			<div class="shipping_info_section">
				<div class="inventory_section bg_grey">
					<h3>Logistics Information</h3>
					<form>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#declared_name">Declared name 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#declared_local_name">Declared local name 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#pieces_included">Pieces included 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#package_length">Package length 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#package_width"> Package width
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#package_height ">Package height 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group"> 
							<label>
								<a href="#" data-toggle="modal" data-target="#package_weight">Package weight 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#country_of_origin">country_of_origin 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#custom_hs_code">Custom HS code 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#custom_declared_value">custom_declared_value 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#contains_powder">contains_powder 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#contains_liquid">Contains liquid 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#contains_battery">Contains battery 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control">
							<div class="input-group-append">
								<span class="input-group-text"><i class="fa fa-pencil"></i></span>
							</div>
						</div>
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#contains_metal">Contains metal 
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="text" class="form-control">
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
					<li class="nav-item"><a class="nav-link nav_link_tabs <?= $i==0?'active':''?>" href="#a_<?=$category['id']?>" data-toggle="tab"><?=$category['category']?></a></li> 
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
				
				<div class="shipping_info_section">
					<div class="border summary_section bg_grey">
						<h4>Product variations</h4>
						<div class="row product_variations_heading">
							<div class="col-md-1  product_variations_size">
								<h5>Size</h5> 
							</div>     
							<div class="col-md-1  product_variations_color">
								<h5>Color</h5>  
							</div>     
							<div class="col-md-3  product_variations_unique_id">
								<h5>Unique Id (SKU)</h5>  
							</div>     
							<div class="col-md-2  product_variations_price">
								<h5>Price</h5>  
							</div>     
							<div class="col-md-2  product_variations_quantity">
								<h5>Quantity</h5>  
							</div>     
							<div class="col-md-1  product_variations_earnings">
								<h5>Earnings</h5> 
							</div>     
							<div class="col-md-2  product_variations_logistucs">
								<h5>Logistics</h5> 
							</div>     
						</div>
						
						<div class="row product_variations" id="add-variations">
							     
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
								<input type="text" class="form-control" placeholder="Acceptable: $19.00">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#brand">Brand
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" class="form-control" placeholder="Acceptable: Nike">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#upc">UPC 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" class="form-control" placeholder="Acceptable: 716393133224">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group"> 
								<label>
									<a href="#" data-toggle="modal" data-target="#max_quantity"> Max Quantity 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" class="form-control" placeholder="Acceptable: 100">
								<div class="input-group-append">
									<span class="input-group-text"><i class="fa fa-pencil"></i></span>
								</div>
							</div>
							<div class="input-group">
								<label>
									<a href="#" data-toggle="modal" data-target="#landing_page_url"> Landing Page URL 
									<i class="fa fa-question-circle"></i></a>
								</label>
								<input type="text" class="form-control" placeholder="Acceptable: http://www.amazon.com/gp/product/B008PE00DA/ref=s9_simh_gw_p193_d0_i3?ref=wish">
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
					<p class="warring_red">You are missing the product name</p>
					<div class="button_wr">
						<button type="button" class="btn btn-primary">Clear</button>   
						<button type="button" class="btn btn-primary">Submit</button>   
					</div>
				</div>
			</div>  
		 
		</div>
	</div>
</section>
<!--<script src="<?= base_url('assets/bootstrap-select-1.12.1/js/bootstrap-select.min.js') ?>"></script>-->
<script>

currentCategoryId = 0;
sizeArr = [];
colorArr = [];

colorPHPArr = '<?php echo json_encode($colorArr) ?>';
colorPHPArr = jQuery.parseJSON(colorPHPArr);

LastSizeKey = '';
LastSizeText = '';
LastColorKey = '';
LastColorText = '';

filteredSizeArr = '';
filteredColorArr = '';



$('.size_id').on('click',function(){

	var size_id = $(this).val();
	//alert(size_id);
	var size_text = $(this).data('size_text');
	var property = $(this).prop('checked');
	if(property==true)
	{
		 

 
		var thisCurrentCategoryId = $(this).data('category_id');
		if(currentCategoryId != thisCurrentCategoryId)
		{
			sizeArr = [];
			$('.category_identity_'+currentCategoryId).prop('checked',false);
			currentCategoryId = thisCurrentCategoryId;
		}
		sizeArr[size_id] = size_text;
		LastSizeKey = size_id;
		LastSizeText = size_text;
		$('.nav_link_tabs').on('click',function(){
        
            colorArr.length = 0;
            sizeArr.splice(size_id);

            makeProductVariation(sizeArr,colorArr);
        });

		
		makeProductVariation(sizeArr,colorArr);
	}else{
        
		$('#add-variations').find('.remove_'+size_id).remove();
		sizeArr.splice(size_id);
        
	}
	
	/* filteredSizeArr = sizeArr.filter(function (el) {
	  return el != null;
	}); */
	
});

$('.color').on('click',function(){
	
	var color_id = $(this).val();
	var color_text = $(this).data('color');
	var property = $(this).prop('checked');
	if(property==true)
	{
		colorArr[color_id] = color_text;
		LastColorKey = color_id;
		LastColorText = color_text;
		makeProductVariation(sizeArr,colorArr);
	}else{
		$('#add-variations').find('.remove_'+color_id).remove();
		colorArr.splice(color_id,1);
	}
	/* filteredColorArr = colorArr.filter(function (el) {
	  return el != null;
	}); */
	
});

alreadyAddedSingleSizeKeys = [];
alreadyAddedSingleColorKeys = [];
function makeProductVariation(sizeArr,colorArr)
{

alert(sizeArr);
	


	var emptySizeArrCheck = true;
	sizeArr.forEach(function(element, i){
		emptySizeArrCheck = false;
	});
	
	var emptyColorArrCheck = true;
	colorArr.forEach(function(element, i){
		emptyColorArrCheck = false;
	});
	
	var alreadyAddedSizeCheck = false;
	alreadyAddedSingleSizeKeys.forEach(function(element, i){
		alreadyAddedSizeCheck = true;
	});
	//alert(alreadyAddedSizeCheck);
	
	var alreadyAddedColorCheck = false;
	alreadyAddedSingleColorKeys.forEach(function(element, i){
		alreadyAddedColorCheck = true;
	});

	var text = '';
	if(!emptySizeArrCheck && !emptyColorArrCheck)
	{
		sizeArr.forEach(function(sizeElement, iSize){
			
			
			
			colorArr.forEach(function(colorElement, iColor){
				
				if(alreadyAddedSizeCheck)
				{
					alreadyAddedSingleSizeKeys.forEach(function(AlreadyElement){
						$('#add-variations').find('.remove_'+AlreadyElement).find('.product_variations_color').html('<span class="color_box" style="background:'+colorPHPArr[colorElement]+';"></span>'
						+'<span class="color_name">'+colorElement+'</span>');
						
						$('#add-variations').find('.remove_'+AlreadyElement).addClass('remove_'+iColor);
						$('#add-variations').find('.remove_'+AlreadyElement).attr('data-color-id',iColor);
					});
					alreadyAddedSingleSizeKeys = [];
					alreadyAddedSingleColorKeys = [];
				}else if(alreadyAddedColorCheck)
				{
					alreadyAddedSingleColorKeys.forEach(function(AlreadyElement){
						$('#add-variations').find('.remove_'+AlreadyElement).find('.product_variations_size').html('<p>'+sizeElement+'</p>');
						$('#add-variations').find('.remove_'+AlreadyElement).addClass('remove_'+iSize);
						$('#add-variations').find('.remove_'+AlreadyElement).attr('data-size-id',iSize);
					});
					alreadyAddedSingleSizeKeys = [];
					alreadyAddedSingleColorKeys = [];
				}else{
					var notAlreadyEntry = true;
					var oldSize = $('#add-variations').find('.remove_'+iSize).each(function(){
							var size__id = $(this).data('size-id');
							var color__id = $(this).data('color-id');
							if(size__id==iSize && color__id==iColor)
							{
								notAlreadyEntry = false;
							}
					});
					if(notAlreadyEntry===true)
					{

						
						
						text = '<div class="row remove_'+iSize+' remove_'+iColor+'" data-size-id="'+iSize+'" data-color-id="'+iColor+'" >'
									+'<div class="col-md-1  product_variations_size">'
										+'<p>'+sizeElement+'</p>'
									+'</div>';
									
						text += 	'<div class="col-md-1  product_variations_color">'
										+'<span class="color_box" style="background:'+colorPHPArr[colorElement]+';"></span>'
										+'<span class="color_name">'+colorElement+'</span>'
									+'</div>';
						
						text += 	'<div class="col-md-3  product_variations_unique_id">'
										+'<div class="input-group">'
											+'<input type="text" class="form-control" placeholder="Acceptable: HSC42">'
											+'<div class="input-group-append">'
												+'<span class="input-group-text"><i class="fa fa-pencil"></i></span>'
											+'</div>'
										+'</div>'
									+'</div>'
									+'<div class="col-md-2  product_variations_price">'
										+'<div class="input-group">'
											+'<input type="text" class="form-control" placeholder="500.00">'
											+'<div class="input-group-append">'
												+'<span class="input-group-text"><i class="fa fa-pencil"></i></span>'
											+'</div>'
										+'</div>'
									+'</div>'
									+'<div class="col-md-2  product_variations_quantity">'
										+'<div class="input-group">'
											+'<input type="text" class="form-control" placeholder="120">'
											+'<div class="input-group-append">'
												+'<span class="input-group-text"><i class="fa fa-pencil"></i></span>'
											+'</div>'
										+'</div>'
									+'</div>'
									+'<div class="col-md-1  product_variations_earnings">'
										+'<div class="form-group">'
											+'<input type="text" class="form-control" placeholder="$453.00" disabled>'
										+'</div>'
									+'</div>'
									+'<div class="col-md-2  product_variations_logistucs">'
										+'<div class="form-check">'
										 +'<label class="form-check-label">'
											+'<input type="radio" class="form-check-input" name="optradio">default'
										  +'</label>'
										+'</div>'
										+'<div class="form-check">'
										  +'<label class="form-check-label">'
											+'<input type="radio" class="form-check-input" name="optradio">custom'
											+'<i class="fa fa-paper-plane" ></i>'
										  +'</label>'
										+'</div>'
									+'</div>'
								 +'</div>';
						//alert(text);
						if(text!='')
						{
                            
							$('#add-variations').append(text);
						}
					}		 
				}		 
			});
		});
	}else if(!emptySizeArrCheck){

		if(LastSizeKey!='' && LastColorKey =='')
		{

			text = '<div class="row remove_'+LastSizeKey+'" data-size-id="'+LastSizeKey+'" data-color-id="">'
						+'<div class="col-md-1  product_variations_size">'
							+'<p>'+LastSizeText+'</p>'
						+'</div>';
						
			text += 	'<div class="col-md-1  product_variations_color">'
							
						+'</div>';
			
			text += 	'<div class="col-md-3  product_variations_unique_id">'
							+'<div class="input-group">'
								+'<input type="text" class="form-control" placeholder="Acceptable: HSC42">'
								+'<div class="input-group-append">'
									+'<span class="input-group-text"><i class="fa fa-pencil"></i></span>'
								+'</div>'
							+'</div>'
						+'</div>'
						+'<div class="col-md-2  product_variations_price">'
							+'<div class="input-group">'
								+'<input type="text" class="form-control" placeholder="500.00">'
								+'<div class="input-group-append">'
									+'<span class="input-group-text"><i class="fa fa-pencil"></i></span>'
								+'</div>'
							+'</div>'
						+'</div>'
						+'<div class="col-md-2  product_variations_quantity">'
							+'<div class="input-group">'
								+'<input type="text" class="form-control" placeholder="120">'
								+'<div class="input-group-append">'
									+'<span class="input-group-text"><i class="fa fa-pencil"></i></span>'
								+'</div>'
							+'</div>'
						+'</div>'
						+'<div class="col-md-1  product_variations_earnings">'
							+'<div class="form-group">'
								+'<input type="text" class="form-control" placeholder="$453.00" disabled>'
							+'</div>'
						+'</div>'
						+'<div class="col-md-2  product_variations_logistucs">'
							+'<div class="form-check">'
							 +'<label class="form-check-label">'
								+'<input type="radio" class="form-check-input" name="optradio">default'
							  +'</label>'
							+'</div>'
							+'<div class="form-check">'
							  +'<label class="form-check-label">'
								+'<input type="radio" class="form-check-input" name="optradio">custom'
								+'<i class="fa fa-paper-plane" ></i>'
							  +'</label>'
							+'</div>'
						+'</div>'
					 +'</div>';
			alreadyAddedSingleSizeKeys.push(LastSizeKey);
			LastSizeKey = '';
			LastSizeText = '';
		}
		if(text!='')
		{

			$('#add-variations').append(text);
		}
	}else if(!emptyColorArrCheck){
		
		if(LastSizeKey=='' && LastColorKey!='')
		{
			text = '<div class="row remove_'+LastColorKey+'" data-size-id="" data-color-id="'+LastColorKey+'">'
						+'<div class="col-md-1  product_variations_size">'
							
						+'</div>'
						+'<div class="col-md-1  product_variations_color">'
							+'<span class="color_box" style="background:'+colorPHPArr[LastColorText]+';"></span>'
							+'<span class="color_name">'+LastColorText+'</span>'
						+'</div>'
						+'<div class="col-md-3  product_variations_unique_id">'
							+'<div class="input-group">'
								+'<input type="text" class="form-control" placeholder="Acceptable: HSC42">'
								+'<div class="input-group-append">'
									+'<span class="input-group-text"><i class="fa fa-pencil"></i></span>'
								+'</div>'
							+'</div>'
						+'</div>'
						+'<div class="col-md-2  product_variations_price">'
							+'<div class="input-group">'
								+'<input type="text" class="form-control" placeholder="500.00">'
								+'<div class="input-group-append">'
									+'<span class="input-group-text"><i class="fa fa-pencil"></i></span>'
								+'</div>'
							+'</div>'
						+'</div>'
						+'<div class="col-md-2  product_variations_quantity">'
							+'<div class="input-group">'
								+'<input type="text" class="form-control" placeholder="120">'
								+'<div class="input-group-append">'
									+'<span class="input-group-text"><i class="fa fa-pencil"></i></span>'
								+'</div>'
							+'</div>'
						+'</div>'
						+'<div class="col-md-1  product_variations_earnings">'
							+'<div class="form-group">'
								+'<input type="text" class="form-control" placeholder="$453.00" disabled>'
							+'</div>'
						+'</div>'
						+'<div class="col-md-2  product_variations_logistucs">'
							+'<div class="form-check">'
							 +'<label class="form-check-label">'
								+'<input type="radio" class="form-check-input" name="optradio">default'
							  +'</label>'
							+'</div>'
							+'<div class="form-check">'
							  +'<label class="form-check-label">'
								+'<input type="radio" class="form-check-input" name="optradio">custom'
								+'<i class="fa fa-paper-plane" ></i>'
							  +'</label>'
							+'</div>'
						+'</div>'
					 +'</div>';
			alreadyAddedSingleColorKeys.push(LastColorKey);
			LastColorKey = '';
			LastColorText = '';
		}
		if(text!='')
		{
			$('#add-variations').append(text);
		}
	}
	//console.log(sizeArr);
	//console.log(colorArr);
}
</script>