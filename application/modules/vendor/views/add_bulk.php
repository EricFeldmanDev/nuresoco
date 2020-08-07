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
	<form method="POST" enctype="multipart/form-data">
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
						<h3>Upload Bulk Products</h3>
						
						<div class="input-group">
							<label>
								<a href="#" data-toggle="modal" data-target="#product_name">Upload Products
								<i class="fa fa-question-circle"></i></a>
							</label>
							<input type="file" name="upload_excel"  required>
							
						</div>
						
						
					</div>
					
					
				</div>
			
			
				
			
				<div class="margin_auto apparal_section sizing_apparel bg_grey">
					
					
					
					
					<div class="border summary_section bg_grey">
						<!--
						<h4>Summary</h4> 
						<p class="warring_red">You are missing the product name</p>
						-->
						<div class="button_wr">
							   
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

	

//$('button[type=submit], input[type=submit]').prop('disabled',true);
</script>
