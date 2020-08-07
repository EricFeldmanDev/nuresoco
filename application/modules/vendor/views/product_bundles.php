<style>
	.bundle_controls{display:flex; justify-content: center; align-items: center;}
	.bundle_control_item{text-align: center; display: flex; flex-direction: column; justify-content: center; margin: 0 20px; align-items: center;}
	.bundle_control_item p{font-weight: bold; font-size: 0.9em; margin-top: 10px;}
	.control_img{border: 1px solid #ddd; border-radius: 5px; width: 100px; height: 100px; padding-top: 11px; cursor: pointer;}
	.control_img:hover{box-shadow: 0 6px 10px rgba(0,0,0,.14), 0 1px 18px rgba(0,0,0,.12), 0 3px 5px rgba(0,0,0,.2);}	
	.bundle_images{display:flex; flex-wrap: wrap; width: calc(100% - 80px);cursor: pointer;}
	.image_container{width:50%; padding: 2px;}
	.express_container{width:80px; text-align: right;display:flex;flex-direction: column;}
	@media(max-width: 767px) {
		.control_img{width: 80px; height: 80px;}
		.control_img img{width: 80%;}
		.bundle_control_item{margin: 0 10px;}
	}
</style>
<section class="profile_section sidebar_bg rating_merchant_ww">
    <?php $this->load->view('_parts/sidebar_merchant') ?>
	<div class="profile_right" id="page-content-wrapper">
	    <div class="col-md-12"> 
			<div class="bundle_controls">
				<div class="bundle_control_item">
					<div class="control_img create_bundle"><img src="<?=base_url('assets/web/images/dashboard/12.png')?>"/></div>
					<p>Add bundle</p>
				</div>
				<div class="bundle_control_item">
					<div class="control_img edit_bundle"><img src="<?=base_url('assets/web/images/dashboard/14.png')?>"/></div>
					<p>Edit</p>
				</div>
				<div class="bundle_control_item">
					<div class="control_img delete_bundles"><img src="<?=base_url('assets/web/images/dashboard/13.png')?>"/></div>
					<p>Delete</p>
				</div>
			</div>
		</div>		
		<div class="clearfix"></div>
		<div class="col-md-12 all_products">
			<div class="profile_section wishlist_products row">
				<?php
				if (!empty($products)) {	
					//var_dump($products);
					$rows = ''; $item = ''; $main_bundle = 0; $product_ids = []; $express = ''; $verified = ''; $category_id=0;
					foreach ($products as $key => $row) {
						$product_ids = [base64_encode($row['product_id'])]; $express = ''; $verified = '';
						if($row['nureso_express_status']== '1') 
							$express = '<img src="'.LANG_URL.'/assets/web/images/prd_1.png" class="express_img"/>';
						if($row['is_product_verified']== '1')
							$verified = '<img src="'.LANG_URL.'/assets/web/images/prd_3.png" class="express_img express_img1"/>';
						$category_id = $row['category_id'];
						$rows .= '<div class="col-sm-12 col-md-6 col-lg-3 col-xl-3 filter wow fadeInUp" style="visibility: visible; animation-name: fadeInUp;">
							<div class="row">
								<div class="filter-item" data-id="'.base64_encode($row['main_bundle']).'">
									<div class="d-flex">
										<div class="bundle_images" data-href>
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
											<div class="mt-auto"><label><input type="radio" name="select"> Select</label></div>
										</div>
									</div>
									<input type="hidden" name="product_ids" value="'.implode(',', $product_ids).'"/>
									<input type="hidden" name="category_id" value="'.$category_id.'"/>
								</div>
							</div>
						</div>';
					}
					echo $rows;
				}else{ ?>
					<br><h3 style="color: #ccc;" class="no-product-found">No Product bundles Found !</h3>
				<?php } ?>
			</div>
		</div>
	</div>
</section>
<div class="modal merchant_modal fade" id="mdlCreateBundle">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span>Create</span> Product Bundle</h4>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <div class="modal-body"> 
				<input type="hidden" id="edit_id" value="0"/>
				<div class="section">
					<h5>Setup</h5> 
					<div class="content">Choose a product category you want to create a bundle for and then select the main product bundle with other products you want in that main bundle.</div> 
				</div> 
				<div class="section"> 
				    <h5>Choose a product category:</h5> 
					<select class="form-control" id="category">
						<?php if($categories) {
							foreach($categories as $row) {
								foreach($row['info'] as $item)
									echo '<option value="'.$item['category_id'].'">'.$item['name'].'</option>';									
							}
						}?>					
					</select>
				</div> 
				<div class="section"> 
				    <h5>Select a main product bundle:</h5> 
					<select class="form-control selectpicker" id="main_bundle" data-live-search="true" data-size="8" data-width="100%"></select>
				</div> 
				<div class="section"> 
				    <h5>Select 3 other products:</h5> 
					<select class="form-control selectpicker" id="product_bundles" multiple data-live-search="true" data-size="8" data-width="100%"></select>					
				</div> 
            </div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary btn_create">Save</button>
			</div>
        </div>
	</div>
</div>
<script>
	var main_bundle = '', product_bundles = [];
	$(document).on('click', '.create_bundle', function() {		
		main_bundle = '', product_bundles = [];
		$('.modal-title').children('span').text('Create');
		$('#edit_id').val(0);
		$('#mdlCreateBundle').modal('show');
	});

	$(document).on('click', '.edit_bundle', function() {
		var radio = $('input[name="select"]:checked');
		if(radio.length==0){
			alert('Please select a product bundle to edit');
			return;
		}
		var parent = radio.parents('.filter-item'),
			id = parent.data('id'),
			category_id = parent.find('input[name="category_id"]').val(),
			product_ids = parent.find('input[name="product_ids"]').val();
		$('#category').val(category_id);
		main_bundle = '', product_bundles = [];
		product_ids = product_ids.split(',');
		for(var i=0; i<product_ids.length; i++) {
			if(i==0) {
				main_bundle = product_ids[i];
			} else {
				product_bundles.push(product_ids[i]);
			}
		}
		$('#category').trigger('change');
		$('.modal-title').children('span').text('Edit');
		$('#edit_id').val(id);
		$('#mdlCreateBundle').modal('show');
	});

	$(document).on('click', '.thumb-imgs a', function() {
		var parent = $(this).parent();
		var src = $(this).children('img').attr('src');
		if(src.indexOf('100x100')>-1) {
			src = src.replace('100x100', '300x300').replace('small100', 'small300');
		}
		parent.siblings('.main-img').children('img').attr('src', src);
	});

	$(document).on('click', '[data-href]', function() {	
		var parent = $(this).parents('.filter-item');
		parent.find('input[type="radio"]').trigger('click');
	});

	$(document).on('click', 'input[name="main_bundle"]', function() {
		var parent = $(this).parents('.filter-item'),
			product_id = parent.data('id');
		$.ajax({
			type: "POST",
			url: '<?=LANG_URL.'/vendor/set_main_product_bundle'?>',
			data: {product_id: product_id},
			dataType: 'json',
			success: function(res){
				if(res.success==false) {
					alert(res.error_msg);
				} else {
					location.reload();
				}
			}, error: function() {
				alert('An error occured.Please try again!');
			}
		});
	});

	$(document).on('click', '.delete_bundles', function() {
		var id = '';
		var radio = $('input[name="select"]:checked');
		if(radio.length>0){
			var parent = radio.parents('.filter-item'),
				main_bundle = parent.data('id');			
			id = main_bundle;
		}
		if(id != '') {
			var msg = confirm('Are you sure to delete?');
			if(!msg) return;					
			$.ajax({
				type: "POST",
				url: '<?=LANG_URL.'/vendor/delete_product_bundle'?>',
				data: {id: id},
				dataType: 'json',
				success: function(res){
					if(res.success==false) {
						alert(res.error_msg);
					} else {
						location.reload();
					}
				}, error: function() {
					alert('An error occured.Please try again!');
				}
			});		
		} else {
			alert('Please select product bundles to delete.');
		}
	});
	
	$('#category').on('change', function() {
		var id = $(this).val();
		$.ajax({
			type: "POST",
			url: '<?=LANG_URL.'/vendor/get_products_by_category'?>',
			data: {category_id: id},
			dataType: 'json',
			success: function(res){				
				if(res.success==false) {
					alert(res.error_msg);
				} else {				
					console.log(res);
					$('#main_bundle').html();
					$('#product_bundles').html();
					if(res.products) {
						var html1 = ''; html2 = '';
						var selected1 = ''; selected2 = '';
						for(var i=0;i<res.products.length;i++) {
							if(main_bundle == res.products[i].product_id) {
								selected1 = 'selected';
							} else {
								selected1 = '';
							}
							if(product_bundles.length>0 && product_bundles.includes(res.products[i].product_id)) {
								selected2 = 'selected';
							} else {
								selected2 = '';
							}
							var content = "<img src='" + res.products[i].image + "' height='50' /> " + res.products[i].product_name;
							html1 += '<option value="'+ res.products[i].product_id + '" data-content="' + content + '" title="' + res.products[i].real_name + '" '+ selected1 + '>' + res.products[i].product_name + '</option>';
							html2 += '<option value="'+ res.products[i].product_id + '" data-content="' + content + '" title="' + res.products[i].real_name + '" '+ selected2 + '>' + res.products[i].product_name + '</option>';
						}						
						$('#main_bundle').html(html1);
						$('#product_bundles').html(html2);
						$('#main_bundle').selectpicker('refresh');
						$('#product_bundles').selectpicker('refresh');
					}
				}
			}, error: function() {
				alert('An error occured.Please try again!');
			}
		});		
	});

	var create_url = '<?=LANG_URL.'/vendor/create_product_bundle'?>',
		update_url = '<?=LANG_URL.'/vendor/update_product_bundle'?>'
	$('.btn_create').on('click', function() {
		var product_ids = $('#product_bundles').val(),
			main_bundle = $('#main_bundle').val();		
		if(!main_bundle) {
			alert('Select a main product bundle');
			return;
		}
		if(!product_ids || product_ids.length<0) {
			alert('Select products');
			return;
		} else if(product_ids.length>3) {
			alert('Select maximum 3 other products');
			return;
		}				
		var id = $('#edit_id').val(), url = create_url;
		var data = {main_bundle: main_bundle, product_bundles: product_ids.join(',')};
		if(id!=0) {
			url = update_url;
			data.id = id;
		}
		$.ajax({
			type: "POST",
			url: url,
			data: data,
			dataType: 'json',
			success: function(res){
				if(res.success==false) {
					alert(res.error_msg);
				} else {
					location.reload();
				}
			}, error: function() {
				alert('An error occured.Please try again!');
			}
		});
	});

	$('#category').trigger('change');

</script>