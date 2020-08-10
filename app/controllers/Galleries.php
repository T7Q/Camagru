<?php
	class Galleries extends Controller {

		public function __construct(){
			$this->galleryModel = $this->model('Gallery');
			$this->imageModel = $this->model('Image');
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

		public function getImages() {
		if ($this->isAjaxRequest()) {
			if (isset($_POST['data'])) {
				$data = json_decode($_POST['data'], true);

				// $temp = $this->galleryModel->getAllImages();
				// $json['res'] = $temp;

				if($this->galleryModel->galleryExists()){
					$json['res'] = "gallery";
					$temp = $this->galleryModel->getAllImages();
					$json['res'] = $temp;
				} else {
					$json['res'] = "Gallery is empty";
				}
			
				// if($data['test']  === "hello"){
				// } else {
				// 	$json['res'] = "Did not receive hello";
				// }
				
			} else {
				$json['message'] = "Oops, something went wrong getting images for Gallery";
			}
            echo json_encode($json);
		} else {
			$this->view('pages/error');
		}

	}
}
?>