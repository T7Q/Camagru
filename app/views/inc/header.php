<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- Google fonts  -->
	<link href="https://fonts.googleapis.com/css2?family=Montserrat&family=Open+Sans&family=Public+Sans:wght@100;200&family=Roboto+Mono:wght@200&family=Roboto:ital,wght@0,100;1,300&display=swap" rel="stylesheet">

	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
	
	<!-- Font Awesome CSS -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
	
	<link rel="stylesheet" href="<?php echo URLROOT; ?>/public/css/style.css">

	<!-- To silence warning about absence of favicon -->
	<link rel="shortcut icon" href="~/favicon.ico">

	<title><?php echo SITENAME; ?></title>

</head>
<body>
	<div class="wrapper">
		<?php require 'app/views/inc/navbar.php'?>
		<div class="container content">