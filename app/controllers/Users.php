<?php
class Users {
	public function __construct(){

	}
	
	public function register(){
		// check for POST
		if ($_SERVER['REQUEST_METHOD'] == 'POST'){
			// process form
		} else {
			// load form
			echo "load form";
		}
	}
}