<?php
	class Galleries extends Controller {

		public function __construct(){
			$this->galleryModel = $this->model('Gallery');
			$this->imageModel = $this->model('Image');
		}
		
		public function all($param = ''){
			$this->view('gallery/gallery');
		}

		public function show() {
			if ($this->isAjaxRequest()) {
				$this->view('gallery/test');
			} else {
				$this->view('users/register');
			}
		}

		public function getImages() {
		if ($this->isAjaxRequest()) {
			if (isset($_POST['data'])) {
				if (isset($_SESSION['user_id'])) {
					$id_user = $_SESSION['user_id'];
				} else {
					$id_user = 0;
				}
				$data = json_decode($_POST['data'], true);
				if($this->galleryModel->galleryExists()){
					$json['res'] = "gallery";
					$temp = $this->galleryModel->getAllImages($id_user);
					$json['res'] = $temp;
				} else {
					$json['res'] = "Gallery is empty";
				}				
			} else {
				$json['message'] = "Oops, something went wrong getting images for Gallery";
			}
            echo json_encode($json);
		} else {
			$this->view('pages/error');
		}

	}


	public function getImageData() {
		if ($this->isAjaxRequest()) {
			if (isset($_POST['data'])) {
				$data = json_decode($_POST['data'], true);
				$temp = explode("id_img", $data['id_image']);
				$id_image = $temp[1];
				$json['message'] = "got reponse" . $id_image;
				// $json['res'] = "Got this in php" + $data['id_image'];
				$id_user = $_SESSION['user_id'];
				if($this->galleryModel->imageExists($id_image)){
					$json['message'] = "before call";
					$temp = $this->galleryModel->getImageData($id_user, $id_image);
					$json['message'] = $temp;
					$json['valid'] = true;
				} else {
					$json['message'] = "Image is not found";
				}
			
				
			} else {
				$json['message'] = "Oops, something went wrong getting images for Gallery";
			}
            echo json_encode($json);
		} else {
			$this->view('pages/error');
		}

	}

	public function deleteImgDb() {
		if ($this->isAjaxRequest()) {
			if (isset($_POST['data'])) {
				$data = json_decode($_POST['data'], true);
				$temp = explode("del_img", $data['id_image']);
				$id = $temp[1];
				$json['message'] = "got reponse" . $id;
				// $json['res'] = "Got this in php" + $data['id_image'];
				
				if($this->galleryModel->imageExists($id)){
					$json['message'] = "before call";
					$temp = $this->galleryModel->deleteImage($id);
					$json['message'] = "succes";
				} else {
					$json['message'] = "Image is not found";
				}
			
				
			} else {
				$json['message'] = "Oops, something went wrong getting images for Gallery";
			}
            echo json_encode($json);
		} else {
			$this->view('pages/error');
		}
	}


	public function like() {
		if ($this->isAjaxRequest()) {
			if (isset($_POST['data'])) {
				$data = json_decode($_POST['data'], true);
				$temp = explode("like", $data['id_image']);
				$id_image = $temp[1];
				$id_user = $_SESSION['user_id'];
				$json['message'] = "got to like";
				if($this->galleryModel->imageExists($id_image)){
					$json['message'] = "before call";

					if($this->galleryModel->isLiked($id_user, $id_image)){
						// unlike
						if($this->galleryModel->unlikeImage($id_user, $id_image)){
							$json['message'] = "false";
							// $json['count'] = $this->galleryModel->likeCount($id_image);
						} else{
							$json['message'] = "Failed updating db in unlike";
						}
					} else {
						// like
						if($this->galleryModel->likeImage($id_user, $id_image)){
							$json['message'] = "true";
						} else{
							$json['message'] = "Failed updating db in unlike";
						}
					}
					
					$json['count'] = $this->galleryModel->likeCount($id_image);
				} else {
					$json['message'] = "Image is not found";
				}
			
				
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