<!-- // basic html for home page
// logged in vs loggout users
// no JS? -->

<?php require APPROOT . '/views/inc/header.php'; ?>

	<div class=".jumbotron.jumbotron-fluid">
		<div class="container">
		<h1><?php echo  $data['title'] ?> to home.php</h1>
		<h1>Camagru</h1>
		<h2 class="lead"> Photo editing App</h2>
	</div>
	<div class="list-group">
	<a class="navbar-brand" href=""><i class="far fa-circle"></i>MY CIRCLE</a>
	<a class="list-group-item" href="#"><i class="fa fa-home fa-fw" aria-hidden="true"></i>&nbsp; Home</a>
	<a class="list-group-item" href="#"><i class="fa fa-book fa-fw" aria-hidden="true"></i>&nbsp; Library</a>
	<a class="list-group-item" href="#"><i class="fa fa-pencil fa-fw" aria-hidden="true"></i>&nbsp; Applications</a>
	<a class="list-group-item" href="#"><i class="fa fa-cog fa-fw" aria-hidden="true"></i>&nbsp; Settings</a>
	</div>

<?php require APPROOT . '/views/inc/footer.php'; ?>