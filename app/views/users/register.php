<?php require 'app/views/inc/header.php'; ?>

	<div class="row">
		<div class="col-md-6 mx-auto">
			<div class="card card-body bg-light mt-5">
				<h2>CREATE AN ACCOUNT</h2>
				<p>Please fill out this form to register with us</p>
				<form action="<?php echo URLROOT; ?>/users/register" method="post">
				<div class="form-group">
					<label for="username"> Username: <sup>*</sup></label>
					<input type="text" name="username" class="form-control form-control-lg <?php echo (!empty($data['username_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['username']; ?>">
            		<span class="invalid-feedback"><?php echo $data['username_err']; ?></span>
				</div>
				<div class="form-group">
					<label for="email"> Email: <sup>*</sup></label>
					<input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
            		<span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
				</div>
				<div class="form-group">
					<label for="password"> Password: <sup>*</sup></label>
					<input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
            		<span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
				</div>
				<div class="form-group">
					<label for="confirm_password"> Confirm password: <sup>*</sup></label>
					<input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_password']; ?>">
            		<span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
				</div>
				<div class="form-group">
					<label for="first_name"> First name: </label>
					<input type="text" name="first_name" class="form-control form-control-lg <?php echo (!empty($data['first_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['first_name']; ?>">
            		<span class="invalid-feedback"><?php echo $data['first_name_err']; ?></span>
				</div>
				<div class="form-group">
					<label for="last_name"> Last name: </label>
					<input type="text" name="last_name" class="form-control form-control-lg <?php echo (!empty($data['last_name_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['last_name']; ?>">
            		<span class="invalid-feedback"><?php echo $data['last_name_err']; ?></span>
				</div>
				<div class="row">
					<div class="col">
						<input type="submit" value="Register" class="btn btn-success btn-block">
					</div>
				</div>
			</div>

			<div class="mt-50">
				<button id="btn2">CLICK ME</button>
				<button id="btn3">CLICK ME2</button>
			</div>
		</div>
	</div>

<?php require 'app/views/inc/footer.php'; ?>