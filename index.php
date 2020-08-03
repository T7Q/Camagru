<?php
	// general settings
	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);

	session_start();

	// load config 
	require_once './app/config/config.php';

	// load database
	require_once './app/config/database.php';

	// autoload router library
	spl_autoload_register(function($className){
		require_once './app/config/RouterControllerLibraries/' . $className . '.php';
	});

	// init Router
	$init = new RouterController;
	$init->render(trim($_SERVER['REQUEST_URI'], '/'));

?>