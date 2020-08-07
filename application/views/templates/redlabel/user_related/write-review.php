<section class="profile_section sidebar_bg rating_merchant_ww">
    <?php $this->load->view('templates/redlabel/user_related/sidebar_user'); ?>
	<div class="col-md-9 profile_right">
	    <div class="page_title"><h3>Review & Ratings Product</h3></div> 
		<form method="POST">
			<div class="col-md-9 shipping_info_section single_review">
				<div class="single_product_review_img row">   
					<div class="col-md-12"><img src="<?=WEB_URL?>images/ak_1.png"/><h5>Review & Ratings Product Name</h5></div>
				</div>			
			    <div class="form-group rate_product">
					<label>Rate this Product :</label>
					<ul>
						<li><a href="javascript:void(0);" id="revStr_1" title="1 star" data-star_count="1" class="revStr"><i class="fa fa-star"></i></a></li> 
						<li><a href="javascript:void(0);" id="revStr_2" title="2 star" data-star_count="2" class="revStr"><i class="fa fa-star"></i></a></li> 
						<li><a href="javascript:void(0);" id="revStr_3" title="3 star" data-star_count="3" class="revStr"><i class="fa fa-star"></i></a></li> 
						<li><a href="javascript:void(0);" id="revStr_4" title="4 star" data-star_count="4" class="revStr"><i class="fa fa-star"></i></a></li> 
						<li><a href="javascript:void(0);" id="revStr_5" title="5 star" data-star_count="5" class="revStr"><i class="fa fa-star"></i></a></li> 
						<li><a href="javascript:void(0);" class="count_rating">0.0</a></li> 
					</ul>
				</div> 
				<div class="clearfix"></div>
				<div class="form-group">
					<label>Review this Product :</label>
					<textarea name="review" class="form-control" rows="5" placeholder="Product Review" required></textarea>
				</div>
				<div class="form-group">
					<input type="hidden" name="rating" id="product_rating" value=""/>
					<button type="submit" name="save" class="btn btn-danger">Submit</button>
				</div>
			</div>
		</form>
	</div>
</section>
<script>
	
$('form').on('submit',function(){
	if($('#product_rating').val()=='')
	{
		alert('Please select rating first!');
	}
});
</script>