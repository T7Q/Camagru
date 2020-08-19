<!-- modal box body -->
<div id="notify-modal" class="mt-3 d-none">
	<p>
		<span>An email notification is sent if your image was liked or commented.</span>
	</p>
	<div class="custom-control custom-switch"> 
		<input type="checkbox" class="custom-control-input" id="notification-switch" <?php echo ($data['notification'] == 1) ? 'checked' : ''; ?>>
		<label class="custom-control-label" for="notification-switch">Update your notificaton settings here</label>
	</div>
</div>