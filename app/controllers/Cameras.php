<?php
	class Cameras extends Controller {

		public function __construct(){

		}
		
		public function snapshot(){
			$data = [
				'title' => 'About Us',
			];
			$this->view('camera/camera', $data);
		}
	}
?>