<div id="profile-modal" class="mt-3">
	<form id="profile-form">
	<div class="form-group">
		<label for="username-form" class="col-form-label">Username:</label>
		<input type="text" name="username" class="form-control" required id="username-form" maxlength="25">
	</div>
	<div class="form-group">
		<label for="first-name" class="col-form-label">First name:</label>
		<input type="text" name="first_name" class="form-control" id="first-name-form" maxlength="25">
	</div>
	<div class="form-group">
		<label for="last-name-form" class="col-form-label">Last name:</label>
		<input type="text" name="last_name" class="form-control" id="last-name-form" maxlength="25">
	</div>
	<div class="form-group">
		<label for="email-form" class="col-form-label">Email:</label>
		<input type="email" name="email" class="form-control" required id="email-form">
	</div>
	<button type="button" class="btn btn-secondary" onclick="closeModal()">Close</button>
	<button type="submit" class="btn btn-primary">Save changes</button>
	</form>
</div>