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
					<button id="stream_button" class="btn btn-primary btn-block">Stop Video</button>
				</div>
				<div class="col input-group">
					<label class="btn btn-primary btn-block" for="file_upload">
						<input id="file_upload" type="file" class="d-none" accept="image/*" type="file">
						Upload Image
					</label>
				</div>
				
			</div>
			<div class="row">
				<div class="col">
					<!-- <label>
						<input type="checkbox" name="test" value="small">	
						<img src="<?= URLROOT . '/public/img/filters/filter5.png' ?>" id="filter1" class="img-thumbnail" alt="Cinque Terre">
					</label> -->
					<select name="filters[]" id="filters" multiple>
						<option value='/public/img/filters/filter8.png'>FIlter1</option>
					</select>
				</div>
				<div class="col">
					<lable>
						<input type="checkbox" onclick="toggleFilter(this.id)" id="filter_2" value="big" class='filter'>
						<img src="<?= URLROOT . '/public/img/filters/filter8.png' ?>" id="img_filter_2" class="img-thumbnail" alt="Cinque Terre">
					</lable>
				</div>
				<div class="col">
					<button id="take_photo" type="button" class="btn btn-lg btn-secondary circleshape"><i class="fas fa-camera icon-7x"></i></button>
					<!-- <button type="button" class="btn btn-lg btn-secondary circleshape" disabled><i class="fas fa-camera icon-7x"></i></button> -->
				</div>
				<div class="col">
					<input type="checkbox" onclick="toggleFilter(this.id)" id="filter_3" value="big" class='filter'>

					<img src="<?= URLROOT . '/public/img/filters/filter13.png' ?>" id="img_filter_3" class="img-thumbnail" alt="Cinque Terre">
				</div>
				<div class="col">
					<input type="checkbox" onclick="toggleFilter(this.id)" id="filter_4" value="big" class='filter'>
					<img src="<?= URLROOT . '/public/img/filters/filter10.png' ?>" id="img_filter_4" class="img-thumbnail" alt="Cinque Terre">
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
				
			<!-- <canvas id="canvas" class="d-none"> -->
			<canvas id="canvas" >canvas
			</canvas>
			<!-- <canvas id="canvas2" class="d-none"> -->
			<canvas id="canvas2" >
			</canvas>
			<canvas id="canvas3" >
			</canvas>
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
	<div class="push"></div>
</div>
<div id="temp" class="output card">
<?php require 'app/views/inc/footer.php'; ?>