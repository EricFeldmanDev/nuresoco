<style>
.rating_star_ul li i::after {
    background: url(<?=WEB_URL.'images/star.png'?>);
}
</style>
<?php
if ($this->session->flashdata('result_delete')) {
    ?> 
    <div class="alert alert-success"><?= $this->session->flashdata('result_delete') ?></div> 
    <?php
}
?>
<section class="profile_section sidebar_bg rating_merchant_ww">
    <?php $this->load->view('_parts/sidebar_merchant') ?>
	<div class="profile_right" id="page-content-wrapper">
	    <div class="review_search_section">
			<div class="col-md-6 rw_rcrh">
				<!--
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search product...">
					<div class="input-group-append">
						<span class="input-group-text"><i class="fa fa-search" aria-hidden="true"></i></span>
					</div>
				</div> 
				-->
		    </div>	
		</div>	

	    <div class="review_rt_section">
			<div class="container">
				<div class="col-md-8 as_rw">
					<div class="row">
						<div class="bg_white rating_w">
							<div class="row"> 
								<div class="col-md-6 rating row">  
									<h4 class="bold">Rating & Reviews</h4> 
									<p><span><?=$vendorAvgReviews['avg_rating']?></span> out of 5</p>
								</div>
								<div class="col-md-6 rating_star">
									<ul class="rating_star_ul">
									<li><i class="star5"></i><div class="rating_star_bg"><div class="progress_ak star_5"></div></div></li> 
									<li><i class="star4"></i><div class="rating_star_bg"><div class="progress_ak star_4"></div></div></li> 
									<li><i class="star3"></i><div class="rating_star_bg"><div class="progress_ak star_3"></div></div></li> 
									<li><i class="star2"></i><div class="rating_star_bg"><div class="progress_ak star_2"></div></div></li> 
									<li><i class="star1"></i><div class="rating_star_bg"><div class="progress_ak star_1"></div></div></li> 
									</ul>
									<!--
									<ul class="rating_star_ul">
									<?php for($i=5;$i>0;$i--){ ?>
										<li>
											<i class="star<?=$i?>"></i>
											<div class="rating_star_bg">
												<?php
													$widthPercentage = 0;
													if(isset($vendorAvgReviews['eachPercentage'][$i]))
													{
														$widthPercentage = $vendorAvgReviews['eachPercentage'][$i];
													}
												?>
												<div class="progress_ak" style="width:<?=@$widthPercentage?>%;"></div>
											</div>
										</li>
									<?php } ?>
									</ul>
									-->
								</div>
							</div>
						</div>
					</div> 
				</div> 
				
				<div class="col-md-4 as_rw as_rw2">
					<ul class="sk_wrapp_ul">
						<li><span class="rating_sort" href="javascript:void(0);" data-toggle="dropdown">Sort <i class="fa fa-caret-down"></i></span>
						 <div class="dropdown-menu sort_drop_down">
							<a class="dropdown-item" data-filter-stars='all' href="javascript:void(0);">
								All Stars
							</a>
							<a class="dropdown-item" data-filter-stars='5' href="javascript:void(0);">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</a>
							<a class="dropdown-item"  data-filter-stars='4' href="javascript:void(0);">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</a>
							<a class="dropdown-item"  data-filter-stars='3' href="javascript:void(0);">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</a>
							<a class="dropdown-item"  data-filter-stars='2' href="javascript:void(0);">
								<i class="fa fa-star"></i>
								<i class="fa fa-star"></i>
							</a>
							<a class="dropdown-item"  data-filter-stars='1' href="javascript:void(0);">
								<i class="fa fa-star"></i>
							</a>
						  </div>
						</li>
						<!--<li><a class="sk_wrapp_link" href="#">Store</a></li>-->
					</ul>		
				</div>
			</div>
        </div>

    <div class="clearfix"></div>

		<div class="reviw_section rating_merchant_section">
			<div class="container">
				<div class="reviews_as row" id="vendor_review_section">
					<?php
					if (!empty($vendor_reviews)) {
						foreach($vendor_reviews as $vendor_review){ ?>
						<div class="col-md-6 col-sm-6 col-lg-4 col-xl-4">
							<div class="col-md-12 review_post">
								<h6 title="<?=$vendor_review['name']?>"><?=strlen($vendor_review['name'])>21?substr($vendor_review['name'],0,21).'...':$vendor_review['name']?><br>
								<?php for($i=0;$i<(int)$vendor_review['rating'];$i++){ ?>
									<i class="fa fa-star"></i>
								<?php } ?>
								</h6>
								<small><?= formate_date($vendor_review['modify_on'])?><br>
								<i class="fa fa-heart"></i>
								</small>
								<p>
									<?=strlen($vendor_review['review'])>190?substr($vendor_review['review'],0,190).'...'.'<a href="javascript:void(0);" class="view-rating" data-rater-name="'.$vendor_review['name'].'">MORE</a>':$vendor_review['review']?>
									<span class="product_full_review" style="display:none;"><?=$vendor_review['review']?></span>
									<span class="product_modify_on" style="display:none;"><?=formate_date($vendor_review['modify_on'])?></span>
									<span class="product_stars_html" style="display:none;">
										<?php for($i=0;$i<(int)$vendor_review['rating'];$i++){ ?>
											<i class="fa fa-star"></i>
										<?php } ?>
									</span>
								</p>
							</div> 
						</div> 
					<?php } ?>
					<?php if($vendorReviewsCount>$vendorReviewLimit){ ?>
						<div class="row load_more_seller_products">
							<div class="clearfix"></div>
							<input type="button" id="loadMore" value="Load More" class="btm btn-primary"/>
						</div>
					<?php } }else{ ?>
						<br><h1 style="color: #ccc;">No Review Found!</h1>
					<?php } ?>
				</div>
			</div>
		</div>
	</div>
</section>
<script>
$('.reviews_as').on('click','.view-rating',function(){
	var name = $(this).data('rater-name');
	var product_full_review = $(this).parent('p').find('.product_full_review').html();
	var product_stars_html = $(this).parent('p').find('.product_stars_html').html();
	var product_modify_on = $(this).parent('p').find('.product_modify_on').html();
	$('#more_modal').find('#description').html(product_full_review);
	$('#more_modal').find('#rater-name').html(name);
	$('#more_modal').find('#stars-html').html(product_stars_html);
	$('#more_modal').find('#modify-on').html(product_modify_on+'<br/><i class="fa fa-heart"></i>');
	$('#more_modal').modal('toggle');
});
$('.dropdown-item').on('click',function(){
	filter_stars = $(this).data('filter-stars');
	offset = 0;
	filterNow('sorting');
});	
<?php if(isset($vendor_reviews[0])){ ?>
	var filterSellerReviewsURL = '<?=base_url('home/filterSellerReviews/'.base64_encode($vendor_reviews[0]['vendor_id']));?>';
	var filter_stars = 'all';
	var offset = 0;
	var limit = <?=$vendorReviewLimit?>;
	$('#vendor_review_section').on('click','#loadMore',function(){
		
		offset = limit + offset;
		filterNow('loading');
	});

	function filterNow(search_type)
	{	
		$.ajax({
			url: filterSellerReviewsURL,
			type: "POST",
			data: {'offset': offset, 'filter_stars':filter_stars, 'callfrom':'vendor'},
			//dataType: 'json',
			success: function (response) {
			  if(response != '')
			  {
				$('#vendor_review_section').find('.load_more_seller_products').remove();
				setTimeout(function() {
				  $('#vendor_review_section').removeClass('ajax_load');
				  if(response!='all_products_loaded')
				  {
					if(search_type=='loading')
					{
						$('#vendor_review_section').append(response);
					}else if(search_type=='sorting'){
						$('#vendor_review_section').html(response);
					}
				  }
				}, 0);
			  }else{
				$('#vendor_review_section').html('');
			  }
			},
		});
	}
<?php } ?>
</script>