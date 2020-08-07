<?php

class Images extends Controller {
	public function __construct() {
		// $this->userModel = $this->model('Image');
	}
	public function create(...$param){
		if ($this->isAjaxRequest()) {
			if (isset($_POST['data'])) {
				$data = json_decode($_POST['data'], true);

				// get main image
                $img_data = str_replace('data:image/png;base64,', '', $data['img_data']);
                $img_data = str_replace(' ', '+', $img_data);
                $img_data = base64_decode($img_data);
                $dest = imagecreatefromstring($img_data);

				
				// $img_filter_data = str_replace('data:image/png;base64,', '', $data['filter_data']);
                // $img_filter_data = str_replace(' ', '+', $img_filter_data);
                // $img_filter_data = base64_decode($img_filter_data);
                // $filter = imagecreatefromstring($img_filter_data);

				
				// // $img_filter_data2 = str_replace('data:image/png;base64,', '', $data['filter2_data']);
                // // $img_filter_data2 = str_replace(' ', '+', $img_filter_data2);
                // // $img_filter_data2 = base64_decode($img_filter_data2);
                // // $filter2 = imagecreatefromstring($img_filter_data2);


				
				// // imagecopymerge($dest, $filter, 0, 0, 0, 0, 640, 100, 100);
				// imagecopy($dest, $filter, 0,0, 0, 0, 640, 480);
				// // imagecopy($dest, $filter2, 0,0, 0, 0, 640, 480);
				
				// // imagealphablending($dest, true);
                // // imagesavealpha($dest, true);
				// //TEST with URL
				// $temp = $data['filter2_data'];
				
				// $src = imagecreatefrompng(__DIR__ . '/../..' . $temp);
				// imagecopyresized($dest, $src, 0, 0, 0, 0, 640, 480, imagesx($src), imagesy($src));
				
				// //
				// TEST WITH ARRAY
				foreach ($data['filters'] as $element) {
					$src = imagecreatefrompng(__DIR__ . '/../..' . $element);
					imagecopyresized($dest, $src, 0, 0, 0, 0, 640, 480, imagesx($src), imagesy($src));
				}


				header('Content-Type: image/png');
				

				// Use output buffering to capture the output from imagepng():
				// Enable output buffering
				ob_start ();
				imagepng($dest);
				// Capture the output and clear the output buffer
                $final_image_data = ob_get_contents();
                ob_end_clean ();
               
                $final_image_data_base_64 = base64_encode($final_image_data);
                $json['photo'] = 'data:image/png;base64,' . $final_image_data_base_64;
                imagedestroy($dest);


				// ob_start ();
                // imagepng($dest);
                // $final_image_data = ob_get_contents();
                // ob_end_clean ();
                // $final_image_data_base_64 = base64_encode($final_image_data);
                // $json['photo'] = 'data:image/png;base64,' . $final_image_data_base_64;
                // imagedestroy($dest);
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