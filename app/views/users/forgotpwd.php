<?php require 'app/views/inc/header.php'; ?>

	<div class="row">
		<div class="col-md-6 mx-auto">
			<div class="card card-body bg-light mt-5">
				<?php $this->flash('forgot_pwd'); ?>
				<h2>Reset your password</h2>
				<p>An email will be send to you with instructions on how to reset your password.</p>
				<form action="<?php echo URLROOT; ?>/users/forgotpwd" method="post">
				<div class="form-group">
					<label for="username"> Enter your email address <sup>*</sup></label>
					<input type="email" name="email" class="form-control form-control-lg <?= isset($data['email_err']) ? 'is-invalid' : ''; ?>">
            		<span class="invalid-feedback"><?= isset($data['email_err']) ? $data['email_err'] : ''  ?></span>
				</div>
				<div class="row">
					<div class="col">
						<input type="submit" value="Reset password" class="btn btn-success btn-block">
					</div>
				</div>
		</div>
	</div>
	</div>

<?php require 'app/views/inc/footer.php'; ?>