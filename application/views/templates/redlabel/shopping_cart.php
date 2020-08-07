<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<style>
.alert-success, .alert-danger {
    padding: 5px 20px;
    display: inline-block;
    margin: 10px 0px 0px 0px;
}
</style>
<div class="" id="shopping-cart" style="min-height:470px;">
	<section class="mycart_section">
		<div class="container-fluid">
			<div class="col-md-8 left_cart pull-left">
				<div class="cart_heading"><h4>My cart</h4></div>
				<div class="row select_delete">
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-6 select_product"><label><input type="checkbox" id="selectAll"/>Select All Products</label></div> 
					<div class="col-md-6 col-sm-6 col-lg-6 col-xl-6 delete_product text-right"><a href="#" id="delete-selected" class="delete_cart"><i class="fa fa-trash"></i> Delete selected (<span id="totalSelected">0</span>)</a></div> 
				</div> 
				<?php //pr($cartItems['array'],1); 
					if ($cartItems['array'] != null) { ?>
					<?php 
						foreach($cartItems['array'] as $product) { 
       //                     echo "<pre>";
							// print_r($product);
						$id=base64_encode($product['product_id']);
						$productName = escape_product_name($product['product_name']);
					?>
						<div class="cart_add_product">
							<label>
								<input type="checkbox" class="checkBoxClass" data-product_id="<?=$product['product_id']?>" data-size_id="<?=$product['size_id']?>" data-color_id="<?=$product['color_id']?>"/>
								<a href="<?=LANG_URL.'/products-details/'.$productName.'/'.$id?>"><?=$product['product_name']?></a>
							</label>
							<div class="row">
						
								<div class="col-md-2 cart_add_product_img">
									<a href="<?=LANG_URL.'/products-details/'.$productName.'/'.$id?>"><img src="<?php echo base_url('assets/uploads/product-images/').$product['image']; ?>"></a>
								</div>   
								<div class="col-md-5 col-sm-12 col-lg-5 col-xl-6 cart_add_product_dsp">
								<?php if($product['color']!=''){?>
									<p><span class="grey">Color</span> : <?=$product['color']?></p>   
								<?php } ?>
								<?php if($product['size']!=''){?>
									<p><span class="grey">Size</span> : <?=$product['size']?></p>   
								<?php } ?>
									<p><span class="grey">Shipping</span> :<?php if ($product['shipping_type']=='paid') {
										echo $product['shipping'];
									}else{
										echo "free";
									} ?></p> 
									<p>
										<div class="quantity_ak"><span class="grey">Quantity : </span>
											<div class="quantity quantityCls">
											<input type="number" id="quantity" min="1" max="2000000" step="1" value="<?=$product['cart_quantity']?>" readonly data-product_id="<?=$product['product_id']?>" data-size_id="<?=$product['size_id']?>" data-color_id="<?=$product['color_id']?>">
											</div>
										</div>
									</p>   
								</div>
								<!--<div class="col-md-3 hide_div"></div>-->
								<div class="col-md-5 col-sm-12 col-lg-5 col-xl-4 cart_add_product_total">
									<p>
										<span>Price:</span>
										<span class="grey">£ <?=$product['logistic_detail']=='default'?$product['price']:$product['variations_price']?></span>
									</p> 
									<p>
										<?php //echo "<pre>"; print_r($product); ?>
										<span>Shipping Time:</span>
										<span class="grey"><?php if($product['shipping_time']==''){ echo  $product['min_estimate'].'-'.$product['max_estimate'].' days'; }else{ echo $product['shipping_time'].' days'; }?></span>
																			</p> 
									<p>
										<span>Total:</span>
										<span class="grey">£ <?=$product['logistic_detail']=='default'?$product['sum_price']:$product['sum_variations_price']?></span>
									</p>
								</div>   
							</div>
						</div>
					<?php } ?>						
				<?php }else{ ?>						
					<div class="alert alert-info"><?= lang('no_products_in_cart') ?></div>
				<?php } ?>
			</div>
			<div class="col-md-4 right_cart pull-left">
				<div class="cart_heading"><h4>Order Summary</h4></div>				
				<div class="total_payment">
					<p>
						<span>Price:</span>
						<span class="grey"><?=$cartItems['finalSum']!=''?'£ '.$cartItems['finalSum']:''?></span>
					</p> 
					<p>
						<span>Shipping:</span>
						<span class="grey">
							<?php
							  	$shipping=0; $shipp=0;
							  	if($cartItems && isset($cartItems['array'])) {
									foreach ($cartItems['array'] as $value) {																		
										$shipp+=number_format($value['shipping']);			 
									} 
								}
							?>
							<?php if ($shipp > 0) {echo $shipp;
							}else{ echo "free";} ?></span>
					</p> 
					<p>
						<span>Total:</span>
						<span class="grey"><?=$cartItems['finalSum']!=''?'£ '.$cartItems['finalSum']:''?></span>
					</p> 
					<p class="coupon_code_p">
						<span>Coupon Code<mark id="coupon_code_discount"></mark>:</span>
						<span class="grey"><span id="couponCode_html"><?=$cartItems['finalSum']!=''?'£ '.$cartItems['finalSum']:''?></span> <a href="javascript:void(0)" class="coupon-close"><i class="fa fa-close"></i></a></span>
					</p>
					<p class="final_total_p">
						<span>Final Total:</span>
						<span class="grey" id="finalSum_html"><?=$cartItems['finalSum']!=''?'£'.$cartItems['finalSum']:''?></span>
					</p>
					<a href="<?=(isset($_SESSION['logged_user']))?base_url('payment-form'):base_url('login')?>"><button class="btn btn-primary">Checkout</button></a>  				
				</div>
				<div class="cupon_code" <?=($cartItems['array'] == null)?'style="display:none;"':''?>>
					<label>Add a Coupon code</label>  <span id="coupon-message"></span>
					 <div class="input-group">
						<input type="text" class="form-control coupon_code" name="coupon_code" placeholder="Cupon Code" <?=($cartItems['array'] == null)?'disabled':''?>>
						<div class="input-group-append">
						  <span class="input-group-text">Apply</span>
						</div>
					  </div> 
				</div>
			</div>
		</div> 	
	</section>
</div>
<script>
var removeFromCartURL = '<?=base_url('home/removeFromCart')?>';
var updateCartQuantity = '<?=base_url('home/updateCartQuantity')?>';
var discountCodeChecker = '<?=base_url('home/discountCodeChecker')?>';
var finalSum = parseFloat(<?=$cartItems['finalSum']!=''?str_replace(',', '',$cartItems['finalSum']):0?>);
$('.coupon_code_p').hide();
$('.final_total_p').hide();
$('.coupon-close').click(function(){
var unsetDiscountUrl='<?=base_url('payment/unset_discountCode')?>';
	$.ajax({
		type: "POST",
		url: unsetDiscountUrl,
		data: {},
		success: function(response){
			$('.close').click();
			$('.coupon_code').val('');
			$('.coupon_code_p').hide();
			$('.final_total_p').hide();
			$('#couponCode_html').html('');
			$('#finalSum_html').html('');
			$('#coupon_code_discount').html('');
		}
	});			


	
});
$('.input-group-text').click(function(){
	var coupon_code = $('.coupon_code').val();
	if(coupon_code!='')
	{
		$.ajax({
			type: "POST",
			url: discountCodeChecker,
			data: {enteredCode: coupon_code},
			dataType: 'json',
			success: function(response){
				console.log(response);
				if(response==0)
				{
					$('.coupon_code_p').hide();
					$('.final_total_p').hide();
					$('#coupon-message').html('<span class="alert alert-danger alert-dismissible">Invalid coupon code<a href="" class="close" data-dismiss="alert" aria-label="close">&times;</a></span>');
				}else{
					if(response.type=='percent')
					{
						var discountedPercentage = response.amount;
						var showAmount = finalSum - (finalSum * discountedPercentage)/100;
						$('#couponCode_html').html('£ '+(finalSum * discountedPercentage)/100);
						$('#finalSum_html').html('£ '+showAmount);
						$('#coupon_code_discount').html('&nbsp;('+response.amount+'%)');
						$('.coupon_code_p').show();
						$('.final_total_p').show();
						$('#coupon-message').html('<span class="alert alert-success alert-dismissible">Coupon code applied<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></span>');
					}else{
						$('#coupon-message').html('<span class="alert alert-danger alert-dismissible">Invalid coupon code<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></span>');
					}
				}
			}	
		});
	}else{
		$('#coupon-message').html('<span class="alert alert-danger alert-dismissible">Please enter coupon code first!<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a></span>');
	}
});
</script>
<?php
if ($this->session->flashdata('deleted')) {
    ?>
    <script>
        $(document).ready(function () {
            ShowNotificator('alert-info', '<?= $this->session->flashdata('deleted') ?>');
        });
    </script>
<?php } ?>