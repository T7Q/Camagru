<!-- <p>index.php</p> -->
<?php 

// load config 
require_once './app/config/config.php';
// load database
require_once './app/config/database.php';



// Autoload RouterController libraries 
// spl_autoload_register(function($className){
// 	require_once './app/libraries/' . $className . '.php';
// });

spl_autoload_register(function($className){
	// require_once './app/RouterControllerLibraries/' . $className . '.php';
	require_once './app/config/RouterControllerLibraries/' . $className . '.php';
});

// init RouterController library
$init = new RouterController;

?>