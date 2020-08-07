<section class="user_ww_section">
    <div class="container"> 
		<div class="row"> 
			<div class="col-md-6 user_ww_left">  
				<h1>Merchants</h1>
			</div>
			<div class="col-md-6 user_ww_right">  
				<ul class="sk_wrapp_ul black_ul">
					<li><a class="sk_wrapp_link" href="javascript:void(0);">Merchent</a></li> 
					<li><a class="sk_wrapp_link active" href="<?= LANG_URL . '/vendor/login'?>">Login in</a></li> 
					<li><a class="sk_wrapp_link" href="<?= LANG_URL . '/vendor/register'?>">Register</a></li> 
				</ul>
			</div>
		</div>
	</div>
</section>

<section class="login_form_section">
    <div class="container">
        <div class="col-md-8 col-sm-8 col-lg-5 col-xl-5 form_box_wraap">
			<div class="row">
				<div class="form_box_header"><h4>Forgot Password</h4></div>     
				<div class="form_box_content">
			
				<?php
					if ($this->session->flashdata('flashError')) {
						?>
						<div class="alert alert-danger"><?= implode('<br>', $this->session->flashdata('flashError')) ?></div>
						<?php
					}
					if ($this->session->flashdata('login_error')) {
						?>
						<div class="alert alert-danger"><?= $this->session->flashdata('login_error') ?></div>
						<?php
					}
					if ($this->session->flashdata('success')) {
						?>
						<div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
						<?php
					}
				?>
				<form method="POST" action="">
					<div class="form-group">
						<input type="email" id="u_email" class="form-control" name="u_email" placeholder="<?= lang('email') ?>" required>
					</div>
					<input type="submit" name="login" class="btn btn-primary btn_ww login submit" value="Submit">
					<br><br>
				</form>
				</div>     
			</div> 		
			</div> 		
    </div>	
</section>
<script>
$('#email').focus();
</script>