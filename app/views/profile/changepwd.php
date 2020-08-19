<!-- modal box body -->
<div id="pwd-modal" class="mt-3 d-none">
	<form id="pwd-form">
		<div class="form-group">
			<label for="currentPwd">Current password<sup>*</sup></label>
			<input type="password" name="currentPwd" class="form-control" id="currentPwd" placeholder="Password">
			<span id="old_password_err1" class="invalid-feedback"></span>
		</div>
		<div class="form-group">
			<label for="newPwd">New password<sup>*</sup></label>
			<input type="password" name="newPwd" class="form-control" id="newPwd" placeholder="Password">
			<span id="password_err1" class="invalid-feedback"></span>
		</div>
		<div class="form-group">
			<label for="ConfirmPwd">Confirm new password<sup>*</sup></label>
			<input type="password" name="ConfirmPwd" class="form-control" id="ConfirmPwd" placeholder="Password">
			<span id="confirm_password_err1" class="invalid-feedback"></span>
		</div>
		<button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
		<button type="submit" class="btn btn-primary">Save changes</button>
	</form>
</div>