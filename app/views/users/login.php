<?php require 'app/views/inc/header.php'; ?>

	<div class="row">
		<div class="col-md-6 m-auto">
			<div class="card card-body bg-light mt-5">
				<?php $this->flash('loggedin'); ?>
				<?php $this->flash('register_success'); ?>
				<h2>SIGN IN</h2>
				<p>Please fill in your credentials to sign in</p>
				<form action="<?php echo URLROOT; ?>/users/login" method="post">
				<div class="form-group">
					<label for="username"> Username: <sup>*</sup></label>
					<input type="text" name="username" class="form-control form-control-lg <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" value="">
            		<span class="invalid-feedback"><?php echo $data['username_err']; ?></span>
				</div>
				<div class="form-group">
					<label for="password"> Password: <sup>*</sup></label>
					<input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="">
            		<span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
				</div>
				<div class="row">
					<div class="col">
						<input type="submit" value="Login" class="btn btn-success btn-block">
					</div>
				</div>
				<a href="<?php echo URLROOT; ?>/users/forgotpwd">Forgot your password?</a>
			</div> 
		</div>
	</div>

<?php require 'app/views/inc/footer.php'; ?>