<?php
	class Photobooth extends Controller {

		public function __construct(){

		}
		
		public function photo(){
			
			$this->checkAccessRights();
			// $data = [
			// 	'title' => 'About Us',
			// ];
			// $this->view('photobooth/photobooth', $data);
			$this->view('photobooth/photobooth');
		}
	}
?>