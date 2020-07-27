<?php
	class Galleries extends Controller {

		public function __construct(){

		}
		
		public function all(){
			$data = [
				'title' => 'About Us',
			];
			$this->view('gallery/gallery', $data);
		}
	}
?>