<section class="express_join_section">
    <div class="container">
        <h3>Select the countries you can deliver to in 5 days or less and click Apply Now to sign up!</h3>
		<div class="express_warehouse">
		    <div class="margin_auto col-md-10">
		    	<form class="form" method="post" action="<?=base_url()?>vendor/express-request">
		    	<?php //echo form_open(base_url().'vendor/express-request'); ?>
					<h5>Tell us about your warehouse</h5>
					<label>Select the countries you can deliver to in 5 days or less:</label>
					<ul class="express_countries_ul">
					<?php foreach($countries['expressCountries'] as $key => $expressCountries){ ?>
						<li><label><input type="checkbox" name="country_id[]" value="<?=$key?>"/> <?=$expressCountries?></label></li>
					<?php } ?>
						<input type="button" class="btn_other show_btn_other" value="+ Other Countries" />
						<input type="button" class="btn_other hide_btn_other" value="- Hide Countries" style="display:none;"/>
					</ul>
					<div class="clearfix"></div>
					<ul class="express_countries_ul more_country" style="margin-top:3%;display:none;">
						<?php foreach($countries['countries'] as $key => $country){ ?>
							<li><label><input type="checkbox" name="country_id[]" value="<?=$key?>"/> <?=$country?></label></li>
						<?php } ?>
					</ul>
					<div class="clearfix"></div>
					<p class="grey text-center">Your application will be reviewed within 3 business days by your Account Manager.</p>
					<div class="text-center"><button class="btn btn-primary" type="submit">Apply Now</button></a></div>
				</form>
				<?php // echo form_close(); ?>	
		    </div>
		</div>
    </div> 	
</section>
<script>
$('.show_btn_other').click(function(){	
	$('.more_country').show();
	$('.show_btn_other').hide();
	$('.hide_btn_other').show();
});
$('.hide_btn_other').click(function(){	
	$('.more_country').hide();
	$('.hide_btn_other').hide();
	$('.show_btn_other').show();
});
$('.form').on('submit',function(e){	
	var checkedNum = $('input[name="country_id[]"]:checked').length;
	if (!checkedNum) {
		alert('Please select atleast one country!');
		e.preventDefault();
	}
});
</script>