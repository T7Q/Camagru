// basic structure of photo.php 
// include JS

<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="container">

	<h1>CREATE YOUR OWN PHOTOS</h1>
	<div class="row top10">
		<div class="col-md-7 border photo">
			<div class="row top10 bottom10">
				<div class="col">
						<ul class="list-group border">
							<li class="list-group-item noborder">INSTRUCTIONS</li>
							<li class="list-group-item noborder">1. Click here to activate your camera or upload an image</li>
							<li class="list-group-item noborder">2. Select filter</li>
							<li class="list-group-item noborder">3. Take a photo</li>
							</ul>
				</div>
			</div>
			<div class="row top10 ">
				
				<div class="col">
					<form action="" method="post">
						<input type="text" name="img" class="form-control form-control-md" value="Image title">
						<span class="invalid-feedback"></span>
					</form>
				</div>
				<div class="col input-group">
					<label class="btn btn-primary btn-block" for="my-file-selector">
						<input id="my-file-selector" type="file" class="d-none">
						Upload your img
					</label>
				</div>
				
			</div>
			<div class="row">
				<div class="col">
					<img src="https://bit.ly/3fNEn1N" class="img-thumbnail" alt="Cinque Terre">
				</div>
				<div class="col">
					<img src="https://bit.ly/30BFP0A" class="img-thumbnail" alt="Cinque Terre">
				</div>
				<div class="col">
					<button type="button" class="btn btn-lg btn-secondary circleshape" disabled><i class="fas fa-camera icon-7x"></i></button>
				</div>
				<div class="col">
					<img src="https://bit.ly/30BFP0A" class="img-thumbnail" alt="Cinque Terre">
				</div>
				<div class="col">
					<img src="https://bit.ly/3fNEn1N" class="img-thumbnail" alt="Cinque Terre">
				</div>
			</div>
		</div>
		<div class="col-md-4 ml-auto border">
			<div class="container top10 scroll">
				

				
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
				</div>
				<div class="card">
					<img class="card-img-top" src="https://bit.ly/2WHkrpv" alt="Card image cap">
					<div class="card-body padding0 maginauto">
						<p class="card-text margin0">Cat image</p>
						<a href="#" class="btn-sm btn-primary">Save</a>
						<a href="#" class="btn-sm btn-primary">Delete</a>
					</div>
				</div>
			</div>
					<!-- https://bit.ly/2WHkrpv -->


		</div>
	</div>
	<div class="push"></div>
</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>