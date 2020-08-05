// basic structure of photo.php 
// include JS

<?php require 'app/views/inc/header.php'; ?>

<div class="container">

	<h1>CREATE YOUR OWN PHOTOS</h1>
	<div class="row top10">
		<div class="col-md-7 border photo">
			<div class="row top10 bottom10">
				<div class="col">
					<div id="camera" class="border embed-responsive embed-responsive-4by3">
				
						<!-- <ul id="instruction" class="list-group embed-responsive-item">
							<li class="list-group-item noborder">INSTRUCTIONS</li>
							<li class="list-group-item noborder">1. Start camera or upload an image</li>
							<li class="list-group-item noborder">2. Select filter(s)</li>
							<li class="list-group-item noborder">3. Take a photo</li>
						</ul> -->
						<!-- <img src="/camagru/public/img/filters/filter1.png" id="filter1" class="video-overlay" alt="Filter1"> -->
						<video id="video" autoplay="true" class="embed-responsive-item"></video>
					</div>
				</div>
			</div>
			<div class="row top10 ">
				
				<div class="col">
					<!-- <form action="" method="post">
						<input type="text" name="img" class="form-control form-control-md" value="Image title">
						<span class="invalid-feedback"></span>
					</form> -->
					<button id="stream_button" class="btn btn-primary btn-block">Stop Video</button>
					<!-- <button id="start-video" class="btn btn-primary btn-block">Start Video</button>
					<button id="stop-video" class="btn btn-primary btn-block d-none">Stop Video</button> -->

				</div>
				<div class="col input-group">
					<label class="btn btn-primary btn-block" for="file_upload">
						<input id="file_upload" type="file" class="d-none" accept="image/*" type="file">
						Upload your img
					</label>
				</div>
				
			</div>
			<div class="row">
				<div class="col">
					<label>
						<input type="checkbox" name="test" value="small">	
						<img src="<?= URLROOT . '/public/img/filters/filter1.png' ?>" id="filter1" class="img-thumbnail" alt="Cinque Terre">
					</label>
				</div>
				<div class="col">
					<lable>
						<input type="checkbox" name="test" value="big">
						<img src="<?= URLROOT . '/public/img/filters/filter2.png' ?>" id="filter2" class="img-thumbnail" alt="Cinque Terre">
					</lable>
				</div>
				<div class="col">
					<button id="take_photo" type="button" class="btn btn-lg btn-secondary circleshape"><i class="fas fa-camera icon-7x"></i></button>
					<!-- <button type="button" class="btn btn-lg btn-secondary circleshape" disabled><i class="fas fa-camera icon-7x"></i></button> -->
				</div>
				<div class="col">
					<input type="checkbox" name="test" value="big">
					<img src="<?= URLROOT . '/public/img/filters/filter3.png' ?>" id="filter3" class="img-thumbnail" alt="Cinque Terre">
				</div>
				<div class="col">
					<input type="checkbox" name="test" value="big">
					<img src="<?= URLROOT . '/public/img/filters/filter4.png' ?>" id="filter4" class="img-thumbnail" alt="Cinque Terre">
				</div>
				<!-- <select>
					<option style="background-image:url(https://bit.ly/3fNEn1N);">filter1</option>
					<option style="background-image:url(https://bit.ly/3fNEn1N);">filter2</option>
					<option style="background-image:url(https://bit.ly/3fNEn1N);">filter2</option>
					<option style="background-image:url(https://bit.ly/3fNEn1N);">filter4</option>
				</select>  -->

			</div>
		</div>
		<div class="col-md-4 ml-auto border">
			<div class="container top10 scroll">
				
			<canvas id="canvas" class="d-none">
			</canvas>
			<div id="temp" class="output card">
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
				</div>
				<div class="card">
					<img class="card-img-top" src="https://bit.ly/2WHkrpv" alt="Card image cap">
					<div class="card-body padding0 maginauto">
						<p class="card-text margin0">Cat image</p>
						<a href="#" class="btn-sm btn-primary">Save</a>
						<a href="#" class="btn-sm btn-primary">Delete</a>
					</div>
				</div>
				<div class="card">
					<img class="card-img-top" src="https://bit.ly/2WHkrpv" alt="Card image cap">
					<div class="card-body padding0 maginauto">
						<p class="card-text margin0">Cat image</p>
						<a href="#" class="btn-sm btn-primary">Save</a>
						<a href="#" class="btn-sm btn-primary">Delete</a>
					</div>
				</div> -->
			</div>


		</div>
	</div>
	<div class="push"></div>
</div>

<?php require 'app/views/inc/footer.php'; ?>