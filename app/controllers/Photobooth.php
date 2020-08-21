<?php
	class Photobooth extends Controller {

		public function __construct(){

		}
		
		public function photo(){
			
			$this->checkAccessRights();
			$this->view('photobooth/photobooth');
		}
	}
?>