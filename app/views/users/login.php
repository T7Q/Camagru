<?php require 'app/views/inc/header.php'; ?>

	<div class="row">
		<div class="col-md-6 m-auto">
			<div class="card card-body bg-light mt-5">
				<div id="alert-body" class="p-3 m-3 rounded text-center d-none"></div>
				<h2>SIGN IN</h2>
				<p>Please fill in your credentials to sign in</p>
				<form id="login-form">
				<div class="form-group">
					<label for="username"> Username: <sup>*</sup></label>
					<input type="text" name="username" class="form-control form-control-lg " >
					<span id="username_err" class="invalid-feedback"></span>
				</div>
				<div class="form-group">
					<label for="password"> Password: <sup>*</sup></label>
					<input type="password" name="password" class="form-control form-control-lg " >
					<span id="password_err" class="invalid-feedback"></span>

					
				</div>
				<div class="row">
					<div class="col">
						<input type="submit" value="Login" class="btn btn-primary btn-block">
					</div>
				</div>
				<div class="row mt-3 mx-auto">
					<a href="<?php echo URLROOT; ?>/users/forgotpwd">Forgot your password?</a>
				</div>
			</div> 
		</div>
	</div>

<script src="<?php echo URLROOT; ?>/public/js/login.js"></script>

<?php require 'app/views/inc/footer.php'; ?>