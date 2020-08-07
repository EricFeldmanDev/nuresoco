
<section class="user_ww_section">
    <div class="container"> 
		<div class="row"> 
			<div class="col-md-6 user_ww_left">  
				<h1>USER</h1>
			</div>
			<div class="col-md-6 user_ww_right">  
				<ul class="sk_wrapp_ul black_ul">
					<li><a class="sk_wrapp_link" href="<?= LANG_URL . '/login'?>">Login </a></li> 
					<li><a class="sk_wrapp_link active" href="<?= LANG_URL . '/register'?>">Register</a></li> 
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
				<div class="form_box_header"><h4>Sign up Here</h4></div>     
				<div class="form_box_content">
				<?php
					if ($this->session->flashdata('flashError')) 
					{
						if(is_array($this->session->flashdata('flashError')))
						{
						?>
						<div class="alert alert-danger"><?= implode('<br>', $this->session->flashdata('flashError')) ?></div>
						<?php
						}
					}
				?>
				<form id="frmSignUp" method="POST" action="">
					<div class="form-group">
						<input type="text" name="name" class="form-control" placeholder="Full Name">
					</div>
					<div class="form-group">
						<input type="email" name="email" class="form-control" placeholder="Email">
					</div>
					<div class="form-group">
						<input type="password" name="pass" class="form-control" placeholder="Password">
					</div>
					<div class="form-group">
						<input type="password" name="pass_repeat" class="form-control" placeholder="Confirm Password">
					</div>
					<div class="form-group form-check">
						<label class="form-check-label">
						    <input class="form-check-input" type="checkbox" name="terms"> I Agree to the <a href="<?=LANG_URL.'/privacy-policy'?>">Privacy Policy</a>
						</label>
					</div>
				    <input type="submit" class="btn btn-primary btn_ww login" value="Register">
				    
				    <a href="<?= LANG_URL . '/login'?>" class="btn btn-primary btn_ww sign_up">Login</a>
				</form>
				</div>     
			</div> 		
        </div> 		
    </div>	
</section>

<script src="<?= base_url('assets/web/bootstrap_validator/bootstrap_validator.js') ?>"></script>
<script>
$(document).ready(function() {
    $('#frmSignUp')
        .bootstrapValidator({
            framework: 'bootstrap',
            //excluded: [':disabled'],
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
            },
            fields: {
            	name: {
                    validators: {
                        notEmpty: {
                            message: 'This field is required'
                        },
                    }
                },
			
				email: {
                    validators: {
                        notEmpty: {
                            message: 'This field is required'
                        },
						regexp: {
                            regexp: '^[^@\\s]+@([^@\\s]+\\.)+[^@\\s]+$',
                            message: 'Please enter a valid email address'
                        },
						 remote: {
							url: '<?= LANG_URL . '/checkUseremail' ?>',
							type: 'POST',
							message: 'This email id already exists',
						}, 
                    }
                },
				pass: {
                    validators: {
                        notEmpty: {
                            message: 'This field is required'
                        },
						identical: {
                            field: 'pass_repeat',
                            message: 'The password and its confirm must be the same'
                        },
                    }
                },
                pass_repeat: {
                    validators: {
                        notEmpty: {
                            message: 'This field is required'
                        },
                        identical: {
                            field: 'pass',
                            message: 'The password and its confirm must be the same'
                        },
                    }
                },
                terms: {
                    validators: {
                        notEmpty: {
                            message: 'Check this box for agree with our policies'
                        },
                    }
                },
            }
        })
        .on('error.validator.bv', function(e, data) {
            data.element
                .data('bv.messages')
                // Hide all the messages
                .find('.help-block[data-bv-for="' + data.field + '"]').hide()
                // Show only message associated with current validator
                .filter('[data-bv-validator="' + data.validator + '"]').show();
        });
});
</script> 