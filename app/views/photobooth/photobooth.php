<?php require 'app/views/inc/header.php'; ?>

<div class="container">
	<h1>CREATE YOUR OWN PHOTOS</h1>
	<div class="row top10">
		<div class="col-md-7 border photo">
			<div class="row top10 bottom10">
				<div class="col">
					<div id="camera" class="border embed-responsive embed-responsive-4by3">
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
			<div class="row top10 ">
				<div class="col">
					<button id="stream_button" class="btn btn-primary btn-block">Start Video</button>
				</div>
				<div class="col input-group">
					<input id='upload' type='file' accept="image/*" class="d-none"/>
					<input id='upload_photo' type='button' value='Upload Image' class="btn btn-primary btn-block" />
				</div>
			</div>
			<div class="row">
				<div class="col">
					<lable>
						<input type="checkbox" onclick="toggleFilter(this.id)" id="filter_1" value="big" class='filter'>
						<img src="<?= URLROOT . '/public/img/filters/filter7.png' ?>" id="img_filter_1" class="img-thumbnail" alt="Cinque Terre">
					</lable>
				</div>
				<div class="col">
					<lable>
						<input type="checkbox" onclick="toggleFilter(this.id)" id="filter_2" value="big" class='filter'>
						<img src="<?= URLROOT . '/public/img/filters/filter8.png' ?>" id="img_filter_2" class="img-thumbnail" alt="Cinque Terre">
					</lable>
				</div>
				<div class="col">
					<button id="take_photo" type="button" class="btn btn-lg btn-secondary circleshape" disabled><i class="fas fa-camera icon-7x"></i></button>
				</div>
				<div class="col">
					<input type="checkbox" onclick="toggleFilter(this.id)" id="filter_3" value="big" class='filter'>

					<img src="<?= URLROOT . '/public/img/filters/filter13.png' ?>" id="img_filter_3" class="img-thumbnail" alt="Cinque Terre">
				</div>
				<div class="col">
					<input type="checkbox" onclick="toggleFilter(this.id)" id="filter_4" value="big" class='filter'>
					<img src="<?= URLROOT . '/public/img/filters/filter10.png' ?>" id="img_filter_4" class="img-thumbnail" alt="Cinque Terre">
				</div>
			</div>
		</div>
		<div class="col-md-4 ml-auto border scroll">
			<div class="container top10 scroll">
			<!-- <div class="container scroll"> -->
				<div id="temp" class="output card"></div>
			<!-- <div id="temp" class="output card"> -->
				<!-- <img id="photo" class="snapshot" alt="The screen capture will appear in this box.">
				<div class="card-body padding0 maginauto">
					<a href="#" class="btn-sm btn-primary">Save</a>
					<a href="#" class="btn-sm btn-primary">Delete</a>
				</div> -->

				<!-- <div class="card">
					<img class="card-img-top" src="https://bit.ly/2WHkrpv" alt="Card image cap">
					<div class="card-body padding0 maginauto">
						<a href="#" class="btn-sm btn-primary">Save</a>
						<a href="#" class="btn-sm btn-primary">Delete</a>
					</div>
				</div> -->
				
			</div>
		</div>
	</div>
</div>
<!-- <div id="temp" class="output card"> -->
<?php require 'app/views/inc/footer.php'; ?>