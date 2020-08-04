<?php
	class Photobooth extends Controller {

		public function __construct(){

		}
		
		public function photo(){
			$data = [
				'title' => 'About Us',
			];
			$this->view('photobooth/photobooth', $data);
		}
	}
?>