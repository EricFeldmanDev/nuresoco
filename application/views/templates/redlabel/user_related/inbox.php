
<section class="profile_section sidebar_bg rating_merchant_ww">
	<?php $this->load->view('templates/redlabel/user_related/sidebar_user'); ?>
	<div class="col-md-9 profile_right">
	    <div class="inbox_section row sticky">
		    <div class="col-md-5 col-sm-12 col-lg-4 col-xl-3 inbox_sidebar border-right">
				<?php 
					$productId = $this->uri->segment(2);
					if($productId!='')
					{
						$productId = base64_decode($productId);
					}
					foreach($chatProducts as $chatProduct){ ?>
					<!--<a href="<?=LANG_URL.'/inbox/'.base64_encode($chatProduct['product_id'])?>">-->
						<div class="user_list <?=($productId!='' && $productId==$chatProduct['product_id'])?'active':''?>" data-product-id="<?=base64_encode($chatProduct['product_id'])?>">
							<img src="<?=UPLOAD_URL.'product-images/'.$chatProduct['image']?>"/>
							<div>
								<h5><?=strlen($chatProduct['product_name'])>22?substr($chatProduct['product_name'],0,19).'...':$chatProduct['product_name']?> </h5> 
								<p><span>
									<!--<i class="fa fa-circle"></i>-->
									<?=strlen($chatProduct['vendor_name'])>21?substr($chatProduct['vendor_name'],0,18).'...':$chatProduct['vendor_name']?> </span> <?=$chatProduct['unread_messages']>0?'<span class="unread_messages">'.$chatProduct['unread_messages'].'</span>':''?></p>
								<time><?=date('d/m/Y h:i A',strtotime($chatProduct['last_message_on']))?></time>
							</div>
						</div>
					<!--</a>-->
				<?php } ?>
			</div>  
		    <div class="col-md-7 col-sm-12 col-lg-8 col-xl-9 inbox_chat">
			    <div class="chat_all">
					<?php //pr($chatMessages,1);
					$userImage = (is_file(UPLOAD_PHYSICAL_PATH.'user-images/'.$userDetails['profile_image']) && $userDetails['profile_image'] !="")?UPLOAD_URL.'user-images/'.$userDetails['profile_image']:WEB_URL.'images/profile_user.png';
					if(!empty($chatMessages)){
						foreach($chatMessages as $chatMessage)
						{
							if($chatMessage['message_from']=='VENDOR')
							{
					?>
								<div class="chat_ww chat_left">
									<img src="<?= (is_file(UPLOAD_PHYSICAL_PATH.'vendor-images/'.$chatMessage['vendor_profile_image']) && $chatMessage['vendor_profile_image'] !="")?UPLOAD_URL.'vendor-images/'.$chatMessage['vendor_profile_image']:WEB_URL.'images/profile_user.png' ?>"/> 
									<p class="text-left"><?=$chatMessage['message']?> 
									    <time><?=date('d/m/Y h:i A',strtotime($chatMessage['created_on']))?> </time>
									</p>
								</div>
					<?php 
							}else{
					?>
								<div class="chat_ww chat_right">
									<p class="text-left"><?=$chatMessage['message']?><time><?=date('d/m/Y h:i A',strtotime($chatMessage['created_on']))?> </time></p>
									<img src="<?= $userImage ?>"/> 
								</div>
								
					<?php 
							}
						}
					}elseif(empty($chatProducts)){
						echo '<h1 style="color:#ccc;text-align:center;padding:20% 0%">No Message To Show!</h1>';
					}else{
						echo '<h1 style="color:#ccc;text-align:center;padding:20% 0%">Please Select Product!</h1>';
					}
					?>
                </div>
				<div class="chat_submit_btn" style="<?=$productId!=''?'':'display:none;'?>">
				    <div class="input-group mb-3">
						<input type="text" id="send_now" class="form-control" placeholder="Type a message">
						<div class="input-group-append">
						  <span class="input-group-text send_message"><i class="fa fa-send-o"></i></span>
						</div>
					</div>  
				</div>
			</div> 
			
		</div>
	</div>
</section>
<script>
<?php
$productId = $this->uri->segment(2);
if($productId!=''){
?>
	var product_id = '<?=$productId?>';
<?php } ?>
var getChatMessages = '<?=LANG_URL.'/home/getChatMessages'?>';
var sendMessage = '<?=LANG_URL.'/home/send_message_by_ajax'?>';
$('.user_list').on('click',function(){
	$(this).find('.unread_messages').remove('');
	$('.user_list').removeClass('active');
	$(this).addClass('active');
	product_id = $(this).data('product-id');
	
	$.ajax({
		type: "POST",
		url: getChatMessages,
		data: {product_id: product_id},
		//dataType: 'json',
		success: function(response){
			//alert(response);
			if(response!='')
			{
				$('.chat_all').html(response);
			}else{
				$('.chat_all').html('');
			}
			window.history.pushState("Chat With Vendor", "Chat", "<?=LANG_URL.'/inbox/'?>"+product_id);
			$('.chat_submit_btn').show();
			$('.chat_all').scrollTop($('.chat_all')[0].scrollHeight);
		}
	});
});
<?php if(isset($userImage)){ ?>
	$('#send_now').keypress(function(e){
		if(e.which == 13 && !e.shiftKey){ //Enter key pressed
			$('.send_message').click();//Trigger search button click event
		}
	});
	$('.send_message').on('click',function(){
		var dt = new Date();
		if(dt.getHours()>12)
		{
			hours = dt.getHours() - 12;
			am_pm = 'PM';
		}else{
			hours = dt.getHours();
			am_pm = 'AM';
		}
		month = dt.getMonth()+1;
		if(month<10)
		{
			month = '0' + month;
		}
		var time = dt.getDate() + '/' + month + '/' + dt.getFullYear() + ' ' + hours + ":" + dt.getMinutes() + ' '+am_pm;
		var message = $('#send_now').val();
		if(message!='')
		{
			$.ajax({
				type: "POST",
				url: sendMessage,
				data: {product_id: product_id,message: message},
				//dataType: 'json',
				success: function(response){
				
					$('.chat_all').append('<div class="chat_ww chat_right"><p class="text-left">'+message+'</p><img src="<?= $userImage ?>"/></div>');
					$('#send_now').val('');
					$('.chat_all').scrollTop($('.chat_all')[0].scrollHeight);
				}
			});
		}
	});
<?php } ?>

$('.chat_all').scrollTop($('.chat_all')[0].scrollHeight);




</script>
