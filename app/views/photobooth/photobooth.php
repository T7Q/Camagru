<?php require 'app/views/inc/header.php'; ?>

<div class="container">
	<!-- <h1 class="mt-3 mb-3">CREATE YOUR OWN PHOTOS</h1> -->
	<div class="row mt-2">
		<div class="col-md-7 border">
			<!-- camera window -->
			<div class="row mt-3 mb-3">
				<div class="col">
					<div id="camera" class="border embed-responsive embed-responsive-4by3 h-80">
						<ul id="instructions" class="list-group embed-responsive-item">
							<li class="list-group-item noborder">INSTRUCTIONS</li>
							<li class="list-group-item noborder">1. Start camera or upload an image</li>
							<li class="list-group-item noborder">2. Select filter(s)</li>
							<li class="list-group-item noborder">3. Take a photo</li>
						</ul>
						<video id="video" autoplay="true" class="embed-responsive-item"></video>
					</div>
				</div>
			</div>
			<div class="row mt-2">
				<div class="col">
					<button id="stream_button" class="btn btn-secondary btn-block">Start Video</button>
				</div>
				<div class="col input-group">
					<input id='upload' type='file' accept="image/*" class="d-none"/>
					<input id='upload_photo' type='button' value='Upload Image' class="btn btn-secondary btn-block" />
				</div>
			</div>
			<div class="row mt-2 mb-3">
				<div class="col">
						<input type="checkbox" onclick="toggleFilter(this.id)" id="filter_1" class='filter'>
						<label for="filter_1" class="label-filter">
							<img src="<?= URLROOT . '/public/img/filters/filter5.png' ?>" id="img_filter_1" class="img-thumbnail" alt="Cinque Terre">
						</label>
				</div>
				<div class="col">
						<input type="checkbox" onclick="toggleFilter(this.id)" id="filter_2" class='filter'>
						<label for="filter_2" class="label-filter">
							<img src="<?= URLROOT . '/public/img/filters/filter15.png' ?>" id="img_filter_2" class="img-thumbnail" alt="Cinque Terre">
						</lable>
				</div>
				<div class="col take_photo_position">
					<button id="take_photo" type="button" class="btn btn-danger btn-circle" disabled><i class="fas fa-camera icon-7x"></i></button>
				</div>
				<div class="col">
					<input type="checkbox" onclick="toggleFilter(this.id)" id="filter_3" class='filter'>
					<label for="filter_3" class="label-filter">
						<img src="<?= URLROOT . '/public/img/filters/filter13.png' ?>" id="img_filter_3" class="img-thumbnail" alt="Cinque Terre">
					</label>
				</div>
				<div class="col">
					<input type="checkbox" onclick="toggleFilter(this.id)" id="filter_4" class='filter'>
					<label for="filter_4" class="label-filter">
						<img src="<?= URLROOT . '/public/img/filters/filter10.png' ?>" id="img_filter_4" class="img-thumbnail" alt="Cinque Terre">
					</label>
				</div>
			</div>
		</div>
		<!-- preview window -->
		<div class="col-md-4 ml-auto border">
			<div id="preview-list" class=" mt-3 mb-3 container">
				<h3 class="text-center">PREVIEW AREA</h3>
			</div>
		</div>
	</div>
</div>
<script src="<?php echo URLROOT; ?>/public/js/photobooth.js"></script>

<?php require 'app/views/inc/footer.php'; ?>