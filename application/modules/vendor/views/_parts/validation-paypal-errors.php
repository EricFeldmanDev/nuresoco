<div class="">
	<?php if(validation_errors()) { ?>
		<div class="alert alert-danger alert-dismissable" role="alert">
			<div class="alert-message">
				<b> Error - </b><?php echo validation_errors(); ?>
			</div>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
	<?php } ?>

	<?php if($this->session->flashdata('flashPaypalSuccess')):?>
		<div class="alert alert-primary alert-dismissable" role="alert">
			<div class="alert-message">
				<?php echo $this->session->flashdata('flashPaypalSuccess');?> 
			</div>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
	<?php endif?>

	<?php if($this->session->flashdata('paypal_provider_success')):?>
		<div class="alert alert-primary alert-dismissable" role="alert">
			<div class="alert-message">
				<?php echo $this->session->flashdata('paypal_provider_success');?> 
			</div>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
	<?php endif?>

	<?php if($this->session->flashdata('flashPaypalError')):?>
		<div class="alert alert-danger alert-dismissable" role="alert">
			<div class="alert-message">
				<?php echo $this->session->flashdata('flashPaypalError');?> 
			</div>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
	<?php endif?>
</div>