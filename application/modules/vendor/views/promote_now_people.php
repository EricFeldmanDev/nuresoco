<section class="send_people_section">    <div class="container">        <div class="margin_auto col-md-5">		    <h3>Select where to send people</h3>		  <form role="form" action="<?=LANG_URL.'/vendor/promoteTotalSpend/'.$this->uri->segment(3)?>" method="post"> 			<div class="form-check">			  <label class="form-check-label">				<span>Your Store</span> <input required="" type="radio" value="s" class="form-check-input" name="send_radio">			  </label>			</div>			<div class="form-check">			  <label class="form-check-label">				<span>Your Products</span> <input required="" type="radio" value="p" class="form-check-input" name="send_radio">			  </label>			</div>			<div class="form-group">				<button type="submit" class="btn btn-primary">Next</button>			</div>		  </form>			</div>	</div> 	</section>