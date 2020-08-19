<?php
	// Controller for pages/home and pages/error requests

	class Pages extends Controller {

		public function __construct(){
		}

		public function index(){
			$this->view('pages/home');
		}

	}
?>