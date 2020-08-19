<?php require 'app/views/inc/header.php'; ?>

	<div class="row">
		<div class="col-md-6 mx-auto">
			<div id="alert-body" class="p-3 m-3 rounded text-center d-none"></div>
			<div class="card card-body bg-light mt-5">
				<h2>Reset your password</h2>
				<p>An email will be send to you with instructions on how to reset your password.</p>
				<form id="forgot-pwd">
				<div class="form-group">
					<label for="username"> Enter your email address <sup>*</sup></label>
					<input type="email" name="email" class="form-control form-control-lg">
            		<span id="email_err" class="invalid-feedback"></span>
				</div>
				<div class="row">
					<div class="col">
						<input type="submit" value="Reset password" class="btn btn-success btn-block">
					</div>
				</div>
		</div>
	</div>
	</div>

<script src="<?php echo URLROOT; ?>/public/js/forgotpwd.js"></script>

<?php require 'app/views/inc/footer.php'; ?>