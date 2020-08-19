<?php require 'app/views/inc/header.php'; ?>

	<div class="row">
		<div class="col-md-6 mx-auto">
			<div class="card card-body bg-light mt-5">
				<h2>CREATE AN ACCOUNT</h2>
				<div id="alert-body" class="p-3 m-3 rounded text-center d-none position-fixed"></div>
				<p>Please fill out this form to register with us</p>
				<form id="register-form">
				<div class="form-group">
					<label for="username"> Username: <sup>*</sup></label>
					<input type="text" name="username" class="form-control form-control-lg">
            		<span id="username_err" class="invalid-feedback"></span>
				</div>
				<div class="form-group">
					<label for="email"> Email: <sup>*</sup></label>
					<input type="email" name="email" class="form-control form-control-lg">
            		<span id="email_err" class="invalid-feedback"></span>
				</div>
				<div class="form-group">
					<label for="password"> Password: <sup>*</sup></label>
					<input type="password" name="password" class="form-control form-control-lg">
            		<span id="password_err" class="invalid-feedback"></span>
				</div>
				<div class="form-group">
					<label for="confirm_password"> Confirm password: <sup>*</sup></label>
					<input type="password" name="confirm_password" class="form-control form-control-lg">
            		<span id="confirm_password_err" class="invalid-feedback"></span>
				</div>
				<div class="form-group">
					<label for="first_name"> First name: </label>
					<input type="text" name="first_name" class="form-control form-control-lg">
            		<span id="first_name_err" class="invalid-feedback"></span>
				</div>
				<div class="form-group">
					<label for="last_name"> Last name: </label>
					<input type="text" name="last_name" class="form-control form-control-lg">
            		<span id="last_name_err" class="invalid-feedback"></span>
				</div>
				<div class="row">
					<div class="col">
						<input type="submit" value="Register" class="btn btn-success btn-block">
					</div>
				</div>
				
			</div>
		</div>
	</div>

<script src="<?php echo URLROOT; ?>/public/js/register.js"></script>

<?php require 'app/views/inc/footer.php'; ?>