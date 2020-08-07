
<section class="profile_section sidebar_bg rating_merchant_ww">
	<?php $this->load->view('_parts/sidebar_merchant'); ?>
	<div class="profile_right" id="page-content-wrapper">
	    <div class="inbox_section row sticky">
		    <div class="col-md-5 col-sm-12 col-lg-4 col-xl-3 inbox_sidebar border-right">
				<?php 
					$productId = $this->uri->segment(3);
					$userId = $this->uri->segment(4);
					if($productId!='' && $userId!='')
					{
						$productId = base64_decode($productId);
						$userId = base64_decode($userId);
					}
					foreach($chatProducts as $chatProduct){ 
					?>
					<!--<a href="<?=LANG_URL.'/inbox/'.base64_encode($chatProduct['product_id'])?>">-->
						<div class="user_list <?=($productId!='' && $productId==$chatProduct['product_id'] && $userId!='' && $userId == $chatProduct['user_id'])?'active':''?>" data-product-id="<?=base64_encode($chatProduct['product_id'])?>" data-user-id="<?=base64_encode($chatProduct['user_id'])?>">
							<img src="<?=UPLOAD_URL.'product-images/'.$chatProduct['image']?>"/>
							<div>
								<h5><?=strlen($chatProduct['product_name'])>22?substr($chatProduct['product_name'],0,19).'...':$chatProduct['product_name']?> </h5> 
								<p><span>
									<!--<i class="fa fa-circle"></i>-->
									<?=strlen($chatProduct['user_name'])>21?substr($chatProduct['user_name'],0,18).'...':$chatProduct['user_name']?> </span> <?=$chatProduct['unread_messages']>0?'<span class="unread_messages">'.$chatProduct['unread_messages'].'</span>':''?></p>
								<time><?=date('d/m/Y h:i A',strtotime($chatProduct['last_message_on']))?></time>
							</div>
						</div>
					<!--</a>-->
				<?php } ?>
			</div>  
		    <div class="col-md-7 col-sm-12 col-lg-8 col-xl-9 inbox_chat">
			    <div class="chat_all">
					<?php //pr($chatMessages,1);
					$vendorImage = (is_file(UPLOAD_PHYSICAL_PATH.'vendor-images/'.$vendor_details['image']) && $vendor_details['image'] !="")?UPLOAD_URL.'vendor-images/'.$vendor_details['image']:WEB_URL.'images/profile_user.png';
					if(!empty($chatMessages)){
						foreach($chatMessages as $chatMessage)
						{
							if($chatMessage['message_from']=='VENDOR')
							{
					?>
								<div class="chat_ww chat_right">
									<p class="text-left"><?=$chatMessage['message']?><time><?=date('d/m/Y h:i A',strtotime($chatMessage['created_on']))?> </time></p>
									<img src="<?= $vendorImage ?>"/> 
								</div>
					<?php 
							}else{
							$userImage = (is_file(UPLOAD_PHYSICAL_PATH.'user-images/'.$chatMessage['user_profile_image']) && $chatMessage['user_profile_image'] !="")?UPLOAD_URL.'user-images/'.$chatMessage['user_profile_image']:WEB_URL.'images/profile_user.png';
					?>
								<div class="chat_ww chat_left">
									<img src="<?= $userImage ?>"/> 
									<p class="text-left"><?=$chatMessage['message']?><time><?=date('d/m/Y h:i A',strtotime($chatMessage['created_on']))?> </time></p>
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
var product_id = '';
var user_id = '';
<?php 
$productId = $this->uri->segment(3);
$userId = $this->uri->segment(4);
if($productId!='' && $userId!=''){
?>
	var product_id = '<?=$productId?>';
	var user_id = '<?=$userId?>';
<?php } ?>
var getChatMessages = '<?=LANG_URL.'/vendor/getChatMessages'?>';
var sendMessage = '<?=LANG_URL.'/vendor/send_message_by_ajax'?>';
$('.user_list').on('click',function(){
	$(this).find('.unread_messages').remove('');
	$('.user_list').removeClass('active');
	$(this).addClass('active');
	product_id = $(this).data('product-id');
	user_id = $(this).data('user-id');
	$.ajax({
		type: "POST",
		url: getChatMessages,
		data: {product_id: product_id,user_id: user_id},
		//dataType: 'json',
		success: function(response){
			//alert(response);
			if(response!='')
			{
				$('.chat_all').html(response);
			}else{
				$('.chat_all').html('');
			}
			window.history.pushState("Chat With User", "Chat", "<?=LANG_URL.'/vendor/inbox/'?>"+product_id+'/'+user_id);
			$('.chat_submit_btn').show();
			$('.chat_all').scrollTop($('.chat_all')[0].scrollHeight);
		}
	});
});
<?php if(isset($vendorImage)){ ?>
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
				data: {product_id: product_id,user_id: user_id,message: message},
				//dataType: 'json',
				success: function(response){
				
					$('.chat_all').append('<div class="chat_ww chat_right"><p class="text-left">'+message+'<time>'+time+'</time></p><img src="<?= $vendorImage ?>"/></div>');
					$('#send_now').val('');
					$('.chat_all').scrollTop($('.chat_all')[0].scrollHeight);
				}
			});
		}
	});
<?php } ?>
$('.chat_all').scrollTop($('.chat_all')[0].scrollHeight);
</script>