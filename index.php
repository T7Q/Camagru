<p>index.php</p>
<?php 
//  require_once './app/server.php';

// load config 
require_once './app/config/config.php';
// load database
require_once './app/config/database.php';

// Autoload core libraries 
spl_autoload_register(function($className){
	require_once './app/libraries/' . $className . '.php';
});

// init Core library
$init = new Core;

?>