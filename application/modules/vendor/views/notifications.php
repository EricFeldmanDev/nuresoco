
<section class="profile_section sidebar_bg rating_merchant_ww">
	<?php $this->load->view('_parts/sidebar_merchant') ?>
	<div class="profile_right" id="page-content-wrapper">
	    <div class="page_title"><h3>All Notifications</h3></div> 
	    <div class="col-md-10 shipping_info_section">
			<?php 
			if(!empty($notifications)){
				foreach($notifications as $notification){
			?>
				<a class="notification-link" href="<?=$notification['link']!=''?$notification['link']:'javascript:void(0);'?>">
					<div class="row user_notification <?=$notification['seen_status']==0?'unseen_notification':'seen_notification'?>">
					<?php if($notification['image']!=''){ ?>
						<div class="col-md-1 user_notification_img">
							<img src="<?=$notification['image']?>"/>    
						</div>  
					<?php } ?>
						<div class="col-md-11 user_notification_content">
							<p>
								<?=$notification['message']?><br>
								<small><?=date('h:i A d F, Y',strtotime($notification['created_on']))?></small>
							</p>
						</div>  
					</div>
				</a>
			<?php } }else{ ?>
				<h1 style="color:#ccc;margin-top:15px;" class="text-center">No Notification Yet</h1>
			<?php } ?>
		</div>
	</div>
</section>
<script>
$('#notification-click').remove();
</script>