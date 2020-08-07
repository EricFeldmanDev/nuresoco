
<section class="payment_sucessfull_section section_padding">
    <div class="container-fluid">
        <div class="row">
			<div class="col-md-5 margin_auto">   
			    <div class="payment_sucessfull payment_failed">
                    <div class="payment_title">
						<i class="fa fa-ban"></i>
						<h4>Payment Failed</h4>
						<?php ?>
						<p><?php if(!empty($this->session->flashdata()) && $this->session->flashdata('paypalError')) {
							echo $this->session->flashdata('paypalError');
						 } ?></p>
					</div>
				</div>
			</div>
		</div>  	
    </div>  	
</section>
