<section class="user_ww_section">
    <div class="container"> 
		<div class="row"> 
			<div class="col-md-6 user_ww_left">  
				<h1>USER</h1>
			</div>
			<div class="col-md-6 user_ww_right">  
				<ul class="sk_wrapp_ul black_ul">
					<li><a class="sk_wrapp_link active" href="<?= LANG_URL . '/login'?>">Login in</a></li> 
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
				<div class="form_box_header"><h4>Change Password</h4></div>     
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
				<form method="POST" action="<?=current_url();?>" id="changePassword">
					<div class="form-group">
						<input type="password" id="password" class="form-control" name="password" placeholder="New Password" required>
					</div>
					<div class="form-group">
						<input type="password" id="confirmpassword" class="form-control" name="confirmpassword" placeholder="Confirm New Password" required>
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
$('#password').focus();
</script>
<script src="<?= base_url('assets/web/bootstrap_validator/bootstrap_validator.js') ?>"></script>
<script>
$(document).ready(function() {
    $('#changePassword')
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
							url: '<?php echo base_url().'home/check_useremail'; ?>',
							type: 'POST',
							message: 'This email id already exists',
						}, 
                    }
                },
				password: {
                    validators: {
                        notEmpty: {
                            message: 'This field is required'
                        },
						identical: {
                            field: 'confirmpassword',
                            message: 'The password and its confirm must be the same'
                        },
                    }
                },
                confirmpassword: {
                    validators: {
                        notEmpty: {
                            message: 'This field is required'
                        },
                        identical: {
                            field: 'password',
                            message: 'The password and its confirm must be the same'
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