<section class="promote_preview_section">    <div class="container">        <div class="margin_auto col-md-6">		  <form method="post" role="form" action="<?=base_url('vendor/promoteNowSubmit/'.$this->uri->segment(3))?>">		  <?php		   if(isset($post)) { ?>		    <input type="hidden" name="send_radio" value="<?=$post['send_radio']?>">		    <input type="hidden" name="budget" value="<?=BUDGET_PERDAY_VALUE*$post['duration']?>/<?=$post['duration']?>">		    <input type="hidden" name="duration" value="<?=$post['duration']?>">		<?php }?> 		    <div class="promote_preview_heading"> 				<h3>You're all ready.</h3>				<p>Your estimated reach is 2,900-7600 people once your promotion has started, you can pause spending at any time.</p>			</div>			<div class="promote_preview_body"> 			    <div class="promote_preview_img"><img src="<?=WEB_ROOT?>assets/uploads/page_images/ak_1.png"/><h2>Promotion Preview</h2></div>				<table class="table table-bordered">				    <tr>                        <td>Audience</td>                           <td>Automatic</td>                       </tr>                    <tr>                        <td>Budget and duration</td>                           <td>$<?=BUDGET_PERDAY_VALUE*$post['duration']?>/<?=$post['duration']?> days</td>                       </tr>									</table>			</div>			<div class="promote_paypal_account">			    <img src="<?=WEB_ROOT?>assets/uploads/page_images/paypal_logo.png"/> 				<div class="promote_paypal_account_dsp">				    <h4>PayPal account <span>(samwilson@gmail.com)</span></h4>                     <p>If you want to change the payment option please go back and choose a different option</p>				</div>			</div>			<div class="form-group">				<button type="submit" name="btnSub" class="btn btn-primary">Create Promotion</button>			</div>		  </form>			</div>    </div> 	</section>