<?php

/*
* App RouterController class
* Creates URL & loads RouterController controller
* URLFORMAT - /controller/method/params
*
*/

class RouterController {
	protected $currentController = 'Pages';
	protected $currentMethod = 'index';
	protected $params = [];

		
	public function render($url_input){
		// echo "init->render <hr>";
		$url = explode('/', $url_input);

		// Look if our root folder is an array's first element, delete it
        if (isset($url[0]) && $url[0] == 'camagru10') {
            array_shift($url);
        }

		// Look in controllers for first value
		if(isset($url[0])){
			if(file_exists('./app/controllers/' . ucwords($url[0]). '.php')){
				// If exists, set as controller
				$this->currentController = ucwords($url[0]);
				// Unset 0 Index
				unset($url[0]);
			}
		}
		// Require the controller
		require_once './app/controllers/'. $this->currentController . '.php';
		
		// Instantiate controller class
		$this->currentController = new $this->currentController;

		// Check for second part of url
		if(isset($url[1])){
			// Check to see if method exists in controller
			if(method_exists($this->currentController, $url[1])){
				$this->currentMethod = $url[1];
				// unset index 1
				unset($url[1]);
			}
		}
		// echo $this->currentMethod;
		
		// Get params
		$this->params =  $url ? array_values($url) : [];
		
		// Call a callback with array of params
		if(method_exists($this->currentController, $this->currentMethod)){
			// if both controller and method are set
			// Call a callback with array of params
			call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
		} else {
			$this->currentController->redirect('pages/home');
		}

	}
}