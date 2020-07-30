<?php require APPROOT . '/views/inc/header.php'; ?>

	<div class="row">
		<div class="col-md-6 mx-auto">
			<div class="card card-body bg-light mt-5">
				<!-- <?php flash('token'); ?> -->
				<h2>Create new password</h2>
				<form action="<?php echo URLROOT; ?>/emails/pwdreset" method="post">
				<div class="form-group">
					<label for="password"> New password: <sup>*</sup></label>
					<input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
            		<span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
				</div>
				<div class="form-group">
					<label for="confirm_password"> Repeat new password: <sup>*</sup></label>
					<input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($data['confirm_password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['confirm_password']; ?>">
            		<span class="invalid-feedback"><?php echo $data['confirm_password_err']; ?></span>
				</div>
				<div class="row">
					<div class="col">
						<input type="submit" value="Update" class="btn btn-success btn-block">
					</div>
				</div>
				<!-- <a href="<?php echo URLROOT; ?>/users/pwd_reset">Forgot your password?</a> -->
			</div> 
		</div>
	</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>