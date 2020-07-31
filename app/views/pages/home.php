<!-- // basic html for home page
// logged in vs loggout users
// no JS? -->

<?php require APPROOT . '/views/inc/header.php'; ?>
	<!-- <div class="row full-height"> -->
		<div class="row half-height text-center div1">
			<div class="container my-auto">

				

				<div style="margin-top: 25%">
					<div class="row justy_center">
						<h1> CAMAGRU</h1>
					</div>
					<div class="col-4 aligntocenter">
					<!-- <div class="col-5 center-block aligntocenter"> -->
						<div class="embed-responsive embed-responsive-1by1 text-center">
							<div id="baloon" class="circleshape embed-responsive-item bg-primary">
							</div>
						</div>
					</div>
					<div class="container text-center my-auto">
						<h1>ENHANCE YOUR IMAGES</h1>
					</div>
				</div>
			</div>
        </div>
		
		<div class="row half-height colorgrey div2">
			
		</div>

		<!-- js test -->
		<script src="<?php echo URLROOT; ?>/public/js/camera.js"></script>
		<script src="<?php echo URLROOT; ?>/public/js/home.js"></script>

<?php require APPROOT . '/views/inc/footer.php'; ?>