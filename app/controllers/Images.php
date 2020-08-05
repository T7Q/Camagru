<?php

class Images extends Controller {
	public function __construct() {
		// $this->userModel = $this->model('Image');
	}
	public function create(...$param){
		if ($this->isAjaxRequest()) {
			if (isset($_POST['data'])) {
				$data = json_decode($_POST['data'], true);
                $img_data = str_replace('data:image/png;base64,', '', $data['img_data']);
                $img_data = str_replace(' ', '+', $img_data);
                $img_data = base64_decode($img_data);
                $dest = imagecreatefromstring($img_data);
                imagealphablending($dest, true);
                imagesavealpha($dest, true);
				ob_start ();
                imagepng($dest);
                $final_image_data = ob_get_contents();
                ob_end_clean ();
                $final_image_data_base_64 = base64_encode($final_image_data);
                $json['photo'] = 'data:image/png;base64,' . $final_image_data_base_64;
                imagedestroy($dest);
                $json['valid'] = true;
                $json['message'] = "Image added to the list";
                $json['description'] = "description";
            } else {
				$json['message'] = "SMTH WENT WRONG";
			}
            echo json_encode($json);
			// try {
			// // $image1 = 'public/img/filters/filter1.png';
			// $image1 = URLROOT . '/public/img/filters/filter1.png';
			// // $image2 = 'public/img/filters/filter2.png';
			// // list($width, $height) = getimagesize($image2);
			// // $image1 = imagecreatefromstring(file_get_contents($image1));
			// // $image2 = imagecreatefromstring(file_get_contents($image2));
			
			// // imagecopymerge($image1, $image2, 0, 0, 0, 0, $width, $height, 100);
			// // header('Content-Type: image/png');
			// // imagepng($image1);
			// // ob_start (); 
			// $final_image_data_base_64 = base64_encode($image1);
			// // ob_end_clean ();
            // $json['photo'] = 'data:image/png;base64,' . $final_image_data_base_64;
			// } catch (Exception $e) {
			// 	$json['message'] = $e->getMessage();
			// }
			// echo json_encode($json);
		} else {
			$this->view('pages/error');
		}
	}

}

?>