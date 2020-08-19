<?php

class Images extends Controller {
	public function __construct() {
		$this->imageModel = $this->model('Image');
		$this->galleryModel = $this->model('Gallery');
	}
	public function create(...$param){
		if ($this->isAjaxRequest()) {
			if (isset($_POST['data'])) {
				$data = json_decode($_POST['data'], true);

				$json['loggedIn'] = (isset($_SESSION['user_id'])) ? true: false ;

				if (isset($_SESSION['user_id'])) {
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
					$json['message'] = "You need to be logged in";
				}
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

				$json['loggedIn'] = (isset($_SESSION['user_id'])) ? true: false ;

				if (isset($_SESSION['user_id'])) {
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
					}
				} else {
					$json['message'] = "You need to be logged in";
					// $json['message'] = "Error: uploaded file is not an image";
					// // echo json_encode($json);

				}
			} else {
				$json['message'] = "Oops, something went wrong saving the image";
			}
            echo json_encode($json);
		} else {
			$this->view('pages/error');
		}

	}

	public function delete() {
		if ($this->isAjaxRequest()) {
			if (isset($_POST['data'])) {
				$data = json_decode($_POST['data'], true);
				$temp = explode("del_img", $data['id_image']);
				$id_image = $temp[1];

				$id_user = (isset($_SESSION['user_id'])) ? $_SESSION['user_id'] : 0 ;
				$json['loggedIn'] = (isset($_SESSION['user_id'])) ? true: false ;
				if (isset($_SESSION['user_id'])){
					if($this->galleryModel->imageExists($id_image)){
						$image_owner = $this->galleryModel->imageOwner($id_image);
						$json['valid'] = false;
						// $json['message'] = $image_owner->id_user;
						if ($id_user === $image_owner->id_user){
							$temp = $this->imageModel->getImgPath($id_image);
							$this->imageModel->deleteImgDb($id_image);
							$json['valid'] = true;
							$json['message'] = "Successfully deleted";
							unlink(APPPATH . '/' . $temp->path); // Delete img from server
						} else {
							$json['valid'] = false;
							$json['message'] = "You can't delete other user images";
						}
					} else {
						$json['valid'] = false;
						$json['message'] = "You can't delete images that do not exist in your gallery";
					}
				} else {
					$json['valid'] = false;
					$json['message'] = "You need to be logged in to remove image";
				}
			} else {
				$json['valid'] = false;
				$json['message'] = "Oops, something went wrong getting images for Gallery";
			}
			echo json_encode($json);
		} else {
			$this->view('pages/error');
		}
	}

}
?>