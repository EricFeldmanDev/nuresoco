<section class="profile_section sidebar_bg rating_merchant_ww">
    <?php include 'sidebar_user.php'; ?>
	<form method="POST" id="frmChangePass" >
		<div class="col-md-9 profile_right">
			<div class="page_title"><h3>Change Password </h3></div> 
			<div class="col-md-11 col-sm-12 col-lg-8 col-xl-6 shipping_info_section">
				<?php
					if ($this->session->flashdata('flashError')) {
						?>
						<div class="alert alert-danger"><?= $this->session->flashdata('flashError') ?></div>
						<?php
					}
					if ($this->session->flashdata('flashSuccess')) {
						?>
						<div class="alert alert-success"><?= $this->session->flashdata('flashSuccess') ?></div>
						<?php
					}
				?>
				<div class="password_change">
					<div class="form-group">
						<label>Old Password:</label>
						<input type="password" name="old_password" class="form-control" placeholder="********">
					</div>
					<div class="form-group">
						<label>New Password:</label>
						<input type="password" name="passsword" class="form-control" placeholder="********">
					</div>
					<div class="form-group">
						<label>Confirm Password:</label>
						<input type="password" name="confirm_passsword" class="form-control" placeholder="********">
					</div>
					<button type="submit" class="btn btn-primary">Password Change</button>
				</div>
			</div>
		</div>
	</form>
</section>

<script src="<?= base_url('assets/web/bootstrap_validator/bootstrap_validator.js') ?>"></script>
<script>
$(document).ready(function() {
    $('#frmChangePass')
        .bootstrapValidator({
            framework: 'bootstrap',
            //excluded: [':disabled'],
            icon: {
                valid: 'glyphicon glyphicon-ok',
                invalid: 'glyphicon glyphicon-remove',
            },
            fields: {
            	old_password: {
                    validators: {
                        notEmpty: {
                            message: 'This field is required'
                        },
						 remote: {
							url: '<?= LANG_URL . '/check-user-password' ?>',
							type: 'POST',
							message: 'Old password is incorrect!',
						},
                    }
                },
				passsword: {
                    validators: {
                        notEmpty: {
                            message: 'This field is required'
                        },
						identical: {
                            field: 'confirm_passsword',
                            message: 'The password and its confirm must be the same'
                        },
                    }
                },
                confirm_passsword: {
                    validators: {
                        notEmpty: {
                            message: 'This field is required'
                        },
                        identical: {
                            field: 'passsword',
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