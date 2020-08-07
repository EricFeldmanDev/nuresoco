
<section class="user_ww_section">
    <div class="container"> 
		<div class="row"> 
			<div class="col-md-6 user_ww_left">  
				<h1>USER</h1>
			</div>
			<div class="col-md-6 user_ww_right">  
				<ul class="sk_wrapp_ul black_ul">
					<li><a class="sk_wrapp_link active" href="<?= LANG_URL . '/login'?>">Login</a></li> 
					<li><a class="sk_wrapp_link" href="<?= LANG_URL . '/register'?>">Register</a></li> 
				</ul>
			</div>
			<!--<div class="col-md-12 language_change">
			    <div class="language_name">Language: 
					<a href="#"><img src="images/language_2.png"/></a>
					<a href="#"><img src="images/language_1.png"/></a>
				</div>  
			</div>-->
		</div>
	</div>
</section>



<section class="login_form_section">
    <div class="container">
        <div class="col-md-8 col-sm-8 col-lg-5 col-xl-5 form_box_wraap">
			<div class="row">
				<div class="form_box_header"><h4>User Login</h4></div>     
				<div class="form_box_content">
				<?php
					if ($this->session->flashdata('flashError')) {
						?>
						<div class="alert alert-danger"><?= $this->session->flashdata('flashError') ?></div>
						<?php
					}
					if ($this->session->flashdata('success')) {
						?>
						<div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
						<?php
					}
				?>
				<form id="frmLogin" method="POST" action="">
					<div class="form-group">
						<input type="email" name="email" class="form-control" placeholder="Email">
					</div>
					<div class="form-group">
						<input type="password" name="pass" class="form-control" placeholder="Password">
					</div>
					<a href="<?= LANG_URL . '/forgotten-password' ?>"><?= lang('forgot_pass') ?></a>
					<input type="submit" class="btn btn-primary btn_ww login" value="Login">
				    <a href="<?= LANG_URL . '/register'?>" class="btn btn-primary btn_ww sign_up">Sign up</a>
				</form>
				</div>     
			</div> 		
        </div> 		
    </div>	
</section>
