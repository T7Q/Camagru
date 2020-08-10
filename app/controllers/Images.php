<?php

class Images extends Controller {
	public function __construct() {
		$this->imageModel = $this->model('Image');
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
				
                $json['valid'] = true;
                $json['message'] = "Image added to the list";
            } else {
				$json['message'] = "Oops, something went wrong mixing the images";
			}
            echo json_encode($json);
		} else {
			$this->view('pages/error');
		}
	}

	public function save(...$param){
		if ($this->isAjaxRequest()) {
			if (isset($_POST['data'])) {
				$data = json_decode($_POST['data'], true);

				// check if / create folder to store photos
				$img_folder = $_SESSION['user_id'];
				$path = __DIR__ . "/../../public/img/user_" . $img_folder . "/";
				if (!is_dir($path)) {
					if (!mkdir($path)) {
						$json['message'] = "Error occured during saving an image";
						echo json_encode($json['message'] = "An error ocurred during the save");
						exit();
					}
				}
				if (substr($data['img_src'], 0, 22) === "data:image/png;base64,") {
					$file = $path . uniqid() . '.png';
					$data['img_src'] = str_replace('data:image/png;base64,', '', $data['img_src']);
					$data['img_src'] = str_replace(' ', '+', $data['img_src']);
					file_put_contents($file, base64_decode($data['img_src']));
					$db_data = [
						'id_user' => $_SESSION['user_id'],
						'path' => substr(strstr($file, "/public/"), 1)
					]; 
					if ($this->imageModel->addPhotoToDb($db_data)){
						$json['valid'] = true;
						$message = "database updated";
					} else {
						$message = "database not updated";
					}
					$json['res'] = $message;
					$json['message'] = "path for db";
				} else {
					$json['message'] = "Error: uploaded file is not an image";
					// echo json_encode($json);
					exit();
				}
			} else {
				$json['message'] = "Oops, something went wrong saving the image";
			}
            echo json_encode($json);
		} else {
			$this->view('pages/error');
		}

	}
}
?>