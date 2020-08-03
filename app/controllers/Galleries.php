<?php
	class Galleries extends Controller {

		public function __construct(){

		}
		
		public function all($param = ''){
		

			// if ($this->isAjaxRequest() ) {
			

			// 	$raw_id = isset($_POST['id']) ? $_POST['id'] : '';
			

			// 	if ($raw_id == 'like'){

			// 		$list_items = array(
			// 			"https://bit.ly/3fRAAjW",
			// 			"https://bit.ly/3juMiDi",
			// 			"https://bit.ly/3eUJiMW",
			// 			"https://bit.ly/3fRAAjW",
			// 			"https://bit.ly/3juMiDi",
			// 			"https://bit.ly/3eUJiMW",
			// 			"https://bit.ly/2WNuzxg",
			// 			"https://bit.ly/3fNEn1N",
			// 			"https://bit.ly/3fNEn1N",
			// 			"https://bit.ly/3fNEn1N",
			// 			"https://bit.ly/3fNEn1N",
			// 			"https://bit.ly/3fNEn1N",
			// 			"https://bit.ly/3fNEn1N",
			// 			"https://bit.ly/3fNEn1N",
			// 			"https://bit.ly/3fNEn1N",
			// 			// "https://bit.ly/3fNEn1N",
			// 			// "https://bit.ly/3fNEn1N",
			// 			// "https://bit.ly/3fNEn1N",
			// 			// "https://bit.ly/3fNEn1N",
			// 			"https://bit.ly/3fNEn1N"
			// 		);
				
			// 		echo json_encode($list_items);
			// 		// $this->view('gallery/test');
			// 	} else if($param == 'show'){
			// 		echo "hello";
			// 	}
			// } else {
			$data = [
				'title' => 'About Us',
			];
			$this->view('gallery/gallery', $data);
			// }
		}

		public function show() {
			if ($this->isAjaxRequest()) {
				sleep(10);
				
				$this->view('gallery/test');
			
			// 	// echo json_encode($list_items);
				
			} else {
				$this->view('users/register');
			}
		}

		public function test() {
			if ($this->isAjaxRequest()) {
				
				// echo "ajax request";
				$this->view('gallery/test2');
			
			// 	// echo json_encode($list_items);
				
			} else {
				echo "NOT ajax request";
				// $this->view('users/register');
			}
		}

	}
?>