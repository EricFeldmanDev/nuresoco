<?php
$session='';
 if($this->session->userdata('successData')){?>
	<?php $session=$this->session->userdata('successData');?>
<?php } ?>
<section class="payment_sucessfull_section section_padding">
    <div class="container-fluid">
        <div class="row">
			<div class="col-sm-7 margin_auto">   
			    <div class="payment_sucessfull">
                    <div class="payment_title">
						<i class="fa fa-check"></i>
						<h4>Payment Successfully</h4>
						<p>You Paid <?=($session)?$session['amount']:''?> USD to atif We'll notify you when they receive the funds.</p>
					</div>
					<div class="payment_body">
						<div class="row payment_row">
						    <div class="col-md-6 payment_row_left">
							    Amount to pay :     
							</div>  
						    <div class="col-md-6 payment_row_right">
							    $<?=($session)?$session['amount']:''?>  
							</div>  
						</div>
						<div class="row payment_row">
						    <div class="col-md-6 payment_row_left">
							    Date :     
							</div>  
						    <div class="col-md-6 payment_row_right">
							   <?=($session)?$session['date']:''?> 
							</div>  
						</div>
						<div class="row payment_row">
						    <div class="col-md-6 payment_row_left">
							    Transition Id :     
							</div>  
						    <div class="col-md-6 payment_row_right">
							    <?=($session)?$session['transation_id']:''?>
							</div>  
						</div>
					</div>
				</div>
			</div>
		</div>  	
    </div>  	
</section>
