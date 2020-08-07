<?php
if ($this->session->flashdata('result_delete')) {
    ?> 
    <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div> 
    <?php
}

$uri3=$this->uri->segment(3); 
?>
<section class="profile_section sidebar_bg rating_merchant_ww">
    <?php $this->load->view('_parts/sidebar_merchant') ?>
	<div class="profile_right" id="page-content-wrapper">
	    <div class="col-md-5 col-sm-12 col-lg-6 col-xl-6 category_ww"> 
			<div class="dropdown">
				<button type="button" class="btn btn-primary dropdown-toggle category" data-toggle="dropdown">
					All Category
				</button>
				<div class="dropdown-menu">
					<?php foreach($vendor_categories as $category){ ?>
						<a class="dropdown-item" href="#" data-category_id="<?=$category['id']?>"><?=$category['name']?></a>
					<?php } ?>
				</div>
				
				<a href="<?=LANG_URL.'/vendor/add/product/'.$uri3?>"><button type="button" class="btn btn-primary add_product"><i class="fa fa-plus"></i> Add New Product</button></a>
			    &nbsp;&nbsp;&nbsp;
			    
			    <a href="<?=LANG_URL.'/vendor/add/bulk/'.$express_required?>">
			    <button type="button" class="btn btn-primary add_product">
			    <i class="fa fa-plus"></i> Add Bulk Products</button></a>

			    
			
			</div>
		</div>
		<div class="col-md-7 col-sm-12 col-lg-6 col-xl-6 ic_icon">

			<?php if($status['express_approve_status']){?>
				<?php
					$status=$status['express_approve_status'];
					if($status=='ACCEPT'){?>
						<span class="badge badge-success" style="padding:7px; ">Nureso express request accepted !</span>
				<?php }	?>
				<?php
					if($status=='REJECT'){?>
						<span class="badge badge-danger" style="padding:7px; ">Nureso express request rejected !</span>
				<?php }	?>
				<?php
					if($status=='PENDING'){?>
						<span class="badge badge-warning" style="padding:7px; ">Nureso express request is under review !</span>
				<?php }	?>
				<?php
					if($status=='NONE'){?>
						<a href="<?=LANG_URL.'/vendor/express'?>"><button class="btn btn-primary all_pds">Join Nureso Express</button></a> 
				<?php }	?>

					

			<?php }  ?>
		    <!-- <a href="#"><button class="btn btn-primary all_pds">Show Express Products</button></a>  -->
		    
		    <a href="#" title=""><img src="<?=WEB_URL?>images/ic_1.png"/></a>  
		    <a href="#" title=""><img src="<?=WEB_URL?>images/ic_2.png"/></a>  
		</div>
		<div class="clearfix"></div>
		<div class="col-md-12 all_products">
			<div class="profile_section wishlist_products">
				<?php
				if (!empty($products)) {
					foreach($products as $key) :
					$id=base64_encode($key['product_id']);
					$productName = escape_product_name($key['product_name']);
					?>
					<div class="col-md-4 col-sm-4 col-lg-3 col-xl-3 product_ak wow fadeInUp">
						<div class="row">
							<a href="<?=LANG_URL.'/products-details/'.$productName.'/'.$id?>"><div class="porduct_img"><img src="<?=UPLOAD_URL.'product-images/'.$key['image']?>"/></div></a>
							<a href="<?=LANG_URL.'/vendor/edit/product/'.$id?>" title="edit" class="product_edit" data-product_id="<?=$id?>"><i class="fa fa-pencil"></i></a>
							<a href="javascript:void(0);" title="close" class="wishlist_close delete_vendor_product" data-product_id="<?=$id?>"><i class="fa fa-close"></i></a>
							<div class="product_dsp">
								<span><?=$key['product_name']?></span>
								<a href="<?=LANG_URL.'/products-details/'.$productName.'/'.$id?>"><button class="product_btn">£ <?=$key['price']?></button></a>
							</div>
						</div>
					</div>
				<?php  endforeach; 
				  }else{ ?>
					<br><h1 style="color: #ccc;" class="no-product-found">No Product Found !</h1>
				<?php } ?>
			</div>
		</div>
	</div>
</section>
<script>
var deleteVendorProductURL = '<?=LANG_URL.'/vendor/deleteVendorProduct'?>';
$('.delete_vendor_product').on('click',function(){
	if (!confirm('Are you sure for delete this product?')) return false;
	anchoreThis = $(this);
	var product_id = $(this).data('product_id');
	$.ajax({
		type: "POST",
		url: deleteVendorProductURL,
		data: {product_id: product_id},
		//dataType: 'json',
		success: function(response){
			if(response=='true')
			{
				anchoreThis.parents('.product_ak').remove();
			}else{
				alert('An error occured.Please try again!');
			}
		}
	});
});
</script>