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
					<a href="<?= LANG_URL . '/admin' ?>"><?= lang('login') ?></a><br><br>
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