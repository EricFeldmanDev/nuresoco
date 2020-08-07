<link href="https://cdn.jsdelivr.net/jquery.slick/1.3.15/slick.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js"></script>
<style>
.rating_star_ul li i::after {
    background: url(<?=WEB_URL.'images/star.png'?>);
}
.alert-success {
    display: inline-block;
    padding: 5px 20px;
    margin: 5px 0px 0px 0px;
}
.alert-danger {
    display: inline-block;
    padding: 5px 20px;
    margin: 5px 0px 0px 0px;
}
#desktop {display:block;}
#mobile {display:none;}
@media screen and (max-width: 687px) {
	#desktop {display:none;}
#mobile {display:block;}
.product_slider .lSSlideOuter {margin:0; padding:0 !important;}
.lSSlideOuter .lSPager.lSGallery {width:100% !important;}
ul.lSPager.lSGallery li {
    height: auto !important;
    width: 70px !important;}
    .lSSlideWrapper.usingCss {height: 320px!important;}
}
.bundle_items{font-size: 1.1rem; font-weight: bold; padding: 0 20px;margin: 10px;}
.filter-item .thumb-imgs{height: 334px;}
</style>
<section class="detialspage_section">	
	<?php if(!empty($vendorProductBundle)){ 	
		echo '<p class="bundle_items">'.(sizeof($vendorProductBundle['product_bundles'])+1).' items in this bundle</p>';			
		function get_item($row, $bundle_id) {
			$id = base64_encode($row['product_id']);
			$productName = escape_product_name($row['product_name']); 
			$item = '<div class="fadeInUp">				
					<div class="filter-item" data-id="'.$id.'">
						<div class="d-flex">
							<div class="thumb-imgs">
								<a href="javascript:">
									<img src="'.get_small_image($row['image'], '100').'">
								</a>';
								foreach($row['products_addition_image'] as $addImag){
									$item .='<a href="javascript:"> 
										<img src="'.get_small_image($addImag['image'], '100').'" width="555" height="320" />
									</a>';
								}
				$item .= '	</div>
							<div class="main-img" data-href="'.base_url('product_bundle-details/'.$productName.'/'.$id.'/'.base64_encode($bundle_id)).'">
								<img src="'.get_small_image($row['image']).'">
							</div>
						</div>
						<div class="d-flex mt-2" data-href="'.base_url('product_bundle-details/'.$productName.'/'.$id.'/'.base64_encode($bundle_id)).'" style="min-height:46px;">
							<span class="p-name block-with-text">'.$row['product_name'].'</span>
							<span class="p-price">£'.$row['price'].'</span>						
						</div>					
						<div class="d-flex mt-2 justify-content-around" style="min-height:23px;">';
							if($row['nureso_express_status']=='1'){
								$item .= '<img src="'.LANG_URL.'/assets/web/images/prd_1.png" class="express_img"/>';
							}
							if($row['is_product_verified']=='1'){
								$item .= '<img src="'.LANG_URL.'/assets/web/images/prd_3.png" class="express_img express_img1"/>';
							}
							if($row['solds']) {
								$item .= '<span class="b-button">'.$row['solds'].'</span>';
							}
				$item .= '		
						</div>
					</div>
				</div>';
			return $item;
		}
		$rows = '<div id="product_section">
					<div class="slider" style="width:100%;">';			
		$rows .= get_item($vendorProductBundle, $bundle_id);		
		if($vendorProductBundle['product_bundles']) {
			foreach($vendorProductBundle['product_bundles'] as $item) {				
				$rows .= get_item($item, $bundle_id);				
			}
		}
		$rows .= '</div></div>';
		echo $rows; ?>
		<script>
			$(document).ready(function() {
				$('.slider').slick({                
					slidesToShow: 4,
					slidesToScroll: 4,
					arrows: false,
					dots: true,
					infinite: false,
					pauseOnHover: true,
					cssEase: 'linear',
					responsive: [{
						breakpoint: 1200,
						settings: {
							slidesToShow: 3,
							slidesToShow: 3
						}
					},{
						breakpoint: 900,
						settings: {
							slidesToShow: 2,
							slidesToShow: 2
						}
					}, {
						breakpoint: 768,
						settings: {
							slidesToShow: 1,
							slidesToScroll: 1
						}
					}]
				});
			});
		</script>	
		<?php	
	}
	?>	
    <div class="container-fluid">
	    <div class="row"> 
			<div class="col-md-6 detials_left prd_slider" id="desktop">
			    <div class="product_slider">
					<div class="item"> 
						
						<ul id="vertical" class="gallery list-unstyled ">
						     <li class='zoom' data-thumb="<?=UPLOAD_URL.'product-images/'.$products_detail['image']?>"> 
								 <img src="<?=UPLOAD_URL.'product-images/'.$products_detail['image']?>" width='555' height='320' />
							 </li>	
						    <?php foreach($products_addition_image as $addImag) :?>
						     <li class='zoom' data-thumb="<?=UPLOAD_URL.'product-images/'.$addImag['image']?>"> 
								 <img src="<?=UPLOAD_URL.'product-images/'.$addImag['image']?>" width='555' height='320' />
							 </li>
						    <?php endforeach; ?>
						</ul>
					</div>
				</div>  
			</div>
            <div class="col-md-6 detials_left prd_slider" id="mobile">
			    <div class="product_slider">
					<div class="item"> 
                    <script>
						$(document).ready(function() {
							
							$('#image-gallery').lightSlider({
								gallery:true,
								item:1,
								thumbItem:9,
								slideMargin: 0,
								speed:500,
								auto:false,
								loop:true,
								onSliderLoad: function() {
									$('#image-gallery').removeClass('cS-hidden');
								}  
							});
						});
					</script>
						<ul id="image-gallery" class="gallery list-unstyled ">
						     <li class='zoom' data-thumb="<?=UPLOAD_URL.'product-images/'.$products_detail['image']?>"> 
								 <img src="<?=UPLOAD_URL.'product-images/'.$products_detail['image']?>" width='555' height='320' />
							 </li>	
						    <?php foreach($products_addition_image as $addImag) :?>
						     <li class='zoom' data-thumb="<?=UPLOAD_URL.'product-images/'.$addImag['image']?>"> 
								 <img src="<?=UPLOAD_URL.'product-images/'.$addImag['image']?>" width='555' height='320' />
							 </li>
						    <?php endforeach; ?>
						</ul>
						
					</div>
				</div>  
			</div>
			<div class="col-md-6 detials_right">
				<h5><span></span> <?=$products_detail['product_name']?></h5> 
				<h6>Price : <span id="price">£ <?=$products_detail['price']?></span></h6>
				<div class="add_and_buy_btn">
				    
					<a class="option" data-goto="<?= base_url('shopping-cart')?>" href="javascript:void(0);" data-id="<?= $products_detail['product_id'] ?>">
						<button type="button" class="btn btn-primary buyNow cursor_disable">Add to cart</button>
					</a>
					<?php if($is_main) { ?>
					<a class="btn-buy-bundle" href="javascript:void(0);" data-id="<?= $product_id ?>" data-bundle="<?=$bundle_id?>">
						<button type="button" class="btn btn-primary">Buy Bundle</button>
					</a>
					<?php } ?>
					<a href="javascript:void(0);" class="add_to_wishlist" data-product_id="<?=base64_encode($products_detail['product_id'])?>">
						<?php
							$blankHeartStyle = '';
							$filledHeartStyle = 'style="display:none;"';
							if(in_array($products_detail['product_id'],$wishlist_Product_ids))
							{
								$blankHeartStyle = 'style="display:none;"';
								$filledHeartStyle = '';
							}
						?>
						<i class="fa fa-heart-o" <?=$blankHeartStyle?>></i>
						<i class="fa fa-heart" <?=$filledHeartStyle?>></i>
					</a>
					<p>Please select size and colour</p>
					<div id="notificator" class="alert" style="display:none;"></div>
					<!--
					<p><i class="fa fa-calendar"></i> <span>Free shipping,</span> 3-4 business days</p>
					-->
					<div class="size_color_drop row">
						<?php if(!empty($products_detail['sizes'])){?>
							<div class="col-md-6 col-sm-6">
								<div class="form-group">
									<select class="form-control" id="selectsize">
										<option value="">Select Size</option>
										<?php foreach($products_detail['sizes'] as $size_id => $size){ ?>
										<option value="<?=$size_id?>"><?=$size?></option>
										<?php } ?>
									</select>
								</div> 
							</div>
						<?php }else{ ?>
							<input type="hidden" class="form-control" id="selectsize" value="no_size_available">
						<?php } ?>
						<?php if(!empty($products_detail['colors'])){?>
							<div class="col-md-6 col-sm-6"> 
								<div class="form-group">
									<select class="form-control" id="selectcolour">
										<option value="">Select Colour</option>
										<?php foreach($products_detail['colors'] as $color_id => $color){ ?>
											<option value="<?=$color_id?>"><?=$color?></option>
										<?php } ?>
									</select>
								</div> 
							</div>
						<?php }else{ ?>
							<input type="hidden" class="form-control" id="selectcolour" value="no_color_available">
						<?php } ?>
					</div>					
					<div class="quantity_ak"><span>Quantity : </span>
						<div class="quantity">
						  <input type="number" id="quantity" min="1" max="350" step="1" value="1" readonly>
						</div>
					</div>
				</div>             
				
				<div class="express_delivery_btn size_color_drop">
				    <?php if($products_detail['nureso_express_status']=='1'){ ?>
					<div class="express_btn_new1">
                        <img src="<?=LANG_URL.'/assets/web/'?>images/prd_1.png"/>
						<div class="express_btn_dsp">
						    <h3>Fast shipping</h3> 
							<p>Get faster shipping on this product. Shipping  5 to 7 days.</p>
						</div>
                    </div>
					<?php } ?>
					<?php if($products_detail['is_product_verified']=='1'){ ?>
 					<div class="express_btn_new verified_product">
                        <img src="<?=LANG_URL.'/assets/web/'?>images/prd_3.png"/>
						<div class="express_btn_dsp">
						    <h3>Verified by Nureso</h3> 
							<p>This product receives great rating from customers</p>
						</div>
                    </div> 
					<?php } ?>
				</div>
				
			</div>  
		</div>  
	</div>
</section>
<section class="tab_section_dtl">
		<div class="tab_ul_tab">
		  <!-- Nav tabs -->
		  <ul class="nav nav-tabs sk_wrapp_ul sk_wrapp_ul_dtl" role="tablist">
			<li class="nav-item">
			  <a class="nav-link active" data-toggle="tab" href="#Overview">Overview</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" data-toggle="tab" id="Description_tab" href="#Description">Description</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" data-toggle="tab" href="#Related">Related</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link tab_rating" data-toggle="tab" href="#Ratings">Ratings</a>
			</li>
			<li class="nav-item">
			  <a class="nav-link" data-toggle="tab" href="#Shipping">Shipping</a>
			</li>
		  </ul>
		</div>
<!-- Tab panes -->
	<div class="tab-content">
	    <div id="Overview" class="Overview tab-pane active">
			<div class="content_tab">
				<section class="rating_and_reviews_section">
					<div class="col-md-6 rating_and_reviews_left">
						<div class="bg_white rating_w">
							<div class="row"> 
								<div class="col-md-6 rating">  
									<?php  //print_r($product_reviews);
									if($product_reviews){
									  $total=array();
									  $i=0;
                                      foreach ($product_reviews as $key => $value) {
                                      	$total[]=$value['rating'];
                                      	$i++;
                                      }
                                      //echo $i;
                                      $m=array_sum($total);
                                      
                                     $finalreview=round($m/$i,2);
                                     }else{
                                     $finalreview='00';
                                     }
									  ?>
									<h4 class="bold">Rating & Reviews</h4> 
									<p><span><?php if($finalreview=='NAN'){ echo '00'; }else{ echo $finalreview; } ?></span> out of 5</p>
								</div>
								<div class="col-md-6 rating_star">  
									<ul class="rating_star_ul">
									<?php for($i=5;$i>0;$i--){ ?>
										<li>
											<i class="star<?=$i?>"></i>
											<div class="rating_star_bg">
												<?php
													$widthPercentage = 0;
													if(isset($productAvgReviews['eachPercentage'][$i]))
													{
														$widthPercentage = $productAvgReviews['eachPercentage'][$i];
													}
												?>
												<div class="progress_ak" style="width:<?=@$widthPercentage?>%;"></div>
											</div>
										</li>
									<?php } ?>
									</ul>
								</div>
								<div class="col-md-12">
									<div class="reviews_as row">
										<?php
										//print_r($product_reviews);
											if (!empty($product_reviews)) { $j=0;
												foreach($product_reviews as $product_review){ ?>
												<div class="col-md-12 col-sm-12 col-lg-12 col-xl-12">
													<div class="col-md-12 review_post">
														<h6 title="<?=$product_review['title']?>"><?=strlen($product_review['title'])>21?substr($product_review['name'],0,21).'...':$product_review['title']?><br>
														<?php for($i=0;$i<(int)$product_review['rating'];$i++){ ?>
															<i class="fa fa-star"></i>
														<?php } ?>
														</h6>
														
														<small><!-- <?= formate_date($product_review['modify_on'])?> -->
                                                         <?php echo get_timeago(strtotime($product_review['created_on']));?>
                                                        <!--  <?php echo date("d", strtotime($product_review['created_on'])).' '.date("M", strtotime($product_review['created_on'])).' '.date("Y", strtotime($product_review['created_on']));?>-->
															<br>
														<i class="fa fa-heart"></i> <?php echo $product_review['name'];?>
														</small>
                                                        <p><img src="<?=LANG_URL?>/assets/check.png"> <span style="color:#59b048">Verified Purchase</span></p>
														<p>
															<?=strlen($product_review['review'])>190?substr($product_review['review'],0,190).'...'.'<a href="javascript:void(0);" class="view-rating" data-rater-name="'.$product_review['name'].'">MORE</a>':$product_review['review']?>
															<span class="product_full_review" style="display:none;"><?=$product_review['review']?></span>
															<span class="product_modify_on" style="display:none;"><?=formate_date($product_review['modify_on'])?></span>
															<span class="product_stars_html" style="display:none;">
																<?php for($i=0;$i<(int)$product_review['rating'];$i++){ ?>
																	<i class="fa fa-star"></i>
																<?php } ?>
															</span>
														</p>
													</div> 
												</div> 
											<?php if($j==1){break;} $j++; } ?>
											<div class="all_review_btn">
												<a href="javascript:void(0);"><button type="button" class="btn btn-primary view_all_review">View All Review</button></a>
											</div>
											<?php }else{ ?>
												<br>
												<div class="col-md-12">
												    <h1 style="color: #ccc;">No Review Yet!</h1>
												</div>
											<?php } ?> 
									</div>
								</div>
							</div>
						</div>
						
						<div class="bg_white similar_w">
							<div class="row"> 
								<div class="col-md-12">  
									<h4 class="bold">Similar Product Bundles</h4>
									<div id="product_section">
									<?php if($relatedProductBundles) {
										$rows = '';
									foreach($relatedProductBundles as $row){ 										
										$id = base64_encode($row['main_bundle']);
										$product_id = base64_encode($row['product_id']);
										$productName = escape_product_name($row['product_name']); 
										$product_ids = [$product_id]; $express = ''; $verified = '';
										if($row['nureso_express_status']== '1') 
											$express = '<img src="'.LANG_URL.'/assets/web/images/prd_1.png" class="express_img"/>';
										if($row['is_product_verified']== '1')
											$verified = '<img src="'.LANG_URL.'/assets/web/images/prd_3.png" class="express_img express_img1"/>';				
										$rows .= '<div class="col-sm-12 col-md-6 col-lg-6 col-xl-4 filter wow fadeInUp" title="'.$row['product_name'].'">
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
															<div class="mt-auto"><button class="btn btn-primary btn-buy-bundle">Buy Bundle</button></div>
														</div>
													</div>
													<input type="hidden" name="product_ids" value="'.implode(',', $product_ids).'"/>							
												</div>
											</div>
										</div>';
										?>
									<?php }
									echo $rows;
									} ?>
									</div>
								</div>
							</div>
						</div> 
					</div> 
					<div class="col-md-6 rating_and_reviews_right">
						<div class="bg_white informations">
							<h4 class="bold">Informations 
							<?php 
							if($this->session->userdata('logged_user')){
								if($messageStatus)
								{
							?>
								<a href="<?=LANG_URL.'/inbox/'.base64_encode($products_detail['product_id'])?>"><button class="btn btn-primary">Message</button></a>
							<?php
								}else{
							?>
								<button class="btn btn-primary" data-toggle="modal" data-target="#message">Message</button>
							<?php } }else{ ?>
								<a href="<?=LANG_URL.'/login'?>"><button class="btn btn-primary">Message</button></a>
							<?php } ?>
							</h4> 
							<ul class="informations_ul">
						<li>
									<h5>Seller</h5>
									<h6><a href="<?=LANG_URL.'/seller/'.base64_encode($products_detail['vendor_id'])?>"><?=$products_detail['store_name']?></a> 
										
									</h6>
								</li> 
								<li><h5>Category</h5><h6><?=$products_detail['category_name']?></h6></li>   
								<?php  ?>
								<li><h5>Shipping</h5><h6><?php  if(!empty($products_detail['shipping_time'])){ echo $products_detail['shipping_time'].' days'; }else{  echo $products_detail['min_estimate'].'-'.$products_detail['max_estimate'].' days'; } ?></h6></li>   
							</ul>
						</div> 
						<div class="bg_white description">
							<h4 class="bold">Description</h4> 
							<p><?=strlen($products_detail['description'])>160?substr($products_detail['description'],0,160).'...':$products_detail['description']?><a href="javascript:void(0)" id="view_full_description" class="color_blue">View full description</a></p>
						</div>
						
						<div class="bg_white accepted_payment">
							<h4 class="bold">Accepted Payment Method</h4> 
							<ul class="payment_ul">
								<li><a href="#" title="paypal"><img src="<?=WEB_URL?>images/payment_1.png"/></a></li>
								<li><a href="#" title="visa"><img src="<?=WEB_URL?>images/payment_2.png"/></a></li>
								<li><a href="#" title="master card"><img src="<?=WEB_URL?>images/payment_3.png"/></a></li>
								<li><a href="#" title="discover network"><img src="<?=WEB_URL?>images/payment_4.png"/></a></li>
								<li><a href="#" title="american express"><img src="<?=WEB_URL?>images/payment_5.png"/></a></li>
							</ul>
						</div>
						
						<div class="bg_white warranty">
							<h4 class="bold">Warranty</h4>
							<ul class="warranty_ul">
								<li>
									<img src="<?=WEB_URL?>images/warranty_1.png"/> 
									The warranty is valid for 30 days after purchase.
								</li>
								<li>
									<img src="<?=WEB_URL?>images/warranty_2.png"/> 
									<!-- We'll refund your money if your item isn't delivered within 30 days. -->
									Quick And Simple Process
								</li>
								<li>
									<img src="<?=WEB_URL?>images/warranty_3.png"/> 
									We'll refund your money if the delivered item doesn't match the description.
								</li>
								<li>
									<img src="<?=WEB_URL?>images/warranty_4.png"/> 
									If you choose to cancel this order, please contact us on the same day of purchase.
								</li>
							</ul>
						</div>
						
						<div class="bg_white postage">
							<h4 class="bold">Postage</h4>
							<ul class="postage_ul">
								<li>
									<img src="<?=WEB_URL?>images/postage.png"/> 
									Ships to the UK, US and many other countries
								</li>
							</ul>
						</div>
					</div>
			    </section>
			</div>
		</div>
		
		<div id="Description" class="Description tab-pane fade">
			<div class="header_tab">
			    <h3>Description</h3>
			</div>
			<div class="content_tab">
			    <ul class="content_tab_ul description">
				    <?=$products_detail['description']?>
				</ul>
			</div>
		</div>
		
        <div id="Related" class="Related tab-pane fade">
			<div class="content_tab">
			    <div id="related-slider" class="owl-carousel">
					<?php foreach($relatedProducts as $relatedProduct){  $id=base64_encode($relatedProduct['product_id']); ?>
						<div class="item" title="<?=$relatedProduct['product_name']?>">
							<div class="col-md-12 product_ak">
								<div class="row">
									<div class="porduct_img"><a href="<?=LANG_URL.'/products-details/'.escape_product_name($relatedProduct['product_name']).'/'.$id?>"><img src="<?=UPLOAD_URL.'product-images/'.$relatedProduct['image']?>"/></a></div>
									<div class="product_dsp">
										<span><?=$relatedProduct['product_name']?></span>
										<a href="<?=LANG_URL.'/products-details/'.escape_product_name($relatedProduct['product_name']).'/'.$id?>"><button class="product_btn">£ <?=$relatedProduct['price'];?></button></a>
									</div>
								</div>
							</div>
						</div>
		            <?php } ?>
				</div>
			</div>
		</div>
		
		<div id="Ratings" class="Ratings tab-pane fade">
			<div class="content_tab">
				<!--
			    <div class="review_search_section">
					<div class="container-fluid">
						<div class="col-md-6 rw_rcrh">
							<div class="input-group">
								<input type="text" class="form-control" placeholder="Search product...">
								<div class="input-group-append">
									<span class="input-group-text">
									<i class="fa fa-search" aria-hidden="true"></i></span>
								</div>
							</div> 
						</div> 
					</div>
				</div>
				-->
				<div class="review_rt_section">
					<div class="product_rating_ak">
						<div class="container-fluid">
						    <div class="col-md-6 as_rw as_ww_1">
							    <div class="row show_products_ratings">
								    <div class="bg_white rating_w">
									    <div class="row"> 
										    <div class="col-md-6 rating row">  
											    <h4 class="bold">Product Rating & Reviews</h4> 
											    <p><span><?php if($finalreview==''){ echo '00'; }else{ echo $finalreview; } ?></span> out of 5</p>
										    </div>
										    <div class="col-md-6 rating_star">  
											    <ul class="rating_star_ul">
											        <?php for($i=5;$i>0;$i--){ ?>
												        <li>
													        <i class="star<?=$i?>"></i>
													        <div class="rating_star_bg">
														        <?php
															        $widthPercentage = 0;
															        if(isset($productAvgReviews['eachPercentage'][$i]))
															        {
																    $widthPercentage = $productAvgReviews['eachPercentage'][$i];
															        }
														        ?>
														        <div class="progress_ak" style="width:<?=@$widthPercentage?>%;">
														        </div>
													        </div>
												        </li>
											        <?php } ?>
											    </ul>
										    </div>
									    </div>
								    </div>
							    </div>
							    <div class="row show_store_ratings" style="display:none;">
								    <div class="bg_white rating_w">
									    <div class="row"> 
										    <div class="col-md-6 rating row">  
											    <h4 class="bold">Store Rating & Reviews</h4> 
											    <p><span><?=$vendorAvgReviews['avg_rating']?></span> out of 5</p>
										    </div>
										    <div class="col-md-6 rating_star">  
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
														    <div class="progress_ak" style="width:<?=@$widthPercentage?>%;">
														    </div>
													    </div>
												    </li>
											        <?php } ?>
											    </ul>
										    </div>
									    </div>
								    </div>
							    </div> 
							    <div class="row">
			                    <div class="col-md-12">
									<div class="reviews_as row">
                                    <?php
function get_timeago( $ptime )
{
    $estimate_time = time() - $ptime;

    if( $estimate_time < 1 )
    {
        return '1 second ago';
    }

    $condition = array(
                12 * 30 * 24 * 60 * 60  =>  'year',
                30 * 24 * 60 * 60       =>  'month',
                24 * 60 * 60            =>  'day',
                60 * 60                 =>  'hour',
                60                      =>  'minute',
                1                       =>  'second'
    );

    foreach( $condition as $secs => $str )
    {
        $d = $estimate_time / $secs;

        if( $d >= 1 )
        {
            $r = round( $d );
            return '' . $r . ' ' . $str . ( $r > 1 ? 's' : '' ) . ' ago';
        }
    }
}?>
										<?php
										//print_r($product_reviews);
											if (!empty($product_reviews)) { $j=0;
												foreach($product_reviews as $product_review){ ?>
												<div class="col-md-12 col-sm-12 col-lg-12 col-xl-12">
													<div class="col-md-12 review_post">
														<h6 title="<?=$product_review['title']?>"><?=strlen($product_review['title'])>21?substr($product_review['title'],0,21).'...':$product_review['title']?><br>
														<?php for($i=0;$i<(int)$product_review['rating'];$i++){ ?>
															<i class="fa fa-star"></i>
														<?php } ?>
														</h6>
														
														<small><!-- <?= formate_date($product_review['modify_on'])?> -->
                                                          <?php echo get_timeago(strtotime($product_review['created_on']));?>
															<br>
														<i class="fa fa-heart"></i> <?php echo $product_review['name'];?>
														</small>
                                                        <p><img src="<?=LANG_URL?>/assets/check.png"> <span style="color:#59b048">Verified Purchase</span></p>
														<p>
															<?=strlen($product_review['review'])>190?substr($product_review['review'],0,190).'...'.'<a href="javascript:void(0);" class="view-rating" data-rater-name="'.$product_review['name'].'">MORE</a>':$product_review['review']?>
															<span class="product_full_review" style="display:none;"><?=$product_review['review']?></span>
															<span class="product_modify_on" style="display:none;"><?=formate_date($product_review['modify_on'])?></span>
															<span class="product_stars_html" style="display:none;">
																<?php for($i=0;$i<(int)$product_review['rating'];$i++){ ?>
																	<i class="fa fa-star"></i>
																<?php } ?>
															</span>
														</p>
													</div> 
												</div> 
											<?php if($j==1){//break;
											          } $j++; } ?>
											<div class="all_review_btn">
												<!-- <a href="javascript:void(0);"><button type="button" class="btn btn-primary view_all_review">View All Review</button></a> -->
											</div>
											<?php }else{ ?>
												<br>
												<div class="col-md-12">
												    <h1 style="color: #ccc;">No Review Yet!</h1>
												</div>
											<?php } ?> 
									</div>
								</div>
		                </div>
				    </div> 

						    <div class="col-md-6 as_rw as_rw2">
							    <ul class="sk_wrapp_ul">
								    <li><a class="sk_wrapp_link active" id="products_ratings" href="javascript:void(0);">Product Rating</a></li> 
								    <li><span class="rating_sort" href="javascript:void(0);" data-toggle="dropdown">Sort <i class="fa fa-caret-down"></i></span>
								    <div class="dropdown-menu sort_drop_down">
									    <a class="dropdown-item filter_star" data-filter-stars='all' href="javascript:void(0);">
										All Stars
									    </a>
									    <a class="dropdown-item filter_star" data-filter-stars='5' href="javascript:void(0);">
										    <i class="fa fa-star"></i>
										    <i class="fa fa-star"></i>
										    <i class="fa fa-star"></i>
										    <i class="fa fa-star"></i>
										    <i class="fa fa-star"></i>
									    </a>
									    <a class="dropdown-item filter_star"  data-filter-stars='4' href="javascript:void(0);">
										    <i class="fa fa-star"></i>
										    <i class="fa fa-star"></i>
										    <i class="fa fa-star"></i>
										    <i class="fa fa-star"></i>
									    </a>
									    <a class="dropdown-item filter_star"  data-filter-stars='3' href="javascript:void(0);">
										    <i class="fa fa-star"></i>
										    <i class="fa fa-star"></i>
										    <i class="fa fa-star"></i>
									    </a>
									    <a class="dropdown-item filter_star"  data-filter-stars='2' href="javascript:void(0);">
										    <i class="fa fa-star"></i>
										    <i class="fa fa-star"></i>
									    </a>
									    <a class="dropdown-item filter_star"  data-filter-stars='1' href="javascript:void(0);">
										    <i class="fa fa-star"></i>
									    </a>
								    </div>
								    </li> 
								    <li><a class="sk_wrapp_link" id="store_ratings" href="javascript:void(0);">Store Rating</a></li> 
							    </ul>		
						    </div>   
 

				<div class="clearfix"></div>
				<div class="reviw_section show_products_ratings">
					<div class="container-fluid">
						<div class="reviews_as row" id="product_review_section">
							
						</div>
					</div>
				</div>
				<div class="reviw_section show_store_ratings" style="display:none;">
					<div class="container-fluid">
						<div class="reviews_as row" id="vendor_review_section">
							
						</div>
					</div>
				</div>	
			</div>
		</div>
		
		<div id="Shipping" class="Shipping tab-pane fade">
			<div class="header_tab">
			  <h3>Shipping</h3>
			</div>
			<div class="content_tab">
			    <ul class="content_tab_ul shipping">
				    <li>  
						<h5>FAST & FREE</h5>
						<p>between Sat 20 oct and Mon 22 oct to <strong>M80AB</strong></p> 
					</li>
					<li>  
						<h5>ITEM LOCATION</h5>
						<p>United Kingdom</p> 
					</li>
					<li>  
						<h5>POSTS TO</h5>
						<p>Worldwide see exclusions</p> 
					</li>
				</ul>
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

$('.filter_star').on('click',function(){
	filter_stars = $(this).data('filter-stars');
	if(active_tab=='products')
	{
		product_offset = 0;
		filterProductNow1('sorting');
	}else{
		offset = 0;
		filterNow('sorting');
	}
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
			data: {'offset': offset, 'filter_stars':filter_stars},
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

var active_tab = 'products';
$('#products_ratings').on('click',function(){
	active_tab = 'products';
	$('.show_products_ratings').show();
	$('.show_store_ratings').hide();
});
$('#store_ratings').on('click',function(){
	active_tab = 'store';
	$('.show_products_ratings').hide();
	$('.show_store_ratings').show();
});

	
$('.quantity_ak').hide();
getColorSizeURL = '<?=base_url('home/get_size_color_details/'.$this->uri->segment(3))?>';

$('.view_all_review').click(function(){
	$('.tab_rating').click();
});

$('#view_full_description').click(function(){
	$('#Description_tab').click();
});


var filterProductReviewsURL = '<?=base_url('home/filterProductReviews/'.$this->uri->segment(3));?>';
var filter_stars = 'all';
var product_offset = 0;
var product_limit = <?=$productReviewLimit?>;
$('#product_review_section').on('click','#loadMore',function(){
	
	product_offset = product_limit + product_offset;
	filterProductNow1('loading');
});

function filterProductNow1(search_type)
{
	$.ajax({
		url: filterProductReviewsURL,
		type: "POST",
		data: {'product_offset': product_offset, 'filter_stars':filter_stars},
		//dataType: 'json',
		success: function (response) {
		  if(response != '')
		  {
			$('#product_review_section').find('.load_more_seller_products').remove();
			setTimeout(function() {
			  $('#product_review_section').removeClass('ajax_load');
			  if(response!='all_products_loaded')
			  {
				if(search_type=='loading')
				{
					$('#product_review_section').append(response);
				}else if(search_type=='sorting'){
					$('#product_review_section').html(response);
				}
			  }
			}, 0);
		  }else{
			$('#product_review_section').html('');
		  }
		},
	});
}

var addToWishlistURL = '<?=base_url('home/addToWishlist/');?>';
var loginCheck = false;
<?php if($this->session->userdata('logged_user') && !empty($this->session->userdata('logged_user'))){ ?>
	loginCheck = true;
<?php } ?>
$('.add_to_wishlist').on('click',function(){
	var product_id = $(this).data('product_id');
	var a_attr = $(this);
	if(loginCheck===true)
	{
		$.ajax({
			url: addToWishlistURL,
			type: "POST",
			data: {'product_id':product_id},
			//dataType: 'json',
			success: function (response) {
			  if(response != '')
			  {
				if(response == 'already')
				{
					alert('This product is already added in wishlist!');
				}else if(response === 0){
					alert('An erro occured.Please try again later!');
				}else{
					a_attr.find('.fa-heart-o').hide();
					a_attr.find('.fa-heart').show();
					var wishlistText = $('.cart-wishlist-items').html();
					if(wishlistText=='')
					{
						wishlistText = 1;
					}else{
						wishlistText = wishlistText.replace('(','');
						wishlistText = wishlistText.replace(')','');
						wishlistText = parseInt(wishlistText)+1;
					}
					$('.cart-wishlist-items').html('('+wishlistText+')');
				}
			  }else{
				alert('An erro occured.Please try again later!');
			  }
			},
		});
	}else{
		window.location.href = "<?=base_url('login')?>";
	}
});
</script>
<style type="text/css">
	ul#vertical {
    height: 466px !important;
}

.rating-block{
	background-color:#FAFAFA;
	border:1px solid #EFEFEF;
	padding:15px 15px 20px 15px;
	border-radius:3px;
}
.bold{
	font-weight:700;
}
.padding-bottom-7{
	padding-bottom:7px;
}

.review-block{
	background-color:#FAFAFA;
	border:1px solid #EFEFEF;
	padding:15px;
	border-radius:3px;
	margin-bottom:15px;
}

.review-block-rate{
	font-size:13px;
	margin-bottom:0px;
}
.review-block-title{
	font-size:15px;
	font-weight:700;
	margin-bottom:0px;
}
.review-block-description{
	font-size:13px;
}
.people_icon img
{
	border-radius: 50%;
	height: 30px;
	width: 30px;
}
.mrt5{
	margin-top: 5px;
}
.bef_review-block
{
	margin-top: 20px;
}
.review-block-rate .fa
{
  color: #f5c107;
}
@media only screen and (min-width: 768px) and (max-width: 959px) 
{
   .people_icon
   {
   	    margin-right: 1rem;
   }
   .review_rt_section .as_rw2 
   {
        padding: 40px 0px;
   }
}
@media only screen and (min-width: 960px) and (max-width: 1024px) {
.people_icon
   {
   	    margin-right: .5rem;
   }

}

</style>

<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click','.buyNow',function(){
			var va=$('#selectsize').val();
			if(va==''){
				$('#selectsize').focus();
				$('#selectcolour').focus();
			}
		});
	});
</script>