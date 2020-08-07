<div class="">
	
	<?php if($this->session->flashdata('flashSuccess')):?>
		<div class="alert alert-primary alert-dismissable" role="alert">
			<div class="alert-message">
				<?php echo $this->session->flashdata('flashSuccess');?> 
			</div>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
	<?php endif?>
	<?php if($this->session->flashdata('flashError')):?>
		<div class="alert alert-danger alert-dismissable" role="alert">
			<div class="alert-message">
				<?php echo $this->session->flashdata('flashError');?> 
			</div>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
	<?php endif?>
	<?php if($this->session->flashdata('selectImage')):?>
		<div class="alert alert-danger alert-dismissable" role="alert">
			<div class="alert-message">
				<?php echo $this->session->flashdata('selectImage');?> 
			</div>
			<button type="button" class="close" data-dismiss="alert" aria-label="Close">
				<span aria-hidden="true">×</span>
			</button>
		</div>
	<?php endif?>
</div>